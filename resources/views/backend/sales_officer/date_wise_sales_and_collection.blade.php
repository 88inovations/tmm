@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      
@if($request->has('_datex') && $request->has('_datey'))
<div class="_report_button_header">
     <a class="nav-link"  href="{{url('date_to_date_sales_amount_report')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>
 @php
$_branch_id  = $previous_filter["_branch_id"];
        @endphp
<section class="invoice" id="printablediv">
    <div class="container">
      <table class="table table-borderd" >
         <thead style="border:0px !important">
          <tr>
            <td colspan="8" style="border:0px !important">
               @include('backend.message.report_header')
            </td>
          </tr>
            
        </thead>
        <tbody>
            <tr style="border:none;">
                <td colspan="4" style="width: 50%;border: none;">
                    <table style="width:100%;border-collapse: collapse;border: 1px solid silver;">
                        <tr>
                            <th colspan="4" class="text-center">Sales Information</th>
                        </tr>
                        <tr>
                            <th style="width: 5%;border: 1px solid silver;">{{__('label.sl')}}</th>
                            <th style="width: 5%;border: 1px solid silver;">{{__('label._code')}}</th>
                            <th style="width: 5%;border: 1px solid silver;">{{__('label._ledger_id')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._amount')}}</th>
                        </tr>
@php
$gross_net_sales_amount  = 0;
@endphp

                @forelse($sales_and_returns as $sr_key=>$sr_val)

@php
$gross_net_sales_amount  +=$sr_val->_total ??  0;
@endphp
                        <tr>
                            <td style="width: 5%;border: 1px solid silver;white-space: nowrap;">{{ ($sr_key+1) }}</td>
                            <td style="width: 5%;border: 1px solid silver;white-space: nowrap;">{!! $sr_val->_code ?? '' !!}</td>
                            <td style="width: 5%;border: 1px solid silver;">{!! $sr_val->_name ?? '' !!}</td>
                            <td style="width: 5%;border: 1px solid silver;white-space: nowrap;">{!! _report_amount($sr_val->_total ?? 0) !!}</td>
                            
                        </tr>
                @empty
                @endforelse
                 <tr>
                            <td colspan="3" class="text-bold"> TOTAL SALES</td>
                            <td style="font-weight: bold;">{!! _report_amount($gross_net_sales_amount ?? 0) !!}</td>
                            
                        </tr>
                    </table>
                    
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border:none;width: 50%;">
                    <table style="width:100%;border-collapse: collapse;border: 1px solid silver;">
                        <tr>
                            <th colspan="4" class="text-center">Collection Information</th>
                        </tr>
                        <tr>
                            <th style="width: 5%;border: 1px solid silver;">{{__('label.sl')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._date')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._voucher_code')}}</th>
                            <th style="width: 30%;border: 1px solid silver;">{{__('label._ledger_id')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._amount')}}</th>
                        </tr>
                @php
                $gross_net_collection  = 0;
                @endphp
                @forelse($cash_bank_datas as $cb_key=>$cb_data)
                    @php
                    $gross_net_collection  +=$cb_data->_dr_amount ??  0;
                    @endphp
                        <tr>
                            <td style="border: 1px solid silver;white-space: nowrap;">{!! ($cb_key+1) !!}</td>
                            <td style="border: 1px solid silver;white-space: nowrap;">{!! _view_date_formate($cb_data->_date ?? '') !!}</td>
                            <td style="border: 1px solid silver;white-space: nowrap;">{!! $cb_data->_voucher_code ?? '' !!}</td>
                            <td style="border: 1px solid silver;">{!! _id_to_name($cb_data->_account_ledger,'_name','account_ledgers') !!}</td>
                            <td style="border: 1px solid silver;white-space: nowrap;">{!! _report_amount($cb_data->_dr_amount ?? 0) !!}</td>
                        </tr>
                @empty
                @endforelse
                <tr>
                    <td colspan="4" class="text-bold">TOTAL Collection</td>
                    <td style="font-weight: bold;">{!! _report_amount($gross_net_collection ?? 0) !!}</td>
                            
                </tr>
                    </table>
                </td>
            </tr>
           
        
        </tbody>
        <tfoot style="border:0px solid #000;">
            <tr style="border:0px solid #000;">
              <td colspan="8" style="border:0px solid #000;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
      </table>
    </div>
  </section>

  @endif
</div>



@endsection



