



<section class="invoice" id="printablediv" style="">
		
            <table class="table" style="border-collapse: collapse;width:100%;margin:0px auto;">
            	<tr>
            		<td colspan="6" style="text-align: center;">
            			  {{ $settings->_top_title ?? '' }}<br>
                   <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 150px"  ><br>
            			<strong>{{ $settings->name ?? '' }}</strong><br>
		         {{$settings->_address ?? '' }}<br>
		        {{$settings->_phone ?? '' }}<br>
		        {{$settings->_email ?? '' }}<br>
            @php
        $bin = $settings->_bin ?? '';
      @endphp
      @if($bin !='')
      VAT REGISTRATION NO: {{ $settings->_bin ?? '' }}<br>
      @endif
		        <b>Invoice/Bill</b>
            		</td>
            	</tr>
                <tr>
               
                <td colspan="6" style="border: 1px dotted grey;">
                  <table style="text-align: left;">
                    <tr> <td style="border:none;" > {{ invoice_barcode($data->_order_number ?? '') }}</td></tr>
                    <tr> <td style="border:none;" > Invoice No: {{ $data->_order_number ?? '' }}</td></tr>
                  <tr> <td style="border:none;" > Date: {{ _view_date_formate($data->_date ?? '') }}</td></tr>
                  </table>
                </td>
              </tr>
            	<tr>
            		<td colspan="6" style="text-align: left;border: 1px dotted grey;">
            			<table style="">
            				 <tr> <td style="border:none;" > <b>Ledger Name:</b> @if($form_settings->_defaut_customer ==$data->_ledger_id)
                      {{ $data->_referance ?? $data->_ledger->_name }}
                  @else
                  {{$data->_ledger->_name ?? '' }}
                  @endif</td></tr>
            				
			                <tr> <td style="border:none;" >Phone:{{$data->_phone ?? '' }} </td></tr>
			                <tr> <td style="border:none;" >Address:{{$data->_address ?? '' }} </td></tr>
            			</table>
            		</td>
            	
            	</tr>
               
               
                <tbody>
                  <tr>
           <th class="text-center" style="width: 5%;border: 1px solid silver;">SL</th>
          <th class="text-left" style="width: 53%;border: 1px solid silver;">Item</th>
          <th class="text-center" style="width: 7%;border: 1px solid silver;">Unit</th>
          <th class="text-center" style="width: 7%;border: 1px solid silver;">Qty</th>
          <th class="text-center" style="width: 8%;border: 1px solid silver;">Rate</th>
          <th class="text-center" style="width: 5%;border: 1px solid silver;display: none;">Discount</th>
          <th class="text-center " style="width: 5%;border: 1px solid silver;display: none;">VAT</th>
          <th class="text-center" style="width: 10%;border: 1px solid silver;">Amount</th>
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
                                     <td class="text-center" style="border: 1px solid silver;vertical-align:top;" >{{($id)}}.</td>

                                    

                              @if(sizeof($_item) > 0)
                                     
                                          <td class="  " style="word-break: break-all;vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                                            
                                           
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



                                    @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                            @php 
                                                  $_barcodes_string = $in_itemVal_multi->_barcode ?? '';
                                                  $_barcodes_string_length = strlen($in_itemVal_multi->_barcode ?? '');
                                                  $_barcodes = explode(",",$_barcodes_string);
                                              @endphp
                                              @if($_barcodes_string_length > 0)
                                              
                                              @if($_in_item_key==0)<br> <b>SN:</b> @endif
                                                  @forelse($_barcodes as $barcode)
                                                    <small >{{$barcode ?? '' }},</small>
                                                  @empty
                                                  @endforelse
                                              @endif

                                  @empty
                                    @endforelse

                                      @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                      @if($_in_item_key==0)
                                              @php
                                         $warenty_name= $in_itemVal_multi->_warrant->_name ?? '';
                                          @endphp

                                          @if($warenty_name !='')
                                          <br>
                                         <b>Warranty:</b>  {{ $in_itemVal_multi->_warrant->_name ?? '' }}
                                          @endif
                                    @endif

                                          @empty
                                    @endforelse
                                          </td>
                                          <td class="text-center  " style="white-space:nowrap;vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                             @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                  {!! $in_itemVal_multi->_items->_units->_name ?? '' !!}
                              @endif
                              @empty
                              @endforelse
                                        </td>
                                           
                                            
                                             <td class="text-center  " style="vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
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
                                            </td>
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                             @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_sales_rate ?? 0) !!}
                              @endif
                              @empty
                              @endforelse
                                              
                                            </td>
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;vertical-align:top;display: none;">
                            @php
                           $row_discount_amount =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_discount_amount +=($in_itemVal_multi->_discount_amount ?? 0);
                             @endphp
                          @empty
                          @endforelse

                                  {!! _report_amount($row_discount_amount ?? 0) !!}

                                            </td>
                                            <td class="text-right display_none " style="vertical-align: text-top;border: 1px solid silver;display: none;">
                            @php
                           $row_vat_amount =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_vat_amount +=($in_itemVal_multi->_vat_amount ?? 0);
                             @endphp
                          @empty
                          @endforelse
                                              {!! _report_amount($row_vat_amount ?? 0) !!}

                                            </td>
                                            
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">
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
                              <td colspan="3" class="text-right " style="border: 1px solid silver;"><b>Total</b></td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_qty_total ?? 0)}}</b> </td>
                              <td style="border: 1px solid silver;"></td>
                              <td class="text-right " style="border: 1px solid silver;display: none;"> <b>{{ _report_amount($_total_discount_amount ?? 0)}}</b> </td>
                              <td class="text-right display_none" style="border: 1px solid silver;display: none;"> <b>{{ _report_amount($_vat_total ?? 0)}}</b> </td>
                              <td class=" text-right" style="border: 1px solid silver;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-left " style="width: 50%;border:1px solid silver;">
                              <table style="width: 100%;border-collapse: collapse;">
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
                              
                              <td colspan="5" class=" text-right"  style="width: 50%;">
                                  <table style="width: 100%;border-collapse: collapse;">
                                     <tr >
                                      <th style="border:1px solid silver;" class="text-right" ><b>Sub Total</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Discount[-]</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>VAT[+]</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Net Total</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_total ?? 0) !!}</th>
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
                                      <th style="border:1px solid silver;" class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Invoice Due </b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                    @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Previous Balance</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</th>
                                    </tr>
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Current Balance</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</th>
                                    </tr>
                                    @endif
                                  </table>

                              </td>
                            </tr>
         @endif

                   
                
				</tbody>
            </table>
            
        </section>
	

<script type="text/javascript">
  window.print();
</script>