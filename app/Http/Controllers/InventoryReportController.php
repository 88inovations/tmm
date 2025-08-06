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
use App\Models\PurchaseDetail;
use App\Models\PurchaseReturnAccount;
use App\Models\PurchaseReturnDetail;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Models\SalesReturnAccount;
use App\Models\PurchaseReturn;
use App\Models\Purchase;
use App\Models\ResturantSales;

class InventoryReportController extends Controller
{

     function __construct()
    {
         
         $this->middleware('permission:actual-sales-report', ['only' => ['reportActualSales','filterActualSales','resetActualSales']]);

         $this->middleware('permission:bill-party-statement', ['only' => ['reportBillOfPartyStatement','filterBillOfPartyStatement','resetBillOfPartyStatement']]);

         $this->middleware('permission:date-wise-purchase', ['only' => ['reportDateWisePurchaseStatement','filterDateWisePurchaseStatement','resetDateWisePurchaseStatement']]);

         $this->middleware('permission:purchase-return-detail', ['only' => ['filterDateWisePurchaseReturnStatement','resetDateWisePurchaseReturnStatement','reportDateWisePurchaseReturnStatement']]);
         
         $this->middleware('permission:date-wise-sales', ['only' => ['reportDateWiseSalesStatement','filterDateWiseSalesStatement','resetDateWiseSalesStatement']]);
         
         $this->middleware('permission:sales-return-detail', ['only' => ['reportDateWiseSalesReturnStatement','filterDateWiseSalesReturnStatement','resetDateWiseSalesReturnStatement']]);
         
         $this->middleware('permission:stock-possition', ['only' => ['reportStockPossition','filterStockPossition','resetStockPossition']]);
         
         $this->middleware('permission:stock-ledger', ['only' => ['reportStockLedger','filterStockLedger','resetStockLedger']]);

         
         $this->middleware('permission:stock-value', ['only' => ['reportStockValue','filterStockValue','resetStockValue']]);

         
         $this->middleware('permission:stock-value-register', ['only' => ['reportStockValueRegister','filterStockValueRegister','resetStockValueRegister']]);

         $this->middleware('permission:gross-profit', ['only' => ['reportGrossProfit','filterGrossProfit','resetGrossProfit']]);
         
         $this->middleware('permission:expired-item', ['only' => ['reportExpiredItem','filterExpiredItem','resetExpiredItem']]);
         
         $this->middleware('permission:shortage-item', ['only' => ['filterShortageItem','reportShortageItem','resetShortageItem']]);
         
         $this->middleware('permission:date-wise-restaurant-sales', ['only' => ['filterDateWiseRestaurantSalesStatement','reportDateWiseRestaurantSalesStatement','resetDateWiseRestaurantSalesStatement']]);

         $this->middleware('permission:date-wise-restaurant-invoice-print', ['only' => ['dateWiseRestaurantInvoice','dateWiseRestaurantInvoiceFilterReset','dateWiseRestaurantInvoiceReport']]);
         $this->middleware('permission:stock-balance', ['only' => ['stockBalance']]);
         $this->middleware('permission:category-wise-item-list', ['only' => ['categoryWiseItemList']]);
         $this->middleware('permission:sales_man_wise_sales_detail', ['only' => ['sales_man_wise_sales_detail']]);
         $this->middleware('permission:branch_wise_sales_statement', ['only' => ['branch_wise_sales_statement']]);
         $this->middleware('permission:transection_terms_wise_sales_report', ['only' => ['transection_terms_wise_sales_report']]);
         $this->middleware('permission:branch_wise_item_sales_return_summary', ['only' => ['branch_wise_item_sales_return_summary']]);
         $this->middleware('permission:branch_wise_item_sales_return_details', ['only' => ['branch_wise_item_sales_return_details']]);
         $this->middleware('permission:branch_and_customer_wise_s_r', ['only' => ['branch_and_customer_wise_s_r']]);
         

    }







    /*Request get Category id and response category wise Item List with name,unit,sales rate,purchase rate, and tp price*/

    public function categoryWiseItemList(Request $request){

        $category_id = $request->_category_id ?? '';

        $categories = DB::table("item_categories")->orderBy('_name','ASC')->get();
        $page_name = "Item List";

        $query = " SELECT t1.`id`, t1.`_item`,  t2._name as cat_name,t3._name as unit_name, t1.`_code`, t1.`_unit_id`, t1.`_pur_rate`, t1.`_sale_rate`, t1.`_trade_price` 
        FROM `inventories` as t1
        INNER JOIN item_categories as t2 ON t1.`_category_id`=t2.id
        INNER JOIN units as t3 ON t3.id=t1._unit_id
         WHERE 1=1 ";
         if($category_id  !=''){
            $query .= " AND t1._category_id=".$category_id."  ";
         }
         $query .= "  ORDER BY t1._item ASC ";

        $all_inventories = DB::select($query);
        $datas =[];
        foreach($all_inventories as $key=>$val){
            $datas[$val->cat_name][] = $val;
        }

        //return $datas;




        return view('backend.inventory-report.category_wise_item_list',compact('categories','datas','page_name','request'));

    }


    /*
    @report name: branch_wise_sales_statement
    @function :branch_wise_sales_statement
    @param: _datex,_datey,_items,_ledger
    @result: item wise customer and customer wise item details with type

    */

    public function branch_wise_sales_statement(Request $request){
        session()->put('branch_wise_sales_statement_filter', $request->all());
        $previous_filter= Session::get('branch_wise_sales_statement_filter');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex= change_date_format($request->_datex ?? '');
        $_datey = change_date_format($request->_datey ?? '');
        $_item_ids = $request->_main_item_id ?? '';
        $_ledger_id = $request->_ledger_id ?? '';
         $_sales_man_id = $request->_sales_man_id ?? '';
        $_report_type = $request->report_type ?? '';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();



     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.branch_wise_sales_statement');

    $datas = [];
if($request->has('_datex') && $request->has('_datey') &&  $_report_type ==2){

     $this->validate($request, [
            '_ledger_id' => 'required',
            
        ]);

    // return $_item_ids;
    //Territory Wise Product Sales & Return Summary
    $report_query_3="
SELECT  s1._date,s5._name as _b_name,s4._alious, s4._name as _l_name,s4._code as _l_code,s1._order_number,s1._item_id, s2._item as _name,s2._code,s3._name as _pack_name,s1._total_qty as _total_qty,s1.avg_sales_rate as avg_sales_rate ,s1._return_qty AS _return_qty,s1.reutn_amount as reutn_amount, s1._value as _value,(s1._value-s1.reutn_amount) as net_sales_amount  FROM (

SELECT  t1._date,'sales' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales` as t1 
INNER JOIN sales_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.=" UNION ALL

SELECT t1._date, 'sales_without_lots' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales_without_lots` as t1 
INNER JOIN sales_without_lot_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_returns` as t1 
INNER JOIN sales_return_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_return_wlms` as t1 
INNER JOIN sales_return_wlm_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'purchase' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM purchases as t1 
INNER JOIN purchase_details as t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN account_ledgers as t3 ON (t3.id=t1._ledger_id)
WHERE 1=1 AND t3._account_group_id IN ( SELECT _customer_group FROM account_group_configs ) AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")   ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}


if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="


) s1 INNER JOIN inventories as s2 on s1._item_id=s2.id
    INNER JOIN item_pack_sizes as s3 on s2._pack_size_id=s3.id
    INNER JOIN account_ledgers as s4 on s4.id=s1._ledger_id
    INNER JOIN branches as s5 ON s5.id=s1._branch_id

       ORDER BY s2._item ASC 
    ";

     $datas = DB::select($report_query_3);
    
}



if($request->has('_datex') && $request->has('_datey') && $_report_type ==3 || $_report_type ==1 ){

     $this->validate($request, [
            '_main_item_id' => 'required',
            '_main_item__search_item_id' => 'required',
            
        ]);

    // return $_item_ids;
    //Territory Wise Product Sales & Return Summary
    $report_query_3="
SELECT  s1._date,s5._name as _b_name,s4._alious, s4._name as _l_name,s4._code as _l_code,s1._order_number,s1._item_id, s2._item as _name,s2._code,s3._name as _pack_name,s1._total_qty as _total_qty,s1.avg_sales_rate as avg_sales_rate ,s1._return_qty AS _return_qty,s1.reutn_amount as reutn_amount, s1._value as _value,(s1._value-s1.reutn_amount) as net_sales_amount  FROM (

SELECT  t1._date,'sales' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales` as t1 
INNER JOIN sales_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND t2._item_id=$_item_ids
  ";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}



 $report_query_3.=" UNION ALL

SELECT t1._date, 'sales_without_lots' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales_without_lots` as t1 
INNER JOIN sales_without_lot_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  AND t2._item_id=$_item_ids
";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_returns` as t1 
INNER JOIN sales_return_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  AND t2._item_id=$_item_ids
";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_return_wlms` as t1 
INNER JOIN sales_return_wlm_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  AND t2._item_id=$_item_ids
";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'purchase' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM purchases as t1 
INNER JOIN purchase_details as t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN account_ledgers as t3 ON (t3.id=t1._ledger_id)
WHERE 1=1 AND t3._account_group_id IN ( SELECT _customer_group FROM account_group_configs ) AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")   AND t2._item_id=$_item_ids
";




 $report_query_3.="


) s1 INNER JOIN inventories as s2 on s1._item_id=s2.id
    INNER JOIN item_pack_sizes as s3 on s2._pack_size_id=s3.id
    INNER JOIN account_ledgers as s4 on s4.id=s1._ledger_id
    INNER JOIN branches as s5 ON s5.id=s1._branch_id

       ORDER BY s2._item ASC 
    ";

     $datas = DB::select($report_query_3);
    
}


if($request->has('_datex') && $request->has('_datey') && $_report_type ==4){
    //Territory Wise Product Sales & Return Summary
    $report_query_4="
SELECT s1._item_id, s2._item as _name,s2._code,s3._name as _pack_name,SUM(s1._total_qty) as _total_qty,AVG(s1.avg_sales_rate) as avg_sales_rate ,SUM(s1._return_qty) AS _return_qty,SUM(s1.reutn_amount) as reutn_amount, SUM(s1._value) as _value,SUM(s1._value-s1.reutn_amount) as net_sales_amount  FROM (

SELECT 'sales' as _type,t1._ledger_id, t2._item_id,SUM(t2._qty) as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,SUM(t2._qty*t2._sales_rate) as _value
FROM `sales` as t1 
INNER JOIN sales_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id

UNION ALL

SELECT 'sales_without_lots' as _type,t1._ledger_id, t2._item_id,SUM(t2._qty) as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,SUM(t2._qty*t2._sales_rate) as _value
FROM `sales_without_lots` as t1 
INNER JOIN sales_without_lot_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id

UNION ALL

SELECT 'sales_return' as _type,t1._ledger_id, t2._item_id,0 as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,SUM(t2._qty) as _return_qty,SUM(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_returns` as t1 
INNER JOIN sales_return_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id
UNION ALL

SELECT 'sales_return' as _type,t1._ledger_id, t2._item_id,0 as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,SUM(t2._qty) as _return_qty,SUM(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_return_wlms` as t1 
INNER JOIN sales_return_wlm_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id

UNION ALL

SELECT 'purchase' as _type,t1._ledger_id, t2._item_id,0 as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,SUM(t2._qty) as _return_qty,SUM(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM purchases as t1 
INNER JOIN purchase_details as t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN account_ledgers as t3 ON (t3.id=t1._ledger_id)
WHERE 1=1 AND t3._account_group_id IN ( SELECT _customer_group FROM account_group_configs ) AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}


$report_query_4.="
GROUP BY t2._item_id

) s1 INNER JOIN inventories as s2 on s1._item_id=s2.id
      INNER JOIN item_pack_sizes as s3 on s2._pack_size_id=s3.id
      GROUP BY s1._item_id ORDER BY s2._item ASC 
    ";

    $datas = DB::select($report_query_4);
    
}





//return $datas;

        return view('backend.inventory-report.branch_wise_sales_statement',compact('request','datas','permited_organizations','permited_branch','permited_costcenters','page_name','datas','sales_persons','previous_filter'));








    }


    public function sales_man_wise_sales_detail(Request $request){
         session()->put('customer_due_statement_report_filter', $request->all());
        $previous_filter= Session::get('customer_due_statement_report_filter');
        $page_name = __('label.sales_man_wise_sales_detail');
        $users = Auth::user();


$_ac_type        = $users->_ac_type ?? 0; // 1 = Sales Officer
$user_type       = $users->user_type ?? '';
$_sales_man_id   = $users->ref_id ?? 0;

      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);

      
     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    $all_ledgers = \DB::table('account_ledgers')->select('id','_code','_name')->get();



    $all_ledgers_id_name=[];
    foreach($all_ledgers as $ledger){
        $all_ledgers_id_name[$ledger->id]=$ledger->_code." ".$ledger->_name;
    }
   

    $permited_organizations_id_name=[];
    foreach($permited_organizations as $organization){
        $permited_organizations_id_name[$organization->id]=$organization->_name ?? '';
    }
    $permited_branch_id_name=[];
    foreach($permited_branch as $val){
        $permited_branch_id_name[$val->id]=$val->_name ?? '';
    }
    $permited_costcenters_id_name=[];
    foreach($permited_costcenters as $val){
        $permited_costcenters_id_name[$val->id]=$val->_name ?? '';
    }

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    $sales_persons =[];

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);

