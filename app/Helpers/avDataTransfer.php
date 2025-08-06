<?php

use App\Models\VoucherMaster;
use App\Models\VoucherMasterDetail;
use App\Models\Accounts;
   

if (! function_exists('old_db')) {
    function old_db()
    {
       // $servername = "103.54.36.11";
        $servername = "127.0.0.1";
        $username = "root";
        $password = '';
        $dbname = "avansisbd_website";
        $old_db = new mysqli($servername, $username, $password, $dbname);
        if ($old_db->connect_error) {
          die("Connection failed: " . $old_db->connect_error);
        }else{
            return $old_db;
        }
    }
}


function insert_unit(){
	$conn = old_db();
	$sql = "SELECT DISTINCT type FROM product";

	$result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access columns by their names
        $type = $row["type"];
        
        \DB::table('units')->insert(['_name'=>$type,'_code'=>$type,'_status'=>1]);

    }
    return "Unit Insert done";
}

function insert_pack_size(){
	$conn = old_db();
	$sql = "SELECT DISTINCT unit FROM `product`";

	$result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $_name = $row["unit"];
        \DB::table('item_pack_sizes')->insert(['_name'=>$_name,'_code'=>$_name,'_status'=>1]);

    }
    return "item_pack_sizes Insert done";
}

function insert_item(){
	$conn = old_db();
	$sql = "SELECT `id`, `name`, `unit`, `origin`, `type`, `tp` FROM `product` where name !='' ";

	$pack_sizes = \DB::table('item_pack_sizes')->get();
	$parck_size_key_val=[];
	foreach($pack_sizes as $val){
		$parck_size_key_val[$val->_name]=$val->id;
	}
	$units = \DB::table('units')->get();
	$units_key_val=[];
	foreach($units as $val){
		$units_key_val[$val->_name]=$val->id;
	}

	$result = $conn->query($sql);
    // Output data of each row
    $id=0;
    while($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $_name = $row["name"];
        $pack_size = $row["unit"];
        $unit = $row["type"];
        $origin = $row["origin"];
        $tp = $row["tp"];

        $code =1000+$id;
        $_unit_id = $units_key_val[$unit];
        $_pack_size_id = $parck_size_key_val[$pack_size];


$data=[
	'id'=>$row_id,
    '_item'=>$_name,
	'_code'=>$code,
	'_oringin'=>$origin,
	'_item_category'=>1,
	'_barcode'=>$code, 
	'_category_id'=>1,
	'_unit_id'=>$_unit_id,
	'_pack_size_id'=>$_pack_size_id,
	'_brand_id'=>1, 
	'_sale_rate'=>$tp,
	'_trade_price'=>$tp, 
	'_mrp_price'=>$tp,
	'_status'=>1,
	'_item_type'=>1,
	'_is_used'=>1

];

      $_item_id=  \DB::table('inventories')->insertGetId($data);
     


        \DB::table('unit_conversions')->insert([
        	'_item_id'=>$_item_id,
        	'_base_unit_id'=>$_unit_id,
        	'_conversion_unit'=>$_unit_id,
        	'_conversion_qty'=>1,
        	'_conversion_unit_name'=>$unit,
        	'_status'=>1,
        ]);
$id++;
    }
    return "inventories Insert done";
}


function unit_conversion(){
    $items=  \DB::select(" SELECT t1.id as _item_id,t1._unit_id,t1._pack_size_id,t2._name as _unit_name FROM `inventories` AS t1 INNER JOIN units as t2 ON t1._unit_id=t2.id ");

    foreach($items as $item){
        $_item_id = $item->_item_id;
        $_base_unit_id = $item->_unit_id;
        $_unit_id = $item->_unit_id;
        $unit = $item->_unit_name;
         \DB::table('unit_conversions')->insert([
            '_item_id'=>$_item_id,
            '_base_unit_id'=>$_unit_id,
            '_conversion_unit'=>$_unit_id,
            '_conversion_qty'=>1,
            '_conversion_unit_name'=>$unit,
            '_status'=>1,
        ]);
    }

}



