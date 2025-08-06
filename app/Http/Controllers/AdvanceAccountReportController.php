<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountGroup;
use App\Models\Accounts;
use App\Models\AccountLedger;
use App\Models\MainAccountHead;
use App\Models\VoucherType;
use App\Models\Sales;
use App\Models\ResturantSales;
use App\Models\ResturantFormSetting;
use App\Models\SalesFormSetting;
use App\Models\GeneralSettings;
use App\Models\AccountHead;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class AdvanceAccountReportController extends Controller
{
    function __construct()
    {
         
         $this->middleware('permission:advance_income_statement', ['only' => ['advance_income_statement','advance_income_statement_report']]);
         $this->middleware('permission:sales_collection_report', ['only' => ['sales_collection_report']]);
        


    }



    /*Sales Collection Report*/

    public function sales_collection_report(Request $request){

        
         session()->put('sales_collection_report_filter', $request->all());
        $previous_filter= Session::get('sales_collection_report_filter');
        $page_name = "Sales Collection Report";
        $users = Auth::user();

      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);

      
     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    $account_heads = \DB::table('account_group_configs')->select('_customer_group')->first();

    $_account_group = $account_heads->_customer_group ?? 0;

    $datas=[];
    if($request->has('_datex') && $request->has('_datey')){
        $sql =" 
        SELECT s1.organization_id,s2._branch_id,s3._name as _b_name,s1._cost_center, s2._code,s2._name, s1.id,s1._voucher_code,s1._short_narration,s1._narration,s1._table_name,s1._voucher_type,
        s1._date,s1._account_head,s1._account_group,s1._account_ledger,s1._dr_amount,s1._cr_amount,s1._balance,s1._serial,s1._pair FROM(
SELECT t1.organization_id,t1._branch_id,t1._cost_center, 0 as id,'' as _voucher_code,'Opening Balance' as _short_narration,'' as _narration, t1._table_name, 
                '' as _voucher_type, '".$_datex."' as _date,t1._account_head,t1._account_group,
                t1._account_ledger,0 as _dr_amount,0 as _cr_amount, SUM(t1._dr_amount-t1._cr_amount) as _balance,t1._serial,t1._pair
                FROM `accounts` t1 
                WHERE t1._status=1 AND t1._account_group IN('".$_account_group."')  AND t1._date < '".$_datex."'
               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                GROUP BY t1._account_ledger 
    UNION ALL

         SELECT t1.organization_id,t1._branch_id,t1._cost_center,t1.id,t1._voucher_code,t1._short_narration,t1._narration,t1._table_name,
                t1._voucher_type,t1._date,t1._account_head,t1._account_group,
                t1._account_ledger,t1._dr_amount,t1._cr_amount, 0 as _balance,t1._serial,t1._pair
                FROM `accounts` t1 
                WHERE t1._status=1 AND t1._account_group IN('".$_account_group."') AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")

                ) as s1
INNER JOIN account_ledgers as s2 ON (s1._account_ledger=s2.id AND s2._balance !=0)
INNER JOIN branches as s3 on s2._branch_id=s3.id
ORDER BY s1._date ASC,s1._account_ledger ASC
                 ";

     $report_datas = \DB::select($sql);

     foreach($report_datas as $val){
        //$val->_oposite_ledger=_oposite_account($val->id,$val->_table_name,$val->_account_ledger);
        $datas[$val->_branch_id."-".$val->_b_name][$val->_account_ledger][]=$val;
     }


    //return $datas;
    }
    return view('backend.advance_account_reports.sales_collection_report',compact('page_name','datas','permited_organizations','permited_branch','permited_costcenters','previous_filter'));
    }


    /*Customer Due Statement Report*/

    public function customer_due_statement(Request $request){

        
         session()->put('customer_due_statement_report_filter', $request->all());
        $previous_filter= Session::get('customer_due_statement_report_filter');
        $page_name = "Customer Due Statement";
        $users = Auth::user();

      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);

      
     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    $account_heads = \DB::table('account_group_configs')->select('_customer_group')->first();

    $_account_group = $account_heads->_customer_group ?? 0;

    $datas=[];
    if($request->has('_datex') && $request->has('_datey')){
        $sql =" 
        SELECT s1.organization_id,s2._branch_id,s3._name as _b_name,s1._cost_center, s2._code,s2._name, s1._account_head,s1._account_group,s1._account_ledger,s1._account_ledger as _ledger_id,s2._phone,s2._address,SUM(s1._opeing_balance) as _opeing_balance,SUM(s1._current_balance) as _current_balance FROM(

SELECT t1.organization_id,t1._branch_id,t1._cost_center, t1._account_head,t1._account_group,
                t1._account_ledger, SUM(t1._dr_amount-t1._cr_amount) as _opeing_balance,0 as _current_balance
                FROM `accounts` t1 
                WHERE t1._status=1 AND t1._account_group IN('".$_account_group."')  AND t1._date < '".$_datex."'
               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                GROUP BY t1._account_ledger 

UNION ALL

         SELECT t1.organization_id,t1._branch_id,t1._cost_center,t1._account_head,t1._account_group,
                t1._account_ledger,0 as _opeing_balance,SUM(t1._dr_amount-t1._cr_amount) as _current_balance
                FROM `accounts` t1  
                WHERE t1._status=1 AND t1._account_group IN('".$_account_group."') AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger 

 
                ) as s1
INNER JOIN account_ledgers as s2 ON s1._account_ledger=s2.id
INNER JOIN branches as s3 on s2._branch_id=s3.id
GROUP BY s1._account_ledger 
HAVING SUM(s1._opeing_balance+s1._current_balance) !=0
ORDER BY s1._account_ledger ASC

                 ";

     $report_datas = \DB::select($sql);

     foreach($report_datas as $val){
        //$val->_oposite_ledger=_oposite_account($val->id,$val->_table_name,$val->_account_ledger);
        $datas[$val->_branch_id."-".$val->_b_name][]=$val;
     }


//return $datas;
    }



    return view('backend.advance_account_reports.customer_due_statement',compact('page_name','datas','permited_organizations','permited_branch','permited_costcenters','previous_filter'));
    }



