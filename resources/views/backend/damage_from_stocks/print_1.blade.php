<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>Sales Invoice</title>
  <link rel="stylesheet" href="{{asset('backend/invoices/style.css')}}">
</head>

<body cz-shortcut-listen="true">
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_top_head tm_mb20">
            <div class="tm_invoice_left">
              <div class="tm_logo"><img src="{{asset($settings->logo ?? '')}}" alt="Logo"></div>
            </div>
            <div class="tm_invoice_right">
              <div class="tm_grid_row tm_col_3">
                <div>
                  <b class="tm_primary_color">Email</b> <br>
                  {!! $settings->_email ?? '' !!}
                </div>
                <div>
                  <b class="tm_primary_color">Phone</b> <br>
                   {!! $settings->_phone ?? '' !!}
                   
                </div>
                <div>
                  <b class="tm_primary_color">Address</b> <br>
                  {!! $settings->_address ?? '' !!}
                </div>
              </div>
            </div>
          </div>
          <div class="tm_invoice_info tm_mb10">
            <div class="tm_invoice_info_left">
              <p class="tm_mb2"><b>Invoice To:</b></p>
              <p>
                <b class="tm_f16 tm_primary_color">@if($form_settings->_defaut_customer ==$data->_ledger_id)
                     {{ $data->_referance ?? $data->_ledger->_name }}
                  @else
                  {{$data->_ledger->_name ?? '' }}
                  @endif </b> <br>
                {!! $data->_address ?? '' !!}<br>
                {!! $data->_phone ?? '' !!}<br>
                {!! $data->_email ?? '' !!}
              </p>
            </div>
            <div class="tm_invoice_info_right">
              <div class="tm_ternary_color tm_f50 tm_text_uppercase tm_text_center tm_invoice_title tm_mb15 tm_mobile_hide">Invoice</div>
              <div class="tm_grid_row tm_col_3 tm_invoice_info_in tm_accent_bg">
                <div>
                  <span class="tm_white_color_60">Grand Total:</span> <br>
                  <b class="tm_f16 tm_white_color">{!! _report_amount($data->_total ?? 0) !!}</b>
                </div>
                <div>
                  <span class="tm_white_color_60">Invoice Date:</span> <br>
                  <b class="tm_f16 tm_white_color">{!! _view_date_formate($data->_date ?? '') !!}</b>
                </div>
                <div>
                  <span class="tm_white_color_60">Invoice No:</span> <br>
                  <b class="tm_f16 tm_white_color">{!! $data->_order_number ?? '' !!}</b>
                </div>
              </div>
            </div>
          </div>
          <div class="tm_table tm_style1">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_7 tm_semi_bold tm_accent_color">Item</th>
                      <th class="tm_width_1 tm_semi_bold tm_accent_color">Unit</th>
                      <th class="tm_width_1 tm_semi_bold tm_accent_color">Qty</th>
                      <th class="tm_width_2 tm_semi_bold tm_accent_color">Price</th>
                      <th class="tm_width_2 tm_semi_bold tm_accent_color tm_text_right">Total</th>
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
                      
                      <td class="tm_width_3" >
                        @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                    @php
                                      $_value_total +=$in_itemVal_multi->_value ?? 0;
                                      $_vat_total += $in_itemVal_multi->_vat_amount ?? 0;
                                      $_qty_total += $in_itemVal_multi->_qty ?? 0;
                                      $_total_discount_amount += $in_itemVal_multi->_discount_amount ?? 0;
                                     @endphp
                                     @if($_in_item_key==0)
                                          <p class="tm_m0 tm_f16 tm_primary_color">  {!! $in_itemVal_multi->_items->_name ?? '' !!}  </p>
                                          {!! $in_itemVal_multi->_showing_item_name ?? '' !!}
                                    @endif
                                          @empty
                                    @endforelse 
                      </td>

                      <td class="tm_width_1" >
                         
                            @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                  {!! _find_unit($in_itemVal_multi->_transection_unit ?? '') !!}
                              @endif
                              @empty
                              @endforelse
                      </td>
                      <td class="tm_width_4" >
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
                                   
                      </td>
                      <td class="tm_width_4" >
                         @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_sales_rate ?? 0) !!}
                              @endif
                              @empty
                              @endforelse
                      </td>
                      <td class="tm_width_1" >
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
                      
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tm_invoice_footer tm_mb15 tm_m0_md">
              <div class="tm_left_footer">
                <div class="tm_card_note tm_ternary_bg tm_white_color"><b>Payment info: </b> @php
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
                                    <b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        {!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b>{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}
                                    @endif
                                    @endif
                                    @endforeach
                                     @endif
                                  </div>
                <p class="tm_mb2"><b class="tm_primary_color">Important Note:</b></p>
                <p class="tm_m0">{!! $data->_note ?? '' !!}</p>
              </div>
              <div class="tm_right_footer">
                <table class="tm_mb15">
                  <tbody>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtoal</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">{!! _report_amount($data->_sub_total ?? 0) !!}</td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_danger_color tm_border_none tm_pt0">Discount </td>
                      <td class="tm_width_3 tm_danger_color tm_text_right tm_border_none tm_pt0">{!! _report_amount($data->_total_discount ?? 0) !!}</td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Tax</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">{!! _report_amount($data->_total_vat ?? 0) !!}</td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_accent_bg tm_radius_6_0_0_6">Grand Total </td>
                      <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right tm_white_color tm_accent_bg tm_radius_0_6_6_0">{!! _report_amount($data->_total ?? 0) !!}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tm_invoice_footer tm_type1">
              <div class="tm_left_footer"></div>
              <div class="tm_right_footer">
                <div class="tm_sign tm_text_center">
                  <img src="{!! asset($form_settings->_seal_image ?? '' ) !!} !!}" alt="Sign">
                 
                  <p class="tm_m0 tm_f16 tm_primary_color">Authorised Signature</p>
                </div>
              </div>
            </div>
          </div>
          @php
                                $_sales_note = $settings->_sales_note ?? '';
                                @endphp
                                @if($_sales_note !='')
          <div class="tm_note tm_font_style_normal tm_text_center">
            <hr class="tm_mb15">
            <p class="tm_mb2"><b class="tm_primary_color">Terms &amp; Conditions:</b></p>
            <p class="tm_m0">{{ $settings->_sales_note ?? '' }}</p>
          </div><!-- .tm_note -->
          @endif
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
@can('sales-edit')
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