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
    <a class="nav-link"  href="{{url('work-sheet')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    <table width="100%">
<tr><td colspan="7" align="center" style="font-size:24px; font-weight:bold">{{$settings->name ?? '' }}</td></tr>
<tr><td colspan="7" align="center" style="font-size:16px;">{{$settings->_address ?? '' }}</td></tr>
<tr><td colspan="7" align="center" style="font-size:16px;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
<tr><td colspan="7" align="center" style="font-size:16px; font-weight:bold">{{$page_name}} </td></tr>
<tr><td colspan="7" align="center" style="font-size:12px; font-weight:bold">As on Date :&nbsp;{{ $previous_filter["_datex"] ?? '' }}</td></tr>
<tr><td colspan="4">{{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}</td></tr>
<tr><td colspan="4"> {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center"] ?? '') }}</td></tr>
</table>
    

    <!-- Table row -->
    <table class="cewReportTable">
          <thead>
          <tr>
            <th style="text-align: left;border-bottom: none;white-space: nowrap;" >Particulars</th>
            <th style="text-align: center;white-space: nowrap;" colspan="2"> TRIAL BALANCE</th>
            <th style="text-align: center;white-space: nowrap;" colspan="2">INCOME STATEMENT</th>
            <th style="text-align: center;white-space: nowrap;" colspan="2">BALANCE SHEET</th>
          </tr>
          <tr>
            <th style="text-align: right;border-top: none;white-space: nowrap;"> </th>
            <th style="text-align: right;white-space: nowrap;">Dr. Amount </th>
            <th style="text-align: right;white-space: nowrap;">Cr. Amount </th>
            <th style="text-align: right;white-space: nowrap;">Expenses</th>
            <th style="text-align: right;white-space: nowrap;">Income</th>
            <th style="text-align: right;white-space: nowrap;">Assets</th>
            <th style="text-align: right;white-space: nowrap;">Liabilities</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
            $trail_dr_total = 0;
            $trail_cr_total = 0;
            $income_dr_total = 0;
            $income_cr_total = 0;
            $balance_dr_total = 0;
            $balance_cr_total = 0;

            @endphp
           @forelse($work_sheet_result as $key=>$value)
           <tr>
             <td style="text-align: left;padding-left: 10px;">{!! $value->_l_name ?? '' !!}</td>
              @if($value->_head_name !=4)
                  @if($value->_amount >= 0)
                          @php
                           $trail_dr_total += $value->_amount;
                          @endphp
                    <td style="text-align: right;"> {{_report_amount(   $value->_amount ) }}</td>
                    <td style="text-align: right;">{{_report_amount( 0 )}} </td>
                    @else
                        @php
                         $trail_cr_total += $value->_amount;
                        @endphp
                    <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                    <td style="text-align: right;"> {{_report_amount(   $value->_amount ) }} </td>
                  @endif
              @else
                <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                <td style="text-align: right;"> {{_report_amount(   0 ) }} </td>
                @if($value->_amount < 0)
                @php
                    $income_dr_total +=abs($value->_amount);
                    $balance_cr_total +=$value->_amount;
                  @endphp
                <td style="text-align: right;"> {{_report_amount( abs($value->_amount) )}}</td>
                 <td style="text-align: right;"> {{_report_amount(   0 ) }} </td>

                <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                 <td style="text-align: right;"> {{_report_amount(   abs($value->_amount) ) }} </td>
                 @else

                 @php
                    $income_cr_total += abs($value->_amount);
                    $balance_dr_total +=$value->_amount;
                  @endphp
                 <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                 <td style="text-align: right;"> {{_report_amount(  abs($value->_amount) ) }} </td>

                 <td style="text-align: right;"> {{_report_amount( abs($value->_amount) )}}</td>
                 <td style="text-align: right;"> {{_report_amount(  0  ) }} </td>
                 @endif
              @endif

              @if($value->_main_head ==4)
                  @php
                    $income_dr_total +=$value->_amount;
                  @endphp
                 <td style="text-align: right;"> {{_report_amount( $value->_amount )}}</td>
                 <td style="text-align: right;"> {{_report_amount(  0  ) }} </td>
              @elseif($value->_main_head ==3)
                  @php
                    $income_cr_total +=$value->_amount;
                  @endphp
                <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                   <td style="text-align: right;"> {{_report_amount(  $value->_amount  ) }} </td>
              @else
                  @if($value->_head_name !=4)
                   <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                   <td style="text-align: right;"> {{_report_amount(  0  ) }} </td>
                   @endif
              @endif


               @if($value->_main_head ==2 || $value->_main_head ==5 || $value->_main_head ==1)

                  @if($value->_amount >= 0)
                        @php
                          $balance_dr_total +=$value->_amount;
                        @endphp
                       <td style="text-align: right;"> {{_report_amount( $value->_amount )}}</td>
                       <td style="text-align: right;"> {{_report_amount(  0  ) }} </td>
                  @else
                        @php
                          $balance_cr_total +=$value->_amount;
                        @endphp
                        <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                        <td style="text-align: right;"> {{_report_amount(  $value->_amount  ) }} </td>
                  @endif



               @else
                    @if($value->_head_name !=4)
                   <td style="text-align: right;"> {{_report_amount( 0 )}}</td>
                   <td style="text-align: right;"> {{_report_amount(  0  ) }} </td>
                   @endif
               @endif



             
            
           </tr>


           @empty
           @endforelse
                  
           <tr class="cewSubHeader">
             <td style="text-align: left;padding-left: 10px;">Grand Total</td>
             <td style="text-align: right;font-weight: bold;">{{_report_amount(  $trail_dr_total )}} </td>
             <td style="text-align: right;font-weight: bold;"> {{_report_amount(  $trail_cr_total )}}</td>
             <td style="text-align: right;font-weight: bold;">{{_report_amount(  $income_dr_total )}} </td>
             <td style="text-align: right;font-weight: bold;"> {{_report_amount(  $income_cr_total )}}</td>
             <td style="text-align: right;font-weight: bold;"> {{_report_amount(  $balance_dr_total )}}</td>
             <td style="text-align: right;font-weight: bold;"> {{_report_amount(  $balance_cr_total )}}</td>
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

<script type="text/javascript">

 function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


        }
         

</script>
@endsection
