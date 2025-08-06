<?php


/*
Update Old software to new software.
1. Step One:
        first Download old database from server and store local pc/Xammp server
2. Step two:
    Go to Config->database.php page and uncomment second_db section and replase your old database name
3. Step three:
     Go to software Setting Menu =>cache Clear 
4. Step four:
        Now hit some Url 
            // clear-cache
            1. moveMissingTablesChunked
            2. database_table_column_update
            3. setDefaultZeroForNumericColumns
            4. set_default_unit_conversion
            5. find_out_two_permission_table_data_diff_and_insert_second_db

            // UPDATE `unit_conversions` SET `_base_unit_id`=6,`_conversion_qty`=1,`_conversion_unit`=6,`_status`=1,`_conversion_unit_name`='Pcs' WHERE 1

            // two_db_table_dirr
            // column_name_diff
Update Manually store_houses table Status null to 1

5. Get Perfect Report Need to Configer Some Software Setting
    * Go to setting menu=>General Setting and update Data [Cash Group,Bank Group,Direct Income & Expense Heads,Indirect Income & Expense Heads]
    * Go to Setting menu=>Account Group Configs [ Here you can take help from master=>Account group page ]

Now Check and confirm everything will fine


UPDATE `account_heads` SET `_parent_id`=0 WHERE _parent_id IS NULL;
UPDATE `account_heads` SET `_parent_id`=0,`_has_parent`=0,`_has_child`=0,`_level`=1;

*/



function find_out_two_permission_table_data_diff_and_insert_second_db(){
     // Fetch permissions from the source database
    $sourcePermissions = DB::connection('mysql')->table('permissions')->get();

    // Fetch existing permission names from the target database
    $targetPermissionNames = DB::connection('second_db')->table('permissions')->pluck('name')->toArray();

    // Find missing records
    $missingPermissions = $sourcePermissions->filter(function ($permission) use ($targetPermissionNames) {
        return !in_array($permission->name, $targetPermissionNames);
    });

    // Insert missing records into the second database
    if ($missingPermissions->isNotEmpty()) {
        // Convert the collection of objects into an array and exclude 'id'
        $insertData = $missingPermissions->map(function ($permission) {
            $data = (array) $permission; // Convert object to array
            unset($data['id']); // Remove the 'id' field to avoid conflicts
            return $data;
        })->toArray();

        DB::connection('second_db')->table('permissions')->insert($insertData);
        return count($missingPermissions) . " permissions inserted into second_db.";
    } else {
        return "No new permissions to insert.";
    }
}


function moveMissingTablesChunked()
{
    // Get the list of tables from both source and target databases
    $sourceTables = DB::connection('mysql')->select('SHOW TABLES');
    $targetTables = DB::connection('second_db')->select('SHOW TABLES');

    // Extract table names
    $sourceTableNames = array_map(fn($table) => reset($table), $sourceTables);
    $targetTableNames = array_map(fn($table) => reset($table), $targetTables);

    // Find tables that are in the source but not in the target
    $missingTables = array_diff($sourceTableNames, $targetTableNames);

    if (empty($missingTables)) {
        return "All tables from the source are already in the target.";
    }

    // Disable foreign key checks in the target database
    DB::connection('second_db')->statement('SET FOREIGN_KEY_CHECKS=0;');

    foreach ($missingTables as $tableName) {
        try {
            // Retrieve the CREATE TABLE statement for the source table
            $createTableQuery = DB::connection('mysql')->select("SHOW CREATE TABLE `$tableName`");
            if (empty($createTableQuery)) {
                logger("Failed to retrieve CREATE TABLE statement for {$tableName}");
                continue;
            }

            $originalCreateTableStatement = $createTableQuery[0]->{'Create Table'};
            logger("Original CREATE TABLE for {$tableName}: {$originalCreateTableStatement}");

            // Remove any column or table comments from the CREATE TABLE statement
            $cleanCreateTableStatement = preg_replace('/COMMENT\s+\'[^\']*\'/', '', $originalCreateTableStatement);
            
            // Adjust column definitions (e.g., default values) where necessary
            $cleanCreateTableStatement = preg_replace_callback(
                '/(`\w+`)\s+(int|bigint|tinyint|smallint|mediumint|decimal|double|float)\([^)]+\)([^,]*)/i',
                function ($matches) {
                    if (stripos($matches[0], 'unsigned') !== false) {
                        return "{$matches[1]} {$matches[2]} {$matches[3]}"; // Retain unsigned fields
                    }
                    return "{$matches[1]} {$matches[2]} DEFAULT 0"; // Add default 0 for numeric fields
                },
                $cleanCreateTableStatement
            );

            logger("Cleaned CREATE TABLE for {$tableName}: {$cleanCreateTableStatement}");

            // Create the table in the target database
            DB::connection('second_db')->statement($cleanCreateTableStatement);
            logger("Table {$tableName} created successfully.");
        } catch (\Exception $e) {
            logger("Error creating table {$tableName}: " . $e->getMessage());
        }
    }

    // Re-enable foreign key checks
    DB::connection('second_db')->statement('SET FOREIGN_KEY_CHECKS=1;');

    return "Missing tables copied successfully.";
}



