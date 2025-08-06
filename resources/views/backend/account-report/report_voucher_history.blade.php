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
    <a class="nav-link"  href="{{url('filter-voucher-history')}}" role="button">
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date: {{ _view_date_formate($request->_datex ?? '') }} To {{ _view_date_formate($request->_datey ?? '') }} </strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                    {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center"] ?? '') }}
                 </td> </tr>
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
           <th style="border:1px solid silver;width: 10%;" class="text-left" >ID</th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Date </th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Ledger </th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Narration</th>
           <th style="border:1px solid silver;width: 20%;" class="text-left" >REF:</th>
            <th style="border:1px solid silver;width: 10%;" class="text-right" >Dr.Amount </th>
            <th style="border:1px solid silver;width: 10%;" class="text-right" >Cr.Amount </th>
          </tr>
          
          
          </thead>
          <tbody>
             
             @php
              $_sub_total_dr_amount =0;
              $_sub_total_cr_amount =0;
             @endphp
             @forelse($datas as $key=> $value)
             @php
              $_sub_total_dr_amount +=$value->_dr_amount ?? 0;
              $_sub_total_cr_amount +=$value->_cr_amount ?? 0;
             @endphp
             <tr>
              
               <td>
                
                  {!! _make_link_for_account($value->_table_name,$value->_id,$value->_voucher_code ?? $value->_id ) !!}
               </td>
               
               <td> {{ _view_date_formate($value->_date ?? '') }}</td>
               <td>{{_ledger_name($value->_account_ledger)}}</td>
               <td>{{$value->_narration ?? 'N/A'}}</td>
               <td>{{$value->_reference ?? ''}}</td>
               
               <td class="text-right">{{ _report_amount(  $value->_dr_amount ?? 0 ) }}</td>
               <td class="text-right">{{ _report_amount(  $value->_cr_amount ?? 0 ) }}</td>
             </tr>
             @empty
             @endforelse
             <tr>
               <td colspan="5"><b>Total</b></td>
               <td class="text-right"><b>{{ _report_amount(  $_sub_total_dr_amount ?? 0 ) }}</b></td>
               <td class="text-right"><b>{{ _report_amount(  $_sub_total_cr_amount ?? 0 ) }}</b></td>


             </tr>

           
           
          
          </tbody>
          
        </table>

      

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
