@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@php
$__user = \Auth::user();
@endphp


@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <a class="m-0 _page_name" href="{{ route('lc_manage.index') }}"> <h2>{{ isset($lc) ? 'Edit' : 'Create' }} LC Entry</h2> </a>
          </div><!-- /.col -->
          
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default new_item_using_modal" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-ship"></i> 
                </button>
               </li>
               @endcan
               @can('account-ledger-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default  new_ledger_button" attr_base_create_url="{{url('account-type-for-new-ledger')}}" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-users"></i> 
                </button>
               </li>
               @endcan
                
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('lc_manage.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<div class="container-fluid">
   
    <form class="lc_entry_form" method="POST" action="{{ isset($lc) ? route('lc_manage.update', $lc->id) : route('lc_manage.store') }}">
        @csrf
        @if(isset($lc)) @method('PUT') @endif


<div class="message-area">
    @include('backend.message.message')
    </div>
        <!-- LC Details Section -->
        <div class="card mb-3">
            <div class="card-header">LC Details</div>
            <div class="card-body">
                <div class="row">
                       @include('basic.org_create')
                     <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name"  value="lc_masters">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control _date datetimepicker-input _submit_event_prevent" data-target="#reservationdate" value="{{_view_date_formate($lc->_date ?? '')}}" />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>
                    <div class="col-md-2">
                        <label for="po_no" class="form-label">PO No</label>
                         <input type="text" id="_search_order_ref_id" name="_search_order_ref_id" class="form-control _search_order_ref_id"
                          value="{{old('_search_order_ref_id',id_wise_name($lc->po_no ?? 0,'purchase_orders','_order_number'))}}" 
                          placeholder="Purchase Order" >

                        <input type="hidden" class="form-control _order_ref_id" id="_order_ref_id" name="po_no" value="{{ old('po_no', $lc->po_no ?? '') }}">
                        
                            
                              <div class="search_box_purchase_order"></div>

                    </div>
                    <div class="col-md-2">
                        <label for="lc_ip_no" class="form-label">LC/IP No *</label>
                        <input type="text" class="form-control lc_ip_no" id="lc_ip_no" name="lc_ip_no" value="{{ old('lc_ip_no', $lc->lc_ip_no ?? '') }}" required>
                    </div>
                    

                    <div class="col-md-2">
                        <label for="lc_ip_date" class="form-label">LC/IP Date *</label>
                        <input type="date" class="form-control lc_ip_date" id="lc_ip_date" name="lc_ip_date" value="{{ old('lc_ip_date', $lc->lc_ip_date ?? '') }}" required>
                    </div>
                     <div class="col-md-2">
                    
                        <label for="expiry_date" class="form-label">{{__('label.expiry_date')}}</label>
                        <input type="date" name="expiry_date" class="form-control" value="{{old('expiry_date',$lc->expiry_date ?? '')}}">
                    
</div>
                    @if(isset($lc))
                    <div class="col-md-2">
                        <label for="amendment_date" class="form-label">Amendment Date <span class="_required">*</span></label>
                        <input type="date" class="form-control" id="amendment_date" name="amendment_date" value="{{ old('amendment_date', $lc->amendment_date ?? '') }}" required>
                    </div>
 <div class="col-md-2">
                    
                        <label for="amendment_no" class="form-label">Amendment No <span class="_required">*</span></label>
                        <input type="text" name="amendment_no" class="form-control" value="{{old('amendment_no',$lc->amendment_no ?? '')}}" required>
                    
</div>

 <div class="col-md-3 ">
     <label for="amendment_type" class="form-label">{{__('label.amendment_type')}} <span class="_required">*</span> <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label.amendment_type') !!}"
                                 _column_name="_name"
                                 attr_table_name="lc_amendment_types"
                                 attr_select_option_class=".amendment_type"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-5 mr-1">+</button></label>
     <select name="amendment_type" class="form-control">
                            @forelse($lc_amendment_types as $type)
                            <option value="{{$type->id}}" @if(old('amendment_type')==$type->id) selected @endif>{!! $type->_name ?? '' !!}</option>
                            @empty
                            @endforelse
                        </select>
                   
                     
    </div>

    <div class="col-md-4">
        <label for="reason_for_amendment" class="form-label">{{__('label.reason_for_amendment')}} <span class="_required">*</span></label>
        <input class="form-control" type="text" name="reason_for_amendment" value="{{old('reason_for_amendment')}}" placeholder="{{__('label.reason_for_amendment')}}" required>
    </div>
                    @endif
                
                    <div class="col-md-2">
                        <label for="bill_no" class="form-label">Bill No</label>
                        <input type="text" class="form-control" id="bill_no" name="bill_no" value="{{ old('bill_no', $lc->bill_no ?? '') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="pi_no" class="form-label">PI No *</label>
                        <input type="text" class="form-control pi_no" id="pi_no" name="pi_no" value="{{ old('pi_no', $lc->pi_no ?? '') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="pi_date" class="form-label">PI Date</label>
                        <input type="date" class="form-control" id="pi_date" name="pi_date" value="{{ old('pi_date', $lc->pi_date ?? '') }}">
                    </div>
               
                    <div class="col-md-2">
                        <label for="bill_of_enty_no" class="form-label">Bill of Entry No</label>
                        <input type="text" class="form-control" id="bill_of_enty_no" name="bill_of_enty_no" value="{{ old('bill_of_enty_no', $lc->bill_of_enty_no ?? '') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="bill_of_enty_date" class="form-label">Bill of Entry Date</label>
                        <input type="date" class="form-control" id="bill_of_enty_date" name="bill_of_enty_date" value="{{ old('bill_of_enty_date', $lc->bill_of_enty_date ?? '') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_of_arrival" class="form-label">Date of Arrival</label>
                        <input type="date" class="form-control" id="date_of_arrival" name="date_of_arrival" value="{{ old('date_of_arrival', $lc->date_of_arrival ?? '') }}">
                    </div>
                  @php
$transport_type = $lc->transport_type ?? old('transport_type');
$partical_shipment  = $lc->partial_shipment ?? old('partial_shipment');
$_is_posting  = $lc->_is_posting ?? '';
                   @endphp
                    <div class="col-md-2">
                        <label for="lc_type" class="form-label">LC Type</label>
                        

                        <input type="text" class="form-control" id="lc_type" name="lc_type" value="{{ old('lc_type', $lc->lc_type ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="lca_no" class="form-label">LCA No</label>
                        <input type="text" class="form-control" id="lca_no" name="lca_no" value="{{ old('lca_no', $lc->lca_no ?? '') }}">
                    </div>
                 
                    <div class="col-md-4">
                        <label for="transport_type" class="form-label">Transport Type</label>
                       
                        <select class="form-control transport_type" name="transport_type">
                            <option value="">Transport Type</option>
                            @forelse($tranport_types as $transport)
                            <option value="{{$transport->id}}" @if($transport->id==$transport_type) selected @endif >{{ $transport->_name ?? '' }}</option>
                            @empty
                            @endforelse
                        </select>

                    </div>
                </div>
                <div class="row ">
                    
                    <div class="col-md-4">
                        <label for="bank" class="form-label _required">Bank</label>
                        <input type="text" class="form-control _search_bank" id="_search_bank" name="_search_bank" value="{{ old('_search_bank', id_wise_name($lc->bank ?? 0,'account_ledgers','_name') ) }}">

                    <input type="hidden" id="bank" name="bank" class="form-control __bank_id" value="{{old('bank',$lc->bank ?? '' )}}" placeholder="bank" >
                        <div class="search_box_bank"> </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 ">
                            <div class="form-group">
                              <label class="mr-2 _required" for="_search_supplier">Supplier:</label>
                            <input type="text" id="_search_supplier" name="_search_supplier" class="form-control _search_supplier" value="{{old('_search_supplier',id_wise_name($lc->supplier ?? 0,'account_ledgers','_name'))}}" placeholder="Supplier" >

                            <input type="hidden" id="supplier" name="supplier" class="form-control __supplier_id" value="{{old('supplier',$lc->supplier ?? '' )}}" placeholder="Supplier" >
                           
                            <div class="search_box_supplier"> </div>
                            </div>
                        </div> 
                      
                        <div class="col-md-4">
                        <label for="partial_shipment" class="form-label">Partial Shipment</label>
                        <select class="form-control " name="partical_shipment">
                            <option value="1" @if(1==$partical_shipment) selected @endif>Allowed</option>
                            <option value="0" @if(0==$partical_shipment) selected @endif>Not Allowed</option>
                        </select>

                        
                    </div>

                   
                </div>
                <div class="row ">
                    <div class="col-md-4">
                        <label for="bank_branch" class="form-label">Bank Branch</label>
                        <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="{{ old('bank_branch', $lc->bank_branch ?? '') }}">
                    </div>
                     <div class="col-md-4">
                        <label for="cnf" class="form-label">CNF Agent</label>
                        <input type="text" class="form-control _search_cnf" id="_search_cnf" name="_search_cnf" value="{{ old('_search_cnf', id_wise_name($lc->cnf ?? 0,'account_ledgers','_name') ) }}">

                    <input type="hidden" id="cnf" name="cnf" class="form-control __cnf_agent_id" value="{{old('cnf',$lc->cnf ?? '')}}" placeholder="CNF Agent" >
                        <div class="search_box_cnf"> </div>
                    </div>
                     <div class="col-md-4">
                        <label for="insurance_cover_note" class="form-label">Insurance Cover Note</label>
                        <input type="text" class="form-control" id="insurance_cover_note" name="insurance_cover_note" value="{{ old('insurance_cover_note', $lc->insurance_cover_note ?? '') }}">
                    </div>
                </div>
                <div class="row ">
                   <div class="col-md-4">
                        <label for="insurance_company" class="form-label">Insurance Company</label>
                        <input type="text" class="form-control _search_insurance_company" id="_search_insurance_company" name="_search_insurance_company" value="{{ old('_search_insurance_company', id_wise_name($lc->insurance_company ?? 0,'account_ledgers','_name') ) }}">

                    <input type="hidden" id="insurance_company" name="insurance_company" class="form-control __insurance_company_id" value="{{old('insurance_company',$lc->insurance_company ?? '' )}}" placeholder="insurance_company" >
                        <div class="search_box_insurance_company"> </div>
                    </div>

                    
                    <div class="col-md-4">
                        <label for="insurance_cover_date" class="form-label">Insurance Cover Date</label>
                        <input type="date" class="form-control" id="insurance_cover_date" name="insurance_cover_date" value="{{ old('insurance_cover_date', $lc->insurance_cover_date ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="lc_tt" class="form-label">LC/TT</label>
                        <input type="text" class="form-control" id="lc_tt" name="lc_tt" value="{{ old('lc_tt', $lc->lc_tt ?? '') }}">
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-2">
                        <label for="currency" class="form-label">Currency</label>
                        <input type="text" class="form-control" id="currency" name="currency" value="{{ old('currency', $lc->currency ?? '') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="_cif_value_foreign" class="form-label">CIF Value (Foreign)</label>
                        <input type="number" step="0.01" class="form-control" id="_cif_value_foreign" name="_cif_value_foreign" value="{{ old('_cif_value_foreign', $lc->_cif_value_foreign ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label for="_cif_value_local" class="form-label">CIF Value (Local)</label>
                        <input type="number" step="0.01" class="form-control" id="_cif_value_local" name="_cif_value_local" value="{{ old('_cif_value_local', $lc->_cif_value_local ?? 0) }}">
                    </div>
               
                    <div class="col-md-2">
                        <label for="_rate_to_bdt" class="form-label">Rate to BDT</label>
                        <input type="number" step="0.01" class="form-control" id="_rate_to_bdt" name="_rate_to_bdt" value="{{ old('_rate_to_bdt', $lc->_rate_to_bdt ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label for="_local_amount" class="form-label">Local Amount</label>
                        <input type="number" step="0.01" class="form-control" id="_local_amount" name="_local_amount" value="{{ old('_local_amount', $lc->_local_amount ?? 0) }}">
                    </div>
                
                    <div class="col-md-6">
                        <label for="remark" class="form-label">Remarks</label>
                        <textarea class="form-control" id="_note" name="_note">{{ old('_note', $lc->_note ?? '') }}</textarea>
                    </div>
                    <div class="col-md-2">
                        <label for="_is_posting" class="form-label _required">Post To Voucher</label>
                        <select class="_is_posting form-control" name="_is_posting">
                            <option value="0" @if($_is_posting==0) selected @endif>NO</option>
                            <option value="1" @if($_is_posting==1) selected @endif>Yes</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="_voucher_id" class="form-label">{{__('label._voucher_id')}}</label>
                        <input type="text" class="form-control _voucher_id" id="_voucher_id" name="_voucher_id" value="{{ old('_voucher_id', $lc->_voucher_id ?? '') }}" >
                    </div>
                    <div class="col-md-2">
                        <label for="_voucher_code" class="form-label">{{__('label._voucher_code')}}</label>
                        <input type="text" class="form-control _voucher_code" id="_voucher_code" name="_voucher_code" value="{{ old('_voucher_code', $lc->_voucher_code ?? '') }}" >
                    </div>
                </div>
            </div>
        </div>


        <!-- LC Item Details Section -->
        <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left" >Code</th>
                                            <th class="text-left display_none" >Base Unit</th>
                                            <th class="text-left display_none" >Con. Qty</th>
                                            <th class="text-left " >Tran. Unit</th>
                                            <th class="text-left">Pack Size</th>
                                            <th class="text-left">Model</th>
                                            <th class="text-left " >HS code</th>
                                            <th class="text-left " >HS code 2</th>
                                            <th class="text-left " >Note</th>
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left" >{{__('label._foreign_rate')}}</th>
                                            <th class="text-left" >Rate</th>
                                            <th class="text-left" >Value</th>
                                            <th class="text-left" >Weight Avg</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
@php
$total_qty=0;
$total_value=0;
@endphp


                                            @if(isset($items))
                                            @forelse($items as $key=>$item)

@php
$total_qty   +=$item->_qty ?? 0;
$total_value  +=$item->_value ?? 0;
@endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                {{$item->id ?? ''}}
                                                  <input type="hidden" name="purchase_detail_id[]" class="form-control purchase_detail_id" value="{{$item->id}}" readonly>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code" value="{{$item->_item_code ?? '' }}">
                                                <div class="search_box_item"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{$item->_item_name ?? '' }}">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="{{$item->_item_id ?? 0}}">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>

                                               <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="{{$item->_base_unit}}" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="{{_find_unit($item->_base_unit_id)}}" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="{{$item->_unit_conversion ?? 1}}" readonly>
                                                  <input type="number" name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly value="{{$item->_base_rate ?? 0}}">
                                              </td>
                                               <td class="">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                  @forelse($item->_items->unit_conversion as $conversion_units )
                                                    <option 
                                                    value="{{$conversion_units->_conversion_unit}}" 
                                                    attr_base_unit_id="{{$conversion_units->_base_unit_id}}" 
        attr_conversion_qty="{{$conversion_units->_conversion_qty}}" 
        attr_conversion_unit="{{$conversion_units->_conversion_unit}}" 
        attr_item_id="{{$conversion_units->_item_id}}"

                                                    @if($conversion_units->_conversion_unit==$item->_transection_unit) selected @endif >{!! $conversion_units->_conversion_unit_name ?? '' !!}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input readonly type="text" name="pack_size[]" class="form-control pack_size" value="{{$item->_items->_pack_size->_name ?? ''}}" >
                                              </td>
                                              <td>
                                                <input  type="text" name="_barcode[]" class="form-control _barcode" value="{{$item->_barcode ?? ''}}" >
                                              </td>
                                              
                                              <td class="">
                                                <input type="text" name="_hs_code[]" class="form-control _hs_code 1__hs_code "  id="1__hs_code" value="{!! $item->_hs_code ?? '' !!}">

                                                <input type="hidden" name="_ref_counter[]" value="{{($key+1)}}" class="_ref_counter" id="1__ref_counter">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_hs_code_2[]" class="form-control _hs_code_2 1__hs_code_2 "  id="1__hs_code_2" value="{{$item->_hs_code_2 ?? '' }}">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_short_note[]" class="form-control _short_note 1__short_note " value="{!! $item->_short_note ?? '' !!}" >
                                              </td>
                                            
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="{{$item->_qty ?? 0}}">
                                              </td>
                                               <td>
                                                <input type="number" name="_foreign_rate[]" class="form-control _foreign_rate _common_keyup" value="{{$item->_foreign_rate ?? 0}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="{{$item->_rate ?? 0}}">
                                              </td>
                                             
                                             
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " value="{!! $item->_value ?? 0 !!}" >
                                              </td>
                                            <td>
                                                <input type="text" name="_weight_avg[]" class="form-control _weight_avg " value="{!! $item->_weight_avg ?? '' !!}" >
                                              </td>
                                             
                                              
                                            </tr>
                                            @empty
                                             @endforelse
                                        @else
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                  <input type="hidden" name="purchase_detail_id[]" class="form-control purchase_detail_id" value="0" readonly>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code">
                                                <div class="search_box_item"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>

                                               <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                                  <input type="number" name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly>
                                              </td>
                                              <td class="">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                              <td>
                                                <input readonly type="text" name="pack_size[]" class="form-control pack_size" >
                                              </td>
                                              <td>
                                                <input  type="text" name="_barcode[]" class="form-control _barcode" >
                                              </td>
                                              
                                              <td class="">
                                                <input type="text" name="_hs_code[]" class="form-control _hs_code 1__hs_code "  id="1__hs_code">

                                                <input type="hidden" name="_ref_counter[]" value="1" class="_ref_counter" id="1__ref_counter">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_hs_code_2[]" class="form-control _hs_code_2 1__hs_code_2 "  id="1__hs_code_2">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_short_note[]" class="form-control _short_note 1__short_note "  >
                                              </td>
                                            
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_foreign_rate[]" class="form-control _foreign_rate _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" >
                                              </td>
                                              
                                             
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value "  >
                                              </td>
                                            <td>
                                                <input type="text" name="_weight_avg[]" class="form-control _weight_avg "  >
                                              </td>
                                             
                                              
                                            </tr>
                                    @endif
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td ></td>
                                              <td class=""></td>
                                              <td class=""></td>
                                              <td class=""></td>
                                              <td></td>
                                              
                                             
                                              <td  class="text-right"></td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="{{$total_qty ?? 0}}" readonly required>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              
                                            
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="{{$total_value ?? 0}}" readonly required>
                                              </td>
                                              <td></td>
                                              
                                              
                                            </tr>

                                          </tfoot>
                                      </table>
                                </div>
                            </div>

                 <!--  -->

       <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">

                         

                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
                        </div>
                        <br><br>
    </form>
</div>

<!-- JS for Item Calculation -->

@endsection

@section('script')
<script>

    $(document).on('click','.submit-button',function(event){
    event.preventDefault();

    var _note = $(document).find('._note').val();
    var _master_branch_id = $(document).find('._master_branch_id').val();
    var lc_ip_no = $(document).find('.lc_ip_no').val();
    var lc_ip_date = $(document).find('.lc_ip_date').val();
    var pi_no = $(document).find('.pi_no').val();
    var _note = $(document).find('._note').val();
    var transport_type = $(document).find('.transport_type').val();

    if(_master_branch_id  ==""){
       alert(" Please Select Branch  ");
        $(document).find('._master_branch_id').addClass('required_border').focus();
        return false;
    }
    if(transport_type  ==""){
       alert(" Please Select Transport Type  ");
        $(document).find('.transport_type').addClass('required_border').focus();
        return false;
    }

    if(lc_ip_no   ==""){
       alert(" Please Input LC/IP No  ");
        $(document).find('.lc_ip_no').addClass('required_border').focus();
        return false;
    }
    if(lc_ip_date   ==""){
       alert(" Please Input LC/IP Date  ");
        $(document).find('.lc_ip_date').addClass('required_border').focus();
        return false;
    }
    if(pi_no   ==""){
       alert(" Please Input PI NO  ");
        $(document).find('.pi_no').addClass('required_border').focus();
        return false;
    }
    if(_note   ==""){
       alert(" Please Input Remarks ");
        $(document).find('._note').addClass('required_border').focus();
        return false;
    }


 if(_note !="" && _master_branch_id !='' &&  lc_ip_no !='' && lc_ip_date !='' && pi_no !=''){
       
       $('.submit-button').attr('disabled','true');
      $(document).find('.lc_entry_form').submit();
    }

     
    
  })


   function purchase_row_add(event){
   event.preventDefault();
      

       _item_row_count= $(document).find("._item_row_count").val();
      $(document).find("._item_row_count").val((parseFloat(_item_row_count)+1));
     var  _item_row_count = (parseFloat(_item_row_count)+1);
     $(document).find("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                              <input type="hidden" name="purchase_detail_id[]" class="form-control purchase_detail_id" value="0" />
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code">
                                                <div class="search_box_item"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                                  <input type="number" name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly>
                                              </td>
                                              <td class="">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                              <td>
                                                <input readonly type="text" name="pack_size[]" class="form-control pack_size" >
                                              </td>
                                               <td>
                                                <input  type="text" name="_barcode[]" class="form-control _barcode" value=""  >
                                              </td>
                                             
                                             <td class="">
                                                <input type="text" name="_hs_code[]" class="form-control _hs_code ${_item_row_count}__hs_code "  id="${_item_row_count}__hs_code">

                                                <input type="hidden" name="_ref_counter[]" value="${_item_row_count}"  class="_ref_counter" id="${_item_row_count}__ref_counter">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_hs_code_2[]" class="form-control _hs_code_2 ${_item_row_count}__hs_code_2 "  id="${_item_row_count}__hs_code_2">

                                              </td>
                                              <td>
                                                <input type="text" name="_short_note[]" class="form-control _short_note ${_item_row_count}__short_note " id="${_item_row_count}__short_note" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                                 <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                              </td>
                                               <td>
                                                <input type="number" name="_foreign_rate[]" class="form-control _foreign_rate _common_keyup" value="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" >
                                               
                                              </td>
                                              

                                              
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " value="0" >
                                              </td>
                                              <td>
                                                <input type="text" name="_weight_avg[]" class="form-control _weight_avg "  >
                                              </td>
                                              
                                           
                                             
                                              
                                              
                                            </tr>`);
     
      

}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
        
        $(this).parent().parent('tr').find('._ref_counter').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
           $(this).parent().parent('tr').find('._ref_counter').remove();
        } 
      }
      _purchase_total_calculation();
  })




  $(document).on('keyup','._value',function(){
    console.log($(this).val())
    var _qty = $(this).closest('tr').find('._qty').val();
 //   console.log()
    var _value = $(this).closest("tr").find("._value").val();
    if(isNaN(_value)){_value = 0}
    if(isNaN(_qty)){_qty = 1}
    var _rate = parseFloat(parseFloat(_value)/parseFloat(_qty));
    if(isNaN(_rate)){_rate = 0}
    $(this).closest("tr").find("._rate").val(_rate);
    _purchase_total_calculation();

  });

  $(document).on('keyup','._common_keyup',function(event){
  event.preventDefault();
  var __this = $(this);
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._rate').val());
  var conversion_qty = parseFloat($(this).closest('tr').find('.conversion_qty').val());

  var _base_rate =(_rate/conversion_qty);
  console.log(_base_rate + " _base_rate")
  console.log(conversion_qty + " conversion_qty")
   __this.closest('tr').find('._base_rate').val(_base_rate);

   // if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }

  $(this).closest('tr').find('._value').val((_qty*_rate));
    _purchase_total_calculation();
})




  function _purchase_total_calculation(){
  console.log('calculation here')
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount_amount = 0;
      $(document).find("._value").each(function() {
            var _s_value =parseFloat($(this).val());
            if(isNaN(_s_value)){_s_value = 0}
          _total__value +=parseFloat(_s_value);
      });
      $(document).find("._qty").each(function() {
            var _s_qty =parseFloat($(this).val());
            if(isNaN(_s_qty)){_s_qty = 0}
          _total_qty +=parseFloat(_s_qty);
      });
     
      $(document).find("._total_qty_amount").val(_total_qty);
      $(document).find("._total_value_amount").val(_total__value);

      var _discount_input = parseFloat($(document).find("#_purchase_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }
      var _total_discount = parseFloat(_discount_input)+parseFloat(_total_discount_amount);
      $(document).find("#_purchase_sub_total").val(_math_round(_total__value));
      var _total = _math_round((parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_total_discount));
      $(document).find("#_purchase_total").val(_total);
  }


 $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    purchase_item_search(_gloabal_this,_text_val);

}, 500));

  $(document).on('keyup','._search_item_code',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    purchase_item_search(_gloabal_this,_text_val);

}, 500));

function purchase_item_search(_gloabal_this,_text_val){
    var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 500px;">
            <thead>
              <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Item</th>
                <th>Pack Size</th>
                <th>Unit</th>
                <th>Manufacture</th>
              </tr>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]?. _manufacture_company;
                          var _balance = data[i]?._balance
                         search_html += `<tr class="search_row_item" >

                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td>
                                         <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_item_code" class="_item_code" value="${data[i]._code}">
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_hs_code" class="_item_hs_code" value="${data[i]?._hs_code}">
                                  <input type="hidden" name="_item_hs_code_2" class="_item_hs_code_2" value="${data[i]?._hs_code_2}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                   <input type="hidden" name="_item_pack_size" class="_item_pack_size" value="${data[i]?._pack_size?._name}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                    <td>${data[i]?._pack_size?._name}</td>
                                   <td>${_balance} ${data[i]._units?._name}</td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="4"><button type="button" class="btn btn-sm btn-default new_item_using_modal" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   New Item
                </button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}



$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).find('._unique_barcode').val());

  var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();
  var _item_code = $(this).children('td').find('._item_code').val();

  var _item_pack_size = $(this).children('td').find('._item_pack_size').val();
  var _item_hs_code = $(this).children('td').find('._item_hs_code').val();
  var _item_hs_code_2 = $(this).children('td').find('._item_hs_code_2').val();

  if(_item_hs_code =='null' || _item_hs_code =='undefined'){
    _item_hs_code = '';
  }
  if(_item_hs_code_2 =='null' || _item_hs_code_2 =='undefined'){
    _item_hs_code_2 = '';
  }




 var _item_row_count = _ref_counter;
  // if(_unique_barcode ==1){
  //   _new_barcode_function(_item_row_count);
  // }
  
  if(isNaN(_item_vat)){ _item_vat=0 }
  _vat_amount = ((_item_rate*_item_vat)/100);

