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
<div style="padding-left: 20px;display: flex;">
 <a class="nav-link"  href="{{url('voucher')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('voucher-edit')
    <a class="nav-link"  title="Edit" href="{{ route('voucher.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->
    <div class="row">
      <div class="col-md-12" style="text-align: center;">
        {{ $settings->_top_title ?? '' }}
        <h2 class="page-header text-center">
           <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}"  style="width: 60px;height: 60px;"> {{$settings->name ?? '' }}
          
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h3 class="text-center"><b>{{ voucher_code_to_name($data->_voucher_type) }}</b></h3>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
        <b>Voucher ID: {{ $data->_code ?? '' }}</b><br>
        <b>Time:</b> {{$data->_time ?? ''}}<br>
        <b>Created By:</b> {{$data->_user_name ?? ''}}<br>
        <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped _grid_table">
          <thead>
          <tr>
            <th>ID</th>
            <th>Ledger</th>
            @if(sizeof($permited_branch) > 1)
            <th>Branch</th>
            @endif
            @if(sizeof($permited_costcenters) > 1)
            <th>Cost Center</th>
            @endif
            <th>Short Narr.</th>
            <th class="text-right" >Dr. Amount</th>
            <th class="text-right" >Cr. Amount</th>
          </tr>
          </thead>
          <tbody>
            @forelse($data->_master_details as $detail_key=>$detail)
          <tr>
            <td>{!! $detail->id ?? '' !!}</td>
            <td>{!! $detail->_voucher_ledger->_name ?? '' !!}</td>
             @if(sizeof($permited_branch) > 1)
            <td>{!! $detail->_detail_branch->_name ?? '' !!}</td>
            @endif
             @if(sizeof($permited_costcenters) > 1)
            <td>{!! $detail->_detail_cost_center->_name ?? '' !!}</td>
            @endif
            <td>{!! $detail->_short_narr ?? '' !!}</td>
            <td class="text-right" >{!! _report_amount( $detail->_dr_amount ?? 0 ) !!}</td>
            <td class="text-right" >{!! _report_amount($detail->_cr_amount ?? 0 )!!}</td>
             
          </tr>
          @empty
          @endforelse
          
          </tbody>
          <tfoot>
            <tr>
              <th style="background-color: rgba(0,0,0,.05);" colspan="3" class="text-center">Total:</th>
              @if(sizeof($permited_branch) > 1)
            <td></td>
            @endif
             @if(sizeof($permited_costcenters) > 1)
            <td></td>
            @endif
              <th style="background-color: rgba(0,0,0,.05);" class="text-right" >{!! _report_amount($data->_amount ?? 0) !!}</th>
              <th style="background-color: rgba(0,0,0,.05);" class="text-right" >{!! _report_amount($data->_amount ?? 0) !!}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-12">
       
        <p class="lead"> <b>In Words: {{ nv_number_to_text( $data->_amount ?? 0) }} </b></p>
        
      </div>
       @include('backend.message.invoice_footer')
    </div>
    <!-- /.row -->
  </section>

@endsection