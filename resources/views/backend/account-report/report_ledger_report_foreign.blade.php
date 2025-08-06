
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('filter-report-foreign_amount')}}" role="button"><i class="fas fa-search"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
   
    <table class="cewReportTable" style="border: none;">
          <thead>
    <tr style="border: none;">
        <td colspan="2" style="width:25%;text-align: center;border: none;background: #fff;">
          <img src="{{asset($settings->logo ?? '')}}" style="width:100px;" alt="Logo">
        </td>
        <td  colspan="3" style="width: 50%;text-align: center;border: none;background: #fff;">
          <h3><b>{{ $settings->name ?? '' }}</b></h3>
          
          <address>{!! $settings->_address ?? '' !!}</address>
        </td>
        <td colspan="2" style="width:25%;text-align: center;border: none;background: #fff;">
          Phone:{!! $settings->_phone ?? '' !!}<br>
         <span><a href= "mailto: {!! $settings->_email ?? '' !!}" style="text-decoration: none;color: #000;">{!! $settings->_email ?? '' !!}</a></span> 
        </td>
      </tr>
      <tr style="border: none;">
        <td style="text-align:center;background: #fff;border: none;"></td>
        <td colspan="5" style="text-align:center;background: #fff;border: none;">
          <h3>{!! $page_name ?? '' !!}</h3>
           <h4>{!! _ledger_name($ledger_id_rows) !!}</h4>
          <h5 class="text-center"><small>Date: {{ _view_date_formate($request->_datex ?? '') }} To {{ _view_date_formate($request->_datey ?? '') }}</small></h5>
        </td>
        <td style="text-align:center;background: #fff;border: none;">
             {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
             <br>
             {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}
        </td>
      </tr>

          <tr>
            @php
            $colspan=4;
            $_less=0;
            $grand_colspan =1;
             
            @endphp
            <th style="width: 8%;border:1px solid silver;">Date</th>
            
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
            <th style="width: 8%;border:1px solid silver;">ID</th>
           
            <th style="width: 20%;border:1px solid silver;">Short Narration</th>
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
          
           
            <th style="width: 20%;border:1px solid silver;">Narration</th>
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
            
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
               
                    <td class="text-left" style="width: 7%;">
                    @if($detail->_table_name=="voucher_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('voucher/print',$detail->_id) }}">
                {{ $detail->_voucher_code ?? '' }}</a>
                    @else
                    {{ $detail->_voucher_code ?? _id_to_order_number($detail->_id,'voucher_masters') }}
                    @endif
                    
                    
                  </td>
            
             
           
                    <td style="text-align: left;width: 20%;">{{ $detail->_short_narration ?? '' }} </td>
                    <td style="text-align: left;width: 20%;">{{ $detail->_narration ?? '' }} <br>
                    @if($detail->_table_name=="voucher_masters")
                      {!! find_vouchar_check_infos($detail->_id) !!}
                    @endif
                    </td>
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
          <tfoot style="border:0px solid #fff !important;">
            <tr style="border:0px solid #fff !important;">
              <td colspan="{{$colspan}}" style="border:0px solid #fff !important;">
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