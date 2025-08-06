<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmJobtitle;
use Illuminate\Http\Request;
use Auth;
use Session;

class HrmJobtitleController extends Controller
{
    function __construct()
    {
        
         $this->middleware('permission:hrm-designation-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-designation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-designation-list', ['only' => ['index']]);
         $this->middleware('permission:hrm-designation-delete', ['only' => ['destroy']]);
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
         $datas = HrmJobtitle::orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.hrm-emp-category.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.hrm-emp-category.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
       
        return view('hrm.hrm-emp-category.create',compact('page_name'));
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
            $data = new HrmJobtitle();
            $data->_name =$request->_name ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-emp-category')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmJobtitle  $HrmJobtitle
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmJobtitle::find($id);

        return view('hrm.hrm-emp-category.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmJobtitle  $HrmJobtitle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmJobtitle::find($id);
        

        return view('hrm.hrm-emp-category.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmJobtitle  $HrmJobtitle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_name' => 'required',
           
        ]);

        try {
            $_user = Auth::user();
            $data =  HrmJobtitle::find($id);
             $data->_name =$request->_name ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-emp-category')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmJobtitle  $HrmJobtitle
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        HrmJobtitle::find($id)->delete();
        return redirect('hrm-emp-category')->with('success','Information deleted successfully');
    }
}
