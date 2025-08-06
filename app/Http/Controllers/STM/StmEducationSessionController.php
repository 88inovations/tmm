<?php

namespace App\Http\Controllers\STM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STM\StmEducationSession;
use Auth;
use Session;

class StmEducationSessionController extends Controller
{
    
     function __construct()
    {
         $this->middleware('permission:stm_education_sessions_list|stm_education_sessions_create|stm_education_sessions_edit|stm_education_sessions_delete', ['only' => ['index','store']]);
         $this->middleware('permission:stm_education_sessions_create', ['only' => ['create','store']]);
         $this->middleware('permission:stm_education_sessions_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stm_education_sessions_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.stm_education_sessions');
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $datas = StmEducationSession::where('_status','!=',"");
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_address') && $request->_address !=''){
            $datas = $datas->where('_address','like',"%$request->_address%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_phone') && $request->_phone !=''){
            $datas = $datas->where('_phone','like',"%$request->_phone%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
          if($request->has('print')){
            if($request->print =="detail"){
                return view('stm.stm_education_sessions.print',compact('datas','page_name','request'));
            }
         }


        return view('stm.stm_education_sessions.index',compact('datas','request','page_name'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_name = $this->page_name;
        return view('stm.stm_education_sessions.create',compact('request','page_name'));
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
                '_name' => 'required|max:255|unique:stm_education_sessions,_name',
            ]);

    $auth_user = Auth::user();
        

        $data = new StmEducationSession();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_detail    = $request->_detail ?? '';
        $data->_status     = $request->_status ?? 0;
        $data->_user_name  =$auth_user->name;
        $data->_user_id     = $auth_user->id;
        $data->save();



        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StmEducationSession  $StmEducationSession
     * @return \Illuminate\Http\Response
     */
    public function show(StmEducationSession $StmEducationSession)
    {
        $page_name = $this->page_name;
        $data = $StmEducationSession;
        return view('stm.stm_education_sessions.show',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StmEducationSession  $StmEducationSession
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = StmEducationSession::find($id);
        
        return view('stm.stm_education_sessions.edit',compact('page_name','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StmEducationSession  $StmEducationSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $auth_user = Auth::user();

        $request->validate([
                '_name' => 'required|max:255|unique:stm_education_sessions,_name,'.$request->id,
            ]);
        $data = StmEducationSession::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_detail    = $request->_detail ?? '';
        $data->_status     = $request->_status ?? 0;
        $data->_user_name  =$auth_user->name;
        $data->_user_id     = $auth_user->id;
        $data->save();
         return redirect()->route('stm_education_sessions.index')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StmEducationSession  $StmEducationSession
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check_data = \DB::table('stm_division_class_students')->where('_session',$id)->first();
        if(!empty($check_data)){
            StmEducationSession::find($id)->delete();
            return redirect()->route('stm_education_sessions.index')->with('success','Information deleted successfully');
        }else{
               return redirect()->route('stm_education_sessions.index')->with('danger','You Can not delete this Information');
        }
    }
}
