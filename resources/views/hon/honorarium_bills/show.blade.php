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
    <a class="nav-link"  href="{{url('honorarium_bills')}}" role="button">
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 16px;font-weight: 500;">For the Month of {{_number_to_month($data->_month)}},{{$data->_year ?? '' }}</td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">Date : {{_view_date_formate($data->_date ?? '')}}</td> </tr>
                 
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                  {{__('label.organization_id')}} : {{ $data->_organization->_name ?? '' }}
                  
                 </td> 
               </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                {{__('label._branch_id')}} : {{ $data->_branch->_name ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                 
                   {{__('label._cost_center_id')}} : {{ $data->_cost_center->_name ?? '' }}
                
                 </td> </tr>
                
              </table>
            </td>
           
          </tr>
        </table>
       
 @forelse($_voucher_detail as $key=>$voucher)
    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
           
          <tr>
               <th>Sl</th>
               <th>Code</th>
               <th>Name</th>
               <th>Phone</th>
               <th>Address</th>
               <th>Designation</th>
               <th>{{__('label._specialist')}}</th>
               <th>Amoun</th>
             </tr>
          </thead>
          <tbody>
      @php
$sub_amount  =0;
      @endphp

 
  @php
$_master_details  = $voucher->_master_details ?? [];
  @endphp
          @forelse($_master_details as $key=>$h_data)
          @if($h_data->_cr_amount  > 0)


@php
$sub_amount  +=$h_data->_cr_amount ?? 0;
@endphp


            <tr>
               <td class="white_space">{{($key+1)}}</td>
               <td class="white_space">{!! $h_data->_voucher_ledger->_code ?? '' !!}</td>
               <td>{!! $h_data->_voucher_ledger->_name ?? '' !!}</td>
               <td>{!! $h_data->_voucher_ledger->_phone ?? '' !!}</td>
               <td>{!! $h_data->_voucher_ledger->_address ?? '' !!}</td>
               <td>{!! $h_data->_voucher_ledger->_designation ?? '' !!}</td>
               <td>{!! $h_data->_voucher_ledger->_specialist ?? '' !!}</td>
               <td class="white_space">{!! _report_amount($h_data->_cr_amount ?? 0) !!}</td>
              
             </tr>
             @endif
          @empty
          @endforelse
           
            
          
          </tbody>
          @if(sizeof($_master_details) > 1)
          <tfoot>
            <tr>
               <th colspan="7">Total</th>
               <th>{!! _report_amount($sub_amount ?? 0) !!}</th>
              
             </tr>
             <tr>
            <td  colspan="8">In Words:  {{ nv_number_to_text($sub_amount ?? 0) }} </td>
          </tr>
          </tfoot>
          @endif
          
        </table>
 @empty
@endforelse

       @include('backend.message.invoice_footer')

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