function insert_branch(){
	$conn = old_db();
	$sql = "SELECT `id`, `name` FROM `territory`";

	$result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access columns by their names
        $_name = $row["name"];
        $id = $row["id"];
        $_code = substr($_name, 0, 2);;
        
        
        \DB::table('branches')->insert(['id'=>$id,'_name'=>$_name,'_code'=>$_code,'_status'=>1]);

    }
    return "branches Insert done";
}



function insert_party_info(){
	$conn = old_db();
	$sql = " SELECT `id`, `territory_id`, `name`, `propaitor`, `cellno`, `address`, `Climt` FROM `party_info`";

	$result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access columns by their names
        $_code = $row["id"];
        $_branch_id = $row["territory_id"];
        $_name = $row["name"];
        $_alious = $row["propaitor"];
        $_phone = $row["cellno"];
        $_address = $row["address"];
        $_credit_limit = $row["Climt"];
        $_main_account_id =1;
        $_acc_head_pl3_id =1;
        $_acc_head_pl2_id =13;
        $_account_head_id =13;
        $_account_group_id =9;

$data=[
'_main_account_id'=>$_main_account_id,
'_acc_head_pl3_id'=>$_acc_head_pl3_id,
'_acc_head_pl2_id'=>$_acc_head_pl2_id,
'_account_group_id'=>$_account_group_id,
'_account_head_id'=>$_account_head_id,
'_name'=>$_name,
'_alious'=>$_alious,
'_code'=>$_code,
'_nid'=>$_code,
'_credit_limit'=>$_credit_limit,
'organization_id'=>1,
'_branch_id'=>$_branch_id,
'_address'=>$_address,
'_phone'=>$_phone,
'_status'=>1,
'_is_sales_form'=>1,
'_show'=>1,
'_user_id'=>46,

];
        
        
        \DB::table('account_ledgers')->insert($data);

    }
    return "party_info Insert done";
}


function insert_supplier_info(){
    $conn = old_db();
    $sql = " SELECT `id`, `name`, `propitor`, `address`, `mobaile` FROM `supplier` ";

    $result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access columns by their names
        $_code = $row["id"];
        $_branch_id = 1;
        $_name = $row["name"];
        $_alious = $row["propitor"];
        $_phone = $row["mobaile"];
        $_address = $row["address"];
        $_credit_limit = 0;
        $_main_account_id =3;
        $_acc_head_pl3_id =17;
        $_acc_head_pl2_id =17;
        $_account_head_id =17;
        $_account_group_id =29;

$data=[
'_main_account_id'=>$_main_account_id,
'_acc_head_pl3_id'=>$_acc_head_pl3_id,
'_acc_head_pl2_id'=>$_acc_head_pl2_id,
'_account_group_id'=>$_account_group_id,
'_account_head_id'=>$_account_head_id,
'_name'=>$_name,
'_alious'=>$_alious,
'_code'=>'S'.$_code,
'_nid'=>$_code,
'_credit_limit'=>$_credit_limit,
'organization_id'=>1,
'_branch_id'=>$_branch_id,
'_address'=>$_address,
'_phone'=>$_phone,
'_status'=>1,
'_is_sales_form'=>1,
'_show'=>1,
'_user_id'=>46,

];
        
        
        \DB::table('account_ledgers')->insert($data);

    }
    return "supplier Insert done";
}

