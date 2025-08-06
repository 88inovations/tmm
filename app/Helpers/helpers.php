<?php
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\CostCenter;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\AccountLedger;
use App\Models\Accounts;
use App\Models\VoucherType;
use App\Models\Inventory;
use App\Models\StoreHouse;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\UnitConversion;
use App\Models\InvoicePrefix;
use App\Models\Budgets;
use App\Models\VoucherMaster;
use App\Models\SalesDetail;
use App\Models\ItemInventory;
use App\Models\Sales;
use App\Models\Purchase;
use App\Models\HRM\Company;

function convert_number($number)
{
    if ($number < 0 || $number > 999999999999999) {
        throw new Exception("Number is out of range");
    }
    $decimalPart = ($number * 100) % 100; // Extract the decimal part (up to two decimal places)
    $number = floor($number); // Remove the decimal part for further conversion
    $Kt = floor($number / 10000000); /* Core */
    $number -= $Kt * 10000000;
    $Gn = floor($number / 100000);  /* Lakh */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */
    $res = "";
    if ($Kt) {$res .= convert_number($Kt) . " Core ";}
    if ($Gn) {$res .= convert_number($Gn) . " Lac";}
    if ($kn) {$res .= (empty($res) ? "" : " ") . convert_number($kn) . " Thousand";}
    if ($Hn) {$res .= (empty($res) ? "" : " ") . convert_number($Hn) . " Hundred";}

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {$res .= " ";}
        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];
            if ($n) {$res .= "-" . $ones[$n];}
        }
    }
    if (empty($res)) {$res = "zero";}

    // Add the decimal part if it exists
    if ($decimalPart > 0) {
        $res .= " Point ";
        $decimalPartWords = convert_number($decimalPart);
        $res .= $decimalPartWords;
    }

    return $res;
}


if (! function_exists('attan_connection')) {
    function attan_connection()
    {
        $server = "localhost";          // Use "hostname\instance" for named instances
$port = "1433";                // Default SQL Server port
$database = "UNIS";
$username = "unisuser";
$password = "unisamho";
      $password = "unisamho";

        // Connection Options
        $connectionOptions = [
            "Database" => $database,
            "UID" => $username,        // Note: UID in uppercase for PDO_SQLSRV
            "PWD" => $password,        // Note: PWD in uppercase for PDO_SQLSRV
            "LoginTimeout" => 15,      // 15 second login timeout
            "Encrypt" => false,        // Disable for local connections
            "TrustServerCertificate" => true // Bypass cert validation for local/dev
        ];

        try {
            // Build correct DSN string for PDO_SQLSRV
            $dsn = "sqlsrv:Server=$server,$port;Database=$database";
            
            // Establish connection
            $conn = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::SQLSRV_ATTR_QUERY_TIMEOUT => 30
            ]);
            return $conn;

            echo "✅ Connection established successfully!\n";
            
            // Test query to verify connectivity
            $stmt = $conn->query("SELECT @@VERSION AS sql_version");
            $result = $stmt->fetch();
            echo "SQL Server Version: " . $result['sql_version'] . "\n";

        } catch (PDOException $e) {
            // Detailed error reporting
            echo "❌ Connection failed:\n";
            echo "Error Code: " . $e->getCode() . "\n";
            echo "Error Message: " . $e->getMessage() . "\n";
            
            // Additional troubleshooting info
            echo "\nTroubleshooting Tips:\n";
            echo "1. Verify SQL Server is running on $server:$port\n";
            echo "2. Check SQL Server Configuration Manager -> TCP/IP is enabled\n";
            echo "3. Test connectivity: telnet $server $port\n";
            echo "4. Verify credentials in SQL Server Security settings\n";
            echo "5. Check if SQL Server Browser service is running (for named instances)\n";
            
            // Log full error details
            error_log("SQL Server Connection Error: " . $e->getMessage());
        }
    }
}


function generateUniqueEmail($email) {
    $originalEmail = $email;
    $counter = 1;

    // Check if the email exists in the database
    while (\DB::table('users')->where('email', $email)->exists()) {
        // Email exists, append a number to make it unique
        $email = $originalEmail . '.' . $counter . '@gmail.com';
        $counter++;
    }
    
    return $email;
}




function _vessel_types(){
    return [1=>'Local',2=>'Foreign',3=>'Join'];
}



function _cash_bank_type_id(){
    return 8;
}


function _blood_group_list(){
    return ['A (+ve)','A (-ve)','B (+ve)','B (-ve)','AB (+ve)','AB (-ve)','O (+ve)','O (-ve)'];
}

function _religion_list(){
    return ['Islam'];
}




/*
Accounts Table Voucher Code Data Update

*/

function account_table_voucher_code_update(){
    $accounts_datas = \DB::select("  SELECT  * FROM `accounts` WHERE 1 ");
    foreach($accounts_datas as $data){
        $_ref_master_id  = $data->_ref_master_id ?? 0;

        $table_name = $data->_table_name ?? '';
        if($table_name=='purchase_accounts'){
            $_code = '_order_number';
            $table_name = "purchases";
        }
        if($table_name=='voucher_masters'){
            $_code = '_code';
            $table_name = "voucher_masters";
        }
        if($table_name=='sales_accounts'){
            $_code = '_order_number';
            $table_name = "sales";
        }


    $voucher_code = id_to_cloumn($id,$_code,$table_name);
    Accounts::where('id',$data->id)->update(['_voucher_code'=>$voucher_code]);


    }
    
return "Voucher Code Update";

}


/*Cash and Bank Ledger Group IDS find for Generale Setting option*/


function cash_and_bank_groups(){
      $cash_and_ledger_groups = \DB::select("SELECT _bank_group,_cash_group FROM general_settings");
        $cash_and_ledger_groups_array = array();
        foreach ($cash_and_ledger_groups as $value) {

            $_bank_array = explode(',',$value->_bank_group);
            $_cash_array = explode(',',$value->_cash_group);
            foreach($_bank_array as $val){
                 array_push($cash_and_ledger_groups_array ,intval($val));
            }
            foreach($_cash_array as $val){
                 array_push($cash_and_ledger_groups_array ,intval($val));
            }
        }


    return   $cash_and_ledger_groups_ids=implode(',', $cash_and_ledger_groups_array);
}

/*Cash and Bank Ledger Group IDS find for Generale Setting option*/


function _bank_groups(){
      
     $account_group_configs = DB::table("account_group_configs")->select('_bank_group')->first();
     return  explode(",",$account_group_configs->_bank_group ?? '');
}

/*Cash and Bank Ledger Group IDS find for Generale Setting option*/


function cash_groups(){
      
    $account_group_configs = DB::table("account_group_configs")->select('_cash_group')->first();
     return  explode(",",$account_group_configs->_cash_group ?? '');
}


function _customer_group_array(){
     $account_group_configs = DB::table("account_group_configs")->select('_customer_group')->first();
     return  explode(",",$account_group_configs->_customer_group ?? '');
}


function _supplier_group_array(){
     $account_group_configs = DB::table("account_group_configs")->select('_supplier_group')->first();
     return  explode(",",$account_group_configs->_supplier_group ?? '');
}


function _employee_group_array(){
     $account_group_configs = DB::table("account_group_configs")->select('_employee_group')->first();
     return  explode(",",$account_group_configs->_employee_group ?? '');
}




function _honorarium_group_array(){
     $account_group_configs = DB::table("account_group_configs")->select('_honorarium_group')->first();
     return  explode(",",$account_group_configs->_honorarium_group ?? '');
}


function _student_group_array(){
     $account_group_configs = DB::table("account_group_configs")->select('_student_groups')->first();
     return  explode(",",$account_group_configs->_student_groups ?? '');
}






if (!function_exists('UserCheckbookpageUpload')) {

  function UserCheckbookpageUpload($query) // Taking input image as parameter
    {
        $image_name = date('mdYHis') . uniqid();
        $ext = strtolower($query->getClientOriginalExtension()); // You can use also getClientOriginalName()
        
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = 'checkbookpage/';    //Creating Sub directory in Public folder to put image
        $image_url = $upload_path.$image_full_name;
        $success = $query->move($upload_path,$image_full_name);
 
        return $image_url; // Just return image
    }
}
function  lc_stages(){
    return [
        1=>'LC Open',
        2=>'LC Amendment',
        3=>'Shipment/Freight',
        4=>'Customs Clearance',
        5=>'Other Expenses',
        6=>'Goods Receipt',
        7=>'LC Payment',
    ];
}


function selected_lc_stage($id){
    $stages =  lc_stages();
    return $stages[$id] ?? '';
}

function selected_vessel_type($id){
    foreach(_vessel_types() as $key=>$val){
        if($id==$key){
            return $val;
        }
    }
    return 1;
}

function _sales_periods(){
    return [1=>'Morning',2=>'Evening'];
}

function _selected_sales_periods($key){
    $periods = _sales_periods();
    return $periods[$key] ?? '';
}

if (! function_exists('id_to_cloumn')) {
    function id_to_cloumn($id,$cloumn,$_table)
    {
      $data= \DB::table($_table)->where('id',$id)->first();
      
      return $data->$cloumn ?? '';
      
      
    }
}

function  generateAssignUniqueSerial($assetCategoryId, $organizationId, $branchId, $deptId, $designationId, $projectId, $assetLocationId, $assetRoomId)
    {
        // Here you can customize how the unique serial is generated.
        // For example, concatenating the values and appending a counter or timestamp

        $latestAssetAssign = \App\Models\AssetManagement\AssetAssign::where('asset_category_id', $assetCategoryId)
            ->where('organization_id', $organizationId)
            ->where('branch_id', $branchId)
            ->where('dept_id', $deptId)
            //->where('designation_id', $designationId)
            ->where('project_id', $projectId)
            ->where('asset_location_id', $assetLocationId)
            ->where('asset_room_id', $assetRoomId)
            ->latest('created_at') // Get the latest record
            ->first();

        // If there is no previous record, initialize the serial
        if (!$latestAssetAssign) {
            return "{$assetCategoryId}-{$organizationId}-{$branchId}-{$deptId}-{$projectId}-{$assetLocationId}-{$assetRoomId}-00001";  // Initial serial
        }

        // Extract the last serial number and increment it
        $lastSerial = $latestAssetAssign->assign_unique_serial;
        $lastSerialParts = explode('-', $lastSerial);
        $lastNumber = (int) end($lastSerialParts);  // Get the last number from the serial
        
        $newSerialNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);  // Increment and pad the serial number
        return "{$assetCategoryId}-{$organizationId}-{$branchId}-{$deptId}-{$designationId}-{$projectId}-{$assetLocationId}-{$assetRoomId}-{$newSerialNumber}";
    }



function item_balance_without_lots($organization_id,$_branch_id,$_store_id,$_item_id,$_qty,$_unit_id){
    $data = \App\Models\ItemBalanceWithoutLot::where('organization_id',$organization_id)
                                                    ->where('_branch_id',$_branch_id)
                                                    ->where('_store_id',$_store_id)
                                                    ->where('_item_id',$_item_id)
                                                    ->first();
    $old_qty = $data->_qty ?? 0;
    if(empty($data)){
        $ItemBalanceWithoutLot = new \App\Models\ItemBalanceWithoutLot();
        $ItemBalanceWithoutLot->organization_id =$organization_id;
        $ItemBalanceWithoutLot->_branch_id =$_branch_id;
        $ItemBalanceWithoutLot->_store_id =$_store_id;
        $ItemBalanceWithoutLot->_item_id =$_item_id;
        $ItemBalanceWithoutLot->_qty =$_qty;
        $ItemBalanceWithoutLot->_unit_id =$_unit_id;
        $ItemBalanceWithoutLot->_unit_conversion =1;
        $ItemBalanceWithoutLot->save();
    }else{
       $balance_qty = \App\Models\ItemInventory::where('organization_id',$organization_id)
                                                    ->where('_branch_id',$_branch_id)
                                                    ->where('_store_id',$_store_id)
                                                    ->where('_item_id',$_item_id)
                                                    ->where('_status',1)
                                                    ->sum('_qty');
        $data->_qty =$balance_qty;
        $data->save();
    }

    return true;



}


