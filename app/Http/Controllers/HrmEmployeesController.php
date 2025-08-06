<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmEmployees;
use App\Models\HRM\HrmEmpCategory;
use App\Models\HRM\HrmDepartment;
use App\Models\HRM\Designation;
use App\Models\HRM\HrmGrade;
use App\Models\HRM\HrmEmpLocation;
use App\Models\AccountLedger;
use App\Models\GeneralSettings;
use App\Models\HRM\CurrentSalaryMaster;
use App\Models\HRM\CurrentSalaryStructure;
use App\Models\HRM\HrmPayheads;
use App\Models\HRM\HrmEducation;
use App\Models\HRM\HrmEmergency;
use App\Models\HRM\HrmEmpaddress;
use App\Models\HRM\HrmExperience;
use App\Models\HRM\HrmGuarantor;
use App\Models\HRM\HrmJobcontract;
use App\Models\HRM\HrmNominee;
use App\Models\HRM\HrmReward;
use App\Models\HRM\HrmTraining;
use App\Models\HRM\HrmTransfer;
use App\Models\HRM\HrmVacancies;
use App\Models\HRM\HrmLanguage;

use App\Models\Zone;
use Illuminate\Http\Request;
use Auth;
use Session;

class HrmEmployeesController extends Controller
{

     function __construct()
    {
        
         $this->middleware('permission:hrm-employee-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-employee-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-employee-list', ['only' => ['index']]);
         $this->middleware('permission:hrm-employee-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.hrm-employee');
    }


     public function employeeDataUpdate()
    {
     // \DB::statement(" UPDATE hrm_employees
     //        JOIN saif_employee_db ON saif_employee_db.EMP_ID= hrm_employees._code
     //        JOIN hrm_departments ON hrm_departments._department = saif_employee_db.DEPARTMENT
     //        SET hrm_employees._department_id=hrm_departments.id ");
//      \DB::statement(" UPDATE hrm_employees
// JOIN saif_employee_db ON saif_employee_db.EMP_ID= hrm_employees._code
// JOIN designations ON designations._name = saif_employee_db.DESIGNATION
// SET hrm_employees._jobtitle_id=designations.id ");

     // $old_data = \DB::select(" SELECT hrm_emp_categories.id as _id,saif_employee_db.CATEGORY,saif_employee_db.EMP_ID as _code FROM saif_employee_db INNER JOIN hrm_emp_categories ON hrm_emp_categories._name=saif_employee_db.CATEGORY  ");

   // $old_data = \DB::select(" SELECT designations.id as _id,saif_employee_db.DESIGNATION,saif_employee_db.EMP_ID as _code FROM saif_employee_db INNER JOIN designations ON designations._name=saif_employee_db.DESIGNATION  ");

  
//    $old_data = \DB::select(" SELECT hrm_grades.id as _id,saif_employee_db.EMP_GRADE,saif_employee_db.EMP_ID as _code
// FROM saif_employee_db 
// INNER JOIN hrm_grades ON hrm_grades._grade=saif_employee_db.EMP_GRADE  ");

//      foreach($old_data as $key=>$val){
//         $_code= $val->_code;
//         $_category_id= $val->_id;

//         //\DB::table("hrm_employees")->where('_code',$_code)->update(['_category_id'=>$_category_id]);
//         \DB::table("hrm_employees")->where('_code',$_code)->update(['_grade_id'=>$_category_id]);
//      }

     
           
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
            session()->put('_employee_list', $request->limit);
        }else{
             $limit= Session::get('_employee_list') ??  default_pagination();
            
        }
       
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
                $page_name = $this->page_name;

         $datas = HrmEmployees::with(['_employee_cat','_emp_department','_emp_designation','_emp_grade','_emp_location','_branch','_cost_center','_organization'])->where('_status',1);

         $all_row = $datas->count();
         
        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_mobile1') && $request->_mobile1 !=''){
            $datas = $datas->where('_mobile1','like',"%$request->_mobile1%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_category_id') && $request->_category_id !=''){
            $datas = $datas->where('_category_id',$request->_category_id);
        }
        if($request->has('_department_id') && $request->_department_id !=''){
            $datas = $datas->where('_department_id',$request->_department_id);
        }
        if($request->has('_jobtitle_id') && $request->_jobtitle_id !=''){
            $datas = $datas->where('_jobtitle_id',$request->_jobtitle_id);
        }
        if($request->has('_grade_id') && $request->_grade_id !=''){
            $datas = $datas->where('_grade_id',$request->_grade_id);
        }

