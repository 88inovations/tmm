<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\GeneralSettings;
use App\Models\VoucherMaster;
use App\Models\VoucherMasterDetail;
use App\Models\HRM\HrmEmployees;
use Auth;
use Session;
use DB;

use Maatwebsite\Excel\Facades\Excel;
use PDO;

class AccountLedgerController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:account-ledger-list|account-ledger-create|account-ledger-edit|account-ledger-delete', ['only' => ['index','store']]);
         $this->middleware('permission:account-ledger-create', ['only' => ['create','store']]);
         $this->middleware('permission:account-ledger-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:account-ledger-delete', ['only' => ['destroy']]);
         $this->page_name = "Account Ledger";
    }



 public function ledger_excel_upload(Request $request){

  //  return dump($request->all());
        //  $request->validate([
        //     'file' => 'required|mimes:xlsx,xls',
        // ]);
 //DB::beginTransaction();
   //     try {
        

        // try {
            // Load the Excel file
            $file = $request->file('file');
            $data = Excel::toArray([], $file)[0]; // Fetch data as an array


         return   $datas = [];

            foreach ($data as $key => $row) {
                if ($key === 0) {
                    // Skip the header row
                    continue;
                }

                    $datas[]= $row;
                    $reg_id = $row[0];
                    $name = $row[1];
                    $gender = $row[2];
                        
        }

        return  $datas;

         //DB::commit();
            return back()->with('success', 'Members imported successfully.');
       // } catch (\Exception $e) {
       //     DB::rollback();
       //     return redirect()->back()
       //     ->with('request',$request->all())
       //     ->with('danger','There is Something Wrong !');
       //  }


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//     public function index(Request $request)
//     {
//         if($request->has('limit')){
//             $limit = $request->limit ??  default_pagination();
//             session()->put('_al_limit', $request->limit);
//         }else{
//              $limit= \Session::get('_al_limit') ??  default_pagination();
            
//         }
        
        
//         $_asc_desc = $request->_asc_desc ?? 'DESC';
//         $asc_cloumn =  $request->asc_cloumn ?? 'id';
//         $page_name = $this->page_name;
//         $account_types = AccountHead::with(['_child_group'])
//         ->where('_parent_id',0)
//         ->orderBy('_name','asc')->get();
//         $account_groups = [];


//        // if($request->has('id') || $request->has('print')){

//             $datas = AccountLedger::with(['account_type','account_group']);
//         if($request->has('id') && $request->id !=""){
//             $ids =  array_map('intval', explode(',', $request->id ));
//             $datas = $datas->whereIn('id', $ids); 
//         }
//         if($request->has('_name') && $request->_name !=''){
//             $datas = $datas->where('_name','like',"%$request->_name%");
//         }
//         if($request->has('_address') && $request->_address !=''){
//             $datas = $datas->where('_address','like',"%$request->_address%");
//         }
//         if($request->has('_code') && $request->_code !=''){
//             $datas = $datas->where('_code','like',"%$request->_code%");
//         }
//         if($request->has('_nid') && $request->_nid !=''){
//             $datas = $datas->where('_nid','like',"%$request->_nid%");
//         }
//         if($request->has('_note') && $request->_note !=''){
//             $datas = $datas->where('_note','like',"%$request->_note%");
//         }
//         if($request->has('_alious') && $request->_alious !=''){
//             $datas = $datas->where('_alious','like',"%$request->_alious%");
//         }
//         if($request->has('_email') && $request->_email !=''){
//             $datas = $datas->where('_email','like',"%$request->_email%");
//         }
//         if($request->has('_phone') && $request->_phone !=''){
//             $datas = $datas->where('_phone','like',"%$request->_phone%");
//         }
//         if ($request->has('_account_group_id') && $request->_account_group_id !="") {
//             $datas = $datas->where('_account_group_id','=',$request->_account_group_id);
//         }
//         if ($request->has('_branch_id') && $request->_branch_id !="") {
//             $datas = $datas->where('_branch_id','=',$request->_branch_id);
//         }
//         if ($request->has('_account_head_id') && $request->_account_head_id !="") {
//             $datas = $datas->where('_account_head_id','=',$request->_account_head_id);

//             $account_groups = AccountGroup::where('_account_head_id',$request->_account_head_id)->orderBy('_name','asc')->get();
//         }
//        // $limit  =$datas->count();
//         $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        
        
//          $users = Auth::user();
// $permited_branch = permited_branch(explode(',',$users->branch_ids));
         
//           if($request->has('print')){
//             if($request->print =="single"){
//                 return view('backend.account-ledger.master_print',compact('datas','page_name','request','limit','permited_branch'));
//             }
//          }

//         return view('backend.account-ledger.index',compact('datas','page_name','account_types','request','account_groups','limit','permited_branch'));

//         // }else{
//         //      $datas = \App\Models\MainAccountHead::with(['_list_account_heads'])->paginate($limit);


    
//         // return view('backend.account-ledger.index_2',compact('datas','page_name','account_types','request','account_groups','limit'));
//         // }


        
//     }



public function group_wise_list(Request $request){


     $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';


       // $limit  =20;
        $_type = $request->_type ?? 'customer';

        $account_groups_arrays   =[];
        $account_heads_array     =[];
        $account_groups          =[];
        $account_types           =[];

        $page_name =__('label.customer_list');

        $_requested_group_array  = [];
        if($_type =='honorarium'){
        $page_name =__('label._honorarium_group');
            $_requested_group_array  = _honorarium_group_array();
        }
        if($_type =='employee'){
        $page_name =__('label._employee_group');
            $_requested_group_array  = _employee_group_array();
        }

        if($_type =='customer'){
        $page_name =__('label.customer_list');
            $_requested_group_array  = _customer_group_array();
        }
        if($_type =='supplier'){
        $page_name =__('label._supplier_group');
            $_requested_group_array  = _supplier_group_array();
        }
        if($_type =='cash'){
        $page_name =__('label.cash_groups');
            $_requested_group_array  = cash_groups();
        }
        if($_type =='bank'){
        $page_name =__('label._bank_groups');
            $_requested_group_array  = _bank_groups();
        }


        $account_heads_array    = \DB::table("account_groups")->whereIn('id',$_requested_group_array)->pluck('_account_head_id')->toArray();
         $account_groups        = \DB::table("account_groups")->whereIn('id',$_requested_group_array)->get();
         $account_types         = \DB::table('account_heads')->whereIn('id',$account_heads_array)->get();

        $account_group_configs        = \DB::table("account_group_configs")->first();


        $_customer_group              = $account_group_configs->_customer_group ?? '';
        $_supplier_group              = $account_group_configs->_supplier_group ?? '';
        $_employee_group              = $account_group_configs->_employee_group ?? '';
        $_honorarium_group            = $account_group_configs->_honorarium_group ?? '';
        $_cash_group_group            = $account_group_configs->_cash_group_group ?? '';
        $_cash_group                  = $account_group_configs->_cash_group ?? '';
        $_bank_group                  = $account_group_configs->_bank_group ?? '';

        $_customer_group_array        = explode(',', $_customer_group);
        $_supplier_group_array        = explode(',', $_supplier_group);
        $_employee_group_array        = explode(',', $_employee_group);
        $_honorarium_group_array      = explode(',', $_honorarium_group);
        $_cash_group_array            = explode(',', $_cash_group);
        $_bank_group_array            = explode(',', $_bank_group);

        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_al_limit', $request->limit);
        }else{
             $limit= \Session::get('_al_limit') ??  default_pagination();
            
        }
    $users =\Auth::user();
    $branch_ids_array = $users->branch_ids ?? '';

       // if($request->has('id') || $request->has('print')){
            $datas = AccountLedger::with(['account_type','account_group'])->whereIn('_account_group_id',$_requested_group_array);

            $datas = $datas->whereIn('_branch_id', explode(',',$branch_ids_array )); 

        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_address') && $request->_address !=''){
            $datas = $datas->where('_address','like',"%$request->_address%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_nid') && $request->_nid !=''){
            $datas = $datas->where('_nid','like',"%$request->_nid%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%$request->_note%");
        }
        if($request->has('_alious') && $request->_alious !=''){
            $datas = $datas->where('_alious','like',"%$request->_alious%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_phone') && $request->_phone !=''){
            $datas = $datas->where('_phone','like',"%$request->_phone%");
        }
        if ($request->has('_account_group_id') && $request->_account_group_id !="") {
            $datas = $datas->where('_account_group_id','=',$request->_account_group_id);
        }
        if ($request->has('_status') && $request->_status !="") {
            $datas = $datas->where('_status','=',$request->_status);
        }
        if ($request->has('_account_head_id') && $request->_account_head_id !="") {
            $datas = $datas->where('_account_head_id','=',$request->_account_head_id);

            $account_groups = AccountGroup::where('_account_head_id',$request->_account_head_id)->orderBy('_name','asc')->get();
        }
       // $limit= $datas->count();
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc);

        if($request->has('print')){
            $datas = $datas->get();
        }else{
            $datas = $datas->paginate($limit);
            $datas = $datas->appends(['_type' => $_type]);
        }


                        
        
        
        
         
         
        $permited_branch =  permited_branch(explode(',',$users->branch_ids));


        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.account-ledger.group_wise_print',compact('datas','page_name','account_types','request','account_groups','limit','_employee_group_array','permited_branch','_type'));
            }
         }

        return view('backend.account-ledger.group_wise_list',compact('datas','page_name','account_types','request','account_groups','limit','_employee_group_array','permited_branch','_type'));
}


public function group_wise_create(Request $request){


    $users  = \Auth::user();


       // $limit  =20;
        $_type = $request->_type ?? 'customer';

        $account_groups_arrays   =[];
        $account_heads_array     =[];
        $account_groups          =[];
        $account_types           =[];

        $page_name =__('label.customer_list');


        $_requested_group_array  = [];
        if($_type =='honorarium'){
        $page_name =__('label._honorarium_group');
            $_requested_group_array  = _honorarium_group_array();
        }
        if($_type =='employee'){
        $page_name =__('label._employee_group');
            $_requested_group_array  = _employee_group_array();
        }

       
        if($_type =='supplier'){
        $page_name =__('label._supplier_group');
            $_requested_group_array  = _supplier_group_array();
        }

        if($_type =='customer'){
            $page_name =__('label.customer_list');
            $_requested_group_array  = _customer_group_array();
        }


        if($_type =='cash'){
        $page_name =__('label.cash_groups');
            $_requested_group_array  = cash_groups();
        }
        if($_type =='bank'){
        $page_name =__('label._bank_groups');
            $_requested_group_array  = _bank_groups();
        }


        $account_heads_array    = \DB::table("account_groups")->whereIn('id',$_requested_group_array)->pluck('_account_head_id')->toArray();
         $account_groups        = \DB::table("account_groups")->whereIn('id',$_requested_group_array)->get();
         $account_types         = \DB::table('account_heads')->whereIn('id',$account_heads_array)->get();

        $account_group_configs        = \DB::table("account_group_configs")->first();


        $_customer_group              = $account_group_configs->_customer_group ?? '';
        $_supplier_group              = $account_group_configs->_supplier_group ?? '';
        $_employee_group              = $account_group_configs->_employee_group ?? '';
        $_honorarium_group            = $account_group_configs->_honorarium_group ?? '';
        $_cash_group_group            = $account_group_configs->_cash_group_group ?? '';
        $_cash_group                  = $account_group_configs->_cash_group ?? '';
        $_bank_group                  = $account_group_configs->_bank_group ?? '';

        $_customer_group_array        = explode(',', $_customer_group);
        $_supplier_group_array        = explode(',', $_supplier_group);
        $_employee_group_array        = explode(',', $_employee_group);
        $_honorarium_group_array      = explode(',', $_honorarium_group);
        $_cash_group_array            = explode(',', $_cash_group);
        $_bank_group_array            = explode(',', $_bank_group);

        
        
        
         
         
        $permited_branch =  permited_branch(explode(',',$users->branch_ids));

        return view('backend.account-ledger.group_wise_create',compact('page_name','account_types','request','account_groups','permited_branch'));
}


