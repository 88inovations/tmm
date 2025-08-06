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
use App\Models\STM\StmBillCollection;
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

class StmBillCollectionController extends Controller
{

     function __construct()
    {
         
         $this->middleware('permission:admission_fee_collection', ['only' => ['admission_fee_collection_list','admissionFeeCollectionForm']]);
         $this->middleware('permission:admission_fee_collection_edit', ['only' => ['admission_fee_collection_edit']]);
         $this->middleware('permission:admission_fee_collection_delete', ['only' => ['admission_fee_collection_delete']]);
         
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request){

            $page_name  = __('label.stm_collection');
            if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_collection_limit', $request->limit);
            }else{
                 $limit= \Session::get('_collection_limit') ??  default_pagination();
                
            }

            $_asc_desc = $request->_asc_desc ?? 'DESC';
            $asc_cloumn =  $request->asc_cloumn ?? 'id';


            $students_lists = StmStudent::where('_admission_session_id',$request->_admission_session_id);

            $datas = StmCollectionMaster::with(['_detail','_branch','_ledger','_edu_class','_edu_division','_edu_session','_student'])->where('_bill_type','!=','_admission_fee')
                                        ->where('_status',1);

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
            if($request->has('_order_number') && $request->_order_number !=''){
                $datas = $datas->where('_order_number',$request->_order_number);
            }

            if($request->has('_month') && $request->_month !=''){
                $datas = $datas->where('_month_id',$request->_month);
            }
            if($request->has('_year') && $request->_year !=''){
                $datas = $datas->where('_year',$request->_year);
            }
            if($request->has('_student_id') && $request->_student_id !=''){
                $datas = $datas->where('_dr_ledger_id',$request->_student_id);
                $students_lists =$students_lists->where('id',$request->_student_id);
            }
            if($request->has('_admission_session_id') && $request->_admission_session_id !=''){
                $datas = $datas->where('_session_id',$request->_admission_session_id);
            }
            if($request->has('_education_type') && $request->_education_type !=''){
                $datas = $datas->where('_stm_division_id',$request->_education_type);

                $students_lists = $students_lists->where('_education_type',$request->_education_type);
            }
            if($request->has('_admission_class_id') && $request->_admission_class_id !=''){
                $datas = $datas->where('_class_id',$request->_admission_class_id);
                 $students_lists = $students_lists->where('_admission_class_id',$request->_admission_class_id);
            }
           
           $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

            
            $students_lists =$students_lists->get();

        


            $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
           $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
           $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();

           




        return view('stm.stm_collection.index',compact('page_name','datas','edu_class','edu_types','stm_education_sessions','request','limit','students_lists'));
    }


    /**
     * Show the form for creating a new resource.
     * Fee Collection
     *
     * @return \Illuminate\Http\Response
     */
    /* Admission Fee Collection and Admission Fee Generate */


    public function create(Request $request){

           $page_name  = __('label.stm_collection_form');

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

        if($request->has('search')){


//return $request->all();

$sql_query = " SELECT t1.id as _bill_detail_id, t1.organization_id, t1._branch_id, t1._cost_center_id, t1._no, t1._student_id, t1._stm_division_id, t1._class_id, t1._bill_type, t1._month_id, t1._year, t1._fee_amount, t1._discount_amount, t1._net_fee_amount, t1._receive_amount, t1._due_amount, t1._is_close, t1._status,
t2._ledger_id,t2._roll_no,t2._name_in_english,t2._name_in_bangla,t2._father_name_english,t2._father_name_bangla,
t2._f_mobile_no,t2._student_id as _student_unique_id,0 as _collection_detail_id
FROM stm_bill_master_details AS t1
INNER JOIN stm_students as t2 ON t1._student_id=t2.id
INNER JOIN stm_bill_masters as t3 ON t3.id=t1._no
WHERE t1._status=1 ";
if($request->has('_admission_session_id') && $request->_admission_session_id !=''){
    $sql_query .=" AND t2._admission_session_id =".$request->_admission_session_id."   ";
               
}
if($request->has('_education_type') && $request->_education_type !=''){
    $sql_query .="  AND  t1._stm_division_id =".$request->_education_type."   ";
               
}
if($request->has('_admission_class_id') && $request->_admission_class_id !=''){
    $sql_query .=" AND  t1._class_id =".$request->_admission_class_id."   ";
               
}
if($request->has('_roll_no') && $request->_roll_no !=''){
    $sql_query .=" AND  t2._roll_no =".$request->_roll_no."   ";
               
}
if($request->has('_student_id') && $request->_student_id !=''){
    $sql_query .=" AND  t2._student_id  = ".$request->_student_id."   ";
               
}

$sql_query .=" AND  t1._due_amount > 0 AND t1._is_close=0   ";

 $datas = \DB::select($sql_query);


      
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




        return view('stm.stm_collection.create',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','income_ledgers','request','datas','collection_ledgers','student_ids'));

    }


    public function student_due_bill_search(Request $request){
          $page_name  = __('label.stm_collection_form');

          

           $income_ledgers = \DB::table('stm_income_ledger_setups')->first();

         

        $auth_user = Auth::user();
       
      
    $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));
        $voucher_types = \App\Models\VoucherType::whereIn('id',[3,6])->select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$auth_user->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$auth_user->organization_ids));

      $datas =[];
      $student_ids = '';

  $student_info = StmStudent::find($request->_student_id);


