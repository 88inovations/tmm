<?php

namespace App\Http\Controllers;

use App\Models\MonthlySalesTarget;
use App\Models\GeneralSettings;
use App\Models\AccountLedger;
use App\Models\SalesCommisionPlan;
use App\Models\HRM\HrmEmployees;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use DateTime;

class MonthlySalesTargetController extends Controller
{
   function __construct()
    {
         $this->middleware('permission:monthly_sales_targets-list|monthly_sales_targets-create|monthly_sales_targets-edit|monthly_sales_targets-delete', ['only' => ['index','store']]);
         $this->middleware('permission:monthly_sales_targets-create', ['only' => ['create','store']]);
         $this->middleware('permission:monthly_sales_targets-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:monthly_sales_targets-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  20;
            
        }else{
             $limit = 20;
            
        }
 $permited_branch = permited_branch(explode(',',$users->branch_ids));
 $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


     $page_name = __('label.monthly_sales_targets');
        $_group = $request->_group ?? 1;
        $datas = MonthlySalesTarget::with(['_organization','_master_store','_master_cost_center','_ledger','_master_branch'])
                ->where('_status',1);




        if($request->has('_branch_id') && $request->_branch_id !=''){
           $datas = $datas->where('_branch_id',$request->_branch_id);
        }else{
            $datas = $datas->whereIn('_branch_id',explode(',',$users->branch_ids));
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
           $datas = $datas->where('_cost_center_id',$request->_cost_center_id);
        }else{
            $datas = $datas->whereIn('_cost_center_id',explode(',',$users->cost_center_ids));
        }

        if($request->has('_ledger_id') && $request->_ledger_id !=''){
           $datas = $datas->where('_ledger_id',$request->_ledger_id);
        }

                
        $datas = $datas->where('_group',$_group)
                ->orderBy('_year','DESC')
                ->paginate($limit);


    $ledgers_accounts = AccountLedger::whereIn('_account_group_id',_employee_group_array());
    if($request->has('_branch_id') && $request->_branch_id !=''){
           $ledgers_accounts = $ledgers_accounts->where('_branch_id',$request->_branch_id);
        }else{
            $ledgers_accounts = $ledgers_accounts->whereIn('_branch_id',explode(',',$users->branch_ids));
        }

    $ledgers_accounts = $ledgers_accounts->orderBy('_name','ASC')->get();
        


        return view('backend.monthly_sales_targets.index',compact('page_name','datas','_group','permited_branch','permited_costcenters','limit','ledgers_accounts','_group'));
    }




public function customer_sales_target_list(Request $request){

    $users = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  20;
            
        }else{
             $limit = 20;
            
        }
 $permited_branch = permited_branch(explode(',',$users->branch_ids));
 $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


     $page_name = __('label.customer_sales_target_list');
        $_group = $request->_group ?? 2;
        $datas = MonthlySalesTarget::with(['_organization','_master_store','_master_cost_center','_ledger','_master_branch'])
                ->where('_status',1);




        if($request->has('_branch_id') && $request->_branch_id !=''){
           $datas = $datas->where('_branch_id',$request->_branch_id);
        }else{
            $datas = $datas->whereIn('_branch_id',explode(',',$users->branch_ids));
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
           $datas = $datas->where('_cost_center_id',$request->_cost_center_id);
        }else{
            $datas = $datas->whereIn('_cost_center_id',explode(',',$users->cost_center_ids));
        }

        if($request->has('_ledger_id') && $request->_ledger_id !=''){
           $datas = $datas->where('_ledger_id',$request->_ledger_id);
        }

                
        $datas = $datas->where('_group',$_group)
                ->orderBy('_year','DESC')
                ->paginate($limit);


    $ledgers_accounts = AccountLedger::whereIn('_account_group_id',_customer_group_array());
    if($request->has('_branch_id') && $request->_branch_id !=''){
           $ledgers_accounts = $ledgers_accounts->where('_branch_id',$request->_branch_id);
        }else{
            $ledgers_accounts = $ledgers_accounts->whereIn('_branch_id',explode(',',$users->branch_ids));
        }

    $ledgers_accounts = $ledgers_accounts->orderBy('_name','ASC')->get();
    
        


        return view('backend.monthly_sales_targets.customer_sales_target_list',compact('page_name','datas','_group','permited_branch','permited_costcenters','limit','ledgers_accounts','_group'));
}


