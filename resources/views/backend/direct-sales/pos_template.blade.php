
    
<section onload="window.print();" class="print_invoice" id="printablediv" style="
  padding:0mm;
  
  margin: 0 auto;
  width: 170px;
  background: #FFF;">
		
            <table style="width:100%;border-collapse: collapse;" >
            	<tr>
            		<td colspan="6" style="text-align: center;">
            		    <div style="">
            		       <b style="font-size: .7em;">  {{ $settings->_top_title ?? '' }}</b><br>
                   <img src="{{asset($settings->logo)}}" alt="{{$settings->name ?? '' }}" style="width: 100px;"  ><br>
            			<b><span style="font-size: .7em;">{{ $settings->name ?? '' }}</span></b><br>
            			<div style="font-size: .7em;">
		         {!! $settings->_address ?? '' !!}<br>
		        {{$settings->_phone ?? '' }}<br>
		        {{$settings->_email ?? '' }}
		        </div>
		        <b style="font-size: .7em;">Invoice/Bill</b>
            		    </div>
            			 
            		</td>
            	</tr>
                <tr>
               
                <td colspan="6" style="border:1px solid #000;">
                  <table style="text-align: left;">
                    <tr> <td style="border:none;" > {{ invoice_barcode($data->_order_number ?? '') }}</td></tr>
                    <tr> <td style="border:none;font-size:0.7em;" > Invoice No: {{ $data->_order_number ?? '' }}</td></tr>
                  <tr> <td style="border:none;font-size:0.7em;" > Date: {{ _view_date_formate($data->_date ?? '') }}</td></tr>
                  </table>
                </td>
              </tr>
            	<tr>
            		<td colspan="6" style="text-align: left;border:1px solid #000;">
            			<table style="">
            				 <tr> <td style="border:none;font-size:0.7em;" > Customer: @if($form_settings->_defaut_customer ==$data->_ledger_id)
                      {{ $data->_referance ?? $data->_ledger->_name }}
                  @else
                  {{$data->_ledger->_name ?? '' }}
                  @endif</td></tr>
            				
			                <tr> <td style="border:none;font-size:0.7em;" >Phone:{{$data->_phone ?? '' }} </td></tr>
			                <tr> <td style="border:none;font-size:0.7em;" >Address:{{$data->_address ?? '' }} </td></tr>
            			</table>
            		</td>
            	
            	</tr>
               
               
                <tbody>
                  <tr>
           <th  style="width: 5%;border:1px solid #000;font-size:0.7em;">##</th>
          <th  style="width: 65%;border:1px solid #000;font-size:0.7em;">Item</th>
          <th  style="width: 10%;border:1px solid #000;font-size:0.7em;">Qty</th>
          <th  style="width: 10%;border:1px solid #000;font-size:0.7em;">Rate</th>
          <th  style="width: 10%;border:1px solid #000;font-size:0.7em;">Amount</th>
         </tr>
        </thead>
        <tbody>
           @if(sizeof($_master_detail_reassign) > 0)
         @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                    $id=1;
                                  @endphp
                                  @forelse($_master_detail_reassign AS $item_key=>$_item )
                                  <tr>
                                     <td style="font-size: .7em;color: #000;line-height: 1.2em; border:1px solid #000;vertical-align:top;" >{{($id)}}.</td>

                                    

                              @if(sizeof($_item) > 0)
                                     
                                          <td style="font-size: .7em;color: #000;line-height: 1.2em; border:1px solid #000;vertical-align:top;">
                                            
                                           
                              @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                    @php
                                      $_value_total +=$in_itemVal_multi->_value ?? 0;
                                      $_vat_total += $in_itemVal_multi->_vat_amount ?? 0;
                                      $_qty_total += $in_itemVal_multi->_qty ?? 0;
                                      $_total_discount_amount += $in_itemVal_multi->_discount_amount ?? 0;
                                     @endphp
                                     @if($_in_item_key==0)
                                            {!! $in_itemVal_multi->_items->_name ?? '' !!} 
                                    @endif
                                          @empty
                                    @endforelse 


                                          </td>
                                           
                                            
                                             <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;">
                          @php
                           $row_qty =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_qty +=($in_itemVal_multi->_qty ?? 0);
                             @endphp
                          @empty
                          @endforelse

                                   {!! _report_amount($row_qty ?? 0) !!}
                                   <br>
                                   @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                  {!! _find_unit($in_itemVal_multi->_transection_unit ?? '') !!}
                              @endif
                              @empty
                              @endforelse
                                            </td>
                                            <td style="font-size: .7em;color: #000;line-height: 1.2em; border:1px solid #000;vertical-align:top;text-align:right;">
                             @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_sales_rate ?? 0) !!}
                              @endif
                              @empty
                              @endforelse
                                              
                                            </td>
                                          
                                            
                                            <td style="font-size: .7em;color: #000;line-height: 1.2em; border:1px solid #000;vertical-align:top;text-align:right;">
                            @php
                           $row__value =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row__value +=($in_itemVal_multi->_value ?? 0);
                             @endphp
                          @empty
                          @endforelse



                                              {!! _report_amount($row__value ?? 0) !!}</td>
                                            
                                            
                                    
                              @endif
                                         
                                  </tr>
                                  @php
                                  $id++;
                                  @endphp


                                  @empty
                                  @endforelse
                            <tr>
                              <td colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em; border:1px solid #000;vertical-align:top;"><b>Total</b></td>
                              <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;"> <b>{{ _report_amount($_qty_total ?? 0)}}</b> </td>
                              <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;"></td>
                              
                              <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                             
                                      <th colspan="3" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b>Sub Total</b></th>
                                      <th colspan="2" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th colspan="3" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b>Discount[-]</b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b>VAT[+]</b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b>Net Total</b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;">{!! _report_amount($data->_total ?? 0) !!}</th>
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
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;" ><b>Invoice Due </b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid #000;vertical-align:top;text-align:right;">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                  
                            </tr>
                            <tr>
                                  <td  colspan="5"  style="font-size: .7em;"><p class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p></td>
                                </tr>
                                 <tr>
                                  <td  colspan="5"  style="font-size: .7em;">

                                    {{$settings->_sales_note ?? '' }}
                                  </td>
                                </tr>
                                <tr>
                                  <td  colspan="5" >
                                    @include("backend.sales.invoice_history")
                                  </td>
                                </tr>
         @endif

                   
                
				</tbody>
            </table>
            
        </section>
	

<script type="text/javascript">
  window.print();
</script>