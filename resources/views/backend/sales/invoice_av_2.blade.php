
<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
   <link rel="stylesheet" href="{{asset('css/print_css.css?v=1.22')}}">
  <!-- Site Title -->
  <title>{{$page_name ?? '' }}</title>

</head>


<body >




 <div style="page-break-after: always;width: 210mm;margin: 0px auto;">
  <table class="table" style="width:100%;border-collapse: collapse;">
    <thead>
      <tr>
        <td colspan="10" style="padding-bottom: 10px;">
          <div style="width: 100%;position: relative;">
            <div class="logo_araa">
               <img src="{{url($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 110px;margin-top:0px;"  >
            </div>
            <div class="company_name_area">
               <div style="padding-right: 10px;">
                 <div class="company_name_title">{{$settings->title ?? '' }}</div>
               <div class="company_sub_title">{{$settings->keywords ?? '' }}</div><br>
               <div class="invoice_title_area">
                 <span class="invoice_title">SALES INVOICE</span>
               </div>
               </div>
            </div>
            <div class="company_address_area">
              <div style="padding-left: 20px;">
                 <div class="head_office" style="">Corporate Office</div>
               <div style="font-size:12px;">
                <span> {{$settings->_address ?? '' }}</span><br>
                  <span>{{$settings->_phone ?? '' }}</span><br>
                 <span> {{$settings->_email ?? '' }}</span>  
               </div><br>

               <div class="page_copy_araa" style="margin-top:7px;">
                 <span class="page_copy_title">
                 
