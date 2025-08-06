<?php

namespace App\Http\Controllers;

use App\Models\SalesWithoutLot;
use App\Models\SalesWithoutLotDetails;
use App\Models\SalesWithoutLotAccount;
// use App\Models\Sales;
// use App\Models\SalesAccount;
// use App\Models\SalesDetail;
use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\StoreHouse;
use App\Models\PurchaseReturnFormSetting;
use App\Models\PurchaseDetail;
use App\Models\PurchaseReturnAccount;
use App\Models\PurchaseReturnDetail;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\SalesFormSetting;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Models\SalesReturnAccount;
use App\Models\SalesReturnFormSetting;
use App\Models\GeneralSettings;
use App\Models\BarcodeDetail;
use App\Models\SalesBarcode;
use App\Models\Warranty;
use App\Models\TransectionTerms;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class SalesWithoutLotController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:sales-list-wl|sales-create|sales-edit-wl|sales-delete-wl|sales-print-wl', ['only' => ['index','store']]);
         $this->middleware('permission:sales-print-wl', ['only' => ['salesPrint']]);
         $this->middleware('permission:sales-create-wl', ['only' => ['create','store']]);
         $this->middleware('permission:sales-edit-wl', ['only' => ['edit','update']]);
         $this->middleware('permission:sales-delete-wl', ['only' => ['destroy']]);
         $this->page_name = __('label.direct_sales');
    }



/*Update Date 14-7-2024*/
    /*Duplicate Coupon Check */

    public function check_coupon_duplicate(Request $request){
        $_token_number = $request->_token_number ?? '';
        $data = SalesWithoutLot::where('_token_number',$_token_number)->first();
        if(empty($data)){
            return 0;
        }else{
            return 1;
        }

    }
