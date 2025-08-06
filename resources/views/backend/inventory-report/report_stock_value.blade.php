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
    <a class="nav-link"  href="{{url('stock-value')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
       <?php
$sequence_to_remove = "––------------–--";
?> 
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            <td style="border:none;width: 33%;text-align: left;">
              
            </td>
            <td style="border:none;width: 33%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>As on Date:{{ $previous_filter["_datex"] ?? '' }} </strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <br/><b>@foreach($permited_branch as $p_branch)
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach  </b></td> </tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: right;">
              <p class="text-right">Print: {{date('d-m-Y H:s:a')}}</p>
            </td>
          </tr>
        </table>
        

    <!-- Table row -->
<table class="cewReportTable">
          <thead>
          <tr>
             

            <th>Code </th>
            <th>Item </th>
            <th style="width: 10%;">Unit</th>
            <th style="width: 10%;">Pack Size</th>
            <th style="width: 10%;" class="text-right">Quantity</th>
            <th style="width: 10%;" class="text-right">Purchase Rate</th>
            <th style="width: 10%;" class="text-right">Purchase Value</th>
            <th style="width: 10%;" class="text-right">Sales Rate</th>
            <th style="width: 10%;" class="text-right">Sales Value</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
             
              $_total_qty = 0;
              $_total_value = 0;
              $_total_sales_value = 0;
              $remove_duplicate_branch=array();
            @endphp
            @forelse($group_array_values as $key=>$_detail)
            @php
              $key_arrays = explode("__",$key);
         
             $_store_id =  $key_arrays[0];
             $_category_id =  $key_arrays[1];
            
             
              @endphp
          
            <tr>
           
              
              <th colspan="5">





             @if(sizeof($_stores) > 1 )
                {{ _store_name($_store_id) }} |
             @endif
             @if(sizeof($category_ids) > 0 )
                {{ _category_name($_category_id) }} 
             @endif
             
              </th>

            </tr>
           

            @php
              $_sub_total_qty = 0;
              $_sub_total_value = 0;
              $_sub_total_sales_value = 0;
              $row_counter =0;
            @endphp
            @forelse($_detail as $g_value)

            @php
            $sales_value = ($g_value->_sale_rate*$g_value->_qty);
              $row_counter +=1;
              $_total_qty += $g_value->_qty;
              $_total_value += $g_value->_cost_value;
              $_sub_total_sales_value += $sales_value ?? 0;
              $_total_sales_value += $sales_value ?? 0;

              $_sub_total_qty += $g_value->_qty;
              $_sub_total_value += $g_value->_cost_value;
            @endphp
            <tr>
             

            <td style="white-space: nowrap;">{!! $g_value->_code ?? '' !!} </td>
            <td>{!! $g_value->_name ?? '' !!} </td>
            <td>{!! _unit_name($g_value->_unit_id ?? 1) !!} </td>
            <td>{!! $g_value->pack_name ?? '' !!} </td>
            
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_qty) !!}</td>
            <td style="width: 10%;" class="text-right">
             
              {!! _report_amount($g_value->_cost_value /$g_value->_qty) !!}
           
          </td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_cost_value) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_sale_rate) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount(($g_value->_sale_rate*$g_value->_qty)) !!}</td>
          </tr>
          @empty
          @endforelse
@if($row_counter > 1)
          <tr>
           

            <th colspan="4" class="text-left" >Sub Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_value) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_sales_value) !!}</th>
          </tr>
@endif
          @empty
          @endforelse
          <tr>
           


            <th colspan="4" class="text-left">Grand Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_value) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_sales_value) !!}</th>
          </tr>
            
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="11">
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
