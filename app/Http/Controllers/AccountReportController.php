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

class AccountReportController extends Controller
{


function __construct()
    {
         
         $this->middleware('permission:outstanding_detail_report', ['only' => ['outstanding_detail_report']]);
         $this->middleware('permission:ledger-report', ['only' => ['ledgerReprt','ledgerReprtShow']]);
         $this->middleware('permission:trail-balance', ['only' => ['trailBalance','trailBalanceReport']]);
         $this->middleware('permission:income-statement', ['only' => ['incomeStatement','incomeStatementReport']]);
         $this->middleware('permission:balance-sheet', ['only' => ['balanceSheet','balanceSheetReport']]);
         $this->middleware('permission:work-sheet', ['only' => ['workSheet','workSheetReport']]);
         $this->middleware('permission:group-ledger', ['only' => ['groupLedger','groupBaseLedgerReport']]);
         $this->middleware('permission:income-statement-settings', ['only' => ['incomeStatementSettings']]);
         $this->middleware('permission:ledger-summary-report', ['only' => ['ledgerSummaryReport','filterLedgerSummarray']]);
         $this->middleware('permission:cash-book', ['only' => ['cashBook','cashBookReport']]);
         $this->middleware('permission:bank-book', ['only' => ['bankBook','bankBookReport']]);
         $this->middleware('permission:day-book', ['only' => ['dayBook','dayBookReport']]);
         $this->middleware('permission:user-wise-collection-payment', ['only' => ['userReceiptPayment','userReceiptPaymentReport']]);
         $this->middleware('permission:date-wise-invoice-print', ['only' => ['dateWiseInvoice','dateWiseInvoiceReport']]);
         $this->middleware('permission:group_wise_ledger_list', ['only' => ['group_wise_ledger_list']]);

    }






    /*
        @function Name: outstanding_detail_report
        @Param  : Last date wise Report No Param Use Only today
        @return  : Payable and Receiveable Ledger [Customer Group and Supplier Group]
    */


    public function outstanding_detail_report(){
        $page_name = __('label.outstanding_detail_report');
        $account_group_configs  =  \DB::select(" SELECT CONCAT(`_employee_group`, ',', `_customer_group`, ',',`_supplier_group`) AS customer_supplier_employee
FROM account_group_configs ORDER BY id LIMIT 1 ");
      $customer_supplier_employee = $account_group_configs[0]->customer_supplier_employee ?? '';
      if($customer_supplier_employee ==''){
        $customer_supplier_employee ="1,43";
      }

     $cu_array = explode(',',$customer_supplier_employee);
     $cs_id_string = implode(',',$cu_array);


     $query_result = DB::table('accounts AS t1')
    ->join('account_ledgers AS t2', 't1._account_ledger', '=', 't2.id')
    ->join('account_groups AS t3', 't1._account_group', '=', 't3.id')
    ->select('t1._account_head', 't1._account_group','t3._name as _group_name', 't1._account_ledger', 
             't2._name as _ledger_name','t2._code','t2._phone','t2._alious', DB::raw('SUM(t1._dr_amount - t1._cr_amount) as _balance'))
    ->where('t1._status', 1)
    ->whereIn('t2._account_group_id', $cu_array)
    ->groupBy('t1._account_ledger')
    ->having(DB::raw('SUM(t1._dr_amount - t1._cr_amount)'), '!=', 0)
    ->orderBy('t1._account_head', 'DESC')
    ->orderBy('t2._name', 'asc')
    ->get();
$datas              = [];
$total_payable      = 0;
$total_receivable   = 0;

foreach($query_result as $val){
    $_balance = $val->_balance ?? 0;

    if($_balance >= 0){
        $total_receivable   +=$val->_balance ?? 0;
        $datas['Receivable From Customer & Supplier'][] = $val;
    }else{
        $total_payable    +=$val->_balance ?? 0;
        $datas['Payable To Supllier & Customer'][] = $val;
    }

}

//return $datas;


        return view('backend.account-report.outstanding_detail_report',compact('page_name','datas','total_payable','total_receivable'));
    }



    public function payable_report(Request $request){
        $page_name = __('label.payable_report');
        session()->put('payable_report', $request->all());
        $previous_filter= Session::get('payable_report');

      //  return $request->all();

        $users = Auth::user();
        $permited_organizations     = permited_organization(explode(',',$users->organization_ids));
        $permited_branch            = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters       = permited_costcenters(explode(',',$users->cost_center_ids));


        $datas     = [];

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
            //return $_branch_ids;
            $account_group_configs = DB::table("account_group_configs")->first();
            $_customer_group       = $account_group_configs->_customer_group ?? '';
            $_supplier_group       = $account_group_configs->_supplier_group ?? '';


            $customer_supplier_array = [];

            $_customer_group_array = explode(",",$_customer_group);
            $_supplier_group_array = explode(",",$_supplier_group);

             $customer_supplier_array = array_merge($_customer_group_array,$_supplier_group_array);
            if(sizeof($customer_supplier_array) == 0){
                $customer_supplier_array =[12,13];
            }


             $account_groups = \DB::table("account_groups")->whereIn('id',$customer_supplier_array)->get();

            $_organization_id_rows = implode(',', $request_organizations);
            $_branch_ids_rows = implode(',', $_branch_ids);
            $_cost_center_id_rows = implode(',', $_cost_center_ids);

            $_account_group_ids   = $request->_account_group_id ?? [];
            $_account_group_id_rows = implode(',',$_account_group_ids);
            $report_type = $request->report_type;

            if($request->has('_cost_center') && $request->has('_branch_id') && $request->has('organization_id')){
                  $string_query = "  SELECT t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center,t3._phone,t3._address,t3._alious, t4._name as _branch_name,t3._code, SUM(t1._dr_amount-t1._cr_amount) AS _balance 
                        FROM accounts AS t1
                        INNER JOIN account_groups as t2 ON t2.id=t1._account_group
                        INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
                        INNER JOIN branches as t4 ON t4.id = t1._branch_id
                          WHERE  t1._status=1 AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") AND t3._account_group_id IN(".$_account_group_id_rows.") GROUP BY t3.id ";
                        if($report_type =='receivable'){
                              $string_query .="   HAVING SUM(t1._dr_amount-t1._cr_amount) > 0 ";
                        }
                        if($report_type =='payable'){
                              $string_query .="   HAVING SUM(t1._dr_amount-t1._cr_amount) < 0 ";
                        }
                        
                         $string_query .= " order by t3._name ASC  ";
                 $select_datas = DB::select($string_query);

                 foreach($select_datas as $data){
                    $datas[$data->_group_name][]=$data;
                 }
                //return $datas;
            }
            



        return view('backend.account-report.payable_report',compact('previous_filter','page_name','datas','permited_organizations','permited_branch','permited_costcenters','request','account_groups'));
    }



    public function customer_statement(Request $request){

          session()->put('customer_statement', $request->all());
       $previous_filter= Session::get('customer_statement');



                $_ledger_id=476;
                $_sales_discount=7;
                $_incentice_expneses=592;
                $sales_id = 4;
                $sales_return=5;
                $sales_commision=8;
                $bad_debt=29;

                $page_name="Customer Statement";

$account_group_configs        = \DB::table("account_group_configs")->first();

$_customer_group = $account_group_configs->_customer_group ?? 0;

            $users = Auth::user();
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);
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
                //return $_branch_ids;

                $_organization_id_rows = implode(',', $request_organizations);
                 $_branch_ids_rows = implode(',', $_branch_ids);
                $_cost_center_id_rows = implode(',', $_cost_center_ids);

                 $ledger_id_rows =  $request->_ledger_id ?? '';

    $s_query = "SELECT DISTINCT t1._account_ledger,t2._name,t2._code
     FROM `accounts` AS t1 
     INNER JOIN account_ledgers as t2 ON (t1._account_ledger=t2.id AND t2._account_group_id IN ('".$_customer_group."') )
     WHERE t1._status=1 ";
     if($_organization_id_rows !=''){
        $s_query .=  "  AND t1.organization_id IN(".$_organization_id_rows.") ";
     }
     if($_branch_ids_rows !=''){
        $s_query .=  "    AND  t2._branch_id IN(".$_branch_ids_rows.") ";
     }

     if($_cost_center_id_rows !=''){
        $s_query .=  "    AND  t1._cost_center IN(".$_cost_center_id_rows.") ";
     }
   


 $reportable_ledgers = \DB::select($s_query);

                return view('backend.account-report.customer_due',compact('reportable_ledgers','_datex','_datey','page_name','permited_branch','permited_costcenters','permited_organizations','request','_organization_id_rows','_branch_ids_rows','_cost_center_id_rows','previous_filter','request_organizations','_branch_ids','_cost_center_ids','ledger_id_rows'));
    }



    public function single_customer_statement(Request $request){

            session()->put('single_customer_statement', $request->all());
            $previous_filter= Session::get('single_customer_statement');
        $page_name = "Single Customer Statement ";
        $users = Auth::user();
       
//return $request->all();

               



                //$page_name="Customer Statement";

                $cash_and_bank_ledgers=[];

              



            $users = Auth::user();
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);
            $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                $permited_branch = permited_branch(explode(',',$users->branch_ids));
                $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

              
                    $request_organizations = explode(',',$users->organization_ids);
                    $_branch_ids = explode(',',$users->branch_ids);
                    $_cost_center_ids = explode(',',$users->cost_center_ids);
                
                //return $_branch_ids;

                $_organization_id_rows = implode(',', $request_organizations);
                 $_branch_ids_rows = implode(',', $_branch_ids);
                $_cost_center_id_rows = implode(',', $_cost_center_ids);

                 $ledger_id_rows =  $request->_ledger_id ?? '';

     $account_group_configs        = \DB::table("account_group_configs")->first();
      $_customer_group              = $account_group_configs->_customer_group ?? '';
                $_customer_group_array        = explode(',', $_customer_group);
                $customer_ledgers  = AccountLedger::with(['_entry_branch'])
                                            ->whereIn('_account_group_id',$_customer_group_array)
                                            ->whereIn('_branch_id',$_branch_ids)
                                          //  ->where('_status',1)
                                            ->get();



        return view('backend.account-report.single_customer_statement',compact('request','page_name','previous_filter','customer_ledgers'));

       
    }


    /*
    * Single page Report Group wise Ledger Information
    * Param take @ledger type id & ledger Group ID And Branch 
    * Return Filter Wise Ledger Information with name ,address ETC
    */

    public function groupWiseLedgerReport(Request $request){
       // return $request->all();
        $page_name = __('Group Wise Ledger Report');
        $users = Auth::user();
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->_branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = [];
         //$account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
         $datas=[];
         
         if($request->has('filtter')){
            if($request->filtter =="1"){
                $_asc_desc = $request->_asc_desc ?? 'DESC';
                $asc_cloumn =  $request->asc_cloumn ?? 'id';

                $datas = AccountLedger::with(['account_type','account_group']);

                $limit = $datas->count();
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
                    if ($request->has('_account_head_id') && $request->_account_head_id !="") {
                        $datas = $datas->where('_account_head_id','=',$request->_account_head_id);
                    }
                    $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
                
            }
         }

 

         return view('backend.account-report.group_wise_ledger_report',compact('request','page_name','permited_branch','permited_organizations','permited_costcenters','account_types','account_groups','datas'));
    }

    /*
    * Filter Page Show for VoucherHistory
    */

    public function filterVoucherHistory(Request $request){
        $page_name = __('Voucher History');
         $previous_filter= Session::get('filter_voucher_history');
         $voucher_types = VoucherType::select('_name','_code')->get();
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

         return view('backend.account-report.filter_voucher_history',compact('request','page_name','voucher_types','previous_filter','permited_branch','permited_costcenters'));
    }


    public function reportVoucherHistory(Request $request){
       // return $request->all();

        $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
        ]);
         $_datex =  change_date_format($request->_datex);
         $_datey=  change_date_format($request->_datey);
                


       session()->put('filter_voucher_history', $request->all());
       $previous_filter= Session::get('filter_voucher_history');
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
         $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $page_name = "Voucher Details";
      // $request_branchs = $request->_branch_id ?? [];
      // $request_cost_centers = $request->_cost_center ?? [];

      // $request_organizations = $request->organization_id ?? [];
      // $permited_organizations = permited_organization(explode(',',$users->organization_ids));
      // $_organization_ids = filterableOrganization($request_organizations,$permited_organizations);
      // $_organization_id_rows = implode(',', $_organization_ids);


      // $_branch_ids = filterableBranch($request_branchs,$permited_branch);
      // $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

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



      $ledger_id_rows = (int) $request->_ledger_id;
    
      $string_query = "  SELECT t1._voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, t1._dr_amount AS _dr_amount,t1._reference, t1._cr_amount  AS _cr_amount, 0 AS _balance ,t1._serial as _serial
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")  order by t1._date,t1.id,t1._serial ASC  ";
 $datas = DB::select($string_query);
