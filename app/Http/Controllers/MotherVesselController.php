<?php

namespace App\Http\Controllers;

use App\Models\MotherVessel;
use Illuminate\Http\Request;
use Session;
use Auth;

class MotherVesselController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:mother-vessel-info-list|mother-vessel-info-create|mother-vessel-info-edit|mother-vessel-info-delete', ['only' => ['index','store']]);
         $this->middleware('permission:mother-vessel-info-create', ['only' => ['create','store']]);
         $this->middleware('permission:mother-vessel-info-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:mother-vessel-info-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.mother-vessel-info');
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

        $datas = MotherVessel::where('is_delete',0);
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
                return view('backend.mother-vessel-info.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.mother-vessel-info.index',compact('datas','request',
            'page_name','limit'));

    }



    public function reset(){
        Session::flash('_vessel_limit');
       return  \Redirect::to('mother-vessel-info?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.mother-vessel-info.create',compact('page_name'));
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
            '_name' => 'required|unique:mother_vessels,_name',
        ]);
        $values = $request->except('_token');
        MotherVessel::create($values);
        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MotherVessel  $MotherVessel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = MotherVessel::find($id);
        return view('backend.mother-vessel-info.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MotherVessel  $MotherVessel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = MotherVessel::find($id);
        return view('backend.mother-vessel-info.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MotherVessel  $MotherVessel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

         $this->validate($request, [
            '_name' => 'required|unique:mother_vessels,_name,'.$id,
        ]);

        $values = $request->except(['_token','_method']);
        MotherVessel::where('id',$id)->update($values);


        return redirect('mother-vessel-info')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MotherVessel  $MotherVessel
     * @return \Illuminate\Http\Response
     */
    public function destroy(MotherVessel $MotherVessel)
    {
        MotherVessel::find($id)->update(['is_delete'=>0]);
        return redirect()->route('mother-vessel-info.index')
                        ->with('danger','Information deleted successfully');
    }
}
