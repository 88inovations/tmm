<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmDepartment;
use Illuminate\Http\Request;
use Auth;
use Session;

class HrmDepartmentController extends Controller
{
    function __construct()
    {
        
         $this->middleware('permission:hrm-department-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-department-list', ['only' => ['index']]);
         $this->middleware('permission:hrm-department-delete', ['only' => ['destroy']]);
         $this->page_name = "Department";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $page_name = $this->page_name;
         $datas = HrmDepartment::orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.hrm-department.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.hrm-department.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
       
        return view('hrm.hrm-department.create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dump($request->all());
        // die();
         $this->validate($request, [
            '_department' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data = new HrmDepartment();
            $data->_department =$request->_department ?? '';
            $data->_details =$request->_details ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-department')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmDepartment  $HrmDepartment
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmDepartment::find($id);

        return view('hrm.hrm-department.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmDepartment  $HrmDepartment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmDepartment::find($id);
        

        return view('hrm.hrm-department.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmDepartment  $HrmDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_department' => 'required',
           
        ]);

        try {
            $_user = Auth::user();
            $data =  HrmDepartment::find($id);
             $data->_department =$request->_department ?? '';
            $data->_details =$request->_details ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-department')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmDepartment  $HrmDepartment
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        HrmDepartment::find($id)->delete();
        return redirect('hrm-department')->with('success','Information deleted successfully');
    }
}