function insert_doctor_info(){
    $conn = old_db();
    $sql = " SELECT `id`, `dr_name`, `specialty`, `phone`, `dr_address`, `reg_date`, `territory_id` FROM `doctors` ";

    $result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access columns by their names
        $_code = $row["id"];
        $_branch_id = $row['territory_id'];
        $_name = $row["dr_name"];
        $_note = $row["specialty"];
        $_phone = $row["phone"];
        $_address = $row["dr_address"];
        $reg_date = change_date_format($row["reg_date"]);
        $_credit_limit = 0;
        $_main_account_id =4;
        $_acc_head_pl3_id =19;
        $_acc_head_pl2_id =19;
        $_account_head_id =20;
        $_account_group_id =51;

$data=[
'_main_account_id'=>$_main_account_id,
'_acc_head_pl3_id'=>$_acc_head_pl3_id,
'_acc_head_pl2_id'=>$_acc_head_pl2_id,
'_account_group_id'=>$_account_group_id,
'_account_head_id'=>$_account_head_id,
'_name'=>$_name,
'_note'=>$_note,
'_code'=>'D'.$_code,
'_nid'=>$_code,
'_credit_limit'=>$_credit_limit,
'organization_id'=>1,
'_branch_id'=>$_branch_id,
'_address'=>$_address,
'_phone'=>$_phone,
'_status'=>1,
'_is_sales_form'=>1,
'_show'=>1,
'_user_id'=>46,
'created_at'=>$reg_date,

];
        
        
        \DB::table('account_ledgers')->insert($data);

    }
    return "doctors Insert done";
}


function insert_employee_info(){
    $conn = old_db();
    $sql = " SELECT `id`, `name`, `designation`, `workplace`, `areaid` FROM `employee`";

    $result = $conn->query($sql);
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access columns by their names
        $_code = $row["id"];
        $_branch_id = $row['areaid'];
        $_name = $row["name"];
        $_note = $row["designation"];
        $_phone = $row["phone"] ?? '';
        $_address = $row["dr_address"] ?? '';
        $_credit_limit = 0;
        $_main_account_id =2;
        $_acc_head_pl3_id =4;
        $_acc_head_pl2_id =4;
        $_account_head_id =4;
        $_account_group_id =50;

$data=[
'_main_account_id'=>$_main_account_id,
'_acc_head_pl3_id'=>$_acc_head_pl3_id,
'_acc_head_pl2_id'=>$_acc_head_pl2_id,
'_account_group_id'=>$_account_group_id,
'_account_head_id'=>$_account_head_id,
'_name'=>$_name,
'_note'=>$_note,
'_code'=>'E'.$_code,
'_nid'=>$_code,
'_credit_limit'=>$_credit_limit,
'organization_id'=>1,
'_branch_id'=>$_branch_id,
'_address'=>$_address,
'_phone'=>$_phone,
'_status'=>1,
'_is_sales_form'=>1,
'_show'=>1,
'_user_id'=>46,

];
        
        
        \DB::table('account_ledgers')->insert($data);

    }
    return "doctors Insert done";
}

$incentives = ['Incentive','Incentive-2021','Incentive-21','Incentive-22','Incentive-2022','Inentive-2022','Incentive-2023','Incentive-23'];
$collections = ['Collection','Collection-21','Collectio'];


function incentive_insert(){
      $conn = old_db();
    $sql = " SELECT s1.date,s1.REF as _transection_ref,s1.emp_id, s1.party_id,p.name,p.territory_id, s1.total_amount as sales_amount,s1.return_amount as return_amount,s1.colection_amount as colection_amount FROM ( 
    
   
    SELECT   t2.date,t2.REF,t2.sales_byid as emp_id, t2.party_id,0 as total_amount,0 as return_amoun,t2.total_amount as colection_amount 
    FROM collecton as t2 where t2.date < '2024-07-01' AND t2.remurck IN  ) as s1 
    INNER JOIN party_info as p ON p.id=s1.party_id ORDER BY s1.date ASC";

    $result = $conn->query($sql);
}




function insert_sales_retun_collection(){
    $conn = old_db();
    $sql = " SELECT 1 as _type, s1.date,s1.REF as _transection_ref,s1.emp_id, s1.party_id,p.name,p.territory_id, s1.total_amount as sales_amount,s1.return_amount as return_amount,s1.colection_amount as colection_amount,s1.incentive_amount FROM ( 
    
    SELECT 2 as _type, t1.date,t1.REF, t1.sales_by as emp_id, t1.party_id,t1.total_amount,0 as return_amount,0 as colection_amount,0 as incentive_amount FROM invoice AS t1 where t1.date < '2024-07-01' 
    UNION ALL 
    SELECT 3 as _type, sr.date,sr.REF,0 as emp_id, sr.cid as party_id,0 as total_amount,sr.amount as return_amount, 0 AS colection_amount  ,0 as incentive_amount 
    FROM sales_return as sr where sr.date < '2024-07-01' 
    UNION ALL 
    SELECT 4  as _type,  t2.date,t2.REF,t2.sales_byid as emp_id, t2.party_id,0 as total_amount,0 as return_amoun,t2.total_amount as colection_amount ,0 as incentive_amount
    FROM collecton as t2 where t2.date < '2024-07-01' AND t2.remurck IN('Collection','Collection-21','Collectio') 
    UNION ALL 
    SELECT 5 as _type,  t2.date,t2.REF,t2.sales_byid as emp_id, t2.party_id,0 as total_amount,0 as return_amoun,0 as colection_amount, t2.total_amount as incentive_amount
    FROM collecton as t2 where t2.date < '2024-07-01' AND t2.remurck IN('Incentive','Incentive-2021','Incentive-21','Incentive-22','Incentive-2022','Inentive-2022','Incentive-2023','Incentive-23')


    ) as s1 
    INNER JOIN party_info as p ON p.id=s1.party_id ORDER BY s1.date ASC";

    $result = $conn->query($sql);
    

   

    $customer_gorup_id = 9;
    $customer_head_id = 13;
   

    $cash_ledger = 1;
    $cash_gorup_id = 3;
    $cash_head_id = 8;
    // Output data of each row
    while($row = $result->fetch_assoc()) {
       // return $row;
        $date = $row["date"];
        $_branch_id = $row['territory_id'];
        $party_id = $row["party_id"];
        $territory_id = $row["territory_id"];
        $sales_amount = $row["sales_amount"] ?? 0;
        $return_amount = $row["return_amount"] ?? 0;
        $colection_amount = $row["colection_amount"] ?? 0;
        $incentive_amount = $row["incentive_amount"] ?? 0;
        $emp_id = $row["emp_id"] ?? 0;
        $_transection_ref = $row["_transection_ref"] ?? '';

        $type_wise_number = type_wise_voucher_number('JV');
        $_voucher_code = voucher_prefix().'JV'."-".$type_wise_number;
        $amount = 0;

        $code='p'.$party_id;
        $ledger_info=\DB::table('account_ledgers')->where('_code',$code)->first();
        $party_ledger_id = $ledger_info->id ?? 13;
        $party_account_type_id = $ledger_info->_account_head_id ?? 0;
        $party_account_group_id = $ledger_info->_account_group_id ?? 0;
        if( $party_ledger_id ==0 || $party_ledger_id ==''){
             $party_ledger_id =13;
             $party_account_type_id =2;
             $party_account_group_id =6;
        }  

        if( $territory_id ==0 || $territory_id ==''){
             $territory_id =1;
        }

        //Sales Data Insert into Voucher from old software to new software
        if($sales_amount > 0){
            $amount = $sales_amount;
            $ledger_id=4;
            $_account_group_id = 38;
            $_account_type_id = 6;





        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_code'=>$_voucher_code,
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_branch_id'=>$territory_id,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Old Sales',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   //Customer Account DR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id;
    $VoucherMasterDetail->_account_group_id = $party_account_group_id;
    $VoucherMasterDetail->_ledger_id = $party_ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = $amount ?? 0;
    $VoucherMasterDetail->_cr_amount =  0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
   //For Customer
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Old Sales';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id;
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount = 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();


   //Sales Account Cr
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id = $ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //For Sales Account
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Old Sales';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $_account_type_id;
    $Accounts->_account_group = $_account_group_id;
    $Accounts->_account_ledger = $ledger_id;
    $Accounts->_dr_amount =  0;
    $Accounts->_cr_amount = $amount ?? 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id?? 0;
    $Accounts->_cost_center =1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

ledger_balance_update($party_ledger_id);
ledger_balance_update($ledger_id);


        } /*End of Sales Entry*/

        if($return_amount > 0){
            $amount = $return_amount;
             $ledger_id=5;
             $_account_group_id = 38;
             $_account_type_id = 6;




        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_branch_id'=>$territory_id,
            '_code'=>$_voucher_code,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Sales Return',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   //Sales Return  DR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id = $ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  $amount ?? 0;
    $VoucherMasterDetail->_cr_amount = 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Sales Return DR
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Sales Return';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $_account_type_id;
    $Accounts->_account_group = $_account_group_id;
    $Accounts->_account_ledger = $ledger_id;
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount = 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();


   //Sales Return Customer Account Cr
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id;
    $VoucherMasterDetail->_account_group_id = $party_account_group_id;
    $VoucherMasterDetail->_ledger_id = $party_ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //For Sales Return Account
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Sales Return';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id;
    $Accounts->_dr_amount = 0;
    $Accounts->_cr_amount = $amount ??  0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();


        }

        if($colection_amount > 0){
            $amount = $colection_amount;
            $ledger_id=1;
            $_account_group_id = 3;
            $_account_type_id = 8;

        


        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_code'=>$_voucher_code,
            '_branch_id'=>$territory_id,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Collection Data',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   //cash Account DR
   // Customer Account CR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id = $ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = $amount ?? 0;
    $VoucherMasterDetail->_cr_amount =  0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
   //For Cash Collection DR
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Collection Data';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $_account_type_id;
    $Accounts->_account_group = $_account_group_id;
    $Accounts->_account_ledger = $ledger_id;
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount =  0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

   


   //Customer CR for 
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id;
    $VoucherMasterDetail->_account_group_id = $party_account_group_id;
    $VoucherMasterDetail->_ledger_id = $party_ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //For Sales Return Account
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Collection Data';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id;
    $Accounts->_dr_amount =  0;
    $Accounts->_cr_amount = $amount ?? 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

        }

        //Insentive Data insert
        //Incentive Expenses DR
        // Customer Ledger Acc: Cr
        if($incentive_amount > 0){
            $amount = $incentive_amount;
            $ledger_id=591;
            $_account_group_id = 40;
            $_account_type_id = 18;

        


        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_code'=>$_voucher_code,
            '_branch_id'=>$territory_id,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Incentive Paid',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

    //Incentive Expenses DR
        // Customer Ledger Acc: Cr

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id = $ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = $amount ?? 0;
    $VoucherMasterDetail->_cr_amount =  0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
   //For Incentive
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Incentive Paid';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $_account_type_id;
    $Accounts->_account_group = $_account_group_id;
    $Accounts->_account_ledger = $ledger_id;
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount =  0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

   


   //Customer CR for 
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id;
    $VoucherMasterDetail->_account_group_id = $party_account_group_id;
    $VoucherMasterDetail->_ledger_id = $party_ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Customer CR for
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Incentive Paid';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id;
    $Accounts->_dr_amount =  0;
    $Accounts->_cr_amount = $amount ?? 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

}  //ENd of Incentive data Insert




        


        

    }
    return "voucher_masters Insert done";
}



