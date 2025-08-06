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
    <a class="nav-link"  href="{{url('income-statement')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
  <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                   {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
        </div>
      </div>

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
            <th style="width: 15%;">Group</th>
            <th style="width: 40%;">Ledger</th>
            <th style="width: 15%;" class="text-right">Upto Previous </th>
            <th style="width: 15%;" class="text-right">Current Period</th>
            <th style="width: 15%;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
            $i8_previous_total = 0;
            $i8_current_total = 0;
            $net_total =0;
            @endphp
           @forelse($income_8 as $i8_key=>$i8_value)
           @php
            $i8_previous_sub_total=0;
            $i8_current_sub_total=0;
            $i8_balance_sub_total=0;
           @endphp
           <tr >
             <td colspan="5" style="text-align: left;" ><b>{{$i8_key}}</b></td>
           </tr>
            @forelse($i8_value as $i_val)
            @php
              $i8_previous_total += $i_val->_previous_balance ?? 0;
              $i8_current_total += $i_val->_current_balance ?? 0;
              $net_total += $i_val->_last_amount ?? 0;



              $i8_previous_sub_total += $i_val->_previous_balance ?? 0;
              $i8_current_sub_total += $i_val->_current_balance ?? 0;
              $i8_balance_sub_total += $i_val->_last_amount ?? 0;


            @endphp
            
                   <tr>
                     <td colspan="2" style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $i_val->_l_name ?? '' }}</td>
                     <td style="text-align: right;">{{ _report_amount( $i_val->_previous_balance ?? 0)  }}</td>
                     <td style="text-align: right;">{{ _report_amount( $i_val->_current_balance ?? 0) }}</td>
                     <td style="text-align: right;">{{ _report_amount( $i_val->_last_amount ?? 0 ) }}</td>
                   </tr>
            @empty
            @endforelse
            @if(sizeof($i8_value)> 1 )
            <tr>
             <td style="text-align: left;" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;Sub Total:  </b></td>
             <td style="text-align: right;"><b>{{ _report_amount($i8_previous_sub_total ?? 0) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $i8_current_sub_total ?? 0 ) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $i8_balance_sub_total ?? 0 ) }}</b></td>
           </tr>
           @endif

           @empty
           @endforelse

           <tr>
             <td style="text-align: left;" colspan="2"><b>Summary for Gross Profit:  </b></td>
             <td style="text-align: right;"><b>{{ _report_amount($i8_previous_total ?? 0) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $i8_current_total ?? 0 ) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $net_total ?? 0 ) }}</b></td>
           </tr>
           <tr >
                   <td colspan="5" style="text-align: left;" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
                 </tr>
            @php
            $oi_previous_total = 0;
            $oi_current_total = 0;
            $oi_amount_total =0;
            @endphp
           @forelse($other_income_expenses as $oi_key=>$oi_value)
           @php
            $oi_previous_sub_total =0;
            $oi_current_sub_total =0;
            $oi_balance_sub_total =0;
           @endphp
                <tr >
                   <td colspan="5" style="text-align: left;" ><b>{{$oi_key}}</b></td>
                 </tr>

                  @forelse($oi_value as $oi_val)
                   @php
                    $oi_previous_sub_total +=$oi_val->_previous_balance ?? 0;
                    $oi_current_sub_total +=$oi_val->_current_balance ?? 0;
                    $oi_balance_sub_total +=$oi_val->_last_amount ?? 0;


                    $oi_previous_total +=$oi_val->_previous_balance ?? 0;
                    $oi_current_total +=$oi_val->_current_balance ?? 0;
                    $oi_amount_total +=$oi_val->_last_amount ?? 0;
                   @endphp
                    <tr>
                     <td colspan="2" style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $oi_val->_l_name ?? '' }}</td>
                     <td style="text-align: right;">{{ _report_amount( $oi_val->_previous_balance ?? 0)  }}</td>
                     <td style="text-align: right;">{{ _report_amount( $oi_val->_current_balance ?? 0) }}</td>
                     <td style="text-align: right;">{{ _report_amount( $oi_val->_last_amount ?? 0 ) }}</td>
                   </tr>

                  @empty
                  @endforelse
                  @if(sizeof($oi_value)> 1 )
                      <tr>
                       <td style="text-align: left;" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;Sub Total:  </b></td>
                       <td style="text-align: right;"><b>{{ _report_amount($oi_previous_sub_total ?? 0) }}</b></td>
                       <td style="text-align: right;"><b>{{ _report_amount( $oi_current_sub_total ?? 0 ) }}</b></td>
                       <td style="text-align: right;"><b>{{ _report_amount( $oi_balance_sub_total ?? 0 ) }}</b></td>
                     </tr>
                     @endif
           @empty
           @endforelse
           <tr>


             <td style="text-align: left;" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;Summary :  </b></td>
             <td style="text-align: right;"><b>{{ _report_amount($oi_previous_total ?? 0) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $oi_current_total ?? 0 ) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $oi_amount_total ?? 0 ) }}</b></td>
           </tr>
           <tr>
             <td style="text-align: left;" colspan="2"><b>Net Profit\Loss :  </b></td>
             <td style="text-align: right;"><b>{{ _report_amount($i8_previous_total + $oi_previous_total ?? 0) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $i8_current_total + $oi_current_total ?? 0 ) }}</b></td>
             <td style="text-align: right;"><b>{{ _report_amount( $net_total + $oi_amount_total ?? 0 ) }}</b></td>
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
