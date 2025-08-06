
@extends('backend.layouts.app')
@section('title',$page_name)



@section('content')

<div class="_report_button_header">
    <a class="nav-link"  href="{{url('purchase-order')}}" role="button"><i class="fa fa-arrow-left"></i></a>


    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
  
<div style="page-break-after: always;">
  <table  style="width:100%;border-collapse: collapse;border:0px !important">
    <thead style="border:0px !important">
      <tr>
        <td colspan="16" style="border:0px !important">
          @include('backend.message.report_header')
        </td>
      </tr>
      <tr>
        <td colspan="16">
          <h3 class="text-center">{{$page_name ?? ''}}</h3>
        </td>
      </tr>
      <tr>
        <th rowspan="2" style="border:1px solid silver;vertical-align: center;">##</th>
        <th colspan="2" style="border:1px solid silver;vertical-align: center;">Supplier</th>
        <th colspan="2" style="border:1px solid silver;vertical-align: center;">Order</th>
        <th colspan="2" style="border:1px solid silver;vertical-align: center;">Product</th>
        <th colspan="2" style="border:1px solid silver;vertical-align: center;">Order Qty</th>
        <th colspan="2" style="border:1px solid silver;vertical-align: center;">Received Qty</th>
        <th colspan="2" style="border:1px solid silver;vertical-align: center;">Pending Qty</th>
        <th rowspan="2" style="border:1px solid silver;vertical-align: center;">Order value</th>
        <th rowspan="2" style="border:1px solid silver;vertical-align: center;">Receive value</th>
        <th rowspan="2" style="border:1px solid silver;vertical-align: center;">Pending value</th>
        
      </tr>
      <tr>
        <td style="border:1px solid silver;vertical-align: center;">Name</td>
        <td style="border:1px solid silver;vertical-align: center;">Code</td>
        <td style="border:1px solid silver;vertical-align: center;">No</td>
        <td style="border:1px solid silver;vertical-align: center;">Date</td>
        <td style="border:1px solid silver;vertical-align: center;">Name</td>
        <td style="border:1px solid silver;vertical-align: center;">Code</td>
        
        <td style="border:1px solid silver;vertical-align: center;">QTY</td>
        <td style="border:1px solid silver;vertical-align: center;">UNIT</td>

        <td style="border:1px solid silver;vertical-align: center;">QTY</td>
        <td style="border:1px solid silver;vertical-align: center;">UNIT</td>

        <td style="border:1px solid silver;vertical-align: center;">QTY</td>
        <td style="border:1px solid silver;vertical-align: center;">UNIT</td>
      </tr>
     
    </thead>

    <tbody>
       
      <tr>
        
        <td colspan="16" >
          <img src="{{asset($settings->_water_mark_image ?? '')}}" style="position: absolute;
    width: 400px;
    margin: 0px auto;
    margin-left: 30%;
    opacity: 0.2;
" alt="Background Image">
        </td>
      
      </tr>
      @php
$sl=1;
      @endphp
      @forelse($rearrange_data_sets as $key=>$val)
      @php

$key_array_data =  explode("___", $key);
$_order_number = $key_array_data[0] ?? '';
$_date = $key_array_data[1] ?? '';
$_ledger_id = $key_array_data[2] ?? '';
$ledger_info=\DB::table('account_ledgers')->where('id',$_ledger_id)->first();

$row_span = sizeof($val);
      @endphp
        @forelse($val as $item_key=>$item_data)
      <tr>
        @if($item_key ==0)
        <td  rowspan="{{$row_span}}" style="border:1px solid silver;vertical-align: center;" >{{ ($sl++) }}</td>
        <td rowspan="{{$row_span}}" style="border:1px solid silver;vertical-align: center;" >{{ $ledger_info->_name ?? '' }}</td>
        <td  rowspan="{{$row_span}}" style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $ledger_info->_code ?? '' }}</td>
        <td  rowspan="{{$row_span}}" style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $_order_number ?? '' }}</td>
        <td rowspan="{{$row_span}}"  style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $_date ?? '' }}</td>
        @endif
      
        <td   style="border:1px solid silver;vertical-align: center;" >{{ $item_data->_item_name ?? '' }}</td>
        <td   style="border:1px solid silver;vertical-align: center;" >{{ $item_data->_code ?? '' }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $item_data->order_qty ?? '' }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $item_data->_unit_name ?? '' }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $item_data->r_order_qty ?? '' }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $item_data->_unit_name ?? '' }}</td>

        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ ($item_data->order_qty - $item_data->r_order_qty) }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ $item_data->_unit_name ?? '' }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ _report_amount($item_data->_order_value ?? 0) }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ _report_amount($item_data->r_order_value ?? 0) }}</td>
        <td   style="border:1px solid silver;vertical-align: center;white-space: nowrap;" >{{ _report_amount($item_data->_order_value-$item_data->r_order_value ?? 0) }}</td>

        
      </tr>
      @empty
        @endforelse
       @empty
       @endforelse
                
    </tbody>



    <tfoot>
   
  <tr>
        <td colspan="16" style="height: 100px;"></td>
      </tr>
        <tr>
        <td colspan="4">
          <div class="inv_footer_arrea_left">
            <span class="sing_section">Prepared By  </span>
          </div>
        </td>
        <td colspan="4">
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Checked by</span>
          </div>
        </td>
        <td colspan="4">
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Accounts Signature</span>
          </div>
        </td>
        <td colspan="4">
          <div class="text-right" style="white-space:nowrap;">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
     
      
    </tfoot>
  </table>
</div>
    
    
   
      

    

    
    <!-- /.row -->
  </section>

@endsection