<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmLeavetypes;
use Illuminate\Http\Request;
use Session;
use Auth;

class HrmLeavetypesController extends Controller
{

    function __construct()
    {
        
         $this->middleware('permission:leave-type-create', ['only' => ['create','store']]);
         $this->middleware('permission:leave-type-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:leave-type-list', ['only' => ['index']]);
         $this->page_name = "Leave Type";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $page_name = $this->page_name;
         $datas = HrmLeavetypes::orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.leave-type.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.leave-type.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('hrm.leave-type.create',compact('page_name'));
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
            '_type' => 'required',
        ]);

        try {
            $_user = Auth::user();
            $data = new HrmLeavetypes();
            $data->_type =$request->_type;
            $data->_status =$request->_status ?? 0;
            $data->_number_of_days =$request->_number_of_days ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('leave-type')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmLeavetypes  $hrmLeavetypes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmLeavetypes::find($id);

        return view('hrm.leave-type.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmLeavetypes  $hrmLeavetypes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmLeavetypes::find($id);

        return view('hrm.leave-type.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmLeavetypes  $hrmLeavetypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_type' => 'required',
        ]);

        try {
            $_user = Auth::user();
            $data =  HrmLeavetypes::find($id);
            $data->_type =$request->_type;
            $data->_status =$request->_status ?? 0;
            $data->_number_of_days =$request->_number_of_days ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('leave-type')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmLeavetypes  $hrmLeavetypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HrmLeavetypes::find($id)->delete();
        return redirect('leave-type')->with('success','Information deleted successfully');
    }
}
