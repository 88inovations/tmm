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
     
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col text-center">
        {{ $settings->_top_title ?? '' }}
        <h2 class="page-header">
           <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}"  style="width: 60px;height: 60px;"> {{$settings->name ?? '' }}
          
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
        <h4 class="text-center"><b>Money Receipt @if($data->_voucher_type=='CR') (Cash) @endif @if($data->_voucher_type=='BR') (Bank) @endif</b></h4>
      </div>
      <!-- /.col -->
      
      
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table  style="width: 100%;border:1px solid silver;">
         
          
         
          <tbody>
            @forelse($data->_master_details as $detail_key=>$detail)
            @if($detail->_cr_amount > 0)
            <tr style="border: 1px solid silver;">
              <td colspan="2" style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td><b>Received From:</b>{{$detail->_voucher_ledger->_name ?? '' }}</td> </tr>
                  <tr><td><b>Address:</b>{{$detail->_voucher_ledger->_address ?? '' }}</td> </tr>
                  <tr><td><b>Phone:</b>{{$detail->_voucher_ledger->_phone ?? '' }}</td> </tr>
                </table>
              </td>
              <td style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td>
                    <b>Voucher ID: {{ $data->_code ?? '' }}</b><br>
        <b>Date:</b> {{ _view_date_formate($data->_date ?? '') }}  {{$data->_time ?? ''}}<br>
        <b>Created By:</b> {{$data->_user_name ?? ''}}<br>
        <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
                  </td></tr>
                </table>
              </td>
            </tr>
            @endif
          @empty
          @endforelse
          <tr style="border: 1px solid silver;">
            <td style="border: 1px solid silver;font-weight: bold;">Receipt Type</td>
            <td style="border: 1px solid silver;font-weight: bold;">Narration</td>
            <td style="border: 1px solid silver;font-weight: bold;" class="text-right">Amount</td>
          </tr>
           @forelse($data->_master_details as $detail_key=>$detail)
          
            @if($detail->_dr_amount > 0)
          <tr style="border: 1px solid silver;">
            
            <td style="border: 1px solid silver;">{!! $detail->_voucher_ledger->_name ?? '' !!}</td>
            
            <td style="border: 1px solid silver;">{!! $detail->_short_narr ?? '' !!}</td>
            <td style="border: 1px solid silver;" class="text-right" >{!! _report_amount( $detail->_dr_amount ?? 0 ) !!}</td>
             
          </tr>
          @endif

          @empty
          @endforelse
          <tr style="border: 1px solid silver;" >
              <td  style="border: 1px solid silver;" colspan="2" class="text-right"><b>Total</b></td>
              <th  style="border: 1px solid silver;"  class="text-right" ><b>{!! _report_amount($data->_amount ?? 0) !!}</b></th>
            </tr>

            <tr>
              <td colspan="3" class="text-left"><b>In Words: </b>{{ nv_number_to_text( $data->_amount ?? 0) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="text-left"><b>Narration:</b> {{ $data->_note ?? '' }}</td>
            </tr>
          
          </tbody>
          <tfoot>
            
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      @include('backend.message.invoice_footer')
    </div>
    <!-- /.row -->
  </section>

@endsection