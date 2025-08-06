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
      <a class="nav-link"  href="{{url('balance-sheet')}}" role="button"><i class="fas fa-search"></i></a>
      <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
    
    </div>

<section class="invoice" id="printablediv">
    
   
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 25%;text-align: left;">
              
            </td>
            <td style="border:none;width: 50%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>DATE :&nbsp;{{ $previous_filter["_datex"] ?? '' }} TO  {{ $previous_filter["_datey"] ?? '' }}</b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                  
                  <b>
                    @foreach($permited_branch as $p_branch)
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach </b></td> </tr>
  <tr>
    <td><b>{{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"]) }} </b></td>
  </tr>
                      <tr>
                        <td class="_report_header_tr text-center" style="border:none;">Print: {{date('d-m-Y H:s:a')}}</td>
                      </tr>
              </table>
            </td>
            <td style="border:none;width: 25%;text-align: right;">
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
            <th style="width: 55%;">Particulars</th>
            <th style="width: 15%;padding-right: 10px;" class="text-right" >Upto Date</th>
            <th style="width: 15%;padding-right: 10px;" class="text-right" >Current Period</th>
            <th style="width: 15%;padding-right: 10px;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
             @php
             
             $opining_diff=0;
            $running_diff=0;
            $total_liabilites = 0;
            $total_liabilites_uptodate = 0;
            $total_liabilites_current = 0;
            $total_liabilites_capital = 0;
            $total_liabilites_capital_uptodate= 0;
            $total_liabilites_capital_current= 0;
             $capital_li=["Capital","Liability"];
           @endphp
           @forelse($balance_sheet_filter as $l_1key=>$l_1_value)
           @php
           $summary_l1_uptodate = 0;
           $summary_l1_current= 0;
            $summary_l1 = 0;
           @endphp
                   <tr>
                     <td colspan="2" style="text-align: left;"><b>{!! $l_1key !!}</b></td>
                   </tr>
                   @forelse($l_1_value as $l_2key=>$l2value)
                    @php
                    $summary_l2 = 0;
                    $summary_l2_uptodate = 0;
                    $summary_l2_current = 0;
                   @endphp
                   <tr>
                     <td colspan="2" style="text-align: left;"><b>&nbsp; &nbsp;{!! $l_2key !!}</b></td>
                   </tr>

                   @forelse($l2value as $l_3key=>$l3value)
                     @php
                      $summary_l3 = 0;
                      $summary_l3_uptodate =0;
                      $summary_l3_current =0;
                     @endphp
                     
                     @forelse($l3value as $l_4key=>$l_4value)
                      @php

                      $summary_l1             +=$l_4value->_balance ?? 0; 
                      $summary_l1_uptodate    +=$l_4value->_opening_amount ?? 0;
                      $summary_l1_current     +=$l_4value->_amount ?? 0; 


                      $summary_l2 +=$l_4value->_balance ?? 0;
                      $summary_l2_uptodate +=$l_4value->_opening_amount ?? 0;
                      $summary_l2_current    +=$l_4value->_amount ?? 0;

                      $summary_l3_uptodate +=$l_4value->_opening_amount ?? 0;
                      $summary_l3_current  +=$l_4value->_amount ?? 0;
                      $summary_l3 +=$l_4value->_balance ?? 0;


                      
                $opining_diff +=$l_4value->_opening_amount ?? 0;
                $running_diff +=$l_4value->_amount ?? 0;
                       $total_liabilites +=$l_4value->_balance ?? 0;

                     if(in_array($l_1key,$capital_li)){
                     $total_liabilites_uptodate +=$l_4value->_opening_amount ?? 0;
                     $total_liabilites_capital_current  +=$l_4value->_amount ?? 0;
                     $total_liabilites_capital +=$l_4value->_balance ?? 0;
                    
                     
                      /*$total_liabilites_capital_uptodate  +=$l_4value->_opening_amount ?? 0;
                      $total_liabilites_capital_current  +=$l_4value->_amount ?? 0;
                      $total_liabilites +=$l_4value->_amount ?? 0;
                      $total_liabilites_uptodate +=$l_4value->_opening_amount ?? 0;
                      $total_liabilites_current +=$l_4value->_amount ?? 0;
                      $total_liabilites_capital += $l_4value->_balance ?? 0;
                      */

                      
                    }

                     @endphp
                     @if($previous_filter["_level"] !="Level 1")
                           <tr>
                             <td  style="text-align: left;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;{!! $l_4value->_l_name ?? '' !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_4value->_opening_amount ?? 0 ))  !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_4value->_amount ?? 0 ))  !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_4value->_balance ?? 0 ))  !!}</td>
                           </tr>
                      @endif
                     @empty
                     @endforelse
                     
                    
                   <tr>
                     <td style="text-align: left;">&nbsp; &nbsp;&nbsp; &nbsp; {!! $l_3key !!}</td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $summary_l3_uptodate ))  !!}</td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $summary_l3_current ))  !!}</td>
                     <td style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $summary_l3 ))  !!}</b></td>
                   </tr>
                  

                   @empty
                   @endforelse

                   @if(sizeof($l_1_value) > 1)
                   <tr>
                     <td style="text-align: left;"><b>&nbsp; &nbsp;&nbsp; &nbsp;Sub Total for {!! $l_2key !!}:</b></td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $summary_l2_uptodate ))  !!}</td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $summary_l2_current ))  !!}</td>
                     <td style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $summary_l2 ))  !!}</b></td>
                   </tr>
                   @endif

                   @empty
                   @endforelse
                   <tr>
                     <td style="text-align: left;"><b>Summary for {!! $l_1key !!}:</b></td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $summary_l1_uptodate ))  !!}</td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $summary_l1_current ))  !!}</td>
                     <td style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $summary_l1 ))  !!}</b></td>
                   </tr>
                   

           @empty
           @endforelse
           @if($total_liabilites !=0)
            <tr>
                     <td class="text-left">Diffrance of Balance Sheet</td>
                     <td style="text-align: right;font-weight: bold;">{{_show_amount_dr_cr(_report_amount($opining_diff))}}</td>
                     <td style="text-align: right;font-weight: bold;">{{_show_amount_dr_cr(_report_amount($running_diff))}}</td>
                     <td class="text-right">{{_show_amount_dr_cr(_report_amount($total_liabilites))}}</td>
            </tr>
            @endif
             <tr>
                     <td class="text-left"><b>Total Capital & Liabilities</b></td>
                     <td style="text-align: right;font-weight: bold;">{{_show_amount_dr_cr(_report_amount($total_liabilites_uptodate))}}</td>
                     <td style="text-align: right;font-weight: bold;">{{_show_amount_dr_cr(_report_amount($total_liabilites_capital_current))}}</td>
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
