<?php

namespace App\Http\Controllers\RLP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RLP\AccessChainUser;
use App\Models\RLP\RlpAccountDetail;
use App\Models\RLP\RlpAccessChain;
use App\Models\RLP\RlpAcknowledgement;
use App\Models\RLP\RlpDeleteHistory;
use App\Models\RLP\RlpDetail;
use App\Models\RLP\RlpMaster;
use App\Models\RLP\RlpRemarks;
use App\Models\RLP\RlpUserGroup;
use Auth;
use Session;
use DB;

class RlpController extends Controller
{

     function __construct()
    {
        
         $this->middleware('permission:rlp-create', ['only' => ['create','store']]);
         $this->middleware('permission:rlp-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:rlp-list', ['only' => ['index']]);
         $this->middleware('permission:rlp-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.rlp-info');
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
       // return $request->all();
        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_rlp_list_limit', $request->limit);
        }else{
             $limit= \Session::get('_rlp_list_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $page_name=$this->page_name;
        $rlp_ids = [];

        $RlpAcknowledgements = RlpAcknowledgement::select('id','rlp_info_id')->where('user_office_id',$auth_user->user_name)
        ->where('is_visible',1)
        ->where('_is_approve',0)
        ->get();

        foreach($RlpAcknowledgements as $val){
           $rlp_ids[]=$val->rlp_info_id;
        }
         //  $datas =RlpMaster::with(['_item_detail','_account_detail','_rlp_remarks','_rlp_req_user','_emp_department','_emp_designation','_branch','_cost_center','_organization','_entry_by'])->with('_rlp_ack')
         // ->where('is_delete',0)->get();

        $datas = RlpMaster::with(['_emp_department','_emp_designation','_branch','_cost_center','_organization','_entry_by','_item_detail','_account_detail'])
         ->where('is_delete',0);
         if($request->has('rlp_status') && $request->rlp_status !=''){
            $datas = $datas->where('rlp_status','=',$request->rlp_status);
        }elseif($auth_user->user_type !='admin'){
                $datas = $datas->whereIn('id',$rlp_ids);  
        }
         if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('request_date','>=', $_datex);
            $datas = $datas->whereDate('request_date','<=', $_datey);
        }

        if($request->has('id') && $request->id !=""){
             $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->where('id', $ids); 
        }
        
        if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        if($request->has('rlp_no') && $request->rlp_no !=''){
            $datas = $datas->where('rlp_no','like',"%$request->rlp_no%");
        }
        if($request->has('rlp_user_office_id') && $request->rlp_user_office_id !=''){
            $datas = $datas->where('rlp_user_office_id','like',"%$request->rlp_user_office_id%");
        }
        if($request->has('priority') && $request->priority !=''){
            $datas = $datas->where('priority','like',"%$request->priority%");
        }
        if($request->has('request_department') && $request->request_department !=''){
            $datas = $datas->where('request_department','=',$request->request_department);
        }
        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id','=',$request->organization_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','=',$request->_branch_id);
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
			$datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);


        $status_details =\DB::table('status_details')->get();

        return view('rlp-module.rlp.index',compact('page_name','datas','limit','request','status_details'));
    }

     public function reset(){
        Session::flash('_rlp_list_limit');
       return  \Redirect::to('rlp?limit='.default_pagination());
    }


    public function rlpApproveReject(Request $request)
    {
        $users = Auth::user();
        $rlp_inserted_id = $request->rlp_id;
        $rlp_remarks = $request->rlp_remarks ?? '';

        $RlpRemarks = new RlpRemarks();
        $RlpRemarks->rlp_info_id = $rlp_inserted_id;
        $RlpRemarks->user_id = $users->id;
        $RlpRemarks->user_office_id = $users->user_name;
        $RlpRemarks->remarks = $rlp_remarks ?? '';
        $RlpRemarks->remarks_date = date('Y-m-d h:i:s');
        $RlpRemarks->_status = 1;
        $RlpRemarks->save();

        $rlp_action = $request->rlp_action ?? '';

        
        $oldAcknowledgements = RlpAcknowledgement::where('rlp_info_id',$rlp_inserted_id)->get();
        foreach($oldAcknowledgements as $key=>$val){
            if($rlp_action =='approve'){
                if($users->user_name ==$val->user_office_id ){
                    $next_group = ($val->ack_order+1);
                    $ap_data = RlpAcknowledgement::where('id',$val->id)->first();
                    $ap_data->ack_status = 1;
                    $ap_data->_is_approve = 1;
                    $ap_data->_status = 1;
                    $ap_data->ack_updated_date = date('Y-m-d h:i:s');
                    $ap_data->save();
                    RlpAcknowledgement::where('rlp_info_id',$rlp_inserted_id)
                    ->where('ack_order',$next_group)
                    ->update(['is_visible'=>1,'ack_request_date'=>date('Y-m-d h:i:s')]);


                    if($val->ack_order ==4){
                        $_update_data=[ 'rlp_status'=>1,
                                        'updated_at'=>date('Y-m-d h:i:s'),
                                        'updated_by'=>$users->id,
                                        '_lock'=>1
                                         ];
                        
                    }else{
                        $_update_data=['rlp_status'=>6,
                                        'updated_at'=>date('Y-m-d h:i:s'),
                                        'updated_by'=>$users->id,
                                        '_lock'=>0
                                         ];
                    }
                    RlpMaster::where('id',$rlp_inserted_id)->update($_update_data);



                }
            }
            if($rlp_action =='revert'){
                if($users->user_name ==$val->user_office_id){
                    $previous = ($val->ack_order-1);
                    $ap_data = RlpAcknowledgement::where('id',$val->id)->first();
                    $ap_data->is_visible = 0;
                    $ap_data->ack_status = 0;
                    $ap_data->_is_approve = 0;
                    $ap_data->_status = 1;
                    $ap_data->save();
                    RlpAcknowledgement::where('rlp_info_id',$rlp_inserted_id)
                    ->where('ack_order',$previous)
                    ->update(['is_visible'=>1,'ack_status'=>0,'_is_approve'=>0]);

                }
            }
            
        }

        if($rlp_action =='reject'){
            RlpMaster::where('id',$rlp_inserted_id)->update(['rlp_status'=>3,'updated_at'=>date('Y-m-d h:i:s'),'updated_by'=>$users->id]);
        }

        $data['status']=$rlp_action;
        $data['message']="Information ".$rlp_action." successfully";
        return $data;

    }

    public function chainWiseDetail(Request $request)
    {
        $rlp_id = $request->chain_id;
        $datas = RlpAccessChain::with(['_chain_user'])->find($rlp_id);
        $data['data']=$datas;
        return $data;
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
        
        $emp_id = $users->user_name;

        $user_assign_rlp_chain = DB::table("rlp_access_chains as t1")
                                ->select('t1.id')
                                ->join('rlp_access_chain_users as t2','t2.chain_id','t1.id')
                                ->where('t2.user_id',$emp_id)
                                ->where('t1.chain_type','RLP')
                                ->where('t2.user_group',1) // user group 1=Rlp Creator
                                ->groupBy('t1.id')
                                ->get();

 
    $rlp_ids = array();
    foreach($user_assign_rlp_chain as $key=>$val){
        array_push($rlp_ids,$val->id);
    }

   

    $rlp_chains = RlpAccessChain::whereIn('id',$rlp_ids)->get();

        return view('rlp-module.rlp.create',compact('page_name','permited_branch','permited_costcenters','permited_organizations','rlp_chains'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return dump($request->all());
        $this->validate($request, [
            'rlp_prefix' => 'required',
            'priority' => 'required',
            'chain_id' => 'required',
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_cost_center_id' => 'required'
        ]);


       //  DB::beginTransaction();
       // try {

        $users = Auth::user();
        $totalamount = (($request->_total_value_amount ?? 0) + ($request->_total_ledger_amount ?? 0));

        $organization_id = $request->organization_id;
        $_main_branch_id  = $request->_branch_id;

        $RlpMaster = new RlpMaster();
        $RlpMaster->organization_id = $organization_id;
        $RlpMaster->_branch_id = $_main_branch_id;
        $RlpMaster->_cost_center_id = $request->_cost_center_id;
        $RlpMaster->priority = $request->priority;
        $RlpMaster->request_date = change_date_format($request->request_date ?? date('Y-m-d'));
        $RlpMaster->chain_id = $request->chain_id;

        $RlpMaster->rlp_user_id = $users->id; //Taken From Auth user
        $RlpMaster->rlp_user_office_id = $users->user_name ?? ''; //Taken From Auth user

        $RlpMaster->request_department = $request->request_department;
        $RlpMaster->request_person = $request->request_person;
        $RlpMaster->designation = $request->designation;
        $RlpMaster->email = $request->email;
        $RlpMaster->contact_number = $request->contact_number;

        $RlpMaster->rlp_prefix = $request->rlp_prefix;
        $RlpMaster->created_by = $users->id; //Taken From Auth user

        $RlpMaster->user_remarks = $request->user_remarks;
        $RlpMaster->_terms_condition = $request->_terms_condition ?? '';
        $RlpMaster->totalamount = $totalamount ?? 0;
        $RlpMaster->is_viewed = $request->is_viewed ?? 1; //
        $RlpMaster->rlp_status = $request->rlp_status ?? 5;//
        $RlpMaster->is_ns = $request->is_ns ?? 0;// Notesheet create or not
        $RlpMaster->save();
        $rlp_inserted_id = $RlpMaster->id;

        //Item Details Data Insert
        $_item_row_ids = $request->_item_row_id ?? [];
        $_item_ids = $request->_item_id ?? [];
        $_item_descriptions = $request->_item_description ?? [];
        $_transection_units = $request->_transection_unit ?? [];
        $_qtys = $request->_qty ?? [];
        $_rates = $request->_rate ?? [];
        $_values = $request->_value ?? [];
        $supplier_ledger_ids = $request->supplier_ledger_id ?? [];
        $_details_remarkss = $request->_details_remarks ?? [];
        $purposes = $request->purpose ?? [];

        if(sizeof($_item_row_ids) > 0){
            foreach($_item_row_ids as $key=>$val){
                if($val !=0){
                    $RlpDetail = RlpDetail::find($val);
                }else{
                    $RlpDetail = new RlpDetail();
                }
                $RlpDetail->rlp_info_id = $rlp_inserted_id;
                $RlpDetail->_item_id = $_item_ids[$key] ?? 0;
                $RlpDetail->_item_description = $_item_descriptions[$key] ?? '';
                $RlpDetail->purpose = $purposes[$key] ?? '';
                $RlpDetail->quantity = $_qtys[$key] ?? 0;
                $RlpDetail->_unit_id = $_transection_units[$key] ?? 0;
                $RlpDetail->unit_price = $_rates[$key] ?? 0;
                $RlpDetail->amount = $_values[$key] ?? 0;
                $RlpDetail->_ledger_id = $supplier_ledger_ids[$key] ?? 0;
                $RlpDetail->_details_remarks = $_details_remarkss[$key] ?? '';
                $RlpDetail->_status = 1;
                $RlpDetail->save();
                
            }
        }

            //RLP Account Head Detail Data Save
            $_rlp_ledger_row_ids = $request->_rlp_ledger_row_id ?? [];
            $_rlp_ledger_ids = $request->_rlp_ledger_id ?? [];
            $_rlp_ledger_descriptions = $request->_rlp_ledger_description ?? [];
            $_ledger_purposes = $request->_ledger_purpose ?? [];
            $_ledger_amounts = $request->_ledger_amount ?? [];
            $_details_remarkss = $request->_details_remarks ?? [];
            if(sizeof($_rlp_ledger_row_ids) > 0){
                foreach($_rlp_ledger_row_ids as $key=>$val){
                    if($val !=0){
                        $RlpAccountDetail = RlpAccountDetail::find($val);  
                    }else{
                        $RlpAccountDetail = new RlpAccountDetail();
                    }
                    $RlpAccountDetail->rlp_info_id = $rlp_inserted_id;
                    $RlpAccountDetail->_rlp_ledger_id = $_rlp_ledger_ids[$key] ?? 0;
                    $RlpAccountDetail->_rlp_ledger_description = $_rlp_ledger_descriptions[$key] ?? '';
                    $RlpAccountDetail->purpose = $_ledger_purposes[$key] ?? '';
                    $RlpAccountDetail->amount = $_ledger_amounts[$key] ?? 0;
                    $RlpAccountDetail->_details_remarks = $_details_remarkss[$key] ?? '';
                    $RlpAccountDetail->_status = 1;
                    $RlpAccountDetail->save();
                }
            }


            //User Remarks Entry

            if($request->user_remarks !=''){
                $RlpRemarks = new RlpRemarks();
                $RlpRemarks->rlp_info_id = $rlp_inserted_id;
                $RlpRemarks->user_id = $users->id;
                $RlpRemarks->user_office_id = $users->user_name;
                $RlpRemarks->remarks = $request->user_remarks ?? '';
                $RlpRemarks->remarks_date = date('Y-m-d h:i:s');
                $RlpRemarks->_status = 1;
                $RlpRemarks->save();
            }

          $access_chains=  AccessChainUser::where('chain_id',$request->chain_id)->where('_status',1)->get();
         // return dump($access_chains);
          foreach($access_chains as $key=>$val){
                $RlpAcknowledgement = new RlpAcknowledgement();
                $RlpAcknowledgement->rlp_info_id = $rlp_inserted_id;
                $RlpAcknowledgement->user_id = $val->user_row_id ?? 0;
                $RlpAcknowledgement->user_office_id = $val->user_id ?? '';
                $RlpAcknowledgement->ack_order = $val->_order ?? 1;
                

                $RlpAcknowledgement->_status = 1;
                if($users->user_name ==$val->user_id){
                    $RlpAcknowledgement->ack_status = 1;
                    $RlpAcknowledgement->is_visible = 1;
                    $RlpAcknowledgement->ack_request_date = date('Y-m-d h:i:s');
                    $RlpAcknowledgement->ack_updated_date = date('Y-m-d h:i:s');
                }else{
                    $RlpAcknowledgement->ack_status = 0;
                    if($val->_order==2){
                        $RlpAcknowledgement->is_visible = 1;
                        $RlpAcknowledgement->ack_request_date = date('Y-m-d h:i:s');
                    }else{
                        $RlpAcknowledgement->is_visible = 0;
                    }
                }
                $RlpAcknowledgement->_is_approve = 0; //Maker Always take _is_approve ==0;

                $RlpAcknowledgement->save();
          }

           // ack_request_date,ack_updated_date,is_visible,_status 

                    

        $__table="rlp_masters";
        $_pfix = $request->rlp_prefix."-".make_order_number($__table,$organization_id,$_main_branch_id);
        \DB::table('rlp_masters')
             ->where('id',$rlp_inserted_id)
             ->update(['rlp_no'=>$_pfix]);

        $_print_value = $request->_print_value ?? 0;
            $print_url=url('rlp')."/".$rlp_inserted_id;
             $success_message= "Information Save successfully. <a target='__blank' style='color:red;' href='".$print_url."'><i class='fas fa-print'></i></a>";

       // DB::commit();
        $redirect_url = url("/rlp/".$rlp_inserted_id."/edit");
        return redirect($redirect_url)->with('success',$success_message);
        

       // } catch (\Exception $e) {
       //     DB::rollback();
           
       //     return redirect()->back()->with('danger','Information not Save');
       //  }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      
        $users = \Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        
        $emp_id = $users->user_name;

        $user_assign_rlp_chain = \DB::select("SELECT DISTINCT t1.id FROM `rlp_access_chains` as t1
                INNER JOIN rlp_access_chain_users as t2 ON t1.id=t2.chain_id
                    WHERE t2.user_id='".$emp_id."'   AND t2.user_group=1 "); // user group 1=Rlp Creator
    $rlp_ids = array();
    foreach($user_assign_rlp_chain as $key=>$val){
        array_push($rlp_ids,$val->id);
    }

   

    $rlp_chains = RlpAccessChain::whereIn('id',$rlp_ids)->get();
    $data =RlpMaster::with(['_item_detail','_account_detail','_rlp_remarks','_rlp_ack_app','_rlp_req_user','_emp_department','_emp_designation','_branch','_cost_center','_organization'])
      ->where('is_delete',0)->find($id);

     
        $page_name = selected_access_chain_types($data->rlp_prefix ?? 'RLP');
     
//return $data->_rlp_ack;

        return view('rlp-module.rlp.show',compact('page_name','permited_branch','permited_costcenters','permited_organizations','rlp_chains','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data =  RlpMaster::where('_lock',0)->find($id);
         if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }
        $page_name=$this->page_name;
        $users = \Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        
        $emp_id = $users->user_name;

        $user_assign_rlp_chain = \DB::select("SELECT DISTINCT t1.id FROM `rlp_access_chains` as t1
                INNER JOIN rlp_access_chain_users as t2 ON t1.id=t2.chain_id
                    WHERE t2.user_id ='".$emp_id."'    "); // user group 1=Rlp Creator
    $rlp_ids = array();
    foreach($user_assign_rlp_chain as $key=>$val){
        array_push($rlp_ids,$val->id);
    }

   

    $rlp_chains = RlpAccessChain::whereIn('id',$rlp_ids)->get();
    $data =RlpMaster::with(['_item_detail','_account_detail','_rlp_remarks','_rlp_ack','_rlp_ack_app','_rlp_req_user','_emp_department','_emp_designation','_branch','_cost_center','_organization'])->where('is_delete',0)->find($id);

        return view('rlp-module.rlp.edit',compact('page_name','permited_branch','permited_costcenters','permited_organizations','rlp_chains','data'));
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
        $this->validate($request, [
            'rlp_prefix' => 'required',
            'priority' => 'required',
            'chain_id' => 'required',
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_cost_center_id' => 'required'
        ]);
        DB::beginTransaction();
       try {

        $users = Auth::user();
        $totalamount = (($request->_total_value_amount ?? 0) + ($request->_total_ledger_amount ?? 0));

        $organization_id = $request->organization_id;
        $_main_branch_id  = $request->_branch_id;

        $RlpMaster = RlpMaster::find($id);
        $RlpMaster->organization_id = $organization_id;
        $RlpMaster->_branch_id = $_main_branch_id;
        $RlpMaster->_cost_center_id = $request->_cost_center_id;
        $RlpMaster->priority = $request->priority;
        $RlpMaster->request_date = change_date_format($request->request_date ?? date('Y-m-d'));
        $RlpMaster->chain_id = $request->chain_id;

        $RlpMaster->rlp_user_id = $users->id; //Taken From Auth user
        $RlpMaster->rlp_user_office_id = $users->user_name ?? ''; //Taken From Auth user

        $RlpMaster->request_department = $request->request_department;
        $RlpMaster->request_person = $request->request_person;
        $RlpMaster->designation = $request->designation;
        $RlpMaster->email = $request->email;
        $RlpMaster->contact_number = $request->contact_number;
        $RlpMaster->rlp_prefix = $request->rlp_prefix;
        $RlpMaster->created_by = $users->id;

        $RlpMaster->user_remarks = $request->user_remarks;
        $RlpMaster->_terms_condition = $request->_terms_condition ?? '';
        $RlpMaster->totalamount = $totalamount ?? 0;
        $RlpMaster->is_viewed = $request->is_viewed ?? 0; //
        $RlpMaster->rlp_status = $request->rlp_status ?? 6;//
        $RlpMaster->is_ns = $request->is_ns ?? 0;//
        $RlpMaster->save();
        $rlp_inserted_id = $RlpMaster->id;

        //Item Details Data Insert
        $_item_row_ids = $request->_item_row_id ?? [];
        $_item_ids = $request->_item_id ?? [];
        $_item_descriptions = $request->_item_description ?? [];
        $_transection_units = $request->_transection_unit ?? [];
        $_qtys = $request->_qty ?? [];
        $_rates = $request->_rate ?? [];
        $_values = $request->_value ?? [];
        $supplier_ledger_ids = $request->supplier_ledger_id ?? [];
        $_details_remarkss = $request->_details_remarks ?? [];
        $purposes = $request->purpose ?? [];

        RlpAccountDetail::where('rlp_info_id',$rlp_inserted_id)->update(['_status'=>0]);
        RlpDetail::where('rlp_info_id',$rlp_inserted_id)->update(['_status'=>0]);

        if(sizeof($_item_row_ids) > 0){
            foreach($_item_row_ids as $key=>$val){
                if($val !=0){
                    $RlpDetail = RlpDetail::find($val);
                }else{
                    $RlpDetail = new RlpDetail();
                }
                $RlpDetail->rlp_info_id = $rlp_inserted_id;
                $RlpDetail->_item_id = $_item_ids[$key] ?? 0;
                $RlpDetail->_item_description = $_item_descriptions[$key] ?? '';
                $RlpDetail->purpose = $purposes[$key] ?? '';
                $RlpDetail->quantity = $_qtys[$key] ?? 0;
                $RlpDetail->_unit_id = $_transection_units[$key] ?? 0;
                $RlpDetail->unit_price = $_rates[$key] ?? 0;
                $RlpDetail->amount = $_values[$key] ?? 0;
                $RlpDetail->_ledger_id = $supplier_ledger_ids[$key] ?? 0;
                $RlpDetail->_details_remarks = $_details_remarkss[$key] ?? '';
                $RlpDetail->_status = 1;
                $RlpDetail->save();
                
            }
        }


            

            //RLP Account Head Detail Data Save
            $_rlp_ledger_row_ids = $request->_rlp_ledger_row_id ?? [];
            $_rlp_ledger_ids = $request->_rlp_ledger_id ?? [];
            $_rlp_ledger_descriptions = $request->_rlp_ledger_description ?? [];
            $_ledger_purposes = $request->_ledger_purpose ?? [];
            $_ledger_amounts = $request->_ledger_amount ?? [];
            $_details_remarkss = $request->_details_remarks ?? [];
            if(sizeof($_rlp_ledger_row_ids) > 0){
                foreach($_rlp_ledger_row_ids as $key=>$val){
                    if($val !=0){
                        $RlpAccountDetail = RlpAccountDetail::find($val);  
                    }else{
                        $RlpAccountDetail = new RlpAccountDetail();
                    }
                    $RlpAccountDetail->rlp_info_id = $rlp_inserted_id;
                    $RlpAccountDetail->_rlp_ledger_id = $_rlp_ledger_ids[$key] ?? 0;
                    $RlpAccountDetail->_rlp_ledger_description = $_rlp_ledger_descriptions[$key] ?? '';
                    $RlpAccountDetail->purpose = $_ledger_purposes[$key] ?? '';
                    $RlpAccountDetail->amount = $_ledger_amounts[$key] ?? 0;
                    $RlpAccountDetail->_details_remarks = $_details_remarkss[$key] ?? '';
                    $RlpAccountDetail->_status = 1;
                    $RlpAccountDetail->save();
                }
            }


            //User Remarks Entry

            if($request->user_remarks !=''){
                $RlpRemarks = new RlpRemarks();
                $RlpRemarks->rlp_info_id = $rlp_inserted_id;
                $RlpRemarks->user_id = $users->id;
                $RlpRemarks->user_office_id = $users->user_name;
                $RlpRemarks->remarks = $request->user_remarks ?? '';
                $RlpRemarks->remarks_date = date('Y-m-d');
                $RlpRemarks->_status = 1;
                $RlpRemarks->save();
            }

         //  $access_chains=  AccessChainUser::where('chain_id',$request->chain_id)->where('_status',1)->get();
         // // return dump($access_chains);
         //  foreach($access_chains as $key=>$val){
         //        $RlpAcknowledgement = new RlpAcknowledgement();
         //        $RlpAcknowledgement->rlp_info_id = $rlp_inserted_id;
         //        $RlpAcknowledgement->user_id = $val->user_row_id ?? 0;
         //        $RlpAcknowledgement->user_office_id = $val->user_id ?? '';
         //        $RlpAcknowledgement->ack_order = $val->_order ?? 1;
         //        $RlpAcknowledgement->ack_status = 0;
         //        $RlpAcknowledgement->is_visible = 0;
         //        $RlpAcknowledgement->_status = 1;
         //        $RlpAcknowledgement->save();
         //  }

           // ack_request_date,ack_updated_date,is_visible,_status 

                    

       

        $_print_value = $request->_print_value ?? 0;
            $print_url=url('rlp')."/".$rlp_inserted_id;
             $success_message= "Information Save successfully. <a target='__blank' style='color:red;' href='".$print_url."'><i class='fas fa-print'></i></a>";

        DB::commit();
        $redirect_url = url("/rlp/".$rlp_inserted_id."/edit");
        return redirect($redirect_url)->with('success',$success_message);
        

       } catch (\Exception $e) {
           DB::rollback();
           
           return redirect()->back()->with('danger','Information not Save');
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
        RlpMaster::where('id',$id)->update(['is_delete'=>1]);
        return redirect()->back()->with('danger','Information Send to Trash');
    }
}
