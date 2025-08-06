<?php

namespace App\Http\Controllers;

use App\Models\StewardAllocation;
use App\Models\AccountLedger;
use App\Models\Branch;
use App\Models\AccountHead;
use App\Models\StoreHouse;
use Illuminate\Http\Request;
use Auth;
use DB;

class StewardAllocationController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:steward-waiter-list|steward-waiter-create|steward-waiter-edit|steward-waiter-delete', ['only' => ['index','store']]);
         $this->middleware('permission:steward-waiter-create', ['only' => ['create','store']]);
         $this->middleware('permission:steward-waiter-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:steward-waiter-delete', ['only' => ['destroy']]);
         $this->page_name = "Waiter/Steward Setup";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $users = Auth::user();
        $limit = $request->limit ?? 10;
        $datas = StewardAllocation::with(['_branch']);
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
       
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','like',"%$request->_branch_id%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
         $branchs = Branch::orderBy('_name','asc')->get();
        $categories = [];
        $units = [];
        $account_groups = [];
        $account_types = AccountHead::select('id','_name')->where('_account_id',2)->orderBy('_name','asc')->get();
         $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $store_houses = StoreHouse::select('id','_name')->whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        return view('backend.steward-waiter.index',compact('datas','request','page_name','branchs','categories','units','account_types','account_groups','permited_branch','store_houses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $page_name = $this->page_name;
      // $branchs = Branch::orderBy('_name','asc')->get();
       $users = Auth::user();
      $branchs = permited_branch(explode(',',$users->branch_ids));
      $_steward_group = \DB::table("default_ledgers")->select('_steward_group')->first();
      $_ledgerss= AccountLedger::select('id','_name','_phone','_alious')->where('_account_group_id',$_steward_group->_steward_group ?? 0)->get();
        return view('backend.steward-waiter.create',compact('page_name','branchs','_ledgerss'));
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
                '_ledgers' => 'required',
                '_branch_id' => 'required',
        ]);

         $data = new StewardAllocation();
         $_cash_ledger_ids = 0;
        $_ledgers = $request->_ledgers ?? [];
        if(sizeof($_ledgers) > 0){
            $__ledgers_ids  =  implode(",",$_ledgers);
        }

        $data->_ledgers       = $__ledgers_ids ?? 0;
        $data->_branch_id = $request->_branch_id ?? '';
        $data->_status = $request->_status ?? 0;
        $data->_created_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StewardAllocation  $StewardAllocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
        $data = StewardAllocation::with(['_branch'])->find($id);
        return view('backend.steward-waiter.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StewardAllocation  $StewardAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = StewardAllocation::find($id);
         $users = Auth::user();
         $branchs = permited_branch(explode(',',$users->branch_ids));

        $_steward_group = \DB::table("default_ledgers")->select('_steward_group')->first();
      $_ledgerss= AccountLedger::select('id','_name','_phone','_alious')->where('_account_group_id',$_steward_group->_steward_group ?? 0)->get();

        return view('backend.steward-waiter.edit',compact('data','page_name','branchs','_ledgerss'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StewardAllocation  $StewardAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                '_ledgers' => 'required',
                '_branch_id' => 'required',
            ]);
        $data = StewardAllocation::find($request->id);
        $_cash_ledger_ids = 0;
        $_ledgers = $request->_ledgers ?? [];
        if(sizeof($_ledgers) > 0){
            $__ledgers_ids  =  implode(",",$_ledgers);
        }

        $data->_ledgers       = $__ledgers_ids ?? 0;
        $data->_branch_id = $request->_branch_id ?? '';
        $data->_status = $request->_status ?? 0;
        $data->_updated_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();

        return redirect('steward-waiter')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StewardAllocation  $StewardAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       StewardAllocation::find($id)->delete();
        return redirect()->route('steward-waiter.index')
                        ->with('success','Information deleted successfully');
    }
}
