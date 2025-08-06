<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>{{$page_name ?? ''}}</title>
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
              <div class="tm_primary_color tm_f50 tm_text_uppercase">{{ $page_name ?? '' }}</div>
              {{voucher_code_to_name($data->_voucher_type ?? '' )}}
            </div>
          </div>
          <div class="tm_invoice_info tm_mb20">
            <div class="tm_invoice_seperator ">{{ invoice_barcode($data->_code ?? '') }}</div>
            <div class="tm_invoice_info_list">
              
              <p class="tm_invoice_number tm_m0">Voucher No: <b class="tm_primary_color">{!! $data->_code ?? '' !!}</b></p><br>
              <p class="tm_invoice_date tm_m0">Date: <b class="tm_primary_color">{!! _view_date_formate($data->_date ?? '') !!}</b></p>
            </div>
          </div>
          <div class="tm_invoice_head tm_mb10">
            <div class="tm_invoice_left">
              <p>
                {{$settings->name ?? '' }} <br>
                {{$settings->_address ?? '' }} <br>{{$settings->_phone ?? '' }} <br>
                {{$settings->_email ?? '' }}
              </p>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <p>
                 <b>Time:</b> {{$data->_time ?? ''}}<br>
                @php
$_bank_name = $data->check_info->_bank_name ?? '';
$_branch_name = $data->check_info->_branch_name ?? '';
$_bank_account = $data->check_info->_bank_account ?? '';
$_check_no = $data->check_info->_check_no ?? '';
$_issue_date = $data->check_info->_issue_date ?? '';
$_cash_date = $data->check_info->_cash_date ?? '';
                @endphp
             @if($_bank_name !='')
              <b>{{__('label._bank_name')}}:</b> {{$_bank_name ?? ''}}<br>
              @endif
             @if($_branch_name !='')
              <b>{{__('label._branch_name')}}:</b> {{$_branch_name ?? ''}}<br>
              @endif
             @if($_bank_account !='')
              <b>{{__('label._bank_account')}}:</b> {{$_bank_account ?? ''}}<br>
              @endif
             @if($_check_no !='')
              <b>{{__('label._check_no')}}:</b> {{$_check_no ?? ''}}<br>
              @endif
             @if($_check_no !='')
              <b>{{__('label._issue_date')}}:</b> {{_view_date_formate($_issue_date ?? '')}}<br>
              @endif
             @if($_check_no !='')
              <b>{{__('label._cash_date')}}:</b> {{_view_date_formate($_cash_date ?? '')}}<br>
              @endif
              <b>Time:</b> {{$data->_time ?? ''}}<br>
              <b>Created By:</b> {{$data->_user_name ?? ''}}<br>
              <b>{{__('label._ref')}}:</b> {{$data->_transection_ref ?? ''}}<br>
              <b>{{__('label.Branch')}}:</b> {{$data->_master_branch->_name ?? ''}}
              </p>
            </div>
          </div>
          
          <div class="tm_table tm_style1 tm_mb30">
<img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    
                    <tr>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label.sl')}}</th>
                      <th class="tm_width_4 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label._ledger_id')}}</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label._description')}}</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label.Dr. Amount')}}</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label.Cr. Amount')}}</th>
                    </tr>

                  </thead>
                  <tbody>

                    @forelse($data->_master_details as $detail_key=>$detail)
                    <tr>
                      <td>{{($detail_key+1)}}.</td>
                      <td class="tm_width_3" style="border:1px solid silver;">
                       {!! $detail->_voucher_ledger->_name ?? '' !!}
                      </td>

                      <td class="tm_width_4" style="border:1px solid silver;">
                         {!! $detail->_short_narr ?? '' !!}
                      </td>
                      <td class="tm_width_2" style="border:1px solid silver;">
                        {!! _report_amount( $detail->_dr_amount ?? 0 ) !!}
                      </td>
                      <td class="tm_width_1" style="border:1px solid silver;">
                      {!! _report_amount($detail->_cr_amount ?? 0 )!!}
                      </td>
                       
                    </tr>
                    @empty
          @endforelse
                  
                    
                            <tr>
                             
                                      <th colspan="3" style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Total</b></th>
                                      <th style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount($data->_amount ?? 0) !!}</th>
                                      <th style="font-size: .7em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;">{!! _report_amount($data->_amount ?? 0) !!}</th>
                                    </tr>
                                   


                                  
                                  
                            </tr>
                           
                              
                  </tbody>
                </table>
                <p class="lead"> <b>Note: {{$data->_note ?? '' }} </b></p>
                <p class="lead"> <b>In Words: {{ nv_number_to_text( $data->_amount ?? 0) }} </b></p>
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
        <input type="hidden" id="download_page_name" value="voucher_{{$data->_order_number}}">
<br>
@can('voucher-edit')
<a class="tm_invoice_btn tm_color2"  title="Edit" href="{{ route('voucher.edit',$data->id) }}">Edit</a>
@endcan

<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="{{ url('voucher') }}">Back</a>
      </div>
    </div>
  </div>
  <script src="{{asset('backend/invoices/jquery.min.js')}}"></script>
  <script src="{{asset('backend/invoices/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/invoices/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/invoices/main.js')}}"></script>

</body>
</html>