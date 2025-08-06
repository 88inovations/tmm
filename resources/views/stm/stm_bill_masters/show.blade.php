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
 <a class="nav-link"  href="{{route('stm_bill_masters.index')}}" role="button"><i class="fa fa-arrow-left"></i></a>

    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
 
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col text-center">
        {{ $settings->_top_title ?? '' }}
        <h2 class="page-header">
           <img src="{{asset($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}"  style="width: 120px;height:auto;"> {{$settings->name ?? '' }}
          
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
        <h4 class="text-center"><b> {{ _fee_lebel($data->_bill_type ?? '') }} Slip</b></h4>
      </div>
      <!-- /.col -->
      
      
    </div>
    <!-- /.row -->

 

    <div class="row ">
            <div class="col-md-6 col-sm-6 text-left">
              <strong>Bill No:</strong>{!! $data->_order_number ?? '' !!}
            </div>
            <div class="col-md-6 col-sm-6 text-right">
              <strong>Date:</strong> {!! _view_date_formate($data->_date ?? date('Y-m-d')) !!}
            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong>{{__('label._class_id')}}:</strong> {!! $data->_edu_class->_name ?? '' !!}
            </div>
            
            <div class="col-md-6 col-sm-6 text-right">
              <strong>{{__('label._month_id')}}:</strong> {!! _number_to_month($data->_month_id ?? '') !!}
            </div>

          
            <div class="col-md-6 col-sm-6 text-left">
              <strong>{{__('label._session_id')}}:</strong> {!! $data->_edu_session->_name ?? '' !!}
            </div>
              <div class="col-md-6 col-sm-6 text-right">
              <strong>{{__('label._year')}}:</strong> {!! $data->_year ?? '' !!}
            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong>{{__('label._stm_division_id')}}:</strong> {!! $data->_edu_division->_name ?? '' !!}
            </div>
            
           
            
            
            
    </div>

   

    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>SL</th>
          <th>Student ID</th>
          <th>Student Name</th>
          <th>Roll No</th>
          <th>Father Name</th>
          <th class="text-right">Amount (৳)</th>
        </tr>
      </thead>
      <tbody>
        @php
$_detail  = $data->_detail ?? [];

$_total_bill_amount = 0;
        @endphp
        @forelse($_detail as $key=> $d_data)

         @php
$_total_bill_amount += $d_data->_net_fee_amount ?? 0;
        @endphp
        <tr>
          <td>{{ ($key+1) }}</td>
          <td>{!! $d_data->_student->_student_id ?? '' !!}</td>
          <td>{!! $d_data->_student->_name_in_english ?? '' !!}</td>
          <td>{!! $d_data->_student->_roll_no ?? '' !!}</td>
          <td>{!! $d_data->_student->_father_name_english ?? '' !!}</td>
          <td class="text-right">{!! _report_amount($d_data->_net_fee_amount ?? 0) !!}</td>
        </tr>
        
        
        @empty
        @endforelse
        <tr>
          <th colspan="5">Total</th>
          <th class="text-right">{!! _report_amount($_total_bill_amount) !!}</th>
        </tr>
      </tbody>
    </table>

    <p><strong>Amount in Words:</strong> {{nv_number_to_text($_total_bill_amount)}}</p>

   

    <div class="row mt-5 text-center">
      <div class="col-md-6 col-sm-6">
        <p>------------------------</p>
        <p>Prepared By</p>
      </div>
      <div class="col-md-6 col-sm-6 text-end">
        <p>------------------------</p>
        <p>Authorized Signature</p>
      </div>
    </div>

    <div class="text-center mt-3">
      <small>This is a computer-generated receipt and does not require a physical signature.</small>
    </div>
  
    <!-- /.row -->
  </section>

@endsection