Office Copy
                  
                   
                 </span>
               </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
       <tr>
        <td colspan="5"> <span class="class="@if($data->_terms_con->id==1) _required @endif ""></span> Payment Terms: {!! $data->_terms_con->_detail ?? '' !!}</td>
        @php
        $_days = $data->_terms_con->_days ?? 0;
        @endphp
        <td colspan="5" style="text-align:right;white-space: nowrap;">
          Vat Registration No.- {!! $settings->_bin ?? '' !!}
        </td>
      </tr>
      <tr>
        <td colspan="6"  style="border: 1px solid #56585bc2;vertical-align: top;">
          
         <table style="width:100%;border-collapse:collapse;font-size: 12px;">
            <tr>
              <td colspan="2" style="width:100%;"> <span class="ledger_info_header">Customer's Informations</span></td>
            </tr>
            <tr>
              <td style="width:20%;">{{__('label._branch_id')}}</td>
              <td style="width:80%;">: {!! $data->_master_branch->_name ?? ''  !!}</td>
            </tr>
            <tr>
              <td style="width:20%;">{{__('label._customer_id')}}</td>
              <td style="width:80%;">: {{$data->_ledger->_code ?? $data->_ledger->id }}</td>
            </tr>
            <tr>
              <td style="width:20%;">{{__('label._customer_name')}}  </td>
              <td style="width:80%;">: {{$data->_ledger->_name ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:20%;">{{__('label.Proprietor_Name')}}  </td>
              <td style="width:80%;">: {{$data->_ledger->_alious ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:20%;">{{__('label.Cell_Phone_No')}}  </td>
              <td style="width:80%;">: {{$data->_phone ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:20%;">{{__('label._address')}}   </td>
              <td style="width:80%;">: {{$data->_address ?? '' }}</td>
            </tr>
          </table>
        </td>
       
        <td colspan="4" style="border: 1px solid #56585bc2;">
          <table style="width:100%;border-collapse:collapse;font-size: 12px;">
            <tr>
              <td style="width:35%;border-bottom: 1px solid #56585bc2;">Sales Order No</td>
              <td style="width:75%;border-bottom: 1px solid #56585bc2;">: {{ $data->_order_ref_id ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:35%;border-bottom: 1px solid #56585bc2;">Sales Invoice No</td>
              <td style="width:75%;border-bottom: 1px solid #56585bc2;">: {{ $data->_order_number ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:35%;border-bottom: 1px solid #56585bc2;">Sales Invoice Type</td>
              <td style="width:75%;border-bottom: 1px solid #56585bc2;">:<span class="@if($data->_terms_con->id==1) _required @endif "> {{ $data->_terms_con->_name ?? '' }} </span></td>
            </tr>
            <tr>
              <td style="width:35%;border-bottom: 1px solid #56585bc2;">Sales Invoice Date</td>
              <td style="width:75%;border-bottom: 1px solid #56585bc2;">: {!! _view_date_formate($data->_date ?? '') !!}</td>
            </tr>
            <tr>
              <td style="width:35%;border-bottom: 1px solid #56585bc2;">Payment Date</td>
              <td style="width:75%;border-bottom: 1px solid #56585bc2;">: {{ _view_date_formate($data->payment_date ?? '') }}</td>
            </tr>
            <tr>
              <td style="width:35%;border-bottom: 1px solid #56585bc2;">Sales Person</td>
              <td style="width:75%;border-bottom: 1px solid #56585bc2;">: {{ $data->_sales_man->_name ?? '' }}</td>
            </tr>
            
            
            <tr>
              <td style="width:45%;">Purchase Order No.</td>
              <td style="width:60%;">:{{ $data->_referance ?? '' }}</td>
            </tr>
          </table>
        </td>
      </tr>
    </thead>

    <tbody style="">
     
      <tr>
          <td colspan="10" style="border:none;height:5px;"></td>
      </tr>
       <tr>
          <th style="border:1px solid #56585bc2;width: 5%;font-size:12px;" class="text-center">SL</th>
          <th style="border:1px solid #56585bc2;width: 30%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Name of Products</th>
          <th style="border:1px solid #56585bc2;width: 10%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Pack Size </th>
          <th style="border:1px solid #56585bc2; width: 8%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Sales Qty</th>
          <th style="border:1px solid #56585bc2; width: 7%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">{{__('label._is_free')}}</th>
          <th style="border:1px solid #56585bc2; width: 8%;font-size:12px;text-align:center;white-space: nowrap;" class="text-center">Trade Price</th>
          <th style="border:1px solid #56585bc2; width: 10%;font-size:12px;white-space: nowrap;" class="text-center">Total Amount</th>
          <th colspan="2" style="border:1px solid #56585bc2; width: 10%;font-size:12px;text-align:center;white-space: nowrap;" class="text-right">Cash Discount</th>
          <th  style="border:1px solid #56585bc2; width: 15%;font-size:12px;text-align:center;white-space: nowrap;" class="text-right">Net Amount</th>
         </tr>

          @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                    $_gross_net_total = 0;
                                    $key =1;
                                  @endphp

           
         @php
$_master_details_news = $data->_master_details_new ?? [];
$qty_sum=0;
$number_of_items = sizeof($_master_details_news);
$add_new_row = 20-$number_of_items;
         @endphp
@forelse($_master_detail_reassign AS $item_key=>$_item )
 @php
                                      $_value_total +=$val->_value ?? 0;
                                      $_vat_total += $val->_vat_amount ?? 0;
                                      $_qty_total += $val->_qty ?? 0;
                                      $_total_discount_amount += $val->_discount_amount ?? 0;
                                      $_gross_net_total  += (($val->_value ?? 0)- ($val->_discount_amount ?? 0));
                                     @endphp
         <tr>
          @if(sizeof($_item) > 0)
          <td style="border-right:1px solid #56585bc2;border-left:1px solid #56585bc2;width: 5%;text-align: center;font-size:12px;padding:4px;" class="text-center">{{($key)}}</td>
          <td style="border-right:1px solid #56585bc2;width: 30%;text-align: left;font-size:12px;padding:4px;" class="text-left">
            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                    @php
                                      $_value_total +=$in_itemVal_multi->_value ?? 0;
                                      $_vat_total += $in_itemVal_multi->_vat_amount ?? 0;
                                      $_qty_total += $in_itemVal_multi->_qty ?? 0;
                                      $_total_discount_amount += $in_itemVal_multi->_discount_amount ?? 0;
                                      $_gross_net_total  += (($in_itemVal_multi->_value ?? 0)- ($in_itemVal_multi->_discount_amount ?? 0));
                                       $key++;
                                     @endphp
                                     @if($_in_item_key==0)
                                     {!! $in_itemVal_multi->_items->_name ?? '' !!}  
                                    @endif
                                          @empty
                                    @endforelse 

           
          </td>
          <td style="border-right:1px solid #56585bc2;width: 10%;text-align: center;font-size:12px;padding:4px;" class="text-center">
            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
            @if($_in_item_key==0)
            {!! $in_itemVal_multi->_items_inv->_pack_size->_name ?? '' !!}
            @endif
             @empty
             @endforelse 

          </td>
          <td style="border-right:1px solid #56585bc2; width: 8%;text-align: center;font-size:12px;white-space: nowrap;padding:4px;" class="text-right">
             @php
                           $row_qty =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_qty +=($in_itemVal_multi->sale_qty ?? 0);
                             @endphp
                          @empty
                          @endforelse

            {!! _qty_amount($row_qty ?? 0) !!}
            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
            @if($_in_item_key==0)
             {{$in_itemVal_multi->_trans_unit->_name ?? '' }}
            
            @endif
             @empty
             @endforelse

            
          </td>
          <td style="border-right:1px solid #56585bc2; width: 7%;text-align: center;font-size:12px;white-space: nowrap;padding:4px;" class="text-right">
            @php
                           $row_qty_free =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_qty_free +=($in_itemVal_multi->free_qty ?? 0);
                             @endphp
                          @empty
                          @endforelse

            {!! _qty_amount($row_qty_free ?? 0) !!}
            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
            @if($_in_item_key==0)
             {{$in_itemVal_multi->_trans_unit->_name ?? '' }}
            
            @endif
             @empty
             @endforelse

            
           
          </td>
          <td style="border-right:1px solid #56585bc2; width: 10%;text-align: right;font-size:12px;padding-top:2px;padding:4px;" class="text-right">
            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_sales_rate ?? 0) !!}
                              @endif
                              @empty
                              @endforelse

            
          </td>
          <td style="border-right:1px solid #56585bc2; width: 10%;text-align: right;font-size:12px;padding:4px;" class="text-right">
            @php
                           $row__value =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row__value +=($in_itemVal_multi->_value ?? 0);
                             @endphp
                          @empty
                          @endforelse



                                              {!! _report_amount($row__value ?? 0) !!}

           
          </td>
          <td style="border-right:1px solid #56585bc2; width: 6%;text-align: right;font-size:12px;white-space: nowrap;padding:4px;" class="text-right">
            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_discount ?? 0) !!} %
                              @endif
                              @empty
                              @endforelse

            
          </td>
          <td style="border-right:1px solid #56585bc2; width: 6%;text-align: right;font-size:12px;white-space: nowrap;padding:4px;" class="text-right">
            @php
                           $row__discount_amount =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row__discount_amount +=($in_itemVal_multi->_discount_amount ?? 0);
                             @endphp
                          @empty
                          @endforelse



                                              {!! _report_amount($row__discount_amount ?? 0) !!}

            
          </td>
          <td style="border-right:1px solid #56585bc2; width: 15%;text-align: right;font-size:12px;white-space: nowrap;padding:4px;" class="text-right">
            {{_report_amount((($row__value ?? 0)- ($row__discount_amount ?? 0)))}}
          </td>
          @endif
         </tr>
          @php
$qty_sum +=$val->_qty ?? 0;
         @endphp
      
@empty
@endforelse
@if($add_new_row > 0)
      @for($j=0; $j<=$add_new_row; $j++)
      <tr>
        <td style="height:20px;border-right:1px solid #56585bc2;border-left:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
        <td style="height:20px;border-right:1px solid #56585bc2;" ></td>
      </tr>

      @endfor

      @endif

                            <tr>
                              <td colspan="6" class="text-left " style="width: 50%;border-top: 1px solid #56585bc2;">
                                <p class="lead" style="font-size:12px;"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p>
                                <div style="height:350px;vertical-align:top;width: 80%;overflow:visible;">
                                  @include("backend.sales.invoice_history")
                                </div>
                                

                              </td>
                              
                              <td colspan="4" class=" text-right"  style="width: 50%;border-top: 1px solid #56585bc2;font-size: 12px;vertical-align: top;">
                                  <table style="width: 100%;border-collapse: collapse;margin-top:5px;">
                                     <tr>
                                      <td class="text-right"  style="border:1px solid #56585bc2;white-space: nowrap; "> Sales Amount =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">{!! _report_amount($data->_sub_total ?? 0) !!}</td>
                                    </tr>
                                   
                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; "> Cash Discount =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">{!! _report_amount($data->_total_discount ?? 0) !!}</td>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">VAT[+]</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">{!! _report_amount($data->_total_vat ?? 0) !!}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; "> Payable Amount =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">{!! _report_amount($data->_total ?? 0) !!}</td>
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
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; "> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</td>
                                    </tr>
                                    @endif

                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; "> {!! $ac_val->_ledger->_name ?? '' !!}[-]
                                        </td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap; ">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</td>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                     @endif
                                      @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">Previous Dues =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</td>
                                    </tr>
                                     <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">Invoice Due =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">{!! _report_amount( $_due_amount) !!}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">Current Dues =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">Credit Limit =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">{!! _report_amount($data->_ledger->_credit_limit ?? 0) !!}</td>
                                    </tr>
                                    @php
$payable_amount = (($data->_l_balance)-($data->_ledger->_credit_limit));
                                    @endphp
                                    @if($payable_amount > 0)
                                    <tr >
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">Net Payable Amount =</td>
                                      <td class="text-right" style="border:1px solid #56585bc2;white-space: nowrap;font-size: 12px; ">

                                       
                                        
                                        {!! _report_amount($payable_amount) !!}
                                        
                                      
                                      </td>
                                    </tr>
                                    @endif
                                    @endif
                                   
                                  </table>

                              </td>
                            </tr>
                <tr>
                  <td colspan="6">
                    <table style="width: 100%;">
                                <tr>
                                  <td colspan="2">

                                    {{$settings->_sales_note ?? '' }} 
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width:100%;">
                                    
                                  </td>
                                
                                  
                                </tr>
                              </table>
                  </td>
                  <td colspan="4">
                   
                  </td>
                </tr>
    </tbody>



   <tfoot class="">
      
      <tr>
        <td colspan="2">
          <div class="inv_footer_arrea_left">
            <span class="sing_section">Customer Signature with Seal  </span>
          </div>
        </td>
        <td colspan="2">
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Delivered by</span>
          </div>
        </td>
        <td colspan="3">
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Accounts Signature</span>
          </div>
        </td>
        <td colspan="3">
          <div class="inv_footer_arrea_right" style="white-space:nowrap;">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
      <tr>
        <td colspan="10">
          <table style="width:100%;">
            <td style="text-align: left;"><span style="">Print Date: {{date('d M Y') }}</span></td>
            <td style="text-align:center;padding-left: 30px;"><span style="font-size:24px;color: gold;font-weight: bold;display:none;">Thank You for your Business</span></td>
            <td style="text-align:right;padding-left: 50px;">Print Time: {{ date('h:i:s a') }}</td>
          </table>
          
        </td>
        
      </tr>
    </tfoot>
  </table>
</div>


<script type="text/javascript">
  window.print();
</script>
</body>


</html>

     

    


     

   

  