var self = $(this);

    var request = $.ajax({
      url: "{{url('item-wise-units')}}",
      method: "GET",
      data: { item_id:_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      self.parent().parent().parent().parent().parent().parent().find('._transection_unit').html("")
      self.parent().parent().parent().parent().parent().parent().find("._transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_code').val(_item_code);
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').val(_item_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_item_rate);
  
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_item_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_item_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat_amount').val(_vat_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
  // if(_unique_barcode ==1){
  //   $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(0);
  //   $(this).parent().parent().parent().parent().parent().parent().find('._qty').attr('readonly',true);
  // }
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_item_rate);
 var _ref_counter = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').attr('name',_ref_counter+'__barcode__'+_id);
  var _item_row_count = _ref_counter;
  // if(_unique_barcode ==1){
  //   _new_barcode_function(_item_row_count);
  // }
  $(this).parent().parent().parent().parent().parent().parent().find('._base_rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);
    $(this).parent().parent().parent().parent().parent().parent().find('.pack_size').val(_item_pack_size);
    $(this).parent().parent().parent().parent().parent().parent().find('._hs_code').val(_item_hs_code);
    $(this).parent().parent().parent().parent().parent().parent().find('._hs_code_2').val(_item_hs_code_2);

  _purchase_total_calculation();
  $(document).find('.search_box_item').hide();
  $(document).find('.search_box_item').removeClass('search_box_show').hide();
  
})

$(document).on('change','._transection_unit',function(){
  var __this = $(this);
  var conversion_qty = $('option:selected', this).attr('attr_conversion_qty');
 
  $(this).closest('tr').find(".conversion_qty").val(conversion_qty);

  converted_qty_value(__this);
})

function converted_qty_value(__this){

  var _vat_amount =0;
  var _qty = __this.closest('tr').find('._qty').val();
  var _rate = __this.closest('tr').find('._rate').val();
  var _base_rate = __this.closest('tr').find('._base_rate').val();
  var conversion_qty = parseFloat(__this.closest('tr').find('.conversion_qty').val());




   if(isNaN(_item_vat)){ _item_vat   = 0 }

  if(isNaN(conversion_qty)){ conversion_qty   = 1 }
  var converted_price_rate = (( conversion_qty/1)*_base_rate);

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_base_rate)){ _base_rate =0 }

  if(converted_price_rate ==0){
    converted_price_rate = _rate;
  }

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }


   var _value = parseFloat(converted_price_rate*_qty).toFixed(2);
 __this.closest('tr').find('._rate').val(converted_price_rate);
 __this.closest('tr').find('._value').val(_value);
    _purchase_total_calculation();


}