//return $request->all();

 $datas = StmBillMasterDetail::with(['_session_info','_division','_class_info','_student','_master'])
                                ->where('_status',1)
                                ->where('_due_amount','>',0)
                                ->where('_is_close','=',0);
 



 if($request->has('_admission_session_id') && $request->_admission_session_id){
    $_admission_session_id = $request->_admission_session_id;
    $datas = $datas->whereHas('_student', function ($query) use ($_admission_session_id) {
                        $query->where('_admission_session_id', $_admission_session_id);
                    });
 }

 if($request->has('_bill_type') && $request->_bill_type){
    $_bill_type = $request->_bill_type;
    $datas = $datas->whereHas('_master', function ($query) use ($_bill_type) {
                        $query->where('_bill_type', $_bill_type);
        });
 }

 if($request->has('_education_type') && $request->_education_type){
    $datas = $datas->where('_stm_division_id',$request->_education_type);
 }
 if($request->has('_admission_class_id') && $request->_admission_class_id){
    $datas = $datas->where('_class_id',$request->_admission_class_id);
 }
 if($request->has('_student_id') && $request->_student_id){
    $datas = $datas->where('_student_id',$request->_student_id);
 }
 $datas = $datas->get();




      



    


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


        //return $request->all();

        return view('stm.stm_collection.due_bill_search_form',compact('income_ledgers','request','datas','collection_ledgers','student_ids','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','student_info'));

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

        $_student_table_id      = $request->_student_table_id ?? 0;
        $_stm_division_id       = $request->_stm_division_id ?? 0;
        $_class_id              = $request->_admission_class_id ?? 0;
        $_session_id            = $request->_admission_session_id ?? 0;

        $_date                  = change_date_format($request->_date ?? date('Y-m-d'));
        $_user_table_id         = $request->_user_table_id ?? 0;
        $_student_id            = $request->_student_id ?? 0;
        $_name_in_english       = $request->_name_in_english ?? '';
        $_father_name_english   = $request->_father_name_english ?? '';
        $organization_id        = $request->organization_id ?? '';
        $_branch_id             = $request->_branch_id ?? '';
        $_cost_center_id        = $request->_cost_center_id ?? '';
        $_bill_type             = $request->_bill_type ?? '';
        $_roshid_book_no        = $request->_roshid_book_no ?? '';
        $_roshid_no             = $request->_roshid_no ?? '';
        $_student_ledger_id             = id_to_cloumn($_student_table_id,'_ledger_id','stm_students');

        $_grand_total                   = $request->_grand_total ?? 0;
        $_grand_collection_amount       = $request->_grand_collection_amount ?? 0;
        $_grand_discount_amount         = $request->_grand_discount_amount ?? 0;
        $_grand_due_balance             = $request->_grand_due_balance ?? 0;
        $_note                          = $request->_note ?? '';

     $stm_income_ledger_setups  = \DB::table('stm_income_ledger_setups')->first();
     $_discount_ledger  = $stm_income_ledger_setups->_discount_ledger ?? 0;




        //Array Variable
       



        $this->validate($request, [
            '_date' => 'required'
        ]);

         
        $__table         = $request->_form_name ?? 'stm_collection_masters';
        $_date           = change_date_format($request->_date);
        $_order_number   = make_order_number($__table,$organization_id,$_branch_id,$_date);

        $_is_confirm     = $request->_is_confirm ?? 1;
         
       $month = date('m', strtotime($_date)); // '05'
        $year = date('Y', strtotime($_date));  // '2025'

        $stm_collection_id  = $request->stm_collection_id ?? 0;



        Accounts::where('_ref_master_id',$stm_collection_id)
                        ->where('_table_name',$__table)
                        ->update(['_status'=>0]);


        DB::beginTransaction();
       try {


        $_print_value                       = $request->_print ?? 0;
         $users = Auth::user();


        $StmCollectionMaster                =  StmCollectionMaster::find($stm_collection_id);
        if(empty($StmCollectionMaster)){
             $StmCollectionMaster                = new StmCollectionMaster();
             $_order_number   = make_order_number($__table,$organization_id,$_branch_id,$_date);
             $StmCollectionMaster->_order_number      = $_order_number;
              $StmCollectionMaster->_created_by        = $auth_user->name;
        }else{
             $StmCollectionMaster->_updated_by        = $auth_user->name;
        }
       
        $StmCollectionMaster->_date         = change_date_format($_date);
        

        
        $StmCollectionMaster->_roshid_book_no    = $_roshid_book_no;
        $StmCollectionMaster->_roshid_no         = $_roshid_no;
        $StmCollectionMaster->organization_id    = $organization_id;
        $StmCollectionMaster->_branch_id         = $_branch_id;
        $StmCollectionMaster->_cost_center_id    = $_cost_center_id;
        $StmCollectionMaster->_bill_type         = $_bill_type;
        $StmCollectionMaster->_month_id          = $month;
        $StmCollectionMaster->_year              = $year;
        $StmCollectionMaster->_stm_division_id   = $_stm_division_id;
        $StmCollectionMaster->_session_id        = $_session_id;
        $StmCollectionMaster->_class_id          = $_class_id;
        $StmCollectionMaster->_student_table_id  = $_student_table_id;
        $StmCollectionMaster->_dr_ledger_id      = $_student_ledger_id;
        $StmCollectionMaster->_number_of_student = 1;
        $StmCollectionMaster->_total_amount      =( $_grand_collection_amount+$_grand_discount_amount);
        $StmCollectionMaster->_discount_amount   = $_grand_discount_amount;
        $StmCollectionMaster->_net_amount        = $_grand_collection_amount;
        $StmCollectionMaster->_note              = $_note;
        $StmCollectionMaster->_user_id           = $auth_user->id;
        $StmCollectionMaster->_user_name         = $auth_user->name;
       
        
        $StmCollectionMaster->_status           = 1;
        $StmCollectionMaster->_lock             = $request->_lock ?? 0;
        $StmCollectionMaster->_is_confirm       = $request->_is_confirm ?? 1;
        $StmCollectionMaster->save();

      


        $purchase_id = $StmCollectionMaster->id;
        $master_id = $StmCollectionMaster->id;

        $_pfix               = $StmCollectionMaster->_order_number ?? '';
        $_code               = $StmCollectionMaster->_order_number ?? '';



 $_session_ids                  = $request->_session_id ?? [];
$_month_ids                     = $request->_month_id ?? [];
$_years                         = $request->_year ?? [];
$stm_bill_master_details_ids    = $request->stm_bill_master_details_id ?? [];
$stm_bill_collections_ids       = $request->stm_bill_collections_id ?? [];

$_fee_amounts                   = $request->_fee_amount ?? [];
$_due_amounts                   = $request->_due_amount ?? [];
$_receive_amounts               = $request->_receive_amount ?? [];
$_collection_ledger_ids         = $request->_collection_ledger_id ?? [];
$_collection_amounts            = $request->_collection_amount ?? [];
$_discount_amounts              = $request->_discount_amount ?? [];
$_due_balances                  = $request->_due_balance ?? [];
$_is_closes                     = $request->_is_close ?? [];
$_is_effects                    = $request->_is_effect ?? [];
$_remarkss                      = $request->_remarks ?? [];

  





    $collection_ledgers_groups  = [];
    $_transection_ref           = [];
   

    for ($i=0; $i <sizeof($stm_bill_master_details_ids) ; $i++) { 

        $_bill_detail_id        = $stm_bill_master_details_ids[$i] ?? 0;
        $_bill_collection_id    = $stm_bill_collections_ids[$i] ?? '';
        $_fee_amount            = $_fee_amounts[$i] ?? 0;
        $_receive_amount        = $_receive_amounts[$i] ?? 0;
        $_due_amount            = $_due_amounts[$i] ?? 0;
        $_discount_amount       = $_discount_amounts[$i] ?? 0;
        $_collection_amount     = $_collection_amounts[$i] ?? 0;
        $_due_balance           = $_due_balances[$i] ?? 0;
        $_net_fee_amount        = (($_fee_amounts[$i] ?? 0)+($_discount_amounts[$i] ?? 0));


        $_short_narr            = $_short_narrs[$i] ?? '';
        $_collection_ledger_id = $_collection_ledger_ids[$i] ?? 0;
        $_is_close              = $_is_closes[$i] ?? 0;
        $_is_effect             = $_is_effects[$i] ?? 0;
        $_remarks               = $_remarkss[$i] ?? 0;
        $_month_id              = $_month_ids[$i] ?? 0;
        $_year                  = $_years[$i] ?? 0;


        $_bill_master_id = _id_to_name($_bill_detail_id,'_no','stm_bill_master_details');


       // if($_collection_amount > 0){
           $StmBillCollectionDetail                         = StmCollectionMasterDetail::find($_bill_collection_id);
           if(empty( $StmBillCollectionDetail)){
            $StmBillCollectionDetail                        = new StmCollectionMasterDetail();
           }

           $StmBillCollectionDetail->_no                    = $purchase_id;
           $StmBillCollectionDetail->_date                  = $_date;
           $StmBillCollectionDetail->organization_id        = $organization_id;
           $StmBillCollectionDetail->_branch_id             = $_branch_id;
           $StmBillCollectionDetail->_cost_center_id        = $_cost_center_id;
           $StmBillCollectionDetail->_session_id            = $_session_id;
           $StmBillCollectionDetail->_class_id              = $_class_id;
           $StmBillCollectionDetail->_student_id            = $_student_table_id;
           $StmBillCollectionDetail->_bill_master_id        =$_bill_master_id;  // find out using details
           $StmBillCollectionDetail->_bill_detail_id        = $_bill_detail_id; 
           $StmBillCollectionDetail->_stm_division_id       = $_stm_division_id; 
           $StmBillCollectionDetail->_bill_type             = $_bill_type; 

           $_total = $_fee_amount;

           $StmBillCollectionDetail->_collection_ledger_id  = $_collection_ledger_id;
           $StmBillCollectionDetail->_fee_amount           = $_fee_amount;
           $StmBillCollectionDetail->_discount_amount      = $_discount_amount;
           $StmBillCollectionDetail->_net_fee_amount       = $_net_fee_amount;
           $StmBillCollectionDetail->_receive_amount       = $_receive_amount;
           $StmBillCollectionDetail->_due_amount          = $_due_amount;
           $StmBillCollectionDetail->_remarks             = $_remarks;
           $StmBillCollectionDetail->_month_id            = $_month_id;
           $StmBillCollectionDetail->_year                = $_year;
          
           //
           
           $StmBillCollectionDetail->_receive_amount      = $_receive_amount;
           $StmBillCollectionDetail->_due_amount          = $_due_amount;
           $StmBillCollectionDetail->_collection_amount   = $_collection_amount;
           $StmBillCollectionDetail->_due_balance         = $_due_balance;
           $StmBillCollectionDetail->_short_narr          = $_short_narr ?? '';

           $StmBillCollectionDetail->_status              = $_status ?? 1;
           $StmBillCollectionDetail->_is_close            = $_is_close ?? 1;
           $StmBillCollectionDetail->_is_effect            = $_is_effect ?? 1;
           $StmBillCollectionDetail->_created_by          = $_created_by ?? 1;
           $StmBillCollectionDetail->created_at           = date('d-m-Y H:i:s');
           $StmBillCollectionDetail->save();


           $master_detail_id        = $StmBillCollectionDetail->id;
           if($_collection_amount > 0  && $_is_effect==1){
            $collection_ledgers_groups[$_collection_ledger_id][]=$_collection_amount ?? 0;
           }
          
   // }

   // if($_is_confirm ==1){
     // Update Sales Invoice Number
       $StmBillMasterDetail                   = StmBillMasterDetail::find($_bill_detail_id);
       $old_receive_amount      = $StmBillMasterDetail->_receive_amount ?? 0;
       $old_due_amount          = $StmBillMasterDetail->_due_amount ?? 0;
       $new_receive_amount      = ($old_receive_amount + $_collection_amount);
       $new_due_amount          = ($_fee_amount -($new_receive_amount));
       $StmBillMasterDetail->_receive_amount  = $new_receive_amount;
       $StmBillMasterDetail->_due_amount      = $new_due_amount;
       $StmBillMasterDetail->_is_close        = $_is_close ?? 0;
       $StmBillMasterDetail->save();
 //   }

      

    }
       
//return $collection_ledgers_groups;

$array_of_dr_amount = 0;

if($_is_confirm ==1){

$_transection_ref_string = implode(',',$_transection_ref);
if(sizeof($collection_ledgers_groups) > 0){
    foreach($collection_ledgers_groups as $l_key=>$l_val){
       //Reporting Account Table Data Insert
        $_account_ledger     = $l_key;
        $_cr_amount          = array_sum($l_val);
        $array_of_dr_amount  += $_cr_amount;
        $_account_type_id       =  ledger_to_group_type($_account_ledger)->_account_head_id;
        $_account_group_id      =  ledger_to_group_type($_account_ledger)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = $_short_narr[$i] ?? 'N/A';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_collection_masters';
            $Accounts->_date                = change_date_format($request->_date);
            $Accounts->_table_name          = $request->_form_name;
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_account_ledger;
            $Accounts->_dr_amount           = $_cr_amount ?? 0;
            $Accounts->_cr_amount           =  0;
            $Accounts->_foreign_amount      = 0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                = $users->name;
            $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
            $Accounts->save();
            ledger_balance_update($_account_ledger);
    }
}


if($_grand_discount_amount > 0){
    

    //  if($_discount_ledger !='' && $_discount_ledger !=0){

        $___discount_amount                 = $_grand_discount_amount ?? 0;
        if($___discount_amount > 0){
            $_account_type_id_discount       =  ledger_to_group_type($_discount_ledger)->_account_head_id ?? 0;
            $_account_group_id_discount      =  ledger_to_group_type($_discount_ledger)->_account_group_id ?? 0;

            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id ?? 100;
            $Accounts->_ref_detail_id       = $master_detail_id ?? 100 ;
            $Accounts->_short_narration     = 'concession';
            $Accounts->_narration           = $_note ?? '';
            $Accounts->_reference           = $_transection_ref_string ?? '';
            $Accounts->_voucher_type        = 'CR';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_collection_masters';
            $Accounts->_date                = $_date;
            $Accounts->_table_name          = 'stm_collection_masters';
            $Accounts->_account_head        = $_account_type_id_discount;
            $Accounts->_account_group       = $_account_group_id_discount;
            $Accounts->_account_ledger      = $_discount_ledger;
            $Accounts->_dr_amount           = $___discount_amount ?? 0;
            $Accounts->_cr_amount           =  0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                = $auth_user->name;
            $Accounts->_month               = $_month_id ?? 0;
            $Accounts->_year                = $_year ?? 0;
            $Accounts->save();
            ledger_balance_update($_discount_ledger); // Bill Discount
        }

             
     //  }

}



//Supplier Journal Voucher Entry

if($array_of_dr_amount > 0){

     //Reporting Account Table Data Insert
        $_main_ledger_id            = $_student_ledger_id;
        $_account_type_id           =  ledger_to_group_type($_main_ledger_id)->_account_head_id;
        $_account_group_id          =  ledger_to_group_type($_main_ledger_id)->_account_group_id;
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = 'Collection';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_collection_masters';
            $Accounts->_date                = change_date_format($request->_date);
            $Accounts->_table_name          = $request->_form_name;
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_main_ledger_id;
            $Accounts->_dr_amount           =  0;
            $Accounts->_cr_amount           =  $array_of_dr_amount ?? 0;
            $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                =  $users->name;
            $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
            $Accounts->save();
            ledger_balance_update($_main_ledger_id);



             //Reporting Account Table Data Insert
        if($_grand_discount_amount > 0){
             $_main_ledger_id            = $_student_ledger_id;
             $_account_type_id           =  ledger_to_group_type($_main_ledger_id)->_account_head_id;
             $_account_group_id          =  ledger_to_group_type($_main_ledger_id)->_account_group_id;
                $Accounts                       = new Accounts();
                $Accounts->_ref_master_id       = $master_id;
                $Accounts->_ref_detail_id       = $master_detail_id;
                $Accounts->_short_narration     = 'Concession';
                $Accounts->_narration           = $request->_note ?? '';
                $Accounts->_reference           = $_transection_ref_string;
                $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
                $Accounts->_voucher_code        = $_code ?? '';
                $Accounts->_transaction         = 'stm_collection_masters';
                $Accounts->_date                = change_date_format($request->_date);
                $Accounts->_table_name          = $request->_form_name;
                $Accounts->_account_head        = $_account_type_id;
                $Accounts->_account_group       = $_account_group_id;
                $Accounts->_account_ledger      = $_main_ledger_id;
                $Accounts->_dr_amount           =  0;
                $Accounts->_cr_amount           =  $_grand_discount_amount ?? 0;
                $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;
                $Accounts->organization_id      = $organization_id;
                $Accounts->_branch_id           = $_branch_id;
                $Accounts->_cost_center         = $_cost_center_id ?? 0;
                $Accounts->_budget_id           = $_budget_id ?? 0;
                $Accounts->_name                =  $users->name;
                $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
                $Accounts->save();
                ledger_balance_update($_main_ledger_id);
        }
       

}








} // End of Is Confirm

             $print_url=url('stm/stm_collection')."/".$master_id;
             $success_message= "Information Save successfully. <a target='__blank' style='color:red;' href='".$print_url."'><i class='fas fa-print'></i></a>";

         DB::commit();
        
        return redirect()->back()
                    ->with('success',$success_message);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
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
 

    $data = StmCollectionMaster::with(['_detail','_cost_center','_branch','_ledger','_organization','_student','_edu_class','_edu_division','_edu_session'])->find($id);
    $page_name = __('label._admission_fee');




    return view('stm.stm_collection.show',compact('page_name','data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



         $page_name  = __('label.stm_collection_form');

          
          $StmBillMaster  = StmCollectionMaster::find($id);
           $income_ledgers = \DB::table('stm_income_ledger_setups')->first();

         

        $auth_user = Auth::user();
       
      
    $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));
        $voucher_types = \App\Models\VoucherType::whereIn('id',[3,6])->select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$auth_user->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$auth_user->organization_ids));

      $datas =[];
      $student_ids = '';

   $student_info = StmStudent::find($StmBillMaster->_student_table_id);






    $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
           $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
           $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();
      



    


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



     $data = StmCollectionMaster::with(['_detail','_cost_center','_branch','_ledger','_organization','_student','_edu_class','_edu_division','_edu_session'])->find($id);
 


