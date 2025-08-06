@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <div class="_report_button_header">
    <a class="nav-link"  href="{{url('expired-item')}}" role="button">
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
            <th style="width: 10%;" >Purchase ID</th>
            <th class="text-left">Item Name </th>
            <th style="width: 10%;">Unit</th>
            <th style="width: 10%;">Manufacture Date</th>
            <th style="width: 10%;">Expire Date</th>
            <th style="width: 10%;" class="text-right">Stock </th>
            <th style="width: 10%;" class="text-right">Purchase Rate </th>
            <th style="width: 10%;" class="text-right">Sales Rate </th>
            <th style="width: 10%;" class="text-right">Purchase Value</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
             
              $_total_qty = 0;
              $_total_cost_value = 0;
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
              <th colspan="9">





            @if(sizeof($_branch_ids) > 1 )
             Branch: {{ _branch_name($_branch_id) }} |
             @endif
             @if(sizeof($_cost_center_ids) > 1 )
               Cost Center: {{ _cost_center_name($_cost_center_id) }} |
             @endif
             @if(sizeof($_stores) > 1 )
               Store: {{ _store_name($_store_id) }} |
             @endif
            
              Category:  {{ _category_name($_category_id) }} 
            
              
              </th>
            </tr>
            @endif

            @php
              $_sub_total_qty = 0;
              $_sub_total_cost_value = 0;
              $row_counter =0;
            @endphp
            @forelse($_detail as $g_value)

            @php
              $row_counter +=1;

              $_total_qty += $g_value->_qty;
              $_total_cost_value += ($g_value->_qty*$g_value->_pur_rate);

              $_sub_total_qty += $g_value->_qty;
              $_sub_total_cost_value += ($g_value->_qty*$g_value->_pur_rate);
            @endphp
            <tr>
             
              <td style="width: 10%;"><a style="text-decoration: none;" target="__blank" href="{{ url('purchase/print',$g_value->_master_id) }}">
                  P- {!! $g_value->_master_id ?? '' !!}</a></td>
            <td class="text-left">{!! $g_value->_item ?? '' !!} </td>
            <td class="text-left" style="width: 10%;">{!! $g_value->_unit_name ?? '' !!}</td>
            
            <td style="width: 10%;">{!! _view_date_formate($g_value->_manufacture_date ) !!}</td>
            <td style="width: 10%;">{!! _view_date_formate($g_value->_expire_date ) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_qty) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_pur_rate) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_sales_rate) !!}</td>
            <td style="width: 10%;" class="text-right">{{ _report_amount(($g_value->_qty*$g_value->_pur_rate)) }}</td>
          </tr>
          @empty
          @endforelse
@if($row_counter > 1)
          <tr>
           

            <th colspan="5" class="text-left" >Sub Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_cost_value) !!}</th>
          </tr>
@endif
          @empty
          @endforelse
           <tr>
           

            <th colspan="5" class="text-left" >Grand Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_cost_value) !!}</th>
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


@endsection

@section('script')

@endsection
