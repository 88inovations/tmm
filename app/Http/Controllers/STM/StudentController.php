<?php

namespace App\Http\Controllers\STM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STM\StmClass;
use App\Models\STM\StmDivision;
use App\Models\STM\StmStudent;
use App\Models\STM\StudentClassSubject;
use App\Models\STM\StmDivisionClassStudent;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Upzila;
use App\Models\PostCode;
use Auth;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use DB;



class StudentController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:stm_students_list|stm_students_create|stm_students_edit|stm_students_delete', ['only' => ['index','store']]);
         $this->middleware('permission:stm_students_create', ['only' => ['create','store']]);
         $this->middleware('permission:stm_students_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stm_students_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.stm_students');
    }


    public function session_class_div_wise_student(Request $request){
        $_admission_session_id  = $request->_admission_session_id ?? '';
        $_education_type  = $request->_education_type ?? '';
        $_admission_class_id  = $request->_admission_class_id ?? '';

      //  return $request->all();

         $students = StmStudent::where('_admission_session_id',$_admission_session_id)
                            ->where('_education_type',$_education_type)
                            ->where('_admission_class_id',$_admission_class_id)
                            ->get();


        return view('stm.stm_students.select_option_student',compact('students'));
 
        
    }



    public function stm_students_excel_upload(Request $request){
             //return dump($request->all());
         $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
$auth_user  = \Auth::user();
       
         $renew_type= $request->renew_type ?? 1;
         $_date= $request->_date ?? date('Y-m-d');

        // try {
            // Load the Excel file
            $file = $request->file('file');
            $data = Excel::toArray([], $file)[0]; // Fetch data as an array

            $datas = [];

            foreach ($data as $key => $row) {
                if ($key === 0) {
                    // Skip the header row
                    continue;
                }

           //return  $datas[]= $row;


$sl = $row[0]; // Serial Number
$_admission_date = $row[1]; // Admission Date (e.g. 2025-01-01)
$_education_type = _order_to_id('_name', trim($row[2]),'stm_divisions');; // Education Type (e.g. General, Technical)
 $_admission_class_id = _order_to_id('_name', trim($row[3]),'stm_classes'); // Session/Class ID where student is admitted
 $_class_name = $row[3];
//$_admission_class_name = $row[4];
$_student_id = $row[4]; // Unique Student ID
$_proximity_card_no = $row[5]; // RFID Card or Proximity Card Number
$_name_in_english = $row[6]; // Student Full Name in English
$_name_in_bangla = $row[7]; // Student Name in Bangla
$_student_image = $row[8]; // Path or Filename of Student's Image
$_gender = $row[9]; // Gender (Male/Female/Other)
$_dob = $row[10]; // Date of Birth (e.g. 2010-05-15)
$_birth_id = $row[11]; // National Birth Certificate Number
$_blood_group = $row[12]; // Blood Group (e.g. A+, B-, O+)
$_identification_mark = $row[13]; // Special identification mark (scar, mole, etc.)
$_age = $row[14]; // Age (auto-calculated or stored)
$_nationality = $row[15]; // Nationality (e.g. Bangladeshi)
$_height = $row[16]; // Height in cm or feet
$_weight = $row[17]; // Weight in kg

// Father's Information
$_father_name_bangla = $row[18]; // Father's Name in Bangla
$_father_name_english = $row[19]; // Father's Name in English
$_father_occupation = $row[20]; // Father's Occupation (e.g. Teacher)
$_father_annual_income = $row[21]; // Father's Yearly Income
$_father_mobile = $row[22]; // Father's Mobile Number
$_father_nid = $row[23]; // Father's NID Number
$_father_email = $row[24]; // Father's Email Address
$_email = $row[24]; // Father's Email Address

// Mother's Information
$_mother_name_bangla = $row[25]; // Mother's Name in Bangla
$_mother_name_english = $row[26]; // Mother's Name in English
$_mother_occupation     = $row[27]; // Mother's Occupation
$_mother_annual_income = $row[28]; // Mother's Yearly Income
$_mother_nid = $row[29]; // Mother's NID Number
$_mother_email = $row[30]; // Mother's Email Address
$_mother_mobile = $row[31]; // Mother's Mobile Number

// Local Guardian Information
$_local_guardian_name = $row[32]; // Local Guardian's Name
$_local_guardian_address = $row[33]; // Local Guardian's Address
$_local_guardian_mobile = $row[34]; // Local Guardian's Mobile Number
$_local_guardian_nid = $row[35]; // Local Guardian's NID

// Address Details
$_present_address = $row[36]; // Present Address of Student
$_permanent_address = $row[37]; // Permanent Address of Student

// Previous Education Information
$_previous_institute_name = $row[38]; // Previous School/College Name
$_previous_class = $row[39]; // Last Class Attended
$_previous_result = $row[40]; // Result from Previous Institute
$_previous_roll_no = $row[41]; // Roll Number in Previous Class

// Uploaded Document Images
$_father_nid_image = $row[42]; // Father's NID Image File
$_mother_nid_image = $row[43]; // Mother's NID Image File
$_guardian_nid_image = $row[44]; // Guardian's NID Image File

// Fee Information
$_admission_fee = $row[45] ?? 0; // One-time Admission Fee
$_monthly_fee = $row[46] ?? 0; // Monthly Tuition Fee

// Residential Details
$_residential_type = trim($row[47]); // Residential Type (e.g. Day Scholar, Hostel)

if($_residential_type =='Non Residential'){
    $_residential_type =1;
}
if($_residential_type =='Residential'){
    $_residential_type =1;
}

$_parents_signature = $row[48]; // Scanned Image/Path of Parents' Signature




$email = str_replace(' ', '', $_name_in_english); // Remove all spaces
$email = strtolower($email) . '@gmail.com'; 
 $_email = generateUniqueEmail($email);

  $account_group_configs        = DB::table('account_group_configs')->first();
  $_cash_group                  = $account_group_configs->_student_groups ?? '';


// First Create Ledger Account
    $_account_group_id  =49; //$request->_account_group_id;
     $_account_head_id = id_to_cloumn($_account_group_id,'_account_head_id','account_groups');
     $_main_account_id = id_to_cloumn($_account_head_id,'_account_id','account_heads');

    $email           = $_father_email ?? '';
   
    $name            = $_name_in_english ?? '';
    $phone            = $_f_mobile_no ?? '';
    $organization_id = $organization_id ?? 1;
    $branch_id       = $branch_id ?? 1;
    $_cost_center_id = $_cost_center_id ?? 1;
    $_ledger_id      = $_ledger_id ?? '';



       // $AccountLedger =  \App\Models\AccountLedger::find($_ledger_id);
        //if(empty($AccountLedger)){
             $code            = _ledger_code($_account_head_id);


            $AccountLedger = new \App\Models\AccountLedger();
            $AccountLedger->_code = $code;
     //   }
        
        $AccountLedger->_account_group_id = $_account_group_id;
        $AccountLedger->_account_head_id =$_account_head_id;
        $AccountLedger->_main_account_id = $_main_account_id;
        $AccountLedger->_branch_id = $_branch_id ?? 1;
        $AccountLedger->_name = $_name_in_english ?? '';
        $AccountLedger->_address = $_parmanent_address ?? '';
        $AccountLedger->_address_2 =  $_local_guardian_address ?? '';
        $AccountLedger->_date_of_birth = $_date_of_birth ?? '';
        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_student_image ); 
                $AccountLedger->_image = $_student_image ;
        }



        
        $AccountLedger->_nid = $_barth_id ?? '';
        $AccountLedger->_note = $_note ?? '';
        $AccountLedger->_alious = $_father_name_english ?? '';
        $AccountLedger->_email = $_email ?? '';
        $AccountLedger->_phone = $_f_mobile_no ?? '';

        $AccountLedger->_credit_limit = $_credit_limit ?? 0;
        $AccountLedger->_short = $_short ?? 5;
        $AccountLedger->_is_user = $_is_user ?? 1;
        $AccountLedger->_is_sales_form = $_is_sales_form ?? 0;
        $AccountLedger->_is_purchase_form = $_is_purchase_form ?? 0;
        $AccountLedger->_is_all_branch = $_is_all_branch ?? 0;
        $AccountLedger->opening_dr_amount = $opening_dr_amount ?? 0;
        $AccountLedger->opening_cr_amount = $opening_cr_amount ?? 0;
        $AccountLedger->_status = $_status ?? 1;
        $AccountLedger->_show = 1;
        $AccountLedger->_is_used = 1;
        $AccountLedger->_created_by = $auth_user->id."-".$auth_user->name;
         
        $AccountLedger->save();

        $_ledger_id  = $AccountLedger->id;
        $code  = $AccountLedger->_code;
        $phone  = $AccountLedger->phone ?? '';


      // Second Create User Account


       $_user_table_id = employee_user_create($_email,$code,$phone,$name,$organization_id,$branch_id,$_cost_center_id,$_ledger_id);

 $_admission_date = change_date_format($_admission_date ?? date('d-m-Y'));

