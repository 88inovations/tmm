
@extends('backend.layouts.app')
@section('title',$page_name)

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/print_css.css')}}">

@endsection

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
    <a class="nav-link"  href="{{url('purchase-order')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('purchase-order-edit')
    <a class="nav-link "
      title="Edit" 
    href="{{ route('purchase-order.edit',$data->id) }}"><i class="nav-icon fas fa-edit"></i> </a>
  @endcan

    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->

    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 33%;text-align: left;">
              <table class="table" style="border:none;">
                  <tr> <td style="border:none;" > {{ invoice_barcode($data->_order_number ?? '') }}</td></tr>
                  <tr>
                  <tr> <td style="border:none;" > <b>Invoice No:{{ $data->_order_number ?? '' }}</b></td></tr>
                  <tr> <td style="border:none;" > <b>Date</b>{{ _view_date_formate($data->_date ?? '') }}</td></tr>
                <tr> <td style="border:none;" > <b> Supplier:</b>  {{$data->_ledger->_name ?? '' }}</td></tr>
                <tr> <td style="border:none;" > <b> Phone:</b>  {{$data->_phone ?? '' }} </td></tr>
                <tr> <td style="border:none;" > <b> Address:</b> {{$data->_address ?? '' }} </td></tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: center;">
              <table class="table" style="border:none;">
                <tr> <td class="text-center" style="border:none;"> {{ $settings->_top_title ?? '' }}</td> </tr>
                <tr> <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_address ?? '' }}</b></td></tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_phone ?? '' }}</b>,<b>{{$settings->_email ?? '' }}</b></td></tr>
                 <tr> <td class="text-center" style="border:none;"><h3>{{$page_name}} Invoice</h3></td> </tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: right;">
              <table class="table" style="border:none;">
                  <tr> <td class="text-right" style="border:none;"  > <b>Time:</b> {{$data->_time ?? ''}} </td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Created By:</b> {{$data->_user_name ?? ''}}</td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Branch:</b> {{$data->_master_branch->_name ?? ''}} </td></tr>
              </table>
            </td>
          </tr>
        </table>
        </div>
      </div>
    
   
      <div class="row">
        <div class="col-12 table-responsive">
         
            @if(sizeof($data->_master_details) > 0)
                        
                              <table class="table _grid_table">
                                <thead >
                                            <th class="text-left" >SL</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-center" >Unit</th>
                                            <th class="text-right" >Qty</th>
                                            <th class="text-right" >Rate</th>
                                            <th class="text-right" >Value</th>
                                             @if(sizeof($permited_branch) > 1)
                                            <th class="text-middle" >Branch</th>
                                            @else
                                            <th class="text-middle display_none" >Branch</th>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <th class="text-middle" >Cost Center</th>
                                            @else
                                             <th class="text-middle display_none" >Cost Center</th>
                                            @endif
                                            
                                           
                                          </thead>
                                <tbody>
                                  @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <td class="" >{{($item_key+1)}}</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                     @endphp
                                            <td class="" >{!! $_item->_items->_name ?? '' !!}</td>
                                          <td class="text-center" >{!! $_item->_trans_unit->_name ?? $_item->_items->_units->_name !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            
                                            <td class="text-right" >{!! _report_amount(($_item->_rate ?? 0)) !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_value ?? 0) !!}</td>
                                             @if(sizeof($permited_branch) > 1)
                                            <td class="" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                            @else
                                            <td class=" display_none" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <td class="" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                            @endif
                                             
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td colspan="2" class="text-right"> <b>Total</b></td>
                                               <td></td>
                                              <td class="text-right">
                                                <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                                              <td></td>
                                             
                                              
                                              <td class="text-right">
                                               <b> {{ _report_amount($_value_total ?? 0) }}</b>
                                              </td>
                                              @if(sizeof($permited_branch) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                             
                                            </tr>
                                </tfoot>
                              </table>
                           
                          </div>
                        </td>
                        </tr>
                        @endif
         
      </div>

    

    <div class="row">
    
       @include('backend.message.invoice_footer')
    </div>
    <!-- /.row -->
  </section>

@endsection