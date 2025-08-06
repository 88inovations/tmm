<?php

namespace App\Http\Controllers\STM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\STM\StmClass;
use App\Models\STM\StmDivision;
use App\Models\STM\StmStudent;
use App\Models\STM\StudentClassSubject;
use App\Models\STM\StmDivisionClassStudent;
use App\Models\STM\StmIncomeLedgerSetup;
use App\Models\STM\StmBillMaster;
use App\Models\STM\StmBillMasterDetail;
use App\Models\STM\StmCollectionMaster;
use App\Models\STM\StmCollectionMasterDetail;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Upzila;
use App\Models\PostCode;
use App\Models\Accounts;
use Auth;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use DB;


class StmBillMasterController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:stm_bill_masters_list|stm_bill_masters_create|stm_bill_masters_edit|stm_bill_masters_delete', ['only' => ['index','store']]);
         $this->middleware('permission:stm_bill_masters_create', ['only' => ['create','store']]);
         $this->middleware('permission:stm_bill_masters_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stm_bill_masters_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.stm_bill_masters');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_name  = __('label.stm_bill_masters');
            $limit  = $request->limit ?? default_pagination();

            $datas = StmBillMaster::with(['_edu_class','_edu_division','_edu_session','_detail'])->where('_status',1);

            if($request->has('organization_id') && $request->organization_id !=''){
                $datas = $datas->where('organization_id',$request->organization_id);
            }

            if($request->has('_branch_id') && $request->_branch_id !=''){
                $datas = $datas->where('_branch_id',$request->_branch_id);
            }
            if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
                $datas = $datas->where('_cost_center_id',$request->_cost_center_id);
            }

            if($request->has('_bill_type') && $request->_bill_type !=''){
                $datas = $datas->where('_bill_type',$request->_bill_type);
            }
            if($request->has('_education_type') && $request->_education_type !=''){
                $datas = $datas->where('_stm_division_id',$request->_education_type);
            }

            if($request->has('_admission_class_id') && $request->_admission_class_id !=''){
                $datas = $datas->where('_class_id',$request->_admission_class_id);
            }

            if($request->has('_admission_session_id') && $request->_admission_session_id !=''){
                $datas = $datas->where('_session_id',$request->_admission_session_id);
            }

            if($request->has('_month') && $request->_month !=''){
                $datas = $datas->where('_month_id',$request->_month);
            }
            if($request->has('_year') && $request->_year !=''){
                $datas = $datas->where('_year',$request->_year);
            }
            if($request->has('_order_number') && $request->_order_number !=''){
                $datas = $datas->where('_order_number',$request->_order_number);
            }

            

            




            $limit = $request->limit ?? 10;

         $_asc_desc = $request->_asc_desc ?? 'DESC';
            $asc_cloumn =  $request->asc_cloumn ?? 'id';

$datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

           

            $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
           $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
           $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();

           




        return view('stm.stm_bill_masters.index',compact('page_name','datas','edu_class','edu_types','stm_education_sessions','request','limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){

           $page_name  = __('label.stm_bill_masters_create');

            $_asc_desc = $request->_asc_desc ?? 'DESC';
            $asc_cloumn =  $request->asc_cloumn ?? 'id';



           $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
           $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
           $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();

           $income_ledgers = \DB::table('stm_income_ledger_setups')->first();

         

        $auth_user = Auth::user();
       
      
        $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));
        $voucher_types = \App\Models\VoucherType::whereIn('id',[3,6])->select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$auth_user->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$auth_user->organization_ids));

      $datas =[];
      $student_ids = '';
      $stm_income_ledger_setups = '';

        if($request->has('search')){

            $stm_income_ledger_setups  = \DB::table('stm_income_ledger_setups')->first();

        $datas = StmDivisionClassStudent::with(['_division','_class_info','_session_info','_student']);

            if($request->has('_education_type') && $request->_education_type !=''){
                $datas= $datas->where('_division_id',$request->_education_type);
            }

            if($request->has('_admission_class_id') && $request->_admission_class_id !=''){
                $datas= $datas->where('_class_id',$request->_admission_class_id);
            }

            if($request->has('_admission_session_id') && $request->_admission_session_id !=''){
                $datas= $datas->where('_session',$request->_admission_session_id);
            }

            if($request->has('_student_id') && $request->_student_id !=''){
                $datas= $datas->where('_student_id',$request->_student_id);
            }
           
            if($request->has('_roll_no') && $request->_roll_no !=''){
                $datas= $datas->where('_roll_no',$request->_roll_no);
            }

            // Filter by student name
                if ($request->has('_student_name') && $request->_student_name != '') {
                    $studentName = $request->_student_name;

                    $datas = $datas->whereHas('_student', function ($query) use ($studentName) {
                        $query->where('_name_in_english', 'like', '%' . $studentName . '%')
                              ->orWhere('_name_in_bangla', 'like', '%' . $studentName . '%');
                    });
                }
           
            $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->get();

            $student_ids = $datas[0]->_student_id ?? '';


    }


   // return $datas;


      //  return $request->all();

    $account_group_configs        = DB::table('account_group_configs')->first();
        $_cash_group                  = $account_group_configs->_cash_group ?? '';
        $_bank_group                  = $account_group_configs->_bank_group ?? '';

        $cash_bank_group_array        = [];
        $cash_bank_group_1            = explode(",", $_cash_group);
        $cash_bank_group_2            = explode(",", $_bank_group);

        $other_ledgers_ids=[];



        $cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);
        $cash_and_bank_ledgers_ids = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_bank_group_array)
                                    ->pluck('id')->toArray();

        $fetchable_ledgers = array_merge($cash_and_bank_ledgers_ids,$other_ledgers_ids);

        $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('id',$fetchable_ledgers)
                                    ->get();




        return view('stm.stm_bill_masters.create',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','income_ledgers','request','datas','collection_ledgers','student_ids','stm_income_ledger_setups'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request){

       // return $request->all();

     $stm_income_ledger_setups  = \DB::table('stm_income_ledger_setups')->first();
     $_discount_ledger  = $stm_income_ledger_setups->_discount_ledger ?? 0;

        $auth_user = Auth::user();

        $_date              = change_date_format($request->_date ?? date('Y-m-d'));
        $organization_id    = $request->organization_id ?? 1;
        $_branch_id         = $request->_branch_id ?? 1;
        $_cost_center_id    = $request->_cost_center_id ?? 1;
        $_bill_type         = $request->_bill_type ?? '';
        $_month_id          = $request->_month ?? '';
        $_year               = $request->_year ?? '';
        $_session_id = $request->_master__session_id ?? '';
         
         $_total_amount     = $request->_grand_total ?? 0;
        $_discount_amount  = array_sum($request->_discount_amount ?? []);
         $_net_amount       = $request->_grand_total ?? 0;
         $_note             = $request->_note ?? '';
         $_roshid_book_no    = $request->_roshid_book_no ?? '';
         $_roshid_no             = $request->_roshid_no ?? '';
         $_student_table_id      = $request->_student_table_id ?? '';
         $_number_of_student   = sizeof($request->_student_id ?? []);




         $_user_id          = $auth_user->id;
         $_user_name        = $auth_user->name ?? '';
         $_created_by       = $auth_user->_created_by ?? '';
         $_updated_by       = $auth_user->_updated_by ?? '';
         $_status           = $request->_status ?? 1;
         $_lock             = $request->_lock ?? 0;
         $_stm_division_id   = $request->_stm_division_id ?? 0;
         $_dr_ledger_id      = $request->_dr_ledger_id ?? 0;
         $_class_id             = $request->_class_id ?? 0;
         //$_session_id             = $request->_admission_session_id ?? 0;

         $stm_bill_masters_id = $request->stm_bill_masters_id ?? '';
         $_transection_ref_string = $request->_transection_ref ?? '';

         $_short_narrations  = $request->_short_narration ?? [];

       


        $StmBillMaster  = StmBillMaster::where('_bill_type',$_bill_type)
                                        ->where('_year',$_year)
                                        ->where('_month_id',$_month_id)
                                        ->where('_session_id',$_session_id)
                                        ->where('_stm_division_id',$_stm_division_id)
                                        ->where('_class_id',$_class_id)->first();
        if(empty($StmBillMaster)){
            $StmBillMaster          = new StmBillMaster();
            $__table="stm_bill_masters";
            $_order_number = make_order_number($__table,$organization_id,$_branch_id,$_date);
            $StmBillMaster->_created_by        = $_created_by;
            $StmBillMaster->_order_number     = $_order_number;

        }else{
            $StmBillMaster->_updated_by        = $_updated_by;
           // $_order_number                      = $request->_order_number ?? '';
        }

        $StmBillMaster->_date   = $_date;
        $StmBillMaster->organization_id   = $organization_id;
        $StmBillMaster->_branch_id        = $_branch_id;
        $StmBillMaster->_cost_center_id   = $_cost_center_id;
        

        $StmBillMaster->_bill_type       = $_bill_type;  //Matching Coloumn
        $StmBillMaster->_month_id        = $_month_id;  //Matching Coloumn
        $StmBillMaster->_year            = $_year;  //Matching Coloumn
        $StmBillMaster->_session_id = $_session_id;  //Matching Coloumn
        $StmBillMaster->_stm_division_id = $_stm_division_id;  //Matching Coloumn
        $StmBillMaster->_class_id        = $_class_id;  //Matching Coloumn

        $StmBillMaster->_dr_ledger_id        = $_dr_ledger_id;
        $StmBillMaster->_total_amount        = $_total_amount;
        $StmBillMaster->_discount_amount        = $_discount_amount;
        $StmBillMaster->_net_amount        = $_net_amount;
        $StmBillMaster->_note        = $_note;
        $StmBillMaster->_user_id        = $_user_id;
        $StmBillMaster->_user_name        = $_user_name;
        $StmBillMaster->_number_of_student        = $_number_of_student ?? 0;
        $StmBillMaster->_status        = $_status;
        $StmBillMaster->_lock        = $_lock;
        $StmBillMaster->save();

        $stm_bill_masters_id  = $StmBillMaster->id;
        $_order_number        = $StmBillMaster->_order_number;
        $_code               = $StmBillMaster->_order_number;



        // Update if 

        Accounts::where('_transaction','stm_bill_masters')
                    ->where('_ref_master_id',$stm_bill_masters_id)
                    ->update(['_status'=>0]);


        /**/
           $_account_type_id       =  ledger_to_group_type($_dr_ledger_id)->_account_head_id;
           $_account_group_id      =  ledger_to_group_type($_dr_ledger_id)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $stm_bill_masters_id;
            $Accounts->_ref_detail_id       = $stm_bill_masters_id;
            $Accounts->_short_narration     = "Bill Generate";
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_bill_masters';
            $Accounts->_date                = $_date;
            $Accounts->_table_name          = $request->_form_name ?? 'stm_bill_masters';
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_dr_ledger_id;
            $Accounts->_dr_amount           = 0;
            $Accounts->_cr_amount           =   $_net_amount ?? 0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                = $auth_user->name;
            $Accounts->_month               = $_month_id ?? 0;
            $Accounts->_year                = $_year ?? 0;
            $Accounts->save();
            ledger_balance_update($_dr_ledger_id);


        StmBillMasterDetail::where('_no',$stm_bill_masters_id)->update(['_status'=>0]);


        $_student_ids           = $request->_student_id ?? [];
        $_admission_fees        = $request->_admission_fee ?? [];
        $_net_fee_amounts        = $request->_admission_fee ?? [];
        $_due_amounts           = $request->_due_amount ?? [];
        $_collection_ledger_ids = $request->_collection_ledger_id ?? [];
        $_collection_amounts    = $request->_collection_amount ?? [];
        $_due_balances          = $request->_due_balance ?? [];
        $_is_closes             = $request->_is_close ?? [];
        $_is_effects            = $request->_is_effect ?? [];
        $stm_bill_master_details_ids = $request->stm_bill_master_details_id ?? [];
        $stm_bill_collections_ids = $request->stm_bill_collections_id ?? [];
        $_session_ids = $request->_session_id ?? [];
        $_discount_amounts = $request->_discount_amount ?? [];

        $collection_ledger_amounts = [];
        foreach($stm_bill_master_details_ids as $key=>$stm_bill_master_details_id){

           


            $_student_id            = $_student_ids[$key] ?? 0;
            $_admission_fee         = $_admission_fees[$key] ?? 0;
            $_net_fee_amount        = $_net_fee_amounts[$key] ?? 0;
            $_due_amount            = $_due_amounts[$key] ?? 0;
            $_collection_ledger_id  = $_collection_ledger_ids[$key] ?? 0;
            $_collection_amount     = $_collection_amounts[$key] ?? 0;
            $_due_balance           = $_due_balances[$key] ?? 0;
            $_is_close              = $_is_closes[$key] ?? 0;
            $_is_effect             = $_is_effects[$key] ?? 0;
            $stm_bill_master_details_id  = $stm_bill_master_details_ids[$key] ?? 0;
            $stm_bill_collections_id     = $stm_bill_collections_ids[$key] ?? 0;
            $_session_id     = $_session_ids[$key] ?? 0;
            $_remarks     = $_remarkss[$key] ?? '';


            
if($_admission_fee > 0){

   

    $StmBillMasterDetail   = StmBillMasterDetail::where('organization_id',$organization_id)
                                                 ->where('_branch_id',$_branch_id)
                                                 ->where('_cost_center_id',$_cost_center_id)
                                                 ->where('_student_id',$_student_id)
                                                 ->where('_session_id',$_session_id)
                                                 ->where('_stm_division_id',$_stm_division_id)
                                                 ->where('_class_id',$_class_id)
                                                 ->where('_bill_type',$_bill_type)
                                                 ->where('_month_id',$_month_id)
                                                 ->where('_year',$_year)
                                                 ->first();

  

            if(empty($StmBillMasterDetail)){
                $StmBillMasterDetail                    = new StmBillMasterDetail();
                $StmBillMasterDetail->_created_by       = $auth_user->name ?? '';
                 $StmBillMasterDetail->_receive_amount  = $_collection_amounts[$key] ?? 0;
                $StmBillMasterDetail->_due_amount       = $_admission_fees[$key] ?? 0;



            }else{
                $StmBillMasterDetail->_updated_by      = $auth_user->name ?? '';
                $old__receive_amount                   = $StmBillMasterDetail->_receive_amount ?? 0;
                $old__due_amount                       = $StmBillMasterDetail->_due_amount ?? 0;

                $StmBillMasterDetail->_receive_amount  = $old__receive_amount;
                $StmBillMasterDetail->_due_amount      = (($_admission_fees[$key] ?? 0)-$old__receive_amount);
            }

            $StmBillMasterDetail->_fee_amount         = $_admission_fees[$key] ?? 0;
            $StmBillMasterDetail->_discount_amount    = $_discount_amounts[$key] ?? 0;
            $StmBillMasterDetail->_net_fee_amount     = $_net_fee_amounts[$key] ?? 0;
            $StmBillMasterDetail->organization_id   = $organization_id;
            $StmBillMasterDetail->_branch_id        = $_branch_id;
            $StmBillMasterDetail->_cost_center_id   = $_cost_center_id;
            $StmBillMasterDetail->_no               = $stm_bill_masters_id;
            $StmBillMasterDetail->_student_id       = $_student_id;
            $StmBillMasterDetail->_month_id         = $_month_id;
            $StmBillMasterDetail->_year             = $_year;
            $StmBillMasterDetail->_stm_division_id  = $_stm_division_id;
            $StmBillMasterDetail->_session_id       = $_session_id;
            $StmBillMasterDetail->_class_id         = $_class_id;
            $StmBillMasterDetail->_bill_type        = $_bill_type;
            $StmBillMasterDetail->_is_close         = $_is_closes[$key] ?? 0;
            $StmBillMasterDetail->_status           = $_statuss[$key] ?? 1;
            $StmBillMasterDetail->save();

            $master_detail_id  = $StmBillMasterDetail->id;


            // Data Send to Account Table For Reports

            // Find Studen id to student Ledger Id

            $_student_ledger_id             = id_to_cloumn($_student_id,'_ledger_id','stm_students');
            $_account_type_id               =  ledger_to_group_type($_student_ledger_id)->_account_head_id;
           $_account_group_id               =  ledger_to_group_type($_student_ledger_id)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $stm_bill_masters_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = $_short_narrations[$key] ?? '';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string ?? '';
            $Accounts->_voucher_type        = 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_bill_masters';
            $Accounts->_date                = $_date;
            $Accounts->_table_name          = 'stm_bill_masters';
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_student_ledger_id;
            $Accounts->_dr_amount           = (($_admission_fees[$key] ?? 0));
            $Accounts->_cr_amount           =  0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                = $auth_user->name;
            $Accounts->_month               = $_month_id ?? 0;
            $Accounts->_year                = $_year ?? 0;
            $Accounts->save();
            ledger_balance_update($_student_ledger_id); // Bill Generate  Complete 
}
            





        } /*End of Generation section */


        


      
            $success_message ="Information Save successfully.";
        return redirect()->route('stm_bill_masters.index')
                    ->with('success',$success_message);



        /* Start Bill Collection Section End*/




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name  = __('label.stm_bill_masters');
        $data = StmBillMaster::with(['_edu_class','_edu_division','_edu_session','_detail'])->where('_status',1)->find($id);

            return view('stm.stm_bill_masters.show',compact('page_name','data'));
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
        

    $data  = StmBillMaster::find($id);
    $bill_voucher_code  = $data->_order_number ?? 0;
    $data->_status  = 0;
    $data->save();


   

  Accounts::where('_transaction','stm_bill_masters')->where('_voucher_code',$bill_voucher_code)->update(['_status'=>0]);

              $success_message ="Information Deleted successfully.";
    return redirect()->route('stm_bill_masters.index')
                    ->with('danger',$success_message);

    }
}
