@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<div class="container-fluid">
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
        <td colspan="3" style="border:none;"> : {!! $data->id ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._purchase_type')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_purchase_type ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_date ?? '') !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._voucher_number')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_voucher_number ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._order_number')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_order_number ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._supplier_name')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_supplier_name ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bank_name')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_bank_name ?? '' !!},{!! $data->_branch_name ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._lc_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_lc_no ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._lc_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_lc_date ?? '') !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._lc_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_lc_no ?? '' !!}</td>
      </tr>
      
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._pi_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_pi_no ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._pi_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_pi_date ?? '') !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._invoice_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_invoice_no ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._invoice_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_invoice_date ?? '') !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._boe_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_boe_no ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._boe_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_boe_date ?? '') !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bl_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_bl_no ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bl_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_bl_date ?? '') !!}</td>
      </tr>

      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._incoterms')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_incoterms ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._import_currency')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_import_currency ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._currency_rate')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_currency_rate ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._date_of_arrival')}}</td>
        <td colspan="3" style="border:none;"> :{!! _view_date_formate($data->_date_of_arrival ?? '') !!}</td>
      </tr>

      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._procurement_officer')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_procurement_officer ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._cnf_agent')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_cnf_agent ?? '' !!}</td>
      </tr>

      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._ammendment_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_ammendment_date ?? '') !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._ammendment_reason')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_ammendment_reason ?? '' !!}</td>
      </tr>

      <tr style="border:none;">
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bill_of_entry_no')}}</td>
        <td colspan="3" style="border:none;"> : {!! $data->_bill_of_entry_no ?? '' !!}</td>
      
        <td colspan="3" style="border:none;font-weight: 600;">{{__('label._bill_of_entry_date')}}</td>
        <td colspan="3" style="border:none;"> : {!! _view_date_formate($data->_bill_of_entry_date ?? '') !!}</td>
      </tr>

          @php
$_details = $data->_details ?? [];

$total_qty = 0;
$total_cfr_value_usd = 0;
$total_cfr_value_bdt = 0;
$total_insurance_bdt = 0;
$total_lc_commision_bdt = 0;
$total_custom_duty_bdt = 0;
$total_custom_duty_tax_ait = 0;
$total_custom_duty_tax_ait_2nd = 0;
$total_customer_other_charge_other = 0;
$total_port_charge = 0;
$total_port_charge_ait = 0;
$total_shiping_agent_charge = 0;
$total_shiping_agent_deduction_charge_2nd = 0;
$total_deport_charge = 0;
$total_container_damage_charge = 0;
$total_cnf_agen_commision = 0;
$total_installation_cost = 0;
$total_other_cost = 0;
$total_salvage_value = 0;
$total_depreciable_asset_value = 0;
$total_other_cost_bdt = 0;
$total_asset_value_bdt = 0;
$total_total_initial_cost = 0;


                    @endphp
<tr>
                     <td style="vertical-align: text-top;" >SL</td>
                      <td style="vertical-align: text-top;" >{{__('label._asset_category_id')}}</td>
                      <td style="vertical-align: text-top;" >Asset Code</td>
                      <td style="vertical-align: text-top;" >{{__('label._asset_name')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._unit_id')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._qty')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._rate_usd')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._cfr_value_usd')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._currency_rate_usd_to_bdt')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._cfr_value_bdt')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._insurance_bdt')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._lc_commision_bdt')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._custom_duty_bdt')}}</td>
                      <td  style="vertical-align: text-top;" class="_required">{{__('label._custom_duty_tax_ait')}}</td>
                      <td style="vertical-align: text-top;"  class="_required">{{__('label._custom_duty_tax_ait_2nd')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._customer_other_charge_other')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._port_charge')}}</td>
                      <td style="vertical-align: text-top;" class="_required">{{__('label._port_charge_ait')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._shiping_agent_charge')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._shiping_agent_deduction_charge_2nd')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._deport_charge')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._container_damage_charge')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._cnf_agen_commision')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._installation_cost')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._other_cost')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._total_initial_cost')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._salvage_value')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._depreciable_asset_value')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._other_cost_bdt')}}</td>
                      <td style="vertical-align: text-top;" >{{__('label._asset_value_bdt')}}</td>
                      <td style="width: 250px;vertical-align: text-top;">{{__('label._remarks')}}</td>
                 
</tr>
@forelse($_details as $key=>$detail)

  @php
$_asset_category_id = $detail->_asset_category_id ?? '';

