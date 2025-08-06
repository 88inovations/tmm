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
 <a class="nav-link"  href="{{url('production')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('production-edit')
    <a class="nav-link"  title="Edit" href="{{ route('production.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
     @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

     


     <div class="row">
      <div class="col-12 table-responsive">
       <table class="table table-bordered">
        <thead style="background: #fff;color: #000;;border:0px solid #fff;">
          <tr style="background: #fff;color: #000;border:0px solid #fff;">
            <td style="background: #fff;color: #000;border:0px solid #fff;" colspan="8" style="text-align: center;">
              <div style="width: 100%;text-align: center;margin: 0px auto;">
                    <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 60px"  > {{$settings->name ?? '' }}<br>
                   <address>
                      
                      Address: {{$settings->_address ?? '' }}<br>
                      Phone: {{$settings->_phone ?? '' }}<br>
                      Email: {{$settings->_email ?? '' }}<br>
                      <b style="text-transform: uppercase;">{{$data->_type ?? '' }}</b>
                     </address>
                     
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="text-left">
              <div>
                <b>From Branch: </b>{{ _branch_name($data->_from_branch ?? 1) }}<br>
                <b>To Branch: </b>{{ _branch_name($data->_to_branch ?? 1) }}<br>
                <b>Reference: </b>{{ $data->_reference ?? '' }}<br>
              </div>
            </td>
            <td colspan="4" class="text-left">
              <div>
                <b style="text-transform: capitalize;">{{$data->_type ?? '' }} No: </b>{{ $data->id; }}<br>
                <b >Date: </b>{{ _view_date_formate($data->_date ?? '') }}<br>
                <b>Created By:</b> {!! $data->_created_by ?? '' !!}<br>
                
              </div>
            </td>
          </tr>
        </thead>
       
         
        <tbody>
          
          <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Store</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Sales Rate</th>
            <th class="text-right">Value</th>
          </tr>

          @php
              $_stock_in_total = 0;
              $_stock_in_qty = 0;
            @endphp
            @forelse($data->_stock_in AS $item_key=>$_master_val )
            <tr>
              <td>{{ ($item_key+1) }}</td>
              <td>{{ _item_name($_master_val->_item_id) }} <br>
                @if($_master_val->_barcode !="")
                  <small><span>Barcode: {{ $_master_val->_barcode ?? 'N/A' }}</span></small>
                  @endif
              </td>
              <td>{{ _store_name($_master_val->_store_id ?? 1 ) }}</td>
              <td>{{ _find_unit($_master_val->_transection_unit ?? 1 ) }}</td>
              <td>{{ _report_amount($_master_val->_qty ?? '') }}</td>
              <td>{{ _report_amount($_master_val->_rate ?? '') }}</td>
              <td>{{ _report_amount($_master_val->_sales_rate ?? '') }}</td>
              <td class="text-right">{{ _report_amount( $_master_val->_value ?? 0) }}</td>
              @php 
              $_stock_in_total += $_master_val->_value;    
              $_stock_in_qty += $_master_val->_qty;    
              @endphp
            </tr>
            @empty
            @endforelse
          <tr>
          <tr>
            <td colspan="4" class="text-left"><b>Total</b></td>
            <td><b>{{ _report_amount($_stock_in_qty ?? 0 ) }} </b></td>
            <td colspan="2"></td>
            <td  class="text-right"><b>{{ _report_amount($_stock_in_total ?? 0 ) }} </b></td>
          </tr>


            <tr>
              <td colspan="8">
                <b>Note:</b> {{$data->_note ?? ''}}
              </td>
            </tr>
            
        </tbody>
        <tfoot>

               <tr>
                 <td colspan="8">
                  @include('backend.message.invoice_footer')
                 </td>
               </tr> 
        </tfoot>
       </table>
      </div>

     </div>

   

   @endsection

@section('script')


@endsection