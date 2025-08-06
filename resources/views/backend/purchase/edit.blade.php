@extends('backend.layouts.app')
@section('title',$page_name)

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
           <a class="m-0 _page_name" href="{{ route('purchase.index') }}">{!! $page_name ?? '' !!} </a>
           
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">

               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <a target="__blank" href="{{url('purchase/print')}}/{{$data->id}}" class="btn btn-sm btn-warning"> <i class="nav-icon fas fa-print"></i> </a>
                  
                
               </li>
               @endcan
               @include('backend.common-modal.item_ledger_sub_link')
                @can('purchase-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default purchase_modal_form" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('purchase.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                 
                   @include('backend.message.message')


                   @php

 $_show_model = $form_settings->_show_model ?? 0;
                   @endphp
                    
              </div>
             
              <div class="card-body">
               <form action="{{url('purchase/update')}}" method="POST" class="purchase_form" >
                @csrf
                      <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-3">
                        <input type="hidden" name="_form_name" class="_form_name"  value="purchases">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_date)}}"  />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <input  type="hidden" name="add_or_edit" class="add_or_edit" value="1">
                              <input  type="hidden" name="_purchase_id" value="{{$data->id}}">
                              <input type="hidden" id="_search_form_value" name="_search_form_value" class="_search_form_value" value="1" >
                        </div>

                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Invoice No:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number',$data->_order_number)}}" placeholder="Invoice No" readonly>
                                
                            </div>
                        </div>
                        @include('basic.org_edit')
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Purchase Order:</label>
                              <input type="text" id="_search_order_ref_id" name="_search_order_ref_id" class="form-control _search_order_ref_id" value="{{old('_order_ref_id',$data->_purchase_order_display->_order_number ?? '' )}}" placeholder="Purchase Order" >
                              <input type="hidden" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id)}}" placeholder="Purchase Order" >
                              <div class="search_box_purchase_order"></div>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="delivery_status">Delivery Status:</label>
                              <select class="form-control" name="_delivery_status">
                                @forelse(_delivery_status() as $key=>$d_val)
                                  <option value="{{$key}}" @if($data->_delivery_status==$key) selected @endif >{{$d_val ?? ''}}</option>
                                @empty
                                @endforelse
                              </select>
                             
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_is_posting">{{__('label._is_posting')}}:</label>
                              <select class="form-control" name="_is_posting">
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                              </select>
                                
                            </div>
                        </div>
                      </div>
                      <div class="row">
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Supplier:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->_ledger->_name ?? '' )}}" placeholder="Supplier" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Supplier" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone',$data->_phone)}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address',$data->_address)}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance',$data->_referance)}}" placeholder="Referance" >
                                
                            </div>
                        </div>
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >CODE</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left display_none" >Base Unit</th>
                                            <th class="text-left display_none" >Con. Qty</th>
                                            <th class="text-left @if(isset($form_settings->_show_unit)) @if($form_settings->_show_unit==0) display_none    @endif @endif" >Tran. Unit</th>
                                            <th class="text-left">Pack Size</th>

                                           @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                            <th class="text-left" >Barcode</th>
                                            @else
                                            <th class="text-left display_none" >Barcode</th>
                                            @endif
                                            @endif
                                            <th class="text-left @if($_show_model==0) display_none    @endif " >Model</th>
                                            <th class="text-left @if(isset($form_settings->_show_short_note)) @if($form_settings->_show_short_note==0) display_none    @endif @endif" >Note</th>
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left" >Rate</th>
                                            <th class="text-left" >Sales Rate</th>

                                            <th class="text-left @if($form_settings->_inline_discount == 0) display_none @endif " >Dis%</th>
                                            <th class="text-left @if($form_settings->_inline_discount == 0) display_none @endif " >Discount</th>


                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <th class="text-left" >VAT%</th>
                                            <th class="text-left" >VAT</th>
                                             @else
                                            <th class="text-left display_none" >VAT%</th>
                                            <th class="text-left display_none" >VAT Amount</th>
                                            @endif
                                            @endif

                                            <th class="text-left" >Value</th>
                                             @if(sizeof($permited_branch) > 1)
                                            <th class="text-left" >Branch</th>
                                            @else
                                            <th class="text-left display_none" >Branch</th>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <th class="text-left" >Cost Center</th>
                                            @else
                                             <th class="text-left display_none" >Cost Center</th>
                                            @endif
                                             @if(sizeof($store_houses) > 1)
                                            <th class="text-left" >Store</th>
                                            @else
                                             <th class="text-left display_none" >Store</th>
                                            @endif
                                            @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                            <th class="text-left" >Shelf</th>
                                            @else
                                             <th class="text-left display_none" >Shelf</th>
                                            @endif
                                            @endif
                                            <th class="text-left @if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none @endif
                                            @endif" >Manu. Date</th>
                                             <th class="text-left @if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none @endif
                                            @endif"> Expired Date </th>
                                           
                                          </thead>
                                          @php
                                          $_total_qty_amount = 0;
                                          $_total_vat_amount =0;
                                          $_total_value_amount =0;
                                          $_total_discount_amount=0;
                                          $__master_details = $data->_master_details;
                                          @endphp
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @if(sizeof($__master_details) > 0)
                                            @forelse($data->_master_details as $m_key=> $detail)
                                             @php
                                              $_total_qty_amount += $detail->_qty ??  0;
                                              $_total_vat_amount += $detail->_vat_amount ??  0;
                                              $_total_value_amount += $detail->_value ??  0;
                                              $_total_discount_amount=$detail->_discount_amount ??  0;
                                              @endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                {{ $detail->id }}
                                                <input type="hidden" name="purchase_detail_id[]" value="{{ $detail->id }}" class="form-control purchase_detail_id" >
                                                
                                              </td>
                                               <td>
                                                <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code" value="{{$detail->_items->_code ?? ''}}">
                                                <div class="search_box_item"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{$detail->_items->_name ?? '' }}">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="{{$detail->_item_id}}">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="{!! $detail->_base_unit !!}" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="{!! $detail->_items->_units->_name ?? '' !!}" />
                                              </td>
                                              @php
