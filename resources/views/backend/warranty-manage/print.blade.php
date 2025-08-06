
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
    <a class="nav-link"  href="{{url('warranty-manage')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('warranty-manage-edit')
    <a class="nav-link"  title="Edit" href="{{ route('warranty-manage.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice " id="printablediv">
    
    
    <!-- /.row -->
    <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 33%;text-align: left;">
              <table class="table" style="border:none;">
                  <tr> <td style="border:none;" >
                    {{ invoice_barcode($data->_order_number ?? '') }}
                 </td>
                 </tr>
                  <tr> <td style="border:none;" > <b>Invoice NO: {{ $data->_order_number ?? '' }}</b></td></tr>
                  <tr> <td style="border:none;" > <b>Date: </b>{{ _view_date_formate($data->_date ?? '') }}</td></tr>
                <tr> <td style="border:none;" > <b> Customer:</b>  {{$data->_ledger->_name ?? '' }}</td></tr>
                <tr> <td style="border:none;" > <b> Phone:</b>  {{$data->_phone ?? '' }} </td></tr>
                <tr> <td style="border:none;" > <b> Address:</b> {{$data->_address ?? '' }} </td></tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: center;">
              <table class="table" style="border:none;">
                <tr> <td class="text-center" style="border:none;font-size: 24px;">{{ $settings->_top_title ?? '' }}<br></td> </tr>
                <tr> <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_address ?? '' }}</b></td></tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_phone ?? '' }}</b>,<b>{{$settings->_email ?? '' }}</b></td></tr>
                 <tr> <td class="text-center" style="border:none;"><h3>{{$page_name}} </h3></td> </tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: right;">
              <table class="table" style="border:none;">
                  <tr> <td class="text-right" style="border:none;"  > <b>Time:</b> {{$data->_time ?? ''}} </td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Created By:</b> {{$data->_user_name ?? ''}}</td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Branch:</b> {{$data->_master_branch->_name ?? ''}} </td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Delivery Date:</b> {{_view_date_formate($data->_delivery_date ?? '' ) }} </td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Status:</b> {{_selected_warranty_status($data->_waranty_status ?? 0 ) }} </td></tr>
              </table>
            </td>
          </tr>
          
         
        </table>
       
        </div>
      </div>
      <div class="row">
        <table style="width: 100%">
          <tr>
            <th style="border: 1px solid #000;">SL</th>
            <th style="border: 1px solid #000;">Description</th>
            <th style="border: 1px solid #000;">Reason of Problem</th>
            <th style="border: 1px solid #000;">Serial No</th>
            <th style="border: 1px solid #000;">Invoice No</th>
            <th style="border: 1px solid #000;">Sales Date</th>
          </tr>
          @php
            $_master_details = $data->_master_details ?? [];
            $s_account = $data->s_account ?? [];
          @endphp
          @forelse($_master_details as $key=> $detail)
          <tr>
            <td  style="border: 1px solid #000;">{{($key+1)}}</td>
            <td  style="border: 1px solid #000;">{{($detail->_items->_name ?? '' )}}</td>
            <td  style="border: 1px solid #000;">{{($detail->_warranty_reason ?? '' )}}</td>
            <td  style="border: 1px solid #000;">{{($detail->_barcode ?? '' )}}</td>
            <td  style="border: 1px solid #000;">{{($data->_order_ref_id ?? '' )}}</td>
            <td  style="border: 1px solid #000;">{{_view_date_formate($data->_sales_date ?? '' )}}</td>
          </tr>

          @empty
          @endforelse
          @forelse($s_account as $key2=>$account)
        @if($_default_warranty_charge ==$account->_ledger_id && $data->_total > 0)
       
          <tr>
            <td colspan="2" style="border: 1px solid #000;">{!! $account->_ledger->_name ?? '' !!}</td>
            <td colspan="4" style="border: 1px solid #000;">{!! _report_amount($data->_total ?? 0) !!}</td>
          </tr>
         
        @endif
        @empty
        @endforelse
        </table>
         
      </div>

   <div class="row">
    <div class="col-12">
      
       
        <p class="lead"> <b>In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </b></p>
        
      </div>
      
      <!-- /.col -->
      @include('backend.message.invoice_footer')
      <!-- /.col -->
    </div>
      <!-- /.col -->
    </div>
     <!-- Table row -->
   

    

    </div>
    <!-- /.row -->
  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection