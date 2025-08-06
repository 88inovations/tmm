<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>{{ $page_name ?? '' }}</title>
  <link rel="stylesheet" href="{{asset('backend/invoices/style.css')}}">
</head>

<body cz-shortcut-listen="true">
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style1" id="tm_download_section">
        <div class="tm_invoice_in">
           <div class="tm_primary_color  tm_text_uppercase tm_text_center"><b>{{ $page_name ?? '' }}</b></div>
          <div class="tm_invoice_head tm_align_center tm_mb20">
            <div class="tm_invoice_left">
              <div class="tm_logo">
                <img src="{{asset($settings->logo ?? '')}}" alt="Logo">
              </div>
              {{$settings->name ?? '' }} <br>
                {{$settings->_address ?? '' }} <br>{{$settings->_phone ?? '' }} <br>
                {{$settings->_email ?? '' }}
            </div>
            <div class="tm_invoice_right tm_text_right">
             
              <div class="tm_primary_color  tm_text_uppercase">Product Name:<span style="font-size: 20px;font-weight:bold;padding: 5px;">{{ $data->_items->_name ?? '' }}</span></div>
              
            <span>  Unit: <b>{{ $data->_items->_units->_name ?? '' }}</b></span><br>
            DATE: <b class="tm_primary_color">{!! _view_date_formate($data->_date ?? '') !!}</b>

            </div>
          </div>
          <h3></h3>
          
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
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Unit</th>
                    </tr>
                  </thead>
                  <h4>Ingredients Details</h4>
                  @php
                  $input_detail = $data->input_detail ?? [];
                  @endphp
                  <tbody>
                   @forelse($input_detail as $key=> $detail)
                   <tr>
                      <td class="tm_width_1" >{{($key+1)}}</td>
                      <td class="tm_width_1" >{{ $detail->_input_item->_name ?? '' }}</td>
                      <td class="tm_width_1" >{{ $detail->_qty ?? '' }}</td>
                      <td class="tm_width_1" >{{ _find_unit($detail->_transection_unit ?? '') }}</td>
                      </tr>
                   @empty
                   @endforelse
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
        @include("basic.print_download")
        <input type="hidden" id="download_page_name" value="formula_{{$data->_items->_name}}">
<br>
@can('musak-four-point-three-edit')
<a class="tm_invoice_btn tm_color2"  title="Edit" href="{{ route('musak-four-point-three.edit',$data->id) }}">Edit</a>
@endcan

<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="{{ url('musak-four-point-three') }}">Back</a>
      </div>
    </div>
  </div>
  <script src="{{asset('backend/invoices/jquery.min.js')}}"></script>
  <script src="{{asset('backend/invoices/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/invoices/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/invoices/main.js')}}"></script>

</body>
</html>