$data =[
    '_user_table_id'         => $_user_table_id,
    'organization_id'        => 1, // or your org ID
    '_branch_id'             => 1, // or your branch ID
    '_account_group_id'      => $_account_group_id,
    '_ledger_id'             => $_ledger_id,
    '_roll_no'               => $_student_id,
    '_admission_date'        => $_admission_date,
    '_admission_session_id'  => 1,
    '_education_type'        => $_education_type,
    '_admission_class_id'    => $_admission_class_id,
    '_current_class_id'      => $_admission_class_id,
    '_student_id'            => $_student_id,
    '_proximity_card_no'     => $_proximity_card_no,
    '_name_in_english'       => $_name_in_english,
    '_name_in_bangla'        => $_name_in_bangla,
    '_religion'              => $_religion ?? 1, // Add if available
    '_student_image'         => $_student_image,
    '_gender'                => $_gender,
    '_email'                 => $_email,
    '_date_of_birth'         => $_dob,
    '_barth_id'              => $_birth_id,
    '_bloodgroup'            => $_blood_group,
    '_s_identification_mark' => $_identification_mark,
    '_age'                   => $_age,
    '_nationality'           => $_nationality,
    '_height'                => $_height,
    '_weight'                => $_weight,
    '_father_name_bangla'    => $_father_name_bangla,
    '_father_name_english'   => $_father_name_english,
    '_occupation'            => $_father_occupation,
    '_annual_income'         => $_father_annual_income,
    '_f_mobile_no'           => $_father_mobile,
    '_f_nid_no'              => $_father_nid,
    '_f_email'               => $_father_email,
    '_mother_name_english'   => $_mother_name_english,
    '_mother_name_of_bangla' => $_mother_name_bangla,
    '_mother_occupation'     => $_mother_occupation,
    '_mother_mobile_no'      => $_mother_mobile,
    '_mother_anual_income'   => $_mother_annual_income,
    '_mother_nid_no'         => $_mother_nid,
    '_mother_email'          => $_mother_email,
    '_local_guardian_name'   => $_local_guardian_name,
    '_local_guardian_occupation' => null, // Not provided
    '_local_guardian_address'=> $_local_guardian_address,
    '_local_guardian_mobile' => $_local_guardian_mobile,
    '_local_guardian_nid'    => $_local_guardian_nid,
    '_local_guardian_nid_image' => $_guardian_nid_image,
    '_present_address'       => $_present_address,
    '_per_country_id'        => null,
    '_per_division_id'       => null,
    '_per_district_id'       => null,
    '_per_thana_id'          => null,
    '_per_union_id'          => null,
    '_cur_division_id'       => null,
    '_cur_country_id'        => null,
    '_cur_district_id'       => null,
    '_cur_thana_id'          => null,
    '_cur_union_id'          => null,
    '_per_post_office'       => null,
    '_cur_post_office'       => null,
    '_parmanent_address'     => $_permanent_address,
    '_previous_institute_name' => $_previous_institute_name,
    '_pre_class'             => $_previous_class,
    '_pre_result'            => $_previous_result,
    '_pre_roll_no'           => $_previous_roll_no,
    '_father_nid_image'      => $_father_nid_image,
    '_mother_nid_image'      => $_mother_nid_image,
    '_birth_certificate'     => null,
    '_transfer_certificate'  => null,
    '_testimonial'           => null,
    '_academic_certificate'  => null,
    '_marksheet'             => null,
    '_student_photo'         => null,
    '_adminssion_fee_amount' => $_admission_fee,
    '_monthly_fee'           => $_monthly_fee,
    '_resedential_type'      => 1,
    '_parents_signature'     => $_parents_signature,
    '_main_subjects'         => null,
    '_optional_subjects'     => null,
    '_detail'                => null,
    '_user_id'               => 46,
    '_user_name'             => 'admin',
    '_status'                => 1,
    '_lock'                  => 0,
    '_created_by'            => $auth_user->id ?? 1,
    '_updated_by'            => $auth_user->id ?? 1,
];