public function final_due_statement(Request $request){
  

  
         session()->put('final_due_statement', $request->all());
        $previous_filter= Session::get('final_due_statement');
        $page_name = __('label.final_due_statement');
       $users = Auth::user();

      

      
     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

    $account_heads = \DB::table('account_group_configs')->select('_customer_group')->first();

    $_account_group = $account_heads->_customer_group ?? 0;

    $datas=[];
    if($request->has('organization_id')){
        $sql =" 
        SELECT s1.organization_id,s2._branch_id,s3._name as _b_name,s1._cost_center, s2._code,s2._name, s1._account_head,s1._account_group,s1._account_ledger,s1._account_ledger as _ledger_id,s2._phone,s2._address,SUM(s1._opeing_balance) as _opeing_balance,SUM(s1._current_balance) as _current_balance FROM(

         SELECT t1.organization_id,t1._branch_id,t1._cost_center,t1._account_head,t1._account_group,
                t1._account_ledger,0 as _opeing_balance,SUM(t1._dr_amount-t1._cr_amount) as _current_balance
                FROM `accounts` t1  
                WHERE t1._status=1 AND t1._account_group IN('".$_account_group."') 
               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger 

 
                ) as s1
INNER JOIN account_ledgers as s2 ON s1._account_ledger=s2.id
INNER JOIN branches as s3 on s2._branch_id=s3.id
GROUP BY s1._account_ledger 
ORDER BY s1._account_ledger ASC

                 ";

     $report_datas = \DB::select($sql);

     foreach($report_datas as $val){
        //$val->_oposite_ledger=_oposite_account($val->id,$val->_table_name,$val->_account_ledger);
        $datas[$val->_branch_id."-".$val->_b_name][]=$val;
     }


  }


    return view('backend.advance_account_reports.final_due_statement',compact('page_name','datas','permited_organizations','permited_branch','permited_costcenters','previous_filter'));
  


}


     public function advance_balance_sheet(Request $request){
        $previous_filter= Session::get('balanceSheetFilter');
        $page_name = "Balance Sheet";
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        
       

         
        return view('backend.advance_account_reports.balance-sheet',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));
    }


   public function advance_balance_sheet_report(Request $request){
         $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required'
        ]);
         session()->put('balanceSheetFilter', $request->all());
        $previous_filter= Session::get('balanceSheetFilter');
        $page_name = "Balance Sheet";
        $users = Auth::user();

      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);

      
     // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);


      $_with_zero_qty = $request->_with_zero ?? 0;
        //AND t1.organization_id IN(".$_organization_id_rows.")

        $balance_sheet =" SELECT s1._section,s2._name as _head_name,s3._name as _group_name, s1._main_account_id,s1._acc_head_pl3_id,s1._acc_head_pl2_id,s1._account_group_id,
