<?php

namespace App\Http\Controllers;

use App\Models\BulkSms;
use App\Models\AccountLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class BulkSmsController extends Controller
{
        function __construct()
    {
         $this->middleware('permission:bulk-sms', ['only' => ['index','store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
         

        $previous_filter= Session::get('group_sms_send_filter');
        $page_name = "SMS SEND";
        $account_groups = \DB::select(" SELECT DISTINCT t2.id as id,t2._name as _name FROM accounts AS t1
                                        INNER JOIN account_groups AS t2 ON t1._account_group=t2.id WHERE t2._show_filter=1 ORDER BY t2._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.bulk_sms.index',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    
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
       // return $request->all();
        $_message = $request->_message ?? '';
        $_account_ledgers = $request->_account_ledger_id ?? [];
        foreach ($_account_ledgers as $value) {
            $ledger_info = AccountLedger::select('_phone')->find($value);
            if($ledger_info->_phone !=""){
             sms_send($_message, $ledger_info->_phone);
            }
        }

        return redirect()->back()->with('success','SMS Send successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BulkSms  $bulkSms
     * @return \Illuminate\Http\Response
     */
    public function show(BulkSms $bulkSms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BulkSms  $bulkSms
     * @return \Illuminate\Http\Response
     */
    public function edit(BulkSms $bulkSms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BulkSms  $bulkSms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BulkSms $bulkSms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BulkSms  $bulkSms
     * @return \Illuminate\Http\Response
     */
    public function destroy(BulkSms $bulkSms)
    {
        //
    }
}
