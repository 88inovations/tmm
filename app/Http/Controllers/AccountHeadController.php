<?php

namespace App\Http\Controllers;

use App\Models\AccountHead;
use App\Models\MainAccountHead;
use App\Models\AccountGroup;
use Illuminate\Http\Request;
use Session;

class AccountHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
    {
         $this->middleware('permission:account-type-list|account-type-create|account-type-edit|account-type-delete', ['only' => ['index','store']]);
         $this->middleware('permission:account-type-create', ['only' => ['create','store']]);
         $this->middleware('permission:account-type-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:account-type-delete', ['only' => ['destroy']]);
         $this->page_name = "Account Type";
    }
    

    public function index(Request $request)
    {
        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_at_limit', $request->limit);
        }else{
             $limit= Session::get('_at_limit') ??  default_pagination();
            
        }

         $base_accounts =\DB::table('main_account_head')->select('id','_name')->get();
         $page_name = $this->page_name;

         // if(!$request->has('_code')){
         //  //  $base_accounts =MainAccountHead::with(['_account_type_group'])->orderBy('id','ASC')->get();
         //  $datas = AccountHead::with(['_main_account_head','children'])->where('_parent_id',0)->get();

         // return view('backend.account-type.p_child_index',compact('page_name','datas','limit','base_accounts'));
         // }
         






       
       
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = AccountHead::with(['_main_account_head','_next_level']);
        $limit = $datas->count();
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_account_id') && $request->_account_id !=''){
            $datas = $datas->where('_account_id',$request->_account_id);
        }
        if($request->has('_parent_id') && $request->_parent_id !=''){
            $datas = $datas->where('_parent_id',$request->_parent_id);
        }

         $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);

         $rearrange_data = array();

            foreach($datas as $key=>$val){
                $rearrange_data[$val->_main_account_head->_name ?? ''][]=$val;
            }

        //return $rearrange_data;
        
        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.account-type.master_print',compact('datas','page_name','request','limit','rearrange_data'));
            }
         }




         
         //return  $base_accounts_key_val;

         

        return view('backend.account-type.index_old',compact('datas','request','page_name','limit','base_accounts','rearrange_data'));

    }



    public function reset(){
        Session::flash('_at_limit');
       return  \Redirect::to('account-type?limit='.default_pagination());
    }


 public function accountTypeForNewLedger(){
        $account_types = \App\Models\AccountHead::with(['_child_group'])
        ->where('_parent_id',0)->orderBy('_name','asc')->get();

        return view('backend.account-type.account_type_options',compact('account_types'));
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
        return view('backend.account-type.create',compact('page_name','account_types'));
    }

       public function parent_wise_child_data(Request $request){
       // return $request->all();
       $_table_name = $request->_table_name ?? '';
       $_compare_cloumn = $request->_compare_cloumn ?? '';
       $_return_cloumn = $request->_return_cloumn ?? '';
       $selected_value = $request->selected_value ?? '';
       $valuePasteClass = $request->valuePasteClass ?? '';
       $second_column = $request->second_column ?? '';
       $second_column_value = $request->second_column_value ?? '';




       $datas = \DB::table($_table_name)->where($_compare_cloumn,'=',$selected_value);
           if($second_column !=''){
            $datas =$datas->where($second_column,'=',$second_column_value);
           }

        $datas =$datas->orderBy($_compare_cloumn,'ASC')
                                        ->get();

        return view('backend.account-type.option',compact('datas','_return_cloumn'));

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
                '_name' => 'required|max:255|unique:account_heads,_name',
            ]);
        $data = new AccountHead();
        $data->_name       = $request->_name ?? '';
        $data->_account_id = $request->_account_id ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_parent_id     = $request->_parent_id ?? 0;
        if($request->_parent_id !=0){
            AccountHead::where('id',$request->_parent_id)->update(['_has_child'=>1]);
            $find_parent_head = AccountHead::find($request->_parent_id)->_level ?? 0;
            $data->_has_parent =1;
            $data->_level =($find_parent_head+1);
        }else{
            $data->_level =1;
        }

       
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountHead  $accountHead
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = AccountHead::with(['_main_account_head','_parent_group'])->find($id);
        return view('backend.account-type.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountHead  $accountHead
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountHead $accountHead,$id)
    {
        $page_name = $this->page_name;
        $data = AccountHead::find($id);
        $account_types = AccountHead::with(['_child_group'])->where('_parent_id',0)->orderBy('_account_id','asc')->get();
        return view('backend.account-type.edit',compact('data','page_name','account_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountHead  $accountHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate([
                '_name' => 'required|max:255|unique:account_heads,_name,'.$request->id,
            ]);
        
        $data = AccountHead::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_account_id = $request->_account_id ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_parent_id     = $request->_parent_id ?? 0;


        if($request->_parent_id !=0){
            AccountHead::where('id',$request->_parent_id)->update(['_has_child'=>1]);
            $find_parent_head = AccountHead::find($request->_parent_id)->_level ?? 0;
            $data->_has_parent =1;
            $data->_level =($find_parent_head+1);
        }else{
            $data->_level =1;
        }

       

        $data->_status     = $request->_status ?? '';
        $data->save();

     $parent_count=   AccountHead::where('_parent_id',$request->_parent_id)->count();
     if($parent_count > 0){

     }else{
        AccountHead::where('id',$request->_parent_id)->update(['_has_child'=>0,'_level'=>1]);
     }

     $_parent_id_second_count=   AccountHead::where('_parent_id_second',$request->_parent_id_second)->count();
     if($_parent_id_second_count > 0){
        AccountHead::where('id',$request->_parent_id_second)->update(['_has_child'=>0,'_level'=>2]);
     }
        


        

        return redirect('account-type')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountHead  $accountHead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $AccountGroup = AccountGroup::where('_account_head_id',$id)->first();
        if($AccountGroup){
           $__message ="You Can not delete this Information";
        $page_name ="Permission Denied";
        return view('backend.message.permission_message',compact('__message','page_name')); 
        }else{

            AccountHead::where('id',$id)->delete();
            return redirect('account-type')->with('success','Information Deleted successfully');
        }
    }
}
