@extends('backend.layouts.app')
@section('title',$page_name)

@section('style')
<style type="text/css">
  ._list_table td, th {
   
    white-space: normal !important;
}
</style>
@endsection

@section('content')


<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          <div class="card">
             
            <div class="card-body filter_body" style="">
               <form  action="{{url('customer_statement')}}" method="GET">
                @csrf
              
                      @include('basic.report_date_filter')
                     @include('basic.org_report')

                     @php
$_account_ledger_id_ = $request->_ledger_id ?? '';
                     @endphp
                   
                    <div class="row">
                       <label>Ledger:</label>
                        <select class="form-control select2" name="_ledger_id">
                         <option value=""><---All---></option>
                          @forelse($reportable_ledgers as $r_ledger)
                          <option value="{{$r_ledger->_account_ledger}}" @if($_account_ledger_id_==$r_ledger->_account_ledger) selected @endif>{!! $r_ledger->_code ?? '' !!} {!! $r_ledger->_name ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                    
                    
                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                               
                                <a href="{{url('customer_statement')}}"   class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
                        </div>
                        <br><br>
                     </div>

                 
                 

                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>

<!-- Report Section Start  -->


@if($request->has('_datex') && $request->has('_datey'))

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                   {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
             
            <th style="width: 5%;">{{__('label.sl')}}</th>
            <th style="width: 5%;">{{__('label.sl')}}</th>
            <th style="width: 5%;">{{__('label._customer_id')}}</th>
            <th style="width: 10%;">Date</th>
            <th style="width: 10%;">ID</th>
            <th style="width: 10%;">Note</th>
            <th style="width: 10%;">Sales</th>
            <th style="width: 10%;">Sales Return</th>
            <th style="width: 10%;">Discount</th>
            <th style="width: 10%;">Net Sales</th>
            <th style="width: 10%;">Incentive</th>
            <th style="width: 10%;">Commision</th>
            <th style="width: 10%;">Bad Debt Exp.</th>
            <th style="width: 10%;">Collection</th>
            <th style="width: 10%;">Balance</th>
            
          </tr>
          
          
          </thead>
          <tbody>

<?php
$reportabl_branches = \DB::select(" SELECT id,_name,_address,_code FROM branches where _status=1 AND id IN(".$_branch_ids_rows.") ORDER BY id asc, _name ASC  ");
$grand_total_balance = 0;
$grand_total_sales=0;
$grand_total_sales_return=0;
$grand_total_discount=0;
$grand_total_incentive=0;
$grand_total_commission=0;
$grand_total_bad_debt=0;
$grand_total_net_sales=0;
$grand_total_collection=0;
?>

@forelse($reportabl_branches as $b_key=>$b_value)

<?php
$customer_group=9;

 $query_1 = " SELECT s1._ledger_id,s1._name,s1._code,s1._branch_id,s2._name as b_name,SUM(s1._balance) as _balance  FROM(

SELECT  t1.id as _ledger_id,t1._name,t1._code,t1._branch_id, 0 AS _balance
FROM `account_ledgers` AS t1
WHERE t1._account_group_id IN($customer_group) AND t1._branch_id IN(".$b_value->id.") ";
if($ledger_id_rows !=''){
 $query_1 .= " AND t1.id IN(".$ledger_id_rows.") ";
}

 $query_1 .= " UNION ALL

SELECT  t2.id as _ledger_id,t2._name,t2._code,t1._branch_id, SUM(t1._dr_amount-t1._cr_amount) AS _balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t2 on t1._account_ledger=t2.id
               WHERE t1._status=1 AND t2._account_group_id=$customer_group AND t1._date < '".$_datex."'    AND t1.organization_id IN(".$_organization_id_rows.") AND  t1._branch_id IN(".$b_value->id.") AND  t1._cost_center IN(".$_cost_center_id_rows.")";
               if($ledger_id_rows !=''){
 $query_1 .= " AND t2.id IN(".$ledger_id_rows.") ";
}
  $query_1 .=  " GROUP BY t1._account_ledger
    ) as s1
    INNER JOIN branches as s2 ON s2.id=s1._branch_id
    GROUP BY s1._ledger_id ORDER BY s1._name ASC ";

$branch_wise_user_and_opening_balances = \DB::select($query_1);
$sl =1;
$branch_wise_balance = 0;

 $branch_wise_total_sales=0;
$branch_wise_total_sales_return=0;
$branch_wise_total_discount=0;
$branch_wise_total_incentive=0;
$branch_wise_total_commission=0;
$branch_wise_total_bad_debt=0;
$branch_wise_total_collection=0;


?>


<tr>
  <th>{!! ($b_key+1) !!}</th>
  <th colspan="15"> {!! $b_value->_name ?? '' !!} {!! $b_value->_address ?? '' !!}</th>
</tr>

@php
 $sub_total_sales=0;
$sub_total_sales_return=0;
$sub_total_discount=0;
$sub_total_incentive=0;
$sub_total_commission=0;
$sub_total_bad_debt=0;
$sub_total_collection=0;
$sub_total_balance=0;


@endphp

@forelse($branch_wise_user_and_opening_balances as $bob_key=>$bob_value)

<?php
 $sub_total_sales=0;
$sub_total_sales_return=0;
$sub_total_discount=0;
$sub_total_incentive=0;
$sub_total_commission=0;
$sub_total_bad_debt=0;
$sub_total_collection=0;
$sub_total_balance=0;


$_balance = $bob_value->_balance ?? 0;
$branch_wise_balance += $bob_value->_balance ?? 0;
$grand_total_balance += $bob_value->_balance ?? 0;
$sub_total_balance += $bob_value->_balance ?? 0;

$_ledger_id = $bob_value->_ledger_id ?? 0; 
$_branch_id = $b_value->id;


//Customer Wise Voucher code find
 $customer_all_vouchers = \DB::table("accounts")
                ->where('_account_ledger',$_ledger_id)
                ->whereIn("accounts.organization_id",$request_organizations)
                ->whereIn("accounts._cost_center",$_cost_center_ids)
                ->where("accounts._branch_id",$_branch_id)
                ->where('accounts._status',1)
                ->pluck('accounts._voucher_code');
// dump($customer_all_vouchers);
// die();


$general_settings             = \DB::table("general_settings")->first();
$account_group_configs        = \DB::table("account_group_configs")->first();
$sales_form_settings          = \DB::table("sales_form_settings")->first();
$sales_return_form_settings   = \DB::table("sales_return_form_settings")->first();
$purchase_form_settings       = \DB::table("purchase_form_settings")->first();

$_cash_group                  = $account_group_configs->_cash_group ?? '';
$_bank_group                  = $account_group_configs->_bank_group ?? '';

$cash_bank_group_array = [];
$cash_bank_group_1 = explode(",", $_cash_group);
$cash_bank_group_2 = explode(",", $_bank_group);

$cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);

