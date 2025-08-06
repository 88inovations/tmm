<?php

namespace App\Http\Controllers;

use App\Models\SalesCommisionPlan;
use App\Models\SalesCommisionPlanDetail;
use Illuminate\Http\Request;
use Auth;
use DB;



class SalesCommisionPlanController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:sales_commision_plans-list|sales_commision_plans-create|sales_commision_plans-edit|sales_commision_plans-delete|sales_commision_plans-print', ['only' => ['index','store']]);
         $this->middleware('permission:sales_commision_plans-print', ['only' => ['sales_commision_plansPrint']]);
         $this->middleware('permission:sales_commision_plans-create', ['only' => ['create','store']]);
         $this->middleware('permission:sales_commision_plans-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sales_commision_plans-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.sales_commision_plans');
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
            session()->put('_pur_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = SalesCommisionPlan::with(['_detail']);
       

        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        

       
       
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = [];
         $account_groups = [];
        $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
       
        
        

        return view('backend.sales_commision_plans.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit'));
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
        $transection_terms      = DB::table('transection_terms')->get();

        return view('backend.sales_commision_plans.create',compact('page_name','permited_organizations','transection_terms'));
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
                '_date' => 'required',
                '_name' => 'required|max:255',
            ]);

          $users = Auth::user();

        DB::beginTransaction();
        try {

         $SalesCommisionPlan = new SalesCommisionPlan();
         $SalesCommisionPlan->organization_id   = $request->organization_id ?? 1;
         $SalesCommisionPlan->_date             = change_date_format($request->_date ?? date('d-m-Y'));
         $SalesCommisionPlan->_fescal_year      = $request->_fescal_year ?? '';
         $SalesCommisionPlan->_name             = $request->_name ?? '';
         $SalesCommisionPlan->_details          = $request->_details ?? '';
         $SalesCommisionPlan->_status           = $request->_main_status ?? 1;
         $SalesCommisionPlan->_is_delete        = $request->_is_delete ?? 0;
         $SalesCommisionPlan->_created_by       = $users->id ?? 0;
         $SalesCommisionPlan->save();

         $_no            = $SalesCommisionPlan->id;

         $_statuss          = $request->_status ?? [];
         $inputs_ids        = $request->inputs_id ?? [];
         $_target_mins      = $request->_target_min ?? [];
         $_target_maxs      = $request->_target_max ?? [];
         $_credit_limits    = $request->_credit_limit ?? [];
         $_terms_ids        = $request->_terms_id ?? [];
         $_p_qtys           = $request->_p_qty ?? [];
         $_bonus_qtys       = $request->_bonus_qty ?? [];
         $_discount_rates   = $request->_discount_rate ?? [];
         $_cash_discount_rates  = $request->_cash_discount_rate ?? [];
         $_gift_items           = $request->_gift_item ?? [];
         $_grades               = $request->_grade ?? [];

         if(sizeof( $inputs_ids) > 0){
            foreach($inputs_ids as $key=>$d_id ){
                $SalesCommisionPlanDetail  = SalesCommisionPlanDetail::find($d_id);
                if(empty($SalesCommisionPlanDetail)){
                 $SalesCommisionPlanDetail  =  new SalesCommisionPlanDetail();
                }
                 $SalesCommisionPlanDetail->_no             =  $_no;
                 $SalesCommisionPlanDetail->_status         =  $_statuss[$key] ?? 1;
                 $SalesCommisionPlanDetail->_target_min     =  $_target_mins[$key] ?? 0;
                 $SalesCommisionPlanDetail->_target_max     =  $_target_maxs[$key] ?? 0;
                 $SalesCommisionPlanDetail->_credit_limit   =  $_credit_limits[$key] ?? 0;
                 $SalesCommisionPlanDetail->_terms_id       =  $_terms_ids[$key] ?? 0;
                 $SalesCommisionPlanDetail->_p_qty          =  $_p_qtys[$key] ?? 0;
                 $SalesCommisionPlanDetail->_bonus_qty      =  $_bonus_qtys[$key] ?? 0;
                 $SalesCommisionPlanDetail->_discount_rate  =  $_discount_rates[$key] ?? 0;
                 $SalesCommisionPlanDetail->_cash_discount_rate  =  $_cash_discount_rates[$key] ?? 0;
                 $SalesCommisionPlanDetail->_gift_item      =  $_gift_items[$key] ?? '';
                 $SalesCommisionPlanDetail->_grade          =  $_grades[$key] ?? '';
                 $SalesCommisionPlanDetail->save();




            }
         }

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
     * @param  \App\Models\SalesCommisionPlan  $salesCommisionPlan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SalesCommisionPlan::with(['_organization','_detail'])->where('id',$id)->first();
          $users = Auth::user();
        $page_name = $this->page_name;
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $transection_terms      = DB::table('transection_terms')->get();

        return view('backend.sales_commision_plans.show',compact('page_name','permited_organizations','transection_terms','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesCommisionPlan  $salesCommisionPlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $data = SalesCommisionPlan::with(['_detail'])->where('id',$id)->first();
          $users = Auth::user();
        $page_name = $this->page_name;
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $transection_terms      = DB::table('transection_terms')->get();

        return view('backend.sales_commision_plans.edit',compact('page_name','permited_organizations','transection_terms','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesCommisionPlan  $salesCommisionPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


         $request->validate([
                'organization_id' => 'required',
                '_fescal_year' => 'required',
                '_date' => 'required',
                '_name' => 'required|max:255',
            ]);

          $users = Auth::user();

        DB::beginTransaction();
        try {

         $SalesCommisionPlan =  SalesCommisionPlan::find($id);
         $SalesCommisionPlan->organization_id   = $request->organization_id ?? 1;
         $SalesCommisionPlan->_date             = change_date_format($request->_date ?? date('d-m-Y'));
         $SalesCommisionPlan->_fescal_year      = $request->_fescal_year ?? '';
         $SalesCommisionPlan->_name             = $request->_name ?? '';
         $SalesCommisionPlan->_details          = $request->_details ?? '';
         $SalesCommisionPlan->_status           = $request->_main_status ?? 1;
         $SalesCommisionPlan->_is_delete        = $request->_is_delete ?? 0;
         $SalesCommisionPlan->_updated_by       = $users->id ?? 0;
         $SalesCommisionPlan->save();

         $_no            = $SalesCommisionPlan->id;

         SalesCommisionPlanDetail::where('_no',$_no)->update(['_status'=>0]);

         $_statuss          = $request->_status ?? [];
         $inputs_ids        = $request->inputs_id ?? [];
         $_target_mins      = $request->_target_min ?? [];
         $_target_maxs      = $request->_target_max ?? [];
         $_credit_limits    = $request->_credit_limit ?? [];
         $_terms_ids        = $request->_terms_id ?? [];
         $_p_qtys           = $request->_p_qty ?? [];
         $_bonus_qtys       = $request->_bonus_qty ?? [];
         $_discount_rates   = $request->_discount_rate ?? [];
         $_cash_discount_rates  = $request->_cash_discount_rate ?? [];
         $_gift_items           = $request->_gift_item ?? [];
         $_grades               = $request->_grade ?? [];

         if(sizeof( $inputs_ids) > 0){
            foreach($inputs_ids as $key=>$d_id ){
                $SalesCommisionPlanDetail  = SalesCommisionPlanDetail::find($d_id);
                if(empty($SalesCommisionPlanDetail)){
                 $SalesCommisionPlanDetail  =  new SalesCommisionPlanDetail();
                }
                 $SalesCommisionPlanDetail->_no             =  $_no;
                 $SalesCommisionPlanDetail->_status         =  $_statuss[$key] ?? 1;
                 $SalesCommisionPlanDetail->_target_min     =  $_target_mins[$key] ?? 0;
                 $SalesCommisionPlanDetail->_target_max     =  $_target_maxs[$key] ?? 0;
                 $SalesCommisionPlanDetail->_credit_limit   =  $_credit_limits[$key] ?? 0;
                 $SalesCommisionPlanDetail->_terms_id       =  $_terms_ids[$key] ?? 0;
                 $SalesCommisionPlanDetail->_p_qty          =  $_p_qtys[$key] ?? 0;
                 $SalesCommisionPlanDetail->_bonus_qty      =  $_bonus_qtys[$key] ?? 0;
                 $SalesCommisionPlanDetail->_discount_rate  =  $_discount_rates[$key] ?? 0;
                 $SalesCommisionPlanDetail->_cash_discount_rate  =  $_cash_discount_rates[$key] ?? 0;
                 $SalesCommisionPlanDetail->_gift_item      =  $_gift_items[$key] ?? '';
                 $SalesCommisionPlanDetail->_grade          =  $_grades[$key] ?? '';
                 $SalesCommisionPlanDetail->save();




            }
         }

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
     * @param  \App\Models\SalesCommisionPlan  $salesCommisionPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesCommisionPlan $salesCommisionPlan)
    {
        //
    }
}
