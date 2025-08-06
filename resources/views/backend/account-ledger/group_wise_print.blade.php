
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('group_wise_list')}}" role="button"><i class="fa fa-arrow-left"></i></a>

    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
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
                 Ledger Group:  <b>{!! $page_name ?? '' !!}</b>
                </td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>

@php
$colspan=9;
@endphp
          <!-- Table row -->
   <table class="cewReportTable">
          <thead>
             
        <tr>
         <th>SL</th>
         <th>Ledger ID</th>
         <th>Code</th>
         <th>Ledger Name</th>
         @if($_type=='honorarium')
         @php
$colspan -=2;
@endphp
         <th>{{__('label._designation')}}</th>
         <th>{{__('label._specialist')}}</th>
         @endif
         <th>Phone</th>
         <th>{{__('label._whatsup_number')}}</th>
         <th>{{__('label._email')}}</th>
         <th>{{__('label._address')}}</th>
         
        </tr>
       
          
          
          </thead>
          <tbody>
            @forelse($datas as $key=>$data)
    <tr>
         <td>{{($key+1)}}</td>
         <td class="white_space">{!! $data->id ?? '' !!}</td>
         <td class="white_space">{!! $data->_code ?? '' !!}</td>
         <td class="white_space">{!! $data->_name ?? '' !!}</td>
         @if($_type=='honorarium')
         <td class="white_space">{!! $data->_designation ?? '' !!}</td>
         <td class="white_space">{!! $data->_specialist ?? '' !!}</td>
         @endif
         <td class="white_space">{!! $data->_phone ?? '' !!}</td>
         <td>{!! $data->_whatsup_number ?? '' !!}</td>
         <td>{!! $data->_email ?? '' !!}</td>
         <td>{!! $data->_address ?? '' !!}</td>
        
        </tr>
@empty
@endforelse

          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="{{$colspan}}" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection