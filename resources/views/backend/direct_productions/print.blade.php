<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>{{$page_name ?? '' }}</title>
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
                {{$settings->name ?? '' }} <br>
                {{$settings->_address ?? '' }} <br>{{$settings->_phone ?? '' }} <br>
                {{$settings->_email ?? '' }}
                
              </div>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <h4>Production Receive Challan</h4>
              <div style="float: right;width: 200px;">
                  <div style="width: 100%;">
                    {{ invoice_barcode($data->_order_number ?? '') }}
                  </div>
                </div>
             <br>
             <br>
                Chalan No: <b class="tm_primary_color">{!! $data->_order_number ?? '' !!}</b>
                <br> 
                Date: <b class="tm_primary_color">{!! _view_date_formate($data->_date ?? '') !!}</b><br><br>
                
             </div>
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
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Unit</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $sub_qty=0;
                    @endphp
                   @forelse($detail_data as $akey=>$val)
                    <tr>
                     @php
                    $sub_qty +=$val->_qty ?? 0;
                    @endphp
                      <td>{{($akey+1)}}</td>
                      <td class="tm_width_3" style="border:1px solid silver;">{{$val->_items->_name ?? ''}}</td>

                      <td class="tm_width_4" style="border:1px solid silver;">{{$val->_units->_name ?? ''}}</td>
                      <td class="tm_width_2" style="border:1px solid silver;">{{ _report_amount($val->_qty ?? '')}}</td>
                      
                    </tr>
                    @empty
                    @endforelse
                    <tr>
                     
                      <th style="border:1px solid silver;" colspan="3"><b>Total</b></th>
                      <th class="tm_width_2" style="border:1px solid silver;">{{ _report_amount($sub_qty)}}</th>
                      
                    </tr>

                  
                    
                                  
                  </tbody>
                </table>
              </div>
            </div>
            <div >
            
          </div>
          
        </div>
         @include('backend.message.invoice_footer')
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
@can('partical-production-receive-edit')
<a class="tm_invoice_btn tm_color2"  title="Edit" href="{{ url('partical-production-receive') }}/{{$data->id}}">Edit</a>
@endcan

<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="{{ url('partical_production_receive_list') }}">Back</a>
      </div>
    </div>
  </div>
  <script src="{{asset('backend/invoices/jquery.min.js')}}"></script>
  <script src="{{asset('backend/invoices/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/invoices/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/invoices/main.js')}}"></script>

</body>
</html>