public function customer_sales_target_create(Request $request){
        $page_name = __('label.monthly_sales_targets');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $general_settings =GeneralSettings::select('_employee_group')->first();
        $_employee_group = $general_settings->_employee_group ?? '';

        $customers = [];

        if($request->has('organization_id') && $request->has('_branch_id') && $request->has('_cost_center_id')){
             $customers = AccountLedger::whereIn('_account_group_id',_customer_group_array())
                                        ->where('_branch_id',$request->_branch_id)
                                        ->orderBy('_name','ASC')
                                        ->get();
        }
       // return $customers;

        $sales_commision_plans = SalesCommisionPlan::with(['_detail'])->get();



        return view('backend.monthly_sales_targets.customer_sales_target_create',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','request','customers','sales_commision_plans'));
}


public function customer_sales_target_edit($id){
    $page_name = __('label.customer_sales_target_edit');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $general_settings =GeneralSettings::select('_employee_group')->first();
        $_employee_group = $general_settings->_employee_group ?? '';

         $data = MonthlySalesTarget::with(['_organization','_master_store','_master_cost_center','_ledger','_master_branch'])->find($id);
       // return $customers;

        $sales_commision_plans = SalesCommisionPlan::with(['_detail'])->get();



        return view('backend.monthly_sales_targets.customer_sales_target_edit',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','sales_commision_plans','data'));
}



public function customer_sales_target_update(Request $request){
   // return $request->all();


    $organization_id    = $request->organization_id ?? 0;
    $_branch_id         = $request->_branch_id ?? 0;
    $_cost_center_id    = $request->_cost_center_id ?? 0;
    $_budget_id         = $request->_budget_id ?? 0;
    $_fescal_year       = $request->_fescal_year ?? 0;
    $_ledger_id        = $request->_ledger_id ?? 0;
    $id                 = $request->id ?? 0;
    $sales_commision_plans_id = $request->sales_commision_plans_id ?? 0;
    $id = $request->id ?? 0;

     $sales_commision_plan_details  = \DB::table("sales_commision_plan_details")->get()->toArray();
    $palan_array     = [];
    foreach($sales_commision_plan_details as $plan){
        $palan_array[$plan->id]=$plan;
    }
   // return $palan_array;

      DB::beginTransaction();
        try {

        $_target_min    = $palan_array[$sales_commision_plans_id]->_target_min ?? 0;
        $_target_max    = $palan_array[$sales_commision_plans_id]->_target_max ?? 0;
        $_credit_limit  = $palan_array[$sales_commision_plans_id]->_credit_limit ?? 0;
        $_gift_item     = $palan_array[$sales_commision_plans_id]->_gift_item ?? 0;
        $_grade         = $palan_array[$sales_commision_plans_id]->_grade ?? 0;

        $firstDate = new DateTime("{$_fescal_year}-01-01");
         $_period_start = $firstDate->format('Y-m-d');

        // Last date of the dynamic year
        $lastDate = new DateTime("{$_fescal_year}-12-31");
        $_period_end = $lastDate->format('Y-m-d');


        $MonthlySalesTarget   = MonthlySalesTarget::find($id);
        if(empty($MonthlySalesTarget)){
            $MonthlySalesTarget   = new MonthlySalesTarget();
        }
        $MonthlySalesTarget->organization_id        = $organization_id;
        $MonthlySalesTarget->_branch_id             = $_branch_id;
        $MonthlySalesTarget->_cost_center_id        = $_cost_center_id;
        $MonthlySalesTarget->_budget_id             = $_budget_id;
        $MonthlySalesTarget->_fescal_year           = $_fescal_year;
        $MonthlySalesTarget->_year                  = $_fescal_year;
        $MonthlySalesTarget->_ledger_id             = $_ledger_id;
        $MonthlySalesTarget->_group                 =2;
        $MonthlySalesTarget->_period_start      =$_period_start;
        $MonthlySalesTarget->_period_end      =$_period_end;
        $MonthlySalesTarget->sales_commision_plans_id      =$sales_commision_plans_id;
        $MonthlySalesTarget->_target_amount      =$_target_min;
        $MonthlySalesTarget->_status      =$_status ?? 1;
        $MonthlySalesTarget->save();






    

      $success_message ="Information Save successfully.";
          DB::commit();
            return redirect()->back()
            ->with('success',$success_message);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger',"Something Wrong");
        }


}


   public function customer_sales_target_show( $id)
    {
        $page_name = __('label.customer_sales_target_show');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $data = MonthlySalesTarget::with(['_ledger','_master_cost_center','_organization','_master_branch'])->find($id);
        



        return view('backend.monthly_sales_targets.customer_sales_target_show',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','data'));
    }

public function customer_sales_target_store(Request $request){
   // return $request->all();


    $organization_id    = $request->organization_id ?? 0;
    $_branch_id         = $request->_branch_id ?? 0;
    $_cost_center_id    = $request->_cost_center_id ?? 0;
    $_budget_id         = $request->_budget_id ?? 0;
    $_fescal_year       = $request->_fescal_year ?? 0;
    $_ledger_ids        = $request->_ledger_id ?? [];
    $sales_commision_plans_ids = $request->sales_commision_plans_id ?? [];

     $sales_commision_plan_details  = \DB::table("sales_commision_plan_details")->get()->toArray();
    $palan_array     = [];
    foreach($sales_commision_plan_details as $plan){
        $palan_array[$plan->id]=$plan;
    }
   // return $palan_array;

      DB::beginTransaction();
        try {

    foreach($_ledger_ids as $row_key=> $_ledger_id){
        $sales_commision_plans_id = $sales_commision_plans_ids[$row_key] ?? 0;

        $_target_min    = $palan_array[$sales_commision_plans_id]->_target_min ?? 0;
        $_target_max    = $palan_array[$sales_commision_plans_id]->_target_max ?? 0;
        $_credit_limit  = $palan_array[$sales_commision_plans_id]->_credit_limit ?? 0;
        $_gift_item     = $palan_array[$sales_commision_plans_id]->_gift_item ?? 0;
        $_grade         = $palan_array[$sales_commision_plans_id]->_grade ?? 0;

        $firstDate = new DateTime("{$_fescal_year}-01-01");
         $_period_start = $firstDate->format('Y-m-d');

        // Last date of the dynamic year
        $lastDate = new DateTime("{$_fescal_year}-12-31");
        $_period_end = $lastDate->format('Y-m-d');


        $MonthlySalesTarget   = MonthlySalesTarget::where('_ledger_id',$_ledger_id)
                                                ->where('_fescal_year',$_fescal_year)
                                                ->first();
        if(empty($MonthlySalesTarget)){
            $MonthlySalesTarget   = new MonthlySalesTarget();
        }
        $MonthlySalesTarget->organization_id        = $organization_id;
        $MonthlySalesTarget->_branch_id             = $_branch_id;
        $MonthlySalesTarget->_cost_center_id        = $_cost_center_id;
        $MonthlySalesTarget->_budget_id             = $_budget_id;
        $MonthlySalesTarget->_fescal_year           = $_fescal_year;
        $MonthlySalesTarget->_year                  = $_fescal_year;
        $MonthlySalesTarget->_ledger_id             = $_ledger_id;
        $MonthlySalesTarget->_group                 =2;
        $MonthlySalesTarget->_period_start      =$_period_start;
        $MonthlySalesTarget->_period_end      =$_period_end;
        $MonthlySalesTarget->sales_commision_plans_id      =$sales_commision_plans_id;
        $MonthlySalesTarget->_target_amount      =$_target_min;
        $MonthlySalesTarget->_status      =$_status ?? 1;
        $MonthlySalesTarget->save();






    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = __('label.monthly_sales_targets');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $general_settings =GeneralSettings::select('_employee_group')->first();
        $_employee_group = $general_settings->_employee_group ?? '';



        return view('backend.monthly_sales_targets.create',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets'));
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
             '_cost_center_id' => 'required',
             '_budget_id' => 'required'
        ]);
        $_ledger_ids = $request->_ledger_id ?? [];
        $_target_amounts = $request->_target_amount ?? [];
        $_sales_amounts = $request->_sales_amount ?? [];
        $_sales_return_amounts = $request->_sales_return_amount ?? [];
        $_collection_amounts = $request->_collection_amount ?? [];
        $_branch_ids = $request->_branch_id ?? [];

        $_row_ids = $request->_row_id ?? [];
        $_budget_id = $request->_budget_id ?? 0;
        $_group = $request->_group ?? 0;
        $_year = $request->_year ?? 0;
        $_month_no = $request->_month_no ?? 0;
        $organization_id = $request->organization_id ?? 0;
        $_cost_center_id = $request->_cost_center_id ?? 0;

        $_period_start = change_date_format($request->_period_start ?? '');
        $_period_end = change_date_format($request->_period_end ?? '');


         DB::beginTransaction();
        try {
        $auth_user= Auth::user();

if(sizeof($_row_ids) > 0){
    for ($i=0; $i <sizeof($_row_ids); $i++) { 
        $row_id = $_row_ids[$i] ?? 0;
        if($row_id ==0){
            $data = new MonthlySalesTarget();
        }else{
            $data = MonthlySalesTarget::find($row_id);
        }
        
        $data->organization_id = $organization_id;
        $data->_cost_center_id = $_cost_center_id;
        $data->_branch_id = $_branch_ids[$i] ?? 1;
        $data->_budget_id = $_budget_id;
        $data->_fescal_year = $request->_year;
        $data->_group = $request->_group ?? 1;
        $data->_year = $request->_year ?? date('Y');
        $data->_month_no = $request->_month_no;
        $data->_ledger_id = $_ledger_ids[$i];
        $data->_period_start = change_date_format($request->_period_start);
        $data->_period_end = change_date_format($request->_period_end);
        $data->_target_amount =$_target_amounts[$i] ?? 0;
        $data->_created_by = $auth_user->id;
        $data->_status = $request->_status ?? 0;
        $data->created_at  = date('Y-m-d H:i:s');;
        $data->save();

    }
}
                

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
     * @param  \App\Models\MonthlySalesTarget  $MonthlySalesTarget
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $page_name = __('label.monthly_sales_targets');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $data = MonthlySalesTarget::with(['_ledger','_master_cost_center','_organization','_master_branch'])->find($id);
        



        return view('backend.monthly_sales_targets.show',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','data'));
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonthlySalesTarget  $MonthlySalesTarget
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $page_name = __('label.monthly_sales_targets');
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
         $data = MonthlySalesTarget::find($id);
        return view('backend.monthly_sales_targets.edit',compact('page_name','permited_organizations','permited_branch','permited_costcenters','permited_budgets','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MonthlySalesTarget  $MonthlySalesTarget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
             'organization_id' => 'required',
             '_cost_center_id' => 'required',
             '_budget_id' => 'required'
        ]);
        $_ledger_ids = $request->_ledger_id ?? [];
        $_target_amounts = $request->_target_amount ?? [];
        $_sales_amounts = $request->_sales_amount ?? [];
        $_sales_return_amounts = $request->_sales_return_amount ?? [];
        $_collection_amounts = $request->_collection_amount ?? [];
        $_branch_ids = $request->_branch_id ?? [];

        $_row_ids = $request->_row_id ?? [];
        $_budget_id = $request->_budget_id ?? 0;
        $_group = $request->_group ?? 0;
        $_year = $request->_year ?? 0;
        $_month_no = $request->_month_no ?? 0;
        $organization_id = $request->organization_id ?? 0;
        $_cost_center_id = $request->_cost_center_id ?? 0;

        $_period_start = change_date_format($request->_period_start ?? '');
        $_period_end = change_date_format($request->_period_end ?? '');


         DB::beginTransaction();
        try {
        $auth_user= Auth::user();

if(sizeof($_row_ids) > 0){
    for ($i=0; $i <sizeof($_row_ids); $i++) { 
        $row_id = $_row_ids[$i] ?? 0;
        if($row_id ==0){
            $data = new MonthlySalesTarget();
        }else{
            $data = MonthlySalesTarget::find($row_id);
        }
        
        $data->organization_id = $organization_id;
        $data->_cost_center_id = $_cost_center_id;
        $data->_branch_id = $_branch_ids[$i] ?? 1;
        $data->_budget_id = $_budget_id;
        $data->_fescal_year = $request->_year;
        $data->_group = $request->_group ?? 1;
        $data->_year = $request->_year ?? date('Y');
        $data->_month_no = $request->_month_no;
        $data->_ledger_id = $_ledger_ids[$i];
        $data->_period_start = change_date_format($request->_period_start);
        $data->_period_end = change_date_format($request->_period_end);
        $data->_target_amount =$_target_amounts[$i] ?? 0;
        $data->_created_by = $auth_user->id;
        $data->_status = $request->_status ?? 0;
        $data->created_at  = date('Y-m-d H:i:s');;
        $data->save();

    }
}
                

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
     * @param  \App\Models\MonthlySalesTarget  $MonthlySalesTarget
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MonthlySalesTarget::find($id)->delete();
        return redirect()->back()
                        ->with('danger','Information deleted successfully');
    }
}
