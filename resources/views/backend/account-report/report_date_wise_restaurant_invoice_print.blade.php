@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
    border: 1px solid silver;
} 
.table td {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
     border: 1px solid silver;
}

}

  </style>
<div class="_report_button_header">
 <a class="nav-link"  href="{{url('date-wise-restaurant-invoice-print')}}" role="button"><i class="fas fa-search"></i></a>

    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">


     
@forelse($datas as $data)

     
       <table class="table table-striped" style="width: 100%;">
        <thead style="background: #fff;color: #000;border:0px">
         <tr style="border:0px">
           <td colspan="7" style="border:0px">
            <div style="width: 100%;text-align: center;">
              {{ $settings->_top_title ?? '' }}<br>
              <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 50px;width: 50px;"  > {{$settings->title ?? '' }}
             <address>
               {{$settings->_address ?? '' }}<br>
                {{$settings->_phone ?? '' }} {{$settings->_email ?? '' }}<br>
                <b> Invoice/Bill</b>
               </address>
            </div>
            
           </td>
         </tr>
         <tr style="border:0px">
           <td colspan="3" class="text-left" style="border:1px solid silver;">
            <b> Customer:</b>
             <address>
              <strong>Name: </strong>{{$data->_ledger->_name ?? '' }}<br>
              <strong>Address: </strong>{{$data->_address ?? 'N/A' }}<br>
              <strong>Phone: </strong> {{$data->_phone ?? 'N/A' }}<br>
              <strong>Email: </strong> {{$data->_email ?? 'N/A' }}
             </address>
           </td>
           <td colspan="4" class="text-right" style="border:1px solid silver;">
             <b>Invoice/Bill No:</b> {{ $data->_order_number ?? '' }}<br>
             <b>Date:</b> {!! _view_date_formate($data->_date ?? '') !!}<br>
             <b>Referance:</b> {!! $data->_referance ?? '' !!}<br>
             <b>Sales By:</b> {!! $data->_sales_man->_name ?? 'N/A' !!}<br>
             <b>Delivered by:</b> {!! $data->_delivery_man->_name ?? 'N/A' !!}<br>
             <b>Created By:</b> {!! $data->_user_name ?? '' !!}<br>
             <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
           </td>
         </tr>
        </thead>
        <tbody>
          <tr>
          <th class="text-left" style="border:1px solid silver;">SL</th>
          <th class="text-left" style="border:1px solid silver;">Item</th>
          <th class="text-right" style="border:1px solid silver;">Qty</th>
          <th class="text-right" style="border:1px solid silver;">Rate</th>
          <th class="text-right" style="border:1px solid silver;">Discount</th>
          <th class="text-right" style="border:1px solid silver;">VAT</th>
          <th class="text-right" style="border:1px solid silver;">Amount</th>
         </tr>
           @if(sizeof($data->_master_details) > 0)
         @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr style="border:1px solid silver;">
                                     <td class="text-left" style="border:1px solid silver;">{{($item_key+1)}}.</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
                                            <td class="  " style="border:1px solid silver;">{!! $_item->_items->_name ?? '' !!}</td>
                                            
                                           <td class="text-right  " style="border:1px solid silver;">{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            <td class="text-right  " style="border:1px solid silver;">{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                            <td class="text-right  " style="border:1px solid silver;">{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
                                            <td class="text-right  " style="border:1px solid silver;">{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                            
                                            <td class="text-right  " style="border:1px solid silver;">{!! _report_amount($_item->_value ?? 0) !!}</td>
                                            
                                            
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                            <tr style="border:1px solid silver;">
                              <td style="border:1px solid silver;" colspan="2" class="text-left "><b>Total</b></td>
                              <td style="border:1px solid silver;" class="text-right "> <b>{{_report_amount( $_qty_total ?? 0)}}</b> </td>
                              <td style="border:1px solid silver;"></td>
                              <td style="border:1px solid silver;" class="text-right "> <b>{{_report_amount( $_total_discount_amount ?? 0) }}</b> </td>
                              <td style="border:1px solid silver;" class="text-right "> <b>{{ _report_amount($_vat_total ?? 0) }}</b> </td>
                              <td style="border:1px solid silver;" class=" text-right"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr style="border:1px solid silver;">
                              <td colspan="3" class="text-left " style="width: 50%;border:0px;">
                              <table style="width: 100%;border:0px;">
                                <tr style="border:0px;">
                                  <td style="border:0px;">

                                    {{$settings->_sales_note ?? '' }}
                                  </td>
                                </tr>
                                <tr style="border:0px;">
                                  <td style="border:0px;"><small class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </small></td>
                                </tr>
                              </table>
                              </td>
                              
                              <td colspan="4" class=" text-right"  style="width: 50%;border:1px solid silver;">
                                  <table style="width: 100%">
                                     <tr>
                                      <th class="text-left" ><b>Sub Total</b></th>
                                      <th class="text-right">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th class="text-left" ><b>Discount[-]</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th class="text-left" ><b>VAT[+]</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th class="text-left" ><b>Net Total</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total ?? 0) !!}</th>
                                    </tr>
                                    @php
                                    $accounts = $data->s_account ?? [];
                                    $_due_amount =$data->_total ?? 0;
                                    @endphp
                                    @if(sizeof($accounts) > 0)
                                    @foreach($accounts as $ac_val)
                                    @if($ac_val->_ledger->id !=$data->_ledger_id)
                                     @if($ac_val->_cr_amount > 0)
                                     @php
                                      $_due_amount +=$ac_val->_cr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th class="text-left" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th class="text-right">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th class="text-left" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[-]
                                        </b></th>
                                      <th class="text-right">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th class="text-left" ><b>Invoice Due </b></th>
                                      <th class="text-right">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                    @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <th class="text-left" ><b>Previous Balance</b></th>
                                      <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</th>
                                    </tr>
                                    <tr>
                                      <th class="text-left" ><b>Current Balance</b></th>
                                      <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</th>
                                    </tr>
                                    @endif
                                  </table>

                              </td>
                            </tr>
         @endif
        </tbody>
        <tfoot>

               <tr>
                 <td colspan="7">
                    @include('backend.message.invoice_footer')
                 </td>
               </tr> 
        </tfoot>
       </table>
      <p style="page-break-after: always;">&nbsp;</p>
<!-- <p style="page-break-before: always;">&nbsp;</p> -->
      
@empty
@endforelse

   

   @endsection