$StmStudent = StmStudent::where('_admission_class_id', $_admission_class_id)
                  ->where('_student_id', $_student_id)
                  ->where('_name_in_english', $_name_in_english)
                  ->first();
    if ($StmStudent) {
        $StmStudent->update($data);
    } else {
        if($_name_in_english !=''){
           
            $student = StmStudent::create($data);
            $id = $student->id;



        if($id !=''){
                $StmDivisionClassStudent = new StmDivisionClassStudent();
                $StmDivisionClassStudent->_student_id           = $id;
                $StmDivisionClassStudent->_roll_no              = $_student_id ?? '';
                $StmDivisionClassStudent->_class_name              = $_class_name ?? '';
                
                $StmDivisionClassStudent->_admission_date       = $_admission_date ?? '';
                $StmDivisionClassStudent->_session              = 1;
                $StmDivisionClassStudent->_division_id          = $_education_type ?? '';
                $StmDivisionClassStudent->_class_id             = $_admission_class_id ?? '';
                $StmDivisionClassStudent->_admission_fee        = $_admission_fee ?? 0;
                $StmDivisionClassStudent->_tution_fee           = $_monthly_fee ?? 0;
                $StmDivisionClassStudent->_status               =1;
                $StmDivisionClassStudent->save();
            }
        }
        
    }


}



 return redirect()->back()->with('success','Information Save successfully');

    }

    