/*Update Date 14-7-2024*/

    public function OnlineInvoice($id){
        // $id = decrypt($id);
       
        $page_name = $this->page_name;
       
        $data =  SalesWithoutLot::with(['_master_branch','_master_details','s_account','_ledger','_terms_con'])->where('_online_inv_no',$id)->first();
        if(empty($data)){
            return "<h1 style='text-align:center;font-weight:bold;'>Thank You. Come Again Another Day.</h1>";
            die();
            exit();
        }
        $form_settings = SalesFormSetting::first();
          

         $_master_details_lot_wise = $data->_master_details ?? [];
         $_master_detail_reassign = [];
         $old_item_id_price = [];
         foreach ($_master_details_lot_wise as $key => $value) {
            $id_prince = $value->_item_id."__".$value->_sales_rate;
             if(in_array($id_prince, $old_item_id_price)){
                $_master_detail_reassign[$id_prince][]=$value;
             }else{
                $_master_detail_reassign[$id_prince][]=$value;
                array_push($old_item_id_price, $id_prince);
             }
         }

         //return $_master_detail_reassign;



         $_l_balance_update = _l_balance_update($data->_ledger_id);

         $total_sales = SalesWithoutLot::where('_ledger_id', $data->_ledger_id)
                                                        ->where('_status',1)
                                                        ->sum('_total');
 
        $history_sales_invoices = [];
        $row_conter=0;
                if($total_sales >= $_l_balance_update ){
                    //return $_l_balance_update;
                //if($_l_balance_update > 0 ){
                 //if last balance gretter then 0 then go ahead
                        $_avoid_sales_ids =[];
                        $available_quantity =  0;
                         $_qty_less = $_l_balance_update;
                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return $available_quantity;
                                 $due_sales_info = SalesWithoutLot::select('id','_date','_order_number','_total')
                                                    ->where('_ledger_id', $data->_ledger_id)
                                                    ->where('_total','>',0)
                                                    ->where('_status',1)
                                                    ->whereNotIn('id', $_avoid_sales_ids)
                                                    ->orderBy('id','DESC')
                                                    ->first();
                                if($due_sales_info){
                                      array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $available_quantity +=$due_sales_info->_total ?? 0;

                                      if($available_quantity  >= $_l_balance_update  ){
                                        $_less_qty = ($due_sales_info->_total -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                         $new_qty = $_less_qty;
                                         $due_sales_info->_due_amount = $new_qty;
                                         array_push($history_sales_invoices, $due_sales_info);
                                         
                                        }else{
                                            $due_sales_info->_due_amount = $due_sales_info->_total ?? 0;
                                            array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);
                }
         
   
          
         //return $history_sales_invoices;     
           


            return view('backend.direct-sales.online_print',compact('page_name','data','form_settings','history_sales_invoices','_master_detail_reassign'));
         
    }







    public function salesAfterReturn($id){
        $page_name = "Sales After Return";

         $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data =  SalesWithoutLot::with(['_master_branch','_master_details','s_account','_ledger','_terms_con'])->find($id);
        $form_settings = SalesFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
$store_houses = permited_stores(explode(',',$users->store_ids));
     $after_sales_return=     DB::select(" SELECT p1._date,p1._ledger_id,p1._item_id,p2._item as _item_name,p3._name as _unit_name,SUM(p1._qty) AS _qty,p1._sales_rate,SUM(p1._vat_amount) AS _vat_amount,SUM(p1._discount_amount) AS _discount_amount,SUM(p1._value) AS _value 
FROM(
SELECT s1.id,s1._date,s1._ledger_id,s2._item_id,s2._qty,s2._sales_rate,s2._value,s2._discount_amount,s2._vat_amount
FROM sales AS s1
INNER JOIN sales_details AS s2 ON s1.id=s2._no
WHERE s1.id=$id
UNION ALL
SELECT t1.id,t1._date,t1._ledger_id,t2._item_id,-t2._qty,t2._sales_rate,-(t2._value) as _value,-t2._discount_amount,-t2._vat_amount
FROM sales_returns AS t1
INNER JOIN sales_return_details AS t2 ON t1.id=t2._no
WHERE t1._order_ref_id=$id
    ) AS p1
    INNER JOIN inventories AS p2 ON p1._item_id=p2.id
    INNER JOIN units as p3 ON p2._unit_id=p3.id
    GROUP BY p1._item_id,p1._sales_rate ");

    $history_sales_invoices=[];


 $sales_returns = SalesReturn::with(['_master_details'])->where('_order_ref_id',$id)->get();
         
   
return view('backend.direct-sales.net_sales_after_return',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','sales_returns','after_sales_return','history_sales_invoices'));
        

        
    }


  

    public function categoryWiseItem(request $request){
       // return $request->all();
        $category_id = $request->_item_category;
        $brach_id = intval($request->brach_id ?? 1);
        $store_id = intval($request->store_id ?? 1);
        $limit = 20;
       
        $sub_category = ItemCategory::where('_parent_id',$category_id)
        ->select('id','_name','_parent_id','_image')
        ->get();
        if(sizeof($sub_category) > 0){
            $data['category']=$sub_category;

            $data['items']=[];

        }else{
 
            if($category_id =='All'){
                $sub_category = ItemCategory::where('_parent_id',$category_id)->get();
                $items = [];
                $data['category']=[];
                $data['items']= $items;
            }else{

                $items = DB::select(" SELECT t1._unique_barcode, t1._image, t1._category_id as _category,t2.id as _row_id,t2._item_id AS _id,t2._item,t2._unit_id AS _unit,t2._sales_rate AS _saleprice,t2._pur_rate AS _purprice,1 as _sales_vat,1 as _p_vat,t2._barcode AS _itemcode,t2._qty as available_qty,t2._sales_vat as _vat,t2._sales_discount  FROM inventories as t1 
                    INNER JOIN product_price_lists AS t2 ON t1.id=t2._item_id
                    WHERE t1._category_id=".$category_id." AND t2._qty > 0 AND t2._branch_id=".$brach_id." AND t2._store_id=".$store_id."  ");
                $data['category']=[];
                $data['items']= $items;
            }
            

        }
return json_encode( $data);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return $request->all();
        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_sales_limit', $request->limit);
        }else{
             $limit= \Session::get('_sales_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        // $datas = DB::table('sales')
        //         ->join('account_ledgers', 'account_ledgers.id', '=', 'sales._ledger_id')
        //          ->select('sales.*', 'account_ledgers._name as _ledger_name')
        //          ->where('sales._status',1);
       

      $datas = SalesWithoutLot::with(['_organization','_master_branch','_ledger'])->where('_status',1);
        //$datas = $datas->whereIn('sales._branch_id',explode(',',\Auth::user()->branch_ids));
        if($request->has('_branch_id') && $request->_branch_id !=""){
            $datas = $datas->where('_branch_id',$request->_branch_id);  
        }else{
          if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
            } 
        }
        

        if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('_date','>=', $_datex);
            $datas = $datas->whereDate('_date','<=', $_datey);
        }

        if($request->has('id') && $request->id !=""){

             $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->where('id', $ids); 
        }
        
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        if($request->has('_order_ref_id') && $request->_order_ref_id !=''){
            $datas = $datas->where('_order_ref_id','like',"%$request->_order_ref_id%");
        }
        if($request->has('track_no') && $request->track_no !=''){
            $datas = $datas->where('track_no','like',"%$request->track_no%");
        }
        if($request->has('_token_number') && $request->_token_number !=''){
           // return $request->_token_number;
            $datas = $datas->where('_token_number',$request->_token_number);
        }
        if($request->has('driver_name') && $request->driver_name !=''){
            $datas = $datas->where('driver_name','like',"%$request->driver_name%");
        }
        if($request->has('driver_mob_no') && $request->driver_mob_no !=''){
            $datas = $datas->where('driver_mob_no','like',"%$request->driver_mob_no%");
        }
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','like',"%$request->_order_number%");
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_store_salves_id') && $request->_store_salves_id !=''){
            $datas = $datas->where('_store_salves_id','=',$request->_store_salves_id);
        }
        if($request->has('_delivery_man_id') && $request->_delivery_man_id !=''){
            $datas = $datas->where('_delivery_man_id','=',$request->_delivery_man_id);
        }

        if($request->has('_period') && $request->_period !='' && $request->_period !='0'){
            $datas = $datas->where('_period','=',$request->_period);
        }

        if($request->has('_sales_man_id') && $request->_sales_man_id !=''){
            $datas = $datas->where('_sales_man_id','=',$request->_sales_man_id);
        }

        if($request->has('_sales_type') && $request->_sales_type !=''){
            $datas = $datas->where('_sales_type','=',$request->_sales_type);
        }

        if($request->has('_payment_terms') && $request->_payment_terms !=''){
            $datas = $datas->where('_payment_terms','=',$request->_payment_terms);
        }

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%$request->_referance%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%$request->_note%");
        }
        if($request->has('BillNo') && $request->BillNo !=''){
            $datas = $datas->where('BillNo','like',"%$request->BillNo%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){

            $datas = $datas->where('_user_name','like',"%$request->_user_name%");
        }
        
        if($request->has('_sub_total') && $request->_sub_total !=''){
            $datas = $datas->where('_sub_total','=',$request->_sub_total);
        }
        if($request->has('_total_discount') && $request->_total_discount !=''){
            $datas = $datas->where('_total_discount','=',$request->_total_discount);
        }
        if($request->has('_total_vat') && $request->_total_vat !=''){
            $datas = $datas->where('_total_vat','=',$request->_total_vat);
        }
        if($request->has('_total') && $request->_total !=''){
            $datas = $datas->where('_total','=',$request->_total);
        }
        if($request->has('_ledger_id') && $request->_ledger_id !='' && $request->has('_search_main_ledger_id') && $request->_search_main_ledger_id ){
            $datas = $datas->where('_ledger_id','=',$request->_ledger_id);
        }
        
     $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
           $form_settings = SalesFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = permited_stores(explode(',',$users->store_ids));
         //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();

         $transection_terms = DB::table("transection_terms")->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.direct-sales.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses','transection_terms'));
            }

            if($request->print =="detail"){
                return view('backend.direct-sales.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses','transection_terms'));
            }
         }

        return view('backend.direct-sales.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses','transection_terms'));
    }

     public function reset(){
        Session::flash('_sales_limit');
       return  \Redirect::to('sales?limit='.default_pagination());
    }


    public function invoiceWiseDetail(Request $request){
         $users = Auth::user();
        $invoice_id = $request->invoice_id;
        $key = $request->_attr_key;
         $data = SalesWithoutLot::with(['_master_details','s_account'])->where('id',$invoice_id)->first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
          $form_settings = SalesFormSetting::first();

        return view('backend.direct-sales.sales_details',compact('data','permited_branch','permited_costcenters','store_houses','key','form_settings'));

    }

      public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = SalesWithoutLot::with(['_master_branch','s_account','_ledger'])->find($id);
         $form_settings = SalesFormSetting::first();

       return view('backend.direct-sales.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data','form_settings'));
    }


    public function checkAvailableQty(Request $request){
       
    }
    public function checkAvailableQtyUpdate(Request $request){
       
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));
        //$store_houses = StoreHouse::select('id','_name')->whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = SalesFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();

        $payment_terms = TransectionTerms::where('_status',1)->get();

        // $_date= Session::get('_session_sales_date') ?? date('Y-m-d');

       return view('backend.direct-sales.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','payment_terms'));
    }

    public function formSettingAjax(){
        $form_settings = SalesFormSetting::first();
        $inv_accounts = AccountLedger::where('_status',1)->get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $cost_of_solds = $inv_accounts;
        $_cash_customers = $inv_accounts;
        return view('backend.direct-sales.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds','_cash_customers'));
    }


    public function itemSalesSearch(Request $request){
        $users = Auth::user();
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_item';
       $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        $_date = change_date_format($request->_date ?? date('Y-m-d'));

        $_master_organization_id = $request->_master_organization_id ?? 1;
        $_master_branch_id = $request->_master_branch_id ?? 1;
        $_cost_center_id = $request->_cost_center_id ?? 1;
        $_master_store_id = $request->_master_store_id ?? 1;

        //$datas = Inventory::with(['_without_lot_balance'])->where('_status',1);

        
        $datas = DB::select("   SELECT p.id, p._item as _name, p._code, p._generic_name, p._description, p._strength, p._oringin, p._item_category, p._barcode, p._category_id, p._discount, p._unit_id, p._pack_size_id, p._brand_id, p._warranty, p._vat, p._trade_price, p._mrp_price, p._reorder, p._order_qty,p._balance, p._opening_qty, p._serial, p._manufacture_company, p._status, p._is_used, p._unique_barcode, p._kitchen_item, ih._effective_date,ih._pur_rate, ih._sales_rate as _sale_rate,un._name as _unit_name,ic._name as _cat_name
FROM inventories as p
LEFT JOIN (
    SELECT ih1._item_id, ih1._effective_date, ih1._sales_rate,ih1._pur_rate, ROW_NUMBER() OVER (PARTITION BY ih1._item_id ORDER BY ih1._effective_date DESC) AS rn
    FROM item_rate_histories ih1
    JOIN (
        SELECT _item_id, MAX(_effective_date) AS max_effective_date
        FROM item_rate_histories
        WHERE _effective_date <= '".$_date."'
        GROUP BY _item_id
    ) ih2 ON ih1._item_id = ih2._item_id AND ih1._effective_date = ih2.max_effective_date
) ih ON p.id = ih._item_id AND ih.rn = 1
INNER JOIN units as un ON un.id=p._unit_id
INNER JOIN item_categories as ic ON ic.id=p._category_id
WHERE 1=1 AND p._status=1 AND  (p._code LIKE '%$text_val%' OR p._item LIKE '%$text_val%' OR p._generic_name LIKE '%$text_val%' OR p._barcode LIKE '%$text_val%')

ORDER BY p._code,p._item LIMIT 20 ");

         //    $datas = DB::select(" SELECT p.id, p._item as _name, p._code, p._generic_name, p._description, p._strength, p._oringin, p._item_category, p._barcode, p._category_id, p._discount, p._unit_id, p._pack_size_id, p._brand_id, p._warranty, p._vat, p._pur_rate, p._sale_rate, p._trade_price, p._mrp_price, p._reorder, p._order_qty,p._balance, p._opening_qty, p._serial, p._manufacture_company, p._status, p._is_used, p._unique_barcode, p._kitchen_item, un._name as _unit_name,t2._name as _cat_name
         // FROM  inventories as p
         // INNER JOIN item_categories as t2 ON t2.id=p._category_id
         // INNER JOIN units as un ON un.id=p._unit_id
         // WHERE  p._status = 1 and  (p._barcode like '%$text_val%' OR p._item like '%$text_val%' OR p._code like '%$text_val%'  )
         //  order by $asc_cloumn $_asc_desc LIMIT $limit ");

        $datas["data"]=$datas;
        return response()->json($datas);
    }


   


    


    public function Settings (Request $request){
        $data = SalesFormSetting::first();
        if(empty($data)){
            $data = new SalesFormSetting();
        }

        $_cash_ledger_ids = 0;
        $_cash_customer = $request->_cash_customer ?? [];
        if(sizeof($_cash_customer) > 0){
            $_cash_ledger_ids  =  implode(",",$_cash_customer);
        }
        
        $data->_default_inventory = $request->_default_inventory;
        $data->_default_sales = $request->_default_sales;
        $data->_default_discount = $request->_default_discount;
        $data->_default_cost_of_solds = $request->_default_cost_of_solds;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_default_vat_account = $request->_default_vat_account;
        
        $data->_default_cash_account = $request->_default_cash_account ?? 0;
        $data->_show_default_cash = $request->_show_default_cash ?? 0;

        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_show_delivery_man = $request->_show_delivery_man ?? 1;
        $data->_show_sales_man = $request->_show_sales_man ?? 1;
        $data->_show_cost_rate = $request->_show_cost_rate ?? 1;
        $data->_show_payment_terms = $request->_show_payment_terms ?? 1;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 1;
        $data->_show_expire_date = $request->_show_expire_date ?? 1;
        $data->_show_p_balance = $request->_show_p_balance ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_cash_customer = $_cash_ledger_ids ?? 0;
        $data->_show_warranty =$request->_show_warranty ?? 0;
        $data->_show_unit =$request->_show_unit ?? 0;
        $data->_defaut_customer =$request->_defaut_customer ?? 0;
        $data->_show_due_history =$request->_show_due_history ?? 0;
        $data->_is_header =$request->_is_header ?? 1;
        $data->_is_footer =$request->_is_footer ?? 1;
        $data->_margin_top =$request->_margin_top ?? "0px";
        $data->_margin_bottom =$request->_margin_bottom ?? "0px";
        $data->_margin_left =$request->_margin_left ?? "0px";
        $data->_margin_right =$request->_margin_right ?? "0px";

        if($request->hasFile('_seal_image')){ 
                $_seal_image = UserImageUpload($request->_seal_image); 
                $data->_seal_image = $_seal_image;
        }
        $data->save();


        return redirect()->back();
                       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //return dump($request->all());
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);

         
         session()->put('_session_sales_date', $request->_date);
         session()->put('_session_period', $request->_period);
    //###########################
    // Purchase Master information Save Start
    //###########################
    $SalesFormSetting = SalesFormSetting::first();
    //_cash_customer_check($_cutomer_id,$_selected_customers,$_bill_amount,$_total)
  $check_cash_customers=  _cash_customer_check($request->_main_ledger_id,$SalesFormSetting->_cash_customer,$request->_total,$request->_total_dr_amount);
  if($check_cash_customers=='no'){
     return redirect()->back()
     ->with('request',$request->all())
     ->with('error','Cash Customer Must Paid Full Amount!');
  }

        $_item_ids = $request->_item_id;
        $_barcodes = $request->_barcode ?? [];
        $_search_item_codes = $request->_search_item_code ?? [];
        $_qtys = $request->_qty;
        $_rates = $request->_rate;
        $_sales_rates = $request->_sales_rate;
        $_vats = $request->_vat;
        $_vat_amounts = $request->_vat_amount;
        $_values = $request->_value;
        $_main_branch_id_detail = $request->_main_branch_id_detail;
        $_main_cost_center = $request->_main_cost_center;
        $_store_ids = $request->_main_store_id;
        $_store_salves_ids = $request->_store_salves_id;
        $_p_p_l_ids = $request->_p_p_l_id;
        $_purchase_invoice_nos = $request->_purchase_invoice_no;
        $_purchase_detail_ids = $request->_purchase_detail_id;
        $_discounts = $request->_discount;
        $_discount_amounts = $request->_discount_amount;
        $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;
        $_warrantys = $request->_warranty;
        $organization_id = $request->organization_id ?? 1;


        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];

        $_date= $request->_date;

            $_main_branch_id = $request->_branch_id;
            $__table="sales_without_lots";
            $_pfix = _sales_pfix().make_order_number($__table,$organization_id,$_main_branch_id,$_date);
            $_order_number = $_pfix;


      // DB::beginTransaction();
      //   try {

            $_p_balance = _l_balance_update($request->_main_ledger_id);

         $_sales_man_id = $request->_sales_man_id;
         $sales_man_name_leder = $request->sales_man_name_leder;
         $_delivery_man_id = $request->_delivery_man_id;
         $delivery_man_name_leder = $request->delivery_man_name_leder;
        
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $Sales = new SalesWithoutLot();
        $Sales->_date = change_date_format($request->_date);
        $Sales->_time = date('H:i:s');
        $Sales->_period = $request->_period ?? 0;
        $Sales->_order_ref_id = $request->_order_ref_id ?? '';
        $Sales->_order_number = $_order_number ?? '';
        $Sales->track_no = $request->track_no ?? '';
        $Sales->_token_number = $request->_token_number ?? '';
        $Sales->driver_name = $request->driver_name ?? '';
        $Sales->driver_mob_no = $request->driver_mob_no ?? '';
        $Sales->_referance = $request->_referance;
        $Sales->_ledger_id = $request->_main_ledger_id;
        $Sales->_user_id = $users->id;
        $Sales->_created_by = $users->id."-".$users->name;
        $Sales->_user_id = $users->id;
        $Sales->_user_name = $users->name;
        $Sales->_note = $request->_note;
        $Sales->_payment_terms = $request->_payment_terms ?? 1;
        $Sales->_sub_total = $__sub_total;
        $Sales->_discount_input = $__discount_input;
        $Sales->_total_discount = $__total_discount;
        $Sales->_total_vat = $request->_total_vat;
        $Sales->_total =  $__total;
        $Sales->organization_id = $organization_id;
        $Sales->_branch_id = $request->_branch_id;
        $Sales->_cost_center_id = $request->_cost_center_id;
        $Sales->_address = $request->_address;
        $Sales->_phone = $request->_phone;
        $Sales->_delivery_man_id = $request->_delivery_man_id ?? 0;
        $Sales->_sales_man_id = $request->_sales_man_id ?? 0;
        $Sales->_sales_type = $request->_sales_type ?? 'sales';
        $Sales->_status = 1;
        $Sales->_lock = $request->_lock ?? 0;

        $Sales->save();
        $_master_id = $Sales->id;          


 

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        
       
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $_total_cost_value += (($_rates[$i]*$conversion_qtys[$i] ?? 1)*$_qtys[$i]);

                $_base_rate = ($_values[$i]/($_qtys[$i]*$conversion_qtys[$i] ?? 1));

  
                $SalesDetail = new SalesWithoutLotDetails();
                $SalesDetail->_item_code = $_search_item_codes[$i] ?? '';
                $SalesDetail->_item_id = $_item_ids[$i] ?? 0;
                $SalesDetail->_p_p_l_id = $_p_p_l_ids[$i] ?? 0;
                $SalesDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i] ?? 0;
                $SalesDetail->_purchase_detail_id = $_purchase_detail_ids[$i] ?? 0;
                $SalesDetail->_qty = $_qtys[$i] ?? 0;

                $SalesDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $SalesDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $SalesDetail->_base_unit = $_base_unit_ids[$i] ?? 1;
                $SalesDetail->_base_rate = $_base_rate ?? 0;
                $SalesDetail->_rate = $_rates[$i] ?? 0;

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_p_p_l_ids[$i]] ?? '';
                $SalesDetail->_barcode = $barcode_string;

                $SalesDetail->_manufacture_date = $_manufacture_dates[$i] ?? '';
                $SalesDetail->_expire_date = $_expire_dates[$i] ?? '';
                $SalesDetail->_warranty = $_warrantys[$i] ?? 0;
                $SalesDetail->_sales_rate = $_sales_rates[$i];
                $SalesDetail->_discount = $_discounts[$i] ?? 0;
                $SalesDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $SalesDetail->_vat = $_vats[$i] ?? 0;
                $SalesDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $SalesDetail->_value = $_values[$i] ?? 0;
                $SalesDetail->_store_id = $_store_ids[$i] ?? 1;
                $SalesDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $SalesDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $SalesDetail->organization_id = $organization_id;
                $SalesDetail->_branch_id = $request->_branch_id ?? 1;
                $SalesDetail->_no = $_master_id;
                $SalesDetail->_status = 1;
                $SalesDetail->_created_by = $users->id."-".$users->name;
                $SalesDetail->save();
                $_sales_details_id = $SalesDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();
                

 

                
