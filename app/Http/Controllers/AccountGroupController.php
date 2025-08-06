<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Session;

class AccountGroupController extends Controller
{

    
    function __construct()
    {
         $this->middleware('permission:account-group-list|account-group-create|account-group-edit|account-group-delete', ['only' => ['index','store']]);
         $this->middleware('permission:account-group-create', ['only' => ['create','store']]);
         $this->middleware('permission:account-group-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:account-group-delete', ['only' => ['destroy']]);
         $this->page_name = "Account Group";
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
            session()->put('_ag_limit', $request->limit);
        }else{
             $limit= Session::get('_ag_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_short';

        $datas = AccountGroup::with(['account_type']);
        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_short') && $request->_short !=''){
            $datas = $datas->where('_short',$request->_short);
        }
        if ($request->has('_account_head_id') && $request->_account_head_id !="") {
            $datas = $datas->where('_account_head_id','=',$request->_account_head_id);
        }
        $limit = $datas->count();

        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
         $page_name = $this->page_name;
         

        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.account-group.master_print',compact('datas','page_name','request','limit'));
            }
         }

          $account_types = AccountHead::with(['_child_group'])->where('_parent_id',0)->orderBy('_account_id','asc')->get();

        return view('backend.account-group.index',compact('datas','page_name','account_types','request','limit'));
    }

    public function reset(){
        Session::flash('_ag_limit');
       return  \Redirect::to('account-group?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $page_name = $this->page_name;
          $account_types = AccountHead::with(['_child_group'])->where('_parent_id',0)->orderBy('_account_id','asc')->get();
       return view('backend.account-group.create',compact('account_types','page_name'));
    }
    
    public function account_group_short_update(Request $request){

        //return $request->all();
        $ids = $request->id ?? [];
        $_shorts = $request->_short ?? [];

        if(sizeof($ids) > 0){
            for ($i=0; $i<sizeof($ids) ; $i++) { 
                accountGroup::where('id',$ids[$i])->update(['_short'=>$_shorts[$i] ?? 0]);
            }
        }

        return redirect()->back()->with('success','Information Save successfully');

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
                '_name' => 'required|max:255|unique:account_groups,_name',
            ]);
        $data = new AccountGroup();
        $data->_name       = $request->_name ?? '';
        $data->_code = $request->_code ?? '';
        $data->_details = $request->_details ?? '';
        $data->_account_head_id  = $request->_account_head_id ?? '';
        $data->_parent_id  = $request->_parent_id ?? 0;
        $data->_short  = $request->_short ?? 5;
        $data->_status     = $request->_status ?? '';
        $data->save();
        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
    public function show(AccountGroup $accountGroup)
    {
        $page_name = $this->page_name;
        $data = $accountGroup;
        return view('backend.account-group.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
     public function edit(AccountHead $accountHead,$id)
    {
        $page_name = $this->page_name;
        $data = AccountGroup::with('account_type')->find($id);
           $account_types = AccountHead::with(['_child_group'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        return view('backend.account-group.edit',compact('data','page_name','account_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate([
                '_name' => 'required|max:255|unique:account_groups,_name,'.$request->id,
            ]);
        $data = AccountGroup::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code = $request->_code ?? '';
        $data->_details = $request->_details ?? '';
        $data->_account_head_id  = $request->_account_head_id ?? '';
        $data->_parent_id  = $request->_parent_id ?? 0;
        $data->_short  = $request->_short ?? 5;
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect('account-group')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        $numOfAccount = Accounts::where('_account_group',$id)->count();
        if($numOfAccount ==0){
            AccountGroup::find($id)->delete();
            return redirect('account-group')->with('success','Information deleted successfully');
        }else{
            $__message ="You Can not delete this Information";
            $page_name ="Permission Denied";
            return view('backend.message.permission_message',compact('__message','page_name'));
        }
    }
}
