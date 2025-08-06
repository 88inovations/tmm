<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv" style="padding:2px;">
    

       
      

    <!-- Table row -->
   <table class="cewReportTable" style="border:none;">
          <thead style="border:none;">
            <tr style="border:none;background: #fff;">
              <td colspan="9" style="border:none;">
                 <table class="table" style="border:none;width: 100%;">
          <tr style="border:none;">
            <div >
             <img src="{{url($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 120px;height: 100px;"  >
           </div>
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;margin-top:-90px ;">
                <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr style="line-height: 16px;border:none;" > <td class="text-center" style="border:none;">
                  <br/><b>@foreach($permited_branch as $p_branch)
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach  </b></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
              </td>
            </tr>
          <tr>
             
            <th style="width: 10%;">SL</th>
            <th style="width: 10%;">Date</th>
            <th style="width: 10%;">INV NO</th>
            <th style="width: 10%;">Customer</th>
            <th style="width: 200px;">Phone</th>
            <th style="width: 10%;">Gross Sales</th>
            <th style="width: 10%;">Discount</th>
            <th style="width: 10%;">VAT</th>
            <th style="width: 10%;">Net Sales Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
@php
$sl=1;
$grand_total__sub_total      = 0;
$grand_total__total_discount   = 0;
$grand_total__total_vat        = 0;
$grand_total__total           = 0;

@endphp
  @forelse($datas as $org_key=>$org_datas) 


   @php

$org_sub__sub_total             = 0;
$org_sub__total_discount         = 0;
$org_sub__total_vat             = 0;
$org_sub__total                 = 0;

@endphp

  <tr class="display_none">
           
 <th colspan="9">{{__('label.organization_id')}} : {!! $permited_organizations_id_name[$org_key] ?? '' !!}</th>
           
</tr>

 @forelse($org_datas as $branch_key=>$branch_data) 

  @php

$branch_sub__sub_total             = 0;
$branch_sub__total_discount         = 0;
$branch_sub__total_vat             = 0;
$branch_sub__total                 = 0;

@endphp
            <tr>
              <th colspan="9">{{__('label._branch_id')}} :  {!! $permited_branch_id_name[$branch_key] ?? '' !!}</th>
            </tr>

@forelse($branch_data as $sales_man_key=>$sales_man_wise_datas) 

 @php

$sales_man_sub__sub_total             = 0;
$sales_man_sub__total_discount         = 0;
$sales_man_sub__total_vat             = 0;
$sales_man_sub__total                 = 0;

@endphp

       <tr>
              <th colspan="9">{{__( 'label._sales_man_id')}} :  {!! $all_ledgers_id_name[$sales_man_key] ?? '' !!}</th>
            </tr>
@forelse($sales_man_wise_datas as $index=>$val) 

@php
$sales_man_sub__sub_total       +=$val->_sub_total ?? 0;
$sales_man_sub__total_discount  +=$val->_total_discount ?? 0;
$sales_man_sub__total_vat       +=$val->_total_vat ?? 0;
$sales_man_sub__total           +=$val->_total ?? 0;

$branch_sub__sub_total         +=$val->_sub_total ?? 0;
$branch_sub__total_discount   +=$val->_total_discount ?? 0;
$branch_sub__total_vat         +=$val->_total_vat ?? 0;
$branch_sub__total             +=$val->_total ?? 0;

$org_sub__sub_total             +=$val->_sub_total ?? 0;
$org_sub__total_discount         +=$val->_total_discount ?? 0;
$org_sub__total_vat              +=$val->_total_vat ?? 0;
$org_sub__total                 +=$val->_total ?? 0;

$grand_total__sub_total       +=$val->_sub_total ?? 0;
$grand_total__total_discount   +=$val->_total_discount ?? 0;
$grand_total__total_vat        +=$val->_total_vat ?? 0;
$grand_total__total           +=$val->_total ?? 0;

@endphp
            <tr>
            <td style="width: 5%;">{{($index+1)}}</td>
            <td style="width: 10%;white-space: nowrap;">{!! _view_date_formate($val->_date ?? '') !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $val->_order_number ?? '' !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $all_ledgers_id_name[$val->_ledger_id] ?? '' !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $val->_phone ?? '' !!}</td>
           
            <td style="width: 10%;">{!! _report_amount($val->_sub_total ?? 0) !!}</td>
            <td style="width: 10%;">{!! _report_amount($val->_total_discount ?? 0) !!}</td>
            <td style="width: 10%;">{!! _report_amount($val->_total_vat ?? 0) !!}</td>
            <td style="width: 10%;">{!! _report_amount($val->_total ?? 0) !!}</td>
           
            </tr>


@php

$sl++;
@endphp

@empty
@endforelse  
<tr>
            <th colspan="5" style="text-align: left;">Sub Total of {{$all_ledgers_id_name[$sales_man_key] ?? '' }}</th>
            <th style="width: 10%;">{{_report_amount($sales_man_sub__sub_total)}}</th>
            <th style="width: 10%;">{{_report_amount($sales_man_sub__total_discount)}}</th>
            <th style="width: 10%;">{{_report_amount($sales_man_sub__total_vat)}}</th>
            <th style="width: 10%;">{{_report_amount($sales_man_sub__total)}}</th>
  </tr>

@empty
@endforelse 
<tr>
            <th colspan="5" style="text-align: left;">Sub Total of {!! $permited_branch_id_name[$branch_key] ?? '' !!}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__sub_total)}}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__total_discount)}}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__total_vat)}}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__total)}}</th>
  </tr>


@empty
@endforelse 
<tr class="display_none">
            <th colspan="5" style="text-align: left;">Sub Total of {!! $permited_organizations_id_name[$org_key] ?? '' !!} {!! $permited_organizations_id_name[$branch_key] ?? '' !!}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__sub_total)}}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__total_discount)}}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__total_vat)}}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__total)}}</th>
  </tr>

@empty
@endforelse 
<tr>
            <th colspan="5" style="text-align: left;">Grand Total</th>
            <th style="width: 10%;">{{_report_amount($grand_total__sub_total)}}</th>
            <th style="width: 10%;">{{_report_amount($grand_total__total_discount)}}</th>
            <th style="width: 10%;">{{_report_amount($grand_total__total_vat)}}</th>
            <th style="width: 10%;">{{_report_amount($grand_total__total)}}</th>
  </tr>
           


      






            
        

    
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="9" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>