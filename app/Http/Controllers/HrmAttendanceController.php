<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HRM\HrmAttendance;
use App\Models\HRM\HrmEmployees;
use App\Models\AccountLedger;
use Auth;
use Session;
use DB;

class HrmAttendanceController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:hrm-attandance-list|hrm-attandance-create|hrm-attandance-edit|hrm-attandance-delete', ['only' => ['index','store']]);
         $this->middleware('permission:hrm-attandance-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-attandance-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-attandance-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.hrm-attandance');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         $auth_user = Auth::user();
       // return $request->all();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_u_limit', $request->limit);
        } else {
             $limit= Session::get('_u_limit') ??  default_pagination();
            
        }

        $page_name = $this->page_name;
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = HrmAttendance::with(['_employee_info'])->where('_is_delete',0);
        
        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->whereIn('organization_id',$request->organization_id);
        }else{
           $datas = $datas->whereIn('organization_id',explode(',',$auth_user->organization_ids)); 
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->whereIn('_branch_id',$request->_branch_id);
        }else{
           $datas = $datas->whereIn('_branch_id',explode(',',$auth_user->branch_ids)); 
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->whereIn('_cost_center_id',$request->_cost_center_id);
        }else{
           $datas = $datas->whereIn('_cost_center_id',explode(',',$auth_user->cost_center_ids)); 
        }

        
        // if($auth_user->user_type !='admin'){
        //         $datas = $datas->where('_user_id',$auth_user->id);   
        // } 

        if($request->has('_number') && $request->_number !=''){
            $datas = $datas->where('_number','like',"%$request->_number%");
        }
        if($request->has('_type') && $request->_type !=''){
            $datas = $datas->where('_type','like',"%$request->_type%");
        }
        if($request->has('_datetime') && $request->_datetime !=''){
            $datas = $datas->where('_datetime','like',"%$request->_datetime%");
        }
         $datas = $datas->orderBy($asc_cloumn,$_asc_desc);
         if($limit =='all'){
            $datas = $datas->paginate($all_row);
         }else{
            $datas = $datas->paginate($limit);
         }

         //return $datas;

         return view('hrm.attandance.index',compact('page_name','datas','request'));
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name=$this->page_name;
        return view('hrm.attandance.create',compact('page_name'));
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
        
        $count_number_of_entry=HrmAttendance::where('_employee_id',$request->_employee_id)->count();
        $_type=1;
        if($count_number_of_entry ==0){
            $_type=1;
        }else{
            if($count_number_of_entry  % 2 == 0){ // echo "Even";  
                $_type=1;
                } else{ // echo "Odd";
                    $_type=2;
                }
        }
        $employee = AccountLedger::find($request->_employee_id);
        $organization_id = $employee->organization_id ?? 1;
        $_branch_id = $employee->_branch_id ?? 1;
        $_cost_center_id = $employee->_cost_center_id ?? 1;
        DB::beginTransaction();
       try {
        $auth_user = Auth::user();

        


        $master_data = new HrmAttendance();
        $master_data->_employee_id = $request->_employee_id ?? 0;
        $master_data->_emp_id = $request->_employee_id_text ?? '';
        $master_data->_employee = $request->_employee_id ?? 0;
        $master_data->organization_id = $organization_id;
        $master_data->_cost_center_id = $_cost_center_id;
        $master_data->_branch_id = $_branch_id;
        $master_data->_number = $count_number_of_entry;
        $master_data->_type =  $_type ?? 1;
        $master_data->_datetime = $request->_datetime ?? date('d-m-Y h:i:s');
        $master_data->in_time = $request->in_time ?? date('h:i:s');
        $master_data->out_time = $request->out_time ?? date('h:i:s');
        $master_data->remarks = $request->remarks ?? '';
        $master_data->_user_id =$auth_user->id ?? 0;
        $master_data->save();
      
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $page_name=$this->page_name;
        $data = HrmAttendance::with(['_employee_info'])->find($id);
        return view('hrm.attandance.edit',compact('page_name','data'));
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
        
      //return $request->all();

        DB::beginTransaction();
       try {
        $auth_user = Auth::user();

        $employee = AccountLedger::find($request->_employee_id);
        $organization_id = $employee->organization_id ?? 1;
        $_branch_id = $employee->_branch_id ?? 1;
        $_cost_center_id = $employee->_cost_center_id ?? 1;

        $master_data = HrmAttendance::find($id);
        $master_data->_employee_id = $employee->id ?? '';
        $master_data->_emp_id = $request->_employee_id_text ?? '';
        $master_data->organization_id = $organization_id;
        $master_data->_cost_center_id = $_cost_center_id;
        $master_data->_branch_id = $_branch_id;
        $master_data->_type = $request->_type ?? 1;
        $master_data->_datetime = $request->_datetime ?? date('d-m-Y h:i:s');
        $master_data->in_time = $request->in_time ?? date('h:i:s');
        $master_data->out_time = $request->out_time ?? date('h:i:s');
        $master_data->remarks = $request->remarks ?? '';
        $master_data->updated_at = date('d-m-Y h:i:s');
        $master_data->_updated_by = $auth_user->id ?? 0;
        $master_data->save();
      
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
        HrmAttendance::where('id',$id)->update(['_is_delete'=>1]);
        return redirect()->back()
                        ->with('success','Information save successfully');
    }
}
