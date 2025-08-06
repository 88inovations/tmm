<?php

namespace App\Http\Controllers;

use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class EasyVoucherController extends Controller
{
     function __construct(){

         $this->middleware('permission:easy-voucher-print', ['only' => ['voucherPrint']]);
         $this->middleware('permission:easy-voucher-create', ['only' => ['create','store']]);
         $this->middleware('permission:easy-voucher-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:easy-voucher-delete', ['only' => ['destroy']]);
         $this->middleware('permission:money-receipt-print', ['only' => ['moneyReceiptPrint']]);
         $this->page_name = "Easy Voucher";

     }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {

        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_vm_limit', $request->limit);
        }else{
             $limit= \Session::get('_vm_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = VoucherMaster::with(['_master_branch','_master_details'])->where('_defalut_ledger_id',1);
        $datas = $datas->whereIn('_branch_id',explode(',',\Auth::user()->branch_ids));
        if($auth_user->user_type !='admin'){
            $datas = $datas->where('_user_id',$auth_user->id);   
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
        
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%trim($request->_code)%");
        }
        if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        if($request->has('_voucher_type') && $request->_voucher_type !=''){
            $datas = $datas->where('_voucher_type','=',$request->_voucher_type);
        }

        if($request->has('_transection_ref') && $request->_transection_ref !=''){
            $datas = $datas->where('_transection_ref','like',"%trim($request->_transection_ref)%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%trim($request->_note)%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%trim($request->_user_name)%");
        }
        
        if($request->has('_amount') && $request->_amount !=''){
            $datas = $datas->where('_amount','=',trim($request->_amount));
        }
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);
        
        $page_name = $this->page_name;
       

        
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
         

         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.easy-voucher.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time'));
            }

            if($request->print =="detail"){
                return view('backend.easy-voucher.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit'));
            }
         }

        return view('backend.easy-voucher.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit'));
    }

     public function reset(){
        Session::flash('_vm_limit');
       return  \Redirect::to('easy-voucher?limit='.default_pagination());
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
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();

       return view('backend.easy-voucher.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            '_voucher_type' => 'required',
            '_date' => 'required'
        ]);

