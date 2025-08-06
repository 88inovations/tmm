<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use Carbon\Carbon;

class DataMigrationController extends Controller
{
    public function showForm()
    {
        return view('data-migration');
    }

    public function migrateData(Request $request)
    {
        $request->validate([
            'migration_date' => 'required|date',
        ]);

        $date = $request->input('migration_date');
        
        try {
            // Get SQL Server connection
            $sqlServerConn = $this->getSqlServerConnection();
            
            // Get data from SQL Server for the selected date
            $sqlServerData = $this->getSqlServerData($sqlServerConn, $date);
            
            // Process and insert into MySQL
            $result = $this->processAndInsertData($sqlServerData);
            
            return redirect()->back()->with('success', "Successfully migrated {$result['inserted']} records. {$result['updated']} records updated.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }
    
    private function getSqlServerConnection()
    {
        $server = config('database.connections.sqlsrv.host');
        $database = config('database.connections.sqlsrv.database');
        $username = config('database.connections.sqlsrv.username');
        $password = config('database.connections.sqlsrv.password');
        $port = config('database.connections.sqlsrv.port', 1433);

        $connectionOptions = [
            "Database" => $database,
            "UID" => $username,
            "PWD" => $password,
            "LoginTimeout" => 15,
            "Encrypt" => false,
            "TrustServerCertificate" => true
        ];

        try {
            $dsn = "sqlsrv:Server=$server,$port;Database=$database";
            $conn = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::SQLSRV_ATTR_QUERY_TIMEOUT => 30
            ]);
            
            return $conn;
        } catch (PDOException $e) {
            throw new \Exception("SQL Server Connection Error: " . $e->getMessage());
        }
    }
    
    private function getSqlServerData($conn, $date)
    {
        $query = "
            SELECT 
                [C_Unique] as reg_id,
                [C_Date],
                [C_Time],
                [L_TID],
                [L_UID],
                [C_Name],
                [C_Office],
                [C_Post],
                [L_Result],
                [L_Mode]
            FROM [UNIS].[dbo].[tEnter] 
            WHERE CONVERT(date, [C_Date]) = ?
            ORDER BY [C_Unique], [C_Date] ASC, [C_Time] ASC
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([$date]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function processAndInsertData($sqlServerData)
{
    $processedData = [];
    $groupedData = [];
    
    // Group data by reg_id (C_Unique)
    foreach ($sqlServerData as $row) {
        $regId = $row['reg_id'];
        
        if (!isset($groupedData[$regId])) {
            $groupedData[$regId] = [
                'first_punch' => null,
                'last_punch' => null,
                'details' => []
            ];
        }
        
        // Combine date and time
        $datetime = Carbon::parse($row['C_Date'] . ' ' . $row['C_Time']);
        
        // Track first and last punch
        if (!$groupedData[$regId]['first_punch'] || $datetime < $groupedData[$regId]['first_punch']) {
            $groupedData[$regId]['first_punch'] = $datetime;
        }
        
        if (!$groupedData[$regId]['last_punch'] || $datetime > $groupedData[$regId]['last_punch']) {
            $groupedData[$regId]['last_punch'] = $datetime;
        }
        
        $groupedData[$regId]['details'][] = $row;
    }
    
    // Prepare data for MySQL insertion
    $inserted = 0;
    $updated = 0;
    
    foreach ($groupedData as $regId => $data) {
        // Find employee details based on reg_id
        $employee = DB::table('account_ledgers')
            ->where('_code', $regId)
            ->select([
                'id', '_account_group_id', '_account_head_id', '_name', '_alious', '_code',
                '_email', '_phone', '_address', '_branch_id', '_designation', '_date_of_birth',
                '_whatsup_number', '_reg_no', 'organization_id', '_cost_center_id'
            ])
            ->first();
        
        if (!$employee) {
            continue; // Skip if employee not found
        }
        
        // Calculate time difference
        $timeDiff = $data['first_punch']->diff($data['last_punch']);
        $timeDiffFormatted = $timeDiff->format('%H:%I:%S');
        
        $attendanceData = [
            'organization_id' => $employee->organization_id,
            '_branch_id' => $employee->_branch_id,
            '_cost_center_id' => $employee->_cost_center_id,
            '_employee_id' => $employee->id,
            '_number' => 'ATD-' . $data['first_punch']->format('Ymd') . '-' . $employee->id,
            '_type' => 'auto',
            '_datetime' => $data['first_punch']->format('Y-m-d H:i:s'),
            '_user_id' => auth()->id() ?? 1, // Default to 1 if not authenticated
            '_is_delete' => 0,
            '_emp_id' => $employee->_code,
            '_employee' => $employee->_name,
            '_updated_by' => auth()->id() ?? 1,
            'reg_id' => $regId,
            '_shift' => null, // You can add shift logic if available
            'atdstat' => 'P', // Present by default
            'flag' => 0,
            'manual_remark' => null,
            'timediff' => $timeDiffFormatted,
            'in_time' => $data['first_punch']->format('H:i:s'),
            'out_time' => $data['last_punch']->format('H:i:s'),
            'remarks' => 'Auto migrated from SQL Server',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Check if record exists for this date and employee
        $existing = DB::table('hrm_attendances')
            ->where('_employee_id', $employee->id)
            ->whereDate('_datetime', $data['first_punch']->format('Y-m-d'))
            ->first();
        
        if ($existing) {
            // Update existing record but preserve some original values
            $updateData = array_merge($attendanceData, [
                '_number' => $existing->_number, // Keep original number
                '_user_id' => $existing->_user_id, // Keep original user who created
                '_is_delete' => $existing->_is_delete, // Keep delete status
                'created_at' => $existing->created_at, // Keep original creation time
            ]);
            
            DB::table('hrm_attendances')
                ->where('id', $existing->id)
                ->update($updateData);
            $updated++;
        } else {
            // Insert new record
            DB::table('hrm_attendances')->insert($attendanceData);
            $inserted++;
        }
    }
    
    return ['inserted' => $inserted, 'updated' => $updated];
}
}