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
.table td{
  border:1px solid silver;
}
}
  </style>
<div class="_report_button_header">
 <a class="nav-link"  href="{{url('individual-replacement')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
     @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

     <div class="row">
      <div class="col-3">
       <h3 class="page-header">
        <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 60px"  > {{$settings->title ?? '' }}
       
       </h3>
      </div>
      <div class="col-6 text-center">
         {{ $settings->_top_title ?? '' }}
       <h4 class="page-header text-center">
        {{$page_name}}
       </h4>
      </div>
      <div class="col-3">
       <h3 class="page-header">
        <small class="float-right">Date: {!! _view_date_formate($data->_ind_repl_out_item->_date ?? '') !!}</small>
       </h3>
      </div>

     </div>
      
     <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
       
       <address>
        <strong>{{$settings->name ?? '' }}</strong><br>
        Address: {{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}
       </address>
      </div>

      <div class="col-sm-4 invoice-col">
       Supplier:
       <address>
        <strong>{{$data->_supplier_ledger->_name ?? '' }}</strong><br>
        Phone: {{$data->_supplier_ledger->_phone ?? '' }}<br>
        Email: {{$data->_supplier_ledger->_email ?? '' }}
       </address>
       Customer:
       <address>
        <strong>{{$data->_customer_ledger->_name ?? '' }}</strong><br>
        Phone: {{$data->_customer_ledger->_phone ?? '' }}<br>
        Email: {{$data->_customer_ledger->_email ?? '' }}
       </address>
      </div>
      

      <div class="col-sm-4 invoice-col">
       
        {{ invoice_barcode($data->_order_number ?? '') }}
                    
       <b>Invoice No: {{ $data->_order_number ?? '' }}</b><br>
       <b>Referance:</b> {!! $data->_referance ?? '' !!}<br>
      
       <b>Created By:</b> {!! $data->_user_name ?? '' !!}<br>
       <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
      </div>

     </div>


     <div class="row">
        @php
  $_ind_repl_old_item = $data->_ind_repl_old_item ?? '';
  $_ind_repl_in_item = $data->_ind_repl_in_item ?? '';
  $_ind_repl_out_item = $data->_ind_repl_out_item ?? '';
  $_ind_repl_in_account = $data->_ind_repl_in_account ?? '';
  $_ind_repl_out_acount = $data->_ind_repl_out_acount ?? '';


  @endphp

  @if($_ind_repl_old_item !='')
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="6">Old Item Information</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Cost Price</th>
        <th>Sales Price</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>
      
        <tr>
          <td>{{$_ind_repl_old_item->_items->_name ?? '' }}</td>
          <td>{{$_ind_repl_old_item->_barcode ?? '' }}</td>
          <td>{{ $_ind_repl_old_item->_qty ?? 0 }}</td>
          <td>{{ $_ind_repl_old_item->_rate ?? 0 }}</td>
          <td>{{ $_ind_repl_old_item->_sales_rate ?? 0 }}</td>
          <td>{{ (($_ind_repl_old_item->_qty ?? 0) * ($_ind_repl_old_item->_sales_rate ?? 0))  }}</td>
        </tr>
     
    </tbody>
  </table>
  @endif

  @if($_ind_repl_in_item != '')
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="6">Item Receive From Supplier</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Cost Price</th>
        <th>Sales Price</th>
        <th>Value</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      
        <tr>
          <td>{{$_ind_repl_in_item->_items->_name ?? '' }}</td>
          <td>{{$_ind_repl_in_item->_barcode ?? '' }}</td>
          <td>{{ $_ind_repl_in_item->_qty ?? 0 }}</td>
          <td>{{ $_ind_repl_in_item->_rate ?? 0 }}</td>
          <td>{{ $_ind_repl_in_item->_sales_rate ?? 0 }}</td>
          <td>{{ ($_ind_repl_in_item->_qty * $_ind_repl_in_item->_rate)  }}</td>
          <td>@if($_ind_repl_in_item->_in_status==1) <span class="btn btn-success">Received</span> @else <span class="btn btn-danger">Not Received </span>@endif</td>
        </tr>
      
    </tbody>
    <tfoot>
      @forelse($_ind_repl_in_account as $key=>$val)
      <tr>
        <td colspan="3">{{$val->_ledger->_name ?? '' }}</td>
        <td colspan="2">@if($val->_dr_amount > 0 ) {{ $val->_dr_amount }} Dr. @endif</td>
        <td colspan="2">@if($val->_cr_amount > 0 ) {{ $val->_cr_amount }} Cr. @endif</td>
       
      </tr>

      @empty
      @endforelse
    </tfoot>
  </table>
  @endif
  @if($_ind_repl_out_item!='' )
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="6">Item Delivery to Customer</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Cost Price</th>
        <th>Sales Price</th>
        <th>Value</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      
        <tr>
          <td>{{$_ind_repl_out_item->_items->_name ?? '' }}</td>
          <td>{{$_ind_repl_out_item->_barcode ?? '' }}</td>
          <td>{{ $_ind_repl_out_item->_qty ?? 0 }}</td>
          <td>{{ $_ind_repl_out_item->_rate ?? 0 }}</td>
          <td>{{ $_ind_repl_out_item->_sales_rate ?? 0 }}</td>
          <td>{{ ($_ind_repl_out_item->_qty * $_ind_repl_out_item->_sales_rate)  }}</td>
          <td>@if($_ind_repl_out_item->_out_status==1) <span class="btn btn-success">Delivered</span> @else <span class="btn btn-danger">Not Delivered </span>@endif</td>
        </tr>
     
    </tbody>
    <tfoot>
      @forelse($_ind_repl_out_acount as $key=>$val)
      <tr>
        <td colspan="3">{{$val->_ledger->_name ?? '' }}</td>
        <td colspan="2">@if($val->_dr_amount > 0 ) {{ $val->_dr_amount }} Dr. @endif</td>
        <td colspan="2">@if($val->_cr_amount > 0 ) {{ $val->_cr_amount }} Cr. @endif</td>
       
      </tr>

      @empty
      @endforelse
    </tfoot>
  </table>
  @endif


     </div>

   

   @endsection

@section('script')


@endsection