return view('backend.account-report.report_voucher_history',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_datex','_datey','datas','previous_filter'));

    }



     public function group_sub_group_summary_report(Request $request){
         session()->put('group_sub_group_summary_report_filter', $request->all());
        $previous_filter= Session::get('group_sub_group_summary_report_filter');
        $page_name = "Group Sub-Group Ledger Summary Report";
        $users = Auth::user();

      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);

       $accountHeads = AccountHead::orderBy('_parent_id')
                                   ->orderBy('id')
                                   ->get(['id', '_name', '_parent_id', '_level']);

        // Prepare hierarchical data with indentation
       $account_types = prepareHierarchy($accountHeads);

        $account_groups = [];

      
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

   $group_array_key_names = [];
   $heads_array_key_names = [];
 $main_account_key_names = [];
    $datas=[];
    if($request->has('report_name') ){

       // return $request->all();
         $_account_head_id = $request->_account_head_id ?? '';
        $_account_group_id = $request->_account_group_id ?? '';


        $all_account_gorups = AccountGroup::select('id','_name')->get();
        $group_array_key_names = [];
        foreach($all_account_gorups as $group){
            $group_array_key_names[$group->id]=$group->_name ?? '';
        }

        $heads_array_key_names = [];
        foreach($account_types as $head){
            $heads_array_key_names[$head->id]=$head->_name ?? '';
        }

        $main_accounts = \DB::table('main_account_head')->select('id','_name')->get();
       

        foreach($main_accounts as $main_account){
             $main_account_key_names[$main_account->id]=$main_account->_name ?? '';
        }



//Find Ledger id 

         $ledger_id_rows ='';
                if($_account_head_id !=''){
                  
                   $second_lebel_head_ids = AccountHead::where('_parent_id',$_account_head_id)->pluck('id')->toArray();
                   array_push($second_lebel_head_ids,$_account_head_id);
                   $thired_level_head_ids  = AccountHead::whereIn('_parent_id',$second_lebel_head_ids)->pluck('id')->toArray();
                   $all_heads_ids = array_merge( $second_lebel_head_ids, $thired_level_head_ids);   
                    $all_heads_ids_unique = array_values(array_unique($all_heads_ids, SORT_REGULAR)); 

                    $ledger_id_array = AccountLedger::whereIn('_account_head_id',$all_heads_ids_unique)->pluck('id')->toArray();

                   $ledger_array =[];
                   foreach($ledger_id_array as $ledger){
                            $ledger_array[] = $ledger;
                    }
                     if(sizeof($ledger_id_array)){
                        $ledger_id_rows =implode(',', $ledger_array);
                     }


                }
                

         
        

         
//return $ledger_id_rows;




if($ledger_id_rows !='' || $_account_head_id ==''){
        $string_query = " SELECT t1._main_account_id,t1._acc_head_pl3_id,t1._acc_head_pl2_id,t1._account_head_id,
t1._account_group_id,t1.id as _ledger_id,t1._name as _l_name,t1._code,t1._alious,t1._phone,t1._address,SUM(t2._dr_amount-t2._cr_amount) as _balance
FROM account_ledgers as t1 
left JOIN accounts as t2 ON (t2._account_ledger=t1.id AND t2._status=1)
WHERE 1=1  ";
if($request->organization_id !='all'){
    $string_query .= " AND t2.organization_id IN(".$_organization_id_rows.") ";
}

if($request->_cost_center !='all'){
   $string_query .= " AND  t2._cost_center IN(".$_cost_center_id_rows.") ";
}

if($request->_branch_id !='all'){
   $string_query .= " AND  t2._branch_id IN(".$_branch_ids_rows.") ";
}
if($request->_account_group_id !='' && $request->_account_group_id !='all'){
   $string_query .= " AND  t1._account_group_id =".$_account_group_id." ";
}
if($ledger_id_rows !=''){
    $string_query .= " AND  t1.id IN(".$ledger_id_rows.") ";
}


 $string_query .= " GROUP BY t1.id ORDER BY t1._name ASC ";
           

          $all_datas = DB::select($string_query);
       $datas = array();
       foreach ($all_datas as $value) {
           $datas[$value->_main_account_id][$value->_acc_head_pl3_id][$value->_acc_head_pl2_id][$value->_account_head_id][$value->_account_group_id][]=$value;
            }

}
    
//return  $datas;
 
    }
    return view('backend.account-report.group_sub_group_summary_report',compact('page_name','datas','permited_organizations','permited_branch','permited_costcenters','previous_filter','account_types','account_groups','group_array_key_names','heads_array_key_names','main_account_key_names'));

        
        
    }



    //###################################
    //
    //
    //####################################

    public function ledgerReportForeign_amount(Request $request){
         $previous_filter= Session::get('ledgerReportForeign_amountFilter');
        $page_name = "Ledger Report With Foreign Amount";
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filterledgerReportForeign_amount',compact('request','page_name','permited_branch','permited_costcenters','previous_filter'));

    }

     public function ledgerReprtShowForeign_amount(Request $request){

        //return $request->all();
         $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_ledger_id' => 'required'
        ]);
         $_datex =  change_date_format($request->_datex);
         $_datey=  change_date_format($request->_datey);
     
                


       session()->put('ledgerReportForeign_amountFilter', $request->all());
       $previous_filter= Session::get('ledgerReportForeign_amountFilter');

     
                  
       $ledger_info = AccountLedger::with(['account_type','account_group','_entry_branch'])->find($request->_ledger_id);
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
         $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

       

        
        $page_name = "Ledger Report [Foreign Amount]";
       

      $request_branchs = $request->_branch_id ?? [];
      $request_cost_centers = $request->_cost_center ?? [];

      $request_organizations = $request->organization_id ?? [];
      // $permited_organizations = permited_organization(explode(',',$users->organization_ids));
      // $_organization_ids = filterableOrganization($request_organizations,$permited_organizations);
      // $_organization_id_rows = implode(',', $_organization_ids);


      // $_branch_ids = filterableBranch($request_branchs,$permited_branch);
      // $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

      // $ledger_id_rows = (int) $request->_ledger_id;
      // $_branch_ids_rows = implode(',', $_branch_ids);
      // $_cost_center_id_rows = implode(',', $_cost_center_ids);

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
        


 $ledger_id_rows = (int) $request->_ledger_id;
      
     if($ledger_id_rows){
     $string_query = " 
     SELECT s1._voucher_code, s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name, s1._id,s1._table_name, s1._date, s1._short_narration, s1._narration, s1._dr_amount, s1._cr_amount, s1._balance,s1._serial FROM(

     SELECT '' as _voucher_code,t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, null as _id,null as _table_name, null as _date, null as _short_narration, 'Opening Balance' as _narration,0 AS _dr_amount, 0  AS _cr_amount, SUM(CASE  WHEN t1._dr_amount > 0 THEN t1._foreign_amount  ELSE -t1._foreign_amount   END ) AS _balance ,0 as _serial 
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
      UNION ALL
            SELECT t1._voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, CASE  WHEN t1._dr_amount > 0 THEN t1._foreign_amount  END AS _dr_amount, CASE  WHEN t1._cr_amount > 0 THEN t1._foreign_amount  END  AS _cr_amount, 0 AS _balance ,t1._serial as _serial
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") ) as s1 order by s1._date,s1._id,s1._serial ASC  ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }

}else{
   $group_array_values = array();
}
$ledger_details =[];

//return $group_array_values;

      //return $group_array_values;
        return view('backend.account-report.report_ledger_report_foreign',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','group_array_values','_datex','_datey','ledger_id_rows','ledger_info'));

    }

	//###################################
	//
	//
	//####################################

    public function ledgerReprt(Request $request){
         $previous_filter= Session::get('ledgerReprtFilter');
    	$page_name = "Ledger Report";
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
    	return view('backend.account-report.ledger',compact('request','page_name','permited_branch','permited_costcenters','previous_filter'));

    }

    //###################################
    //
    //
    //####################################

    public function ledger_report_with_item_detail(Request $request){
         $previous_filter= Session::get('ledger_report_with_item_detail');
        $page_name = "Ledger Report";
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.ledger_report_with_item_detail',compact('request','page_name','permited_branch','permited_costcenters','previous_filter'));

    }



    public function ledger_report_with_item_detail_response(Request $request){
        //return $request->all();
         $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_ledger_id' => 'required'
        ]);
         $_datex =  change_date_format($request->_datex);
         $_datey=  change_date_format($request->_datey);
     //    $users = Auth::user();
     //    $permited_branch = permited_branch(explode(',',$users->branch_ids));
     //    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

       
     //      $request_branchs = $request->_branch_id ?? [];
     //      $request_cost_centers = $request->_cost_center ?? [];

     //      $_branch_ids = filterableBranch($request_branchs,$permited_branch);
     //      $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

     //      $_branch_ids_rows = implode(',', $_branch_ids);
     //      $_cost_center_id_rows = implode(',', $_cost_center_ids);
                


       session()->put('ledgerReprtFilter', $request->all());
       $previous_filter= Session::get('ledgerReprtFilter');

     
                  
       $ledger_info = AccountLedger::with(['account_type','account_group','_entry_branch'])->find($request->_ledger_id);
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
         $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

       

        
$page_name = "Ledger Report";
      $ledger_id_rows = (int) $request->_ledger_id;
       
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

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     $string_query = " 
     SELECT s1._voucher_code, s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name, s1._id,s1._table_name, s1._date, s1._short_narration, s1._narration, s1._dr_amount, s1._cr_amount, s1._balance,s1._serial,s1._reference FROM(

     SELECT '' as _voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, null as _id,null as _table_name, null as _date, null as _short_narration, 'Opening Balance' as _narration, 0 AS _dr_amount, 0  AS _cr_amount, SUM(t1._dr_amount-t1._cr_amount) AS _balance ,0 as _serial ,'' as _reference
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
      UNION ALL
            SELECT t1._voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, t1._dr_amount AS _dr_amount, t1._cr_amount  AS _cr_amount, 0 AS _balance ,t1._serial as _serial ,t1._reference
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") ) as s1 order by s1._date,s1._id,s1._serial ASC  ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }

}else{
   $group_array_values = array();
}
$ledger_details =[];

      //return $group_array_values;
        return view('backend.account-report.ledger_report_with_item_detail_response',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','group_array_values','_datex','_datey','ledger_id_rows','ledger_info'));

    }

  //###################################
  //
  //
  //####################################

    public function chartOfAccount(Request $request){
       
         $page_name = "Chart of Accounts";
          $data = MainAccountHead::with(['_account_type'])->get();
        
      return view('backend.account-report.chart-of-account',compact('request','page_name','data'));

    }


    public function chartOfLedger(Request $request){
       
        $page_name = "Chart of Ledger";
         $data = MainAccountHead::with(['_account_type'])->get();
        
      return view('backend.account-report.chart-of-ledger',compact('request','page_name','data'));

    }


    public function ledgerReprtShow(Request $request){
        //return $request->all();
    	 $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_ledger_id' => 'required'
        ]);
         $_datex =  change_date_format($request->_datex);
         $_datey=  change_date_format($request->_datey);
     //    $users = Auth::user();
     //    $permited_branch = permited_branch(explode(',',$users->branch_ids));
     //    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

       
     //      $request_branchs = $request->_branch_id ?? [];
     //      $request_cost_centers = $request->_cost_center ?? [];

     //      $_branch_ids = filterableBranch($request_branchs,$permited_branch);
     //      $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

     //      $_branch_ids_rows = implode(',', $_branch_ids);
     //      $_cost_center_id_rows = implode(',', $_cost_center_ids);
                


       session()->put('ledgerReprtFilter', $request->all());
       $previous_filter= Session::get('ledgerReprtFilter');

     
                  
       $ledger_info = AccountLedger::with(['account_type','account_group','_entry_branch'])->find($request->_ledger_id);
    	
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
         $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

       

        