function moveMissingTablesChunked_2()
{
    // Get the list of tables from both source and target databases
  $sourceTables = DB::connection('mysql')->select('SHOW TABLES');
    $targetTables = DB::connection('second_db')->select('SHOW TABLES');

    // Extract table names
    $sourceTableNames = array_map(fn($table) => reset($table), $sourceTables);
    $targetTableNames = array_map(fn($table) => reset($table), $targetTables);

    // Find tables that are in the source but not in the target
    $missingTables = array_diff($sourceTableNames, $targetTableNames);

    if (empty($missingTables)) {
        return "All tables from the source are already in the target.";
    }

    // Disable foreign key checks temporarily
    DB::connection('second_db')->statement('SET FOREIGN_KEY_CHECKS=0;');

    foreach ($missingTables as $tableName) {
        // Get the CREATE TABLE statement from the source database
        $createTableQuery = DB::connection('mysql')->select("SHOW CREATE TABLE `$tableName`");
        if (!$createTableQuery) continue;

        // Extract the CREATE TABLE statement
        $createTableStatement = $createTableQuery[0]->{'Create Table'};

        // Create the table in the target database
        DB::connection('second_db')->statement($createTableStatement);

        // Use chunking to copy data from the source to the target database
        DB::connection('mysql')->table($tableName)
            ->orderBy('id') // Assuming 'id' is the primary key
            ->chunk(1000, function ($data) use ($tableName) {
                // Process data for invalid dates
                $sanitizedData = $data->map(function ($row) {
                    foreach ($row as $column => $value) {
                        if (is_string($value)) {
                            // Handle invalid date or datetime values
                            if ($value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
                                $row->$column = null; // Replace with NULL
                            }
                        }
                    }
                    return (array) $row; // Convert object to array for insertion
                });

                // Insert sanitized data into the target database
                DB::connection('second_db')->table($tableName)->insert($sanitizedData->toArray());
            });
    }

    // Re-enable foreign key checks
    DB::connection('second_db')->statement('SET FOREIGN_KEY_CHECKS=1;');

    return "Migration completed successfully.";

    //return "Missing tables successfully copied to target database.";
}

function setDefaultZeroForNumericColumns()
{
    // Get the list of tables in the target database (second_db)
    $tables = DB::connection('second_db')->select('SHOW TABLES');

    // Iterate through each table
    foreach ($tables as $table) {
        $tableName = reset($table); // Extract the table name

        // Get the columns of the current table
        $columns = DB::connection('second_db')->select("SHOW COLUMNS FROM `$tableName`");

        // Iterate through each column
        foreach ($columns as $column) {
            $columnName = $column->Field;  // Column name
            $columnType = $column->Type;   // Column type
            $isNullable = $column->Null === 'YES'; // Check if column is nullable

            // Check if the column is numeric (int, float, double, or decimal) and does not already have a default value
            if ((strpos($columnType, 'int') !== false || 
                 strpos($columnType, 'float') !== false || 
                 strpos($columnType, 'double') !== false || 
                 strpos($columnType, 'decimal') !== false) && $isNullable) {
                try {
                    // Update NULL values in the column to 0
                    DB::connection('second_db')->statement("UPDATE `$tableName` SET `$columnName` = 0 WHERE `$columnName` IS NULL");

                    // Alter the column to set the default value to 0
                    DB::connection('second_db')->statement("ALTER TABLE `$tableName` MODIFY `$columnName` $columnType NOT NULL DEFAULT 0");
                } catch (\Exception $e) {
                    // Log or handle exceptions if needed
                    echo "Error updating column $columnName in table $tableName: " . $e->getMessage();
                }
            }
        }
    }

    return "Default values for numeric columns (including decimals) have been set to 0, and NULL values have been updated.";
}


