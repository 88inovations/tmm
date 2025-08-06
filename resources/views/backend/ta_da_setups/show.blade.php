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
    <a class="nav-link"  href="{{route('sales_commision_plans.index')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <?php
$sequence_to_remove = "––------------–--";
?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 20px;"><b>{{$page_name}}  </b></td> </tr>

                 
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">Date : {{_view_date_formate($data->_date ?? '')}}</td> </tr>
                 
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">
                  {{__('label.organization_id')}} : {{ $data->_organization->_name ?? '' }}
                  
                 </td> 
               </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">
                Plan Name : {{ $data->_name ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 18px;">
                 
                   {{__('label._fescal_year')}} : {{ $data->_fescal_year ?? '' }}
                
                 </td> </tr>
                
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
    <table class="table table-bordered" >
                                          <thead >
@php

$_details = $data->_detail ?? [];
@endphp
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >{{__('label._target_min')}}</th>
                                            <th class="text-left" >{{__('label._target_max')}}</th>
                                            <th class="text-left" >{{__('label._credit_limit')}}</th>
                                            <th class="text-left" >{{__('label._terms_id')}}</th>
                                            <th class="text-left" >{{__('label._p_qty')}}</th>
                                            <th class="text-left" >{{__('label._bonus_qty')}}</th>
                                            <th class="text-left" >{{__('label._anual_discount')}}</th>
                                            <th class="text-left" >{{__('label._cash_discount_rate')}}</th>
                                            <th class="text-left" >{{__('label._gift_item')}}</th>
                                            <th class="text-left" >{{__('label._grade')}}</th>
                                            <th class="text-left" >{{__('label._status')}}</th>
                                          </thead>
                                          <tbody >
                                        
                                            @forelse($_details as $detail)
                                             <tr >
                                             
                                               <td>{{ $$detail->id ?? '' }} </td>
                                              <td>{{_report_amount($detail->_target_min ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_target_max ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_credit_limit ?? 0)}}</td>
                                              <td>{{id_to_cloumn($detail->_terms_id,'_name','transection_terms') }} || {{id_to_cloumn($detail->_terms_id,'_days','transection_terms') }} Days</td>
                                              <td>{{_report_amount($detail->_p_qty ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_bonus_qty ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_discount_rate ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_cash_discount_rate ?? 0)}}</td>
                                              <td>{{$detail->_gift_item ?? '' }}</td>
                                              <td>{{$detail->_grade ?? '' }}</td>
                                              <td>{{ selected_status($data->detail ?? 0)  }}</td>
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                         
                                          </tbody>
                                          
                                      </table>


       @include('backend.message.invoice_footer')

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
