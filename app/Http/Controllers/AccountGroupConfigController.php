<?php

namespace App\Http\Controllers;

use App\Models\AccountGroupConfig;
use Illuminate\Http\Request;

class AccountGroupConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_name = "Account Group Config";
        $data = AccountGroupConfig::first();
        return view('backend.account-group.account_group_configs',compact('data'));
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

      //  return $request->all();

        $_employee_groups = $request->_employee_group ?? [];
        $_employee_groups_string = implode(",",$_employee_groups);

        $_direct_income_groups = $request->_direct_income_group ?? [];
        $_direct_income_groups_string = implode(",",$_direct_income_groups);
        
        $_indirect_income_groups = $request->_indirect_income_group ?? [];
        $_indirect_income_groups_string = implode(",",$_indirect_income_groups);

        
        $_direct_expense_groups = $request->_direct_expense_group ?? [];
        $_direct_expense_groups_string = implode(",",$_direct_expense_groups);

        $_indirect_expense_groups = $request->_indirect_expense_group ?? [];
        $_indirect_expense_groups_string = implode(",",$_indirect_expense_groups);

        $_cash_groups = $request->_cash_group ?? [];
        $_cash_groups_string = implode(",",$_cash_groups);

        $_bank_groups = $request->_bank_group ?? [];
        $_bank_groups_string = implode(",",$_bank_groups);

        $_customer_groups = $request->_customer_group ?? [];
        $_customer_groups_string = implode(",",$_customer_groups);

        $_supplier_groups = $request->_supplier_group ?? [];
        $_supplier_groups_string = implode(",",$_supplier_groups);

        $_direct_inc_exp_headss = $request->_direct_inc_exp_heads ?? [];
        $_direct_inc_exp_headss_string = implode(",",$_direct_inc_exp_headss);

        $_indirect_inc_exp_headss = $request->_indirect_inc_exp_heads ?? [];
        $_indirect_inc_exp_headss_string = implode(",",$_indirect_inc_exp_headss);
        
        $_honorarium_groups = $request->_honorarium_group ?? [];
        $_honorarium_groups_string = implode(",",$_honorarium_groups);

        
        $_student_groups = $request->_student_groups ?? [];
        $_student_groups_string = implode(",",$_student_groups);

        if($request->id ==''){
            $data = new AccountGroupConfig();
        }else{
            $data = AccountGroupConfig::find($request->id);
        }
        $data->_employee_group = $_employee_groups_string;
        $data->_direct_inc_exp_heads = $_direct_inc_exp_headss_string;
        $data->_indirect_inc_exp_heads = $_indirect_inc_exp_headss_string;
        $data->_direct_income_group = $_direct_income_groups_string;
        $data->_indirect_income_group = $_indirect_income_groups_string;
        $data->_direct_expense_group = $_direct_expense_groups_string;
        $data->_indirect_expense_group = $_indirect_expense_groups_string;
        $data->_cash_group = $_cash_groups_string;
        $data->_bank_group = $_bank_groups_string;
        $data->_customer_group = $_customer_groups_string;
        $data->_supplier_group = $_supplier_groups_string;
        $data->_honorarium_group = $_honorarium_groups_string;
        $data->_student_groups = $_student_groups_string;
        $data->save();
        return redirect()->back()
                        ->with('success','Information Save successfully');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountGroupConfig  $accountGroupConfig
     * @return \Illuminate\Http\Response
     */
    public function show(AccountGroupConfig $accountGroupConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountGroupConfig  $accountGroupConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountGroupConfig $accountGroupConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountGroupConfig  $accountGroupConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountGroupConfig $accountGroupConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountGroupConfig  $accountGroupConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountGroupConfig $accountGroupConfig)
    {
        //
    }
}
