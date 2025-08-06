@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<div class="container">
<style type="text/css">
  
  .col-md-3{
    margin-top: 5px !important;
  }
  .col-md-4{
    margin-top: 5px !important;
  }
  .col-md-6{
    margin-top: 5px !important;
  }
  .col-md-8{
    margin-top: 5px !important;
  }
  .col-md-12{
    margin-top: 5px !important;
  }
</style>
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
             @can('asset_import_cost_list')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.index')}}">{{__('label.asset_import_cost')}}</a></li>
            @endcan
            @can('asset_import_cost_create')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.create')}}">Add New</a></li>
            @endcan
            <li class="breadcrumb-item">
               <a style="cursor: pointer;"   title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>
               </a>
            </li>
            <li class="breadcrumb-item">
                <a style="cursor: pointer;" onclick="fnExcelReport();"   title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
            </li>
           
          </ol>
        </nav>
        <div class="mb-9">
       


<section class="invoice" id="printablediv">
   <div class="text-center">
      <address>
        <img src="{{asset('/')}}{{$settings->logo ?? '' }}" style="width:60px;height: 60px;"><br>
            {!! $settings->name ?? '' !!}<br>
            @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}<br>@endif
           <b>Cost Calculation of Asset Items</b>
           
           
           
        </address>
  </div>
  
    <table class="table table-bordered table-sm fs--1 mb-0"  style="width:100%;">
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">ID</td>
        <td colspan="11" style="border:none;"> : {!! $data->id ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._order_number')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_order_number ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._purchase_type')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_purchase_type ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._voucher_number')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_voucher_number ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bank_name')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_bank_name ?? '' !!},{!! $data->_branch_name ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._lc_no')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_lc_no ?? '' !!},{!! _view_date_formate($data->_lc_date ?? '') !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bill_of_entry_no')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_bill_of_entry_no ?? '' !!},{!! _view_date_formate($data->_bill_of_entry_date ?? '') !!}</td>
      </tr>

      
      
      
      
@php
$_details = $data->_details ?? [];
@endphp

                    <tr>
                      <th>SL</th>
                      <th>{{__('label._ref')}}</th>
                      <th>{{__('label._ledger_id')}}</th>
                      <th>{{__('label._name')}}</th>
                      <th>{{__('label._unit_id')}}</th>
                      <th>{{__('label._qty')}}</th>
                      <th>{{__('label._rate_usd')}}</th>
                      <th>{{__('label._cfr_value_usd')}}</th>
                      <th>{{__('label._currency_rate_usd_to_bdt')}}</th>
                      <th>{{__('label._cfr_value_bdt')}}</th>
                      <th>{{__('label._insurance_bdt')}}</th>
                      <th>{{__('label._lc_commision_bdt')}}</th>
                      <th>{{__('label._custom_duty_bdt')}}</th>
                      <th>{{__('label._other_cost_bdt')}}</th>
                      <th>{{__('label._asset_value_bdt')}}</th>
                    </tr>
                 

@forelse($_details as $key=>$detail)
  <tr class="">
                      <td style="white-space: nowrap;"> {{($key+1)}}</td>
                      <td style="white-space: nowrap;">{{ $detail->id ?? '' }}</td>
                      <td style="white-space: nowrap;">{{ $detail->_asset_ledger->_name ?? '' }}</td>
                      <td style="white-space: nowrap;">{{ $detail->_asset_name ?? '' }}</td>
                      <td style="white-space: nowrap;">{{ $detail->_unit->_name ?? '' }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_qty ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_rate_usd ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_cfr_value_usd ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_currency_rate_usd_to_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_cfr_value_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_insurance_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_lc_commision_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_custom_duty_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;"> {{_report_amount($detail->_other_cost_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{_report_amount($detail->_asset_value_bdt ?? 0)}}</td>
                    </tr>
@empty
@endforelse

 <tr>
                  
                      <th style="white-space: nowrap;text-align: center;" colspan="5">Grand Total</th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_qty ?? 0) }} </th>
                      <th style="white-space: nowrap;text-align: right;"></th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_cfr_value_usd ?? 0) }} </th>
                      <th style="white-space: nowrap;text-align: right;"></th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_cfr_value_bdt ?? 0) }}</th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_insurance_bdt ?? 0) }}</th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_lc_commision_bdt ?? 0) }} </th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_custom_duty_bdt ?? 0) }}</th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_other_cost_bdt ?? 0) }}</th>
                      <th style="white-space: nowrap;text-align: right;">{{_report_amount($data->_total_asset_value_bdt ?? 0) }}</th>
                    </tr>
<tr style="border:none;">
  <td colspan="14" style="border:none;">{{__('label._note')}}:{!! $data->_note ?? '' !!}</td>
</tr>
<tfoot>
  <tr style="border:none;">
    <td style="border:none;" colspan="14">
      <table style="width:100%;border-collapse:collapse;border:0px solid #fff;">
        <tr>
          <td style="height:60px;border:0px solid #fff;"></td>
          <td style="height:60px;border:0px solid #fff;"></td>
          <td style="height:60px;border:0px solid #fff;"></td>
          <td style="height:60px;border:0px solid #fff;"></td>
        </tr>
        <tr>
          <td style="border:0px solid #fff;">
            <div style="text-align:center;">
              <b> Prepared By</b><br>
              <small style="font-size:12px;"></small>
            </div>
          </td>
          <td style="border:0px solid #fff;">
            <div style="text-align:center;">
              <b> Checked by</b><br>
              <small style="font-size:12px;"></small>
            </div>
          </td>
          <td style="border:0px solid #fff;">
            <div style="text-align:center;">
              <b> Approved by</b><br>
              <small style="font-size:12px;"></small>
            </div>
          </td>
          
        </tr>
      </table>
    </td>
  </tr>
  


</tfoot>
</table>
  
  
       
                        

                     
 </section>
          
        
            
</div>
</div>


        @endsection

@section('script')
  <script>
   

  </script>
@endsection