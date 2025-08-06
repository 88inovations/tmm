@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<div class="container">
@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_import_cost_list')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.index')}}">{{__('label.asset_import_cost')}}</a></li>
            @endcan
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')

          
        <div id="orderTable" data-list='{"valueNames":["_date","_order_number","_supplier_name","_bank_name","_branch_name","_lc_no","_lc_date","_bill_of_entry_no","_bill_of_entry_date","_total_qty","_total_cfr_value_usd","_total_cfr_value_bdt","_total_insurance_bdt","_total_lc_commision_bdt","_total_custom_duty_bdt","_total_other_cost_bdt","_total_asset_value_bdt","_note","created_by","updated_by","status","_lock","created_at","updated_at"],"page":10,"pagination":true}'>
                  <div class="mb-4">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search orders" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div>
                </div>
                
                <div class="col-auto">
                 @can('asset_import_cost_create')
                  <a class="btn btn-primary "
                  href="{{route('asset_import_cost.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a>
                  @endcan
                 
                </div>
              </div>
            </div>
                    
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-12 bg-white border-top border-bottom border-200 position-relative top-1">
                      <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                              
                             
                              <th class=" align-middle ps-8" scope="col"  >{{__('label.action')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="id" >{{__('label.id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_date" >{{__('label._date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_order_number" >{{__('label._order_number')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_supplier_name" >{{__('label._supplier_name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_bank_name" >{{__('label._bank_name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_branch_name" >{{__('label._branch_name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_lc_no" >{{__('label._lc_no')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_lc_date" >{{__('label._lc_date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_bill_of_entry_no" >{{__('label._bill_of_entry_no')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_bill_of_entry_date" >{{__('label._bill_of_entry_date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_qty" >{{__('label._total_qty')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_cfr_value_usd" >{{__('label._total_cfr_value_usd')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_cfr_value_bdt" >{{__('label._total_cfr_value_bdt')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_insurance_bdt" >{{__('label._total_insurance_bdt')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_lc_commision_bdt" >{{__('label._total_lc_commision_bdt')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_custom_duty_bdt" >{{__('label._total_custom_duty_bdt')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_other_cost_bdt" >{{__('label._total_other_cost_bdt')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_total_asset_value_bdt" >{{__('label._total_asset_value_bdt')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_note" >{{__('label._note')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="status" >{{__('label.status')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_lock" >{{__('label._lock')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_by" >{{__('label.created_by')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_by" >{{__('label.updated_by')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_at" >{{__('label.created_at')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_at" >{{__('label.updated_at')}}</th>
                              
                             
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
@forelse ($data as $key => $value)
<tr class="hover-actions-trigger btn-reveal-trigger position-static">
<td class=" align-middle white-space-nowrap ps-8">
  <div class="d-flex align-items-center text-90">
     @can('asset_import_cost_edit')
        <a class="mr-10"  href="{{ route('asset_import_cost.edit',$value->id) }}" title="{!! $lan_data->lang_name ?? 'English' !!}">
          <span class="fas fa-pen"></span>
        </a>
    @endcan
   
     @can('asset_import_cost_delete')         
                {!! Form::open(['method' => 'DELETE','route' => ['asset_import_cost.destroy', $value->id],'style'=>'display:inline']) !!}
                     <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                {!! Form::close() !!}
      @endcan
  </div>
  
  </td>
  
 
<td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>

<td class="_date align-middle white-space-nowrap ps-8 ">{!! _view_date_formate($value->_date ?? '') !!}</td>
<td class="_order_number align-middle white-space-nowrap ps-8 ">{!! $value->_order_number ?? '' !!}</td>
<td class="_supplier_name align-middle white-space-nowrap ps-8 ">{!! $value->_supplier_name ?? '' !!}</td>
<td class="_bank_name align-middle white-space-nowrap ps-8 ">{!! $value->_bank_name ?? '' !!}</td>
<td class="_branch_name align-middle white-space-nowrap ps-8 ">{!! $value->_branch_name ?? '' !!}</td>
<td class="_lc_no align-middle white-space-nowrap ps-8 ">{!! $value->_lc_no ?? '' !!}</td>
<td class="_lc_date align-middle white-space-nowrap ps-8 ">{!! _view_date_formate($value->_lc_date ?? '') !!}</td>
<td class="_bill_of_entry_no align-middle white-space-nowrap ps-8 ">{!! $value->_bill_of_entry_no ?? '' !!}</td>
<td class="_bill_of_entry_date align-middle white-space-nowrap ps-8 ">{!! _view_date_formate($value->_bill_of_entry_date ?? '') !!}</td>
<td class="_total_qty align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_qty ?? 0) !!}</td>
<td class="_total_cfr_value_usd align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_cfr_value_usd ?? 0) !!}</td>
<td class="_total_cfr_value_bdt align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_cfr_value_bdt ?? 0) !!}</td>
<td class="_total_insurance_bdt align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_insurance_bdt ?? 0) !!}</td>
<td class="_total_lc_commision_bdt align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_lc_commision_bdt ?? 0) !!}</td>
<td class="_total_custom_duty_bdt align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_custom_duty_bdt ?? 0) !!}</td>
<td class="_total_other_cost_bdt align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_other_cost_bdt ?? 0) !!}</td>
<td class="_total_asset_value_bdt align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->_total_asset_value_bdt ?? 0) !!}</td>
<td class="_note align-middle white-space-nowrap ps-8 ">{!! $value->_note ?? '' !!}</td>

<td class="_status align-middle white-space-nowrap text-start fw-bold text-700">
<span class="badge badge-phoenix fs--2 {{_status_base_class($value->_status)}}">
<span class="badge-label">{{ selected_status($value->_status) }}</span>
<span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
</td>
   <td class="_lock align-middle white-space-nowrap ps-8 " >
      @can('lock-permission')
      <input class=" _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="{{$value->id}}" value="{{$value->_lock}}" @if($value->_lock==1) checked @endif>
      @endcan

      
      @if($value->_lock==1)
      <i class="fa fa-lock _green ml-1 _icon_change__{{$value->id}}" aria-hidden="true"></i>
      @else
      <i class="fa fa-lock _required ml-1 _icon_change__{{$value->id}}" aria-hidden="true"></i>
      @endif
      

    </td>
    
<td class="created_by align-middle white-space-nowrap ps-8 ">{!! $value->_created_by->name ?? '' !!}</td>    
<td class="updated_by align-middle white-space-nowrap ps-8 ">{!! $value->_updated_by->name ?? '' !!}</td>    
<td class="created_at align-middle white-space-nowrap ps-8 ">{!! $value->created_at ?? '' !!}</td>    
<td class="updated_at align-middle white-space-nowrap ps-8 ">{!! $value->updated_at ?? '' !!}</td>    
</tr>
@empty
@endforelse
                          </tbody>
                        </table>
                      </div>
                     
                    </div>
                  </div>
            
          
          
          
        </div>
        </div>



@endsection

@section('script')

<script type="text/javascript">
   $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="asset_import_costs";
      if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })
</script>

@endsection