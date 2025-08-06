
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
    <a class="nav-link"  href="{{url('holidays')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('holidays-edit')
 <a  href="{{ route('holidays.edit',$data->id) }}" 
    class="nav-link "  title="Edit"  >
    <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    
    <div class="container-fluid">
      <div style="text-align: center;">
       <h3> {{$settings->name ?? '' }} </h3>
       <div>{{$settings->_address ?? '' }}</br>
       {{$settings->_phone ?? '' }}</div>
       <h3>{{$page_name}}</h3>

      </div>
    <!-- /.row -->
    <table class="table">
      <tr>
        <td>From Date:</td>
        <td>{{ _view_date_formate($data->_dfrom ?? '' ) }}</td>
      </tr>
      <tr>
        <td>To Date:</td>
        <td>{{ _view_date_formate($data->_dto ?? '' ) }}</td>
      </tr>
      <tr>
        <td colspan="2"><b>Details</b></td>
      </tr>
      @php
      $holiday_details = $data->holiday_details ?? [];
      @endphp
      @if(sizeof($holiday_details) > 0)
      <tr>
        <td colspan="2">
          <table style="width:100%;">
            <tr>
              <td>Name</td>
              <td>Date</td>
              <td>Type</td>
            </tr>
            @forelse($holiday_details as $detail)
            <tr>
              <td>{{ $detail->_name ?? '' }}</td>
              <td>{{ _view_date_formate($detail->_date ?? '') }}</td>
              <td>{{ $detail->_type ?? '' }}</td>
            </tr>
            @empty
            @endforelse

          </table>
        </td>
      </tr>
      @endif
    </table>
    
    

    

    <div class="row">
       @include('backend.message.invoice_footer')
    </div>
    </div>
  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection