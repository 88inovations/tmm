<?php

namespace App\Http\Controllers;
use App\Models\HRM\HrmMonthlySalaryDetail;
use App\Models\HRM\HrmPayheads;
use App\Models\HRM\HrmMonthlySalaryMaster;
use App\Models\HRM\HrmEmpCategory;
use App\Models\HRM\HrmDepartment;
use App\Models\HRM\Designation;
use App\Models\HRM\HrmGrade;
use App\Models\HRM\HrmEmpLocation;
use App\Models\HRM\HrmEmployees;
use App\Models\HRM\SalarySheet;
use App\Models\Zone;

use App\Models\VoucherMaster;
use App\Models\VoucherMasterDetail;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucharCheckInfo;

use Illuminate\Http\Request;
use Auth;
use Session;
use DB;

class HrmMonthlySalaryController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:monthly-salary-structure-list|monthly-salary-structure-create|monthly-salary-structure-edit|monthly-salary-structure-delete', ['only' => ['index','store']]);
         $this->middleware('permission:monthly-salary-structure-create', ['only' => ['create','store']]);
         $this->middleware('permission:monthly-salary-structure-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:monthly-salary-structure-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.monthly-salary-structure');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
       // return $request->all();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_u_limit', $request->limit);
        }else{
             $limit= Session::get('_u_limit') ??  default_pagination();
            
        }
        $page_name = $this->page_name;
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = HrmMonthlySalaryMaster::with(['_employee']);
        if($request->has('_emp_code') && $request->_emp_code !=''){
            $datas = $datas->where('_emp_code','like',"%$request->_emp_code%");
        }
         $datas = $datas->orderBy($asc_cloumn,$_asc_desc);
         if($limit =='all'){
            $datas = $datas->paginate($all_row);
         }else{
            $datas = $datas->paginate($limit);
         }
         $auth_user= \Auth::user();
          $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));
