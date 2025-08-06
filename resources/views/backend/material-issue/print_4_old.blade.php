@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: silver;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
 <a class="nav-link"  href="{{url('sales')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('sales-edit')
    <a class="nav-link"  title="Edit" href="{{ route('sales.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

  @php
    $_is_header = $form_settings->_is_header ?? 0;
    $_is_footer = $form_settings->_is_footer ?? 0;
    $_margin_top = $form_settings->_margin_top ?? '0px';
    $_margin_bottom = $form_settings->_margin_bottom ?? '0px';
    $_margin_left = $form_settings->_margin_left ?? '0px';
    $_margin_right = $form_settings->_margin_right ?? '0px';
  @endphp
   <div style="width: 100%;margin-bottom: {{$_margin_bottom}};margin-top: {{$_margin_top}};margin-left: {{$_margin_left}};margin-right: {{$_margin_right}}" > 
@if($_is_header ==1 )
     <div class="row">
      <div class="col-4">
       <div style="width: 100%">
        <div style="width: 40%;float: left;">
            <h3><img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 150px;width: 150px"  >  </h3>
        </div>
        <div style="width: 60%;float: left;">
            
        </div>
         
         
       
       </div>
        
      </div>
      <div class="col-4 " style="text-align: center;">
            <h2 style="text-align: center;">{{ $settings->name ?? '' }}</h2>
            <h5 style="text-align: center;">{{ $settings->keywords ?? '' }}</h5>
           <div>{!! $settings->_address ?? '' !!}<br>
            Phone: {{$settings->_phone ?? '' }}<br>
            Email: {{$settings->_email ?? '' }}</div>
      </div>
      <div class="col-4 ">
    </div>
      <div class="col-md-12" >
        <div style="text-align: center;">
          <span style="font-size: 30px;
    font-weight: bold;
    padding: 5px;
    background: #34ce19;
    border-radius: 5px;">Sales Invoice</span> 
        </div>
        
      </div>
     </div>
@endif
  
