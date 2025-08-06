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
 <a class="nav-link"  href="{{url('supplier_payment')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('supplier_payment_edit')
    <a class="nav-link"  title="Edit" href="{{ route('supplier_payment.edit',$data->id) }}">
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
           <img src="{{asset($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}"  style="width: 120px;height: auto;"> {{$settings->name ?? '' }}
          
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
        <h4 class="text-center"> Payment Receipt @if($data->_voucher_type=='CP') (Cash Payment) @endif @if($data->_voucher_type=='BP') (Bank Payment) @endif</h4>
        
      </div>
      <!-- /.col -->
       <div class="col-sm-12 invoice-col">
      <table style="width:100%;padding-left: 20px;">
        <tr>
          <td style="width:200px;">{{__('label._date')}}</td>
          <td>: {{ _view_date_formate($data->_date ?? date('d-m-Y')) }}</td>
        </tr>
        <tr>
          <td style="width:200px;">Supplier Name</td>
          <td>: {{$data->_sup_cus->_name ?? '' }}</td>
        </tr>
        <tr>
          <td style="width:200px;">Supplier Code</td>
          <td>: {{$data->_sup_cus->_code ?? '' }}</td>
        </tr>
        <tr>
          <td style="width:200px;">Address</td>
          <td>: {{$data->_sup_cus->_address ?? '' }}</td>
        </tr>
        <tr>
          <td style="width:200px;">Phone</td>
          <td>: {{$data->_sup_cus->_phone ?? '' }}</td>
        </tr>
        
      </table>
    </div>
      
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table  style="width: 100%;border:1px solid silver;">
         
          
         
          <tbody>
            @forelse($data->_master_details as $detail_key=>$detail)
            @if($detail->_dr_amount > 0)
            <tr style="border: 1px solid silver;">
              <td colspan="2" style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td><b>Payment To:</b>{{$detail->_voucher_ledger->_name ?? '' }}</td> </tr>
                  <tr><td><b>Address:</b>{{$detail->_voucher_ledger->_address ?? '' }}</td> </tr>
                  <tr><td><b>Phone:</b>{{$detail->_voucher_ledger->_phone ?? '' }}</td> </tr>
                </table>
              </td>
              <td style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td>
                    <b>Voucher ID: {{ $data->_code ?? '' }}</b><br>
        <b>Date:</b>  {{ _view_date_formate($data->_date ?? '') }}  {{$data->_time ?? ''}}<br>
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
            <td style="border: 1px solid silver;font-weight: bold;">Payment Type</td>
            <td style="border: 1px solid silver;font-weight: bold;">Invoice Number</td>
            <td style="border: 1px solid silver;font-weight: bold;" class="text-right">Amount</td>
          </tr>
           @forelse($data->_master_details as $detail_key=>$detail)
          
            @if($detail->_collection_amount > 0)
          <tr style="border: 1px solid silver;">
            
            <td style="border: 1px solid silver;">{!! $detail->_receive_ledger->_name ?? '' !!}</td>
            
            <td style="border: 1px solid silver;">{!! $detail->_invoice_number ?? '' !!}</td>
            <td style="border: 1px solid silver;" class="text-right" >{!! _report_amount( $detail->_collection_amount ?? 0 ) !!}</td>
             
          </tr>
          @endif

          @empty
          @endforelse
          <tr style="border: 1px solid silver;" >
              <td  style="border: 1px solid silver;" colspan="2" class="text-center"><b>Total</b></td>
              <th  style="border: 1px solid silver;"  class="text-right" ><b>{!! _report_amount($data->_amount ?? 0) !!}</b></th>
            </tr>

            <tr>
              <td colspan="3" class="text-left"><b>In Words: </b>{{ convert_number( $data->_amount ?? 0)  }} {{taka_only()}}</td>
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