/*Previous Software data fetch and inssert to new Software using Voucher*/


function actural_sales_collection_sales_return_and_incentive(){

    $conn = old_db();
    $sql = " SELECT a.emp_id,a.territory as territory_id,DATE(a.date) as date,a.REF as _transection_ref, a.name,a.pid as party_id, sum(a.salesamount) as sales_amount,SUM(a.collectionamoun) as colection_amount,SUM(a.return_amount) as return_amount,(SUM(a.salesamount)-(SUM(a.collectionamoun)+SUM(a.return_amount))) as balance
FROM (
    SELECT invoice.sales_by as  emp_id, party_info.name as name, invoice.date,invoice.REF,invoice.party_id as pid,invoice.territory_id as territory, invoice.total_amount as salesamount, 0 as collectionamoun, null as remurck,0 as return_amount 
               FROM `invoice` 
               INNER JOIN party_info ON party_info.id=invoice.party_id 
    
               UNION ALL
    SELECT collecton.sales_byid as emp_id, party_info.name, collecton.date,collecton.reF,collecton.party_id,collecton.territory_id as territory, 0 as salesamount,collecton.total_amount,collecton.remurck ,0 as return_amount 
               FROM `collecton` 
               INNER JOIN party_info ON party_info.id=collecton.party_id  where  collecton.remurck NOT  LIKE '%Incentive%'
    UNION ALL
    SELECT 0 as emp_id, party_info.name,sales_return.date,sales_return.REF,party_info.id as pid,party_info.territory_id as territory,0 as salesamount, 0 as collectionamoun, null as remurck,  sales_return.amount as return_amount 
    FROM party_info 
    INNER JOIN sales_return on party_info.id=sales_return.cid 
    
) a WHERE  a.date>='2011-01-01' and a.date <='2024-06-30 23:59:59' 
GROUP by a.pid,a.REF,a.date
ORDER by a.date";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
       // return $row;
        $date = $row["date"];
        $_branch_id = $row['territory_id'];
        $party_id = $row["party_id"];
        $territory_id = $row["territory_id"];
        $sales_amount = $row["sales_amount"] ?? 0;
        $return_amount = $row["return_amount"] ?? 0;
        $colection_amount = $row["colection_amount"] ?? 0;
        $incentive_amount = $row["incentive_amount"] ?? 0;
        $emp_id = $row["emp_id"] ?? 0;
        $_transection_ref = $row["_transection_ref"] ?? '';

        $type_wise_number = type_wise_voucher_number('JV');
        $_voucher_code = voucher_prefix().'JV'."-".$type_wise_number;
        $amount = 0;
        $party_account_type_id =13;
        $party_account_group_id =9;

        $code='p'.$party_id;
        $ledger_info=\DB::table('account_ledgers')->where('_code',$code)->first();
        $party_ledger_id = $ledger_info->id ?? 15; //Defalut cash customer
        $party_account_type_id = 13; //Customer Group
        $party_account_group_id = 9;
        if( $party_ledger_id ==0 || $party_ledger_id ==''){
             $party_ledger_id =15;
             $party_account_type_id =13;
             $party_account_group_id =9;
        }  

        if( $territory_id ==0 || $territory_id ==''){
             $territory_id =1;
        }

        //Sales Data Insert into Voucher from old software to new software

        // Customer Ac ------dr
        //Sales Account -----CR
        if($sales_amount > 0){
            $amount = $sales_amount;
        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_code'=>$_voucher_code,
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_branch_id'=>$territory_id,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Old Sales',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   //Customer Account DR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id; //Customer Type
    $VoucherMasterDetail->_account_group_id = $party_account_group_id; //Customer Group
    $VoucherMasterDetail->_ledger_id = $party_ledger_id; //Customer Account
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = $amount ?? 0;
    $VoucherMasterDetail->_cr_amount =  0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
   //For Customer
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Old Sales';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id; //Customer ID
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount = 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

    ledger_balance_update($party_ledger_id);

    //Sales Account CR
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = 6; //Revenu/Income ID
    $VoucherMasterDetail->_account_group_id = 38; //Operating Income
    $VoucherMasterDetail->_ledger_id = 4; //Sales Account ID
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Collection Data';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head =6;
    $Accounts->_account_group = 38;
    $Accounts->_account_ledger = 4;
    $Accounts->_dr_amount =  0;
    $Accounts->_cr_amount = $amount ?? 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

} //End of Sales Voucher

ledger_balance_update(4); // for Sales Account 


//Start of Collection 
if($colection_amount > 0){
            $amount = $colection_amount;
            $cash_leder_id=1;
            $cash_leder_account_group_id = 3;
            $cash_leder_account_type_id = 8;

        


        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_code'=>$_voucher_code,
            '_branch_id'=>$territory_id,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Collection Data',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   //cash Account DR
   // Customer Account CR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $cash_leder_account_type_id;
    $VoucherMasterDetail->_account_group_id = $cash_leder_account_group_id;
    $VoucherMasterDetail->_ledger_id = $cash_leder_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = $amount ?? 0;
    $VoucherMasterDetail->_cr_amount =  0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
   //For Cash Collection DR
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Collection Data';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $cash_leder_account_type_id;
    $Accounts->_account_group = $cash_leder_account_group_id;
    $Accounts->_account_ledger = $cash_leder_id;
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount =  0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

   


   //Customer CR for 
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id; //Customer Type
    $VoucherMasterDetail->_account_group_id = $party_account_group_id; //Customer Group
    $VoucherMasterDetail->_ledger_id = $party_ledger_id; //Customer Account
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Collection Data';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id;
    $Accounts->_dr_amount =  0;
    $Accounts->_cr_amount = $amount ?? 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

     ledger_balance_update($party_ledger_id);
     ledger_balance_update($cash_leder_id);

} //End of Collection


//Sales Return 

if($return_amount > 0){
            $amount = $return_amount;
             $sales_return_id=5;
             $sales_retun_group_id = 38;
             $sales_return_type_id = 6;




        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_branch_id'=>$territory_id,
            '_code'=>$_voucher_code,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>'Sales Return',
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   //Sales Return  DR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $sales_return_type_id;
    $VoucherMasterDetail->_account_group_id = $sales_retun_group_id;
    $VoucherMasterDetail->_ledger_id = $sales_return_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  $amount ?? 0;
    $VoucherMasterDetail->_cr_amount = 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Sales Return DR
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Sales Return';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $sales_return_type_id;
    $Accounts->_account_group = $sales_retun_group_id;
    $Accounts->_account_ledger = $sales_return_id;

    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount = 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();


   //Sales Return Customer Account Cr
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id;
    $VoucherMasterDetail->_account_group_id = $party_account_group_id;
    $VoucherMasterDetail->_ledger_id = $party_ledger_id;
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount =  0;
    $VoucherMasterDetail->_cr_amount = $amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //For Sales Return Account
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = 'Sales Return';
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id;
    $Accounts->_dr_amount = 0;
    $Accounts->_cr_amount = $amount ??  0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();
 ledger_balance_update($party_ledger_id);
     ledger_balance_update($sales_return_id);

} //End of Sales Return







}

