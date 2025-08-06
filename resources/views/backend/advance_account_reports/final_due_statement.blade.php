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
               <form  action="{{url('final_due_statement')}}" method="GET">
                @csrf
              
                  
                     @include('basic.org_report')
                    @php
$report_type = $previous_filter['report_type'] ?? 1;
                    @endphp
                    <div class="row">
                      <label>Report Type:</label>
                        <select class="form-control" name="report_type">
                          <option value="1" @if($report_type==1) selected  @endif>Top Sheet</option>
                          <option value="2" @if($report_type==2) selected  @endif>Detail</option>
                        </select>
                    </div>
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('customer_due_statement')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date As on: {{date('l, F j, Y H:i:s A')}}</strong></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                
             {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }} </td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
             
            <th style="width: 5%;">{{__('label.sl')}}</th>
            <th style="width: 5%;">{{__('label._customer_id')}}</th>
            <th style="width: 10%;">{{__('label._name')}}</th>
            <th style="width: 10%;">{{__('label._phone')}}</th>
            <th style="width: 10%;">{{__('label._address')}}</th>
            <th style="width: 10%;">{{__('label._balance_amount')}}</th>
            
          </tr>
          
          
          </thead>
          <tbody>
@php
$sl=1;

$grand_total_balance=0;
$grand_total_opeing_balance=0;
$grand_total_current_balance=0;



@endphp
  @forelse($datas as $b_key=>$branch_data)



  <tr>
           
            <th colspan="6">{!! $b_key ?? '' !!}</th>
           
            </tr>

@php

$sub_total_branch_balance=0;
$sub_total_branch_opeing_balance=0;
$sub_total_branch_current_balance=0;

$index  =0;
@endphp

            @forelse($branch_data as $key=>$val)


@php

$grand_total_balance  +=($val->_opeing_balance +$val->_current_balance);
$grand_total_opeing_balance +=($val->_opeing_balance );
$grand_total_current_balance +=($val->_current_balance );

$sub_total_branch_balance  +=($val->_opeing_balance +$val->_current_balance);
$sub_total_branch_opeing_balance  +=($val->_opeing_balance );
$sub_total_branch_current_balance  +=($val->_current_balance );






@endphp
@if(($val->_opeing_balance + $val->_current_balance ) !=0)
            <tr>
            <td style="width: 5%;">{{($index+1)}}</td>
            <td style="width: 5%;white-space: nowrap;"> {{$val->_ledger_id}}  {!! $val->_code ?? '' !!}</td>
            <td style="width: 10%;white-space: nowrap;;">{!! $val->_name ?? '' !!}</td>
            <td style="width: 10%;">{!! $val->_phone ?? '' !!}</td>
            <td style="width: 10%;">{!! $val->_address ?? '' !!}</td>
            <td style="width: 10%;">{!! _show_amount_dr_cr(_report_amount($val->_opeing_balance + $val->_current_balance )) !!}</td>
           
            </tr>

