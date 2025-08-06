
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
    <a class="nav-link"  href="{{url('ledger-report')}}" role="button"><i class="fas fa-search"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->
    
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <h2 class="page-header">
            {{$settings->name ?? '' }}
          <small class="float-right"></small>
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
      <div class="invoice-col" style="width:100%;white-spcae:nowrap;">
        <h3 class="text-center" style="font-size:24px;"><b>{!! _ledger_name($ledger_id_rows) !!}</b> </h3>
        </div>
        @php
        $_alious = $ledger_info->_alious ?? '';
        @endphp
        @if($_alious !='')
       <h5 class="text-center">Proprietor: {{ $ledger_info->_alious ?? '' }}</h5> 
        @endif
        <h5 class="text-center"><small>Date: {{ _view_date_formate($request->_datex ?? '') }} To {{ _view_date_formate($request->_datey ?? '') }}</small></h5>
          <h5 class="text-center"><b>Ledger Report</b></h5>
          <h6 class="text-center"> {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }} </h6>
          <h6 class="text-center">  {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }} </h6>

      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
        <b>Group Name: {!! $ledger_info->account_group->_name ?? '' !!} </b><br>
        <b>Address: {{ $ledger_info->_address ?? '' }}</b><br>
        
        <b>Phone:</b> {{ $ledger_info->_phone ?? '' }}<br>
        <b>Email:</b> {{ $ledger_info->_email ?? '' }}<br>
       
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <table class="cewReportTable">
          <thead>
          <tr>
            @php
            $colspan=4;
            $_less=0;
            $grand_colspan =1;
             
            @endphp
            <th style="width: 8%;border:1px solid silver;">Date</th>
            @if(isset($previous_filter['_check_id']))
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
            <th style="width: 8%;border:1px solid silver;">ID</th>
            @else
            
            @endif

            @if(isset($previous_filter['short_naration']))
            <th style="width: 20%;border:1px solid silver;">Short Narration</th>
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
           @else
            
            @endif
            @if(isset($previous_filter['naration']))
            <th style="width: 20%;border:1px solid silver;">Narration</th>
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
            @else
            
            @endif
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Dr. Amount</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Cr. Amount</th>
            <th style="width: 15%;border:1px solid silver;" class="text-right" >Balance</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
            $_dr_grand_total = 0;
            $_cr_grand_total = 0;
            $_total_balance = 0;
            @endphp
            @forelse($group_array_values as $key=>$value)
            <tr>
              
                
            </tr>
                @forelse($value as $l_key=>$l_val)

               
                  @php
                    $running_sub_dr_total=0;
                    $running_sub_cr_total=0;
                    $runing_balance_total = 0;
                  @endphp
                  @forelse($l_val as $_dkey=>$detail)
                  @php
                    $_dr_grand_total +=$detail->_dr_amount ?? 0;
                    $_cr_grand_total +=$detail->_cr_amount ?? 0;
                    $running_sub_dr_total +=$detail->_dr_amount ?? 0;
                    $running_sub_cr_total +=$detail->_cr_amount ?? 0;
                    $runing_balance_total += (($detail->_balance+$detail->_dr_amount)-$detail->_cr_amount);
                    $_total_balance += (($detail->_balance+$detail->_dr_amount)-$detail->_cr_amount);
                  @endphp
                  
                    <tr>
                    <td style="width: 8%;text-align: left;">
                      
                      {{ _view_date_formate($detail->_date ?? $_datex) }} </td>
                       @if(isset($previous_filter['_check_id']))
                 <td class="text-left" style="width: 7%;white-space: nowrap;">
                     {!! _make_link_for_account($detail->_table_name,$detail->_id,$detail->_voucher_code ?? $detail->_id ) !!}
                    
             </td>
             @endif
             
             @if(isset($previous_filter['short_naration']))
                    <td style="text-align: left;width: 20%;">{{ $detail->_short_narration ?? '' }} </td>
              @endif
             @if(isset($previous_filter['naration']))
                    <td style="text-align: left;width: 20%;">{{ $detail->_narration ?? '' }} </td>
            @endif
                    <td style="text-align: right;width: 10%;">{{ _report_amount($detail->_dr_amount ?? 0) }} </td>
                    <td style="text-align: right;width: 10%;">{{ _report_amount($detail->_cr_amount ?? 0) }} </td>
                    <td style="text-align: right;width: 15%;">{{ _show_amount_dr_cr(_report_amount(  $runing_balance_total )) }} </td>

                  </tr>

                  @empty
                  @endforelse

                 
                

                @empty
                @endforelse



              
            <tr>
                 <td colspan="{{$colspan}}"></td>
            </tr>

            @empty
            @endforelse
            <tr>
              
                <td colspan="{{($grand_colspan)}}" style="text-align: left;background: #f5f9f9;"><b>Grand Total </b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_report_amount($_dr_grand_total) }}</b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_report_amount($_cr_grand_total) }}</b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_show_amount_dr_cr(_report_amount($_total_balance)) }}</b> </td>
            </tr>
          
          </tbody>
          <tfoot>
            <tr>
              <td colspan="{{$colspan}}">
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