function prepareHierarchy($items, $parentId = 0, $level = 0)
    {
        $result = [];

        foreach ($items as $item) {
            if ($item->_parent_id == $parentId) {
                $item->_indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level); // Create indentation
                $result[] = $item;
                $children = prepareHierarchy($items, $item->id, $level + 1);
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }


function ledger_balance_update(){
    $get_all_ledgers = \DB::table("account_ledgers")->get();

    $accousts_summary = \DB::select(" SELECT SUM(t1._dr_amount-t1._cr_amount) as _balance,t1._account_ledger 
FROM `accounts` AS t1 WHERE t1._status=1
GROUP BY t1._account_ledger ");
    foreach($accousts_summary as $data){
        $_balance = $data->_balance ?? 0;

        \DB::table("account_ledgers")->where('id',$data->_account_ledger)->update(['_balance'=>$_balance]);
    }

return "Balance Data Updated";
}


    function sales_table_due_receive_update(){
        //First Get Customer Balance

        $customer_balances = \DB::select(" SELECT t1._account_ledger,SUM(t1._dr_amount-t1._cr_amount) as _balance
                                            FROM `accounts` as t1  WHERE t1._status=1 AND t1._account_group IN(9,10)
                                        GROUP BY t1._account_ledger ORDER BY t1._account_ledger ASC ");

        foreach($customer_balances as $key=>$customer_ledger){
            $_balance = $customer_ledger->_balance ?? 0;
            $_ledger_id = $customer_ledger->_account_ledger;
            if($_balance ==0){
                //Update All Sales Invoice with Receive Amount

               $sales_datas =  \DB::table("sales")->where('_status',1)->where('_ledger_id',$_ledger_id)->get();
               foreach($sales_datas as $sales){
                $_total = $sales->_total ?? 0;
                    \DB::table("sales")->where('id',$sales->id)->update(['_receive_amount'=>$_total]);
               }

            }

            //
            if($_balance > 0){

                 $_l_balance_update = _l_balance_update($_ledger_id);

                 $total_sales = Sales::where('_ledger_id', $_ledger_id)
                                                        ->where('_status',1)
                                                        ->sum('_total');

                  $sales_datas =  \DB::table("sales")->where('_status',1)
                                  ->where('_ledger_id',$_ledger_id)
                                  ->orderBy('id','DESC')->get();

               // $history_sales_invoices=[];

                foreach($sales_datas as $sales){

                    $_total = $sales->_total ?? 0;

                    //If balance and first equal then  full amount will be due
                     $_qty_less = $_l_balance_update;
                     $available_quantity =  0;

                     if($total_sales >= $_l_balance_update ){

                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return $_l_balance_update;
                                  $due_sales_info = Sales::where('id', $sales->id)
                                                    ->first();
                                if($due_sales_info){
                                     // array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $available_quantity += (($due_sales_info->_total-$due_sales_info->_total_discount)+$due_sales_info->_total_vat);

                                      if($available_quantity  >= $_l_balance_update  ){
                                        $_less_qty = ((($due_sales_info->_total-$due_sales_info->_total_discount)+$due_sales_info->_total_vat) -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                       
                                         $new_qty = $_less_qty;
                                          $_receive_amount=($_l_balance_update-$new_qty);
                                         $due_sales_info->_receive_amount = $_receive_amount;
                                         $due_sales_info->_due_amount = $new_qty;
                                         $due_sales_info->save();
                                       //  array_push($history_sales_invoices, $due_sales_info);
                                         
                                        }else{
                                            $due_sales_info->_due_amount = $due_sales_info->_total ?? 0;
                                            $due_sales_info->save();
                                          //  array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);


                    }else{
                        \DB::table("sales")->where('id',$sales->id)->update(['_due_amount'=>$_total]);
                       // return "131 update";
                    }

                        
               }

        

            } //End of balance

        }

        return "update all Sales Invoice";
    }


       function purchase_table_due_receive_update(){
        //First Get Customer Balance

        $customer_balances = \DB::select(" SELECT t1._account_ledger,SUM(t1._cr_amount-t1._dr_amount) as _balance
                                            FROM `accounts` as t1  WHERE t1._status=1 AND t1._account_group IN(9,10)
                                        GROUP BY t1._account_ledger ORDER BY t1._account_ledger ASC ");

        foreach($customer_balances as $key=>$customer_ledger){
            $_balance = $customer_ledger->_balance ?? 0;
            $_ledger_id = $customer_ledger->_account_ledger;
            if($_balance ==0){
                //Update All Sales Invoice with Receive Amount

               $sales_datas =  \DB::table("purchases")->where('_status',1)->where('_ledger_id',$_ledger_id)->get();
               foreach($sales_datas as $sales){
                $_total = $sales->_total ?? 0;
                    \DB::table("purchases")->where('id',$sales->id)->update(['_receive_amount'=>$_total]);
               }

            }

            //
            if($_balance > 0){

                 $_l_balance_update = _l_balance_update($_ledger_id);

                 $total_sales = Purchase::where('_ledger_id', $_ledger_id)
                                                        ->where('_status',1)
                                                        ->sum('_total');

                  $sales_datas =  \DB::table("purchases")->where('_status',1)
                                  ->where('_ledger_id',$_ledger_id)
                                  ->orderBy('id','DESC')->get();

               // $history_sales_invoices=[];

                foreach($sales_datas as $sales){

                    $_total = $sales->_total ?? 0;

                    //If balance and first equal then  full amount will be due
                     $_qty_less = $_l_balance_update;
                     $available_quantity =  0;

                     if($total_sales >= $_l_balance_update ){

                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return $_l_balance_update;
                                  $due_sales_info = Purchase::where('id', $sales->id)
                                                    ->first();
                                if($due_sales_info){
                                     // array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $available_quantity += (($due_sales_info->_total-$due_sales_info->_total_discount)+$due_sales_info->_total_vat);

                                      if($available_quantity  >= $_l_balance_update  ){
                                        $_less_qty = ((($due_sales_info->_total-$due_sales_info->_total_discount)+$due_sales_info->_total_vat) -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                       
                                         $new_qty = $_less_qty;
                                          $_receive_amount=($_l_balance_update-$new_qty);
                                         $due_sales_info->_receive_amount = $_receive_amount;
                                         $due_sales_info->_due_amount = $new_qty;
                                         $due_sales_info->save();
                                       //  array_push($history_sales_invoices, $due_sales_info);
                                         
                                        }else{
                                            $due_sales_info->_due_amount = $due_sales_info->_total ?? 0;
                                            $due_sales_info->save();
                                          //  array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);


                    }else{
                        \DB::table("purchases")->where('id',$sales->id)->update(['_due_amount'=>$_total]);
                       // return "131 update";
                    }

                        
               }

        

            } //End of balance

        }

        return "update all Purchase Invoice";
    }



function openig_ledger_amount_to_voucher(){
    $all_ledgers = \DB::table("account_ledgers")->get();

    \DB::table("voucher_masters")->insert([
        '_code'=>1,
        '_from_name'=>'voucher_masters',
        'organization_id'=>1,
        '_branch_id'=>1,
        '_cost_center_id'=>1,
        '_budget_id'=>1,
        '_status'=>1,
    ]);

    foreach($all_ledgers as $ledger){
        $opening_dr_amount = $ledger->opening_dr_amount ?? 0;
        $opening_cr_amount = $ledger->opening_cr_amount ?? 0;
        $_account_type_id = $ledger->_account_head_id ?? 0;
        $_account_group_id = $ledger->_account_group_id ?? 0;
        $_ledger_id = $ledger->id ?? 0;

        if($opening_dr_amount > 0 || $opening_cr_amount > 0){

            $data=[
                '_no'=>1,
                '_account_type_id'=>$_account_type_id,
                '_account_group_id'=>$_account_group_id,
                '_ledger_id'=>$_ledger_id,
                '_dr_amount'=>$opening_dr_amount,
                '_cr_amount'=>$opening_cr_amount,
                '_type'=>'JV',
                '_short_narr'=>'Opening Balance',
                'organization_id'=>1,
                '_branch_id'=>1,
                '_cost_center'=>1,
                '_budget_id'=>1,
                '_status'=>1,
            ]; 

            \DB::table("voucher_master_details")->insert($data);

        }

    }

    return "Opening Balance Transfer to Voucher. Now Edit the Voucher and adjust to Capital Account";
}




function sales_details_update_to_item_inventory(){


    ItemInventory::where('_transection','sales')->delete();

  $all_sales_details = \App\Models\SalesDetail::with(['_items','_units','_trans_unit','master_data'])->where('_status',1)->get();







foreach($all_sales_details as $val){
            $ItemInventory = new \App\Models\ItemInventory();
            $ItemInventory->_item_id =  $val->_item_id;
            $ItemInventory->_item_name =  $val->_items->_name ?? '';
             $ItemInventory->_unit_id =  $val->_base_unit ?? '';
            $ItemInventory->_category_id = _item_category($val->_item_id);
            $ItemInventory->_date = change_date_format($val->created_at);
            $ItemInventory->_time = date('H:i:s');
            $ItemInventory->_transection = "Sales";
            $ItemInventory->_transection_ref = $val->_no;
            $ItemInventory->_transection_detail_ref_id = $val->id;
            $ItemInventory->_qty = -($val->_qty);

            $ItemInventory->_transection_unit = $val->_base_unit;
            $ItemInventory->_unit_conversion = $val->_unit_conversion?? 1;
            $ItemInventory->_base_unit = $val->_base_unit;

            $ItemInventory->_rate = $val->_sales_rate;
            $ItemInventory->_cost_rate = $val->_rate;
            $ItemInventory->_manufacture_date = $val->_manufacture_date;
            $ItemInventory->_expire_date = $val->_expire_date;
            $ItemInventory->_cost_value = ($val->_qty*$val->_rate);
            $ItemInventory->_value = $val->_value ?? 0;
            $ItemInventory->organization_id = $val->master_data->organization_id ?? 1;
            $ItemInventory->_branch_id = $val->master_data->_branch_id ?? 1;
            $ItemInventory->_store_id = $val->master_data->_store_id ?? 1;
            $ItemInventory->_cost_center_id = $val->master_data->_cost_center_id ?? 1;
            $ItemInventory->_store_salves_id = $val->_store_salves_id ?? '';
            $ItemInventory->_status = 1;
            $ItemInventory->_created_by = $val->_created_by;
            $ItemInventory->save();
}


return "sales data upload to item inventory";

             
}





function display_child_category($_childs_category,$level=0,$selected_cat='',$edit_parent_id=0){
    $data="";
    if(sizeof($_childs_category) > 0){
    foreach($_childs_category as $c_key=>$c_val){
         $next_childs = $c_val->_childs ?? [];
         $has_child = sizeof($next_childs);
         $disabled = "";
         if($has_child > 0){ $disabled = "disabled"; }
         $selected = '';
         if($c_val->id==$edit_parent_id){ $selected = 'selected';  }
        // dump($c_val);
         
        $data .= "<option value=".$c_val->id."   ".$selected." >  ".level_wise_option_gap($c_val,$level)."/".$c_val->id."-".$c_val->_name ?? ''."</option>";
       
        if($has_child > 0){
             $level++;
          $data .=display_child_category($next_childs,$level,$c_val->_parent_id,$edit_parent_id);
        }
    }
}
    return $data;

}

function display_child_categoryIndex($_childs_category,$level=0,$selected_cat=''){
    $data="";
    if(sizeof($_childs_category) > 0){
    foreach($_childs_category as $c_key=>$c_val){
         $next_childs = $c_val->_childs ?? [];
         $has_child = sizeof($next_childs);
         $disabled = "";
         if($has_child > 0){ $disabled = "disabled"; }
         $selected = '';
         if($c_val->_parent_id==$selected_cat){ $selected = 'selected';  }
         
        $data .= "<p class='border1px'>  ".level_wise_option_gap($level)."/".$c_val->_name ?? ''."</p>";
        $level++;
        if($has_child > 0){

          $data .=display_child_category($next_childs,$level,$c_val->_parent_id);
        }
    }
}
    return $data;

}

function level_wise_option_gap($c_val,$level=0){

    $gap_data="";
    if($level==0){
        $gap_data = $c_val->_parents->_name;
    }elseif($level==1){
        
       $gap_data = "level 2/".$c_val->_parents->_name;
        //$gap_data .= "----";
     }elseif($level==2){
         $gap_data = "level 3/".$c_val->_parents->_parents->_name."/".$c_val->_parents->_name;
    }elseif($level==3){
         $gap_data = $c_val->_parents->_parents->_parents->_name."/".$c_val->_parents->_parents->_name."/".$c_val->_parents->_name;
    }elseif($level==4){
         $gap_data = "level 4/".$c_val->_parents->_parents->_parents->_parents->_name."/".$c_val->_parents->_parents->_parents->_name."/".$c_val->_parents->_parents->_name."/".$c_val->_parents->_name;
    }elseif($level==5){
         $gap_data = "level 5/".$c_val->_parents->_parents->_parents->_parents->_parents->_name."/".$c_val->_parents->_parents->_parents->_parents->_name."/".$c_val->_parents->_parents->_parents->_name."/".$c_val->_parents->_parents->_name."/".$c_val->_parents->_name;
    }elseif($level==5){
         $gap_data = "--------------/".$c_val->_parents->_name;
    }
    return $gap_data;
}

function get_user_ip(){
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


 function getMACAddress() {
    return '';
}

function user_log_history(){
    $auth_user = \Auth::user();
    $user_id = $auth_user->id ?? '';
    $attep_type = ($user_id) ? 'Success' : 'Fail';

    
    $data=[
            'user_id' => $auth_user->id ?? '',
            'attep_type' => $attep_type,
            'login_at' => now(),
            'ip_address' =>get_user_ip(),
             'mac_address' => getMACAddress(), // MAC address (not feasible in web applications)
             'device_name' => request()->userAgent(), // Device name (not directly feasible in web applications)
        ];


      


    \DB::table("user_login_histories")->insert($data);
}





if (! function_exists('month_names')) {
    function _month_names()
    {
        return [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            ];

    }
}

function month_wise_day($month,$year){
    $date = new DateTime("$year-$month-01"); // Create a DateTime object for the first day of the month
    return $date->format('t'); // Return the number of days in the month
}

if (! function_exists('number_to_month')) {
    function _number_to_month($id)
    {
        $months=_month_names();
        return $months[$id] ?? '';

    }
}



if (! function_exists('_issue_pfix')) {
    function _issue_pfix()
    {
        $data= InvoicePrefix::where('_table_name','material_issues')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}

if (! function_exists('insective_groups')) {
    function insective_groups()
    {
        return [1=>'Employee',2=>'Customer',3=>'Supplier'];
    }
}

if (! function_exists('insective_select_group')) {
    function insective_select_group($_group_key)
    {
       foreach(insective_groups() as $key=>$val){
        if($_group_key==$key){
            return $val;
        }
       }
    }
}



if (! function_exists('_issue_return_pfix')) {
    function _issue_return_pfix()
    {
        $data= InvoicePrefix::where('_table_name','material_issue_returns')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}

function taka_only(){
    return " Taka Only";
}

if (!function_exists('_gender_list')) {
    function _gender_list() 
    {
        return ['Male','Female','Others'];
    }
}
function income_nu_to_title($id){
    $data=_income_statement_titles();
    return $data[$id] ?? '';
}

function _income_statement_titles(){
    return [1=>"OPERATING INCOME",2=>'Operating Expense',3=>'Non-Operating Income',4=>'Non-Operating Expenses'];
}

function id_wise_name($id,$table_name,$_cloumn_name){
    return \DB::table($table_name)->where('id',$id)->first()->$_cloumn_name ?? '';
}

if (!function_exists('find_main_account_id_by_head_id')) {
    function find_main_account_id_by_head_id($head_id) 
    {
        $account_heads = \DB::table("account_heads")->where("id",$head_id)->first();
        return $account_heads->_account_id ?? 0;
    }
}
if (! function_exists('_find_group_to_head')) {
    function _find_group_to_head($id)
    {
        $data = \App\Models\AccountGroup::find($id);
        return $data->_account_head_id ?? 1;                            
    }
}
if (! function_exists('employee_user_create')) {
    function employee_user_create($email,$code,$phone,$name,$organization_id,$branch_id,$_cost_center_id,$_ledger_id)
    {
      
        $user = \App\Models\User::where('email',$email)->first();
        if( $user ){
             $user_id =  $user->id ?? 0;
             return $user->id ?? 0;
        }else{
            $user = new \App\Models\User();
        }

        $user->name = $name ?? '';
        $user->user_name = $code ?? '';
        $user->email = $email ?? $name.'@gmail.com';
        $user->user_type = 'user';
        $user->ref_id = $_ledger_id;
        $user->organization_ids = $organization_id ?? '';
        $user->branch_ids = $branch_id ?? '';
        $user->cost_center_ids = $_cost_center_id ?? '';
        $user->status = 1;
        $user->save();
        $user->assignRole('user');

        return $user->id ?? 0;
    }
} 

function employee_code($organization_id){
     $org_code = \App\Models\HRM\Company::find($organization_id)->_code ?? '';
    $number_of_employee =\App\Models\HRM\HrmEmployees::where('organization_id',$organization_id)->count();
    $add_zeroo='';
    $new_number=($number_of_employee+1);
    
    if(strlen($new_number)==1){
                    $add_zeroo = "0000".$new_number;
                  }elseif(strlen($new_number)==2){
                    $add_zeroo = "000".$new_number;
                  }elseif(strlen($new_number)==3){
                    $add_zeroo = "00".$new_number;
                  }elseif(strlen($new_number)==4){
                    $add_zeroo = "0".$new_number;
                  }else{
                    $add_zeroo = $new_number;
                  }

    return $org_code."-".$add_zeroo;

}

if (! function_exists('create_update_user')) {
    function create_update_user($request)
    {
      
        $user = \App\Models\User::where('email',$request->email)->first();
        if( $user ){
             $user_id =  $user->id ?? 0;
        }

        if($request->email ==''){
            return 0;
        }

      if($request->_ledger_is_user ==1){
       
        $_ledger_id = $request->_ledger_id ?? 0;
        if($user_id ==0){
            $user = new \App\Models\User();
        }else{
           $user =  \App\Models\User::find($user_id); 
        }
        $user->name = $request->_name;
        $user->user_name = $request->_code;
        $user->email = $request->_email;
        $user->user_type = 'user';
        $user->ref_id = $_ledger_id;
        $user->organization_ids = $request->organization_id ?? '';
        $user->branch_ids = $request->_branch_id ?? '';
        $user->cost_center_ids = $request->_cost_center_id ?? '';

        $user->status = 0;
        $user->save();
        $user->assignRole('user');
        $user_id = $user->id;

        return $user_id;
      }else{
        return 0;
      }
    }
} 



if (! function_exists('access_chain_types')) {
    function find_group_and_permision($_rlp_acks,$__user)
    {
      $ack_order = 1;
      foreach($_rlp_acks as $key=>$val){
        if($__user->user_name==$val->user_office_id && $val->ack_order){
            $ack_order = $val->ack_order;
        }
      }

      return $ack_order;
    }
}

if (! function_exists('find_vouchar_check_infos')) {
    function find_vouchar_check_infos($_voucher_no)
    {

        $data= \DB::table("vouchar_check_infos")->where('_voucher_no',$_voucher_no)->where('_check_no','!=','')->first();
            if(!empty($data)){
                $_check_no = $data->_check_no ?? '';
                $_issue_date = $data->_issue_date ?? '';
                $_cash_date = $data->_cash_date ?? '';
                if($_check_no==""){
                    $_check_no='';
                }else{
                     $_check_no="Check No: ".$_check_no."  ";
                }

                if($_issue_date=="0000-00-00"){
                    $_issue_date='';
                }else{
                     $_issue_date="Issue Date: "._view_date_formate($_issue_date)."  ";
                }
                if($_cash_date=="0000-00-00"){
                    $_cash_date='';
                }else{
                     $_cash_date="Issue Date: "._view_date_formate($_cash_date);
                }

                
                $info="[ ".$_check_no."". $_issue_date ."". $_cash_date ." ]";
            return $info ?? '';
        }else{
            return "";
            
        }
    }
}

function key_wise_value($key,$array){
    return $array[$key] ?? '';
}

if (! function_exists('_order_to_id')) {
    function _order_to_id($_coloumn,$_order,$_table)
    {
      $data= \DB::table($_table)->where($_coloumn,$_order)->first();
      return $data->id ?? 0;
    }
}
if (! function_exists('_id_to_name')) {
    function _id_to_name($id,$return_col,$_table)
    {
      $data= \DB::table($_table)->where('id',$id)->first();
      return $data->$return_col ?? 0;
    }
}

if (! function_exists('_id_to_order_number')) {
    function _id_to_order_number($id,$_table)
    {
      $data= \DB::table($_table)->where('id',$id)->first();
      if($_table=="voucher_masters"){
        return $data->_code ?? 0;
      }else{
        return $data->_order_number ?? 0;
      }
      
    }
}
if (! function_exists('access_chain_types')) {
    function access_chain_types()
    {
      return ['RLP'=>'Request for Local Purchase','NOT'=>'NOTESHEET','WOR'=>'WORKORDER'];
    }
}

if (! function_exists('selected_access_chain_types')) {
    function selected_access_chain_types($id)
    {
      foreach(access_chain_types() as $key=>$val){
        if($id == $key){
            return $val;
        } 
      } 
      return 'Empty';
    }
}
if (! function_exists('priorities')) {
    function priorities()
    {
      return [1=>'Urgent',2=>'High',3=>'Medium',4=>'Normal'];
    }
}

if (! function_exists('selected_priority')) {
    function selected_priority($id)
    {
      foreach(priorities() as $key=>$val){
        if($id == $key){
            return $val;
        } 
      } 
      return 'Empty';
    }
}






if (! function_exists('selected_rlp_status')) {
    function selected_rlp_status($id)
    {
      $rlp_status = \DB::table('status_details')->get();
      foreach($rlp_status as $key=>$val){
        if($val->id ==$id){
            return "<button class='btn' style='background:".$val->bg_color."'>".$val->name ?? ''."</button>";
        }
      }
      return "empty";
    }
}

//RLP Database Connection



if (!function_exists('UserImageUpload')) {

  function UserImageUpload($query) // Taking input image as parameter
    {
        $image_name = date('mdYHis') . uniqid();
        $ext = strtolower($query->getClientOriginalExtension()); // You can use also getClientOriginalName()
        
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = 'images/';    //Creating Sub directory in Public folder to put image
        $image_url = $upload_path.$image_full_name;
        $success = $query->move($upload_path,$image_full_name);
 
        return $image_url; // Just return image
    }
}

if (!function_exists('student_image_upload')) {
    function student_image_upload($query)
    {
        $upload_path = public_path('images/'); // Full path to /public/images
        $original_name = $query->getClientOriginalName(); // Original name with extension
        $file_name = pathinfo($original_name, PATHINFO_FILENAME); // Just name
        $extension = $query->getClientOriginalExtension(); // Just extension

        $final_name = $original_name;
        $counter = 1;

        // If file exists, add -1, -2, etc.
        while (file_exists($upload_path . $final_name)) {
            $final_name = $file_name . '-' . $counter . '.' . $extension;
            $counter++;
        }

        // Move the file
        $query->move($upload_path, $final_name);

        // Return the relative path (e.g. images/filename.jpg)
        return 'images/' . $final_name;
    }
}

if (!function_exists('office_days_cat')) {
    function office_days_cat() 
    {
        return ['on','off','half day'];
    }
}
if (!function_exists('full_half')) {
    function full_half() 
    {
        return ['full day','half day'];
    }
}

if (!function_exists('pay_head_types')) {
    function pay_head_types() 
    {
        return ['Payable','Deduction'];
    }
}


if (!function_exists('item_code_generate')) {

  function item_code_generate($cat_id=0) // Taking input image as parameter
    {
             $category_wise_last_row =\DB::table('inventories')->where('_category_id',$cat_id)->count();
             $last_serial =\DB::table('inventories')->where('_category_id',$cat_id)->orderBy('id','Desc')->first();
            $_serial = (($last_serial->_serial ?? 0)+1);
             $category_serial = ($_serial+1);

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

              $data["full_product_code"] =$full_product_code;
              $data["_serial"] =$_serial;

            return  $data;
    }
}

function category_wise_serial($cat_id){
            $category_wise_last_row =\DB::table('asset_items')->where('category_id',$cat_id)->count();
             $last_serial =\DB::table('item_categories')->where('id',$cat_id)->orderBy('id','Desc')->first();
            $_serial = (($last_serial->_serial ?? 0)+1);
             $category_serial = ($category_wise_last_row+1);

            
                $base_cat_id = $last_serial->_code ?? '';

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

            return  $full_product_code;
}

function make_po_number($organization_id,$branch_id){
    $row_counts = \App\Models\PurchaseOrder::where('organization_id',$organization_id)
                                            ->where('_branch_id',$branch_id)
                                            ->count();
     $row_counts = ($row_counts+1);                                   
    $org_code = \App\Models\HRM\Company::find($organization_id)->_code ?? '';
    $branch_code = \App\Models\Branch::find($branch_id)->_code ?? '';
    if(strlen($row_counts)==1){
        $last_row_number = "0".$row_counts;
      }else{
        $last_row_number = $row_counts;
      }
      return $org_code."-".$branch_code."-".$last_row_number;
}

function _ledger_code($_account_head_id){
     $types = \DB::table("account_ledgers")
                ->where('_account_head_id',$_account_head_id)
                ->orderBy('id','DESC')->first();
            $year_prefix ='';
            //$year_prefix =date('y')."-";
             $string = $types->_code ?? ''; // Your mixed string
            if($string ==''){
                $count =1;
            }else{
                $string_to_array=explode('-',$string);
                // return sizeof($string_to_array);
                if(sizeof($string_to_array)==6){
                    $year_prefix =$string_to_array[0]."-".$string_to_array[1]."-".$string_to_array[2]."-".$string_to_array[3]."-".$string_to_array[4]."-" ;
                    $integers = $string_to_array[5] ?? 0; 
                }elseif(sizeof($string_to_array)==5){
                    $year_prefix =$string_to_array[0]."-".$string_to_array[1]."-".$string_to_array[2]."-".$string_to_array[3]."-";
                    $integers = $string_to_array[4] ?? 0; 
                }elseif(sizeof($string_to_array)==4){
                    $year_prefix =$string_to_array[0]."-".$string_to_array[1]."-".$string_to_array[2]."-";
                    $integers = $string_to_array[3] ?? 0; 
                }elseif(sizeof($string_to_array)==3){
                    $year_prefix =$string_to_array[0]."-".$string_to_array[1]."-";
                    $integers = $string_to_array[2] ?? 0; 
                }elseif(sizeof($string_to_array)==2){
                    $year_prefix =$string_to_array[0]."-";
                    $integers = $string_to_array[1] ?? 0; 
                }else{
                    $year_prefix ='';
                  //  $year_prefix =date('y')."-";
                    $integers=0;
                }

                $count = str_pad((intval( $integers)+1), 5, '0', STR_PAD_LEFT);
              //    preg_match_all('/\d+/', $string, $matches); // Match all integer numbers
              //    $integers = $matches[0]; // Extracted integer numbers
              // return  $count = $prefix .(intval(implode("", $integers))+1);
            }
           
         // Check if the generated code is already in use (Duplicate check)
    $generated_code = $year_prefix . $count;
    while (\DB::table('account_ledgers')->where('_code', $generated_code)->exists()) {
        $count = str_pad((intval($count) + 1), 5, '0', STR_PAD_LEFT); // Increment the count if a duplicate is found
        $generated_code = $year_prefix . $count;
    }

    return $generated_code;
}


function make_order_number($table,$organization_id,$branch_id,$_date='',$order_number_pattern=1){

     $order_number_pattern =1;
     $prefix = _find_invoice_prefix($table);

    //Patter 1 =Prefix [You Can Prefix Make Empty], Year 2 digit, Month 2 digit, Date 2 Digit and Count + 1

    //

     
if($order_number_pattern==1){
    if($_date ==''){
       $_date= date('Y-m-d');
    }
    $_date = change_date_format($_date ?? date('Y-m-d'));
    $year=   date('y', strtotime($_date));
    $month=   date('m', strtotime($_date));
    $_date_filed='_date';
    $column_name = '_order_number';
    if($table=="voucher_masters"){
        $column_name = '_code';
    }
    if($table=="rlp_masters"){
        $_date_filed = 'request_date';
        $column_name = 'rlp_no';
    }
    if($table=="bill_receives"){
        $column_name = 'BillRecvID';
    }
    $year_big=   date('Y', strtotime($_date));
    $small_year=   date('y', strtotime($_date));
    $month=   date('m', strtotime($_date));
    $year_prefix = $prefix.$small_year."-";
   // return $table;



        $currnt_year=date('Y');
        

         $types = \DB::table($table)
                ->whereYear($_date_filed,$year_big)
                ->orderBy('id','DESC')->first();

            $string = $types->$column_name ?? ''; // Your mixed string
            if($string ==''){
                $count =1;
            }else{
                $string_to_array=explode('-',$string);
                // return sizeof($string_to_array);
                if(sizeof($string_to_array)==6){
                    $integers = $string_to_array[5] ?? 0; 
                }elseif(sizeof($string_to_array)==5){
                    $integers = $string_to_array[4] ?? 0; 
                }elseif(sizeof($string_to_array)==4){
                    $integers = $string_to_array[3] ?? 0; 
                }elseif(sizeof($string_to_array)==3){
                    $integers = $string_to_array[2] ?? 0; 
                }elseif(sizeof($string_to_array)==2){
                    $integers = $string_to_array[1] ?? 0; 
                }else{
                    $integers=0;
                }

              return  $count = $year_prefix .str_pad((intval( $integers)+1), 5, '0', STR_PAD_LEFT);
              //    preg_match_all('/\d+/', $string, $matches); // Match all integer numbers
              //    $integers = $matches[0]; // Extracted integer numbers
              // return  $count = $prefix .(intval(implode("", $integers))+1);
            }
           
        return  $voucherNumber =   $year_prefix . str_pad($count, 5, '0', STR_PAD_LEFT);


    }

if($order_number_pattern==2){
    if($table =="productions"){
        $org_cloumn="_from_organization_id";
        $branch_cloumn="_from_branch";
    }else{
       $org_cloumn="organization_id";
        $branch_cloumn="_branch_id"; 
    }
    $row_counts = \DB::table($table)->where($org_cloumn,$organization_id)
                                            ->where($branch_cloumn,$branch_id)
                                            ->count();
     $row_counts = ($row_counts+1);                                   
    $org_code = \App\Models\HRM\Company::find($organization_id)->_code ?? '';
    $branch_code = \App\Models\Branch::find($branch_id)->_code ?? '';
    if(strlen($row_counts)==1){
        $last_row_number = "0".$row_counts;
      }else{
        $last_row_number = $row_counts;
      }
      return $prefix.$org_code."-".$branch_code."-".$last_row_number;
  }



    $last_row_data = \DB::table($table)->orderBy('id', 'desc')->first()->id ?? 0;
    return $prefix.($last_row_data+1);
  


}


if (!function_exists('item_code_Regenerate')) {

  function item_code_Regenerate() 
    {
             //Regenerate of item Code

        //Fetch all data
        $all_items = Inventory::orderBy('_item','ASC')->get();
            $rearrage_items = [];
            foreach ($all_items as $key => $value) {
               $rearrage_items[$value->_category_id][]=$value;
            }
            $category_serial=0;
            foreach ($rearrage_items as $key => $val) {
                if(strlen($key)==1){
                $base_cat_id = "0".$key;
                }else{
                  $base_cat_id = $key;
                }
                $category_serial=1;
                foreach ($val as $product_key => $product_value) {
                  

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
                  $product_row_id = $product_value["id"];
                Inventory::where('id',$product_row_id)->update(['_code'=>$full_product_code,'_serial'=>$category_serial]);
                  $category_serial++;
            }
        }
    }
}






if (! function_exists('_itemUnit_update')) {
    function _itemUnit_update($_item_id,$_item_name,$_unit_id)
    {
        \DB::table("item_inventories")->where("_item_id",$_item_id)
                                    ->update(['_unit_id'=>$_unit_id,'_item_name'=>$_item_name]);
        \DB::table("product_price_lists")->where("_item_id",$_item_id)
                                    ->update(['_unit_id'=>$_unit_id,'_item'=>$_item_name]);
        \DB::table("inventories")->where("id",$_item_id)
                                    ->update(['_unit_id'=>$_unit_id,'_item'=>$_item_name]);                            
    }
}
if (! function_exists('_find_category_id')) {
    function _find_category_id($_category)
    {
        $data = ItemCategory::where('_name',$_category)->first();
        return $data->id ?? 1;                            
    }
}
if (! function_exists('findItemBaseCat')) {
    function findItemBaseCat($id)
    {
        $data = Inventory::where('id',$id)->first();
        return $data->_item_category ?? 1;                            
    }
}



if (! function_exists('invoice_barcode')) {
    function invoice_barcode($_order_number)
    {
       $generator = new Picqer\Barcode\BarcodeGeneratorPNG();  
       // echo  '<img style="max-width:90% !important;height: 0.24in !important; display: block;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode('"'.$_order_number.'"', $generator::TYPE_CODE_128)) . '">';    



       echo  '<img style="max-width:90% !important;height: 0.24in !important; display: block;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode($_order_number, $generator::TYPE_CODE_128)) . '">';            
    }
}

if (! function_exists('delivery_company')) {
    function delivery_company()
    {
       return [0=>"Own Delivery",1=>"Food Panda",2=>"Pathao"];                           
    }
}
if (! function_exists('_table_name')) {
    function _table_name($table_ids)
    {
        
        $tables = \DB::select( "SELECT _name FROM table_infos where id IN(".$table_ids.")" );   
        $_table_array = [];
        foreach ($tables as $key => $value) {
           array_push($_table_array, $value->_name);
        } 

        $_table_stings  =implode(",",$_table_array);  
        return $_table_stings;                   
    }
}

if (! function_exists('unitConversation_save')) {
    function unitConversation_save($_item_id,$_unit_id,$_conversion_qty,$_conversion_unit,$unit_status,$action=0)
    {
        if($action==0){
            $UnitConversion = new UnitConversion();
        }else{
           $UnitConversion = UnitConversion::find($action); 
        }
        
        $UnitConversion->_item_id = $_item_id;
        $UnitConversion->_base_unit_id =  $_unit_id;
        $UnitConversion->_conversion_qty =  $_conversion_qty;
        $UnitConversion->_conversion_unit =  $_conversion_unit;
        $UnitConversion->_status =  $unit_status;
        $UnitConversion->_conversion_unit_name =  _find_unit($_conversion_unit);
        $UnitConversion->save();                            
    }
}


// if (!function_exists('sms_send')) {
//     function sms_send($messages, $to){
//         $sending_phone_numbers = array();
//         $phone_numbers = "";
//         if($to !=""){
//             $phone_array=explode(",",$to);
//             foreach ($phone_array as $_phone_num) {
//                 $_phone_num = str_replace('-', '', $_phone_num);
//                 $newstring = substr($_phone_num, -11);
//                 if(strlen($newstring)==11){
//                     array_push($sending_phone_numbers, $newstring);
//                 } 
//             }
//         }
//         if(sizeof($sending_phone_numbers) > 0){
//            $phone_numbers = implode(",",$sending_phone_numbers);
//         }

//         return "ok";

//         if($phone_numbers !=""){
//             $company = \DB::table("general_settings")->select("title")->first();
//             $messages = $messages;
//             $messages =urlencode($messages);
     


// $_phone = str_replace('-', '', $phone_numbers);
//            $toUser =$_phone;
       
// $apikey ="4a76b03e4b5a6d93";
// $secretkey ="a6b8685c";
// $sender="AVANSIS%20BD";
// $message=$messages;
//              $url="http://217.172.190.215/sendtext?apikey=".$apikey."&secretkey=".$secretkey."&callerID=".$sender."&toUser=".$toUser."&messageContent=".$message."";  
//             $curl = curl_init();
            
//             curl_setopt($curl, CURLOPT_URL, $url);
//             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//             curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , 30);
//             curl_setopt($curl, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
//             curl_setopt($curl, CURLOPT_HEADER, 0);
//             $result = curl_exec($curl);
//             $err = curl_error($curl);
//             curl_close($curl);


//             if($err){
//                 return $err;
//             }
                
            
//         }else{
//             return "no";
//         }

        
//     }
//  }



if (!function_exists('sms_send')) {
    function sms_send($messages, $to){

        return "ok";

        $sending_phone_numbers = array();
        $phone_numbers = "";
        if($to !=""){
            $phone_array=explode(",",$to);
            foreach ($phone_array as $_phone_num) {
                $newstring = substr($_phone_num, -11);
                if(strlen($newstring)==11){
                    array_push($sending_phone_numbers, $newstring);
                } 
            }
        }
        if(sizeof($sending_phone_numbers) > 0){
           $phone_numbers = implode(",",$sending_phone_numbers);
        }

        if($phone_numbers !=""){
            $company = \DB::table("general_settings")->select("title",'sms_url','sms_apikey','sms_sender','sms_secretkey')->first();
            $messages = $messages.".Thanks,".$company->title ?? '';
            $messages = urlencode($messages);
            $apikey     = $company->sms_apikey ?? '';
            $secretkey  = $company->sms_secretkey ?? '';
            $sender     = $company->sms_sender ?? '';
            $sms_url    = $company->sms_url ?? '';
            


           $toUser =$phone_numbers;
        //   https://apismpp.ajuratech.com/sendtext?apikey=API_KEY&secretkey=SECRET_KEY&callerID=SENDER_ID&toUser=MOBILE_NUMBER&messageContent=MESSAGE
// $apikey     = "9e47053b71ab28ff";
// $secretkey  = "a4eb9bb9";
// $sender     = "8804445629106";
// $sms_url    = "http://217.172.190.215";
$message    = $messages;
             $url="".$sms_url."/sendtext?apikey=".$apikey."&secretkey=".$secretkey."&callerID=".$sender."&toUser=".$toUser."&messageContent=".$message."";  
            $curl = curl_init();
            
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , 30);
            curl_setopt($curl, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
            curl_setopt($curl, CURLOPT_HEADER, 0);
            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);


            if($err){
                return $err;
            }
                
            
        }else{
            return "no";
        }

        
    }
 }



if (!function_exists('_barcode_insert_update')) {
    function _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0){
        
        $modelName = "\\App\\Models\\".$modelName;
           
         $data = $modelName::where('_p_p_id',$_p_p_id)
                            ->where('_item_id',$_item_id)
                            //->where('_no_id',$_no_id)
                            //->where('_no_detail_id',$_no_detail_id)
                            ->where('_barcode',$_barcode)
                            ->first();
        if(empty($data)){
            $data = new $modelName();
        }
       $data->_p_p_id = $_p_p_id;
       $data->_item_id = $_item_id;
       if($p==0){
            $data->_no_id = $_no_id;
            $data->_no_detail_id = $_no_detail_id;
       }
       
       if($_return ==1){
            if(($data->_qty-$_qty) >=0){
                $data->_qty = ($data->_qty-$_qty);
            }
         
         }else{
            $data->_qty = $_qty;
         }
      
       $data->_barcode = $_barcode;
       $data->_status = $_status;
       $data->save();

       if($data->_qty < 1){
          $id = $data->id;
          $modelName::where('id',$id)->update(['_status'=>0]);
       }
       
        
    }
 }



if (! function_exists('_oposite_account')) {
    function _oposite_account($_master_id,$_table_name,$_ledger_id)
    {
        $_ledgers = \DB::select(" SELECT DISTINCT t2._name FROM `accounts` AS t1 
            INNER JOIN account_ledgers AS t2 ON t2.id=t1._account_ledger
            WHERE t1._status =1 AND t1.`_table_name`='".$_table_name."' 
            AND t1.`_ref_master_id`=".$_master_id." AND t1.`_account_ledger` !=$_ledger_id ");
       
        return $_ledgers;
    }
}

if (! function_exists('_devloped_by')) {
    function _devloped_by()
    {
        //return "sohoz-hisab.com call:01677-023131";
    }
}



if (! function_exists('_barcode_status')) {
    function _barcode_status($modelName,$_no_id)
    {
        $modelName = "\\App\\Models\\".$modelName; 
        $data = $modelName::where('_no_id',$_no_id)
                            ->update(['_status'=>0,'_qty'=>0]);
    }
}

if (! function_exists('convertLocalToUTC')) {
    function convertLocalToUTC($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'Europe/Paris')->setTimezone('UTC');
    }
}

if (! function_exists('convertUTCToLocal')) {
    function convertUTCToLocal($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'UTC')->setTimezone('Europe/Paris');
    }
}

if (! function_exists('default_pagination')) {
    function default_pagination()
    {
        return 20;
    }
}

if (! function_exists('_php_round')) {
    function _php_round($_amount,$_param=1)
    {
        return round($_amount);
    }
}


if (! function_exists('_cash_customer_check')) {
    function _cash_customer_check($_cutomer_id,$_selected_customers,$_bill_amount,$_total)
    {
            if($_selected_customers !=0){
                $selected_customer_array = explode(",",$_selected_customers);
                if(in_array($_cutomer_id, $selected_customer_array)){
                    if(intval($_bill_amount) !=intval($_total)){
                        return "no";
                    }
                }
              }
    }
}









if (! function_exists('inventory_stock_update')) {
    function inventory_stock_update($item_id)
    {
        $balance=\DB::select("SELECT SUM(IFNULL(_qty,0)  ) as _balance FROM item_inventories WHERE _item_id=$item_id and _status=1 ");
        \DB::table('inventories')->where('id',$item_id)->update(['_balance'=>$balance[0]->_balance,'_is_used'=>1]);
        \DB::table("product_price_lists")->where('_qty','>',0)->where('_status',0)->update(['_status'=>1]);
    }
}



if (! function_exists('_inventory_last_price')) {
    function _inventory_last_price($item_id,$_pur_rate,$_sale_rate)
    {
        
        \DB::table('inventories')->where('id',$item_id)
                                ->update(['_pur_rate'=>$_pur_rate,'_sale_rate'=>$_sale_rate]);
    }
}



if (! function_exists('all_inventory_stock_update')) {
    function all_inventory_stock_update()
    {
        \DB::table('inventories')
         ->update(['_balance'=>0]);
         
        $all_items=\DB::select("SELECT SUM(IFNULL(_qty,0)  ) as _balance,_item_id FROM item_inventories where _status=1 group By _item_id ORDER BY _item_id ASC ");
        foreach($all_items as $item){
            \DB::table('inventories')
            ->where('id',$item->_item_id)->update(['_balance'=>$item->_balance,'_is_used'=>1]);
        }

        return "Balance Data Update";
        
    }
}



if (! function_exists('_l_balance_update')) {
    function _l_balance_update($ledger)
    {

       
        $balance=\DB::select("SELECT SUM(IFNULL(_dr_amount,0)-IFNULL(_cr_amount,0)) as _balance 
            FROM `accounts` WHERE _account_ledger=$ledger  AND _status=1 ");

      
      return $balance[0]->_balance ?? 0;
    }
}


if (! function_exists('ledger_balance_update')) {
    function ledger_balance_update($ledger)
    {

        $balance=\DB::select("SELECT SUM(IFNULL(_dr_amount,0)-IFNULL(_cr_amount,0)) as _balance FROM `accounts` WHERE _account_ledger=$ledger AND _status=1 ");
        \DB::table('account_ledgers')->where('id',$ledger)->update(['_balance'=>$balance[0]->_balance,'_is_used'=>1]);
    }
}

function _find_id_to_code($_table_name,$_ref_master_id){
    if($_table_name =="production"){
        $_table_name ="productions";
    }
    
    if($_table_name =="sales_accounts"){
        $_table_name ="sales";
    }
    if($_table_name =="sales_return_accounts"){
        $_table_name ="sales_returns";
    }
    
    if($_table_name =="purchase_accounts"){
        $_table_name ="purchases";
    }
    
    
    if($_table_name =="purchase_return_accounts"){
        $_table_name ="purchase_returns";
    }
    
    if($_table_name =="purchase_return"){
        $_table_name ="purchase_returns";
    }
    
    if($_table_name =="purchase_order_accounts"){
        $_table_name ="purchase_orders";
    }
    
    

    $data = DB::table($_table_name)->where('id',$_ref_master_id)->first();
    $code = '';
    if(isset($data->_order_number) && $data->_order_number !=''){
        $code = $data->_order_number ?? '';
    }
    if(isset($data->_code) && $data->_code !=''){
        $code = $data->_code ?? '';
    }
    return $code ?? '';
}

if (! function_exists('account_data_save')) {
       function account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount,$_cr_amount,$_branch_id,$_cost_center,$_name,$_serial=0,$organization_id=1,$_pair=1){
       
        
        $_account_head =  ledger_to_group_type($_account_ledger)->_account_head_id;
        $_account_group =  ledger_to_group_type($_account_ledger)->_account_group_id;
            $Accounts =  Accounts::where('_ref_master_id',$_ref_master_id)
                                    ->where('_ref_detail_id',$_ref_detail_id)
                                    ->where('_table_name',$_table_name)
                                    ->where('_account_ledger',$_account_ledger)
                                    ->where('_serial',$_serial)
                                    ->first();
            if(empty($Accounts)){
                $Accounts = new Accounts();
            }
            if($_table_name=='transfer'){
                $_table_name='productions';
            }
            $_voucher_code = _find_id_to_code($_table_name,$_ref_master_id);
             $_sales_man_id  = 0;
            if($_table_name =='sales' || $_table_name =='sales_returns' || $_table_name =='sales_without_lots' || $_table_name =='sales_return_wlms' ||  $_table_name =='resturant_sales' ||  $_table_name =='receive_payments' ){
                $_sales_man_id  = id_to_cloumn($_ref_master_id,'_sales_man_id',$_table_name);
            }
            
            
            $Accounts->_ref_master_id = $_ref_master_id;
            $Accounts->_ref_detail_id = $_ref_detail_id;
            $Accounts->_voucher_code = $_voucher_code ?? '';
            $Accounts->_short_narration = $_short_narration;
            $Accounts->_narration = $_narration;
            $Accounts->_reference = $_reference;
            $Accounts->_transaction = $_transaction;
            $Accounts->_date = $_date;
            $Accounts->_table_name = $_table_name;
            $Accounts->_account_head = $_account_head;
            $Accounts->_account_group = $_account_group;
            $Accounts->_account_ledger = $_account_ledger;
            $Accounts->_dr_amount = $_dr_amount;
            $Accounts->_cr_amount = $_cr_amount;
            $Accounts->_branch_id = $_branch_id;
            $Accounts->organization_id = $organization_id;
            $Accounts->_cost_center = $_cost_center;
            $Accounts->_sales_man_id = $_sales_man_id;
            $Accounts->_name =$_name;
            $Accounts->_status =1;
            $Accounts->_serial =$_serial;
            $Accounts->_pair =$_pair;
            $Accounts->save(); 




            $id= $Accounts->id;

            ledger_balance_update($_account_ledger);
        

    }
}


if (! function_exists('_item_category')) {
    function _item_category($item)
    {
        $cates = Inventory::where('id',$item)->select('_category_id')->first();
        return $cates->_category_id ?? 0;
    }
}

if (! function_exists('_p_t_status')) {
    function _p_t_status($_p_status)
    {
        if($_p_status ==1){
            return "Transit";
        }elseif($_p_status ==2){
            return "Work-in-progress";
        }elseif($_p_status ==3){
            return "Complete";
        }else{
            return "N/A";
        }
    }
}






if (! function_exists('filterableStores')) {
    function filterableStores($request_store_ids,$permited_stores)
    {
        $_store_ids = array();
         
         if(sizeof($request_store_ids) > 0){
            foreach ($request_store_ids as $value) {
                array_push($_store_ids, (int) $value);
            }
        }else{
                foreach ($permited_stores as $val) {
                    array_push($_store_ids, $val->id);
                }
            
        }
        return $_store_ids;
    }
}

if (! function_exists('filterableBranch')) {
    function filterableBranch($request_branchs,$permited_branch)
    {
        $_branch_ids = array();
         
         if(sizeof($request_branchs) > 0){
            foreach ($request_branchs as $value) {
                array_push($_branch_ids, (int) $value);
            }
        }else{
                foreach ($permited_branch as $branch) {
                    array_push($_branch_ids, $branch->id);
                }
            
        }
        return $_branch_ids;
    }
}

if (! function_exists('filterableOrganization')) {
    function filterableOrganization($request_organizations,$permited_organizations)
    {
        $_organization_ids = array();
         
         if(sizeof($request_organizations) > 0){
            foreach ($request_organizations as $value) {
                array_push($_organization_ids, (int) $value);
            }
        }else{
                foreach ($permited_organizations as $org) {
                    array_push($_organization_ids, $org->id);
                }
            
        }
        return $_organization_ids;
    }
}



if (! function_exists('filterableCostCenter')) {
    function filterableCostCenter($request_cost_centers,$permited_costcenters)
    {
        
         $_cost_center_ids=array();
        if(sizeof($request_cost_centers) > 0){
            foreach ($request_cost_centers as $value) {
                array_push($_cost_center_ids, (int) $value);
            }
        }else{
            foreach ($permited_costcenters as $cost_center) {
                array_push($_cost_center_ids, $cost_center->id);
            }
            
        }
        return $_cost_center_ids;
    }
}



if (! function_exists('permited_branch')) {
    function permited_branch($branch_ids)
    {
        return Branch::whereIn('id',$branch_ids)->select('id','_name')->get();
    }
}


if (! function_exists('_branch_name')) {
    function _branch_name($branch_ids)
    {
        $branch= Branch::where('id',$branch_ids)->select('_name')->first();
        return $branch->_name ?? 'ALL';
    }
}

if (! function_exists('_unit_name')) {
    function _unit_name($id)
    {
        $data= Units::where('id',$id)->select('_name')->first();
        return $data->_name ?? '';
    }
}

if (! function_exists('_store_name')) {
    function _store_name($id)
    {
        $store= StoreHouse::where('id',$id)->select('_name')->first();
        return $store->_name ?? '';
    }
}

if (! function_exists('_cost_center_name')) {
    function _cost_center_name($id)
    {
        $data= CostCenter::where('id',$id)->select('_name')->first();
        return $data->_name ?? 'ALL';
    }
}
if (! function_exists('_company_name')) {
    function _company_name($id)
    {
        $data= Company::where('id',$id)->select('_name')->first();
        return $data->_name ?? '';
    }
}

if (! function_exists('_category_name')) {
    function _category_name($id)
    {
        $data= ItemCategory::where('id',$id)->select('_name')->first();
        return $data->_name ?? '';
    }
}

if (! function_exists('_item_name')) {
    function _item_name($id)
    {
        $data= Inventory::where('id',$id)->select('_item as _name')->first();
        return $data->_name ?? '';
    }
}


if (! function_exists('_ledger_name')) {
    function _ledger_name($id)
    {
        $data= AccountLedger::where('id',$id)->select('_name')->first();
        return $data->_name ?? '';
    }
}

if (! function_exists('_group_name')) {
    function _group_name($id)
    {
        $data= AccountGroup::where('id',$id)->select('_name')->first();
        return $data->_name ?? '';
    }
}

if (! function_exists('_find_voucher_code')){
    function _find_voucher_code($id,$table_name)
    {
        if($table_name=="purchase_accounts"){
        $table_name=="purchases";
        }
        $data= \DB::table($table_name)->where('id',$id)->first();

// voucher_masters



// purchases_return
// purchase_return_accounts
// sales
// sales_accounts
// warranty_masters
// warranty_accounts
// resturant_sales
// restaurant_sales_accounts
// resturant_sales_accounts
// sales_return
// sales_return_accounts
// damage
// transfer
// production
// replacement_masters
// replacement_item_accounts
// warranty_masters
// service_masters
// individual_replace_masters


        if($table_name=="voucher_masters"){
            return $data->_code ?? '';
        }else{
            return $data->_order_number ?? '';
        }
        
    }
}






if (! function_exists('permited_budgets')) {
    function permited_budgets($ids)
    {
        return Budgets::whereIn('_cost_center_id',$ids)
                    ->select('id','_name')
                    ->where('_status',1)
                    ->get();
    }
}


if (! function_exists('permited_costcenters')) {
    function permited_costcenters($ids)
    {
        return CostCenter::whereIn('id',$ids)->select('id','_name')->get();
    }
}

if (! function_exists('permited_stores')) {
    function permited_stores($ids)
    {
        return StoreHouse::whereIn('id',$ids)->select('id','_name')->get();
    }
}

if (! function_exists('permited_organization')) {
    function permited_organization($ids)
    {
        return \App\Models\HRM\Company::whereIn('id',$ids)->select('id','_name')->get();
    }
}


if (! function_exists('filter_page_numbers')) {
    function filter_page_numbers()
    {
        return  [5,10,20,30,40,50,100,200,300,400,500];
    }
}

if (! function_exists('db_name')) {
    function db_name()
    {
        return  "branch_wise_account_soft";
    }
}

if (! function_exists('common_status')) {
    function common_status()
    {
        return  ['1'=>'Active','0'=>'In Active'];
    }
}

if (! function_exists('yes_nos')) {
    function yes_nos()
    {
        return  [0=>'NO',1=>'YES'];
    }
}
if (! function_exists('selected_yes_nos')) {
    function selected_yes_nos($key)
    {
        $yes_nos=yes_nos();
        return  $yes_nos[$key] ?? '';
    }
}
if (! function_exists('_sales_spot')) {
    function _sales_spot()
    {
        return  [1=>'Spot Sales',2=>'Online Sales'];
    }
}
if (! function_exists('_delivery_status')) {
    function _delivery_status()
    {
        return  [1=>'Order Placement',2=>'Cancel',3=>'Partial Delivery',4=>'Delivery',5=>'Processing',6=>'In-Transit & Tracking'];
    }
}

if (! function_exists('_selected_delivery_status')) {
    function _selected_delivery_status($id)
    {
        foreach (_delivery_status() as $key => $value) {
            if($id ===$key){
                return $value;
            }
        }
    }
}
if (! function_exists('_warranty_status')) {
    function _warranty_status()
    {
        return  [1=>'Receive',2=>'Processing',3=>'Complete',4=>'Deliverd',5=>'Cancel',6=>'Replace'];
    }
}
if (! function_exists('_service_status')) {
    function _service_status()
    {
        return  [1=>'Receive',2=>'Processing',3=>'Complete',4=>'Deliverd',5=>'Cancel'];
    }
}
if (! function_exists('_selected_warranty_status')) {
    function _selected_warranty_status($id)
    {
        foreach (_warranty_status() as $key => $value) {
            if($id ===$key){
                return $value;
            }
        }
    }
}
if (! function_exists('selected_ser_status')) {
    function selected_ser_status($id)
    {
        foreach (_service_status() as $key => $value) {
            if($id ===$key){
                return $value;
            }
        }
    }
}

if (! function_exists('asc_desc')) {
    function asc_desc()
    {
        return  ['DESC','ASC'];
    }
}

if (! function_exists('selected_status')) {
    function selected_status($value)
    {
        foreach(common_status() as $key=>$val){
            if($key == $value){
                return $val;
            }
        }
    }
}

if (! function_exists('selected_status')) {
    function selected_status($value)
    {
        foreach(common_status() as $key=>$val){
            if($key == $value){
                return $val;
            }
        }
    }
}


if (! function_exists('selected_yes_no')) {
    function selected_yes_no($value)
    {
        foreach(yes_nos() as $key=>$val){
            if($key == $value){
                return $val;
            }
        }
    }
}


if (! function_exists('default_date_formate')) {
    function default_date_formate($value='DD-MM-YYYY')
    {
        return $value;
    }
}

if (! function_exists('voucher_prefix')) {
    function voucher_prefix()
    {
        $data= InvoicePrefix::where('_table_name','voucher_masters')->select('_prefix')->first();

        return $data->_prefix ?? '';
    }
}
if (! function_exists('resturant_prefix')) {
    function resturant_prefix()
    {
        $data= InvoicePrefix::where('_table_name','resturant_sales')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('service_prefix')) {
    function service_prefix()
    {
        $data= InvoicePrefix::where('_table_name','service_masters')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('production_prefix')) {
    function production_prefix()
    {
         $data= InvoicePrefix::where('_table_name','productions')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('warranty_prefix')) {
    function warranty_prefix()
    {
        $data= InvoicePrefix::where('_table_name','warranty_masters')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('_sales_pfix')) {
    function _sales_pfix()
    {
        $data= InvoicePrefix::where('_table_name','sales')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}


if (! function_exists('_replace_prefix')) {
    function _replace_prefix()
    {
         $data= InvoicePrefix::where('_table_name','replacement_masters')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}


if (! function_exists('_find_invoice_prefix')) {
    function _find_invoice_prefix($table_name)
    {
         $data= InvoicePrefix::where('_table_name',$table_name)->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}




if (! function_exists('ind_rep_prefix')) {
    function ind_rep_prefix()
    {
         $data= InvoicePrefix::where('_table_name','individual_replace_masters')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}



if (! function_exists('_transfer_prefix')) {
    function _transfer_prefix()
    {
        $data= InvoicePrefix::where('_table_name','transfer')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}

if (! function_exists('_sales_return_pfix')) {
    function _sales_return_pfix()
    {
        $data= InvoicePrefix::where('_table_name','sales_returns')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}


if (! function_exists('_purchase_pfix')) {
    function _purchase_pfix()
    {
        $data= InvoicePrefix::where('_table_name','purchases')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('damage_receive_pfix')) {
    function damage_receive_pfix()
    {
        $data= InvoicePrefix::where('_table_name','damage_receive_masters')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('damage_send_pfix')) {
    function damage_send_pfix()
    {
        $data= InvoicePrefix::where('_table_name','damage_send_masters')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}

if (! function_exists('_purchase_return_pfix')) {
    function _purchase_return_pfix()
    {
        $data= InvoicePrefix::where('_table_name','purchase_returns')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}
if (! function_exists('_damage_pfix')) {
    function _damage_pfix()
    {
       $data= InvoicePrefix::where('_table_name','damage_adjustments')->select('_prefix')->first();
        return $data->_prefix ?? '';
    }
}

if (! function_exists('report_date_formate')) {
    function report_date_formate()
    {
        return 'd-m-Y';
    }
}

if (! function_exists('_view_date_formate')) {
    function _view_date_formate($_date)
    {
        if($_date =='' || $_date =='0000-00-00' || $_date =='1970-01-01'){
            return "";
        } 
       return date('d-m-Y', strtotime($_date));
    }
}



if (! function_exists('voucher_code_to_name')) {
    function voucher_code_to_name($value)
    {
        $types = VoucherType::where('_code',$value)->select('_name')->first();
        return $types->_name ?? '';
    }
}


// if (! function_exists('type_wise_voucher_number')) {
//     function type_wise_voucher_number($type='JV',$_date='')
//     {
//         if($_date ==''){
//             $_date = date('Y-m-d');
//         }
//         $currnt_year=  date('Y', strtotime($_date));;
//         $year_2_digit =  date('y', strtotime($_date));;
//         $types = VoucherMaster::where('_voucher_type',$type)
//         ->whereYear('_date',$currnt_year)
//        // ->count();
//         ->orderBy('id','DESC')->first();

//          $string = $types->_code ?? ''; // Your mixed string
//             if($string ==''){
//                 $count =1;
//             }else{
//                 $string_to_array=explode('-',$string);
//                 // return $string_to_array;
//                 if(sizeof($string_to_array)==4){
//                     $integers = $string_to_array[3] ?? 0; 
//                 }elseif(sizeof($string_to_array)==3){
//                     $integers = $string_to_array[2] ?? 0; 
//                 }elseif(sizeof($string_to_array)==2){
//                     $integers = $string_to_array[1] ?? 0; 
//                 }else{
//                     $integers=0;
//                 }

//               return  $count = $year_2_digit."-".str_pad((intval( $integers)+1), 5, '0', STR_PAD_LEFT);
             
//             }
// return  $voucherNumber =   $year_2_digit."-" . str_pad($count, 5, '0', STR_PAD_LEFT);
        
        
//     }
// }

if (! function_exists('type_wise_voucher_number')) {
    function type_wise_voucher_number($type='JV')
    {
       

        $types = VoucherMaster::where('_voucher_type',$type)
                ->orderBy('id','DESC')->first();

            $string = $types->_code ?? ''; // Your mixed string
            if($string ==''){
                $count =1;
            }else{
                 preg_match_all('/\d+/', $string, $matches); // Match all integer numbers
                 $integers = $matches[0]; // Extracted integer numbers
              return  $count = (intval(implode("", $integers))+1);
            }
           
  return  $voucherNumber =    str_pad($count, 4, '0', STR_PAD_LEFT);
        
    }
}

if (! function_exists('prefix_taka')) {
    function prefix_taka($value="Tk")
    {
        
        return $value;
    }
}



function select_warranty_status($id){
    $val='';
    foreach(_warranty_status() as $key=>$val){
        if($id==$key){
            return $val;
        }
    }
    return $val;
}


//Database insert formate Date

if (! function_exists('change_date_format')) {
    function change_date_format($_date)
    {
      return   date('Y-m-d', strtotime($_date));
    }
}

if (! function_exists('input_date_formate')) {
    function input_date_formate($_date)
    {
      return   date('mm/dd/yy', strtotime($_date));
    }
}



if (! function_exists('_report_amount')) {
    function _report_amount($_amount)
    {
        $_amount = (float) $_amount;
        if($_amount =='0.0000'){
            return '0';
        }
     // $number=  number_format((float) $_amount ?? 0, default_des(), '.', ',');
        return number_format($_amount, (abs($_amount) < 1 ? 4 : 2));

    }
}


if (! function_exists('_qty_amount')) {
    function _qty_amount($_amount)
    {
        $_amount = (float) $_amount;
        if($_amount =='0.0000'){
            return '0';
        }
     // $number=  number_format((float) $_amount ?? 0, default_des(), '.', ',');
        return number_format($_amount, (abs($_amount) < 1 ? 4 : 0));

    }
}





if (! function_exists('default_des')) {
    function default_des()
    {
      return   4;
    }
}

function _time_formate($time){
    if($time ==''){
        return '';
    }
    return  date('h:i:s A', strtotime($time )); 
}

if (! function_exists('_date_diff')) {
    function _date_diff($date1,$date2)
    {
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        $diff1 = date_diff($date1,$date2);
        $daysdiff = $diff1->format("%R%a");
        return $daysdiff = abs($daysdiff);
    }
}

if (! function_exists('_date_time_diff')) {
    function _date_time_diff($date1,$date2)
    {
       
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);

    $interval = $datetime1->diff($datetime2);

    $days = $interval->d;
    $hours = $interval->h;
    $minutes = $interval->i;
    if($days > 0){
        return " $days days, $hours hours, $minutes minutes";
    }else{
        return "$hours hours, $minutes minutes";
    }


    }
}

function number_of_day_calculation($day_x,$day_y){
    $timestamp1 = strtotime($day_x);
    $timestamp2 = strtotime($day_y);

    // Calculate the difference in seconds and convert to days
    $diffInSeconds = abs($timestamp2 - $timestamp1);
   return $diffInDays = $diffInSeconds / (60 * 60 * 24);
}


if (! function_exists('ledger_to_group_type')) {
    function ledger_to_group_type($ledger)
    {
      return AccountLedger::where('id',$ledger)->select('_account_group_id','_account_head_id')->first();
    }
}
if (! function_exists('_find_employee_name')) {
    function _find_employee_name($_office_id)
    {
      $data = \DB::table("hrm_employees")->where("_code",$_office_id)->first();

      return $data->_name ?? '';
    }
}

if (! function_exists('_find_ledger')) {
    function _find_ledger($ledger)
    {
      $ledger_info =  AccountLedger::where('id',$ledger)->select('_name')->first();
      return $ledger_info->_name ?? '';
    }
}

if (! function_exists('_find_unit')) {
    function _find_unit($unit)
    {
      $unit_info =  Units::where('id',$unit)->select('_name')->first();
      return $unit_info->_name ?? '';
    }
}
if (! function_exists('_table_name')) {
    function _table_name($id)
    {
      $table =  \App\Models\TableInfo::where('id',$id)->select('_name')->first();
      return $table->_name ?? '';
    }
}


if (! function_exists('_last_balance')) {
    function _last_balance($ledger)
    {
      return \DB::select(' select SUM(_dr_amount-_cr_amount) as _balance from accounts where _account_ledger="'.$ledger.'" ');
    }
}


if (! function_exists('nv_number_to_text')) {
    function  nv_number_to_text($amount)
    {

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return prefix_taka().".  ".ucfirst($digit->format($amount ?? 0))." Only."; 
        
    }
}

if (! function_exists('_default_amount_dr_cr')) {
    function  _default_amount_dr_cr()
    {

        return 1; 
        
    }
}

if (! function_exists('_show_amount_dr_cr')) {
    function  _show_amount_dr_cr($amount)
    {
        $amount = (string) $amount;
        $first_amount = $amount[0] ?? 0;
        if($first_amount==='-'){
            if(_default_amount_dr_cr()==1){
                $amount = substr($amount, 1);
                return $amount." Cr";
            }elseif(_default_amount_dr_cr()==2){
                 $amount = substr($amount, 1);
                 return "(".$amount.")";
            }else{
                return $amount;
            }
        }else{
           if(_default_amount_dr_cr()==1){
                return $amount." Dr";
            }elseif(_default_amount_dr_cr()==2){
                 return $amount;
            }else{
                return $amount;
            } 
        }
        
        
    }
}

function _link_for_item_inventory($_transection_ref,$_transection){

    if($_transection=='Purchase'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','purchases') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('purchase/print',$_transection_ref)."'>".$_order_number."</a>";
    }

    if($_transection=='Purchase Return'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','purchase_returns') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('purchase-return/print',$_transection_ref)."'>".$_order_number."</a>";
    }

    if($_transection=='Sales'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','sales') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='Sales Return'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','sales_returns') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales-return/print',$_transection_ref)."'>".$_order_number."</a>";
    }

    if($_transection=='Restaurant Sales'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','resturant_sales') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('restaurant-sales/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='Kitchen'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','resturant_sales') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('restaurant-sales/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='Damage'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','damage_adjustments') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('damage/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='transfer'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','productions') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('transfer/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='transfer in'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','productions') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('transfer/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='production'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','productions') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('production/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='Replacement'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','individual_replace_masters') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('item-replace/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='Replacement In'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','individual_replace_masters') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('item-replace/print',$_transection_ref)."'>".$_order_number."</a>";
    }
    if($_transection=='damage_from_stocks'){
        $_order_number  = id_to_cloumn($_transection_ref,'_order_number','damage_from_stocks') ?? $_transection_ref;
        return " <a style='text-decoration: none;' target='__blank' href='".url('damage_from_stocks/print',$_transection_ref)."'>".$_order_number."</a>";
    }

}

function _make_link_for_account($table,$_transection_ref,$_voucher_code){

if($_voucher_code =='' ){
    if($table =='sales' || $table=='sales_accounts'){
        $_voucher_code =id_to_cloumn($_transection_ref,'_order_number','sales');
    }
    
}

    if($table=='voucher_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".route('voucher.show',$_transection_ref)."'>".$_voucher_code."</a>";
    }

    if($table=='supplier_payments'){
        return " <a style='text-decoration: none;' target='__blank' href='".route('supplier_payment.show',$_transection_ref)."'>".$_voucher_code."</a>";
    }

    
    if($table=='purchases'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('purchase/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='purchase_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('purchase/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='purchases_return' || $table=='purchase_returns'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('purchase-return/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='purchase_return_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('purchase-return/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='sales'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='sales_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='sales_returns' || $table=='sales_return' ){
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales-return/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='Sales Return WLM'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales_return_wlm/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='sales_return_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('sales-return/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='damage'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('damage/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='transfer'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('transfer-production',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='production'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('transfer-production',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='replacement_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('item-replace/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='replacement_item_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('item-replace/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='warranty_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('warranty-manage/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='resturant_sales_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('restaurant-sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='restaurant_sales_accounts'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('restaurant-sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='resturant_sales'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('restaurant-sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='sales_without_lots'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('direct-sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='sales_without_lots'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('direct-sales/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='service_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('third-party-service/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='individual_replace_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('individual-replacement-print/print',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='asset_import_costs'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('asset-management/asset_import_cost',$_transection_ref)."'>".$_voucher_code."</a>";
    }

    if($table=='receive_payments'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('customer_payment',$_transection_ref)."'>".$_voucher_code."</a>";
    }

    if($table=='supplier_payments'){
        return " <a style='text-decoration: none;' target='__blank' href='".url('supplier_payments',$_transection_ref)."'>".$_voucher_code."</a>";
    }

    if($table=='stm_bill_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".route('stm_bill_masters.show',$_transection_ref)."'>".$_voucher_code."</a>";
    }
    if($table=='stm_collection_masters'){
        return " <a style='text-decoration: none;' target='__blank' href='".route('stm_collection.show',$_transection_ref)."'>".$_voucher_code."</a>";
    }


    if($table=='bill_send_masters'){
        return $_voucher_code;
    }
    if($table=='bill_receives'){
        return $_voucher_code;
    }

                  
    
}


if (!function_exists('formInputField')) {
    function formInputField($field, $label = null, $type = 'number', $data = null)
    {
        $labelText = $label ?? ucfirst(str_replace('_', ' ', $field));
        $value = old($field, $data->$field ?? '');

        return <<<HTML
<div class="col-lg-3 col-md-6 col-sm-12">
    <label for="{$field}">{$labelText}</label>
    <input type="{$type}" name="{$field}" id="{$field}" value="{$value}" class="form-control">
</div>
HTML;
    }
}


if (!function_exists('database_backup_info')) {
    function database_backup_info()
    {
        $DbName = env('DB_DATABASE');
        $connect = DB::connection()->getPdo();

        // Get all table names
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        $prep = "Tables_in_$DbName";
        $tables = [];
        foreach ($result as $res) {
            $tables[] = $res[$prep];
        }

        // Priority tables to handle foreign key dependencies
        $priorityTables = ['roles', 'permissions', 'role_has_permissions', 'users', 'model_has_roles', 'model_has_permissions'];
        $otherTables = array_diff($tables, $priorityTables);
        $orderedTables = array_merge($priorityTables, $otherTables);

        $output = "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($orderedTables as $table) {
            // Table structure
            $show_table_query = "SHOW CREATE TABLE `$table`";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetch();

            $output .= "\n\n" . $show_table_result["Create Table"] . ";\n\n";

            // Table data
            $select_query = "SELECT * FROM `$table`";
            $statement = $connect->prepare($select_query);
            $statement->execute();

            while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $columns = array_map(fn($col) => "`$col`", array_keys($row));
                $escaped_values = array_map(fn($val) => $connect->quote($val), array_values($row));

                $output .= "INSERT INTO `$table` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $escaped_values) . ");\n";
            }
        }

        $output .= "\n\nSET FOREIGN_KEY_CHECKS=1;\n";

        // Save and Download the file
        $file_name = 'database_backup_on_' . date('y-m-d_H-i-s') . '.sql';
        $file_path = storage_path($file_name);

        file_put_contents($file_path, $output);

        // Force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);
        unlink($file_path); // Delete after download
        exit;
    }
}









