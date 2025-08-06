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
      <div class="tm_invoice tm_style2 tm_type1 tm_accent_border" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_top_head tm_mb20 tm_mb10_md">
            <div class="tm_invoice_left">
              <div class="tm_logo"><img src="{{asset($settings->logo ?? '')}}" alt="Logo" style="width:120px;height:auto;"></div>

            </div>
            <div class="tm_invoice_right">
              <div class="tm_grid_row tm_col_3">
                <div class="tm_text_center">
                  <p class="tm_accent_color tm_mb0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="currentColor"><path d="M424 80H88a56.06 56.06 0 00-56 56v240a56.06 56.06 0 0056 56h336a56.06 56.06 0 0056-56V136a56.06 56.06 0 00-56-56zm-14.18 92.63l-144 112a16 16 0 01-19.64 0l-144-112a16 16 0 1119.64-25.26L256 251.73l134.18-104.36a16 16 0 0119.64 25.26z"></path></svg>
                  </p>
                   {!! $settings->_email ?? '' !!}
                </div>
                <div class="tm_text_center">
                  <p class="tm_accent_color tm_mb0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="currentColor"><path d="M391 480c-19.52 0-46.94-7.06-88-30-49.93-28-88.55-53.85-138.21-103.38C116.91 298.77 93.61 267.79 61 208.45c-36.84-67-30.56-102.12-23.54-117.13C45.82 73.38 58.16 62.65 74.11 52a176.3 176.3 0 0128.64-15.2c1-.43 1.93-.84 2.76-1.21 4.95-2.23 12.45-5.6 21.95-2 6.34 2.38 12 7.25 20.86 16 18.17 17.92 43 57.83 52.16 77.43 6.15 13.21 10.22 21.93 10.23 31.71 0 11.45-5.76 20.28-12.75 29.81-1.31 1.79-2.61 3.5-3.87 5.16-7.61 10-9.28 12.89-8.18 18.05 2.23 10.37 18.86 41.24 46.19 68.51s57.31 42.85 67.72 45.07c5.38 1.15 8.33-.59 18.65-8.47 1.48-1.13 3-2.3 4.59-3.47 10.66-7.93 19.08-13.54 30.26-13.54h.06c9.73 0 18.06 4.22 31.86 11.18 18 9.08 59.11 33.59 77.14 51.78 8.77 8.84 13.66 14.48 16.05 20.81 3.6 9.53.21 17-2 22-.37.83-.78 1.74-1.21 2.75a176.49 176.49 0 01-15.29 28.58c-10.63 15.9-21.4 28.21-39.38 36.58A67.42 67.42 0 01391 480z"></path></svg>
                  </p>
                   {!! $settings->_phone ?? '' !!}
                </div>
                <div class="tm_text_center">
                  <p class="tm_accent_color tm_mb0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="currentColor"><circle cx="256" cy="192" r="32"></circle><path d="M256 32c-88.22 0-160 68.65-160 153 0 40.17 18.31 93.59 54.42 158.78 29 52.34 62.55 99.67 80 123.22a31.75 31.75 0 0051.22 0c17.42-23.55 51-70.88 80-123.22C397.69 278.61 416 225.19 416 185c0-84.35-71.78-153-160-153zm0 224a64 64 0 1164-64 64.07 64.07 0 01-64 64z"></path></svg>
                  </p>
                  {!! $settings->_address ?? '' !!}
                </div>
              </div>
            </div>
            <div class="tm_shape_bg tm_accent_bg"></div>
          </div>
          <div class="tm_invoice_info tm_mb10">
            <div class="tm_invoice_info_left">
              <p class="tm_mb2"><b>Invoice To:</b></p>
              <p>
                <b class="tm_f16 tm_primary_color">
                @if($form_settings->_defaut_customer ==$data->_ledger_id)
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
              <div class="tm_f50 tm_text_uppercase tm_text_center tm_invoice_title tm_mb15 tm_ternary_color tm_mobile_hide">Invoice</div>
              <div class="tm_grid_row tm_col_3 tm_invoice_info_in tm_round_border tm_gray_bg">
                <div>
                  <span>Invoice No:</span> <br>
                  <b class="tm_f18 tm_accent_color">{!! $data->_order_number ?? '' !!}</b>
                </div>
                <div>
                  <span>Invoice Date:</span> <br>
                  <b class="tm_f18 tm_accent_color">{!! _view_date_formate($data->_date ?? '') !!}</b>
                </div>
                <div>
                  <span>Grand Total:</span> <br>
                  <b class="tm_f18 tm_accent_color">{!! _report_amount($data->_total ?? 0) !!}</b>
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
<a class="tm_invoice_btn tm_color2"  title="Edit" href="{{ route('sales.edit',$data->id) }}">Edit</a>
@endcan
<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="{{ url('sales') }}">Back</a>

      </div>
    </div>
  </div>
  <script src="{{asset('backend/invoices/jquery.min.js')}}"></script>
  <script src="{{asset('backend/invoices/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/invoices/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/invoices/main.js')}}"></script>

</body>
</html>