$total_qty                        +=$detail->_qty ??  0;
$total_cfr_value_usd              +=$detail->_cfr_value_usd ??  0;
$total_cfr_value_bdt              +=$detail->_cfr_value_bdt ??  0;
$total_insurance_bdt              +=$detail->_insurance_bdt ??  0;
$total_lc_commision_bdt           +=$detail->_lc_commision_bdt ??  0;
$total_custom_duty_bdt            +=$detail->_custom_duty_bdt ??  0;
$total_custom_duty_tax_ait        +=$detail->_custom_duty_tax_ait ??  0;
$total_custom_duty_tax_ait_2nd    +=$detail->_custom_duty_tax_ait_2nd ??  0;
$total_customer_other_charge_other +=$detail->_customer_other_charge_other ??  0;
$total_port_charge                +=$detail->_port_charge ??  0;
$total_port_charge_ait            +=$detail->_port_charge_ait ??  0;
$total_shiping_agent_charge       +=$detail->_shiping_agent_charge ??  0;
$total_shiping_agent_deduction_charge_2nd +=$detail->_shiping_agent_deduction_charge_2nd ??  0;
$total_deport_charge              +=$detail->_deport_charge ??  0;
$total_container_damage_charge    +=$detail->_container_damage_charge ??  0;
$total_cnf_agen_commision         +=$detail->_cnf_agen_commision ??  0;
$total_installation_cost          +=$detail->_installation_cost ??  0;
$total_other_cost                 +=$detail->_other_cost ??  0;
$total_total_initial_cost            +=$detail->_total_initial_cost ??  0;
$total_salvage_value              +=$detail->_salvage_value ??  0;
$total_depreciable_asset_value    +=$detail->_depreciable_asset_value ??  0;
$total_other_cost_bdt             +=$detail->_other_cost_bdt ??  0;
$total_asset_value_bdt            +=$detail->_asset_value_bdt ??  0;


@endphp

  <tr class="">
                      <td style="white-space: nowrap;"> {{($key+1)}}</td>
                      <td style="white-space: nowrap;">{{ $detail->_asset_ledger->_name ?? '' }}</td>
                      <td style="white-space: nowrap;">{{ $detail->_items->_code ?? '' }}</td>
                      <td style="">{{ $detail->_asset_name ?? '' }}</td>
                      <td style="white-space: nowrap;">{{ $detail->_unit->_name ?? '' }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_qty ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_rate_usd ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_cfr_value_usd ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_currency_rate_usd_to_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_cfr_value_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_insurance_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_lc_commision_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_custom_duty_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_custom_duty_tax_ait ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_custom_duty_tax_ait_2nd ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_customer_other_charge_other ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_port_charge ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_port_charge_ait ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_shiping_agent_charge ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_shiping_agent_deduction_charge_2nd ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_deport_charge ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_container_damage_charge ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_cnf_agen_commision ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_installation_cost ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_other_cost ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_total_initial_cost ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_salvage_value ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_depreciable_asset_value ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_other_cost_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;">{{ _report_amount($detail->_asset_value_bdt ?? 0) }}</td>
                      <td style="white-space: nowrap;text-align: right;width: 250px;">{!! $detail->_remarks ?? '' !!}</td>
                      

                      
                   
                    
                    </tr>
@empty
@endforelse

 <tr>
                      <th></th>
                      <th colspan="4">Grand Total</th>
                     
                      
                      <th>{{_report_amount($total_qty ?? 0) }}</th>
                      <th></th>
                      <th>{{ _report_amount($total_cfr_value_usd ?? 0)}}</th>
                      <th></th>
                      <th>{{ _report_amount($total_cfr_value_bdt ?? 0) }}</th>
                      <th>{{_report_amount($total_insurance_bdt ?? 0)}}</th>
                      <th>{{_report_amount($total_lc_commision_bdt ?? 0)}}</th>
                      <th>{{_report_amount($total_custom_duty_bdt ?? 0)}}</th>
                      <th>{{_report_amount($total_custom_duty_tax_ait ?? 0)}}</th>
                      <th>{{_report_amount($total_custom_duty_tax_ait_2nd ?? 0)}}</th>
                      <th>{{_report_amount($total_customer_other_charge_other ?? 0)}}</th>
                      <th>{{_report_amount($total_port_charge ?? 0)}}</th>
                      <th>{{_report_amount($total_port_charge_ait ?? 0)}}</th>
                      <th>{{_report_amount($total_shiping_agent_charge ?? 0)}}</th>
                      <th>{{_report_amount($total_shiping_agent_deduction_charge_2nd ?? 0)}}</th>
                      <th>{{_report_amount($total_deport_charge ?? 0)}}</th>
                      <th>{{_report_amount($total_container_damage_charge ?? 0)}}</th>
                      <th>{{_report_amount($total_cnf_agen_commision ?? 0)}}</th>
                      <th>{{_report_amount($total_installation_cost ?? 0)}}</th>
                      <th>{{_report_amount($total_other_cost ?? 0)}}</th>
                      <th>{{_report_amount($total_total_initial_cost ?? 0)}}</th>
                      <th>{{_report_amount($total_salvage_value ?? 0)}}</th>
                      <th>{{_report_amount($total_depreciable_asset_value ?? 0)}}</th>
                      <th> {{_report_amount($total_other_cost_bdt ?? 0)}}</th>
                      <th>{{_report_amount($total_asset_value_bdt ?? 0)}}</th>
                      <th></th>
                    </tr>
<tr style="border:none;">
  <td colspan="31" style="border:none;">{{__('label._note')}}:{!! $data->_note ?? '' !!}</td>
</tr>
<tfoot>
  <tr style="border:none;">
    <td style="border:none;" colspan="31">
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