public function downloadAdmissionForm(Request $request)
{
    $id = $request->id;
      $data = StmStudent::with(['_edu_class','_edu_division','_edu_session','_per_division','_cur_division','_per_district','_cur_district','_per_thana','_cur_thana','_per_union','_cur_union','_per_country','_cur_country'])->find($id);
    // You can pass student data as needed


 $subjects = \DB::table('stm_subjects')->orderBy('id','ASC')->get();
  $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();

return view('stm.stm_students.pdf_form',compact('data','subjects','edu_class'));
    $pdf = PDF::loadView('stm.stm_students.pdf_form', $data);
    return $pdf->download('stm.stm_students.pdf');
}


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;

         $_asc_desc = $request->_asc_desc ?? 'DESC';
            $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = StmStudent::with(['_edu_class','_edu_division','_edu_session']);
        if($request->has('_admission_class_id')){
            $limit = $datas->count();
        }
        if($request->has('_education_type') && $request->_education_type !=''){
            $datas = $datas->where('_education_type',$request->_education_type);
        }
        if($request->has('_roll_no') && $request->_roll_no !=''){
            $datas = $datas->where('_roll_no',$request->_roll_no);
        }
        if($request->has('_admission_class_id') && $request->_admission_class_id !=''){
            $datas = $datas->where('_admission_class_id',$request->_admission_class_id);
        }
        if($request->has('_name_in_english') && $request->_name_in_english !=''){
            $datas = $datas->where('_name_in_english','like',"%$request->_name_in_english%");
        }
        if($request->has('_student_id') && $request->_student_id !=''){
            $datas = $datas->where('_student_id','like',"%$request->_student_id%");
        }
        if($request->has('_gender') && $request->_gender !=''){
            $datas = $datas->where('_gender','like',"%$request->_gender%");
        }
        if($request->has('_age') && $request->_age !=''){
            $datas = $datas->where('_age','like',"%$request->_age%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status',$request->_status);
        }
        if($request->has('_f_mobile_no') && $request->_f_mobile_no !=''){
            $datas = $datas->where('_f_mobile_no','like',"%$request->_f_mobile_no%");
        }

        if($request->has('_father_name_english') && $request->_father_name_english !=''){
            $datas = $datas->where('_father_name_english','like',"%$request->_father_name_english%");
        }
        if($request->has('_local_guardian_name') && $request->_local_guardian_name !=''){
            $datas = $datas->where('_local_guardian_name','like',"%$request->_local_guardian_name%");
        }
        if($request->has('_local_guardian_mobile') && $request->_local_guardian_mobile !=''){
            $datas = $datas->where('_local_guardian_mobile','like',"%$request->_local_guardian_mobile%");
        }

        // Filter by student name
                if ($request->has('_student_name') && $request->_student_name != '') {
                    $studentName = $request->_student_name;

                   
                        $datas->where('_name_in_english', 'like', '%' . $studentName . '%')
                              ->orWhere('_name_in_bangla', 'like', '%' . $studentName . '%');
                    
                }





$datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);


         $page_name = $this->page_name;
          if($request->has('print')){
            if($request->print =="detail"){
                return view('stm.stm_students.print',compact('datas','page_name','request'));
            }
         }

        $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
        $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
        $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();


        return view('stm.stm_students.index',compact('datas','request','page_name','edu_class','edu_types','stm_education_sessions','limit'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_name = $this->page_name;

        $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
        $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
        $counteries = Country::get();
        $loc_divisions = Division::orderBy('name','asc')->get();
        $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();

        $subjects = \DB::table('stm_subjects')->orderBy('id','ASC')->get();


        $account_groups = \DB::table('account_groups')->whereIn('id',_student_group_array())->get();

        
        


        return view('stm.stm_students.create',compact('request','page_name','edu_class','edu_types','counteries','loc_divisions','stm_education_sessions','subjects','account_groups'));
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
        $request->validate([
                '_admission_date' => 'required',
                '_student_id' => 'required',
            ]);

    $auth_user = Auth::user();


    $_main_subjects = implode(", ",$request->_main_subjects ?? []);
    $_optional_subjects = implode(", ",$request->_optional_subjects ?? []);



      // First Create Ledger Account
    $_account_group_id  = $request->_account_group_id;
     $_account_head_id = id_to_cloumn($request->_account_group_id,'_account_head_id','account_groups');
     $_main_account_id = id_to_cloumn($_account_head_id,'_account_id','account_heads');

    $email           = $request->_email ?? '';
   
    $name            = $request->_name_in_english ?? '';
    $phone            = $request->_f_mobile_no ?? '';
    $organization_id = $request->organization_id ?? 1;
    $branch_id       = $request->branch_id ?? 1;
    $_cost_center_id = $request->_cost_center_id ?? 1;
    $_ledger_id = $request->_ledger_id ?? '';
    $_proximity_card_no = $request->_proximity_card_no ?? '';


 $code ='';
        $AccountLedger =  \App\Models\AccountLedger::find($_ledger_id);
        if(empty($AccountLedger)){
            if($request->_proximity_card_no ==''){

             $code            = _ledger_code($_account_head_id);
            }


            $AccountLedger = new \App\Models\AccountLedger();
            $AccountLedger->_code = $request->_proximity_card_no ?? '';
        }
        
        $AccountLedger->_account_group_id = $_account_group_id;
        $AccountLedger->_account_head_id =$_account_head_id;
        $AccountLedger->_main_account_id = $_main_account_id;
        $AccountLedger->_branch_id = $request->_branch_id ?? 1;
        $AccountLedger->_proximity_card_no = $request->_proximity_card_no ??  $code;
        $AccountLedger->_name = $request->_name_in_english ?? '';
        $AccountLedger->_address = $request->_parmanent_address ?? '';
        $AccountLedger->_address_2 =  $request->_local_guardian_address ?? '';
        $AccountLedger->_date_of_birth = $request->_date_of_birth ?? '';
        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_student_image ); 
                $AccountLedger->_image = $_student_image ;
        }



        
        $AccountLedger->_nid = $request->_barth_id ?? '';
        $AccountLedger->_note = $request->_note ?? '';
        $AccountLedger->_alious = $request->_father_name_english ?? '';
        $AccountLedger->_email = $request->_email ?? '';
        $AccountLedger->_phone = $request->_f_mobile_no ?? '';

        $AccountLedger->_credit_limit = $request->_credit_limit ?? 0;
        $AccountLedger->_short = $request->_short ?? 5;
        $AccountLedger->_is_user = $request->_is_user ?? 1;
        $AccountLedger->_is_sales_form = $request->_is_sales_form ?? 0;
        $AccountLedger->_is_purchase_form = $request->_is_purchase_form ?? 0;
        $AccountLedger->_is_all_branch = $request->_is_all_branch ?? 0;
        $AccountLedger->opening_dr_amount = $request->opening_dr_amount ?? 0;
        $AccountLedger->opening_cr_amount = $request->opening_cr_amount ?? 0;
        $AccountLedger->_status = $request->_status ?? 1;
        $AccountLedger->_show = 1;
        $AccountLedger->_is_used = 1;
        $AccountLedger->_created_by = $auth_user->id."-".$auth_user->name;
         
        $AccountLedger->save();

        $_ledger_id  = $AccountLedger->id;
        $code  = $AccountLedger->_code;
        $phone  = $AccountLedger->phone ?? '';


      // Second Create User Account


       $_user_table_id = employee_user_create($email,$code,$phone,$name,$organization_id,$branch_id,$_cost_center_id,$_ledger_id);



        

        $data = StmStudent::find($request->id);
        if(empty($data)){
            $data = new StmStudent();









        }

        $data->_user_table_id        = $_user_table_id;
        $data->_account_group_id     = $_account_group_id;
        $data->_ledger_id            = $_ledger_id;
        $data->_user_id              = $auth_user->id;
        $data->_user_name            = $auth_user->name ?? '';
        $data->organization_id       = $request->organization_id ?? 1;
        $data->_branch_id            = $request->_branch_id ?? 1;
        $data->_roll_no              = $request->_roll_no ?? '';
        $data->_main_subjects        = $_main_subjects ?? '';
        $data->_optional_subjects    = $_optional_subjects ?? '';
        $data->_admission_date       = $request->_admission_date ?? '';
        $data->_student_id           = $request->_student_id ?? '';
        $data->_proximity_card_no    = $request->_proximity_card_no ?? '';
        $data->_admission_session_id = $request->_admission_session_id ?? '';
        $data->_education_type       = $request->_education_type ?? '';
        $data->_admission_class_id    = $request->_admission_class_id ?? '';
        $data->_adminssion_fee_amount = $request->_adminssion_fee_amount ?? 0;
        $data->_monthly_fee           = $request->_monthly_fee ?? 0;
        $data->_name_in_english       = $request->_name_in_english ?? '';
        $data->_name_in_bangla       = $request->_name_in_bangla ?? '';
        $data->_gender              = $request->_gender ?? '';
        $data->_date_of_birth       = $request->_date_of_birth ?? '';
        $data->_barth_id            = $request->_barth_id ?? '';
        $data->_email               = $request->_email ?? '';
        $data->_bloodgroup          = $request->_bloodgroup ?? '';
        $data->_religion            = $request->_religion ?? '';
        $data->_s_identification_mark       = $request->_s_identification_mark ?? '';
        $data->_nationality       = $request->_nationality ?? '';
        $data->_age                 = $request->_age ?? '';
        $data->_height              = $request->_height ?? '';
        $data->_weight       = $request->_weight ?? '';
        $data->_resedential_type       = $request->_resedential_type ?? '';
      

        $data->_cur_country_id       = $request->_cur_country_id ?? 0;
        $data->_cur_division_id       = $request->_cur_division_id ?? 0;
        $data->_cur_district_id       = $request->_cur_district_id ?? 0;
        $data->_cur_thana_id       = $request->_cur_thana_id ?? 0;
        $data->_cur_union_id       = $request->_cur_union_id ?? 0;
        $data->_cur_post_office       = $request->_cur_post_office ?? 0;
        $data->_present_address       = $request->_present_address ?? 0;

        $data->_per_country_id       = $request->_per_country_id ?? 0;
        $data->_per_division_id       = $request->_per_division_id ?? 0;
        $data->_per_district_id       = $request->_per_district_id ?? 0;
        $data->_per_thana_id       = $request->_per_thana_id ?? 0;
        $data->_per_union_id       = $request->_per_union_id ?? 0;
        $data->_per_post_office       = $request->_per_post_office ?? 0;

        $data->_parmanent_address       = $request->_parmanent_address ?? '';

        $data->_father_name_bangla       = $request->_father_name_bangla ?? '';
        $data->_father_name_english       = $request->_father_name_english ?? '';
        $data->_occupation       = $request->_occupation ?? '';
        $data->_annual_income       = $request->_annual_income ?? '';
        $data->_f_mobile_no       = $request->_f_mobile_no ?? '';
        $data->_f_nid_no       = $request->_f_nid_no ?? '';
        $data->_f_email       = $request->_f_email ?? '';

        $data->_mother_name_english       = $request->_mother_name_english ?? '';
        $data->_mother_name_of_bangla       = $request->_mother_name_of_bangla ?? '';
        $data->_mother_occupation       = $request->_mother_occupation ?? '';
        $data->_mother_anual_income       = $request->_mother_anual_income ?? '';
        $data->_mother_nid_no       = $request->_mother_nid_no ?? '';
        $data->_mother_email       = $request->_mother_email ?? '';
        $data->_mother_mobile_no       = $request->_mother_mobile_no ?? '';

        $data->_local_guardian_name       = $request->_local_guardian_name ?? '';
        $data->_local_guardian_occupation       = $request->_local_guardian_occupation ?? '';
        $data->_local_guardian_address       = $request->_local_guardian_address ?? '';
        $data->_local_guardian_mobile       = $request->_local_guardian_mobile ?? '';
        $data->_local_guardian_nid       = $request->_local_guardian_nid ?? '';
        $data->_local_guardian_nid_image       = $request->_local_guardian_nid_image ?? '';

        $data->_previous_institute_name       = $request->_previous_institute_name ?? '';
        $data->_pre_class       = $request->_pre_class ?? '';
        $data->_pre_result       = $request->_pre_result ?? '';
        $data->_pre_roll_no       = $request->_pre_roll_no ?? '';

         if ($request->hasFile('_student_image')) {
            $_student_image = student_image_upload($request->file('_student_image'));
            $data->_student_image  = $_student_image;

        }
        if ($request->hasFile('_father_nid_image')) {
            $_father_nid_image = student_image_upload($request->file('_father_nid_image'));
            $data->_father_nid_image  = $_father_nid_image;
        }
        if ($request->hasFile('_mother_nid_image')) {
            $_mother_nid_image = student_image_upload($request->file('_mother_nid_image'));
            $data->_mother_nid_image  = $_mother_nid_image;
        }
        
        if ($request->hasFile('_birth_certificate')) {
            $_birth_certificate = student_image_upload($request->file('_birth_certificate'));
            $data->_birth_certificate  = $_birth_certificate;
        }
        if ($request->hasFile('_transfer_certificate')) {
            $_transfer_certificate = student_image_upload($request->file('_transfer_certificate'));
            $data->_transfer_certificate  = $_transfer_certificate;
        }
        
        if ($request->hasFile('_testimonial')) {
            $_testimonial = student_image_upload($request->file('_testimonial'));
            $data->_testimonial  = $_testimonial;
        }
        

        if ($request->hasFile('_academic_certificate')) {
            $_academic_certificate = student_image_upload($request->file('_academic_certificate'));
            $data->_academic_certificate  = $_academic_certificate;
        }
        

        if ($request->hasFile('_marksheet')) {
            $_marksheet = student_image_upload($request->file('_marksheet'));
            $data->_marksheet  = $_marksheet;
        }

        $data->_detail    = $request->_detail ?? '';
        $data->_status    = $request->_status ?? 1;
        $data->save();

        $id = $data->id;
        $_student_id = $data->id;

        // if($request->id==''){
        //     $StmDivisionClassStudent = new StmDivisionClassStudent();
        //     $StmDivisionClassStudent->_roll_no              = $request->_roll_no ?? '';
        //     $StmDivisionClassStudent->_main_subjects        = $_main_subjects ?? '';
        //     $StmDivisionClassStudent->_optional_subjects    = $_optional_subjects ?? '';
        //     $StmDivisionClassStudent->_admission_date       = $request->_admission_date ?? '';
        //     $StmDivisionClassStudent->_student_id           = $id;
        //     $StmDivisionClassStudent->_session              = $request->_admission_session_id ?? '';
        //     $StmDivisionClassStudent->_division_id          = $request->_education_type ?? '';
        //     $StmDivisionClassStudent->_class_id             = $request->_admission_class_id ?? '';
        //     $StmDivisionClassStudent->_admission_fee        = $request->_adminssion_fee_amount ?? 0;
        //     $StmDivisionClassStudent->_tution_fee           = $request->_monthly_fee ?? 0;
        //     $StmDivisionClassStudent->_status               =1;
        //     $StmDivisionClassStudent->save();
        // }else{

        

            StmDivisionClassStudent::where('_student_id',$_student_id)->update(['_status'=>0]);

          //  return $request->all();

            $division_class_student_ids = $request->division_class_student_id ?? [];
            $_division_ids = $request->_division_id ?? [];
            $_class_ids = $request->_class_id ?? [];
             $_dsc_roll_nos = $request->_dsc_roll_no ?? [];
            $_admission_fees = $request->_admission_fee ?? [];
            $_tution_fees = $request->_tution_fee ?? [];
            $_exam_fees = $request->_exam_fee ?? [];
            $_monthly_food_fees = $request->_monthly_food_fee ?? [];
            $_residential_fees = $request->_residential_fee ?? [];
            $_std_session_ids = $request->_std_session_id ?? [];
            $_statuss = $request->_detail_status ?? [];

            if(sizeof($division_class_student_ids) > 0){
                foreach($division_class_student_ids as $k=>$division_class_student_id){


               
                   $division_class_student_id = $division_class_student_ids[$k] ?? 0;
                   $div_id = $_division_ids[$k] ?? 0;
                   $_cls_id = $_class_ids[$k] ?? 0;
                   $rol_id = $_dsc_roll_nos[$k] ?? 0;
                   $_add_fee = $_admission_fees[$k] ?? 0;
                   $_tu_fee = $_tution_fees[$k] ?? 0;
                   $exam_fee = $_exam_fees[$k] ?? 0;
                   $montly_fee = $_monthly_food_fees[$k] ?? 0;
                   $resedent_fee = $_residential_fees[$k] ?? 0;
                   $_std_session_id = $_std_session_ids[$k] ?? 0;

                   $StmDivisionClassStudent = StmDivisionClassStudent::find($division_class_student_id);
                   if(empty($StmDivisionClassStudent)){
                        $StmDivisionClassStudent = new StmDivisionClassStudent();
                        $StmDivisionClassStudent->_created_by = $auth_user->id;
                   }else{
                    $StmDivisionClassStudent->_updated_by = $auth_user->id;
                   }
                    $StmDivisionClassStudent->_student_id = $_student_id;
                    $StmDivisionClassStudent->_session = $_std_session_id;
                    $StmDivisionClassStudent->_division_id = $div_id;
                    $StmDivisionClassStudent->_class_id = $_cls_id;
                    $StmDivisionClassStudent->_roll_no = $rol_id;
                    $StmDivisionClassStudent->_admission_fee = $_add_fee;
                    $StmDivisionClassStudent->_tution_fee = $_tu_fee;
                    $StmDivisionClassStudent->_exam_fee = $exam_fee;
                    $StmDivisionClassStudent->_monthly_food_fee = $montly_fee;
                    $StmDivisionClassStudent->_residential_fee = $resedent_fee;
                    $StmDivisionClassStudent->_status = $_statuss[$k] ?? 1;
                    $StmDivisionClassStudent->save();

                    //return $StmDivisionClassStudent;

                }
            }

