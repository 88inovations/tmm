<?php

namespace App\Http\Controllers;

use App\Models\QuaterlyInsentiveSetup;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;

class QuaterlyInsentiveSetupController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:quaterly_insentive_setups-list|quaterly_insentive_setups-create|quaterly_insentive_setups-edit|quaterly_insentive_setups-delete', ['only' => ['index','store']]);
         $this->middleware('permission:quaterly_insentive_setups-create', ['only' => ['create','store']]);
         $this->middleware('permission:quaterly_insentive_setups-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:quaterly_insentive_setups-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_name = __('label.quaterly_insentive_setups');
        $_incentive_group = $request->_incentive_group ?? 1;


        $datas = QuaterlyInsentiveSetup::where('_status',1)
                    ->where('_incentive_group',$_incentive_group)
                    ->orderBy('_insentive_year','DESC')
                    ->paginate(20);
        


        return view('backend.quaterly_insentive_setups.index',compact('page_name','datas','_incentive_group'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = __('label.quaterly_insentive_setups');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        return view('backend.quaterly_insentive_setups.create',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // return $request->all();
        $this->validate($request, [
             'organization_id' => 'required',
            '_branch_id' => 'required',
             '_cost_center_id' => 'required',
             '_budget_id' => 'required',
            '_incentive_group' => 'required',
            '_insentive_year' => 'required',
            '_insentive_quater_no' => 'required',
            '_insentive_slap_no' => 'required',
            '_insentive_period_start' => 'required',
            '_insentive_period_end' => 'required',
            '_slap_min_amount' => 'required',
            '_slap_max_amount' => 'required',
            '_incentive_rate' => 'required'
        ]);

         DB::beginTransaction();
        try {
        $auth_user= Auth::user();

                $data = new QuaterlyInsentiveSetup();
                $data->organization_id = $request->organization_id;
                $data->_branch_id = $request->_branch_id;
                $data->_cost_center_id = $request->_cost_center_id;
                $data->_budget_id = $request->_budget_id;
                $data->_incentive_group = $request->_incentive_group;
                $data->_insentive_year = $request->_insentive_year;
                $data->_fescal_year = $request->_insentive_year;
                $data->_insentive_quater_no = $request->_insentive_quater_no;
                $data->_insentive_slap_no = $request->_insentive_slap_no;
                $data->_insentive_period_start = change_date_format($request->_insentive_period_start);
                $data->_insentive_period_end = change_date_format($request->_insentive_period_end);
                $data->_slap_min_amount = $request->_slap_min_amount ?? 0;
                $data->_slap_max_amount = $request->_slap_max_amount ?? 0;
                $data->_incentive_rate = $request->_incentive_rate ?? 0;
                $data->_created_by = $auth_user->id;
                $data->_status = $request->_status ?? 0;
                $data->created_at  = date('Y-m-d H:i:s');;
                $data->save();

        $success_message ="Information Save successfully.";
          DB::commit();
            return redirect()->back()
            ->with('success',$success_message);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('success',"Something Wrong");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuaterlyInsentiveSetup  $quaterlyInsentiveSetup
     * @return \Illuminate\Http\Response
     */
    public function show(QuaterlyInsentiveSetup $quaterlyInsentiveSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuaterlyInsentiveSetup  $quaterlyInsentiveSetup
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $page_name = __('label.quaterly_insentive_setups');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
         $data = QuaterlyInsentiveSetup::find($id);
        return view('backend.quaterly_insentive_setups.edit',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuaterlyInsentiveSetup  $quaterlyInsentiveSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
             'organization_id' => 'required',
            '_branch_id' => 'required',
             '_cost_center_id' => 'required',
             '_budget_id' => 'required',
            '_incentive_group' => 'required',
            '_insentive_year' => 'required',
            '_insentive_quater_no' => 'required',
            '_insentive_slap_no' => 'required',
            '_insentive_period_start' => 'required',
            '_insentive_period_end' => 'required',
            '_slap_min_amount' => 'required',
            '_slap_max_amount' => 'required',
            '_incentive_rate' => 'required'
        ]);

         DB::beginTransaction();
        try {
        $auth_user= Auth::user();

                $data = QuaterlyInsentiveSetup::find($id);
                $data->organization_id = $request->organization_id;
                $data->_branch_id = $request->_branch_id;
                $data->_cost_center_id = $request->_cost_center_id;
                $data->_budget_id = $request->_budget_id;
                $data->_incentive_group = $request->_incentive_group;
                $data->_insentive_year = $request->_insentive_year;
                $data->_fescal_year = $request->_insentive_year;
                $data->_insentive_quater_no = $request->_insentive_quater_no;
                $data->_insentive_slap_no = $request->_insentive_slap_no;
                $data->_insentive_period_start = change_date_format($request->_insentive_period_start);
                $data->_insentive_period_end = change_date_format($request->_insentive_period_end);
                $data->_slap_min_amount = $request->_slap_min_amount ?? 0;
                $data->_slap_max_amount = $request->_slap_max_amount ?? 0;
                $data->_incentive_rate = $request->_incentive_rate ?? 0;
                $data->_updated_by = $auth_user->id;
                $data->_status = $request->_status ?? 0;
                $data->updated_at  = date('Y-m-d H:i:s');;
                $data->save();

        $success_message ="Information Save successfully.";
          DB::commit();
            return redirect()->back()
            ->with('success',$success_message);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('success',"Something Wrong");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuaterlyInsentiveSetup  $quaterlyInsentiveSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QuaterlyInsentiveSetup::find($id)->delete();
        return redirect()->back()
                        ->with('danger','Information deleted successfully');
    }
}
