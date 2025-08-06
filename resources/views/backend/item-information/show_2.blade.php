<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$page_name ?? ''}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     
      <style type="text/css">
            @page {
              size: A4 ;
              margin: 5mm 5mm 5mm 5mm;
            }
            .company_title{
                font-weight: 700;
                font-size: 22px;
            }
            .header_report_name{
                font-weight: 700;
                font-size: 18px;
            }
            .header_address{
                font-weight: 500;
                font-size: 14px;
            }
            th,td{
                border: 1px solid silver;
                font-size: 14px;
                font-weight: 400;

            }
            th{
                font-weight: bold;
            }
      </style>
    </head>

<style type="text/css">
     @page {
              size: A3 landscape ;
              margin: 5mm 5mm 5mm 5mm;
            }
    .vertical_left{
        writing-mode: vertical-lr;
        transform: rotate(180deg);
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
    }
    .vertical_normal{
        white-space: nowrap;
        font-size: 12px;
        vertical-align: top;
    }
    .bold{
        font-weight: 600;
    }
    .text_right{
        text-align: right;
    }
    .text_left{
        text-align: left;
    }
</style>
    <body class="antialiased">
        <div  >
        <div style="width:100%;border-collapse: collapse;float: left;">
        <table style="width:100%;border-collapse: collapse;">
            <thead>
                <tr style="border:none;">
                    <td colspan="44" style="border:none;">
                        <div class="report_top_header">
                            <table style="width:100%;text-align:center;">
                                <tr style="border:none;">
                                    <td style="border:none;"> <span style="font-size: 22px;font-weight: bold;">{!! $company_name ?? '' !!}</span></td>
                                </tr>
                               
                                <tr style="border:none;">
                                    <td style="border:none;"> <span class="header_report_name">{{ $page_name ?? '' }} for the Month of {{ _number_to_month($period) }} , {{$year}}</span></td>
                                </tr>
                                
                            </table>
                           
                            
                        </div>
                    </td>
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
                     <td style="font-size: 12px;">SL</td>
                      <td style="font-size: 12px;">{{__('label._asset_category_id')}}</td>
                      <td style="font-size: 12px;">Asset Code</td>
                      <td style="font-size: 12px;">{{__('label._asset_name')}}</td>
                      <td style="font-size: 12px;">{{__('label._unit_id')}}</td>
                      <td style="font-size: 12px;">{{__('label._qty')}}</td>
                      <td style="font-size: 12px;">{{__('label._rate_usd')}}</td>
                      <td style="font-size: 12px;">{{__('label._cfr_value_usd')}}</td>
                      <td style="font-size: 12px;">{{__('label._currency_rate_usd_to_bdt')}}</td>
                      <td style="font-size: 12px;">{{__('label._cfr_value_bdt')}}</td>
                      <td style="font-size: 12px;">{{__('label._insurance_bdt')}}</td>
                      <td style="font-size: 12px;">{{__('label._lc_commision_bdt')}}</td>
                      <td style="font-size: 12px;">{{__('label._custom_duty_bdt')}}</td>
                      <td style="font-size: 12px;" class="_required">{{__('label._custom_duty_tax_ait')}}</td>
                      <td style="font-size: 12px;" class="_required">{{__('label._custom_duty_tax_ait_2nd')}}</td>
                      <td style="font-size: 12px;">{{__('label._customer_other_charge_other')}}</td>
                      <td style="font-size: 12px;">{{__('label._port_charge')}}</td>
                      <td style="font-size: 12px;" class="_required">{{__('label._port_charge_ait')}}</td>
                      <td style="font-size: 12px;">{{__('label._shiping_agent_charge')}}</td>
                      <td style="font-size: 12px;">{{__('label._shiping_agent_deduction_charge_2nd')}}</td>
                      <td style="font-size: 12px;">{{__('label._deport_charge')}}</td>
                      <td style="font-size: 12px;">{{__('label._container_damage_charge')}}</td>
                      <td style="font-size: 12px;">{{__('label._cnf_agen_commision')}}</td>
                      <td style="font-size: 12px;">{{__('label._installation_cost')}}</td>
                      <td style="font-size: 12px;">{{__('label._other_cost')}}</td>
                      <td style="font-size: 12px;">{{__('label._total_initial_cost')}}</td>
                      <td style="font-size: 12px;">{{__('label._salvage_value')}}</td>
                      <td style="font-size: 12px;">{{__('label._depreciable_asset_value')}}</td>
                      <td style="font-size: 12px;">{{__('label._other_cost_bdt')}}</td>
                      <td style="font-size: 12px;">{{__('label._asset_value_bdt')}}</td>
                      <td style="font-size: 12px;width: 250px;">{{__('label._remarks')}}</td>
                 
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
                      <td style="white-space: nowrap;">{{ $detail->_asset_name ?? '' }}</td>
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




                
            </tbody>
            <tfoot style="padding-bottom: 50px;">
                
               
                <tr>
                    <td colspan="3" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Prepared By</span>
                    </td>
                    <td colspan="3" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Checked By</span>
                    </td>
                    <td colspan="10" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Head of HR</span>
                    </td>
                    <td colspan="10" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Finance & Accounts</span>
                    </td>
                    <td colspan="10" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Director</span>
                    </td>
                    <td colspan="8" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Managing Director</span>
                    </td>
                   
                </tr>
                <tr>
                    <td colspan="44" style="border: none;">
                        <div style="padding-top:70px;">
                              
                        </div>
                    </td>
                </tr>
            </tfoot>

            
        </table>
    </div>

</div>
</body>





            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
    </body>


</html>