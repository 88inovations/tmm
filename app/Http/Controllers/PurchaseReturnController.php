<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Purchase;
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
use App\Models\SalesDetail;
use App\Models\BarcodeDetail;
use App\Models\PurchaseReturnBarcode;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class PurchaseReturnController extends Controller
{

      function __construct()
    {
         $this->middleware('permission:purchase-return-list|purchase-return-create|purchase-return-edit|purchase-return-delete|purchase-return-print', ['only' => ['index','store']]);
         $this->middleware('permission:purchase-return-print', ['only' => ['purchase-returnPrint']]);
         $this->middleware('permission:purchase-return-create', ['only' => ['create','store']]);
         $this->middleware('permission:purchase-return-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:purchase-return-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.material_return');
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
            session()->put('_pur_return_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_return_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = PurchaseReturn::with(['_master_branch','_master_details','purchase_account','_ledger']);
        $datas = $datas->whereIn('_branch_id',explode(',',\Auth::user()->branch_ids));
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
            $datas = $datas->whereIn('id', $ids); 
        }
        
        if($request->has('_order_ref_id') && $request->_order_ref_id !=''){
            $datas = $datas->where('_order_ref_id',$request->_order_ref_id);
        }

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%trim($request->_referance)%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%trim($request->_note)%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%trim($request->_user_name)%");
        }
        if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        
        if($request->has('_sub_total') && $request->_sub_total !=''){
            $datas = $datas->where('_sub_total','=',trim($request->_sub_total));
        }
        if($request->has('_total_discount') && $request->_total_discount !=''){
            $datas = $datas->where('_total_discount','=',trim($request->_total_discount));
        }
        if($request->has('_total_vat') && $request->_total_vat !=''){
            $datas = $datas->where('_total_vat','=',trim($request->_total_vat));
        }
        if($request->has('_total') && $request->_total !=''){
            $datas = $datas->where('_total','=',trim($request->_total));
        }
        if($request->has('_ledger_id') && $request->_ledger_id !='' && $request->has('_search_main_ledger_id') && $request->_search_main_ledger_id ){
            $datas = $datas->where('_ledger_id','=',trim($request->_ledger_id));
        }
        
        $datas = $datas->where('_status',1)->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
           $form_settings = PurchaseReturnFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.purchase-return.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.purchase-return.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.purchase-return.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }

     public function reset(){
        Session::flash('_pur_return_limit');
       return  \Redirect::to('purchase-return?limit='.default_pagination());
    }

    public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = PurchaseReturn::with(['_master_branch','purchase_account','_ledger'])->find($id);

       return view('backend.purchase-return.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data'));
    }

    public function purchaseOrderSearch(Request $request){
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_date';
        $text_val = trim($request->_text_val);
        $datas = Purchase::with(['_ledger','_purchase_order_display'])
                ->where('_status',1);
          if($request->has('_text_val') && $request->_text_val !=''){
            $datas = $datas->where('_order_number','like',"%$request->_text_val%")
            ->orWhere('_order_ref_id','like',"%$request->_text_val%")
            ->orWhere('id','like',"%$request->_text_val%");
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }

    public function purchaseOrderDetails(Request $request){
        //return $request->all();
        $this->validate($request, [
            '_purchase_main_id' => 'required',
        ]);
        $_purchase_main_id = $request->_purchase_main_id;

       $datas = ProductPriceList::with(['_detail_branch','_detail_cost_center','_store','unit_conversion','_units','_trans_unit','_items'])
                                ->where('_master_id',$_purchase_main_id)
                                ->where('_qty','>',0)
                                ->where('_status',1)
                                ->get();

        
        return json_encode( $datas);
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
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
       // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));
        $form_settings = PurchaseReturnFormSetting::first();
        $inv_accounts = AccountLedger::get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $vat_accounts = $inv_accounts;
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();

       return view('backend.purchase-return.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units'));
    }


    public function purchaseSettings(Request $request){
        $data = PurchaseReturnFormSetting::first();
        if(empty($data)){
            $data = new PurchaseReturnFormSetting();
        }
        $data->_default_inventory = $request->_default_inventory;
        $data->_default_purchase = $request->_default_purchase;
        $data->_default_discount = $request->_default_discount;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_unit = $request->_show_unit ?? 0;
        $data->_show_vat = $request->_show_vat;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_show_p_balance = $request->_show_p_balance;
         $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->save();

       return redirect()->back()->with('success','Information Save successfully');
                       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
     // return dump($request->all());
         $all_req= $request->all();
        $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_order_ref_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);
        $_item_ids = $request->_item_id;
        $_barcodes = $request->_barcode;
        $_qtys = $request->_qty;
        $_rates = $request->_rate;
        $_sales_rates = $request->_sales_rate;
        $_vats = $request->_vat;
        $_vat_amounts = $request->_vat_amount;
        $_values = $request->_value;
        $_main_branch_id_detail = $request->_main_branch_id_detail;
        $_main_cost_center = $request->_main_cost_center;
         $_store_ids = $request->_main_store_id ?? [];
        $_store_salves_ids = $request->_store_salves_id;
        $_purchase_detal_refs = $request->_purchase_detal_ref;
        $_price_list_ids = $request->_price_list_id;
        $_ref_counters = $request->_ref_counter;
        $organization_id = $request->organization_id ?? 1;
        $_master_branch_id = $request->_branch_id ?? 1;


        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];


        $over_qty =array();
        if(sizeof($_price_list_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                  $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $check_unique_bar =  Inventory::select('_unique_barcode')->where('id',$_item_ids[$i])->first();
                if($check_unique_bar->_unique_barcode==1 ){
                    if($barcode_string !=""){
                            $_barcods_arr = explode(",",$barcode_string);
                            if(sizeof($_barcods_arr) > 0){
                                 $_qty = (sizeof($_barcods_arr) <= 1) ? $_qtys[$i] : 1;
                                foreach ($_barcods_arr as $_barcods_arr_val) {
                                     $checkqty = DB::select(" SELECT t1._qty FROM `product_price_lists` AS t1
                                    INNER JOIN barcode_details as t2 ON t1.id=t2._p_p_id
                                    WHERE t2._barcode='".$_barcods_arr_val."' AND t1._qty >=".$_qty." AND t1.id=".$_price_list_ids[$i]." ");
                                     
                                    if(empty($checkqty)){
                                        array_push($over_qty, 1);
                                    }
                                }
                            }
                         }

                }else{
                    $converted_qty = ($_qtys[$i] * $conversion_qtys[$i]);
                    $checkqty = DB::select(" SELECT t1._qty FROM `product_price_lists` AS t1
                                    WHERE (t1._qty) >=".$converted_qty." AND t1.id=".$_price_list_ids[$i]." ");

                    // $checkqty = ProductPriceList::where('_qty','>=',$_qtys[$i])
                    //                 ->where('id',$_price_list_ids[$i])->first();
                        if(empty($checkqty)){
                            array_push($over_qty, 1);
                        }
                 }
                
               
            }
        }
        if(sizeof($over_qty) > 0){
            return redirect()->back()->with('danger','You can not return more then available qty !');
        }


    DB::beginTransaction();
    try {
       
       $_p_balance = _l_balance_update($request->_main_ledger_id);
    //###########################
    // Purchase Master information Save Start
    //###########################
       $_print_value = $request->_print ?? 0;

            //$_pfix = _purchase_return_pfix().$purchase_id;
       /*Make Order Number*/
            $_main_branch_id = $request->_branch_id;
            $__table="purchase_returns";
            $_date = $request->_date;
            $_order_number = make_order_number($__table,$organization_id,$_main_branch_id,$_date);

    /*Make Order Number*/
         $users = Auth::user();
        $PurchaseReturn = new PurchaseReturn();
        $PurchaseReturn->_date = change_date_format($request->_date);
        $PurchaseReturn->_time = date('H:i:s');
        $PurchaseReturn->_order_ref_id = $request->_order_ref_id;
        $PurchaseReturn->_referance = $request->_referance;
        $PurchaseReturn->_order_number = $_order_number ?? '';
        $PurchaseReturn->_ledger_id = $request->_main_ledger_id;
        $PurchaseReturn->_user_id = $users->id;
        $PurchaseReturn->_created_by = $users->id."-".$users->name;
        $PurchaseReturn->_user_id = $users->id;
        $PurchaseReturn->_user_name = $users->name;
        $PurchaseReturn->_note = $request->_note;
        $PurchaseReturn->_sub_total = $request->_sub_total;
        $PurchaseReturn->_discount_input = $request->_discount_input;
        $PurchaseReturn->_total_discount = $request->_total_discount;
        $PurchaseReturn->_total_vat = $request->_total_vat;
        $PurchaseReturn->_total = $request->_total;
        $PurchaseReturn->organization_id = $organization_id;
        $PurchaseReturn->_branch_id = $request->_branch_id;
        $PurchaseReturn->_cost_center_id = $request->_cost_center_id;
        $PurchaseReturn->_status = 1;
         $PurchaseReturn->_lock = $request->_lock ?? 0;
        $PurchaseReturn->save();
        $purchase_id = $PurchaseReturn->id;

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        
        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                if($_qtys[$i] > 0){
                    $PurchaseReturnDetail = new PurchaseReturnDetail();
                    $PurchaseReturnDetail->_item_id = $_item_ids[$i];
                    $PurchaseReturnDetail->_qty = $_qtys[$i];

                    $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                    $PurchaseReturnDetail->_barcode = $barcode_string;

                    $PurchaseReturnDetail->_rate = $_rates[$i];
                    $PurchaseReturnDetail->_sales_rate = $_sales_rates[$i];

                    $PurchaseReturnDetail->_transection_unit = $_transection_units[$i] ?? 1;
                    $PurchaseReturnDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                    $PurchaseReturnDetail->_base_unit = $_base_unit_ids[$i] ?? 1;

                    $PurchaseReturnDetail->_discount = $_discounts[$i] ?? 0;
                    $PurchaseReturnDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                    $PurchaseReturnDetail->_vat = $_vats[$i] ?? 0;
                    $PurchaseReturnDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                    $PurchaseReturnDetail->_value = $_values[$i] ?? 0;
                    $PurchaseReturnDetail->_store_id = $_store_ids[$i] ?? 1;
                    $PurchaseReturnDetail->_cost_center_id = $_cost_center_id ?? 1;
                    $PurchaseReturnDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                    $PurchaseReturnDetail->organization_id = $organization_id ?? 1;
                    $PurchaseReturnDetail->_branch_id = $branch_id ?? 1;
                    $PurchaseReturnDetail->_no = $purchase_id;
                    $PurchaseReturnDetail->_purchase_ref_id = $request->_order_ref_id;
                    $PurchaseReturnDetail->_purchase_detal_ref = $_purchase_detal_refs[$i];
                    $PurchaseReturnDetail->_status = 1;
                    $PurchaseReturnDetail->_created_by = $users->id."-".$users->name;
                    $PurchaseReturnDetail->save();
                    $_purchase_detail_id = $PurchaseReturnDetail->id;

                    $item_info = Inventory::where('id',$_item_ids[$i])->first();
                        $_unique_barcode = $item_info->_unique_barcode ?? 0;
                        
                        $ProductPriceList = ProductPriceList::find($_price_list_ids[$i]);
                        $_p_qty = $ProductPriceList->_qty;
                       
                        //Barcode  deduction from old string data
                    if($_unique_barcode ==1){
                         $_old_barcode_strings =  $ProductPriceList->_barcode;
                        
                        $_new_barcode_array = array();
                        if($_old_barcode_strings !=""){
                            $_old_barcode_array = explode(",",$_old_barcode_strings);
                        }
                        if($barcode_string !=""){
                            $_new_barcode_array = explode(",",$barcode_string);
                        }
                        if(sizeof($_new_barcode_array) > 0 && sizeof($_old_barcode_array) > 0){
                          $_last_barcode_array =  array_diff($_old_barcode_array,$_new_barcode_array);
                          if(sizeof($_last_barcode_array ) > 0){
                            $_last_barcode_string = implode(",",$_last_barcode_array);
                          }else{
                            $_last_barcode_string = $barcode_string;
                          }
                          
                          $ProductPriceList->_barcode = $_last_barcode_string;
                        }

                    }

                        //Barcode  deduction from old string data
                       
                        $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                       
                        $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
                        $ProductPriceList->_status = $_status;
                        $ProductPriceList->save();
                        $product_price_id =  $ProductPriceList->id;

                        /*
                            Barcode insert into database section
                           _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
                           IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
                                        [  $data->_no_id = $_no_id;
                                            $data->_no_detail_id = $_no_detail_id;
                                            ] use  $p=1;
                        */
                                    if($_unique_barcode ==1){
                                         
                                         if($barcode_string !=""){
                                           $barcode_array=  explode(",",$barcode_string);
                                           $_qty = 1;
                                           $_stat = 1;
                                           $_return=1;
                                           
                                           foreach ($barcode_array as $_b_v) {
                                            _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,1);
                                            _barcode_insert_update('PurchaseReturnBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,0,0);
                                             
                                           }
                                        }
                                    }else{
                            $_qty = $_qtys[$i] ?? 0;
                            $_stat = 1;
                            $_return=1;
                            $_b_v=$ProductPriceList->_barcode ?? '';

                                _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,1);
                                _barcode_insert_update('PurchaseReturnBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,0);
                            }

                                    /*
                                Barcode insert into database section
                            */


                                            $ItemInventory = new ItemInventory();
                                            $ItemInventory->_item_id =  $_item_ids[$i];
                                            $ItemInventory->_item_name =  $item_info->_item ?? '';
                                            $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                                            $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                                            $ItemInventory->_date = change_date_format($request->_date);
                                            $ItemInventory->_time = date('H:i:s');
                                            $ItemInventory->_transection = "Purchase Return";
                                            $ItemInventory->_transection_ref = $purchase_id;

                                            $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;
                                            $ItemInventory->_qty = -($_qtys[$i] *$conversion_qtys[$i] ?? 1);
                                            $ItemInventory->_rate = $_sales_rates[$i] ?? 0;
                                            $ItemInventory->_cost_rate = ($_rates[$i]/$conversion_qtys[$i] ?? 1);

                                             //Unit Conversion section
                                            $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                                            $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                                            $ItemInventory->_base_unit = $_base_unit_ids[$i] ?? 1;
                                            $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                                            
                                            $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);
                                            $ItemInventory->_value = -($_values[$i] ?? 0);
                                            $ItemInventory->organization_id = $organization_id ?? 1;
                                            $ItemInventory->_branch_id = $branch_id ?? 1;
                                            $ItemInventory->_store_id = $_store_ids[$i] ?? 1;
                                            $ItemInventory->_cost_center_id = $_cost_center_id ?? 1;
                                            $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                                            $ItemInventory->_status = 1;
                                            $ItemInventory->_created_by = $users->id."-".$users->name;
                                            $ItemInventory->save(); 

                                            inventory_stock_update($_item_ids[$i]);

                }
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

         $PurchaseReturnFormSetting = PurchaseReturnFormSetting::first();
        $_default_inventory = $PurchaseReturnFormSetting->_default_inventory;
        $_default_purchase = $PurchaseReturnFormSetting->_default_purchase;
        $_default_discount = $PurchaseReturnFormSetting->_default_discount;
        $_default_vat_account = $PurchaseReturnFormSetting->_default_vat_account;

        $_ref_master_id=$purchase_id;
        $_ref_detail_id=$purchase_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Purchase Return';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;
        if($request->_sub_total > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id,1);
            //Default Purchase Return
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,0,$request->_sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id,1);
        

            //Default Purchase Return
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,$request->_sub_total,0,$_branch_id,$_cost_center,$_name,3,$organization_id,2);
        //Default Inventory
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$request->_sub_total,$_branch_id,$_cost_center,$_name,4,$organization_id,2);
        }

        if($request->_total_discount > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_discount,$_cr_amount=0,$_branch_id,$_cost_center,$_name,5,$organization_id,3);
             //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,0,$request->_total_discount,$_branch_id,$_cost_center,$_name,6,$organization_id,3);
        
        }
        if($request->_total_vat > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,$_cr_amount=0,$_branch_id,$_cost_center,$_name,7,$organization_id,4);
        //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,$_dr_amount=0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8,$organization_id,4);
        
        }

        // ############################
        //  Purchase Account         Dr 
        //      Account Payable     Cr
        //
        //  Inventory Account       Dr
        //     Purchase Account     Cr
        //
        //  Account Payable         Dr
        //    Purchase Discount   Cr
        //
        //  Vat Account          Dr
        //     Account Payable   Cr
        //##################################

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

                        $PurchaseReturnAccount = new PurchaseReturnAccount();
                        $PurchaseReturnAccount->_no = $purchase_id;
                        $PurchaseReturnAccount->_account_type_id = $_account_type_id;
                        $PurchaseReturnAccount->_account_group_id = $_account_group_id;
                        $PurchaseReturnAccount->_ledger_id = $ledger;
                        $PurchaseReturnAccount->_cost_center = $_cost_center_id ?? 0;
                        $PurchaseReturnAccount->organization_id = $organization_id;
                        $PurchaseReturnAccount->_branch_id = $_branch_id ?? 0;
                        $PurchaseReturnAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $PurchaseReturnAccount->_dr_amount = $_dr_amount[$i];
                        $PurchaseReturnAccount->_cr_amount = $_cr_amount[$i];
                        $PurchaseReturnAccount->_status = 1;
                        $PurchaseReturnAccount->_created_by = $users->id."-".$users->name;
                        $PurchaseReturnAccount->save();

                        $purchase_detail_id = $PurchaseReturnAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$purchase_detail_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Purchase Return';
                        $_date = change_date_format($request->_date);
                        $_table_name ='purchase_return_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id ?? 0;
                        $_cost_center_a = $_cost_center_id ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i),$organization_id,5);
                          
                    }
                }

                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $PurchaseReturnAccount = new PurchaseReturnAccount();
                        $PurchaseReturnAccount->_no = $purchase_id;
                        $PurchaseReturnAccount->_account_type_id = $_account_type_id;
                        $PurchaseReturnAccount->_account_group_id = $_account_group_id;
                        $PurchaseReturnAccount->_ledger_id = $request->_main_ledger_id;
                        $PurchaseReturnAccount->_cost_center = $users->cost_center_ids;
                        $PurchaseReturnAccount->organization_id = $organization_id;
                        $PurchaseReturnAccount->_branch_id = $users->branch_ids;
                        $PurchaseReturnAccount->_short_narr = 'Payment';
                        $PurchaseReturnAccount->_dr_amount = 0;
                        $PurchaseReturnAccount->_cr_amount = $_total_dr_amount;
                        $PurchaseReturnAccount->_status = 1;
                        $PurchaseReturnAccount->_created_by = $users->id."-".$users->name;
                        $PurchaseReturnAccount->save();

 
                        $_sales_account_id = $PurchaseReturnAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='Payment';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                         $_transaction= 'Purchase Return';
                        $_date = change_date_format($request->_date);
                        $_table_name ='purchase_return_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a =  $_total_dr_amount;
                        $_branch_id_a = $request->_branch_id ?? 1;
                        $_cost_center_a = $request->_cost_center_id ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20),$organization_id,6);
                }
            }
       
