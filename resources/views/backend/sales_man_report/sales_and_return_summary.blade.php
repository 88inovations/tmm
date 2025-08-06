<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

    
      

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
            <th style="width: 10%;">Sales Amount</th>
            <th style="width: 10%;">Return Amount</th>
            <th style="width: 10%;">Net Sales Balance</th>
          </tr>
          
          
          </thead>
          <tbody>
@php
$sl=1;
$grand_total__sales_amount      = 0;
$grand_total__sales_return_amount   = 0;
$grand_total__cumulative_sales           = 0;

@endphp
  @forelse($datas as $org_key=>$org_datas) 


   @php

$org_sub__sales_amount             = 0;
$org_sub__sales_return_amount         = 0;
$org_sub__total                 = 0;

@endphp

  <tr class="display_none">
           
 <th colspan="8">{{__('label.organization_id')}} : {!! $permited_organizations_id_name[$org_key] ?? '' !!}</th>
           
</tr>

 @forelse($org_datas as $branch_key=>$branch_data) 

  @php

$branch_sub__sales_amount             = 0;
$branch_sub__sales_return_amount         = 0;
$branch_sub__total_vat             = 0;
$branch_sub__total                 = 0;

@endphp
            <tr>
              <th colspan="8">{{__('label._branch_id')}} :  {!! $permited_branch_id_name[$branch_key] ?? '' !!}</th>
            </tr>

@forelse($branch_data as $sales_man_key=>$sales_man_wise_datas) 

 @php

$sales_man_sub__sales_amount             = 0;
$sales_man_sub__sales_return_amount         = 0;

$sales_man_sub__total                 = 0;

@endphp

       <tr class="display_none">
              <th colspan="8">{{__( 'label._sales_man_id')}} :  {!! $all_ledgers_id_name[$sales_man_key] ?? '' !!}</th>
            </tr>
@forelse($sales_man_wise_datas as $index=>$val) 

@php
$sales_man_sub__sales_amount       +=$val->_sales_amount ?? 0;
$sales_man_sub__sales_return_amount  +=$val->_sales_return_amount ?? 0;

$sales_man_sub__total           += ($val->_sales_amount-$val->_sales_return_amount);

$branch_sub__sales_amount         +=$val->_sales_amount ?? 0;
$branch_sub__sales_return_amount   +=$val->_sales_return_amount ?? 0;

$branch_sub__total             +=($val->_sales_amount-$val->_sales_return_amount);

$org_sub__sales_amount             +=$val->_sales_amount ?? 0;
$org_sub__sales_return_amount         +=$val->_sales_return_amount ?? 0;

$org_sub__total                 +=($val->_sales_amount-$val->_sales_return_amount);

$grand_total__sales_amount       +=$val->_sales_amount ?? 0;
$grand_total__sales_return_amount   +=$val->_sales_return_amount ?? 0;

$grand_total__cumulative_sales           +=($val->_sales_amount-$val->_sales_return_amount);

@endphp
            <tr class="display_none">
            <td style="width: 5%;">{{($index+1)}}</td>
           
            <td style="width: 10%;">{!! _report_amount($val->_sales_amount ?? 0) !!}</td>
            <td style="width: 10%;">{!! _report_amount($val->_sales_return_amount ?? 0) !!}</td>
            <td style="width: 10%;">{!! _report_amount($sales_man_sub__total ?? 0) !!}</td>
           
            </tr>


@php

$sl++;
@endphp

@empty
@endforelse  
<tr>
            <td style="text-align: left;"> {{$all_ledgers_id_name[$sales_man_key] ?? 'No Sales Person' }}</td>
            <td style="width: 10%;">{{_report_amount($sales_man_sub__sales_amount)}}</td>
            <td style="width: 10%;">{{_report_amount($sales_man_sub__sales_return_amount)}}</td>
            <td style="width: 10%;">{{_report_amount($sales_man_sub__total)}}</td>
  </tr>

@empty
@endforelse 
<tr>
            <th  style="text-align: left;">Sub Total of {!! $permited_branch_id_name[$branch_key] ?? '' !!}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__sales_amount)}}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__sales_return_amount)}}</th>
            <th style="width: 10%;">{{_report_amount($branch_sub__total)}}</th>
  </tr>


@empty
@endforelse 
<tr class="display_none">
            <th  style="text-align: left;">Sub Total of {!! $permited_organizations_id_name[$org_key] ?? '' !!} {!! $permited_organizations_id_name[$branch_key] ?? '' !!}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__sales_amount)}}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__sales_return_amount)}}</th>
            <th style="width: 10%;">{{_report_amount($org_sub__total)}}</th>
  </tr>

@empty
@endforelse 
<tr>
            <th  style="text-align: left;">Grand Total</th>
            <th style="width: 10%;">{{_report_amount($grand_total__sales_amount)}}</th>
            <th style="width: 10%;">{{_report_amount($grand_total__sales_return_amount)}}</th>
            <th style="width: 10%;">{{_report_amount($grand_total__cumulative_sales)}}</th>
  </tr>
           


      






            
        

    
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="4" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>