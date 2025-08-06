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
                               
                               <a href="{{url('customer_statement')}}"    class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
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
            <th style="width: 10%;">Collection</th>
            <th style="width: 10%;">Balance</th>
            
          </tr>
          
          
          </thead>
          <tbody>

@php
$sub_total_sales=0;
$sub_total_sales_return=0;
$sub_total_discount=0;
$sub_total_incentive=0;
$sub_total_commission=0;
$sub_total_bad_debt=0;
$sub_total_collection=0;
$sub_total_balance=0;
$l_sl=1;
@endphp

@forelse($reportable_ledgers as $ledger)
@php
$_ledger_id = $ledger->_account_ledger;
$_name = $ledger->_name;
$_code = $ledger->_code;

$sub_total_sales=0;
$sub_total_sales_return=0;
$sub_total_discount=0;
$sub_total_incentive=0;
$sub_total_commission=0;
$sub_total_bad_debt=0;
$sub_total_collection=0;
$sub_total_balance=0;

$grand_total_sales=0;
$grand_total_sales_return=0;
$grand_total_discount=0;
$grand_total_incentive=0;
$grand_total_commission=0;
$grand_total_bad_debt=0;
$grand_total_net_sales=0;
$grand_total_collection=0;
$grand_total_balance=0;
@endphp

<!-- First Find out Ledger Balance -->

<?php 
$balance_datas = \DB::select(" SELECT  null as _date, null as _short_narration, 'Opening Balance' as _narration, 0 AS _dr_amount, 0  AS _cr_amount, SUM(t1._dr_amount-t1._cr_amount) AS _balance ,0 as _serial,t2._branch_id,t3._name as b_name 
            FROM accounts as t1
            INNER JOIN account_ledgers as t2 on t1._account_ledger=t2.id
            INNER JOIN branches as t3 ON t3.id=t2._branch_id
               WHERE t1._status=1 AND t1._date < '".$_datex."' AND t1._account_ledger IN(".$_ledger_id.")   AND t1.organization_id IN(".$_organization_id_rows.") AND  t2._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center IN(".$_cost_center_id_rows.") 
                 GROUP BY t1._account_ledger ");


  $customer_all_vouchers = \DB::table("accounts")
                ->where('_account_ledger',$_ledger_id)
                ->join('account_ledgers','account_ledgers.id','accounts._account_ledger')
                ->whereIn("accounts.organization_id",$request_organizations)
                ->whereIn("accounts._cost_center",$_cost_center_ids)
                ->whereIn("account_ledgers._branch_id",$_branch_ids)
                ->where('accounts._status',1)
                ->pluck('accounts._voucher_code');

    $_sales_discount=7;
    $_incentice_expneses=592;
    $sales_returns=[5,2];
    $sales_commision=8;
    $bad_debt=29;
    $collection_ledgers =[4,591,589,588,587,586,585,584,583,117,1,7,592,5,8,29,2];

    $cash_and_bank_ledgers =[591,589,588,587,586,585,584,583,117,1];

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

  $all_accounts_rows =[];

  foreach ($all_data_rows as $key => $value) {
    $all_accounts_rows[$value->_branch_id][]=$value; 
  }

    


//dump($all_accounts_rows);
//die();
$_balance = $balance_datas[0]->_balance ?? 0;
$sub_total_balance += $balance_datas[0]->_balance ?? 0;
$b_name = $balance_datas[0]->b_name ?? '';

$sl=1;

?>
<tr>
             
            <th style="width: 5%;">{{$l_sl++}}</th>
            <th style="width: 5%;">{{$sl++}}</th>
            <th style="width: 5%;" rowspan =""> {{$_ledger_id}}  </th>
            <th style="width: 10%;">{!! $_code ?? '' !!}</th>
            <th style="width: 10%;">{!! $_name ?? '' !!}</th>
            <th style="width: 10%;">Opening Balance</th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;"></th>
            <th style="width: 10%;text-align: right;">{{_report_amount($_balance ?? 0)}}</th>
            
          </tr>

@forelse( $all_accounts_rows as $b_key=>$branch_wise_data)

<tr>
  <th colspan="12">{!! _id_to_name($b_key,'_name','branches') !!}</th>
</tr>

  @forelse($branch_wise_data as $key=>$val)

<tr>
             
            <td style="width: 5%;white-space: nowrap;"></td>
            <td style="width: 5%;white-space: nowrap;">{{$sl++}}</td>
            <td style="width: 5%;white-space: nowrap;" rowspan =""> </td>
            <td style="width: 10%;white-space: nowrap;">{!! _view_date_formate($val->_date ?? '') !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $val->_voucher_code ?? ''  !!} </td>
             <td style="width: 10%;">{!! $val->_note ?? ''  !!} </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==4 && $val->_cr_amount > 0)
               @php
