@extends('backend.layouts.app')
@section('title',$page_name)

@section('style')
<style type="text/css">
  ._list_table td, th {
   
    white-space: normal !important;
}
</style>
@endsection

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          <div class="card">
               @if (count($errors) > 0)
                 <div class="alert alert-danger">
                      <strong>Whoops!</strong> There were some problems with your input.<br><br>
                      <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                      </ul>
                  </div>
              @endif
            <div class="card-header">
              
                  <h4 class="text-center">{{ $page_name ?? '' }}</h4>
            </div>
          
         
            <div class="card-body filter_body" style="">
               <form  action="" method="GET">
                @csrf
                    <div class="row">
                      <label>Start Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input" data-target="#reservationdate" required @if(isset($previous_filter["_datex"])) value='{{$previous_filter["_datex"] }}' @endif />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                         @if(isset($previous_filter["_datex"]))
                              <input type="hidden" name="_old_filter" class="_old_filter" value="1">
                              @else
                              <input type="hidden" name="_old_filter" class="_old_filter" value="0">
                              @endif
                    </div>
                    <div class="row">
                      <label>End Date:</label>
                        <div class="input-group date" id="reservationdate_2" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_2" data-target="#reservationdate_2" required @if(isset($previous_filter["_datey"])) value='{{$previous_filter["_datey"] }}' @endif />
                                      <div class="input-group-append" data-target="#reservationdate_2" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                    </div>
                     @include('basic.org_report')
                    
                    
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                        </div>
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>

<!-- Report Section Start  -->
@if(sizeof($datas) > 0)
<div class="_report_button_header">
    
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                   {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
             
            <th style="width: 10%;">SL</th>
            <th style="width: 10%;">Date</th>
            <th style="width: 10%;">INV NO</th>
            <th style="width: 10%;">Short Des.</th>
            <th style="width: 200px;">Particular</th>
            <th style="width: 10%;">Dr Amount</th>
            <th style="width: 10%;">Cr Amount</th>
            <!-- Dinamic Ledger Account -->
            <th style="width: 10%;">Balance</th>
          </tr>
          
          
          </thead>
          <tbody>
@php
$sl=1;
$grand_total_dr_amount=0;
$grand_total_cr_amount=0;
$grand_total_balance=0;

@endphp
  @forelse($datas as $b_key=>$branch_data)


   @php

$sub_total_branch_dr_amount=0;
$sub_total_branch_cr_amount=0;
$sub_total_branch_balance=0;

            @endphp

  <tr>
           
            <th colspan="8">{!! $b_key ?? '' !!}</th>
           
            </tr>

            @forelse($branch_data as $key=>$vales)
@php
$index =0;
$sub_total_dr_amount=0;
$sub_total_cr_amount=0;
$sub_total_balance=0;
@endphp
@forelse($vales as $s_key=>$val)
@php

$sub_total_dr_amount    +=$val->_dr_amount ?? 0;
$sub_total_cr_amount    +=$val->_cr_amount ?? 0;
$current_dr_cr_diff     =($val->_dr_amount-$val->_cr_amount);
$sub_total_balance      +=($val->_balance + $current_dr_cr_diff);

$sub_total_branch_dr_amount    +=$val->_dr_amount ?? 0;
$sub_total_branch_cr_amount    +=$val->_cr_amount ?? 0;
$sub_total_branch_balance      +=($val->_balance + $current_dr_cr_diff);


$grand_total_dr_amount    +=$val->_dr_amount ?? 0;
$grand_total_cr_amount    +=$val->_cr_amount ?? 0;
$grand_total_balance      +=($val->_balance + $current_dr_cr_diff);




@endphp
@if($index ==0)
<tr>
           
            <th colspan="8">{!! $val->_code ?? '' !!} -- {!! $val->_name ?? '' !!}</th>
           
            </tr>
@endif
            <tr>
            <td style="width: 5%;">{{($index+1)}}</td>
            <td style="width: 10%;white-space: nowrap;">{!! _view_date_formate($val->_date ?? '') !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $val->_voucher_code ?? '' !!}</td>
            <td style="width: 10%;">{!! $val->_short_narration ?? '' !!} || {!! $val->_serial ?? '' !!}|| {!! $val->_pair ?? '' !!}</td>
            <td style="width: 200px !important;white-space: normal;">{!! $val->_narration ?? '' !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! _report_amount($val->_dr_amount ?? 0) !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! _report_amount($val->_cr_amount ?? 0) !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! _show_amount_dr_cr(_report_amount($sub_total_balance?? 0)) !!}</td>
           
            </tr>
            @php
$index++;
$sl++;
@endphp

@empty
@endforelse
<tr>
            <th colspan="5" style="text-align: left;">Sub Total of {{_find_ledger($key)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_report_amount($sub_total_dr_amount)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_report_amount($sub_total_cr_amount)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_show_amount_dr_cr(_report_amount($sub_total_balance))}}</th>
  </tr>
            @empty
            @endforelse

<tr>
            <th colspan="5" style="text-align: left;">Sub Total of {!! $b_key ?? '' !!}</th>
            <th style="width: 10%;white-space: nowrap;">{{_report_amount($sub_total_branch_dr_amount)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_report_amount($sub_total_branch_cr_amount)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_show_amount_dr_cr(_report_amount($sub_total_branch_balance))}}</th>
  </tr>
            @empty
            @endforelse





  <tr>
            <th colspan="5" style="text-align: left;">Grand Total </th>
            <th style="width: 10%;white-space: nowrap;">{{_report_amount($grand_total_dr_amount)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_report_amount($grand_total_cr_amount)}}</th>
            <th style="width: 10%;white-space: nowrap;">{{_show_amount_dr_cr(_report_amount($grand_total_balance))}}</th>
  </tr>
            
        

    
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="10" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>
  @endif
<!-- End of Report Data view Section -->



    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript">


 
    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }
     
     


     function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            
          }
     

  })



</script>
@endsection