public function customer_list(Request $request)
    {

      $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        $page_name =__('label.customer_list');
       // $limit  =20;
         $_customer_group_array  = _customer_group_array();
        $account_heads_array   = \DB::table("account_groups")->whereIn('id',$_customer_group_array)->pluck('_account_head_id')->toArray();
        $account_groups     = \DB::table("account_groups")->whereIn('id',$_customer_group_array)->get();
         $account_types  = \DB::table('account_heads')->whereIn('id',$account_heads_array)->get();

        $account_group_configs        = \DB::table("account_group_configs")->first();
        $_customer_group              = $account_group_configs->_customer_group ?? '';
        $_supplier_group              = $account_group_configs->_supplier_group ?? '';
        $_employee_group              = $account_group_configs->_employee_group ?? '';

        $_customer_group_array        = explode(',', $_customer_group);
        $_supplier_group_array        = explode(',', $_supplier_group);
        $_employee_group_array        = explode(',', $_employee_group);

        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_al_limit', $request->limit);
        }else{
             $limit= \Session::get('_al_limit') ??  default_pagination();
            
        }
    $users =\Auth::user();
    $branch_ids_array = $users->branch_ids ?? '';

       // if($request->has('id') || $request->has('print')){
            $datas = AccountLedger::with(['account_type','account_group'])->whereIn('_account_group_id',$_customer_group_array);

            $datas = $datas->whereIn('_branch_id', explode(',',$branch_ids_array )); 

        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_address') && $request->_address !=''){
            $datas = $datas->where('_address','like',"%$request->_address%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_nid') && $request->_nid !=''){
            $datas = $datas->where('_nid','like',"%$request->_nid%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%$request->_note%");
        }
        if($request->has('_alious') && $request->_alious !=''){
            $datas = $datas->where('_alious','like',"%$request->_alious%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_phone') && $request->_phone !=''){
            $datas = $datas->where('_phone','like',"%$request->_phone%");
        }
        if ($request->has('_account_group_id') && $request->_account_group_id !="") {
            $datas = $datas->where('_account_group_id','=',$request->_account_group_id);
        }
        if ($request->has('_status') && $request->_status !="") {
            $datas = $datas->where('_status','=',$request->_status);
        }
        if ($request->has('_account_head_id') && $request->_account_head_id !="") {
            $datas = $datas->where('_account_head_id','=',$request->_account_head_id);

            $account_groups = AccountGroup::where('_account_head_id',$request->_account_head_id)->orderBy('_name','asc')->get();
        }
       // $limit= $datas->count();
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc);
        if($request->has('print')){
            $datas = $datas->get();
        }else{
            $datas = $datas->paginate($limit);
        }

        
        
        
         $_type = 'customer';
         
        $permited_branch =  permited_branch(explode(',',$users->branch_ids));

        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.account-ledger.group_wise_print',compact('datas','page_name','account_types','request','account_groups','limit','_employee_group_array','permited_branch','_type'));
            }
         }



        return view('backend.account-ledger.customer_list',compact('datas','page_name','account_types','request','account_groups','limit','_employee_group_array','permited_branch'));

        // }else{
        //      $datas =  AccountHead::with(['_child_group','_list_account_group'])->where('_parent_id',0)->get();

        //     return view('backend.account-ledger.index_4',compact('page_name','account_types','account_groups','limit','datas','_employee_group_array'));
        // }


        
    }

    public function customer_create(){

       // $config_data = \DB::table('account_group_configs')->first();

        $_customer_group_array  = _customer_group_array();
        $account_heads_array   = \DB::table("account_groups")->whereIn('id',$_customer_group_array)->pluck('_account_head_id')->toArray();
        $account_groups     = \DB::table("account_groups")->whereIn('id',$_customer_group_array)->get();
         $account_types  = \DB::table('account_heads')->whereIn('id',$account_heads_array)->get();




         return view('backend.account-ledger.customer_create',compact('account_groups','account_types'));





    }

    public function customer_store(Request $request){
       // return $request->all();
        $_account_head_id = $request->_account_head_id;

      //   $group_code = AccountGroup::find($request->_account_group_id)->_code ?? '';

         
      //  return _ledger_code($_account_head_id);

    //Group Wise 
        $data = new AccountLedger();
        $data->_account_head_id = $request->_account_head_id;
        $data->_account_group_id = $request->_account_group_id;
        $_main_account_id = id_to_cloumn($request->_account_head_id,'_account_id','account_heads');
        $data->_main_account_id = $_main_account_id;

        $data->organization_id = $request->organization_id ?? 1;
        $data->_branch_id = $request->_branch_id ?? 1;
        $data->_cost_center_id = $request->_cost_center_id ?? 1;


        $data->_name = $request->_name ?? '';
        $data->_address = $request->_address ?? '';

        //Honoriam 
        $data->_designation = $request->_designation ?? '';
        $data->_specialist = $request->_specialist ?? '';
        $data->_address_2 = $request->_address_2 ?? '';
        $data->_date_of_birth = $request->_date_of_birth ?? '';
        $data->_whatsup_number = $request->_whatsup_number ?? '';
        $data->_reg_no = $request->_reg_no ?? '';


        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                $data->_image = $_image;
        }


        $data->_code = $request->_code ?? _ledger_code($_account_head_id);
        $data->_nid = $request->_nid ?? '';
        $data->_note = $request->_note ?? '';
        $data->_alious = $request->_alious ?? '';
        $data->_email = $request->_email ?? '';
        $data->_phone = $request->_phone ?? '';
        $data->_credit_limit = $request->_credit_limit ?? 0;
        $data->_short = $request->_short ?? 5;
        $data->_is_user = $request->_is_user ?? 0;
        $data->_is_sales_form = $request->_is_sales_form ?? 1;
        $data->_is_purchase_form = $request->_is_purchase_form ?? 1;
        $data->_is_all_branch = $request->_is_all_branch ?? 1;
        $data->opening_dr_amount = $request->opening_dr_amount ?? 0;
        $data->opening_cr_amount = $request->opening_cr_amount ?? 0;
        $data->_status = $request->_status;
        $data->_show = 1;
        $data->_is_used = 1;
        $data->_created_by = Auth::user()->id."-".Auth::user()->name;
         
        $data->save();


      


        return redirect()->back()->with('success','Information Save successfully');



    }



     public function index(Request $request)
    {

      $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        $page_name = $this->page_name;
       // $limit  =20;
         $account_types = AccountHead::with(['_child_group'])->orderBy('_name','asc')->get();
        $account_groups = [];

        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_al_limit', $request->limit);
        }else{
             $limit= \Session::get('_al_limit') ??  default_pagination();
            
        }

          $account_group_configs        = \DB::table("account_group_configs")->first();
        $_customer_group              = $account_group_configs->_customer_group ?? '';
        $_supplier_group              = $account_group_configs->_supplier_group ?? '';
        $_employee_group              = $account_group_configs->_employee_group ?? '';

        $_customer_group_array        = explode(',', $_customer_group);
        $_supplier_group_array        = explode(',', $_supplier_group);
        $_employee_group_array        = explode(',', $_employee_group);


       // if($request->has('id') || $request->has('print')){
            $datas = AccountLedger::with(['account_type','account_group']);
        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_address') && $request->_address !=''){
            $datas = $datas->where('_address','like',"%$request->_address%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_nid') && $request->_nid !=''){
            $datas = $datas->where('_nid','like',"%$request->_nid%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%$request->_note%");
        }
        if($request->has('_alious') && $request->_alious !=''){
            $datas = $datas->where('_alious','like',"%$request->_alious%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_phone') && $request->_phone !=''){
            $datas = $datas->where('_phone','like',"%$request->_phone%");
        }
        if ($request->has('_account_group_id') && $request->_account_group_id !="") {
            $datas = $datas->where('_account_group_id','=',$request->_account_group_id);
        }
        if ($request->has('_status') && $request->_status !="") {
            $datas = $datas->where('_status','=',$request->_status);
        }
        if ($request->has('_branch_id') && $request->_branch_id !="") {
            $datas = $datas->where('_branch_id','=',$request->_branch_id);
        }
        if ($request->has('_account_head_id') && $request->_account_head_id !="") {
            $datas = $datas->where('_account_head_id','=',$request->_account_head_id);

            $account_groups = AccountGroup::where('_account_head_id',$request->_account_head_id)->orderBy('_name','asc')->get();
        }
       // $limit= $datas->count();
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        
        
         $users = Auth::user();
$permited_branch = permited_branch(explode(',',$users->branch_ids));
         
          if($request->has('print')){
            if($request->print =="single"){
                return view('backend.account-ledger.master_print',compact('datas','page_name','request','limit','permited_branch'));
            }
         }

        return view('backend.account-ledger.index',compact('datas','page_name','account_types','request','account_groups','limit','_employee_group_array','permited_branch'));

        // }else{
        //      $datas =  AccountHead::with(['_child_group','_list_account_group'])->where('_parent_id',0)->get();

        //     return view('backend.account-ledger.index_4',compact('page_name','account_types','account_groups','limit','datas'));
        // }


        
    }

    public function copy_to_employee($id){
       $account_ledger = \DB::table("account_ledgers")->find($id);
       $_ledger_id = $account_ledger->id ?? '' ;
        $auth_user = Auth::user();

            $data =  HrmEmployees::where('_ledger_id',$_ledger_id)->first();
            if(empty($data)){
                 $data = new HrmEmployees();
             }
           
            $data->_name =$account_ledger->_name ?? '';
            $data->_code =$account_ledger->_code ?? employee_code($account_ledger->organization_id);
            $data->_mobile1 =$account_ledger->_phone ?? '';
            $data->_nid =$account_ledger->_nid ?? '';
            
            $data->_email =$account_ledger->_email ?? '';
            $data->_cost_center_id =$account_ledger->_cost_center_id ?? 1;
            $data->_branch_id =$account_ledger->_branch_id ?? 1;
            $data->organization_id =$account_ledger->organization_id ?? 1;
            $data->_active =1;
            $data->_ledger_id =$account_ledger->id;
            $data->user_id =$account_ledger->_user_id; //Users Table ID
            $data->_status =1;
            $data->_user = $auth_user->id;
            $data->_created_by = $auth_user->id."-".$auth_user->_name;
            $data->save();
                return redirect()->back()
                        ->with('success','Information save successfully');

    }


     public function reset(){
        Session::flash('_al_limit');
       return  \Redirect::to('account-ledger?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_name = $this->page_name;
        $account_types = AccountHead::with(['_child_group'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        if ($request->ajax()) {
            return view('backend.account-ledger.create_ajax',compact('account_types','page_name','account_groups','branchs'));

        }else{
            return view('backend.account-ledger.create',compact('account_types','page_name','account_groups','branchs'));
        }

       
    }

    public function ledger_search(Request $request){
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_name';
        $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        $_head_no = $request->_head_no ?? 0;
        $datas = AccountLedger::select('id','_name','_alious','_code','_address','_balance','_phone','_branch_id','_credit_limit')->with(['_entry_branch'])
        ->where('_status',1);
         if($_head_no !=0){
            $datas = $datas->where('_account_head_id','=',$_head_no);
        }
         if($request->has('_text_val') && $text_val !=''){
            $datas = $datas->where('_name','like',"%$text_val%")
            ->orWhere('_code','like',"%$text_val%")
            ->orWhere('id','like',"%$text_val%");
        }
       
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }

    public function mainLedgerSearch(Request $request){
     //  return $request->all();

        $users = \Auth::user();
        
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_name';
        $text_val = $request->_text_val ?? '';
        $_form = $request->_form ?? 0;
         $_branch_id = $request->_branch_id ?? '';
         if($_branch_id=='' || $_branch_id=='all'){
            $_branch_ids = explode(',',$users->branch_ids);
            }else{
                $_branch_ids = explode(',',$request->_branch_id);
            }
        $_form_name = $request->_form_name ?? '';



        $datas = AccountLedger::select('id','_name','_code','_address','_balance','_phone','_alious','_credit_limit','_branch_id')->with(['_entry_branch'])->where('_status',1);
        if($_form_name =='sales' || $_form_name =='branch_wise_sales_statement' || $_form_name =='sales_orders' || $_form_name =='receive_payments'){

            $customer_groups = DB::table("account_group_configs")->first()->_customer_group ?? '';
             $_group_ids = explode(',',$customer_groups);

            $datas = $datas->whereIn('_branch_id',$_branch_ids);
            $datas = $datas->whereIn('_account_group_id',$_group_ids);
        }

       
        if($_form ==2){
            $datas = $datas->where('_is_sales_form','=',1);
        }
        if($_form ==1){
           $datas = $datas->where('_is_purchase_form','=',1);
        }
        
        if (!empty($text_val)) {
                $datas = $datas->where(function ($query) use ($text_val) {
                    $query->where('_name', 'like', "%$text_val%")
                        ->orWhere('id', 'like', "%$text_val%")
                        ->orWhere('_code', 'like', "%$text_val%")
                        ->orWhere('_phone', 'like', "%$text_val%");
                });
            }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dump($request->all());
      //  die();
        
        $this->validate($request, [
            '_account_head_id' => 'required',
            '_account_group_id' => 'required',
            '_branch_id' => 'required',
            '_name' => 'required',
            '_status' => 'required'
        ]);
// DB::beginTransaction();
//        try {
    $group_code = AccountGroup::find($request->_account_group_id)->_code ?? '';
    //Group Wise 
        $data = new AccountLedger();
        $data->_account_head_id = $request->_account_head_id;
        $data->_account_group_id = $request->_account_group_id;
        $_main_account_id = id_to_cloumn($request->_account_head_id,'_account_id','account_heads');
        $data->_main_account_id = $_main_account_id;

        $data->organization_id = $request->organization_id ?? 1;
        $data->_branch_id = $request->_branch_id ?? 1;
        $data->_cost_center_id = $request->_cost_center_id ?? 1;
        $data->_name = $request->_name ?? '';
        $data->_address = $request->_address ?? '';
        $data->_code = $request->_code ?? '';
        $data->_nid = $request->_nid ?? '';
        $data->_note = $request->_note ?? '';
        $data->_alious = $request->_alious ?? '';
        $data->_email = $request->_email;
        $data->_phone = $request->_phone;
        $data->_credit_limit = $request->_credit_limit ?? 0;
        $data->_short = $request->_short ?? 5;
        $data->_is_user = $request->_is_user ?? 1;
        $data->_is_sales_form = $request->_is_sales_form ?? 1;
        $data->_is_purchase_form = $request->_is_purchase_form ?? 1;
        $data->_is_all_branch = $request->_is_all_branch ?? 1;
        $data->opening_dr_amount = $request->opening_dr_amount ?? 0;
        $data->opening_cr_amount = $request->opening_cr_amount ?? 0;
        $data->_status = $request->_status ?? 1;

        //Honoriam 
        $data->_designation = $request->_designation ?? '';
        $data->_specialist = $request->_specialist ?? '';
        $data->_address_2 = $request->_address_2 ?? '';
        $data->_date_of_birth = $request->_date_of_birth ?? '';
        $data->_whatsup_number = $request->_whatsup_number ?? '';
        $data->_reg_no = $request->_reg_no ?? '';


        $data->_show = 1;
        $data->_is_used = 1;
        $data->_created_by = Auth::user()->id."-".Auth::user()->name;
         if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                $data->_image = $_image;
        }
        if($request->hasFile('_nidimage')){ 
                $_nidimage = UserNidUpload($request->_nidimage); 
                $data->_nid_image =  $_nidimage;
        }
        
        if($request->hasFile('_checkbookpageimage')){ 
                $_checkbookpageimage = UserCheckbookpageUpload($request->_checkbookpageimage); 
                
                
                $data->_checkpage_image =  $_checkbookpageimage;
        }
        $data->save();

        $ledger_id = $data->id;

        $settings = GeneralSettings::select('_opening_ledger')->first();
        $_opening_ledger = $settings->_opening_ledger ?? 0;
        $opening_dr_amount =$request->opening_dr_amount ?? 0;
        $opening_cr_amount =$request->opening_cr_amount ?? 0;
        $_total_dr_amount = 0;
        if($opening_dr_amount > 0){
            $_total_dr_amount = $opening_dr_amount;
        }
        if($opening_cr_amount > 0){
            $_total_dr_amount = $opening_cr_amount;
        }
        
        if($_opening_ledger !=0 && $_total_dr_amount > 0 ){

            $users = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster = new VoucherMaster();
            $VoucherMaster->_date =date('Y-m-d');
            $VoucherMaster->_voucher_type = 'JV';
            $VoucherMaster->_branch_id = $request->_branch_id;
            $VoucherMaster->_transection_ref = $request->_transection_ref ?? '';
            $VoucherMaster->_amount = $_total_dr_amount;
            $VoucherMaster->_note = 'Opening Balance';
            $VoucherMaster->_form_name = 'voucher_masters';
            $VoucherMaster->_lock = $request->_lock ?? 0;
            $VoucherMaster->_cost_center_id = $request->_ledger_cost_center_id ?? 1;
            $VoucherMaster->_status =1;
            $VoucherMaster->_created_by = $users->id."-".$users->name;
            $VoucherMaster->_user_id = $users->id;
            $VoucherMaster->_user_name = $users->name;
            $VoucherMaster->_time = date('H:i:s');
            $VoucherMaster->save();
            $master_id = $VoucherMaster->id;
            VoucherMaster::where('id',$master_id )->update(['_code'=>voucher_prefix().$master_id]);

           

            if($opening_dr_amount > 0 || $opening_cr_amount > 0){
               
                    $_account_type_id =  ledger_to_group_type($ledger_id)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($ledger_id)->_account_group_id;

                    $VoucherMasterDetail = new VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $_account_group_id;
                    $VoucherMasterDetail->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $VoucherMasterDetail->_branch_id = $request->_branch_id;
                    $VoucherMasterDetail->_short_narr = 'Opening Balance';

                    $VoucherMasterDetail->_ledger_id = $ledger_id;
                     if($opening_dr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = $opening_dr_amount ?? 0;
                        $VoucherMasterDetail->_cr_amount =  0;
                    }
                    if($opening_cr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = 0;
                        $VoucherMasterDetail->_cr_amount =  $opening_cr_amount ?? 0;
                    }

                    $VoucherMasterDetail->_dr_amount = $opening_dr_amount ?? 0;
                    $VoucherMasterDetail->_cr_amount = $opening_cr_amount ?? 0;

                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;



                    //Reporting Account Table Data Insert

                    $Accounts = new Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = 'Opening Balance';
                    $Accounts->_narration = 'Opening Balance';
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = date('Y-m-d');
                    $Accounts->_table_name = 'voucher_masters';
                    $Accounts->_account_head = $_account_type_id;
                    $Accounts->_account_group = $_account_group_id;

                    $Accounts->_account_ledger = $ledger_id;
                    if($opening_dr_amount > 0){
                        $Accounts->_dr_amount = $opening_dr_amount ?? 0;
                        $Accounts->_cr_amount = 0;
                    }
                    if($opening_cr_amount > 0){
                        $Accounts->_dr_amount = 0;
                        $Accounts->_cr_amount = $opening_cr_amount ?? 0;
                    }

                    $Accounts->_branch_id = $request->_branch_id;
                    $Accounts->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();
               
                    $_account_type_id =  ledger_to_group_type($_opening_ledger)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($_opening_ledger)->_account_group_id;

                    $VoucherMasterDetail = new VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $_account_group_id;
                    $VoucherMasterDetail->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $VoucherMasterDetail->_branch_id = $request->_branch_id;
                    $VoucherMasterDetail->_short_narr = 'Opening Balance';

                    $VoucherMasterDetail->_ledger_id = $_opening_ledger;
                    if($opening_dr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = 0;
                        $VoucherMasterDetail->_cr_amount =  $opening_dr_amount ?? 0;
                    }
                    if($opening_cr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = $opening_cr_amount ?? 0;
                        $VoucherMasterDetail->_cr_amount =  0;
                    }
                    

                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;
                    //Reporting Account Table Data Insert

                    $Accounts = new Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = 'Opening Balance';
                    $Accounts->_narration = 'Opening Balance';
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = date('Y-m-d');
                    $Accounts->_table_name = 'voucher_masters';
                    $Accounts->_account_head = $_account_type_id;
                    $Accounts->_account_group = $_account_group_id;

                    $Accounts->_account_ledger = $_opening_ledger;
                    

                    if($opening_dr_amount > 0){
                        $Accounts->_dr_amount = 0;
                        $Accounts->_cr_amount = $opening_dr_amount ?? 0;
                    }
                    if($opening_cr_amount > 0){
                        $Accounts->_dr_amount = $opening_cr_amount ?? 0;
                        $Accounts->_cr_amount = 0;
                    }

                    $Accounts->_branch_id = $request->_branch_id;
                    $Accounts->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();
            }

        }


          //  DB::commit();
        return redirect()->back()->with('success','Information save successfully');
       // } catch (\Exception $e) {
       //     DB::rollback();
       //     return redirect()->back()->with('danger','Information not Save');
       //  }





        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxLedgerSave(Request $request)
    {
        
        $ledger_name = trim($request->_ledger_name ?? '');
        $old_ledger_check = AccountLedger::where('_name',$ledger_name)->first();
        // if($old_ledger_check){
        //     $id = 0;
        //     return $id;
        // }



        
        $data = new AccountLedger();
        $data->_account_head_id = $request->_account_head_id;
        $data->_account_group_id = $request->_account_groups;
        $data->_branch_id = $request->_ledger_branch_id;
        $data->_name = $request->_ledger_name;
        $data->_address = $request->_ledger_address;
        $data->_code = $request->_ledger_code;
        $data->_nid = $request->_ledger_nid;

         $_main_account_id = id_to_cloumn($request->_account_head_id,'_account_id','account_heads');
        $data->_main_account_id = $_main_account_id;
        
        $data->_email = $request->_ledger_email;
        $data->_phone = $request->_ledger_phone;
        $data->_credit_limit = $request->_ledger_credit_limit ?? 0;
        $data->_short = $request->_ledger_short ?? 5;
        $data->_is_user = $request->_ledger_is_user ?? 0;
        $data->_is_sales_form = $request->_ledger_is_sales_form ?? 1;
        $data->_is_purchase_form = $request->_ledger_is_purchase_form ?? 1;
        $data->_is_all_branch = $request->_ledger_is_all_branch ?? 1;
        $data->_status = $request->_ledger_status;
        $data->_show =1;
        $data->_created_by = Auth::user()->id."-".Auth::user()->name;
        $data->save();
        $id = $data->id;


        $ledger_id = $data->id;

        $settings = GeneralSettings::select('_opening_ledger')->first();
        $_opening_ledger = $settings->_opening_ledger ?? 0;
        $opening_dr_amount =$request->opening_dr_amount ?? 0;
        $opening_cr_amount =$request->opening_cr_amount ?? 0;
        $_total_dr_amount =0;
        if($opening_dr_amount > 0){
            $_total_dr_amount = $opening_dr_amount;
        }
        if($opening_cr_amount > 0){
            $_total_dr_amount = $opening_cr_amount;
        }
        
        if($_opening_ledger !=0 && $_total_dr_amount > 0){

            $users = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster = new VoucherMaster();
            $VoucherMaster->_date =date('Y-m-d');
            $VoucherMaster->_voucher_type = 'JV';
            $VoucherMaster->_branch_id = $request->_ledger_branch_id;
            $VoucherMaster->_transection_ref = $request->_transection_ref ?? '';
            $VoucherMaster->_amount = $_total_dr_amount;
            $VoucherMaster->_note = 'Opening Balance';
            $VoucherMaster->_form_name = 'voucher_masters';
            $VoucherMaster->_lock = $request->_lock ?? 0;
            $VoucherMaster->organization_id = $request->_ledger_organization_id ?? 1;
            $VoucherMaster->_cost_center_id = $request->_ledger_cost_center_id ?? 1;
            $VoucherMaster->_status =1;
            $VoucherMaster->_created_by = $users->id."-".$users->name;
            $VoucherMaster->_user_id = $users->id;
            $VoucherMaster->_user_name = $users->name;
            $VoucherMaster->_time = date('H:i:s');
            $VoucherMaster->save();
            $master_id = $VoucherMaster->id;
            VoucherMaster::where('id',$master_id )->update(['_code'=>voucher_prefix().$master_id]);

           

            if($opening_dr_amount > 0 || $opening_cr_amount > 0){
               

                   $_account_type_id =  ledger_to_group_type($ledger_id)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($ledger_id)->_account_group_id;

                    $VoucherMasterDetail = new VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $_account_group_id;
                    $VoucherMasterDetail->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $VoucherMasterDetail->organization_id = $request->_ledger_organization_id ?? 1;
                    $VoucherMasterDetail->_branch_id = $request->_ledger_branch_id ?? 1;
                    $VoucherMasterDetail->_short_narr = 'Opening Balance';

                    $VoucherMasterDetail->_ledger_id = $ledger_id;
                     if($opening_dr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = $opening_dr_amount ?? 0;
                        $VoucherMasterDetail->_cr_amount =  0;
                    }
                    if($opening_cr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = 0;
                        $VoucherMasterDetail->_cr_amount =  $opening_cr_amount ?? 0;
                    }

                    $VoucherMasterDetail->_dr_amount = $opening_dr_amount ?? 0;
                    $VoucherMasterDetail->_cr_amount = $opening_cr_amount ?? 0;

                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;



                    //Reporting Account Table Data Insert

                    $Accounts = new Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = 'Opening Balance';
                    $Accounts->_narration = 'Opening Balance';
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = date('Y-m-d');
                    $Accounts->_table_name = 'voucher_masters';
                    $Accounts->_account_head = $_account_type_id;
                    $Accounts->_account_group = $_account_group_id;

                    $Accounts->_account_ledger = $ledger_id;
                    if($opening_dr_amount > 0){
                        $Accounts->_dr_amount = $opening_dr_amount ?? 0;
                        $Accounts->_cr_amount = 0;
                    }
                    if($opening_cr_amount > 0){
                        $Accounts->_dr_amount = 0;
                        $Accounts->_cr_amount = $opening_cr_amount ?? 0;
                    }

                    $Accounts->organization_id = $request->_ledger_organization_id ?? 1;
                    $Accounts->_branch_id = $request->_ledger_branch_id ?? 1;
                    $Accounts->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();
               
                    $_account_type_id =  ledger_to_group_type($_opening_ledger)->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($_opening_ledger)->_account_group_id;

                    $VoucherMasterDetail = new VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $_account_group_id;
                    $VoucherMasterDetail->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $VoucherMasterDetail->organization_id = $request->_ledger_organization_id ?? 1;
                    $VoucherMasterDetail->_branch_id = $request->_ledger_branch_id ?? 1;
                    $VoucherMasterDetail->_short_narr = 'Opening Balance';

                    $VoucherMasterDetail->_ledger_id = $_opening_ledger;
                    if($opening_dr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = 0;
                        $VoucherMasterDetail->_cr_amount =  $opening_dr_amount ?? 0;
                    }
                    if($opening_cr_amount > 0){
                        $VoucherMasterDetail->_dr_amount = $opening_cr_amount ?? 0;
                        $VoucherMasterDetail->_cr_amount =  0;
                    }
                    

                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;
                    //Reporting Account Table Data Insert

                    $Accounts = new Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                    $Accounts->_short_narration = 'Opening Balance';
                    $Accounts->_narration = 'Opening Balance';
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_transaction = 'Account';
                    $Accounts->_date = date('Y-m-d');
                    $Accounts->_table_name = 'voucher_masters';
                    $Accounts->_account_head = $_account_type_id;
                    $Accounts->_account_group = $_account_group_id;

                    $Accounts->_account_ledger = $_opening_ledger;
                    

                    if($opening_dr_amount > 0){
                        $Accounts->_dr_amount = 0;
                        $Accounts->_cr_amount = $opening_dr_amount ?? 0;
                    }
                    if($opening_cr_amount > 0){
                        $Accounts->_dr_amount = $opening_cr_amount ?? 0;
                        $Accounts->_cr_amount = 0;
                    }

                    $Accounts->organization_id = $request->_ledger_organization_id ?? 1;
                    $Accounts->_branch_id = $request->_ledger_branch_id ?? 1;
                    $Accounts->_cost_center = $request->_ledger_cost_center_id ?? 1;
                    $Accounts->_name =$users->name;
                    $Accounts->save();
            }
        }
        return $id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountLedger  $accountLedger
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = AccountLedger::with(['account_type','account_group','last_balance'])->find($id);
        $page_name = $this->page_name;
        return view('backend.account-ledger.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountLedger  $accountLedger
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountLedger $accountLedger)
    {
        //return $accountLedger;
        $data = $accountLedger;
        $page_name = $this->page_name;
        $account_types = AccountHead::with(['_child_group'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')
                        ->where('_account_head_id',$data->_account_head_id)
                        ->orderBy('_name','asc')
                        ->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        
       return view('backend.account-ledger.edit',compact('account_types','page_name','account_groups','branchs','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountLedger  $accountLedger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            '_account_head_id' => 'required',
            '_account_group_id' => 'required',
            '_branch_id' => 'required',
            '_name' => 'required',
            '_status' => 'required'
        ]);
        $data = AccountLedger::find($request->id);
        $data->_account_head_id = $request->_account_head_id;
        $data->_account_group_id = $request->_account_group_id;

        $_main_account_id = id_to_cloumn($request->_account_head_id,'_account_id','account_heads');
        $data->_main_account_id = $_main_account_id;

        $data->_branch_id = $request->_branch_id ?? 1;
        $data->_name = $request->_name ?? '';
        $data->_address = $request->_address;
         $data->_alious = $request->_alious ?? '';
        $data->_code = $request->_code;
        $data->_nid = $request->_nid;
        $data->_note = $request->_note;
        $data->_email = $request->_email;
        $data->_phone = $request->_phone;
        $data->_credit_limit = $request->_credit_limit ?? 0;
        $data->_short = $request->_short ?? 5;
        $data->_is_user = $request->_is_user ?? 1;
        $data->_is_sales_form = $request->_is_sales_form ?? 1;
        $data->_is_purchase_form = $request->_is_purchase_form ?? 1;
        $data->_is_all_branch = $request->_is_all_branch ?? 1;
        $data->_status = $request->_status ?? 1;

        //Honoriam 
        $data->_designation = $request->_designation ?? '';
        $data->_specialist = $request->_specialist ?? '';
        $data->_address_2 = $request->_address_2 ?? '';
        $data->_date_of_birth = $request->_date_of_birth ?? '';
        $data->_whatsup_number = $request->_whatsup_number ?? '';
        $data->_reg_no = $request->_reg_no ?? '';


        $data->_updated_by = Auth::user()->id."-".Auth::user()->name;
         if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                
                
                $data->_image = $_image;
        }
        if($request->hasFile('_nidimage')){ 
                $_nidimage = UserNidUpload($request->_nidimage); 
                $data->_nid_image =  $_nidimage;
        }
        
        if($request->hasFile('_checkbookpageimage')){ 
                $_checkbookpageimage = UserCheckbookpageUpload($request->_checkbookpageimage); 
                $data->_checkpage_image =  $_checkbookpageimage;
        }

        $data->save();
    //return $data->id;
        //if Update Account Ledger Then Update All Transection Table

        \DB::table("accounts")->where('_account_ledger',$data->id)->update(['_account_head'=>$request->_account_head_id,'_account_group'=>$request->_account_group_id]);

        \DB::table("purchase_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);

        \DB::table("purchase_return_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);

        \DB::table("replacement_item_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);
        
        \DB::table("resturant_sales_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);

        \DB::table("sales_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);
        
        \DB::table("sales_return_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);
        
        \DB::table("warranty_accounts")->where('_ledger_id',$data->id)->update(['_account_type_id'=>$request->_account_head_id,'_account_group_id'=>$request->_account_group_id]);

        return redirect()->back()->with('success','Information save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountLedger  $accountLedger
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
      
        $numOfAccount = Accounts::where('_account_ledger',$id)->count();
        if($numOfAccount ==0){
            AccountLedger::find($id)->delete();
            return redirect('account-ledger')->with('success','Information deleted successfully');
        }else{
            $__message ="You Can not delete this Information";
            $page_name ="Permission Denied";
            return view('backend.message.permission_message',compact('__message','page_name'));
        }
        
    }



public function type_base_group(Request $request){
        $account_groups = AccountGroup::where('_account_head_id',$request->id)
                                        ->orderBy('_name','asc')
                                        ->get();
        return view('backend.account-ledger.type_base_group',compact('account_groups'));
}

public function groupBaseLedger(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                 ->where('_is_used',1)
                                ->select('id','_name')
                                ->get();
        return view('backend.account-ledger.group_base_ledger',compact('data'));
}
public function groupBaseSmsLedger(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                 
                                ->select('id','_name','_phone')
                                ->get();
        return view('backend.account-ledger.group_sms_base_ledger',compact('data'));
}

public function groupBaseLedgerPurchaseStatement(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                ->where('_is_used',1)
                                ->select('id','_name')
                                ->get();
        return view('backend.account-ledger.group_base_ledger_pur_statement',compact('data'));
}

public function groupBaseBillParty(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                ->where('_is_used',1)
                                ->select('id','_name')
                                ->get();
        return view('backend.account-ledger.group-base-bill-party-ledger',compact('data'));
}


public function groupBaseLedgerPurchaseReturnStatement(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                ->where('_is_used',1)
                                ->select('id','_name')
                                ->get();
        return view('backend.account-ledger.group_base_ledger_pur_return',compact('data'));
}



public function groupBaseLedgerSalesStatement(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                ->where('_is_used',1)
                                ->select('id','_name')
                                ->get();
        return view('backend.account-ledger.group_base_ledger_sales',compact('data'));
}


public function groupBaseLedgerSalesReturnStatement(Request $request){
        
         $data = AccountLedger::whereIn('_account_group_id',$request->_account_group_id)
                                        ->where('_is_used',1)
                                        ->select('id','_name')
                                        ->get();
        return view('backend.account-ledger.group_base_ledger_sales_return',compact('data'));
}



}
