@extends('backend.layouts.app')
@section('title',$page_name)

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
               <form  action="{{url('payable_report')}}" method="POST">
                @csrf
                    <div class="row">
                   
                      @include('basic.org_report')

               @php

$_account_group_ids = $previous_filter["_account_group_id"] ?? [];
$report_type = $previous_filter["report_type"] ?? '';
               @endphp        
                  
                    <div class="col-sm-12 ">
                        <label for="_account_group_id" class="col-sm-4 col-form-label">Account Group:<span class="_required">*</span></label>
                        <select class="form-control  _account_group_id multiple_select" name="_account_group_id[]" multiple required>
                          
                          @forelse($account_groups as $account_type )
                          <option value="{{$account_type->id}}" @if(in_array($account_type->id,$_account_group_ids)) selected @endif>{{ $account_type->_name ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                    <div class="col-sm-12 ">
                        <label for="report_type" class="col-sm-4 col-form-label">Report Type:<span class="_required">*</span></label>
                        <select class="form-control  report_type " name="report_type"  >
                          <option value="receivable" @if($report_type=='receivable') selected @endif>Receivable</option>
                          <option value="payable" @if($report_type=='payable') selected @endif>Payable</option>
                        </select>
                    </div>
                  
                    </div>
                    
                    
                     <div class="row  text-center">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('payable_report')}}" class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                        </div>
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>

@if($request->has('organization_id') && $request->has('_branch_id') && $request->has('_cost_center'))

@php
$_branch_id = $request->_branch_id  ?? '';
@endphp

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;">{{$settings->name ?? '' }}<br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> {{$settings->keywords ?? '' }}</div>
                </td> </tr>
                
                <?php
                $sequence_to_remove = "––------------–--";
                ?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
        <table class="table" style="border:none;width: 100%;margin-bottom: 0px !important;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;margin-bottom: 0px !important;">
                


                <tr style="border:none;">
                  <td style="border:none;">
                      <table class="table" >
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Date & Time </th>
                          <td style="width:90%;text-align: left;border: none;">: {{date('d-m-Y H:s A')}} </td>
                        </tr>
                      @if($_branch_id !='all')
                       <tr>
                          <th style="width:10%;text-align: left;border: none;">{{__('label._branch_id')}}  </th>
                          <td style="width:90%;text-align: left;border: none;">: {{ id_to_cloumn($_branch_id,'_name','branches') }} </td>
                        </tr>
                      @endif
                         <tr>
                          <th style="width:10%;text-align: left;border: none;font-weight: bold;">Subject </th>
                          <td style="width:90%;text-align: left;border: none;font-weight: bold;">:
                            @if($report_type =='payable')
                              Payable Report
                            @else
                             Receivable Report
                            @endif
                          
                           </td>
                         
                        </tr>
                        
                      </table>
                  </td>
                </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
            <th>SL</th>
           
            <th>{{__('label._code')}}</th>
            <th>{{__('label._ledger_id')}}</th>
            <th>{{__('label._alious')}}</th>
            <th>{{__('label._phone')}}</th>
            <th>{{__('label._address')}}</th>
            <th>{{__('label._amount')}}</th>
            <th>{{__('label._balance')}}</th>
          </tr>
          
          
          </thead>
          <tbody>
@php
$total_amount=0;
$running_balance=0;
@endphp
@forelse($datas as $group_name=>$group_data)

@php
$group_amount=0;
@endphp
          <tr>
            <td colspan="8" class="text-bold">{!! $group_name ?? '' !!}</td>
          </tr>

          @forelse($group_data as $l_key=> $data)

          @php
$group_amount     +=$data->_balance ?? 0;
$total_amount     +=$data->_balance ?? 0;
$running_balance  +=$data->_balance ?? 0;
@endphp
              <tr>
            <td>{{($l_key+1)}}</td>
            <td class="white_space">{!! $data->_code ?? '' !!}</td>
            <td>{!! $data->_l_name ?? '' !!}</td>
            <td>{!! $data->_alious ?? '' !!}</td>
            <td>{!! $data->_phone ?? '' !!}</td>
            <td>{!! $data->_address ?? '' !!}</td>
            <td class="white_space">{!! _show_amount_dr_cr(_report_amount($data->_balance ?? 0)) !!}</td>
            <td class="white_space">{!! _show_amount_dr_cr(_report_amount($running_balance)) !!}</td>
          </tr>
          @empty
          @endforelse

          <tr>
            <td colspan="6" class="text-bold">SUB TOTAL {!! $group_name ?? '' !!}</td>
            <td class="text-right text-bold white_space">{{_show_amount_dr_cr(_report_amount($group_amount))}}</td>
            <td></td>
          </tr>

@empty
@endforelse

<tr>
            <td colspan="6" class="text-bold">GRAND TOTAL </td>
            <td class="text-right text-bold white_space">{{_show_amount_dr_cr(_report_amount($total_amount))}}</td>
            <td></td>
          </tr>
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="8" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

  @endif







@endsection

@section('script')

<script type="text/javascript">



</script>
@endsection

