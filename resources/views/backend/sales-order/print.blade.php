
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
.table td{
  border: 1px solid #000;
  padding-left:  3px;
  padding-right:  3px;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('sales-order')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('sales-order-edit')
 <a class="nav-link "  title="Edit"  href="{{ route('sales-order.edit',$data->id) }}"><i class="nav-icon fas fa-edit"></i> </a>                        
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
                  <tr> <td style="border:none;" >  {{ invoice_barcode($data->_order_number ?? '') }}</td></tr>
                  <tr> <td style="border:none;" > <b>Invoice NO:  {{ $data->_order_number ?? '' }}</b></td></tr>
                  <tr> <td style="border:none;" > <b>Date: </b>{{ _view_date_formate($data->_date ?? '') }}</td></tr>
                <tr> <td style="border:none;" > <b> Customer:</b>  {{$data->_ledger->_name ?? '' }}</td></tr>
                <tr> <td style="border:none;" > <b> Proprietor:</b>  {{$data->_ledger->_alious ?? '' }}</td></tr>
                <tr> <td style="border:none;" > <b> Phone:</b>  {{$data->_phone ?? '' }} </td></tr>
                <tr> <td style="border:none;" > <b> Address:</b> {{$data->_address ?? '' }} </td></tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: center;">
              <table class="table" style="border:none;">
                <tr> <td class="text-center" style="border:none;"> {{ $settings->_top_title ?? '' }}</td> </tr>
                <tr> <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr> <td class="text-center" style="border:none;font-size: 12px;"><b>{{$settings->_address ?? '' }}</b></td></tr>
                <tr> <td class="text-center" style="border:none;font-size: 12px;"><b>{{$settings->_phone ?? '' }}</b>,<b>{{$settings->_email ?? '' }}</b></td></tr>
                 <tr> <td class="text-center" style="border:none;"><h3>{{$page_name}} </h3></td> </tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: right;">
              <table class="table" style="border:none;">
                  <tr> <td class="text-right" style="border:none;"  > <b>Time:</b> {{$data->_time ?? ''}} </td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Created By:</b> {{$data->_user_name ?? ''}}</td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>{{__('label._branch_id')}}:</b> {{$data->_master_branch->_name ?? ''}} </td></tr>
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
                                            <tr>
          <th style="border:1px solid #56585bc2;width: 5%;font-size:12px;" class="text-center">SL</th>
          <th style="border:1px solid #56585bc2;width: 30%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Name of Products</th>
          <th style="border:1px solid #56585bc2;width: 10%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Pack Size </th>
          <th style="border:1px solid #56585bc2; width: 8%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Sales Qty</th>
          <th style="border:1px solid #56585bc2; width: 7%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">{{__('label._is_free')}}</th>
          <th style="border:1px solid #56585bc2; width: 7%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Qty(Total)</th>
          <th style="border:1px solid #56585bc2; width: 8%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Trade Price</th>
          <th style="border:1px solid #56585bc2; width: 10%;font-size:12px;white-space: nowrap;" class="text-center">Total Amount</th>
          
          <th colspan="2" style="border:1px solid #56585bc2; width: 10%;font-size:12px;text-align:center;white-space: nowrap;" >Cash Discount</th>

          <th  style="border:1px solid #56585bc2; width: 15%;font-size:12px;text-align:center;white-space: nowrap;" class="text-right">Net Amount</th>
         </tr>
                                             
                                            
                                           
                                          </thead>
                                <tbody>
                                  @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_sale_qty =0;
                                    $_total_free_qty =0;
                                    $_total_discount_amount =0;
                                    $_net_value_total =0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <td class="" style="border:1px dotted grey;" >{{($item_key+1)}}</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_net_value_total +=(($_item->_value ?? 0)-($_item->_discount_amount ?? 0));
                                      $_qty_total += $_item->_qty ?? 0;

                                      $_total_sale_qty +=$_item->sale_qty ?? 0;
                                            $_total_free_qty +=$_item->free_qty ?? 0;
                                             $_total_discount_amount +=$_item->_discount_amount ?? 0;
                                     @endphp
                                          
                                            <td class="" style="border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! $_item->_items->_name ?? '' !!}</td>
                                           
                                            <td class="" style="border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! $_item->_items->_pack_size->_name ?? '' !!}</td>
                                          
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->sale_qty ?? 0) !!}</td>
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->free_qty ?? 0) !!}</td>
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->_rate ?? 0) !!}</td>
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->_value ?? 0) !!}</td>

                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->_discount ?? 0) !!} @if($_item->_discount > 0) % @endif </td>
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
                                            <td style="text-align: right;border:1px dotted grey;padding-left: 3px;padding-right: 3px;" >{!! _report_amount(($_item->_value ?? 0)-($_item->_discount_amount ?? 0)) !!}</td>
                                            
                                             
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td colspan="3" style="text-align: left;border:1px dotted grey;"> <b>Total</b></td>
                                              <td style="text-align: right;border:1px dotted grey;">
                                                <b>{{ _report_amount($_total_sale_qty ?? 0) }}</b> </td>

                                                 <td style="text-align: right;border:1px dotted grey;"><b>{{ _report_amount($_total_free_qty ?? 0) }}</b> </td>
                                                 <td style="text-align: right;border:1px dotted grey;"><b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                                             
                                              <td style="text-align: right;border:1px dotted grey;"></td>
                                              <td style="text-align: right;border:1px dotted grey;">
                                               <b> {{ _report_amount($_value_total ?? 0) }}</b>
                                              </td>
                                             
                                              
                                             
                                              <td style="text-align: right;border:1px dotted grey;"></td>
                                              <td style="text-align: right;border:1px dotted grey;">
                                               <b> {{ _report_amount($_total_discount_amount ?? 0) }}</b>
                                              </td>
                                             
                                              <td style="text-align: right;border:1px dotted grey;">
                                               <b> {{ _report_amount($_net_value_total ?? 0) }}</b>
                                              </td>
                                            </tr>
                                           
                                              
                                     <tr>
                                      <td colspan="10" class="text-right"  style="border:1px dotted grey;font-weight:bold;white-space: nowrap; "> Sales Amount =</td>
                                      <td class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; ">{!! _report_amount($data->_sub_total ?? 0) !!}</td>
                                    </tr> 
                                    @if($_total_discount_amount > 0)
                                     <tr>
                                      <td colspan="10" class="text-right"  style="border:1px dotted grey;font-weight:bold;white-space: nowrap; "> Line Discount =</td>
                                      <td class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; ">{!! _report_amount($_total_discount_amount ?? 0) !!}</td>
                                    </tr>
                                    @endif
                                    @if($data->_discount_input > 0)
                                     <tr>
                                      <td colspan="10" class="text-right"  style="border:1px dotted grey;font-weight:bold;white-space: nowrap; "> Invoice Discount =</td>
                                      <td class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; ">{!! _report_amount($data->_discount_input ?? 0) !!}</td>
                                    </tr>
                                    @endif
                                   
                                   @if($data->_total_discount > 0)
                                    <tr>
                                      <td  colspan="10" class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; "> Total Discount =</td>
                                      <td class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; ">{!! _report_amount($data->_total_discount ?? 0) !!}</td>
                                    </tr>
                                   @endif
                                    

                                    <tr>
                                      <td  colspan="10" class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; "> Net Payable Amount =</td>
                                      <td class="text-right" style="border:1px dotted grey;font-weight:bold;white-space: nowrap; ">{!! _report_amount($data->_total ?? 0) !!}</td>
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