//return $request->all();

     //   }

//         _admission_session_id
// _education_type
// _admission_class_id
// _adminssion_fee_amount
// _monthly_fee
// _roll_no



        if($request->id ==''){
             $StudentClassSubject =  StudentClassSubject::where('_student_id',$id)
                                ->where('_division_id',$request->_education_type)
                                ->where('_class_id',$request->_admission_class_id)
                                ->where('_roll_no',$request->_roll_no)
                                ->where('_session',$request->_admission_session_id)->first();
        if(empty($StudentClassSubject)){
            $StudentClassSubject                    = new StudentClassSubject();
            $StudentClassSubject->_created_by       = $auth_user->id;
            
        }else{
             $StudentClassSubject->_updated_by       = $auth_user->id;
        }
            $StudentClassSubject->_student_id       = $id;
            $StudentClassSubject->_session      = $request->_admission_session_id;
            $StudentClassSubject->_division_id  = $request->_education_type;
            $StudentClassSubject->_class_id     = $request->_admission_class_id;
            $StudentClassSubject->_roll_no      = $request->_roll_no;
            $StudentClassSubject->_admission_fee= $request->_adminssion_fee_amount ?? 0;
            $StudentClassSubject->_tution_fee   = $request->_monthly_fee ?? 0;
            $StudentClassSubject->_status       = $request->_status ?? 1;
            $StudentClassSubject->_promoted     = $request->_promoted ?? 0;
            $StudentClassSubject->_lock       = $request->_lock ?? 1;
            $StudentClassSubject->_lock       = $request->_lock ?? 1;
            $StudentClassSubject->save();
        }



        //Make a Voucher For Addmission Fee When Student Information Is Collected
      







        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StmStudent  $StmStudent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = StmStudent::with(['_edu_class','_edu_division','_edu_session','_per_division','_cur_division','_per_district','_cur_district','_per_thana','_cur_thana','_per_union','_cur_union','_per_country','_cur_country'])->find($id);
        $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
        $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
        $counteries = Country::get();
        $loc_divisions = Division::orderBy('name','asc')->get();
        $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();
         $subjects = \DB::table('stm_subjects')->orderBy('id','ASC')->get();
        return view('stm.stm_students.show',compact('page_name','data','edu_class','edu_types','counteries','loc_divisions','stm_education_sessions','subjects'));
    }


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StmStudent  $StmStudent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = StmStudent::with(['_division_class_student'])->find($id);

        $page_name = $this->page_name;

        $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
        $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
        $counteries = Country::get();
        $loc_divisions = Division::orderBy('name','asc')->get();
        $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();
        
        $subjects = \DB::table('stm_subjects')->orderBy('id','ASC')->get();
         $account_groups = \DB::table('account_groups')->whereIn('id',_student_group_array())->get();


        return view('stm.stm_students.create',compact('page_name','edu_class','edu_types','counteries','loc_divisions','stm_education_sessions','data','subjects','account_groups'));


        
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StmStudent  $StmStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        
         return redirect()->route('stm_students.index')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StmStudent  $StmStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check_data = \DB::table('stm_division_class_students')->where('_session',$id)->first();
        if(!empty($check_data)){
            StmStudent::find($id)->delete();
            return redirect()->route('stm_students.index')->with('success','Information deleted successfully');
        }else{
              return redirect()->route('stm_students.index')->with('danger','You Can not delete this Information');
        }
    }
}