        $sales_persons = DB::table('account_ledgers')
                        ->select('id','_name','_code','_phone','_address')
                        ->where('_branch_id',$request->_branch_id)
                        ->whereIn('_account_group_id',$employee_grops_array)
                        ->get();

    }


    if($_ac_type ==1 && $user_type !='admin' ){
        $sales_persons = DB::table('account_ledgers')
                        ->select('id','_name','_code','_phone','_address')
                        ->where('id',$_sales_man_id)
                        ->get();
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    $account_heads = \DB::table('account_group_configs')->select('_customer_group')->first();

    $_account_group = $account_heads->_customer_group ?? 0;

    $datas=[];
    $_sales_man_id = $request->_sales_man_id ?? '';


    if($request->has('_datex') && $request->has('_datey')){

        //Only Sales Amount
        if($request->_report_type==1){
            $sql = " SELECT t1.id,t1._order_number,t1._date,t1._ledger_id,t1._address,t1._phone,
                t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,t1._sub_total,
                t1._total_discount,t1._total_vat,t1._total,t1._receive_amount,t1._due_amount
                FROM `sales` as t1
                WHERE   t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
                    if($_sales_man_id !=''){
                        $sql .= " AND t1._sales_man_id=".$_sales_man_id."  ";
                    }

                $only_sales_report = DB::select($sql);

                foreach($only_sales_report as $value){
                  $datas[$value->organization_id][$value->_branch_id][$value->_sales_man_id][]=$value;  
                }

                

        } /* ENd of Report One*/

         if($request->_report_type==2){
            $sql = " 

            SELECT t1.id,t1._order_number,t1._date,t1._ledger_id,t1._address,t1._phone,
                t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,(t1._sub_total-t1._total_discount) as _sales_amount, 0 as _sales_return_amount
                FROM `sales` as t1
                WHERE   t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
                    if($_sales_man_id !=''){
                        $sql .= " AND t1._sales_man_id=".$_sales_man_id."  ";
                    }
               $sql .= "      UNION ALL
                SELECT t1.id,t1._order_number,t1._date,t1._ledger_id,t1._address,t1._phone,
                t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,0 as _sales_amount, (t1._sub_total-t1._total_discount) as _sales_return_amount
                FROM `sales_returns` as t1
                WHERE   t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
                    if($_sales_man_id !=''){
                        $sql .= " AND t1._sales_man_id=".$_sales_man_id."  ";
                    }

                $only_sales_report = DB::select($sql);

                foreach($only_sales_report as $value){
                  $datas[$value->organization_id][$value->_branch_id][$value->_sales_man_id][]=$value;  
                }

               

        } /* ENd of Report One*/

        /*Sales & Sales Return With Product Details*/
         if($request->_report_type==3){

            $page_name ="Sales & Sales Return With Product Details";

            $sql = " 

            SELECT s1._sales_type, s1.organization_id,s1._branch_id,s1._store_id,s1._sales_man_id,s1._cost_center_id,
s1._item_id,s2._item,s2._code as _item_code,s3._name as _unit_name,SUM(s1._qty) as _qty,SUM((s1._unit_conversion*s1._qty)) as _con_qty,s1._base_unit,SUM(s1.free_qty) as free_qty ,s1._sales_rate,SUM(s1._value) as _value FROM (

SELECT t1._sales_type, t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,
t2._item_id,t2._transection_unit,t2._unit_conversion,t2._qty,(t2._unit_conversion*t2._qty) as _con_qty,t2._base_unit,t2.free_qty,t2._sales_rate,t2._value
FROM `sales` as t1
INNER JOIN sales_details as t2 ON t1.id=t2._no
WHERE t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") 

UNION ALL

SELECT t1._sales_type, t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,
t2._item_id,t2._transection_unit,t2._unit_conversion,-t2._qty,-(t2._unit_conversion*t2._qty) as _con_qty,t2._base_unit,0 as free_qty,t2._sales_rate,-t2._value
FROM sales_returns as t1
INNER JOIN sales_return_details as t2 ON t1.id=t2._no

WHERE t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") 
    
    ) as s1
    INNER JOIN inventories as s2 ON s1._item_id=s2.id
    INNER JOIN units as s3 ON s3.id=s2._unit_id
    GROUP BY s1._sales_type, s1.organization_id,s1._branch_id,s1._sales_man_id,s1._item_id,s1._sales_rate  ";

                $only_sales_report = DB::select($sql);

                foreach($only_sales_report as $value){
                  $datas[$value->organization_id][$value->_branch_id][$value->_sales_man_id][$value->_sales_type][]=$value;  
                }

               

        } /* ENd of Report Three*/
//return $datas;

/*Sales & Sales Return Summary In Amount*/
         if($request->_report_type==4){

            $page_name ="Sales & Sales Return Summary";

            $sql = " 

            SELECT  t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,SUM(t1._sub_total-t1._total_discount) as _sales_amount, 0 as _sales_return_amount
                FROM `sales` as t1
                WHERE   t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
                    if($_sales_man_id !=''){
                        $sql .= " AND t1._sales_man_id=".$_sales_man_id."  ";
                    }
                $sql .= "  GROUP BY t1.organization_id,t1._branch_id,t1._sales_man_id ";
               $sql .= "      UNION ALL
                SELECT t1.organization_id,t1._branch_id,t1._store_id,t1._sales_man_id,t1._cost_center_id,0 as _sales_amount, SUM(t1._sub_total-t1._total_discount) as _sales_return_amount
                FROM `sales_returns` as t1
                WHERE   t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
                    if($_sales_man_id !=''){
                        $sql .= " AND t1._sales_man_id=".$_sales_man_id."  ";
                    }
                 $sql .= "  GROUP BY t1.organization_id,t1._branch_id,t1._sales_man_id ";

                $only_sales_report = DB::select($sql);

                foreach($only_sales_report as $value){
                  $datas[$value->organization_id][$value->_branch_id][$value->_sales_man_id][]=$value;  
                }

               

        } /* ENd of Report Four*/

  //  return $datas;


    } /*End of Date isset Condition*/

return view('backend.inventory-report.sales_man_wise_sales_detail',compact('page_name','datas','permited_organizations','permited_branch','permited_costcenters','previous_filter','sales_persons','permited_organizations_id_name','permited_branch_id_name','permited_costcenters_id_name','all_ledgers_id_name'));

   
    }






    public function stockBalance(Request $request){

        $page_name = "Stock Balance Report";
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
        
        

        return view('backend.inventory-report.stockBalance',compact('page_name','permited_organizations','request','permited_branch','permited_costcenters','permited_stores','manufactures','previous_filter'));
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
INNER JOIN item_inventories as t2 ON t1.id=t2._item_id
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
        return view('backend.inventory-report.report_stock_balance',compact('request','page_name','group_array_values','_datex','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','permited_stores'));
    }

     public function difInventory(Request $request){

        $only_diff= $request->only_diff ?? 0;
        $results=[];


$query = " SELECT s1._item_id,t3._item,SUM(s1._a_qty) as _qty,SUM(s1._p_qty) as _p_qty FROM(
            SELECT t1._item_id,t1._qty as _a_qty,0 as _p_qty
            FROM item_inventories as t1 WHERE t1._status=1
            UNION ALL
            SELECT t2._item_id,0 as _a_qty,t2._qty as _p_qty 
            FROM product_price_lists as t2 WHERE t2._status=1
) as s1
    INNER JOIN inventories as t3 ON s1._item_id=t3.id
    
    GROUP BY s1._item_id ";