$_unit_conversion = $detail->_unit_conversion ?? 1;
if($_unit_conversion==0){
  $_unit_conversion=1;
} 
                                              @endphp
                                              <td class="display_none">
                                                <input type="text" name="conversion_qty[]"  class="form-control conversion_qty " value="{!! $detail->_unit_conversion ?? 1 !!}" readonly>
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="{!! $detail->_items->_pur_rate ?? 0 !!}" >
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                  @forelse($detail->_items->unit_conversion as $conversion_units )
                                                    <option 
                                                    value="{{$conversion_units->_conversion_unit}}" 
                                                    attr_base_unit_id="{{$conversion_units->_base_unit_id}}" 
        attr_conversion_qty="{{$conversion_units->_conversion_qty}}" 
        attr_conversion_unit="{{$conversion_units->_conversion_unit}}" 
        attr_item_id="{{$conversion_units->_item_id}}"

                                                    @if($conversion_units->_conversion_unit==$detail->_transection_unit) selected @endif >{!! $conversion_units->_conversion_unit_name ?? '' !!}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input readonly type="text" name="pack_size[]" class="form-control pack_size" value="{{$detail->_items->_pack_size->_name ?? ''}}" >
                                              </td>

                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td>
                                                <input type="text" name="{{($m_key+1)}}__barcode__{{$detail->_item_id}}" class="form-control _barcode {{($m_key+1)}}__barcode"  value="{{$detail->_barcode ?? '' }} " id="{{($m_key+1)}}__barcode" >
                                               

                                                <input type="hidden" name="_ref_counter[]" value="{{($m_key+1)}}" class="_ref_counter" id="{{($m_key+1)}}__ref_counter">
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="{{($m_key+1)}}__barcode__{{$detail->_item_id}}" class="form-control _barcode {{($m_key+1)}}__barcode"  value="{{$detail->_barcode ?? '' }} " id="{{($m_key+1)}}__barcode" >
                                               

                                                <input type="hidden" name="_ref_counter[]" value="{{($m_key+1)}}" class="_ref_counter" id="{{($m_key+1)}}__ref_counter">


                                              </td>
                                              @endif
                                            @endif

                                             <td class="@if($_show_model==0) display_none   @endif">
                                                <input type="text" name="_model[]" class="form-control _model {{($m_key+1)}}__model "  value="{{$detail->_model ?? '' }}">
                                              </td>

                                             <td class="@if(isset($form_settings->_show_short_note)) @if($form_settings->_show_short_note==0) display_none   @endif @endif">
                                                <input type="text" name="_short_note[]" class="form-control _short_note {{($m_key+1)}}__short_note "  value="{{$detail->_short_note ?? '' }}">
                                              </td>

                                              <td>
                                                 @if($detail->_items->_unique_barcode==1)
 <script type="text/javascript">
  $('#<?php echo ($m_key+1);?>__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
                                            </script>
                                            @endif
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup"  value="{{$detail->_qty ?? 0 }}" @if($detail->_items->_unique_barcode==1) readonly @endif >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="{{$detail->_rate ?? 0 }}" >
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="{{$detail->_base_rate ?? 0 }}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate " value="{{$detail->_sales_rate ?? 0 }}" >
                                              </td>

                                               <td class="@if($form_settings->_inline_discount == 0) display_none @endif">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" value="{{$detail->_discount}}">
                                              </td>
                                              <td class="@if($form_settings->_inline_discount == 0) display_none @endif">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount  " value="{{$detail->_discount_amount}}">
                                              </td>
                                              @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td>
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" value="{{$detail->_vat ?? 0 }}">
                                              </td>
                                              <td>
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" value="{{$detail->_vat_amount ?? 0 }}">
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" value="{{$detail->_vat ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" value="{{$detail->_vat_amount ?? 0 }}" >
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly value="{{ $detail->_value ?? 0 }}" >
                                              </td>
                                            @if(sizeof($permited_branch) > 1)  
                                              <td>
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                                <td>
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif > {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td>
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}"  @if(isset($detail->_store_id)) @if($detail->_store_id == $store->id) selected @endif   @endif >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}"   @if(isset($detail->_store_id)) @if($detail->_store_id == $store->id) selected @endif   @endif  >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              @endif
                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td>
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="{{$detail->_store_salves_id ?? '' }}">
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="{{$detail->_store_salves_id ?? '' }}" >
                                              </td>
                                              @endif
                                              @endif

                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date "  value="{{$detail->_manufacture_date ?? '' }}">
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " value="{{$detail->_expire_date ?? '' }}" >
                                              </td>
                                              
                                            </tr>
                                           
                                            @empty
                                            @endforelse
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
                                              <td class="display_none"></td>
                                              <td class="display_none"></td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif"></td>
                                              <td></td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right display_none"></td>
                                             @endif
                                            @endif

                                            @if(isset($form_settings->_show_short_note)) @if($form_settings->_show_short_note==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right display_none"></td>
                                             @endif
                                            @endif
                                                <td  class="text-right @if($_show_model==0)  display_none @endif"></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="{{$_total_qty_amount}}" readonly required>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              <td class="@if($form_settings->_inline_discount == 0) display_none @endif"></td>
                                              <td class="@if($form_settings->_inline_discount == 0) display_none @endif">
                                                <input type="number" min="0"  step="any" min="0" name="_total_discount_amount" class="form-control _total_discount_amount"  readonly required value="{{$_total_discount_amount ?? 0}}">
                                              </td>
                                              @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="{{$_total_vat_amount ?? 0}}" readonly required>
                                              </td>
                                              @else
                                              <td class="display_none"></td>
                                              <td class="display_none">
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="{{$_total_vat_amount ?? 0}}" readonly required>
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="{{$_total_value_amount ?? 0}}" readonly required>



                                              </td>
                                              @if(sizeof($permited_branch) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif

                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td></td>
                                              @else
                                              @endif
                                              <td class="display_none"></td>
                                              @endif
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif  @endif"></td>

                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif  @endif"></td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                          @if($__user->_ac_type==1)
                      @include('backend.purchase.edit_ac_cb')
                         
                      @else
                       @include('backend.purchase.edit_ac_detail')
                      @endif
                          

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;">
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_note">Note</label></td>
                              <td style="width: 70%;border:0px;">
                                @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('purchase/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '' )}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_sub_total">Sub Total</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_purchase_sub_total" readonly value="{{ _php_round($data->_sub_total ?? 0) }}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_discount_input" class="form-control width_200_px" id="_purchase_discount_input" value="{{$data->_discount_input ?? 0}}" >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total_discount">Total Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_discount" class="form-control width_200_px" id="_purchase_total_discount" readonly value="{{$data->_total_discount ?? 0}}">
                              </td>
                            </tr>
                            @if(isset($form_settings->_show_vat)) 
                            @if($form_settings->_show_vat==1)
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total_vat">Total VAT</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_vat" class="form-control width_200_px" id="_purchase_total_vat" readonly value="{{$data->_total_vat ?? 0}}">
                              </td>
                            </tr>
                            @else
                            <tr class="display_none">
                              <td style="width: 10%;border:0px;"><label for="_total_vat">Total VAT</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_vat" class="form-control width_200_px" id="_purchase_total_vat" readonly value="{{$data->_total_vat ?? 0}}">
                              </td>
                            </tr>
                            @endif
                            @endif
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total">NET Total </label></td>
                              <td style="width: 70%;border:0px;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="{{ _php_round($data->_total ?? 0)}}">
                          <input type="hidden" name="_item_row_count" value="{{sizeof($__master_details)}}" class="_item_row_count">
                              </td>
                            </tr>
                             @include('backend.message.send_sms')
                          </table>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-12 " style="height: 50px;">
                         </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                          @if($sales_number > 0 )
                          <p class="text-center _required">This invoice Item already sold. Please don't Change any item information.
                            </p>
                            <p>
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button></p>
                          @else
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
                          @endif
                            
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ url('purchase-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Purchase Form Settings</h5>
        <button type="button" class="close exampleModalClose"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body purchase_settings_modal">
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary exampleModalClose" >Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
       </form>
    </div>
  </div>



</div>
@include('backend.common-modal.item_ledger_modal')

@endsection

@section('script')

@include('backend.purchase.purchase_script')

@endsection

