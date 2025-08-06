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
    <a class="nav-link"  href="{{url('group-ledger')}}" role="button">
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
                 {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
            @php
            $colspan=4;
            $_less=0;
            $grand_colspan =1;
             
            @endphp
            <th style="width: 15%;border:1px solid silver;">Date</th>
            @if(isset($previous_filter['_check_id']))
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
            <th style="width: 10%;border:1px solid silver;">ID</th>
            @else
            
            @endif

            @if(isset($previous_filter['short_naration']))
            <th style="width: 10%;border:1px solid silver;">Short Narration</th>
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
           @else
            
            @endif
            @if(isset($previous_filter['naration']))
            <th style="width: 10%;border:1px solid silver;">Narration</th>
            @php
            $colspan +=1;
            $grand_colspan +=1;
            @endphp
            @else
            
            @endif
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Dr. Amount</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Cr. Amount</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Balance</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
            $_dr_grand_total = 0;
            $_cr_grand_total = 0;
            @endphp
            @forelse($group_array_values as $key=>$value)
            <tr>
              
                <td colspan="{{$colspan}}" style="text-align: left;background: #f5f9f9;">
                  
                     <b> {{ $key ?? '' }} </b>
                    
                @php
                    $_group_running_sub_dr_total=0;
                    $_group_running_sub_cr_total=0;
                   
                  @endphp
              
              </td>
            </tr>
                @forelse($value as $l_key=>$l_val)

               
                  <tr>
                    <td colspan="{{$colspan}}" style="text-align: left;">
                     
                        <b>  {{ $l_key ?? '' }} </b>
                        
                     </td>
                  </tr>
                  @php
                    $running_sub_dr_total=0;
                    $running_sub_cr_total=0;
                    $runing_balance_total = 0;
                  @endphp
                  @forelse($l_val as $_dkey=>$detail)
                  @php
                    $_dr_grand_total +=$detail->_dr_amount ?? 0;
                    $_cr_grand_total +=$detail->_cr_amount ?? 0;

                    $_group_running_sub_dr_total+=$detail->_dr_amount ?? 0;
                    $_group_running_sub_cr_total+=$detail->_cr_amount ?? 0;
                    

                    $running_sub_dr_total +=$detail->_dr_amount ?? 0;
                    $running_sub_cr_total +=$detail->_cr_amount ?? 0;
                    $runing_balance_total += (($detail->_balance+$detail->_dr_amount)-$detail->_cr_amount);
                  @endphp
                  
                    <tr>
                    <td style="text-align: left;">
                      
                      {{ _view_date_formate($detail->_date ?? $_datex) }} </td>
                    @if(isset($previous_filter['_check_id']))
                    <td class="text-left">
                    @if($detail->_table_name=="voucher_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ route('voucher.show',$detail->_id) }}">
                {{ voucher_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="purchases")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('purchase/print',$detail->_id) }}">
                  {{ _purchase_pfix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="purchase_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('purchase/print',$detail->_id) }}">
                  {{ _purchase_pfix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="purchases_return")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('purchase-return/print',$detail->_id) }}">
                  {{ _purchase_return_pfix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="purchase_return_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('purchase-return/print',$detail->_id) }}">
                  {{ _purchase_return_pfix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="sales")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('sales/print',$detail->_id) }}">
                  {{ _sales_pfix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="sales_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('sales/print',$detail->_id) }}">
                  {{ _sales_pfix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="warranty_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('warranty-manage/print',$detail->_id) }}">
                  {{ warranty_prefix() }} {!! $detail->_id ?? '' !!}</a> <br>
                    @endif

                    @if($detail->_table_name=="warranty_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('warranty-manage/print',$detail->_id) }}">
                   {{ warranty_prefix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="resturant_sales")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('restaurant-sales/print',$detail->_id) }}">
                  {{ resturant_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="restaurant_sales_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('restaurant-sales/print',$detail->_id) }}">
                  {{ resturant_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="resturant_sales_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('restaurant-sales/print',$detail->_id) }}">
                 {{ resturant_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="sales_return")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('sales-return/print',$detail->_id) }}">
                  {{ _sales_return_pfix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="sales_return_accounts")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('sales-return/print',$detail->_id) }}">
                  {{ _sales_return_pfix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="damage")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('damage/print',$detail->_id) }}">
                  {{ _damage_pfix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif

                @if($detail->_table_name=="transfer")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('transfer-production/print',$detail->_id) }}">
                  {{ _transfer_prefix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif
                    @if($detail->_table_name=="production")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('transfer-production/print',$detail->_id) }}">
                  {{ production_prefix() }} {!! $detail->_id ?? '' !!}</a>
                    @endif

                    @if($detail->_table_name=="replacement_masters")
                       <a style="text-decoration: none;" target="__blank" href="{{ url('item-replace/print',$detail->_id) }}">
                       {{ _replace_prefix() }}{!! $detail->_id ?? '' !!}</a>
                   @endif
                   @if($detail->_table_name=="replacement_item_accounts")
                       <a style="text-decoration: none;" target="__blank" href="{{ url('item-replace/print',$detail->_id) }}">
                        {{ _replace_prefix() }} {!! $detail->_id ?? '' !!}</a>
                   @endif

                   @if($detail->_table_name=="warranty_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('warranty-manage/print',$detail->_id) }}">
                  {{ warranty_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                   @if($detail->_table_name=="service_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('third-party-service/print',$detail->_id) }}">
                  {{ service_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
                   @if($detail->_table_name=="individual_replace_masters")
                 <a style="text-decoration: none;" target="__blank" href="{{ url('individual-replacement-print',$detail->_id) }}">
                  {{ ind_rep_prefix() }}{!! $detail->_id ?? '' !!}</a>
                    @endif
             </td>
             @endif
             @if(isset($previous_filter['short_naration']))
                    <td style="text-align: left;">{{ $detail->_short_narration ?? '' }} </td>
            @endif
             @if(isset($previous_filter['naration']))
                    <td style="text-align: left;">{{ $detail->_narration ?? '' }} </td>
            @endif
                    <td style="text-align: right;">{{ _report_amount($detail->_dr_amount ?? 0) }} </td>
                    <td style="text-align: right;">{{ _report_amount($detail->_cr_amount ?? 0) }} </td>
                    <td style="text-align: right;">{{ _show_amount_dr_cr(_report_amount(  $runing_balance_total )) }} </td>

                  </tr>

                  @empty
                  @endforelse



                  <tr>
             
                <td colspan="{{($grand_colspan)}}" style="text-align: left;background: #f5f9f9;"><b>Sub Total of {{ $l_key ?? '' }} </b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_report_amount($running_sub_dr_total) }}</b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_report_amount($running_sub_cr_total) }}</b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_show_amount_dr_cr(_report_amount($running_sub_dr_total-$running_sub_cr_total)) }}</b> </td>
            </tr>
                

                @empty
                @endforelse

           

             <tr>
                    <td colspan="{{($grand_colspan)}}" style="text-align: left;background: #f5f9f9;"><b>Sub Total of {{$key ?? ''}}: </b> </td>
                    <td style="text-align: right;background: #f5f9f9;"><b>{{ _report_amount($_group_running_sub_dr_total ?? 0) }}</b> </td>
                    <td style="text-align: right;background: #f5f9f9;"><b>{{ _report_amount($_group_running_sub_cr_total ?? 0) }}</b> </td>
                    <td style="text-align: right;background: #f5f9f9;"><b>{{_show_amount_dr_cr(_report_amount($_group_running_sub_dr_total-$_group_running_sub_cr_total)) }}</b> </td>
                </tr>

              
            <tr>
                  <td colspan="{{$colspan}}"></td>
            </tr>

            @empty
            @endforelse
            <tr>
              
                <td colspan="{{($grand_colspan)}}" style="text-align: left;background: #f5f9f9;"><b>Grand Total </b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_report_amount($_dr_grand_total) }}</b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_report_amount($_cr_grand_total) }}</b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b>{{_show_amount_dr_cr(_report_amount($_dr_grand_total-$_cr_grand_total)) }}</b> </td>
            </tr>
          
          </tbody>
          <tfoot>
            <tr>
              <td colspan="{{$colspan}}">
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
