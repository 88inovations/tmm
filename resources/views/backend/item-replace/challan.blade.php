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
<div class="_report_button_header">
 <a class="nav-link"  href="{{url('item-replace')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('item-replace-edit')
    <a class="nav-link"  title="Edit" href="{{ route('item-replace.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

     <div class="row">
      <div class="col-4">
       <h3 class="page-header">
        <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 60px"  > {{$settings->title ?? '' }}

        
       </h3>
      </div>
      <div class="col-md-4"><h3 class="text-center">Challan</h3></div>
      <div class="col-md-4"><small class="float-right">Date: {!! _view_date_formate($data->_date ?? '') !!}</small></div>

     </div>

     <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
       From
       <address>
        <strong>{{$settings->name ?? '' }}</strong><br>
        Address: {{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}
       </address>
      </div>

      <div class="col-sm-4 invoice-col">
       To
       <address>
        <strong>{{$data->_ledger->_name ?? '' }}</strong><br>
        {{$data->_address ?? '' }}<br>
        Phone: {{$data->_phone ?? '' }}<br>
        Email: {{$data->_email ?? '' }}
       </address>
      </div>

      <div class="col-sm-4 invoice-col">
       <b>Challan/Bill No: {{ $data->_order_number ?? '' }}</b><br>
       <b>Referance:</b> {!! $data->_referance ?? '' !!}<br>
       <b>Created By:</b> {!! $data->_user_name ?? '' !!}<br>
       <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
      </div>

     </div>


     <div class="row">
      <div class="col-12 table-responsive">
       <table class="table table-striped">
        <thead>
         <tr>
          <th style="border:1px solid silver;" class="text-left">SL</th>
          <th style="border:1px solid silver;" class="text-left">Item</th>
          <th style="border:1px solid silver;" class="text-right">Qty</th>
         </tr>
        </thead>
        <tbody>
           @if(sizeof($data->_master_details) > 0)
         @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <td style="border:1px solid silver;" class="text-left" >{{($item_key+1)}}.</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
                                            <td style="border:1px solid silver;" class="  " >{!! $_item->_items->_name ?? '' !!} <br>
                                               @php
                                          $barcode_arrays = explode(',', $_item->_barcode ?? '');
                                          @endphp
                                          @forelse($barcode_arrays as $barcode)
                                        <span style="width: 100%;">{{$barcode}}</span><br>
                                          @empty
                                          @endforelse
                                            </td>
                                            
                                             <td style="border:1px solid silver;" class="text-right  " >{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            
                                            
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                            <tr>
                              <td style="border:1px solid silver;" colspan="2" class="text-right "><b>Total</b></td>
                              <td style="border:1px solid silver;" class="text-right "> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                              
                            </tr>
                            
                              
                             
         @endif
        </tbody>
        <tfoot>

               <tr>
                 <td colspan="5">
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