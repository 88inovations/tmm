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

class StudentModuleSetupController extends Controller
{
    //

    function __construct()
    {
        
         $this->middleware('permission:stm_income_ledger_setups', ['only' => ['stm_income_ledger_setups']]);
         $this->middleware('permission:stm_division_class_students', ['only' => ['stm_division_class_students']]);
         
    }


    public function stm_division_class_students(Request $request){

         $page_name = __('label.stm_division_class_students');
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas =[];

        if($request->has('search')){



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
}

        $edu_class = StmClass::where('_status',1)->orderBy('_name','ASC')->get();
        $edu_types = StmDivision::where('_status',1)->orderBy('_name','ASC')->get();
        $stm_education_sessions = \DB::table('stm_education_sessions')->orderBy('_name','DESC')->get();
            






        return view('stm.stm_division_class_students.index',compact('page_name','datas','edu_class','edu_types','stm_education_sessions','edu_class','edu_types','stm_education_sessions','request'));
    }



/*

stm_division_class_students_store
*/

public function stm_division_class_students_store(Request $request){

   // return $request->all();

    $ids = $request->id ?? [];
    $_std_session_ids = $request->_std_session_id ?? [];
    $_division_ids = $request->_division_id ?? [];
    $_class_ids = $request->_class_id ?? [];
    $_dsc_roll_nos = $request->_dsc_roll_no ?? [];
    $_admission_fees = $request->_admission_fee ?? [];
    $_tution_fees = $request->_tution_fee ?? [];
    $_exam_fees = $request->_exam_fee ?? [];
    $_anual_fees = $request->_anual_fee ?? [];
    $_monthly_food_fees = $request->_monthly_food_fee ?? [];
    $_residential_fees = $request->_residential_fee ?? [];
    $_other_fees = $request->_other_fee ?? [];
    $_other_2_fees = $request->_other_2_fee ?? [];
    $_other_3_fees = $request->_other_3_fee ?? [];
    $_statuss = $request->_status ?? [];


    foreach($ids as $key=>$id){

       $StmDivisionClassStudent =  StmDivisionClassStudent::find($id);
       $StmDivisionClassStudent->_division_id  = $_division_ids[$key] ?? 0;
       $StmDivisionClassStudent->_class_id  = $_class_ids[$key] ?? 0;
       $StmDivisionClassStudent->_roll_no  = $_dsc_roll_nos[$key] ?? 0;
       $StmDivisionClassStudent->_session  = $_std_session_ids[$key] ?? 0;
       $StmDivisionClassStudent->_admission_fee  = $_admission_fees[$key] ?? 0;
       $StmDivisionClassStudent->_tution_fee  = $_tution_fees[$key] ?? 0;
       $StmDivisionClassStudent->_anual_fee  = $_anual_fees[$key] ?? 0;
       $StmDivisionClassStudent->_exam_fee  = $_exam_fees[$key] ?? 0;
       $StmDivisionClassStudent->_monthly_food_fee  = $_monthly_food_fees[$key] ?? 0;
       $StmDivisionClassStudent->_residential_fee  = $_residential_fees[$key] ?? 0;
       $StmDivisionClassStudent->_other_fee  = $_other_fees[$key] ?? 0;
       $StmDivisionClassStudent->_other_2_fee  = $_other_2_fees[$key] ?? 0;
       $StmDivisionClassStudent->_other_3_fee  = $_other_3_fees[$key] ?? 0;
       $StmDivisionClassStudent->_status  = $_statuss[$key] ?? 0;
       $StmDivisionClassStudent->save();

       

    }

      return redirect()->back()->with('success','Information Save successfully');

}



public function search_ledger(Request $request)
{
    $query = $request->get('q');

        $ledgers = \DB::table('account_ledgers')
            ->select('id', '_name', '_code', '_alious')
            ->where('_name', 'like', "%{$query}%")
            ->orWhere('_alious', 'like', "%{$query}%")
            ->orWhere('_code', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json($ledgers);
    }



    public function stm_income_ledger_setups(){
        $page_name = __('label.stm_income_ledger_setups');

        $ledgers = \DB::table('account_ledgers')->where('_main_account_id',3)->get();

         $editData = StmIncomeLedgerSetup::first();

        return view('stm.stm_division_class_students.stm_income_ledger_setups',compact('page_name','editData','ledgers'));
    }


    public function stm_income_ledger_setups_store(Request $request){




        $data = $request->validate([
        'id' => 'nullable|exists:stm_income_ledger_setups,id',
        '_admission_fee_ledger' => 'nullable|integer',
        '_tution_fee_ledger' => 'nullable|integer',
        '_anual_fee_ledger' => 'nullable|integer',
        '_exam_fee_ledger' => 'nullable|integer',
        '_monthly_food_fee_ledger' => 'nullable|integer',
        '_residential_fee_ledger' => 'nullable|integer',
        '_other_fee_ledger' => 'nullable|integer',
        '_other_2_fee_ledger' => 'nullable|integer',
        '_other_3_fee_ledger' => 'nullable|integer',
        '_discount_ledger' => 'nullable|integer',
    ]);

    if ($request->has('id') && $request->id) {
        // Update
        $ledger = StmIncomeLedgerSetup::find($request->id);
        $data['_updated_by'] = auth()->user()->name ?? 'system';
        $ledger->update($data);
   //return $request->all();
        return redirect()->back()->with('success', 'Ledger Setup Updated Successfully!');
        } else {
            // Insert
            $data['_created_by'] = auth()->user()->name ?? 'system';
            StmIncomeLedgerSetup::create($data);

            return redirect()->back()->with('success', 'Ledger Setup Saved Successfully!');
        }


    }




}
