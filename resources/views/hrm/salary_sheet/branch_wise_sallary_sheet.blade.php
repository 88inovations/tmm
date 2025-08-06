@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('salary_sheet_list')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 20px;"><b>{{$page_name}}  </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 18px;">For the Month of {{_number_to_month($data->_month)}},{{$data->_year ?? '' }}</td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">Date : {{_view_date_formate($data->_date ?? '')}}</td> </tr>
                 
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">
                  {{__('label.organization_id')}} : {{ $data->_organization->_name ?? '' }}
                  
                 </td> 
               </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">
                {{__('label._branch_id')}} : {{ $data->_master_branch->_name ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">
                 
                   {{__('label._cost_center_id')}} : {{ $data->_master_cost_center->_name ?? '' }}
                
                 </td> </tr>
                
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
           
          <tr>
               <th>Sl</th>
               <th>Code</th>
               <th>Name</th>
               <th>Department</th>
               <th>Designation</th>
               <th>Phone</th>
               <th>Gross Salary</th>
               <th>Deduction</th>
               <th>Net Salary</th>
             </tr>
          </thead>
          <tbody>
      @php
$sub_total_earnings  =0;
$sub_total_deduction  =0;
$sub_net_total_earning  =0;
      @endphp
          @forelse($salery_datas as $key=>$salary)


@php
$sub_total_earnings  +=$salary->total_earnings ?? 0;
$sub_total_deduction  +=$salary->total_deduction ?? 0;
$sub_net_total_earning  +=$salary->net_total_earning ?? 0;
@endphp


            <tr>
               <td class="white_space">{{($key+1)}}</td>
               <td class="white_space">{!! $salary->_emp_code ?? '' !!}</td>
               <td>{!! $salary->_employee->_name ?? '' !!}</td>
               <td>{!! $salary->_employee->_emp_department->_name ?? '' !!}</td>
               <td>{!! $salary->_employee->_emp_designation->_name ?? '' !!}</td>
               <td>{!! $salary->_employee->_mobile1 ?? '' !!}</td>
               <td class="white_space">{!! _report_amount($salary->total_earnings ?? 0) !!}</td>
               <td class="white_space">{!! _report_amount($salary->total_deduction ?? 0) !!}</td>
               <td class="white_space">{!! _report_amount($salary->net_total_earning ?? 0) !!}</td>
              
             </tr>
          @empty
          @endforelse
           
          
          </tbody>
          @if(sizeof($salery_datas) > 1)
          <tfoot>
            <tr>
               <th colspan="6">Total</th>
               <th>{!! _report_amount($sub_total_earnings ?? 0) !!}</th>
               <th>{!! _report_amount($sub_total_deduction ?? 0) !!}</th>
               <th>{!! _report_amount($sub_net_total_earning ?? 0) !!}</th>
              
             </tr>
          </tfoot>
          @endif
          
        </table>


       @include('backend.message.invoice_footer')

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