//return $datas;
         return view('hrm.monthly-salary-structure.index',compact('page_name','datas','request','permited_branch','permited_costcenters','limit'));
         
    }

     public function salaryStructureGroup(Request $request)
    {
        $page_name = __('label.group_salary_structure');
        $users = \Auth::user();
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
        $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
        $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
        $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
        $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();
        $job_zones = Zone::where('_status',1)->orderBy('_name','ASC')->get();
       
        //return "ok";
        $organization_id = $request->organization_id ?? '';
        $_branch_id = $request->_branch_id ?? '';
        $_cost_center_id = $request->_cost_center_id ?? '';
        $_category_id = $request->_category_id ?? '';
        $_department_id = $request->_department_id ?? '';
        $_jobtitle_id = $request->_jobtitle_id ?? '';
        $_grade_id = $request->_grade_id ?? '';
        $_location = $request->_location ?? '';
        $_zone_id = $request->_zone_id ?? '';

        $employees = [];

        if($organization_id !='' || $_branch_id !='' || $_cost_center_id !='' || $_department_id !='' || $_jobtitle_id !='' || $_grade_id !='' || $_location !='' || $_zone_id !=''){

            $employees = HrmEmployees::with(['_employee_cat','_emp_department','_emp_designation','_emp_grade','_emp_location','_branch','_cost_center','_organization','_basic_salary_master'])->where('_status',1);
            if($organization_id !=''){
                $employees = $employees->where('organization_id',$organization_id);
            }

            if($_branch_id !=''){
                $employees = $employees->where('_branch_id',$_branch_id);
            }
            if($_cost_center_id !=''){
                $employees = $employees->where('_cost_center_id',$_cost_center_id);
            }
            if($_category_id !=''){
                $employees = $employees->where('_category_id',$_category_id);
            }
            if($_department_id !=''){
                $employees = $employees->where('_department_id',$_department_id);
            }
            if($_jobtitle_id !=''){
                $employees = $employees->where('_jobtitle_id',$_jobtitle_id);
            }
            if($_grade_id !=''){
                $employees = $employees->where('_grade_id',$_grade_id);
            }
            if($_location !=''){
                $employees = $employees->where('_location',$_location);
            }
            if($_zone_id !=''){
                $employees = $employees->where('_zone_id',$_zone_id);
            }

             $employees = $employees->get();
    }
        //return $employees;

    $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        
        return view('hrm.monthly-salary-structure.group_salary_structure',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','employee_catogories','departments','designations','grades','job_locations','job_zones','request','employees','permited_budgets'));

    }


    public function salaryStructureGroupSave(Request $request){
       // return $request->all();
        $this->validate($request, [
            '_month' => 'required',
            '_year' => 'required',
            '_payment_type' => 'required',
        ]);

        $_payment_type = $request->_payment_type;
        $_month = $request->_month;
        $_year = $request->_year;
        $_budget_id = $request->_budget_id;
        $selected_employee_checks = $request->selected_employee_check ?? [];
        $employee_ids = $request->id ?? [];
        $employee_codes = $request->_code ?? [];
        $_employee_ids = $request->_employee_id ?? [];
        $_employee_ledger_ids = $request->_employee_ledger_id ?? [];
        $_jobtitle_ids = $request->_jobtitle_id ?? [];
        $_department_ids = $request->_department_id ?? [];
        $_category_ids = $request->_category_id ?? [];
        $_grade_ids = $request->_grade_id ?? [];
        $organization_ids = $request->organization_id ?? [];
        $_branch_ids = $request->_branch_id ?? [];
        $_cost_center_ids = $request->_cost_center_id ?? [];
        $total_earningss = $request->total_earnings ?? [];
        $total_deductions = $request->total_deduction ?? [];
        $net_total_earnings = $request->net_total_earning ?? [];

    //return $selected_employee_checks;
        if(sizeof($selected_employee_checks) > 0){
            foreach($selected_employee_checks as $key=>$check_val){
                if($check_val ==1){
                    $_employee_id = $employee_ids[$key] ?? 0;
                    //return $_payment_type;
                    $master_data = HrmMonthlySalaryMaster::where('_employee_id',$_employee_id)
                                                            ->where('_month',$_month)
                                                            ->where('_year',$_year)
                                                            ->where('_payment_type',$_payment_type)
                                                            ->first();
                    if(empty($master_data)){
                        $master_data = new HrmMonthlySalaryMaster();
                    }
                    
                    $master_data->_employee_id = $_employee_ids[$key] ?? 0;
                    $master_data->_employee_ledger_id = $_employee_ledger_ids[$key] ?? 0;
                    $master_data->_emp_code = $employee_codes[$key] ?? '';
                    $master_data->_jobtitle_id = $_jobtitle_ids[$key] ?? 0;
                    $master_data->_department_id = $_department_ids[$key] ?? 0;
                    $master_data->_category_id = $_category_ids[$key] ?? 0;
                    $master_data->_grade_id = $_grade_ids[$key] ?? 0;
                    $master_data->organization_id = $organization_ids[$key] ?? 0;
                    $master_data->_branch_id = $_branch_ids[$key] ?? 0;
                    $master_data->_cost_center_id = $_cost_center_ids[$key] ?? 0;
                    $master_data->_budget_id = $_budget_id ?? 0;
                    $master_data->_month = $_month ?? 0;
                    $master_data->_year = $_year ?? 0;
                    $master_data->_paydays = $_paydays ?? 0;
                    $master_data->_present_days = $_present_days ?? 0;
                    $master_data->_absent_days = $_absent_days ?? 0;
                    $master_data->_arrdays = $_arrdays ?? 0;
                    $master_data->_verify = $_verify ?? 0;
                    $master_data->_payment_type = $_payment_type ?? 0;

                    $master_data->total_earnings = $total_earningss[$key] ?? 0;
                    $master_data->total_deduction = $total_deductions[$key] ?? 0;
                    $master_data->net_total_earning = $net_total_earnings[$key] ?? 0;
                    $master_data->_status = $_status ?? 1;
                    $master_data->_is_delete = $_is_delete ?? 0;
                    $master_data->save();
                    $_master_id = $master_data->id;

                    $payheads_datas = \DB::table('current_salary_structures')
                                    ->where('_employee_id',$_employee_ids[$key] ?? 0)
                                    ->where('_status',1)->get();


                    if(sizeof($payheads_datas) > 0){
                        for ($i=0; $i <sizeof($payheads_datas) ; $i++) { 

                    $data = HrmMonthlySalaryDetail::where('_employee_id',$payheads_datas[$i]->_employee_id)
                                                    ->where('_master_id',$_master_id)
                                                    ->where('_payhead_id',$payheads_datas[$i]->_payhead_id ?? 0)
                                                    ->first();
                    if(empty($data)){
                        $data = new HrmMonthlySalaryDetail();
                    }
                            


                            $data->_master_id = $_master_id;
                            $data->_employee_id = $payheads_datas[$i]->_employee_id;
                            $data->_emp_code = $payheads_datas[$i]->_emp_code ?? '';
                            $data->_employee_ledger_id = $payheads_datas[$i]->_employee_ledger_id ?? 0;
                            $data->_payhead_id = $payheads_datas[$i]->_payhead_id ?? 0;
                            $data->_amount = $payheads_datas[$i]->_amount ?? 0;
                            $data->_payhead_type_id = $payheads_datas[$i]->_payhead_type_id ?? 0;
                            $data->_status = 1;
                            $data->save();
                        }
                    }
                  
                }
            }
        }

         return redirect('group_salary_structure')
                                    ->with('success','Information save successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        $payheads_data = HrmPayheads::with(['_payhead_type'])->where('_status',1)->get();
        $payheads =array();
        $payhead_types=array();
        foreach($payheads_data as $key=>$val){
            if(!in_array($val->_payhead_type->_name ?? '', $payhead_types)){
                array_push($payhead_types,$val->_payhead_type->_name ?? '');
            }
            $payheads[$val->_payhead_type->_name ?? ''][]=$val;
        }
        $users = Auth::user();
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        return view('hrm.monthly-salary-structure.create',compact('page_name','payheads','payhead_types','permited_budgets'));

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
        $this->validate($request, [
            '_month' => 'required',
            '_year' => 'required',
            '_payment_type' => 'required',
            '_employee_id' => 'required',
            '_employee_id_text' => 'required'
        ]);
        
        

        $_payhead_ids = $request->_payhead_id ?? [];
        $_amounts = $request->_amount ?? [];
        $_payhead_type_ids = $request->_payhead_type_id ?? [];

    DB::beginTransaction();
       try {
        $master_data = HrmMonthlySalaryMaster::where('_employee_id',$request->_employee_id)
                                                ->where('_month',$request->_month)
                                                ->where('_year',$request->_year)
                                                ->where('_payment_type',$request->_payment_type)
                                                ->first();
        if(empty($master_data)){
            $master_data = new HrmMonthlySalaryMaster();
        }
        
        $master_data->_employee_id = $request->_employee_id ?? '';
        $master_data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
        $master_data->_emp_code = $request->_employee_id_text ?? '';
        $master_data->_jobtitle_id = $request->_jobtitle_id ?? 0;
        $master_data->_department_id = $request->_department_id ?? 0;
        $master_data->_category_id = $request->_category_id ?? 0;
        $master_data->_grade_id = $request->_grade_id ?? 0;
        $master_data->organization_id = $request->organization_id ?? 0;
        $master_data->_branch_id = $request->_branch_id ?? 0;
        $master_data->_cost_center_id = $request->_cost_center_id ?? 0;
        $master_data->_budget_id = $request->_budget_id ?? 0;
        $master_data->_month = $request->_month ?? 0;
        $master_data->_year = $request->_year ?? 0;
        $master_data->_paydays = $request->_paydays ?? 0;
        $master_data->_present_days = $request->_present_days ?? 0;
        $master_data->_absent_days = $request->_absent_days ?? 0;
        $master_data->_arrdays = $request->_arrdays ?? 0;
        $master_data->_verify = $request->_verify ?? 0;

        $master_data->total_earnings = $request->total_earnings ?? 0;
        $master_data->total_deduction = $request->total_deduction ?? 0;
        $master_data->net_total_earning = $request->net_total_earning ?? 0;
        $master_data->_status = $request->_status ?? 1;
        $master_data->_is_delete = $request->_is_delete ?? 0;
        $master_data->save();
        $_master_id = $master_data->id;

        if(sizeof($_payhead_ids) > 0){
            for ($i=0; $i <sizeof($_payhead_ids) ; $i++) { 
                $data = new HrmMonthlySalaryDetail();
                $data->_master_id = $_master_id;
                $data->_employee_id = $request->_employee_id;
                $data->_emp_code = $request->_employee_id_text ?? '';
                $data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
                $data->_payhead_id = $_payhead_ids[$i] ?? 0;
                $data->_amount = $_amounts[$i] ?? 0;
                $data->_payhead_type_id = $_payhead_type_ids[$i] ?? 0;
                $data->_status = 1;
                $data->save();
            }
        }
      
        DB::commit();
        return redirect()->back()
                        ->with('success','Information save successfully');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back();
        }
    }



    
    public function salary_sheet(Request $request){
        $users = \Auth::user();
            $page_name = __('label.salary_sheet');
         $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
         $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
         $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
         $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
         $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();
         $job_zones = Zone::where('_status',1)->orderBy('_name','ASC')->get();
       
        return view('hrm.salary_sheet.form',compact('page_name','employee_catogories','departments','designations','grades','job_locations','job_zones'));


        
    }



    public function month_wise_sallary_sheet(Request $request){
         $users = \Auth::user();
            $page_name = __('label.month_wise_sallary_sheet');
         $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
         $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
         $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
         $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
         $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();
         $job_zones = Zone::where('_status',1)->orderBy('_name','ASC')->get();
       
        return view('hrm.salary_sheet.month_wise_sallary_sheet',compact('page_name','employee_catogories','departments','designations','grades','job_locations','job_zones'));
    }


    public function month_wise_salary_sheet_report(Request $request){

       // return $request->all();
        $_month                 = $request->_month ?? '';
        $_year                  = $request->_year ?? '';
        $organization_id        = $request->organization_id ?? '';
        $_branch_id             = $request->_branch_id ?? '';
        $_cost_center_id        = $request->_cost_center_id ?? '';

         $page_name = __('label.month_wise_sallary_sheet');

     $datas   = SalarySheet::with(['_organization','_master_branch','_master_cost_center'])
                            ->where('_month',$_month)
                            ->where('_year',$_year)
                            ->where('organization_id',$organization_id);
                    if( $_branch_id  !=''){
                     $datas   = $datas->where('_branch_id',$_branch_id);
                    }
                    $datas   = $datas->where('_cost_center_id',$_cost_center_id)->get();

   
    



    return view('hrm.salary_sheet.month_wise_salary_sheet_report',compact('page_name','datas','_month','_year','organization_id'));
    }


    public function salary_sheet_list(Request $request){
         $page_name = __('label.salary_sheet');
       

        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('salary_sheet_limit', $request->limit);
        }else{
             $limit= \Session::get('salary_sheet_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';



        $datas = SalarySheet::with(['_master_cost_center','_organization','_master_branch'])->where('is_delete',0);
        if($request->has('_year')  && $request->_year !=''){
            $datas = $datas->where('_year',$request->_year);
        }
        if($request->has('_month')  && $request->_month !=''){
            $datas = $datas->where('_month',$request->_month);
        }
        if($request->has('organization_id')  && $request->organization_id !=''){
            $datas = $datas->where('organization_id',$request->organization_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id',$request->_branch_id);
        }else{
           if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
            } 
        }
        if($request->has('_cost_center_id')  && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id',$request->_cost_center_id);
        }
       
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);


        return view('hrm.salary_sheet.list',compact('page_name','datas','request','limit'));
    }


    /*
@Title: salary_sheet_generate
@param: organization_id, _branch_id,_cost_center_id,Month,Year
@description: organization_id, _branch_id,_cost_center_id wise data fetch from monthly_salary_structure table and make a voucher basse on payhead table _ledger_id wise

*/

public function salary_sheet_generate(Request $request){




$organization_id = $request->organization_id ?? '';
$_branch_id = $request->_branch_id ?? '';
$_cost_center_id = $request->_cost_center_id ?? '';
$_month = $request->_month ?? '';
$_year = $request->_year ?? '';
$_date = change_date_format($request->_date ?? date('Y-m-d'));

$users = Auth::user();
$branch_ids         = [];
$cost_center_ids    = [];
if($_branch_id ==''){
 $branch_ids = (explode(',',$users->branch_ids));
}else{
   $branch_ids[]=$_branch_id;
}



    //return $request->all();

 DB::beginTransaction();
       try {


foreach($branch_ids as $b_key=>$_branch_id){




$salary_data = HrmMonthlySalaryMaster::with(['_details'])
        ->where('_month',$_month)
        ->where('_year',$_year)
        ->where('_status',1);
if($organization_id !=''){
    $salary_data =$salary_data->where('organization_id',$organization_id);
}
if($_branch_id !=''){
    $salary_data =$salary_data->where('_branch_id',$_branch_id);
}
if($_cost_center_id !=''){
    $salary_data =$salary_data->where('_cost_center_id',$_cost_center_id);
}
 $salary_data =$salary_data->get();

$re_arrange_datas =[];
$employe_id_amounts=[];
$salary_amount=[];
$allowance_amount=[];
$deduction_amount=[];
$org_branch_costcer=[];
foreach($salary_data as $data){

    $org_branch_costcer[]=$data->organization_id."__".$data->_branch_id."__".$data->_cost_center_id;
  //  return $data;
    $_details = $data->_details ?? [];
    foreach($_details as $detail){
       $_ledger_id = $detail->_payhead->_ledger_id;
        //organization_id__branch_id__cost_center_id__ledger_id=amount
        $re_arrange_datas[$data->organization_id."__".$data->_branch_id."__".$data->_cost_center_id."__".$_ledger_id."__".$detail->_payhead_type_id][]=$detail->_amount ?? 0; 
        if($detail->_payhead_type_id ==1){
            $salary_amount[$data->organization_id."__".$data->_branch_id."__".$data->_cost_center_id][]=$detail->_amount ?? 0; 
        }
        
        if( $detail->_payhead_type_id==2){
            $allowance_amount[$data->organization_id."__".$data->_branch_id."__".$data->_cost_center_id][]=$detail->_amount ?? 0; 
        }
        if( $detail->_payhead_type_id==3){
            $deduction_amount[$data->organization_id."__".$data->_branch_id."__".$data->_cost_center_id][]=$detail->_amount ?? 0; 
        }
        


    }
    $employe_id_amounts[$data->organization_id."__".$data->_branch_id."__".$data->_cost_center_id."__".$data->_employee_ledger_id][]=$data->net_total_earning ?? 0;
}

//return $re_arrange_datas;
//return $employe_id_amounts;

$auth_user =\Auth::user();
//First set Status 0 if alreay data exit
//return $salary_amount;

foreach($org_branch_costcer as $org_b_cs){
    $org_string_to_array = explode('__',$org_b_cs);
    //return $org_string_to_array;
    $org_id = $org_string_to_array[0] ?? 1; 
    $branch_id = $org_string_to_array[1] ?? 1; 
    $cost_center_id = $org_string_to_array[2] ?? 1; 

$_note ="Salary sheet Created for the month "._number_to_month($_month)."- ".$_year." "._branch_name($branch_id);

    $salary_amounts = array_sum($salary_amount[$org_b_cs] ?? []);
    $allowance_amounts = array_sum($allowance_amount[$org_b_cs] ?? []);
    $deduction_amounts = array_sum($deduction_amount[$org_b_cs] ?? []);
    $net_payable_amounts = (($salary_amounts+$allowance_amounts)-$deduction_amounts);

    $SalarySheet = SalarySheet::where('_month',$_month)
                    ->where('_year',$_year)
                    ->where('organization_id',$org_id)
                    ->where('_branch_id',$branch_id)
                    ->where('_cost_center_id',$cost_center_id)
                    ->first();
//Lock check
$_lock = $SalarySheet->_lock ?? 0;
if($_lock==1){
    $_lock_mesge=_number_to_month($data->_month)." - ".$_year."  Salary Already Generated and Locked";
    return redirect()->back()->with('error',$_lock_mesge);
}

    if(empty($SalarySheet)){
        $SalarySheet = new SalarySheet();
        $SalarySheet->_created_by = $auth_user->id;
    }else{
        $SalarySheet->_updated_by = $auth_user->_updated_by;
    }

        $SalarySheet->_month = $_month;
        $SalarySheet->_year = $_year;
        $SalarySheet->organization_id = $org_id;
        $SalarySheet->_branch_id = $branch_id;
        $SalarySheet->_cost_center_id = $_cost_center_id;
        $SalarySheet->_date = $request->_date ?? date('Y-m-d');
        //$SalarySheet->_voucher_id = $_voucher_id;
        //$SalarySheet->_voucher_code = $_voucher_code;
        $SalarySheet->salary_amount = $salary_amounts;
        $SalarySheet->allowance_amount = $allowance_amounts;
        $SalarySheet->deduction_amount = $deduction_amounts;
        $SalarySheet->net_payable_amount = $net_payable_amounts;
        $SalarySheet->_note = $_note;
        $SalarySheet->_user_id = $auth_user->id;
        $SalarySheet->_user_name = $auth_user->user_name ?? '';
        $SalarySheet->_status = 1;
        $SalarySheet->_lock = 0;
        $SalarySheet->_is_posting = $request->_is_posting ?? 0;
        $SalarySheet->save();

        $salary_sheet_id = $SalarySheet->id;
        $_defalut_ledger_id = $SalarySheet->id;






        //Make Voucher Depend On Organization,Branch and Cost center




         $voucher_info = VoucherMaster::where('_transection_type','salary_sheets')
                            ->where('_transection_ref',$salary_sheet_id)
                            ->first();
         if(!empty($voucher_info )){
           $voucher_id =  $voucher_info->id;
            VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$voucher_id)
                        ->where('_transaction','salary_sheets')
                        ->update(['_status'=>0]);

         }else{
            $type_wise_number = type_wise_voucher_number('JV',$_date);
            $_code = voucher_prefix()."JV"."-".$type_wise_number;
             $voucher_info = new VoucherMaster();
            $voucher_info->_code = $_code;
         }

   
    
        $voucher_info->_defalut_ledger_id = $_defalut_ledger_id;
        $voucher_info->_transection_ref = $_defalut_ledger_id;
        $voucher_info->_transection_type = 'salary_sheets';
        
        $voucher_info->_date = change_date_format($_date);
       
        $voucher_info->_time = date('H:i:s');
        $voucher_info->_form_name = 'voucher_masters';
        $voucher_info->_ref_table = 'salary_sheets';
       
        $voucher_info->_created_by = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id = $auth_user->id;
        $voucher_info->_user_name = $auth_user->name;
        $voucher_info->_note = $_note;
        $voucher_info->_voucher_type = 'JV';
        
        $voucher_info->_amount = $net_payable_amounts ?? 0;
        

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

          Accounts::where('_voucher_code',$voucher_code)
                        ->update(['_status'=>0]);

        SalarySheet::where('id',$_defalut_ledger_id)
                    ->update(['voucher_id'=>$master_id,'voucher_code'=>$voucher_code]);




        //Make Voucher Detail 
        $serial_key=0;

        //data without Emplyee Ledger ID
        foreach($re_arrange_datas as $obc_key=>$obc_sad){
            $serial_key++;

             $obc_string_to_array = explode('__',$obc_key);
              $obc_org_id = $obc_string_to_array[0] ?? ''; 
             $obc_branch_id = $obc_string_to_array[1] ?? 1; 
             $obc_cost_center_id = $obc_string_to_array[2] ?? 1; 
              $obc_ledger_id = $obc_string_to_array[3] ?? ''; 
             $obc_type_id = $obc_string_to_array[4] ?? 1; 
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
                if($obc_type_id==1){
                    $VoucherMasterDetail->_dr_amount = $_tk_amount ?? 0;
                    $VoucherMasterDetail->_cr_amount =  0;
                }
                if($obc_type_id==2){
                    $VoucherMasterDetail->_dr_amount = $_tk_amount ?? 0;
                    $VoucherMasterDetail->_cr_amount =  0;
                }
                if($obc_type_id==3){
                    $VoucherMasterDetail->_dr_amount = 0;
                    $VoucherMasterDetail->_cr_amount =  $_tk_amount ?? 0;
                }
                
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
                $Accounts->_transaction = 'salary_sheets';
               // $Accounts->_transaction = 'Account';
                $Accounts->_date = change_date_format($_date);
                $Accounts->_table_name = 'voucher_masters';
                $Accounts->_account_head = $_account_type_id;
                $Accounts->_account_group = $_account_group_id;
                $Accounts->_account_ledger = $obc_ledger_id;
                if($obc_type_id==1){
                    $Accounts->_dr_amount = $_tk_amount ?? 0;
                    $Accounts->_cr_amount =  0;
                }
                if($obc_type_id==2){
                    $Accounts->_dr_amount = $_tk_amount ?? 0;
                    $Accounts->_cr_amount =  0;
                }
                if($obc_type_id==3){
                    $Accounts->_dr_amount =  0;
                    $Accounts->_cr_amount = $_tk_amount ?? 0;
                }
                $Accounts->organization_id = $obc_org_id ?? 1;
                $Accounts->_branch_id = $obc_branch_id ?? 0;
                $Accounts->_cost_center = $obc_cost_center_id ?? 0;
                $Accounts->_budget_id = $_budget_id ?? 0;
                $Accounts->_serial = $serial_key ?? 0;
                $Accounts->_name =$auth_user->name;
                $Accounts->_sales_man_id = $_sales_man_id ?? 0;
                $Accounts->save();


                 }
             } //End of All ledger Voucher without Employees



        } 


            //Employee Ledger Account
        $_tk_amount=0;
    foreach($employe_id_amounts as $em_key=>$emp_value){

             $obc_string_to_array = explode('__',$em_key);
             $obc_org_id = $obc_string_to_array[0] ?? 1; 
             $obc_branch_id = $obc_string_to_array[1] ?? 1; 
             $obc_cost_center_id = $obc_string_to_array[2] ?? 1; 
             $obc_ledger_id = $obc_string_to_array[3] ?? 0; 
           
             $_tk_amount =  array_sum($emp_value);

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
                $Accounts->_transaction = 'salary_sheets';
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
                $Accounts->_name =$auth_user->name;
                $Accounts->_sales_man_id = $_sales_man_id ?? 0;
                $Accounts->save();

                }
             }
        }

   
}
}

            DB::commit();
            return redirect()->back()
             ->with('success', __('label.info_created'));
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('success',"Something Wrong");
        }

      


}


