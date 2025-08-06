<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DamageReceiveMaster;
use App\Models\DamageReceiveDetail;
use App\Models\DamageReceiveFormSetting;
use App\Models\DamageReceiveBarcode;
use App\Models\DamageReceiveAccount;
use App\Models\DamageItemHistory;
use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\StoreHouse;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\BarcodeDetail;
use App\Models\GeneralSettings;
use Auth;
use DB;
use Session;

class DamageReceiveMasterController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:damage_receive-list|damage_receive-create|damage_receive-edit|damage_receive-delete|damage_receive-print', ['only' => ['index','store']]);
         $this->middleware('permission:damage_receive-print', ['only' => ['damage_receivePrint']]);
         $this->middleware('permission:damage_receive-create', ['only' => ['create','store']]);
         $this->middleware('permission:damage_receive-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:damage_receive-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.damage_receive');
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

        $datas = DamageReceiveMaster::with(['_organization','_master_branch','_ledger']);
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
            $datas = $datas->where('_order_ref_id','like',"%trim($request->_order_ref_id)%");
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
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','=',trim($request->_order_number));
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
        $form_settings = DamageReceiveFormSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.damage_receive.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.damage_receive.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.damage_receive.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }

     public function reset(){
        Session::flash('_damage_limit');
       return  \Redirect::to('damage_receive?limit='.default_pagination());
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
        $store_houses = permited_stores(explode(',',$users->store_ids));
        //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = DamageReceiveFormSetting::first();
        $inv_accounts = AccountLedger::select('id','_name','_account_group_id','_code','_account_head_id','_phone','_balance','_address','_credit_limit','_alious')->orderBy('_name','ASC')->get();
        $p_accounts = $inv_accounts;
        $dis_accounts =$p_accounts;
        $capital_accounts = $inv_accounts;

      
       

       
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();

       return view('backend.damage_receive.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','capital_accounts'));
    }

     public function damage_receiveSettings(Request $request){
        $data = DamageReceiveFormSetting::first();
        if(empty($data)){
            $data = new DamageReceiveFormSetting();
        }

        $data->_default_inventory = $request->_default_inventory;
        $data->_default_purchase = $request->_default_purchase;
        $data->_default_discount = $request->_default_discount;
        $data->_opening_inventory = $request->_opening_inventory;
        $data->_default_capital = $request->_default_capital;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_show_short_note = $request->_show_short_note ?? 0;
        $data->_show_unit = $request->_show_unit ?? 0;
        $data->_inline_discount = $request->_inline_discount;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_show_manufacture_date = $request->_show_manufacture_date;
        $data->_show_expire_date = $request->_show_expire_date;
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
       //  dump($request->all());
        // die();
        
       $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);
    //###########################
    // Purchase Master information Save Start
    //###########################
       DB::beginTransaction();
        try {
         $organization_id = $request->organization_id ?? 1;
         $_p_balance = _l_balance_update($request->_main_ledger_id);
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;
         $__total_vat = (float) $request->_total_vat ?? 0;
         

        $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $DamageReceiveMaster = new DamageReceiveMaster();
        $DamageReceiveMaster->_date = change_date_format($request->_date);
        $DamageReceiveMaster->_time = date('H:i:s');
        $DamageReceiveMaster->_damage_type = $request->_damage_type ?? 0;
        $DamageReceiveMaster->_order_ref_id = $request->_order_ref_id ?? 0;
        $DamageReceiveMaster->_referance = $request->_referance;
        $DamageReceiveMaster->_ledger_id = $request->_main_ledger_id;
        $DamageReceiveMaster->_user_id = $request->_main_ledger_id;
        $DamageReceiveMaster->_created_by = $users->id."-".$users->name;
        $DamageReceiveMaster->_user_id = $users->id;
        $DamageReceiveMaster->_user_name = $users->name;
        $DamageReceiveMaster->_note = $request->_note;
        $DamageReceiveMaster->_sub_total = $__sub_total;
        $DamageReceiveMaster->_discount_input = $__discount_input;
        $DamageReceiveMaster->_total_discount = $__total_discount;
        $DamageReceiveMaster->_total_vat = $__total_vat;
        $DamageReceiveMaster->_total =  $__total;
        $DamageReceiveMaster->_branch_id = $request->_branch_id;
        $DamageReceiveMaster->organization_id = $organization_id;
        $DamageReceiveMaster->_cost_center_id = $request->_cost_center_id;
        $DamageReceiveMaster->_address = $request->_address;
        $DamageReceiveMaster->_phone = $request->_phone;
        $DamageReceiveMaster->_status = 1;
        $DamageReceiveMaster->_lock = $request->_lock ?? 0;
        $DamageReceiveMaster->save();
        $purchase_id = $DamageReceiveMaster->id;

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
        $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;
        $_discounts = $request->_discount ?? [];
        $_discount_amounts =$request->_discount_amount ?? [];
        $_short_notes =$request->_short_note ?? [];

        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];




       


        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $item_info = Inventory::where('id',$_item_ids[$i])->first();
                
                
                $PurchaseDetail = new DamageReceiveDetail();
                $PurchaseDetail->_item_id = $_item_ids[$i];
                $PurchaseDetail->_qty = $_qtys[$i];

                $PurchaseDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $PurchaseDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $PurchaseDetail->_base_unit = $_base_unit_ids[$i] ?? 1;

                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                if($barcode_string ==''){
                    $barcode_string = $item_info->_barcode ?? '';
                }

                $PurchaseDetail->_barcode = $barcode_string;
                $PurchaseDetail->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $PurchaseDetail->_expire_date = $_expire_dates[$i] ?? null;

                


                $PurchaseDetail->_rate = $_rates[$i];
                $PurchaseDetail->_short_note = $_short_notes[$i] ?? '';
                $PurchaseDetail->_sales_rate = $_sales_rates[$i];
                $PurchaseDetail->_discount = $_discounts[$i] ?? 0;
                $PurchaseDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $PurchaseDetail->_vat = $_vats[$i] ?? 0;
                $PurchaseDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $PurchaseDetail->_value = $_values[$i] ?? 0;
                $PurchaseDetail->_store_id = $_store_ids[$i] ?? 1;
                $PurchaseDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $PurchaseDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $PurchaseDetail->organization_id = $organization_id ?? 1;
                $PurchaseDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $PurchaseDetail->_no = $purchase_id;
                $PurchaseDetail->_status = 1;
                $PurchaseDetail->_created_by = $users->id."-".$users->name;
                $PurchaseDetail->save();
                $_purchase_detail_id = $PurchaseDetail->id;

               



                
                $ProductPriceList = new DamageItemHistory();
                $ProductPriceList->_item_id = $_item_ids[$i];
                $ProductPriceList->_item_name = $item_info->_item ?? '';
                $ProductPriceList->_category_id = $item_info->_category_id ?? 0;
                $ProductPriceList->_date = change_date_format($request->_date);
                $ProductPriceList->_time = date('H:i:s');


            $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
            if($general_settings->_pur_base_model_barcode==1){
                 if($item_info->_unique_barcode ==1){
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                    }else{
                        if($barcode_string !=''){
                            $ProductPriceList->_barcode = $barcode_string.$purchase_id;
                            $PurchaseD = DamageReceiveDetail::find($_purchase_detail_id);
                            $PurchaseD->_barcode = $barcode_string.$purchase_id;
                            $PurchaseD->save();
                        }
                    }
            }else{
                 if($barcode_string ==''){
                    $barcode_string = $item_info->_barcode ?? '';
                }
                $ProductPriceList->_barcode =$barcode_string ?? '';
            }
               
                
                $ProductPriceList->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $ProductPriceList->_input_type = 'damage_receive';
                $ProductPriceList->_transection = 'damage_receive_from_customer';

                $ProductPriceList->_expire_date = $_expire_dates[$i] ?? null;
                $ProductPriceList->_qty = ($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_pur_rate = ($_rates[$i] / $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_sales_rates[$i] / $conversion_qtys[$i] ?? 1);

                //Unit Conversion section
                $ProductPriceList->_transection_unit = $_transection_units[$i] ?? 1;
                $ProductPriceList->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ProductPriceList->_base_unit = $_base_unit_ids[$i] ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;


                
                
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $_discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_vat_amounts[$i] ?? 0;
                $ProductPriceList->_value =$_values[$i] ?? 0;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_transection_ref = $purchase_id;
                $ProductPriceList->_transection_detail_ref_id =$_purchase_detail_id;
                $ProductPriceList->organization_id = $organization_id ?? 1;
                $ProductPriceList->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ProductPriceList->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ProductPriceList->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ProductPriceList->_store_id = $_store_ids[$i] ?? 1;
                $ProductPriceList->_status =1;
                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                $_unique_barcode =  $ProductPriceList->_unique_barcode;

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
                               $_return=0;
                               $p=0;
                               foreach ($barcode_array as $_b_v) {
                                _barcode_insert_update('BarcodeDetail',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                _barcode_insert_update('DamageReceiveBarcode',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                 
                               }
                            }
                     }else{
                       $_qty = $ProductPriceList->_qty ?? 0;
                       $_stat = 1;
                       $_return=0;
                       $p=0;
                       $_b_v=$ProductPriceList->_barcode ?? '';

                        _barcode_insert_update('BarcodeDetail',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                        _barcode_insert_update('DamageReceiveBarcode',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);

                     }
                

                
/*
    Barcode insert into database section
*/


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

        $PurchaseFormSettings = DamageReceiveFormSetting::first();
        $_default_inventory = $PurchaseFormSettings->_default_inventory;
        $_default_purchase = $PurchaseFormSettings->_default_purchase;
        $_default_discount = $PurchaseFormSettings->_default_discount;
        $_default_vat_account = $PurchaseFormSettings->_default_vat_account;

        $_ref_master_id=$purchase_id;
        $_ref_detail_id=$purchase_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'damage_receive_masters';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =   $request->_cost_center_id;
        $_name =$users->name;
        
        if($__sub_total > 0){

            //Default Purchase
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id);

            //Default Inventory
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$__sub_total,0,$_branch_id,$_cost_center,$_name,3,$organization_id);
            //Default Purchase 
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,0,$__sub_total,$_branch_id,$_cost_center,$_name,4,$organization_id);
        }

        if($__total_discount > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__total_discount,0,$_branch_id,$_cost_center,$_name,5,$organization_id);
             //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,0,$__total_discount,$_branch_id,$_cost_center,$_name,6,$organization_id);
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,$__total_vat,0,$_branch_id,$_cost_center,$_name,7,$organization_id);
        //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_vat,$_branch_id,$_cost_center,$_name,8,$organization_id);
        
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

        $_ledger_id =  $request->_ledger_id ?? [];
        $_short_narr =  $request->_short_narr ?? [];
        $_dr_amount =  $request->_dr_amount ?? [];
         $_cr_amount =  $request->_cr_amount ?? [];
        $_branch_id_detail =  $request->_branch_id_detail ?? [];
        $_cost_center =  $request->_cost_center ?? [];
       
        if(sizeof($_ledger_id) > 0){
                foreach($_ledger_id as $i=>$ledger) {
                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;

                        $PurchaseAccount = new DamageReceiveAccount();
                        $PurchaseAccount->_no = $purchase_id;
                        $PurchaseAccount->_account_type_id = $_account_type_id;
                        $PurchaseAccount->_account_group_id = $_account_group_id;
                        $PurchaseAccount->_ledger_id = $ledger;
                        $PurchaseAccount->_cost_center = $_cost_center[$i] ?? 0;
                        $PurchaseAccount->organization_id = $organization_id ?? 1;
                        $PurchaseAccount->_branch_id = $_branch_id_detail[$i] ?? 0;
                        $PurchaseAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $PurchaseAccount->_dr_amount = $_dr_amount[$i];
                        $PurchaseAccount->_cr_amount = $_cr_amount[$i];
                        $PurchaseAccount->_status = 1;
                        $PurchaseAccount->_created_by = $users->id."-".$users->name;
                        $PurchaseAccount->save();

                        $purchase_detail_id = $PurchaseAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$purchase_detail_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'damage_receive_masters';
                        $_date = change_date_format($request->_date);
                        $_table_name ='damage_receive_accounts';
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
                if($_total_cr_amount > 0 && $users->_ac_type==1){
                        $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $PurchaseAccount = new DamageReceiveAccount();
                        $PurchaseAccount->_no = $purchase_id;
                        $PurchaseAccount->_account_type_id = $_account_type_id;
                        $PurchaseAccount->_account_group_id = $_account_group_id;
                        $PurchaseAccount->_ledger_id = $request->_main_ledger_id;
                        $PurchaseAccount->_cost_center = $request->_cost_center_id;
                        $PurchaseAccount->_branch_id = $request->_branch_id;
                        $PurchaseAccount->organization_id = $organization_id;
                        $PurchaseAccount->_short_narr = 'N/A';
                        $PurchaseAccount->_dr_amount = $_total_cr_amount;
                        $PurchaseAccount->_cr_amount = 0;
                        $PurchaseAccount->_status = 1;
                        $PurchaseAccount->_created_by = $users->id."-".$users->name;
                        $PurchaseAccount->save();

 
                        $_sales_account_id = $PurchaseAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'damage_receive_masters';
                        $_date = change_date_format($request->_date);
                        $_table_name ='damage_receive_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = $_total_cr_amount;
                        $_cr_amount_a =  0;
                        $_branch_id_a = $request->_branch_id ?? 1;
                        $_cost_center_a = $request->_cost_center_id ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20),$organization_id);
                }
            }

             
            $_l_balance = _l_balance_update($request->_main_ledger_id);
            $_pfix = damage_receive_pfix().$purchase_id;

            $_main_branch_id = $request->_branch_id;
            $__table="damage_receive_masters";
            $_pfix = make_order_number($__table,$organization_id,$_main_branch_id,$request->_date);


             \DB::table('damage_receive_masters')
             ->where('id',$purchase_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);
               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){

                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Dear ".$_name.", Invoice N0.".$_pfix." Invoice Amount: ".prefix_taka()."."._report_amount($request->_total).". Payment Amount. ".prefix_taka()."."._report_amount($_total_cr_amount).". Previous Balance ".prefix_taka()."."._report_amount($_p_balance).". Current Balance:".prefix_taka()."."._report_amount($_l_balance);
                sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

          DB::commit();
            return redirect()->back()->with('success','Information save successfully')->with('_master_id',$purchase_id)->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }

       
    }