return "insert Data sales";
    
}

function insenctive_expense_insert(){
      $conn = old_db();
    $sql = " SELECT party_info.name, collecton.date,collecton.sales_byid as emp_id ,collecton.reF,collecton.party_id,collecton.territory_id, null,SUM(collecton.total_amount)  as incentive_amount ,collecton.remurck 
               FROM `collecton` 
               INNER JOIN party_info ON party_info.id=collecton.party_id
                WHERE  collecton.date>='2010-01-01' and collecton.date<='2024-06-30 23:59:59' 
                AND collecton.remurck  LIKE '%Incentive%'
                GROUP BY collecton.reF,collecton.party_id
                ORDER by collecton.date ";

 $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
       // return $row;
        $date = $row["date"];
        $_branch_id = $row['territory_id'];
        $party_id = $row["party_id"];
        $territory_id = $row["territory_id"];
        $incentive_amount = $row["incentive_amount"] ?? 0;
        $emp_id = $row["emp_id"] ?? 0;
        $_transection_ref = $row["_transection_ref"] ?? '';
        $remurck = $row["remurck"] ?? '';

        $type_wise_number = type_wise_voucher_number('JV');
        $_voucher_code = voucher_prefix().'JV'."-".$type_wise_number;
        $amount = 0;

        $party_account_type_id =13;
        $party_account_group_id =9;
        $code='p'.$party_id;
        $ledger_info=\DB::table('account_ledgers')->where('_code',$code)->first();
        $party_ledger_id = $ledger_info->id ?? 15; //Defalut cash customer
        $party_account_type_id = 13; //Customer Group
        $party_account_group_id = 9;
        if( $party_ledger_id ==0 || $party_ledger_id ==''){
             $party_ledger_id =15;
             $party_account_type_id =13;
             $party_account_group_id =9;
        }  

        if( $territory_id ==0 || $territory_id ==''){
             $territory_id =1;
        }

        //Sales Data Insert into Voucher from old software to new software

        // Customer Ac ------dr
        //Sales Account -----CR
        if($incentive_amount > 0){
            $amount = $incentive_amount;
        $voucher_data =[
            '_date'=>change_date_format($date),
            '_time'=>date('H:i:s'),
            '_code'=>$_voucher_code,
            '_voucher_type'=>'JV',
            'organization_id'=>1,
            '_branch_id'=>$territory_id,
            '_budget_id'=>0,
            '_sales_man_id'=>$emp_id,
            '_transection_ref'=>$_transection_ref,
            '_amount'=>$amount,
            '_note'=>$remurck,
            '_form_name'=>'voucher_masters',
            '_lock'=>0,
            '_cost_center_id'=>1,
            '_status'=>1,
            '_user_id'=>46,
            '_user_name'=>'admin',
        ];
   $master_id=  \DB::table('voucher_masters')->insertGetId($voucher_data);

   

    //Incentive Expense DR
    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = 18; //Revenu/Income ID
    $VoucherMasterDetail->_account_group_id = 40; //Operating Income
    $VoucherMasterDetail->_ledger_id = 592; //Incentive Expenses
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = $amount ?? 0;
    $VoucherMasterDetail->_cr_amount =  0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
 
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = $remurck;
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = 18;
    $Accounts->_account_group = 40;
    $Accounts->_account_ledger = 592;
    $Accounts->_dr_amount = $amount ?? 0;
    $Accounts->_cr_amount =  0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id ?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

    //Customer Account CR

   $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $party_account_type_id; //Customer Type
    $VoucherMasterDetail->_account_group_id = $party_account_group_id; //Customer Group
    $VoucherMasterDetail->_ledger_id = $party_ledger_id; //Customer Account
    $VoucherMasterDetail->organization_id = 1;
    $VoucherMasterDetail->_branch_id =$territory_id;
    $VoucherMasterDetail->_cost_center = 1;
    $VoucherMasterDetail->_budget_id = 0;
    $VoucherMasterDetail->_short_narr = 'N/A';
    $VoucherMasterDetail->_dr_amount = 0;
    $VoucherMasterDetail->_cr_amount =$amount ?? 0;
    $VoucherMasterDetail->_status = 1;
    $VoucherMasterDetail->_created_by =46;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
   //For Customer
    $Accounts = new Accounts();
    $Accounts->_ref_master_id = $master_id;
    $Accounts->_ref_detail_id = $master_detail_id;
    $Accounts->_voucher_code = $_voucher_code;
    $Accounts->_short_narration = 'N/A';
    $Accounts->_narration = $remurck;
    $Accounts->_reference = $_transection_ref ?? '';
    $Accounts->_voucher_type ='JV';
    $Accounts->_transaction = 'Account';
    $Accounts->_date = change_date_format($date);
    $Accounts->_table_name = 'voucher_masters';
    $Accounts->_account_head = $party_account_type_id;
    $Accounts->_account_group = $party_account_group_id;
    $Accounts->_account_ledger = $party_ledger_id; //Customer ID
    $Accounts->_dr_amount =  0;
    $Accounts->_cr_amount =$amount ?? 0;
    $Accounts->organization_id = 1;
    $Accounts->_branch_id = $territory_id?? 0;
    $Accounts->_cost_center = 1;
    $Accounts->_budget_id =  0;
    $Accounts->_name ='admin';
    $Accounts->_sales_man_id = $emp_id ?? 0;
    $Accounts->save();

    ledger_balance_update($party_ledger_id);
    ledger_balance_update(592); // for Sales Account 

    } //End of Sales Voucher
    }
return "insert Data Incentive";
}


