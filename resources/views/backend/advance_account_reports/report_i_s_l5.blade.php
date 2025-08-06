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
            <th style="width: 15%;">Ledger</th>
            <th style="width: 15%;" class="text-right">Upto Previous </th>
            <th style="width: 15%;" class="text-right">Current Period</th>
            <th style="width: 15%;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php


            $first_second_third_level_groups = [];


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


 @php
  $level_2_subtotal_previous_balance=[];
  $level_2_subtotal_current_balance=[];
  $level_2_subtotal_last_amount=[];
  @endphp
<!-- <tr>
   <th colspan="5" >{{ id_wise_name($main_account_key,"main_account_head",'_name') }}</th>
</tr> -->

@forelse($main_account as $first_head_key=>$first_head_val)

@php
  $level_3_subtotal_previous_balance=[];
  $level_3_subtotal_current_balance=[];
  $level_3_subtotal_last_amount=[];
  @endphp


@if(!in_array($first_head_key,$first_second_third_level_groups))
@php
array_push($first_second_third_level_groups,$first_head_key);
@endphp
<tr>
 
  <td colspan="5">&nbsp;&nbsp;&nbsp;<b>{{ key_wise_value($first_head_key,$account_heads) }}</b></td>
</tr>
@endif

  @forelse($first_head_val as $second_level_key=>$second_level_val)


  @php
  $level_4_subtotal_previous_balance=[];
  $level_4_subtotal_current_balance=[];
  $level_4_subtotal_last_amount=[];
  @endphp



@if(!in_array($second_level_key,$first_second_third_level_groups))
@php
array_push($first_second_third_level_groups,$second_level_key);
@endphp
  <tr>
  
  <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ key_wise_value($second_level_key,$account_heads) }}</b></td>
</tr>
@endif
  @forelse($second_level_val as $third_key=>$third_val)

  @php
  $level_5_subtotal_previous_balance=[];
  $level_5_subtotal_current_balance=[];
  $level_5_subtotal_last_amount=[];
  @endphp


@if(!in_array($third_key,$first_second_third_level_groups))
@php
array_push($first_second_third_level_groups,$third_key);
@endphp
  <tr>
  <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ key_wise_value($third_key,$account_heads) }}</td>
</tr>
@endif
@forelse($third_val as $forth_key=>$forth_val)

@php
  $level_6_subtotal_previous_balance=[];
  $level_6_subtotal_current_balance=[];
  $level_6_subtotal_last_amount=[];
  @endphp

<tr>
  
  <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ id_wise_name($forth_key,"account_groups",'_name') }}</td>
</tr>

@forelse($forth_val as $led_key=>$led_val)
              <tr>
                <td></td>
                <td >{{$led_val->_l_name ?? ''}}</td>
                

                @php
                array_push($level_1_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($level_1_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($level_1_subtotal_last_amount,$led_val->_last_amount ?? 0);

                array_push($level_2_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($level_2_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($level_2_subtotal_last_amount,$led_val->_last_amount ?? 0);
                
                array_push($level_3_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($level_3_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($level_3_subtotal_last_amount,$led_val->_last_amount ?? 0);
                
                array_push($level_4_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($level_4_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($level_4_subtotal_last_amount,$led_val->_last_amount ?? 0);
                
                array_push($level_5_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($level_5_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($level_5_subtotal_last_amount,$led_val->_last_amount ?? 0);
                
                array_push($level_6_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($level_6_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($level_6_subtotal_last_amount,$led_val->_last_amount ?? 0);


                array_push($net_subtotal_previous_balance,$led_val->_previous_balance ?? 0);
                array_push($net_subtotal_current_balance,$led_val->_current_balance ?? 0);
                array_push($net_subtotal_last_amount,$led_val->_last_amount ?? 0);

                $ledger_previous_balance_sum    +=$led_val->_previous_balance ?? 0;
                $ledger_current_balance_sum     +=$led_val->_current_balance ?? 0;
                $ledger_last_amount_balance_sum +=$led_val->_last_amount ?? 0;
                @endphp

               

                <td class="text-right">{{_report_amount($led_val->_previous_balance ?? 0)}}</td>
                <td class="text-right">{{_report_amount($led_val->_current_balance ?? 0)}}</td>
                <td class="text-right">{{_report_amount($led_val->_last_amount ?? 0)}}</td>
                
              </tr>
@empty
@endforelse

<tr style="font-weight: bold;">

               <th class="text-left " colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL {{ id_wise_name($forth_key,"account_groups",'_name') }}</th>
              <th class="text-right ">{{_report_amount(array_sum($level_6_subtotal_previous_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_6_subtotal_current_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_6_subtotal_last_amount))}}</th>
            
</tr>

@empty
@endforelse

@if(!in_array($third_key,$first_second_third_level_groups))
@php
array_push($first_second_third_level_groups,$third_key);
@endphp
          <tr style="color: #000;font-weight: bold;background: #89d9eb;">
            
              <th class="text-left " colspan="2" >TOTAL {{ key_wise_value($third_key,$account_heads) }}</th>
              <th class="text-right ">{{_report_amount(array_sum($level_5_subtotal_previous_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_5_subtotal_current_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_5_subtotal_last_amount))}}</th>
            
            </tr>
@endif

              @empty
               @endforelse


 @empty
@endforelse



 <tr style="color: #000;font-weight: bold;background: #f5f5f5;">
            
              <th class="text-left " colspan="2" >TOTAL {{ key_wise_value($third_key,$account_heads) }}</th>
              <th class="text-right ">{{_report_amount(array_sum($level_4_subtotal_previous_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_4_subtotal_current_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_4_subtotal_last_amount))}}</th>
            
            </tr>


@empty
@endforelse
@if($third_key !=$second_level_key)

          <tr style="color: #000;font-weight: bold;background: #89d9eb;">
              <th class="text-left " colspan="2">TOTAL {{ key_wise_value($second_level_key,$account_heads) }}</th>
              <th class="text-right ">{{_report_amount(array_sum($level_2_subtotal_previous_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_2_subtotal_current_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_2_subtotal_last_amount))}}</th>
            
            </tr> 
@endif


              @empty
            @endforelse
@if($second_level_key !=$first_head_key)
            <tr style="color: #fff;background: #000;font-weight: bold;">
              <th class="text-left " colspan="2">TOTAL {{ key_wise_value($first_head_key,$account_heads) }}</th>
              <th class="text-right ">{{_report_amount(array_sum($level_1_subtotal_previous_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_1_subtotal_current_balance))}}</th>
              <th class="text-right">{{_report_amount(array_sum($level_1_subtotal_last_amount))}}</th>
            
            </tr> 
@endif

            @if($key >= 1 && $key < 2)
            <tr>
              <td colspan="5" style="color:green;font-weight: bold;">LESS: COST OF GOODS SOLD</td>
            </tr>
            @endif

            

            @if($key ==2)
            <tr style="background: #89d9eb;color:#fff;font-weight: bold;">
              <th class="" colspan="2" >GROSS PROFIT</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_previous_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_current_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_last_amount))}}</th>
            </tr>
            @endif

            @if($key ==4)
            <tr style="background: #89d9eb;font-weight: bolder;">
              <th class="" colspan="2">NET INCOME BEFORE INCOME TAX</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_previous_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_current_balance))}}</th>
              <th class="text-right ">{{_report_amount(array_sum($net_subtotal_last_amount))}}</th>
            </tr>
            @endif

            @empty
            @endforelse

            
            <tr>
              <th class="" colspan="2">NET INCOME AFTER INCOME TAX</th>
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
