<?php

namespace App\Http\Controllers;

use App\Models\MaterialIssue;
use App\Models\MaterialIssueDetail;
use App\Models\AccountLedger;
use App\Models\AccountHead;
use App\Models\AccountGroup;
use App\Models\MaterialIssueSetting;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\Warranty;
use App\Models\TransectionTerms;
use App\Models\Inventory;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use App\Models\MaterialIssueBarcode;
use App\Models\Accounts;
use App\Models\HRM\Company;
use DB;


use Illuminate\Http\Request;
use Auth;
use Session;

class MaterialIssueController extends Controller
{

       function __construct()
    {
         $this->middleware('permission:material-issue-list|material-issue-create|material-issue-edit|material-issue-delete|material-issue-print', ['only' => ['index','store']]);
         $this->middleware('permission:material-issue-print', ['only' => ['materialIssuePrint']]);
         $this->middleware('permission:material-issue-create', ['only' => ['create','store']]);
         $this->middleware('permission:material-issue-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:material-issue-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.material_issued');
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

        
       

      $datas = MaterialIssue::with(['_organization','_master_branch','_master_cost_center','_ledger','_master_details'])->where('_status',1);
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
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','like',"%$request->_order_number%");
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id','=',$request->organization_id);
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
            $datas = $datas->where('_referance','like',"%$request->_referance%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%$request->_note%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){

            $datas = $datas->where('_user_name','like',"%$request->_user_name%");
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
           $form_settings = MaterialIssueSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = permited_stores(explode(',',$users->store_ids));
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.material-issue.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses','permited_organizations'));
            }

            if($request->print =="detail"){
                return view('backend.material-issue.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses','permited_organizations'));
            }
         }

        return view('backend.material-issue.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses','permited_organizations'));
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
        
        $form_settings = MaterialIssueSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();

        $payment_terms = TransectionTerms::where('_status',1)->get();

       return view('backend.material-issue.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','payment_terms'));
    }
  public function formSettingAjax(){
        $form_settings = MaterialIssueSetting::first();
        $inv_accounts = AccountLedger::orderBy('_name','asc')->get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $cost_of_solds = $inv_accounts;
        $_cash_customers = $inv_accounts;
        return view('backend.material-issue.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds','_cash_customers'));
    }

    public function Settings (Request $request){
        $data = MaterialIssueSetting::first();
        if(empty($data)){
            $data = new MaterialIssueSetting();
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
        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_show_delivery_man = $request->_show_delivery_man ?? 1;
        $data->_show_sales_man = $request->_show_sales_man ?? 1;
        $data->_show_cost_rate = $request->_show_cost_rate ?? 1;
        $data->_show_payment_terms = $request->_show_payment_terms ?? 1;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 1;
        $data->_show_expire_date = $request->_show_expire_date ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_show_warranty =$request->_show_warranty ?? 0;
        $data->_show_unit =$request->_show_unit ?? 0;
        $data->_show_cost_center =$request->_show_cost_center ?? 0;
        $data->_show_branch =$request->_show_branch ?? 0;
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
         // return dump($request->all());
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
    $SalesFormSetting = MaterialIssueSetting::first();
    

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
        $organization_id = $request->organization_id ?? 1;


        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];

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
         $users = Auth::user();
        $Sales = new MaterialIssue();
        $Sales->_date = change_date_format($request->_date);
        $Sales->_time = date('H:i:s');
        $Sales->_order_ref_id = $request->_order_ref_id ?? '';
        $Sales->_order_number = $request->_order_number ?? '';
        $Sales->_referance = $request->_referance ?? '';
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
        $Sales->_sales_type = $request->_sales_type ?? 'material_issues';
        $Sales->_delivery_details = $request->_delivery_details ?? '';
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

               // $_base_rate = ($_values[$i]/($_qtys[$i]*$conversion_qtys[$i] ?? 1));

                 $converted_l=($_qtys[$i]*$conversion_qtys[$i] ?? 1);
                if($converted_l ==0){$converted_l=1;}
                $_base_rate = ($_values[$i]/$converted_l);

                $MaterialIssueDetail = new MaterialIssueDetail();
                $MaterialIssueDetail->_item_id = $_item_ids[$i];
                $MaterialIssueDetail->_p_p_l_id = $_p_p_l_ids[$i];
                $MaterialIssueDetail->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $MaterialIssueDetail->_purchase_detail_id = $_purchase_detail_ids[$i];
                $MaterialIssueDetail->_qty = $_qtys[$i];

                $MaterialIssueDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $MaterialIssueDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $MaterialIssueDetail->_base_unit = $_base_unit_ids[$i] ?? 1;
                $MaterialIssueDetail->_base_rate = $_base_rate;
                $MaterialIssueDetail->_rate = $_rates[$i];

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_p_p_l_ids[$i]] ?? '';
                $MaterialIssueDetail->_barcode = $barcode_string;

                $MaterialIssueDetail->_manufacture_date = $_manufacture_dates[$i];
                $MaterialIssueDetail->_expire_date = $_expire_dates[$i];
                $MaterialIssueDetail->_warranty = $_warrantys[$i] ?? 0;
                $MaterialIssueDetail->_sales_rate = $_sales_rates[$i];
                $MaterialIssueDetail->_discount = $_discounts[$i] ?? 0;
                $MaterialIssueDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $MaterialIssueDetail->_vat = $_vats[$i] ?? 0;
                $MaterialIssueDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $MaterialIssueDetail->_value = $_values[$i] ?? 0;
                $MaterialIssueDetail->_store_id = $_store_ids[$i] ?? 1;
                $MaterialIssueDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $MaterialIssueDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $MaterialIssueDetail->organization_id = $organization_id;
                $MaterialIssueDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $MaterialIssueDetail->_no = $_master_id;
                $MaterialIssueDetail->_status = 1;
                $MaterialIssueDetail->_created_by = $users->id."-".$users->name;
                $MaterialIssueDetail->save();
                $_sales_details_id = $MaterialIssueDetail->id;

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


                // $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                // $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                // $ProductPriceList->_status = $_status;
                // $ProductPriceList->save();

                $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
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
                        _barcode_insert_update('MaterialIssueBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                         
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
                $ItemInventory->_transection = "material_issues";
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
        $_transaction= 'material_issues';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;
        
        if($__sub_total > 0){

            

            //Issue Expense Head DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
           
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

          
            

          $_l_balance = _l_balance_update($request->_main_ledger_id);
            //$_pfix = _sales_pfix().$_master_id;

            $_main_branch_id = $request->_branch_id;
            $__table="material_issues";
            $_pfix = _issue_pfix().make_order_number($__table,$organization_id,$_main_branch_id);

             \DB::table('material_issues')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

              

             $print_url=url('material-issue/print')."/".$_master_id;
             $success_message= "Information Save successfully. <a target='__blank' style='color:red;' href='".$print_url."'><i class='fas fa-print'></i></a>";

           DB::commit();
            return redirect()->back()
                ->with('success',$success_message)
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
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialIssue  $materialIssue
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialIssue $materialIssue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialIssue  $materialIssue
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
       
        $form_settings = MaterialIssueSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $data =  MaterialIssue::with(['_master_branch','_master_details','_ledger'])->where('_lock',0)->find($id);
         if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }
          $sales_number = MaterialIssueDetail::where('_no',$id)->count();
          $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
            $payment_terms = TransectionTerms::where('_status',1)->get();
       return view('backend.material-issue.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','data','sales_number','_warranties','payment_terms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialIssue  $materialIssue
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

          $SalesFormSetting = MaterialIssueSetting::first();
    
            $_sales_id = $request->_sales_id;
            $_lock_check =  MaterialIssue::where('_lock',0)->find($_sales_id); 
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
        $_delivery_details = $request->_delivery_details ?? '';

        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];

 //====
        // Product Price list table update with previous sales details item
        // 
        //======
$checkqty = array();
$over_qtys = array();
      

//Prevoius Return information
     $previous_sales_details = MaterialIssueDetail::where('_no',$_sales_id)->where('_status',1)->get();
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

    // if(sizeof($over_qtys) > 0){
    //     return redirect()->back()
    //     ->with('request',$request->all())
    //     ->with('danger','You Can not Return More then available Qty !');
    // }



    DB::beginTransaction();
           try {
        
       
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

     

    MaterialIssueDetail::where('_no', $_sales_id)
            ->update(['_status'=>0]);
    ItemInventory::where('_transection',"material_issues")
        ->where('_transection_ref',$_sales_id)
        ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]);  
      

    MaterialIssueBarcode::where('_no_id',$_sales_id)
                  ->update(['_status'=>0,'_qty'=>0]);

     $_p_balance = _l_balance_update($request->_main_ledger_id);
        
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $Sales = MaterialIssue::find($_sales_id);
        $Sales->_date = change_date_format($request->_date);
        $Sales->_time = date('H:i:s');
        $Sales->_payment_terms = $request->_payment_terms ?? 1;
        $Sales->_order_ref_id = $request->_order_ref_id;
        $Sales->_order_number = $request->_order_number ?? '';
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
        $Sales->_sales_type = $request->_sales_type ?? 'material_issues';
        $Sales->_delivery_details = $request->_delivery_details ?? '';
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
                        $SalesDetail = new MaterialIssueDetail();
                }else{
                    $SalesDetail = MaterialIssueDetail::find($_sales_detail_row_ids[$i]);
                }


                //$_base_rate = ($_values[$i]/($_qtys[$i]*$conversion_qtys[$i] ?? 1));

                 $converted_l=($_qtys[$i]*$conversion_qtys[$i] ?? 1);
                if($converted_l ==0){$converted_l=1;}
                $_base_rate = ($_values[$i]/$converted_l);

                $SalesDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $SalesDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $SalesDetail->_base_unit = $_base_unit_ids[$i] ?? 1;
                $SalesDetail->_base_rate = $_base_rate;

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $SalesDetail->_barcode = $barcode_string;
                $SalesDetail->_warranty = $_warrantys[$i] ?? 0;
                
                $SalesDetail->_item_id = $_item_ids[$i];
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
                $SalesDetail->_store_id = $_store_ids[$i] ?? 1;
                $SalesDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $SalesDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $SalesDetail->organization_id = $organization_id ?? 1;
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




                // $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                // $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                // $ProductPriceList->_status = $_status;
                // $ProductPriceList->save();

                $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();


