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
    <a class="nav-link"  href="{{url('barcode-history')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Barcode:{{ $previous_filter["_barcode"] ?? '' }} </strong></td> </tr>
               
              </table>
            </td>
            
          </tr>
        </table>

    <!-- Table row -->
    <table class="cewReportTable">
          <thead>
          <tr>
            <th>Type</th>
            <th>Date</th>
            <th>ID</th>
            <th>Ledger Name</th>
            <th>Item Name</th>
            <th>Barcode</th>
            <th>Warranty</th>
            <th >QTY</th>
            <th >Rate</th>
            <th >Sales Rate</th>
            <th >Branch</th>
            <th >Store</th>
          </tr>
          
          
          </thead>
          <tbody>
           
                  @forelse($datas as $_dkey=>$detail)
                    <tr>
                    <td style="text-align: left;">{{$detail->_type ?? '' }} </td>
                    <td style="text-align: left;white-space: nowrap;">{{ _view_date_formate($detail->_date ?? '') }} </td>
                    <td class="text-center" style="white-space: nowrap;">
                    @if($detail->_table_name=="purchases")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('purchase/print',$detail->_id) }}">
                  P-{!! $detail->_id ?? '' !!}</a>
                    @endif
                   
                    @if($detail->_table_name=="purchases_return")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('purchase-return/print',$detail->_id) }}">
                  PR-{!! $detail->_id ?? '' !!}</a>
                    @endif
                   
                    @if($detail->_table_name=="sales")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('sales/print',$detail->_id) }}">
                  S-{!! $detail->_id ?? '' !!}</a>
                    @endif
                    
                    @if($detail->_table_name=="sales_return")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('sales-return/print',$detail->_id) }}">
                  SR-{!! $detail->_id ?? '' !!}</a>
                    @endif
                   
                    @if($detail->_table_name=="damage")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('damage/print',$detail->_id) }}">
                  DM-{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="replacement_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('item-replace/print',$detail->_id) }}">
                  RP-{!! $detail->_id ?? '' !!}</a>
                    @endif
             </td>
                    <td style="text-align: left;">{{ _ledger_name($detail->_ledger_id) }} </td>
                    <td style="text-align: left;">{{ _item_name($detail->_item_id ) }} </td>
                    <td style="text-align: left;">{{ $previous_filter["_barcode"] ?? '' }} </td>
                    <td style="text-align: left;">{{ $detail->_w_name ?? '' }} </td>
                    <td style="text-align: left;">{{ $detail->_qty ?? '' }} (1) </td>
                    <td style="text-align: left;">{{ _report_amount($detail->_rate ?? 0) }} </td>
                    <td style="text-align: left;">{{ _report_amount($detail->_sales_rate ?? 0) }} </td>
                    <td style="text-align: left;">{{ _branch_name($detail->_branch_id ?? 0) }} </td>
                    <td style="text-align: left;">{{ _store_name($detail->_store_id ?? 0) }} </td>

                  </tr>

                  @empty
                  @endforelse

                  
            
          
          </tbody>
          <tfoot>
            <tr>
              <td colspan="12">
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
