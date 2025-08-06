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
 <a class="nav-link"  href="{{url('material-issue')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('material-issue-edit')
    <a class="nav-link"  title="Edit" href="{{ route('material-issue.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
   <div class="container-fluid">
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
      <div class="col-12 text-center">
       <!--<h3 class="page-header">-->
       <!-- <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 60px"  > {{$settings->title ?? '' }}-->
       <!-- <small class="float-right">Date: {!! _view_date_formate($data->_date ?? '') !!}</small>-->
       <!--</h3>-->
       <address>
        <strong>{{$settings->name ?? '' }}</strong><br>
        {{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}<br>
        <b>Sales Invoice</b>
       </address>
      </div>

     </div>
     @endif

     <div class="row invoice-info">
      

      <div class="col-sm-8 invoice-col">
       <b>Ledger:</b>
       <address>
        <strong>
         @if($form_settings->_defaut_customer ==$data->_ledger_id)
                     {{ $data->_referance ?? $data->_ledger->_name }}
                  @else
                  {{$data->_ledger->_name ?? '' }}
                  @endif
                </strong><br>
        {{$data->_address ?? '' }}<br>
        Phone: {{$data->_phone ?? '' }}<br>
        Email: {{$data->_email ?? '' }}
       @php
        $bin = $settings->_bin ?? '';
      @endphp
      @if($bin !='')
      <br>
      
      @endif
       </address>
      </div>

      <div class="col-sm-4 invoice-col ">
         {{ invoice_barcode($data->_order_number ?? '') }}
       <b>Invoice No: {{ $data->_order_number ?? '' }}</b><br>
       <b >Date: {!! _view_date_formate($data->_date ?? '') !!}</b><br>
       <b>Referance:</b> {!! $data->_referance ?? '' !!}<br>
       <b>Created By:</b> {!! $data->_user_name ?? '' !!}<br>
       
      
      </div>

     </div>


     <div class="row">
      <div class="col-12 table-responsive">
       <table class="table table-striped _grid_table">
        <thead>
         <tr>
          <th class="text-left" style="width: 5%;">SL</th>
          <th class="text-left" style="width: 55%;">Product Description</th>
          <th class="text-left" style="width: 10%;">Unit</th>
          <th class="text-right" style="width: 10%;">Qty</th>
          <th class="text-right" style="width: 10%;">Rate</th>
          <th class="text-right" style="width: 10%;">Amount</th>
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
                                     <td class="text-left" style="vertical-align: top;">{{($item_key+1)}}.</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
                                             <td class="  " style="word-break: break-all;vertical-align: text-top;border:1px solid silver;" >{!! $_item->_items->_name ?? '' !!}<br>
                                             
                                              @php 
                                                  $_barcodes_string = $_item->_barcode ?? '';
                                                  $_barcodes_string_length = strlen($_item->_barcode ?? '');
                                                  $_barcodes = explode(",",$_barcodes_string);
                                              @endphp
                                              @if($_barcodes_string_length > 0)
                                              <b>SN:</b>
                                                  @forelse($_barcodes as $barcode)
                                                    <span>{{$barcode ?? '' }},</span>
                                                  @empty
                                                  @endforelse
                                              @endif

                                             </td>

                                            
                                             <td class="text-left  " style="vertical-align: text-top;border:1px solid silver;">{!! $_item->_trans_unit->_name ?? '' !!}</td>
                                            
                                             <td class="text-right  " style="vertical-align: text-top;border:1px solid silver;">{!! _report_amount($_item->_qty ?? 0) !!}</td>
                                            <td class="text-right  " style="vertical-align: text-top;border:1px solid silver;">{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                            
                                            <td class="text-right  " style="vertical-align: text-top;border:1px solid silver;">{!! _report_amount($_item->_value ?? 0) !!}</td>
                                            
                                            
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                            <tr>
                              <td colspan="3" class="text-right "><b>Total</b></td>
                              <td class="text-right "> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                              <td></td>
                              <td class=" text-right"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-left " style="width: 50%;">
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
                                      <th class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[-]
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

               <tr>
                 <td colspan="6">
                  @if($_is_footer ==1)
                    @include('backend.message.invoice_footer')
                  @endif
                 </td>
               </tr> 
        </tfoot>
       </table>
      </div>
</div>

</div>
</div>
   </section>

   @endsection

@section('script')


@endsection