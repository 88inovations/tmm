<?php

namespace App\Http\Controllers\HON;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HON\HonorimSetup;
use App\Models\GeneralSettings;
use App\Models\VoucharCheckInfo;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Models\HON\HonorariumBill;
use App\Models\HON\HonorariumBillDetail;
use App\Models\HON\HonorariumPayment;
use App\Models\HON\HonorariumPaymentDetail;
use App\Models\AccountGroup;
use App\Models\Accounts;
use App\Models\AccountLedger;
use App\Models\MainAccountHead;
use App\Models\VoucherMaster;
use App\Models\VoucherMasterDetail;

class HonorariumPaymentController extends Controller
{
      function __construct()
    {
         $this->middleware('permission:honorarium_payments_list|honorarium_payments_create|honorarium_payments_edit|honorarium_payments_delete', ['only' => ['index','store']]);
         $this->middleware('permission:honorarium_payments_create', ['only' => ['create','store']]);
         $this->middleware('permission:honorarium_payments_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:honorarium_payments_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.honorarium_payments');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $page_name = $this->page_name;
        $users = Auth::user();
          $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_honararium_limit', $request->limit);
        }else{
             $limit= \Session::get('_honararium_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';


         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        

        
        $datas = HonorariumPayment::with(['_ledger','_organization','_cost_center','_branch']);

        if($request->has('_year')  && $request->_year !=''){
            $datas = $datas->where('_year',$request->_year);
        }
        if($request->has('_month')  && $request->_month !=''){
            $datas = $datas->where('_month',$request->_month);
        }
        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id','=',$request->organization_id);
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','=',$request->_branch_id);
        }
        if($request->has('_honorarium_ledger_id') && $request->_honorarium_ledger_id !=''){
            $datas = $datas->where('_honorarium_ledger_id','=',$request->_honorarium_ledger_id);
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

      $_requested_group_array  = _honorarium_group_array();


     $ledgers = AccountLedger::with(['_branch'])->whereIn('_account_group_id',$_requested_group_array);


        if($request->has('organization_id') && $request->organization_id !=''){
            $ledgers = $ledgers->where('organization_id','=',$request->organization_id);
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $ledgers = $ledgers->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $ledgers = $ledgers->where('_branch_id','=',$request->_branch_id);
        }

         $ledgers  = $ledgers->get();



        



        return view('hon.honorarium_payments.index',compact('page_name','request','datas','permited_organizations','permited_branch','permited_costcenters','ledgers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        //return $request->all();
         $page_name = $this->page_name;
        $users = Auth::user();
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $_requested_group_array  = _honorarium_group_array();
        
        $datas =[];

         $ledgers = AccountLedger::with(['_branch'])->whereIn('_account_group_id',$_requested_group_array);


        if($request->has('organization_id') && $request->organization_id !=''){
            $ledgers = $ledgers->where('organization_id','=',$request->organization_id);
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $ledgers = $ledgers->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $ledgers = $ledgers->where('_branch_id','=',$request->_branch_id);
        }

         $ledgers  = $ledgers->get();
         $ledger_info ='';
         $emplyee_ledgers =[];
         $collection_ledgers =[];

         if($request->has('_honorarium_ledger_id') && $request->_honorarium_ledger_id !=''){
            $ledger_info = AccountLedger::find($request->_honorarium_ledger_id);
            $datas = HonorariumBillDetail::with(['_organization','_cost_center','_branch','_ledger'])
                            ->where('_due_amount','>',0)
                            ->where('_status',1)
                            ->where('_is_close',0);

                if($request->has('_honorarium_ledger_id')  && $request->_honorarium_ledger_id !=''){
                    $datas = $datas->where('_ledger_id',$request->_honorarium_ledger_id);
                }
                
                $datas = $datas->get();

                
   $cash_and_bank_groups  = cash_and_bank_groups();

    $cash_and_bank_groups_array            = explode(",", $cash_and_bank_groups);
        
   $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_and_bank_groups_array)
                                    ->get();


    $_employee_group_array  = _employee_group_array();

     $emplyee_ledgers = \DB::table("account_ledgers")
                                    ->where('_branch_id',$ledger_info->_branch_id)
                                    ->whereIn('_account_group_id',$_employee_group_array)
                                    ->get();


    }
       



        



        return view('hon.honorarium_payments.create',compact('page_name','request','datas','permited_organizations','permited_branch','permited_costcenters','ledgers','ledger_info','collection_ledgers','emplyee_ledgers'));
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


        $auth_user  = Auth::user();

        $_date              = change_date_format($request->_date ?? date('d-m-Y'));
        $_note              = $request->_note ?? '';
        $_type              = $request->_type ?? 'JV';
        $_months             = $request->_month ?? [];
        $_years              = $request->_year ?? [];

        $_budget_id         = $request->_budget_id ?? 0;
        $_sales_man_id         = $request->_sales_man_id ?? 0;
        $_honorarium_ledger_id        = $request->_honorarium_ledger_id ?? 0;
        $organization_id   = $request->organization_id ?? 0;
        $_cost_center_id   = $request->_cost_center_id ?? 0;
        $_branch_id        = $request->_branch_id ?? 0;

        $_setup_ids         = $request->_setup_id ?? 0;
        $_amounts           = $request->_amount ?? [];
        $_statuss           = $request->_status ?? [];
        $_short_narrs       = $request->_short_narr ?? [];

        $_bill_detail_ids   = $request->_bill_detail_id ?? [];
        $_payment_detail_ids   = $request->_payment_detail_id ?? [];


        $_bill_amounts   = $request->_bill_amount ?? [];
        $_paid_amounts   = $request->_paid_amount ?? [];
        $_collection_ledger_ids   = $request->_collection_ledger_id ?? [];
        $_due_amounts   = $request->_due_amount ?? [];
        $_pay_amounts   = $request->_pay_amount ?? [];
        $_due_balances   = $request->_due_balance ?? [];
        $_short_narrs   = $request->_short_narr ?? [];
        $_is_closes   = $request->_is_close ?? [];
        $_is_effects   = $request->_is_effect ?? [];

        $_grand_pay_amount  = $request->_grand_pay_amount ?? 0;

        $_grand_amount =0;
        foreach($_is_effects as $is_ek=>$_is_effect){
            $_grand_amount +=$_pay_amounts[$is_ek] ?? 0;
        }

        $honorarium_payments_id  = $request->honorarium_payments_id ?? 0;


     DB::beginTransaction();
       try {


        $HonorariumPayment  = HonorariumPayment::find($honorarium_payments_id);

        if(empty($HonorariumPayment)){
            $HonorariumPayment  = new HonorariumPayment();
            $HonorariumPayment->_created_by  = $auth_user->_name ?? '';
        }else{
            $HonorariumPayment->_updated_by       = $auth_user->_name ?? '';

        }
        $HonorariumPayment->_date             = $_date;
        $HonorariumPayment->organization_id   = $organization_id;
        $HonorariumPayment->_branch_id        = $_branch_id;
        $HonorariumPayment->_cost_center_id   = $_cost_center_id;
        $HonorariumPayment->_honorarium_ledger_id  = $_honorarium_ledger_id;
        $HonorariumPayment->_amount           = $_grand_amount;
        $HonorariumPayment->_note             = $_note;
        $HonorariumPayment->save();

        $honorarium_payment_row_id            = $HonorariumPayment->id;
        $_defalut_ledger_id                   = $HonorariumPayment->id;



        HonorariumPaymentDetail::where('_no',$honorarium_payment_row_id)->update(['_status'=>0]);



        $voucher_info = VoucherMaster::where('_transection_type','honorarium_payments')
                            ->where('_transection_ref',$honorarium_payment_row_id)
                            ->first();
         if(!empty($voucher_info )){
           $voucher_id =  $voucher_info->id;
            VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$voucher_id)
                        ->where('_transaction','honorarium_payments')
                        ->update(['_status'=>0]);

         }else{
            $type_wise_number = type_wise_voucher_number($_type,$_date);
            $_code = voucher_prefix().$_type."-".$type_wise_number;
             $voucher_info = new VoucherMaster();
            $voucher_info->_code = $_code;
         }

   
    
        $voucher_info->_defalut_ledger_id = $_defalut_ledger_id;
        $voucher_info->_transection_ref = $_defalut_ledger_id;
        $voucher_info->_transection_type = 'honorarium_payments';
        
        $voucher_info->_date = change_date_format($_date);
       
        $voucher_info->_time = date('H:i:s');
        $voucher_info->_form_name = 'voucher_masters';
        $voucher_info->_ref_table = 'honorarium_payments';
       
        $voucher_info->_created_by = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id = $auth_user->id;
        $voucher_info->_user_name = $auth_user->name;
        $voucher_info->_note = $_note;
        $voucher_info->_voucher_type = $_type ?? 'JV';
        
        $voucher_info->_amount = $_grand_amount ?? 0;
        

        $voucher_info->organization_id = $organization_id ?? 1;
        $voucher_info->_branch_id = $_branch_id ?? 1;
        $voucher_info->_cost_center_id = $_cost_center_id ?? 1;
        $voucher_info->_budget_id = $_budget_id ?? 0;
        $voucher_info->_sales_man_id = $_sales_man_id;
        $voucher_info->_lock = 0;
        $voucher_info->_status =1;
        $voucher_info->save();

        $voucher_id  = $voucher_info->id;
        $master_id  = $voucher_info->id;
        $voucher_code       = $voucher_info->_code ?? '';

        VoucharCheckInfo::where('_voucher_no',$master_id)->update(['_status'=>0]);

        $VoucharCheckInfo =  VoucharCheckInfo::where('_voucher_no',$master_id)->first();
        if(empty($VoucharCheckInfo)){
          $VoucharCheckInfo = new VoucharCheckInfo();

        }
        $VoucharCheckInfo->_voucher_no=$master_id;
        $VoucharCheckInfo->_check_no=$request->_check_no ?? '';
        $VoucharCheckInfo->_bank_name=$request->_bank_name ?? '';
        $VoucharCheckInfo->_branch_name=$request->_branch_name ?? '';
        $VoucharCheckInfo->_bank_account=$request->_bank_account ?? '';
        $VoucharCheckInfo->_issue_date=$request->_issue_date ?? '';
        $VoucharCheckInfo->_cash_date=$request->_cash_date ?? '';
        $VoucharCheckInfo->_status=1;
        $VoucharCheckInfo->save();



        HonorariumPayment::where('id',$honorarium_payment_row_id)
                        ->update(['voucher_id'=>$voucher_id,'voucher_code'=>$voucher_code]);


        


        $serial_key = 0;
        foreach($_is_effects as $ef_key=>$_is_effect){

            $_payment_detail_id    = $_payment_detail_ids[$ef_key] ?? 0;
            $_status    = $_statuss[$ef_key] ?? 0;
            $_bill_detail_id    = $_bill_detail_ids[$ef_key] ?? 0;
            $_bill_amount    = $_bill_amounts[$ef_key] ?? 0;
            $_paid_amount    = $_paid_amounts[$ef_key] ?? 0;
            $_collection_ledger_id    = $_collection_ledger_ids[$ef_key] ?? 0;
            $_due_amount    = $_due_amounts[$ef_key] ?? 0;
            $_pay_amount    = $_pay_amounts[$ef_key] ?? 0;
            $_due_balance    = $_due_balances[$ef_key] ?? 0;
            $_short_narr    = $_short_narrs[$ef_key] ?? 'N/A';
            $_is_close    = $_is_closes[$ef_key] ?? 0;
            $_month    = $_months[$ef_key] ?? 0;
            $_year    = $_years[$ef_key] ?? 0;


            if($ef_key ==0){

                $_account_type_id =  ledger_to_group_type($_honorarium_ledger_id)->_account_head_id ?? 0;
                $_account_group_id =  ledger_to_group_type($_honorarium_ledger_id)->_account_group_id ?? 0;

                $VoucherMasterDetail = new VoucherMasterDetail();
                $VoucherMasterDetail->_no = $master_id;
                $VoucherMasterDetail->_account_type_id = $_account_type_id;
                $VoucherMasterDetail->_account_group_id = $_account_group_id;
                $VoucherMasterDetail->_ledger_id = $_honorarium_ledger_id ?? 0;

                $VoucherMasterDetail->organization_id = $organization_id;
                $VoucherMasterDetail->_branch_id = $_branch_id ?? 0;
                $VoucherMasterDetail->_cost_center = $_cost_center_id ?? 0;
                $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;

                $VoucherMasterDetail->_short_narr = $_note ?? '';
                $VoucherMasterDetail->_dr_amount = $_grand_amount ?? 0;
                $VoucherMasterDetail->_cr_amount =  0;
                
                
                $VoucherMasterDetail->_status = 1;
                $VoucherMasterDetail->_created_by = $auth_user->id."-".$auth_user->name;
                $VoucherMasterDetail->save();
                $master_detail_id = $VoucherMasterDetail->id;

                //Reporting Account Table Data Insert
                $Accounts = new Accounts();
                $Accounts->_ref_master_id = $master_id;
                $Accounts->_voucher_code = $voucher_code ?? '';
                $Accounts->_ref_detail_id = $master_detail_id;
                $Accounts->_short_narration = $_note ?? 'N/A';
                $Accounts->_narration = $_note ?? '';
                $Accounts->_reference = $_defalut_ledger_id;
                $Accounts->_voucher_type = $_type ?? 'JV';
                $Accounts->_transaction = 'honorarium_payments';
               // $Accounts->_transaction = 'Account';
                $Accounts->_date = change_date_format($_date);
                $Accounts->_table_name = 'voucher_masters';
                $Accounts->_account_head = $_account_type_id;
                $Accounts->_account_group = $_account_group_id;
                $Accounts->_account_ledger = $_honorarium_ledger_id;
                $Accounts->_dr_amount =  $_grand_amount ?? 0;
                $Accounts->_cr_amount = 0;
                $Accounts->organization_id = $organization_id ?? 1;
                $Accounts->_branch_id = $_branch_id ?? 0;
                $Accounts->_cost_center = $_cost_center_id ?? 0;
                $Accounts->_budget_id = $_budget_id ?? 0;
                $Accounts->_serial = $serial_key ?? 0;
                $Accounts->_month = $_month ?? 0;
                $Accounts->_year = $_year ?? 0;
                $Accounts->_name = $auth_user->name;
                $Accounts->_sales_man_id = $_sales_man_id ?? 0;
                $Accounts->save();

            } //End of Dorcotr Voucher



            

            $_account_type_id =  ledger_to_group_type($_collection_ledger_id)->_account_head_id ?? 0;
            $_account_group_id =  ledger_to_group_type($_collection_ledger_id)->_account_group_id ?? 0;


            $HonorariumPaymentDetail  = HonorariumPaymentDetail::find($_payment_detail_id);
            if(empty($HonorariumPaymentDetail)){
                $HonorariumPaymentDetail = new HonorariumPaymentDetail(); 
                $HonorariumPaymentDetail->_created_by = $auth_user->name ?? ''; 
            }else{
                $HonorariumPaymentDetail->_updated_by = $auth_user->name ?? ''; 
            }

            $HonorariumPaymentDetail->_no = $honorarium_payment_row_id ?? 0; 
            $HonorariumPaymentDetail->_month = $_month ?? 0; 
            $HonorariumPaymentDetail->_year = $_year ?? 0; 
            $HonorariumPaymentDetail->_account_type_id = $_account_type_id ?? 0; 
            $HonorariumPaymentDetail->_account_group_id = $_account_group_id ?? 0; 
            $HonorariumPaymentDetail->_bill_master_id = $_bill_master_id ?? 0; 
            $HonorariumPaymentDetail->_bill_detail_id = $_bill_detail_id ?? 0; 
            $HonorariumPaymentDetail->_ledger_id = $_collection_ledger_id ?? 0; 
            $HonorariumPaymentDetail->_sales_man_id = $_sales_man_id ?? 0; 
            $HonorariumPaymentDetail->_amount = $_pay_amount ?? 0; 
            $HonorariumPaymentDetail->_previous_receive = $_paid_amount ?? 0; 
            $HonorariumPaymentDetail->_due_amount = $_due_balance ?? 0; 
            $HonorariumPaymentDetail->organization_id = $organization_id ?? 0; 
            $HonorariumPaymentDetail->_branch_id = $_branch_id ?? 0; 
            $HonorariumPaymentDetail->_cost_center = $_cost_center_id ?? 0; 
            $HonorariumPaymentDetail->_budget_id = $_budget_id ?? 0; 
            $HonorariumPaymentDetail->_short_narr = $_short_narr ?? ''; 
            $HonorariumPaymentDetail->_status = 1; 
            $HonorariumPaymentDetail->_is_close = $_is_close; 
            $HonorariumPaymentDetail->_is_effect = $_is_effect; 
            $HonorariumPaymentDetail->save(); 



            if($_is_effect ==1){

                $serial_key++;
                // Honorarium Expnese Ledger for group org_id,branch_id,and cost_center

               $_account_type_id =  ledger_to_group_type($_collection_ledger_id)->_account_head_id ?? 0;
                $_account_group_id =  ledger_to_group_type($_collection_ledger_id)->_account_group_id ?? 0;

                $VoucherMasterDetail = new VoucherMasterDetail();
                $VoucherMasterDetail->_no = $master_id;
                $VoucherMasterDetail->_account_type_id = $_account_type_id;
                $VoucherMasterDetail->_account_group_id = $_account_group_id;
                $VoucherMasterDetail->_ledger_id = $_collection_ledger_id ?? 0;

                $VoucherMasterDetail->organization_id = $organization_id;
                $VoucherMasterDetail->_branch_id = $_branch_id ?? 0;
                $VoucherMasterDetail->_cost_center = $_cost_center_id ?? 0;
                $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;

                $VoucherMasterDetail->_short_narr = $_short_narr ?? '';
                $VoucherMasterDetail->_dr_amount = 0;
                $VoucherMasterDetail->_cr_amount =  $_pay_amount ?? 0;
                
                
                $VoucherMasterDetail->_status = 1;
                $VoucherMasterDetail->_created_by = $auth_user->id."-".$auth_user->name;
                $VoucherMasterDetail->save();
                $master_detail_id = $VoucherMasterDetail->id;

                //Reporting Account Table Data Insert
                $Accounts = new Accounts();
                $Accounts->_ref_master_id = $master_id;
                $Accounts->_voucher_code = $voucher_code ?? '';
                $Accounts->_ref_detail_id = $master_detail_id;
                $Accounts->_short_narration = $_short_narr ?? 'N/A';
                $Accounts->_narration = $_note ?? '';
                $Accounts->_reference = $_defalut_ledger_id;
                $Accounts->_voucher_type = $_type ?? 'JV';
                $Accounts->_transaction = 'honorarium_payments';
               // $Accounts->_transaction = 'Account';
                $Accounts->_date = change_date_format($_date);
                $Accounts->_table_name = 'voucher_masters';
                $Accounts->_account_head = $_account_type_id;
                $Accounts->_account_group = $_account_group_id;
                $Accounts->_account_ledger = $_collection_ledger_id;
                $Accounts->_dr_amount =  0;
                $Accounts->_cr_amount = $_pay_amount;
                $Accounts->organization_id = $organization_id ?? 1;
                $Accounts->_branch_id = $_branch_id ?? 0;
                $Accounts->_cost_center = $_cost_center_id ?? 0;
                $Accounts->_budget_id = $_budget_id ?? 0;
                $Accounts->_serial = $serial_key ?? 0;
                $Accounts->_month = $_month ?? 0;
                $Accounts->_year = $_year ?? 0;
                $Accounts->_name = $auth_user->name;
                $Accounts->_sales_man_id = $_sales_man_id ?? 0;
                $Accounts->save();






                // Bill data update
        }

           $HonorariumBillDetail                = HonorariumBillDetail::find($_bill_detail_id);
           $old_receive_amount                  = $HonorariumBillDetail->_paid_amount ?? 0;
           $old_due_amount                      = $HonorariumBillDetail->_due_amount ?? 0;
           $new_receive_amount                  = ($old_receive_amount + $_pay_amount);
           $new_due_amount                      = ($_bill_amount -($new_receive_amount));
           $HonorariumBillDetail->_paid_amount  = $new_receive_amount;
           $HonorariumBillDetail->_due_amount   = $new_due_amount;
           $HonorariumBillDetail->_is_close     = $_is_close ?? 0;
           $HonorariumBillDetail->save();

    }


            DB::commit();
            return redirect()->route('honorarium_payments.index')
             ->with('success', __('label.info_created'));
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('success',"Something Wrong");
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
        //

        $auth_user = Auth::user();
         $page_name = __('label.honorarium_payments');

       $data   = HonorariumPayment::with(['_ledger','_organization','_branch','_cost_center'])->find($id);
        $ledger_info  = $data->_ledger;

    
     $_details = $data->_details ?? [];

   $cash_and_bank_groups  = cash_and_bank_groups();

    $cash_and_bank_groups_array            = explode(",", $cash_and_bank_groups);
        
   $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_and_bank_groups_array)
                                    ->get();


    $_employee_group_array  = _employee_group_array();

     $emplyee_ledgers = \DB::table("account_ledgers")
                                    ->where('_branch_id',$ledger_info->_branch_id)
                                    ->whereIn('_account_group_id',$_employee_group_array)
                                    ->get();

    



    return view('hon.honorarium_payments.show',compact('page_name','data','_details','collection_ledgers','emplyee_ledgers','ledger_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $page_name = __('label.honorarium_payments');
         $auth_user = Auth::user();

           $permited_organizations = permited_organization(explode(',',$auth_user->organization_ids));
        $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));

       $data   = HonorariumPayment::with(['_ledger','_organization','_branch','_cost_center'])->find($id);
       $datas = $data->_details ?? [];

          $ledger_info  = $data->_ledger;
      
        $cash_and_bank_groups  = cash_and_bank_groups();

    $cash_and_bank_groups_array            = explode(",", $cash_and_bank_groups);
        
   $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_and_bank_groups_array)
                                    ->get();


    $_employee_group_array  = _employee_group_array();

     $emplyee_ledgers = \DB::table("account_ledgers")
                                    ->where('_branch_id',$ledger_info->_branch_id)
                                    ->whereIn('_account_group_id',$_employee_group_array)
                                    ->get();

    $check_info  = VoucharCheckInfo::where('_voucher_no',$data->voucher_id)->where('_status',1)->first();

      return view('hon.honorarium_payments.edit',compact('page_name','data','datas','collection_ledgers','emplyee_ledgers','ledger_info','permited_organizations','permited_branch','permited_costcenters','check_info'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