if($only_diff ==1){
 $query .= "   HAVING SUM(s1._a_qty) !=SUM(s1._p_qty) ";
}
    if($request->has('only_diff')){
         $results = DB::select($query);
    }
    
 

        $page_name = "Diffrence Between Inventory & Product Price Table";
         
        return view('backend.inventory-report.diff_inventory',compact('page_name','results','request'));
    }


     public function filterItemHistory(Request $request){

        $previous_filter= Session::get('item_history');
        $page_name = "Item History";
         
        return view('backend.inventory-report.filter_item_history',compact('request','page_name','previous_filter'));
    }

    public function reportItemHistory(Request $request){
      $this->validate($request, [
            '_search_item_id' => 'required',
            '_item_id' => 'required',
        ]);

        session()->put('item_history', $request->all());
        $previous_filter= Session::get('item_history');
        $page_name = "Item History";
        $_item_id = $request->_item_id;


        
         $purchase_details = DB::select("  SELECT 'purchase_details' as _table_name,t1.*
FROM purchase_details AS t1  WHERE t1._item_id=".$_item_id." ");

    $purchase_return_details = DB::select("  SELECT 'purchase_return_details' as _table_name,t1.*
FROM purchase_return_details AS t1  WHERE t1._item_id=".$_item_id." ");

    $sales_details = DB::select("  SELECT 'sales_details' as _table_name,t1.*
FROM sales_details AS t1  WHERE t1._item_id=".$_item_id." ");

    $sales_return_details = DB::select("  SELECT 'sales_return_details' as _table_name,t1.*
FROM sales_return_details AS t1  WHERE t1._item_id=".$_item_id." ");

    $damage_adjustment_details = DB::select("  SELECT 'damage_adjustment_details' as _table_name,t1.*
FROM damage_adjustment_details AS t1  WHERE t1._item_id=".$_item_id." ");

        return view('backend.inventory-report.report_item_history_row',compact('request','page_name','previous_filter','purchase_details','purchase_return_details','sales_details','sales_return_details','damage_adjustment_details'));
    }


    public function itemHistoryUpdate(Request $request){
      $row_id= $request->row_id;
      $table_name= $request->table_name;
      $column_name= $request->column_name;
      $column_value= $request->column_value;
      $string_query= " UPDATE ".$table_name." SET ".$column_name." = '".$column_value."' WHERE id = ".$row_id." ";
    return  \DB::statement($string_query);
      
    }


    public function resetItemHistory(){
        Session::flash('item_history');
        return redirect()->back();
    }


     public function filterBarcodeHistory(Request $request){

        $previous_filter= Session::get('barcode_history');
        $page_name = "Barcode History";
        return view('backend.inventory-report.filter_barcode_history',compact('request','page_name','previous_filter'));
    }


    public function reportBarcodeHistory(Request $request){
      $this->validate($request, [
            '_barcode' => 'required'
        ]);

        session()->put('barcode_history', $request->all());
        $previous_filter= Session::get('barcode_history');
        $page_name = "Barcode History";
        $_barcode = $request->_barcode ?? '';
        $datas = DB::select(" 
SELECT s1._type,s1._table_name,s4._name as _w_name,s1._ledger_id,s1.id as _id, s1._barcode,s1._warranty,s1._date,s1._item_id,s1._qty,s1._rate,s1._sales_rate,s1._store_id,s1._branch_id,s1._no  FROM(
          SELECT '1.Purchase' AS _type,'purchases' as _table_name,t2._ledger_id,t2.id, t1._barcode,t3._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM purchase_details AS t1 
INNER JOIN purchases AS t2 ON t1._no=t2.id
LEFT JOIN inventories AS t3 ON t3.id=t1._item_id where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT  '2.Purchase Return' AS _type,'purchase_return' as _table_name,t2._ledger_id,t2.id,t1._barcode,t3._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM purchase_return_details AS t1 
INNER JOIN purchase_returns AS t2 ON t1._no=t2.id
LEFT JOIN inventories AS t3 ON t3.id=t1._item_id where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '3.Sales' AS _type,'sales' as _table_name,t2._ledger_id,t2.id,t1._barcode,t1._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM sales_details AS t1
INNER JOIN sales AS t2 ON t1._no=t2.id where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '4.Sales Return' AS _type,'sales_return' as _table_name,t2._ledger_id,t2.id,t1._barcode,t1._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM sales_return_details AS t1
INNER JOIN sales_returns AS t2 ON t1._no=t2.id where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '5.Damage' AS _type,'damage' as _table_name,t2._ledger_id,t2.id,t1._barcode,t1._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM damage_adjustment_details AS t1
INNER JOIN damage_adjustments AS t2 ON t1._no=t2.id 
 where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '6.Rep In' AS _type,'replacement_masters' as _table_name,t2._ledger_id,t2.id,t1._barcode,inv._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM replacement_item_ins AS t1
INNER JOIN inventories as inv ON inv.id=t1._item_id
INNER JOIN replacement_masters AS t2 ON t1._no=t2.id 
 where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '7.Rep Out' AS _type,'replacement_masters' as _table_name,t2._ledger_id,t2.id,t1._barcode,inv._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM replacement_item_outs AS t1
INNER JOIN inventories as inv ON inv.id=t1._item_id
INNER JOIN replacement_masters AS t2 ON t1._no=t2.id 
 where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '8.Rep To Supplier' AS _type,'individual_replace_masters' as _table_name,t2._supplier_id as _ledger_id,t2.id,t1._barcode,inv._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM individual_replace_old_items AS t1
INNER JOIN inventories as inv ON inv.id=t1._item_id
INNER JOIN individual_replace_masters AS t2 ON t1._no=t2.id 
 where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '9.In For Rep.' AS _type,'individual_replace_masters' as _table_name,t2._supplier_id as _ledger_id,t2.id,t1._barcode,inv._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM individual_replace_in_items AS t1
INNER JOIN inventories as inv ON inv.id=t1._item_id
INNER JOIN individual_replace_masters AS t2 ON t1._no=t2.id 
 where t1._barcode LIKE '%$_barcode%'
UNION ALL
SELECT '10.Rep Delivery' AS _type,'individual_replace_masters' as _table_name,t2._supplier_id as _ledger_id,t2.id,t1._barcode,inv._warranty,t2._date,t1._item_id,t1._qty,t1._rate,t1._sales_rate,t1._store_id,t1._branch_id,t1._no 
FROM individual_replace_out_items AS t1
INNER JOIN inventories as inv ON inv.id=t1._item_id
INNER JOIN individual_replace_masters AS t2 ON t1._no=t2.id 
 where t1._barcode LIKE '%$_barcode%'

  ) as s1
 LEFT JOIN warranties as s4 on s4.id=s1._warranty
  ORDER BY s1._type ASC
  ");
  //return $datas;
        return view('backend.inventory-report.report_barcode_history',compact('request','page_name','previous_filter','datas'));
    }


    public function resetBarcodeHistory(){
        Session::flash('barcode_history');
        return redirect()->back();
    }


     public function filterBillOfPartyStatement(Request $request){

        $previous_filter= Session::get('bill_of_party_statement');
        $page_name = "Bill of Party Statement";

        $exixting_groups = \DB::select("SELECT DISTINCT `_account_group` FROM `accounts` WHERE 1");
        $group_ids = [];
        foreach ($exixting_groups as $key => $value) {
         array_push($group_ids, $value->_account_group);
        }
        $account_groups = AccountGroup::select('id','_name')
                                        ->where('_show_filter',1)
                                        ->whereIn('id',$group_ids)
                                        ->orderBy('_name','ASC')
                                        ->get();
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_bill_of_party_statement',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportBillOfPartyStatement(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('bill_of_party_statement', $request->all());
        $previous_filter= Session::get('bill_of_party_statement');
        $page_name = "Bill of Party Statement";
        
       $users = Auth::user();
        
        $datas=[];
         $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       

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
      
     if($ledger_id_rows){
     $string_query = "
SELECT s1._sl, s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name, s1._id,s1._table_name, s1._date, s1._short_narration, s1._narration, s1._dr_amount, s1._cr_amount, s1._balance  FROM (
      SELECT t1._status,null as _sl, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, null as _id,null as _table_name, '".$_datex."' as _date, null as _short_narration, 'Opening Balance' as _narration, 0 AS _dr_amount, 0  AS _cr_amount, SUM(t1._dr_amount-t1._cr_amount) AS _balance  
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
      UNION ALL
            SELECT t1._status, t1.id as _sl, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, t1._dr_amount AS _dr_amount, t1._cr_amount  AS _cr_amount, 0 AS _balance 
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 

              ) as s1 WHERE s1._status=1 order by s1._date,s1._sl ASC  ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_bill_of_party_statement',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    public function resetBillOfPartyStatement(){
        Session::flash('bill_of_party_statement');
        return redirect()->back();
    }


     public function filterDateWisePurchaseStatement(Request $request){

        $previous_filter= Session::get('date_wise_purchase_statement');
        $page_name = "Date Wise Purchase Statement";
        $account_groups = DB::select(" SELECT DISTINCT t2._account_group_id as _ledger_id,t3.id,t3._name AS _name
                                      FROM purchases AS t1
                                      INNER JOIN account_ledgers AS t2 ON t2.id=t1._ledger_id
                                      INNER JOIN account_groups AS t3 ON t3.id=t2._account_group_id
                                      ORDER BY t3._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_date_wise_purchase_statement',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportDateWisePurchaseStatement(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('date_wise_purchase_statement', $request->all());
        $previous_filter= Session::get('date_wise_purchase_statement');
        $page_name = "Date Wise Purchase Statement";
        
       $users = Auth::user();
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       

      // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     // return $request->all();

       $datas = Purchase::with(['_ledger','_master_details'])
                ->whereIn('_branch_id', $_branch_ids)
                ->whereIn('organization_id', $_organization_ids)
                ->whereIn('_cost_center_id', $_cost_center_ids)
                ->whereIn('_ledger_id', $ledger_ids)
                ->whereDate('_date','>=',$_datex)
                ->whereDate('_date','<=',$_datey)
                ->get();
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_ledger->account_group->_name][$value->_ledger->_name][]=$value;
       }
  //return $group_array_values;

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_date_wise_purchase_statement',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    public function resetDateWisePurchaseStatement(){
        Session::flash('date_wise_purchase_statement');
        return redirect()->back();
    }



     public function filterDateWisePurchaseReturnStatement(Request $request){

        $previous_filter= Session::get('date_wise_purchase_return_statement');
        $page_name = "Date Wise Purchase Return Statement";
        $account_groups = DB::select(" SELECT DISTINCT t2._account_group_id as _ledger_id ,t3.id,t3._name AS _name
                                      FROM purchase_returns AS t1
                                      INNER JOIN account_ledgers AS t2 ON t2.id=t1._ledger_id
                                      INNER JOIN account_groups AS t3 ON t3.id=t2._account_group_id
                                      ORDER BY t3._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_date_wise_purchase_return_statement',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportDateWisePurchaseReturnStatement(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('date_wise_purchase_return_statement', $request->all());
        $previous_filter= Session::get('date_wise_purchase_return_statement');
        $page_name = "Date Wise Purchase Return Statement";
        
       $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       

       // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     // return $request->all();

       $datas = PurchaseReturn::with(['_ledger','_master_details'])
               ->whereIn('organization_id', $_organization_ids)
                ->whereIn('_branch_id', $_branch_ids)
                ->whereIn('_cost_center_id', $_cost_center_ids)
                ->whereIn('_ledger_id', $ledger_ids)
                ->whereDate('_date','>=',$_datex)
                ->whereDate('_date','<=',$_datey)
                ->get();
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_ledger->account_group->_name][$value->_ledger->_name][]=$value;
       }
  //return $group_array_values;

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_date_wise_purchase_return_statement',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    public function resetDateWisePurchaseReturnStatement(){
        Session::flash('date_wise_purchase_return_statement');
        return redirect()->back();
    }



     public function transection_terms_wise_sales_report(Request $request){

          session()->put('transection_terms_wise_sales_report', $request->all());
        $previous_filter= Session::get('transection_terms_wise_sales_report');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex             = change_date_format($request->_datex ?? '');
        $_datey             = change_date_format($request->_datey ?? '');
        $_item_ids          = $request->_main_item_id ?? '';
        $_ledger_id         = $request->_ledger_id ?? '';
        $_sales_man_id      = $request->_sales_man_id ?? '';
        $_report_type       = $request->report_type ?? '';
        $transection_term  = $request->transection_terms ?? '';
        $_invoice_type      = $request->_invoice_type ?? 'all';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


        $branchs_ids = $users->branch_ids ?? '';
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $branchs_ids = $request->_branch_id ?? '';
        }

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$branchs_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();

   

    $transection_terms = \DB::table('transection_terms')->orderBy('_days','ASC')->get();

     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.transection_terms_wise_sales_report');
    $datas = [];
    if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

           

            $sales_summary_query =" SELECT 'Sales' as type,t1._payment_terms,t3._name as _tern_name,t2._name,t1._address,t1._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t1._sub_total,t1._total_discount,t1._total_vat,t1._total,t1._receive_amount, t1._due_amount,t1._is_close,t1._trans_amount,IFNULL(t4._total, 0) AS _sales_return
            FROM `sales` AS t1
            INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
            LEFT JOIN transection_terms as t3 ON t3.id=t1._payment_terms
            LEFT JOIN sales_returns as t4 ON t4._order_ref_id=t1.id
             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }

            if($transection_term !=''){
                $sales_summary_query .="  AND t1._payment_terms = $transection_term ";
            }

            if($_sales_man_id !=''){
                $sales_summary_query .="  AND t1._sales_man_id= $_sales_man_id ";
            }


            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

            if($_invoice_type =='due'){
                $sales_summary_query .="  AND t1._due_amount > 0 ";
            }
            if($_invoice_type =='paid'){
                $sales_summary_query .="  AND t1._is_close =1 ";
            }

         


            $sales_summary_result = \DB::select($sales_summary_query);

            foreach($sales_summary_result as $key=>$value){
                $datas[$value->_tern_name][]  = $value;
            }
           // return $datas;
    }





         
        return view('backend.inventory-report.transection_terms_wise_sales_report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas','sales_persons','transection_terms'));
    }


    public function branch_wise_item_sales_return_summary(Request $request){
         session()->put('branch_wise_item_sales_return_summary_filter', $request->all());
        $previous_filter= Session::get('branch_wise_item_sales_return_summary_filter');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex= change_date_format($request->_datex ?? '');
        $_datey = change_date_format($request->_datey ?? '');
        $_item_ids = $request->_main_item_id ?? '';
        $_ledger_id = $request->_ledger_id ?? '';
         $_sales_man_id = $request->_sales_man_id ?? '';
        $_report_type = $request->report_type ?? '';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();



     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.branch_wise_item_sales_return_summary');

    $datas = [];


if($request->has('_datex') && $request->has('_datey') && $_report_type ==4){
    //Territory Wise Product Sales & Return Summary
    $report_query_4="
SELECT s1._item_id, s2._item as _name,s2._code,s3._name as _pack_name,SUM(s1._total_qty) as _total_qty,AVG(s1.avg_sales_rate) as avg_sales_rate ,SUM(s1._return_qty) AS _return_qty,SUM(s1.reutn_amount) as reutn_amount, SUM(s1._value) as _value,SUM(s1._value-s1.reutn_amount) as net_sales_amount  FROM (

SELECT 'sales' as _type,t1._ledger_id, t2._item_id,SUM(t2._qty) as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,SUM(t2._qty*t2._sales_rate) as _value
FROM `sales` as t1 
INNER JOIN sales_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id

UNION ALL

SELECT 'sales_without_lots' as _type,t1._ledger_id, t2._item_id,SUM(t2._qty) as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,SUM(t2._qty*t2._sales_rate) as _value
FROM `sales_without_lots` as t1 
INNER JOIN sales_without_lot_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id

UNION ALL

SELECT 'sales_return' as _type,t1._ledger_id, t2._item_id,0 as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,SUM(t2._qty) as _return_qty,SUM(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_returns` as t1 
INNER JOIN sales_return_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id
UNION ALL

SELECT 'sales_return' as _type,t1._ledger_id, t2._item_id,0 as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,SUM(t2._qty) as _return_qty,SUM(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_return_wlms` as t1 
INNER JOIN sales_return_wlm_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_4.=" AND t1._sales_man_id=$_sales_man_id ";
}
$report_query_4.="
GROUP BY t2._item_id

UNION ALL

SELECT 'purchase' as _type,t1._ledger_id, t2._item_id,0 as _total_qty,AVG(t2._sales_rate) as avg_sales_rate,SUM(t2._qty) as _return_qty,SUM(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM purchases as t1 
INNER JOIN purchase_details as t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN account_ledgers as t3 ON (t3.id=t1._ledger_id)
WHERE 1=1 AND t3._account_group_id IN ( SELECT _customer_group FROM account_group_configs ) AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";

if($_item_ids !=''){
 $report_query_4.=" AND t2._item_id=$_item_ids ";
}


$report_query_4.="
GROUP BY t2._item_id

) s1 INNER JOIN inventories as s2 on s1._item_id=s2.id
      INNER JOIN item_pack_sizes as s3 on s2._pack_size_id=s3.id
      GROUP BY s1._item_id ORDER BY s2._item ASC 
    ";

    $datas = DB::select($report_query_4);
    
}





//return $datas;

        return view('backend.inventory-report.branch_wise_item_sales_return_summary',compact('request','datas','permited_organizations','permited_branch','permited_costcenters','page_name','datas','sales_persons','previous_filter'));



    }



    public function branch_wise_item_sales_return_details(Request $request){
         session()->put('branch_wise_item_sales_return_details_filter', $request->all());
        $previous_filter= Session::get('branch_wise_item_sales_return_details_filter');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex= change_date_format($request->_datex ?? '');
        $_datey = change_date_format($request->_datey ?? '');
        $_item_ids = $request->_main_item_id ?? '';
        $_ledger_id = $request->_ledger_id ?? '';
         $_sales_man_id = $request->_sales_man_id ?? '';
        $_report_type = $request->report_type ?? '';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();



     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.branch_wise_item_sales_return_details');

    $datas = [];



        return view('backend.inventory-report.branch_wise_item_sales_return_details',compact('request','datas','permited_organizations','permited_branch','permited_costcenters','page_name','datas','sales_persons','previous_filter'));



    }


    public function branch_wise_item_sales_return_details_report(Request $request){
         session()->put('branch_wise_item_sales_return_details_filter', $request->all());
        $previous_filter= Session::get('branch_wise_item_sales_return_details_filter');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex= change_date_format($request->_datex ?? '');
        $_datey = change_date_format($request->_datey ?? '');
        $_item_ids = $request->_main_item_id ?? '';
        $_ledger_id = $request->_ledger_id ?? '';
         $_sales_man_id = $request->_sales_man_id ?? '';
        $_report_type = $request->report_type ?? '';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();



     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.branch_wise_item_sales_return_details');

    $datas = [];


if($request->has('_datex') && $request->has('_datey') && $_report_type ==3 || $_report_type ==1 ){

     $this->validate($request, [
            '_main_item_id' => 'required',
            '_main_item__search_item_id' => 'required',
            
        ]);

    // return $_item_ids;
    //Territory Wise Product Sales & Return Summary
    $report_query_3="
SELECT  s1._date,s5._name as _b_name,s4._alious, s4._name as _l_name,s4._code as _l_code,s1._order_number,s1._item_id, s2._item as _name,s2._code,s3._name as _pack_name,s1._total_qty as _total_qty,s1.avg_sales_rate as avg_sales_rate ,s1._return_qty AS _return_qty,s1.reutn_amount as reutn_amount, s1._value as _value,(s1._value-s1.reutn_amount) as net_sales_amount  FROM (

SELECT  t1._date,'sales' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales` as t1 
INNER JOIN sales_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND t2._item_id=$_item_ids
  ";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}

if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.=" UNION ALL

SELECT t1._date, 'sales_without_lots' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales_without_lots` as t1 
INNER JOIN sales_without_lot_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  AND t2._item_id=$_item_ids
";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}

if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_returns` as t1 
INNER JOIN sales_return_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  AND t2._item_id=$_item_ids
";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}

if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_return_wlms` as t1 
INNER JOIN sales_return_wlm_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  AND t2._item_id=$_item_ids
";
if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}

if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'purchase' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM purchases as t1 
INNER JOIN purchase_details as t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN account_ledgers as t3 ON (t3.id=t1._ledger_id)
WHERE 1=1 AND t3._account_group_id IN ( SELECT _customer_group FROM account_group_configs ) AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")   AND t2._item_id=$_item_ids
";




 $report_query_3.="


) s1 INNER JOIN inventories as s2 on s1._item_id=s2.id
    INNER JOIN item_pack_sizes as s3 on s2._pack_size_id=s3.id
    INNER JOIN account_ledgers as s4 on s4.id=s1._ledger_id
    INNER JOIN branches as s5 ON s5.id=s1._branch_id

       ORDER BY s2._item ASC 
    ";

     $datas = DB::select($report_query_3);
    
}





//return $datas;

        return view('backend.inventory-report.branch_wise_item_sales_return_details',compact('request','datas','permited_organizations','permited_branch','permited_costcenters','page_name','datas','sales_persons','previous_filter'));



    }



    public function branch_and_customer_wise_s_r(Request $request){
         session()->put('branch_and_customer_wise_s_r_filter', $request->all());
        $previous_filter= Session::get('branch_and_customer_wise_s_r_filter');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex= change_date_format($request->_datex ?? '');
        $_datey = change_date_format($request->_datey ?? '');
        $_item_ids = $request->_main_item_id ?? '';
        $_ledger_id = $request->_ledger_id ?? '';
         $_sales_man_id = $request->_sales_man_id ?? '';
        $_report_type = $request->report_type ?? '';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();



     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.branch_and_customer_wise_s_r');

    $datas = [];



        return view('backend.inventory-report.branch_and_customer_wise_s_r',compact('request','datas','permited_organizations','permited_branch','permited_costcenters','page_name','datas','sales_persons','previous_filter'));



    }


    public function branch_and_customer_wise_s_r_report(Request $request){
         session()->put('branch_and_customer_wise_s_r_filter', $request->all());
        $previous_filter= Session::get('branch_and_customer_wise_s_r_filter');
         $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $_datex= change_date_format($request->_datex ?? '');
        $_datey = change_date_format($request->_datey ?? '');
        $_item_ids = $request->_main_item_id ?? '';
        $_ledger_id = $request->_ledger_id ?? '';
         $_sales_man_id = $request->_sales_man_id ?? '';
        $_report_type = $request->report_type ?? '';
    //return $request->all();

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->get();



     $_customer_group_string = DB::table('account_group_configs')->select('_customer_group')->first();
     $_customer_group_ids = explode(",", $_customer_group_string->_customer_group ?? '');


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
    $page_name = __('label.branch_and_customer_wise_s_r');

    $datas = [];


if($request->has('_datex') && $request->has('_datey') &&  $_report_type ==2){

     $this->validate($request, [
            '_ledger_id' => 'required',
            
        ]);

    // return $_item_ids;
    //Territory Wise Product Sales & Return Summary
    $report_query_3="
SELECT  s1._date,s5._name as _b_name,s4._alious, s4._name as _l_name,s4._code as _l_code,s1._order_number,s1._item_id, s2._item as _name,s2._code,s3._name as _pack_name,s1._total_qty as _total_qty,s1.avg_sales_rate as avg_sales_rate ,s1._return_qty AS _return_qty,s1.reutn_amount as reutn_amount, s1._value as _value,(s1._value-s1.reutn_amount) as net_sales_amount  FROM (

SELECT  t1._date,'sales' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales` as t1 
INNER JOIN sales_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.=" UNION ALL

SELECT t1._date, 'sales_without_lots' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,(t2._qty) as _total_qty,(t2._sales_rate) as avg_sales_rate,0 as _return_qty,0 as reutn_amount,(t2._qty*t2._sales_rate) as _value
FROM `sales_without_lots` as t1 
INNER JOIN sales_without_lot_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._ledger_id,t1._branch_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_returns` as t1 
INNER JOIN sales_return_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'sales_return' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM `sales_return_wlms` as t1 
INNER JOIN sales_return_wlm_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}

if($_sales_man_id !=''){
 $report_query_3.=" AND t1._sales_man_id=$_sales_man_id ";
}
if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="

UNION ALL

SELECT t1._date, 'purchase' as _type,t1._order_number,t1._branch_id,t1._ledger_id, t2._item_id,0 as _total_qty,(t2._sales_rate) as avg_sales_rate,(t2._qty) as _return_qty,(t2._qty*t2._sales_rate) as reutn_amount,0 as _value
FROM purchases as t1 
INNER JOIN purchase_details as t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN account_ledgers as t3 ON (t3.id=t1._ledger_id)
WHERE 1=1 AND t3._account_group_id IN ( SELECT _customer_group FROM account_group_configs ) AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'   AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")   ";
if($_item_ids !=''){
    $report_query_3.= " AND t2._item_id=$_item_ids ";
}


if($_ledger_id !=''){
 $report_query_3.=" AND t1._ledger_id=$_ledger_id ";
}



 $report_query_3.="


) s1 INNER JOIN inventories as s2 on s1._item_id=s2.id
    INNER JOIN item_pack_sizes as s3 on s2._pack_size_id=s3.id
    INNER JOIN account_ledgers as s4 on s4.id=s1._ledger_id
    INNER JOIN branches as s5 ON s5.id=s1._branch_id

       ORDER BY s2._item ASC 
    ";

     $datas = DB::select($report_query_3);
    
}




//return $datas;

        return view('backend.inventory-report.branch_and_customer_wise_s_r',compact('request','datas','permited_organizations','permited_branch','permited_costcenters','page_name','datas','sales_persons','previous_filter'));



    }




     public function date_to_date_sales_detail(Request $request){

           session()->put('date_to_date_sales_detail', $request->all());
        
        $previous_filter= Session::get('date_to_date_sales_detail');
        $page_name = __('label.date_to_date_sales_detail');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $datas =   [];
        if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

            $sales_summary_query =" SELECT 'Sales' as type,t2._name,t1._address,t1._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t1._sub_total,t1._total_discount,t1._total_vat,t1._total FROM `sales` AS t1
            INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

         //   $sales_summary_query .="  ORDER BY t1._date ASC ";

            $sales_summary_query .=" UNION ALL
            SELECT 'Sales Return' as type,t2._name,t1._address,t1._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t1._sub_total,t1._total_discount,t1._total_vat,t1._total FROM sales_returns AS t1
             INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
              WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }
          //   $sales_summary_query .="  ORDER BY t1._date ASC ";


            $sales_summary_result = \DB::select($sales_summary_query);

            foreach($sales_summary_result as $key=>$value){
                $datas[$value->type][]  = $value;
            }
    //return $datas;
        }


         
        return view('backend.inventory-report.date_to_date_sales_detail',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas'));
    }




     public function date_to_date_sales_item_detail(Request $request){

           session()->put('date_to_date_sales_item_detail', $request->all());
        
        $previous_filter= Session::get('date_to_date_sales_item_detail');
        $page_name = __('label.date_to_date_sales_item_detail');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $datas =   [];
        if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

            $sales_summary_query =" SELECT 'Sales' as type,t2._name,t1._address,t1._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._unit_conversion,t3._transection_unit,t3._base_unit,t3._barcode,t3._qty,
t3._sales_rate,t3._discount,t3._discount_amount,t3._vat_amount,t3._value,t3._manufacture_date,
t3._expire_date,t3._warranty

             FROM `sales` AS t1
            INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
             INNER JOIN sales_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id

             INNER JOIN units as t5 ON t5.id=t3._transection_unit

             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

         //   $sales_summary_query .="  ORDER BY t1._date ASC ";

            $sales_summary_query .=" UNION ALL
            SELECT 'Sales Return' as type,t2._name,t1._address,t1._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._unit_conversion,t3._transection_unit,t3._base_unit,t3._barcode,t3._qty,
t3._sales_rate,t3._discount,t3._discount_amount,t3._vat_amount,t3._value,t3._manufacture_date,
t3._expire_date,t3._warranty 
FROM sales_returns AS t1
             INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
              INNER JOIN sales_return_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id
              INNER JOIN units as t5 ON t5.id=t3._transection_unit

              WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }
          //   $sales_summary_query .="  ORDER BY t1._date ASC ";


            $sales_summary_result = \DB::select($sales_summary_query);

            foreach($sales_summary_result as $key=>$value){
                $datas[$value->type][]  = $value;
            }
    //return $datas;
        }


         
        return view('backend.inventory-report.date_to_date_sales_item_detail',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas'));
    }


     public function date_to_date_sales_item_summary(Request $request){

           session()->put('date_to_date_sales_item_summary', $request->all());
        
        $previous_filter= Session::get('date_to_date_sales_item_summary');
        $page_name = __('label.date_to_date_sales_item_summary');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $datas =   [];
        if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

            $sales_summary_query =" SELECT 'Sales' as type,t3._item_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._base_unit,
            SUM(t3._qty*t3._unit_conversion) as _qty,(SUM(t3._value)/SUM(t3._qty*t3._unit_conversion)) as _sales_rate,SUM(t3._discount_amount) as _discount_amount,SUM(t3._vat_amount) as _vat_amount,SUM(t3._value) as _value

             FROM `sales` AS t1
           
             INNER JOIN sales_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id
             INNER JOIN units as t5 ON t5.id=t3._base_unit

             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

           $sales_summary_query .=" GROUP BY  t3._item_id";

            $sales_summary_query .=" UNION ALL
            SELECT 'Sales Return' as type,t3._item_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._base_unit,
            SUM(t3._qty*t3._unit_conversion) as _qty,(SUM(t3._value)/SUM(t3._qty*t3._unit_conversion)) as _sales_rate,SUM(t3._discount_amount) as _discount_amount,SUM(t3._vat_amount) as _vat_amount,SUM(t3._value) as _value
FROM sales_returns AS t1
             
              INNER JOIN sales_return_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id
              INNER JOIN units as t5 ON t5.id=t3._base_unit

              WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }
            $sales_summary_query .="  GROUP BY t3._item_id ";


            $sales_summary_result = \DB::select($sales_summary_query);

            foreach($sales_summary_result as $key=>$value){
                $datas[$value->type][]  = $value;
            }
    //return $datas;
        }


         
        return view('backend.inventory-report.date_to_date_sales_item_summary',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas'));
    }



     public function date_to_date_purchases_detail(Request $request){

           session()->put('date_to_date_purchases_detail', $request->all());
        
        $previous_filter= Session::get('date_to_date_purchases_detail');
        $page_name = __('label.date_to_date_purchases_detail');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $datas =   [];
        if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

            $sales_summary_query =" SELECT 'Purchase' as type,t2._name,t2._address,t2._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t1._sub_total,t1._total_discount,t1._total_vat,t1._total FROM `purchases` AS t1
            INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

         //   $sales_summary_query .="  ORDER BY t1._date ASC ";

            $sales_summary_query .=" UNION ALL
            SELECT 'Purchase Return' as type,t2._name,t2._address,t2._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t1._sub_total,t1._total_discount,t1._total_vat,t1._total FROM purchase_returns AS t1
             INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
              WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }
          //   $sales_summary_query .="  ORDER BY t1._date ASC ";


            $sales_summary_result = \DB::select($sales_summary_query);

            foreach($sales_summary_result as $key=>$value){
                $datas[$value->type][]  = $value;
            }
    //return $datas;
        }


         
        return view('backend.inventory-report.date_to_date_purchases_detail',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas'));
    }


     public function date_to_date_purchases_item_detail(Request $request){

           session()->put('date_to_date_purchases_item_detail', $request->all());
        
        $previous_filter= Session::get('date_to_date_purchases_item_detail');
        $page_name = __('label.date_to_date_purchases_item_detail');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $datas =   [];
        if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

            $sales_summary_query =" SELECT 'Sales' as type,t2._name,t2._address,t2._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._unit_conversion,t3._transection_unit,t3._base_unit,t3._barcode,t3._qty,
t3._sales_rate,t3._discount,t3._discount_amount,t3._vat_amount,t3._value
             FROM `purchases` AS t1
            INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
             INNER JOIN purchase_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id

             INNER JOIN units as t5 ON t5.id=t3._transection_unit

             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

         //   $sales_summary_query .="  ORDER BY t1._date ASC ";

            $sales_summary_query .=" UNION ALL
            SELECT 'Sales Return' as type,t2._name,t2._address,t2._phone,t2._code,t2._alious,t1._order_number,t1._date,t1._ledger_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._unit_conversion,t3._transection_unit,t3._base_unit,t3._barcode,t3._qty,
t3._sales_rate,t3._discount,t3._discount_amount,t3._vat_amount,t3._value
FROM purchase_returns AS t1
             INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
              INNER JOIN purchase_return_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id
              INNER JOIN units as t5 ON t5.id=t3._transection_unit

              WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $sales_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $sales_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $sales_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }
          //   $sales_summary_query .="  ORDER BY t1._date ASC ";


            $sales_summary_result = \DB::select($sales_summary_query);

            foreach($sales_summary_result as $key=>$value){
                $datas[$value->type][]  = $value;
            }
    //return $datas;
        }


         
        return view('backend.inventory-report.date_to_date_purchases_item_detail',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas'));
    }


     public function date_to_date_purchases_item_summary(Request $request){

           session()->put('date_to_date_purchases_item_summary', $request->all());
        
        $previous_filter= Session::get('date_to_date_purchases_item_summary');
        $page_name = __('label.date_to_date_purchases_item_summary');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

        $datas =   [];
        if($request->has('_datex') && $request->has('_datey')){
            $organization_id    = $request->organization_id ?? 'all';
            $_branch_id         = $request->_branch_id ?? 'all';
            $_cost_center       = $request->_cost_center ?? 'all';
            $_datex             = change_date_format($request->_datex ?? date('d-m-Y'));
            $_datey             = change_date_format($request->_datey ?? date('d-m-Y'));
        //return $request->all();

            $_summary_query =" SELECT 'Purchase' as type,t3._item_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._base_unit,
            SUM(t3._qty*t3._unit_conversion) as _qty,(SUM(t3._value)/SUM(t3._qty*t3._unit_conversion)) as _sales_rate,SUM(t3._discount_amount) as _discount_amount,SUM(t3._vat_amount) as _vat_amount,SUM(t3._value) as _value

             FROM `purchases` AS t1
             INNER JOIN purchase_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id
             INNER JOIN units as t5 ON t5.id=t3._base_unit

             WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($organization_id !='all'){
                $_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }

           $_summary_query .=" GROUP BY  t3._item_id";

            $_summary_query .=" UNION ALL
            SELECT 'Purchase Return' as type,t3._item_id,t4._item as _item_name,t4._code as item_code,t5._name as _tran_unit,t3._item_id,t3._base_unit,
            SUM(t3._qty*t3._unit_conversion) as _qty,(SUM(t3._value)/SUM(t3._qty*t3._unit_conversion)) as _sales_rate,SUM(t3._discount_amount) as _discount_amount,SUM(t3._vat_amount) as _vat_amount,SUM(t3._value) as _value
FROM purchase_returns AS t1
             
              INNER JOIN purchase_return_details as t3 ON (t1.id=t3._no AND t3._status=1)
             INNER JOIN inventories as t4 ON t4.id=t3._item_id
              INNER JOIN units as t5 ON t5.id=t3._base_unit

              WHERE t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";

            if($organization_id !='all'){
                $_summary_query .="  AND t1.organization_id= $organization_id ";
            }
            if($_branch_id !='all'){
                $_summary_query .="  AND t1._branch_id= $_branch_id ";
            }

            if($_cost_center !='all'){
                $_summary_query .="  AND t1._cost_center_id= $_cost_center ";
            }
            $_summary_query .="  GROUP BY t3._item_id ";


            $_summary_result = \DB::select($_summary_query);

            foreach($_summary_result as $key=>$value){
                $datas[$value->type][]  = $value;
            }
    //return $datas;
        }


         
        return view('backend.inventory-report.date_to_date_purchases_item_summary',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas'));
    }



    


     public function filterDateWiseSalesStatement(Request $request){

        $previous_filter= Session::get('date_wise_sales_statement');
        $page_name = "Date Wise Sales Statement";
        $account_groups = DB::select(" SELECT DISTINCT t2._account_group_id as _ledger_id,t3.id,t3._name AS _name
                                      FROM sales AS t1
                                      INNER JOIN account_ledgers AS t2 ON t2.id=t1._ledger_id
                                      INNER JOIN account_groups AS t3 ON t3.id=t2._account_group_id
                                      ORDER BY t3._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_date_wise_sales_statement',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportDateWiseSalesStatement(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('date_wise_sales_statement', $request->all());
        $previous_filter= Session::get('date_wise_sales_statement');
        $page_name = "Date Wise Sales Statement";
        
       $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       

      // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     // return $request->all();

       $datas = Sales::with(['_ledger','_master_details'])
                ->whereIn('organization_id', $_organization_ids)
                ->whereIn('_branch_id', $_branch_ids)
                ->whereIn('_cost_center_id', $_cost_center_ids)
                ->whereIn('_ledger_id', $ledger_ids)
                ->whereDate('_date','>=',$_datex)
                ->whereDate('_date','<=',$_datey)
                ->get();
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_ledger->account_group->_name][$value->_ledger->_name][]=$value;
       }
  //return $group_array_values;

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_date_wise_sales_statement',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    public function resetDateWiseSalesStatement(){
        Session::flash('date_wise_sales_statement');
        return redirect()->back();
    }

    public function filterActualSales(Request $request){

        $previous_filter= Session::get('actual_sales');
        $page_name = "Date Wise Sales Statement";
        $account_groups = DB::select(" SELECT DISTINCT t2._account_group_id as _ledger_id,t3.id,t3._name AS _name
                                      FROM sales AS t1
                                      INNER JOIN account_ledgers AS t2 ON t2.id=t1._ledger_id
                                      INNER JOIN account_groups AS t3 ON t3.id=t2._account_group_id
                                      ORDER BY t3._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_actual_sales',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }

    public function reportActualSales(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('actual_sales', $request->all());
        $previous_filter= Session::get('actual_sales');
        $page_name = "Actual Sales Report";
        
       $users = Auth::user();
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       

     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     // return $request->all();

       $datas = Sales::with(['_ledger','_master_details','_sales_return'])
                ->whereIn('organization_id', $_organization_ids)
                ->whereIn('_branch_id', $_branch_ids)
                ->whereIn('_cost_center_id', $_cost_center_ids)
                ->whereIn('_ledger_id', $ledger_ids)
                ->whereDate('_date','>=',$_datex)
                ->whereDate('_date','<=',$_datey)
                ->get();
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_ledger->account_group->_name][$value->_ledger->_name][]=$value;
       }
  //return $group_array_values;

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_actual_sales',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }

     public function resetActualSales(){
        Session::flash('actual_sales');
        return redirect()->back();
    }





    //Filter Date wise Restaurant Sals Statement
     public function filterDateWiseRestaurantSalesStatement(Request $request){

        $previous_filter= Session::get('date_wise_restaurant_sales_statement');
        $page_name = "Date Wise Sales Restaurant Statement";
        $account_groups = DB::select(" SELECT DISTINCT t2._account_group_id as _ledger_id,t3.id,t3._name AS _name
                                      FROM resturant_sales  AS t1
                                      INNER JOIN account_ledgers AS t2 ON t2.id=t1._ledger_id
                                      INNER JOIN account_groups AS t3 ON t3.id=t2._account_group_id
                                      ORDER BY t3._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_date_wise_restaurant_sales_statement',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportDateWiseRestaurantSalesStatement(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('date_wise_restaurant_sales_statement', $request->all());
        $previous_filter= Session::get('date_wise_restaurant_sales_statement');
        $page_name = "Date Wise Sales Restaurant Statement";
        
       $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       

      // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     // return $request->all();

       $datas = ResturantSales::with(['_ledger','_master_details'])
                ->whereIn('organization_id', $_organization_ids)
                ->whereIn('_branch_id', $_branch_ids)
                ->whereIn('_cost_center_id', $_cost_center_ids)
                ->whereIn('_ledger_id', $ledger_ids)
                ->whereDate('_date','>=',$_datex)
                ->whereDate('_date','<=',$_datey)
                ->get();
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_ledger->account_group->_name][$value->_ledger->_name][]=$value;
       }
  //return $group_array_values;

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_date_wise_restaurant_sales_statement',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    public function resetDateWiseRestaurantSalesStatement(){
        Session::flash('date_wise_restaurant_sales_statement');
        return redirect()->back();
    }


     public function filterDateWiseSalesReturnStatement(Request $request){

        $previous_filter= Session::get('date_wise_sales_return_statement');
        $page_name = "Date Wise Sales Return Statement";
        $account_groups = DB::select(" SELECT DISTINCT t2._account_group_id as _ledger_id,t3.id,t3._name AS _name
                                      FROM sales_returns AS t1
                                      INNER JOIN account_ledgers AS t2 ON t2.id=t1._ledger_id
                                      INNER JOIN account_groups AS t3 ON t3.id=t2._account_group_id
                                      ORDER BY t3._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.inventory-report.filter_date_wise_sales_return_statement',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportDateWiseSalesReturnStatement(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_account_ledger_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('date_wise_sales_return_statement', $request->all());
        $previous_filter= Session::get('date_wise_sales_return_statement');
        $page_name = "Date Wise Sales Return Statement";
        
        $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }
      $ledger_id_rows = implode(',', $ledger_ids);

       

      // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
       $datas = SalesReturn::with(['_ledger','_master_details'])
                ->whereIn('organization_id', $_organization_ids)
                ->whereIn('_branch_id', $_branch_ids)
                ->whereIn('_cost_center_id', $_cost_center_ids)
                ->whereIn('_ledger_id', $ledger_ids)
                ->whereDate('_date','>=',$_datex)
                ->whereDate('_date','<=',$_datey)
                ->get();
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_ledger->account_group->_name][$value->_ledger->_name][]=$value;
       }
  //return $group_array_values;

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.inventory-report.report_date_wise_sales_return_statement',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    public function resetDateWiseSalesReturnStatement(){
      
        Session::flash('date_wise_sales_return_statement');
        return redirect()->back();
    }


