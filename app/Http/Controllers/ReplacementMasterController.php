<?php

namespace App\Http\Controllers;

use App\Models\ReplacementMaster;
use App\Models\AccountHead;
use App\Models\AccountGroup;
use App\Models\ReplacementFormSetting;
use App\Models\StoreHouse;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\Units;
use App\Models\Warranty;
use App\Models\ItemCategory;
use App\Models\AccountLedger;
use App\Models\WarrantyMaster;
use App\Models\WarrantyDetail;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ReplacementItemAccount;
use App\Models\ReplacementItemOut;
use App\Models\ReplacementItemIn;
use App\Models\RepOutBarcode;
use App\Models\ProductPriceList;
use App\Models\GeneralSettings;
use App\Models\RepInBarcode;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;





class ReplacementMasterController extends Controller
{

          function __construct()
    {
         $this->middleware('permission:sales-list|sales-create|sales-edit|sales-delete|sales-print', ['only' => ['index','store']]);
         $this->middleware('permission:sales-print', ['only' => ['salesPrint']]);
         $this->middleware('permission:sales-create', ['only' => ['create','store']]);
         $this->middleware('permission:sales-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sales-delete', ['only' => ['destroy']]);
         $this->page_name = "Item Replacement";
    }

     public function reset(){
        Session::flash('_replacement_limit');
       return  \Redirect::to('item-replace?limit='.default_pagination());
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
            session()->put('_replacement_limit', $request->limit);
        }else{
             $limit= \Session::get('_replacement_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

      
       

      $datas = ReplacementMaster::with(['_master_branch','_ledger'])->where('_status',1);
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
            $datas = $datas->where('_order_ref_id','like',"%trim($request->_order_ref_id)%");
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

        if($request->has('_sales_man_id') && $request->_sales_man_id !=''){
            $datas = $datas->where('_sales_man_id','=',$request->_sales_man_id);
        }

        if($request->has('_sales_type') && $request->_sales_type !=''){
            $datas = $datas->where('_sales_type','=',$request->_sales_type);
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
           $form_settings = ReplacementFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.item-replace.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.item-replace.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.item-replace.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }


     public function challanPrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
          $data = ReplacementMaster::with(['_master_details','s_account','_master_in_details','_delivery_man','_sales_man'])->find($id); 
        $form_settings = ReplacementFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        
            return view('backend.item-replace.challan',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
        
       
    }

    public function Print($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data = ReplacementMaster::with(['_master_details','s_account','_master_in_details','_delivery_man','_sales_man','_ledger','_warranty_detail'])->find($id); 
        $form_settings = ReplacementFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();


 
        $history_sales_invoices = [];
        
            return view('backend.item-replace.customer_delilvery_report',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices'));
         
       
    }


     public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = ReplacementMaster::with(['_master_details','s_account','_master_in_details','_delivery_man','_sales_man'])->find($id); 

       return view('backend.item-replace.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data'));
    }

     public function formSettingAjax(){
        $form_settings = ReplacementFormSetting::first();
        $inv_accounts = AccountLedger::where('_account_head_id',2)->get();
        $p_accounts = AccountLedger::where('_account_head_id',8)->get();
        $dis_accounts = AccountLedger::whereIn('_account_head_id',[10,5])->get();
        $cost_of_solds = AccountLedger::where('_account_head_id',9)->get();
        $_cash_customers = AccountLedger::whereIn('_account_head_id',[12,13])->get();
        return view('backend.item-replace.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds','_cash_customers'));
    }

