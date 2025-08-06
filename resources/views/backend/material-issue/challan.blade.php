

<style type="text/css">
  .border_top_2{
    border-top: 1px solid silver;
  }
</style>

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
            <b>CHALLAN/BILL</b>
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
                     <tr> <td style="border:none;" > <b>{{__('label._cost_center_id')}}:</b> 
                  {{$data->_master_cost_center->_name ?? '' }}
                  </td>
                </tr>
                    
                      <tr> <td style="border:none;" ><b>Phone:</b> {{$data->_phone ?? '' }} </td></tr>
                      <tr> <td style="border:none;" ><b>Address:</b> {{$data->_address ?? '' }} </td></tr>
                      <tr> <td style="border:none;" ><b>{{__('label._delivery_details')}}:</b> {!! $data->_delivery_details ?? '' !!} </td></tr>
                  </table>
                </td>
              
              </tr>
               
               
                <tbody>
                  <tr>
           <th class="text-center" style="width: 5%;border: 1px solid silver;">SL</th>
          <th class="text-left" style="width: 53%;border: 1px solid silver;">Item</th>
          <th class="text-center" style="width: 7%;border: 1px solid silver;">Unit</th>
          <th class="text-center" style="width: 7%;border: 1px solid silver;">Qty</th>
          
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
                              
                            </tr>
                           
         @endif

                 <tr>
                   <td colspan="4" style="height:60px;"></td>
                 </tr> 

                 <tr>
                   <td colspan="4">
                     <table style="width:100%;">
                       <tr>
                   <td style="width:25%;text-align: center;"><span class="border_top_2" >Received By</span></td>
                   <td style="width:25%;text-align: center;"><span class="border_top_2" >Prepared By</span></td>
                   <td style="width:25%;text-align: center;"><span class="border_top_2" >Checked By</span></td>
                   <td style="width:25%;text-align: center;"><span class="border_top_2" >Approved By</span></td>
                 </tr>
                     </table>
                   </td>
                 </tr> 

 
                
        </tbody>
            </table>
            
   
        </section>
  

<script type="text/javascript">
  window.print();
</script>