public function filterStockPossition(Request $request){
      $previous_filter= Session::get('filter_stock_possition');
      $page_name = "Stock Position";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_stock_possition',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}


/*Over All Stock Possition Report 

 Here Only take Three Param:
    @ start_date
    @ end_date
    @ item_category [All or Single Category]
    @  
*/


public function over_all_stock_possition(Request $request){

    


    $page_name = "Stock Position";

    $_datex = change_date_format($request->_datex);
    $_datey = change_date_format($request->_datey);
    $_category_id = $request->_category_id ?? 'all';


    $datas = [];
    if($request->has('_datex') && $request->has('_datey')){
       // return $request->all();
         $this->validate($request, [
            '_datex' => 'required',
            '_category_id' => 'required',
            '_datey' => 'required'
        ]);

        $_string_query = "  SELECT  s1._item_id,CONCAT(s1._name,' ',t4._name) as _name,s1._category_id,t3._name as _unit,s1._unit_id,s1._store_id,s1._branch_id, s1._cost_center_id, SUM(s1._opening) AS _opening,SUM(s1._stockin) as _stockin,SUM(s1._stockout) AS _stockout
              FROM (
              SELECT t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IFNULL(t1._qty,0)) AS _opening,0 as _stockin,0 AS _stockout 
                FROM item_inventories as t1 
                WHERE  t1._status=1 AND t1._date < '".$_datex."' ";
        if($_category_id !='all'){
             $_string_query .= "   AND t1._category_id IN(".$_category_id.") ";
        }
             


              $_string_query .= "    GROUP BY t1._category_id,t1._item_id 
              UNION ALL
              SELECT t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, 0 AS _opening, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin,SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout 
                FROM item_inventories as t1 
                WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  ";
        if($_category_id !='all'){
                 $_string_query .= "      AND t1._category_id IN(".$_category_id.") ";
        }
               $_string_query .= "    GROUP BY t1._category_id,t1._item_id 
            ) as s1
            inner join units as t3 ON t3.id=s1._unit_id
            inner join inventories as t5 ON t5.id=s1._item_id
            INNER JOIN item_pack_sizes as t4 ON t5._pack_size_id=t4.id
             GROUP BY s1._category_id,s1._item_id  ";
            

              $all_data = DB::select($_string_query);

    foreach ($all_data as $value) {
        $datas[$value->_category_id][]=$value;
      }

      
    }
 


    return view('backend.inventory-report.over_all_stock_possition',compact('page_name','request','datas'));


}







