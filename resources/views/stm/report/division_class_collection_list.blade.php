

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>


<section class="invoice p-2" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;"><b>{{$settings->name ?? '' }}</b><br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> {{$settings->keywords ?? '' }}</div>
                </td> </tr>
                
              <?php
              $sequence_to_remove = "––------------–--";
              ?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <h3>{!! $page_name ?? '' !!}</h3>
              </td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <h3>Period: {!! _view_date_formate($request->_datex)  !!} To  {!! _view_date_formate($request->_datey)  !!}</h3>
              </td></tr>
               <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  Date & Time: {{ date('d-m-Y H:s a') }}
              </td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
        
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space">{{__('label.sl')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._date')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._session')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._division_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._class_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._name_in_bangla')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._name_in_english')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._roll_no')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._bill_type')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._amount')}}</td>
          </tr>
          
          
          </thead>
          <tbody>
@php
$_total__collection_amount=0;
$_sl = 1;
@endphp
@forelse($datas as $d_key=>$data)
@if($data->_collection_amount > 0)
@php
$_total__collection_amount +=$data->_collection_amount ?? 0;
@endphp
        <tr>
            <td class="white_space">{{ ($_sl++) }}</td>
            <td class="white_space">{!! _view_date_formate($data->_date ?? '') !!} </td>
            <td class="white_space">{!! $data->_session_info->_name ?? '' !!} </td>
            <td class="white_space">{!! $data->_division->_name ?? '' !!} </td>
            <td class="white_space">{!! $data->_class_info->_name ?? '' !!} </td>
            <td class="white_space">{!! $data->_student->_name_in_bangla ?? '' !!} </td>
            <td class="white_space">{!! $data->_student->_name_in_english ?? '' !!} </td>
            <td class="white_space">{!! $data->_student->_roll_no ?? '' !!} </td>
            @php
$_bill_type = str_replace('_', ' ', ltrim($data->_bill_type ?? '', '_'));

// Capitalize the first letter of each word
$_bill_type = ucwords($_bill_type);
            @endphp

            <td class="white_space">{!! $_bill_type ?? '' !!} </td>
            <td class="white_space">{!! _report_amount($data->_collection_amount ?? 0)  !!}</td>
          </tr>
  @endif
@empty
@endforelse
<tr>
  <tr>
            <th colspan="9" class="white_space">Total Amount</th>
            <th class="white_space">{!! _report_amount($_total__collection_amount ?? 0)  !!}</th>
          </tr>
</tr>
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="10" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>