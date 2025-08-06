<?php

namespace App\Http\Controllers\AV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;






class AvReportController extends Controller
{

    function __construct()
    {
         
         $this->middleware('permission:transection_terms_wise_sales', ['only' => ['transection_terms_wise_sales']]);

    }

    //

    public function transection_terms_wise_sales(Request $request){

        $users = \Auth::user();
        $user_type = $users->user_type ?? 'user';

        $page_name          = __('label.transection_terms_wise_sales');
        $transection_terms  = DB::table('transection_terms')->where('_status',1)->orderBy('_days','ASC')->get();
        $group_by_array     =[1=>'Sales Invoice',2=>'Month',3=>'Month and Teritory']; 
        //Group By Sales Invoice,Month and (Month and Teritory)
        $datas              = [];
         session()->put('transection_terms_wise_sales', $request->all());
        $previous_filter= Session::get('transection_terms_wise_sales');


           $employee_grops = DB::table('account_group_configs')->select('_employee_group')->first();
        $string = $employee_grops->_employee_group ?? '';
        $employee_grops_array = explode(",", $string);
        //return $user_type;
         $sales_persons = DB::table('account_ledgers as t1')
                        ->select('t1.id','t1._name','t1._code','t1._phone','t1._address','t1._email','t1._branch_id','branches._name as b_name')
                        ->join('branches','branches.id','t1._branch_id')
                        ->whereIn('t1._branch_id',explode(',',$users->branch_ids))
                        ->whereIn('t1._account_group_id',$employee_grops_array);
            if($user_type !='admin'){
                $sales_persons = $sales_persons->where('t1.id',$users->ref_id);
            }

     $sales_persons = $sales_persons->where('t1._status',1)->get();

        return view('av.reports.transection_terms_wise_sales',compact('page_name','request','datas','transection_terms','group_by_array','previous_filter','sales_persons'));
        
    }


    public function transection_terms_wise_sales_report(Request $request){
            // return $request->all();
            $users          = \Auth::user();
            $user_type      = $users->user_type ?? 'user';
            $_datex         = change_date_format($request->_datex ?? '');
            $_datey         = change_date_format($request->_datey ?? '');
            $_ledger_id     = $request->_ledger_id ?? '';
            $_sales_man_id  = $request->_sales_man_id ?? '';
            $_payment_terms = $request->_payment_terms ?? '';
            $group_by       = $request->group_by ?? 1;
            $page_name = __('label.transection_terms_wise_sales');
            session()->put('transection_terms_filter', $request->all());
            $previous_filter= Session::get('transection_terms_filter');

    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

            if($request->organization_id=='all'){
            $request_organizations          = explode(',',$users->organization_ids);
            }else{
                $request_organizations      = explode(',',$request->organization_id);
            }

            if($request->_branch_id=='all'){
                $_branch_ids        = explode(',',$users->branch_ids);
            }else{
                $_branch_ids        = explode(',',$request->_branch_id);
            }

            if($request->_cost_center=='all'){
                $_cost_center_ids       = explode(',',$users->cost_center_ids);
            }else{
                $_cost_center_ids       = explode(',',$request->_cost_center);
            }

            $_organization_id_rows      = implode(',', $request_organizations);
            $_cost_center_id_rows       = implode(',', $_cost_center_ids);
            $_branch_ids_rows           = implode(',', $_branch_ids);

            $sales_form_settings            = DB::table("sales_form_settings")->first();
            $sales_return_form_settings     = DB::table("sales_return_form_settings")->first();

            $sales_plus_ledgers             = [];
            $sales_minus_ledgers            = [];
            
            $sales_ledger_id                =  $sales_form_settings->_default_sales ?? 0;
            $_sales_discount_ledger_id      =  $sales_form_settings->_default_discount ?? 0;
            
            $sales_return_ledger_id             =  $sales_return_form_settings->_default_sales ?? 0;
            $sales_return_discount_ledger_id    =  $sales_return_form_settings->_default_discount  ?? 0;

//organization_id
//_cost_center_id
//_branch_id
//_payment_terms
//_sales_man_id
//_ledger_id
           if($group_by ==1){
           


            $query_string = " SELECT 'sales' as _type,t3._name,t3._code,t1.id,t1._order_number,t1._date,t1._ledger_id,t1._phone,t1._address,t1._sub_total,
                    t1._discount_input,t1._total_discount,t1._total_vat,t1._total,t1._note
                    FROM `sales` AS t1
                    INNER JOIN account_ledgers AS t3 ON t3.id=t1._ledger_id
                     WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
            if($request->organization_id !=''){
                $query_string .=" AND  t1.organization_id IN(".$_organization_id_rows.")  ";
            }
            if($request->_cost_center_id !=''){
                $query_string .=" AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
            }
            if($request->_branch_id !=''){
                $query_string .=" AND  t1._branch_id IN(".$_branch_ids_rows.")  ";
            }
            if($request->_payment_terms !=''){
                $query_string .=" AND  t1._payment_terms IN(".$_payment_terms.")  ";
            }

            if($request->_sales_man_id !=''){
                $query_string .=" AND  t1._sales_man_id IN(".$_sales_man_id.")  ";
            }
            if($request->_ledger_id !=''){
                $query_string .=" AND  t1._ledger_id IN(".$_ledger_id.")  ";
            }

            $query_string .=" UNION ALL
                    SELECT 'sales_without_lots' as _type,t3._name ,t3._code ,t1.id,t1._order_number,t1._date,t1._ledger_id,t1._phone,t1._address,t1._sub_total,
                    t1._discount_input,t1._total_discount,t1._total_vat,t1._total,t1._note
                    FROM `sales_without_lots` AS t1
                    INNER JOIN account_ledgers AS t3 ON t3.id=t1._ledger_id
                    WHERE 1=1 AND t1._date  >= '".$_datex."'  AND t1._date <= '".$_datey."' ";
               if($request->organization_id !=''){
                $query_string .=" AND  t1.organization_id IN(".$_organization_id_rows.")  ";
            }
            if($request->_cost_center_id !=''){
                $query_string .=" AND  t1._cost_center_id IN(".$_cost_center_id_rows.")  ";
            }
            if($request->_branch_id !=''){
                $query_string .=" AND  t1._branch_id IN(".$_branch_ids_rows.")  ";
            }
            if($request->_payment_terms !=''){
                $query_string .=" AND  t1._payment_terms IN(".$_payment_terms.")  ";
            }

            if($request->_sales_man_id !=''){
                $query_string .=" AND  t1._sales_man_id IN(".$_sales_man_id.")  ";
            }
            if($request->_ledger_id !=''){
                $query_string .=" AND  t1._ledger_id IN(".$_ledger_id.")  ";
            }

             $datas = DB::select($query_string);





            return view('av.reports.sales_report.group_1',compact('page_name','datas','previous_filter','permited_organizations','permited_branch','permited_costcenters','request'));
           }





    }
}
