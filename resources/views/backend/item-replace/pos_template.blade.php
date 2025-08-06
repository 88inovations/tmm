

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

<section class="invoice" id="printablediv" style="">
		
            <table class="table" style="border-collapse: collapse;">
            	<tr>
            		<td colspan="5" style="text-align: center;">
            			{{ $settings->_top_title ?? '' }}<br>
            			<strong>{{ $settings->name ?? '' }}</strong><br>
		         {{$settings->_address ?? '' }}<br>
		        {{$settings->_phone ?? '' }}<br>
		        {{$settings->_email ?? '' }}<br>
		        <b>{{$page_name}}</b>
            		</td>
            	</tr>
            	<tr>
            		<td colspan="3" style="text-align: left;border: 1px dotted grey;">
            			<table style="">
            				 <tr> <td style="border:none;" > <b>Customer:</b></td></tr>
            				 <tr> <td style="border:none;" > {{$data->_ledger->_name ?? '' }}</td></tr>
			                <tr> <td style="border:none;" >Phone:{{$data->_phone ?? '' }} </td></tr>
			                <tr> <td style="border:none;" >Address:{{$data->_address ?? '' }} </td></tr>
            			</table>
            		</td>
            		<td colspan="2" style="border: 1px dotted grey;">
            			<table style="text-align: left;">
            				<tr> <td style="border:none;" > Invoice No: {{ $data->_order_number ?? '' }}</td></tr>
                  <tr> <td style="border:none;" > Date: {{ _view_date_formate($data->_date ?? '') }}</td></tr>
            			</table>
            		</td>
            	</tr>
               
               
                <tbody>
                   <tr>
                   	<td style="text-align: left;border:1px dotted grey;">SL</td>
                   	<td style="text-align: left;border:1px dotted grey;">Item</td>
                   	<td style="text-align: right;border:1px dotted grey;">QTY</td>
                   	<td style="text-align: right;border:1px dotted grey;">Rate</td>
                   	<td style="text-align: right;border:1px dotted grey;">Amount</td>
                   </tr>
                   @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                  
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
<td class="text-left" style="border:1px dotted grey;" >{{($item_key+1)}}</td>
<td  class="text-left" style="border:1px dotted grey;">{!! $_item->_items->_name ?? '' !!}</td>
<td  style="border:1px dotted grey;text-align: right;" >{!! _report_amount($_item->_qty ?? 0) !!}</td>
<td  style="border:1px dotted grey;text-align: right;">{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
<td  style="border:1px dotted grey;text-align: right;" >{!! _report_amount($_item->_value ?? 0) !!}</td>
                                  </tr>
                                  @empty
                                  @endforelse
                                   <tr>
                              <td style="border:1px dotted grey;" colspan="2" class="text-right "><b>Sub Total</b></td>

                              <td style="border:1px dotted grey;text-align: right;" class="text-right "> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                              <td style="border:1px dotted grey;text-align: right;"></td>
                              <td style="border:1px dotted grey;text-align: right;" class=" text-right"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
   
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>Discount[-]</b></td>
  <td  style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</td>
</tr>

@if($form_settings->_show_vat==1)
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>VAT[+]</b></td>
  <td style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</td>
</tr>
@endif
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>Net Total</b></td>
  <td style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount($data->_total ?? 0) !!}</td>
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
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
    </b></td>
  <td style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</td>
</tr>
@endif
@if($ac_val->_dr_amount > 0)
 @php
  $_due_amount -=$ac_val->_dr_amount ?? 0;
 @endphp
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right"><b> {!! $ac_val->_ledger->_name ?? '' !!}[-]
    </b></td>
  <td style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</td>
</tr>
@endif

@endif
@endforeach
@if($_due_amount >= 0)
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>Invoice Due </b></td>
  <td style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount( $_due_amount) !!}</td>
</tr>
@else
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>Advance </b></td>
  <td style="border:1px dotted grey;text-align: right;" class="text-right">{!! _report_amount( -($_due_amount)) !!}</td>
</tr>
  
  @endif

@endif
@if($form_settings->_show_p_balance==1)
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>Previous Balance</b></td>
  <td  style="border:1px dotted grey;text-align: right;" class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</td>
</tr>
<tr>
  <td style="border:1px dotted grey;" colspan="4" class="text-right" ><b>Current Balance</b></td>
  <td style="border:1px dotted grey;text-align: right;"class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</td>
</tr>
@endif
<tr>
  <td style="border:1px dotted grey;" colspan="5" class="text-left" >In Words:  {{ nv_number_to_text($data->_total ?? 0) }}</td>
</tr>

<tr>
  <td style="border:1px dotted grey;" colspan="5" class="text-left" >  {{$settings->_sales_note ?? '' }}</td>
</tr>
<tr>
  <td colspan="5">
    @include("backend.sales.invoice_history")
  </td>
</tr>

                   
                
				</tbody>
            </table>
            
        </section>
	

<script type="text/javascript">
  window.print();
</script>