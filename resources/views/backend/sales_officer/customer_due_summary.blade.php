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
            <td colspan="6" style="border:0px !important">
               @include('backend.message.report_header')
            </td>
          </tr>
            

          <tr>
            <th style="width: 5%;">{{__('label.sl')}}</th>
            <th style="width: 5%;">{{__('label._code')}}</th>
            <th style="width: 15%;">{{__('label._ledger_id')}}</th>
            <th style="width: 10%;">{{__('label._phone')}}</th>
            <th style="width: 15%;">{{__('label._address')}}</th>
            <th style="width: 10%;">{{__('label._amount')}}</th>
          </tr>
        </thead>
        <tbody>
           @php
              $grand_total_amount =0;
            @endphp
          @forelse($datas as $key=> $data)
             
             @php
              $grand_total_amount +=$data->_balance ?? 0;
            @endphp
<tr>
            <td style="border:1px solid silver;">{!! ($key+1) !!} </td>
            <td style="border:1px solid silver;white-space: nowrap;">{!! $data->_code ?? '' !!} </td>
            <td style="border:1px solid silver;">{!! $data->_name ?? '' !!} </td>
            <td style="border:1px solid silver;">{!! $data->_phone ?? '' !!} </td>
            <td style="border:1px solid silver;">{!! $data->_address ?? '' !!} </td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{{ _report_amount($data->_balance) }}</td>
          </tr>
          @empty
          @endforelse
          <tr>
            

            <th colspan="5" class="text-left"  style="border:1px solid silver;">GRAND TOTAL </th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($grand_total_amount) !!}</th>
          </tr>
        
        </tbody>
        <tfoot style="border:0px solid #000;">
            <tr style="border:0px solid #000;">
              <td colspan="7" style="border:0px solid #000;">
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