s1._account_head_id,s1._ledger_id,s1._ledger_name as _l_name,s1.organization_id,s1._branch_id,s1._cost_center,SUM(s1._opening_amount)  AS _opening_amount,SUM(s1._amount) as _amount,SUM(s1._opening_amount+s1._amount) as _balance FROM(

SELECT 1 as _section, t1._main_account_id,t1._acc_head_pl3_id,t1._acc_head_pl2_id,t1._account_group_id,
t1._account_head_id,t1.id as _ledger_id,t1._name as _ledger_name,t2.organization_id,t2._branch_id,t2._cost_center,SUM(t2._dr_amount-t2._cr_amount)  AS _opening_amount,0 as _amount
FROM account_ledgers AS t1
INNER JOIN accounts AS t2 ON (t1.id=t2._account_ledger AND t2._status=1)
WHERE  t1._main_account_id IN(1) AND t2._date < '".$_datex."'
AND t2.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN (".$_branch_ids_rows.") AND  t2._cost_center IN(".$_cost_center_id_rows.")
GROUP BY t1.id
UNION ALL
SELECT 2 as _section, t1._main_account_id,t1._acc_head_pl3_id,t1._acc_head_pl2_id,t1._account_group_id,
t1._account_head_id,t1.id as _ledger_id,t1._name as _ledger_name,t2.organization_id,t2._branch_id,t2._cost_center,SUM(t2._dr_amount-t2._cr_amount)  AS _opening_amount,0 as _amount
FROM account_ledgers AS t1
INNER JOIN accounts AS t2 ON (t1.id=t2._account_ledger AND t2._status=1)
WHERE t1._main_account_id IN(2,5) AND t2._date < '".$_datex."'
AND t2.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN (".$_branch_ids_rows.") AND  t2._cost_center IN(".$_cost_center_id_rows.")
GROUP BY t1.id
UNION ALL
SELECT 2 as _section, 5 as _main_account_id,3 as _acc_head_pl3_id,3 as _acc_head_pl2_id,32 as _account_group_id,
23 as _account_head_id,143 as _ledger_id,'RETAINED EARNINGS(P&L)' as _ledger_name,t2.organization_id,t2._branch_id,t2._cost_center,SUM(t2._dr_amount-t2._cr_amount)  AS _opening_amount,0 as _amount
FROM account_ledgers AS t1
INNER JOIN accounts AS t2 ON (t1.id=t2._account_ledger AND t2._status=1)
WHERE t1._main_account_id IN(3,4) AND t2._date < '".$_datex."'
AND t2.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN (".$_branch_ids_rows.") AND  t2._cost_center IN(".$_cost_center_id_rows.")

    
    UNION ALL
    
 
SELECT 1 as _section, t1._main_account_id,t1._acc_head_pl3_id,t1._acc_head_pl2_id,t1._account_group_id,
t1._account_head_id,t1.id as _ledger_id,t1._name as _ledger_name,t2.organization_id,t2._branch_id,t2._cost_center,0  AS _opening_amount,SUM(t2._dr_amount-t2._cr_amount) as _amount
FROM account_ledgers AS t1
INNER JOIN accounts AS t2 ON (t1.id=t2._account_ledger AND t2._status=1)
WHERE t1._main_account_id IN(1) AND t2._date  >= '".$_datex."'  AND t2._date <= '".$_datey."' 
               AND t2.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN (".$_branch_ids_rows.") AND  t2._cost_center IN(".$_cost_center_id_rows.")
GROUP BY t1.id
UNION ALL
SELECT 2 as _section, t1._main_account_id,t1._acc_head_pl3_id,t1._acc_head_pl2_id,t1._account_group_id,
t1._account_head_id,t1.id as _ledger_id,t1._name as _ledger_name,t2.organization_id,t2._branch_id,t2._cost_center,0  AS _opening_amount,SUM(t2._dr_amount-t2._cr_amount) as _amount
FROM account_ledgers AS t1
INNER JOIN accounts AS t2 ON (t1.id=t2._account_ledger AND t2._status=1)
WHERE t1._main_account_id IN(2,5) AND t2._date  >= '".$_datex."'  AND t2._date <= '".$_datey."' 
               AND t2.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN (".$_branch_ids_rows.") AND  t2._cost_center IN(".$_cost_center_id_rows.")
GROUP BY t1.id

UNION ALL
SELECT 2 as _section, 5 as _main_account_id,3 as _acc_head_pl3_id,3 as _acc_head_pl2_id,32 as _account_group_id,
23 as _account_head_id,143 as _ledger_id,'RETAINED EARNINGS(P&L)' as _ledger_name,t2.organization_id,t2._branch_id,t2._cost_center,0  AS _opening_amount,SUM(t2._dr_amount-t2._cr_amount) as _amount
FROM account_ledgers AS t1
INNER JOIN accounts AS t2 ON (t1.id=t2._account_ledger AND t2._status=1)
WHERE t1._main_account_id IN(3,4) AND t2._date  >= '".$_datex."'  AND t2._date <= '".$_datey."' 
               AND t2.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN (".$_branch_ids_rows.") AND  t2._cost_center IN(".$_cost_center_id_rows.")

    
    ) AS s1 
    INNER JOIN account_heads as s2 ON s1._account_head_id=s2.id
    INNER JOIN account_groups AS s3 ON s3.id=s1._account_group_id
    GROUP BY s1._ledger_id 
    ORDER BY s1._section ASC, s3._short ASC ";

    $balance_sheet_result = DB::select($balance_sheet);
      $balance_sheet_filter = array();
      foreach ($balance_sheet_result as $value) {
        $balance_sheet_filter[$value->_section][$value->_main_account_id][$value->_head_name][$value->_group_name][]=$value;
      }