$page_name = "Ledger Report";
      $ledger_id_rows = (int) $request->_ledger_id;
       
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

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     $string_query = " 
     SELECT s1._voucher_code, s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name, s1._id,s1._table_name, s1._date, s1._short_narration, s1._narration, s1._dr_amount, s1._cr_amount, s1._balance,s1._serial FROM(

     SELECT '' as _voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, null as _id,null as _table_name, null as _date, null as _short_narration, 'Opening Balance' as _narration, 0 AS _dr_amount, 0  AS _cr_amount, SUM(t1._dr_amount-t1._cr_amount) AS _balance ,0 as _serial 
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
      UNION ALL
            SELECT t1._voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, t1._dr_amount AS _dr_amount, t1._cr_amount  AS _cr_amount, 0 AS _balance ,t1._serial as _serial
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") ) as s1 order by s1._date,s1._id,s1._serial ASC  ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }

    }else{
       $group_array_values = array();
    }
    $ledger_details =[];

      //return $group_array_values;
    	return view('backend.account-report.ledger_show',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','group_array_values','_datex','_datey','ledger_id_rows','ledger_info'));

}




    public function full_ledger_detail(Request $request){
        //return $request->all();
         $this->validate($request, [
            '_ledger_id' => 'required'
        ]);
       
          


       session()->put('ledgerReprtFilter', $request->all());
       $previous_filter= Session::get('ledgerReprtFilter');

     
                  
       $ledger_info = AccountLedger::with(['account_type','account_group','_entry_branch'])->find($request->_ledger_id);
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];


       

        
$page_name = "Ledger Report";
      $ledger_id_rows = (int) $request->_ledger_id;
       
    

    //End of Organization ,Branch,Cost Center IDS
      
     if($ledger_id_rows){
     $string_query = " 
     SELECT s1._voucher_code, s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name, s1._id,s1._table_name, s1._date, s1._short_narration, s1._narration, s1._dr_amount, s1._cr_amount, s1._balance,s1._serial,s1._reference FROM(

            SELECT t1._voucher_code, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, t1._dr_amount AS _dr_amount, t1._cr_amount  AS _cr_amount, 0 AS _balance ,t1._serial as _serial,t1._reference
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 
              AND t1._account_ledger IN(".$ledger_id_rows.")  ) as s1 order by s1._date,s1._id,s1._serial ASC  ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }

    }else{
       $group_array_values = array();
    }
    $ledger_details =[];

        return view('backend.account-report.full_ledger_detail',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','group_array_values','ledger_id_rows','ledger_info'));

}




public function group_wise_ledger_list(Request $request){

        $page_name = __('label.group_wise_ledger_list');
         $users = Auth::user();
        
        $datas=[];
  session()->put('filter_group_wise_ledger_list', $request->all());
       $previous_filter= Session::get('filter_group_wise_ledger_list');

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

    $account_types         = \DB::table('account_heads')->orderBy('_name','ASC')->get();
     $account_groups        = \DB::table("account_groups")->orderBy('_name','ASC')->get();

     if($request->has('_account_group_id')){

        $datas   = AccountLedger::with(['account_type']);

        if($request->has('organization_id') && $request->organization_id !=''){
            $datas   = $datas->where('organization_id',$request->organization_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !='all'){
            $datas   = $datas->where('_branch_id',$request->_branch_id);
        }
        if($request->has('_account_group_id') && $request->_account_group_id !=''){
            $datas   = $datas->whereIn('_account_group_id',$request->_account_group_id);
        }
        $datas   = $datas->orderBy('_name','ASC')->get();

     }


    return view('backend.account-report.group_wise_ledger_list',compact('datas','page_name','account_types','account_groups','permited_organizations','permited_branch','permited_costcenters','request','previous_filter'));
}


public function group_wise_ledger_list_reset(){
     Session::flash('filter_group_wise_ledger_list');
         return redirect()->back();
}





//Day book filter
    public function dayBook(Request $request){
        $previous_filter= Session::get('filter_day_book');
        $page_name = "Day Book";
        $voucher_types = VoucherType::select('_name','_code')->get();
        $transactions=DB::select('SELECT DISTINCT `_transaction` FROM `accounts`'); 
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_day_book',compact('request','page_name','voucher_types','previous_filter','permited_branch','permited_costcenters','transactions'));
    }

    public function dayBookReport(Request $request){


        //return $request->all();

      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_transaction' => 'required',
        ]);

        session()->put('filter_day_book', $request->all());
        $previous_filter= Session::get('filter_day_book');
        $page_name = "Day Book";
         $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];

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

    //End of Organization ,Branch,Cost Center IDS

        $_voucher_types = $request->_voucher_type ?? [];
        $_transaction = $request->_transaction ?? 'all';
        $_voucher_types_codes='';
         if(sizeof($_voucher_types) > 0){
          foreach ($_voucher_types as $value) {
            $_voucher_types_codes .="'".$value."',";
          }
          $_voucher_types_codes = rtrim($_voucher_types_codes,",");
        }
        


        $query = " SELECT `_ref_master_id` as _id,`_short_narration`,`_narration`,`_reference`,`_transaction`,`_voucher_type`,`_date`,`_account_group`,`_account_ledger`,`_dr_amount`,`_cr_amount`,`_table_name` FROM
         `accounts` WHERE  _status=1 AND _date  >= '".$_datex."'  AND _date <= '".$_datey."' 
               AND  _branch_id IN(".$_branch_ids_rows.") AND organization_id IN(".$_organization_id_rows.") AND  _cost_center IN(".$_cost_center_id_rows.")  ";
          if(sizeof($_voucher_types) > 0){
            $query .= " AND _voucher_type IN(".$_voucher_types_codes.") ";
          }
          if($_transaction !='all'){
             $query .= " AND _transaction ='".$_transaction."' ";
          }
          $query .= " ORDER BY _date, _ref_master_id ASC";
           $query_result = DB::select($query);
           $_result_group = array();
           foreach ($query_result as $value) {
             $_result_group["ID:".$value->_id." | Date:"._view_date_formate($value->_date)." | Transaction: ".$value->_transaction." | Type: ".$value->_voucher_type." | Reference".$value->_reference ??'N/A'][]=$value;
           }

         
        return view('backend.account-report.report_day_book',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_result_group'));

    }

public function dayBookFilterReset(){
  Session::flash('filter_day_book');
  return redirect()->back();
}


//Day Wise Summary Report For Restaurant Part

 public function dayWiseSummaryReportFilter(Request $request){
        $previous_filter= Session::get('day_wise_summary_report_filter');
        $page_name = "Work Period Sales Summary Report";
         
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_day_wise_summary_report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));
    }


public function dayWiseSummaryReport(Request $request){

  $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
        ]);

        session()->put('day_wise_summary_report_filter', $request->all());
        $previous_filter= Session::get('day_wise_summary_report_filter');
        $page_name = "Work Period Sales Summary Report";
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $request_organizations = $request->organization_id ?? '';
        $request_branchs = $request->_branch_id ?? '';
        $request_cost_centers = $request->_cost_center ?? '';

        if($request_branchs =='all'){
          $request_branchs =  $users->branch_ids;
        }

        if($request_cost_centers =='all'){
          $request_cost_centers =  $users->cost_center_ids;
        }

    if($request_organizations =='all'){
        $request_organizations = $users->organization_ids;
    }
    $_organization_id_rows = $request_branchs;;
    $_branch_ids_rows = $request_branchs;
    $_cost_center_id_rows = $request_cost_centers;


  $ResturantFormSetting = ResturantFormSetting::first();

  $_default_sales = $ResturantFormSetting->_default_sales;
  $_default_discount = $ResturantFormSetting->_default_discount;
  $_default_vat_account = $ResturantFormSetting->_default_vat_account;
  $_default_service_charge = $ResturantFormSetting->_default_service_charge;
  $_default_other_charge = $ResturantFormSetting->_default_other_charge;
  $_default_delivery_charge = $ResturantFormSetting->_default_delivery_charge;

  $sales_return_form_settings           = \DB::table("sales_return_form_settings")->first();
  $_default_sales_return                = $sales_return_form_settings->_default_sales ?? 0;
  $_default_discount_sales_return       = $sales_return_form_settings->_default_discount ?? 0;
  $_default_vat_account_sales_return    = $sales_return_form_settings->_default_vat_account ?? 0;

   

  $_sales =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_sales.") AND  t1._branch_id IN(".$_branch_ids_rows.")  AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_sales_result = DB::select($_sales);



  $_sales_return =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_sales_return.") AND  t1._branch_id IN(".$_branch_ids_rows.")  AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_sales_return_resutl = DB::select($_sales_return);

  

  $_discount =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_discount.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_discount_result = DB::select($_discount);
  
  $_vat_account =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_vat_account.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_vat_account_result = DB::select($_vat_account);

  $_service_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_service_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_service_charge_result = DB::select($_service_charge);

  $_other_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_other_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_other_charge_result = DB::select($_other_charge);
  
  $_delivery_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_delivery_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_delivery_charge_result = DB::select($_delivery_charge);


   // $_cash_group_details = GeneralSettings::select("_cash_group")->first();
   // $_cash_group = $_cash_group_details->_cash_group ?? 0;


  $cash_and_bank_groups_ids   = cash_and_bank_groups(); //



   $all_cash_group =" SELECT SUM(t1._dr_amount-t1._cr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_group IN(".$cash_and_bank_groups_ids.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") ";
    $all_cash_group_result = DB::select($all_cash_group);
     $total_cashin_hand = $all_cash_group_result[0]->_balance ?? 0;


   $ledger_group_query =" SELECT  t3._name as _l_name,SUM(t1._dr_amount-t1._cr_amount) as _balance
            FROM accounts AS t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_group IN(".$cash_and_bank_groups_ids.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 
              GROUP BY t1._account_ledger   ";
    $ledger_groupd_result = DB::select($ledger_group_query);


 $item_sales_query ="
SELECT s1._category_id,s2._name as _cat_name, SUM(_total_qty) as _total_qty, SUM(_total_value) as _total_value FROM (

      SELECT t2._item_id, t3._item AS _item_name,t2._qty AS _total_qty, (t2._value) AS _total_value,t3._category_id 
     FROM resturant_sales AS t1 
INNER JOIN resturant_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 


UNION ALL

SELECT t2._item_id, t3._item AS _item_name,t2._qty AS _total_qty, (t2._value) AS _total_value ,t3._category_id
     FROM sales AS t1 
INNER JOIN sales_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 

) as s1
INNER JOIN item_categories as s2 on s1._category_id=s2.id

 GROUP BY s1._category_id ORDER BY s2._name ASC

";
    $item_sales_res = DB::select($item_sales_query);





  return view('backend.account-report.report_day_wise_summary_res',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_default_sales_result','_default_discount_result','_default_vat_account_result','_default_service_charge_result','_default_other_charge_result','_default_delivery_charge_result','ledger_groupd_result','total_cashin_hand','item_sales_res','_sales_return_resutl'));
  
}

public function dayWiseSummaryReportFilterReset(){
  Session::flash('day_wise_summary_report_filter');
  return redirect()->back();
}


public function itemSalesReportFilter(Request $request){
   $previous_filter= Session::get('filter_item_sales_report');
    $page_name = "Item Sales Report";
     
    $users = Auth::user();
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
    return view('backend.account-report.filter_item_sales_report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));
}

public function itemSalesReport(Request $request){
    $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
        ]);

        session()->put('filter_item_sales_report', $request->all());
        $previous_filter= Session::get('filter_item_sales_report');
        $page_name = "Item Sales Report";
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
      

  $ResturantFormSetting = ResturantFormSetting::first();
  $_default_sales = $ResturantFormSetting->_default_sales;
  $_default_discount = $ResturantFormSetting->_default_discount;
  $_default_vat_account = $ResturantFormSetting->_default_vat_account;
  $_default_service_charge = $ResturantFormSetting->_default_service_charge;
  $_default_other_charge = $ResturantFormSetting->_default_other_charge;
  $_default_delivery_charge = $ResturantFormSetting->_default_delivery_charge;


        $request_organizations = $request->organization_id ?? '';
        $request_branchs = $request->_branch_id ?? '';
        $request_cost_centers = $request->_cost_center ?? '';

        if($request_branchs =='all'){
          $request_branchs =  $users->branch_ids;
        }

        if($request_cost_centers =='all'){
          $request_cost_centers =  $users->cost_center_ids;
        }

    if($request_organizations =='all'){
        $request_organizations = $users->organization_ids;
    }
    $_organization_id_rows = $request_branchs;;
    $_branch_ids_rows = $request_branchs;
    $_cost_center_id_rows = $request_cost_centers;



  $_sales =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_sales.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_sales_result = DB::select($_sales);

  $_discount =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_discount.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_discount_result = DB::select($_discount);
  
  $_vat_account =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_vat_account.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_vat_account_result = DB::select($_vat_account);

  $_service_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_service_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_service_charge_result = DB::select($_service_charge);

  $_other_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_other_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_other_charge_result = DB::select($_other_charge);
  
  $_delivery_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_delivery_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_delivery_charge_result = DB::select($_delivery_charge);


   // $_cash_group_details = GeneralSettings::select("_cash_group")->first();
   // $_cash_group = $_cash_group_details->_cash_group ?? 0;

   $cash_and_bank_groups_ids   = cash_and_bank_groups(); //

    $all_cash_group =" SELECT  t2._name as _l_name,SUM(t1._dr_amount-t1._cr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_group IN(".$cash_and_bank_groups_ids.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")  ";
    $all_cash_group_result = DB::select($all_cash_group);
     $total_cashin_hand = $all_cash_group_result[0]->_balance ?? 0;


   $ledger_group_query =" SELECT  t3._name as _l_name,SUM(t1._dr_amount) as _balance
            FROM accounts AS t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_group IN(".$cash_and_bank_groups_ids.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 
              GROUP BY t1._account_ledger   ";
    $ledger_groupd_result = DB::select($ledger_group_query);



    //Restaurant Sales Item
     $item_sales_query ="
SELECT s1._item_id, s1._code,s1._item_name,s1._transection_unit,s3._name as _tran_name,SUM(_total_qty) as _total_qty, SUM(_total_value) as _total_value FROM (

      SELECT t2._item_id,t3._code, t3._item AS _item_name,t2._transection_unit,t2._qty AS _total_qty, (t2._qty*t2._sales_rate) AS _total_value 
     FROM resturant_sales AS t1 
INNER JOIN resturant_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 


UNION ALL

SELECT t2._item_id, t3._code, t3._item AS _item_name,t2._transection_unit,t2._qty AS _total_qty, (t2._qty*t2._sales_rate) AS _total_value 
     FROM sales AS t1 
INNER JOIN sales_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 

) as s1 
LEFT JOIN units as s3 ON s3.id=s1._transection_unit

GROUP BY s1._item_id ORDER BY s1._item_name ASC

";
    $item_sales_res = DB::select($item_sales_query);



  return view('backend.account-report.report_item_sales_report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_default_sales_result','_default_discount_result','_default_vat_account_result','_default_service_charge_result','_default_other_charge_result','_default_delivery_charge_result','ledger_groupd_result','total_cashin_hand','item_sales_res'));
}

public function itemSalesReportFilterReset(){
  Session::flash('filter_item_sales_report');
  return redirect()->back();
}



public function detailItemSalesReportFilter(Request $request){
   $previous_filter= Session::get('filter_deail_item_sales_report');
    $page_name = "Item Details Sales Report";
     
    $users = Auth::user();
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
    return view('backend.account-report.filter_deail_item_sales_report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));
}

public function detailItemSalesReportFilterReset(){
  Session::flash('filter_deail_item_sales_report');
  return redirect()->back();
}

public function detailItemSalesReport(Request $request){
    $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
        ]);

        session()->put('filter_deail_item_sales_report', $request->all());
        $previous_filter= Session::get('filter_deail_item_sales_report');
        $page_name = "Item Sales Report";
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];




        $request_organizations = $request->organization_id ?? '';
        $request_branchs = $request->_branch_id ?? '';
        $request_cost_centers = $request->_cost_center ?? '';

        if($request_branchs =='all'){
          $request_branchs =  $users->branch_ids;
        }

        if($request_cost_centers =='all'){
          $request_cost_centers =  $users->cost_center_ids;
        }

    if($request_organizations =='all'){
        $request_organizations = $users->organization_ids;
    }
    $_organization_id_rows = $request_branchs;;
    $_branch_ids_rows = $request_branchs;
    $_cost_center_id_rows = $request_cost_centers;



  $ResturantFormSetting = ResturantFormSetting::first();
  $_default_sales = $ResturantFormSetting->_default_sales;
  $_default_discount = $ResturantFormSetting->_default_discount;
  $_default_vat_account = $ResturantFormSetting->_default_vat_account;
  $_default_service_charge = $ResturantFormSetting->_default_service_charge;
  $_default_other_charge = $ResturantFormSetting->_default_other_charge;
  $_default_delivery_charge = $ResturantFormSetting->_default_delivery_charge;


//return $request->all();

        // $_branch_ids = filterableBranch($request_branchs,$permited_branch);
        // $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);
        // $_branch_ids_rows = implode(',', $_branch_ids);
        // $_cost_center_id_rows = implode(',', $_cost_center_ids);


        

   $item_sales_query =" 
SELECT   SUM(s1._total_qty) AS _total_qty, SUM(s1._total_value) AS _total_value,s1._unit_id FROM(
   SELECT t2._item_id,t3._item, t2._qty AS _total_qty, t2._value AS _total_value,t3._unit_id 
   FROM resturant_sales AS t1 
INNER JOIN resturant_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
UNION ALL

   SELECT t2._item_id,t3._item, t2._qty AS _total_qty, t2._value AS _total_value,t3._unit_id 
   FROM sales AS t1 
INNER JOIN sales_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
) as s1  

 ";
     $item_sales_res = DB::select($item_sales_query);

     $total_qty = $item_sales_res[0]->_total_qty ?? 0;
     $_total_value = $item_sales_res[0]->_total_value ?? 0;

//Sales By Group

$item_group_query ="

SELECT s1._category_id, s1._name,
      SUM(s1._total_qty) AS _total_qty, SUM(s1._value) AS _value  FROM(
 SELECT t3._category_id, t4._name as _name,
      (t2._qty) AS _total_qty, (t2._value) AS _value ,t3._unit_id
      FROM resturant_sales AS t1 
      INNER JOIN resturant_details AS t2 ON t1.id=t2._no
      INNER JOIN inventories AS t3 ON t2._item_id=t3.id
      INNER JOIN item_categories AS t4 ON t4.id=t3._category_id
      WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
UNION ALL
 SELECT t3._category_id, t4._name as _name,
      (t2._qty) AS _total_qty, (t2._value) AS _value ,t3._unit_id
      FROM sales AS t1 
      INNER JOIN sales_details AS t2 ON t1.id=t2._no
      INNER JOIN inventories AS t3 ON t2._item_id=t3.id
      INNER JOIN item_categories AS t4 ON t4.id=t3._category_id
      WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'

) as s1 GROUP BY s1._category_id ORDER BY s1._name ASC

       ";


  $item_group_res = DB::select($item_group_query);

$item_detail_query =" 
SELECT s1._order_number,s1._category_id, s1._cat_name, s1._code, s1._name,s1._qty,
s1._sales_rate, s1._value ,s1._unit_id FROM(

SELECT t1._order_number,t3._category_id, t4._name as _cat_name, t3._code, t3._item as _name,t2._qty AS _qty,
t2._sales_rate AS _sales_rate, (t2._qty*t2._sales_rate) AS _value ,t3._unit_id
FROM resturant_sales AS t1 
INNER JOIN resturant_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
INNER JOIN item_categories AS t4 ON t4.id=t3._category_id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
UNION ALL

SELECT t1._order_number, t3._category_id, t4._name as _cat_name, t3._code,t3._item as _name,t2._qty AS _qty,
t2._sales_rate AS _sales_rate, (t2._qty*t2._sales_rate) AS _value ,t3._unit_id
FROM sales AS t1 
INNER JOIN sales_details AS t2 ON t1.id=t2._no
INNER JOIN inventories AS t3 ON t2._item_id=t3.id
INNER JOIN item_categories AS t4 ON t4.id=t3._category_id
WHERE 1=1 AND t2._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
) as s1 ORDER BY s1._name ASC ";
 $item_detail_res = DB::select($item_detail_query);

 $item_detail_res_group_by_category = array();
 foreach($item_detail_res as $key=>$item_val){
    $item_detail_res_group_by_category[$item_val->_cat_name][]=$item_val;
 }



//return $item_detail_res_group_by_category;

   // $_cash_group_details = GeneralSettings::select("_cash_group")->first();
   // $_cash_group = $_cash_group_details->_cash_group ?? 0;

  $cash_and_bank_groups_ids   = cash_and_bank_groups(); //

    $all_cash_group =" SELECT  t2._name as _l_name,SUM(t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_group IN(".$cash_and_bank_groups_ids.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")  ";
    $all_cash_group_result = DB::select($all_cash_group);
     $total_cashin_hand = $all_cash_group_result[0]->_balance ?? 0;


   $ledger_group_query =" SELECT  t3._name as _l_name,SUM(t1._dr_amount) as _balance
            FROM accounts AS t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_group IN(".$cash_and_bank_groups_ids.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 
              GROUP BY t1._account_ledger   ";
    $ledger_groupd_result = DB::select($ledger_group_query);



    $_sales =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_sales.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_sales_result = DB::select($_sales);

  $_discount =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_discount.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_discount_result = DB::select($_discount);
  
  $_vat_account =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_vat_account.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_vat_account_result = DB::select($_vat_account);

  $_service_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_service_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_service_charge_result = DB::select($_service_charge);

  $_other_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_other_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_other_charge_result = DB::select($_other_charge);
  
  $_delivery_charge =" SELECT  t1._account_ledger AS _account_ledger,t3._name as _l_name,SUM(t1._cr_amount-t1._dr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$_default_delivery_charge.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") GROUP BY t1._account_ledger ";
  $_default_delivery_charge_result = DB::select($_delivery_charge);






  return view('backend.account-report.report_detail_item_sales_report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','total_qty','_total_value','item_group_res','item_detail_res','ledger_groupd_result','total_cashin_hand','item_detail_res_group_by_category','_default_discount_result','_default_vat_account_result','_default_service_charge_result','_default_other_charge_result','_default_delivery_charge_result'));
}