$cash_and_bank_ledgers = \DB::table("account_ledgers")->whereIn('_account_group_id',$cash_bank_group_array)->pluck('id')->toArray();

$cash_and_bank_ledgers_string = implode(',',$cash_and_bank_ledgers);



$_sales_discount        =   $sales_form_settings->_default_discount ?? 0;
$_incentice_expneses    = $general_settings->_customer_incentive_ledger ?? 0;
$sales_id               = $sales_form_settings->_default_sales ?? 0;
$sales_return          = $sales_return_form_settings->_default_sales ?? 0;
$sales_commision        = $general_settings->_customer_incentive_ledger ?? 0;
$bad_debt               = $general_settings->_baddebt_ledgers ?? 0;
$_default_purchase      = $purchase_form_settings->_default_purchase ?? 0;


  //  $_sales_discount=7;
  //  $_incentice_expneses=592;
    $sales_returns=[$sales_return,$_default_purchase];
   // $sales_commision=8;
   // $bad_debt=29;

     $collection_ledgers    = [];
     foreach($cash_and_bank_ledgers as $cb_led){
      array_push($collection_ledgers,intval($cb_led));
     }
      array_push($collection_ledgers,intval($sales_id));
      array_push($collection_ledgers,intval($sales_return));
      array_push($collection_ledgers,intval($_sales_discount));
      array_push($collection_ledgers,intval($_incentice_expneses));
      array_push($collection_ledgers,intval($sales_return));
      array_push($collection_ledgers,intval($sales_commision));
      array_push($collection_ledgers,intval($bad_debt));
      array_push($collection_ledgers,intval($_default_purchase));



  $all_data_rows = \DB::table('accounts')
   ->join('account_ledgers','account_ledgers.id','accounts._account_ledger')
   ->leftJoin('voucher_masters','voucher_masters._code','accounts._voucher_code')

    ->select("accounts.id","accounts._account_ledger","accounts._voucher_code","accounts._dr_amount","accounts._cr_amount","accounts._narration as _note","accounts._date","voucher_masters._amount","accounts._short_narration","accounts._branch_id","accounts.organization_id","accounts._cost_center")
   ->whereIn('accounts._voucher_code',$customer_all_vouchers)
   ->whereIn("accounts._account_ledger",$collection_ledgers)
  // ->whereIn("accounts.organization_id",$request_organizations)
  // ->whereIn("accounts._cost_center",$_cost_center_ids)
   //->whereIn("account_ledgers._branch_id",$_branch_ids)
   ->whereBetween('accounts._date', [$_datex, $_datey])
   ->where('accounts._status',1)
   ->orderBy('accounts._date',"ASC")
   ->orderBy('accounts.id',"ASC")
   ->get();

