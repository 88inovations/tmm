
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div style="padding-left: 20px;display: flex;">
 
    <a class="nav-link"  href="{{url('lot-item-information')}}" role="button"><i class="fa fa-arrow-left"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
   
    <!-- info row -->
    <div class="col-12">
       <div style="text-align: center;">
         <h3><img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 50px;width: 50px"  > {{$settings->name ?? '' }}
       
       </h3>
       <div>{{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}</div>
       </div>
       <h3 class="text-center">  {{$page_name}}</h3>
        
      </div>
  
<div class="table-responsive">
   <table  style="width: 100%" style="border:1px solid silver;">
                      <tr>
                         <th style="border:1px solid silver;">SL</th>
                         <th style="border:1px solid silver;">Item</th>
                         <th style="border:1px solid silver;">Unit</th>
                         <th style="border:1px solid silver;">Code</th>
                         <th style="border:1px solid silver;">Barcode</th>
                         <th style="border:1px solid silver;">QTY</th>
                         
                         <th style="border:1px solid silver;">Discount</th>
                         <th style="border:1px solid silver;">Vat</th>
                         <th style="border:1px solid silver;">Purchase Rate</th>
                         <th style="border:1px solid silver;">Sales Rate</th>
                         <th style="border:1px solid silver;">Total Value</th>
                         <th style="border:1px solid silver;">Manu. Date</th>
                         <th style="border:1px solid silver;">Exp. Date</th>
                         <th style="border:1px solid silver;">Status</th>            
                      </tr>
                      @php
                        $total_qty=0;
                        $total_value=0;
                      @endphp
                        @foreach ($datas as $key => $data)
                         @php
                        $total_qty +=$data->_qty;
                        $total_value +=($data->_qty*$data->_pur_rate);
                      @endphp
                        <tr>
                           
                           
                            <td style="border:1px solid silver;">{{ ($key+1) }}</td>
                            <td style="border:1px solid silver;">{{ $data->_item ?? '' }}</td>
                            <td style="border:1px solid silver;">{{ $data->_units->_name ?? '' }}</td>
                            <td style="border:1px solid silver;">{{ $data->_code ?? '' }}</td>
                            <td style="border:1px solid silver;">{{ $data->_barcode ?? '' }}</td>
                            <td style="border:1px solid silver;" class="text-right">{{ $data->_qty ?? 0 }}</td>
                            <td style="border:1px solid silver;" class="text-right">{{ _report_amount( $data->_discount ?? 0 ) }}</td>
                            <td style="border:1px solid silver;" class="text-right">{{ _report_amount( $data->_vat ?? 0 ) }}</td>
                            <td style="border:1px solid silver;" class="text-right">{{ _report_amount($data->_pur_rate ?? 0 ) }}</td>
                            <td style="border:1px solid silver;" class="text-right">{{ _report_amount($data->_sales_rate ?? 0 ) }}</td>
                            <td style="border:1px solid silver;" class="text-right">{{ _report_amount(($data->_qty*$data->_pur_rate) ) }}</td>
                            <td style="border:1px solid silver;">{{ _view_date_formate($data->_manufacture_date ?? '') }}</td>
                            <td style="border:1px solid silver;">{{ _view_date_formate($data->_expire_date ?? '') }}</td>
                           <td style="border:1px solid silver;">{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @endforeach
                        <tr>
                          <th style="border:1px solid silver;" colspan="5" class="text-left">Total</th>
                          <th style="border:1px solid silver;" class="text-right">{{_report_amount($total_qty)}}</th>
                          <th style="border:1px solid silver;" colspan="4"></th>
                          <th style="border:1px solid silver;" class="text-right">{{_report_amount($total_value)}}</th>
                          <th style="border:1px solid silver;" colspan="3"></th>
                        </tr>
                    </table>
                </div>
    
    
  </section>

@endsection