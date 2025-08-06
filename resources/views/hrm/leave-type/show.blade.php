
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
    <a class="nav-link"  href="{{url('leave-type')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('leave-type-edit')
 <a  href="{{ route('leave-type.edit',$data->id) }}" 
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
     
    <!-- /.row -->
    <table class="table">
      <tr>
        <td>{{__('label._type')}}:</td>
        <td>{{ $data->_type ?? ''  }}</td>
      </tr>
      <tr>
        <td>{{__('label._number_of_days')}}:</td>
        <td>{{ $data->_number_of_days ?? ''  }}</td>
      </tr>
      <tr>
        <td>{{__('label._status')}}:</td>
        <td>{{ selected_status($data->_status) }}</td>
      </tr>
      
    </table>
    
    

    

    
    </div>
  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection