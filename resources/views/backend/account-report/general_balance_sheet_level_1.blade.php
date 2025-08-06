@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
}
._report_header_tr{
  line-height: 16px !important;
}
  </style>
    <div class="_report_button_header">
      <a class="nav-link"  href="{{url('general_balance-sheet')}}" role="button"><i class="fas fa-search"></i></a>
      <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
    
    </div>

<section class="invoice" id="printablediv">
    
   
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 10%;text-align: left;">
              
            </td>
            <td style="border:none;width: 80%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>As on Date :&nbsp;{{ $previous_filter["_datex"] ?? '' }} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                   {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            <td style="border:none;width: 10%;text-align: right;">
              <p class="text-right">Print: {{date('d-m-Y H:s:a')}}</p>
            </td>
          </tr>
        </table>
        </div>
      </div>
    <!-- /.row -->

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
            <th style="width: 80%;">Particulars</th>
            <th style="width: 20%;padding-right: 10px;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
             @php
            $total_liabilites = 0;
             $total_liabilites_capital = 0;
             $capital_li=["Capital","Liability"];
           @endphp
           @forelse($balance_sheet_filter as $l_1key=>$l_1_value)
           @php
            $summary_l1 = 0;
           @endphp
                   <tr>
                     <td colspan="2" style="text-align: left;"><b>{!! $l_1key !!}</b></td>
                   </tr>
                   @forelse($l_1_value as $l_2key=>$l2value)
                   @php
                    $summary_l2 = 0;
                   @endphp
                   <tr>
                     <td colspan="2" style="text-align: left;"><b>&nbsp; &nbsp;{!! $l_2key !!}</b></td>
                   </tr>

                   @forelse($l2value as $l_3key=>$l3value)
                     @php
                      $summary_l3 = 0;
                     @endphp
                     
                     @forelse($l3value as $l_4key=>$l_4value)
                     @php

                      $summary_l1 +=$l_4value->_amount ?? 0; 
                      $summary_l2 +=$l_4value->_amount ?? 0;
                      $summary_l3 +=$l_4value->_amount ?? 0;
                      $total_liabilites +=$l_4value->_amount ?? 0;
                       if(in_array($l_1key,$capital_li)){
                      $total_liabilites_capital += $l_4value->_amount ?? 0;
                    }

                     @endphp
                     @if($previous_filter["_level"] !="Level 1")
                          <tr>
                             <td  style="text-align: left;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;{!! $l_4value->_l_name ?? '' !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_4value->_amount ?? 0 ))  !!}</td>
                           </tr>
                      @endif
                     @empty
                     @endforelse
                     
                    
                   <tr>
                     <td style="text-align: left;">&nbsp; &nbsp; {!! $l_3key !!}</td>
                     <td style="text-align: right;padding-right: 10px;"> {!! _show_amount_dr_cr(_report_amount(  $summary_l3 ))  !!}</td>
                   </tr>
                  

                   @empty
                   @endforelse

                   @if(sizeof($l_1_value) > 1)
                   <tr>
                     <td style="text-align: left;"><b>&nbsp; &nbsp;Sub Total for {!! $l_2key !!}:</b></td>
                     <td style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $summary_l2 ))  !!}</b></td>
                   </tr>
                   @endif

                   @empty
                   @endforelse
                   <tr>
                     <td style="text-align: left;"><b>Summary for {!! $l_1key !!}:</b></td>
                     <td style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $summary_l1 ))  !!}</b></td>
                   </tr>
                   

           @empty
           @endforelse
           @if($total_liabilites !=0)
           <tr>
                     <td class="text-left">Diffrance of Balance Sheet</td>
                     <td class="text-right">{{_show_amount_dr_cr(_report_amount($total_liabilites))}}</td>
            </tr>
            @endif
            <tr>
                     <td class="text-left"><b>Total Capital & Liabilities</b></td>
                     <td class="text-right"><b>{{_show_amount_dr_cr(_report_amount($total_liabilites_capital))}}</b></td>
            </tr>      


          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                <div class="row">
                   @include('backend.message.invoice_footer')
                </div>
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
