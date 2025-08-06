<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmEmpLocation;
use Illuminate\Http\Request;
use Auth;

class HrmEmpLocationController extends Controller
{
    function __construct()
    {
        
         $this->middleware('permission:hrm-emp-location-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-emp-location-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-emp-location-list', ['only' => ['index']]);
         $this->middleware('permission:hrm-emp-location-delete', ['only' => ['destroy']]);
         $this->page_name = "Employee Location";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {

        
        $page_name = $this->page_name;
         $datas = HrmEmpLocation::orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.hrm-emp-location.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.hrm-emp-location.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
       
        return view('hrm.hrm-emp-location.create',compact('page_name'));
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
            '_name' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data = new HrmEmpLocation();
            $data->_name =$request->_name ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-emp-location')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmEmpLocation  $HrmEmpLocation
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmEmpLocation::find($id);

        return view('hrm.hrm-emp-location.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmEmpLocation  $HrmEmpLocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmEmpLocation::find($id);
        

        return view('hrm.hrm-emp-location.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmEmpLocation  $HrmEmpLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_name' => 'required',
           
        ]);

        try {
            $_user = Auth::user();
            $data =  HrmEmpLocation::find($id);
             $data->_name =$request->_name ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-emp-location')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmEmpLocation  $HrmEmpLocation
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        HrmEmpLocation::find($id)->delete();
        return redirect('hrm-emp-location')->with('success','Information deleted successfully');
    }
}