//return $request->all();
        

       DB::beginTransaction();
       try {

            $_print_value = $request->_print ?? 0;
            $organization_id = $request->organization_id ?? 1;

            $users = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster = new VoucherMaster();
            $VoucherMaster->_date = change_date_format($request->_date);
            $VoucherMaster->_voucher_type = $request->_voucher_type;
            $VoucherMaster->organization_id = $organization_id;
            $VoucherMaster->_branch_id = $request->_branch_id;
            $VoucherMaster->_transection_ref = $request->_transection_ref;
            $VoucherMaster->_amount = $request->_total_amount;
            $VoucherMaster->_note = $request->_note;
            $VoucherMaster->_form_name = $request->_form_name;
            $VoucherMaster->_lock = $request->_lock ?? 0;
            $VoucherMaster->_cost_center_id = $request->_cost_center_id ?? 1;
            $VoucherMaster->_status =1;
            $VoucherMaster->_defalut_ledger_id =1;
            $VoucherMaster->_created_by = $users->id."-".$users->name;
            $VoucherMaster->_user_id = $users->id;
            $VoucherMaster->_user_name = $users->name;
            $VoucherMaster->_time = date('H:i:s');
            $VoucherMaster->save();
            $master_id = $VoucherMaster->id;
            VoucherMaster::where('id',$master_id )->update(['_code'=>voucher_prefix().$master_id]);

            //Inser Voucher Details Table
           $_dr_row_ids = $request->_dr_row_id ?? [];
           $_dr_ledger_ids = $request->_dr_ledger_id ?? [];
           $_dr_short_narrs = $request->_dr_short_narr ?? [];

           $_cr_row_ids = $request->_cr_row_id ?? [];
           $_cr_ledger_ids = $request->_cr_ledger_id ?? [];
           $_cr_short_narrs = $request->_cr_short_narr ?? [];

           $_branch_id_details = $request->_branch_id_detail ?? [];
           $_cost_centers = $request->_cost_center ?? [];
           $_amounts = $request->_amount ?? [];


            if(sizeof($_dr_row_ids) > 0){
                for ($i = 0; $i <sizeof($_dr_row_ids) ; $i++) {
                    if($_dr_row_ids[$i]=="0"){

                    //Debet Account Insert
                    $type = ($i+1);

                    $debit_ledger_id = $_dr_ledger_ids[$i];
                    $debit_short_narr = $_dr_short_narrs[$i];
                    $debit_branch_id = $_branch_id_details[$i];
                    $debit_cost_center = $_cost_centers[$i];
                    $debit_amount = $_amounts[$i];
                    $debit_p_balance = _l_balance_update($debit_ledger_id);
                    $debit_account_type_id =  ledger_to_group_type($debit_ledger_id)->_account_head_id;
                    $debit_account_group_id =  ledger_to_group_type($debit_ledger_id)->_account_group_id;
                    

                    $VoucherMasterDetail = new VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $debit_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $debit_account_group_id;
                    $VoucherMasterDetail->_ledger_id = $debit_ledger_id;
                    $VoucherMasterDetail->_cost_center = $debit_cost_center ?? 0;
                    $VoucherMasterDetail->organization_id = $organization_id;
                    $VoucherMasterDetail->_branch_id = $debit_branch_id ?? 0;
                    $VoucherMasterDetail->_short_narr = $debit_short_narr ?? 'N/A';
                    $VoucherMasterDetail->_dr_amount = $debit_amount ?? 0;
                    $VoucherMasterDetail->_cr_amount =  0;
                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_type = $type;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;


                    //Reporting Account Table Data Insert
                    $Accounts = new Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = $debit_short_narr ?? 'N/A';
                    $Accounts->_narration = $request->_note;
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = change_date_format($request->_date);
                    $Accounts->_table_name = $request->_form_name;
                    $Accounts->_account_head = $debit_account_type_id;
                    $Accounts->_account_group = $debit_account_group_id;
                    $Accounts->_account_ledger = $debit_ledger_id;
                    $Accounts->_dr_amount = $debit_amount ?? 0;
                    $Accounts->_cr_amount = 0;
                    $Accounts->organization_id = $organization_id;
                    $Accounts->_branch_id = $debit_branch_id ?? 1;
                    $Accounts->_cost_center = $debit_cost_center ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();

                   $debit_l_balance = ledger_balance_update($debit_ledger_id);


                    $__cr_amount = 0;
                    $__dr_amount =$debit_amount ?? 0;
                    $__amount =0;
                    $_message_string = "";
                    if($__dr_amount > 0){
                      $_message_string = "Your Accont has been debited by ";
                      $__amount =$__dr_amount;
                    }
                   

                    $_ledger_info = AccountLedger::select('_phone','_name')->where('id',$debit_ledger_id)->where('_phone','!=','')->first();
                    //SMS SEND to Customer and Supplier
                     $_send_sms = $request->_send_sms ?? '';
                     if($_send_sms=='yes'){
                        $_name = $_ledger_info->_name ?? '';
                        $_phones = $_ledger_info->_phone ?? "";
                        if(strlen($_phones) >= 11){
                             $messages = "Dear ".$_name.", Voucher N0.".$master_id." ".$_message_string.": ".prefix_taka()."."._report_amount($__amount).". Your Previous Balance ".prefix_taka()."."._report_amount($debit_p_balance).". And Current Balance:".prefix_taka()."."._report_amount($debit_l_balance);
                                sms_send($messages, $_phones);
                        }
                       
                     }
                     //End Sms Send to customer and Supplier
                    $credit_ledger_id = $_cr_ledger_ids[$i];
                    $credit_short_narr = $_cr_short_narrs[$i];
                    $credit_branch_id = $_branch_id_details[$i];
                    $credit_cost_center = $_cost_centers[$i];
                    $credit_amount = $_amounts[$i];
                    $credit_p_balance = _l_balance_update($credit_ledger_id);
                    $credit_account_type_id =  ledger_to_group_type($credit_ledger_id)->_account_head_id;
                    $credit_account_group_id =  ledger_to_group_type($credit_ledger_id)->_account_group_id;
                    

                    $VoucherMasterDetail = new VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $credit_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $credit_account_group_id;
                    $VoucherMasterDetail->_ledger_id = $credit_ledger_id;
                    $VoucherMasterDetail->_cost_center = $credit_cost_center ?? 0;
                    $VoucherMasterDetail->organization_id = $organization_id;
                    $VoucherMasterDetail->_branch_id = $credit_branch_id ?? 0;
                    $VoucherMasterDetail->_short_narr = $credit_short_narr ?? 'N/A';
                    $VoucherMasterDetail->_dr_amount =  0;
                    $VoucherMasterDetail->_cr_amount = $credit_amount ?? 0;
                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_type = $type;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;


                    //Reporting Account Table Data Insert
                    $Accounts = new Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = $credit_short_narr ?? 'N/A';
                    $Accounts->_narration = $request->_note;
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = change_date_format($request->_date);
                    $Accounts->_table_name = $request->_form_name;
                    $Accounts->_account_head = $credit_account_type_id;
                    $Accounts->_account_group = $credit_account_group_id;
                    $Accounts->_account_ledger = $credit_ledger_id;
                    $Accounts->_dr_amount = 0;
                    $Accounts->_cr_amount = $credit_amount ?? 0;
                    $Accounts->organization_id = $organization_id;
                    $Accounts->_branch_id = $credit_branch_id ?? 1;
                    $Accounts->_cost_center = $credit_cost_center ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();

                   $credit_l_balance = ledger_balance_update($credit_ledger_id);


                    $__cr_amount = $credit_amount ?? 0;
                    $__dr_amount =0;
                    $__amount =0;
                    $_message_string = "";
                    if($__cr_amount > 0){
                      $_message_string = "Your Accont has been credited by ";
                      $__amount =$__cr_amount;
                    }

                    $_ledger_info = AccountLedger::select('_phone','_name')->where('id',$credit_ledger_id)->where('_phone','!=','')->first();
                    //SMS SEND to Customer and Supplier
                     $_send_sms = $request->_send_sms ?? '';
                     if($_send_sms=='yes'){
                        $_name = $_ledger_info->_name ?? '';
                        $_phones = $_ledger_info->_phone ?? "";
                        if(strlen($_phones) >= 11){
                             $messages = "Dear ".$_name.", Voucher N0.".$master_id." ".$_message_string.": ".prefix_taka()."."._report_amount($__amount).". Your Previous Balance ".prefix_taka()."."._report_amount($credit_p_balance).". And Current Balance:".prefix_taka()."."._report_amount($credit_l_balance);
                                sms_send($messages, $_phones);
                        }
                       
                     }
                     //End Sms Send to customer and Supplier

                    }
                    
                }
            }

           

           DB::commit();
        return redirect()->back()
                        ->with('success','Information save successfully')
                        ->with('_master_id',$master_id)
                        ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
         $data = VoucherMaster::with(['_master_branch','_master_details'])->find($id);
         $_master_details = $data->_master_details ?? [];
        
        $rearrange_data = [];
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }

         if($data->_defalut_ledger_id==1){
             foreach ($_master_details as $key => $value) {
                 $rearrange_data[$value->_type][] =$value;
             }
             
            return view('backend.easy-voucher.show',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','data','rearrange_data'));
        }else{
           return view('backend.voucher.show',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','data','rearrange_data')); 
        }

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $data = VoucherMaster::with(['_master_branch','_master_details'])->where('_lock',0)->find($id);
        $_master_details = $data->_master_details ?? [];
        
        $rearrange_data = [];
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }

         if($data->_defalut_ledger_id==1){
             foreach ($_master_details as $key => $value) {
                 $rearrange_data[$value->_type][] =$value;
             }
             
            return view('backend.easy-voucher.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','data','rearrange_data'));
        }else{
           return view('backend.voucher.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','data','rearrange_data')); 
        }

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
     $this->validate($request, [
            '_voucher_type' => 'required',
            '_date' => 'required'
        ]);