//return $balance_sheet_filter;

if($request->_level =='Level 1'){
      
       return view('backend.advance_account_reports.balance_sheet_level_1_update',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));

     }else{
       return view('backend.advance_account_reports.balance-sheet-report_update',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));
     }



       
    }



    /*Filter Advance Income Statement Report*/

    public function advance_income_statement(Request $request){
        $previous_filter= Session::get('AdvanceincomeStatementFillter');
        $page_name = "Income Statement";
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $incomeStatementLedgers = DB::table('account_ledgers')
                                    ->select('account_ledgers.id','account_ledgers._name','account_ledgers._show','account_heads._name as _head_name')
                                    ->join('account_heads','account_heads.id','account_ledgers._account_head_id')
                                    ->whereIn('account_heads._account_id',[3,4])
                                    ->orderBy('account_heads.id','ASC')
                                    ->orderBy('account_ledgers.id','ASC')
                                    ->get();
        $_filter_ledgers = array();
        foreach ($incomeStatementLedgers as $value) {
          $_filter_ledgers[$value->_head_name][] = $value;
        }
       

         
        return view('backend.advance_account_reports.filter_advance_income_statement',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_filter_ledgers'));
    }

    public function advance_income_statement_report(Request $request){
        $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required'
        ]);
         session()->put('AdvanceincomeStatementFillter', $request->all());
        $previous_filter= Session::get('AdvanceincomeStatementFillter');
        $page_name = "Income Statement";
        $users = Auth::user();
       

          $_datex =  change_date_format($request->_datex);
          $_datey=  change_date_format($request->_datey);
         
          

          // Start of Organization ,Branch,Cost Center IDS

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    if($request->organization_id=='all'){
        $request_organizations = explode(',',$users->organization_ids);
    }else{
        $request_organizations = explode(',',$request->organization_id);
    }

    if($request->_branch_id=='all'){
         $_branch_ids = explode(',',$users->branch_ids);
    }else{
        $_branch_ids = explode(',',$request->_branch_id);
    }

   

    if($request->_cost_center=='all'){
        $_cost_center_ids = explode(',',$users->cost_center_ids);
    }else{
        $_cost_center_ids = explode(',',$request->_cost_center);
    }

    $_organization_id_rows = implode(',', $request_organizations);
     $_branch_ids_rows = implode(',', $_branch_ids);
    $_cost_center_id_rows = implode(',', $_cost_center_ids);

            $group_configs = \DB::table("account_group_configs")->first();
            $_direct_income_group_string = $group_configs->_direct_income_group ?? 0;
            $_indirect_income_group_string = $group_configs->_indirect_income_group ?? 0;
            $_direct_expense_group_string = $group_configs->_direct_expense_group ?? 0;
            $_indirect_expense_group_string = $group_configs->_indirect_expense_group ?? 0;
            $_tax_expense_group_string = $group_configs->_tax_expense_group ?? 0;



            $income_query = " SELECT  t6._short, t5._serial,t5._main_account_id, t5._acc_head_pl3_id, t5._acc_head_pl2_id, t5._account_head_id, t5._account_group_id,t6._name as _group_name, t5._account_ledger,t5._l_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount FROM (

               
            SELECT 1 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,   SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_group IN (".$_direct_income_group_string.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT 1 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._account_group IN ( ".$_direct_income_group_string." )  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger

UNION ALL 
            SELECT 2 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,   SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_group IN (".$_direct_expense_group_string.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT 2 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._account_group IN ( ".$_direct_expense_group_string." )  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
UNION ALL
               
            SELECT 3 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,   SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_group IN (".$_indirect_income_group_string.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT 3 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._account_group IN ( ".$_indirect_income_group_string." )  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger

   UNION ALL            
            SELECT 4 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,   SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_group IN (".$_indirect_expense_group_string.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT 4 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._account_group IN ( ".$_indirect_expense_group_string." )  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger

     UNION ALL            
            SELECT 5 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,   SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_group IN (".$_tax_expense_group_string.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT 5 as _serial, t3._main_account_id, t3._acc_head_pl3_id, t3._acc_head_pl2_id, t3._account_group_id, t3._account_head_id, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE  t1._status=1 AND t1._account_group IN ( ".$_tax_expense_group_string." )  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger

                 ) as t5
INNER JOIN account_groups as t6 ON t5._account_group_id=t6.id


                  GROUP BY t5._account_ledger ORDER BY t5._serial,t6._short ASC  ";
 
      $query_result = DB::select($income_query);
      $data_sets = [];
$_level_id = $request->_level_id ?? 6;

$account_heads_all=AccountHead::select('id','_name')->get();
$account_heads=[];
foreach($account_heads_all as $key=>$account){
    $account_heads[$account->id]=$account->_name ?? '';
}

//return $_level_id;

if($_level_id ==1){
    foreach ($query_result as $value) {
        $data_sets[$value->_serial][$value->_main_account_id][]=$value;
      }

return view('backend.advance_account_reports.report_i_s_l1',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_level_id','data_sets','account_heads'));
}


if($_level_id ==2){
    foreach ($query_result as $value) {
        $data_sets[$value->_serial][$value->_main_account_id][$value->_acc_head_pl3_id][]=$value;
      }

      return view('backend.advance_account_reports.report_i_s_l2',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_level_id','data_sets','account_heads'));

}
if($_level_id ==3){
    foreach ($query_result as $value) {
        $data_sets[$value->_serial][$value->_main_account_id][$value->_acc_head_pl3_id][$value->_acc_head_pl2_id][]=$value;
      }

      return view('backend.advance_account_reports.report_i_s_l3',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_level_id','data_sets','account_heads'));

}
if($_level_id ==4){
    foreach ($query_result as $value) {
        $data_sets[$value->_serial][$value->_main_account_id][$value->_acc_head_pl3_id][$value->_acc_head_pl2_id][$value->_account_head_id][]=$value;
      }
//return $data_sets;
      return view('backend.advance_account_reports.report_i_s_l4',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_level_id','data_sets','account_heads'));

}
if($_level_id ==5){
    foreach ($query_result as $value) {
        $data_sets[$value->_serial][$value->_main_account_id][$value->_acc_head_pl3_id][$value->_acc_head_pl2_id][$value->_account_head_id][$value->_account_group_id][]=$value;
      }

      //return  $data_sets;

      return view('backend.advance_account_reports.report_i_s_l5',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_level_id','data_sets','account_heads'));

}
if($_level_id ==6){
    foreach ($query_result as $value) {
        $data_sets[$value->_serial][$value->_main_account_id][$value->_acc_head_pl3_id][$value->_acc_head_pl2_id][$value->_account_head_id][$value->_account_group_id][]=$value;
      }

      return view('backend.advance_account_reports.report_i_s_l6',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_level_id','data_sets','account_heads'));

}



      

      




    }



}
