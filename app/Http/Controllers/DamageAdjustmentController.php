<?php

namespace App\Http\Controllers;

use App\Models\DamageAdjustment;
use App\Models\Sales;
use App\Models\SalesAccount;
use App\Models\SalesDetail;
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
use App\Models\DamageFormSetting;
use App\Models\DamageAdjustmentDetail;
use App\Models\Warranty;
use App\Models\BarcodeDetail;
use App\Models\DamageBarcode;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class DamageAdjustmentController extends Controller
{

        function __construct()
    {
         $this->middleware('permission:damage-list|damage-create|damage-edit|damage-delete|damage-print', ['only' => ['index','store']]);
         $this->middleware('permission:damage-print', ['only' => ['damagePrint']]);
         $this->middleware('permission:damage-create', ['only' => ['create','store']]);
         $this->middleware('permission:damage-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:damage-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.damage');
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
            session()->put('_damage_limit', $request->limit);
        }else{
             $limit= \Session::get('_damage_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = DamageAdjustment::with(['_organization','_master_branch','_ledger','_master_details'])->where('_status',1);
        $datas = $datas->whereIn('_branch_id',explode(',',\Auth::user()->branch_ids));
        if($request->has('_branch_id') && $request->_branch_id !=""){
            $datas = $datas->where('_user_id',$request->_branch_id);  
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
            $datas = $datas->where('_order_ref_id','like',"%trim($request->_order_ref_id)%");
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_store_salves_id') && $request->_store_salves_id !=''){
            $datas = $datas->where('_store_salves_id','=',$request->_store_salves_id);
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
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $users = Auth::user();
        $form_settings = DamageFormSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.damage.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.damage.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.damage.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }

     public function reset(){
        Session::flash('_damage_limit');
       return  \Redirect::to('damage?limit='.default_pagination());
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
        $store_houses = permited_stores(explode(',',$users->store_ids));
        $form_settings = DamageFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();

       return view('backend.damage.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties'));
    }

     public function formSettingAjax(){
        $form_settings = DamageFormSetting::first();
        $inv_accounts = AccountLedger::get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $cost_of_solds = $inv_accounts;
        return view('backend.damage.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds'));
    }

       public function Settings (Request $request){

     //   return $request->all();
        $data = DamageFormSetting::first();
        if(empty($data)){
            $data = new DamageFormSetting();
        }
        $data->_default_inventory = $request->_default_inventory;
        $data->_default_discount = $request->_default_discount;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_show_unit = $request->_show_unit ?? 1;
        $data->_show_cost_rate = $request->_show_cost_rate ?? 1;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 1;
        $data->_show_expire_date = $request->_show_expire_date ?? 1;
        $data->_show_warranty = $request->_show_warranty ?? 0;
        $data->save();


        return redirect()->back();
                       

    }
    public function Print($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data =  DamageAdjustment::with(['_master_branch','_master_details','_ledger'])->find($id);
        $form_settings = DamageFormSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
       return view('backend.damage.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
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
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);


         //###########################
        // Purchase Details information Save Start
        //###########################
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

    //###########################
    // Purchase Master information Save Start
    //###########################
         DB::beginTransaction();
         try {
             $_p_balance = _l_balance_update($request->_main_ledger_id);
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $DamageAdjustment = new DamageAdjustment();
        $DamageAdjustment->_date = change_date_format($request->_date);
        $DamageAdjustment->_time = date('H:i:s');
        $DamageAdjustment->_order_ref_id = $request->_order_ref_id;
        $DamageAdjustment->_order_number = $request->_order_number ?? '';
        $DamageAdjustment->_referance = $request->_referance;
        $DamageAdjustment->_ledger_id = $request->_main_ledger_id;
        $DamageAdjustment->_user_id = $users->id;
        $DamageAdjustment->_created_by = $users->id."-".$users->name;
        $DamageAdjustment->_user_id = $users->id;
        $DamageAdjustment->_user_name = $users->name;
        $DamageAdjustment->_note = $request->_note;
        $DamageAdjustment->_sub_total = $__sub_total;
        $DamageAdjustment->_discount_input = $__discount_input;
        $DamageAdjustment->_total_discount = $__total_discount;
        $DamageAdjustment->_total_vat = $request->_total_vat;
        $DamageAdjustment->_total =  $__total;
        $DamageAdjustment->organization_id = $organization_id;
        $DamageAdjustment->_branch_id = $request->_branch_id;
        $DamageAdjustment->_cost_center_id = $request->_cost_center_id ?? 1;
        $DamageAdjustment->_address = $request->_address;
        $DamageAdjustment->_phone = $request->_phone;
        $DamageAdjustment->_status = 1;
        $DamageAdjustment->_lock = $request->_lock ?? 0;
        $DamageAdjustment->save();
        $_master_id = $DamageAdjustment->id;         

        //###########################
        // Purchase Master information Save End
        //###########################

        
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $DamageAdjustmentDetail = new DamageAdjustmentDetail();

                //$_total_cost_value += ($_rates[$i]*$_qtys[$i]);

                $_total_cost_value += (($_rates[$i]*$conversion_qtys[$i] ?? 1)*$_qtys[$i]);

                $_base_rate = ($_values[$i]/($_qtys[$i]*$conversion_qtys[$i] ?? 1));
                $DamageAdjustmentDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $DamageAdjustmentDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $DamageAdjustmentDetail->_base_unit = $_base_unit_ids[$i] ?? 1;
                $DamageAdjustmentDetail->_base_rate = $_base_rate;


                
                $DamageAdjustmentDetail->_item_id = $_item_ids[$i];
                $DamageAdjustmentDetail->_p_p_l_id = $_p_p_l_ids[$i];
                $DamageAdjustmentDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $DamageAdjustmentDetail->_purchase_detail_id = $_purchase_detail_ids[$i];
                $DamageAdjustmentDetail->_qty = $_qtys[$i];
                 $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_p_p_l_ids[$i]] ?? '';

                $DamageAdjustmentDetail->_barcode = $barcode_string;
                 $DamageAdjustmentDetail->_warranty = $_warrantys[$i] ?? 0;

                $DamageAdjustmentDetail->_manufacture_date = $_manufacture_dates[$i];
                $DamageAdjustmentDetail->_expire_date = $_expire_dates[$i];
                $DamageAdjustmentDetail->_rate = $_rates[$i];
                $DamageAdjustmentDetail->_sales_rate = $_sales_rates[$i];
                $DamageAdjustmentDetail->_discount = $_discounts[$i] ?? 0;
                $DamageAdjustmentDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $DamageAdjustmentDetail->_vat = $_vats[$i] ?? 0;
                $DamageAdjustmentDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $DamageAdjustmentDetail->_value = $_values[$i] ?? 0;
                $DamageAdjustmentDetail->_store_id = $_store_ids[$i] ?? 1;
                $DamageAdjustmentDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $DamageAdjustmentDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $DamageAdjustmentDetail->organization_id = $organization_id;
                $DamageAdjustmentDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $DamageAdjustmentDetail->_no = $_master_id;
                $DamageAdjustmentDetail->_status = 1;
                $DamageAdjustmentDetail->_created_by = $users->id."-".$users->name;
                $DamageAdjustmentDetail->save();
                $_sales_details_id = $DamageAdjustmentDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();

                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                 $_p_qty = $ProductPriceList->_qty;
                // $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                // $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);

                $_unique_barcode = $ProductPriceList->_unique_barcode;

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
                }else{
                  $ProductPriceList->_barcode = $barcode_string;
                }
                //Barcode  deduction from old string data

                $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();

                // $ProductPriceList->_status = $_status;
                // $ProductPriceList->save();



            $product_price_id =  $ProductPriceList->id;
             if($_unique_barcode ==1){
                  if($barcode_string !=""){
                       $barcode_array=  explode(",",$barcode_string);
                       $_qty = 1;
                       $_stat = 1;
                       $_return=1;
                       
                       foreach ($barcode_array as $_b_v) {
                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                        _barcode_insert_update('DamageBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                         
                       }
                    }
             }else{
                $_qty = $ProductPriceList->_qty;
               $_stat = 1;
               $_return=1;
               $_b_v =$ProductPriceList->_barcode;

                _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                _barcode_insert_update('DamageBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
             }

                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Damage";
                $ItemInventory->_transection_ref = $_master_id;
                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;

                  //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                // $ItemInventory->_qty = -($_qtys[$i]);
                // $ItemInventory->_rate = $_sales_rates[$i];
                // $ItemInventory->_cost_rate = $_rates[$i];
                // $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);

                $ItemInventory->_qty = -($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_sales_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_rate = $_rates[$i];
                $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);


                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                $ItemInventory->_expire_date = $_expire_dates[$i];
                $ItemInventory->_value = $_values[$i] ?? 0;
                $ItemInventory->organization_id = $organization_id;
                $ItemInventory->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ItemInventory->_store_id = $_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_main_cost_center[$i] ?? 1;
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

        $DamageFormSetting = DamageFormSetting::first();
        $_default_inventory = $DamageFormSetting->_default_inventory;
        $_default_discount = $DamageFormSetting->_default_discount;
        $_default_vat_account = $DamageFormSetting->_default_vat_account;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Damage';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;
        
        if($__sub_total > 0){
            //Default Damage DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
           // _default_inventory  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__sub_total,$_branch_id,$_cost_center,$_name,1,$organization_id);

           
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

        $_l_balance = _l_balance_update($request->_main_ledger_id);
        $_pfix = _sales_pfix().$_master_id;
            $_main_branch_id = $request->_branch_id;
            $__table="damage_adjustments";
            $_pfix = make_order_number($__table,$organization_id,$_main_branch_id);
            
        \DB::table('damage_adjustments')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

           DB::commit();
            return redirect()->back()
                ->with('success','Information save successfully')
                ->with('_master_id',$_master_id)
                ->with('_print_value',$_print_value);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger','There is Something Wrong !');
         }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DamageAdjustment  $damageAdjustment
     * @return \Illuminate\Http\Response
     */
    public function show(DamageAdjustment $damageAdjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DamageAdjustment  $damageAdjustment
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
        $form_settings = DamageFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
         $data =  DamageAdjustment::with(['_master_branch','_master_details','_ledger'])->where('_lock',0)->find($id);
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }
        
       return view('backend.damage.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','data','_warranties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DamageAdjustment  $damageAdjustment
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request)
    {


         
        //return $request->all();
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required',
            '_sales_id' => 'required'
        ]);

         //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
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


        $checkqty = array();
        $over_qtys = array();
        $_sales_id = $request->_sales_id;

         $data =  DamageAdjustment::where('_lock',0)->find($request->_sales_id);
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }

         //Prevoius Return information
     $previous_sales_details = DamageAdjustmentDetail::where('_no',$_sales_id)->where('_status',1)->get();
    foreach ($previous_sales_details as $value) {
         $product_prices = ProductPriceList::where('_purchase_detail_id',$value->_purchase_detail_id)->first();
         $new_qty = (($value->_qty*$value->_unit_conversion)+$product_prices->_qty);
         $_unique_barcode = $product_prices->_unique_barcode;
         $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
         array_push($checkqty, ['id'=>$product_prices->_purchase_detail_id,'_qty'=>$new_qty,'_barcode'=>$_old_new_barcode,'_unique_barcode'=>$_unique_barcode]);
    }



    foreach ($_purchase_detail_ids as $item_key=> $_item) {
        foreach ($checkqty as $check_item) {
              $barcode_string=$all_req[$_ref_counters[$item_key]."__barcode__".$_item_ids[$item_key]] ?? '';
          if($_unique_barcode ==1){
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
                                if($_item==$check_item["id"] && ($_qtys[$item_key]*$conversion_qtys[$item_key]) > $check_item["_qty"] ){
                                    array_push($over_qtys, $_item); //if use model barcode and want to return more then purchase quantity then show a messge
                                 }
                          }
                           //Unique Barcode Olready Check as wrong Barcode number
                        }
                       
                    }
                }
            }


          }else{

                 //This section come when no barcode used for item purchase and purchase return
                //Here we need to check item id and item available qty
                if($_item==$check_item["id"] && ($_qtys[$item_key]*$conversion_qtys[$item_key]) > $check_item["_qty"] ){
                    array_push($over_qtys, $_item); //If input Extra qty then shw a messge
                }
            }
            
        }
    }

    if(sizeof($over_qtys) > 0){
        return redirect()->back()
        ->with('request',$request->all())
        ->with('danger','You Can not Return More then available Qty !');
    }







    //###########################
    // Purchase Master information Save Start
    //###########################
        DB::beginTransaction();
        try {
        

       

        //====
        // Product Price list table update with previous sales details item
        // 
        //======

        // $previous_sales_details = DamageAdjustmentDetail::where('_no',$_sales_id)->get();
        // foreach ($previous_sales_details as $value) {
        //         $ProductPriceList = ProductPriceList::where('id',$value->_p_p_l_id)->first();
        //         $_p_qty = $ProductPriceList->_qty;
        //         $_status = (($_p_qty + $value->_qty) > 0) ? 1 : 0;
        //         $ProductPriceList->_qty = ($_p_qty + $value->_qty);
        //         $ProductPriceList->_status = $_status;
        //         $ProductPriceList->save();
        // }

        foreach ($previous_sales_details as $value) {

            $product_prices =ProductPriceList::where('id',$value->_p_p_l_id)->first();
             $new_qty = (($value->_qty*$value->_unit_conversion)+$product_prices->_qty);
             $_unique_barcode = $product_prices->_unique_barcode;
             $_up_status = (($new_qty) > 0) ? 1 : 0;
             if($_unique_barcode ==1){
                $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
                if($_old_new_barcode !=""){
                    $_unique_old_newbarcode_array =   explode(",",$_old_new_barcode);
                    foreach ($_unique_old_newbarcode_array as $_arraY_val) {
                      $_unique_old_newbarcode_array[]=trim($_arraY_val);
                    }
                    $_unique_old_newbarcode_array = array_unique($_unique_old_newbarcode_array);
                     $_last_barcode_string = implode(",",$_unique_old_newbarcode_array);
                     $product_prices->_barcode =$_last_barcode_string;
                    if(sizeof($_unique_old_newbarcode_array) > 0){
                        foreach ($_unique_old_newbarcode_array as $_bar_value) {
                                BarcodeDetail::where('_p_p_id',$product_prices->id)
                                            ->where('_item_id',$product_prices->_item_id)
                                            ->where('_barcode',$_bar_value)
                                            ->update(['_qty'=>1,'_status'=>1]);
                            }
                    }
                }
                
             }
             $product_prices->_qty = $new_qty;
             
             $product_prices->save();

        }

     

    DamageAdjustmentDetail::where('_no', $_sales_id)
            ->update(['_status'=>0]);
    ItemInventory::where('_transection',"Damage")
        ->where('_transection_ref',$_sales_id)
        ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]);  
    DamageBarcode::where('_no_id',$_sales_id)
                  ->update(['_status'=>0,'_qty'=>0]);
    $_p_balance = _l_balance_update($request->_main_ledger_id);
  
        
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $DamageAdjustment = DamageAdjustment::find($_sales_id);
        $DamageAdjustment->_date = change_date_format($request->_date);
        $DamageAdjustment->_time = date('H:i:s');
        $DamageAdjustment->_order_ref_id = $request->_order_ref_id;
        $DamageAdjustment->_order_number = $request->_order_number ?? '';
        $DamageAdjustment->_referance = $request->_referance;
        $DamageAdjustment->_ledger_id = $request->_main_ledger_id;
        $DamageAdjustment->_user_id = $request->_main_ledger_id;
        $DamageAdjustment->_created_by = $users->id."-".$users->name;
        $DamageAdjustment->_user_id = $users->id;
        $DamageAdjustment->_user_name = $users->name;
        $DamageAdjustment->_note = $request->_note;
        $DamageAdjustment->_sub_total = $__sub_total;
        $DamageAdjustment->_discount_input = $__discount_input;
        $DamageAdjustment->_total_discount = $__total_discount;
        $DamageAdjustment->_total_vat = $request->_total_vat;
        $DamageAdjustment->_total =  $__total;
        $DamageAdjustment->organization_id = $organization_id;
        $DamageAdjustment->_branch_id = $request->_branch_id;
        $DamageAdjustment->_cost_center_id = $request->_cost_center_id ?? 1;
        $DamageAdjustment->_address = $request->_address;
        $DamageAdjustment->_phone = $request->_phone;
        $DamageAdjustment->_status = 1;
        $DamageAdjustment->_lock = $request->_lock ?? 0;
        $DamageAdjustment->save();
        $_master_id = $DamageAdjustment->id;
                                           

        



        

       
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $_total_cost_value += (($_rates[$i]*$conversion_qtys[$i] ?? 1)*$_qtys[$i]);
                


                if($_sales_detail_row_ids[$i] ==0){
                        $DamageAdjustmentDetail = new DamageAdjustmentDetail();
                }else{
                    $DamageAdjustmentDetail = DamageAdjustmentDetail::find($_sales_detail_row_ids[$i]);
                }
                 $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $DamageAdjustmentDetail->_barcode = $barcode_string;
                $DamageAdjustmentDetail->_warranty = $_warrantys[$i] ?? 0;

                $_base_rate = ($_values[$i]/($_qtys[$i]*$conversion_qtys[$i] ?? 1));
                $DamageAdjustmentDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $DamageAdjustmentDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $DamageAdjustmentDetail->_base_unit = $_base_unit_ids[$i] ?? 1;
                $DamageAdjustmentDetail->_base_rate = $_base_rate;

                
                $DamageAdjustmentDetail->_item_id = $_item_ids[$i];
                $DamageAdjustmentDetail->_p_p_l_id = $_p_p_l_ids[$i];
                $DamageAdjustmentDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $DamageAdjustmentDetail->_purchase_detail_id = $_purchase_detail_ids[$i];
                $DamageAdjustmentDetail->_qty = $_qtys[$i];
                
                $DamageAdjustmentDetail->_rate = $_rates[$i];
                $DamageAdjustmentDetail->_sales_rate = $_sales_rates[$i];
                $DamageAdjustmentDetail->_discount = $_discounts[$i] ?? 0;
                $DamageAdjustmentDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $DamageAdjustmentDetail->_vat = $_vats[$i] ?? 0;
                $DamageAdjustmentDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $DamageAdjustmentDetail->_value = $_values[$i] ?? 0;
                $DamageAdjustmentDetail->_manufacture_date = $_manufacture_dates[$i];
                $DamageAdjustmentDetail->_expire_date = $_expire_dates[$i];
                $DamageAdjustmentDetail->_store_id = $_store_ids[$i] ?? 1;
                $DamageAdjustmentDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $DamageAdjustmentDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $DamageAdjustmentDetail->organization_id = $organization_id;
                $DamageAdjustmentDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $DamageAdjustmentDetail->_no = $_master_id;
                $DamageAdjustmentDetail->_status = 1;
                $DamageAdjustmentDetail->_created_by = $users->id."-".$users->name;
                $DamageAdjustmentDetail->save();
                $_sales_details_id = $DamageAdjustmentDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();

                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                 $_p_qty = $ProductPriceList->_qty;
                $_unique_barcode = $ProductPriceList->_unique_barcode;
 if($_unique_barcode ==1){

                //Barcode  deduction from old string data
                 $_old_barcode_strings =  $ProductPriceList->_barcode;
                 $_last_barcode_array = array();
                $_new_barcode_array = array();
                if($_old_barcode_strings !=""){
                    $_old_barcode_array = explode(",",$_old_barcode_strings);
                }
                if($barcode_string !=""){
                    $_new_barcode_array = explode(",",$barcode_string);
                }

                foreach ($_old_barcode_array as $_old_value) {
                  if(!in_array($_old_value, $_new_barcode_array)){
                   
                    array_push($_last_barcode_array, $_old_value);
                  }
                }
               
                if(sizeof($_last_barcode_array ) > 0){
                  $_new_last_barcode_string = implode(",",$_last_barcode_array);
                  
                }else{
                  $_new_last_barcode_string = '';
                }

$ProductPriceList->_barcode = $_new_last_barcode_string;
              
}
                //Barcode  deduction from old string data
                $_p_qty = $ProductPriceList->_qty;
                $_status = (($_p_qty - ($_qtys[$i]*$conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]*$conversion_qtys[$i] ?? 1));
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();

                $product_price_id =  $ProductPriceList->id;
                 $_unique_barcode =  $ProductPriceList->_unique_barcode;
                  if($_unique_barcode ==1){
                 if($barcode_string !=""){
                       $barcode_array=  explode(",",$barcode_string);
                       $_qty = 1;
                       $_stat = 1;
                       $_return=1;
                       
                       foreach ($barcode_array as $_b_v) {
                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                        _barcode_insert_update('DamageBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                         
                       }
                    }
              }else{
                $_qty = $ProductPriceList->_qty;
               $_stat = 1;
               $_return=1;
               $_b_v =$ProductPriceList->_barcode;

                _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                _barcode_insert_update('DamageBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
             }





                $ItemInventory = ItemInventory::where('_transection',"Sales")
                                    ->where('_transection_ref',$_sales_id)
                                    ->where('_transection_detail_ref_id',$_sales_details_id)
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
                $ItemInventory->_transection = "Damage";
                $ItemInventory->_transection_ref = $_master_id;
                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;

                //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                // $ItemInventory->_qty = -($_qtys[$i]);
                // $ItemInventory->_rate = $_sales_rates[$i];
                // $ItemInventory->_cost_rate = $_rates[$i];
                // $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);

                $ItemInventory->_qty = -($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_sales_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_rate = $_rates[$i];
                $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);


                $ItemInventory->_value = $_values[$i] ?? 0;


                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                $ItemInventory->_expire_date = $_expire_dates[$i];
                $ItemInventory->organization_id = $organization_id;
                $ItemInventory->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ItemInventory->_store_id = $_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_updated_by = $users->id."-".$users->name;
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

        $DamageFormSetting = DamageFormSetting::first();
        $_default_inventory = $DamageFormSetting->_default_inventory;
        $_default_discount = $DamageFormSetting->_default_discount;
        $_default_vat_account = $DamageFormSetting->_default_vat_account;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Damage';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;
        
         if($__sub_total > 0){

             //Default Damage DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
           // _default_inventory  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id);

          
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

        $_l_balance = _l_balance_update($request->_main_ledger_id);
        $_pfix = _sales_pfix().$_master_id;

            
        \DB::table('damage_adjustments')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance]);

       

 
            

           DB::commit();
           if(($request->_lock ?? 0) ==1){
                return redirect('damage/print/'.$_master_id)
                ->with('success','Information save successfully');
          }else{
             return redirect()->back()
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
     * @param  \App\Models\DamageAdjustment  $damageAdjustment
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        return redirect()->back()->with('danger','You Can not delete this Information');

    }
}