// dump($all_data_rows );
// die();


?>


@if(sizeof($all_data_rows) > 0 || ($bob_value->_balance) > 0 )
<tr>
             
          
            <td></td>
            <td style="width: 5%;white-space: nowrap;">{{$sl++}}</td>
            <td style="width: 5%;white-space: nowrap;font-weight: bold;" > {{$bob_value->_ledger_id ?? '' }}  </td>
            <td style="width: 10%;white-space: nowrap;font-weight: bold;">{!! $bob_value->_code ?? '' !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $bob_value->_name ?? '' !!} </td>
            <td style="width: 10%;">{!! $bov_value->_narration ?? '' !!}</td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;text-align: right;white-space: nowrap;font-weight: bold;">{{_report_amount($bob_value->_balance ?? 0)}}</td>
            
          </tr>
@endif

@forelse($all_data_rows as $key=>$val)

<tr>
             
            <td style="width: 5%;white-space: nowrap;"></td>
            <td style="width: 5%;white-space: nowrap;"></td>
            <td style="width: 5%;white-space: nowrap;" rowspan =""> </td>
            <td style="width: 10%;white-space: nowrap;">{!! _view_date_formate($val->_date ?? '') !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $val->_voucher_code ?? ''  !!} </td>
             <td style="width: 250px;white-space: nowrap;">{!! $val->_note ?? ''  !!} </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==4 && $val->_cr_amount > 0)
               @php
$sub_total_sales +=$val->_cr_amount ?? 0;
$branch_wise_total_sales +=$val->_cr_amount ?? 0;
$grand_total_sales +=$val->_cr_amount ?? 0;
$_balance += $val->_cr_amount ?? 0;
$sub_total_balance += $val->_cr_amount ?? 0;

$branch_wise_balance += $val->_cr_amount ?? 0;
$grand_total_balance += $val->_cr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_cr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if(in_array($val->_account_ledger,$sales_returns) && $val->_dr_amount > 0)
               @php
$sub_total_sales_return +=$val->_dr_amount ?? 0;
$branch_wise_total_sales_return +=$val->_dr_amount ?? 0;
$grand_total_sales_return +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$_sales_discount && $val->_dr_amount > 0)
               @php
