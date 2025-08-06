

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
                  Date & Time: {{ date('d-m-Y H:s a') }}
              </td></tr>
        <tr style="line-height: 16px;" > 
        <td class="text-center" style="border:none;font-size:20px;color:#F4791F;">
                  <b>Total Students Found: {{ $datas->count() }}</b>
        </td>
        </tr>


                
              </table> 
            </td>
            
          </tr>
        </table>
        
      

    <!-- Table row -->
 <!--   <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space">{{__('label.sl')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._session')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._division_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._class_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._number_of_student')}}</td>
          </tr>
          
          
          </thead>
          <tbody>
@php
$_total_number_of_student=0;
@endphp
@forelse($datas as $d_key=>$data)
@php
$_total_number_of_student +=$data->_number_of_student ?? 0;
@endphp
        <tr>
            <td class="white_space">{{ ($d_key+1) }}</td>
            <td class="white_space">{!! _id_to_name($data->_session,'_name','stm_education_sessions') !!} </td>
            <td class="white_space">{!! _id_to_name($data->_division_id,'_name','stm_divisions') !!} </td>
            <td class="white_space">{!! _id_to_name($data->_class_id,'_name','stm_classes') !!}</td>
            <td class="white_space">{!! ($data->_number_of_student ?? 0)  !!}</td>
          </tr>
@empty
@endforelse
<tr>
  <tr>
            <th colspan="4" class="white_space">Total Student</th>
            <th class="white_space">{!! ($_total_number_of_student ?? 0)  !!}</th>
          </tr>
</tr>
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="5" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table> -->

   <table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Session</th>
            <th>Division</th>
            <th>Class</th>
            <th>Roll</th>
            <th>Gender</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
@php
  $sortedDatas = $datas->sortBy(function($item) {
    return $item->_student->_roll_no;
  });
@endphp

@foreach($sortedDatas as $index => $student)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $student->_student->_name_in_english ?? 'N/A' }}</td>
        <td>{!! _id_to_name($student->_session,'_name','stm_education_sessions') !!}</td>
        <td>{!! _id_to_name($student->_division_id,'_name','stm_divisions') !!}</td>
        <td>{!! _id_to_name($student->_class_id,'_name','stm_classes') ?? 'N/A' !!}</td>
        <td>{{ $student->_student->_roll_no }}</td>
        <td>{{ ucfirst($student->_student->_gender ?? 'N/A') }}</td>
        <td>{{ $student->_student->_f_mobile_no }}</td>
    </tr>
@endforeach
    </tbody>
</table>
    
    <!-- /.row -->
  </section>