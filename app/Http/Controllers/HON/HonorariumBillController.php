<?php

namespace App\Http\Controllers\HON;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HON\HonorimSetup;
use App\Models\GeneralSettings;
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

class HonorariumBillController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:honorarium_bills_list|honorarium_bills_create|honorarium_bills_edit|honorarium_bills_delete', ['only' => ['index','store']]);
         $this->middleware('permission:honorarium_bills_create', ['only' => ['create','store']]);
         $this->middleware('permission:honorarium_bills_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:honorarium_bills_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.honorarium_bills');
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
        

        
        $datas = HonorariumBill::with(['_organization','_cost_center','_branch']);

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
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);



        



        return view('hon.honorarium_bills.index',compact('page_name','request','datas','permited_organizations','permited_branch','permited_costcenters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

         $page_name = $this->page_name;
        $users = Auth::user();
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $_requested_group_array  = _honorarium_group_array();
        
        $datas =[];

        if($request->has('_month') && $request->has('_year')){
            $datas = AccountLedger::with(['_honorarium_info','account_type','account_group','_organization','_branch','_cost_center'])->whereIn('_account_group_id',$_requested_group_array);


            if($request->has('organization_id') && $request->organization_id !=''){
                $datas = $datas->where('organization_id','=',$request->organization_id);
            }

            if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
                $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
            }
            if($request->has('_branch_id') && $request->_branch_id !=''){
                $datas = $datas->where('_branch_id','=',$request->_branch_id);
            }

             $datas  = $datas->get();
        }
       
        



        



        return view('hon.honorarium_bills.create',compact('page_name','request','datas','permited_organizations','permited_branch','permited_costcenters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

       // return $request->all();


        $auth_user  = Auth::user();

        $_date              = change_date_format($request->_date ?? date('d-m-Y'));
        $_note              = $request->_note ?? '';
        $_month             = $request->_month ?? '';
        $_year              = $request->_year ?? '';

        $_budget_id         = $request->_budget_id ?? 0;
        $_ledger_ids        = $request->_ledger_id ?? [];
        $organization_ids   = $request->organization_id ?? [];
        $_cost_center_ids   = $request->_cost_center_id ?? [];
        $_branch_ids        = $request->_branch_id ?? [];
        $_setup_ids         = $request->_setup_id ?? [];
        $_amounts           = $request->_amount ?? [];
        $_statuss           = $request->_status ?? [];
        $_short_narrs           = $request->_short_narr ?? [];

        $rearrage_data_sets_amount = [];
        $rearrage_data_sets_ledgers = [];
        $re_arrange_datas = [];

        //Honorarium Expense Ledger Find out from general Settings

        $settings  = \DB::table('general_settings')->select('_honorarium_ledger')->first();

        $_honorarium_ledger = $settings->_honorarium_ledger ?? '';
        if($_honorarium_ledger ==''){
            return redirect('admin-settings')->with('danger','Please Setup Honorarium Expense Ledger');
        }

            //Previous Data Update to Status =0
            for ($i=0; $i <sizeof($_statuss) ; $i++) { 
                        $_status = $_statuss[$i] ?? 0;
                       $organization_id = $organization_ids[$i] ?? 0;
                       
                       $_branch_id      = $_branch_ids[$i] ?? 0;
                       $_cost_center_id = $_cost_center_ids[$i] ?? 0;
                       $_ledger_id      = $_ledger_ids[$i] ?? 0;
                       $_amount      = $_amounts[$i] ?? 0;
                       $_short_narr      = $_short_narrs[$i] ?? '';


             HonorariumBillDetail::where('_month',$_month)
                                            ->where('_year',$_year)
                                            ->where('_branch_id',$_branch_id)
                                            ->where('organization_id',$organization_id)
                                            ->where('_cost_center',$_cost_center_id)
                                            ->where('_ledger_id',$_ledger_id)
                                            ->update(['_status'=>0]);
            }




        // Data Rearrage for make Voucher
        for ($i=0; $i <sizeof($_statuss) ; $i++) { 

           $_status = $_statuss[$i] ?? 0;
           $organization_id = $organization_ids[$i] ?? 0;
           
           $_branch_id      = $_branch_ids[$i] ?? 0;
           $_cost_center_id = $_cost_center_ids[$i] ?? 0;
           $_ledger_id      = $_ledger_ids[$i] ?? 0;
           $_amount      = $_amounts[$i] ?? 0;
           $_short_narr      = $_short_narrs[$i] ?? '';

           //Update Previous All Information

           




            $_account_type_id =  ledger_to_group_type($_ledger_id)->_account_head_id ?? 0;
            $_account_group_id =  ledger_to_group_type($_ledger_id)->_account_group_id ?? 0;

           $HonorariumBillDetail  = HonorariumBillDetail::where('_month',$_month)
                                                        ->where('_year',$_year)
                                                        ->where('_branch_id',$_branch_id)
                                                        ->where('organization_id',$organization_id)
                                                        ->where('_ledger_id',$_ledger_id)
                                                        ->first();
            if(empty( $HonorariumBillDetail)){
                 $HonorariumBillDetail              = new  HonorariumBillDetail();
                 $HonorariumBillDetail->_created_by = $auth_user->name ?? '';
            }
            $HonorariumBillDetail->_month           = $_month ?? '';
            $HonorariumBillDetail->_year            = $_year ?? '';
            $HonorariumBillDetail->_account_type_id = $_account_type_id ?? 0;
            $HonorariumBillDetail->_account_group_id = $_account_group_id ?? 0;
            $HonorariumBillDetail->_ledger_id       = $_ledger_id ?? 0;
            $HonorariumBillDetail->_sales_man_id       = $_sales_man_id ?? 0;
            $HonorariumBillDetail->_amount       = $_amount ?? 0;
            $HonorariumBillDetail->_due_amount       = $_amount ?? 0;
            $HonorariumBillDetail->organization_id       = $organization_id ?? 0;
            $HonorariumBillDetail->_branch_id       = $_branch_id ?? 0;
            $HonorariumBillDetail->_cost_center       = $_cost_center_id ?? 0;
            $HonorariumBillDetail->_budget_id       = $_budget_id ?? 0;
            $HonorariumBillDetail->_short_narr       = $_short_narr ?? 'N/A';
            $HonorariumBillDetail->_status          = $_status ?? 0;
            $HonorariumBillDetail->_is_close       = $_is_close ?? 0;
            $HonorariumBillDetail->save();





           if($_status ==1){
                $rearrage_data_sets_amount[$organization_id."__".$_branch_id."__".$_cost_center_id][] = $_amount;
                $rearrage_data_sets_ledgers[$organization_id."__".$_branch_id."__".$_cost_center_id][] = $_ledger_id;
                $re_arrange_datas[$organization_id."__".$_branch_id."__".$_cost_center_id."__".$_ledger_id][]=$_amount ?? 0; 
           }

        }

 DB::beginTransaction();
       try {

$serial_key =1;
foreach($rearrage_data_sets_amount as $org_b_cs=>$amouns){
    $org_string_to_array = explode('__',$org_b_cs);
    //return $org_string_to_array;
    $org_id = $org_string_to_array[0] ?? 1; 
    $branch_id = $org_string_to_array[1] ?? 1; 
    $cost_center_id = $org_string_to_array[2] ?? 1; 

    $_amount   = array_sum($amouns);
        //First Generate Voucher Master useing dataset  $rearrage_data_sets_amount 

         $HonorariumBill = HonorariumBill::where('_month',$_month)
                    ->where('_year',$_year)
                    ->where('organization_id',$org_id)
                    ->where('_branch_id',$branch_id)
                    ->where('_cost_center_id',$cost_center_id)
                    ->first();
        //Lock check
        $_lock = $HonorariumBill->_lock ?? 0;
        if($_lock==1){
            $_lock_mesge=_number_to_month($data->_month)." - ".$_year." Honorarium Bill already Genarated ";
            return redirect()->back()->with('error',$_lock_mesge);
        }

        if(empty($HonorariumBill)){
            $HonorariumBill = new HonorariumBill();
            $HonorariumBill->_created_by = $auth_user->id;
        }else{
            $HonorariumBill->_updated_by = $auth_user->_updated_by;
        }

        $HonorariumBill->_month = $_month;
        $HonorariumBill->_year = $_year;
        $HonorariumBill->organization_id = $org_id;
        $HonorariumBill->_branch_id = $branch_id;
        $HonorariumBill->_cost_center_id = $_cost_center_id;
        $HonorariumBill->_date = $_date;
        //$HonorariumBill->_voucher_id = $_voucher_id;
        //$HonorariumBill->_voucher_code = $_voucher_code;
        $HonorariumBill->_amount = $_amount;
        $HonorariumBill->_note = $_note;
        $HonorariumBill->_user_id = $auth_user->id;
        $HonorariumBill->_user_name = $auth_user->user_name ?? '';
        $HonorariumBill->_status = 1;
        $HonorariumBill->_lock = 0;
        $HonorariumBill->_is_posting = $request->_is_posting ?? 0;
        $HonorariumBill->save();

        $_honorarium_bill_id = $HonorariumBill->id;
        $_defalut_ledger_id = $HonorariumBill->id;




        //



         $voucher_info = VoucherMaster::where('_transection_type','honorarium_bills')
                            ->where('_transection_ref',$_honorarium_bill_id)
                            ->first();
         if(!empty($voucher_info )){
           $voucher_id =  $voucher_info->id;
            VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$voucher_id)
                        ->where('_transaction','honorarium_bills')
                        ->update(['_status'=>0]);

         }else{
            $type_wise_number = type_wise_voucher_number('JV',$_date);
            $_code = voucher_prefix()."JV"."-".$type_wise_number;
             $voucher_info = new VoucherMaster();
            $voucher_info->_code = $_code;
         }

   
    
        $voucher_info->_defalut_ledger_id = $_defalut_ledger_id;
        $voucher_info->_transection_ref = $_defalut_ledger_id;
        $voucher_info->_transection_type = 'honorarium_bills';
        
        $voucher_info->_date = change_date_format($_date);
       
        $voucher_info->_time = date('H:i:s');
        $voucher_info->_form_name = 'voucher_masters';
        $voucher_info->_ref_table = 'honorarium_bills';
       
        $voucher_info->_created_by = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id = $auth_user->id;
        $voucher_info->_user_name = $auth_user->name;
        $voucher_info->_note = $_note;
        $voucher_info->_voucher_type = 'JV';
        
        $voucher_info->_amount = $_amount ?? 0;
        

        $voucher_info->organization_id = $org_id ?? 1;
        $voucher_info->_branch_id = $branch_id ?? 1;
        $voucher_info->_cost_center_id = $cost_center_id ?? 1;
        $voucher_info->_budget_id = $_budget_id ?? 0;
        $voucher_info->_sales_man_id = 0;
        $voucher_info->_lock = 0;
        $voucher_info->_status =1;
        $voucher_info->save();

       // return $voucher_info;

        $master_id = $voucher_info->id;
        $voucher_code = $voucher_info->_code;

        HonorariumBill::where('id',$_defalut_ledger_id)
                    ->update(['voucher_id'=>$master_id,'voucher_code'=>$voucher_code]);




        // Honorarium Expnese Ledger for group org_id,branch_id,and cost_center

               $_account_type_id =  ledger_to_group_type($_honorarium_ledger)->_account_head_id ?? 0;
                $_account_group_id =  ledger_to_group_type($_honorarium_ledger)->_account_group_id ?? 0;

                $VoucherMasterDetail = new VoucherMasterDetail();
                $VoucherMasterDetail->_no = $master_id;
                $VoucherMasterDetail->_account_type_id = $_account_type_id;
                $VoucherMasterDetail->_account_group_id = $_account_group_id;
                $VoucherMasterDetail->_ledger_id = $_honorarium_ledger ?? 0;

                $VoucherMasterDetail->organization_id = $org_id;
                $VoucherMasterDetail->_branch_id = $branch_id ?? 0;
                $VoucherMasterDetail->_cost_center = $cost_center_id ?? 0;
                $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;

                $VoucherMasterDetail->_short_narr = $_note ?? '';
                $VoucherMasterDetail->_dr_amount = $_amount;
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
                $Accounts->_voucher_type = 'JV';
                $Accounts->_transaction = 'honorarium_bills';
               // $Accounts->_transaction = 'Account';
                $Accounts->_date = change_date_format($_date);
                $Accounts->_table_name = 'voucher_masters';
                $Accounts->_account_head = $_account_type_id;
                $Accounts->_account_group = $_account_group_id;
                $Accounts->_account_ledger = $_honorarium_ledger;
                $Accounts->_dr_amount =  $_amount;
                $Accounts->_cr_amount = 0;
                $Accounts->organization_id = $org_id ?? 1;
                $Accounts->_branch_id = $branch_id ?? 0;
                $Accounts->_cost_center = $cost_center_id ?? 0;
                $Accounts->_budget_id = $_budget_id ?? 0;
                $Accounts->_serial = $serial_key ?? 0;
                $Accounts->_month = $_month ?? 0;
                $Accounts->_year = $_year ?? 0;
                $Accounts->_name = $auth_user->name;
                $Accounts->_sales_man_id = $_sales_man_id ?? 0;
                $Accounts->save();



         //data without Honorarium Person Dr Ledger
        foreach($re_arrange_datas as $obc_key=>$obc_sad){
            $serial_key++;

             $obc_string_to_array = explode('__',$obc_key);
              $obc_org_id = $obc_string_to_array[0] ?? ''; 
             $obc_branch_id = $obc_string_to_array[1] ?? 1; 
             $obc_cost_center_id = $obc_string_to_array[2] ?? 1; 
              $obc_ledger_id = $obc_string_to_array[3] ?? ''; 
             $_tk_amount =  array_sum($obc_sad);
            // echo $obc_ledger_id;
            //  if($obc_ledger_id ==''){
            //     return "empty Ledger";
            //  }

             $obc_org_b_c=$obc_org_id."__".$obc_branch_id."__".$obc_cost_center_id;


             if($org_b_cs ==$obc_org_b_c){
                if($_tk_amount > 0){


                $_account_type_id =  ledger_to_group_type($obc_ledger_id)->_account_head_id ?? 0;
                $_account_group_id =  ledger_to_group_type($obc_ledger_id)->_account_group_id ?? 0;

                $VoucherMasterDetail = new VoucherMasterDetail();
                $VoucherMasterDetail->_no = $master_id;
                $VoucherMasterDetail->_account_type_id = $_account_type_id;
                $VoucherMasterDetail->_account_group_id = $_account_group_id;
                $VoucherMasterDetail->_ledger_id = $obc_ledger_id ?? 0;

                $VoucherMasterDetail->organization_id = $obc_org_id;
                $VoucherMasterDetail->_branch_id = $obc_branch_id ?? 0;
                $VoucherMasterDetail->_cost_center = $obc_cost_center_id ?? 0;
                $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;

                $VoucherMasterDetail->_short_narr = $_note;
                $VoucherMasterDetail->_dr_amount = 0;
                $VoucherMasterDetail->_cr_amount =  $_tk_amount ?? 0;
                
                
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
                $Accounts->_voucher_type = 'JV';
                $Accounts->_transaction = 'honorarium_bills';
               // $Accounts->_transaction = 'Account';
                $Accounts->_date = change_date_format($_date);
                $Accounts->_table_name = 'voucher_masters';
                $Accounts->_account_head = $_account_type_id;
                $Accounts->_account_group = $_account_group_id;
                $Accounts->_account_ledger = $obc_ledger_id;
                $Accounts->_dr_amount =  0;
                $Accounts->_cr_amount = $_tk_amount ?? 0;
                $Accounts->organization_id = $obc_org_id ?? 1;
                $Accounts->_branch_id = $obc_branch_id ?? 0;
                $Accounts->_cost_center = $obc_cost_center_id ?? 0;
                $Accounts->_budget_id = $_budget_id ?? 0;
                $Accounts->_serial = $serial_key ?? 0;
                $Accounts->_month = $_month ?? 0;
                $Accounts->_year = $_year ?? 0;
                $Accounts->_name =$auth_user->name;
                $Accounts->_sales_man_id = $_sales_man_id ?? 0;
                $Accounts->save();


                 }
             } //End of All ledger Voucher without Employees



        } 




    } // End of 

    DB::commit();
            return redirect()->route('honorarium_bills.index')
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

         $page_name = __('label.honorarium_bills');

     $data   = HonorariumBill::with(['_organization','_branch','_cost_center'])->find($id);

      $_voucher_detail  = $data->_voucher_detail ?? [];

    



    return view('hon.honorarium_bills.show',compact('page_name','data','_voucher_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
