<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Auth;
use Session;

class ZoneController extends Controller
{
   function __construct()
    {
        
         $this->middleware('permission:zones-create', ['only' => ['create','store']]);
         $this->middleware('permission:zones-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:zones-list', ['only' => ['index']]);
         $this->middleware('permission:zones-delete', ['only' => ['destroy']]);
         $this->page_name = "Zone";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {

        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_zone_limit', $request->limit);
        }else{
             $limit= \Session::get('_zone_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $page_name = $this->page_name;
         $datas = Zone::with(['_organization','_master_branch','_entry_by']);
         if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
         if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id',$request->organization_id);
        }
        if($request->has('_brand_id') && $request->_brand_id !=''){
            $datas = $datas->where('_brand_id',$request->_brand_id);
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status',$request->_status);
        }
         $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.zones.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.zones.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       
        return view('hrm.zones.create',compact('page_name','permited_organizations','permited_branch'));
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
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_name' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data = new Zone();
            $data->organization_id =$request->organization_id ?? '';
            $data->_branch_id =$request->_branch_id ?? '';
            $data->_name =$request->_name ?? '';
            $data->_detail =$request->_detail ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user_id= $_user->id;
            $data->save();
            return redirect('zones')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = Zone::with(['_organization','_master_branch','_entry_by'])->find($id);

        return view('hrm.zones.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = Zone::find($id);
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       
        return view('hrm.zones.edit',compact('page_name','permited_organizations','permited_branch','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_name' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data =  Zone::find($id);
             $data->organization_id =$request->organization_id ?? '';
            $data->_branch_id =$request->_branch_id ?? '';
            $data->_name =$request->_name ?? '';
            $data->_detail =$request->_detail ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user_id= $_user->id;
            $data->save();
            return redirect('zones')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        Zone::find($id)->delete();
        return redirect('zones')->with('success','Information deleted successfully');
    }
}
