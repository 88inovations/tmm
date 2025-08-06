<?php

namespace App\Http\Controllers;
use App\Models\HRM\CurrentSalaryStructure;
use App\Models\HRM\HrmPayheads;
use App\Models\HRM\CurrentSalaryMaster;
use App\Models\HRM\HrmEmpCategory;
use App\Models\HRM\HrmDepartment;
use App\Models\HRM\Designation;
use App\Models\HRM\HrmGrade;
use App\Models\HRM\HrmEmpLocation;
use App\Models\Zone;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;

class HrmCurrentSalaryStruController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:initial-salary-structure-list|initial-salary-structure-create|initial-salary-structure-edit|initial-salary-structure-delete', ['only' => ['index','store']]);
         $this->middleware('permission:initial-salary-structure-create', ['only' => ['create','store']]);
         $this->middleware('permission:initial-salary-structure-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:initial-salary-structure-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.initial-salary-structure');
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

        $datas = CurrentSalaryMaster::with(['_employee']);
        if($request->has('_emp_code') && $request->_emp_code !=''){
            $datas = $datas->where('_emp_code','like',"%$request->_emp_code%");
        }
         $datas = $datas->orderBy($asc_cloumn,$_asc_desc);
         if($limit =='all'){
            $datas = $datas->paginate($all_row);
         }else{
            $datas = $datas->paginate($limit);
         }

         return view('hrm.initial-salary-structure.index',compact('page_name','datas','request'));
         
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
//return $payheads;
        return view('hrm.initial-salary-structure.create',compact('page_name','payheads','payhead_types'));

    }




    /*
    @Title: salary_sheet
    @ Description : Monthly basic salary sheet Genate
    @ 

    */



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    public function salaryStructureSearch(Request $request){
        $employee_id = $request->employee_id ?? '';

        $data = CurrentSalaryMaster::with(['_details'])->where('_employee_id',$employee_id)->first();

        return json_encode($data);
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
            '_employee_id' => 'required',
            '_employee_id_text' => 'required'
        ]);
        $duplicate_check = CurrentSalaryMaster::where('_employee_id',$request->_employee_id)->first();
        if($duplicate_check){
            return redirect()->back()->with('success',__('Please Update Salary information'));
        }

        $_payhead_ids = $request->_payhead_id ?? [];
        $_amounts = $request->_amount ?? [];
        $_payhead_type_ids = $request->_payhead_type_id ?? [];

    DB::beginTransaction();
       try {
        $master_data = new CurrentSalaryMaster();
        $master_data->_employee_id = $request->_employee_id ?? '';
        $master_data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
        $master_data->_emp_code = $request->_employee_id_text ?? '';
        $master_data->total_earnings = $request->total_earnings ?? 0;
        $master_data->total_deduction = $request->total_deduction ?? 0;
        $master_data->net_total_earning = $request->net_total_earning ?? 0;
        $master_data->_status = $request->_status ?? 1;
        $master_data->_is_delete = $request->_is_delete ?? 0;
        $master_data->save();
        $_master_id = $master_data->id;

         $_type_wise_amounts=[];
        $basic_salary=0;


               




        if(sizeof($_payhead_ids) > 0){
            for ($i=0; $i <sizeof($_payhead_ids) ; $i++) { 
                $data = new CurrentSalaryStructure();
                $data->_master_id = $_master_id;
                $data->_employee_id = $request->_employee_id;
                $data->_emp_code = $request->_employee_id_text ?? '';
                $data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
                $data->_payhead_id = $_payhead_ids[$i] ?? 0;
                $data->_amount = $_amounts[$i] ?? 0;
                $data->_payhead_type_id = $_payhead_type_ids[$i] ?? 0;
                $data->_status = 1;
                $data->save();

                if($i==0){
                    $basic_salary=$_amounts[$i] ?? 0;
                }
                 $_type_wise_amounts[$_payhead_type_ids[$i]][]=$_amounts[$i] ?? 0;


            }
        }


$_gross_salary=array_sum($_type_wise_amounts[1]) ?? 0;
$allowances=array_sum($_type_wise_amounts[2]) ?? 0;
$deductions=array_sum($_type_wise_amounts[3]) ?? 0;

        $net_salary = $request->net_total_earning ?? 0;
        \DB::table('hrm_employees')->where('id',$request->_employee_id)
                                    ->update([
                                        'net_salary'=>$net_salary,
                                        '_gross_salary'=>$_gross_salary,
                                        'allowances'=>$allowances,
                                        'deductions'=>$deductions,
                                        'basic_salary'=>$basic_salary,
                                    ]);
      
        DB::commit();
        return redirect()->back()
                        ->with('success','Information save successfully');
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
        $page_name = $this->page_name;
         $data = CurrentSalaryMaster::with(['_details','_employee'])->find($id);
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

         return view('hrm.initial-salary-structure.show',compact('page_name','data','payheads','payhead_types'));
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
        $data = CurrentSalaryMaster::with(['_details','_employee'])->find($id);
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

         return view('hrm.initial-salary-structure.edit',compact('page_name','data','payheads','payhead_types'));
        
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
            '_employee_id' => 'required',
            '_employee_id_text' => 'required'
        ]);
       
//return $request->all();


        $_detail_row_ids = $request->_detail_row_id ?? [];
        $_payhead_ids = $request->_payhead_id ?? [];
        $_amounts = $request->_amount ?? [];
        $_payhead_type_ids = $request->_payhead_type_id ?? [];

    DB::beginTransaction();
       try {

        CurrentSalaryStructure::where('_master_id',$id)->update(['_status'=>0]);
        $master_data = CurrentSalaryMaster::find($id);
        $master_data->_employee_id = $request->_employee_id ?? '';
        $master_data->_employee_ledger_id = $request->_employee_ledger_id ?? 0;
        $master_data->_emp_code = $request->_employee_id_text ?? '';
        $master_data->total_earnings = $request->total_earnings ?? 0;
        $master_data->total_deduction = $request->total_deduction ?? 0;
        $master_data->net_total_earning = $request->net_total_earning ?? 0;
        $master_data->_status = $request->_status ?? 1;
        $master_data->_is_delete = $request->_is_delete ?? 0;
        $master_data->save();
        $_master_id = $master_data->id;

        

        $_type_wise_amounts=[];
        $basic_salary=0;

        if(sizeof($_detail_row_ids) > 0){
            for ($i=0; $i <sizeof($_detail_row_ids) ; $i++) { 
                if($_detail_row_ids[$i]==''){
                    $data = new CurrentSalaryStructure();
                }else{
                    $data = CurrentSalaryStructure::find($_detail_row_ids[$i]);
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
                if($i==0){
                    $basic_salary=$_amounts[$i] ?? 0;
                }

                $_type_wise_amounts[$_payhead_type_ids[$i]][]=$_amounts[$i] ?? 0;
            }
        }

//return $_type_wise_amounts;
$_gross_salary=array_sum($_type_wise_amounts[1]) ?? 0;
$allowances=array_sum($_type_wise_amounts[2]) ?? 0;
$deductions=array_sum($_type_wise_amounts[3]) ?? 0;

        $net_salary = $request->net_total_earning ?? 0;
        \DB::table('hrm_employees')->where('id',$request->_employee_id)
                                    ->update([
                                        'net_salary'=>$net_salary,
                                        '_gross_salary'=>$_gross_salary,
                                        'allowances'=>$allowances,
                                        'deductions'=>$deductions,
                                        'basic_salary'=>$basic_salary,
                                    ]);
      
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