$sub_total_discount +=$val->_dr_amount ?? 0;
$branch_wise_total_discount +=$val->_dr_amount ?? 0;
$grand_total_discount +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;


$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;"></td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$_incentice_expneses && $val->_dr_amount > 0)
               @php
$sub_total_incentive +=$val->_dr_amount ?? 0;
$branch_wise_total_incentive +=$val->_dr_amount ?? 0;
$grand_total_incentive +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$sales_commision && $val->_dr_amount > 0)
               @php
$sub_total_commission +=$val->_dr_amount ?? 0;
$branch_wise_total_commission +=$val->_dr_amount ?? 0;
$grand_total_commission +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$bad_debt && $val->_dr_amount > 0)
               @php
$sub_total_bad_debt +=$val->_dr_amount ?? 0;
$branch_wise_total_bad_debt +=$val->_dr_amount ?? 0;
$grand_total_bad_debt +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;

               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>



            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if(in_array($val->_account_ledger,$cash_and_bank_ledgers) && $val->_dr_amount > 0)
@if($val->_cr_amount !=$val->_amount)
<?php
$cash_back_multiple_entrys = \DB::table("accounts")->where('_voucher_code',$val->_voucher_code)
                                                  ->where("_account_ledger",$_ledger_id)
                                                  ->where('_status',1)
                                                  ->first();

      $sub_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
      $branch_wise_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
      $grand_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
$_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;
$sub_total_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;

$branch_wise_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;
$grand_total_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;


?>
{{ _report_amount($cash_back_multiple_entrys->_cr_amount ?? 0) }} 
@else
  @php
$sub_total_collection +=$val->_dr_amount ?? 0;
$branch_wise_total_collection +=$val->_dr_amount ?? 0;
$grand_total_collection +=$val->_dr_amount ?? 0;

$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}

@endif

             
              @endif
            </td>
           
         
          
            <td style="width: 10%;text-align: right;white-space: nowrap;">{{_report_amount($_balance ?? 0)}}</td>
            
          </tr>

  @empty
@endforelse 
@if(sizeof($all_data_rows) > 0)
<tr>


             
            <th colspan="6" style="width: 5%;text-align: left;">Sub Total {!! $bob_value->_code ?? '' !!} {!! $bob_value->_name ?? '' !!}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales_return)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_discount)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales-($sub_total_sales_return+$sub_total_discount))}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_incentive)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_commission)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_bad_debt)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_collection)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_balance)}}</th>
            
          </tr>       

@endif

@empty
@endforelse <!-- End of branch_wise_user_and_opening_balances Loop -->

@if($_account_ledger_id_ =='')
<tr>
            <th colspan="6">Sub Total {!! $b_value->_name ?? '' !!}</th>
          <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_sales_return)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_discount)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_sales-($branch_wise_total_sales_return+$branch_wise_total_discount))}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_incentive)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_commission)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_bad_debt)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($branch_wise_total_collection)}}</th>
            <th style="width: 10%;text-align: right;white-space: nowrap;">{{_report_amount($branch_wise_balance ?? 0)}}</th>
            
          </tr>
@endif

@empty
@endforelse <!-- End of Branch Loop -->

@if($_account_ledger_id_ =='')
<tr>
            <th colspan="5">Grand Total </th>
            <th style="width: 250px;text-align: right;"></th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_sales_return)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_discount)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_sales-($grand_total_sales_return+$grand_total_discount))}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_incentive)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_commission)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_bad_debt)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_collection)}}</th>
            <th style="width: 10%;text-align: right;white-space: nowrap;">{{_report_amount($grand_total_balance ?? 0)}}</th>
            
          </tr>

@endif



            
        

    
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="14" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

  @endif
 
<!-- End of Report Data view Section -->



    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript">


 
    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }
     
     


     function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            
          }
     

  })



</script>
@endsection

