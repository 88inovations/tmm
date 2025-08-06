<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountGroup;
use App\Models\Accounts;
use App\Models\AccountLedger;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Models\Sales;
use App\Models\SalesAccount;
use App\Models\SalesDetail;
use App\Models\VoucherMaster;
use App\Models\AccountHead;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\StoreHouse;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Units;

class DMReportController extends Controller
{
    //

     function __construct()
    {
        
         $this->middleware('permission:damage_report', ['only' => ['damage_report']]);
         $this->middleware('permission:dm_send_to_supplier', ['only' => ['dm_send_to_supplier']]);
         $this->middleware('permission:dm_receive_from_stock', ['only' => ['dm_receive_from_stock']]);
         $this->middleware('permission:dm_receive_from_customer', ['only' => ['dm_receive_from_customer']]);
         $this->middleware('permission:dm_item_stock_value', ['only' => ['dm_item_stock_value']]);
         $this->middleware('permission:dm_item_stock_possition', ['only' => ['dm_item_stock_possition']]);
         $this->middleware('permission:dm_item_ledger', ['only' => ['dm_item_ledger']]);
    }


    public function damage_report(){
        $page_name ="Damage Management Report";
        return view('backend.dm_report.index',compact('page_name'));
    }




   public function  dm_send_to_supplier(Request $request){

        $page_name =__('label.dm_send_to_supplier');
          $previous_filter= $request->all();
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $item_categories = DB::select(" SELECT id,_name FROM `item_categories` WHERE id IN( SELECT DISTINCT _category_id FROM damage_item_histories ) ");
$item_categories_key_value=[];
  foreach ($item_categories as $category_key => $category_value) {
         $item_categories_key_value[$category_value->id]=$category_value->_name ?? ''; 
      }


      $customer_ledgers = DB::select(" SELECT t1.id,t1._name,t1._phone,t1._address,t1._balance,t1._branch_id,t1.organization_id
FROM account_ledgers as t1 WHERE id IN(SELECT DISTINCT _ledger_id FROM damage_send_masters) ");


      $item_pack_sizes = DB::table("item_pack_sizes")->get();
      $item_pack_key_value=[];
      foreach ($item_pack_sizes as $key => $value) {
         $item_pack_key_value[$value->id]=$value->_name ?? ''; 
      }
      $units = DB::table("units")->get();
      $unit_key_value=[];
      foreach ($units as $unit_key => $unit_value) {
         $unit_key_value[$unit_value->id]=$unit_value->_name ?? ''; 
      }

       
       $items = DB::select( " SELECT t1.id as _item_id,CONCAT(t1._item, ' ', t2._name) AS  _item_name FROM inventories AS t1
INNER JOIN item_pack_sizes as t2 ON t1._pack_size_id=t2.id " );

       $group_array_values = [];
         $_datex =  change_date_format($request->_datex);
              $_datey=  change_date_format($request->_datey);

              
             // Start of Organization ,Branch,Cost Center IDS


            if($request->organization_id=='all'){
                $request_organizations = explode(',',$users->organization_ids);
            }else{
                $request_organizations = explode(',',$request->organization_id);
            }

            if($request->_branch_id=='all'){
                 $_branch_ids = explode(',',$users->branch_ids);
            }else{
                $_branch_ids = explode(',',$request->_branch_id);
            }

           

            if($request->_cost_center=='all'){
                $_cost_center_ids = explode(',',$users->cost_center_ids);
            }else{
                $_cost_center_ids = explode(',',$request->_cost_center);
            }

            $_organization_id_rows = implode(',', $request_organizations);
             $_branch_ids_rows = implode(',', $_branch_ids);
            $_cost_center_id_rows = implode(',', $_cost_center_ids);

            $_stores = $request->_store ?? 'all';

            $category_ids = $request->_category_id ?? '' ;
            $category_ids_rows = $request->_category_id ?? '' ;
             

             $_item_ids = $request->_item_id ?? [];
             $_item_id_rows = '';
             if(sizeof($_item_ids)> 0){
                  $_item_id_rows = implode(',', $_item_ids);
             }

       if($request->has('_datex') && $request->has('_datey')){

            
// /return $request->all();
// /Start Main Query 

        $querys = "  SELECT  t2.id, t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,t1._item_name ,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id,t1._qty,t1._unit_conversion,t1._transection_unit,t1._base_unit,abs(t1._qty) as _qty,t1._rate,t1._value,
t1._sales_rate,t3._name as _ledger_name,t3._code,t2._order_number
        FROM damage_item_histories as t1 
        INNER JOIN  damage_receive_masters as t2 ON t1._transection_ref=t2.id
        inner join account_ledgers as t3 on t3.id=t2._ledger_id
        WHERE t1._transection='damage_send_to_supplier' AND  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") ";

         if($_stores !='all'){
                   $querys .="  AND  t1._store_id IN(".$_stores.")  ";
                }
 if($request->has('_category_id') && $request->_category_id !=''){
                   $querys .="  AND  t1._category_id IN(".$category_ids_rows.")  ";
                }
 if($request->has('_customer_id') && $request->_customer_id !=''){
                   $querys .="  AND  t2._ledger_id =$request->_customer_id  ";
    }

 if($_item_id_rows !=''){
                   $querys .="  AND  t1._item_id IN(".$_item_id_rows.")  ";
                }

$querys .="   ORDER BY t1._date ASC,t1._item_name ASC   ";




            $results = DB::select($querys);
            foreach($results as $r_key=>$value){
                 $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
            }


       }



        //return  $group_array_values;



        return view('backend.dm_report.dm_send_to_supplier',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','items','item_categories','item_categories_key_value','item_pack_key_value','unit_key_value','group_array_values','_branch_ids','_cost_center_ids','_stores','category_ids','customer_ledgers'));



     

    }
    public function  dm_receive_from_stock(Request $request){
        $page_name =__('label.dm_receive_from_stock');
         $previous_filter= $request->all();
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $item_categories = DB::select(" SELECT id,_name FROM `item_categories` WHERE id IN( SELECT DISTINCT _category_id FROM damage_item_histories ) ");
$item_categories_key_value=[];
  foreach ($item_categories as $category_key => $category_value) {
         $item_categories_key_value[$category_value->id]=$category_value->_name ?? ''; 
      }


      $customer_ledgers = DB::select(" SELECT t1.id,t1._name,t1._phone,t1._address,t1._balance,t1._branch_id,t1.organization_id
FROM account_ledgers as t1 WHERE id IN(SELECT DISTINCT _ledger_id FROM damage_from_stocks) ");


      $item_pack_sizes = DB::table("item_pack_sizes")->get();
      $item_pack_key_value=[];
      foreach ($item_pack_sizes as $key => $value) {
         $item_pack_key_value[$value->id]=$value->_name ?? ''; 
      }
      $units = DB::table("units")->get();
      $unit_key_value=[];
      foreach ($units as $unit_key => $unit_value) {
         $unit_key_value[$unit_value->id]=$unit_value->_name ?? ''; 
      }

       
       $items = DB::select( " SELECT t1.id as _item_id,CONCAT(t1._item, ' ', t2._name) AS  _item_name FROM inventories AS t1
INNER JOIN item_pack_sizes as t2 ON t1._pack_size_id=t2.id " );

       $group_array_values = [];
         $_datex =  change_date_format($request->_datex);
              $_datey=  change_date_format($request->_datey);

              
             // Start of Organization ,Branch,Cost Center IDS


            if($request->organization_id=='all'){
                $request_organizations = explode(',',$users->organization_ids);
            }else{
                $request_organizations = explode(',',$request->organization_id);
            }

            if($request->_branch_id=='all'){
                 $_branch_ids = explode(',',$users->branch_ids);
            }else{
                $_branch_ids = explode(',',$request->_branch_id);
            }

           

            if($request->_cost_center=='all'){
                $_cost_center_ids = explode(',',$users->cost_center_ids);
            }else{
                $_cost_center_ids = explode(',',$request->_cost_center);
            }

            $_organization_id_rows = implode(',', $request_organizations);
             $_branch_ids_rows = implode(',', $_branch_ids);
            $_cost_center_id_rows = implode(',', $_cost_center_ids);

            $_stores = $request->_store ?? 'all';

            $category_ids = $request->_category_id ?? '' ;
            $category_ids_rows = $request->_category_id ?? '' ;
             

             $_item_ids = $request->_item_id ?? [];
             $_item_id_rows = '';
             if(sizeof($_item_ids)> 0){
                  $_item_id_rows = implode(',', $_item_ids);
             }

       if($request->has('_datex') && $request->has('_datey')){

            
// /return $request->all();
// /Start Main Query 

        $querys = "  SELECT  t2.id, t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,t1._item_name ,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id,t1._qty,t1._unit_conversion,t1._transection_unit,t1._base_unit,t1._qty,t1._rate,t1._value,
t1._sales_rate,t3._name as _ledger_name,t3._code,t2._order_number
        FROM damage_item_histories as t1 
        INNER JOIN  damage_receive_masters as t2 ON t1._transection_ref=t2.id
        inner join account_ledgers as t3 on t3.id=t2._ledger_id
        WHERE t1._transection='damage_from_stocks' AND  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") ";

         if($_stores !='all'){
                   $querys .="  AND  t1._store_id IN(".$_stores.")  ";
                }
 if($request->has('_category_id') && $request->_category_id !=''){
                   $querys .="  AND  t1._category_id IN(".$category_ids_rows.")  ";
                }
 if($request->has('_customer_id') && $request->_customer_id !=''){
                   $querys .="  AND  t2._ledger_id =$request->_customer_id  ";
    }

 if($_item_id_rows !=''){
                   $querys .="  AND  t1._item_id IN(".$_item_id_rows.")  ";
                }

$querys .="   ORDER BY t1._date ASC,t1._item_name ASC   ";




            $results = DB::select($querys);
            foreach($results as $r_key=>$value){
                 $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
            }


       }



        //return  $group_array_values;



        return view('backend.dm_report.dm_receive_from_stock',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','items','item_categories','item_categories_key_value','item_pack_key_value','unit_key_value','group_array_values','_branch_ids','_cost_center_ids','_stores','category_ids','customer_ledgers'));



     
    }
   public function  dm_receive_from_customer(Request $request){
        $page_name =__('label.dm_receive_from_customer');
         $previous_filter= $request->all();
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $item_categories = DB::select(" SELECT id,_name FROM `item_categories` WHERE id IN( SELECT DISTINCT _category_id FROM damage_item_histories ) ");
$item_categories_key_value=[];
  foreach ($item_categories as $category_key => $category_value) {
         $item_categories_key_value[$category_value->id]=$category_value->_name ?? ''; 
      }


      $customer_ledgers = DB::select(" SELECT t1.id,t1._name,t1._phone,t1._address,t1._balance,t1._branch_id,t1.organization_id
FROM account_ledgers as t1 WHERE id IN(SELECT DISTINCT _ledger_id FROM damage_receive_masters) ");


      $item_pack_sizes = DB::table("item_pack_sizes")->get();
      $item_pack_key_value=[];
      foreach ($item_pack_sizes as $key => $value) {
         $item_pack_key_value[$value->id]=$value->_name ?? ''; 
      }
      $units = DB::table("units")->get();
      $unit_key_value=[];
      foreach ($units as $unit_key => $unit_value) {
         $unit_key_value[$unit_value->id]=$unit_value->_name ?? ''; 
      }

       
       $items = DB::select( " SELECT t1.id as _item_id,CONCAT(t1._item, ' ', t2._name) AS  _item_name FROM inventories AS t1
INNER JOIN item_pack_sizes as t2 ON t1._pack_size_id=t2.id " );

       $group_array_values = [];
         $_datex =  change_date_format($request->_datex);
              $_datey=  change_date_format($request->_datey);

              
             // Start of Organization ,Branch,Cost Center IDS


            if($request->organization_id=='all'){
                $request_organizations = explode(',',$users->organization_ids);
            }else{
                $request_organizations = explode(',',$request->organization_id);
            }

            if($request->_branch_id=='all'){
                 $_branch_ids = explode(',',$users->branch_ids);
            }else{
                $_branch_ids = explode(',',$request->_branch_id);
            }

           

            if($request->_cost_center=='all'){
                $_cost_center_ids = explode(',',$users->cost_center_ids);
            }else{
                $_cost_center_ids = explode(',',$request->_cost_center);
            }

            $_organization_id_rows = implode(',', $request_organizations);
             $_branch_ids_rows = implode(',', $_branch_ids);
            $_cost_center_id_rows = implode(',', $_cost_center_ids);

            $_stores = $request->_store ?? 'all';

            $category_ids = $request->_category_id ?? '' ;
            $category_ids_rows = $request->_category_id ?? '' ;
             

             $_item_ids = $request->_item_id ?? [];
             $_item_id_rows = '';
             if(sizeof($_item_ids)> 0){
                  $_item_id_rows = implode(',', $_item_ids);
             }

       if($request->has('_datex') && $request->has('_datey')){

            
// /return $request->all();
// /Start Main Query 

        $querys = "  SELECT  t2.id, t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,t1._item_name ,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id,t1._qty,t1._unit_conversion,t1._transection_unit,t1._base_unit,t1._qty,t1._rate,t1._value,
t1._sales_rate,t3._name as _ledger_name,t3._code,t2._order_number
        FROM damage_item_histories as t1 
        INNER JOIN  damage_receive_masters as t2 ON t1._transection_ref=t2.id
        inner join account_ledgers as t3 on t3.id=t2._ledger_id
        WHERE t1._transection='damage_receive_from_customer' AND  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") ";

         if($_stores !='all'){
                   $querys .="  AND  t1._store_id IN(".$_stores.")  ";
                }
 if($request->has('_category_id') && $request->_category_id !=''){
                   $querys .="  AND  t1._category_id IN(".$category_ids_rows.")  ";
                }
 if($request->has('_customer_id') && $request->_customer_id !=''){
                   $querys .="  AND  t2._ledger_id =$request->_customer_id  ";
    }

 if($_item_id_rows !=''){
                   $querys .="  AND  t1._item_id IN(".$_item_id_rows.")  ";
                }

$querys .="   ORDER BY t1._date ASC,t1._item_name ASC   ";




            $results = DB::select($querys);
            foreach($results as $r_key=>$value){
                 $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
            }


       }



        //return  $group_array_values;



        return view('backend.dm_report.dm_receive_from_customer',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','items','item_categories','item_categories_key_value','item_pack_key_value','unit_key_value','group_array_values','_branch_ids','_cost_center_ids','_stores','category_ids','customer_ledgers'));



     
    }
   public function  dm_item_stock_value(Request $request){
        $page_name =__('label.dm_item_stock_value');
        return view('backend.dm_report.dm_item_stock_value',compact('page_name'));

    }



    public function stockBalance(Request $request){

        $page_name = __('label.dm_item_stock_value');
        $_datex = $request->_datex ?? date('Y-m-d');
         $users = Auth::user();

        $permited_stores = permited_stores(explode(',',$users->store_ids));
        $request_store_ids = $request->_store ?? [];
         $_store_ids = filterableStores($request_store_ids,$permited_stores);
        $_store_id_rows = implode(',', $_store_ids);

       //Requested Organization,cost center,Branch and Store
       // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS



      $previous_filter= Session::get('stock_balance_filter');


//Product Category
       $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();

    //DISTINCT _manufacture_company 
     $manufactures = DB::select("SELECT DISTINCT _manufacture_company FROM `inventories` WHERE 1");
        
        

        return view('backend.dm_report.stockBalance',compact('page_name','permited_organizations','request','permited_branch','permited_costcenters','permited_stores','manufactures','previous_filter'));
    }

    
    public function ReportstockBalance(Request $request){
     
     $request->_datex = date("Y-m-d");

        session()->put('stock_balance_filter', $request->all());
        $previous_filter= Session::get('stock_balance_filter');
        $page_name = "Last Stock Balance Report";
        
        $users = Auth::user();
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];
        $request_organizations = $request->organization_id ?? [];
        $request_store_ids = $request->_store ?? [];
        $_manufacture_companys = $request->_manufacture_company ?? [];

        //Permited Organization,cost center,Branch and Store
       // $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       // $permited_branch = permited_branch(explode(',',$users->branch_ids));
       // $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_stores = permited_stores(explode(',',$users->store_ids));
        $_store_ids = filterableStores($request_store_ids,$permited_stores);
        $_store_id_rows = implode(',', $_store_ids);
        $_manufacture_companys_rows = implode(',', $_manufacture_companys);

        //if not selected organization ,cost center,Branch and Store
       // $_organization_ids = filterableOrganization($request_organizations,$permited_organizations);
       // $_branch_ids = filterableBranch($request_branchs,$permited_branch);
       // $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

      //    //Array to String id creation
      // $_organization_id_rows = implode(',', $_organization_ids);
      // $_branch_ids_rows = implode(',', $_branch_ids);
      // $_cost_center_id_rows = implode(',', $_cost_center_ids);

         // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS

    
        $datas=[];
        

        


     

      
      $_with_zero_qty = $request->_with_zero ?? 0;

      $_string_query =" SELECT t1.id as _item_id,t4._name as _unit,t1._item,t1._manufacture_company,t1._pur_rate,t1._sale_rate,t3._name AS item_cat,SUM(t2._qty) as balance_qty,t2._branch_id,
t2._cost_center_id,t2._store_id,t2._category_id
FROM inventories AS t1
INNER JOIN damage_item_histories as t2 ON t1.id=t2._item_id
INNER JOIN item_categories AS t3 ON t1._category_id=t3.id
INNER JOIN units as t4 ON t1._unit_id=t4.id
WHERE t2._status=1 AND  t2.organization_id IN(".$_organization_id_rows.")   AND  t2._branch_id IN(".$_branch_ids_rows.") AND  t2._cost_center_id IN(".$_cost_center_id_rows.") 
        AND t2._store_id IN(".$_store_id_rows.")  ";

    if(sizeof($_manufacture_companys) > 0){
        $_string_query .=" AND FIND_IN_SET(t1._manufacture_company,'".$_manufacture_companys_rows."')  ";
    }

        
    $_string_query .= "   GROUP BY t2._branch_id,t2._cost_center_id,t2._store_id,t2._item_id ";
      if($_with_zero_qty ==1){
       $_string_query .= " HAVING (SUM(t2._qty) > 0) ";
     }
      if($_with_zero_qty ==2){
       $_string_query .= " HAVING (SUM(t2._qty) = 0) ";
     }

     //return $_string_query;

     $datas = DB::select($_string_query);

if(sizeof($datas) > 0){
    foreach ($datas as $value) {
        $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][$value->_manufacture_company][]=$value;
    }
}else{
$group_array_values = array();
}


    $_datex = date("Y-m-d");
       //return $group_array_values;
        return view('backend.dm_report.report_stock_balance',compact('request','page_name','group_array_values','_datex','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','permited_stores'));
    }


    public function dm_item_stock_possition(Request $request){
        $page_name =__('label.dm_item_stock_possition');

        $previous_filter= Session::get('filter_stock_possition');
     
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $categories = DB::select( " SELECT DISTINCT t1._category_id FROM damage_item_histories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.dm_report.dm_item_stock_possition',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));


        

    }



public function dm_report_item_stock_possition(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_category' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('filter_stock_possition', $request->all());
        $previous_filter= Session::get('filter_stock_possition');
        $page_name = "Stock Position";
        
        $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $category_ids = array();
        $_item_categorys = $request->_item_category ?? [];
        if(sizeof($_item_categorys) > 0){
            foreach ($_item_categorys as $value) {
                array_push($category_ids, (int) $value);
            }
        }

        $_items_ids = array();
        $_items = (array) $request->_item_id;
        if(sizeof($_items) > 0){
            foreach ($_items as $value) {
                array_push($_items_ids, (int) $value);
            }

        }else{
            $basic_information = Inventory::select('id')->whereIn('_category_id',$_item_categorys)->get();
            foreach ($basic_information as $value) {
                array_push($_items_ids, (int) $value->id);
            }
        }

      $_with_zero_qty = $request->_with_zero ?? 0;
     
      $_items_ids_rows = implode(',', $_items_ids);

      
      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }

    $_stores_id_rows = implode(',', $_stores);
    $category_ids_rows = implode(',', $category_ids);

    // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      $_string_query = "  SELECT  s1._item_id,s1._name,s1._category_id,t3._name as _unit,s1._unit_id,s1._store_id,s1._branch_id, s1._cost_center_id, SUM(s1._opening) AS _opening,SUM(s1._stockin) as _stockin,SUM(s1._stockout) AS _stockout
      FROM (
      SELECT t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IFNULL(t1._qty,0)) AS _opening,0 as _stockin,0 AS _stockout 
        FROM damage_item_histories as t1 
        WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND t1._item_id IN(".$_items_ids_rows.")
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        GROUP BY t1._branch_id,t1._cost_center_id,t1._store_id,t1._category_id,t1._item_id 
      UNION ALL
      SELECT t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, 0 AS _opening, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin,SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout 
        FROM damage_item_histories as t1 
        WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
           AND t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND t1._item_id IN(".$_items_ids_rows.")
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        GROUP BY t1._branch_id,t1._cost_center_id,t1._store_id,t1._category_id,t1._item_id 
    ) as s1
    inner join units as t3 ON t3.id=s1._unit_id
     GROUP BY s1._branch_id,s1._cost_center_id,s1._store_id,s1._category_id,s1._item_id  ";
     if($_with_zero_qty ==1){
       $_string_query .= " HAVING (SUM(s1._stockin+s1._stockout+s1._opening) != 0) ";
     }

      $datas = DB::select($_string_query);

       
       $group_array_values =array();
      // foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
      // }

      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][]=$value;
      }

}else{
   $group_array_values = array();
}
      // return $group_array_values;
        return view('backend.dm_report.report_stock_possition',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }



    public function dm_item_ledger(Request $request){
      //  return $request->all();
        $page_name =__('label.dm_item_ledger');
         $previous_filter= $request->all();
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $item_categories = DB::select(" SELECT id,_name FROM `item_categories` WHERE id IN( SELECT DISTINCT _category_id FROM damage_item_histories ) ");
$item_categories_key_value=[];
  foreach ($item_categories as $category_key => $category_value) {
         $item_categories_key_value[$category_value->id]=$category_value->_name ?? ''; 
      }


      $item_pack_sizes = DB::table("item_pack_sizes")->get();
      $item_pack_key_value=[];
      foreach ($item_pack_sizes as $key => $value) {
         $item_pack_key_value[$value->id]=$value->_name ?? ''; 
      }
      $units = DB::table("units")->get();
      $unit_key_value=[];
      foreach ($units as $unit_key => $unit_value) {
         $unit_key_value[$unit_value->id]=$unit_value->_name ?? ''; 
      }

       
       $items = DB::select( " SELECT t1.id as _item_id,CONCAT(t1._item, ' ', t2._name) AS  _item_name FROM inventories AS t1
INNER JOIN item_pack_sizes as t2 ON t1._pack_size_id=t2.id " );

       $group_array_values = [];
         $_datex =  change_date_format($request->_datex);
              $_datey=  change_date_format($request->_datey);

              
             // Start of Organization ,Branch,Cost Center IDS


            if($request->organization_id=='all'){
                $request_organizations = explode(',',$users->organization_ids);
            }else{
                $request_organizations = explode(',',$request->organization_id);
            }

            if($request->_branch_id=='all'){
                 $_branch_ids = explode(',',$users->branch_ids);
            }else{
                $_branch_ids = explode(',',$request->_branch_id);
            }

           

            if($request->_cost_center=='all'){
                $_cost_center_ids = explode(',',$users->cost_center_ids);
            }else{
                $_cost_center_ids = explode(',',$request->_cost_center);
            }

            $_organization_id_rows = implode(',', $request_organizations);
             $_branch_ids_rows = implode(',', $_branch_ids);
            $_cost_center_id_rows = implode(',', $_cost_center_ids);

            $_stores = $request->_store ?? 'all';

            $category_ids = $request->_category_id ?? '' ;
            $category_ids_rows = $request->_category_id ?? '' ;
             

             $_item_ids = $request->_item_id ?? [];
             $_item_id_rows = '';
             if(sizeof($_item_ids)> 0){
                  $_item_id_rows = implode(',', $_item_ids);
             }

       if($request->has('_datex') && $request->has('_datey')){

            

//Start Main Query 

        $querys = "  SELECT '' as id, ".$_datex." as _date,'' as _transection_ref ,'Opening' as _transection,t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, 0 as _stockin,0 AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM damage_item_histories as t1 
        WHERE  t1._status=1 AND  t1._date < '".$_datex."' AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.")  ";

 if($_stores !='all'){
                   $querys .="  AND  t1._store_id IN(".$_stores.")  ";
                }
 if($request->has('_category_id') && $request->_category_id !=''){
                   $querys .="  AND  t1._category_id IN(".$category_ids_rows.")  ";
                }

 if($_item_id_rows !=''){
                   $querys .="  AND  t1._item_id IN(".$_item_id_rows.")  ";
                }

$querys .="  GROUP BY t1._branch_id,t1._cost_center_id,t1._store_id,t1._category_id,t1._item_id
        
 UNION ALL
 SELECT t1.id, t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin, SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM damage_item_histories as t1 
        WHERE  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") ";

         if($_stores !='all'){
                   $querys .="  AND  t1._store_id IN(".$_stores.")  ";
                }
 if($request->has('_category_id') && $request->_category_id !=''){
                   $querys .="  AND  t1._category_id IN(".$category_ids_rows.")  ";
                }

 if($_item_id_rows !=''){
                   $querys .="  AND  t1._item_id IN(".$_item_id_rows.")  ";
                }

$querys .="   GROUP BY t1.id   ";




            $results = DB::select($querys);
            foreach($results as $r_key=>$value){
                 $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id."__".$value->_item_id][]=$value;
            }


       }







        return view('backend.dm_report.dm_item_ledger',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','items','item_categories','item_categories_key_value','item_pack_key_value','unit_key_value','group_array_values','_branch_ids','_cost_center_ids','_stores','category_ids'));

       




    }
}
