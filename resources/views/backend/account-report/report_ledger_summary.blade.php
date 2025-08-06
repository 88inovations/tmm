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
    <a class="nav-link"  href="{{url('filter-ledger-summary')}}" role="button">
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>AS ON Date:{{ date('d-m-y') }} </strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}</td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
            
            <th style="border:1px solid silver;" class="text-left" >SL</th>
            <th style="border:1px solid silver;" class="text-left" >Ledger Name</th>
            <th style="border:1px solid silver;" class="text-left" >Address</th>
            <th style="border:1px solid silver;" class="text-left" >Phone</th>
            <th style="border:1px solid silver;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
            $_grand_total = 0;
            @endphp
           @forelse($group_array_values as $key=>$value)
            @php
            $_group_total = 0;
            @endphp
           <tr>
             <td colspan="5" class="text-left"><b>{{$key}}</b></td>
           </tr>
           @forelse($value as $_ledger_key=>$_ledger_info)
          
           @php
            $_group_total += $_ledger_info->_balance ?? 0;
            $_grand_total += $_ledger_info->_balance ?? 0;
            @endphp
            <tr>
              <td >{{( $_ledger_key +1 )}}</td>
              <td> {{ $_ledger_info->_l_name ?? '' }}</td>
              <td> {{ $_ledger_info->_address ?? '' }}</td>
              <td> {{ $_ledger_info->_phone ?? '' }}</td>
              <td class="text-right"> {{ _show_amount_dr_cr(_report_amount( $_ledger_info->_balance ?? 0 )) }}  </td>
            </tr>

           @empty
           @endforelse

           <tr>
             <td  colspan="4" class="text-left"><b>Summary of {{$key}}</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $_group_total )) }} </td>
           </tr>
           @empty
           @endforelse
           <tr>
             <td colspan="4"  class="text-left"><b>Grand Total</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $_grand_total )) }} </td>
           </tr>
          
          </tbody>
          
        </table>
      

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
