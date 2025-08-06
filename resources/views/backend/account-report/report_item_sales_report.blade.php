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
    <a class="nav-link"  href="{{url('item-sales-report')}}" role="button">
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
     

        <table class="cewReportTable">
          <thead>
          <tr>
            <th>SL</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Qty</th>
            <th>Units</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
            @php
              $total_item_qty = 0;
              $total_item_amount =0;
            @endphp
            @forelse($item_sales_res as $key=>$value)
            @php
              $total_item_qty += $value->_total_qty ?? 0;
              $total_item_amount += $value->_total_value ?? 0;
            @endphp
              <tr>
                <td>{!! ($key+1) !!}</td>
                <td>{!! $value->_code ?? '' !!}</td>
                <td>{!! $value->_item_name ?? '' !!}</td>
                <td>{!! _report_amount($value->_total_qty ?? 0) !!}</td>
                <td>{!! $value->_tran_name ?? '' !!}</td>
                <td>{!! _report_amount($value->_total_value ?? 0) !!}</td>
              </tr>
            @empty
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3">TOTAL</th>
              <th><b>{{ _report_amount($total_item_qty) }}</b></th>
              <th></th>
              <th><b>{{ _report_amount($total_item_amount) }}</b></th>
            </tr>
          </tfoot>
          
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
               <td colspan="2" class="text-center">Calculations</td>
             </tr>
          </thead>
          <tbody>
            @php
            $_default_sales_bal= $_default_sales_result[0]->_balance ?? 0;
            $_default_discount_bal= $_default_discount_result[0]->_balance ?? 0;
            $_default_vat_account_bal= $_default_vat_account_result[0]->_balance ?? 0;
            $_default_service_charge_bal= $_default_service_charge_result[0]->_balance ?? 0;
            $_default_other_charge_bal= $_default_other_charge_result[0]->_balance ?? 0;
            $_default_delivery_charge_bal= $_default_delivery_charge_result[0]->_balance ?? 0;
            @endphp
            
             <tr>
               <td>{{ $_default_sales_result[0]->_l_name ?? 'Sales' }}</td>
               <td>{{ _report_amount($_default_sales_result[0]->_balance ?? 0) }}</td>
             </tr>

             <tr>
               <td>{{ $_default_discount_result[0]->_l_name ?? 'Discount' }}</td>
               <td>{{ _report_amount($_default_discount_result[0]->_balance ?? 0) }}</td>
             </tr>
             <tr>
               <td><b>NET TOTAL</b></td>
               <td><b>{{ _report_amount(( $_default_sales_bal +  $_default_discount_bal )) }}</b></td>
             </tr>
    @if($_default_vat_account_bal !=0)
             <tr>
               <td>{{ $_default_vat_account_result[0]->_l_name ?? 'VAT' }}</td>
               <td>{{ _report_amount($_default_vat_account_result[0]->_balance ?? 0) }}</td>
             </tr>
    @endif
    @if($_default_service_charge_bal !=0)
             <tr>
               <td>{{ $_default_service_charge_result[0]->_l_name ?? 'Service Charge Income' }}</td>
               <td>{{ _report_amount($_default_service_charge_result[0]->_balance ?? 0) }}</td>
             </tr>
    @endif
    @if($_default_other_charge_bal !=0)
             <tr>
               <td>{{ $_default_other_charge_result[0]->_l_name ?? 'Other Charge Income' }}</td>
               <td>{{ _report_amount($_default_other_charge_result[0]->_balance ?? 0) }}</td>
             </tr>
    @endif
    @if($_default_delivery_charge_bal !=0)

             <tr>
               <td>{{ $_default_delivery_charge_result[0]->_l_name ?? 'Delivery Charge Income' }}</td>
               <td>{{ _report_amount($_default_delivery_charge_result[0]->_balance ?? 0) }}</td>
             </tr>
@endif
             <tr>
               <td><b>GRAND TOTAL</b></td>
               <td><b>{{ _report_amount( $_default_sales_bal+$_default_discount_bal+$_default_vat_account_bal+$_default_service_charge_bal+$_default_other_charge_bal+$_default_delivery_charge_bal ) }}</b></td>
             </tr>
             
           
          
          </tbody>
          
        </table>

        <table class="cewReportTable">
          <thead>
          <tr>
           <th colspan="3" style="border:1px solid silver;" class="text-center" >Payments</th>
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