    public function Settings (Request $request){
        $data = ReplacementFormSetting::first();
        if(empty($data)){
            $data = new ReplacementFormSetting();
        }

        
        $data->_default_inventory = $request->_default_inventory;
        $data->_default_warranty_charge = $request->_default_warranty_charge;
        $data->_default_sales = $request->_default_sales;
        $data->_default_discount = $request->_default_discount;
        $data->_default_cost_of_solds = $request->_default_cost_of_solds;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_show_delivery_man = $request->_show_delivery_man ?? 1;
        $data->_show_sales_man = $request->_show_sales_man ?? 1;
        $data->_show_cost_rate = $request->_show_cost_rate ?? 1;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 1;
        $data->_show_expire_date = $request->_show_expire_date ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_show_warranty =$request->_show_warranty ?? 0;
        $data->save();


        return redirect()->back();
                       

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
        $store_houses = StoreHouse::select('id','_name')->whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ReplacementFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
        return view('backend.item-replace.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties'));
        
    }


    public function orderSearch(Request $request){
    //  return "ol";
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_date';
        $text_val = $request->_text_val;
        $_branch_id = $request->_branch_id;
        $datas = WarrantyMaster::with(['_ledger']);
         if($request->has('_text_val') && $request->_text_val !=''){
            $datas = $datas->where('_phone','like',"%$request->_text_val%")
            ->orWhere('id','like',"%$request->_text_val%")
            ->orWhere('_order_number','like',"%$request->_text_val%");
        }
         $datas = $datas->where('_status',1)
                 ->where('_waranty_status',6)
                 ->where('_branch_id',$_branch_id);
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }

     public function purchaseOrderDetails(Request $request){
        $this->validate($request, [
            '_purchase_main_id' => 'required',
        ]);
        $_purchase_main_id = $request->_purchase_main_id;

       $datas = WarrantyDetail::with(['_detail_branch','_detail_cost_center','_store','_items'])
                                ->where('_no',$_purchase_main_id)
                                ->where('_status',1)
                                ->get();
      
        
        return json_encode( $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      


        $all_req= $request->all();
       $users = Auth::user();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_order_ref_id' => 'required',
            '_form_name' => 'required'
        ]);

          $SalesFormSetting = ReplacementFormSetting::first();

            $_item_ids = $request->_item_id;
            $_barcodes = $request->_barcode ?? [];
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

         DB::beginTransaction();
         try {

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
         
        $ReplacementMaster = new ReplacementMaster();
        $ReplacementMaster->_date = change_date_format($request->_date);
        $ReplacementMaster->_time = date('H:i:s');
        $ReplacementMaster->_order_ref_id = $request->_order_ref_id;
        $ReplacementMaster->_order_number = $request->_order_number ?? '';
        $ReplacementMaster->_referance = $request->_referance;
        $ReplacementMaster->_ledger_id = $request->_main_ledger_id;
        $ReplacementMaster->_user_id = $users->id;
        $ReplacementMaster->_created_by = $users->id."-".$users->name;
        $ReplacementMaster->_user_id = $users->id;
        $ReplacementMaster->_user_name = $users->name;
        $ReplacementMaster->_note = $request->_note;
        $ReplacementMaster->_sub_total = $__sub_total;
        $ReplacementMaster->_discount_input = $__discount_input;
        $ReplacementMaster->_total_discount = $__total_discount;
        $ReplacementMaster->_total_vat = $request->_total_vat;
        $ReplacementMaster->_total =  $__total;
        $ReplacementMaster->_branch_id = $request->_branch_id;
        $ReplacementMaster->_cost_center_id = $request->_cost_center_id ?? 1;
        $ReplacementMaster->_address = $request->_address;
        $ReplacementMaster->_phone = $request->_phone;
        $ReplacementMaster->_delivery_man_id = $request->_delivery_man_id ?? 0;
        $ReplacementMaster->_sales_man_id = $request->_sales_man_id ?? 0;
        $ReplacementMaster->_sales_type = $request->_sales_type ?? 'replacement';
        $ReplacementMaster->_status = 1;
        $ReplacementMaster->_lock = $request->_lock ?? 0;

        $ReplacementMaster->save();
        $_master_id = $ReplacementMaster->id;             

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        

        //Old Item Store In 
        $_old_item_ids = $request->_old_item_id ?? [];
        $_old_ref_counters = $request->_old_ref_counter ?? [];
        $_warranty_reasons = $request->_warranty_reason ?? [];
        $_old_sales_detail_ids = $request->_old_sales_detail_id ?? [];
        $_warranty_row_ids = $request->_warranty_row_id ?? [];
        $_order_ref_id = $request->_order_ref_id ?? 0;

        if(sizeof($_warranty_row_ids) > 0){
          for ($i=0; $i <sizeof($_warranty_row_ids) ; $i++) { 
              $old_item_details = WarrantyDetail::where('_no',$_order_ref_id)
                                  ->where('id',$_warranty_row_ids[$i])
                                  ->first();
              $_p_p_l_id = $old_item_details->_p_p_l_id;

      $barcode_string=$all_req[$_old_ref_counters[$i]."_old_barcode__".$_old_item_ids[$i]] ?? '';


              $ReplacementItemIn = new ReplacementItemIn();
              $ReplacementItemIn->_no = $_master_id;
              $ReplacementItemIn->_complain_detail_row_id = $_warranty_row_ids[$i];
              $ReplacementItemIn->_p_p_l_id = $_p_p_l_id;
              $ReplacementItemIn->_item_id = $old_item_details->_item_id ?? 0;
              $ReplacementItemIn->_qty = $old_item_details->_qty ?? 0;
              $ReplacementItemIn->_rate = $old_item_details->_rate ?? 0;
              $ReplacementItemIn->_sales_rate = $old_item_details->_sales_rate ?? 0;
              $ReplacementItemIn->_discount = $old_item_details->_discount ?? 0;
              $ReplacementItemIn->_discount_amount = $old_item_details->_discount_amount ?? 0;
              $ReplacementItemIn->_warranty_reason = $old_item_details->_warranty_reason ?? '';
              $ReplacementItemIn->_vat = $old_item_details->_vat ?? 0;
              $ReplacementItemIn->_vat_amount = $old_item_details->_vat_amount ?? 0;
              $ReplacementItemIn->_sd = $old_item_details->_sd ?? 0;
              $ReplacementItemIn->_sd_amount = $old_item_details->_sd_amount ?? 0;
              $ReplacementItemIn->_cd = $old_item_details->_cd ?? 0;
              $ReplacementItemIn->_cd_amount = $old_item_details->_cd_amount ?? 0;
              $ReplacementItemIn->_ait = $old_item_details->_ait ?? 0;
              $ReplacementItemIn->_ait_amount = $old_item_details->_ait_amount ?? 0;
              $ReplacementItemIn->_rd = $old_item_details->_rd ?? 0;
              $ReplacementItemIn->_rd_amount = $old_item_details->_rd_amount ?? 0;
              $ReplacementItemIn->_at = $old_item_details->_at ?? 0;
              $ReplacementItemIn->_at_amount = $old_item_details->_at_amount ?? 0;
              $ReplacementItemIn->_tti = $old_item_details->_tti ?? 0;
              $ReplacementItemIn->_tti_amount = $old_item_details->_tti_amount ?? 0;
              $ReplacementItemIn->_value = $old_item_details->_value ?? 0;
              $ReplacementItemIn->_store_id = $old_item_details->_store_id ?? 0;
              $ReplacementItemIn->_cost_center_id = $old_item_details->_cost_center_id ?? 0;
              $ReplacementItemIn->_store_salves_id = $old_item_details->_store_salves_id ?? 0;
              $ReplacementItemIn->_manufacture_date = $old_item_details->_manufacture_date ?? '';
              $ReplacementItemIn->_expire_date = $old_item_details->_expire_date ?? '';
              $ReplacementItemIn->_branch_id = $old_item_details->_branch_id ?? 1;
              $ReplacementItemIn->_barcode = $barcode_string ?? 1;
              $ReplacementItemIn->_status = 1;
              $ReplacementItemIn->_created_by = $users->id."-".$users->name;
              $ReplacementItemIn->save();


              $_purchase_detail_id = $ReplacementItemIn->id;
              $purchase_id = $_master_id;

               



                $item_info = Inventory::where('id',$_old_item_ids[$i])->first();
                $ProductPriceList = new ProductPriceList();
                $ProductPriceList->_item_id = $_old_item_ids[$i];
                $ProductPriceList->_item = $item_info->_item ?? '';

            
            $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
            if($general_settings->_pur_base_model_barcode==1){
                 if($item_info->_unique_barcode ==1){
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                    }else{
                        if($barcode_string !=''){
                            $ProductPriceList->_barcode = $barcode_string.$purchase_id;
                            $PurchaseD = PurchaseDetail::find($_purchase_detail_id);
                            $PurchaseD->_barcode = $barcode_string.$purchase_id;
                            $PurchaseD->save();
                        }
                    }
            }else{
                $ProductPriceList->_barcode =$barcode_string ?? '';
            }
               
                
                $ProductPriceList->_manufacture_date =$old_item_details->_manufacture_date ?? null;

                $ProductPriceList->_expire_date = $old_item_details->_expire_date ?? null;
                $ProductPriceList->_qty = $old_item_details->_qty ?? 1;
                $ProductPriceList->_sales_rate = $old_item_details->_sales_rate ?? 0;
                $ProductPriceList->_pur_rate = $old_item_details->_rate ?? 0;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = "replacement";
                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $old_item_details->_discount ?? 0;
                $ProductPriceList->_p_discount_amount = $old_item_details->_discount_amount ?? 0;
                $ProductPriceList->_p_vat = $old_item_details->_vat ?? 0;
                $ProductPriceList->_p_vat_amount = $old_item_details->_vat_amount ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$old_item_details->_value ?? 0;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->_branch_id = $old_item_details->_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $old_item_details->_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = $old_item_details->_store_salves_id ?? '';
                $ProductPriceList->_store_id = $old_item_details->_store_id ?? 1;
                $ProductPriceList->_status =1;
                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                $_unique_barcode =  $ProductPriceList->_unique_barcode;

                     if($_unique_barcode ==1){
                         if($barcode_string !=""){

                               $barcode_array=  explode(",",$barcode_string);
                               $_qty = 1;
                               $_stat = 1;
                               $_return=0;
                               $p=0;
                               foreach ($barcode_array as $_b_v) {
                                _barcode_insert_update('BarcodeDetail',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                _barcode_insert_update('RepInBarcode',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                 
                               }
                            }
                     }
                


                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $old_item_details->_item_id;
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($old_item_details->_item_id);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Replacement In";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;
                $ItemInventory->_qty = $old_item_details->_qty;
                $ItemInventory->_rate = $old_item_details->_sales_rate ?? 0;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                $ItemInventory->_cost_rate = $old_item_details->_rate ?? 0;
                $ItemInventory->_cost_value = ($old_item_details->_qty*$old_item_details->_rate);
                $ItemInventory->_value = $old_item_details->_value ?? 0;
                $ItemInventory->_branch_id = $old_item_details->_branch_id ?? 1;
                $ItemInventory->_store_id = $old_item_details->_store_id ?? 1;
                $ItemInventory->_cost_center_id = $old_item_details->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $old_item_details->_store_salves_id ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                _inventory_last_price($old_item_details->_item_id,$old_item_details->_rate,$old_item_details->_sales_rate);

                inventory_stock_update($old_item_details->_item_id);

              
          }
          
        } //End of Stock In



       
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $_total_cost_value += ($_rates[$i]*$_qtys[$i]);

                $SalesDetail = new ReplacementItemOut();
                $SalesDetail->_item_id = $_item_ids[$i];
                $SalesDetail->_p_p_l_id = $_p_p_l_ids[$i];
                $SalesDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $SalesDetail->_purchase_detail_id = $_purchase_detail_ids[$i];
                $SalesDetail->_qty = $_qtys[$i];

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_p_p_l_ids[$i]] ?? '';
                $SalesDetail->_barcode = $barcode_string;

                $SalesDetail->_manufacture_date = $_manufacture_dates[$i];
                $SalesDetail->_expire_date = $_expire_dates[$i];
                $SalesDetail->_rate = $_rates[$i];
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
                $SalesDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $SalesDetail->_no = $_master_id;
                $SalesDetail->_status = 1;
                $SalesDetail->_created_by = $users->id."-".$users->name;
                $SalesDetail->save();
                $_sales_details_id = $SalesDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();
                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                $_p_qty = $ProductPriceList->_qty;
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
                $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();


/***************************************
   Barcode insert into database section
   _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
   IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
   [  $data->_no_id = $_no_id; $data->_no_detail_id = $_no_detail_id; ] use  $p=1;
**************************************************/
                 $product_price_id =  $ProductPriceList->id;
             if($_unique_barcode ==1){
                  if($barcode_string !=""){
                       $barcode_array=  explode(",",$barcode_string);
                       $_qty = 1;
                       $_stat = 1;
                       $_return=1;
                       
                       foreach ($barcode_array as $_b_v) {
                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                        _barcode_insert_update('RepOutBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                         
                       }
                    }
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
                $ItemInventory->_transection = "Replacement";
                $ItemInventory->_transection_ref = $_master_id;
                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;
                $ItemInventory->_qty = -($_qtys[$i]);
                $ItemInventory->_rate = $_sales_rates[$i];
                $ItemInventory->_cost_rate = $_rates[$i];
                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                $ItemInventory->_expire_date = $_expire_dates[$i];
                $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);
                $ItemInventory->_value = $_values[$i] ?? 0;
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
        $_transaction= 'Replacement';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  1;
        $_name =$users->name;
        
        if($__total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //Default Sales DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__total,0,$_branch_id,$_cost_center,$_name,1);
           //Default Account Receivable  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__total,$_branch_id,$_cost_center,$_name,2);

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6);
             
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8);
        
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

                        $SalesAccount = new ReplacementItemAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $ledger;
                        $SalesAccount->_cost_center = $_cost_center[$i] ?? 0;
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
                        $_transaction= 'Replacement';
                        $_date = change_date_format($request->_date);
                        $_table_name ='replacement_item_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id_detail[$i] ?? 0;
                        $_cost_center_a = $_cost_center[$i] ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i));
                          
                    }


                }
            
                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $SalesAccount = new ReplacementItemAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $request->_main_ledger_id;
                        $SalesAccount->_cost_center = $users->cost_center_ids;
                        $SalesAccount->_branch_id = $users->branch_ids;
                        $SalesAccount->_short_narr = 'Replacement Payment';
                        $SalesAccount->_dr_amount = 0;
                        $SalesAccount->_cr_amount = $_total_dr_amount;
                        $SalesAccount->_status = 1;
                        $SalesAccount->_created_by = $users->id."-".$users->name;
                        $SalesAccount->save();

 
                        $_sales_account_id = $SalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='Replacement Payment';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Replacement';
                        $_date = change_date_format($request->_date);
                        $_table_name ='replacement_item_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a = $_total_dr_amount ?? 0;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20));
                }
            }

          $_l_balance = _l_balance_update($request->_main_ledger_id);
          $_pfix = _replace_prefix().$_master_id;
             \DB::table('replacement_masters')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Dear ".$_name.", Date: ".$request->_date." Invoice N0.".$_pfix." Invoice Amount: ".prefix_taka()."."._report_amount($request->_total).". Payment Amount. ".prefix_taka()."."._report_amount($_total_dr_amount).". Previous Balance ".prefix_taka()."."._report_amount($_p_balance).". Current Balance:".prefix_taka()."."._report_amount($_l_balance);
                  sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

    

           DB::commit();
            return redirect()->back()
                ->with('success','Information save successfully')
                ->with('_master_id',$_master_id)
                ->with('_print_value',$_print_value)
                ->with('_sales_man_id',$_sales_man_id)
                ->with('sales_man_name_leder',$sales_man_name_leder)
                ->with('_delivery_man_id',$_delivery_man_id)
                ->with('delivery_man_name_leder',$delivery_man_name_leder);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()
           ->with('request',$request->all())
           ->with('danger','There is Something Wrong !');
        }


    }

     public function invoiceWiseDetail(Request $request){
         $users = Auth::user();
        $invoice_id = $request->invoice_id;
        $key = $request->_attr_key;
        $data = ReplacementMaster::with(['_master_details','s_account','_master_in_details'])->where('id',$invoice_id)->first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
          $form_settings = ReplacementFormSetting::first();

        return view('backend.item-replace.sales_details',compact('data','permited_branch','permited_costcenters','store_houses','key','form_settings'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReplacementMaster  $replacementMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ReplacementMaster $replacementMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReplacementMaster  $replacementMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $store_houses = StoreHouse::select('id','_name')->whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ReplacementFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
         $data = ReplacementMaster::with(['_master_details','s_account','_master_in_details','_delivery_man','_sales_man'])->find($id);


        return view('backend.item-replace.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReplacementMaster  $replacementMaster
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
    {

      


         $all_req= $request->all();
       $users = Auth::user();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_order_ref_id' => 'required',
            '_replacement_id' => 'required',
            '_form_name' => 'required'
        ]);

          $SalesFormSetting = ReplacementFormSetting::first();
            $_sales_id = $request->_replacement_id;
            $_item_ids = $request->_item_id;
            $_barcodes = $request->_barcode ?? [];
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

         DB::beginTransaction();
         try {

      ReplacementItemIn::where('_no', $_sales_id)
            ->update(['_status'=>0]);
      ReplacementItemOut::where('_no', $_sales_id)
            ->update(['_status'=>0]);
    ItemInventory::where('_transection',"Replacement")
        ->where('_transection_ref',$_sales_id)
        ->update(['_status'=>0]);
    ReplacementItemAccount::where('_no',$_sales_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name','Replacement')
                     ->update(['_status'=>0]);  
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name','replacement_item_accounts')
                     ->update(['_status'=>0]);  

    RepOutBarcode::where('_no_id',$_sales_id)
                  ->update(['_status'=>0,'_qty'=>0]);
    RepInBarcode::where('_no_id',$_sales_id)
                  ->update(['_status'=>0,'_qty'=>0]);

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
         
        $ReplacementMaster = ReplacementMaster::find($_sales_id);
        $ReplacementMaster->_date = change_date_format($request->_date);
        $ReplacementMaster->_time = date('H:i:s');
        $ReplacementMaster->_order_ref_id = $request->_order_ref_id;
        $ReplacementMaster->_order_number = $request->_order_number ?? '';
        $ReplacementMaster->_referance = $request->_referance;
        $ReplacementMaster->_ledger_id = $request->_main_ledger_id;
        $ReplacementMaster->_user_id = $users->id;
        $ReplacementMaster->_created_by = $users->id."-".$users->name;
        $ReplacementMaster->_user_id = $users->id;
        $ReplacementMaster->_user_name = $users->name;
        $ReplacementMaster->_note = $request->_note;
        $ReplacementMaster->_sub_total = $__sub_total;
        $ReplacementMaster->_discount_input = $__discount_input;
        $ReplacementMaster->_total_discount = $__total_discount;
        $ReplacementMaster->_total_vat = $request->_total_vat;
        $ReplacementMaster->_total =  $__total;
        $ReplacementMaster->_branch_id = $request->_branch_id;
        $ReplacementMaster->_address = $request->_address;
        $ReplacementMaster->_phone = $request->_phone;
        $ReplacementMaster->_delivery_man_id = $request->_delivery_man_id ?? 0;
        $ReplacementMaster->_sales_man_id = $request->_sales_man_id ?? 0;
        $ReplacementMaster->_sales_type = $request->_sales_type ?? 'replacement';
        $ReplacementMaster->_status = 1;
        $ReplacementMaster->_lock = $request->_lock ?? 0;

        $ReplacementMaster->save();
        $_master_id = $ReplacementMaster->id;             

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        

        //Old Item Store In 
        $_old_item_ids = $request->_old_item_id ?? [];
        $_old_ref_counters = $request->_old_ref_counter ?? [];
        $_warranty_reasons = $request->_warranty_reason ?? [];
        $_old_sales_detail_ids = $request->_old_sales_detail_id ?? [];
        $_warranty_row_ids = $request->_warranty_row_id ?? [];
        $_complain_detail_row_ids = $request->_complain_detail_row_id ?? [];
        $_order_ref_id = $request->_order_ref_id ?? 0;

        if(sizeof($_warranty_row_ids) > 0){
          for ($i=0; $i <sizeof($_warranty_row_ids) ; $i++) { 
              $old_item_details = WarrantyDetail::where('_no',$_order_ref_id)
                                  ->where('id',$_warranty_row_ids[$i])
                                  ->first();
              $_p_p_l_id = $old_item_details->_p_p_l_id;

      $barcode_string=$all_req[$_old_ref_counters[$i]."_old_barcode__".$_old_item_ids[$i]] ?? '';

              if($_old_sales_detail_ids[$i] ==0){
                $ReplacementItemIn = new ReplacementItemIn();
              }else{
                $ReplacementItemIn = ReplacementItemIn::find($_old_sales_detail_ids[$i]);
              }
              
              $ReplacementItemIn->_no = $_master_id;
              $ReplacementItemIn->_complain_detail_row_id = $_warranty_row_ids[$i];
              $ReplacementItemIn->_p_p_l_id = $_p_p_l_id;
              $ReplacementItemIn->_item_id = $old_item_details->_item_id ?? 0;
              $ReplacementItemIn->_qty = $old_item_details->_qty ?? 0;
              $ReplacementItemIn->_rate = $old_item_details->_rate ?? 0;
              $ReplacementItemIn->_sales_rate = $old_item_details->_sales_rate ?? 0;
              $ReplacementItemIn->_discount = $old_item_details->_discount ?? 0;
              $ReplacementItemIn->_discount_amount = $old_item_details->_discount_amount ?? 0;
              $ReplacementItemIn->_warranty_reason = $old_item_details->_warranty_reason ?? '';
              $ReplacementItemIn->_vat = $old_item_details->_vat ?? 0;
              $ReplacementItemIn->_vat_amount = $old_item_details->_vat_amount ?? 0;
              $ReplacementItemIn->_sd = $old_item_details->_sd ?? 0;
              $ReplacementItemIn->_sd_amount = $old_item_details->_sd_amount ?? 0;
              $ReplacementItemIn->_cd = $old_item_details->_cd ?? 0;
              $ReplacementItemIn->_cd_amount = $old_item_details->_cd_amount ?? 0;
              $ReplacementItemIn->_ait = $old_item_details->_ait ?? 0;
              $ReplacementItemIn->_ait_amount = $old_item_details->_ait_amount ?? 0;
              $ReplacementItemIn->_rd = $old_item_details->_rd ?? 0;
              $ReplacementItemIn->_rd_amount = $old_item_details->_rd_amount ?? 0;
              $ReplacementItemIn->_at = $old_item_details->_at ?? 0;
              $ReplacementItemIn->_at_amount = $old_item_details->_at_amount ?? 0;
              $ReplacementItemIn->_tti = $old_item_details->_tti ?? 0;
              $ReplacementItemIn->_tti_amount = $old_item_details->_tti_amount ?? 0;
              $ReplacementItemIn->_value = $old_item_details->_value ?? 0;
              $ReplacementItemIn->_store_id = $old_item_details->_store_id ?? 0;
              $ReplacementItemIn->_cost_center_id = $old_item_details->_cost_center_id ?? 0;
              $ReplacementItemIn->_store_salves_id = $old_item_details->_store_salves_id ?? 0;
              $ReplacementItemIn->_manufacture_date = $old_item_details->_manufacture_date ?? '';
              $ReplacementItemIn->_expire_date = $old_item_details->_expire_date ?? '';
              $ReplacementItemIn->_branch_id = $old_item_details->_branch_id ?? 1;
              $ReplacementItemIn->_barcode = $barcode_string ?? 1;
              $ReplacementItemIn->_status = 1;
              $ReplacementItemIn->_created_by = $users->id."-".$users->name;
              $ReplacementItemIn->save();


              $_purchase_detail_id = $ReplacementItemIn->id;
              $purchase_id = $_master_id;

               



                $item_info = Inventory::where('id',$_old_item_ids[$i])->first();
                $ProductPriceList = new ProductPriceList();
                $ProductPriceList->_item_id = $_old_item_ids[$i];
                $ProductPriceList->_item = $item_info->_item ?? '';

            
            $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
            if($general_settings->_pur_base_model_barcode==1){
                 if($item_info->_unique_barcode ==1){
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                    }else{
                        if($barcode_string !=''){
                            $ProductPriceList->_barcode = $barcode_string.$purchase_id;
                            $PurchaseD = PurchaseDetail::find($_purchase_detail_id);
                            $PurchaseD->_barcode = $barcode_string.$purchase_id;
                            $PurchaseD->save();
                        }
                    }
            }else{
                $ProductPriceList->_barcode =$barcode_string ?? '';
            }
               
                
                $ProductPriceList->_manufacture_date =$old_item_details->_manufacture_date ?? null;

                $ProductPriceList->_expire_date = $old_item_details->_expire_date ?? null;
                $ProductPriceList->_qty = $old_item_details->_qty ?? 1;
                $ProductPriceList->_sales_rate = $old_item_details->_sales_rate ?? 0;
                $ProductPriceList->_pur_rate = $old_item_details->_rate ?? 0;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = "replacement";
                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $old_item_details->_discount ?? 0;
                $ProductPriceList->_p_discount_amount = $old_item_details->_discount_amount ?? 0;
                $ProductPriceList->_p_vat = $old_item_details->_vat ?? 0;
                $ProductPriceList->_p_vat_amount = $old_item_details->_vat_amount ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$old_item_details->_value ?? 0;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->_branch_id = $old_item_details->_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $old_item_details->_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = $old_item_details->_store_salves_id ?? '';
                $ProductPriceList->_store_id = $old_item_details->_store_id ?? 1;
                $ProductPriceList->_status =1;
                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                $_unique_barcode =  $ProductPriceList->_unique_barcode;

                     if($_unique_barcode ==1){
                         if($barcode_string !=""){

                               $barcode_array=  explode(",",$barcode_string);
                               $_qty = 1;
                               $_stat = 1;
                               $_return=0;
                               $p=0;
                               foreach ($barcode_array as $_b_v) {
                                _barcode_insert_update('BarcodeDetail',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                _barcode_insert_update('PurchaseBarcode',$product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                 
                               }
                            }
                     }
                

                $ItemInventory = ItemInventory::where('_transection',"Replacement In")
                                    ->where('_transection_ref',$purchase_id)
                                    ->where('_transection_detail_ref_id',$_purchase_detail_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                } 


                $ItemInventory->_item_id =  $old_item_details->_item_id;
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($old_item_details->_item_id);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Replacement In";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;
                $ItemInventory->_qty = $old_item_details->_qty;
                $ItemInventory->_rate = $old_item_details->_sales_rate ?? 0;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                $ItemInventory->_cost_rate = $old_item_details->_rate ?? 0;
                $ItemInventory->_cost_value = ($old_item_details->_qty*$old_item_details->_rate);
                $ItemInventory->_value = $old_item_details->_value ?? 0;
                $ItemInventory->_branch_id = $old_item_details->_branch_id ?? 1;
                $ItemInventory->_store_id = $old_item_details->_store_id ?? 1;
                $ItemInventory->_cost_center_id = $old_item_details->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $old_item_details->_store_salves_id ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                _inventory_last_price($old_item_details->_item_id,$old_item_details->_rate,$old_item_details->_sales_rate);

                inventory_stock_update($old_item_details->_item_id);

              
          }
          
        } //End of Stock In



       
        $_total_cost_value=0;
        $_sales_detail_row_ids = $request->_sales_detail_row_id ?? [];

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $_total_cost_value += ($_rates[$i]*$_qtys[$i]);

                if($_sales_detail_row_ids[$i]==0){
                  $SalesDetail = new ReplacementItemOut();
                }else{
                  $SalesDetail = ReplacementItemOut::find($_sales_detail_row_ids[$i]);
                }
                
                $SalesDetail->_item_id = $_item_ids[$i];
                $SalesDetail->_p_p_l_id = $_p_p_l_ids[$i];
                $SalesDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $SalesDetail->_purchase_detail_id = $_purchase_detail_ids[$i];
                $SalesDetail->_qty = $_qtys[$i];

               // return $barcode_string=$all_req[."__barcode__".$_p_p_l_ids[$i]] ?? '';
                 $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i].""] ?? '';
                $SalesDetail->_barcode = $barcode_string;

                $SalesDetail->_manufacture_date = $_manufacture_dates[$i];
                $SalesDetail->_expire_date = $_expire_dates[$i];
                $SalesDetail->_rate = $_rates[$i];
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
                $SalesDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $SalesDetail->_no = $_master_id;
                $SalesDetail->_status = 1;
                $SalesDetail->_created_by = $users->id."-".$users->name;
                $SalesDetail->save();
                $_sales_details_id = $SalesDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();
                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                $_p_qty = $ProductPriceList->_qty;
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
                $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();


/***************************************
   Barcode insert into database section
   _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
   IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
   [  $data->_no_id = $_no_id; $data->_no_detail_id = $_no_detail_id; ] use  $p=1;
**************************************************/
                 $product_price_id =  $ProductPriceList->id;
             if($_unique_barcode ==1){
                  if($barcode_string !=""){
                       $barcode_array=  explode(",",$barcode_string);
                       $_qty = 1;
                       $_stat = 1;
                       $_return=1;
                       
                       foreach ($barcode_array as $_b_v) {
                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                        _barcode_insert_update('SalesBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                         
                       }
                    }
             }
                 

                
/*
    Barcode insert into database section
*/
              $ItemInventory = ItemInventory::where('_transection',"Replacement")
                                    ->where('_transection_ref',$_sales_id)
                                    ->where('_transection_detail_ref_id',$_sales_details_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                }

                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Replacement";
                $ItemInventory->_transection_ref = $_master_id;
                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;
                $ItemInventory->_qty = -($_qtys[$i]);
                $ItemInventory->_rate = $_sales_rates[$i];
                $ItemInventory->_cost_rate = $_rates[$i];
                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                $ItemInventory->_expire_date = $_expire_dates[$i];
                $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);
                $ItemInventory->_value = $_values[$i] ?? 0;
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
        $_transaction= 'Replacement';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  1;
        $_name =$users->name;
        
        if($__total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //Default Sales DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__total,0,$_branch_id,$_cost_center,$_name,1);
           //Default Account Receivable  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__total,$_branch_id,$_cost_center,$_name,2);

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6);
             
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8);
        
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

                        $SalesAccount = new ReplacementItemAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $ledger;
                        $SalesAccount->_cost_center = $_cost_center[$i] ?? 0;
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
                        $_transaction= 'Replacement';
                        $_date = change_date_format($request->_date);
                        $_table_name ='replacement_item_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id_detail[$i] ?? 0;
                        $_cost_center_a = $_cost_center[$i] ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i));
                          
                    }


                }
            
                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $SalesAccount = new ReplacementItemAccount();
                        $SalesAccount->_no = $_master_id;
                        $SalesAccount->_account_type_id = $_account_type_id;
                        $SalesAccount->_account_group_id = $_account_group_id;
                        $SalesAccount->_ledger_id = $request->_main_ledger_id;
                        $SalesAccount->_cost_center = $users->cost_center_ids;
                        $SalesAccount->_branch_id = $users->branch_ids;
                        $SalesAccount->_short_narr = 'Replacement Payment';
                        $SalesAccount->_dr_amount = 0;
                        $SalesAccount->_cr_amount = $_total_dr_amount;
                        $SalesAccount->_status = 1;
                        $SalesAccount->_created_by = $users->id."-".$users->name;
                        $SalesAccount->save();

 
                        $_sales_account_id = $SalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='Replacement Payment';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Replacement';
                        $_date = change_date_format($request->_date);
                        $_table_name ='replacement_item_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a = $_total_dr_amount ?? 0;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20));
                }
            }

          $_l_balance = _l_balance_update($request->_main_ledger_id);
          $_pfix = _replace_prefix().$_master_id;
             \DB::table('replacement_masters')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Dear ".$_name.", Date: ".$request->_date." Invoice N0.".$_pfix." Invoice Amount: ".prefix_taka()."."._report_amount($request->_total).". Payment Amount. ".prefix_taka()."."._report_amount($_total_dr_amount).". Previous Balance ".prefix_taka()."."._report_amount($_p_balance).". Current Balance:".prefix_taka()."."._report_amount($_l_balance);
                  sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

    

           DB::commit();
            return redirect()->back()
                ->with('success','Information save successfully')
                ->with('_master_id',$_master_id)
                ->with('_print_value',$_print_value)
                ->with('_sales_man_id',$_sales_man_id)
                ->with('sales_man_name_leder',$sales_man_name_leder)
                ->with('_delivery_man_id',$_delivery_man_id)
                ->with('delivery_man_name_leder',$delivery_man_name_leder);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()
           ->with('request',$request->all())
           ->with('danger','There is Something Wrong !');
        }


    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReplacementMaster  $replacementMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReplacementMaster $replacementMaster)
    {
        //
    }
}
