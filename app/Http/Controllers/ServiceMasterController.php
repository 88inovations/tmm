<?php

namespace App\Http\Controllers;

use App\Models\ServiceMaster;
use App\Models\AccountHead;
use App\Models\AccountGroup;
use App\Models\AccountLedger;
use App\Models\ServiceFromSetting;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\Branch;
use App\Models\StoreHouse;
use App\Models\GeneralSettings;
use App\Models\ServiceDetail;
use App\Models\ServiceAccount;
use App\Models\VoucherType;
use App\Models\Accounts;


use Illuminate\Http\Request;
use Auth;
use DB;

class ServiceMasterController extends Controller
{

        function __construct()
    {
         $this->middleware('permission:third-party-service-list|third-party-service-create|third-party-service-edit|third-party-service-delete|third-party-service-print', ['only' => ['index','store']]);
         $this->middleware('permission:third-party-service-print', ['only' => ['Print']]);
         $this->middleware('permission:third-party-service-create', ['only' => ['create','store']]);
         $this->middleware('permission:third-party-service-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:third-party-service-delete', ['only' => ['destroy']]);
         $this->page_name = "Repair/Service Invoice";
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
            session()->put('_thired_partey_service_limit', $request->limit);
        }else{
             $limit= \Session::get('_thired_partey_service_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = ServiceMaster::with(['_master_branch','_ledger','_s_account','_master_details']);
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
        
        if($request->has('_address') && $request->_address !=''){
            $datas = $datas->where('_address','like',"%$request->_address%");
        }

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%$request->_referance%");
        }
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','like',"%$request->_order_number%");
        }
        if($request->has('_phone') && $request->_phone !=''){
            $datas = $datas->where('_phone','like',"%$request->_phone%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%$request->_user_name%");
        }
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        
        if($request->has('_total') && $request->_total !=''){
            $datas = $datas->where('_total','=',trim($request->_total));
        }
        if($request->has('_service_status') && $request->_service_status !=''){
            $datas = $datas->where('_service_status','=',trim($request->_service_status));
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
        $form_settings = ServiceFromSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = [];
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.third-party-service.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.third-party-service.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.third-party-service.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }


     public function reset(){
        Session::flash('_thired_partey_service_limit');
       return  \Redirect::to('third-party-service?limit='.default_pagination());
    }


      public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = ServiceMaster::with(['_master_branch','_s_account','_ledger'])->find($id);

