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
    <a class="nav-link"  href="{{url('single-stock-ledger')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice " id="printablediv">
    

        <table class="table" style="border:none;width: 100%;">
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
  @endforeach </b></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
            <th style="white-space: nowrap;">Inventory </th>
            <th style="white-space: nowrap;">ID</th>
            <th style="white-space: nowrap;">Date</th>
            <th style="white-space: nowrap;">Unit</th>
            <th style="white-space: nowrap;" class="text-right">Stock In</th>
            <th style="white-space: nowrap;" class="text-right">Stock Out</th>
            <th style="white-space: nowrap;" class="text-right">Balance</th>
          </tr>
          
          
          
          
          </thead>
          <tbody>
            @php
             
              $_total_stockin = 0;
              $_total_stockout = 0;
              $_total_balance = 0;
              $row_counter = 0;
              $_sub_total_balance = 0;
               
            @endphp
            
            
            @forelse($datas as $key=> $g_value)

            @php
              $row_counter +=1;
              $_total_stockin += $g_value->_stockin;
              $_total_stockout += $g_value->_stockout;
              $_total_balance += ($g_value->_balance);

               $_sub_total_balance += ($g_value->_balance);

            @endphp
@if($key ==0)
          <tr>
            <th style="white-space: nowrap;" colspan=""> {!! $g_value->_name ?? '' !!}</th>
          </tr>
@endif

            <tr>
             

            <td style="text-transform: capitalize;white-space: nowrap;">{!! $g_value->_transection ?? '' !!} </td>
            <td style="width: 10%;white-space: nowrap;">
             
{!! _link_for_item_inventory($g_value->_transection_ref,$g_value->_transection) !!}


              </td>
            <td style="width: 10%;white-space: nowrap;">{!! _view_date_formate($g_value->_date ?? '') !!}</td>
            <td style="width: 10%;">{!! _find_unit($g_value->_unit_id) !!}</td>
            <td style="width: 10%;white-space: nowrap;" class="text-right">{!! _report_amount($g_value->_stockin) !!}</td>
            <td style="width: 10%;white-space: nowrap;" class="text-right">{!! _report_amount($g_value->_stockout) !!}</td>
            <td style="width: 10%;white-space: nowrap;" class="text-right">{{ _report_amount( $_sub_total_balance) }}</td>
          </tr>
          @empty
          @endforelse

          <tr>
           

            <th colspan="4" class="text-left">Grand Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_stockin) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_stockout) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_balance) !!}</th>
          </tr>
            
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="7">
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
