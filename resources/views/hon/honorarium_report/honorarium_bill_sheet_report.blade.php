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
    <a class="nav-link"  href="{{url('honorarium_bill_sheet')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
  
        <table style="width: 100%; border: none;">
                <tr>
                  <!-- Logo on the left -->
                  <td style="width: 150px; vertical-align: top; border: none;">
                    <img src="{{ asset($settings->logo ?? '') }}" alt="Logo" style="width: 120px; height: auto;">
                  </td>

                  <!-- Company details on the right -->
                  <td style="vertical-align: top; border: none;text-align: center;">
                      <div style="width:100%;margin-left:-50px;">
                        <table style="width: 100%; border: none;">
                          <tr>
                            <td style="font-size: 24px; font-weight: bold;">{{ $settings->name ?? '' }}</td>
                          </tr>
                          <tr>
                            <td>{{ $settings->_address ?? '' }}</td>
                          </tr>
                          <tr>
                            <td>{{ $settings->_phone ?? '' }}, {{ $settings->_email ?? '' }}</td>
                          </tr>
                        </table>
                      </div>
                  </td>
                </tr>
  
</table>
<div style="width:100%;padding:10px;">
  

<table style="width:100%;">
  <tr>
          <td style="font-size: 16px; font-weight: 500;">{{ __('label.organization_id') }}: {{ _company_name($organization_id ?? 0) }}</td>
        </tr>
        <tr>
          <td style="font-size: 16px; font-weight: 500;">{{ __('label._branch_id') }}: {{ _branch_name($_branch_id ?? 0) }}</td>
        </tr>
        <tr>
          <td style="font-size: 16px; font-weight: 500;">{{ __('label._cost_center_id') }}: {{ _cost_center_name($_cost_center_id ?? 0) }}</td>
        </tr>
        <tr>
          <td style="font-size: 16px; font-weight: 500;">{{ __('label._subject') }}: {{ $page_name }}</td>
        </tr>
        <tr>
          <td style="font-size: 16px; font-weight: 500;">Period: For the Month of {{ _number_to_month($_month ?? 0) }}, {{ $_year ?? '' }}</td>
        </tr>
         <tr>
          <td style="font-size: 16px; font-weight: 500;">Date: {{ _view_date_formate(date('Y-m-d')) }}</td>
        </tr>
</table>
</div>


 
    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
         
           
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

    @forelse($datas as $key=>$voucher)
      @php
$branch_total = 0;
      @endphp




 
  @php
$_voucher_detail  = $voucher->_voucher_detail ?? [];
  @endphp


          @forelse($_voucher_detail as $key=>$_master)

            <tr>
               <th colspan="8" class="white_space">{{ _branch_name($_master->_branch_id ?? 0)}}</th>
              
             </tr>

          @php
$_master_details  = $_master->_master_details ?? [];
          @endphp

          @forelse($_master_details as $key=>$h_data )

          @if($h_data->_cr_amount  > 0)


@php
$sub_amount  +=$h_data->_cr_amount ?? 0;
$branch_total +=$h_data->_cr_amount ?? 0;
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

          <tr>
               <th colspan="7">Total {{ _branch_name($_master->_branch_id ?? 0)}}</th>
               <th>{!! _report_amount($branch_total ?? 0) !!}</th>
              
             </tr>
            

            @empty
          @endforelse

         
           
            
             @empty
            @endforelse

             @if(sizeof($datas) > 1)
   
            <tr>
               <th colspan="7">Total</th>
               <th>{!! _report_amount($sub_amount ?? 0) !!}</th>
              
             </tr>
             <tr>
            <td  colspan="8">In Words:  {{ nv_number_to_text($sub_amount ?? 0) }} </td>
          </tr>
         
          @endif
          
          </tbody>
          
          
        </table>


       @include('backend.message.invoice_footer')

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
