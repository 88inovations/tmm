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

.level_1bg{
  background-color:#3498db42;
}
.level_2bg{
 background-color: #17a2b878;
}
.level_3bg{
 background-color: #00bc8c6b;
}
.level_4bg{
 background-color: #20c99729;
}
.level_5bg{
 background-color:#ffc10724;
}
._red_bg{
 background-color:red;
 font-weight: bold;
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
             {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }} </td> </tr>
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
          $total_amount_with_dr_cr_opening=0;
          $total_amount_with_dr_cr_running=0;
          $total_amount_with_dr_cr_balance=0;
           @endphp
           @forelse($balance_sheet_filter as $l_1key=>$l_1_value)
          
                   <tr class="level_1bg">
                     <td colspan="4" style="text-align: left;"><b>
                       @if($l_1key==1) ASSETS @else LIABILITIES & EQUITY @endif
                     </b></td>
                   </tr>
          @php
          $l_1_total_amount_with_dr_cr_opening=0;
          $l_1_total_amount_with_dr_cr_running=0;
          $l_1_total_amount_with_dr_cr_balance=0;
          @endphp
                   @forelse($l_1_value as $l_2key=>$l2value)
                    
                   <tr class="level_2bg">
                     <td colspan="4" style="text-align: left;"><b>&nbsp; &nbsp;{!! id_wise_name($l_2key,'main_account_head','_name') !!}</b></td>
                   </tr>  <!-- Level 2 Name  -->

          @php
          $l2_total_amount_with_dr_cr_opening=0;
          $l2_total_amount_with_dr_cr_running=0;
          $l2_total_amount_with_dr_cr_balance=0;
          @endphp

                   @forelse($l2value as $l_3key=>$l3value)
                     <tr class="level_3bg">
                     <td colspan="4" style="text-align: left;"><b>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;{!! $l_3key ?? '' !!}</b></td>
                   </tr>   <!-- Level 3 Key Name -->

            @php
          $l3_total_amount_with_dr_cr_opening=0;
          $l3_total_amount_with_dr_cr_running=0;
          $l3_total_amount_with_dr_cr_balance=0;
          @endphp
                     
                     @forelse($l3value as $l_4key=>$l_4value)

                     @php
          $l_4_total_amount_with_dr_cr_opening=0;
          $l_4_total_amount_with_dr_cr_running=0;
          $l_4_total_amount_with_dr_cr_balance=0;
          @endphp
                     
                   <tr class="level_4bg display_none">
                     <td colspan="4" style="text-align: left;"><b>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;{!! $l_4key ?? '' !!}</b></td>
                        </tr>   <!-- Level 4 Key Name -->
                     
                     @forelse($l_4value as $l_5key=>$l_5value)

          @php
          $total_amount_with_dr_cr_opening +=$l_5value->_opening_amount ?? 0;
          $total_amount_with_dr_cr_running +=$l_5value->_amount ?? 0;
          $total_amount_with_dr_cr_balance +=$l_5value->_balance ?? 0;
         
          $l_1_total_amount_with_dr_cr_opening +=$l_5value->_opening_amount ?? 0 ;
          $l_1_total_amount_with_dr_cr_running +=$l_5value->_amount ?? 0;
          $l_1_total_amount_with_dr_cr_balance +=$l_5value->_balance ?? 0;
         
          $l2_total_amount_with_dr_cr_opening +=$l_5value->_opening_amount ?? 0 ;
          $l2_total_amount_with_dr_cr_running +=$l_5value->_amount ?? 0;
          $l2_total_amount_with_dr_cr_balance +=$l_5value->_balance ?? 0;
        
          $l3_total_amount_with_dr_cr_opening +=$l_5value->_opening_amount ?? 0 ;
          $l3_total_amount_with_dr_cr_running +=$l_5value->_amount ?? 0;
          $l3_total_amount_with_dr_cr_balance +=$l_5value->_balance ?? 0;

          $l_4_total_amount_with_dr_cr_opening +=$l_5value->_opening_amount ?? 0 ;
          $l_4_total_amount_with_dr_cr_running +=$l_5value->_amount ?? 0;
          $l_4_total_amount_with_dr_cr_balance +=$l_5value->_balance ?? 0;
          @endphp


                           <tr  class="display_none">
                             <td  style="text-align: left;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;{!! $l_5value->_l_name ?? '' !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_5value->_opening_amount ?? 0 ))  !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_5value->_amount ?? 0 ))  !!}</td>
                             <td style="text-align: right;padding-right: 10px;">{!! _show_amount_dr_cr(_report_amount(   $l_5value->_balance ?? 0 ))  !!}</td>
                           </tr>

                      @empty
                     @endforelse <!-- END of 5th Loop -->

<tr class="grey_bg">
                     <th style="text-align: left;border:1px solid silver;"><b>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;  {!! $l_4key ?? '' !!} :</b></th>
                     <th style="text-align: right;border:1px solid silver;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l_4_total_amount_with_dr_cr_opening ))  !!}</th>
                     <th style="text-align: right;border:1px solid silver;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l_4_total_amount_with_dr_cr_running ))  !!}</th>
                     <th style="text-align: right;border:1px solid silver;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $l_4_total_amount_with_dr_cr_balance ))  !!}</b></th>
</tr>



                     
                     @empty
                     @endforelse <!-- END of 4th Loop -->
                     
<tr class="grey_bg">
                     <th style="text-align: left;"><b>TOTAL  {!! $l_3key ?? '' !!} :</b></th>
                     <th style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l2_total_amount_with_dr_cr_opening ))  !!}</th>
                     <th style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l2_total_amount_with_dr_cr_running ))  !!}</th>
                     <th style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $l2_total_amount_with_dr_cr_balance ))  !!}</b></th>
</tr>
                  
                  

                   @empty
                   @endforelse <!-- END OF 3rd Loop -->
 <tr class="grey_bg">
                     <th style="text-align: left;"><b>TOTAL  {!! id_wise_name($l_2key,'main_account_head','_name') !!} :</b></th>
                     <th style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l_1_total_amount_with_dr_cr_opening ))  !!}</th>
                     <th style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l_1_total_amount_with_dr_cr_running ))  !!}</th>
                     <th style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $l_1_total_amount_with_dr_cr_balance ))  !!}</b></th>
</tr>
                   

                   @empty
                   @endforelse <!-- END of 2nd Loop -->
 @if($l_1key==2)
 <tr>
                     <th style="text-align: left;"><b>TOTAL  @if($l_1key==2)  LIABILITIES & EQUITY @endif :</b></th>
                     <th style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l_1_total_amount_with_dr_cr_opening ))  !!}</th>
                     <th style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $l_1_total_amount_with_dr_cr_running ))  !!}</th>
                     <th style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $l_1_total_amount_with_dr_cr_balance ))  !!}</b></th>
</tr>
@endif

              

     

           @empty
           @endforelse <!-- END of First Loop -->
@if(abs($total_amount_with_dr_cr_balance) > 0)
            <tr class="">
                     <td style="text-align: left;"><b>DIFFERENCE OF BALANCE SHEET :</b></td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $total_amount_with_dr_cr_opening ))  !!}</td>
                     <td style="text-align: right;font-weight: bold;">{!! _show_amount_dr_cr(_report_amount(  $total_amount_with_dr_cr_running ))  !!}</td>
                     <td style="text-align: right;padding-right: 10px;"><b> {!! _show_amount_dr_cr(_report_amount(  $total_amount_with_dr_cr_balance ))  !!}</b></td>
        </tr>
@endif
           
               




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