//Cash book filter
    public function cashBook(Request $request){
        $previous_filter= Session::get('filter_cash_book');
        $page_name = "Cash Book";
          $_cash_groups = \DB::select( " SELECT _cash_group FROM general_settings  " );
     $_cash_group= $_cash_groups[0]->_cash_group ?? 0;

        $account_ledgers = \DB::select( " SELECT t1._code, t1.id,t1._account_head_id,t1._account_group_id,t1._name FROM account_ledgers AS t1 WHERE t1._account_group_id IN ($_cash_group ) " );
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_cash_book',compact('request','page_name','account_ledgers','previous_filter','permited_branch','permited_costcenters'));
    }

    public function cashBookReport(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_account_ledger_id' => 'required',
        ]);

        session()->put('filter_cash_book', $request->all());
        $previous_filter= Session::get('filter_cash_book');
        $page_name = "Cash Book";
         $users = Auth::user();
       
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];
        $ledger_ids = $request->_account_ledger_id ?? [];
        $ledger_id_rows = implode(',', $ledger_ids);

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

    //End of Organization ,Branch,Cost Center IDS
        



        $opening_query_sting = "

        SELECT l1._type as _type,l1._voucher_code,l1._date as _date,l1._account_ledger as _account_ledger,l1._l_name as _l_name, l1._short_narration as _short_narration,l1._reference,l1._table_name,l1._id,l1._dr_amount,l1._cr_amount,l1._serial FROM (
         SELECT 'A. Opening Cash' as _type,'' as _voucher_code,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger  
UNION ALL
SELECT 'B. Receipt & Payment' as _type,t1._voucher_code,t1._date, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._short_narration as _short_narration,t1._reference as _reference,t1._table_name, t1._ref_master_id as _id,t1._dr_amount as _dr_amount,t1._cr_amount as _cr_amount,t1._serial
            FROM accounts as t1
             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
               AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 

    UNION ALL
    SELECT  'C. Closing Cash' as _type,'' as _voucher_code,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date <= '".$_datey."'  AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger ) AS l1 ORDER By l1._type,l1._date,l1._id ASC ";

         $_opening_balance =  DB::select($opening_query_sting);
         $_result_group =array();
         foreach ($_opening_balance as $value) {
           $_result_group[$value->_type][]=$value;
         }
        // return $_result_group;
        return view('backend.account-report.report_cash_book',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_result_group'));

    }

public function cashBookFilterReset(){
  Session::flash('filter_cash_book');
  return redirect()->back();
}


//Bank book filter
    public function bankBook(Request $request){
        $previous_filter= Session::get('filter_bank_book');
        $page_name = "Bank Book";
        $account_ledgers = \DB::select( " SELECT t1.id,t1._account_head_id,t1._account_group_id,t1._name FROM account_ledgers AS t1 WHERE t1._account_group_id=(SELECT _bank_group FROM general_settings ) " );
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_bank_book',compact('request','page_name','account_ledgers','previous_filter','permited_branch','permited_costcenters'));
    }

    public function bankBookReport(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_account_ledger_id' => 'required',
        ]);

        session()->put('filter_bank_book', $request->all());
        $previous_filter= Session::get('filter_bank_book');
        $page_name = "Bank Book";
         $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];

      
        $ledger_ids = $request->_account_ledger_id ?? [];

        $ledger_id_rows = implode(',', $ledger_ids);
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

    //End of Organization ,Branch,Cost Center IDS
        





        $opening_query_sting = " SELECT 'A. Opening Bank' as _type,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger 
UNION ALL
SELECT 'B. Receipt & Payment' as _type,t1._date, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._short_narration as _short_narration,t1._reference as _reference,t1._table_name, t1._ref_master_id as _id,t1._dr_amount as _dr_amount,t1._cr_amount as _cr_amount,t1._serial
            FROM accounts as t1
             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
               AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")

    UNION ALL
    SELECT 'C. Closing Bank' as _type,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date <= '".$_datey."'  AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger ";

         $_opening_balance =  DB::select($opening_query_sting);
         $_result_group =array();
         foreach ($_opening_balance as $value) {
           $_result_group[$value->_type][]=$value;
         }
        return view('backend.account-report.report_bank_book',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_result_group'));

    }

public function bankBookFilterReset(){
  Session::flash('filter_bank_book');
  return redirect()->back();
}



public function dateWiseInvoice(Request $request){
        $users = Auth::user();
        $previous_filter= Session::get('filter_date_wise_invoice_print');
        $page_name = "Date Wise Invoice Print";
        $sales_mans = DB::select(" SELECT id,_name FROM account_ledgers WHERE id IN(SELECT DISTINCT t1._sales_man_id FROM sales AS t1  WHERE t1._sales_man_id !=0) ");
        $delivery_mans = DB::select(" SELECT id,_name FROM account_ledgers WHERE id IN(SELECT DISTINCT t1._delivery_man_id FROM sales AS t1  WHERE t1._delivery_man_id !=0) ");
        $users_info = DB::select(" SELECT DISTINCT _user_name as name FROM sales  ");
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        return view('backend.account-report.filter_date_wise_invoice_print',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','sales_mans','delivery_mans','users_info','permited_organizations'));
    }





     public function dateWiseInvoiceReport(Request $request){
   //   return $request->all();
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_branch_id' => 'required',
            '_cost_center' => 'required',
        ]);
        session()->put('filter_date_wise_invoice_print', $request->all());
        $previous_filter= Session::get('filter_date_wise_invoice_print');
        $page_name = "Sales Invoice";
         $users = Auth::user();
         $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $request_branchs = $request->_branch_id ?? '';
        if($request_branchs =='all'){
           $_branch_ids =  explode(',',$users->branch_ids);
        }else{
            $_branch_ids = explode(',',$request_branchs);
        }
        

        $request_cost_centers = $request->_cost_center ?? '';
        if($request_cost_centers =='all'){
           $_cost_center_ids =  explode(',',$users->cost_center_ids);
        }else{
            $_cost_center_ids = explode(',',$request_cost_centers);
        }

        $organization_id = $request->organization_id ?? '';
        if($organization_id =='all'){
           $organization_ids =  explode(',',$users->organization_ids);
        }else{
            $organization_ids = explode(',',$organization_id);
        }

        $_delivery_man_id = $request->_delivery_man_id ?? '';
        if($_delivery_man_id =='all'){
           $_delivery_man_ids =  explode(',',$users->_delivery_man_ids);
        }else{
            $_delivery_man_ids = explode(',',$_delivery_man_id);
        }

        $_sales_man_id = $request->_sales_man_id ?? '';
        if($_sales_man_id =='all'){
           $_sales_man_ids =  explode(',',$users->_sales_man_ids);
        }else{
            $_sales_man_ids = explode(',',$_sales_man_id);
        }
        //_sales_man_ids
      //  $_delivery_man_ids = $request->_delivery_man_id ?? '';
        $user_names = $request->_name ?? '';
      //  $organization_ids = $request->organization_id ?? '';

        
     
        $datas = Sales::with(['_master_branch','_master_details','s_account','_ledger','_terms_con','_sales_man','_delivery_man'])->where('_status',1);
        $datas = $datas->whereDate('_date','>=', $_datex);
        $datas = $datas->whereDate('_date','<=', $_datey);
        if($request->has('organization_id')){
                    $datas = $datas->whereIn('organization_id',$organization_ids);
        } 

        if($request->has('_cost_center_id')){
                    $datas = $datas->whereIn('_cost_center_id',$_cost_center_ids);
        }       
        if($request->has('_branch_id')){
                    $datas = $datas->whereIn('_branch_id',$_branch_ids);
        }
        if($request->has('_delivery_man_id')){
                    $datas = $datas->whereIn('_delivery_man_id',$_delivery_man_ids);
        }

        if($request->has('_sales_man_id') && $request->_name !='all'){
            $datas = $datas->whereIn('_sales_man_id',$_sales_man_ids);
        }
        if($request->has('_name') && $request->_name !='all'){
            $datas = $datas->where('_user_name',$user_names);
        }
         $datas = $datas->orderBy('_date','ASC')
                                ->get();
         $form_settings = SalesFormSetting::first();
      

return view('backend.account-report.report_date_wise_invoice_print',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas','form_settings'));


    }


public function dateWiseInvoiceFilterReset(){
  Session::flash('filter_date_wise_invoice_print');
  return redirect()->back();
}


public function dateWiseRestaurantInvoice(Request $request){
        $users = Auth::user();
        $previous_filter= Session::get('filter_date_wise_invoice_print');
        $page_name = "Date Wise Invoice Print";
        $sales_mans = DB::select(" SELECT id,_name FROM account_ledgers WHERE id IN(SELECT DISTINCT t1._sales_man_id FROM resturant_sales AS t1  WHERE t1._sales_man_id !=0) ");
        $delivery_mans = DB::select(" SELECT id,_name FROM account_ledgers WHERE id IN(SELECT DISTINCT t1._delivery_man_id FROM resturant_sales AS t1  WHERE t1._delivery_man_id !=0) ");
        $users_info = DB::select(" SELECT DISTINCT _user_name as name FROM resturant_sales  ");
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_date_wise_restaurant_invoice_print',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','sales_mans','delivery_mans','users_info'));
    }



    

     public function dateWiseRestaurantInvoiceReport(Request $request){
   //   return $request->all();
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_branch_id' => 'required',
            '_cost_center' => 'required',
        ]);
        session()->put('filter_date_wise_restaurnt_invoice_print', $request->all());
        $previous_filter= Session::get('filter_date_wise_restaurnt_invoice_print');
        $page_name = "Date Wise Invoice Print";
         $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];
        $_delivery_man_ids = $request->_delivery_man_id ?? [];
        $user_names = $request->_name ?? [];
        
      $_branch_ids = filterableBranch($request_branchs,$permited_branch);
      $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);
       $datas = ResturantSales::with(['_master_branch','_master_details','s_account','_ledger','_delivery_man','_sales_man'])->where('_status',1);
        $datas = $datas->whereDate('_date','>=', $_datex);
        $datas = $datas->whereDate('_date','<=', $_datey);
        if($request->has('_cost_center_id')){
                    $datas = $datas->whereIn('_cost_center_id',$_cost_center_ids);
        }       
        if($request->has('_branch_id')){
                    $datas = $datas->whereIn('_branch_id',$_branch_ids);
        }
        if($request->has('_delivery_man_id')){
                    $datas = $datas->whereIn('_delivery_man_id',$_delivery_man_ids);
        }

        if($request->has('_sales_man_id')){
            $datas = $datas->whereIn('_sales_man_id',$request->_sales_man_id);
        }
        if($request->has('_name')){
            $datas = $datas->whereIn('_user_name',$user_names);
        }
        $datas = $datas->orderBy('_date','ASC')
                                ->get();
         $form_settings = ResturantFormSetting::first();
      

return view('backend.account-report.report_date_wise_restaurant_invoice_print',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','datas','form_settings'));


    }


