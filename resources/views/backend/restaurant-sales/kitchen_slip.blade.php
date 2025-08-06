

<div class="_report_button_header">
 <a class="nav-link"  href="{{url('restaurant-sales')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('restaurant-sales-edit')
    <a class="nav-link"  title="Edit" href="{{ route('restaurant-sales.edit',$data->id) }}">
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
            				 <tr> <td style="border:none;" ><b>Table No:</b> 
                      @forelse($tables as $table)
                      <span>{{$table->_name ?? ''}}</span>
                      @empty
                      @endforelse
                     </td></tr>
                     <tr> <td style="border:none;" ><b>Served By:</b> 
                      @forelse($stewards as $steward)
                      <span>{{$steward->_name ?? ''}}</span>
                      @empty
                      @endforelse
                     </td></tr>
                     <tr> <td style="border:none;" ><b>Customer:</b> {{$data->_ledger->_name ?? '' }}</td></tr>
            			</table>
            		</td>
            		<td colspan="2" style="border: 1px dotted grey;">
            			<table style="text-align: left;">
            				<tr> <td style="border:none;" ><b> Order No:</b> {{ $data->_order_number ?? '' }}</td></tr>
                  <tr> <td style="border:none;" ><b> Date:</b> {{ _view_date_formate($data->_date ?? '') }}</td></tr>
                  <tr> <td style="border:none;" ><b> Time:</b> {{ $data->_time ?? '' }}</td></tr>
            			</table>
            		</td>
            	</tr>
               
               
                <tbody>
                   <tr>
                   	<td style="text-align: left;border:1px dotted grey;">SL</td>
                   	<td style="text-align: left;border:1px dotted grey;">Item</td>
                   	<td style="text-align: right;border:1px dotted grey;">QTY</td>
                   	<td style="text-align: right;border:1px dotted grey;">Kitchen</td>
                   </tr>
                   @php
                                   
                    $_qty_total = 0;
                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                  
                                     @php
                                      $_qty_total += $_item->_qty ?? 0;
                                     @endphp
<td class="text-left" style="border:1px dotted grey;" >{{($item_key+1)}}</td>
<td  class="text-left" style="border:1px dotted grey;">{!! $_item->_items->_name ?? '' !!}</td>
<td  style="border:1px dotted grey;text-align: right;" >{!! _report_amount($_item->_qty ?? 0) !!}</td>
<td  style="border:1px dotted grey;text-align: right;" >{!! selected_yes_no($_item->_kitchen_item ?? 0) !!}</td>
                                  </tr>
                                  @empty
                                  @endforelse
                                   <tr>
                              <td style="border:1px dotted grey;" colspan="2" class="text-right "><b>Sub Total</b></td>

                              <td style="border:1px dotted grey;text-align: right;" class="text-right "> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                              <td style="border:1px dotted grey;"></td>
                              
                            </tr>
   

                   
                
				</tbody>
            </table>
            
        </section>
	

<script type="text/javascript">
  window.print();
</script>