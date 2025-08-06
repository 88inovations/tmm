<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SecurityDeposit;
use App\Models\AccountLedger;
use App\Models\User;
use Auth;
use DB;
use Session;

class SecurityDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
    {
         $this->middleware('permission:security_deposits-list|security_deposits-create|security_deposits-edit|security_deposits-delete', ['only' => ['index','store']]);
         $this->middleware('permission:security_deposits-create', ['only' => ['create','store']]);
         $this->middleware('permission:security_deposits-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:security_deposits-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.security_deposits');
    }

    public function index(Request $request)
    {


  //     $sqlConn = sqlConn();

  //         $query = " SELECT [SecDepID]
  //     ,[RecvDate]
  //     ,[RecvFrom]
  //     ,[ChqDetails]
  //     ,[ChqDate]
  //     ,[RecvAmount]
  //     ,[ProjectID]
  //     ,[RecvType]
  //     ,[Remarks]
  //     ,[AddUser]
  //     ,[EditUser]
  //     ,[Active]
  // FROM [Inv_Meghna].[dbo].[tblSecurityDeposit] ";
  //       $stmt = sqlsrv_query($sqlConn, $query);
  //       if ($stmt === false) {
  //           die(print_r(sqlsrv_errors(), true));
  //       }
  //       // Fetch data into an array
  //       $data = array();
  //       while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  //          // return $row;
  //           $id = $row["RecvFrom"];
  //           $Remarks = $row["Remarks"];
  //           $ledger = \DB::table('account_ledgers')->where('id',$id)->first()->_code ?? '';
  //           $_ledger_code = $ledger->_code ?? '';
  //           $RecvType = $row["RecvType"];
  //           $RecvAmount = $row["RecvAmount"] ?? 0;
  //           $Active = $row["Active"] ?? 0;
  //           if($Active ==1){
  //               $_type="Receive";
  //           }else{
  //                $_type="Return";
  //           }
  //           $RecvDate =  $row["RecvDate"]->format('Y-m-d');
  //           $ChqDate =  $row["ChqDate"]->format('Y-m-d');
  //           $RecvAmount =  $row["RecvAmount"] ?? 0;
  //           $ChqDetails =  $row["ChqDetails"] ?? '';

  //            $auth_user = Auth::user();
  //          $_order_number = make_order_number('security_deposits',1,1,$RecvDate);

  //        $SecurityDeposit = new SecurityDeposit();
  //        $SecurityDeposit->_date = change_date_format($RecvDate);
  //        $SecurityDeposit->_cheque_date = change_date_format($ChqDate);
  //        $SecurityDeposit->_order_number = $_order_number;
  //        $SecurityDeposit->organization_id = 1;
  //        $SecurityDeposit->_branch_id = 1;
  //        $SecurityDeposit->_cost_center_id = 1;
  //        $SecurityDeposit->_ledger_id = $id ?? 0;
  //        $SecurityDeposit->_ledger_code = $_ledger_code;
  //        $SecurityDeposit->_type = $_type ?? '';
  //        $SecurityDeposit->_bank_name = $request->_bank_name ?? '';
  //        $SecurityDeposit->_bank_branch_name = $request->_bank_branch_name ?? '';
  //        $SecurityDeposit->_cheque_no = $ChqDetails ?? '';
  //        $SecurityDeposit->_remarks = $Remarks ?? '';
  //        $SecurityDeposit->_voucher_no = $SecDepID ?? '';
  //        $SecurityDeposit->_amount = $RecvAmount ?? 0;
  //        $SecurityDeposit->_user_id = $auth_user->id;
  //        $SecurityDeposit->_created_by = $auth_user->id;
  //        $SecurityDeposit->_user_name = $auth_user->name ?? '';
  //        $SecurityDeposit->_status = 1;
  //        $SecurityDeposit->_lock = 0;
  //        $SecurityDeposit->save();
           

           
  //       }

        //
        $auth_user = Auth::user();

         $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        $limit =  $request->limit ?? 30;
        $datas = SecurityDeposit::with(['_organization','_master_branch','_ledger','_master_cost_center']);
        if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
        } 
        if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('_date','>=', $_datex);
            $datas = $datas->whereDate('_date','<=', $_datey);
        }

        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number',$request->_order_number);
        }
        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id',$request->organization_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id',$request->_branch_id);
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id',$request->_cost_center_id);
        }
        if($request->has('_ledger_id') && $request->_ledger_id !=''){
            $datas = $datas->where('_ledger_id',$request->_ledger_id);
        }
        if($request->has('_ledger_code') && $request->_ledger_code !=''){
            $datas = $datas->where('_ledger_code',$request->_ledger_code);
        }
        if($request->has('_type') && $request->_type !=''){
            $datas = $datas->where('_type',$request->_type);
        }
        if($request->has('_cheque_no') && $request->_cheque_no !=''){
            $datas = $datas->where('_cheque_no',$request->_cheque_no);
        }
        if($request->has('_cheque_date') && $request->_cheque_date !=''){
            $datas = $datas->whereDate('_cheque_date',$request->_cheque_date);
        }
        if($request->has('_amount') && $request->_amount !=''){
            $datas = $datas->where('_amount',$request->_amount);
        }
        if($request->has('_remarks') && $request->_remarks !=''){
            $datas = $datas->where('_remarks',$request->_remarks);
        }
        if($request->has('_bank_name') && $request->_bank_name !=''){
            $datas = $datas->where('_bank_name','like','%$request->_bank_name%');
        }
        if($request->has('_bank_branch_name') && $request->_bank_branch_name !=''){
            $datas = $datas->where('_bank_branch_name','like','%$request->_bank_branch_name%');
        }
        if($request->has('_voucher_no') && $request->_voucher_no !=''){
            $datas = $datas->where('_voucher_no','like','%$request->_voucher_no%');
        }
        
        if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock',$request->_lock);
        }

       // $limit = $datas->count();

        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        $page_name = $this->page_name;

        $users = $auth_user;
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      //  $store_houses = permited_stores(explode(',',$users->store_ids));
       

        return view('backend.security_deposits.index',compact('datas','page_name','limit','request','permited_organizations','permited_branch','permited_costcenters','users'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.security_deposits.create',compact('page_name'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            'organization_id' => 'required',
            '_cost_center_id' => 'required',
            '_main_ledger_id' => 'required',
            '_type' => 'required',
            '_form_name' => 'required'
        ]);

         $auth_user = Auth::user();
        $_order_number = make_order_number($request->_form_name,$request->organization_id,$request->_branch_id);

         $SecurityDeposit = new SecurityDeposit();
         $SecurityDeposit->_date = change_date_format($request->_date);
         $SecurityDeposit->_cheque_date = change_date_format($request->_cheque_date);
         $SecurityDeposit->_order_number = $_order_number;
         $SecurityDeposit->organization_id = $request->organization_id ?? 1;
         $SecurityDeposit->_branch_id = $request->_branch_id ?? 1;
         $SecurityDeposit->_cost_center_id = $request->_cost_center_id ?? 1;
         $SecurityDeposit->_ledger_id = $request->_main_ledger_id ?? 0;
         $SecurityDeposit->_ledger_code = id_to_cloumn($request->_main_ledger_id,'_code','account_ledgers');
         $SecurityDeposit->_type = $request->_type ?? '';
         $SecurityDeposit->_bank_name = $request->_bank_name ?? '';
         $SecurityDeposit->_bank_branch_name = $request->_bank_branch_name ?? '';
         $SecurityDeposit->_cheque_no = $request->_cheque_no ?? '';
         $SecurityDeposit->_remarks = $request->_remarks ?? '';
         $SecurityDeposit->_voucher_no = $request->_voucher_no ?? '';
         $SecurityDeposit->_amount = $request->_amount ?? 0;
         $SecurityDeposit->_user_id = $auth_user->id;
         $SecurityDeposit->_created_by = $auth_user->id;
         $SecurityDeposit->_user_name = $auth_user->name ?? '';
         $SecurityDeposit->_status = 1;
         $SecurityDeposit->_lock = 0;
         $SecurityDeposit->save();


         return redirect()->back()->with('success','Information save successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SecurityDeposit  $securityDeposit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $data = SecurityDeposit::with(['_organization','_master_branch','_ledger','_master_cost_center'])->find($id);
        $page_name  = $this->page_name;
        
        return view('backend.security_deposits.print',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SecurityDeposit  $securityDeposit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $page_name = $this->page_name;
       $data = SecurityDeposit::with(['_organization','_master_branch','_ledger'])->find($id);
       if($data->_lock ==1){
            return redirect()->back()->with('error','You have no permission to edit this action');
        }
        return view('backend.security_deposits.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SecurityDeposit  $securityDeposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            'organization_id' => 'required',
            '_cost_center_id' => 'required',
            '_main_ledger_id' => 'required',
            '_type' => 'required',
            '_form_name' => 'required'
        ]);

         $auth_user = Auth::user();


         $SecurityDeposit = SecurityDeposit::find($id);
         $SecurityDeposit->_date = change_date_format($request->_date);
         $SecurityDeposit->_cheque_date = change_date_format($request->_cheque_date);
         $SecurityDeposit->_order_number = $request->_order_number;
         $SecurityDeposit->organization_id = $request->organization_id ?? 1;
         $SecurityDeposit->_branch_id = $request->_branch_id ?? 1;
         $SecurityDeposit->_cost_center_id = $request->_cost_center_id ?? 1;
         $SecurityDeposit->_ledger_id = $request->_main_ledger_id ?? 0;
         $SecurityDeposit->_ledger_code = id_to_cloumn($request->_main_ledger_id,'_code','account_ledgers');
         $SecurityDeposit->_type = $request->_type ?? '';
         $SecurityDeposit->_bank_name = $request->_bank_name ?? '';
         $SecurityDeposit->_bank_branch_name = $request->_bank_branch_name ?? '';
         $SecurityDeposit->_cheque_no = $request->_cheque_no ?? '';
         $SecurityDeposit->_remarks = $request->_remarks ?? '';
         $SecurityDeposit->_voucher_no = $request->_voucher_no ?? '';
         $SecurityDeposit->_amount = $request->_amount ?? 0;
         $SecurityDeposit->_user_id = $auth_user->id;
         $SecurityDeposit->_created_by = $auth_user->id;
         $SecurityDeposit->_user_name = $auth_user->name ?? '';
         $SecurityDeposit->_status = $request->_status ?? 1;
         $SecurityDeposit->_lock = $request->_lock ?? 0;
         $SecurityDeposit->save();


         return redirect()->back()->with('success','Information save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SecurityDeposit  $securityDeposit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SecurityDeposit::where('id',$id)->delete();
        return redirect()->back()->with('success','Information deleted successfully');
    }
}