public function branch_wise_sallary_sheet($id){
    $page_name = __('label.branch_wise_sallary_sheet');

     $data   = SalarySheet::with(['_organization','_master_branch','_master_cost_center'])->find($id);

     $salery_datas = HrmMonthlySalaryMaster::with(['_employee'])->where('_year',$data->_year)
                                            ->where('_month',$data->_month)
                                            ->where('organization_id',$data->organization_id)
                                            ->where('_branch_id',$data->_branch_id)
                                            ->where('_cost_center_id',$data->_cost_center_id)
                                            ->where('_status',1)
                                            ->get();

    



    return view('hrm.salary_sheet.branch_wise_sallary_sheet',compact('page_name','data','salery_datas'));
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = HrmMonthlySalaryMaster::with(['_details','_employee'])->find($id);
         $page_name = $this->page_name;
        $payheads_data = HrmPayheads::with(['_payhead_type'])->where('_status',1)->get();
        $payheads =array();
        $payhead_types=array();
        foreach($payheads_data as $key=>$val){
            if(!in_array($val->_payhead_type->_name ?? '', $payhead_types)){
                array_push($payhead_types,$val->_payhead_type->_name ?? '');
            }
            $payheads[$val->_payhead_type->_name ?? ''][]=$val;
        }

       // return $payheads;

         return view('hrm.monthly-salary-structure.show',compact('page_name','data','payheads','payhead_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = HrmMonthlySalaryMaster::with(['_employee_cat','_emp_department','_emp_designation','_emp_grade','_branch','_cost_center','_organization','_details','_employee'])->find($id);

              

        $payheads_data = HrmPayheads::with(['_payhead_type'])->where('_status',1)->get();
        $payheads =array();
        $payhead_types=array();
        foreach($payheads_data as $key=>$val){
            if(!in_array($val->_payhead_type->_name ?? '', $payhead_types)){
                array_push($payhead_types,$val->_payhead_type->_name ?? '');
            }
            $payheads[$val->_payhead_type->_name ?? ''][]=$val;
        }
        $users = Auth::user();
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));

         return view('hrm.monthly-salary-structure.edit',compact('page_name','data','payheads','payhead_types','permited_budgets'));
        
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
            'id' => 'required',
            '_month' => 'required',
            '_year' => 'required',
            '_payment_type' => 'required',
            '_employee_id' => 'required',
            '_employee_id_text' => 'required'
        ]);
        
        
        $id = $request->id;
        $_payhead_ids = $request->_payhead_id ?? [];
        $_amounts = $request->_amount ?? [];
        $_payhead_type_ids = $request->_payhead_type_id ?? [];
        $_detail_row_ids = $request->_detail_row_id ?? [];

    DB::beginTransaction();
       try {
        HrmMonthlySalaryDetail::where('_master_id',$id)->update(['_status'=>0]);
        $master_data = HrmMonthlySalaryMaster::find($id);
        if(empty($master_data)){
            $master_data = new HrmMonthlySalaryMaster();
        }
        
        $master_data->_employee_id = $request->_employee_id ?? '';
        $master_data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
        $master_data->_emp_code = $request->_employee_id_text ?? '';
        $master_data->_jobtitle_id = $request->_jobtitle_id ?? 0;
        $master_data->_department_id = $request->_department_id ?? 0;
        $master_data->_category_id = $request->_category_id ?? 0;
        $master_data->_grade_id = $request->_grade_id ?? 0;
        $master_data->organization_id = $request->organization_id ?? 0;
        $master_data->_branch_id = $request->_branch_id ?? 0;
        $master_data->_cost_center_id = $request->_cost_center_id ?? 0;
        $master_data->_budget_id = $request->_budget_id ?? 0;
        $master_data->_month = $request->_month ?? 0;
        $master_data->_year = $request->_year ?? 0;
        $master_data->_paydays = $request->_paydays ?? 0;
        $master_data->_present_days = $request->_present_days ?? 0;
        $master_data->_absent_days = $request->_absent_days ?? 0;
        $master_data->_arrdays = $request->_arrdays ?? 0;
        $master_data->_verify = $request->_verify ?? 0;

        $master_data->total_earnings = $request->total_earnings ?? 0;
        $master_data->total_deduction = $request->total_deduction ?? 0;
        $master_data->net_total_earning = $request->net_total_earning ?? 0;
        $master_data->_status = $request->_status ?? 1;
        $master_data->_is_delete = $request->_is_delete ?? 0;
        $master_data->save();
        $_master_id = $master_data->id;

        if(sizeof($_payhead_ids) > 0){
            for ($i=0; $i <sizeof($_payhead_ids) ; $i++) { 
                $row_id = $_detail_row_ids[$i] ?? 0;

                $data =  HrmMonthlySalaryDetail::find($row_id);
                if(empty($data)){
                    $data = new HrmMonthlySalaryDetail();
                }

                $data->_master_id = $_master_id;
                $data->_employee_id = $request->_employee_id;
                $data->_emp_code = $request->_employee_id_text ?? '';
                $data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
                $data->_payhead_id = $_payhead_ids[$i] ?? 0;
                $data->_amount = $_amounts[$i] ?? 0;
                $data->_payhead_type_id = $_payhead_type_ids[$i] ?? 0;
                $data->_status = 1;
                $data->save();
            }
        }
      
        DB::commit();
        return redirect()->back()
                        ->with('success','Information save successfully');
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
        //
    }
}