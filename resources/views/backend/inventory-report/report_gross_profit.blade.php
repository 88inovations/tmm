@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <div class="_report_button_header">
    <a class="nav-link"  href="{{url('gross-profit')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
 
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <br/><b>@foreach($permited_branch as $p_branch)
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach  </b></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
        

    <!-- Table row -->
    <table class="cewReportTable">
          <thead>
          <tr>
            <th>Item Name </th>
            <th style="width: 10%;">Unit</th>
            <th style="width: 10%;" class="text-right">QTY</th>
            <th style="width: 10%;" class="text-right">Sales Value </th>
            <th style="width: 10%;" class="text-right">Cost Value </th>
            <th style="width: 10%;" class="text-right">Gross Profit</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
             
              $_total_qty = 0;
              $_total_sales_value = 0;
              $_total_cost_value = 0;
              $_total_profit = 0;
               $remove_duplicate_branch=array();
            @endphp
            @forelse($group_array_values as $key=>$_detail)
            @php
              $key_arrays = explode("__",$key);
             $_branch_id =  $key_arrays[0];
             $_cost_center_id =  $key_arrays[1];
             $_store_id =  $key_arrays[2];
             $_category_id =  $key_arrays[3];
           
              @endphp
             @if(!in_array($key,$remove_duplicate_branch))
            <tr>
              @php
                array_push($remove_duplicate_branch,$key);
              @endphp
              <th colspan="7">





            @if(sizeof($_branch_ids) > 1 )
              {{ _branch_name($_branch_id) }} |
             @endif
             @if(sizeof($_cost_center_ids) > 1 )
                {{ _cost_center_name($_cost_center_id) }} |
             @endif
             @if(sizeof($_stores) > 1 )
                {{ _store_name($_store_id) }} |
             @endif
             @if(sizeof($category_ids) > 1 )
                {{ _category_name($_category_id) }} 
             @endif
              
              </th>
            </tr>
            @endif

            @php
              $_sub_total_qty = 0;
              $_sub_total_sales_value = 0;
              $_sub_total_cost_value = 0;
              $_sub_total_profit = 0;
              $row_counter =0;
            @endphp
            @forelse($_detail as $g_value)

            @php
              $row_counter +=1;

              $_total_qty += $g_value->_qty;
              $_total_sales_value += $g_value->_value;
              $_total_cost_value += $g_value->_cost_value;
              $_total_profit += ($g_value->_value-$g_value->_cost_value);

              $_sub_total_qty += $g_value->_qty;
              $_sub_total_sales_value += $g_value->_value;
              $_sub_total_cost_value += $g_value->_cost_value;
              $_sub_total_profit += ($g_value->_value-$g_value->_cost_value);
            @endphp
            <tr>
             

            <td>{!! $g_value->_name ?? '' !!} </td>
            <td style="width: 10%;">{!! $g_value->_unit_name ?? '' !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_qty) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_value) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_cost_value) !!}</td>
            <td style="width: 10%;" class="text-right">{{ _report_amount(($g_value->_value-$g_value->_cost_value)) }}</td>
          </tr>
          @empty
          @endforelse
@if($row_counter > 1)
          <tr>
           

            <th colspan="2" class="text-left" >Sub Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_sales_value) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_cost_value) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_profit) !!}</th>
          </tr>
@endif
          @empty
          @endforelse
          <tr>
           

            <th colspan="2" class="text-left">Grand Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_sales_value) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_cost_value) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_profit) !!}</th>
          </tr>
            
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="9">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>
     

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')

@endsection
