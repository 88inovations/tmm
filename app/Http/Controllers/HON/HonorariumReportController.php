<?php

namespace App\Http\Controllers\HON;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HON\HonorariumBill;
use App\Models\HON\HonorariumBillDetail;
use App\Models\HON\HonorariumPayment;
use App\Models\HON\HonorariumPaymentDetail;
use App\Models\HON\HonorimSetup;

use App\Models\AccountGroup;
use App\Models\Accounts;
use App\Models\AccountLedger;
use App\Models\MainAccountHead;
use App\Models\VoucherType;
use App\Models\GeneralSettings;
use App\Models\AccountHead;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class HonorariumReportController extends Controller
{

       function __construct()
    {
     
         $this->middleware('permission:honorarium_report', ['only' => ['honorarium_report']]);
         $this->page_name = __('label.honorarium_report');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_name =  $this->page_name;
        return view('hon.honorarium_report.index',compact('page_name'));
    }

    public function honorarium_bill_sheet(Request $request){

        session()->put('honorarium_bill_sheet_report', $request->all());
        $previous_filter= Session::get('honorarium_bill_sheet_report');


          $page_name = __('label.honorarium_bill_sheet');
        $users = Auth::user();
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $_requested_group_array  = _honorarium_group_array();
        
        $ledgers =[];



            return view('hon.honorarium_report.honorarium_bill_sheet',compact('page_name','request','ledgers','permited_organizations','permited_branch','permited_costcenters','previous_filter'));
        
    }

    public function honorarium_bill_sheet_reset(){
        Session::flash('honorarium_bill_sheet_report');
         return redirect()->back();
    }


    public function honorarium_bill_sheet_report(Request $request){


               $page_name = __('label.honorarium_bills');

                $datas   = HonorariumBill::with(['_organization','_branch','_cost_center','_voucher_detail']);
                 if($request->has('organization_id') && $request->organization_id !=''){
                        $datas = $datas->where('organization_id','=',$request->organization_id);
                 }

                    if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
                        $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
                    }

                    if($request->has('_branch_id') && $request->_branch_id !=''){
                        $datas = $datas->where('_branch_id','=',$request->_branch_id);
                    }

                    if($request->has('_month') && $request->_month !=''){
                        $datas = $datas->where('_month','=',$request->_month);
                    }
                    if($request->has('_year') && $request->_year !=''){
                        $datas = $datas->where('_year','=',$request->_year);
                    }


                $datas = $datas->get();


$organization_id  = $request->organization_id ?? 0;
$_cost_center_id= $request->_cost_center_id ?? 0;
$_branch_id= $request->_branch_id ?? 0;
$_month= $request->_month ?? 0;
$_year= $request->_year ?? 0;

               

    



    return view('hon.honorarium_report.honorarium_bill_sheet_report',compact('page_name','datas','organization_id','_cost_center_id','_branch_id','_month','_year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
