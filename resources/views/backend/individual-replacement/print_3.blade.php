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
 <a class="nav-link"  href="{{url('third-party-service')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('third-party-service-edit')
    <a class="nav-link"  title="Edit" href="{{ route('third-party-service.edit',$data->id) }}">
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
      <div class="col-4 text-center">
         {{ $settings->_top_title ?? '' }}
       <h3 class="page-header text-center">
        {{$page_name}}
       </h3>
      </div>
      <div class="col-4">
       <h3 class="page-header">
        <small class="float-right">Date: {!! _view_date_formate($data->_date ?? '') !!}</small>
       </h3>
      </div>

     </div>
     <div class="row">
      <div class="col-3 ">
       <b>Customer:</b>
       <address>
        <strong>{{$data->_ledger->_name ?? '' }}</strong><br>
        Address: {{$data->_address ?? '' }}<br>
        Phone: {{$data->_phone ?? '' }}<br>
        Email: {{$data->_email ?? '' }}
       </address>
      </div>
      <div class="col-6 text-center">
         {{ $settings->_top_title ?? '' }}
       <div style="text-align: center;">
         <h3><img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 50px;width: 50px"  > {{$settings->name ?? '' }}
       
       </h3>
       <div>{{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}</div>
       </div>
       
        
      </div>
      <div class="col-3 ">
       {{ invoice_barcode($data->_order_number ?? '') }}

       <b>Invoice No: {{ $data->_order_number ?? '' }}</b><br>
       <b>Date: {!! _view_date_formate($data->_date ?? '') !!}</b><br>
       <b>Referance:</b> {!! $data->_referance ?? '' !!}<br>
       <b>Account Balance:</b>{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}<br>
       <b>Created By:</b> {!! $data->_user_name ?? '' !!}<br>
       <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
      </div>
     

     </div>

     <div class="row invoice-info">
      

      

      

     </div>


     <div class="row">
      <div class="col-12 table-responsive">
       <table class="table table-striped _grid_table">
        <thead>
         <tr>
           <th class="text-left" style="width: 10%;">SL</th>
          <th class="text-left" style="width: 20%;">Item</th>
          <th class="text-left" style="width: 20%;">Barcode</th>
          <th class="text-right" style="width: 10%;">Qty</th>
          <th class="text-right" style="width: 10%;">Rate</th>
          <th class="text-right" style="width: 10%;">Discount</th>
          <th class="text-right" style="width: 10%;">VAT</th>
          <th class="text-right" style="width: 10%;">Amount</th>
         </tr>
        </thead>
        <tbody>
           @php
          $_master_details = $data->_master_details ?? [];
          @endphp
           @if(sizeof( $_master_details) > 0)
         @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <td class="text-left" >{{($item_key+1)}}.</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
                                           <td class="  " style="word-break: break-all;vertical-align: text-top;">{!! $_item->_items->_name ?? '' !!}
                                            <br>
                                                {!! $_item->_short_note ?? '' !!}
                                           </td>
                                            <td class="  " style="word-break: break-all;vertical-align: text-top;"> @php
                                                $barcode_arrays = explode(',', $_item->_barcode ?? '');
                                                @endphp
                                                @forelse($barcode_arrays as $barcode)
                                              <span style="width: 100%;">{{$barcode}}</span><br>
                                                @empty
                                                @endforelse

                                            </td>
                                            
                                             <td class="text-right  " style="vertical-align: text-top;">{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;">{!! _report_amount($_item->_rate ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;">{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;">{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                            
                                            <td class="text-right  " style="vertical-align: text-top;">{!! _report_amount($_item->_value ?? 0) !!}</td>
                                            
                                            
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                            <tr>
                              <td colspan="3" class="text-right "><b>Total</b></td>
                              <td class="text-right "> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                              <td></td>
                              <td class="text-right "> <b>{{ _report_amount($_total_discount_amount ?? 0) }}</b> </td>
                              <td class="text-right "> <b>{{ _report_amount($_vat_total ?? 0) }}</b> </td>
                              <td class=" text-right"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="4" class="text-left " style="width: 50%;">
                              <table style="width: 100%">
                                <tr>
                                  <td>

                                    {{$settings->_purchse_note ?? '' }}
                                  </td>
                                </tr>
                                <tr>
                                  <td><p class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p></td>
                                </tr>
                                <tr>
                                  <td><p class="lead"> 
                                    Remarks:{{ $data->_note ?? '' }}
                                   </p></td>
                                </tr>
                              </table>
                              </td>
                              
                              <td colspan="4" class=" text-right"  style="width: 50%;">
                                  <table style="width: 100%">
                                     <tr>
                                      <th class="text-right" ><b>Sub Total</b></th>
                                      <th class="text-right">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th class="text-right" ><b>Discount</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th class="text-right" ><b>VAT</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th class="text-right" ><b>Net Total</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total ?? 0) !!}</th>
                                    </tr>
                                     @php
                                    $accounts = $data->_s_account ?? [];
                                    $_due_amount =$data->_total ?? 0;
                                    @endphp
                                    @if(sizeof($accounts) > 0)
                                    @foreach($accounts as $ac_val)
                                    @if($ac_val->_ledger->id !=$data->_ledger_id)
                                     @if($ac_val->_cr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_cr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th class="text-right" ><b> Less:{!! $ac_val->_ledger->_name ?? '' !!}
                                        </b></th>
                                      <th class="text-right">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount +=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th class="text-right" ><b> Add:{!! $ac_val->_ledger->_name ?? '' !!}
                                        </b></th>
                                      <th class="text-right">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th class="text-right" ><b>Invoice Due </b></th>
                                      <th class="text-right">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                    @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <th class="text-right" ><b>Previous Balance</b></th>
                                      <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0))  !!}</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" ><b>Current Balance</b></th>
                                      <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0) ) !!}</th>
                                    </tr>
                                    @endif
                                  </table>

                              </td>
                            </tr>
         @endif
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