         $datas = $datas->orderBy($asc_cloumn,$_asc_desc);
         if($limit =='all'){
            $datas = $datas->paginate($all_row);
         }else{
            $datas = $datas->paginate($limit);
         }
         

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.hrm-employee.print',compact('datas','page_name','request'));
            }
         }

         $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
         $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
         $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
         $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
         $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();


        return view('hrm.hrm-employee.index',compact('datas','page_name','employee_catogories','departments','designations','grades','job_locations','limit','request'));
    }

    public function showResume($id)
    {
          $employee = HrmEmployees::with([
                    '_employee_cat', '_emp_department', '_emp_designation', '_emp_grade', '_emp_location',
                    '_organization', '_hrm_education', 'hrm_experiences', 'hrm_emergencies',
                    'hrm_empaddresses', '_hrm_languages', '_hrm_trainings', '_hrm_transfers', '_hrm_guarantors', 'hrm_jobcontracts'
                ])->findOrFail($id);

        return view('hrm.hrm-employee.resume', compact('employee'));
    }


    public function employeeSearch(Request $request){
       $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_code';
        $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }








         $datas = HrmEmployees::with(['_organization','_branch','_cost_center','_employee_cat','_emp_department','_emp_designation','_emp_grade','_emp_location'])->where('_status',1)
        ->where(function ($query) use ($text_val) {
                $query->orWhere('_code','like',"%$text_val%")
                      ->orWhere('_name','like',"%$text_val%");
            });
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $page_name = $this->page_name;
         $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
         $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
         $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
         $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
         $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();
         $job_zones = Zone::where('_status',1)->orderBy('_name','ASC')->get();
       
        return view('hrm.hrm-employee.create',compact('page_name','employee_catogories','departments','designations','grades','job_locations','job_zones'));
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
            '_name' => 'required',
            '_category_id' => 'required',
            '_department_id' => 'required',
            '_jobtitle_id' => 'required',
            '_grade_id' => 'required',
            
        ]);

        try {

            $_user = Auth::user();
            $_account_groups = GeneralSettings::select('_employee_group')->first();
            $_employee_group = $_account_groups->_employee_group ?? 50;
            $_account_head_id = _find_group_to_head($_employee_group);

             $data = new AccountLedger();
            $data->_account_head_id = $_account_groups;
            $data->_account_group_id = $_account_head_id;
            $data->_branch_id = $request->_branch_id;
            $data->_name = $request->_name;
            $data->_address = $request->_officedes ?? 'N/A';
            $data->_code = $request->_code ?? '';
            $data->_nid = $request->_nid ?? 'N/A';
            $data->_email = $request->_email;
            $data->_phone = $request->_mobile1;
            $data->_credit_limit = $request->_ledger_credit_limit ?? 0;
            $data->_short = $request->_ledger_short ?? 1;
            $data->_is_user = $request->_ledger_is_user ?? 1;
            $data->_is_sales_form = 1;
            $data->_is_purchase_form = 1;
            $data->_is_all_branch = 1;
            $data->_status = 1;
            $data->_show =1;
            $data->_created_by = $_user->id."-".$_user->name;
            $data->save();
            $_ledger_id = $data->id;


$email=$request->_email;
$code =$request->_code ?? '';
$phone = $request->_mobile1 ?? '';
$name  = $request->_name ?? '';
$organization_id = $request->organization_id;
$branch_id =$request->_branch_id;
$_cost_center_id=$request->_cost_center_id;
$user_id = employee_user_create($email,$code,$phone,$name,$organization_id,$branch_id,$_cost_center_id,$_ledger_id);
        

            $data = new HrmEmployees();
            $data->_name =$request->_name ?? '';
            $data->_code =$request->_code ?? employee_code($request->organization_id);
            $data->_father =$request->_father ?? '';
            $data->_mother =$request->_mother ?? '';
            $data->_spouse =$request->_spouse ?? '';
            $data->_mobile1 =$request->_mobile1 ?? '';
            $data->_mobile2 =$request->_mobile2 ?? '';
            $data->_spousesmobile =$request->_spousesmobile ?? '';
            $data->_nid =$request->_nid ?? '';
            $data->_gender =$request->_gender ?? '';
            $data->_bloodgroup =$request->_bloodgroup ?? '';
            $data->_religion =$request->_religion ?? '';
            $data->_dob =$request->_dob ?? '';
            $data->_education =$request->_education ?? '';
            $data->_email =$request->_email ?? '';
            $data->_jobtitle_id =$request->_jobtitle_id ?? 1;
            $data->_department_id =$request->_department_id ?? 1;
            $data->_category_id =$request->_category_id ?? 1;
            $data->_grade_id =$request->_grade_id ?? 1;
            $data->_location =$request->_location ?? 1;
            $data->_zone_id =$request->_zone_id ?? 1;
            $data->_officedes =$request->_officedes ?? 1;
            $data->_bank =$request->_bank ?? 1;
            $data->_bankac =$request->_bankac ?? 1;
            $data->_cost_center_id =$request->_cost_center_id ?? 1;
            $data->_branch_id =$request->_branch_id ?? 1;
            $data->organization_id =$request->organization_id ?? 1;
            $data->_active =$request->_active ?? 1;
            $data->_doj =$request->_doj ?? '';
            $data->_tin =$request->_tin ?? '';
            $data->_gross_salary =$request->_gross_salary ?? 0;
            $data->basic_salary =$request->basic_salary ?? 0;
            $data->net_salary =$request->net_salary ?? 0;
            $data->allowances =$request->allowances ?? 0;
            $data->deductions =$request->deductions ?? 0;


            
            $data->_ledger_id =$_ledger_id;
            $data->user_id =$user_id; //Users Table ID
            if($request->hasFile('_photo')){ 
                $_photo = UserImageUpload($request->_photo); 
                $data->_photo = $_photo;
            }
            if($request->hasFile('_signature')){ 
                $_signature = UserImageUpload($request->_signature); 
                $data->_signature = $_signature;
            }

            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->_created_by = $_user->id."-".$_user->_name;
            $data->save();
             
            return redirect('hrm-employee')->with('success','Information Save successfully');
       }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmEmployees  $HrmEmployees
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmEmployees::with(['_employee_cat','_emp_department','_emp_designation','_emp_grade','_emp_location','_branch','_cost_center','_organization','_hrm_education','hrm_emergencies','hrm_empaddresses','_details','hrm_experiences','hrm_experiences','_hrm_languages','hrm_nominees','_hrm_rewards','_hrm_trainings','_hrm_transfers','hrm_jobcontracts'])->find($id);

        return view('hrm.hrm-employee.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmEmployees  $HrmEmployees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


         $data = HrmEmployees::with(['_hrm_education','hrm_emergencies','hrm_empaddresses','_details','hrm_experiences','hrm_experiences','_hrm_languages','hrm_nominees','_hrm_rewards','_hrm_trainings','_hrm_transfers','hrm_jobcontracts'])->find($id);
         $page_name = $this->page_name;
         $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
         $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
         $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
         $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
         $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();
         $job_zones = Zone::where('_status',1)->orderBy('_name','ASC')->get();

         $payheads_data = HrmPayheads::with(['_payhead_type'])->where('_status',1)->get();
        $payheads =array();
        $payhead_types=array();
        foreach($payheads_data as $key=>$val){
            if(!in_array($val->_payhead_type->_name ?? '', $payhead_types)){
                array_push($payhead_types,$val->_payhead_type->_name ?? '');
            }
            $payheads[$val->_payhead_type->_name ?? ''][]=$val;
        }



        return view('hrm.hrm-employee.edit',compact('page_name','employee_catogories','departments','designations','grades','job_locations','data','job_zones','payheads','payhead_types'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmEmployees  $HrmEmployees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //return $request->all();

        $this->validate($request, [
            '_name' => 'required',
            '_category_id' => 'required',
            '_department_id' => 'required',
            '_jobtitle_id' => 'required',
            '_grade_id' => 'required',
            '_ledger_id' => 'required',
            
        ]);
        
    //  return $request->all();

      

            $_user = Auth::user();
            $_account_groups = GeneralSettings::select('_employee_group')->first();
            $_employee_group = $_account_groups->_employee_group;
             $_account_head_id = _find_group_to_head($_employee_group);
            if($request->_ledger_id ==0){
                $data = new AccountLedger();
            }else{
                $data = AccountLedger::find($request->_ledger_id);
                if(empty($data)){
                    $data = new AccountLedger();
                }
            }
            
            $data->_account_head_id = $_account_head_id;
            $data->_account_group_id = $_employee_group;
            $data->_branch_id = $request->_branch_id;
            $data->_name = $request->_name;
            $data->_address = $request->_officedes ?? 'N/A';
            $data->_code = $request->_code ?? '';
            $data->_nid = $request->_nid ?? 'N/A';
            $data->_email = $request->_email;
            $data->_phone = $request->_mobile1;
            $data->_credit_limit = $request->_ledger_credit_limit ?? 0;
            $data->_short = $request->_ledger_short ?? 1;
            $data->_is_user = $request->_ledger_is_user ?? 1;
            $data->_is_sales_form = 1;
            $data->_is_purchase_form = 1;
            $data->_is_all_branch = 1;
            $data->_status = 1;
            $data->_show =1;
            $data->_created_by = $_user->id."-".$_user->name;
            $data->save();
            $_ledger_id = $data->id;
            $request->_ledger_id=$_ledger_id;

$email=$request->_email;
$code =$request->_code ?? '';
$phone = $request->_mobile1 ?? '';
$name  = $request->_name ?? '';
$organization_id = $request->organization_id;
$branch_id =$request->_branch_id;
$_cost_center_id=$request->_cost_center_id;
//$user_id = employee_user_create($email,$code,$phone,$name,$organization_id,$branch_id,$_cost_center_id,$_ledger_id);
        

            $data = HrmEmployees::find($id);
            $data->_name =$request->_name ?? '';
            $data->_code =$request->_code ?? '';
            $data->_father =$request->_father ?? '';
            $data->_mother =$request->_mother ?? '';
            $data->_spouse =$request->_spouse ?? '';
            $data->_mobile1 =$request->_mobile1 ?? '';
            $data->_mobile2 =$request->_mobile2 ?? '';
            $data->_spousesmobile =$request->_spousesmobile ?? '';
            $data->_nid =$request->_nid ?? '';
            $data->_gender =$request->_gender ?? '';
            $data->_bloodgroup =$request->_bloodgroup ?? '';
            $data->_religion =$request->_religion ?? '';
            $data->_dob =$request->_dob ?? '';
            $data->_education =$request->_education ?? '';
            $data->_email =$request->_email ?? '';
            $data->_jobtitle_id =$request->_jobtitle_id ?? 1;
            $data->_department_id =$request->_department_id ?? 1;
            $data->_category_id =$request->_category_id ?? 1;
            $data->_grade_id =$request->_grade_id ?? 1;
            $data->_location =$request->_location ?? 1;
            $data->_zone_id =$request->_zone_id ?? 1;
            $data->_officedes =$request->_officedes ?? 1;
            $data->_bank =$request->_bank ?? 1;
            $data->_bankac =$request->_bankac ?? 1;
            $data->_cost_center_id =$request->_cost_center_id ?? 1;
            $data->_branch_id =$request->_branch_id ?? 1;
            $data->organization_id =$request->organization_id ?? 1;
            $data->_active =$request->_active ?? 1;
            $data->_doj =$request->_doj ?? '';
            $data->_tin =$request->_tin ?? '';
            $data->_ledger_id =$_ledger_id;
            $data->user_id =$request->user_id ?? '';
            $data->_gross_salary =$request->_gross_salary ?? 0;
            $data->basic_salary =$request->basic_salary ?? 0;
            $data->net_salary =$request->net_salary ?? 0;
            $data->allowances =$request->allowances ?? 0;
            $data->deductions =$request->deductions ?? 0;
            

            if($request->hasFile('_photo')){ 
                $_photo = UserImageUpload($request->_photo); 
                $data->_photo = $_photo;
            }
            if($request->hasFile('_signature')){ 
                $_signature = UserImageUpload($request->_signature); 
                $data->_signature = $_signature;
            }

            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->_created_by = $_user->id."-".$_user->_name;
            $data->save();


            $employee_id = $data->id;
            $_employee_id = $data->id;



CurrentSalaryStructure::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmEducation::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmEmergency::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmEmpaddress::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmExperience::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmGuarantor::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmJobcontract::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmNominee::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmReward::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmTraining::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmLanguage::where('_employee_id',$_employee_id)->update(['_status'=>0]);
HrmTransfer::where('_employee_id',$_employee_id)->update(['_status'=>0]);

            // Data Insert hrm_education

//  CurrentSalaryStructure;

$_detail_row_ids= $request->_detail_row_id ?? [];
$_payhead_ids= $request->_payhead_id ?? [];
$_payhead_type_ids= $request->_payhead_type_id ?? [];
$_amounts= $request->_amount ?? [];
$_emp_code = _find_id_to_code("hrm_employees",$employee_id);
$_employee_ledger_id = $_ledger_id;


$total_earnings = $request->total_earnings ?? 0;
$total_deduction = $request->total_deduction ?? 0;
$net_total_earning = $request->net_total_earning ?? 0;

$CurrentSalaryMaster = CurrentSalaryMaster::where('_employee_id',$_employee_id)->first();
if(empty($CurrentSalaryMaster)){
    $CurrentSalaryMaster = new CurrentSalaryMaster();
}
    $CurrentSalaryMaster->_employee_id = $_employee_id;
    $CurrentSalaryMaster->_employee_ledger_id = $_employee_ledger_id;
    $CurrentSalaryMaster->_emp_code = $_emp_code;
    $CurrentSalaryMaster->total_earnings = $total_earnings;
    $CurrentSalaryMaster->total_deduction = $total_deduction;
    $CurrentSalaryMaster->net_total_earning = $net_total_earning;
    $CurrentSalaryMaster->_status = $_status ?? 1;
    $CurrentSalaryMaster->save();


for ($i=0; $i <sizeof($_detail_row_ids) ; $i++) { 
    if(empty($_detail_row_ids[$i])){
        $CurrentSalaryStructure = new CurrentSalaryStructure();
    }else{
        $CurrentSalaryStructure = CurrentSalaryStructure::find($_detail_row_ids[$i]);
    }
    $CurrentSalaryStructure->_employee_id = $_employee_id;
    $CurrentSalaryStructure->_emp_code = $_emp_code;
    $CurrentSalaryStructure->_employee_ledger_id = $_employee_ledger_id;
    $CurrentSalaryStructure->_payhead_id = $_payhead_ids[$i] ?? 0;
    $CurrentSalaryStructure->_payhead_type_id = $_payhead_type_ids[$i] ?? 0;
    $CurrentSalaryStructure->_amount = $_amounts[$i] ?? 0;
    $CurrentSalaryStructure->_status = 1;
    $CurrentSalaryStructure->save();
}
/* Salary Details End */

//  HrmPayheads;


//  HrmEducation;
$hrm_education_ids = $request->hrm_education_id ?? [];
$_levels = $request->_level ?? [];
$_subjects = $request->_subject ?? [];
$_institutes = $request->_institute ?? [];
$_years = $request->_year ?? [];
$_scores = $request->_score ?? [];
$_edsdates = $request->_edsdate ?? [];
$_ededates = $request->_ededate ?? [];

if(sizeof($hrm_education_ids) > 0){
    for ($i=0; $i <sizeof($hrm_education_ids) ; $i++) { 
        $hrm_education_id = $hrm_education_ids[$i] ?? 0;
        if($hrm_education_id ==0){
            $HrmEducation = new HrmEducation();
        }else{
            $HrmEducation = HrmEducation::find($hrm_education_id);
        }
        $HrmEducation->_employee_id = $_employee_id ?? '';
        $HrmEducation->_level = $_levels[$i] ?? '';
        $HrmEducation->_subject = $_subjects[$i] ?? '';
        $HrmEducation->_institute = $_institutes[$i] ?? '';
        $HrmEducation->_year = $_years[$i] ?? 0;
        $HrmEducation->_score = $_scores[$i] ?? 0;
        $HrmEducation->_edsdate = $_edsdates[$i] ?? '';
        $HrmEducation->_ededate = $_ededates[$i] ?? '';
        $HrmEducation->_status = 1;
        $HrmEducation->_user = $_user->id;
        $HrmEducation->save();

    }
}


//  HrmEmergency;
$hrm_emergencies_ids = $request->hrm_emergencies_id ?? [];
$emerg_names = $request->emerg_name ?? [];
$emerg_relationships = $request->emerg_relationship ?? [];
$emerg_mobiles = $request->emerg_mobile ?? [];
$emerg_homes = $request->emerg_home ?? [];
$emerg_works = $request->emerg_work ?? [];
if(sizeof($hrm_emergencies_ids) > 0){
    for ($i=0; $i <sizeof($hrm_emergencies_ids) ; $i++) { 
        $hrm_emergencies_id = $hrm_emergencies_ids[$i] ?? 0;
        if($hrm_emergencies_id ==0){
            $HrmEmergency = new HrmEmergency();
        }else{
            $HrmEmergency = HrmEmergency::find($hrm_emergencies_id);
        }
        $HrmEmergency->_name=$emerg_names[$i] ?? '';
        $HrmEmergency->_relationship=$emerg_relationships[$i] ?? '';
        $HrmEmergency->_mobile=$emerg_mobiles[$i] ?? '';
        $HrmEmergency->_home=$emerg_homes[$i] ?? '';
        $HrmEmergency->_work=$emerg_works[$i] ?? '';
        $HrmEmergency->_employee_id=$_employee_id;
        $HrmEmergency->_status=1;
        $HrmEmergency->_user = $_user->id;
        $HrmEmergency->save();
    }
}

//  HrmEmpaddress;
$hrm_empaddresses_ids = $request->hrm_empaddresses_id ?? [];
$_types = $request->_type ?? [];
$_districts = $request->_district ?? [];
$_polices = $request->_police ?? [];
$_posts = $request->_post ?? [];
$_addresss = $request->_address ?? [];
$_eaddresss = $request->_eaddress ?? [];
if(sizeof($hrm_empaddresses_ids) > 0){
    for ($i=0; $i <sizeof($hrm_empaddresses_ids) ; $i++) { 
        $hrm_empaddresses_id =$hrm_empaddresses_ids[$i] ?? 0;
        if($hrm_empaddresses_id ==0){
            $HrmEmpaddress = new HrmEmpaddress();
        }else{
            $HrmEmpaddress = HrmEmpaddress::find($hrm_empaddresses_id);
        }
        $HrmEmpaddress->_type = $_types[$i] ?? '';
        $HrmEmpaddress->_address = $_addresss[$i] ?? '';
        $HrmEmpaddress->_post = $_posts[$i] ?? '';
        $HrmEmpaddress->_police = $_polices[$i] ?? '';
        $HrmEmpaddress->_district = $_districts[$i] ?? '';
        $HrmEmpaddress->_eaddress = $_eaddresss[$i] ?? '';
        $HrmEmpaddress->_employee_id = $_employee_id;
        $HrmEmpaddress->_status = 1;
        $HrmEmpaddress->_user = $_user->id;
        $HrmEmpaddress->save();
    }
}

//  HrmExperience;
$hrm_experiences_ids = $request->hrm_experiences_id ?? [];
$_companys = $request->_company ?? [];
$hrm_experiences_jobtitle_ids = $request->hrm_experiences_jobtitle_id ?? [];
$_wfroms = $request->_wfrom ?? [];
$_wtos = $request->_wto ?? [];
$_notes = $request->_note ?? [];

if(sizeof($hrm_experiences_ids) > 0){
    for ($i=0; $i <sizeof($hrm_experiences_ids) ; $i++) { 
        $hrm_experiences_id =$hrm_experiences_ids[$i] ?? 0;
        if($hrm_experiences_id ==0){
            $HrmExperience = new HrmExperience();
        }else{
            $HrmExperience = HrmExperience::find($hrm_experiences_id);
        }
        $HrmExperience->_company = $_companys[$i] ?? '';
        $HrmExperience->_jobtitle_id = $hrm_experiences_jobtitle_ids[$i] ?? '';
        $HrmExperience->_wfrom = $_wfroms[$i] ?? '';
        $HrmExperience->_wto = $_wtos[$i] ?? '';
        $HrmExperience->_note = $_notes[$i] ?? '';
        $HrmExperience->_employee_id = $_employee_id;
        $HrmExperience->_status = 1;
        $HrmExperience->_user = $_user->id;
        $HrmExperience->save();
    }
}
//  HrmGuarantor;
$hrm_guarantors_ids = $request->hrm_guarantors_id ?? [];
$gur_names = $request->gur_name ?? [];
$gur_fathers = $request->gur_father ?? [];
$gur_mothers = $request->gur_mother ?? [];
$gur_occupations = $request->gur_occupation ?? [];
$gur_workstations = $request->gur_workstation ?? [];
$gur_address1s = $request->gur_address1 ?? [];
$gur_address2s = $request->gur_address2 ?? [];
$gur_mobiles = $request->gur_mobile ?? [];
$gur_emails = $request->gur_email ?? [];
$gur_nationalids = $request->gur_nationalid ?? [];
$gur_dobs = $request->gur_dob ?? [];

if(sizeof($hrm_guarantors_ids) > 0){
    for ($i=0; $i <sizeof($hrm_guarantors_ids) ; $i++) { 
        $hrm_guarantors_id =$hrm_guarantors_ids[$i] ?? 0;
        if($hrm_guarantors_id ==0){
            $HrmGuarantor = new HrmGuarantor();
        }else{
            $HrmGuarantor = HrmGuarantor::find($hrm_guarantors_id);
        }
        $HrmGuarantor->_name = $gur_names[$i] ?? '';
        $HrmGuarantor->_father = $gur_fathers[$i] ?? '';
        $HrmGuarantor->_mother = $gur_mothers[$i] ?? '';
        $HrmGuarantor->_occupation = $gur_occupations[$i] ?? '';
        $HrmGuarantor->_workstation = $gur_workstations[$i] ?? '';
        $HrmGuarantor->_address1 = $gur_address1s[$i] ?? '';
        $HrmGuarantor->_address2 = $gur_address2s[$i] ?? '';
        $HrmGuarantor->_mobile = $gur_mobiles[$i] ?? '';
        $HrmGuarantor->_email = $gur_emails[$i] ?? '';
        $HrmGuarantor->_nationalid = $gur_nationalids[$i] ?? '';
        $HrmGuarantor->_dob = $gur_dobs[$i] ?? '';
        $HrmGuarantor->_employee_id = $_employee_id;
        $HrmGuarantor->_status = 1;
        $HrmGuarantor->_user = $_user->id;
        $HrmGuarantor->save();
    }
}



//  HrmJobcontract;
$_ctype = $request->_ctype ?? '';
$_csdate = $request->_csdate ?? '';
$_cdetail = $request->_cdetail ?? '';
$_cedate = $request->_cedate ?? '';


$HrmJobcontract = HrmJobcontract::where('_employee_id',$_employee_id)
                                ->where('_ctype',$_ctype)
                                ->where('_csdate',$_csdate)
                                ->where('_cdetail',$_cdetail)
                                ->where('_cedate',$_cedate)
                                ->first();
if(empty($HrmJobcontract)){
    $HrmJobcontract = new HrmJobcontract();
    $HrmJobcontract->_ctype = $_ctype;
    $HrmJobcontract->_csdate = $_csdate;
    $HrmJobcontract->_cedate = $_cedate;
    $HrmJobcontract->_cdetail = $_cdetail;
    $HrmJobcontract->_employee_id = $_employee_id;
    $HrmJobcontract->_status = 1;
    $HrmJobcontract->_user = $_user->id;
    $HrmJobcontract->save();
}

//  HrmNominee;
$HrmNominee = HrmNominee::where('_employee_id',$_employee_id)->first();
if(empty($HrmNominee)){
    $HrmNominee = new HrmNominee();
}
$HrmNominee->_nname= $request->_nname ?? '';
$HrmNominee->_nfather= $request->_nfather ?? '';
$HrmNominee->_nmother= $request->_nmother ?? '';
$HrmNominee->_ndob= $request->_ndob ?? '';
$HrmNominee->_nnationalid= $request->_nnationalid ?? '';
$HrmNominee->_nmobile= $request->_nmobile ?? '';
$HrmNominee->_naddress1= $request->_naddress1 ?? '';
$HrmNominee->_naddress2= $request->_naddress2 ?? '';
$HrmNominee->_nrelation= $request->_nrelation ?? '';
$HrmNominee->_nbenefit= $request->_nbenefit ?? '';
$HrmNominee->_employee_id= $_employee_id ?? '';
if($request->has('_nphoto')){
    $_nphoto = UserImageUpload($request->_nphoto); 
    $HrmNominee->_nphoto = $_nphoto;
}
$HrmNominee->_status= 1;
$HrmNominee->save();


//  HrmReward;
$hrm_rewards_ids = $request->hrm_rewards_id ?? [];
$_rcategorys = $request->_rcategory ?? [];
$_rtypes = $request->_rtype ?? [];
$_rcauses = $request->_rcause ?? [];
$_rnotes = $request->_rnote ?? [];
if(sizeof($hrm_rewards_ids) > 0){
    for ($i=0; $i <sizeof($hrm_rewards_ids) ; $i++) { 
        $hrm_rewards_id =$hrm_rewards_ids[$i] ?? 0;
        if($hrm_rewards_id ==0){
            $HrmReward = new HrmReward();
        }else{
            $HrmReward = HrmReward::find($hrm_rewards_id);
        }
        $HrmReward->_rcategory = $_rcategorys[$i] ?? '';
        $HrmReward->_rtype = $_rtypes[$i] ?? '';
        $HrmReward->_rcause = $_rcauses[$i] ?? '';
        $HrmReward->_rnote = $_rnotes[$i] ?? '';
        $HrmReward->_employee_id = $_employee_id;
        $HrmReward->_status = 1;
        $HrmReward->_user = $_user->id;
        $HrmReward->save();
    }
}


//  HrmTraining;
$hrm_trainings_ids = $request->hrm_trainings_id ?? [];
$training_types = $request->training_type ?? [];
$training_names = $request->training_name ?? [];
$training_subjects = $request->training_subject ?? [];
$training_organizeds = $request->training_organized ?? [];
$training_places = $request->training_place ?? [];
$training_trfroms = $request->training_trfrom ?? [];
$training_trtos = $request->training_trto ?? [];
$training_results = $request->training_result ?? [];
$training_notes = $request->training_note ?? [];

if(sizeof($hrm_trainings_ids) > 0){
    for ($i=0; $i <sizeof($hrm_trainings_ids) ; $i++) { 
        $hrm_trainings_id =$hrm_trainings_ids[$i] ?? 0;
        if($hrm_trainings_id ==0){
            $HrmTraining = new HrmTraining();
        }else{
            $HrmTraining = HrmTraining::find($hrm_trainings_id);
        }
        $HrmTraining->_type = $training_types[$i] ?? '';
        $HrmTraining->_name = $training_names[$i] ?? '';
        $HrmTraining->_subject = $training_subjects[$i] ?? '';
        $HrmTraining->_organized = $training_organizeds[$i] ?? '';
        $HrmTraining->_place = $training_places[$i] ?? '';
        $HrmTraining->_trfrom = $training_trfroms[$i] ?? '';
        $HrmTraining->_trto = $training_trtos[$i] ?? '';
        $HrmTraining->_result = $training_results[$i] ?? '';
        $HrmTraining->_note = $training_notes[$i] ?? '';
        $HrmTraining->_employee_id = $_employee_id;
        $HrmTraining->_status = 1;
        $HrmTraining->_user = $_user->id;
        $HrmTraining->save();
    }
}

$hrm_languages_ids = $request->hrm_languages_id ?? [];
$_languages = $request->_language ?? [];
$_fluencys = $request->_fluency ?? [];
$_lnotes = $request->_lnote ?? [];

if(sizeof($hrm_languages_ids) > 0){
    for ($i=0; $i <sizeof($hrm_languages_ids) ; $i++) { 
        $hrm_languages_id =$hrm_languages_ids[$i] ?? 0;
        if($hrm_languages_id ==0){
            $HrmLanguage = new HrmLanguage();
        }else{
            $HrmLanguage = HrmLanguage::find($hrm_languages_id);
        }
        $HrmLanguage->_language = $_languages[$i] ?? '';
        $HrmLanguage->_fluency = $_fluencys[$i] ?? '';
        $HrmLanguage->_lnote = $_lnotes[$i] ?? '';
        $HrmLanguage->_employee_id = $_employee_id;
        $HrmLanguage->_status = 1;
        $HrmLanguage->_user = $_user->id;
        $HrmLanguage->save();
    }
}


//  HrmTransfer;
$hrm_transfers_ids = $request->hrm_transfers_id ?? [];
$_forganization_ids = $request->_forganization_id ?? [];
$_fbranch_ids = $request->_fbranch_id ?? [];
$_fcost_center_ids = $request->_fcost_center_id ?? [];
$_ttransfers = $request->_ttransfer ?? [];
$_torganization_ids = $request->_torganization_id ?? [];
$_tbranch_ids = $request->_tbranch_id ?? [];
$_tcost_center_ids = $request->_tcost_center_id ?? [];
$_tjoins = $request->_tjoin ?? [];
$_tnotes = $request->_tnote ?? [];

if(sizeof($hrm_transfers_ids) > 0){
    for ($i=0; $i <sizeof($hrm_transfers_ids) ; $i++) { 
        $hrm_transfers_id =$hrm_transfers_ids[$i] ?? 0;
        if($hrm_transfers_id ==0){
            $HrmTransfer = new HrmTransfer();
        }else{
            $HrmTransfer = HrmTransfer::find($hrm_transfers_id);
        }
        $HrmTransfer->_forganization_id = $_forganization_ids[$i] ?? '';
        $HrmTransfer->_fbranch_id = $_fbranch_ids[$i] ?? '';
        $HrmTransfer->_fcost_center_id = $_fcost_center_ids[$i] ?? '';
        $HrmTransfer->_torganization_id = $_torganization_ids[$i] ?? '';
        $HrmTransfer->_tbranch_id = $_tbranch_ids[$i] ?? '';
        $HrmTransfer->_tcost_center_id = $_tcost_center_ids[$i] ?? '';
        $HrmTransfer->_ttransfer = $_ttransfers[$i] ?? '';
        $HrmTransfer->_tjoin = $_tjoins[$i] ?? '';
        $HrmTransfer->_tnote = $_tnotes[$i] ?? '';
        $HrmTransfer->_employee_id = $_employee_id;
        $HrmTransfer->_status = 1;
        $HrmTransfer->_user = $_user->id;
        $HrmTransfer->save();
    }
}


CurrentSalaryStructure::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmEducation::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmEmergency::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmEmpaddress::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmExperience::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmGuarantor::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmJobcontract::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmNominee::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmReward::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmTraining::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmLanguage::where('_employee_id',$_employee_id)->where('_status',0)->delete();
HrmTransfer::where('_employee_id',$_employee_id)->where('_status',0)->delete();


 return redirect()->back()->with('success','Information Save successfully');
        
    }

    
     
    public function destroy($id){
        HrmEmployees::where('id',$id)->update(['_status'=>0]);
        return redirect('hrm-employee')->with('success','Information deleted successfully');
    }
}
