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
               
                <td colspan="4" style="border:none;width: 50%;">
                    <table style="width:100%;">
                        <tr>
                            <th style="width: 5%;border: 1px solid silver;">{{__('label.sl')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._date')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._voucher_code')}}</th>
                            <th style="width: 30%;border: 1px solid silver;">{{__('label.customer')}}</th>
                            <th style="width: 30%;border: 1px solid silver;">{{__('label._ledger_id')}}</th>
                            <th style="width: 10%;border: 1px solid silver;">{{__('label._amount')}}</th>
                        </tr>
                @php
                $gross_net_collection  = 0;
                @endphp
                @forelse($cash_bank_datas as $cb_key=>$cb_data)
                    @php
                    $gross_net_collection  +=$cb_data->_dr_amount ??  0;

                    $_master_id  = $cb_data->_ref_master_id ?? 0;
                    $_table_name = $cb_data->_table_name ?? 'sales';
                    $_ledger_id  = $cb_data->_account_ledger  ?? 0;


                    @endphp
                        <tr>
                            <td style="border:1px solid silver;white-space: nowrap;">{!! ($cb_key+1) !!}</td>
                            <td style="border:1px solid silver;white-space: nowrap;">{!! _view_date_formate($cb_data->_date ?? '') !!}</td>
                            <td style="border:1px solid silver;white-space: nowrap;">{!! $cb_data->_voucher_code ?? '' !!}</td>
                            <td style="border:1px solid silver;">
                               
   @php 
              $ledgers=  _oposite_account($_master_id,$_table_name,$_ledger_id);
              foreach($ledgers as $key_s=> $l){
                echo $l->_name;
                echo "<br/>";
              }
              @endphp
                        </td>

                        </td>
                            
                            <td style="border:1px solid silver;">{!! _id_to_name($cb_data->_account_ledger,'_name','account_ledgers') !!}</td>
                            <td style="border:1px solid silver;white-space: nowrap;">{!! _report_amount($cb_data->_dr_amount ?? 0) !!}</td>
                        </tr>
                @empty
                @endforelse
                <tr>
                    <td  style="border:1px solid silver;" colspan="5" class="text-bold">GRAND TOTAL</td>
                    <td style="font-weight: bold;border: 1px solid silver;">{!! _report_amount($gross_net_collection ?? 0) !!}</td>
                            
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



