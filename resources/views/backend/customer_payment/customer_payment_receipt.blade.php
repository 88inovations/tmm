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
 <a class="nav-link"  href="{{url('customer_payment')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('customer_payment_edit')
    <a class="nav-link"  title="Edit" href="{{ route('customer_payment.edit',$data->id) }}">
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
        <h3>
           <img src="{{asset($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}"  style="width: 120px;height: auto;"> {{$settings->name ?? '' }}
          
        </h3>
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
           
          <tr style="border: 1px solid silver;">
            <td style="border: 1px solid silver;font-weight: bold;">Payment Type</td>
            <td style="border: 1px solid silver;font-weight: bold;" class="text-right">Amount</td>
          </tr>
           @forelse($datas as $detail_key=>$detail)
          
         
          <tr style="border: 1px solid silver;">
            
            <td style="border: 1px solid silver;">{!! $detail_key ?? '' !!}</td>
            <td style="border: 1px solid silver;" class="text-right" >{!! _report_amount( array_sum($detail) ) !!}</td>
             
          </tr>
        

          @empty
          @endforelse
          <tr style="border: 1px solid silver;" >
              <td  style="border: 1px solid silver;"  class="text-left"><b>Total</b></td>
              <th  style="border: 1px solid silver;"  class="text-right" ><b>{!! _report_amount($data->_amount ?? 0) !!}</b></th>
            </tr>

            <tr>
              <td colspan="2" class="text-left"><b>In Words: </b>{{ convert_number( $data->_amount ?? 0)  }} {{taka_only()}}</td>
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