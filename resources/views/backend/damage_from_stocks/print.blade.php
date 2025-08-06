<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>damage_from_stocks Invoice</title>
  <link rel="stylesheet" href="{{asset('backend/invoices/style.css')}}">
</head>

<body cz-shortcut-listen="true">
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style1" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_align_center tm_mb20">
            <div class="tm_invoice_left">
              <div class="tm_logo">
                <img src="{{asset($settings->logo ?? '')}}" alt="Logo">
              </div>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <div class="tm_primary_color tm_f50 tm_text_uppercase">Invoice</div>
            </div>
          </div>
          <div class="tm_invoice_info tm_mb20">
            <div class="tm_invoice_seperator ">{{ invoice_barcode($data->_order_number ?? '') }}</div>
            <div class="tm_invoice_info_list">
              <p class="tm_invoice_number tm_m0">Invoice No: <b class="tm_primary_color">{!! $data->_order_number ?? '' !!}</b></p>
              <p class="tm_invoice_date tm_m0">Date: <b class="tm_primary_color">{!! _view_date_formate($data->_date ?? '') !!}</b></p>
            </div>
          </div>
          <div class="tm_invoice_head tm_mb10">
            <div class="tm_invoice_left">
              <p class="tm_mb2"><b class="tm_primary_color">Invoice To:</b></p>
              <p>
                {{$settings->name ?? '' }} <br>
                {{$settings->_address ?? '' }} <br>{{$settings->_phone ?? '' }} <br>
                {{$settings->_email ?? '' }}
              </p>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <p class="tm_mb2"><b class="tm_primary_color">Pay To:</b></p>
              <p>
                @if($form_settings->_defaut_customer ==$data->_ledger_id)
                     {{ $data->_referance ?? $data->_ledger->_name }}
                  @else
                  {{$data->_ledger->_name ?? '' }}
                  @endif <br>
                {{$data->_address ?? '' }}<br>
                {{$data->_phone ?? '' }} <br>
                {{$data->_email ?? '' }}
              </p>
            </div>
          </div>
          <div class="tm_table tm_style1 tm_mb30">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">SL</th>
                      <th class="tm_width_4 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Description</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Qty</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Price</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg tm_text_right" style="border:1px solid silver;">Total</th>
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
                      @if(sizeof($_item) > 0)
                      <td>{{($id)}}.</td>
                      <td class="tm_width_3" style="border:1px solid silver;">
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

                      <td class="tm_width_4" style="border:1px solid silver;">
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
                      <td class="tm_width_2" style="border:1px solid silver;">
                         @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_damage_from_stocks_rate ?? 0) !!}
                              @endif
                              @empty
                              @endforelse
                      </td>
                      <td class="tm_width_1" style="border:1px solid silver;">
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
                       @endif
                    </tr>
                    @php
                                  $id++;
                                  @endphp


                                  @empty
                                  @endforelse
                    
                    @endif
                    <tr>
                              <td colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em; border:1px solid silver;vertical-align:top;text-align: right;"><b>Total</b></td>
                              <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;"> <b>{{ _report_amount($_qty_total ?? 0)}}</b> </td>
                              <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;"></td>
                              
                              <td style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                             
                                      <th colspan="3" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Sub Total</b></th>
                                      <th colspan="2" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   @if($data->_total_discount > 0)
                                    <tr>
                                      <th colspan="3" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Discount[-]</b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   @endif

                                    @if($form_settings->_show_vat==1 && $data->_total_vat > 0)
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>VAT[+]</b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Net Total</b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount($data->_total ?? 0) !!}</th>
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
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th  colspan="3"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Balance </b></th>
                                      <th  colspan="2"  style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                  
                            </tr>
                            <tr>
                                  <td  colspan="5"  style="font-size: .7em;"><p class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p></td>
                                </tr>
                                @php
                                $_damage_from_stocks_note = $settings->_damage_from_stocks_note ?? '';
                                @endphp
                                @if($_damage_from_stocks_note !='')
                                 <tr>
                                  <td  colspan="5"  style="font-size: .7em;">

                                    {{ $settings->_damage_from_stocks_note ?? '' }}
                                  </td>
                                </tr>
                                @endif
                                <tr>
                                  <td  colspan="5" >
                                    @include("backend.damage_from_stocks.invoice_history")
                                  </td>
                                </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div >
              @include('backend.message.invoice_footer')
          </div>
          
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><circle cx="392" cy="184" r="24" fill="currentColor"></circle></svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg>
          </span>
          <span class="tm_btn_text">Download</span>
        </button>
        <input type="hidden" id="download_page_name" value="invoice_{{$data->_order_number}}">
<br>
@can('damage_from_stocks-edit')
<a class="tm_invoice_btn tm_color2"  title="Edit" href="{{ route('damage_from_stocks.edit',$data->id) }}">Edit</a>
@endcan

<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="{{ url('damage_from_stocks') }}">Back</a>
      </div>
    </div>
  </div>
  <script src="{{asset('backend/invoices/jquery.min.js')}}"></script>
  <script src="{{asset('backend/invoices/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/invoices/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/invoices/main.js')}}"></script>

</body>
</html>