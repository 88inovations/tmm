@extends('backend.layouts.app')
@section('title',$page_name)

@section('style')
<style type="text/css">
  ._list_table td, th {
   
    white-space: normal !important;
}

        .indent {
            padding-left: 20px;
        }

</style>
@endsection

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          <div class="card">
              
            <div class="card-body filter_body" style="">
               <form  action="" method="GET">
                @csrf
                    
                         @php
              $users = \Auth::user();
              $permited_organizations = permited_organization(explode(',',$users->organization_ids));

              $account_head_id = $previous_filter["_account_head_id"] ?? '';
              @endphp 

<div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6 ">
              <div class="form-group ">
              <label>{!! __('label.organization') !!}:</label>
              <select  class="form-control _master_organization_id " name="organization_id"  >
                <option value="all">All {!! __('label.organization') !!}</option>
               @forelse($permited_organizations as $val )
               <option value="{{$val->id}}" 
                @if(isset($previous_filter["organization_id"]) && $val->id==$previous_filter["organization_id"]) ) selected @endif
                               >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
               @empty
               @endforelse
              </select>
              </div>
              </div>
              <div class="col-md-6">
                          <label>{{__('label._branch_id')}}:</label>
                          <input type="hidden" name="report_name" value="group_sub_group_summary_report">
                         <select id="_branch_id" class="form-control _branch_id _master_branch_id" name="_branch_id"  >
                          <option value="all">All {{__('label._branch_id')}}</option>
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" 
                            @if(isset($previous_filter["_branch_id"]) && $branch->id==$previous_filter["_branch_id"]) selected @endif
                             > {{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>
                      <div class="col-md-6">
                          <label>{{__('label._cost_center_id')}}:</label>
                         <select class="form-control width_150_px _cost_center "  name="_cost_center"   >
                                      <option value="all">All {{__('label._cost_center_id')}}</option>
                            @forelse($permited_costcenters as $costcenter )
                            <option value="{{$costcenter->id}}" 
                              @if(isset($previous_filter["_cost_center"]) && $costcenter->id==$previous_filter["_cost_center"]) selected @endif
                                 
                              > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                    
                    <div class="col-md-6">
                                <label >Account Type: </label>
                            
                               <select type_base_group="{{url('type_base_group')}}" class="form-control width_150_px _account_head_id " name="_account_head_id" >
                                  <option value="">--Select Account Type--</option>
                                  @foreach ($account_types as $accountHead)
                                    <option value="{{ $accountHead->id }}" @if($account_head_id ==$accountHead->id) selected  @endif>
                                        {!! $accountHead->_indent !!}  [{{$accountHead->_level}}]-{{$accountHead->id}}-{{ $accountHead->_name }}
                                    </option>
                                @endforeach
                                </select>
                           
                        </div>
                       
                            <div class="col-md-6">
                                <label  >Account Group:</label>
                       
                               <select class="form-control _account_groups " name="_account_group_id" >
                                  <option value="all">--Select Account Group--</option>
                                  @forelse($account_groups as $account_group )
                                  <option value="{{$account_group->id}}"  @if(old('_account_group_id') == $account_group->id) selected @endif   >{{ $account_group->id ?? '' }} - {{ $account_group->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            
                        </div>
                    
                    </div>
                    <div class="row  text-center">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                        
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('group_sub_group_summary_report')}}" class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset</a>
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
    

        
      

    <!-- Table row -->
   <table class="cewReportTable">
           <thead>
            <tr style="border:none;">
              <td colspan="5" style="border:none;">
                <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 
                 <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;">
                  {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}<br>
                  {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center"] ?? '') }} </b><br>

</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
              </td>
            </tr>
             <tr>
            
            <th style="border:1px solid silver;" class="text-left" >SL</th>
            <th style="border:1px solid silver;" class="text-left" >Ledger Name</th>
            <th style="border:1px solid silver;" class="text-right" >Amount</th>
          </tr>
        </thead>
        <tbody>
          <tbody>
            @php
            $_grand_total = 0;
            $account_head_id_stock=[];
            $account_head_id_for_subtotalstock=[];
            @endphp
           @forelse($datas as $main_accunt_key=>$main_account_data)
            @php
            $sub_total_main_account_amount = 0;
            @endphp
           <tr>
             <td colspan="3" class="text-left"><b>{{$main_account_key_names[$main_accunt_key] ?? '' }}</b></td>
           </tr>
           @forelse($main_account_data as $third_head_key=>$third_head_amounts_data) <!-- Third Head Loop Start -->
          
           @php
            $sub_total_third_head_amount = 0;
            @endphp
            @if(!in_array($third_head_key, $account_head_id_stock))
           <?php 
array_push($account_head_id_stock,$third_head_key);
           ?>

            <tr>
             <td colspan="3" class="text-left"><b>&nbsp;&nbsp;{{$heads_array_key_names[$third_head_key] ?? '' }}</b></td>
           </tr>
           @endif

             @forelse($third_head_amounts_data as $second_head_key=>$second_head_datas) <!-- Start 2nd Head Loop  -->
             @php
            $sub_total_second_head_amount=0;
             @endphp

        @if(!in_array($second_head_key, $account_head_id_stock))
         <?php 
array_push($account_head_id_stock,$second_head_key);
           ?>
            <tr>
             <td colspan="3" class="text-left"><b>&nbsp;&nbsp;&nbsp;&nbsp;{{$heads_array_key_names[$second_head_key] ?? '' }}</b></td>
           </tr>
          
           @endif

           @forelse($second_head_datas as $first_head_key=>$group_datas)

           @php
$sub_total_first_head_amount=0;
             @endphp

@if(!in_array($first_head_key, $account_head_id_stock))
<?php 
array_push($account_head_id_stock,$first_head_key);
           ?>

             <tr>
             <td colspan="3" class="text-left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$heads_array_key_names[$first_head_key] ?? '' }}</b></td>
           </tr>
   @endif

           @forelse($group_datas as $group_key=>$ledger_data)
            <tr>
             <td colspan="3" class="text-left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$group_array_key_names[$group_key] ?? '' }}</b></td>
           </tr>
             @php
$sub_total_group_amount=0;
             @endphp

           @forelse($ledger_data as $_ledger_key=>$_ledger_info)
@php
$_grand_total                   += $_ledger_info->_balance ?? 0;
$sub_total_main_account_amount  += $_ledger_info->_balance ?? 0;
$sub_total_third_head_amount    += $_ledger_info->_balance ?? 0;
$sub_total_second_head_amount   += $_ledger_info->_balance ?? 0;
$sub_total_first_head_amount    += $_ledger_info->_balance ?? 0;
$sub_total_group_amount         += $_ledger_info->_balance ?? 0;
 @endphp
            <tr>

              <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{( $_ledger_key +1 )}}</td>
              <td> {{ $_ledger_info->_l_name ?? '' }}</td>
              <td class="text-right"> {{ _show_amount_dr_cr(_report_amount( $_ledger_info->_balance ?? 0 )) }}  </td>
            </tr>
           @empty
           @endforelse
           <tr>
             <td  colspan="2" class="text-left"><b>Sub total of {{$group_array_key_names[$group_key] ?? '' }}</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $sub_total_first_head_amount )) }} </td>
           </tr>

           @empty
           @endforelse