$_l_balance = _l_balance_update($request->_main_ledger_id);


             \DB::table('purchase_returns')
             ->where('id',$purchase_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance]);
             $success_message = $_order_number.'|| Information save successfully';
        DB::commit();
            return redirect()->back()
            ->with('success',$success_message)
            ->with('_master_id',$purchase_id)
            ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           
           return redirect()->back()->with('danger',"Information Not Save. There Is an ERROR ");
        }
      
    }


  


    public function purchasePrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
         $data =  PurchaseReturn::with(['_master_branch','_master_details','purchase_account','_ledger'])->find($id);
        $form_settings = PurchaseReturnFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();

         if($form_settings->_invoice_template==1){
            return view('backend.purchase-return.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.purchase-return.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==3){
           return view('backend.purchase-return.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==4){
          return view('backend.purchase-return.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }else{
            return view('backend.purchase-return.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }


       
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
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         $store_houses = permited_stores(explode(',',$users->store_ids));

        $form_settings = PurchaseReturnFormSetting::first();
        $inv_accounts = AccountLedger::get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $vat_accounts = $inv_accounts;
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
       $data =  PurchaseReturn::with(['_master_branch','_master_details','purchase_account','_ledger'])->where('_lock',0)->find($id);
        
     if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }
          $sales_number = SalesDetail::where('_purchase_invoice_no',$id)->count();
       return view('backend.purchase-return.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','data','sales_number'));
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
         
    //  return dump($request->all());
         $all_req= $request->all();
        $this->validate($request, [
            '_order_number' => 'required',
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_form_name' => 'required',
        ]);

        $purchase_id = $request->_purchase_return_id;
        $organization_id = $request->organization_id;
        $_branch_id = $request->_branch_id;
        $_cost_center_id = $request->_cost_center_id;

        $_item_ids = $request->_item_id;
        $_barcodes = $request->_barcode;
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
        $purchase_detail_ids = $request->purchase_detail_id;
         $_price_list_ids = $request->_price_list_id;
         $_purchase_detal_refs = $request->_purchase_detal_ref;
         $_ref_counters = $request->_ref_counter;

        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];

        $checkqty = array();
        $over_qtys = array();

        $_lock_check =  PurchaseReturn::where('_lock',0)->find($purchase_id); 
        if(!$_lock_check){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }

    //Prevoius Return information
     $previous_infos = PurchaseReturnDetail::where('_no',$purchase_id)->where('_status',1)->get();
    foreach ($previous_infos as $value) {
         $product_prices = ProductPriceList::where('_purchase_detail_id',$value->_purchase_detal_ref)->first();
         $new_qty = (($value->_qty*$value->_unit_conversion)+$product_prices->_qty);
         $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
         $_unique_barcode = $product_prices->_unique_barcode;
         array_push($checkqty, ['id'=>$product_prices->_purchase_detail_id,'_qty'=>$new_qty,'_barcode'=>$_old_new_barcode,'_unique_barcode'=>$_unique_barcode]);
    }

    foreach ($_purchase_detal_refs as $item_key=> $_item) {
        foreach ($checkqty as $check_item) {
              $barcode_string=$all_req[$_ref_counters[$item_key]."__barcode__".$_item_ids[$item_key]] ?? '';
if($check_item["_unique_barcode"] ==1){
    if(strlen($barcode_string) > 0){ //Check Barcode Available
                if($_item==$check_item["id"]){ //Check Previous item id and Current Item id Same
                    $_req_barcode_array = explode(",",$barcode_string); // Barcode make array from string
                    foreach ($_req_barcode_array as $_bar_value) {
                        $_barcode_yes = str_contains($check_item["_barcode"], $_bar_value); //Check available barcode number with product price list table and previous purchase return details table
                        if(!$_barcode_yes){
                           // if Return false then its wrong barcode and send message
                            $msg = "You Input Wrong Barcode. Wrong Barcode Numer is- ". $_bar_value;
                            return redirect()->back()->with('danger',$msg);
                        }else{
                            //this section come after check available 
                          $check_model_or_unique =   explode(",",$check_item["_barcode"]); //Barcode string to array to check model barcode or unique barcode

                          if(sizeof(array_unique($check_model_or_unique)) ==1){ // if sizeof($check_model_or_unique)==1 then we desied that its used a model barcode 
                           
                              //Model Barcode and now check quantity
                                if($_item==$check_item["id"] && ( $_qtys[$item_key] * $conversion_qtys[$item_key] ) > $check_item["_qty"] ){
                                    array_push($over_qtys, $_item); //if use model barcode and want to return more then purchase quantity then show a messge
                                 }
                          }
                           //Unique Barcode Olready Check as wrong Barcode number

                          
                        }
                       
                    }
                }
            }
        } else{
    //return ( $_qtys[$item_key] * $conversion_qtys[$item_key] );
                 //This section come when no barcode used for item purchase and purchase return
                //Here we need to check item id and item available qty
                if($_item==$check_item["id"] && ( $_qtys[$item_key] * $conversion_qtys[$item_key] ) > $check_item["_qty"] ){
                    array_push($over_qtys, $_item); //If input Extra qty then shw a messge
                }
            }
            
        }
    }

    if(sizeof($over_qtys) > 0){
        return redirect()->back()->with('danger','You Can not Return More then available Qty !');
    }else{
         foreach ($previous_infos as $value) {

            $product_prices = ProductPriceList::where('_purchase_detail_id',$value->_purchase_detal_ref)->first();
              $new_qty = (($value->_qty*$value->_unit_conversion)+$product_prices->_qty);
             $_unique_barcode = $product_prices->_unique_barcode;
             $_up_status = (($new_qty) > 0) ? 1 : 0;
             $product_prices->_qty =$new_qty;
            if($_unique_barcode ==1){
                $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
                $product_prices->_barcode =$_old_new_barcode;
                $product_prices->_qty =$new_qty;
                if($_old_new_barcode !=""){
                    $_unique_old_newbarcode_array =   explode(",",$_old_new_barcode);
                    if(sizeof($_unique_old_newbarcode_array) > 0){
                        foreach ($_unique_old_newbarcode_array as $_bar_value) {
                                BarcodeDetail::where('_p_p_id',$product_prices->id)
                                            ->where('_item_id',$product_prices->_item_id)
                                            ->where('_no_detail_id',$value->_purchase_detal_ref)
                                            ->where('_barcode',$_bar_value)
                                            ->update(['_qty'=>1,'_status'=>1]);
                            }
                    }
                }
                
             }
             
             
             $product_prices->save();

             //return $product_prices;

        }
    }
    

       //######################
       // Previous information need to make zero for every thing.
       //#####################


     
     
   
    PurchaseReturnDetail::where('_no', $purchase_id)
            ->update(['_status'=>0]);
    ItemInventory::where('_transection',"Purchase Return")
        ->where('_transection_ref',$purchase_id)
        ->update(['_status'=>0]);
    PurchaseReturnAccount::where('_no',$purchase_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$purchase_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]); 
    Accounts::where('_ref_master_id',$purchase_id)
                    ->where('_table_name','purchase_return_accounts')
                     ->update(['_status'=>0]);  
    $_p_balance = _l_balance_update($request->_main_ledger_id); 
        
    _barcode_status("PurchaseReturnBarcode",$purchase_id); //Status Change to Zero before row update
     

      //  return 6;           

    //###########################
    // Purchase Return Master information Save Start
    //###########################
       $_print_value = $request->_print ?? 0;
       $users = Auth::user();
       $organization_id = $request->organization_id;
       $__table=$request->_form_name ?? '';
       $branch_id=$request->_branch_id ?? 1;

        $PurchaseReturn = PurchaseReturn::where('id',$purchase_id)->first();

if( change_date_format($PurchaseReturn->_date) != change_date_format($request->_date)){
              
               
               $_order_number = make_order_number($__table,$organization_id,$branch_id,$request->_date);
                 $PurchaseReturn->_order_number = $_order_number ?? '';
            }else{
                $PurchaseReturn->_order_number = $request->_order_number ?? '';
            }



        if(empty($PurchaseReturn)){
            return redirect()->back()->with('danger','Purchase Return Numbe Is not Correct!');
        }
        $PurchaseReturn->_date = change_date_format($request->_date);
        $PurchaseReturn->_time = date('H:i:s');
        $PurchaseReturn->_order_ref_id = $request->_order_ref_id;
        $PurchaseReturn->_referance = $request->_referance;
        $PurchaseReturn->_ledger_id = $request->_main_ledger_id;
        $PurchaseReturn->_user_id = $request->_main_ledger_id;
        $PurchaseReturn->_created_by = $users->id."-".$users->name;
        $PurchaseReturn->_updated_by = $users->id."-".$users->name;
        $PurchaseReturn->_user_id = $users->id;
        $PurchaseReturn->_user_name = $users->name;
        $PurchaseReturn->_note = $request->_note;
        $PurchaseReturn->_sub_total = $request->_sub_total;
        $PurchaseReturn->_discount_input = $request->_discount_input;
        $PurchaseReturn->_total_discount = $request->_total_discount;
        $PurchaseReturn->_total_vat = $request->_total_vat;
        $PurchaseReturn->_total = $request->_total;
        $PurchaseReturn->organization_id = $organization_id;
        $PurchaseReturn->_branch_id = $_branch_id;
        $PurchaseReturn->_cost_center_id = $_cost_center_id ?? 1;
        $PurchaseReturn->_status = 1;
        $PurchaseReturn->_lock = $request->_lock ?? 0;
        $PurchaseReturn->save();
        $purchase_id = $PurchaseReturn->id;

        //###########################
        // PurchaseReturn Master information Save End
        //###########################

        //###########################
        // PurchaseReturn Details information Save Start
        //###########################
        
        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                if($purchase_detail_ids[$i]==0){
                    $PurchaseReturnDetail = new PurchaseReturnDetail();
                }else{
                    $PurchaseReturnDetail = PurchaseReturnDetail::find($purchase_detail_ids[$i]);
                }
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $PurchaseReturnDetail->_barcode = $barcode_string;
                
                $PurchaseReturnDetail->_item_id = $_item_ids[$i];

                $PurchaseReturnDetail->_qty = $_qtys[$i];
                $PurchaseReturnDetail->_rate = $_rates[$i];
                $PurchaseReturnDetail->_sales_rate = $_sales_rates[$i];

                $PurchaseReturnDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $PurchaseReturnDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $PurchaseReturnDetail->_base_unit = $_base_unit_ids[$i] ?? 1;

                $PurchaseReturnDetail->_discount = $_discounts[$i] ?? 0;
                $PurchaseReturnDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $PurchaseReturnDetail->_vat = $_vats[$i] ?? 0;
                $PurchaseReturnDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $PurchaseReturnDetail->_value = $_values[$i] ?? 0;
                $PurchaseReturnDetail->_store_id = $_store_ids[$i] ?? 1;
                $PurchaseReturnDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $PurchaseReturnDetail->_cost_center_id = $_cost_center_id ?? 1;
                $PurchaseReturnDetail->organization_id = $organization_id ?? 1;
                $PurchaseReturnDetail->_branch_id = $_branch_id ?? 1;
                $PurchaseReturnDetail->_no = $purchase_id;
                $PurchaseReturnDetail->_purchase_ref_id = $request->_order_ref_id;
                $PurchaseReturnDetail->_purchase_detal_ref = $_purchase_detal_refs[$i];
                $PurchaseReturnDetail->_status = 1;
                $PurchaseReturnDetail->_created_by = $users->id."-".$users->name;
                $PurchaseReturnDetail->save();
                $_purchase_detail_id = $PurchaseReturnDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();

                
                 $ProductPriceList = ProductPriceList::where('_purchase_detail_id',$_purchase_detal_refs[$i])
                                                    ->where('_master_id',$request->_order_ref_id)->first();


                 
                $_p_qty = $ProductPriceList->_qty ;
                $___unique_barcode = $ProductPriceList->_unique_barcode;
                $_old_barcode_strings =  $ProductPriceList->_barcode;
                //Barcode  deduction from old string data
                if($___unique_barcode ==1){

                        $_new_barcode_array = array();
                        if($_old_barcode_strings !=""){
                            $_old_barcode_array = explode(",",$_old_barcode_strings);
                        }
                        if($barcode_string !=""){
                            $_new_barcode_array = explode(",",$barcode_string);
                        }
                        if(sizeof($_new_barcode_array) > 0 && sizeof($_old_barcode_array) > 0){
                            $_last_barcode_array=  array_diff($_old_barcode_array,$_new_barcode_array);
                            if(sizeof($_last_barcode_array ) > 0){
                                $_last_barcode_string = implode(",",$_last_barcode_array);
                                $ProductPriceList->_barcode = $_last_barcode_string; //For Unique Barcode
                            }
                        }
                }else{
                    $ProductPriceList->_barcode = $barcode_string;
                }
                

                //Barcode  deduction from old string data
               
                $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                //return $_p_qty;
                       
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();

                /*
    Barcode insert into database section
   _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
   IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
                [  $data->_no_id = $_no_id;
                    $data->_no_detail_id = $_no_detail_id;
                    ] use  $p=1;
*/
                $product_price_id =  $ProductPriceList->id;
        if($___unique_barcode ==1){
                 if($barcode_string !=""){
                   $barcode_array=  explode(",",$barcode_string);
                   $_qty = (sizeof($barcode_array) <= 1) ? $_qtys[$i] : 1;
                   $_stat = 1;
                   $_return=1;
                   
                   foreach ($barcode_array as $_b_v) {
                   _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,1);
                    _barcode_insert_update('PurchaseReturnBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,0);

                    $bar_ab=PurchaseReturnBarcode::where('_p_p_id',$product_price_id)
                                            ->where('_item_id',$_item_ids[$i])
                                            ->where('_no_id',$purchase_id)
                                            ->where('_no_detail_id',$_purchase_detail_id)
                                            ->where('_barcode',$_b_v)
                                            ->first();
                    if(empty($bar_ab)){
                        $bar_ab = new PurchaseReturnBarcode();
                        $bar_ab->_p_p_id =$product_price_id;
                        $bar_ab->_item_id =$_item_ids[$i];
                        $bar_ab->_no_id =$purchase_id;
                        $bar_ab->_no_detail_id =$_purchase_detail_id;
                        $bar_ab->_barcode =$_b_v;

                    }
                    $bar_ab->_qty =$_qty;
                    $bar_ab->_status =$_stat;
                    $bar_ab->save();

                     
                   }
                }

}else{
$_qty = $_qtys[$i] ?? 0;
$_stat = 1;
$_return=1;
$_b_v=$ProductPriceList->_barcode ?? '';

    _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,1);
    _barcode_insert_update('PurchaseReturnBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,1,0);
}
                

                $ItemInventory = ItemInventory::where('_transection',"Purchase Return")
                                    ->where('_transection_ref',$purchase_id)
                                    ->where('_transection_detail_ref_id',$_purchase_detail_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                }

                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Purchase Return";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;

                // $ItemInventory->_qty = -($_qtys[$i] *$conversion_qtys[$i] ?? 1);
                // $ItemInventory->_rate = ($_sales_rates[$i]  /$conversion_qtys[$i] ?? 1);
                // $ItemInventory->_cost_rate = ($_rates[$i]/$conversion_qtys[$i] ?? 1);

                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;
                $ItemInventory->_qty = -($_qtys[$i] *$conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate = $_sales_rates[$i] ?? 0;
                $ItemInventory->_cost_rate = ($_rates[$i]/$conversion_qtys[$i] ?? 1);
                 //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $_base_unit_ids[$i] ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                // $ItemInventory->_qty = -($_qtys[$i]);
                // $ItemInventory->_rate = $_sales_rates[$i];
                // $ItemInventory->_cost_rate = $_rates[$i];

                $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);
                $ItemInventory->_value = ($_values[$i] ?? 0);
                $ItemInventory->organization_id = $organization_id ?? 1;
                $ItemInventory->_branch_id = $branch_id ?? 1;
                $ItemInventory->_store_id = $_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 

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

        $PurchaseReturnFormSetting = PurchaseReturnFormSetting::first();
        $_default_inventory = $PurchaseReturnFormSetting->_default_inventory;
        $_default_purchase = $PurchaseReturnFormSetting->_default_purchase;
        $_default_discount = $PurchaseReturnFormSetting->_default_discount;
        $_default_vat_account = $PurchaseReturnFormSetting->_default_vat_account;

        $_ref_master_id=$purchase_id;
        $_ref_detail_id=$purchase_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Purchase Return';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;
        if($request->_sub_total > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id,1);
            //Default Purchase Return
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,0,$request->_sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id,1);
        

            //Default Purchase Return
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,$request->_sub_total,0,$_branch_id,$_cost_center,$_name,3,$organization_id,2);
        //Default Inventory
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$request->_sub_total,$_branch_id,$_cost_center,$_name,4,$organization_id,2);
        }

        if($request->_total_discount > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_discount,$_cr_amount=0,$_branch_id,$_cost_center,$_name,5,$organization_id,3);
             //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,0,$request->_total_discount,$_branch_id,$_cost_center,$_name,6,$organization_id,3);
        
        }
        if($request->_total_vat > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,$_cr_amount=0,$_branch_id,$_cost_center,$_name,7,$organization_id,4);
        //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,$_dr_amount=0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8,$organization_id,4);
        
        }

        // ############################
        //  Purchase Account         Dr 
        //      Account Payable     Cr
        //
        //  Inventory Account       Dr
        //     Purchase Account     Cr
        //
        //  Account Payable         Dr
        //    Purchase Discount   Cr
        //
        //  Vat Account          Dr
        //     Account Payable   Cr
        //##################################

        $_ledger_id = (array) $request->_ledger_id;
        $_short_narr = (array) $request->_short_narr;
        $_dr_amount = (array) $request->_dr_amount;
         $_cr_amount = (array) $request->_cr_amount;
        $_branch_id_detail = (array) $request->_branch_id_detail;
        $_cost_center = (array) $request->_cost_center;
        $purchase_account_ids = (array) $request->purchase_account_id;
       
        if(sizeof($_ledger_id) > 0){
                foreach($_ledger_id as $i=>$ledger) {
                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;
                         $PurchaseReturnAccount = PurchaseReturnAccount::where('id',$purchase_account_ids[$i] ?? 0)
                                                                        ->where('_ledger_id',$ledger)
                                                            ->first();
                        if(empty($PurchaseReturnAccount)){
                            $PurchaseReturnAccount = new PurchaseReturnAccount();
                        }
                        
                        $PurchaseReturnAccount->_no = $purchase_id;
                        $PurchaseReturnAccount->_account_type_id = $_account_type_id;
                        $PurchaseReturnAccount->_account_group_id = $_account_group_id;
                        $PurchaseReturnAccount->_ledger_id = $ledger;
                        $PurchaseReturnAccount->_cost_center = $_cost_center_id ?? 0;
                        $PurchaseReturnAccount->organization_id =$organization_id;
                        $PurchaseReturnAccount->_branch_id = $_branch_id ?? 0;
                        $PurchaseReturnAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $PurchaseReturnAccount->_dr_amount = $_dr_amount[$i];
                        $PurchaseReturnAccount->_cr_amount = $_cr_amount[$i];
                        $PurchaseReturnAccount->_status = 1;
                        $PurchaseReturnAccount->_updated_by = $users->id."-".$users->name;
                        $PurchaseReturnAccount->save();

                        $purchase_detail_id = $PurchaseReturnAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$purchase_detail_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Purchase Return';
                        $_date = change_date_format($request->_date);
                        $_table_name ='purchase_return_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id ?? 0;
                        $_cost_center_a = $_cost_center_id ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i),$organization_id,5);
                          
                    }
                }

                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $PurchaseReturnAccount = new PurchaseReturnAccount();
                        $PurchaseReturnAccount->_no = $purchase_id;
                        $PurchaseReturnAccount->_account_type_id = $_account_type_id;
                        $PurchaseReturnAccount->_account_group_id = $_account_group_id;
                        $PurchaseReturnAccount->_ledger_id = $request->_main_ledger_id;
                        $PurchaseReturnAccount->_cost_center = $users->cost_center_ids;
                        $PurchaseReturnAccount->organization_id = $organization_id;
                        $PurchaseReturnAccount->_branch_id = $users->branch_ids;
                        $PurchaseReturnAccount->_short_narr = 'N/A';
                        $PurchaseReturnAccount->_dr_amount = 0;
                        $PurchaseReturnAccount->_cr_amount = $_total_dr_amount;
                        $PurchaseReturnAccount->_status = 1;
                        $PurchaseReturnAccount->_created_by = $users->id."-".$users->name;
                        $PurchaseReturnAccount->save();

 
                        $_sales_account_id = $PurchaseReturnAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                         $_transaction= 'Purchase Return';
                        $_date = change_date_format($request->_date);
                        $_table_name ='purchase_return_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a =  $_total_dr_amount;
                        $_branch_id_a = $request->_branch_id ?? 1;
                        $_cost_center_a = $request->_cost_center_id ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20),$organization_id,6);
                }
            }


$_l_balance = _l_balance_update($request->_main_ledger_id);


             \DB::table('purchase_returns')
             ->where('id',$purchase_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance]);

        if(($request->_lock ?? 0) ==1){
                return redirect('purchase-return/print/'.$purchase_id)
                ->with('success','Information save successfully');
          }else{
             return redirect()->back()
               ->with('success','Information save successfully')
               ->with('_master_id',$purchase_id)
               ->with('_print_value',$_print_value);
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
