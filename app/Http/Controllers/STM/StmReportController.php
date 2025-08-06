<?php

namespace App\Http\Controllers\STM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountGroup;
use App\Models\Accounts;
use App\Models\AccountLedger;
use App\Models\MainAccountHead;
use App\Models\VoucherType;
use App\Models\Sales;
use App\Models\ResturantSales;
use App\Models\ResturantFormSetting;
use App\Models\SalesFormSetting;
use App\Models\GeneralSettings;
use App\Models\AccountHead;
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

use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class StmReportController extends Controller
{
    //
    function __construct()
    {
         
        
         $this->middleware('permission:division_class_student_report', ['only' => ['division_class_student_report']]);
         $this->middleware('permission:division_class_collection_report', ['only' => ['division_class_collection_report']]);
         $this->middleware('permission:division_class_collection_status_report', ['only' => ['division_class_collection_status_report']]);
         $this->middleware('permission:student_ledger_report', ['only' => ['student_ledger_report']]);
         $this->middleware('permission:month_wise_payment_status_report', ['only' => ['month_wise_payment_status_report']]);








    }


    public function division_class_student_report(Request $request){

         $page_name  = __('label.division_class_wise_student_list');

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


        return view('stm.report.division_class_student_report',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','request'));


    }

/*Divsion and class wise Student List 
    it will be ajax call
*/

public function division_class_wise_student_list(Request $request){
        $page_name  = __('label.division_class_wise_student_list');
        $auth_user = Auth::user();
         $datas =[];
         $datas = StmDivisionClassStudent::where('_status',1);
         
         if($request->has('_admission_session_id') && $request->_admission_session_id){
            $datas = $datas->where('_session',$request->_admission_session_id);
         }
         if($request->has('_education_type') && $request->_education_type){
            $datas = $datas->where('_division_id',$request->_education_type);
         }
         if($request->has('_admission_class_id') && $request->_admission_class_id){
            $datas = $datas->where('_class_id',$request->_admission_class_id);
         }
         
         $datas = $datas->select(
                '_session',
                '_division_id',
                '_class_id',
                DB::raw('count(*) as _number_of_student')
            )->groupBy('_session', '_division_id', '_class_id')
            ->orderBy('_session')
            ->orderBy('_division_id')
            ->orderBy('_class_id')
            ->get();


        return view('stm.report.division_class_wise_student_list',compact('datas','page_name'));
}




    public function division_class_collection_report(Request $request){

            $page_name  = __('label.division_class_collection_report');

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


        return view('stm.report.division_class_collection_report',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','request'));

        
    }

    /*Divsion and class wise Student List 
    it will be ajax call
*/

public function division_class_collection_list(Request $request){
        $page_name  = __('label.division_class_collection_report');
        $auth_user = Auth::user();

        $_datex   = change_date_format($request->_datex ?? date('Y-m-d'));
        $_datey   = change_date_format($request->_datey ?? date('Y-m-d'));
        $_bill_type = $request->_bill_type ?? '';
         $datas =[];
         $datas = StmCollectionMasterDetail::with(['_student'])
         ->where('_status', 1)
         ->where('_is_effect', 1)
         ->whereBetween('_date', [$_datex, $_datey]);

    

         
         if($request->has('_admission_session_id') && $request->_admission_session_id){
            $datas = $datas->where('_session_id',$request->_admission_session_id);
         }
         if($request->has('_education_type') && $request->_education_type){
            $datas = $datas->where('_stm_division_id',$request->_education_type);
         }
         if($request->has('_admission_class_id') && $request->_admission_class_id){
            $datas = $datas->where('_class_id',$request->_admission_class_id);
         }
         if($request->has('_bill_type') && $request->_bill_type){
            $datas = $datas->where('_bill_type',$request->_bill_type);
         }
         
            $datas = $datas->orderBy('_date', 'asc')
            ->orderBy('_session_id')
            ->orderBy('_stm_division_id')
            ->orderBy('_class_id')
            ->get();
   // return $datas;

        return view('stm.report.division_class_collection_list',compact('datas','page_name','request'));
}



    public function division_class_collection_status_report(Request $request){
$page_name  = __('label.division_class_collection_status_report');

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


        return view('stm.report.division_class_collection_status_report',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','request'));


        
    }


    public function division_class_collection_status_list(Request $request){
$page_name  = __('label.division_class_collection_status_report');
        $auth_user = Auth::user();

        $_datex   = change_date_format($request->_datex ?? date('Y-m-d'));
        $_datey   = change_date_format($request->_datey ?? date('Y-m-d'));
        $_bill_type = $request->_bill_type ?? '';
         $datas =[];

$slq = " SELECT t3._name_in_bangla,t3._name_in_english,t3._father_name_bangla,t3._admission_session_id,t3._admission_class_id,
t3._education_type,s1._student_id, SUM(s1._fee_amount) as _fee_amount,SUM(s1._discount_amount) as _discount_amount,
SUM(s1._receive_amount) as _receive_amount,t3._admission_session_id,t3._education_type,t3._admission_class_id ,t3._roll_no , t4._name as  _division_name,
t5._name as _class_name,t6._name as _session__name



FROM(

SELECT t1._student_id, t1._fee_amount, 0 as _discount_amount, 0 as _receive_amount
FROM stm_bill_master_details as t1
INNER JOIN stm_bill_masters as l1 ON l1.id=t1._no

WHERE t1._status=1 AND  l1._date  >= '".$_datex."'  AND l1._date <= '".$_datey."' 
UNION ALL
SELECT t2._student_id,0 as _fee_amount,t2._discount_amount,t2._collection_amount as _receive_amount
FROM stm_collection_master_details as t2 WHERE t2._status=1 AND  t2._date  >= '".$_datex."'  AND t2._date <= '".$_datey."' 

    ) as s1
    INNER JOIN stm_students as t3 ON t3.id=s1._student_id
    INNER JOIN stm_divisions as t4 ON t4.id=t3._education_type
    INNER JOIN stm_classes as t5 ON t5.id=t3._admission_class_id
    INNER JOIN stm_education_sessions as t6 ON t6.id=t3._admission_session_id

      WHERE 1=1 ";

  if($request->has('_admission_session_id') && $request->_admission_session_id){
       $slq .= " AND  t3._admission_session_id =".$request->_admission_session_id." ";
    }

  if($request->has('_education_type') && $request->_education_type){
       $slq .= " AND  t3._education_type =".$request->_education_type." ";
    }
  if($request->has('_admission_class_id') && $request->_admission_class_id){
       $slq .= " AND  t3._admission_class_id =".$request->_admission_class_id." ";
    }

$slq .=" GROUP BY s1._student_id ORDER BY t3._admission_session_id,
t3._education_type,t3._admission_class_id,CAST(t3._roll_no AS UNSIGNED),t3._name_in_english ASC ";

          $datas = \DB::select($slq);

        return view('stm.report.division_class_collection_status_list',compact('datas','page_name','request'));



    }

    public function student_ledger_report(Request $request){

            $page_name  = __('label.student_ledger_report');

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


        return view('stm.report.student_ledger_report',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','request'));

        
    }



    public function student_ledger_report_data(Request $request){
$page_name  = __('label.division_class_collection_status_report');
        $auth_user = Auth::user();

        $_datex   = change_date_format($request->_datex ?? date('Y-m-d'));
        $_datey   = change_date_format($request->_datey ?? date('Y-m-d'));
        $_bill_type = $request->_bill_type ?? '';
         $datas =[];

         //return $request->all();

$slq = " SELECT t3._name_in_bangla,t3._name_in_english,t3._father_name_bangla,t3._admission_session_id,t3._admission_class_id,
t3._education_type,s1._student_id, (s1._fee_amount) as _fee_amount,(s1._discount_amount) as _discount_amount,
(s1._receive_amount) as _receive_amount,t3._admission_session_id,t3._education_type,t3._admission_class_id ,t3._roll_no ,s1._order_number,s1._date,s1._bill_type,s1._type



FROM(

SELECT t1._student_id,t1._bill_type, t1._fee_amount, 0 as _discount_amount, 0 as _receive_amount,l1._order_number,l1._date,'Bill' as _type
FROM stm_bill_master_details as t1
INNER JOIN stm_bill_masters as l1 ON l1.id=t1._no

WHERE t1._status=1 ";
if($request->has('_student_id') && $request->_student_id){
       $slq .= " AND  t1._student_id =".$request->_student_id." ";
    }

$slq .= " UNION ALL
SELECT t2._student_id,t2._bill_type,0 as _fee_amount,t2._discount_amount,t2._collection_amount as _receive_amount,l1._order_number,l1._date,'payment' as _type
FROM stm_collection_master_details as t2 
INNER JOIN stm_collection_masters as l1 ON l1.id=t2._no
WHERE t2._status=1 AND (t2._discount_amount > 0 OR t2._collection_amount > 0)";

if($request->has('_student_id') && $request->_student_id){
       $slq .= " AND  t2._student_id =".$request->_student_id." ";
}

$slq .= " ) as s1
    INNER JOIN stm_students as t3 ON t3.id=s1._student_id

      WHERE 1=1 ";
$slq .="  ORDER BY s1._date ASC ";

          $datas = \DB::select($slq);

        return view('stm.report.student_ledger_report_data',compact('datas','page_name','request'));



    }
    
    public function month_wise_payment_status_report(Request $request){



            $page_name  = __('label.month_wise_payment_status_report');

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


        return view('stm.report.month_wise_payment_status_report',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','request'));

        
    

        
    }


    public function month_wise_payment_status_data(Request $request){

        $page_name  = __('label.month_wise_payment_status_report');
        $auth_user = Auth::user();

       $query = "
        SELECT 
            t1._date, t1._session_id, t1._student_id, t1._month_id, t1._year, t1._collection_amount,
            s._name_in_bangla, s._name_in_english, s._roll_no,
            d._name AS division_name,
            c._name AS class_name
        FROM stm_collection_master_details AS t1
        LEFT JOIN stm_students AS s ON s.id = t1._student_id
        LEFT JOIN stm_divisions AS d ON d.id = t1._stm_division_id
        LEFT JOIN stm_classes AS c ON c.id = t1._class_id
        WHERE t1._status = 1
    ";

    // Apply filters
 if (isset($request->_admission_session_id) && !empty($request->_admission_session_id)) {
    $query .= " AND t1._session_id = " . intval($request->_admission_session_id);
}

if (isset($request->_education_type) && !empty($request->_education_type)) {
    $query .= " AND t1._stm_division_id = " . intval($request->_education_type);
}

if (isset($request->_admission_class_id) && !empty($request->_admission_class_id)) {
    $query .= " AND t1._class_id = " . intval($request->_admission_class_id);
}

if (isset($request->_year) && !empty($request->_year)) {
    $query .= " AND t1._year = " . intval($request->_year);
}

if (isset($request->_student_id) && !empty($request->_student_id)) {
    $query .= " AND t1._student_id = " . intval($request->_student_id);
}

    $collections = \DB::select($query);

    // Group by student
    $grouped = collect($collections)->groupBy('_student_id');
    $reportData = [];

    foreach ($grouped as $student_id => $entries) {
        $student = $entries->first();
        $row = [
            'division' => $student->division_name ?? '',
            'class' => $student->class_name ?? '',
            'name' => $student->_name_in_bangla ?? '',
            '_name_in_english' =>  $student->_name_in_english ?? '',
            'roll' => $student->_roll_no ?? '',
            'monthly' => array_fill(1, 12, 0),
            'total' => 0
        ];

        foreach ($entries as $entry) {
            $month = (int)$entry->_month_id;
            $amount = (float)$entry->_collection_amount;
            $row['monthly'][$month] += $amount;
            $row['total'] += $amount;
        }

        $reportData[] = $row;
    }

    //return $reportData;

    return view('stm.report.month_wise_payment_status_list',compact('reportData','page_name','request'));


    }






public function monthly_class_wise_fee_collection_ledger(Request $request){

         $page_name  = __('label.monthly_class_wise_fee_collection_ledger');
           $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
           $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
           $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();
          $auth_user = Auth::user();
       
      
        $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));
        $voucher_types = \App\Models\VoucherType::whereIn('id',[3,6])->select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$auth_user->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$auth_user->organization_ids));


        return view('stm.report.monthly_class_wise_fee_collection_ledger',compact('page_name','edu_class','edu_types','stm_education_sessions','voucher_types','permited_branch','permited_costcenters','permited_budgets','permited_organizations','request'));


    }

    public function monthlyCollectionReport(Request $request)
{
    // Inputs: month, year, optional class_id, student_id, division etc.
    $month = $request->_month ?? null;
    $year = $request->_year ?? null;
    $classId = $request->_admission_class_id ?? null;
    $divisionId = $request->_education_type ?? null;
  //  $studentId = $request->_student_id ?? null;

//return $request->all();

$page_name  = __('label.monthly_class_wise_fee_collection_ledger');

$datas = DB::table('stm_students as s')
        ->join('stm_divisions as d', 's._education_type', '=', 'd.id')
        ->join('stm_classes as c', 's._current_class_id', '=', 'c.id')
        ->join('stm_collection_master_details as b','s.id','=','b._student_id')
        ->join('stm_collection_masters as cm','cm.id','=','b._no')
        ->select(
            's._student_id',
            's._roll_no',
            's._name_in_bangla',
            's._name_in_english',
            's._father_name_english',
            's._father_name_bangla',
            'b._bill_type',
            'b._fee_amount',
            'b._collection_amount',
            'b._discount_amount',
            'cm._date',
            'cm._roshid_no',
            'cm._roshid_book_no',
            'cm._note',
            'cm._order_number',
            
        )
        ->where(function($q) {
            $q->where('b._collection_amount', '>', 0)
            ->orWhere('b._discount_amount', '>', 0);
        })->where('b._status', 1)->where('b._month_id',$month)
        ->where('b._year',$year)
        ->where('b._stm_division_id',$divisionId)
        ->where('b._class_id',$classId)
        ->where('s._status', 1)
        ->where('s._admission_class_id', $request->_admission_class_id)
        ->where('s._education_type', $request->_education_type)
        ->orderBy('s._roll_no')
        ->get();


    //return $datas;

    return view('stm.report.monthly_collection_report', compact('datas', 'page_name', 'request'));
}




}
