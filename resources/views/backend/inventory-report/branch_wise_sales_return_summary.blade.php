@if($request->has('_datex') && $request->has('_datey') && $report_type==4)
<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    <div class="container-fluid">
      <table class="table table-borderd" >
         <thead style="border:0px !important">
          <tr>
            <td colspan="9" style="border:0px !important">
               @include('backend.message.report_header')
            </td>
          </tr>
          
          <tr>
            <td colspan="9" style="border:0px !important">
              <div style="width:100%;overflow: hidden;">
                <div style="width:130px;float: left;"><b>Date & Time</b> </div>
                <div style="float: left;">:{{ date('d-m-Y H:s a') }}</div>
              </div>
              <div style="width:100%;overflow: hidden;">
                <div style="width:130px;float: left;"><b>Name of Territory</b> </div>
                <div style="float: left;">:
@if($request->_branch_id =='')
 All Territory
@else
{{ _branch_name($request->_branch_id) }}
@endif
                </div>
              </div>
              <div style="width:100%;overflow: hidden;">
                <div style="width:130px;float: left;"><b>Name of Officer</b> </div>
                <div style="float: left;">:
@if($request->_sales_man_id  =='')
 All Officer
@else
{{ _ledger_name($request->_sales_man_id) }}
@endif
                </div>
              </div>
              <div style="width:100%;overflow: hidden;">
                <div style="width:130px;float: left;"><b>Subject. </b> </div>
                <div style="float: left;">: Territory Wise Product Sales Statement.</div>
              </div>
@php
$item_info = \App\Models\Inventory::with(['_pack_size'])->find($request->_main_item_id);
@endphp
              <div style="width:100%;overflow: hidden;">
                <div style="width:130px;float: left;"><b>Name of Product  </b> </div>
                <div style="float: left;">:{!! $item_info->_item ?? 'All Product.' !!} </div>
              </div>
              <div style="width:100%;overflow: hidden;">
                <div style="width:130px;float: left;"><b>Business Period  </b> </div>
                <div style="float: left;">: {{_view_date_formate($request->_datex)}} TO {{_view_date_formate($request->_datey)}}</div>
              </div>
            </td>
          </tr>

          <tr>
             
            <td style="border:1px solid silver;white-space: nowrap;">SL </td>
            <td style="border:1px solid silver;white-space: nowrap;"> Product ID</td>
            <td style="border:1px solid silver;white-space: nowrap;">Name of Product </td>
            <td style="width: 10%;border:1px solid silver;white-space: nowrap;">Pack Size</td>
            <td style="width: 10%;border:1px solid silver;white-space: nowrap;" class="text-right">Sales Quantity</td>
            <td style="width: 10%;border:1px solid silver;white-space: nowrap;" class="text-right">Trade Price</td>
            <td style="width: 10%;border:1px solid silver;white-space: nowrap;" class="text-right"> Sales Returned</td>
            <td style="width: 10%;border:1px solid silver;white-space: nowrap;" class="text-right">Total Sales Quantity</td>
            <td style="width: 10%;border:1px solid silver;white-space: nowrap;" class="text-right">Total Sales Amount</td>
          </tr>
        </thead>

        <tbody>
          
           @php
              $_total_sales_qty =0;
              $_total_return_qty =0;
              $_total_sales_qty =0;
              $_total_sales_amount =0;
            @endphp
  @forelse($datas as $key=>$data)

    @php
              $_total_sales_qty +=$data->_total_qty ?? 0;
              $_total_return_qty +=$data->_return_qty ?? 0;
              $_total_sales_qty +=($data->_total_qty-$data->_return_qty);
              $_total_sales_amount +=$data->net_sales_amount ?? 0;
            @endphp


        <tr>
             
            <td style="border:1px solid silver;">{{($key+1)}} </td>
            <td style="border:1px solid silver;"> {!! $data->_code ?? '' !!}</td>
            <td style="border:1px solid silver;">{!! $data->_name ?? '' !!} </td>
            <td style="width: 10%;border:1px solid silver;">{!! $data->_pack_name ?? '' !!}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{{_report_amount($data->_total_qty ?? 0)}}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{{_report_amount($data->avg_sales_rate ?? 0)}}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{{_report_amount($data->_return_qty ?? 0)}}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{{_report_amount($data->_total_qty-$data->_return_qty)}}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($data->net_sales_amount ?? 0) !!}</td>
          </tr>
@empty
@endforelse
          <tr>
            <th colspan="4" class="text-left"  style="border:1px solid silver;">Grand Total </th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_total_sales_qty) !!}</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right"></th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_total_return_qty) !!}</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_total_sales_qty) !!}</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_total_sales_amount) !!}</th>
          </tr>
         
        </tbody>
        <tfoot style="border:0px solid #000;">
            <tr style="border:0px solid #000;">
              <td colspan="9" style="border:0px solid #000;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
      </table>
    </div>
  </section>

  @endif