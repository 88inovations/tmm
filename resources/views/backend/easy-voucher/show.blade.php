@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

    <div class="message-area">
     @include('backend.message.message')
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                     <h4><a  href="{{ route('voucher.index') }}"> {!! $page_name ?? '' !!} </a>  
                      @include('backend.message.voucher-header')
                      </h4>
                  </div>
                  <div class="col-md-6">
                   <div class="d-flex right" style="float: right;">
                       @can('voucher-create')
                        <a title="Add New" class="btn  btn-sm btn-success  mr-3" href="{{ route('voucher.create') }}"> <i class="nav-icon fa fa-plus"></i> </a>
                      @endcan
                      @can('voucher-edit')
                                    <a title="Edit" class="btn  btn-default  mr-3" href="{{ route('voucher.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
                                    </a>
                      @endcan
                      @can('voucher-print')
                         <a style="cursor: pointer;" class="btn btn-sm btn-danger mr-3"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="nav-icon fas fa-print"></i></a>
     
                      @endcan
                      @can('voucher-list')
                       <a class="btn btn-sm btn-primary" title="List" href="{{ route('voucher.index') }}"> <i class="nav-icon fa fa-th-list" aria-hidden="true"></i></a>
                       @endcan
                    </div>
                   
                  </div>
                </div>
             </div>
              <div class="card-body">
                <div class="wrapper">
  <!-- Main content -->
<section class="invoice" id="printablediv">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
           <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}"  style="width: 60px;height: 60px;"> {{$settings->name ?? '' }}
          <small class="float-right">Date: {{ _view_date_formate($data->_date ?? '') }}</small>
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
        <table class="table table-striped">
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
            <td class="text-right" >{!! _report_amount( $detail->_dr_amount ) !!}</td>
            <td class="text-right" >{!! _report_amount( $detail->_cr_amount ) !!}</td>
             
          </tr>
          @empty
          @endforelse
          
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-right">Total:</th>
              @if(sizeof($permited_branch) > 1)
            <td></td>
            @endif
             @if(sizeof($permited_costcenters) > 1)
            <td></td>
            @endif
              <th class="text-right" >{!! _report_amount( $data->_amount ?? 0 )!!}</th>
              <th class="text-right" >{!! _report_amount( $data->_amount ?? 0 )!!}</th>
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
        @php
$digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        @endphp
        <p class="lead"> <b>In Words: {{ prefix_taka() }}. {{ $digit->format($data->_amount ?? 0) }}. </b></p>
        
      </div>
       @include('backend.message.invoice_footer')
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
               
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


@endsection