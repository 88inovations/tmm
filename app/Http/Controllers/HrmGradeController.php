<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmGrade;
use Illuminate\Http\Request;
use Auth;
use Session;

class HrmGradeController extends Controller
{
    function __construct()
    {
        
         $this->middleware('permission:hrm-grade-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-grade-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-grade-list', ['only' => ['index']]);
         $this->middleware('permission:hrm-grade-delete', ['only' => ['destroy']]);
         $this->page_name = "Grade";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $page_name = $this->page_name;
         $datas = HrmGrade::orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.hrm-grade.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.hrm-grade.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
       
        return view('hrm.hrm-grade.create',compact('page_name'));
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
            '_grade' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data = new HrmGrade();
            $data->_grade =$request->_grade ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-grade')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmGrade  $HrmGrade
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmGrade::find($id);

        return view('hrm.hrm-grade.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmGrade  $HrmGrade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmGrade::find($id);
        

        return view('hrm.hrm-grade.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmGrade  $HrmGrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_grade' => 'required',
           
        ]);

        try {
            $_user = Auth::user();
            $data =  HrmGrade::find($id);
             $data->_grade =$request->_grade ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-grade')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmGrade  $HrmGrade
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        HrmGrade::find($id)->delete();
        return redirect('hrm-grade')->with('success','Information deleted successfully');
    }
}
