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
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('detail-item-sales-report')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date: {{ _view_date_formate($request->_datex ?? '') }} To {{ _view_date_formate($request->_datey ?? '') }} </strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}
                 </td> </tr>
              </table>
            </td>
           
          </tr>
        </table>
        <!-- Table row -->
       @php
           
            $_default_discount_bal= $_default_discount_result[0]->_balance ?? 0;
            $_default_vat_account_bal= $_default_vat_account_result[0]->_balance ?? 0;
            $_default_service_charge_bal= $_default_service_charge_result[0]->_balance ?? 0;
            $_default_other_charge_bal= $_default_other_charge_result[0]->_balance ?? 0;
            $_default_delivery_charge_bal= $_default_delivery_charge_result[0]->_balance ?? 0;
            @endphp

        <table class="cewReportTable">
          <thead>
          <tr>
            <th colspan="3" class="text-center">  Item Group By Sales Amount</th>
          </tr>
          </thead>
          <tbody>
           @php
            $group_total=0;
           @endphp
             @forelse($item_group_res as $key=>$value)
             @php
              $group_total +=$value->_value;
             @endphp
             <tr>
              <td>{{ $value->_name ?? '' }}</td>
              <td class="text-right">{{ _report_amount(($value->_value/$_total_value)*100) }} %</td>
              <td class="text-right">{{ _report_amount($value->_value ?? 0) }}</td>
              
             </tr>
            @empty
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-right"><b>Total</b></td>
              <td class="text-right"><b>{{  _report_amount($group_total) }}</b></td>
            </tr>
          </tfoot>
          
        </table>


        <table class="cewReportTable mt-2" >
          <thead>
          <tr>
            <th colspan="3" class="text-center">  Item Group By Quantity</th>
          </tr>
          </thead>
          <tbody>
           @php
            $group_qty=0;
           @endphp
             @forelse($item_group_res as $key=>$value)
             @php
              $group_qty +=$value->_total_qty;
             @endphp
             <tr>
              <td>{{ $value->_name ?? '' }}</td>
              <td class="text-right">{{ _report_amount(($value->_total_qty/$total_qty)*100) }} %</td>
              <td class="text-right">{{ _report_amount($value->_total_qty ?? 0) }}</td>
              
             </tr>
            @empty
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-right"><b>Total</b></td>
              <td class="text-right"><b>{{  _report_amount($group_qty) }}</b></td>
            </tr>
          </tfoot>
          
        </table>

        <table class="cewReportTable mt-2" >
          <thead>
          <tr>
            <th>SL</th>
            <th>{{__('label._order_number')}}</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
            <th class="text-center">Net-Amount</th>
          </tr>
          </thead>
          <tbody>
           @php
            $_detail_qty=0;
            $_detail_amount=0;
           @endphp



             @forelse($item_detail_res_group_by_category as $cat_key=>$values)

@php
    $_sub_detail_qty=0;
    $sub_detail_amount=0;
@endphp
 <tr>
   <th colspan="6">{!! $cat_key ?? '' !!}</th>
 </tr>

@forelse($values as $key=>$value)
             @php
              $_detail_qty +=$value->_qty ?? 0;
              $_detail_amount +=$value->_value ?? 0;

              $_sub_detail_qty +=$value->_qty ?? 0;
              $sub_detail_amount +=$value->_value ?? 0;
             @endphp
             <tr>
              <td>{{ ($key+1) }}</td>
              <td>{{ $value->_order_number ?? '' }}</td>
              <td>{{ $value->_code ?? '' }}</td>
              <td>{{ $value->_name ?? '' }}</td>
              <td  class="text-right">{{ _report_amount($value->_qty ?? 0 ) }} [{!! _find_unit($value->_unit_id) !!}]</td>
              <td  class="text-right">{{ _report_amount($value->_sales_rate ?? 0 ) }}</td>
              <td class="text-right">{{ _report_amount($value->_value) }} </td>
              
              
             </tr>
       @empty
        @endforelse
@if(sizeof($values) > 1)
 <tr>
              <td colspan="4" ><b>Total {!! $cat_key ?? '' !!}</b></td>
              <td class="text-right"><b>{{  _report_amount($_sub_detail_qty) }}</b></td>
              <td></td>
              <td class="text-right"><b>{{  _report_amount($sub_detail_amount) }}</b></td>
            </tr>

@endif

            @empty
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" ><b>Total</b></td>
              <td class="text-right"><b>{{  _report_amount($_detail_qty) }}</b></td>
              <td></td>
              <td class="text-right"><b>{{  _report_amount($_detail_amount) }}</b></td>
            </tr>
            <tr>
              <td colspan="4" ><b>[-] Sales Discount</b></td>
              <td class="text-right"></td>
              <td></td>
              <td class="text-right"><b>{{  _report_amount($_default_discount_bal) }}</b></td>
            </tr>
            <tr>
              <td colspan="4" ><b>Net Sales</b></td>
              <td class="text-right"></td>
              <td></td>
              <td class="text-right"><b>{{  _report_amount($_detail_amount+$_default_discount_bal) }}</b></td>
            </tr>
          </tfoot>
          
        </table>

         <table class="cewReportTable">
          <thead>
          <tr>
           <th colspan="3" style="border:1px solid silver;" class="text-center" >Receive Cash & Bank</th>
          </tr>
          </thead>
          <tbody>
            @php

            @endphp
           @forelse($ledger_groupd_result as $key1=>$val )
             <tr>
               <td>{{ $val->_l_name ?? '' }}</td>
               <td>{{ round((($val->_balance/$total_cashin_hand)*100),2) }} % </td>
               <td>{{ _report_amount($val->_balance ?? 0) }}</td>
             </tr>
          @empty
          @endforelse

           
          
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2">TOTAL</th>
              <th><b>{{ _report_amount($total_cashin_hand) }}</b></th>
            </tr>
          </tfoot>
          
        </table>
       

    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
