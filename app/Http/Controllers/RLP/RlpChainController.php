<?php

namespace App\Http\Controllers\RLP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RLP\RlpAccessChain;
use App\Models\RLP\AccessChainUser;
use App\Models\RLP\RlpUserGroup;
use Auth;
use DB;

class RlpChainController extends Controller
{

    function __construct()
    {
        
         $this->middleware('permission:approval-chain-create', ['only' => ['create','store']]);
         $this->middleware('permission:approval-chain-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:approval-chain-list', ['only' => ['index']]);
         $this->middleware('permission:approval-chain-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.approval-chain');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


       $users = Auth::user();
       $page_name=$this->page_name;
       $datas =RlpAccessChain::with(['_branch','_cost_center','_organization','_chain_user','_entry_by'])
       ->whereIn('_branch_id',explode(',',$users->branch_ids))
       ->whereIn('_cost_center_id',explode(',',$users->cost_center_ids))
       ->whereIn('organization_id',explode(',',$users->organization_ids));
       if($users->user_type !='admin'){
                $datas = $datas->where('_user_id',$users->id);   
        } 

        $datas =$datas->get() ;

       if($request->has('print')){
            if($request->print =="detail"){
                return view('rlp-module.approval-chain.print',compact('page_name','datas'));
            }
         }

        return view('rlp-module.approval-chain.index',compact('page_name','datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       

        $page_name=$this->page_name;
        $users = \Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $rlp_user_groups = RlpUserGroup::where('_status',1)->orderBy('_order','ASC')->get();

        return view('rlp-module.approval-chain.create',compact('page_name','permited_branch','permited_costcenters','permited_organizations','rlp_user_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return dump($request->all());
        $request->validate([
                'chain_type' => 'required',
                'chain_name' => 'required',
                'organization_id' => 'required',
                '_branch_id' => 'required',
                '_cost_center_id' => 'required',
                'user_id' => 'required',
            ]);

      DB::beginTransaction();
        try {
   $users = \Auth::user();

        $RlpAccessChain = new RlpAccessChain();
        $RlpAccessChain->chain_type = $request->chain_type;
        $RlpAccessChain->chain_name = $request->chain_name;
        $RlpAccessChain->organization_id = $request->organization_id;
        $RlpAccessChain->_branch_id = $request->_branch_id;
        $RlpAccessChain->_cost_center_id = $request->_cost_center_id;
        $RlpAccessChain->department_id = $request->department_id ?? 1;
        $RlpAccessChain->_status = $request->_status ?? 1;
        $RlpAccessChain->created_by = $users->id;
        $RlpAccessChain->_user_id = $users->id;
        $RlpAccessChain->save();
       $rlp_access_id = $RlpAccessChain->id;

       $user_ids = $request->user_id ?? [];
       $user_row_ids = $request->user_row_id ?? [];
       $ack_orders = $request->ack_order ?? [];
       $user_groups = $request->user_group ?? [];

       if(sizeof($user_row_ids) > 0){
        for ($i=0; $i < sizeof($user_ids) ; $i++) { 
            $AccessChainUser = new AccessChainUser();
            $AccessChainUser->chain_id = $rlp_access_id;
            $AccessChainUser->user_row_id = $user_row_ids[$i];
            $AccessChainUser->user_id = $user_ids[$i];
            $AccessChainUser->user_group = $user_groups[$i];
            $AccessChainUser->_order = $ack_orders[$i];
            $AccessChainUser->_status = 1;
            $AccessChainUser->save();
        }
       }
            DB::commit();
           return redirect()->back()->with('success','Information Save successfully');
       } catch (\Exception $e) {
           DB::rollback();
         return redirect()->back()->with('error','Something Went Wrong');
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
        $page_name=$this->page_name;
       $data =RlpAccessChain::with(['_branch','_cost_center','_organization','_chain_user'])->find($id) ;
       $page_name=$this->page_name;
       $users = \Auth::user();
       $permited_branch = permited_branch(explode(',',$users->branch_ids));
       $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       $rlp_user_groups = RlpUserGroup::where('_status',1)->orderBy('_order','ASC')->get();

    return view('rlp-module.approval-chain.show',compact('page_name','permited_branch','permited_costcenters','permited_organizations','rlp_user_groups','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $page_name=$this->page_name;
       $data =RlpAccessChain::with(['_branch','_cost_center','_organization','_chain_user'])->find($id) ;
       $page_name=$this->page_name;
       $users = \Auth::user();
       $permited_branch = permited_branch(explode(',',$users->branch_ids));
       $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       $permited_organizations = permited_organization(explode(',',$users->organization_ids));
       $rlp_user_groups = RlpUserGroup::where('_status',1)->orderBy('_order','ASC')->get();

    return view('rlp-module.approval-chain.edit',compact('page_name','permited_branch','permited_costcenters','permited_organizations','rlp_user_groups','data'));

        
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
        //return dump($request->all());
        $request->validate([
                'chain_type' => 'required',
                'chain_name' => 'required',
                'organization_id' => 'required',
                '_branch_id' => 'required',
                '_cost_center_id' => 'required',
                'user_id' => 'required',
            ]);

      DB::beginTransaction();
        try {
            $users = \Auth::user();
        $RlpAccessChain = RlpAccessChain::find($id);
        $RlpAccessChain->chain_type = $request->chain_type;
        $RlpAccessChain->chain_name = $request->chain_name;
        $RlpAccessChain->organization_id = $request->organization_id;
        $RlpAccessChain->_branch_id = $request->_branch_id;
        $RlpAccessChain->_cost_center_id = $request->_cost_center_id;
        $RlpAccessChain->department_id = $request->department_id ?? 1;
        $RlpAccessChain->_status = $request->_status ?? 1;
        $RlpAccessChain->_user_id = $users->id;
        $RlpAccessChain->updated_by = $users->id;
        $RlpAccessChain->save();
       $rlp_access_id = $RlpAccessChain->id;

       $user_ids = $request->user_id ?? [];
       $user_row_ids = $request->user_row_id ?? [];
       $ack_orders = $request->ack_order ?? [];
       $user_groups = $request->user_group ?? [];
       $_row_ids = $request->_row_id ?? [];

       AccessChainUser::where('chain_id',$id)->update(['_status'=>0]);

       if(sizeof($_row_ids) > 0){
        for ($i=0; $i < sizeof($_row_ids) ; $i++) { 
            if($_row_ids[$i]==0){
                $AccessChainUser = new AccessChainUser();
            }else{
                $AccessChainUser = AccessChainUser::find($_row_ids[$i]);
            }
            
            $AccessChainUser->chain_id = $rlp_access_id;
            $AccessChainUser->user_row_id = $user_row_ids[$i];
            $AccessChainUser->user_id = $user_ids[$i];
            $AccessChainUser->user_group = $user_groups[$i];
            $AccessChainUser->_order = $ack_orders[$i];
            $AccessChainUser->_status = 1;
            $AccessChainUser->save();
        }
       }
            DB::commit();
           return redirect()->back()->with('success','Information Save successfully');
       } catch (\Exception $e) {
           DB::rollback();
         return redirect()->back()->with('error','Something Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->back()->with('danger','You Can not delete this Information');

    }
}
