@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-entry-assign-list')
            <li class="breadcrumb-item"><a href="{{route('asset_depreciation.index')}}">{{$page_name ?? ''}}</a></li>
            @endcan
           
            <li class="breadcrumb-item">
               <a style="cursor: pointer;"   title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>
               </a>
            </li>
            <li class="breadcrumb-item">
                <a style="cursor: pointer;" onclick="fnExcelReport();"   title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
            </li>
           
          </ol>
        </nav>
        <div class="mb-9">
       


<section class="invoice" id="printablediv">
   <div class="text-center">
      <address>
        <img src="{{asset('/')}}{{$settings->logo ?? '' }}" style="width:60px;height: 60px;"><br>
            {!! $settings->name ?? '' !!}<br>
            @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}<br>@endif
           
        @php

$month =$main_data->_dep_month;
$year  =$main_data->_dep_year;
        @endphp  
           <b> Fixed assets depreciation <br/> Period For the Month {{_number_to_month($main_data->_dep_month ?? '')}}, {{$main_data->_dep_year ?? ''}}</b>
           
           
        </address>
  </div>
  
    <table class="table table-bordered table-sm fs--1 mb-0"  style="width:100%;">
      <tr>
        <td style="width:5%;padding: 0px;text-align: center;vertical-align: top;"><b>SL</b></td>
        <td style="width:20%;padding:0px;text-align: center;vertical-align: top;"><b>Asset</b></td>
        <td style="width:20%;padding:0px;text-align: center;vertical-align: top;"><b>Asset Code</b></td>
        <td style="width:10%;padding: 0px;text-align: center;vertical-align: top;"><b>Cost of Purchase</b></td>
        <td style="width:5%;padding: 0px;text-align: center;vertical-align: top;"><b>Other Cost</b></td>
        <td style="width:10%;padding: 0px;text-align: center;vertical-align: top;"><b>Total <br> Value</b></td>
        <td style="width:5%;padding:0px;text-align: center;vertical-align: top;"><b>Dep Rate</b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Accumulated <br> Depreciation <br>at the beginning<br> of the Month</b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Dep. for <br>the Month</b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Accumulated <br>Depreciation at the end <br>of theMonth</b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Net <br>book <br>Value </b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Selling <br>Value </b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>P/L On  <br>sale </b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Date of <br>Sale </b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>Dep. <br>Period </b></td>
        <td style="width:10%;padding:0px;text-align: center;vertical-align: top;"><b>remarks </b></td>
      </tr>




      @php

$total_purchase_price=0;
$total_extra_cost=0;
$total_evaluated_price=0;
$total_acc_before_dep=0;
$total_asset_dep_amount=0;
$total_accumulated_dep_val=0;
$total_book_value=0;
$total_selling_value=0;
$total_pl_amount =0;

$sub_total_selling_value=0;
$sub_total_purchase_price=0;
$sub_total_extra_cost=0;
$sub_total_evaluated_price=0;
$sub_total_acc_before_dep=0;
$sub_total_asset_dep_amount=0;
$sub_total_accumulated_dep_val=0;
$sub_total_book_value=0;
$sub_total_pl_amount=0;

      @endphp
      @forelse($asset_detail_data as $key=>$values)

      @php
$ledger_name =  _find_ledger($key);
      @endphp
<tr>
    <td colspan="16" style="text-align: left;"><b>{{ $ledger_name }}</b></td>
</tr>
      @forelse($values as $v_key=>$val)
      @php
$acc_before_dep = (($val->accumulated_dep_val ?? 0)-($val->_asset_dep_amount ?? 0));


$total_purchase_price +=$val->_asset_item->purchase_price ?? 0;
$total_extra_cost  +=$val->_asset_item->extra_cost ?? 0;
$total_evaluated_price  +=$val->_asset_item->evaluated_price ?? 0;
$total_acc_before_dep  +=$acc_before_dep ?? 0;
$total_asset_dep_amount  +=$val->_asset_dep_amount ?? 0;
$total_accumulated_dep_val  +=$val->accumulated_dep_val ?? 0;
$total_book_value  +=$val->book_value ?? 0;
$total_selling_value  +=$val->_asset_item->_selling_value?? 0;
$total_pl_amount  +=$val->_asset_item->_pl_amount ?? 0;


$sub_total_purchase_price +=$val->_asset_item->purchase_price ?? 0;
$sub_total_extra_cost  +=$val->_asset_item->extra_cost ?? 0;
$sub_total_evaluated_price  +=$val->_asset_item->evaluated_price ?? 0;
$sub_total_acc_before_dep  +=$acc_before_dep ?? 0;
$sub_total_asset_dep_amount  +=$val->_asset_dep_amount ?? 0;
$sub_total_accumulated_dep_val  +=$val->accumulated_dep_val ?? 0;
$sub_total_book_value  +=$val->book_value ?? 0;
$sub_total_selling_value  +=$val->_asset_item->_selling_value?? 0;
$sub_total_pl_amount  +=$val->_asset_item->_pl_amount ?? 0;


      @endphp
      <tr>
        <td style="width:5%;padding: 0px;">{{($v_key+1)}}</td>
        <td style="width:20%;padding:0px;white-space: nowrap;">{!! $val->_asset_item->name ?? '' !!}</td>
        <td style="width:20%;padding:0px;white-space: nowrap;">{!! $val->_asset_item->asset_code ?? '' !!}</td>
        <td style="width:10%;padding: 0px;text-align: right;white-space: nowrap;">{!! _report_amount($val->_asset_item->purchase_price ?? 0) !!}</td>
        <td style="width:5%;padding: 0px;text-align: right;white-space: nowrap;">{!! _report_amount($val->_asset_item->extra_cost ?? 0) !!}</td>
        <td style="width:10%;padding: 0px;text-align: right;white-space: nowrap;">{!! _report_amount($val->_asset_item->evaluated_price ?? 0) !!}</td>
        <td style="width:5%;padding:0px;text-align: center;white-space: nowrap;">{!! _report_amount($val->_asset_item->dep_rate ?? 0) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _report_amount($acc_before_dep ) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _report_amount(($val->_asset_dep_amount ?? 0)) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _report_amount(($val->accumulated_dep_val ?? 0)) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _report_amount(($val->book_value ?? 0)) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _report_amount(($val->_asset_item->_selling_value ?? 0)) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _report_amount(($val->_asset_item->_pl_amount ?? 0)) !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{!! _view_date_formate($val->_asset_item->_sale_date ?? '') !!}</td>
        <td style="width:10%;padding:0px;text-align: right;white-space: nowrap;">{{month_wise_day($month,$year)}}</td>
        
        <td style="width:10%;padding:0px;"> </td>
      </tr>

       @empty
    @endforelse

   <tr>
        <td colspan="3" style="width:25%;padding: 0px;text-align: left;"><b>Sub Total {{ $ledger_name }}</b></td>
        <td style="width:10%;padding: 0px;text-align: right;"><b>{{_report_amount($sub_total_purchase_price)}}</b></td>
        <td style="width:5%;padding: 0px;text-align: right;"><b>{{_report_amount($sub_total_extra_cost)}}</b></td>
        <td style="width:10%;padding: 0px;text-align: right;"><b>{{_report_amount($sub_total_evaluated_price)}}</b></td>
        <td style="width:5%;padding:0px;"><b></b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($sub_total_acc_before_dep) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($sub_total_asset_dep_amount) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($sub_total_accumulated_dep_val) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($sub_total_book_value) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($sub_total_selling_value) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($sub_total_pl_amount) }}</b></td>
        <td style="width:10%;padding:0px;"><b> </b></td>
        <td style="width:10%;padding:0px;"><b> </b></td>
        <td style="width:10%;padding:0px;"><b> </b></td>
      </tr>
    @empty
    @endforelse

     <tr>
        <td colspan="3" style="width:25%;padding: 0px;text-align: right;"><b>GRAND TOTAL</b></td>
        <td style="width:10%;padding: 0px;text-align: right;"><b>{{_report_amount($total_purchase_price)}}</b></td>
        <td style="width:5%;padding: 0px;text-align: right;"><b>{{_report_amount($total_extra_cost)}}</b></td>
        <td style="width:10%;padding: 0px;text-align: right;"><b>{{_report_amount($total_evaluated_price)}}</b></td>
        <td style="width:5%;padding:0px;"><b></b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($total_acc_before_dep) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($total_asset_dep_amount) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($total_accumulated_dep_val) }}</b></td>
        <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($total_book_value) }}</b></td>
       <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($total_selling_value) }}</b></td>
       <td style="width:10%;padding:0px;text-align: right;"><b>{{_report_amount($total_pl_amount) }}</b></td>
        <td style="width:10%;padding:0px;"><b> </b></td>
        <td style="width:10%;padding:0px;"><b> </b></td>
        <td style="width:10%;padding:0px;"><b> </b></td>
      </tr>

<tfoot>
  <tr>
   
  </tr>
</tfoot>
    </table>
  
  
       
                        

                     
 </section>
          
        
            
</div>
</div>
</div>
</div>



@endsection

@section('script')
@endsection