@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <div class="_report_button_header">
    <a class="nav-link"  href="{{url('filter-actual-sales')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <br/><b>@foreach($permited_branch as $p_branch)
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach  </b></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
       

    <!-- Table row -->
    <table class="cewReportTable">
          <thead>
          <tr>
            <th style="width: 15%;">Item Name </th>
            <th style="width: 10%;">Store</th>
            <th style="width: 10%;">Barcode</th>
            <th style="width: 5%;">Unit</th>
            <th style="width: 10%;" class="text-right">Quantity</th>
            <th style="width: 10%;" class="text-right">Rate</th>
            <th style="width: 10%;" class="text-right">VAT%</th>
            <th style="width: 10%;" class="text-right">VAT</th>
            <th style="width: 10%;" class="text-right">Value</th>
          </tr>
          
          
          </thead>
          @php
                $_grand_invoice_qty=0;
                $_grand_invoice_vat_amount=0;
                $_grand_invoice_value=0;
          @endphp
           
          @forelse($group_array_values as $key=>$_group_val)
          @php
                $_group_invoice_qty=0;
                $_group_invoice_vat_amount=0;
                $_group_invoice_value=0;
          @endphp
          <tr>
            <th colspan="9" class="text-left">{!! $key !!}</th>
          </tr>
           
          @forelse($_group_val as $master_key=> $master_val)
          @php
                $_ledger_invoice_qty=0;
                $_ledger_invoice_vat_amount=0;
                $_ledger_invoice_value=0;
              @endphp
            <tr>
            <th colspan="9" class="text-left">{!! $master_key !!}</th>
          </tr>

            @forelse($master_val as $d_key=> $del_val)
              <tr>
                <th colspan="9" class="text-left">
                  <a style="text-decoration: none;" target="__blank" href="{{ url('sales/print',$del_val->id) }}">
                    ID: {!! $del_val->id ?? '' !!}</a> | Date : {!! _view_date_formate($del_val->_date) !!} | Reference : {!! $del_val->_order_ref_id ?? '' !!}
                  </th>
              </tr>
              @php
                $_invoice_qty=0;
                $_invoice_vat_amount=0;
                $_invoice_value=0;
              @endphp
               @forelse($del_val->_master_details as  $_master_details)
               @php
                $_invoice_qty += $_master_details->_qty;
                $_invoice_vat_amount += $_master_details->_vat_amount;
                $_invoice_value +=$_master_details->_value;

                $_ledger_invoice_qty += $_master_details->_qty;
                $_ledger_invoice_vat_amount += $_master_details->_vat_amount;
                $_ledger_invoice_value +=$_master_details->_value;

                $_group_invoice_qty += $_master_details->_qty;
                $_group_invoice_vat_amount += $_master_details->_vat_amount;
                $_group_invoice_value +=$_master_details->_value;

                $_grand_invoice_qty += $_master_details->_qty;
                $_grand_invoice_vat_amount += $_master_details->_vat_amount;
                $_grand_invoice_value +=$_master_details->_value;
              @endphp
              <tr>
                <td class="text-left">{!! $_master_details->_items->_name ?? '' !!}</td>
                <td class="text-left">{!! $_master_details->_store->_name ?? '' !!}</td>
                <td class="text-left">{!! $_master_details->_barcode ?? '' !!}</td>
                <td class="text-left">{!! $_master_details->_items->_units->_name ?? '' !!}</td>
                <td class="text-right">{!! _report_amount($_master_details->_qty ?? 0) !!}</td>
                <td class="text-right">{!! _report_amount($_master_details->_sales_rate ?? 0) !!}</td>
                <td class="text-right">{!! _report_amount($_master_details->_vat ?? 0) !!}</td>
                <td class="text-right">{!! _report_amount($_master_details->_vat_amount ?? 0) !!}</td>
                <td class="text-right">{!! _report_amount($_master_details->_value ?? 0) !!}</td>
              </tr>
            @empty
            @endforelse
            <tr>
              <th colspan="4" class="text-left">Sub Total:</th>
              <th class="text-right">{{_report_amount($_invoice_qty)}}</th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right">{{_report_amount($_invoice_vat_amount)}}</th>
              <th class="text-right">{{_report_amount($_invoice_value)}}</th>
            </tr>
            @empty
            @endforelse
            <tr>
              <th colspan="4" class="text-left">Summary for {!! $master_key !!}</th>
              <th class="text-right">{{ _report_amount($_ledger_invoice_qty) }}</th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right">{{ _report_amount($_ledger_invoice_vat_amount) }}</th>
              <th class="text-right">{{ _report_amount($_ledger_invoice_value) }}</th>
            </tr>
          @empty
          @endforelse
            <tr>
              <th colspan="4" class="text-left">Summary for {!! $key !!}</th>
              <th class="text-right">{{ _report_amount($_group_invoice_qty) }}</th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right">{{ _report_amount($_group_invoice_vat_amount) }}</th>
              <th class="text-right">{{ _report_amount($_group_invoice_value) }}</th>
            </tr>

          @empty
          @endforelse
         <tr>
              <th colspan="4" class="text-left">Grand Total</th>
              <th class="text-right">{{ _report_amount($_grand_invoice_qty) }}</th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right">{{ _report_amount($_grand_invoice_vat_amount) }}</th>
              <th class="text-right">{{ _report_amount($_grand_invoice_value) }}</th>
            </tr>
          
          </tbody>
          <tfoot>
            <tr>
              <td colspan="9">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>
     

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')

@endsection
