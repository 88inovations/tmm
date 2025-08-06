<?php

namespace App\Http\Controllers;

use App\Models\WarrantyMaster;
use App\Models\StoreHouse;
use App\Models\Warranty;
use App\Models\WarrantyFormSetting;
use App\Models\AccountLedger;
use App\Models\GeneralSettings;
use App\Models\WarrantyDetail;
use App\Models\WarrantyAccount;
use App\Models\AccountHead;
use App\Models\AccountGroup;
use App\Models\Accounts;
use Auth;
use Illuminate\Http\Request;
use DB;
use Session;




class WarrantyMasterController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:warranty-manage-list|warranty-manage-create|warranty-manage-edit|warranty-manage-delete', ['only' => ['index','store']]);
         $this->middleware('permission:warranty-manage-create', ['only' => ['create','store']]);
         $this->middleware('permission:warranty-manage-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:warranty-manage-delete', ['only' => ['destroy']]);
         $this->page_name = "Complain/Warranty Management";
    }


    public function warrantyCheck(Request $request){
      $barcode = $request->_barcode ?? '';
      $page_name="Warranty Check";
       $data=DB::select(" SELECT t1._barcode,t2._order_number,t2.id as _s_id,t2._ledger_id as _s_ledger,t2._date,t3._master_id,t4._order_number as _p_order_number,t4._date as _p_date,t4._ledger_id as _p_ledger,t1._item_id,t5._item,t5._warranty,t6._name,t6._duration,t6._period
FROM sales_barcodes AS t1
INNER JOIN sales AS t2 ON t1._no_id=t2.id
INNER JOIN product_price_lists AS t3 ON t3.id=t1._p_p_id
INNER JOIN purchases AS t4 ON t4.id=t3._master_id
INNER JOIN inventories AS t5 ON t5.id=t1._item_id
INNER JOIN warranties AS t6 ON t6.id=t5._warranty
WHERE t1._barcode='".$barcode."' ");
      return view('backend.warranty-manage.check',compact('page_name','data','request'));
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
            session()->put('_warranty_limit', $request->limit);
        }else{
             $limit= \Session::get('_warranty_limit') ??  default_pagination();
            
        }
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $limit = $request->limit ?? 10;
        $datas = WarrantyMaster::with(['_master_branch','_ledger']);
         //$datas = $datas->orderBy('id','desc')->paginate($limit);
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
         if($request->has('_waranty_status') && $request->_waranty_status !=''){
            $datas = $datas->where('_waranty_status','=',$request->_waranty_status);
        }
        if($request->has('_order_ref_id') && $request->_order_ref_id !=''){
            $datas = $datas->where('_order_ref_id','like',"%trim($request->_order_ref_id)%");
        }
        if($request->has('_order_number') && $request->_order_number !=''){
         
            $datas = $datas->where('_order_number','LIKE',"%$request->_order_number%");
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
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
           $form_settings = WarrantyFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.warranty-manage.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.warranty-manage.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        $page_name = $this->page_name;

        return view("backend.warranty-manage.index",compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }


    public function warrantySearch(Request $request){
         $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_date';
        $text_val = $request->_text_val;
        $_branch_id = $request->_branch_id;
        $datas = WarrantyMaster::with(['_master_branch','_ledger'])
                            ->where('_status',6)
                            ->where('_branch_id',$_branch_id);
         if($request->has('_text_val') && $request->_text_val !=''){
            $datas = $datas->where('id','like',"%$request->_text_val%")
            ->orWhere('_order_number','like',"%$request->_text_val%");
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }

    public function warrantySearchDetail(Request $request){

        $_purchase_main_id =  $request->_purchase_main_id ?? '';
        //  $limit = $request->limit ?? default_pagination();
        // $_asc_desc = $request->_asc_desc ?? 'ASC';
        // $asc_cloumn =  $request->asc_cloumn ?? '_date';
        // $text_val = $request->_text_val;
        // $_branch_id = $request->_branch_id;
         $datas = DB::select(" SELECT t1.id,t1._sales_date,t1._date as _warranty_date,t2._p_p_l_id,t3._master_id,t4._ledger_id AS supplier_id,t5._name AS _supplier_name,t6.id as _customer_id,t6._name AS _customer_name,t2.*,t7._name AS _warrenty_name,t7._description,t7._duration,t7._period,t8._item AS _item_name
            FROM warranty_masters as t1 
            INNER JOIN warranty_details AS t2 ON t1.id=t2._no
            INNER JOIN product_price_lists AS t3 ON  t3.id=t2._p_p_l_id
            INNER JOIN purchases AS t4 ON t4.id=t3._master_id
            INNER JOIN account_ledgers AS t5 ON t4._ledger_id=t5.id
            INNER JOIN account_ledgers AS t6 ON t6.id=t1._ledger_id
            INNER JOIN warranties AS t7 ON t7.id=t2._warranty
            INNER JOIN inventories AS t8 ON t8.id=t2._item_id
            WHERE t2._status=1 AND t1.id=".$_purchase_main_id."  ");
        return json_encode( $datas);
    }



     public function formSettingAjax(){
        $form_settings = WarrantyFormSetting::first();
        $p_accounts = AccountLedger::where('_account_head_id',8)->get();
        return view('backend.warranty-manage.form_setting_modal',compact('form_settings','p_accounts'));
    }

    public function barcodeWarrantySearch(Request $request){
        $_text_val = $request->_text_val ?? '';
        $_item_detail = \DB::select(" SELECT sb._p_p_id,sb._item_id,sb._no_id AS _sales_id,sb._no_detail_id AS _sales_detail_id,sb._qty,sb._status,
sm._branch_id,sm._ledger_id, sm._address, sm._phone, sm._date, sm._store_id, sm._cost_center_id, sm._delivery_man_id,sm._sales_man_id, inv._item AS _item_name,inv._warranty AS _wattanty_id,ac._name AS _ledger_name, sb._barcode,sd._rate,sd._sales_rate,sd._discount,sd._discount_amount,sd._vat,sd._vat_amount,sd._manufacture_date,sd._expire_date
FROM `sales_barcodes` AS sb 
INNER JOIN sales AS sm ON sm.id=sb._no_id
INNER JOIN sales_details as sd ON sd._no=sm.id
INNER JOIN inventories AS inv ON inv.id=sb._item_id
INNER JOIN account_ledgers as ac ON ac.id=sm._ledger_id
WHERE sb._status=1  AND sb._barcode='".$_text_val."' AND sd._barcode LIKE '%$_text_val%' ");
       return json_encode($_item_detail);
    }

    public function warrantySettings(Request $request){
        $data = WarrantyFormSetting::first();
        if(empty($data)){
            $data = new WarrantyFormSetting();
        }

       
        $data->_default_warranty_charge = $request->_default_warranty_charge;
        $data->_show_vat = $request->_show_vat;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
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
        $page_name = $this->page_name;
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();

        return view("backend.warranty-manage.create",compact('page_name','permited_branch','permited_costcenters','store_houses','_warranties'));
    }

    public function print($id){
        $data = WarrantyMaster::with(['_master_branch','_ledger','_master_details','s_account'])->find($id);
        $page_name = "Complain Receive Report";
        $WarrantyFormSetting =  WarrantyFormSetting::first();
        $_default_warranty_charge = $WarrantyFormSetting->_default_warranty_charge;
        return view('backend.warranty-manage.print',compact('data','page_name','_default_warranty_charge'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //return $request->all();
          $users = Auth::user();
          $settings = GeneralSettings::first();
            $_lock = $settings->_auto_lock ?? 0;
            DB::beginTransaction();
           try {
            $_date = $request->_date;
            $WarrantyMaster = new WarrantyMaster();
            $WarrantyMaster->_date = change_date_format($_date);
            $WarrantyMaster->_delivery_date = change_date_format($request->_delivery_date);
            $WarrantyMaster->_time = date('H:i:s');
            $WarrantyMaster->_order_ref_id = $request->_order_ref_id ?? '';
            $WarrantyMaster->_sales_date = change_date_format($request->_sales_date ?? '');
            $WarrantyMaster->_referance = $request->_referance ?? '';
            $WarrantyMaster->_address = $request->_address ?? '';
            $WarrantyMaster->_phone = $request->_phone ?? '';
            $WarrantyMaster->_ledger_id  = $request->_main_ledger_id  ?? '';
            $WarrantyMaster->_user_id  = $users->id  ?? '';
            $WarrantyMaster->_created_by = $users->id."-".$users->name;
            $WarrantyMaster->_user_name = $users->name;
            $WarrantyMaster->_waranty_status = $request->_waranty_status ?? 1;
            $WarrantyMaster->_note = $request->_note ?? '';
            $WarrantyMaster->_total = $request->_total_dr_amount ?? 0;
            $WarrantyMaster->_branch_id = $request->_branch_id ?? 1;
            $WarrantyMaster->_store_id = $request->_store_id ?? 1;
            $WarrantyMaster->_status = $request->_status ?? 1;
            $WarrantyMaster->_lock = $_lock ?? 0;
            $WarrantyMaster->save();
             $_master_id = $WarrantyMaster->id;
             $_order_number = warranty_prefix().$_master_id;
             WarrantyMaster::where('id',$_master_id)->update(['_order_number'=>$_order_number]);

            $_item_ids = $request->_item_id ?? [];
            $_p_p_l_ids = $request->_p_p_l_id ?? [];
            $_purchase_invoice_nos = $request->_purchase_invoice_no ?? [];
            $_purchase_detail_ids = $request->_purchase_detail_id ?? [];
            $_sales_ref_ids = $request->_sales_ref_id ?? [];
            $_sales_detail_ref_ids = $request->_sales_detail_ref_id ?? [];
            $_barcode_s = $request->_barcode_ ?? [];
            $_ref_counters = $request->_ref_counter ?? [];
            $_warrantys = $request->_warranty ?? [];
            $_qtys = $request->_qty ?? [];
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
                    $WarrantyDetail = new WarrantyDetail();
                    $WarrantyDetail->_item_id = $_item_ids[$i] ?? 0;
                    $WarrantyDetail->_p_p_l_id = $_p_p_l_ids[$i] ?? 0;
                    $WarrantyDetail->_qty = $_qtys[$i] ?? 0;
                    $WarrantyDetail->_rate = $_rates[$i] ?? 0;
                    $WarrantyDetail->_sales_rate = $_sales_rates[$i] ?? 0;
                    $WarrantyDetail->_discount = $_discounts[$i] ?? 0;
                    $WarrantyDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                    $WarrantyDetail->_vat = $_vats[$i] ?? 0;
                    $WarrantyDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                    $WarrantyDetail->_value =($_qtys[$i]*$_sales_rates[$i]);
                    $WarrantyDetail->_store_id = $_main_store_ids[$i] ?? 1;
                    $WarrantyDetail->_warranty = $_warrantys[$i] ?? 0;
                    $WarrantyDetail->_warranty_reason = $_warranty_reasons[$i] ?? '';
                    $WarrantyDetail->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                    $WarrantyDetail->_store_salves_id = $_main_store_ids[$i] ?? 1;
                    $WarrantyDetail->_barcode = $_barcode_s[$i] ?? '';
                    $WarrantyDetail->_no = $_master_id ?? 0;
                    $WarrantyDetail->_sales_no = $_sales_ref_ids[$i] ?? 0;
                    $WarrantyDetail->_sales_detail_id = $_sales_detail_ref_ids[$i] ?? 0;
                    $WarrantyDetail->_branch_id = $_main_branch_id_details[$i] ?? 1;
                    $WarrantyDetail->_status = 1;
                    $WarrantyDetail->save();
                }
            }

            $_total_dr_amount = 0;
            $_total_cr_amount = 0;
            $WarrantyFormSetting =  WarrantyFormSetting::first();
            $_default_warranty_charge = $WarrantyFormSetting->_default_warranty_charge;
            $_ref_master_id=$_master_id;
            $_ref_detail_id=$_master_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'Warranty';
            $_date = change_date_format($_date ?? date('Y-m-d'));
            $_table_name = $request->_form_name ?? 'warranty_masters';
            $_branch_id = $request->_branch_id ?? 1;
            $_cost_center =$request->_cost_center ??  1;
            $_name =$users->name;

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_main_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];
            $_branch_id_details = $request->_main_branch_id_detail ?? [];

            if(sizeof($_ledger_ids) > 0){
                for ($i=0; $i <sizeof($_ledger_ids); $i++) { 
                     $ledger = intval($_ledger_ids[$i] ?? 0);
                      $_dr_amount =(float) $_dr_amounts[$i] ?? 0;
                      $_cr_amount =0;
                     
                        if($ledger !=0){
                            $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                            $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                            $WarrantyAccount = new WarrantyAccount();
                            $WarrantyAccount->_no = $_master_id;
                            $WarrantyAccount->_account_type_id = $_account_type_id;
                            $WarrantyAccount->_account_group_id = $_account_group_id;
                            $WarrantyAccount->_ledger_id = $ledger;
                            $WarrantyAccount->_cost_center = $_cost_centers[$i] ?? 1;
                            $WarrantyAccount->_branch_id = $_branch_id_details[$i] ?? 1;
                            $WarrantyAccount->_short_narr = $_short_narrs[$i] ?? 'N/A';
                            $WarrantyAccount->_dr_amount = $_dr_amount ?? 0;
                            $WarrantyAccount->_cr_amount = $_cr_amount ?? 0;
                            $WarrantyAccount->_status = 1;
                            $WarrantyAccount->_created_by = $users->id."-".$users->name;
                            $WarrantyAccount->save();

                            $_sales_account_id = $WarrantyAccount->id;

                            //Reporting Account Table Data Insert
                            $_ref_master_id=$_master_id;
                            $_ref_detail_id=$_sales_account_id;
                            $_short_narration=$_short_narrs[$i] ?? 'N/A';
                            $_narration = $request->_note;
                            $_reference= $request->_referance ?? 'N/A';
                            $_transaction= 'Warranty';
                            $_date = change_date_format($_date);
                            $_table_name ='warranty_masters';
                            $_account_ledger = $ledger;
                            $_dr_amount_a = $_dr_amount ?? 0;
                            $_cr_amount_a = $_cr_amount ?? 0;
                            $_branch_id_a = $_branch_id_details[$i] ?? 1;
                            $_cost_center_a = $_cost_centers[$i] ?? 1;
                            $_name =$users->name;
                            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(2+$i));
                        }
                    
                }

                if($request->_total_dr_amount > 0){


                //Default Service charge Account 
                    $_account_type_id =  ledger_to_group_type($_default_warranty_charge)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($_default_warranty_charge)->_account_group_id;

                    $WarrantyAccount = new WarrantyAccount();
                    $WarrantyAccount->_no = $_master_id;
                    $WarrantyAccount->_account_type_id = $_account_type_id;
                    $WarrantyAccount->_account_group_id = $_account_group_id;
                    $WarrantyAccount->_ledger_id = $_default_warranty_charge;
                    $WarrantyAccount->_cost_center = $_cost_center_head ?? 1;
                    $WarrantyAccount->_branch_id = $request->_branch_id ?? 1;
                    $WarrantyAccount->_short_narr = $request->_search_main_ledger_id ?? 'N/A';
                    $WarrantyAccount->_dr_amount =  0;
                    $WarrantyAccount->_cr_amount = $request->_total_dr_amount ?? 0;
                    $WarrantyAccount->_status = 1;
                    $WarrantyAccount->_created_by = $users->id."-".$users->name;
                    $WarrantyAccount->save();

                      $_sales_account_id = $WarrantyAccount->id;

                    //Reporting Account Table Data Insert
                    $_ref_master_id=$_master_id;
                    $_ref_detail_id=$_sales_account_id;
                    $_short_narration='Service Charge';
                    $_narration = $request->_note;
                    $_reference= $request->_referance ?? 'N/A';
                    $_transaction= 'Warranty';
                    $_date = change_date_format($_date);
                    $_table_name ='warranty_masters';
                    $_account_ledger = $_default_warranty_charge;
                    $_dr_amount_a =  0;
                    $_cr_amount_a = $request->_total_dr_amount ?? 0;
                    $_branch_id_a = $request->_branch_id ?? 1;
                    $_cost_center_a = $_cost_center_head ?? 1;
                    $_name =$users->name;
                    account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(1));

                }

            }
            

              $_print_value=$request->_print ?? 0;
               DB::commit();
                return redirect()->back()->with('success','Information save successfully')->with('_master_id',$_master_id)->with('_print_value',$_print_value);
           } catch (\Exception $e) {
               DB::rollback();
               
               return redirect()->back()->with('error','Somthing Went Wrong');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WarrantyMaster  $warrantyMaster
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $data = WarrantyMaster::with(['_master_branch','_ledger','_master_details','s_account'])->find($id);
        $page_name = "Complain Receive Report";
        $WarrantyFormSetting =  WarrantyFormSetting::first();
        $_default_warranty_charge = $WarrantyFormSetting->_default_warranty_charge;
        return view('backend.warranty-manage.print',compact('data','page_name','_default_warranty_charge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WarrantyMaster  $warrantyMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data =  WarrantyMaster::where('_lock',0)->find($id);
         if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }
        $page_name = $this->page_name;
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
          $data = WarrantyMaster::with(['_master_branch','_ledger','_master_details','s_account'])->find($id);
        $WarrantyFormSetting =  WarrantyFormSetting::first();
             $_default_warranty_charge = $WarrantyFormSetting->_default_warranty_charge;

        return view("backend.warranty-manage.edit",compact('page_name','permited_branch','permited_costcenters','store_houses','_warranties','data','_default_warranty_charge'));
    }

    public function reset(){
        Session::flash('_warranty_limit');
       return  \Redirect::to('warranty-manage?limit='.default_pagination());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WarrantyMaster  $warrantyMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       // return $request->all();
        $users = Auth::user();
          $settings = GeneralSettings::first();
            $_lock = $settings->_auto_lock ?? 0;
            DB::beginTransaction();
           try {
            $_date = $request->_date;
            $WarrantyMaster = WarrantyMaster::find($id);
            $WarrantyMaster->_date = change_date_format($_date);
            $WarrantyMaster->_delivery_date = change_date_format($request->_delivery_date);
            $WarrantyMaster->_time = date('H:i:s');
            $WarrantyMaster->_order_ref_id = $request->_order_ref_id ?? '';
            $WarrantyMaster->_sales_date = change_date_format($request->_sales_date ?? '');
            $WarrantyMaster->_referance = $request->_referance ?? '';
            $WarrantyMaster->_address = $request->_address ?? '';
            $WarrantyMaster->_phone = $request->_phone ?? '';
            $WarrantyMaster->_ledger_id  = $request->_main_ledger_id  ?? '';
            $WarrantyMaster->_user_id  = $users->id  ?? '';
            $WarrantyMaster->_created_by = $users->id."-".$users->name;
            $WarrantyMaster->_user_name = $users->name;
            $WarrantyMaster->_waranty_status = $request->_waranty_status ?? 1;
            $WarrantyMaster->_note = $request->_note ?? '';
            $WarrantyMaster->_total = $request->_total_dr_amount ?? 0;
            $WarrantyMaster->_branch_id = $request->_branch_id ?? 1;
            $WarrantyMaster->_store_id = $request->_store_id ?? 1;
            $WarrantyMaster->_status = $request->_status ?? 1;
            $WarrantyMaster->_lock = $_lock ?? 0;
            $WarrantyMaster->save();
             $_master_id = $WarrantyMaster->id;

            $_item_ids = $request->_item_id ?? [];
            $_p_p_l_ids = $request->_p_p_l_id ?? [];
            $_purchase_invoice_nos = $request->_purchase_invoice_no ?? [];
            $_purchase_detail_ids = $request->_purchase_detail_id ?? [];
            $_sales_ref_ids = $request->_sales_ref_id ?? [];
            $_sales_detail_ref_ids = $request->_sales_detail_ref_id ?? [];
            $_barcode_s = $request->_barcode_ ?? [];
            $_ref_counters = $request->_ref_counter ?? [];
            $_warrantys = $request->_warranty ?? [];
            $_qtys = $request->_qty ?? [];
            $_main_branch_id_details = $request->_main_branch_id_detail ?? [];
            $_main_cost_centers = $request->_main_cost_center ?? [];
            $_main_store_ids = $request->_main_store_id ?? [];
            $_warranty_reasons = $request->_warranty_reason ?? [];

             $_rates = $request->_rate ?? [];
            $_sales_rates = $request->_sales_rate ?? [];

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];

    WarrantyAccount::where('_no',$_master_id)                               
            ->update(['_status'=>0]);
    WarrantyDetail::where('_no',$_master_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_master_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]);  
    Accounts::where('_ref_master_id',$_master_id)
                    ->where('_table_name','warranty_masters')
                     ->update(['_status'=>0]);  


            if(sizeof($_item_ids) > 0){
                for ($i=0; $i <sizeof($_item_ids) ; $i++) { 
                    if($_purchase_detail_ids[$i] !=0){
                        $WarrantyDetail = WarrantyDetail::find($_purchase_detail_ids[$i]);
                    }else{
                        $WarrantyDetail = new WarrantyDetail();
                    }
                    
                    $WarrantyDetail->_item_id = $_item_ids[$i] ?? 0;
                    $WarrantyDetail->_p_p_l_id = $_p_p_l_ids[$i] ?? 0;
                    $WarrantyDetail->_qty = $_qtys[$i] ?? 0;
                    $WarrantyDetail->_rate = $_rates[$i] ?? 0;
                    $WarrantyDetail->_sales_rate = $_sales_rates[$i] ?? 0;
                    $WarrantyDetail->_discount = $_discounts[$i] ?? 0;
                    $WarrantyDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                    $WarrantyDetail->_vat = $_vats[$i] ?? 0;
                    $WarrantyDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                    $WarrantyDetail->_value =($_qtys[$i]*$_sales_rates[$i]);
                    $WarrantyDetail->_store_id = $_main_store_ids[$i] ?? 1;
                    $WarrantyDetail->_warranty = $_warrantys[$i] ?? 0;
                    $WarrantyDetail->_warranty_reason = $_warranty_reasons[$i] ?? '';
                    $WarrantyDetail->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                    $WarrantyDetail->_store_salves_id = $_main_store_ids[$i] ?? 1;
                    $WarrantyDetail->_barcode = $_barcode_s[$i] ?? '';
                    $WarrantyDetail->_sales_no = $_sales_ref_ids[$i] ?? 0;
                    $WarrantyDetail->_sales_detail_id = $_sales_detail_ref_ids[$i] ?? '';
                    $WarrantyDetail->_no = $_master_id ?? 0;
                    $WarrantyDetail->_branch_id = $_main_branch_id_details[$i] ?? 1;
                    $WarrantyDetail->_status = 1;
                    $WarrantyDetail->save();
                }
            }

            $_total_dr_amount = 0;
            $_total_cr_amount = 0;
            $WarrantyFormSetting =  WarrantyFormSetting::first();
            $_default_warranty_charge = $WarrantyFormSetting->_default_warranty_charge;
            $_ref_master_id=$_master_id;
            $_ref_detail_id=$_master_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'Warranty';
            $_date = change_date_format($_date ?? date('Y-m-d'));
            $_table_name = $request->_form_name ?? 'warranty_masters';
            $_branch_id = $request->_branch_id ?? 1;
            $_cost_center =$request->_cost_center ??  1;
            $_name =$users->name;

            $_ledger_ids = $request->_ledger_id ?? [];
            $_cost_centers = $request->_main_cost_center ?? [];
            $_short_narrs = $request->_short_narr ?? [];
            $_dr_amounts = $request->_dr_amount ?? [];
            $_cr_amounts = $request->_cr_amount ?? [];
            $_branch_id_details = $request->_main_branch_id_detail ?? [];

            if(sizeof($_ledger_ids) > 0){
                for ($i=0; $i <sizeof($_ledger_ids) ; $i++) { 
                     $ledger = intval($_ledger_ids[$i]);
                      $_dr_amount =(float) $_dr_amounts[$i] ?? 0;
                      $_cr_amount =0;
                     

                    $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                    $WarrantyAccount = new WarrantyAccount();
                    $WarrantyAccount->_no = $_master_id;
                    $WarrantyAccount->_account_type_id = $_account_type_id;
                    $WarrantyAccount->_account_group_id = $_account_group_id;
                    $WarrantyAccount->_ledger_id = $ledger;
                    $WarrantyAccount->_cost_center = $_cost_centers[$i] ?? 1;
                    $WarrantyAccount->_branch_id = $_branch_id_details[$i] ?? 1;
                    $WarrantyAccount->_short_narr = $_short_narrs[$i] ?? 'N/A';
                    $WarrantyAccount->_dr_amount = $_dr_amount ?? 0;
                    $WarrantyAccount->_cr_amount = $_cr_amount ?? 0;
                    $WarrantyAccount->_status = 1;
                    $WarrantyAccount->_created_by = $users->id."-".$users->name;
                    $WarrantyAccount->save();

                    $_sales_account_id = $WarrantyAccount->id;

                    //Reporting Account Table Data Insert
                    $_ref_master_id=$_master_id;
                    $_ref_detail_id=$_sales_account_id;
                    $_short_narration=$_short_narrs[$i] ?? 'N/A';
                    $_narration = $request->_note;
                    $_reference= $request->_referance ?? 'N/A';
                    $_transaction= 'Warranty';
                    $_date = change_date_format($_date);
                    $_table_name ='warranty_masters';
                    $_account_ledger = $ledger;
                    $_dr_amount_a = $_dr_amount ?? 0;
                    $_cr_amount_a = $_cr_amount ?? 0;
                    $_branch_id_a = $_branch_id_details[$i] ?? 1;
                    $_cost_center_a = $_cost_centers[$i] ?? 1;
                    $_name =$users->name;
                    account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(2+$i));
                }

                if($request->_total_dr_amount > 0){
                //Default Service charge Account 
                    $_account_type_id =  ledger_to_group_type($_default_warranty_charge)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($_default_warranty_charge)->_account_group_id;

                    $WarrantyAccount = new WarrantyAccount();
                    $WarrantyAccount->_no = $_master_id;
                    $WarrantyAccount->_account_type_id = $_account_type_id;
                    $WarrantyAccount->_account_group_id = $_account_group_id;
                    $WarrantyAccount->_ledger_id = $_default_warranty_charge;
                    $WarrantyAccount->_cost_center = $_cost_center_head ?? 1;
                    $WarrantyAccount->_branch_id = $request->_branch_id ?? 1;
                    $WarrantyAccount->_short_narr = $request->_search_main_ledger_id ?? 'N/A';
                    $WarrantyAccount->_dr_amount =  0;
                    $WarrantyAccount->_cr_amount = $request->_total_dr_amount ?? 0;
                    $WarrantyAccount->_status = 1;
                    $WarrantyAccount->_created_by = $users->id."-".$users->name;
                    $WarrantyAccount->save();

                      $_sales_account_id = $WarrantyAccount->id;

                    //Reporting Account Table Data Insert
                    $_ref_master_id=$_master_id;
                    $_ref_detail_id=$_sales_account_id;
                    $_short_narration='Service Chare';
                    $_narration = $request->_note;
                    $_reference= $request->_referance ?? 'N/A';
                    $_transaction= 'Warranty';
                    $_date = change_date_format($_date);
                    $_table_name ='warranty_masters';
                    $_account_ledger = $_default_warranty_charge;
                    $_dr_amount_a =  0;
                    $_cr_amount_a = $request->_total_dr_amount ?? 0;
                    $_branch_id_a = $request->_branch_id ?? 1;
                    $_cost_center_a = $_cost_center_head ?? 1;
                    $_name =$users->name;
                    account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(1));
                }

            }
            

            $_print_value=1;
               DB::commit();
                return redirect()->back()->with('success','Information save successfully')->with('_master_id',$_master_id)->with('_print_value',$_print_value);
           } catch (\Exception $e) {
               DB::rollback();
               $_mess['message']='error';
               $_mess['_master_id'] =$_master_id;
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WarrantyMaster  $warrantyMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(WarrantyMaster $warrantyMaster)
    {
        //
    }
}