       return view('backend.third-party-service.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data'));
    }



     public function purchaseWiseDetail(Request $request){
        $users = Auth::user();
        $invoice_id = $request->invoice_id;
        $key = $request->_attr_key;
        $data = ServiceMaster::with(['_master_details','_s_account'])->where('id',$invoice_id)->first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();

        return view('backend.third-party-service.detail',compact('data','permited_branch','permited_costcenters','store_houses','key'));
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
        
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ServiceFromSetting::first();
        $inv_accounts = [];
      //  $p_accounts = AccountLedger::where('_account_head_id',8)->get();
        $dis_accounts = [];
        $capital_accounts = [];

        $p_accounts = AccountLedger::whereIn('_account_head_id',[8,10,5])->orderBy('_name','ASC')->get();
        $dis_accounts = $p_accounts;
       
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();

       return view('backend.third-party-service.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','capital_accounts'));
    }


    public function Settings (Request $request){
        $data = ServiceFromSetting::first();
        if(empty($data)){
            $data = new ServiceFromSetting();
        }
        $data->_default_service_income = $request->_default_service_income;
        $data->_default_discount = $request->_default_discount;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_show_short_note = $request->_show_short_note;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_show_p_balance = $request->_show_p_balance ?? 1;
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
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);

         $users = Auth::user();
          $settings = GeneralSettings::first();
            $_lock = $settings->_auto_lock ?? 0;
             DB::beginTransaction();
            try {

            $_p_balance = _l_balance_update($request->_main_ledger_id);
            $__sub_total = (float) $request->_sub_total;
            $__total = (float) $request->_total;
            $__discount_input = (float) $request->_discount_input;
            $__total_discount = (float) $request->_total_discount;

        


            $_date = $request->_date;
            $ServiceMaster = new ServiceMaster();
            $ServiceMaster->_date = change_date_format($_date);
            $ServiceMaster->_delivery_date = change_date_format($request->_delivery_date);
            $ServiceMaster->_time = date('H:i:s');
            $ServiceMaster->_order_ref_id = $request->_order_ref_id ?? '';
            $ServiceMaster->_referance = $request->_referance ?? '';
            $ServiceMaster->_address = $request->_address ?? '';
            $ServiceMaster->_phone = $request->_phone ?? '';
            $ServiceMaster->_ledger_id  = $request->_main_ledger_id  ?? '';
            $ServiceMaster->_user_id  = $users->id  ?? '';
            $ServiceMaster->_created_by = $users->id."-".$users->name;
            $ServiceMaster->_user_name = $users->name;
            $ServiceMaster->_service_status = $request->_service_status ?? 1;
            $ServiceMaster->_note = $request->_note ?? '';

            $ServiceMaster->_sub_total = $__sub_total;
            $ServiceMaster->_discount_input = $__discount_input;
            $ServiceMaster->_total_discount = $__total_discount;
            $ServiceMaster->_total_vat = $request->_total_vat;
            $ServiceMaster->_total =  $__total;


            $ServiceMaster->_branch_id = $request->_branch_id ?? 1;
            $ServiceMaster->_store_id = $request->_store_id ?? 1;
            $ServiceMaster->_status = $request->_status ?? 1;
            $ServiceMaster->_lock = $_lock ?? 0;
            $ServiceMaster->save();
             $_master_id = $ServiceMaster->id;


            $_item_ids = $request->_item_id ?? [];
            $_short_notes = $request->_short_note ?? [];
            $_service_names = $request->_service_name ?? [];

            $_purchase_detail_ids = $request->_purchase_detail_id ?? [];
            $_sales_ref_ids = $request->_sales_ref_id ?? [];
            $_sales_detail_ref_ids = $request->_sales_detail_ref_id ?? [];
            $_barcode_s = $request->_barcode_ ?? [];
            $_ref_counters = $request->_ref_counter ?? [];
            $_warrantys = $request->_warranty ?? [];
            $_qtys = $request->_qty ?? [];
            $_values = $request->_value ?? [];

            $_main_branch_id_details = $request->_main_branch_id_detail ?? [];
            $_main_cost_centers = $request->_main_cost_center ?? [];
            $_main_store_ids = $request->_main_store_id ?? [];
            $_warranty_reasons = $request->_warranty_reason ?? [];
            $_rates = $request->_rate ?? [];
            $_sales_rates = $request->_sales_rate ?? [];
            $_sales_detail_ids = $request->_sales_detail_id ?? [];

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];


            $_base_unit_ids =$request->_base_unit_id ?? [];
            $_main_unit_vals =$request->_main_unit_val ?? [];
            $conversion_qtys =$request->conversion_qty ?? [];
            $_base_rates =$request->_base_rate ?? [];
            $_transection_units =$request->_transection_unit ?? [];


            if(sizeof($_item_ids) > 0){
                for ($i=0; $i <sizeof($_item_ids) ; $i++) { 

                     $item_info = Inventory::where('id',$_item_ids[$i])->first();

                    $__single_barcode = $all_req[$_ref_counters[$i]."__barcode__". $_item_ids[$i]];
                    $ServiceDetail = new ServiceDetail();
                    $ServiceDetail->_item_id = $_item_ids[$i] ?? 0;
                    $ServiceDetail->_qty = $_qtys[$i] ?? 0;
                    $ServiceDetail->_rate = $_rates[$i] ?? 0;
                    $ServiceDetail->_discount = $_discounts[$i] ?? 0;

                    $ServiceDetail->_transection_unit = $_transection_units[$i] ?? $item_info->_unit_id;
                    $ServiceDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                    $ServiceDetail->_base_unit = $item_info->_unit_id ?? 1;
                    $ServiceDetail->_unit_id = $item_info->_unit_id ?? 1;



                    $ServiceDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                    $ServiceDetail->_vat = $_vats[$i] ?? 0;
                    $ServiceDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                    $ServiceDetail->_short_note = $_short_notes[$i] ?? '';
                    $ServiceDetail->_value = $_values[$i] ?? 0;
                    $ServiceDetail->_service_name = $_service_names[$i] ?? '';
                    $ServiceDetail->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                    $ServiceDetail->_barcode = $__single_barcode ?? '';
                    $ServiceDetail->_no = $_master_id ?? 0;
                    $ServiceDetail->_branch_id = $_main_branch_id_details[$i] ?? 1;
                    $ServiceDetail->_status = 1;
                    $ServiceDetail->save();
                }
            }

                           

            $_total_dr_amount = 0;
            $_total_cr_amount = 0;
            $ServiceFromSetting =  ServiceFromSetting::first();
            

        
        $_default_service_income = $ServiceFromSetting->_default_service_income;
        $_default_discount = $ServiceFromSetting->_default_discount;
        $_default_vat_account = $ServiceFromSetting->_default_vat_account;


            $_ref_master_id=$_master_id;
            $_ref_detail_id=$_master_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'Service';
            $_date = change_date_format($_date ?? date('Y-m-d'));
            $_table_name = $request->_form_name ?? 'service_masters';
            $_branch_id = $request->_branch_id ?? 1;
             $_cost_center =  1;
            $_name =$users->name;

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_main_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];
            $_branch_id_details = $request->_main_branch_id_detail ?? [];

             if($__sub_total > 0){

                //Customer Account Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_service_income),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
            //Service Income Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_service_income,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            
        }

 
            if(sizeof($_ledger_ids) > 0){
                for ($i=0; $i <sizeof($_ledger_ids); $i++) { 
                     $ledger = intval($_ledger_ids[$i] ?? 0);
                      $_dr_amount =(float) $_dr_amounts[$i] ?? 0;
                      $_cr_amount =0;
                     
                        if($ledger !=0){
                            $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                            $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                            $_total_dr_amount += $_dr_amounts[$i] ?? 0;
                            $_total_cr_amount += $_cr_amounts[$i] ?? 0;

                            $ServiceAccount = new ServiceAccount();
                            $ServiceAccount->_no = $_master_id;
                            $ServiceAccount->_account_type_id = $_account_type_id;
                            $ServiceAccount->_account_group_id = $_account_group_id;
                            $ServiceAccount->_ledger_id = $ledger;
                            $ServiceAccount->_cost_center = $_cost_centers[$i] ?? 1;
                            $ServiceAccount->_branch_id = $_branch_id_details[$i] ?? 1;
                            $ServiceAccount->_short_narr = $_short_narrs[$i] ?? 'N/A';
                            $ServiceAccount->_dr_amount = $_dr_amount ?? 0;
                            $ServiceAccount->_cr_amount = $_cr_amount ?? 0;
                            $ServiceAccount->_status = 1;
                            $ServiceAccount->_created_by = $users->id."-".$users->name;
                            $ServiceAccount->save();

                            $_sales_account_id = $ServiceAccount->id;

                            //Reporting Account Table Data Insert
                            $_ref_master_id=$_master_id;
                            $_ref_detail_id=$_sales_account_id;
                            $_short_narration=$_short_narrs[$i] ?? 'N/A';
                            $_narration = $request->_note;
                            $_reference= $request->_referance ?? 'N/A';
                            $_transaction= 'Service';
                            $_date = change_date_format($_date);
                            $_table_name ='service_masters';
                            $_account_ledger = $ledger;
                            $_dr_amount_a = $_dr_amount ?? 0;
                            $_cr_amount_a = $_cr_amount ?? 0;
                            $_branch_id_a = $_branch_id_details[$i] ?? 1;
                            $_cost_center_a = $_cost_centers[$i] ?? 1;
                            $_name =$users->name;
                            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(2+$i));
                        }
                    
                }

                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){


                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $ServiceAccount = new ServiceAccount();
                        $ServiceAccount->_no = $_master_id;
                        $ServiceAccount->_account_type_id = $_account_type_id;
                        $ServiceAccount->_account_group_id = $_account_group_id;
                        $ServiceAccount->_ledger_id = $request->_main_ledger_id;
                        $ServiceAccount->_cost_center = $users->cost_center_ids;
                        $ServiceAccount->_branch_id = $users->branch_ids;
                        $ServiceAccount->_short_narr = 'N/A';
                        $ServiceAccount->_dr_amount =  0;
                        $ServiceAccount->_cr_amount = $_total_dr_amount;
                        $ServiceAccount->_status = 1;
                        $ServiceAccount->_created_by = $users->id."-".$users->name;
                        $ServiceAccount->save();

 
                        $service_account_id = $ServiceAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$service_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Service';
                        $_date = change_date_format($request->_date);
                        $_table_name ='service_masters';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a =  $_total_dr_amount;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20));
                }


        


        }

       //return $_cost_center;
                if($__total_discount > 0){
             //#################
            // Service  Discount Dr.
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


        $_pfix = service_prefix().$_master_id;
        $_l_balance = _l_balance_update($request->_main_ledger_id);
        $_order_number = service_prefix().$_master_id;
        ServiceMaster::where('id',$_master_id)
        ->where('id',$_master_id)
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
                
            

              $_print_value=$request->_print ?? 0;
               DB::commit();
                return redirect()->back()->with('success','Information save successfully')->with('_master_id',$_master_id)->with('_print_value',$_print_value);
           } catch (\Exception $e) {
               DB::rollback();
               $_mess['message']='error';
               $_mess['_master_id'] ='no';
               return redirect()->back()->with('success','Something Went Wrong');
            }
    }

    public function Print($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
         $data =  ServiceMaster::with(['_master_branch','_master_details','_s_account','_ledger'])->find($id);
        $form_settings = ServiceFromSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();


         if($form_settings->_invoice_template==1){
            return view('backend.third-party-service.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.third-party-service.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==3){
            return view('backend.third-party-service.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==4){
           return view('backend.third-party-service.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }else{
            return view('backend.third-party-service.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceMaster $serviceMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceMaster  $serviceMaster
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
        
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
          $form_settings = ServiceFromSetting::first();
            $inv_accounts = [];
        $dis_accounts = [];
        $capital_accounts = [];

        $p_accounts = AccountLedger::whereIn('_account_head_id',[8,10,5])->orderBy('_name','ASC')->get();
        $dis_accounts = $p_accounts;
        
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $data =  ServiceMaster::with(['_master_branch','_master_details','_s_account','_ledger'])->where('_lock',0)->find($id);
         
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }
          
       return view('backend.third-party-service.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
           $all_req= $request->all();
         $this->validate($request, [
            '_purchase_id' => 'required',
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);

         $service_master_id = $request->_purchase_id;

         $users = Auth::user();
          $settings = GeneralSettings::first();
            $_lock = $settings->_auto_lock ?? 0;
             DB::beginTransaction();
            try {

        
    ServiceDetail::where('_no', $service_master_id)
            ->update(['_status'=>0]);
   
    
    ServiceAccount::where('_no',$service_master_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$service_master_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]); 
    Accounts::where('_ref_master_id',$service_master_id)
                    ->where('_table_name','service_masters')
                     ->update(['_status'=>0]); 



            $_p_balance = _l_balance_update($request->_main_ledger_id);
            $__sub_total = (float) $request->_sub_total;
            $__total = (float) $request->_total;
            $__discount_input = (float) $request->_discount_input;
            $__total_discount = (float) $request->_total_discount;

        


            $_date = $request->_date;
            $ServiceMaster = ServiceMaster::find($service_master_id);
            $ServiceMaster->_date = change_date_format($_date);
            $ServiceMaster->_delivery_date = change_date_format($request->_delivery_date);
            $ServiceMaster->_time = date('H:i:s');
            $ServiceMaster->_order_ref_id = $request->_order_ref_id ?? '';
            $ServiceMaster->_referance = $request->_referance ?? '';
            $ServiceMaster->_address = $request->_address ?? '';
            $ServiceMaster->_phone = $request->_phone ?? '';
            $ServiceMaster->_ledger_id  = $request->_main_ledger_id  ?? '';
            $ServiceMaster->_user_id  = $users->id  ?? '';
            $ServiceMaster->_updated_by = $users->id."-".$users->name;
            $ServiceMaster->_user_name = $users->name;
            $ServiceMaster->_service_status = $request->_service_status ?? 1;
            $ServiceMaster->_note = $request->_note ?? '';

            $ServiceMaster->_sub_total = $__sub_total;
            $ServiceMaster->_discount_input = $__discount_input;
            $ServiceMaster->_total_discount = $__total_discount;
            $ServiceMaster->_total_vat = $request->_total_vat;
            $ServiceMaster->_total =  $__total;


            $ServiceMaster->_branch_id = $request->_branch_id ?? 1;
            $ServiceMaster->_store_id = $request->_store_id ?? 1;
            $ServiceMaster->_status = $request->_status ?? 1;
            $ServiceMaster->_lock = $_lock ?? 0;
            $ServiceMaster->save();
             $_master_id = $ServiceMaster->id;
             

            $_item_ids = $request->_item_id ?? [];
            $_short_notes = $request->_short_note ?? [];
            $_service_names = $request->_service_name ?? [];

            $_purchase_detail_ids = $request->purchase_detail_id ?? [];
            $_sales_ref_ids = $request->_sales_ref_id ?? [];
            $_sales_detail_ref_ids = $request->_sales_detail_ref_id ?? [];
            $_barcode_s = $request->_barcode_ ?? [];
            $_ref_counters = $request->_ref_counter ?? [];
            $_warrantys = $request->_warranty ?? [];
            $_qtys = $request->_qty ?? [];
            $_values = $request->_value ?? [];

            $_main_branch_id_details = $request->_main_branch_id_detail ?? [];
            $_main_cost_centers = $request->_main_cost_center ?? [];
            $_main_store_ids = $request->_main_store_id ?? [];
            $_warranty_reasons = $request->_warranty_reason ?? [];
            $_rates = $request->_rate ?? [];
            $_sales_rates = $request->_sales_rate ?? [];
            $_sales_detail_ids = $request->_sales_detail_id ?? [];

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];


            if(sizeof($_item_ids) > 0){
                for ($i=0; $i <sizeof($_item_ids) ; $i++) { 
                    if( $_purchase_detail_ids[$i]==0){
                        $ServiceDetail = new ServiceDetail();
                    }else{
                        $ServiceDetail = ServiceDetail::find( $_purchase_detail_ids[$i]);
                    }

                    $__single_barcode = $all_req[$_ref_counters[$i]."__barcode__". $_item_ids[$i]];
                    
                    $ServiceDetail->_item_id = $_item_ids[$i] ?? 0;
                    $ServiceDetail->_qty = $_qtys[$i] ?? 0;
                    $ServiceDetail->_rate = $_rates[$i] ?? 0;
                    $ServiceDetail->_discount = $_discounts[$i] ?? 0;
                    $ServiceDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                    $ServiceDetail->_vat = $_vats[$i] ?? 0;
                    $ServiceDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                    $ServiceDetail->_short_note = $_short_notes[$i] ?? '';
                    $ServiceDetail->_value = $_values[$i] ?? 0;
                    $ServiceDetail->_service_name = $_service_names[$i] ?? '';
                    $ServiceDetail->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                    $ServiceDetail->_barcode = $__single_barcode ?? '';
                    $ServiceDetail->_no = $_master_id ?? 0;
                    $ServiceDetail->_branch_id = $_main_branch_id_details[$i] ?? 1;
                    $ServiceDetail->_status = 1;
                    $ServiceDetail->save();
                }
            }

                           

            $_total_dr_amount = 0;
            $_total_cr_amount = 0;
            $ServiceFromSetting =  ServiceFromSetting::first();
            

        
        $_default_service_income = $ServiceFromSetting->_default_service_income;
        $_default_discount = $ServiceFromSetting->_default_discount;
        $_default_vat_account = $ServiceFromSetting->_default_vat_account;


            $_ref_master_id=$_master_id;
            $_ref_detail_id=$_master_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'Service';
            $_date = change_date_format($_date ?? date('Y-m-d'));
            $_table_name = $request->_form_name ?? 'service_masters';
            $_branch_id = $request->_branch_id ?? 1;
             $_cost_center =  1;
            $_name =$users->name;

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_main_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];
            $_branch_id_details = $request->_main_branch_id_detail ?? [];

             if($__sub_total > 0){

                //Customer Account Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_service_income),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
            //Service Income Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_service_income,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            
        }

 
            if(sizeof($_ledger_ids) > 0){
                for ($i=0; $i <sizeof($_ledger_ids); $i++) { 
                    $ledger = intval($_ledger_ids[$i] ?? 0);
                    $_dr_amount =(float) $_dr_amounts[$i] ?? 0;
                      $_cr_amount =0;
                     
                        if($ledger !=0){
                            $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                            $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                            $_total_dr_amount += $_dr_amounts[$i] ?? 0;
                            $_total_cr_amount += $_cr_amounts[$i] ?? 0;

                            $ServiceAccount = new ServiceAccount();
                            $ServiceAccount->_no = $_master_id;
                            $ServiceAccount->_account_type_id = $_account_type_id;
                            $ServiceAccount->_account_group_id = $_account_group_id;
                            $ServiceAccount->_ledger_id = $ledger;
                            $ServiceAccount->_cost_center = $_cost_centers[$i] ?? 1;
                            $ServiceAccount->_branch_id = $_branch_id_details[$i] ?? 1;
                            $ServiceAccount->_short_narr = $_short_narrs[$i] ?? 'N/A';
                            $ServiceAccount->_dr_amount = $_dr_amount ?? 0;
                            $ServiceAccount->_cr_amount = $_cr_amount ?? 0;
                            $ServiceAccount->_status = 1;
                            $ServiceAccount->_created_by = $users->id."-".$users->name;
                            $ServiceAccount->save();

                            $_sales_account_id = $ServiceAccount->id;

                            //Reporting Account Table Data Insert
                            $_ref_master_id=$_master_id;
                            $_ref_detail_id=$_sales_account_id;
                            $_short_narration=$_short_narrs[$i] ?? 'N/A';
                            $_narration = $request->_note;
                            $_reference= $request->_referance ?? 'N/A';
                            $_transaction= 'Service';
                            $_date = change_date_format($_date);
                            $_table_name ='service_masters';
                            $_account_ledger = $ledger;
                            $_dr_amount_a = $_dr_amount ?? 0;
                            $_cr_amount_a = $_cr_amount ?? 0;
                            $_branch_id_a = $_branch_id_details[$i] ?? 1;
                            $_cost_center_a = $_cost_centers[$i] ?? 1;
                            $_name =$users->name;
                            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(2+$i));
                        }
                    
                }


                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){


                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $ServiceAccount = new ServiceAccount();
                        $ServiceAccount->_no = $_master_id;
                        $ServiceAccount->_account_type_id = $_account_type_id;
                        $ServiceAccount->_account_group_id = $_account_group_id;
                        $ServiceAccount->_ledger_id = $request->_main_ledger_id;
                        $ServiceAccount->_cost_center = $users->cost_center_ids;
                        $ServiceAccount->_branch_id = $users->branch_ids;
                        $ServiceAccount->_short_narr = 'N/A';
                        $ServiceAccount->_dr_amount =  0;
                        $ServiceAccount->_cr_amount = $_total_dr_amount;
                        $ServiceAccount->_status = 1;
                        $ServiceAccount->_created_by = $users->id."-".$users->name;
                        $ServiceAccount->save();

 
                        $service_account_id = $ServiceAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$service_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Service';
                        $_date = change_date_format($request->_date);
                        $_table_name ='service_masters';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a =  $_total_dr_amount;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20));
                }


        }

       //return $_cost_center;
                if($__total_discount > 0){
             //#################
            // Service  Discount Dr.
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
        //return $request->_main_ledger_id;
        $_pfix = service_prefix().$_master_id;
       $_l_balance = _l_balance_update($request->_main_ledger_id);
        $_order_number = service_prefix().$_master_id;
        ServiceMaster::where('id',$_master_id)
        ->where('id',$_master_id)
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
                
            

              $_print_value=$request->_print ?? 0;
               DB::commit();
               if($_print_value ==0){
                return redirect()->back()->with('success','Information save successfully');
               }else{
                return redirect()->back()->with('success','Information save successfully')->with('_master_id',$_master_id)->with('_print_value',$_print_value);
               }
                
           } catch (\Exception $e) {
               DB::rollback();
               $_mess['message']='error';
               $_mess['_master_id'] ='no';
               return redirect()->back()->with('success','Something Went Wrong');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceMaster $serviceMaster)
    {
        //
    }



}
