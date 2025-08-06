<?php

namespace App\Http\Controllers;

use App\Models\VesselInfo;
use Illuminate\Http\Request;
use Session;
use Auth;

class VesselInfoController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:vessel-info-list|vessel-info-create|vessel-info-edit|vessel-info-delete', ['only' => ['index','store']]);
         $this->middleware('permission:vessel-info-create', ['only' => ['create','store']]);
         $this->middleware('permission:vessel-info-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:vessel-info-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.vessel-info');
    }

    public function index(Request $request)
    {
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_vessel_limit', $request->limit);
        }else{
             $limit= Session::get('_vessel_limit') ??  default_pagination();
            
        }
       
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = VesselInfo::where('is_delete',0);
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_license_no') && $request->_license_no !=''){
            $datas = $datas->where('_license_no','like',"%$request->_license_no%");
        }
        if($request->has('_country_name') && $request->_country_name !=''){
            $datas = $datas->where('_country_name','like',"%$request->_country_name%");
        }
        if($request->has('_type') && $request->_type !=''){
            $datas = $datas->where('_type','like',"%$request->_type%");
        }
        if($request->has('_route') && $request->_route !=''){
            $datas = $datas->where('_route','like',"%$request->_route%");
        }
        if($request->has('_owner_name') && $request->_owner_name !=''){
            $datas = $datas->where('_owner_name','like',"%$request->_owner_name%");
        }
        if($request->has('_contact_one') && $request->_contact_one !=''){
            $datas = $datas->where('_contact_one','like',"%$request->_contact_one%");
        }
        if($request->has('_contact_two') && $request->_contact_two !=''){
            $datas = $datas->where('_contact_two','like',"%$request->_contact_two%");
        }
        if($request->has('_contact_three') && $request->_contact_three !=''){
            $datas = $datas->where('_contact_three','like',"%$request->_contact_three%");
        }
        if($request->has('_capacity') && $request->_capacity !=''){
            $datas = $datas->where('_capacity','like',"%$request->_capacity%");
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status',$request->_status);
        }
      

         $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
         
         $page_name = $this->page_name;
        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.vessel-info.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.vessel-info.index',compact('datas','request',
            'page_name','limit'));

    }



    public function reset(){
        Session::flash('_vessel_limit');
       return  \Redirect::to('vessel-info?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.vessel-info.create',compact('page_name'));
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
            '_name' => 'required|unique:vessel_infos,_name',
        ]);
        $values = $request->except('_token');
        VesselInfo::create($values);
        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VesselInfo  $VesselInfo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = VesselInfo::find($id);
        return view('backend.vessel-info.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VesselInfo  $VesselInfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = VesselInfo::find($id);
        return view('backend.vessel-info.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VesselInfo  $VesselInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->validate($request, [
            '_name' => 'required|unique:vessel_infos,_name,'.$id,
        ]);

        $values = $request->except(['_token','_method']);
        VesselInfo::where('id',$id)->update($values);


        return redirect('vessel-info')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VesselInfo  $VesselInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(VesselInfo $VesselInfo)
    {
        VesselInfo::find($id)->update(['is_delete'=>0]);
        return redirect()->route('vessel-info.index')
                        ->with('danger','Information deleted successfully');
    }
}