public function damage_receivePrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
         $data =  DamageReceiveMaster::with(['_master_branch','_master_details','purchase_account','_ledger'])->find($id);
        $form_settings = DamageReceiveFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));

         if($form_settings->_invoice_template==1){
            return view('backend.damage_receive.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.damage_receive.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==3){
            return view('backend.damage_receive.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==4){
           return view('backend.damage_receive.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }else{
            return view('backend.damage_receive.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }

       
    }

    public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = DamageReceiveMaster::with(['_master_branch','purchase_account','_ledger'])->find($id);

       return view('backend.damage_receive.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DamageReceiveMaster  $damageReceiveMaster
     * @return \Illuminate\Http\Response
     */
    public function show(DamageReceiveMaster $damageReceiveMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DamageReceiveMaster  $damageReceiveMaster
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
        //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = DamageReceiveFormSetting::first();
        $inv_accounts = AccountLedger::select('id','_name','_account_group_id','_code','_account_head_id','_phone','_balance','_address','_credit_limit','_alious')->orderBy('_name','ASC')->get();
        $p_accounts = $inv_accounts;
        $dis_accounts =$p_accounts;
        $capital_accounts = $inv_accounts;
        
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $data =  DamageReceiveMaster::with(['_master_branch','_master_details','purchase_account','_ledger'])->where('_lock',0)->find($id);
         
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }
          $sales_number = '';
       return view('backend.damage_receive.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','data','sales_number'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DamageReceiveMaster  $damageReceiveMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         
      // return $request->all();
        $all_req= $request->all();
        $this->validate($request, [
            '_purchase_id' => 'required',
            '_form_name' => 'required',
            '_date' => 'required',
            '_main_ledger_id' => 'required',
        ]);



       //######################
       // Previous information need to make zero for every thing.
       //#####################
     $purchase_id = $request->_purchase_id;
     $data =  DamageReceiveMaster::where('_lock',0)->find($purchase_id); 
     if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }


     // $sales_number = SalesDetail::where('_purchase_invoice_no',$purchase_id)->count();
      $sales_number = 0;
    

    //###########################
    // Purchase Master information Save Start
    //###########################
      // DB::beginTransaction();
      //   try {

    if($sales_number == 0 ){
    DamageReceiveDetail::where('_no', $purchase_id)
            ->update(['_status'=>0]);
    DamageItemHistory::where('_master_id',$purchase_id)
                    ->update(['_status'=>0]);
    
    }
    DamageReceiveAccount::where('_no',$purchase_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$purchase_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]); 
    Accounts::where('_ref_master_id',$purchase_id)
                    ->where('_table_name','damage_receive_accounts')
                     ->update(['_status'=>0]); 

    $_p_balance = _l_balance_update($request->_main_ledger_id); 
    if($sales_number == 0 ){  
    _barcode_status("BarcodeDetail",$purchase_id);          
    _barcode_status("DamageReceiveBarcode",$purchase_id); 
    }  

    $organization_id = $request->organization_id ?? 1;      

    //###########################
    // Purchase Master information Save Start
    //###########################
       $_print_value = $request->_print ?? 0;
       $users = Auth::user();
        $Purchase = DamageReceiveMaster::where('id',$purchase_id)->first();
        if(empty($Purchase)){
            return redirect()->back()->with('danger','Something Went Wrong !');
        }
        $Purchase->_date = change_date_format($request->_date);
        $Purchase->_time = date('H:i:s');
        $Purchase->_order_ref_id = $request->_order_ref_id;
        $Purchase->_referance = $request->_referance;
        $Purchase->_ledger_id = $request->_main_ledger_id;
        $Purchase->_user_id = $users->id;
        $Purchase->_created_by = $users->id."-".$users->name;
        $Purchase->_updated_by = $users->id."-".$users->name;
        $Purchase->_user_id = $users->id;
        $Purchase->_user_name = $users->name;
        $Purchase->_note = $request->_note;
        $Purchase->_sub_total = $request->_sub_total;
        $Purchase->_discount_input = $request->_discount_input;
        $Purchase->_total_discount = $request->_total_discount;
        $Purchase->_total_vat = $request->_total_vat;
        $Purchase->_total = $request->_total;
        $Purchase->organization_id = $organization_id;
        $Purchase->_branch_id = $request->_branch_id;
        $Purchase->_cost_center_id = $request->_cost_center_id ?? 1;

        $Purchase->_address = $request->_address;
        $Purchase->_phone = $request->_phone;
        $Purchase->_status = 1;
        $Purchase->_lock = $request->_lock ?? 0;
        $Purchase->save();
        $purchase_id = $Purchase->id;

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
        $purchase_detail_ids = $request->purchase_detail_id;
        $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;

        $_discounts = $request->_discount ?? [];
        $_discount_amounts =$request->_discount_amount ?? [];
        $_short_notes =$request->_short_note ?? [];


        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];

        
if($sales_number == 0 ){
        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $item_info = Inventory::where('id',$_item_ids[$i])->first();
                
                if($purchase_detail_ids[$i] ==0){
                    $PurchaseDetail = new DamageReceiveDetail();
                    $PurchaseDetail->_created_by = $users->id."-".$users->name;
                }else{
                    $PurchaseDetail = DamageReceiveDetail::where('id',$purchase_detail_ids[$i])->first();
                }
                $PurchaseDetail->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $PurchaseDetail->_expire_date = $_expire_dates[$i] ?? null;

                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                
                if($barcode_string ==''){
                    $barcode_string = $item_info->_barcode ?? '';
                }

                $PurchaseDetail->_barcode = $barcode_string;
                $PurchaseDetail->_item_id = $_item_ids[$i];
                $PurchaseDetail->_qty = $_qtys[$i];

                $PurchaseDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $PurchaseDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $PurchaseDetail->_base_unit = $_base_unit_ids[$i] ?? 1;

                $PurchaseDetail->_short_note = $_short_notes[$i] ?? '';
                $PurchaseDetail->_rate = $_rates[$i];
                $PurchaseDetail->_sales_rate = $_sales_rates[$i];
                $PurchaseDetail->_discount = $_discounts[$i] ?? 0;
                $PurchaseDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $PurchaseDetail->_vat = $_vats[$i] ?? 0;
                $PurchaseDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $PurchaseDetail->_value = $_values[$i] ?? 0;
                $PurchaseDetail->_store_id = $_store_ids[$i] ?? 1;
                $PurchaseDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $PurchaseDetail->_store_salves_id = $_store_salves_ids[$i] ?? 1;
                $PurchaseDetail->organization_id = $organization_id ?? 1;
                $PurchaseDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $PurchaseDetail->_no = $purchase_id;
                $PurchaseDetail->_status = 1;
                $PurchaseDetail->_updated_by = $users->id."-".$users->name;
                $PurchaseDetail->save();
                $_purchase_detail_id = $PurchaseDetail->id;

                

                $ProductPriceList = DamageItemHistory::where('_master_id',$purchase_id)
                                    ->where('_purchase_detail_id',$_purchase_detail_id)
                                    ->where('_input_type','damage_receive')
                                    ->first();
                if(empty($ProductPriceList)){
                    $ProductPriceList = new DamageItemHistory();
                    $ProductPriceList->_created_by = $users->id."-".$users->name;
                }
                
               // $ProductPriceList->_barcode =$barcode_string ?? '';

                $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
                if($general_settings->_pur_base_model_barcode==1){
                     if($item_info->_unique_barcode ==1){
                        $ProductPriceList->_barcode =$barcode_string ?? '';
                        }else{
                            if($barcode_string !=''){
                                if($purchase_detail_ids[$i] ==0){
                                $ProductPriceList->_barcode = $barcode_string.$purchase_id;
                                $PurchaseD = PurchaseDetail::find($_purchase_detail_id);
                                $PurchaseD->_barcode = $barcode_string.$purchase_id;
                                $PurchaseD->save();
                                }
                            }
                        }
                }else{
                     if($barcode_string ==''){
                            $barcode_string = $item_info->_barcode ?? '';
                        }
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                }
                
                $ProductPriceList->_date = change_date_format($request->_date);
                 $ProductPriceList->_time = date('H:i:s');
                $ProductPriceList->_input_type = 'damage_receive';
                $ProductPriceList->_transection = 'damage_receive_from_customer';
                $ProductPriceList->_item_id = $_item_ids[$i];
                $ProductPriceList->_item_name = $item_info->_item ?? '';
                $ProductPriceList->_category_id = $item_info->_category_id ?? 0;
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_unit_id =  $item_info->_unit_id ?? 1;
                $ProductPriceList->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $ProductPriceList->_expire_date = $_expire_dates[$i] ?? null;
                $ProductPriceList->_qty = ($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_sales_rates[$i] / $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_pur_rate = ($_rates[$i] / $conversion_qtys[$i] ?? 1);
                 //Unit Conversion section
                $ProductPriceList->_transection_unit = $_transection_units[$i] ?? 1;
                $ProductPriceList->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ProductPriceList->_base_unit = $_base_unit_ids[$i] ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;

                $ProductPriceList->_value =$_values[$i] ?? 0;

                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                
                $ProductPriceList->_transection_detail_ref_id =$_purchase_detail_id;
                $ProductPriceList->_transection_ref = $purchase_id;


                $ProductPriceList->_p_discount_input = $_discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_vat_amounts[$i] ?? 0;
                $ProductPriceList->organization_id = $organization_id ?? 1;
                $ProductPriceList->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ProductPriceList->_store_id = $_store_ids[$i] ?? 1;
                $ProductPriceList->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ProductPriceList->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ProductPriceList->_status =1;
                $ProductPriceList->_updated_by = $users->id."-".$users->name;
                $ProductPriceList->save();



                    $product_price_id =  $ProductPriceList->id;
                    $_unique_barcode =  $ProductPriceList->_unique_barcode;

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
                   $new_and_available_barcodes=[];
                   $_qty = 1;
                   $_stat = 1;
                   $_return=0;
                   $p=0;
                   foreach ($barcode_array as $_b_v) {
                       
                     if(_check_barcode_already_sales($_b_v)=='no'){
                        array_push($new_and_available_barcodes,$_b_v);
                                    _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                    }
                    _barcode_insert_update('DamageReceiveBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                     
                   }
                   $new_available_qty=sizeof($new_and_available_barcodes);
                   $barcode_string = implode(",",$new_and_available_barcodes);
                    DamageItemHistory::where('id',$product_price_id)
                                        ->update(['_qty'=>$new_available_qty,'_barcode'=>$barcode_string]);
        }
}else{
       $_qty = $ProductPriceList->_qty ?? 0;
       $_stat = 1;
       $_return=0;
       $p=0;
       $_b_v=$ProductPriceList->_barcode ?? '';
      _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
      _barcode_insert_update('DamageReceiveBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);

}
               

                 

                
/*
    Barcode insert into database section
*/


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

        $PurchaseFormSettings = DamageReceiveFormSetting::first();
        $_default_inventory = $PurchaseFormSettings->_default_inventory;
        $_default_purchase = $PurchaseFormSettings->_default_purchase;
        $_default_discount = $PurchaseFormSettings->_default_discount;
        $_default_vat_account = $PurchaseFormSettings->_default_vat_account;

        $_ref_master_id=$purchase_id;
        $_ref_detail_id=$purchase_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'damage_receive_masters';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;

        $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;
         $__total_vat = (float) $request->_total_vat ?? 0;
if($__sub_total > 0){

            //Default Purchase
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
        //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__sub_total,$_branch_id,$_cost_center,$_name,2,$organization_id);

            //Default Inventory
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$__sub_total,0,$_branch_id,$_cost_center,$_name,3,$organization_id);
        //Default Purchase 
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,0,$__sub_total,$_branch_id,$_cost_center,$_name,4,$organization_id);
        }

        if($__total_discount > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__total_discount,0,$_branch_id,$_cost_center,$_name,5,$organization_id);
             //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,0,$__total_discount,$_branch_id,$_cost_center,$_name,6,$organization_id);
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7,$organization_id);
        //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8,$organization_id);
        
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

        $_ledger_id =  $request->_ledger_id ?? [];
        $_short_narr =  $request->_short_narr ?? [];
        $_dr_amount =  $request->_dr_amount ?? [];
         $_cr_amount =  $request->_cr_amount ?? [];
        $_branch_id_detail =  $request->_branch_id_detail ?? [];
        $_cost_center =  $request->_cost_center ?? [];
        $purchase_account_ids =  $request->purchase_account_id ?? [];
    
        if(sizeof($_ledger_id) > 0){
                foreach($_ledger_id as $i=>$ledger) {

                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;
                         $PurchaseAccount = DamageReceiveAccount::where('id',$purchase_account_ids[$i] ?? 0)
                                                            ->where('_ledger_id',$ledger)
                                                            ->first();
                        if(empty($PurchaseAccount)){
                            $PurchaseAccount = new DamageReceiveAccount();
                        }
                        
                        $PurchaseAccount->_no = $purchase_id;
                        $PurchaseAccount->_account_type_id = $_account_type_id;
                        $PurchaseAccount->_account_group_id = $_account_group_id;
                        $PurchaseAccount->_ledger_id = $ledger;
                        $PurchaseAccount->_cost_center = $_cost_center[$i] ?? 0;
                        $PurchaseAccount->organization_id = $organization_id ?? 1;
                        $PurchaseAccount->_branch_id = $_branch_id_detail[$i] ?? 0;
                        $PurchaseAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $PurchaseAccount->_dr_amount = $_dr_amount[$i];
                        $PurchaseAccount->_cr_amount = $_cr_amount[$i];
                        $PurchaseAccount->_status = 1;
                        $PurchaseAccount->_updated_by = $users->id."-".$users->name;
                        $PurchaseAccount->save();

                        $purchase_detail_id = $PurchaseAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$purchase_detail_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'damage_receive_masters';
                        $_date = change_date_format($request->_date);
                        $_table_name ='damage_receive_accounts';
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
                if($_total_cr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $PurchaseAccount = new DamageReceiveAccount();
                        $PurchaseAccount->_no = $purchase_id;
                        $PurchaseAccount->_account_type_id = $_account_type_id;
                        $PurchaseAccount->_account_group_id = $_account_group_id;
                        $PurchaseAccount->_ledger_id = $request->_main_ledger_id;
                        $PurchaseAccount->organization_id = $organization_id;
                        $PurchaseAccount->_branch_id = $request->_branch_id;
                        $PurchaseAccount->_cost_center = $request->_cost_center_id;
                        $PurchaseAccount->_short_narr = 'N/A';
                        $PurchaseAccount->_dr_amount = $_total_cr_amount;
                        $PurchaseAccount->_cr_amount = 0;
                        $PurchaseAccount->_status = 1;
                        $PurchaseAccount->_created_by = $users->id."-".$users->name;
                        $PurchaseAccount->save();

 
                        $_sales_account_id = $PurchaseAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$purchase_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'damage_receive_masters';
                        $_date = change_date_format($request->_date);
                        $_table_name ='damage_receive_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = $_total_cr_amount;
                        $_cr_amount_a = 0;
                        $_branch_id_a = $request->_branch_id ?? 1;
                        $_cost_center_a = $request->_cost_center_id ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20),$organization_id);
                }
            }

             
            $_l_balance = _l_balance_update($request->_main_ledger_id);
            $_pfix = $request->_order_number ?? damage_receive_pfix().$purchase_id;

             \DB::table('damage_receive_masters')
             ->where('id',$purchase_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

             //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Dear ".$_name.", Invoice N0.".$_pfix." Invoice Amount: ".prefix_taka()."."._report_amount($request->_total).". Payment Amount. ".prefix_taka()."."._report_amount($_total_cr_amount).". Previous Balance ".prefix_taka()."."._report_amount($_p_balance).". Current Balance:".prefix_taka()."."._report_amount($_l_balance);
                sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

            //   DB::commit();
        if(($request->_lock ?? 0) ==1){
                return redirect('damage_receive/print/'.$purchase_id)
                ->with('success','Information save successfully');
          }else{
            return redirect()->back()
            ->with('success','Information save successfully')
            ->with('_master_id',$purchase_id)
            ->with('_print_value',$_print_value);
          }

        
       // } catch (\Exception $e) {
       //     DB::rollback();
       //     return redirect()->back()->with('danger','There is Something Wrong !');
       //  }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DamageReceiveMaster  $damageReceiveMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(DamageReceiveMaster $damageReceiveMaster)
    {
        //
    }
}