public function dateWiseRestaurantInvoiceFilterReset(){
  Session::flash('filter_date_wise_restaurant_invoice_print');
  return redirect()->back();
}



   //User Receipt Payment
    public function userReceiptPayment(Request $request){
        $previous_filter= Session::get('filter_user_receipt_payment');
        $page_name = "User Wise Receipt & Payment";
        $_defalut_groups = \DB::select("SELECT _bank_group,_cash_group FROM general_settings");
        $_defalut_groups_array = array();
        foreach ($_defalut_groups as $value) {
          array_push($_defalut_groups_array ,intval($value->_bank_group));
          array_push($_defalut_groups_array ,intval($value->_cash_group));
        }
        $_defalut_groups_ids=implode(',', $_defalut_groups_array);

        $account_ledgers = \DB::select( " SELECT t1.id,t1._account_head_id,t1._account_group_id,t1._name FROM account_ledgers AS t1 WHERE t1._account_group_id IN(".$_defalut_groups_ids." ) " );
        $users = Auth::user();
        if($users->user_type=="admin"){
          $users_info =  DB::select(" SELECT DISTINCT _name as name FROM accounts  ");
        }else{
          $users_info =[];
        }
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_user_receipt_payment',compact('request','page_name','account_ledgers','previous_filter','permited_branch','permited_costcenters','users_info'));
    }



    public function userReceiptPaymentReport(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_account_ledger_id' => 'required',
            '_name' => 'required',
        ]);

        session()->put('filter_user_receipt_payment', $request->all());
        $previous_filter= Session::get('filter_user_receipt_payment');
        $page_name = "User Wise Receipt & Payment";
         $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];
        $user_names = $request->_name ?? [];
         $_user_name_codes='';
         if(sizeof($user_names) > 0){
          foreach ($user_names as $value) {
            $_user_name_codes .="'".$value."',";
          }
          $_user_name_codes = rtrim($_user_name_codes,",");
        }
        $ledger_ids = $request->_account_ledger_id ?? [];
        $ledger_id_rows = implode(',', $ledger_ids);

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

    //End of Organization ,Branch,Cost Center IDS


        $opening_query_sting = " 
SELECT l1._type,l1._date,l1._account_ledger,l1._l_name,l1._short_narration,l1._reference,l1._table_name,l1._id,l1._dr_amount,l1._cr_amount,l1._serial,l1._name FROM(
        SELECT 'A. Opening' as _type,'".$_datex."' as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial,t1._name
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") AND t1._name IN(".$_user_name_codes.")
                 GROUP BY t1._account_ledger,t1._name 
UNION ALL
SELECT 'B. Receipt & Payment' as _type,t1._date, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._short_narration as _short_narration,t1._reference as _reference,t1._table_name, t1._ref_master_id as _id,t1._dr_amount as _dr_amount,t1._cr_amount as _cr_amount,t1._serial,t1._name
            FROM accounts as t1
             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
               AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
               AND t1._name IN(".$_user_name_codes.")

    UNION ALL
    SELECT 'C. Closing' as _type,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial,t1._name
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date <= '".$_datey."'  AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
               AND t1._name IN(".$_user_name_codes.")
                 GROUP BY t1._account_ledger,t1._name 

                 ) as l1 ORDER BY l1._type,l1._date,l1._id ASC ";

         $_opening_balance =  DB::select($opening_query_sting);
         $_result_group =array();
         foreach ($_opening_balance as $value) {
           $_result_group[$value->_type."-".$value->_name][]=$value;
         }
        return view('backend.account-report.report_user_receipt_payment',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_result_group'));

    }

public function userReceiptPaymentFilterReset(){
  Session::flash('filter_user_receipt_payment');
  return redirect()->back();
}


//Bank book filter
    public function receiptPayment(Request $request){
        $previous_filter= Session::get('filter_receipt_payment');
        $page_name = "Receipt Payment";
        $_defalut_groups = \DB::select("SELECT CONCAT(`_bank_group`,',', `_cash_group`) AS bank_cash FROM `general_settings`");
        
        $_defalut_groups_ids=$_defalut_groups[0]->bank_cash ?? 0;

        $account_ledgers = \DB::select( " SELECT t1.id,t1._account_head_id,t1._account_group_id,t1._name FROM account_ledgers AS t1 WHERE t1._account_group_id IN(".$_defalut_groups_ids." ) " );
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('backend.account-report.filter_receipt_payment',compact('request','page_name','account_ledgers','previous_filter','permited_branch','permited_costcenters'));
    }

    public function receiptPaymentReport(Request $request){
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_account_ledger_id' => 'required',
        ]);

        session()->put('filter_receipt_payment', $request->all());
        $previous_filter= Session::get('filter_receipt_payment');
        $page_name = "Receipt Payment";
         $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
        $ledger_ids = $request->_account_ledger_id ?? [];
        $ledger_id_rows = implode(',', $ledger_ids);


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

    //End of Organization ,Branch,Cost Center IDS




        $opening_query_sting = " 
SELECT l1._type,l1._date,l1._account_ledger,l1._l_name,l1._voucher_code,l1._short_narration,l1._reference,l1._table_name,l1._id,l1._dr_amount,l1._cr_amount,l1._serial FROM(
        SELECT 'A. Opening' as _type,null as _voucher_code,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger 
UNION ALL
SELECT 'B. Receipt & Payment' as _type,t1._voucher_code,t1._date, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._short_narration as _short_narration,t1._reference as _reference,t1._table_name, t1._ref_master_id as _id,t1._dr_amount as _dr_amount,t1._cr_amount as _cr_amount,t1._serial
            FROM accounts as t1
             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
               AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")

    UNION ALL
    SELECT 'C. Closing' as _type,null as _voucher_code,null as _date,  t1._account_ledger AS _account_ledger,t3._name as _l_name,null as _short_narration,null as _reference,null as _table_name, null as _id,SUM(t1._dr_amount-t1._cr_amount) as _dr_amount,0 as _cr_amount,0 as _serial
            FROM accounts as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
               WHERE t1._status=1 AND t1._date <= '".$_datey."'  AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger  ) as l1 ORDER BY l1._type,l1._date,l1._id ASC ";

         $_opening_balance =  DB::select($opening_query_sting);
         $_result_group =array();
         foreach ($_opening_balance as $value) {
           $_result_group[$value->_type][]=$value;
         }
        return view('backend.account-report.report_receipt_payment',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_result_group'));

    }

public function receiptPaymentFilterReset(){
  Session::flash('filter_receipt_payment');
  return redirect()->back();
}

    public function groupLedger(Request $request){

        $previous_filter= Session::get('groupBaseLedgerReportFilter');
        $page_name = "Group Ledger Statement";
        $account_groups = \DB::select(" SELECT DISTINCT t2.id as id,t2._name as _name FROM accounts AS t1
                                        INNER JOIN account_groups AS t2 ON t1._account_group=t2.id WHERE t2._show_filter=1 ORDER BY t2._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.account-report.group_ledger',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function groupBaseLedgerReport(Request $request){
     // return $request->all();
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required'
        ]);

        $_status = $request->_status ?? '';
        if($_status ==''){
           $_status = "1,0";
        }

        session()->put('groupBaseLedgerReportFilter', $request->all());
        $previous_filter= Session::get('groupBaseLedgerReportFilter');
        $page_name = "Group Ledger Statement";
        
        $users = Auth::user();
        
        $datas=[];
        $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }

      $ledger_id_rows = implode(',', $ledger_ids);
       
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

    //End of Organization ,Branch,Cost Center IDS


      
     if($ledger_id_rows){
     $string_query = " 
      SELECT s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name, s1._id,s1._table_name, s1._date, s1._short_narration, s1._narration, s1._dr_amount, s1._cr_amount, s1._balance,s1._serial FROM(

     SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, null as _id,null as _table_name, null as _date, null as _short_narration, 'Opening Balance' as _narration, 0 AS _dr_amount, 0  AS _cr_amount, SUM(t1._dr_amount-t1._cr_amount) AS _balance,0 as _serial  
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") AND  t3._status IN(".$_status.")
                 GROUP BY t1._account_ledger
      UNION ALL
            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, t1._ref_master_id as _id, t1._table_name AS _table_name, t1._date as _date, t1._short_narration as _short_narration, t1._narration as _narration, t1._dr_amount AS _dr_amount, t1._cr_amount  AS _cr_amount, 0 AS _balance ,t1._serial as _serial
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") AND  t3._status IN(".$_status.") ) as s1 order by s1._date,s1._id,s1._serial ASC ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.account-report.group_ledger_report',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }


    

    public function groupBaseLedgerFilterReset(){
        Session::flash('groupBaseLedgerReportFilter');

        return redirect()->back();
    }
 public function filterLedgerSummarray(Request $request){

        $previous_filter= Session::get('ledgerSummaryFilter');
        $page_name = "Ledger Summary Report";
        $account_groups = \DB::select(" SELECT DISTINCT t2.id as id,t2._name as _name FROM accounts AS t1
                                        INNER JOIN account_groups AS t2 ON t1._account_group=t2.id WHERE t2._show_filter=1 ORDER BY t2._name ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.account-report.filter_ledger_summary',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }


    public function ledgerSummaryReport(Request $request){
   //  return $request->all();
      $this->validate($request, [
            '_branch_id' => 'required',
            '_account_group_id' => 'required'
        ]);

      $_status = $request->_status ?? '';
        if($_status ==''){
           $_status = "1,0";
        }

        session()->put('ledgerSummaryFilter', $request->all());
        $previous_filter= Session::get('ledgerSummaryFilter');
        $page_name = "Ledger Summary Report";
        $_order_by= $request->_order_by ?? 'DESC';
        $_with_zero= $request->_with_zero ?? 1;
        
       $users = Auth::user();
        
        $datas=[];

        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }
      $ledger_id_rows = implode(',', $ledger_ids);

       

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

    //End of Organization ,Branch,Cost Center IDS


      
     if($ledger_id_rows){
     $string_query = "  
            SELECT t1._account_group AS _account_group,t2._name as _group_name,t3._address,t3._phone, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, SUM(t1._dr_amount-t1._cr_amount) AS _balance
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND  t3._status IN(".$_status.")
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")    GROUP BY t1._account_ledger ";
              if($_with_zero ==1){
                $string_query .= " HAVING (abs(SUM(t1._dr_amount-t1._cr_amount)) > 0 )  ";
              }

              $string_query .= "   ORDER BY  abs(SUM(t1._dr_amount-t1._cr_amount))  $_order_by ";
           

        $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][]=$value;
       }

}else{
   $group_array_values = array();
}
        //return $group_array_values;
        return view('backend.account-report.report_ledger_summary',compact('request','page_name','group_array_values','basic_information','previous_filter','permited_branch','permited_costcenters'));
    }


    public function ledgerSummaryFilterReset(){
        Session::flash('ledgerSummaryFilter');

        return redirect()->back();
    }

    public function LedgerReportFilterReset(){
        Session::flash('ledgerReprtFilter');

        return redirect()->back();
    }



    public function trailBalance(Request $request){
        $previous_filter= Session::get('trailBalanceReportFilter');
        $page_name = "Trail Balance";
       $account_groups = \DB::select(" SELECT DISTINCT t2.id as id,t2._name as _name FROM accounts AS t1
                                        INNER JOIN account_groups AS t2 ON t1._account_group=t2.id WHERE t2._show_filter=1 ORDER BY t2._short ASC ");
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));


         
        return view('backend.account-report.trail-balance',compact('request','page_name','account_groups','previous_filter','permited_branch','permited_costcenters'));
    }




    public function trailBalanceReport(Request $request){
        //return $request->all();
      $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required'
        ]);

        session()->put('trailBalanceReportFilter', $request->all());
        $previous_filter= Session::get('trailBalanceReportFilter');
        $page_name = "Trail Balance";
       
        $datas=[];
         $_datex =  change_date_format($request->_datex);
        $_datey=  change_date_format($request->_datey);
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

    //End of Organization ,Branch,Cost Center IDS



        $group_ids = array();
        $_account_groups = $request->_account_group_id ?? [];
        if(sizeof($_account_groups) > 0){
            foreach ($_account_groups as $value) {
                array_push($group_ids, (int) $value);
            }
        }else{
            $account_groups = \DB::select(" SELECT  t1.id as id,t1._name as _name FROM account_groups AS t1  WHERE t1._show_filter=1 ORDER BY t1._name ASC ");
            foreach ($account_groups as $value) {
                array_push($group_ids, (int) $value->id);
            }
        }