/*
    Barcode insert into database section
*/

                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_code = $_search_item_codes[$i] ?? '';
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                 $ItemInventory->_pack_size_id =  $item_info->_pack_size_id ?? '';
                 $ItemInventory->_brand_id =  $item_info->_brand_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Direct Sales";
                $ItemInventory->_transection_ref = $_master_id;
                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;

                $ItemInventory->_qty = -($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_sales_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_rate = $_rates[$i] ?? 0;
                $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);

                // $ItemInventory->_qty = -($_qtys[$i]*$conversion_qtys[$i] ?? 1);
                // $ItemInventory->_rate = $_sales_rates[$i];
                // $ItemInventory->_cost_rate = ($_rates[$i] / $conversion_qtys[$i] ?? 1);
                // $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);
                  //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                $ItemInventory->_expire_date = $_expire_dates[$i];
                $ItemInventory->_value = $_values[$i] ?? 0;
                $ItemInventory->organization_id = $organization_id;
                $ItemInventory->_branch_id = $request->_branch_id ?? 1;
                $ItemInventory->_store_id = $request->_master_store_id ?? 1;
                $ItemInventory->_cost_center_id = $request->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 

                item_balance_without_lots($organization_id,$request->_branch_id,$request->_master_store_id,$_item_ids[$i],($_qtys[$i] * $conversion_qtys[$i] ?? 1), $item_info->_unit_id );

                inventory_stock_update($_item_ids[$i]);
            }
        }

        //###########################
        // Purchase Details information Save End
        //###########################

        //###########################
        // Purchase Account information Save End
        //###########################
        $_total_dr_amount = 0;
        $_total_cr_amount = 0;

        
        $_default_inventory = $SalesFormSetting->_default_inventory;
        $_default_sales = $SalesFormSetting->_default_sales;
        $_default_discount = $SalesFormSetting->_default_discount;
        $_default_vat_account = $SalesFormSetting->_default_vat_account;
        $_default_cost_of_solds = $SalesFormSetting->_default_cost_of_solds;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Direct Sales';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;
        
        if($__sub_total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //Default  Account Receivable DR.

            //This section Will Be Transfer to Bill Send Part
            // When Bill Will Send Then this Voucher Will Be Create 

            /*
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
           //Default Sales  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id);
            */

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3,$organization_id);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4,$organization_id);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5,$organization_id);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6,$organization_id);
             
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7,$organization_id);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8,$organization_id);
        
        }

       

        $_ledger_id = (array) $request->_ledger_id;
        $_short_narr = (array) $request->_short_narr;
        $_dr_amount = (array) $request->_dr_amount;
         $_cr_amount = (array) $request->_cr_amount;
        $_branch_id_detail = (array) $request->_branch_id_detail;
        $_cost_center = (array) $request->_cost_center;
       
        if(sizeof($_ledger_id) > 0){

                foreach($_ledger_id as $i=>$ledger) {
                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;

                        $SalesAccount = new SalesWithoutLotAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $ledger;
                        $SalesAccount->_cost_center = $_cost_center[$i] ?? 0;
                        $SalesAccount->organization_id = $organization_id;
                        $SalesAccount->_branch_id = $_branch_id_detail[$i] ?? 0;
                        $SalesAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $SalesAccount->_dr_amount = $_dr_amount[$i];
                        $SalesAccount->_cr_amount = $_cr_amount[$i];
                        $SalesAccount->_status = 1;
                        $SalesAccount->_created_by = $users->id."-".$users->name;
                        $SalesAccount->save();

                        $_sales_account_id = $SalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Direct Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='sales_without_lot_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id_detail[$i] ?? 0;
                        $_cost_center_a = $_cost_center[$i] ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i),$organization_id);
                          
                    }


                }
            
                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $SalesAccount = new SalesWithoutLotAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $request->_main_ledger_id;
                        $SalesAccount->_cost_center = $users->cost_center_ids;
                        $SalesAccount->organization_id = $organization_id;
                        $SalesAccount->_branch_id = $users->branch_ids;
                        $SalesAccount->_short_narr = 'Sales Payment';
                        $SalesAccount->_dr_amount = 0;
                        $SalesAccount->_cr_amount = $_total_dr_amount;
                        $SalesAccount->_status = 1;
                        $SalesAccount->_created_by = $users->id."-".$users->name;
                        $SalesAccount->save();

 
                        $_sales_account_id = $SalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='Sales Payment';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Direct Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='sales_without_lot_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a = $_total_dr_amount ?? 0;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20),$organization_id);
                }
            }

          $_l_balance = _l_balance_update($request->_main_ledger_id);
       


            $_online_inv_no = substr(encrypt($Sales->id),0, 30);

             \DB::table('sales_without_lots')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_online_inv_no'=>$_online_inv_no]);

               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $g_s = \DB::table('general_settings')->select('name')->first();
                $m_url = url('direct-inv')."/".$_online_inv_no;
                
                $messages = "Thank You from ".$g_s->name.".Total value: "._report_amount($request->_total)." Details:".$m_url." ";

                  sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

             $print_url=url('direct-sales/print')."/".$_master_id;
             $success_message= "Information Save successfully. <a target='__blank' style='color:red;' href='".$print_url."'><i class='fas fa-print'></i></a>";

         //  DB::commit();
            return redirect()->back()
                ->with('success',$success_message)
                ->with('_master_id',$_master_id)
                ->with('_print_value',$_print_value)
                ->with('_sales_man_id',$_sales_man_id)
                ->with('sales_man_name_leder',$sales_man_name_leder)
                ->with('_delivery_man_id',$_delivery_man_id)
                ->with('delivery_man_name_leder',$delivery_man_name_leder);
       // } catch (\Exception $e) {
       //     DB::rollback();
       //     return redirect()->back()
       //     ->with('request',$request->all())
       //     ->with('danger','There is Something Wrong !');
       //  }

       
    }


  


    public function Print($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data =  SalesWithoutLot::with(['_master_branch','_master_details','s_account','_ledger','_terms_con'])->find($id);
        $form_settings = SalesFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));
         $_master_details_lot_wise = $data->_master_details ?? [];
         $_master_detail_reassign = [];
         $old_item_id_price = [];
         foreach ($_master_details_lot_wise as $key => $value) {
            $id_prince = $value->_item_id."__".$value->_sales_rate;
             if(in_array($id_prince, $old_item_id_price)){
                $_master_detail_reassign[$id_prince][]=$value;
             }else{
                $_master_detail_reassign[$id_prince][]=$value;
                array_push($old_item_id_price, $id_prince);
             }
         }

         //return $_master_detail_reassign;



         $_l_balance_update = _l_balance_update($data->_ledger_id);

         $total_sales = SalesWithoutLot::where('_ledger_id', $data->_ledger_id)
                                                        ->where('_status',1)
                                                        ->sum('_total');
 
        $history_sales_invoices = [];
        $row_conter=0;
                if($total_sales >= $_l_balance_update ){
                    //return $_l_balance_update;
                //if($_l_balance_update > 0 ){
                 //if last balance gretter then 0 then go ahead
                        $_avoid_sales_ids =[];
                        $available_quantity =  0;
                         $_qty_less = $_l_balance_update;
                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return $available_quantity;
                                 $due_sales_info = SalesWithoutLot::select('id','_date','_order_number','_total')
                                                    ->where('_ledger_id', $data->_ledger_id)
                                                    ->where('_total','>',0)
                                                    ->where('_status',1)
                                                    ->whereNotIn('id', $_avoid_sales_ids)
                                                    ->orderBy('id','DESC')
                                                    ->first();
                                if($due_sales_info){
                                      array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $available_quantity +=$due_sales_info->_total ?? 0;

                                      if($available_quantity  >= $_l_balance_update  ){
                                        $_less_qty = ($due_sales_info->_total -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                         $new_qty = $_less_qty;
                                         $due_sales_info->_due_amount = $new_qty;
                                         array_push($history_sales_invoices, $due_sales_info);
                                         
                                        }else{
                                            $due_sales_info->_due_amount = $due_sales_info->_total ?? 0;
                                            array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);
                }
         
   
          
         //return $history_sales_invoices;     
           







         if($form_settings->_invoice_template==1){
            return view('backend.direct-sales.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.direct-sales.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==3){
            return view('backend.direct-sales.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==4){
            return view('backend.direct-sales.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==6){
            return view('backend.direct-sales.print_4',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==5){
            return view('backend.direct-sales.pos_template',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }else{
            return view('backend.direct-sales.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }
       
    }

    public function challanPrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
         $data =  SalesWithoutLot::with(['_master_branch','_master_details','s_account','_ledger'])->find($id);
        $form_settings = SalesFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));
            return view('backend.direct-sales.challan',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
     

     public function edit($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::orderBy('_name','asc')->get();
         $permited_branch = permited_branch(explode(',',$users->branch_ids));
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       $store_houses = permited_stores(explode(',',$users->store_ids));
       // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = SalesFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
          $data =  SalesWithoutLot::with(['_master_branch','_master_details','s_account','_ledger'])->where('_lock',0)->find($id);
         if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }
          $sales_number = SalesWithoutLotDetails::where('_no',$id)->count();
           $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
            $payment_terms = TransectionTerms::where('_status',1)->get();
       return view('backend.direct-sales.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','data','sales_number','_warranties','payment_terms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
   
    public function update(Request $request)
    {
         // dump($request->all());
         // exit();
        $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required',
            '_sales_id' => 'required'
        ]);
    //###########################
    // Sales Master information Save Start
    //###########################

          $SalesFormSetting = SalesFormSetting::first();
    //_cash_customer_check($_cutomer_id,$_selected_customers,$_bill_amount,$_total)
            $check_cash_customers=  _cash_customer_check($request->_main_ledger_id,$SalesFormSetting->_cash_customer,$request->_total,$request->_total_dr_amount);
            if($check_cash_customers=='no'){
            return redirect()->back()->with('error','Cash Customer Must Paid Full Amount!');
            }
            $_sales_id = $request->_sales_id;
            $_lock_check =  SalesWithoutLot::where('_lock',0)->find($_sales_id); 
            if(!$_lock_check){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }


        $_item_ids = $request->_item_id;
        //$_barcodes = $request->_barcode;
        $_qtys = $request->_qty;
        $_rates = $request->_rate;
        $_sales_rates = $request->_sales_rate;
        $_vats = $request->_vat;
        $_vat_amounts = $request->_vat_amount;
        $_values = $request->_value;
        $_main_branch_id_detail = $request->_main_branch_id_detail;
        $_main_cost_center = $request->_main_cost_center;
        $_store_ids = $request->_main_store_id;
        $_store_salves_ids = $request->_store_salves_id;
        $_p_p_l_ids = $request->_p_p_l_id;
        $_purchase_invoice_nos = $request->_purchase_invoice_no;
        $_purchase_detail_ids = $request->_purchase_detail_id;
        $_discounts = $request->_discount;
        $_discount_amounts = $request->_discount_amount;
        $_sales_detail_row_ids = $request->_sales_detail_row_id;
         $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;
        $_warrantys = $request->_warranty;
        $organization_id = $request->organization_id ?? 1;

        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];
        $_search_item_codes = $request->_search_item_code ?? [];

 //====
        // Product Price list table update with previous sales details item
        // 
        //======
$checkqty = array();
$over_qtys = array();
      

//Prevoius Return information
     $previous_sales_details = SalesWithoutLotDetails::where('_no',$_sales_id)->where('_status',1)->get();
    



           DB::beginTransaction();
           try {
        
       
       

     

    SalesWithoutLotDetails::where('_no', $_sales_id)
            ->update(['_status'=>0]);
    ItemInventory::where('_transection',"Direct Sales")
        ->where('_transection_ref',$_sales_id)
        ->update(['_status'=>0]);
    SalesWithoutLotAccount::where('_no',$_sales_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]);  
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name','sales_without_lot_accounts')
                     ->update(['_status'=>0]);  

    SalesBarcode::where('_no_id',$_sales_id)
                  ->update(['_status'=>0,'_qty'=>0]);

     $_p_balance = _l_balance_update($request->_main_ledger_id);
        
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $Sales = SalesWithoutLot::find($_sales_id);
        if(change_date_format($request->_date) != change_date_format($Sales->_date)){
            $_date= $request->_date;

            $_main_branch_id = $request->_branch_id;
            $__table="sales_without_lots";
            $_pfix = _sales_pfix().make_order_number($__table,$organization_id,$_main_branch_id,$_date);
             $_order_number = $_pfix;
             $Sales->_order_number = $_order_number ?? '';

        }

        $Sales->_date = change_date_format($request->_date);
        $Sales->_time = date('H:i:s');

         $Sales->track_no = $request->track_no ?? '';
        $Sales->_token_number = $request->_token_number ?? '';
        $Sales->driver_name = $request->driver_name ?? '';
        $Sales->driver_mob_no = $request->driver_mob_no ?? '';
         $Sales->_period = $request->_period ?? 0;


        $Sales->_payment_terms = $request->_payment_terms ?? 1;
        $Sales->_order_ref_id = $request->_order_ref_id;
        
        $Sales->_referance = $request->_referance;
        $Sales->_ledger_id = $request->_main_ledger_id;
        $Sales->_user_id = $request->_main_ledger_id;
        $Sales->_created_by = $users->id."-".$users->name;
        $Sales->_user_id = $users->id;
        $Sales->_user_name = $users->name;
        $Sales->_note = $request->_note;
        $Sales->_sub_total = $__sub_total;
        $Sales->_discount_input = $__discount_input;
        $Sales->_total_discount = $__total_discount;
        $Sales->_total_vat = $request->_total_vat;
        $Sales->_total =  $__total;
        $Sales->organization_id = $organization_id;
        $Sales->_branch_id = $request->_branch_id;
        $Sales->_cost_center_id = $request->_cost_center_id ?? 1;
        $Sales->_address = $request->_address;
        $Sales->_phone = $request->_phone;
        $Sales->_delivery_man_id = $request->_delivery_man_id ?? 0;
        $Sales->_sales_man_id = $request->_sales_man_id ?? 0;
        $Sales->_sales_type = $request->_sales_type ?? 'sales';
        $Sales->_status = 1;
        $Sales->_lock = $request->_lock ?? 0;
        $Sales->save();
        $_master_id = $Sales->id;
                                           

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
       



        

       
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $_total_cost_value += (($_rates[$i]*$conversion_qtys[$i] ?? 1)*$_qtys[$i]);
                if($_sales_detail_row_ids[$i] ==0){
                        $SalesDetail = new SalesWithoutLotDetails();
                }else{
                    $SalesDetail = SalesWithoutLotDetails::find($_sales_detail_row_ids[$i]);
                }


                $_base_rate = ($_values[$i]/($_qtys[$i]*$conversion_qtys[$i] ?? 1));
                $SalesDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $SalesDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $SalesDetail->_base_unit = $_base_unit_ids[$i] ?? 1;
                $SalesDetail->_base_rate = $_base_rate;

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $SalesDetail->_barcode = $barcode_string;
                $SalesDetail->_warranty = $_warrantys[$i] ?? 0;
                
                $SalesDetail->_item_id = $_item_ids[$i];
                $SalesDetail->_item_code = $_search_item_codes[$i] ?? '';
                $SalesDetail->_p_p_l_id = $_p_p_l_ids[$i];
                $SalesDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $SalesDetail->_purchase_detail_id = $_purchase_detail_ids[$i];
                $SalesDetail->_qty = $_qtys[$i];




                $SalesDetail->_rate = $_rates[$i];
                $SalesDetail->_sales_rate = $_sales_rates[$i];
                $SalesDetail->_discount = $_discounts[$i] ?? 0;
                $SalesDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $SalesDetail->_vat = $_vats[$i] ?? 0;
                $SalesDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $SalesDetail->_value = $_values[$i] ?? 0;
                $SalesDetail->_manufacture_date = $_manufacture_dates[$i];
                $SalesDetail->_expire_date = $_expire_dates[$i];
                $SalesDetail->_store_id = $request->_master_store_id ?? 1;
                $SalesDetail->_cost_center_id = $request->_cost_center_id ?? 1;
                $SalesDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $SalesDetail->organization_id = $organization_id ?? 1;
                $SalesDetail->_branch_id = $request->_branch_id ?? 1;
                $SalesDetail->_no = $_master_id;
                $SalesDetail->_status = 1;
                $SalesDetail->_created_by = $users->id."-".$users->name;
                $SalesDetail->save();
                $_sales_details_id = $SalesDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();

               



                
/*
    Barcode insert into database section


*/




                $ItemInventory = ItemInventory::where('_transection',"Direct Sales")
                                    ->where('_transection_ref',$_sales_id)
                                    ->where('_transection_detail_ref_id',$_sales_details_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                } 
                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_item_code = $_search_item_codes[$i] ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                 $ItemInventory->_pack_size_id =  $item_info->_pack_size_id ?? '';
                 $ItemInventory->_brand_id =  $item_info->_brand_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Direct Sales";
                $ItemInventory->_transection_ref = $_master_id;
                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;

                $ItemInventory->_qty = -($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_sales_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_rate = $_rates[$i];
                $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);

                //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                
                $ItemInventory->_value = $_values[$i] ?? 0;

                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                $ItemInventory->_expire_date = $_expire_dates[$i];
                $ItemInventory->organization_id = $organization_id;
                $ItemInventory->_branch_id = $request->_branch_id ?? 1;
                $ItemInventory->_store_id = $request->_master_store_id ?? 1;
                $ItemInventory->_cost_center_id = $request->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_updated_by = $users->id."-".$users->name;
                $ItemInventory->save(); 

                item_balance_without_lots($organization_id,$request->_branch_id,$request->_master_store_id,$_item_ids[$i],($_qtys[$i] * $conversion_qtys[$i] ?? 1), $item_info->_unit_id );

                inventory_stock_update($_item_ids[$i]);
            }
        }

        //###########################
        // Purchase Details information Save End
        //###########################

        //###########################
        // Purchase Account information Save End
        //###########################
        $_total_dr_amount = 0;
        $_total_cr_amount = 0;

        
        $_default_inventory = $SalesFormSetting->_default_inventory;
        $_default_sales = $SalesFormSetting->_default_sales;
        $_default_discount = $SalesFormSetting->_default_discount;
        $_default_vat_account = $SalesFormSetting->_default_vat_account;
        $_default_cost_of_solds = $SalesFormSetting->_default_cost_of_solds;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Direct Sales';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;

      
        
         if($__sub_total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //This section Will Be Transfer to Bill Send Part
            // When Bill Will Send Then this Voucher Will Be Create

/*

            //Default Sales DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
           //Default Account Receivable  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id);


*/

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3,$organization_id);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4,$organization_id);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5,$organization_id);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6,$organization_id);
             
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7,$organization_id);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8,$organization_id);
        
        }

       

        $_ledger_id = (array) $request->_ledger_id;
        $_short_narr = (array) $request->_short_narr;
        $_dr_amount = (array) $request->_dr_amount;
         $_cr_amount = (array) $request->_cr_amount;
        $_branch_id_detail = (array) $request->_branch_id_detail;
        $_cost_center = (array) $request->_cost_center;
        $purchase_account_ids =  $request->purchase_account_id;
       
        if(sizeof($_ledger_id) > 0){
                foreach($_ledger_id as $i=>$ledger) {
                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;
                        $SalesAccount = SalesWithoutLotAccount::where('id',$purchase_account_ids[$i] ?? 0)
                                                            ->where('_ledger_id',$ledger)
                                                            ->first();
                        if(empty($PurchaseAccount)){
                             $SalesAccount = new SalesWithoutLotAccount();
                        }
                       
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $ledger;
                        $SalesAccount->_cost_center = $_cost_center[$i] ?? 0;
                        $SalesAccount->organization_id = $organization_id;
                        $SalesAccount->_branch_id = $_branch_id_detail[$i] ?? 0;
                        $SalesAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $SalesAccount->_dr_amount = $_dr_amount[$i];
                        $SalesAccount->_cr_amount = $_cr_amount[$i];
                        $SalesAccount->_status = 1;
                        $SalesAccount->_created_by = $users->id."-".$users->name;
                        $SalesAccount->save();

                        $_sales_account_id = $SalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Direct Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='sales_without_lot_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id_detail[$i] ?? 0;
                        $_cost_center_a = $_cost_center[$i] ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i),$organization_id);
                          
                    }
                }

                 
                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $SalesAccount = new SalesWithoutLotAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $request->_main_ledger_id;
                        $SalesAccount->_cost_center = $users->cost_center_ids;
                        $SalesAccount->organization_id = $organization_id;
                        $SalesAccount->_branch_id = $users->branch_ids;
                        $SalesAccount->_short_narr = 'N/A';
                        $SalesAccount->_dr_amount = 0;
                        $SalesAccount->_cr_amount = $_total_dr_amount;
                        $SalesAccount->_status = 1;
                        $SalesAccount->_created_by = $users->id."-".$users->name;
                        $SalesAccount->save();

                        $_sales_account_id = $SalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Direct Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='sales_without_lot_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a = $_total_dr_amount ?? 0;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20),$organization_id);
                }
            }

 
             $_l_balance = _l_balance_update($request->_main_ledger_id);
            //  $_pfix = _sales_pfix().$_master_id;

            
              //SMS SEND to Customer and Supplier
            $_online_inv_no = substr(encrypt($_master_id),0, 30);

             \DB::table('sales_without_lots')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_online_inv_no'=>$_online_inv_no]);

               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';

             if($_send_sms=='yes'){
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Thank You from ".$g_s->name.".Total value: "._report_amount($request->_total)." Details:".$m_url." ";
                  sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

          DB::commit();
          if(($request->_lock ?? 0) ==1){
                return redirect('direct-sales/print/'.$_master_id)
                ->with('success','Information save successfully');
          }else{
            return redirect()
                ->back()
                ->with('success','Information save successfully')
                ->with('_master_id',$_master_id)
                ->with('_print_value',$_print_value);
          }
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger','There is Something Wrong !');
        }

       
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        return redirect()->back()->with('danger','You Can not delete this Information');

    }
}
