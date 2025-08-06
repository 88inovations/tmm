@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.red_color{
color: red;
}
  </style>
  <div class="_report_button_header">
    <a class="nav-link"  href="{{url('advance_income_statement')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
  <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                   {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
        </div>
      </div>

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
            <th style="width: 15%;">Group</th>
            <th style="width: 15%;" class="text-right">Upto Previous </th>
            <th style="width: 15%;" class="text-right">Current Period</th>
            <th style="width: 15%;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
 @php
            $net_subtotal_previous_balance=[];
            $net_subtotal_current_balance=[];
            $net_subtotal_last_amount=[];
            @endphp

            @forelse($data_sets as $key=>$data )
            @php
            $level_1_subtotal_previous_balance=[];
            $level_1_subtotal_current_balance=[];
            $level_1_subtotal_last_amount=[];
            @endphp
            @forelse($data  as $main_account_key=>$main_account)
@php
$ledger_previous_balance_sum=0;
$ledger_current_balance_sum=0;
$ledger_last_amount_balance_sum=0;
@endphp
              <tr>
                <td >{{ id_wise_name($main_account_key,"main_account_head",'_name') }}</td>
                @forelse($main_account as $led_key=>$led_val)

                @php
array_push($level_1_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
array_push($level_1_subtotal_current_balance,$led_val->_current_balance ?? 0);
array_push($level_1_subtotal_last_amount,$led_val->_last_amount ?? 0);


array_push($net_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
array_push($net_subtotal_current_balance,$led_val->_current_balance ?? 0);
array_push($net_subtotal_last_amount,$led_val->_last_amount ?? 0);

                $ledger_previous_balance_sum    +=$led_val->_previous_balance ?? 0;
                $ledger_current_balance_sum     +=$led_val->_current_balance ?? 0;
                $ledger_last_amount_balance_sum +=$led_val->_last_amount ?? 0;
                @endphp

               @empty
               @endforelse

                <td class="text-right">{{_report_amount($ledger_previous_balance_sum)}}</td>
                <td class="text-right">{{_report_amount($ledger_current_balance_sum)}}</td>
                <td class="text-right">{{_report_amount($ledger_last_amount_balance_sum)}}</td>
                
              </tr>
              @empty
            @endforelse

            <tr>
              <th class="text-left ">TOTAL {{ id_wise_name($main_account_key,"main_account_head",'_name') }}</th>
              <th class="text-right ">{{_report_amount(array_sum($level_1_subtotal_previous_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_1_subtotal_current_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_1_subtotal_last_amount))}}</th>
            
            </tr>

            @if($key ==2)
            <tr>
              <th class="red_color">GROSS PROFIT</th>
              <th class="text-right red_color">{{_report_amount(array_sum($net_subtotal_previous_balance))}}</th>
              <th class="text-right red_color">{{_report_amount(array_sum($net_subtotal_current_balance))}}</th>
              <th class="text-right red_color">{{_report_amount(array_sum($net_subtotal_last_amount))}}</th>
            </tr>
            @endif

           @if($key ==4)
            <tr style="background: #89d9eb;font-weight: bolder;">
              <th class="" >NET INCOME BEFORE INCOME TAX</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_previous_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_current_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_last_amount))}}</th>
            </tr>
            @endif

            @empty
            @endforelse

            <tr>
              <th class="" >NET INCOME AFTER INCOME TAX</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_previous_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_current_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_last_amount))}}</th>
            </tr>
                  


          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                <div class="row">
                   @include('backend.message.invoice_footer')
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
     


    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')


@endsection