return view('stm.stm_collection.edit',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','income_ledgers','collection_ledgers','student_ids','data','student_info'));

    
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
        
        $data  = StmCollectionMaster::find($id);
        $data->_status  = 0;
        $data->save();
        $stm_collection_order = $data->_order_number ?? '';



         $data = StmCollectionMaster::with(['_detail'])->find($id);

         $_details  = $data->_detail ?? [];

         foreach($_details as $key=>$detail){
            $_bill_detail_id        = $detail->_bill_detail_id ?? 0;
            $StmBillMasterDetail    = StmBillMasterDetail::find($_bill_detail_id);

            $old_receive_amount     = $StmBillMasterDetail->_receive_amount ?? 0;
            $old_due_amount         = $StmBillMasterDetail->_due_amount ?? 0;
            $old_is_close           = $StmBillMasterDetail->_is_close ?? 0;

$StmBillMasterDetail->_receive_amount = ($old_receive_amount-(($detail->_collection_amount)+$detail->_discount_amount));
           $StmBillMasterDetail->_due_amount  = ($old_due_amount-$detail->_due_amount ?? 0);
           $StmBillMasterDetail->_is_close    = 0;
           $StmBillMasterDetail->save();



         }




          Accounts::where('_transaction','stm_collection_masters')
                       ->where('_voucher_code',$stm_collection_order)
                       ->update(['_status'=>0]);

              $success_message ="Information Deleted successfully.";

        return redirect()->route('stm_collection.index')
                    ->with('danger',$success_message);
    }

   public function admission_fee_collection_list(Request $request){

         $limit = $request->limit ?? 10;

         $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';



            $page_name  = __('label.admission_fee_collection_list');
            $limit  = $request->limit ?? default_pagination();

            $datas = StmCollectionMaster::where('_bill_type','_admission_fee','_student')
            ->where('_status',1);

            if($request->has('_admission_session_id') && $request->_admission_session_id !=''){
                $datas = $datas->where('_session_id',$request->_admission_session_id);
            }

            if($request->has('_education_type') && $request->_education_type !=''){
                $datas = $datas->where('_stm_division_id',$request->_education_type);
            }

            if($request->has('_admission_class_id') && $request->_admission_class_id !=''){
                $datas = $datas->where('_class_id',$request->_admission_class_id);
            }

            if($request->has('_student_id') && $request->_student_id !=''){
                $datas = $datas->where('_student_table_id',$request->_student_id);
            }

           



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

            if($request->has('_month_id') && $request->_month_id !=''){
                $datas = $datas->where('_month_id',$request->_month_id);
            }
            if($request->has('_year') && $request->_year !=''){
                $datas = $datas->where('_year',$request->_year);
            }
            if($request->has('_order_number') && $request->_order_number !=''){
                $datas = $datas->where('_order_number',$request->_order_number);
            }

             // Filter by student name
                if ($request->has('_student_id') && $request->_student_id != '') {
                    $studentName = $request->_student_id;

                    $datas = $datas->whereHas('_student', function ($query) use ($studentName) {
                        $query->where('id', '=', $studentName );
                    });
                }




            

$datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

           

        $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
        $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
        $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();

           




        return view('stm.stm_bill_masters.admission_fee_collection_list',compact('page_name','datas','edu_class','edu_types','stm_education_sessions','limit','request'));
    }


    /* Admission Fee Collection and Admission Fee Generate */


    public function admissionFeeCollectionForm(Request $request){

           $page_name  = __('label.admissionFeeCollectionForm');

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

        if($request->has('search')){

            $request->validate([
                '_student_id' => 'required',
        ]);

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




        return view('stm.stm_bill_masters.admission_fee_collection_form',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','income_ledgers','request','datas','collection_ledgers','student_ids'));

    }


    /* Admission Fee Collection Receive and Save Form*/

    public function admission_fee_collection_store(Request $request){

 

     $stm_income_ledger_setups  = \DB::table('stm_income_ledger_setups')->first();
     $_discount_ledger  = $stm_income_ledger_setups->_discount_ledger ?? 0;

        $auth_user = Auth::user();

        $_date              = change_date_format($request->_date ?? date('Y-m-d'));
        $organization_id    = $request->organization_id ?? 1;
        $_branch_id         = $request->_branch_id ?? 1;
        $_cost_center_id    = $request->_cost_center_id ?? 1;
        $_bill_type         = $request->_bill_type ?? '';
        $_month_id          = $request->_month ?? date("m", strtotime($_date));
         $_year             = $request->_year ??date("Y", strtotime($_date));
         $_total_amount     = $request->_grand_total ?? 0;
         $_discount_amount  = array_sum($request->_discount_amount ?? []);
         $_net_amount       = $request->_grand_total ?? 0;
         $_note             = $request->_note ?? '';
         $_roshid_book_no             = $request->_roshid_book_no ?? '';
         $_roshid_no             = $request->_roshid_no ?? '';
         $_student_table_id      = $request->_student_table_id ?? '';
         $_master__session_id    = $request->_master__session_id ?? '';




         $_user_id          = $auth_user->id;
         $_user_name        = $auth_user->name ?? '';
         $_created_by       = $auth_user->_created_by ?? '';
         $_updated_by       = $auth_user->_updated_by ?? '';
         $_status           = $request->_status ?? 1;
         $_lock             = $request->_lock ?? 0;
         $_stm_division_id             = $request->_stm_division_id ?? 0;
          $_dr_ledger_id             = $request->_dr_ledger_id ?? 0;
         $_class_id             = $request->_class_id ?? 0;

         $stm_bill_masters_id = $request->stm_bill_masters_id ?? '';
         $_transection_ref_string = $request->_transection_ref ?? '';

       


        $StmBillMaster  = StmBillMaster::find($stm_bill_masters_id);
        if(empty($StmBillMaster)){
            $StmBillMaster          = new StmBillMaster();
            $__table="stm_bill_masters";
            $_order_number = make_order_number($__table,$organization_id,$_branch_id,$_date);
            $StmBillMaster->_created_by        = $_created_by;

        }else{
            $StmBillMaster->_updated_by        = $_updated_by;

            $_order_number                      = $request->_order_number ?? '';
        }

        $StmBillMaster->_date   = $_date;
        $StmBillMaster->organization_id   = $organization_id;
        $StmBillMaster->_branch_id   = $_branch_id;
        $StmBillMaster->_cost_center_id   = $_cost_center_id;
        $StmBillMaster->_order_number     = $_order_number;
        $StmBillMaster->_bill_type       = $_bill_type;
        $StmBillMaster->_month_id        = $_month_id;
        $StmBillMaster->_year            = $_year;
        $StmBillMaster->_stm_division_id = $_stm_division_id;
        $StmBillMaster->_class_id        = $_class_id;
        $StmBillMaster->_dr_ledger_id        = $_dr_ledger_id;
        $StmBillMaster->_total_amount        = $_total_amount;
        $StmBillMaster->_discount_amount        = $_discount_amount;
        $StmBillMaster->_net_amount        = $_net_amount;
        $StmBillMaster->_note        = $_note;
        $StmBillMaster->_user_id        = $_user_id;
        $StmBillMaster->_user_name        = $_user_name;
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
            $Accounts->_short_narration     = 'Admission Fee Bill';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_bill_masters';
            $Accounts->_date                = $_date;
            $Accounts->_table_name          = $request->_form_name ?? 'stm_bill_masters';
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_dr_ledger_id; // Income Ledger Accounts
            $Accounts->_dr_amount           =  0;
            $Accounts->_cr_amount           = $_net_amount ?? 0;
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



        /* Start Bill Collection Section Start*/

        $stm_collection_masters_id = $request->stm_collection_masters_id ?? 0;


        $StmCollectionMaster   = StmCollectionMaster::find($stm_collection_masters_id);
        if(empty($StmCollectionMaster)){
             $__table="stm_collection_masters";
            $collection_order_number = make_order_number($__table,$organization_id,$_branch_id,$_date);


            $StmCollectionMaster                = new StmCollectionMaster();
            $StmCollectionMaster->_created_by   = $auth_user->name ?? '';
            $StmCollectionMaster->_order_number   = $collection_order_number;
        }else{
             $StmCollectionMaster->_updated_by  = $auth_user->name ?? '';
        }
        $StmCollectionMaster->_date             = $_date;
        $StmCollectionMaster->_roshid_book_no   = $_roshid_book_no ?? '';
        $StmCollectionMaster->_roshid_no        = $_roshid_no ?? '';
        $StmCollectionMaster->organization_id   = $organization_id;
        $StmCollectionMaster->_branch_id        = $_branch_id;
        $StmCollectionMaster->_cost_center_id   = $_cost_center_id;
        $StmCollectionMaster->_bill_type        = $_bill_type;
        $StmCollectionMaster->_month_id         = $_month_id;
        $StmCollectionMaster->_year             = $_year;
        $StmCollectionMaster->_class_id         = $_class_id;
        $StmCollectionMaster->_session_id         = $_master__session_id ?? 0;
        $StmCollectionMaster->_stm_division_id         = $_stm_division_id ?? 0;
        $StmCollectionMaster->_student_table_id   = $_student_table_id ?? 0;
        $StmCollectionMaster->_dr_ledger_id     = $_dr_ledger_id;
        $StmCollectionMaster->_total_amount     = $_total_amount;
        $StmCollectionMaster->_discount_amount  = $_discount_amount;
        $StmCollectionMaster->_net_amount       = $_net_amount;
        $StmCollectionMaster->_note             = $_note;
        $StmCollectionMaster->stm_bill_masters_id = $stm_bill_masters_id;
        $StmCollectionMaster->_user_id          = $auth_user->id;
        $StmCollectionMaster->_user_name        = $auth_user->name;
        $StmCollectionMaster->_status           = 1;
        $StmCollectionMaster->_lock             = $request->_lock ?? 0;
        $StmCollectionMaster->save();


        $stm_master_id                  = $StmCollectionMaster->id;
        $collection_order_number        = $StmCollectionMaster->_order_number;
        


        StmCollectionMasterDetail::where('_no',$stm_master_id)->update(['_status'=>0]); 






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
            $_is_effect             = $_is_effects[$key] ?? 1;
            $stm_bill_master_details_id  = $stm_bill_master_details_ids[$key] ?? 0;
            $stm_bill_collections_id     = $stm_bill_collections_ids[$key] ?? 0;
            $_session_id     = $_session_ids[$key] ?? 0;
            $_remarks     = $_remarkss[$key] ?? '';



            $StmBillMasterDetail   = StmBillMasterDetail::find($stm_bill_master_details_id);
            if(empty($StmBillMasterDetail)){
                $StmBillMasterDetail                    = new StmBillMasterDetail();
                $StmBillMasterDetail->_created_by       =$auth_user->name ?? '';

            }else{
                $StmBillMasterDetail->_updated_by      = $auth_user->name ?? '';
            }

            $StmBillMasterDetail->organization_id   = $organization_id;
            $StmBillMasterDetail->_branch_id        = $_branch_id;
            $StmBillMasterDetail->_cost_center_id   = $_cost_center_id;
            $StmBillMasterDetail->_no     = $stm_bill_masters_id;
            $StmBillMasterDetail->_student_id        = $_student_id;
            $StmBillMasterDetail->_month_id         = $_month_id;
            $StmBillMasterDetail->_year            = $_year;
            $StmBillMasterDetail->_stm_division_id         = $_stm_division_id;
            $StmBillMasterDetail->_class_id         = $_class_id;
            $StmBillMasterDetail->_bill_type         = $_bill_type;
            $StmBillMasterDetail->_fee_amount         = $_admission_fees[$key] ?? 0;
            $StmBillMasterDetail->_discount_amount         = $_discount_amounts[$key] ?? 0;
            $StmBillMasterDetail->_net_fee_amount         = $_net_fee_amounts[$key] ?? 0;
            $StmBillMasterDetail->_receive_amount         = $_collection_amounts[$key] ?? 0;
            $StmBillMasterDetail->_due_amount         = $_due_balances[$key] ?? 0;
            $StmBillMasterDetail->_is_close         = $_is_closes[$key] ?? 0;
            $StmBillMasterDetail->_status         = $_statuss[$key] ?? 1;
            $StmBillMasterDetail->save();

            $master_detail_id  = $StmBillMasterDetail->id;


            // Data Send to Account Table For Reports

            // Find Studen id to student Ledger Id

            

            $_student_ledger_id      = id_to_cloumn($_student_id,'_ledger_id','stm_students');
            $_account_type_id        =  ledger_to_group_type($_student_ledger_id)->_account_head_id;
           $_account_group_id        =  ledger_to_group_type($_student_ledger_id)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $stm_bill_masters_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = 'Admission Fee Bill';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string ?? '';
            $Accounts->_voucher_type        = 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'stm_bill_masters';
            $Accounts->_date                = $_date;
            $Accounts->_table_name          = 'stm_bill_masters';
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_student_ledger_id;  // Student Ledger Accounts
            $Accounts->_dr_amount           = (($_collection_amounts[$key] ?? 0)+($_discount_amounts[$key] ?? 0));
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





        $StmCollectionMasterDetail   = StmCollectionMasterDetail::find($stm_bill_collections_id);
       if(empty($StmCollectionMasterDetail)){
            $StmCollectionMasterDetail   = new StmCollectionMasterDetail();
            $StmCollectionMasterDetail->_created_by   = $auth_user->name ?? '';
       }else{
            $StmCollectionMasterDetail->_updated_by   = $auth_user->name ?? '';
       }
       $StmCollectionMasterDetail->_date                = $_date;
       $StmCollectionMasterDetail->_no                  = $stm_master_id;
       $StmCollectionMasterDetail->organization_id      = $organization_id;
       $StmCollectionMasterDetail->_branch_id      = $_branch_id;
       $StmCollectionMasterDetail->_cost_center_id      = $_cost_center_id;
       $StmCollectionMasterDetail->_stm_division_id     = $_stm_division_id;
       $StmCollectionMasterDetail->_class_id            = $_class_id;
       $StmCollectionMasterDetail->_session_id          = $_session_id;
       $StmCollectionMasterDetail->_bill_type           = $_bill_type;
       $StmCollectionMasterDetail->_student_id          = $_student_id;
       $StmCollectionMasterDetail->_bill_master_id      = $stm_bill_masters_id;
       $StmCollectionMasterDetail->_bill_detail_id      = $master_detail_id;
       $StmCollectionMasterDetail->_collection_ledger_id= $_collection_ledger_id;

        $StmCollectionMasterDetail->_bill_type         = $_bill_type;
        $StmCollectionMasterDetail->_fee_amount        = $_admission_fees[$key] ?? 0;
        $StmCollectionMasterDetail->_discount_amount   = $_discount_amounts[$key] ?? 0;
        $StmCollectionMasterDetail->_net_fee_amount    = $_net_fee_amounts[$key] ?? 0;
       // $StmCollectionMasterDetail->_receive_amount    = $_collection_amounts[$key] ?? 0;
        $StmCollectionMasterDetail->_collection_amount    = $_collection_amounts[$key] ?? 0;
        $StmCollectionMasterDetail->_due_amount        = $_due_balances[$key] ?? 0;
           

       $StmCollectionMasterDetail->_remarks             = $_remarks;
       $StmCollectionMasterDetail->_status              = $_status ?? 1;
       $StmCollectionMasterDetail->_is_close            = $_is_close ?? 1;
       $StmCollectionMasterDetail->_is_effect            = $_is_effect ?? 1;
       $StmCollectionMasterDetail->save();

       $collection_detail_id   = $StmCollectionMasterDetail->id;




       /* Bill Collection Details Account Record*/
 Accounts::where('_transaction','stm_collection_masters')
                    ->where('_ref_master_id',$stm_master_id)
                    ->update(['_status'=>0]);

       /* Voucher for Cash or Bank Account */
    //$_student_ledger_id = id_to_cloumn($_student_id,'_ledger_id','stm_students');
    $_account_type_id_collection       =  ledger_to_group_type($_collection_ledger_id)->_account_head_id ?? 0;
    $_account_group_id_collection      =  ledger_to_group_type($_collection_ledger_id)->_account_group_id ?? 0;

    $Accounts                       = new Accounts();
    $Accounts->_ref_master_id       = $stm_master_id ?? 100;
    $Accounts->_ref_detail_id       = $collection_detail_id ?? 100 ;
    $Accounts->_short_narration     = 'Admission Fee collection';
    $Accounts->_narration           = $_note ?? '';
    $Accounts->_reference           = $_transection_ref_string ?? '';
    $Accounts->_voucher_type        = 'CR';
    $Accounts->_voucher_code        = $collection_order_number ?? '';
    $Accounts->_transaction         = 'stm_collection_masters';
    $Accounts->_date                = $_date;
    $Accounts->_table_name          = 'stm_collection_masters';
    $Accounts->_account_head        = $_account_type_id_collection;
    $Accounts->_account_group       = $_account_group_id_collection;
    $Accounts->_account_ledger      = $_collection_ledger_id; // Cash or Bank Account Ledger
    $Accounts->_dr_amount           = $_collection_amounts[$key] ?? 0;
    $Accounts->_cr_amount           =  0;
    $Accounts->organization_id      = $organization_id;
    $Accounts->_branch_id           = $_branch_id;
    $Accounts->_cost_center         = $_cost_center_id ?? 0;
    $Accounts->_budget_id           = $_budget_id ?? 0;
    $Accounts->_name                = $auth_user->name;
    $Accounts->_month               = $_month_id ?? 0;
    $Accounts->_year                = $_year ?? 0;
    $Accounts->save();
    ledger_balance_update($_collection_ledger_id); // Bill collection ledger on cash or baksh

       /* Voucher for Cash or Bank Account */
    //$_student_ledger_id = id_to_cloumn($_student_id,'_ledger_id','stm_students');
       if($_discount_ledger !='' && $_discount_ledger !=0){

        $___discount_amount = $_discount_amounts[$key] ?? 0;
        if($___discount_amount > 0){
            $_account_type_id_discount       =  ledger_to_group_type($_discount_ledger)->_account_head_id ?? 0;
            $_account_group_id_discount      =  ledger_to_group_type($_discount_ledger)->_account_group_id ?? 0;

            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $stm_master_id ?? 100;
            $Accounts->_ref_detail_id       = $collection_detail_id ?? 100 ;
            $Accounts->_short_narration     = $_note ?? 'N/A';
            $Accounts->_narration           = $_note ?? '';
            $Accounts->_reference           = $_transection_ref_string ?? '';
            $Accounts->_voucher_type        = 'CR';
            $Accounts->_voucher_code        = $collection_order_number ?? '';
            $Accounts->_transaction         = 'stm_collection_masters';
            $Accounts->_date                = $_date;
            $Accounts->_table_name          = 'stm_collection_masters';
            $Accounts->_account_head        = $_account_type_id_discount;
            $Accounts->_account_group       = $_account_group_id_discount;
            $Accounts->_account_ledger      = $_discount_ledger;
            $Accounts->_dr_amount           = $_discount_amounts[$key] ?? 0;
            $Accounts->_cr_amount           =  0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                = $auth_user->name;
            $Accounts->_month               = $_month_id ?? 0;
            $Accounts->_year                = $_year ?? 0;
            $Accounts->save();
            ledger_balance_update($_discount_ledger); // Bill Discount
        }

             
       }
   




       /* Voucher for Cash or Bank Account */
    $_student_ledger_id                 = id_to_cloumn($_student_id,'_ledger_id','stm_students');
    $_account_type_id_collection       =  ledger_to_group_type($_student_ledger_id)->_account_head_id ?? 0;
    $_account_group_id_collection      =  ledger_to_group_type($_student_ledger_id)->_account_group_id ?? 0;

    $Accounts                       = new Accounts();
    $Accounts->_ref_master_id       = $stm_master_id ?? 200;
    $Accounts->_ref_detail_id       = $collection_detail_id ?? 200;
    $Accounts->_short_narration     = $_note ?? 'N/A';
    $Accounts->_narration           = $_note ?? '';
    $Accounts->_reference           = $_transection_ref_string ?? '';
    $Accounts->_voucher_type        = 'CR';
    $Accounts->_voucher_code        = $collection_order_number ?? '';
    $Accounts->_transaction         = 'stm_collection_masters';
    $Accounts->_date                = $_date;
    $Accounts->_table_name          = 'stm_collection_masters';
    $Accounts->_account_head        = $_account_type_id_collection;
    $Accounts->_account_group       = $_account_group_id_collection;
    $Accounts->_account_ledger      = $_student_ledger_id; // Student Ledger Accounts
    $Accounts->_dr_amount           =  0;
    $Accounts->_cr_amount           = (($_collection_amounts[$key] ?? 0 )+($_discount_amounts[$key] ?? 0 ));
    $Accounts->organization_id      = $organization_id;
    $Accounts->_branch_id           = $_branch_id;
    $Accounts->_cost_center         = $_cost_center_id ?? 0;
    $Accounts->_budget_id           = $_budget_id ?? 0;
    $Accounts->_name                = $auth_user->name;
    $Accounts->_month               = $_month_id ?? 0;
    $Accounts->_year                = $_year ?? 0;
    $Accounts->save();
    ledger_balance_update($_collection_ledger_id); // Bill Generate  Complete 




        } /*End of Generation section */


        


      
            $success_message ="Information Save successfully.";
        return redirect()->route('admission_fee_collection_list')
                    ->with('success',$success_message);



        /* Start Bill Collection Section End*/




    }

/* Admission Collection Show*/


public function admission_fee_collection_show(Request $request){
  $id  = $request->id;

    $data = StmCollectionMaster::with(['_detail','_cost_center','_branch','_ledger','_organization','_student','_edu_class','_edu_division','_edu_session'])->find($id);
    $page_name = __('label._admission_fee');




    return view('stm.stm_bill_masters.admission_slip',compact('page_name','data'));
}




/* Admission Fee Collection and Admission Fee Generate */


    public function admission_fee_collection_edit(Request $request){

           $page_name  = __('label.admissionFeeCollectionForm');

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

      
$id  = $request->id;

    $data = StmCollectionMaster::with(['_detail','_cost_center','_branch','_ledger','_organization','_student','_edu_class','_edu_division','_edu_session'])->find($id);
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




        return view('stm.stm_bill_masters.admission_fee_collection_edit',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','income_ledgers','request','data','collection_ledgers','student_ids'));

    }



public function admission_fee_collection_delete(Request $request){
    $id = $request->id ?? '';

    $data  = StmCollectionMaster::find($id);
    $data->_status  = 0;
    $data->save();


   $stm_bill_masters_id  = $data->stm_bill_masters_id ?? 0;
   $stm_collection_order = $data->_order_number ?? '';

   $StmBillMaster           = StmBillMaster::find($stm_bill_masters_id);
   $bill_voucher_code  = $StmBillMaster->_order_number ?? '';
   $StmBillMaster->_status   = 0;
   $StmBillMaster->save();

  Accounts::where('_transaction','stm_bill_masters')->where('_voucher_code',$bill_voucher_code)->update(['_status'=>0]);
  Accounts::where('_transaction','stm_collection_masters')->where('_voucher_code',$stm_collection_order)->update(['_status'=>0]);

              $success_message ="Information Save successfully.";
        return redirect()->route('admission_fee_collection_list')
                    ->with('success',$success_message);


}



}