public function reportStockPossition(Request $request){
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

      $_string_query = "  SELECT t4._code, s1._item_id,s1._name,s1._category_id,t3._name as _unit,s1._unit_id,s1._store_id,s1._branch_id, s1._cost_center_id, SUM(s1._opening) AS _opening,SUM(s1._stockin) as _stockin,SUM(s1._stockout) AS _stockout
      FROM (
      SELECT t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IFNULL(t1._qty,0)) AS _opening,0 as _stockin,0 AS _stockout 
        FROM item_inventories as t1 
        WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND t1._item_id IN(".$_items_ids_rows.")
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        GROUP BY t1._item_id 
      UNION ALL
      SELECT t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, 0 AS _opening, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin,SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout 
        FROM item_inventories as t1 
        WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
           AND t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND t1._item_id IN(".$_items_ids_rows.")
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        GROUP BY t1._branch_id,t1._cost_center_id,t1._store_id,t1._category_id,t1._item_id 
    ) as s1
    inner join units as t3 ON t3.id=s1._unit_id
    INNER JOIN inventories as t4 ON t4.id=s1._item_id
     GROUP BY s1._item_id  ";
     if($_with_zero_qty ==1){
       $_string_query .= " HAVING (SUM(s1._stockin+s1._stockout+s1._opening) != 0) ";
     }

      $group_array_values = DB::select($_string_query);

       
       //$group_array_values =array();
      // foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
      // }

      // foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][]=$value;
      // }

}else{
   $group_array_values = array();
}
      // return $group_array_values;
        return view('backend.inventory-report.report_stock_possition',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }

public function stockPossitionCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(["_pack_size"])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.stock_possition_cat_base_item',compact('data'));
}

public function resetStockPossition(){
  Session::flash('filter_stock_possition');
  return redirect()->back();
}

public function filterStockLedger(Request $request){
      $previous_filter= Session::get('filter_stock_ledger');
      $page_name = "Stock Ledger";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
       $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_stock_ledger',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}

public function reportStockLedger(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_category' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('filter_stock_ledger', $request->all());
        $previous_filter= Session::get('filter_stock_ledger');
        $page_name = "Stock Ledger";
        
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

     

      $request_branchs = $request->_branch_id ?? [];
      $request_cost_centers = $request->_cost_center ?? [];
      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }
      $_items_ids_rows = implode(',', $_items_ids);
       $_stores_id_rows = implode(',', $_stores);
     $category_ids_rows = implode(',', $category_ids);

      

    // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      
      $datas = DB::select("  

      SELECT '' as id, ".$_datex." as _date,'' as _transection_ref ,'Opening' as _transection,t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, 0 as _stockin,0 AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM item_inventories as t1 
        WHERE  t1._status=1 AND  t1._date < '".$_datex."' AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") 
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.")
        GROUP BY t1._branch_id,t1._cost_center_id,t1._store_id,t1._category_id,t1._item_id
        
 UNION ALL
 SELECT t1.id, t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin, SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM item_inventories as t1 
        WHERE  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") 
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.")
        GROUP BY t1.id  


      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id."__".$value->_item_id][]=$value;
      }

      //   foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][$value->_item_id][]=$value;
      // }
       

}else{
   $group_array_values = array();
}
      // return $group_array_values;
        return view('backend.inventory-report.report_stock_ledger',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }
public function resetStockLedger(){
  Session::flash('filter_stock_ledger');
  return redirect()->back();
}

public function filterSingleStockLedger(Request $request){
      $previous_filter= Session::get('filter_single_stock_ledger');
      $page_name = "Single Item Stock Ledger";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
       
       $items = DB::select( " SELECT t1.id as _item_id,CONCAT(t1._item, ' ', t2._name) AS  _item_name FROM inventories AS t1
INNER JOIN item_pack_sizes as t2 ON t1._pack_size_id=t2.id " );
        return view('backend.inventory-report.filter_single_stock_ledger',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','items'));
}


public function reportSingleStockLedger(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_id' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('filter_single_stock_ledger', $request->all());
        $previous_filter= Session::get('filter_single_stock_ledger');
        $page_name = "Single Item Stock Ledger";
        
        $users = Auth::user();
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        
        $category_ids=[];
        $_items_ids = array();
        $_items = (array) $request->_item_id;
        if(sizeof($_items) > 0){
            foreach ($_items as $value) {
                array_push($_items_ids, (int) $value);
            }

        }

     

      $request_branchs = $request->_branch_id ?? [];
      $request_cost_centers = $request->_cost_center ?? [];
      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }
      $_items_ids_rows = implode(',', $_items_ids);
      $_stores_id_rows = implode(',', $_stores);
      $category_ids_rows = implode(',', $category_ids);


      // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      
      $datas = DB::select("  

      SELECT '' as id, ".$_datex." as _date,'' as _transection_ref ,'Opening' as _transection,t1._item_id,CONCAT( t1._item_name ,' ',t3._name) as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, 0 as _stockin,0 AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM item_inventories as t1 
        INNER JOIN inventories as t2 ON t1._item_id=t2.id
        INNER JOIN item_pack_sizes as t3 ON t2._pack_size_id=t3.id
        WHERE  t1._status=1 AND  t1._date < '".$_datex."' AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") 
        AND t1._store_id IN(".$_stores_id_rows.") 
        AND t1._item_id IN(".$_items_ids_rows.")
        GROUP BY t1._item_id
        
 UNION ALL
 SELECT t1.id, t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,CONCAT( t1._item_name ,' ',t3._name) as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin, SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM item_inventories as t1 
        INNER JOIN inventories as t2 ON t1._item_id=t2.id
        INNER JOIN item_pack_sizes as t3 ON t2._pack_size_id=t3.id
        WHERE  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") 
        AND t1._store_id IN(".$_stores_id_rows.") 
        AND t1._item_id IN(".$_items_ids_rows.")
        GROUP BY t1.id  


      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id."__".$value->_item_id][]=$value;
      }

      //   foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][$value->_item_id][]=$value;
      // }
       

}else{
   $group_array_values = array();
}

//return $datas;

      // return $group_array_values;
        return view('backend.inventory-report.report_single_stock_ledger_2',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids','datas'));
    }

    
public function resetSingleStockLedger(){
  Session::flash('filter_single_stock_ledger');
  return redirect()->back();
}

public function stockLedgerCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(['_pack_size'])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.stock_ledger_cat_base_item',compact('data'));
}




public function filterStockValueRegister(Request $request){
      $previous_filter= Session::get('filter_stock_value_register');
      $page_name = "Stock Value Register";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
       $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_stock_value_register',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}

public function reportStockValueRegister(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_category' => 'required'
        ]);

        session()->put('filter_stock_value_register', $request->all());
        $previous_filter= Session::get('filter_stock_value_register');
        $page_name = "Stock Value Register";
        
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

     

      $request_branchs = $request->_branch_id ?? [];
      $request_cost_centers = $request->_cost_center ?? [];
      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }
      $_stores_id_rows = implode(',', $_stores);
      $category_ids_rows = implode(',', $category_ids);
      $_items_ids_rows = implode(',', $_items_ids);


       // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

    
      $datas = DB::select("  SELECT t1._date, t1._transection_ref as _transection_ref  ,t1._transection as _transection,t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id, SUM(IF((t1._qty > 0), t1._qty,0  )) as _stockin, SUM(IF((t1._qty < 0), t1._qty,0  )) AS _stockout,SUM(IFNULL(t1._qty,0)) as _balance 
        FROM item_inventories as t1 
        WHERE  t1._status=1 AND    t1._date <= '".$_datex."' AND t1.organization_id IN(".$_organization_id_rows.")
        AND  t1._branch_id IN(".$_branch_ids_rows.") 
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.") AND t1._transection IN('Purchase','Purchase Return')
        GROUP BY t1.id ORDER by t1.id ASC
      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id."__".$value->_item_id][]=$value;
      }

       
       

}else{
   $group_array_values = array();
}
       //return $group_array_values;
        return view('backend.inventory-report.report_stock_value_register',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }

public function stockValueRegisterCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(["_pack_size"])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.stock_value_register_cat_base_item',compact('data'));
}

public function resetStockValueRegister(){
  Session::flash('filter_stock_value_register');
  return redirect()->back();
}

public function filterStockValue(Request $request){
      $previous_filter= Session::get('filter_stock_value');
      $page_name = "Stock Value";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_stock_value',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}

public function reportStockValue(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_category' => 'required'
        ]);

        session()->put('filter_stock_value', $request->all());
        $previous_filter= Session::get('filter_stock_value');
        $page_name = "Stock Value";
        
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

     

      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }
      $_items_ids_rows = implode(',', $_items_ids);
      $_stores_id_rows = implode(',', $_stores);
      $category_ids_rows = implode(',', $category_ids);


       // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      
      $datas = DB::select("  SELECT t2._code,t3._name as pack_name,t1._item_id,t1._item_name as _name,t1._category_id,t1._unit_id,t1._store_id,t1._branch_id, t1._cost_center_id,SUM(IFNULL(t1._qty,0)) as _qty , t2._pur_rate as _cost_rate,SUM( t1._qty*t2._pur_rate ) as _cost_value,t2._sale_rate
        FROM item_inventories as t1 
        INNER JOIN inventories as t2 ON t1._item_id=t2.id
        INNER JOIN item_pack_sizes as t3 ON t3.id=t2._pack_size_id
        WHERE  t1._status=1 AND  t1._date <= '".$_datex."' AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.") AND t1._qty !=0

        GROUP BY t1._item_id
         HAVING(SUM(IFNULL(t1._qty,0)) > 0)

      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_store_id."__".$value->_category_id][]=$value;
      }

       
       

}else{
   $group_array_values = array();
}
       //return $group_array_values;
        return view('backend.inventory-report.report_stock_value',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }

public function stockValueCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(['_pack_size'])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.stock_value_cat_base_item',compact('data'));
}

public function resetStockValue(){
  Session::flash('filter_stock_value');
  return redirect()->back();
}

public function filterGrossProfit(Request $request){
      $previous_filter= Session::get('filter_gross_profit');
      $page_name = "Gross Profit";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
       $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_gross_profit',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}

public function reportGrossProfit(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_category' => 'required',
            '_datey' => 'required',
        ]);

        session()->put('filter_gross_profit', $request->all());
        $previous_filter= Session::get('filter_gross_profit');
        $page_name = "Gross Profit";
        
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

     

      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }

      $_items_ids_rows = implode(',', $_items_ids);
      $_stores_id_rows = implode(',', $_stores);
      $category_ids_rows = implode(',', $category_ids);

       // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      
      $datas = DB::select("  
 SELECT t1._item_id,t1._item_name as _name,t1._category_id,t2._name as _unit_name,t1._store_id,t1._branch_id, t1._cost_center_id,  SUM(IFNULL( -(t1._qty),0  )) AS _qty,SUM(-(t1._qty)*t1._rate) as _value,
  SUM(-(t1._qty)*t1._cost_rate) as _cost_value 
        FROM item_inventories as t1 
        inner JOIN units as t2 on t1._unit_id=t2.id
        WHERE  t1._status=1 AND   t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
        AND  t1._branch_id IN(".$_branch_ids_rows.")  AND t1.organization_id IN(".$_organization_id_rows.")
        AND t1._store_id IN(".$_stores_id_rows.") AND t1._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.") AND t1._transection IN('Sales','Sales Return')
        GROUP BY t1._branch_id,t1._cost_center_id,t1._store_id,t1._category_id,t1._item_id


      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
      }

       
       

}else{
   $group_array_values = array();
}
      //return $group_array_values;
        return view('backend.inventory-report.report_gross_profit',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }

public function grossProfitCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(["_pack_size"])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.gross_profit_cat_base_item',compact('data'));
}

public function resetGrossProfit(){
  Session::flash('filter_gross_profit');
  return redirect()->back();
}



public function filterExpiredItem(Request $request){
      $previous_filter= Session::get('filter_expired_item');
      $page_name = "Expired Item";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
       $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_expired_item',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}

public function reportExpiredItem(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_item_category' => 'required',
            '_datey' => 'required',
        ]);

        session()->put('filter_expired_item', $request->all());
        $previous_filter= Session::get('filter_expired_item');
        $page_name = "Expired Item";
        
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

     

      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }
      $_items_ids_rows = implode(',', $_items_ids);
      $_stores_id_rows = implode(',', $_stores);
      $category_ids_rows = implode(',', $category_ids);


       // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      
      $datas = DB::select("  
 SELECT t1.`id`, t1.`_item_id`,t2._category_id, t1.`_item`, t1.`_unit_id`,t3._name as _unit_name, t1.`_barcode`, t1.`_manufacture_date`, t1.`_expire_date`, t1.`_qty`, t1.`_sales_rate`, t1.`_pur_rate`, t1.`_sales_discount`, t1.`_sales_vat`, t1.`_value`, t1.`_master_id`, t1.`_branch_id`, t1.`_cost_center_id`, t1.`_store_id`, t1.`_store_salves_id`, t1.`_status` 
 FROM `product_price_lists` as t1
 INNER JOIN inventories as t2 ON t1._item_id=t2.id
 INNER JOIN units as t3 on t3.id=t1._unit_id
  WHERE  t1._status=1 AND   t1._expire_date  >= '".$_datex."'  AND t1._expire_date <= '".$_datey."' 
        AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1._qty !=0
        AND t1._store_id IN(".$_stores_id_rows.") AND t2._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.")  AND t1._cost_center_id IN(".$_cost_center_id_rows.")
        ORDER BY t1.`_item` ASC


      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
      }

      // foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][]=$value;
      // }

       
       

}else{
   $group_array_values = array();
}
       //return $group_array_values;
        return view('backend.inventory-report.report_expired_item',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }

public function expiredItemCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(["_pack_size"])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.expired_item_cat_base_item',compact('data'));
}

public function resetExpiredItem(){
  Session::flash('filter_expired_item');
  return redirect()->back();
}

public function filterShortageItem(Request $request){
      $previous_filter= Session::get('filter_shortage_item');
      $page_name = "Shortage Item";
      $users = Auth::user();
      $permited_branch = permited_branch(explode(',',$users->branch_ids));
      $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      $datas=[];
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $stores = StoreHouse::get();
      $categories = DB::select( " SELECT DISTINCT t1._category_id FROM item_inventories AS t1" );
      $_categories_ids = [];
      foreach ($categories as $value) {
        array_push($_categories_ids, intval($value->_category_id));
      }
     $_item_categories = ItemCategory::with(['_parents'])->whereIn('id',$_categories_ids)->get();
      
        return view('backend.inventory-report.filter_shortage_item',compact('page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','request','stores','_item_categories'));
}

public function reportShortageItem(Request $request){
      $this->validate($request, [
            '_item_category' => 'required'
        ]);

        session()->put('filter_shortage_item', $request->all());
        $previous_filter= Session::get('filter_shortage_item');
        $page_name = "Shortage Item";
        
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

     
      $_stores = $request->_store ?? [];
      if(sizeof($_stores) ==0){
        $stores_all = StoreHouse::get();
        foreach ($stores_all as $value) {
          array_push($_stores, (int) $value->id);
        }
      }
      $_items_ids_rows = implode(',', $_items_ids);
      $_stores_id_rows = implode(',', $_stores);
      $category_ids_rows = implode(',', $category_ids);


     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $_organization_ids = explode(',',$users->organization_ids);
    }else{
        $_organization_ids = explode(',',$request->organization_id);
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

    $_organization_id_rows = implode(',', $_organization_ids);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    //End of Organization ,Branch,Cost Center IDS
      
     if($_items_ids){

      
      $datas = DB::select("  
SELECT t1._branch_id,t1._store_id,t1._cost_center_id,t2._category_id,t1._item_id,t1._item_name,SUM(t1._qty) as _qty,t3._name AS _unit_name,t2._reorder,t2._order_qty ,t2._manufacture_company
FROM item_inventories as t1 
INNER JOIN inventories AS t2 ON t1._item_id=t2.id
INNER JOIN units AS t3 ON t2._unit_id=t3.id
WHERE t1._status=1 AND t1.organization_id IN(".$_organization_id_rows.")  AND  t1._branch_id IN(".$_branch_ids_rows.") 
        AND t1._store_id IN(".$_stores_id_rows.") AND t2._category_id IN(".$category_ids_rows.")
        AND t1._item_id IN(".$_items_ids_rows.")  AND t1._cost_center_id IN(".$_cost_center_id_rows.")
         GROUP BY t1._item_id HAVING (SUM(t1._qty) <= t2._reorder)
       
        ORDER BY t2.`_item` ASC


      ");
    $group_array_values =array();
      foreach ($datas as $value) {
        $group_array_values[$value->_branch_id."__".$value->_cost_center_id."__".$value->_store_id."__".$value->_category_id][]=$value;
      }

      // foreach ($datas as $value) {
      //   $group_array_values[$value->_branch_id][$value->_cost_center_id][$value->_store_id][$value->_category_id][]=$value;
      // }

       
       

}else{
   $group_array_values = array();
}
       //return $group_array_values;
        return view('backend.inventory-report.report_shortage_item',compact('request','page_name','group_array_values','_datex','_datey','previous_filter','permited_branch','permited_costcenters','_branch_ids','_cost_center_ids','_stores','category_ids'));
    }

public function shortageItemCatItem(Request $request){
  $category_id = $request->_category_id;
  $data = Inventory::with(["_pack_size"])->whereIn('_category_id',$category_id)->get();
  return view('backend.item-category.shortage_item_cat_base_item',compact('data'));
}

public function resetShortageItem(){
  Session::flash('filter_shortage_item');
  return redirect()->back();
}


}