//return $group_ids;

        $ledger_ids = array();
        $_account_ledgers = (array) $request->_account_ledger_id ?? [];
        if(sizeof($_account_ledgers) > 0){
            foreach ($_account_ledgers as $value) {
                array_push($ledger_ids, (int) $value);
            }
            $basic_information = AccountLedger::with(['account_group'])
                    ->select('_account_group_id','id as _ledger_id','_name')
                         ->whereIn('id',$_account_ledgers)->get();
        }else{
            $basic_information = AccountLedger::with(['account_group'])->select('_account_group_id','id as _ledger_id','_name')
            ->whereIn('_account_group_id',$group_ids)->get();
            foreach ($basic_information as $value) {
                array_push($ledger_ids, (int) $value->_ledger_id);
            }
        }


    

      $ledger_id_rows = implode(',', $ledger_ids);
      



      
      if($ledger_id_rows){
     $string_query = " 
 SELECT t5._account_group,t5._group_name, t5._account_ledger,t5._l_name,t5._branch_id,t5._cost_center, t5._branch_name,  SUM(t5._o_dr_amount)  AS _o_dr_amount, SUM(t5._o_cr_amount)  AS _o_cr_amount ,SUM(t5._c_dr_amount) as _c_dr_amount,SUM(t5._c_cr_amount) as _c_cr_amount FROM (
     SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount)  AS _o_dr_amount, SUM(t1._cr_amount)  AS _o_cr_amount ,0 as _c_dr_amount,0 as _c_cr_amount 
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
      UNION ALL
            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,0 as _cr_amount, 0 as _o_cr_amount, SUM(t1._dr_amount) AS _c_dr_amount, SUM(t1._cr_amount)  AS _c_cr_amount
            FROM accounts AS t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
              WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
              AND t1._account_ledger IN(".$ledger_id_rows.") AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
              GROUP BY t1._account_ledger
              ) as t5 GROUP BY t5._account_ledger  ";

       $datas = DB::select($string_query);
       $group_array_values = array();
       foreach ($datas as $value) {
           $group_array_values[$value->_group_name][$value->_l_name][]=$value;
       }
}else{
   $group_array_values = array();
}
     //  return $group_array_values;

       

        //return $group_array_values;
        return view('backend.account-report.trail-balance-report',compact('request','page_name','group_array_values','basic_information','_datex','_datey','previous_filter','permited_branch','permited_costcenters'));
    }

    public function trailBalanceReportFilterReset(){
        Session::flash('trailBalanceReportFilter');

        return redirect()->back();
    }


    public function incomeStatement(Request $request){
        $previous_filter= Session::get('incomeStatementFillter');
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
       

         
        return view('backend.account-report.income-statement',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','_filter_ledgers'));
    }


    public function incomeStatementReport(Request $request){
        $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required'
        ]);
         session()->put('incomeStatementFillter', $request->all());
        $previous_filter= Session::get('incomeStatementFillter');
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

    //End of Organization ,Branch,Cost Center IDS


        //AND t1.organization_id IN(".$_organization_id_rows.")
$general_settings_info =\DB::table('general_settings')->first();
 $_direct_inc_exp_heads_string = $general_settings_info->_direct_inc_exp_heads ?? '';
 $_indirect_inc_exp_heads = $general_settings_info->_indirect_inc_exp_heads ?? '';

      $income_query = " SELECT t5._account_group,t5._group_name, t5._account_ledger,t5._l_name,t5._branch_id,t5._cost_center, t5._branch_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount FROM (

      SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_head IN (".$_direct_inc_exp_heads_string.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id

               WHERE  t1._status=1 AND t1._account_head IN ( ".$_direct_inc_exp_heads_string." )  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
                 ) as t5 GROUP BY t5._account_ledger ";
 //return $income_query;
      $income_8_result = DB::select($income_query);
      $income_8 = array();
      foreach ($income_8_result as $value) {
        $income_8[$value->_group_name][]=$value;
      }

        //return $income_8;

      $other_income_expense_query = " SELECT t5._account_group,t5._group_name, t5._account_ledger,t5._l_name,t5._branch_id,t5._cost_center, t5._branch_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount FROM (

      SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._cr_amount-t1._dr_amount)  AS _previous_balance, 0  AS _current_balance
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date < '".$_datex."' AND t3._show=1 AND t1._account_head IN (".$_indirect_inc_exp_heads.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
            UNION ALL
            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 AND t1._account_head IN (".$_indirect_inc_exp_heads.") AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger
                 ) as t5 GROUP BY t5._account_ledger ";
            $other_income_expense_result = DB::select($other_income_expense_query);
            $other_income_expenses = array();
            foreach ($other_income_expense_result as $value) {
              $other_income_expenses[$value->_group_name][]=$value;
            }
    //return $other_income_expense_query;
      
        return view('backend.account-report.income-statement-report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','income_8','other_income_expenses'));
    }



    public function balanceSheet(Request $request){
        $previous_filter= Session::get('balanceSheetFilter');
        $page_name = "Balance Sheet";
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        
       

         
        return view('backend.account-report.balance-sheet',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));
    }


//     public function balanceSheetReport(Request $request){
//          $this->validate($request, [
//             '_datex' => 'required',
//             '_datey' => 'required'
//         ]);
//          session()->put('balanceSheetFilter', $request->all());
//         $previous_filter= Session::get('balanceSheetFilter');
//         $page_name = "Balance Sheet";
//         $users = Auth::user();
        

//       $_datex =  change_date_format($request->_datex);
//       $_datey=  change_date_format($request->_datey);
//       $_with_zero_qty = $request->_with_zero ?? 0;


//       // Start of Organization ,Branch,Cost Center IDS

//     $permited_organizations = permited_organization(explode(',',$users->organization_ids));
//     $permited_branch = permited_branch(explode(',',$users->branch_ids));
//     $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

//     if($request->organization_id=='all'){
//         $request_organizations = explode(',',$users->organization_ids);
//     }else{
//         $request_organizations = explode(',',$request->organization_id);
//     }

//     if($request->_branch_id=='all'){
//          $_branch_ids = explode(',',$users->branch_ids);
//     }else{
//         $_branch_ids = explode(',',$request->_branch_id);
//     }

   

//     if($request->_cost_center=='all'){
//         $_cost_center_ids = explode(',',$users->cost_center_ids);
//     }else{
//         $_cost_center_ids = explode(',',$request->_cost_center);
//     }

//     $_organization_id_rows = implode(',', $request_organizations);
//      $_branch_ids_rows = implode(',', $_branch_ids);
//     $_cost_center_id_rows = implode(',', $_cost_center_ids);

//     //End of Organization ,Branch,Cost Center IDS


//       $balance_sheet = "
//       SELECT s1._head_id, s1._main_head,s1._head_name, s1._account_group,s1._group_name, s1._account_ledger,s1._l_name,s1._branch_id,s1._cost_center, s1._branch_name,  SUM(s1._opening_amount)  AS _opening_amount,sum(s1._amount) as _amount ,sum(s1._opening_amount+s1._amount) AS _balance
//       FROM (
//  SELECT t5.id as _head_id, t5._name as _main_head,t6._name as _head_name, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount-t1._cr_amount)  AS _opening_amount,0 as _amount
//             FROM accounts as t1
//             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
//             INNER JOIN account_groups as t2 ON t2.id=t3._account_group_id
//             INNER JOIN account_heads as t6 ON t6.id=t3._account_head_id
//             INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
//             INNER JOIN branches as t4 ON t4.id = t1._branch_id
//                WHERE  t1._status=1 AND  t1._date < '".$_datex."'   AND t5.id IN (1,2,5)
//               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
//                  GROUP BY t1._account_ledger

//           UNION ALL
//           SELECT t5.id as _head_id, 'Capital' as _main_head, 'Owner\'s equity' as _head_name, 'Owner\'s Equity' AS _account_group,'Owner\'s Equity' as _group_name, null  AS _account_ledger,'Income Statement Account' as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount-t1._cr_amount)  AS _opening_amount,0 as _amount
//             FROM accounts as t1
//             INNER JOIN account_groups as t2 ON t2.id=t1._account_group
//             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
//             INNER JOIN account_heads as t6 ON t6.id=t1._account_head
//             INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
//             INNER JOIN branches as t4 ON t4.id = t1._branch_id
//                WHERE  t1._status=1 AND  t1._date < '".$_datex."'   AND t5.id IN (3,4)
//              AND t1.organization_id IN(".$_organization_id_rows.")  AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
// UNION ALL

//          SELECT t5.id as _head_id, t5._name as _main_head,t6._name as _head_name, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name, 0 AS _opening_amount, SUM(t1._dr_amount-t1._cr_amount)  AS _amount
//             FROM accounts as t1
//             INNER JOIN account_groups as t2 ON t2.id=t1._account_group
//             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
//             INNER JOIN account_heads as t6 ON t6.id=t1._account_head
//             INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
//             INNER JOIN branches as t4 ON t4.id = t1._branch_id
//                WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' AND t5.id IN (1,2,5)
//               AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
//                  GROUP BY t1._account_ledger

//           UNION ALL
//           SELECT t5.id as _head_id, 'Capital' as _main_head, 'Owner\'s equity' as _head_name, 'Owner\'s Equity' AS _account_group,'Owner\'s Equity' as _group_name, null  AS _account_ledger,'Income Statement Account' as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,0 AS _opening_amount,  SUM(t1._dr_amount-t1._cr_amount)  AS _amount
//             FROM accounts as t1
//             INNER JOIN account_groups as t2 ON t2.id=t1._account_group
//             INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
//             INNER JOIN account_heads as t6 ON t6.id=t1._account_head
//             INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
//             INNER JOIN branches as t4 ON t4.id = t1._branch_id
//                WHERE  t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t5.id IN (3,4)
//              AND t1.organization_id IN(".$_organization_id_rows.")  AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 
// ) AS s1 GROUP BY s1._account_ledger ORDER BY s1._head_id ASC
// ";

//       $balance_sheet_result = DB::select($balance_sheet);
//       $balance_sheet_filter = array();
//       foreach ($balance_sheet_result as $value) {
//         $balance_sheet_filter[$value->_main_head][$value->_head_name][$value->_group_name][]=$value;
//       }

//    // return  $balance_sheet_filter;

//      if($request->_level =='Level 1'){
      
//        return view('backend.account-report.balance_sheet_level_1',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));

//      }else{
//        return view('backend.account-report.balance-sheet-report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));
//      }

       
//     }

       public function balanceSheetReport(Request $request){
         $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required'
        ]);
         session()->put('balanceSheetFilter', $request->all());
        $previous_filter= Session::get('balanceSheetFilter');
        $page_name = "Balance Sheet";
        $users = Auth::user();
        // $permited_branch = permited_branch(explode(',',$users->branch_ids));
        // $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