$sub_total_sales +=$val->_cr_amount ?? 0;
$_balance += $val->_cr_amount ?? 0;
$sub_total_balance += $val->_cr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_cr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if(in_array($val->_account_ledger,$sales_returns) && $val->_dr_amount > 0)
               @php
$sub_total_sales_return +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$_sales_discount && $val->_dr_amount > 0)
               @php
$sub_total_discount +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;"></td>
            <td style="width: 10%;text-align: right;white-space: nowrap;display: none;">
               @if($val->_account_ledger==$_incentice_expneses && $val->_dr_amount > 0)
               @php
$sub_total_incentive +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$sales_commision && $val->_dr_amount > 0)
               @php
$sub_total_commission +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$bad_debt && $val->_dr_amount > 0)
               @php
$sub_total_bad_debt +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if(in_array($val->_account_ledger,$cash_and_bank_ledgers) && $val->_dr_amount > 0)
@if($val->_cr_amount !=$val->_amount)
@php
$cash_back_multiple_entrys = \DB::table("accounts")->where('_voucher_code',$val->_voucher_code)
                                                  ->where("_account_ledger",$_ledger_id)
                                                  ->where('_status',1)
                                                  ->first();

      $sub_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
$_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;
$sub_total_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;


@endphp
{{ _report_amount($cash_back_multiple_entrys->_cr_amount ?? 0) }} 
@else
  @php
$sub_total_collection +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}

@endif

             
              @endif
            </td>
           
            
          
            <td style="width: 10%;text-align: right;white-space: nowrap;">{{_report_amount($_balance ?? 0)}}</td>
            
          </tr>
            @php
$grand_total_sales +=$sub_total_sales ?? 0;
$grand_total_sales_return +=$sub_total_sales_return ?? 0;
$grand_total_discount +=$sub_total_discount ?? 0;
$grand_total_net_sales +=($sub_total_sales-($sub_total_sales_return+$sub_total_discount));
$grand_total_incentive +=$sub_total_incentive ?? 0;
$grand_total_commission +=$sub_total_commission ?? 0;
$grand_total_bad_debt +=$sub_total_bad_debt ?? 0;
$grand_total_collection +=$sub_total_collection ?? 0;
$grand_total_balance +=$sub_total_balance ?? 0;
  @endphp
  
@empty
@endforelse

<tr>


             
            <th colspan="6" style="width: 5%;">Sub Total {!! $_code ?? '' !!} {!! $_name ?? '' !!}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales_return)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_discount)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales-($sub_total_sales_return+$sub_total_discount))}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_incentive)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_commission)}}</th>
            <th style="width: 10%;text-align: right;display: none;">{{_report_amount($sub_total_bad_debt)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_collection)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_balance)}}</th>
            
          </tr>

@empty
@endforelse



@empty
@endforelse
<tr>
             
            <th colspan="6" style="width: 5%;">Grand Total</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_sales_return)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_discount)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_net_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_incentive)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_commission)}}</th>
            <th style="width: 10%;text-align: right;display: none;">{{_report_amount($grand_total_bad_debt)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_collection)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($grand_total_balance)}}</th>
            
          </tr>







            
        

    
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="8" style="border: none;">
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

