<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>{{$data->_name ?? '' }}</title>
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
                <img src="{{asset($settings->logo ?? '')}}" alt="{{$data->_name ?? '' }}"><br>
                 {{$settings->name ?? '' }} <br>
                {{$settings->_address ?? '' }} <br>{{$settings->_phone ?? '' }} <br>
                {{$settings->_email ?? '' }}
              </div>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <div class="tm_primary_color tm_f20 tm_text_uppercase">{{$data->_name ?? '' }}</div>
              <span>{{__('label.organization_id')}}: <b>{{$data->_organization->_name ?? '' }}</b></span><br>
              <span>{{__('label.Branch')}}: <b>{{$data->_master_branch->_name ?? '' }}</b></span><br>
              <span>{{__('label._cost_center_id')}}: <b>{{$data->_master_cost_center->_name ?? '' }}</b></span><br>
              <span>{{__('label._start_date')}}: <b>{{ _view_date_formate($data->_start_date ?? '') }}</b></span><br>
              <span>{{__('label._end_date')}}: <b>{{ _view_date_formate($data->_end_date ?? '') }}</b></span><br>
              <span>{{__('label._project_value')}}: <b>{{ _report_amount($data->_project_value ?? '') }}</b></span><br>

            </div>
          </div>
          
          
          <div class="tm_table tm_style1 tm_mb30">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      
                      <th class="tm_width_4 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label._description')}}</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label.budget_amount')}}</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;white-space: nowrap;">{{__('label.expense_amount')}}</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg tm_text_right" style="border:1px solid silver;white-space: nowrap;">Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($group_datas as $key=>$val)
                    <tr>
                      <td colspan="5"><b>{!! $key ?? '' !!}</b></td>
                    </tr>
                    @forelse($val as $detail)
                      <tr>
                        <td>{!! $detail->_ledger_name ?? '' !!}</td>
                        <td>{!! _report_amount($detail->_budget_amount ?? 0) !!}</td>
                        <td>{!! _report_amount($detail->actual_expenses ?? 0) !!}</td>
                        <td><b>
                          @php
                          $_budget_amount = $detail->_budget_amount ?? 0;
                          @endphp
                          @if($_budget_amount > 0)
                          {{ _report_amount(@($detail->actual_expenses/$detail->_budget_amount ?? 1)*100) }}
                          @else
                          0
                          @endif % </b></td>
                      </tr>

                    @empty
                    @endforelse

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
        <input type="hidden" id="download_page_name" value="budgets_{{$data->_name}}">
<br>
@can('budgets-edit')
<a class="tm_invoice_btn tm_color2"  title="Edit" href="{{ route('budgets.edit',$data->id) }}">Edit</a>
@endcan

<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="{{ url('budgets') }}">Back</a>
      </div>
    </div>
  </div>
  <script src="{{asset('backend/invoices/jquery.min.js')}}"></script>
  <script src="{{asset('backend/invoices/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/invoices/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/invoices/main.js')}}"></script>

</body>
</html>