$_with_zero_qty = $request->_with_zero ?? 0;
      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $request_branchs = $request->_branch_id ?? [];
      $request_cost_centers = $request->_cost_center ?? [];
      $request_organizations = $request->organization_id ?? [];

      // $_branch_ids = filterableBranch($request_branchs,$permited_branch);
      // $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

      // $_branch_ids_rows = implode(',', $_branch_ids);
      // $_cost_center_id_rows = implode(',', $_cost_center_ids);
      // 

      //   $permited_organizations = permited_organization(explode(',',$users->organization_ids));
      //   $_organization_ids = filterableOrganization($request_organizations,$permited_organizations);
      //   $_organization_id_rows = implode(',', $_organization_ids);
        //AND t1.organization_id IN(".$_organization_id_rows.")

       //Start of Report Edition

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
        // $ledger_id_rows = implode(',', $ledger_ids);

 //End of Report Edition

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
      
       return view('backend.account-report.balance_sheet_level_1_update',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));

     }else{
       return view('backend.account-report.balance-sheet-report_update',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));
     }

 }


public function check_voucher_diff_amount(Request $request){

    $account_diff=" SELECT _voucher_code,_date,
    CONCAT(`_ref_master_id`, '_', `_table_name`) AS `reference_table`, 
    SUM(_dr_amount) AS total_dr_amount, 
    SUM(_cr_amount) AS total_cr_amount
FROM 
    `accounts`
WHERE 
    `_status` = 1
GROUP BY 
    CONCAT(`_ref_master_id`, '_', `_table_name`)
HAVING 
    SUM(_dr_amount) != SUM(_cr_amount) ";

 $vouchers = \DB::select($account_diff);
$page_name =" Voucher Issue Find";

return view('backend.account-report.check_voucher_diff_amount',compact('vouchers','page_name'));

}

   public function general_balanceSheet(Request $request){
        $previous_filter= Session::get('general_balanceSheetReport');
        $page_name = "General_balanceSheetReport";
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        
       

         
        return view('backend.account-report.general_balance-sheet',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));
    }



    public function general_balanceSheetReport(Request $request){
        $this->validate($request, [
            '_datex' => 'required'
        ]);
         session()->put('general_balanceSheetReport', $request->all());
        $previous_filter= Session::get('general_balanceSheetReport');
        $page_name = "Balance Sheet";
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

      $_datex =  change_date_format($request->_datex);
      $_datey=  change_date_format($request->_datey);
      $request_branchs = $request->_branch_id ?? [];
      $request_cost_centers = $request->_cost_center ?? [];

    //  $_branch_ids = filterableBranch($request_branchs,$permited_branch);
    //  $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);

     // $organization_ids = implode(',', $users->organization_ids);
      $_branch_ids_rows =  $users->branch_ids;
      $_cost_center_id_rows = $users->cost_center_ids;
      $_with_zero_qty = $request->_with_zero ?? 0;


      $balance_sheet = "   SELECT t5._name as _main_head,t6._name as _head_name, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount-t1._cr_amount)  AS _amount
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_heads as t6 ON t6.id=t1._account_head
            INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date <= '".$_datex."'  AND t5.id IN (1,2,5)
               AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger

          UNION ALL
          SELECT 'Capital' as _main_head, 'Owner\'s equity' as _head_name, 'Owner\'s Equity' AS _account_group,'Owner\'s Equity' as _group_name, null  AS _account_ledger,'Income Statement Account' as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount-t1._cr_amount)  AS _amount
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_heads as t6 ON t6.id=t1._account_head
            INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date <= '".$_datex."' AND t3._show=1 AND t5.id IN (3,4)
               AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") ";

      $balance_sheet_result = DB::select($balance_sheet);
      $balance_sheet_filter = array();
      foreach ($balance_sheet_result as $value) {
        $balance_sheet_filter[$value->_main_head][$value->_head_name][$value->_group_name][]=$value;
      }

     if($request->_level =='Level 1'){
      
       return view('backend.account-report.general_balance_sheet_level_1',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));

     }else{
       return view('backend.account-report.general_balance-sheet-report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','balance_sheet_filter','_with_zero_qty'));
     }

       
    }

      public function general_balanceSheetFilterReset(Request $request){
      Session::flash('general_balanceSheetReport');

        return redirect()->back();
    }


    public function workSheet(Request $request){
        $previous_filter= Session::get('workSheetFilter');
        $page_name = "Work Sheet";
        
        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        
       

         
        return view('backend.account-report.work-sheet',compact('request','page_name','previous_filter','permited_branch','permited_costcenters'));

    }

    public function workSheetReport(Request $request){

      $this->validate($request, [
            '_datex' => 'required'
        ]);
         session()->put('balanceSheetFilter', $request->all());
        $previous_filter= Session::get('balanceSheetFilter');
        $page_name = "Work Sheet";
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

    //End of Organization ,Branch,Cost Center IDS


      $balance_sheet = "   SELECT t5.id as _main_head,t6._name as _head_name, t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount-t1._cr_amount)  AS _amount
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_heads as t6 ON t6.id=t1._account_head
            INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date < '".$_datex."'  AND t1.organization_id IN(".$_organization_id_rows.")
               AND  t1._branch_id IN (".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.")
                 GROUP BY t1._account_ledger

          UNION ALL
          SELECT 6 as _main_head, 4 as _head_name, 'Owner\'s Equity' AS _account_group,'Owner\'s Equity' as _group_name, null  AS _account_ledger,'Income Statement Account' as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  SUM(t1._dr_amount-t1._cr_amount)  AS _amount
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN account_heads as t6 ON t6.id=t1._account_head
            INNER JOIN main_account_head as t5 ON t5.id=t6._account_id
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
               WHERE  t1._status=1 AND t1._date <= '".$_datex."'  AND t3._show=1 AND t5.id IN (3,4)
             AND t1.organization_id IN(".$_organization_id_rows.")  AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 


                   ";
       $work_sheet_result = DB::select($balance_sheet);
      

      

        return view('backend.account-report.work-sheet-report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','work_sheet_result'));
      
    }

    public function workSheetFilterReset(Request $request){
      Session::flash('workSheetFilter');

        return redirect()->back();
    }






    public function incomeStatementFilterReset(){
        Session::flash('incomeStatementFillter');

        return redirect()->back();
    }

    public function balanceSheetFilterReset(){
        Session::flash('balanceSheetFilter');

        return redirect()->back();
    }




    public function incomeStatementSettings(Request $request){

        AccountLedger::where('_show',1)->update(['_show'=>0]);

      $_ledger_ids = $request->_l_id ?? [];
      $_shows = $request->_show ?? [];
        foreach ($_ledger_ids as  $key=>$value) {
          $AccountLedger = AccountLedger::find($value);
          $AccountLedger->_show = $_shows[$key];
          $AccountLedger->save();

          
        }

        return redirect()->back();

    }





 public function incomeExpenseReport()
    {
        
        $page_name = __('label.income_expense_summary');
        return view('reports.income-expense', compact('page_name'));
    }

    public function getIncomeExpenseData(Request $request)
    {
        

       
         session()->put('incomeStatementFillter', $request->all());
        $previous_filter= Session::get('incomeStatementFillter');
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

    //End of Organization ,Branch,Cost Center IDS


        //AND t1.organization_id IN(".$_organization_id_rows.")
$general_settings_info =\DB::table('general_settings')->first();
 $_direct_inc_exp_heads_string = $general_settings_info->_direct_inc_exp_heads ?? '';
 $_indirect_inc_exp_heads = $general_settings_info->_indirect_inc_exp_heads ?? '';

      $income_query = " SELECT t5._account_group,t5._group_name, t5._account_ledger,t5._l_name,t5._branch_id,t5._cost_center, t5._branch_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount, t5._code FROM (

      
            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance,t3._code
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
            INNER JOIN account_heads as s5 on s5.id=t1._account_head

               WHERE  t1._status=1 AND s5._account_id IN(3) and t3._show=1  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  AND t3._show=1 
                 GROUP BY t1._account_ledger
                 ) as t5 GROUP BY t5._account_ledger ";
 //return $income_query;
      $income_8_result = DB::select($income_query);
      $income_8 = array();
      foreach ($income_8_result as $value) {
        $income_8[$value->_group_name][]=$value;
      }

        //return $income_8;

      $other_income_expense_query = " SELECT t5._account_group,t5._group_name, t5._account_ledger,t5._l_name,t5._branch_id,t5._cost_center, t5._branch_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount FROM (

            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance,t3._code
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
            INNER JOIN account_heads as s5 on s5.id=t1._account_head
               WHERE  t1._status=1  AND s5._account_id IN(4) and t3._show=1  AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
                 GROUP BY t1._account_ledger
                 ) as t5 GROUP BY t5._account_ledger ";
            $other_income_expense_result = DB::select($other_income_expense_query);
            $other_income_expenses = array();
            foreach ($other_income_expense_result as $value) {
              $other_income_expenses[$value->_group_name][]=$value;
            }
    //return $other_income_expense_query;

          //  return $income_8;
      
        // return view('reports.income-statement-report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','income_8','other_income_expenses'));

        return view('reports.income_report_2',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','income_8','other_income_expenses'));


    }





 public function collection_expense_report()
    {
        
        $page_name = __('label.collection_expense_report');
        return view('reports.collection_expense_report', compact('page_name'));
    }

    public function collection_expenseData(Request $request)
    {
        

       
         session()->put('collection_expense_report', $request->all());
        $previous_filter= Session::get('collection_expense_report');
          $page_name = __('label.collection_expense_report');
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

    //End of Organization ,Branch,Cost Center IDS


      $income_query = " SELECT t5._group_name, t5._account_ledger,t5._l_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount, t5._code FROM (
            SELECT t1._bill_type as _group_name, t1._collection_ledger_id AS _account_ledger,t3._name as _l_name, 0 AS _previous_balance, SUM(t1._collection_amount)   AS _current_balance,t3._code
            FROM stm_collection_master_details as t1
            INNER JOIN account_ledgers as t3 ON t3.id=t1._collection_ledger_id
               WHERE  t1._status=1 AND t1._is_effect=1 and t3._show=1  AND  t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  
                 GROUP BY t1._bill_type,t1._collection_ledger_id
                 ) as t5 GROUP BY t5._group_name, t5._account_ledger ";
 //return $income_query;
      $income_8_result = DB::select($income_query);
      $income_8 = array();
      foreach ($income_8_result as $value) {
        $income_8[$value->_group_name][]=$value;
      }

       // return $income_8;

      $other_income_expense_query = " SELECT t5._account_group,t5._group_name, t5._account_ledger,t5._l_name,t5._branch_id,t5._cost_center, t5._branch_name,  SUM(t5._previous_balance)  AS _previous_balance, SUM(t5._current_balance)  AS _current_balance, SUM(t5._previous_balance+t5._current_balance) as _last_amount FROM (

            SELECT t1._account_group AS _account_group,t2._name as _group_name, t1._account_ledger AS _account_ledger,t3._name as _l_name,t1._branch_id AS _branch_id,t1._cost_center as _cost_center, t4._name as _branch_name,  0 AS _previous_balance, SUM(t1._cr_amount-t1._dr_amount)   AS _current_balance,t3._code
            FROM accounts as t1
            INNER JOIN account_groups as t2 ON t2.id=t1._account_group
            INNER JOIN account_ledgers as t3 ON t3.id=t1._account_ledger
            INNER JOIN branches as t4 ON t4.id = t1._branch_id
            INNER JOIN account_heads as s5 on s5.id=t1._account_head
               WHERE  t1._status=1  AND s5._account_id IN(4) and t3._show=1  AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'
                 GROUP BY t1._account_ledger
                 ) as t5 GROUP BY t5._account_ledger ";
            $other_income_expense_result = DB::select($other_income_expense_query);
            $other_income_expenses = array();
            foreach ($other_income_expense_result as $value) {
              $other_income_expenses[$value->_group_name][]=$value;
            }
    //return $other_income_expense_query;

          //  return $income_8;
      
        // return view('reports.income-statement-report',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','income_8','other_income_expenses'));

        return view('reports.collection_expense_data',compact('request','page_name','previous_filter','permited_branch','permited_costcenters','income_8','other_income_expenses'));


    }








}