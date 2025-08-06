<?php

namespace App\Http\Controllers\STM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STM\StmSubject;
use Auth;
use Session;

class StmSubjectController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:stm_subjects_list|stm_subjects_create|stm_subjects_edit|stm_subjects_delete', ['only' => ['index','store']]);
         $this->middleware('permission:stm_subjects_create', ['only' => ['create','store']]);
         $this->middleware('permission:stm_subjects_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stm_subjects_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.stm_subjects');
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = $request->limit ?? 20;
        $_order_cloumn=$request->_order_cloumn ?? 'id';
        $_asc_des=$request->_asc_des ?? 'DESC';
        
        $datas = StmSubject::where('_name','!=',"");
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status',$request->_status);
        }
        

         $datas = $datas->orderBy($_order_cloumn,$_asc_des)->paginate($limit);
         $page_name = $this->page_name;
          if($request->has('print')){
            if($request->print =="detail"){
                return view('stm.stm_subjects.print',compact('datas','page_name','request'));
            }
         }


        return view('stm.stm_subjects.index',compact('datas','request','page_name'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_name = $this->page_name;
        return view('stm.stm_subjects.create',compact('request','page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
                '_name' => 'required|max:255|unique:stm_subjects,_name',
            ]);

    $auth_user = Auth::user();
        

        $data = new StmSubject();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? 0;
        $data->_user_name  =$auth_user->name;
        $data->_user_id     = $auth_user->id;
        $data->save();



        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StmSubject  $StmSubject
     * @return \Illuminate\Http\Response
     */
    public function show(StmSubject $StmSubject)
    {
        $page_name = $this->page_name;
        $data = $StmSubject;
        return view('stm.stm_subjects.show',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StmSubject  $StmSubject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = StmSubject::find($id);
        
        return view('stm.stm_subjects.edit',compact('page_name','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StmSubject  $StmSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $auth_user = Auth::user();

        $request->validate([
                '_name' => 'required|max:255|unique:stm_subjects,_name,'.$request->id,
            ]);
        $data = StmSubject::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? 1;
        $data->_user_name  =$auth_user->name;
        $data->_user_id     = $auth_user->id;
        $data->save();
         return redirect()->route('stm_subjects.index')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StmSubject  $StmSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            StmSubject::where('id',$id)->update(['_status'=>0]);
            return redirect()->route('stm_subjects.index')->with('success','Information deleted successfully');
        
    }
}
