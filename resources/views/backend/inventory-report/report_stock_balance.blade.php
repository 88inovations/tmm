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
    <a class="nav-link"  href="{{url('stock-balance')}}" role="button">
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date As On:{{ _view_date_formate($_datex ?? '') }} </strong></td> </tr>
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
            <th style="width: 10%;" class="text-right">Purchase Rate</th>
            <th style="width: 10%;" class="text-right">Sales Rate</th>
            <th style="width: 10%;" class="text-right">Qty</th>
            <th style="width: 10%;" class="text-right">Purchase Value</th>
            <th style="width: 10%;" class="text-right">Sales Value</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
              $_total_balance = 0;
              $_total_purchase_value= 0;
              $_total_sales_value= 0;
              $remove_duplicate_branch=array();
            @endphp
            @forelse($group_array_values as $branch_key=> $branch_data)
             @if(sizeof($_branch_ids) > 1 )
            <tr>
              <th colspan="7">
                Branch: {{ _branch_name($branch_key) }}
              </th>
            </tr>
            @endif

            @forelse($branch_data as $cost_key=> $cost_data)
             @if(sizeof($_cost_center_ids) > 1 )
            <tr>
              <th colspan="7">
                Cost Center: {{ _cost_center_name($cost_key) }}
              </th>
            </tr>
            @endif

             @forelse($cost_data as $store_key=> $store_data)
              @if(sizeof($permited_stores) > 1 )
             <tr>
              <th colspan="7">
                Store: {{ _store_name($store_key) }}
              </th>
            </tr>
            @endif

             @forelse($store_data as $category_key=> $category_data)
             <tr>
              <th colspan="7">
               Category: {{ _category_name($category_key) }}
              </th>
            </tr>


             @php
              $_sub_total_balance =0;
              $_sub_purchase_value =0;
              $_sub_sales_value =0;


            @endphp

             @forelse($category_data as $m_key=> $m_value)
             <tr>
               <td colspan="7"><b>{{$m_key ?? '' }}</b></td>
             </tr>

             @forelse($m_value as $g_key=>$g_value)


            @php
              $_sub_total_balance += $g_value->balance_qty ?? 0;
              $_total_balance += $g_value->balance_qty ?? 0;

              $_total_purchase_value +=($g_value->balance_qty*$g_value->_pur_rate);
              $_total_sales_value +=($g_value->balance_qty * $g_value->_sale_rate);


              $_sub_purchase_value +=($g_value->balance_qty*$g_value->_pur_rate);
              $_sub_sales_value +=($g_value->balance_qty * $g_value->_sale_rate);
            @endphp
            <tr style="background: @if($g_value->balance_qty ==0) #e66c6c @endif">
             
            <td>{!! $g_value->_item ?? '' !!} </td>
            <td style="width: 10%;">{!! $g_value->_unit ?? '' !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_pur_rate) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_sale_rate) !!}</td>
            <td style="width: 10%;" class="text-right">{{ _report_amount($g_value->balance_qty) }}</td>
            <td style="width: 10%;" class="text-right">{{ _report_amount($g_value->balance_qty*$g_value->_pur_rate) }}</td>
            <td style="width: 10%;" class="text-right">{{ _report_amount($g_value->balance_qty * $g_value->_sale_rate) }}</td>
          </tr>
          @empty
          @endforelse
          @empty
          @endforelse

          <tr>
            

            <th colspan="2" class="text-left" >Sub Total </th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_balance) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_purchase_value) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_sales_value) !!}</th>
          </tr>


          @empty
          @endforelse

          @empty
          @endforelse

          @empty
          @endforelse
           

           @empty
          @endforelse
          <tr>
            

            <th colspan="2" class="text-left" >Grand Total </th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_balance) !!}</th>
              <th style="width: 10%;" class="text-right">{!! _report_amount($_total_purchase_value) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_sales_value) !!}</th>
          </tr>
            
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="6">
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