//return $request->all();
        

       DB::beginTransaction();
       try {

            $_print_value = $request->_print ?? 0;
            $organization_id = $request->organization_id ?? 1;
            $users = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster = VoucherMaster::find($id);
            $VoucherMaster->_date = change_date_format($request->_date);
            $VoucherMaster->_voucher_type = $request->_voucher_type;
            $VoucherMaster->organization_id = $organization_id;
            $VoucherMaster->_branch_id = $request->_branch_id;
            $VoucherMaster->_transection_ref = $request->_transection_ref;
            $VoucherMaster->_amount = $request->_total_amount;
            $VoucherMaster->_note = $request->_note;
            $VoucherMaster->_form_name = $request->_form_name;
            $VoucherMaster->_lock = $request->_lock ?? 0;
            $VoucherMaster->_cost_center_id = $request->_cost_center_id ?? 1;
            $VoucherMaster->_status =1;
            $VoucherMaster->_defalut_ledger_id =1;
            $VoucherMaster->_created_by = $users->id."-".$users->name;
            $VoucherMaster->_user_id = $users->id;
            $VoucherMaster->_user_name = $users->name;
            $VoucherMaster->_time = date('H:i:s');
            $VoucherMaster->save();
            $master_id = $VoucherMaster->id;
            VoucherMaster::where('id',$master_id)->update(['_code'=>voucher_prefix().$master_id]);

            VoucherMasterDetail::where('_no',$master_id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$master_id)
                    ->where('_table_name',$request->_form_name)
                    ->update(['_status'=>0]);

            //Inser Voucher Details Table
           $_dr_row_ids = $request->_dr_row_id ?? [];
           $_dr_ledger_ids = $request->_dr_ledger_id ?? [];
           $_dr_short_narrs = $request->_dr_short_narr ?? [];

           $_cr_row_ids = $request->_cr_row_id ?? [];
           $_cr_ledger_ids = $request->_cr_ledger_id ?? [];
           $_cr_short_narrs = $request->_cr_short_narr ?? [];

           $_branch_id_details = $request->_branch_id_detail ?? [];
           $_cost_centers = $request->_cost_center ?? [];
           $_amounts = $request->_amount ?? [];


            if(sizeof($_dr_ledger_ids) > 0){
                for ($i = 0; $i <sizeof($_dr_ledger_ids) ; $i++) {

                    $type = ($i+1);

                    $debit_ledger_id = $_dr_ledger_ids[$i];
                    $debit_short_narr = $_dr_short_narrs[$i];
                    $debit_branch_id = $_branch_id_details[$i];
                    $debit_cost_center = $_cost_centers[$i];
                    $debit_amount = $_amounts[$i];

                    $debit_p_balance = _l_balance_update($debit_ledger_id);
                    $debit_account_type_id =  ledger_to_group_type($debit_ledger_id)->_account_head_id;
                    $debit_account_group_id =  ledger_to_group_type($debit_ledger_id)->_account_group_id;
                    
                    if($_dr_row_ids[$i] ==0){
                        $VoucherMasterDetail = new VoucherMasterDetail();
                    }else{
                        $VoucherMasterDetail = VoucherMasterDetail::find($_dr_row_ids[$i]); 
                    }

                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $debit_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $debit_account_group_id;
                    $VoucherMasterDetail->_ledger_id = $debit_ledger_id;
                    $VoucherMasterDetail->_cost_center = $debit_cost_center ?? 0;
                    $VoucherMasterDetail->organization_id = $organization_id;
                    $VoucherMasterDetail->_branch_id = $debit_branch_id ?? 0;
                    $VoucherMasterDetail->_short_narr = $debit_short_narr ?? 'N/A';
                    $VoucherMasterDetail->_dr_amount = $debit_amount ?? 0;
                    $VoucherMasterDetail->_cr_amount =  0;
                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_type = $type;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;

                    //Reporting Account Table Data Insert
                    $Accounts = Accounts::where('_ref_master_id',$master_id)
                                        ->where('_table_name',$request->_form_name)
                                        ->where('_ref_detail_id',$master_detail_id)
                                        ->first();
                    if(empty($Accounts)){
                        $Accounts = new Accounts();
                    }

                    
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = $debit_short_narr ?? 'N/A';
                    $Accounts->_narration = $request->_note;
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = change_date_format($request->_date);
                    $Accounts->_table_name = $request->_form_name;
                    $Accounts->_account_head = $debit_account_type_id;
                    $Accounts->_account_group = $debit_account_group_id;
                    $Accounts->_account_ledger = $debit_ledger_id;
                    $Accounts->_dr_amount = $debit_amount ?? 0;
                    $Accounts->_cr_amount = 0;
                    $Accounts->organization_id = $organization_id;
                    $Accounts->_branch_id = $debit_branch_id ?? 1;
                    $Accounts->_cost_center = $debit_cost_center ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();

                   $debit_l_balance = ledger_balance_update($debit_ledger_id);


                    $__cr_amount = 0;
                    $__dr_amount =$debit_amount ?? 0;
                    $__amount =0;
                    $_message_string = "";
                    if($__dr_amount > 0){
                      $_message_string = "Your Accont has been debited by ";
                      $__amount =$__dr_amount;
                    }
                   

                    $_ledger_info = AccountLedger::select('_phone','_name')->where('id',$debit_ledger_id)->where('_phone','!=','')->first();
                    //SMS SEND to Customer and Supplier
                     $_send_sms = $request->_send_sms ?? '';
                     if($_send_sms=='yes'){
                        $_name = $_ledger_info->_name ?? '';
                        $_phones = $_ledger_info->_phone ?? "";
                        if(strlen($_phones) >= 11){
                             $messages = "Dear ".$_name.", Voucher N0.".$master_id." ".$_message_string.": ".prefix_taka()."."._report_amount($__amount).". Your Previous Balance ".prefix_taka()."."._report_amount($debit_p_balance).". And Current Balance:".prefix_taka()."."._report_amount($debit_l_balance);
                                sms_send($messages, $_phones);
                        }
                       
                     }



            //Start Credit account Information


            $credit_ledger_id = $_cr_ledger_ids[$i];
            $credit_short_narr = $_cr_short_narrs[$i];
            $credit_branch_id = $_branch_id_details[$i];
            $credit_cost_center = $_cost_centers[$i];
            $credit_amount = $_amounts[$i];
            $credit_p_balance = _l_balance_update($credit_ledger_id);
            $credit_account_type_id =  ledger_to_group_type($credit_ledger_id)->_account_head_id;
            $credit_account_group_id =  ledger_to_group_type($credit_ledger_id)->_account_group_id;
                    
                if($_cr_row_ids[$i] ==0){
                        $cr_voucher_details = new VoucherMasterDetail();
                    }else{
                        $cr_voucher_details = VoucherMasterDetail::find($_cr_row_ids[$i]); 
                    }

                    
                    $cr_voucher_details->_no = $master_id;
                    $cr_voucher_details->_account_type_id = $credit_account_type_id;
                    $cr_voucher_details->_account_group_id = $credit_account_group_id;
                    $cr_voucher_details->_ledger_id = $credit_ledger_id;
                    $cr_voucher_details->_cost_center = $credit_cost_center ?? 0;
                    $cr_voucher_details->organization_id = $organization_id;
                    $cr_voucher_details->_branch_id = $credit_branch_id ?? 0;
                    $cr_voucher_details->_short_narr = $credit_short_narr ?? 'N/A';
                    $cr_voucher_details->_dr_amount =  0;
                    $cr_voucher_details->_cr_amount = $credit_amount ?? 0;
                    $cr_voucher_details->_status = 1;
                    $cr_voucher_details->_type = $type;
                    $cr_voucher_details->_created_by = $users->id."-".$users->name;
                    $cr_voucher_details->save();
                    $cr_master_detail_id = $cr_voucher_details->id;


                    //Reporting Account Table Data Insert
                  
                    $cr_account = Accounts::where('_ref_master_id',$master_id)
                                        ->where('_table_name',$request->_form_name)
                                        ->where('_ref_detail_id',$cr_master_detail_id)
                                        ->first();
                    if(empty($cr_account)){
                        $cr_account = new Accounts();
                    }

                    $cr_account->_ref_master_id = $master_id;
                    $cr_account->_ref_detail_id = $cr_master_detail_id;
                    $cr_account->_short_narration = $credit_short_narr ?? 'N/A';
                    $cr_account->_narration = $request->_note;
                    $cr_account->_reference = $request->_transection_ref;
                    $cr_account->_voucher_type = $request->_voucher_type ?? 'JV';
                    $cr_account->_transaction = 'Account';
                    $cr_account->_date = change_date_format($request->_date);
                    $cr_account->_table_name = $request->_form_name;
                    $cr_account->_account_head = $credit_account_type_id;
                    $cr_account->_account_group = $credit_account_group_id;
                    $cr_account->_account_ledger = $credit_ledger_id;
                    $cr_account->_dr_amount = 0;
                    $cr_account->_cr_amount = $credit_amount ?? 0;
                    $cr_account->organization_id = $organization_id;
                    $cr_account->_branch_id = $credit_branch_id ?? 1;
                    $cr_account->_cost_center = $credit_cost_center ?? 1;
                    $cr_account->_name =$users->name;
                    $cr_account->save();

                   $credit_l_balance = ledger_balance_update($credit_ledger_id);


                    $__cr_amount = $credit_amount ?? 0;
                    $__dr_amount =0;
                    $__amount =0;
                    $_message_string = "";
                    if($__cr_amount > 0){
                      $_message_string = "Your Accont has been credited by ";
                      $__amount =$__cr_amount;
                    }

                    $_ledger_info = AccountLedger::select('_phone','_name')->where('id',$credit_ledger_id)->where('_phone','!=','')->first();
                    //SMS SEND to Customer and Supplier
                     $_send_sms = $request->_send_sms ?? '';
                     if($_send_sms=='yes'){
                        $_name = $_ledger_info->_name ?? '';
                        $_phones = $_ledger_info->_phone ?? "";
                        if(strlen($_phones) >= 11){
                             $messages = "Dear ".$_name.", Voucher N0.".$master_id." ".$_message_string.": ".prefix_taka()."."._report_amount($__amount).". Your Previous Balance ".prefix_taka()."."._report_amount($credit_p_balance).". And Current Balance:".prefix_taka()."."._report_amount($credit_l_balance);
                                sms_send($messages, $_phones);
                        } //End of Mobile number Check
                       
                     }//End Sms Send to customer and Supplier
                     
  
                    
                }//End of for Loop
            } //End of Sizeof

           

           DB::commit();
        return redirect()->back()
                        ->with('success','Information save successfully')
                        ->with('_master_id',$master_id)
                        ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         return redirect()->back()->with('error','You Can not delete this Information !');
    }
}