@if($report_type ==2)
@php



  $_ledger_id = $val->_ledger_id;
         $_l_balance_update = _l_balance_update($_ledger_id);

          $total_sales = \App\Models\Sales::where('_ledger_id', $val->_ledger_id)
                                                        ->where('_status',1)
                                                        ->sum('_total');
 
        $history_sales_invoices = [];
        $row_conter=0;
         $_p_balance = ($val->_opeing_balance + $val->_current_balance ) ?? 0;
         if($_p_balance > 0 ){
                if($total_sales >= $_l_balance_update ){
                  //  return $_l_balance_update;
                //if($_l_balance_update > 0 ){
                 //if last balance gretter then 0 then go ahead
                        $_avoid_sales_ids =[];
                        $available_quantity =  0;
                         $_qty_less = $_l_balance_update;
                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return $available_quantity;
                                 $due_sales_info = \App\Models\Sales::with(['_terms_con'])->select('id','_date','_order_number','_total','_total_discount','_total_vat','_payment_terms')
                                                    ->where('_ledger_id', $_ledger_id)
                                                    ->where('_total','>',0)
                                                    ->where('_status',1)
                                                    ->whereNotIn('id', $_avoid_sales_ids)
                                                    ->orderBy('id','DESC')
                                                    ->first();

                                                   
                                $new_qty=0;
                                if($due_sales_info){
                                      array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $available_quantity += (($due_sales_info->_total)+$due_sales_info->_total_vat);

          //Calculation of due Days
              $due_days =0;
               $diff_days = number_of_day_calculation($due_sales_info->_date,date('Y-m-d'));
              $_days = $due_sales_info->_terms_con->_days ?? 0;
                               
              if($diff_days > $_days){
                 $due_days =  ($diff_days-$_days); 
              } 
              //End of due date calculation


                                      if($available_quantity  >= $_l_balance_update  ){

 

                                        $_less_qty = ((($due_sales_info->_total)+$due_sales_info->_total_vat) -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                         $new_qty = $_less_qty;
                                         $due_sales_info->_due_amount = $new_qty;
                                         $due_sales_info->due_days = $due_days;
                                         array_push($history_sales_invoices, $due_sales_info);


                                    
                  
               
                


                                         
                                        }else{
                                            $due_sales_info->_due_amount = $due_sales_info->_total ?? 0;
                                            $due_sales_info->due_days = $due_days;
                                            array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);
                }else{

                     $_avoid_sales_ids =[];
                        $available_quantity =  0;
                         $_qty_less = $_l_balance_update;
                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return 'ok';
                               // return $available_quantity;
                                 $due_sales_info = \App\Models\Accounts::select('id','_ref_master_id','_date','_voucher_code as _order_number','_dr_amount as _total')
                                                    ->where('_account_ledger', $_ledger_id)
                                                    ->where('_dr_amount','>',0)
                                                    ->where('_status',1)
                                                    ->whereNotIn('id', $_avoid_sales_ids)
                                                    ->orderBy('id','DESC')
                                                    ->first();
                                $_ref_master_id = $due_sales_info->_ref_master_id ?? '';
                                $current_row_id = $due_sales_info->id ?? '';
                                $sum = \DB::table('accounts')
                                        ->select(DB::raw('SUM(_dr_amount -_cr_amount ) as vat_discount'))
                                        ->where('_account_ledger', $_ledger_id)
                                        ->where('_ref_master_id', $_ref_master_id)
                                        ->where('_transaction', 'Sales')
                                        ->where('id', '!=',$current_row_id)
                                        ->first();

                                 $vat_discount = $sum->vat_discount ?? 0;

                                if($due_sales_info){
                                      array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $this_net_total = (($due_sales_info->_total ?? 0)+$vat_discount);
                                       $due_sales_info->_total = $this_net_total;

                                       $available_quantity +=$this_net_total ?? 0;

            //Calculation of due Days
              $due_days =0;
              $diff_days = _date_diff($due_sales_info->_date,date('Y-m-d'));
              $_days = $due_sales_info->_terms_con->_days ?? 0;
                               
              if($diff_days > $_days){
                 $due_days =  ($diff_days-$_days); 
              } 
              //End of due date calculation




                                      if($available_quantity  >= $_l_balance_update  ){
                                        $_less_qty = ($this_net_total -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                         $new_qty = $_less_qty;
                                         $due_sales_info->_due_amount = $new_qty;
                                         $due_sales_info->due_days = $due_days;
                                         array_push($history_sales_invoices, $due_sales_info);
                                         
                                        }else{
                                            $due_sales_info->_due_amount = $this_net_total ?? 0;
                                            $due_sales_info->due_days = $due_days;
                                            array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);

                }
         
   }

@endphp

<!-- Due INvoice Details -->
<tr>
  
  <td colspan="6">
    @if(sizeof($history_sales_invoices) > 0) 
        <table class=" " style="width: 100%; border-collapse: collapse;">
          <thead style="background:#96d896;">
            <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;">Date</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Invoice No.</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Sales Amount</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Pending Amount</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">O/D By Days</td>
            </tr>
          </thead>
         
            @php
            $due_sales_amount=0;
            $due_due_amount =0;
            @endphp
            @forelse($history_sales_invoices as $his_val)
            @php
            $due_sales_amount +=$his_val->_total ?? 0;
            $due_due_amount +=$his_val->_due_amount ?? 0;
            @endphp
              <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;">{{ _view_date_formate($his_val->_date ?? '') }}</td>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;padding-right:5px;z">{{ $his_val->_order_number ?? '' }}</td>
              <td style="border:1px solid #000;text-align: right;font-size: 10px;white-space: nowrap;padding-right:5px;">{{ _report_amount($his_val->_total ?? 0) }}</td>
              <td style="border:1px solid #000;text-align: right;font-size: 10px;white-space: nowrap;padding-right:5px;">{{ _report_amount($his_val->_due_amount ?? 0) }}</td>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;color:red;font-weight:bold;">
                  {{  $his_val->due_days ?? 0 }} Days
                  
                  </td>
              
            </tr>
            @empty
            @endforelse
         
          
            <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;" colspan="2"><b>Total</b></td>
              <td style="border:1px solid #000;text-align: right;font-size: 12px;white-space: nowrap;"><b>{{ _report_amount($due_sales_amount ?? 0) }}</b></td>
              <td style="border:1px solid #000;text-align: right;font-size: 12px;white-space: nowrap;"><b>{{ _report_amount($due_due_amount ?? 0) }}</b></td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;"></td>
            </tr>
          
        </table>

@endif <!-- Check invoice history Data Available is or not -->
@endif <!-- Check Report Type -->


            @php
$index++;
$sl++;
@endphp

@endif <!-- Check Balance is not 0 -->



  </td>
</tr>



@empty
@endforelse


<tr>
            <th colspan="5" style="text-align: left;">Sub Total of {!! $b_key ?? '' !!}</th>
            <th style="width: 10%;">{{_show_amount_dr_cr(_report_amount($sub_total_branch_balance))}}</th>
  </tr>
            @empty
            @endforelse





  <tr>
            <th colspan="5" style="text-align: left;">Grand Total </th>
            <th style="width: 10%;">{{_show_amount_dr_cr(_report_amount($grand_total_balance))}}</th>
  </tr>
            
        

    
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="6" style="border: none;">
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

