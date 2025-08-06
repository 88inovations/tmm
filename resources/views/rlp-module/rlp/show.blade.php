
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
.footer{
       position:relative;
       top:-20px; 
       height:10px;
    }
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('rlp')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('rlp-edit')
 <a  href="{{ route('rlp.edit',$data->id) }}" 
    class="nav-link "  title="Edit"  >
    <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
       
        <div style="text-align: center;">
       <h3> {{$settings->name ?? '' }} </h3>
       <div>{{$settings->_address ?? '' }}</br>
       {{$settings->_phone ?? '' }}</div>
       <h3>{{$page_name}}</h3>

      </div>
      </div>
      
    </div>
    <!-- info row -->
   
  @php
                      $_item_detail = $data->_item_detail ?? [];
                      $row_span= sizeof($_item_detail);
                      $purpose =[];
                      $item_total_qty=[];
                      $item_total_amount=[];
                      @endphp
@if($row_span > 0)
<div class="">
    <table class="table table-bordered ">
        <tr>
          <td>{{__('label._date')}}:</td>
          <td><b>{!! _view_date_formate($data->request_date ?? '') !!}</b></td>
          <td>{!! $data->rlp_prefix !!} No:</td>
          <td><b>{!! $data->rlp_no ?? '' !!}</b></td>
          <td>{{__('label.priority')}}:</td>
          <td><b>{!! selected_priority($data->priority ?? 1) !!}</b></td>
        </tr>
        <tr>
          <td>{{__('label.organization_id')}}:</td>
          <td><b>{!! $data->_organization->_name ?? '' !!}</b></td>
          <td>{{__('label._branch_id')}}:</td>
          <td><b>{!! $data->_branch->_name ?? '' !!}</b></td>
          <td>{{__('label._cost_center_id')}}:</td>
          <td><b>{!! $data->_cost_center->_name ?? '' !!}</b></td>
        </tr>
    </table>
   <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class="text-center"><b>{{__('label.sl')}}</b></th>
                         <th class="text-center"><b>{{__('label.item_details')}}</b></th>
                         <th class="text-center"><b>{{__('label.purpose_purchase')}}</b></th>
                         <th colspan="2" class="text-center"><b>{{__('label.quantity')}}</b></th>
                         <th class="text-center"><b>{{__('label.estimated_price')}}</b></th>
                         <th class="text-center"><b>{{__('label.total_estimated_price')}}</b></th>
                         <th class="text-center"><b>{{__('label.supplier_details')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      @php
                      $sl=1;
                      $last_key = (sizeof($_item_detail)-1);
                      @endphp
                      @forelse($_item_detail as $key=>$item)
                       @php
                      
                      $item_total_qty[]=$item->quantity ?? 0;
                      $item_total_amount[]=$item->amount ?? 0;
                      @endphp
                      <tr>
                        <td>{{$sl}}</td>
                        <td>{!! $item->_items->_item ?? '' !!} <br>
                          {!! $item->_item_description ?? '' !!}
                        </td>
                       
                        <td >
                          @if(!in_array($item->purpose,$purpose))
                          @php
                          array_push($purpose,$item->purpose);
                          @endphp
                           {!! $item->purpose ?? '' !!} 
                           @endif
                        </td>
                       
                        <td>{!! _find_unit($item->_unit_id) !!}</td>
                        <td style="text-align:right;">{!! _report_amount($item->quantity ?? 0) !!}</td>
                        <td style="text-align:right;">{!! _report_amount($item->unit_price ?? 0) !!}</td>
                        <td style="text-align:right;">{!! _report_amount($item->amount ?? 0) !!}</td>
                        <td>{!! $item->_supplier->_name ?? '' !!}</td>
                      </tr>
                      
                      @php
                      $sl++;
                      @endphp
                      @empty
                      @endforelse

                       @php
                      $_account_detail = $data->_account_detail ?? [];
                      $row_span= sizeof($_account_detail);
                      $purpose =[];
                      $_total_ac_amount=[];
                      @endphp
                      @forelse($_account_detail as $key=>$item)
                      
                      <tr>
                        <td>{{$sl}}</td>
                        <td>{!! $item->_ledger->_name ?? '' !!} <br>
                          {!! $item->_rlp_ledger_description ?? '' !!}
                        </td>
                       
                        <td >
                          @if(!in_array($item->purpose,$purpose))
                          @php
                          array_push($purpose,$item->purpose);
                          @endphp
                           {!! $item->purpose ?? '' !!} 
                           @endif
                        </td>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">{!! _report_amount($item->amount ?? 0) !!}</td>
                        @php
                        $item_total_amount[]=$item->amount ?? 0;
                        @endphp
                      </tr>

                      @php
                      $sl++;
                      @endphp
                      @empty
                      @endforelse
        <tr>
            <th colspan="3">{{__('label._total')}}:</th>
            <th></th>
            <th class="text-right">{{ _report_amount(array_sum($item_total_qty)) }}</th>
            <th></th>
            <th class="text-right">{{ _report_amount(array_sum($item_total_amount)) }}</th>
            <th></th>
          </tr>    
          <tr>
            <td colspan="8"><b>In Word:</b> {!! convert_number(array_sum($item_total_amount)) !!} Taka Only.</td>
          </tr>  
          <tr>
            <td colspan="8">{!! __('label._terms_condition') !!}: <br> {!! $data->_terms_condition ?? '' !!} </td>
          </tr>

</tbody>

@php

$_rlp_acks =  $data->_rlp_ack_app ?? [];

@endphp
                        <tfoot class="footer">
                          <tr>
                            <td colspan="8">
                              <table style="width:100%;">
                                <tr>
                                   @forelse($_rlp_acks as $key=>$val)
                                @if($val->ack_status==1)
                                  <td  style="height: 100px;">
                                    <!-- <img src="{{asset($val->_signature)}}" style="width: 100px;height: 50px;margin:0px auto;"> -->
                                    <div style="text-align: center;">
                                      <img src="{{asset($val->_employee->_signature ?? '')}}" style="height: 80px;padding:10px 0px;">
                                    </div>

                                  </td>
                                @endif
                                @empty
                                @endforelse
                                </tr>
                                <tr>
                            @forelse($_rlp_acks as $key=>$val)
                            @if($val->ack_status==1 )
                              <td  class="text-center">
                                <b>{!! $val->_check_group->_display_name ?? '' !!}</b>
                                <br>
                                {!! $val->_employee->_name ?? '' !!}<br>
                                {!! $val->_employee->_emp_designation->_name ?? '' !!}<br>

                              </td>
                            @endif
                            @empty
                            @endforelse
                          </tr>
                              </table>
                              
                            </td>
                           
                          </tr>
                          
                        </tfoot>
                        

                        
                    </table>
                </div>
    @endif

  </section>

</div>
@endsection

@section('script')

@endsection