@if(!in_array($first_head_key,$account_head_id_for_subtotalstock))
            <?php 
array_push($account_head_id_for_subtotalstock,$first_head_key);
           ?>
            <tr>
             <td  colspan="2" class="text-left"><b>Sub total of {{$heads_array_key_names[$first_head_key] ?? '' }}</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $sub_total_first_head_amount )) }} </td>
           </tr>
@endif

            @empty
            @endforelse <!-- ENd $third_head_amounts_data  Loop  -->

@if(!in_array($second_head_key,$account_head_id_for_subtotalstock))
            <?php 
array_push($account_head_id_for_subtotalstock,$second_head_key);
           ?>

            <tr>
             <td  colspan="2" class="text-left"><b>Sub total of {{$heads_array_key_names[$second_head_key] ?? '' }}</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $sub_total_second_head_amount )) }} </td>
           </tr>
           @endif

            @empty
            @endforelse <!-- ENd $third_head_amounts_data  Loop  -->
            @if(!in_array($third_head_key,$account_head_id_for_subtotalstock))
            <?php 
array_push($account_head_id_for_subtotalstock,$third_head_key);
           ?>
            <tr>
             <td  colspan="2" class="text-left"><b>Sub total of {{$heads_array_key_names[$third_head_key] ?? '' }}</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $sub_total_third_head_amount )) }} </td>
           </tr>
           @endif

        @empty
        @endforelse <!-- ENd $main_account_data  Loop  -->


           <tr>
             <td  colspan="2" class="text-left"><b>Summary of {{$main_account_key_names[$main_accunt_key] ?? '' }}</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $sub_total_main_account_amount )) }} </td>
           </tr>
           @empty
           @endforelse <!-- End $datas Loop -->
           <tr>
             <td colspan="2"  class="text-left"><b>Grand Total</b></td>
             <td class="text-right">{{ _show_amount_dr_cr(_report_amount(  $_grand_total )) }} </td>
           </tr>
          
          </tbody>
        </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="3" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>
  @else

  @if(isset($previous_filter["report_name"]))

     <h5 class="text-center _required">No Data Found</h5>
     @endif
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