$(document).on('keyup','._search_order_ref_id',delay(function(e){
    $(document).find('._search_order_ref_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _branch_id = $(document).find('._master_branch_id').val();
    var _delivery_statuses = `<?php echo json_encode(_delivery_status()); ?>`;
    _delivery_statuses_array= JSON.parse(_delivery_statuses);
    console.log(_delivery_statuses_array[1])

  var request = $.ajax({
      url: "{{url('purchase-pre-order-search')}}",
      method: "GET",
      data: { _text_val,_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
       console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table table-bordered style="width: 100%;">
                            <thead>
                              <th style="border:1px solid #ccc;text-align:center;">ID</th>
                              <th style="border:1px solid #ccc;text-align:center;">Order Number</th>
                              <th style="border:1px solid #ccc;text-align:center;">Date</th>
                              <th style="border:1px solid #ccc;text-align:center;">Supplier</th>
                              <th style="border:1px solid #ccc;text-align:center;">Delivery Status</th>
                              <th style="border:1px solid #ccc;text-align:center;">Amount</th>
                            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var _delivery_status = data[i]?._delivery_status;
                          var row_color="";
                          if(_delivery_status==1){
                            row_color="Green";
                          }
                          if(_delivery_status==4){
                            row_color="Red";
                          }

                         search_html += `<tr class="search_row_purchase_order" style="color:${row_color}">
                                        <td style="border:1px solid #ccc;">${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i]._ledger_id}">
                                        <input type="hidden" name="_purchase_main_id" class="_purchase_main_id" value="${data[i].id}">
                                        <input type="hidden" name="_purchase_main_date" class="_purchase_main_date" value="${(data[i]?._date)}">
                                        </td>
                                         <td style="border:1px solid #ccc;">${data[i]?._order_number}</td>
                                         <td style="border:1px solid #ccc;">${(data[i]._date)}</td>
                                        <td style="border:1px solid #ccc;">${data[i]._ledger._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._ledger._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_main_order_number" class="_main_order_number" value="${data[i]?._order_number}">
                                        
                                        <input type="hidden" name="_date_main_ledger" class="_date_main_ledger" value="${(data[i]._date)}"></td>
                                        <td style="border:1px solid #ccc;">${_delivery_statuses_array[_delivery_status]}</td>
                                        <td style="border:1px solid #ccc;">${data[i]?._total}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_purchase_order').html(search_html);
      _gloabal_this.parent('div').find('.search_box_purchase_order').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));

$(document).on("click",'.search_row_purchase_order',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _purchase_main_id = $(this).find('._purchase_main_id').val();
    var _purchase_main_date = $(this).find('._purchase_main_date').val();
    var _main_branch_id = $(this).find('._main_branch_id').val();
    var _date_main_ledger = $(this).find('._date_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _main_order_number = $(this).find('._main_order_number').val();

    $(document).find("._search_order_ref_id").val(_main_order_number)


    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
   
    if(_address_main_ledger =='null' ){ _address_main_ledger =""; } 
    if(_phone_main_ledger =='null' ){ _phone_main_ledger =""; } 

    $(document).find(".__supplier_id").val(_id);
    $(document).find("._search_supplier").val(_name);
    $(document).find("._order_ref_id").val(_purchase_main_id);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);



    

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $(document).find('meta[name="csrf-token"]').attr('content') } });

    var request = $.ajax({
      url: "{{url('purchase-pre-order-details')}}",
      method: "POST",
      data: { _purchase_main_id,_main_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {
     
      var data = result;
      console.log(data)
      var _purchase_row_single = ``;
      $(document).find("#area__purchase_details").empty();
     
if(data.length > 0 ){
  $(document).find('._purchase_row').remove();
  $(document).find("._item_row_count").val(0)
  for (var i = 0; i < data.length; i++) {
   var _item_row_count = (parseFloat(i)+1);
    var _item_name = (data[i]._items._name) ? data[i]._items._name : '' ;
    var _unique_barcode = (data[i]._items._unique_barcode) ? data[i]._items._unique_barcode : '' ;
    var _item_id = (data[i]._item_id) ? data[i]._item_id : '' ;
    var _qty   = (data[i]._qty  ) ? data[i]._qty   : 0 ;
    var _rate    = (data[i]._rate) ? data[i]._rate    : 0 ;
    var _base_rate    = (data[i]._base_rate) ? data[i]._base_rate    : 0 ;
    var _sales_rate =  data[i]?._items?._sale_rate ;
    var _barcode =  data[i]?._items?._barcode ;
    var _code =  data[i]?._items?._code ;
    var _hs_code =  data[i]?._items?._hs_code ;
    var _hs_code_2 =  data[i]?._items?._hs_code_2 ;
    var _value = ( (data[i]._qty*data[i]._rate) ) ? (data[i]._qty*data[i]._rate) : 0 ;
    var _main_unit_id= data[i]._transection_unit;
    var _unit_name = data[i]._items._units._name;
    var pack_size_name = data[i]._items._pack_size._name;
    var conversion_qty = data[i]?._unit_conversion;

    $(document).find("._item_row_count").val(_item_row_count)
   

      $(document).find("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                              <input type="hidden" name="purchase_detail_id[]" class="form-control purchase_detail_id" value="0" />
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code" value="${_code}">
                                                <div class="search_box_item"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="${_item_name}">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="${_item_id}">
                                                <div class="search_box_item">
                                                  
                                                </div>

                                              </td>
                                              <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="${conversion_qty}" readonly>
                                              </td>
                                              <td class="">
                                                <select class="form-control ${_item_row_count}_transection_unit _transection_unit _transection_unit____${i}" name="_transection_unit[]">
                                                <option value="${_main_unit_id}">${_unit_name}</option>
                                                </select>
                                              </td>
                                               <td>
                                                <input readonly type="text" name="pack_size[]" class="form-control pack_size" value="${pack_size_name}" >
                                              </td>
                                               <td>
                                                <input  type="text" name="_barcode[]" class="form-control _barcode" value="${_barcode}" >
                                              </td>
                                              <td>
                                                <input type="text" name="${_item_row_count}_hs_code__${_item_id}" class="form-control _hs_code ${_item_row_count}__hs_code " id="${_item_row_count}__hs_code" value="${_hs_code}" >
                                              </td>
                                            <td class="">
                                                <input type="text" name="_hs_code_2[]" class="form-control _hs_code_2 ${_item_row_count}__hs_code_2 " value="${_hs_code_2}" id="${_item_row_count}__hs_code_2">

                                              </td>
                                              <td>
                                                <input type="text" name="_short_note[]" class="form-control _short_note ${_item_row_count}__short_note "  >
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="${_qty}">
                                                <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="${_rate}">
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="${_base_rate}" >
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value "  value="${_value}">
                                              </td>
                                              <td>
                                                <input type="text" name="_weight_avg[]" class="form-control _weight_avg ">
                                              </td>
                                              
                                            </tr>`);

item_wise_unitConversionDetail(_item_id,_item_row_count);


$(document).find("._transection_unit____"+i).val(_main_unit_id);


                                           
                                            
                                          }

                                        }else{
                                          _purchase_row_single += `Returnable Item Not Found !`;
                                        }

            
            
              _purchase_total_calculation();
    })



  })



 // var single_row =  `<tr class="_voucher_row">
 //                      <td><a  href="" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
 //                      <td></td>
 //                      <td><input type="text" name="_search_ledger_id[]" @if($__user->_ac_type==1) attr_account_head_no="1" @endif  class="form-control _search_ledger_id width_280_px" placeholder="Ledger"   >
 //                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
 //                      <div class="search_box">
 //                      </div>
 //                      </td>
 //                       @if(sizeof($permited_branch)>1)
 //                      <td>
 //                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
 //                        @forelse($permited_branch as $branch )
 //                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
 //                        @empty
 //                        @endforelse
 //                        </select>
 //                        </td>
 //                        @else
 //                          <td class="display_none">
 //                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
 //                        @forelse($permited_branch as $branch )
 //                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
 //                        @empty
 //                        @endforelse
 //                        </select>
 //                        </td>
 //                        @endif

 //                         @if(sizeof($permited_costcenters)>1)
 //                        <td>
 //                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
 //                            @forelse($permited_costcenters as $costcenter )
 //                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
 //                            @empty
 //                            @endforelse
 //                            </select>
 //                            </td>
 //                        @else
 //                        <td class="display_none">
 //                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
 //                            @forelse($permited_costcenters as $costcenter )
 //                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
 //                            @empty
 //                            @endforelse
 //                            </select>
 //                            </td>
 //                        @endif
 //                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
 //                            <td>
 //                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
 //                            </td>
 //                            <td class=" @if($__user->_ac_type==1) display_none @endif ">
 //                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
 //                              </td>
 //                            </tr>`;

 //  function voucher_row_add(event) {
 //      event.preventDefault();
 //      $("#area__voucher_details").append(single_row);
 //  }


</script>
@endsection