<table style="width: 100%;"  > 

  <tr>
    <td ><b>Payment Terms: {{ $data->_terms_con->_name ?? '' }}</b></td>

    <td colspan="2">
      <b>
      @php
        $bin = $settings->_bin ?? '';
      @endphp
      @if($bin !='')
      VAT REGISTRATION NO: {{ $settings->_bin ?? '' }}
      @endif
    </b>
    </td>
  </tr>
  
          <tr>
            <td rowspan="6" style="width: 60%;;border: 1px solid silver;">
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 20%;text-align: left;"><b>Customer ID</b></td>
                    
                    <td style="width: 80%;text-align: left;"><b>:{{$data->_ledger->id ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Customer Name</b></td>
                    <td><b>:{{$data->_ledger->_name ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Proprietor</b></td>
                    <td><b>:{{$data->_ledger->_alious ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Cell NO</b></td>
                    <td><b>:{{$data->_phone ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Address</b></td>
                    <td><b>:{{$data->_address ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b></b></td>
                    <td><b></b></td>
                  </tr>
                </table>
            </td>
            <td style="width: 15%;border: 1px solid silver;">Invoice No: </td>
            <td style="width: 25%;border: 1px solid silver;">
              {{ invoice_barcode($data->_order_number ?? '') }}
              {{ $data->_order_number ?? '' }} </td>
          </tr>
          <tr>
            <td style="width: 15%;border: 1px solid silver;">Invoice Type</td>
            <td style="width:25%;border: 1px solid silver;"></td>
          </tr><tr>
            <td style="width: 15%;border: 1px solid silver;">Invoice Date</td>
            <td style="width: 25%;border: 1px solid silver;">{!! _view_date_formate($data->_date ?? '') !!}</td>
          </tr><tr>
            <td style="width: 15%;border: 1px solid silver;">Payment Date</td>
            <td style="width: 25%;border: 1px solid silver;">
              <?php
$date=date_create($data->_date);
$day = $data->_terms_con->_days ?? 0;
date_add($date,date_interval_create_from_date_string("$day days"));
echo _view_date_formate(date_format($date,"Y-m-d"));
?>
            </td>
          </tr><tr>
            <td style="width: 15%;border: 1px solid silver;">Sales By</td>
            <td style="width: 15%;border: 1px solid silver;">{!! $data->_user_name ?? '' !!}</td>
          </tr><tr>
            <td style="width: 15%;border: 1px solid silver;">Sales Order NO</td>
            <td style="width: 15%;border: 1px solid silver;">{!! $data->_order_ref_id ?? '' !!}</td>
          </tr>
        </table>
     

       <table style="width: 100%;" class="">
        
         <tr>
           <th class="text-left" style="width: 5%;border: 1px solid silver;">SL</th>
          <th class="text-left" style="width: 53%;border: 1px solid silver;">Product Name</th>
          <th class="text-left" style="width: 7%;border: 1px solid silver;">Unit</th>
          <th class="text-right" style="width: 7%;border: 1px solid silver;">Qty</th>
          <th class="text-right" style="width: 8%;border: 1px solid silver;">Rate</th>
          <th class="text-right" style="width: 5%;border: 1px solid silver;">Discount</th>
          <th class="text-right" style="width: 5%;border: 1px solid silver;">VAT</th>
          <th class="text-right" style="width: 10%;border: 1px solid silver;">Amount</th>
         </tr>
        
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
                                     <td class="text-left" style="border: 1px solid silver;" >{{($item_key+1)}}.</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
                                          <td class="  " style="word-break: break-all;vertical-align: text-top;border: 1px solid silver;">{!! $_item->_items->_name ?? '' !!}
                                          
                                          

                                            @php 
                                                  $_barcodes_string = $_item->_barcode ?? '';
                                                  $_barcodes_string_length = strlen($_item->_barcode ?? '');
                                                  $_barcodes = explode(",",$_barcodes_string);
                                              @endphp
                                              @if($_barcodes_string_length > 0)
                                              <br>
                                              <b>SN:</b>
                                                  @forelse($_barcodes as $barcode)
                                                    <small >{{$barcode ?? '' }},</small>
                                                  @empty
                                                  @endforelse
                                              @endif
                                              @php
                                         $warenty_name= $_item->_warrant->_name ?? '';
                                          @endphp
                                          @if($warenty_name !='')
                                          <br>
                                         <b>Warranty:</b>  {{ $_item->_warrant->_name ?? '' }}
                                          @endif
                                          </td>
                                          <td class="  " style="word-break: break-all;vertical-align: text-top;border: 1px solid silver;">{!! $_item->_items->_units->_name ?? '' !!}</td>
                                           
                                            
                                             <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                            
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">{!! _report_amount($_item->_value ?? 0) !!}</td>
                                            
                                            
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                            <tr>
                              <td colspan="3" class="text-right " style="border: 1px solid silver;"><b>Total</b></td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_qty_total ?? 0)}}</b> </td>
                              <td style="border: 1px solid silver;"></td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_total_discount_amount ?? 0)}}</b> </td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_vat_total ?? 0)}}</b> </td>
                              <td class=" text-right" style="border: 1px solid silver;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="4" class="text-left " style="width: 50%;">
                              <table style="width: 100%">
                                <tr>
                                  <td>

                                    {{$settings->_sales_note ?? '' }}
                                  </td>
                                </tr>
                                <tr>
                                  <td><p class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p></td>
                                </tr>
                                <tr>
                                  <td>
                                    @include("backend.sales.invoice_history")
                                  </td>
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
                                      <th class="text-right" ><b>Discount[-]</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th class="text-right" ><b>VAT[+]</b></th>
                                      <th class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th class="text-right" ><b>Net Total</b></th>
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
                                      <th class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th class="text-right">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
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
                                      <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" ><b>Current Balance</b></th>
                                      <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</th>
                                    </tr>
                                    @endif
                                  </table>

                              </td>
                            </tr>
         @endif
        </tbody>
        <tfoot>
@if($_is_footer ==1)
               <tr>
                 <td colspan="8">
                    <div class="col-12 mt-5">
                  <div class="row">
                    <div class="col-6 text-left " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;">Customer Signature</span></div>
                    
                    <div class="col-6 text-right " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;"> Authorised Signature</span></div>
                  </div>
                </div>
                 </td>
               </tr> 
@endif
        </tfoot>
       </table>
   
</div>
   

   @endsection

@section('script')

@endsection