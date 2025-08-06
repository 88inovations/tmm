<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class SalesOfficerReportController extends Controller
{
    function __construct()
    {
         
         $this->middleware('permission:date_to_date_sales_amount_report', ['only' => ['date_to_date_sales_amount_report']]);

    }



    /*
    @ Name      : date_to_date_sales_amount_report
    @param      : date,organization_id,branch_id,cost_center_id,officer_id
    @Return     : Date to Date wise Sales Amount Details
    @date       : 09-02-2025
    @Author     : Md Farhad Ali
    @Mobile     : 01756-256562
    */

    public function date_to_date_sales_amount_report(Request $request){

        $page_name = __('label.date_to_date_sales_amount_report');
        session()->put('date_to_date_sales_amount_report_filter', $request->all());
        $previous_filter= Session::get('date_to_date_sales_amount_report_filter');
        $datas = [];
        $users                      = Auth::user();
        $user_type                  = $users->user_type ?? 'user';
        $ref_id                     = $users->ref_id ?? 0;
        $_datex                     =  change_date_format($request->_datex);
        $_datey                     =  change_date_format($request->_datey);
        $permited_organizations     =  permited_organization(explode(',',$users->organization_ids));
        $permited_branch            =  permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters       =  permited_costcenters(explode(',',$users->cost_center_ids));


            $datas     = [];

            if($request->organization_id=='all'){
                $request_organizations = explode(',',$users->organization_ids);
            }else{
                $request_organizations = explode(',',$request->organization_id);
            }

            if(!$request->has('_branch_id') || $request->_branch_id=='all'){
                 $_branch_ids = explode(',',$users->branch_ids);
            }else{
                $_branch_ids = explode(',',$request->_branch_id);
            }

           

            if($request->_cost_center=='all'){
                $_cost_center_ids = explode(',',$users->cost_center_ids);
            }else{
                $_cost_center_ids = explode(',',$request->_cost_center);
            }

            $account_group_configs        = \DB::table("account_group_configs")->first();
            $_employee_group              = $account_group_configs->_employee_group ?? '';
            $_customer_group              = $account_group_configs->_customer_group ?? '';

            $_customer_group_array        = explode(',', $_customer_group);
            $_employee_group_array        = explode(',', $_employee_group);
            $_organization_id_rows       = implode(',', $request_organizations);
            $_branch_ids_rows            = implode(',', $_branch_ids);
            $_cost_center_id_rows         = implode(',', $_cost_center_ids);

            $sales_officers = [];

            if($user_type =='admin'){
               // return $_branch_ids;
                $sales_officers  = \DB::table('account_ledgers')
                                            ->whereIn('_account_group_id',$_employee_group_array)
                                            ->whereIn('_branch_id',$_branch_ids)
                                            ->where('_status',1)
                                            ->get();
            }else{
                $sales_officers  = \DB::table('account_ledgers')
                                            ->where('id',$ref_id)
                                            ->where('_status',1)
                                            ->get();
            }

            $officer_id          = $request->sales_officer_id ?? '';
            $report_type         = $request->report_type ?? '';
           // return $request->all();

            if($report_type =='invoice_wise_sales'){
                $invoice_wise_saels_query =" SELECT 'Sales' as _type,'' as _order_ref_id,t1.id, t1._order_number,t1._date,t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,t1._payment_terms,t1._total as _sales_amount,0 as return_amount
                        FROM sales as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND  t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
                        UNION ALL
                        SELECT 'Sales Return' as _type,t1._order_ref_id,t1.id, t1._order_number,t1._date,t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,0 as _payment_terms,0 as _sales_amount,t1._total as return_amount
                        FROM sales_returns as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  ";
                    $datas = DB::select($invoice_wise_saels_query);
                    $page_name = __('label.invoice_wise_sales');
                     return view('backend.sales_officer.invoice_wise_sales',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','_datex','_datey','previous_filter'));
            }

            if($report_type =='date_wise_sales'){
                $invoice_wise_saels_query =" SELECT 'Sales' as _type,'' as _order_ref_id,t1.id, t1._order_number,t1._date,t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,t1._payment_terms,SUM(t1._total) as _sales_amount,0 as return_amount
                        FROM sales as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND  t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  GROUP BY t1._date 
                        UNION ALL
                        SELECT 'Sales Return' as _type,t1._order_ref_id,t1.id, t1._order_number,t1._date,t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,0 as _payment_terms,0 as _sales_amount,SUM(t1._total) as return_amount
                        FROM sales_returns as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' GROUP BY t1._date  ";
                    $datas = DB::select($invoice_wise_saels_query);
                    $page_name = __('label.date_wise_sales');

                     return view('backend.sales_officer.invoice_wise_sales',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','_datex','_datey','previous_filter'));
            }

            if($report_type =='sales_and_return_summary'){
                $invoice_wise_saels_query =" SELECT 'Sales' as _type,t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,t1._payment_terms,SUM(t1._total) as _sales_amount,0 as return_amount
                        FROM sales as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND  t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  GROUP BY t1._ledger_id 
                        UNION ALL
                        SELECT 'Sales Return' as _type,t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,0 as _payment_terms,0 as _sales_amount,SUM(t1._total) as return_amount
                        FROM sales_returns as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' GROUP BY t1._ledger_id  ";
                    $datas = DB::select($invoice_wise_saels_query);
                    $page_name = __('label.sales_and_return_summary');

                     return view('backend.sales_officer.sales_and_return_summary',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','_datex','_datey','previous_filter'));
            }

            if($report_type =='customer_due_summary'){

               $customer_ledger_ids  = \DB::table('account_ledgers')
                                            ->whereIn('_account_group_id',$_customer_group_array)
                                            ->whereIn('_branch_id',$_branch_ids)
                                          //  ->where('_status',1)
                                            ->pluck('id')->toArray();
                $_customer_ledger_ids_row   = implode(',', $customer_ledger_ids);

                $invoice_wise_saels_query =" SELECT t2.id,t2._name,t2._phone,t2._code,t2._address,SUM(t1._dr_amount-t1._cr_amount) as _balance
                        FROM `accounts` AS t1
                        INNER JOIN account_ledgers as t2 ON t1._account_ledger=t2.id
                        WHERE t1._status=1 AND t2.id IN(".$_customer_ledger_ids_row.") 
                        GROUP BY t1._account_ledger 
                        HAVING SUM(t1._dr_amount-t1._cr_amount) !=0
                        ORDER BY t2._name ASC
                          ";
                    $datas = DB::select($invoice_wise_saels_query);
                    $page_name = __('label.customer_due_summary');

                     return view('backend.sales_officer.customer_due_summary',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','_datex','_datey','previous_filter'));
            }

    if($report_type =='date_wise_sales_and_collection'){

                $customer_ledger_ids  = \DB::table('account_ledgers')
                                            ->whereIn('_account_group_id',$_customer_group_array)
                                            ->whereIn('_branch_id',$_branch_ids)
                                          //  ->where('_status',1)
                                            ->pluck('id')->toArray();
                $_customer_ledger_ids_row   = implode(',', $customer_ledger_ids);


                 $invoice_wise_saels_query =" 
        SELECT s1._phone,s1._address,s1._ledger_id,s1._code,s1._name,SUM(s1._total) as _total  FROM(
                 SELECT t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,t1._total as _total
                        FROM sales as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND  t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND  t1._ledger_id IN(".$_customer_ledger_ids_row.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."'  
                        UNION ALL
                        SELECT t1._phone,t1._address,t1._ledger_id,t2._code,t2._name,-t1._total as _total
                        FROM sales_returns as t1 
                        INNER JOIN account_ledgers as t2 ON t2.id=t1._ledger_id
                        WHERE 1=1 AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") AND  t1._ledger_id IN(".$_customer_ledger_ids_row.")
                        AND t1._sales_man_id IN($officer_id) AND t1._status=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' 
                        ) as s1 GROUP BY s1._ledger_id ORDER BY s1._name ASC
                         ";
                     $sales_and_returns = DB::select($invoice_wise_saels_query);





$_cash_group                  = $account_group_configs->_cash_group ?? '';
$_bank_group                  = $account_group_configs->_bank_group ?? '';

$cash_bank_group_array        = [];
$cash_bank_group_1            = explode(",", $_cash_group);
$cash_bank_group_2            = explode(",", $_bank_group);

 $cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);
 $cash_and_bank_ledgers = \DB::table("account_ledgers")
                            ->whereIn('_account_group_id',$cash_bank_group_array)
                            ->pluck('id')->toArray();

//Customer Wise Voucher code find
$customer_all_vouchers = \DB::table("accounts")
                ->whereIn('accounts.organization_id',$request_organizations)
                ->whereIn('accounts._branch_id',$_branch_ids)
                ->whereIn('accounts._cost_center',$_cost_center_ids)
                ->whereIn('accounts._account_ledger',$customer_ledger_ids)
                ->whereBetween('accounts._date', [$_datex, $_datey])
                ->where('accounts._status',1)
                ->distinct() 
                ->pluck('accounts._voucher_code')->toArray();


     $cash_bank_datas = \DB::table("accounts")
                ->whereIn('accounts.organization_id',$request_organizations)
                ->whereIn('accounts._branch_id',$_branch_ids)
                ->whereIn('accounts._cost_center',$_cost_center_ids)
                ->whereIn('accounts._account_ledger',$cash_and_bank_ledgers)
                ->whereIn('accounts._voucher_code',$customer_all_vouchers)
                ->whereBetween('accounts._date', [$_datex, $_datey])
                ->where('accounts._dr_amount','>',0)
                ->where('accounts._status',1)
                ->get();


 $page_name = __('label.date_wise_sales_and_collection');


        return view('backend.sales_officer.date_wise_sales_and_collection',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','_datex','_datey','previous_filter','sales_and_returns','cash_bank_datas'));
}



    if($report_type =='customer_collection_detail'){

                $customer_ledger_ids  = \DB::table('account_ledgers')
                                            ->whereIn('_account_group_id',$_customer_group_array)
                                            ->whereIn('_branch_id',$_branch_ids)
                                          //  ->where('_status',1)
                                            ->pluck('id')->toArray();
                $_customer_ledger_ids_row   = implode(',', $customer_ledger_ids);







$_cash_group                  = $account_group_configs->_cash_group ?? '';
$_bank_group                  = $account_group_configs->_bank_group ?? '';

$cash_bank_group_array        = [];
$cash_bank_group_1            = explode(",", $_cash_group);
$cash_bank_group_2            = explode(",", $_bank_group);

 $cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);
 $cash_and_bank_ledgers = \DB::table("account_ledgers")
                            ->whereIn('_account_group_id',$cash_bank_group_array)
                            ->pluck('id')->toArray();

//Customer Wise Voucher code find
$customer_all_vouchers = \DB::table("accounts")
                ->whereIn('accounts.organization_id',$request_organizations)
                ->whereIn('accounts._branch_id',$_branch_ids)
                ->whereIn('accounts._cost_center',$_cost_center_ids)
                ->whereIn('accounts._account_ledger',$customer_ledger_ids)
                ->whereBetween('accounts._date', [$_datex, $_datey])
                ->where('accounts._status',1)
                ->distinct() 
                ->pluck('accounts._voucher_code')->toArray();


     $cash_bank_datas = \DB::table("accounts")
                ->whereIn('accounts.organization_id',$request_organizations)
                ->whereIn('accounts._branch_id',$_branch_ids)
                ->whereIn('accounts._cost_center',$_cost_center_ids)
                ->whereIn('accounts._account_ledger',$cash_and_bank_ledgers)
                ->whereIn('accounts._voucher_code',$customer_all_vouchers)
                ->whereBetween('accounts._date', [$_datex, $_datey])
                ->where('accounts._dr_amount','>',0)
                ->where('accounts._status',1)
                ->get();


 $page_name = __('label.customer_collection_detail');


        return view('backend.sales_officer.customer_collection_detail',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','_datex','_datey','previous_filter','cash_bank_datas'));
}



          //return $request->all();



        return view('backend.sales_officer.date_to_date_sales_amount_report',compact('page_name','datas','request','permited_organizations','permited_branch','permited_costcenters','sales_officers','previous_filter'));
    }
}
