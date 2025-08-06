<?php

namespace App\Http\Controllers\HON;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HON\HonorimSetup;
use App\Models\GeneralSettings;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

use App\Models\AccountGroup;
use App\Models\Accounts;
use App\Models\AccountLedger;
use App\Models\MainAccountHead;

class HonorimSetupController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:honorim_setups_list|honorim_setups_create|honorim_setups_edit|honorim_setups_delete', ['only' => ['index','store']]);
         $this->middleware('permission:honorim_setups_create', ['only' => ['create','store']]);
         $this->middleware('permission:honorim_setups_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:honorim_setups_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.honorim_setups');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $page_name = $this->page_name;
        $users = Auth::user();
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        

        $_requested_group_array  = _honorarium_group_array();
        $datas = AccountLedger::with(['_honorarium_info','account_type','account_group','_organization','_branch','_cost_center'])
                                    ->whereIn('_account_group_id',$_requested_group_array);


        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id','=',$request->organization_id);
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','=',$request->_branch_id);
        }

         $datas  = $datas->get();



        



        return view('hon.honorim_setups.index',compact('page_name','request','datas','permited_organizations','permited_branch','permited_costcenters'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('honorim_setups.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        //return $request->all();

        $_ledger_ids        = $request->_ledger_id ?? [];
        $organization_ids   = $request->organization_id ?? [];
        $_cost_center_ids   = $request->_cost_center_id ?? [];
        $_branch_ids        = $request->_branch_id ?? [];
        $_setup_ids         = $request->_setup_id ?? [];
        $_amounts           = $request->_amount ?? [];
        $_statuss           = $request->_status ?? [];



        DB::beginTransaction();
        try {

            foreach($_setup_ids as $key=>$setup_id){
                $_ledger_id         = $_ledger_ids[$key] ?? 1;
                $organization_id    = $organization_ids[$key] ?? 1;
                $_cost_center_id    = $_cost_center_ids[$key] ?? 1;
                $_branch_id         = $_branch_ids[$key] ?? 1;
                $_setup_id          = $_setup_ids[$key] ?? 0;
                $_amount            = $_amounts[$key] ?? 0;
                $_status            = $_statuss[$key] ?? 0;

                $HonorimSetup = HonorimSetup::find($setup_id);
                if(empty($HonorimSetup)){
                    $HonorimSetup                   = new HonorimSetup();
                }
                    $HonorimSetup->id               = $_setup_id;
                    $HonorimSetup->_ledger_id       = $_ledger_id;
                    $HonorimSetup->organization_id  = $organization_id;
                    $HonorimSetup->_branch_id       = $_branch_id;
                    $HonorimSetup->_cost_center_id  = $_cost_center_id;
                    $HonorimSetup->_amount          = $_amount;
                    $HonorimSetup->_status          = $_status;
                    $HonorimSetup->save();

            }



          DB::commit();
        return redirect()->back()
            ->with('success','Information save successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
            ->with('request',$request->all())
            ->with('danger','There is Something Wrong !');
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
