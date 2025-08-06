<?php

namespace App\Http\Controllers;

use App\Models\TaDaSetup;
use Illuminate\Http\Request;
use Auth;
use DB;

class TaDaSetupController extends Controller
{
     function __construct()
    {
         // $this->middleware('permission:ta_da_setups-list|ta_da_setups-create|ta_da_setups-edit|ta_da_setups-delete|ta_da_setups-print', ['only' => ['index','store']]);
         // $this->middleware('permission:ta_da_setups-print', ['only' => ['ta_da_setupsPrint']]);
         // $this->middleware('permission:ta_da_setups-create', ['only' => ['create','store']]);
         // $this->middleware('permission:ta_da_setups-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:ta_da_setups-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.ta_da_setups');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_ta_da_limit', $request->limit);
        }else{
             $limit= \Session::get('_ta_da_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = TaDaSetup::with(['_organization'])->where('_status',1);
       

        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        
        if($request->has('_year') && $request->_year !=''){
            $datas = $datas->where('_year','like',"%$request->_year%");
        }
        

       
       
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
        
          $users = Auth::user();
       
        
        

        return view('backend.ta_da_setups.index',compact('datas','page_name','request','limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       

        return view('backend.ta_da_setups.create',compact('page_name','permited_organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
//return $request->all();

         $request->validate([
                'organization_id' => 'required',
                '_fescal_year' => 'required',
            ]);

          $users = Auth::user();

        DB::beginTransaction();
        try {

         $TaDaSetup = new TaDaSetup();
         $TaDaSetup->organization_id   = $request->organization_id ?? 1;
         $TaDaSetup->_fescal_year      = $request->_fescal_year ?? '';
         $TaDaSetup->_sloat_min        = $request->_sloat_min ?? 0;
         $TaDaSetup->_sloat_max        = $request->_sloat_max ?? 0;
         $TaDaSetup->_type             = $request->_type ?? 0;
         $TaDaSetup->_ta_rate          = $request->_ta_rate ?? 0;
         $TaDaSetup->_fixed_amount     = $request->_fixed_amount ?? 0;
         $TaDaSetup->_status           = $request->_status ?? 1;
         $TaDaSetup->_is_delete        = $request->_is_delete ?? 0;
         $TaDaSetup->_created_by       = $users->id ?? 0;
         $TaDaSetup->save();

         

       //  return $request->all();

              DB::commit();
            return redirect()->back()->with('success','Information Save successfully');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }

       



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaDaSetup  $TaDaSetup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TaDaSetup::with(['_organization'])->where('id',$id)->first();
          $users = Auth::user();
        $page_name = $this->page_name;
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       

        return view('backend.ta_da_setups.show',compact('page_name','permited_organizations','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaDaSetup  $TaDaSetup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $data = TaDaSetup::where('id',$id)->first();
          $users = Auth::user();
        $page_name = $this->page_name;
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
      

        return view('backend.ta_da_setups.edit',compact('page_name','permited_organizations','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaDaSetup  $TaDaSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


         $request->validate([
                'organization_id' => 'required',
                '_fescal_year' => 'required',
            ]);

          $users = Auth::user();

        DB::beginTransaction();
        try {

         $TaDaSetup =  TaDaSetup::find($id);
        $TaDaSetup->organization_id   = $request->organization_id ?? 1;
         $TaDaSetup->_fescal_year      = $request->_fescal_year ?? '';
         $TaDaSetup->_sloat_min        = $request->_sloat_min ?? 0;
         $TaDaSetup->_sloat_max        = $request->_sloat_max ?? 0;
         $TaDaSetup->_type             = $request->_type ?? 0;
         $TaDaSetup->_ta_rate          = $request->_ta_rate ?? 0;
         $TaDaSetup->_fixed_amount     = $request->_fixed_amount ?? 0;
         $TaDaSetup->_status           = $request->_status ?? 1;
         $TaDaSetup->_is_delete        = $request->_is_delete ?? 0;
         $TaDaSetup->_created_by       = $users->id ?? 0;
         $TaDaSetup->save();

       //  return $request->all();

              DB::commit();
            return redirect()->back()->with('success','Information Save successfully');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaDaSetup  $TaDaSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Zone::find($id)->delete();
        return redirect('ta_da_setups')->with('success','Information deleted successfully');
    }
}