function updateSecondDatabaseTablesWithData()
{
    // Fetch all tables in the second database
    $tables = DB::connection('second_db')->select('SHOW TABLES');

    // Extract the table names as a simple array
    $tableNames = array_map(fn($table) => reset($table), $tables);

    // Columns to update and their values
    $columnsToUpdate = [
        'organization_id' => 1,
        '_budget_id' => 1,
    ];

    foreach ($tableNames as $tableName) {
        // Fetch the columns of the current table
        $columnsInTable = DB::connection('second_db')->select("SHOW COLUMNS FROM `$tableName`");

        // Extract column names
        $columnsInTable = array_column($columnsInTable, 'Field');

        // Build the update data only for columns that exist in the current table
        $updateData = [];
        foreach ($columnsToUpdate as $column => $value) {
            if (in_array($column, $columnsInTable)) {
                $updateData[$column] = $value;
            }
        }

        // If there are columns to update, perform the update
        if (!empty($updateData)) {
            DB::connection('second_db')->table($tableName)->update($updateData);
        }
    }

    return "All applicable tables in the second database have been updated successfully.";
}



function set_default_unit_conversion(){
    $all_inventories = \DB::select(" SELECT t1.id as _item_id,t1._unit_id,t2._name as _conversion_unit_name
FROM inventories as t1 
INNER JOIN units as t2 ON t1._unit_id=t2.id ");
    $number_of_unit=0;
    foreach($all_inventories as $inventory){
        $check_is = \DB::table('unit_conversions')->where('_item_id',$inventory->_item_id)->where('_status',1)->first();
        if(empty($check_is)){
            $number_of_unit++;
            \DB::table('unit_conversions')->insert([
                '_item_id'=>$inventory->_item_id,
                '_base_unit_id'=>$inventory->_unit_id,
                '_conversion_unit'=>$inventory->_unit_id,
                '_conversion_unit'=>$inventory->_conversion_unit_name,
                '_conversion_qty'=>1,
                '_status'=>1
            ]);
        }

        // Update Packzise and Brand


    }
$packsizes = \DB::table('inventories')->whereNull('_pack_size_id')->get();
$brands = \DB::table('inventories')->whereNull('_brand_id')->get();
$items_codes = \DB::table('inventories')->orderBy('id','ASC')->get();

foreach($packsizes as $pack){
    \DB::table('inventories')->where('id',$pack->id)->update(['_pack_size_id'=>1]);
}
foreach($brands as $brand){
    \DB::table('inventories')->where('id',$brand->id)->update(['_brand_id'=>1]);
}


foreach($items_codes as $key=>$items_code){
        $cat_id = $items_code->_category_id;
         $category_serial = ($key+1);

            if(strlen($cat_id)==1){
                $base_cat_id = "0".$cat_id;
            }else{
                $base_cat_id = $cat_id;
            }

             if(strlen($category_serial)==1){
                $product_code = "0000".$category_serial;
              }elseif(strlen($category_serial)==2){
                $product_code = "000".$category_serial;
              }elseif(strlen($category_serial)==3){
                $product_code = "00".$category_serial;
              }elseif(strlen($category_serial)==4){
                $product_code = "0".$category_serial;
              }else{
                $product_code = $category_serial;
              }

              $full_product_code = $base_cat_id."-".$product_code;
              //CheckDuplicate Item Code


    \DB::table('inventories')->where('id',$items_code->id)->update(['_code'=>$full_product_code]);
}


  

    return " $number_of_unit Unit Conversion Data Updated";

}


function updateSpecificColumns()
{
    // Define the columns to check
   // $columnsToCheck = ['organization_id', '_branch_id', '_cost_center_id'];
   // $columnsToCheck = ['_unit_conversion', '_transection_unit', '_base_unit'];
    $columnsToCheck = ['_cost_center'];
    
    // Get all table names from the database
    $tables = DB::select('SHOW TABLES');
    $database = config('database.connections.mysql.database'); // Current database name
    $tables = array_map(fn($table) => reset($table), $tables);

    // Loop through each table and check for the required columns
    foreach ($tables as $table) {
        try {
            // Fetch column information for the table
            $columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", [$database, $table]);
            $columnNames = array_column($columns, 'COLUMN_NAME');

            // Check if the table contains all the specified columns
            if (array_intersect($columnsToCheck, $columnNames) === $columnsToCheck) {
                // Update the table to set the values of the specified columns to 1
                // DB::table($table)->update([
                //     'organization_id' => 1,
                //     '_branch_id' => 1,
                //     '_cost_center_id' => 1,
                // ]);
                // DB::table($table)->update([
                //     '_unit_conversion' => 1,
                //     '_transection_unit' => 1,
                //     '_base_unit' => 1,
                // ]);
                DB::table($table)->update([
                    '_cost_center' => 1,
                ]);
                logger("Table {$table}: Updated successfully.");
            }
        } catch (\Exception $e) {
            logger("Table {$table}: Error updating - " . $e->getMessage());
        }
    }

    return "Update process completed.";
}


	function database_table_column_update()
{
    $sourceDb = 'server_avansis_db';
    $targetDb = 'pridepack20_psoft';

    // Step 1: Fetch column differences between databases
    $columnDifferences = DB::select("
        SELECT 
            t1.table_name AS table_name,
            t1.column_name AS column_name,
            t1.column_type AS column_type,
            t1.is_nullable AS is_nullable,
            t1.column_default AS column_default,
            'database1' AS database_name
        FROM 
            information_schema.columns t1
        WHERE 
            t1.table_schema = '{$sourceDb}'
            AND NOT EXISTS (
                SELECT 1
                FROM information_schema.columns t2
                WHERE t2.table_schema = '{$targetDb}'
                  AND t2.table_name = t1.table_name
                  AND t2.column_name = t1.column_name
            )
        UNION
        SELECT 
            t2.table_name AS table_name,
            t2.column_name AS column_name,
            t2.column_type AS column_type,
            t2.is_nullable AS is_nullable,
            t2.column_default AS column_default,
            'database2' AS database_name
        FROM 
            information_schema.columns t2
        WHERE 
            t2.table_schema = '{$targetDb}'
            AND NOT EXISTS (
                SELECT 1
                FROM information_schema.columns t1
                WHERE t1.table_schema = '{$sourceDb}'
                  AND t1.table_name = t2.table_name
                  AND t1.column_name = t2.column_name
            )
    ");

    // Default values for columns
    $isNullable = true; // Allow NULL values by default
    $defaultValue = null; // Default value is NULL

    // Step 2: Add missing columns to the target database
    foreach ($columnDifferences as $column) {
        $tableName = $column->table_name;
        $columnName = $column->column_name;
        $columnType = $column->column_type;

        // Check if the column exists in the target database (second database)
        $columnExists = DB::connection('second_db')
            ->select("SHOW COLUMNS FROM `{$tableName}` WHERE Field = '{$columnName}'");

        if (empty($columnExists)) {
            // Construct ALTER TABLE statement to add the missing column
            $alterStatement = "ALTER TABLE `{$targetDb}`.`{$tableName}` " .
                              "ADD COLUMN `{$columnName}` {$columnType}" .
                              ($isNullable ? ' NULL' : ' NOT NULL') .
                              ($defaultValue !== null ? " DEFAULT {$defaultValue}" : '');

            // Execute ALTER TABLE statement using the second_db connection
            try {
                DB::connection('second_db')->statement($alterStatement);
               // echo "Column '{$columnName}' added to table '{$tableName}' in the second database.\n";
            } catch (\Exception $e) {
                echo "Error adding column '{$columnName}' to table '{$tableName}': {$e->getMessage()}\n";
            }
        }
    }

    // Step 3: Compare and find missing tables
    $tablesToTransfer = DB::connection('mysql')->select("
        SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = '{$sourceDb}'
          AND table_name NOT IN (
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = '{$targetDb}'
          )
    ");

    // Step 4: Add missing tables to the target database
    foreach ($tablesToTransfer as $table) {
        $tableName = $table->table_name;

        // Retrieve table creation SQL from the source database
        $createTableSQL = DB::connection('mysql')->select("SHOW CREATE TABLE `{$sourceDb}`.`{$tableName}`");

        // Modify the SQL to use the target database name
        $createTableSQL = str_replace("`{$sourceDb}`", "`{$targetDb}`", $createTableSQL[0]->{'Create Table'});

        // Create the table in the target database
        try {
            DB::connection('second_db')->statement($createTableSQL);
            //echo "Table '{$tableName}' created in the second database.\n";
        } catch (\Exception $e) {
            echo "Error creating table '{$tableName}': {$e->getMessage()}\n";
        }
    }

    echo 'Missing columns and tables added successfully!';
}




function two_db_table_dirr(){
	$sourceTables = DB::connection('mysql')->select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'pridepack20_psoft'
        ");

        // Get table names from the second database (target)
        $targetTables = DB::connection('second_db')->select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'server_avansis_db'
        ");

        // Extract table names from the query result
        $sourceTableNames = array_column($sourceTables, 'table_name');
        $targetTableNames = array_column($targetTables, 'table_name');

        // Find tables in source database but not in target database
        $tablesInSourceOnly = array_diff($sourceTableNames, $targetTableNames);

        // Find tables in target database but not in source database
        $tablesInTargetOnly = array_diff($targetTableNames, $sourceTableNames);

        return [
            'tables_in_source_only' => $tablesInSourceOnly,
            'tables_in_target_only' => $tablesInTargetOnly,
        ];
    
}


function column_name_diff(){
    //Second DB: pridepack20_psoft

	// Get tables from the first database (source)
        $sourceTables = DB::connection('mysql')->select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'pridepack20_psoft'
        ");

        // Get tables from the second database (target)
        $targetTables = DB::connection('second_db')->select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'server_avansis_db'
        ");

        // Extract table names from the query result
        $sourceTableNames = array_column($sourceTables, 'table_name');
        $targetTableNames = array_column($targetTables, 'table_name');

        $columnDifferences = [];

        // Step 1: Compare column names for tables that exist in both databases
        foreach ($sourceTableNames as $table) {
            if (in_array($table, $targetTableNames)) {
                // Get column names from source database
                $sourceColumns = DB::connection('mysql')->select("
                    SELECT column_name, column_type, is_nullable, column_default
                    FROM information_schema.columns
                    WHERE table_schema = 'pridepack20_psoft'
                      AND table_name = '{$table}'
                ");

                // Get column names from target database
                $targetColumns = DB::connection('second_db')->select("
                    SELECT column_name
                    FROM information_schema.columns
                    WHERE table_schema = 'server_avansis_db'
                      AND table_name = '{$table}'
                ");

                // Extract column names
                $sourceColumnNames = array_column($sourceColumns, 'column_name');
                $targetColumnNames = array_column($targetColumns, 'column_name');

                // Find missing columns in source but not in target
                $columnsInSourceOnly = array_diff($sourceColumnNames, $targetColumnNames);

                // Store the results for this table
                if ($columnsInSourceOnly) {
                    $columnDifferences[$table] = [
                        'columns_in_source_only' => $columnsInSourceOnly,
                    ];

                    // Step 2: Add the missing columns to the second database
                    foreach ($columnsInSourceOnly as $columnName) {
                        $columnDetails = collect($sourceColumns)->firstWhere('column_name', $columnName);

                        // Construct ALTER TABLE statement
                        $alterStatement = "ALTER TABLE server_avansis_db.{$table} " .
                                          "ADD COLUMN {$columnName} {$columnDetails->column_type} " .
                                          ($columnDetails->is_nullable === 'YES' ? 'NULL' : 'NOT NULL') .
                                          ($columnDetails->column_default ? " DEFAULT '{$columnDetails->column_default}'" : '');

                        // Execute the ALTER TABLE statement on the second database
                        try {
                            DB::connection('second_db')->statement($alterStatement);
                            Log::info("Column '{$columnName}' added to table '{$table}' in the second database.");
                        } catch (\Exception $e) {
                            Log::error("Error adding column '{$columnName}' to table '{$table}': " . $e->getMessage());
                        }
                    }
                }
            }
        }

        return $columnDifferences;
}