/***************************************
   Barcode insert into database section
   _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
   IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
   [  $data->_no_id = $_no_id; $data->_no_detail_id = $_no_detail_id; ] use  $p=1;
**************************************************/
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
                        _barcode_insert_update('MaterialIssueBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                         
                       }
                    }
              }
                
/*
    Barcode insert into database section


*/




                $ItemInventory = ItemInventory::where('_transection',"material_issues")
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
                $ItemInventory->_transection = "material_issues";
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
        $_transaction= 'material_issues';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;

         if($__sub_total > 0){

            //#################
            // Expense Head Dr.
            //      Inventory Cr
            //#################

            //Expense Head DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
           
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4,$organization_id);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Expense Head  Cr
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
             \DB::table('material_issues')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance]);
          DB::commit();
          if(($request->_lock ?? 0) ==1){
                return redirect('material-issue/print/'.$_master_id)
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


    public function Print($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data =  MaterialIssue::with(['_master_branch','_master_details','_ledger','_terms_con'])->find($id);
        $form_settings = MaterialIssueSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         
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

         $total_sales = MaterialIssue::where('_ledger_id', $data->_ledger_id)
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
                                 $due_sales_info = MaterialIssue::select('id','_date','_order_number','_total')
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
         
   
         if($form_settings->_invoice_template==1){
            return view('backend.material-issue.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.material-issue.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==3){
            return view('backend.material-issue.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==4){
            return view('backend.material-issue.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==6){
            return view('backend.material-issue.print_4',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }elseif($form_settings->_invoice_template==5){
            return view('backend.material-issue.pos_template2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }else{
            return view('backend.material-issue.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         }
       
    }

    public function challanPrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data =  MaterialIssue::with(['_master_branch','_master_details','_ledger','_terms_con','_master_cost_center','_organization'])->find($id);


        $form_settings = MaterialIssueSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         
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

         $total_sales = MaterialIssue::where('_ledger_id', $data->_ledger_id)
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
                                 $due_sales_info = MaterialIssue::select('id','_date','_order_number','_total')
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
         
   
        
            return view('backend.material-issue.challan',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','history_sales_invoices','_master_detail_reassign'));
         
        
       
    }
public function issueAfterReturn($id){
        $page_name = "Issue After Return";

         $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
        $data =  Sales::with(['_master_branch','_master_details','s_account','_ledger','_terms_con'])->find($id);
        $form_settings = SalesFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         
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
         
   
return view('backend.sales.net_sales_after_return',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','sales_returns','after_sales_return','history_sales_invoices'));
        

        
    }
     public function checkQtyUpdateFoMaterialIssue(Request $request){
       $_over_qty = array();

       $unique_p_ids = $request->unique_p_ids ?? [];
      $_p_ids = implode(",",$unique_p_ids); //Product Price list table ID
      //return $request->_sales_id;
        $previous_sales_details = \DB::select(" SELECT t1._p_p_l_id,t1._item_id,SUM(t1._qty) as _total_qty
FROM (
SELECT s1._p_p_l_id,s1._item_id,sum(s1._qty) as _qty
    FROM material_issue_details as s1
WHERE s1._no=".$request->_sales_id." GROUP BY s1._p_p_l_id
UNION ALL
SELECT s1.id as _p_p_l_id,s1._item_id,s1._qty 
    FROM product_price_lists AS s1 WHERE s1.id IN(".$_p_ids.")
    ) as t1 GROUP BY t1._p_p_l_id ");


        $unique_p_q = [];
        foreach($request->_p_p_l_ids_qtys as $index=> $val){
         $unique_p_q[$val["_p_id"]][]=$val;
        }
        $_id_qty=array();
        foreach ($unique_p_q as $key=>$value) {
            $qty_sum =0;
            foreach ($value as $row) {
                 $qty_sum +=floatval($row["_p_qty"]);
             }
            array_push($_id_qty, ['_id'=>$key,'_qty'=>$qty_sum]);  
        }

       
       foreach ($previous_sales_details as $value) {
           foreach ($_id_qty as $c_val) {
            
               if($value->_p_p_l_id ==$c_val["_id"]   ){
                if(floatval($value->_total_qty) < floatval($c_val["_qty"])){
                    array_push($_over_qty, $c_val["_id"]);
                }
               }
           }
       }
       
        
        return json_encode($_over_qty); 
    }

    public function itemIssueEditBarcodeSearch(Request $request){
     // return $request->all();
        $users = Auth::user();
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_qty';
        $_master_id =  $request->_master_id;
       $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        $_this_barcode='';

        //First Check Unique Barcode or Model Barcode to compare barcode details table qty
        // if qty =1 then we can deside that's it's an unique barcode then we fetch baroce base all information from product prince list table as we use without barcode version 

     


         $datas = DB::select(" SELECT s1.id,s1._master_id, s1._name,s1._item_id,s1._unit_id, s1._barcode,s1._warranty,s1._unique_barcode, s1._manufacture_date, s1._expire_date,  s1._qty,s1._sales_rate, s1._pur_rate,  s1._sales_discount,s1._sales_vat, s1._purchase_detail_id, s1._branch_id, s1._cost_center_id,  s1._store_id,  s1._store_salves_id FROM (
SELECT id,_master_id, _item as _name, _item_id, _unit_id, _barcode,_warranty,_unique_barcode, _manufacture_date, _expire_date, _qty, _sales_rate, _pur_rate, _sales_discount, _sales_vat, _purchase_detail_id, _branch_id, _cost_center_id, _store_id, _store_salves_id 
from product_price_lists
where  _status = 1 and  (_barcode like '%$text_val%' OR _item like '%$text_val%' OR _item_id LIKE '%$text_val%'  ) and _branch_id in ($users->branch_ids) and _cost_center_id in ($users->cost_center_ids) AND  _qty > 0
UNION ALL
SELECT t1._p_p_l_id as id,t1._purchase_invoice_no as _master_id,  t2._item as _name,t1._item_id,t2._unit_id as _unit_id, t1._barcode,t1._warranty,t2._unique_barcode, t1._manufacture_date, t1._expire_date,  t1._qty,t1._sales_rate, t1._rate AS _pur_rate,  t1._discount as _sales_discount, t1._vat AS _sales_vat, t1._purchase_detail_id,   t1._branch_id, t1._cost_center_id,  t1._store_id,  t1._store_salves_id
FROM material_issue_details AS t1
INNER JOIN inventories AS t2 ON t1._item_id=t2.id
where  t1._status = 1 and  (t1._barcode like '%$text_val%' OR t2._item like '%$text_val%' OR t2.id LIKE '%$text_val%'  ) and t1._branch_id in ($users->branch_ids) and t1._cost_center_id in ($users->cost_center_ids) AND  t1._qty> 0
   )  AS s1   ORDER BY s1._name ASC LIMIT $limit ");

        
    $_search_type='item_search';
         


        $_this_barcode=$text_val;
        $data["datas"]=$datas;
        $data["_search_type"]=$_search_type;
        $data["_this_barcode"]=$_this_barcode;
        return json_encode( $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialIssue  $materialIssue
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialIssue $materialIssue)
    {
        //
    }
}
