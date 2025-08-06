@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <a class="m-0 _page_name" href="{{ route('material-issue-return.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-ship"></i> 
                </button>
               </li>
               @endcan
               @can('account-ledger-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-users"></i> 
                </button>
               </li>
               @endcan
                @can('material-issue-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('material-issue-return.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
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
                    <div class="alert _required ">
                      <span class="_over_qty"></span> 
                    </div>

                    
              </div>
        @php
    $_show_delivery_man = $form_settings->_show_delivery_man ?? 0;
    $_show_sales_man = $form_settings->_show_sales_man ?? 0;
    $_show_barcode = $form_settings->_show_barcode ?? 0;
    $_show_cost_rate =  $form_settings->_show_cost_rate ?? 0;
    $_show_payment_terms =  $form_settings->_show_payment_terms ?? 0;
    $_show_vat =  $form_settings->_show_vat ?? 0;
    $_inline_discount = $form_settings->_inline_discount ?? 0;
    $_show_self = $form_settings->_show_self ?? 0;
    $_show_warranty = $form_settings->_show_warranty ?? 0;
    $_defaut_customer = $form_settings->_defaut_customer ?? 0;
    $_show_unit = $form_settings->_show_unit ?? 0;
    $_show_manufacture_date = $form_settings->_show_manufacture_date ?? 0;
    $_show_expire_date = $form_settings->_show_expire_date ?? 0;

    $_show_branch = $form_settings->_show_branch ?? 0;
    $_show_cost_center = $form_settings->_show_cost_center ?? 0;
    $_show_store = $form_settings->_show_store ?? 0;

    @endphp
              <div class="card-body">
               <form action="{{route('material-issue-return.store')}}" method="POST" class="purchase_form" >
                @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name" value="material_issue_return">
                            <div class="form-group">
                                <label>{{__('label._date')}}:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" name="_sales_return_id" class="_sales_return_id" value="">
                              <input type="hidden" id="_search_form_value" name="_search_form_value" class="_search_form_value" value="2" >
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">{{__('label.issue_number')}}:<span class="_required">*</span></label>
                              <input type="text" id="_search_order_ref_id" name="_search_order_ref_id" class="form-control _search_order_ref_id" value="{{old('_order_ref_id')}}" placeholder="{{__('label.issue_number')}}" >
                              <input type="hidden" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id')}}" placeholder="{{__('label.issue_number')}}" >
                              <div class="search_box_purchase_order"></div>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                         <div class="form-group ">
                             <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
                            <select class="form-control _master_organization_id" name="organization_id" required >

                               <option value="" disabled>{{__('label.select_organization')}}</option>
                               @forelse($permited_organizations as $val )
                               <option value="{{$val->id}}" disabled>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                         <div class="form-group ">
                             <label>Branch:<span class="_required">*</span></label>
                            <select class="form-control _master_branch_id" name="_branch_id" required >
                               <option value="" disabled>{{__('label.select_branch')}}</option>
                               @forelse($permited_branch as $branch )
                               <option value="{{$branch->id}}" disabled >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                             <input type="hidden" name="_branch_id" class="_assign_branch_id">
                             <input type="hidden" name="_cost_center_id" class="_assign_cost_center_id">
                             <input type="hidden" name="organization_id" class="_assign_organization_id">
                         </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                         <div class="form-group ">
                             <label>{{__('label.Cost center')}}:<span class="_required">*</span></label>
                            <select class="form-control _cost_center_id" name="_cost_center_id" required >
                               <option value="" disabled>{{__('label.select_cost_center')}}</option>
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" disabled>{{ $cost_center->_code ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                        
                        
                        
                        @if($_show_delivery_man ==1)
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_delivery_man">Delivery Man:</label>
                              <input type="text" id="_search_main_delivery_man" name="_search_main_delivery_man" class="form-control _search_main_delivery_man" 
                               placeholder="Delivery Man" readonly >

                            <input type="hidden" id="_delivery_man" name="_delivery_man_id" class="form-control _delivery_man"  placeholder="Delivery Man" >
                            <div class="search_box_delivery_man"> </div>
                            </div>
                        </div>
                        @endif
                         @if($_show_sales_man ==1)
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_sales_man">Sales Man:</label>
                              <input type="text" id="_search_main_sales_man" name="_search_main_sales_man" class="form-control _search_main_sales_man"  placeholder="Sales Man" readonly>

                            <input type="hidden" id="_sales_man" name="_sales_man_id" class="form-control _sales_man"  placeholder="Sales Man" >
                            <div class="search_box_sales_man"> </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">{{__('label.issue_return_no')}}:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number')}}" placeholder="Order Number" readonly >
                                
                            </div>
                        </div>
              </div>
            <div class="row">
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">{{__('label._ledger_id')}}:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id')}}" placeholder="{{__('label._ledger_id')}}" required readonly>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id')}}" placeholder="{{__('label._ledger_id')}}" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">{{__('label._phone')}}:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone')}}" placeholder="{{__('label._phone')}}" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">{{__('label._address')}}:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address')}}" placeholder="{{__('label._address')}}" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">{{__('label._referance')}}:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance')}}" placeholder="{{__('label._referance')}}" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">{{__('label._delivery_details')}}:</label>
                              <textarea class="form-control" name="_delivery_details" >{!! old('_delivery_details') !!}</textarea>
                              
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
                                            <th class="text-left" >{{__('label.id')}}</th>
                                            <th class="text-left" >{{__('label._item')}}</th>
                                            <th class="text-left display_none" >{{__('label._base_unit')}}</th>
                                            <th class="text-left display_none" >{{__('lable.conversion_qty')}}</th>
                                            <th class="text-left @if($_show_unit==0) display_none @endif " >{{__('label.transection_unit')}}</th>
                                           
                                            <th class="text-left @if($_show_barcode == 0) display_none @endif" >{{__('label._barcode')}}</th>
                                            <th class="text-left @if($_show_warranty==0) display_none @endif" >{{__('label._warrantry')}}</th>
                                            <th class="text-left  " >{{__('label._qty')}}</th>
                                            
                                            <th class="text-left @if($_show_cost_rate == 0) display_none @endif" >{{__('label._cost_rate')}}</th>
                                            <th class="text-left" >{{__('label.issue_rate')}}</th>
                                            
                                            <th class="text-left @if($_show_vat == 0) display_none @endif " >{{__('label._vat')}}%</th>
                                            <th class="text-left @if($_show_vat == 0) display_none @endif" >{{__('label._vat_amount')}}</th>
                                            
                                            <th class="text-left @if($_inline_discount == 0) display_none @endif " >{{__('label._dis')}}%</th>
                                            <th class="text-left @if($_inline_discount == 0) display_none @endif " >{{__('label._discount_amount')}}</th>
                                            <th class="text-left" >{{__('label._value')}}</th>
                                             <th class="text-middle @if($_show_manufacture_date==0) display_none @endif " >{{__('label._manufacture_date')}}</th>
                                             <th class="text-middle @if($_show_expire_date==0) display_none @endif "> {{__('label._expire_date')}} </th>
                                            <th class="text-left   @if($_show_branch == 0) display_none @endif" >{{__('label._branch_id')}}</th>
                                             <th class="text-left @if($_show_cost_center==0) display_none @endif" >{{__('label._cost_center_id')}}</th>
                                             <th class="text-left @if($_show_store== 0) display_none @endif" >{{__('label.store_house')}}</th>
                                             <th class="text-left @if($_show_self==0) display_none @endif" >{{__('label.shelf')}}</th>
                                           
                                           
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            <tr class="_purchase_row">
                                              <td></td>
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" readonly>

                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" >
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
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>

                                             
                                              <td class=" @if($_show_barcode  ==0) display_none @endif ">
                                                <input type="text" name="_barcode[]" class="form-control _barcode " >
                                              </td>
                                              <td  class="@if($_show_warranty  ==0) display_none @endif" >
                                                <select name="_warranty[]" class="form-control _warranty 1___warranty">
                                                   <option value="0">--Select --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td class=" @if($_show_cost_rate ==0) display_none @endif " >
                                                <input type="number" name="_rate[]" class="form-control _rate  " readonly>
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup " >
                                              </td>
                                              
                                              <td class=" @if($_show_vat == 0) display_none @endif ">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" placeholder="VAT%" >
                                              </td>
                                              <td class="@if($_show_vat ==0) display_none @endif " >
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" placeholder="VAT Amount"  >
                                              </td>
                                              
                                              
                                              <td class="@if($_inline_discount ==0) display_none @endif " >
                                                <input type="text" name="_discount[]" class="form-control  _discount _common_keyup" >
                                              </td>
                                              <td class="@if($_inline_discount ==0) display_none @endif" >
                                                <input type="text" name="_discount_amount[]" class="form-control  _discount_amount" >
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                               <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date "  >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date "  >
                                              </td>
                                            
                                               <td class="@if($_show_branch == 0) display_none @endif ">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" >{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                             
                                             


                                               <td class=" @if($_show_cost_center == 0) display_none @endif " >
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" > {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            
                                              <td class=" @if($_show_store == 0) display_none @endif ">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                             
                                             
                                              <td class=" @if($_show_self==0) display_none @endif ">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " >
                                              </td>
                                              
                                              
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td></td>
                                              <td></td>
                                              <td colspan="2"  class="text-right"><b>Total</b></td>
                                              
                                                <td  class="text-right @if($_show_barcode==0) display_none @endif"></td>
                                                <td  class="text-right @if($_show_warranty==0) display_none @endif"></td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif"></td>
                                              <td></td>
                                              
                                              <td class="@if($_show_vat==0) display_none @endif"></td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="0" readonly required>
                                              </td>
                                              
                                              <td class="@if($_inline_discount==0) display_none @endif"></td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" step="any" min="0" name="_total_discount_amount" class="form-control _total_discount_amount" value="0" readonly required>
                                              </td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly required>
                                              </td>
                                               <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                              </td>
                                             
                                               <td class="@if($_show_branch == 0) display_none @endif"></td>
                                               <td class="@if($_show_cost_center == 0) display_none @endif"></td>
                                               <td class="@if($_show_store == 0) display_none @endif"></td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif"></td>
                                             
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                       
                         


                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;margin: 0px auto;">
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_note">Note<span class="_required">*</span></label></td>
                              <td style="border:0px;width: 80%;">
                                @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('sales-return/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_sub_total">Sub Total</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="0">
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_discount_input" class="form-control width_200_px" id="_discount_input" value="0" >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total_discount">Total Discount</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_total_discount" class="form-control width_200_px" id="_total_discount" readonly value="0">
                              </td>
                            </tr>
                           
                            <tr class=" @if($_show_vat==0) display_none @endif">
                              <td style="border:0px;width: 20%;"><label for="_total_vat">Total VAT</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_total_vat" class="form-control width_200_px" id="_total_vat" readonly value="0">
                              </td>
                            </tr>
                           
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total">NET Total </label></td>
                              <td style="border:0px;width: 80%;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="0">
                              </td>
                            </tr>
                             @include('backend.message.send_sms')
                          </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ url('material-issue-setting')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('label.material_issue_form_settings')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body display_form_setting_info">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
       </form>
    </div>
  </div>



</div>


@endsection

@section('script')

<script type="text/javascript">
  @if(empty($form_settings))
    $("#form_settings").click();
    setting_data_fetch();
  @endif
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  if(_after_print ==1){
      var open_new = window.open(_master_id, '_blank');
      if (open_new) {
          //Browser has allowed it to be opened
          open_new.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
  }




  $(document).on("click","#form_settings",function(){
         setting_data_fetch();
  })

  function setting_data_fetch(){
      var request = $.ajax({
            url: "{{url('material-issue-setting-modal')}}",
            method: "GET",
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_form_setting_info").html(result);
         })
  }

  $(document).on('keyup','._search_order_ref_id',delay(function(e){
    $(document).find('._search_order_ref_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _branch_id = $(document).find('._master_branch_id').val();

  var request = $.ajax({
      url: "{{url('material-issue-search')}}",
      method: "GET",
      data: { _text_val,_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {
console.log(result)
      var search_html =``;
      var data = result.data; 
       console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table table-bordered style="width: 100%;">
                            <thead>
                              <th style="border:1px solid #ccc;text-align:center;">{{__('label.id')}}</th>
                              <th style="border:1px solid #ccc;text-align:center;">{{__('label.issue_number')}}</th>
                              <th style="border:1px solid #ccc;text-align:center;">{{__('label._ledger_id')}}</th>
                              <th style="border:1px solid #ccc;text-align:center;">{{__('label._date')}}</th>
                            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var _delivery_man_id = (data[i]._delivery_man ) ? data[i]._delivery_man.id : '' ;
                          var _delivery_man_name = (data[i]._delivery_man ) ? data[i]._delivery_man._name : '' ;
                          var _sales_man_id = (data[i]._sales_man ) ? data[i]._sales_man.id : '' ;
                          var _sales_man_name = (data[i]._sales_man ) ? data[i]._sales_man._name : '' ;
                          var __address = (data[i]._ledger._address ) ? data[i]._ledger._address : '' ;
                          var __phone = (data[i]._phone ) ? data[i]._phone : '' ;
                          var __organization_id = (data[i].organization_id ) ? data[i].organization_id : '' ;
                          var __branch_id = (data[i]._branch_id ) ? data[i]._branch_id : '' ;
                          var __cost_center_id = (data[i]._cost_center_id ) ? data[i]._cost_center_id : '' ;

                         search_html += `<tr class="search_row_purchase_order" >
                                        <td style="border:1px solid #ccc;">${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i]._ledger_id}">
                                        <input type="hidden" name="_purchase_main_id" class="_purchase_main_id" value="${data[i].id}">

                                        <input type="hidden" name="__organization_id" class="__organization_id" value="${__organization_id}">

                                        <input type="hidden" name="__branch_id" class="__branch_id" value="${__branch_id}">

                                        <input type="hidden" name="__cost_center_id" class="__cost_center_id" value="${__cost_center_id}">
                                        <input type="hidden" name="_material_issue_order_number" class="_material_issue_order_number" value="${data[i]._order_number}">

                                        <input type="hidden" name="_purchase_main_date" class="_purchase_main_date" value="${after_request_date__today(data[i]._date)}">
                                        </td>
                                        <td style="border:1px solid #ccc;">${data[i]._order_number}</td>

                                        <td style="border:1px solid #ccc;">${data[i]._ledger._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._ledger._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${__address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${__phone}">
                                        <input type="hidden" name="_delivery_man_main_id" class="_delivery_man_main_id" value="${_delivery_man_id}">
                                        <input type="hidden" name="_delivery_man_main_name" class="_delivery_man_main_name" value="${_delivery_man_name}">
                                        <input type="hidden" name="_sales_man_main_id" class="_sales_man_main_id" value="${_sales_man_id}" >
                                        <input type="hidden" name="_sales_man_main_name" class="_sales_man_main_name" value="${_sales_man_name}" }">
                                        <input type="hidden" name="_date_main_ledger" class="_date_main_ledger" value="${after_request_date__today(data[i]._date)}">
                                   </td>

                                   <td style="border:1px solid #ccc;">${after_request_date__today(data[i]._date)}
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card">
        <table style="width: 300px;"> 
            <thead>
                <th colspan="3">No Data Found</th></thead>
            <tbody>
            </tbody>
        </table>
        </div>`;
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
    var _material_issue_order_number = $(this).find('._material_issue_order_number').val();


    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    var _search_main_delivery_man = $(this).find('._delivery_man_main_name').val();
    var _delivery_man_id = $(this).find('._delivery_man_main_id').val();
    var _search_main_sales_man = $(this).find('._sales_man_main_name').val();
    var _sales_man = $(this).find('._sales_man_main_id').val();

    var __organization_id = $(this).find('.__organization_id').val();
    var __branch_id = $(this).find('.__branch_id').val();
    var __cost_center_id = $(this).find('.__cost_center_id').val();





   
    if(_address_main_ledger =='null' ){ _address_main_ledger =""; } 
    if(_phone_main_ledger =='null' ){ _phone_main_ledger =""; } 

    $("._main_ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);
    $("._order_ref_id").val(_purchase_main_id);
    $("._phone").val(_phone_main_ledger);
    $("._address").val(_address_main_ledger);

    $(document).find("._master_organization_id").val(__organization_id).change();
    $(document).find("._master_branch_id").val(__branch_id).change();
    $(document).find("._cost_center_id").val(__cost_center_id).change();

$(document).find("._assign_organization_id").val(__organization_id);
$(document).find("._assign_branch_id").val(__branch_id);
$(document).find("._assign_cost_center_id").val(__cost_center_id);
    






    $("._search_main_delivery_man").val(_search_main_delivery_man);
    $("._delivery_man_id").val(_delivery_man_id);
    $("._search_main_sales_man").val(_search_main_sales_man);
    $("._sales_man").val(_sales_man);
    $("._search_order_ref_id").val(_material_issue_order_number);

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var request = $.ajax({
      url: "{{url('material-issue-details')}}",
      method: "POST",
      data: { _purchase_main_id,_main_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {


      console.log(result)
      var data = result;
      var _purchase_row_single = ``;
      $(document).find("#area__purchase_details").empty();
     
if(data.length > 0 ){
  for (var i = 0; i < data.length; i++) {
     var _row_id = (data[i].id) ? data[i].id : '' ;
    var _item_name = (data[i]._items._name) ? data[i]._items._name : '' ;
    var _store_salves_id = (data[i]._store_salves_id) ? data[i]._store_salves_id : '' ;
    var _barcode  = (data[i]._barcode ) ? data[i]._barcode  : '' ;
    var _warranty  = (data[i]._warranty ) ? data[i]._warranty  : '0' ;
    var _unique_barcode  = (data[i]._items._unique_barcode ) ? data[i]._items._unique_barcode  : '' ;
    
    var _qty   = (data[i]._qty  ) ? data[i]._qty   : 0 ;
    var _rate    = (data[i]._rate) ? data[i]._rate    : 0 ;
    var _sales_rate = (data[i]._sales_rate ) ? data[i]._sales_rate : 0 ;
    var _vat = (  data[i]._vat ) ? data[i]._vat : 0 ;

    var _manufacture_date = (data[i]._manufacture_date) ? data[i]._manufacture_date : '' ;
    var _expire_date = (data[i]._expire_date) ? data[i]._expire_date : '' ;

    var _vat_amount = ( ((data[i]._qty*data[i]._sales_rate)*data[i]._vat)/100 ) ? ( ((data[i]._qty*data[i]._sales_rate)*data[i]._vat)/100 ) : 0 ;
    var _discount = (data[i]._discount ) ? data[i]._discount : 0 ;
    var _discount_amount = ( ((data[i]._qty*data[i]._sales_rate)*data[i]._discount)/100 ) ? ( ((data[i]._qty*data[i]._sales_rate)*data[i]._discount)/100 ) : 0 ;
    var _value = ( (data[i]._qty*data[i]._sales_rate) ) ? (data[i]._qty*data[i]._sales_rate) : 0 ;
    var _item_row_count = (i+1);


     var unit_conversion_data = data[i]?.unit_conversion;

      var unit_conversion_options=``;
      for (var j = 0; j < unit_conversion_data.length; j++) {
          unit_conversion_options +=`<option value="${unit_conversion_data[j]?._conversion_unit}"
          attr_base_unit_id="${unit_conversion_data[j]?._base_unit_id}"
          attr_conversion_qty="${unit_conversion_data[j]?._conversion_qty}"
          attr_conversion_unit="${unit_conversion_data[j]?._conversion_unit}"
          attr_item_id="${unit_conversion_data[j]?._item_id}"
          >${unit_conversion_data[j]?._conversion_unit_name}</option>`;  
      }


       $(document).find("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>${_row_id}</td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id ${_item_row_count}__search_item_id width_280_px" placeholder="Item" value="${_item_name}(${_qty})(${data[i]?._trans_unit?._name})" readonly>
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " value="${data[i]._item_id}" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " value="${data[i]._p_p_l_id}"  >
                                                <input type="hidden" name="_sales_ref_id[]" class="form-control _sales_ref_id" value="${data[i]._no}" >
                                                <input type="hidden" name="_sales_detail_ref_id[]" class="form-control _sales_detail_ref_id" value="${data[i].id}" >
                                                
                                                
                                              </td>

                                              <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="${data[i]?._items?._unit_id}" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="${data[i]?._units?._name}" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty "  readonly value="${data[i]?._unit_conversion}">
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="${data[i]?._base_rate}" >
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _transection_unit _transection_unit___${i}" name="_transection_unit[]">
                                                ${unit_conversion_options}
                                                </select>
                                              </td>

                                             
                                              <td class="@if($_show_barcode==0) display_none @endif">
                                                
                                                <input type="hidden" class="_old_barcode" value="${((data[i]._barcode=='null') ? '' : data[i]._barcode) }" />
                                                <input type="text" name="${_item_row_count}__barcode__${data[i]._p_p_l_id}" class="form-control _barcode ${_item_row_count}__barcode " id="${_item_row_count}__barcode" value="" >

                                                <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                                <input type="hidden" name="_unique_barcode[]" value="" class="_unique_barcode   ${_item_row_count}__unique_barcode" id="${_item_row_count}_unique_barcode">
                                              </td>
                                              <td class="@if($_show_warranty==0) display_none @endif">
                                                <select name="_warranty[]" class="form-control _warranty ${_item_row_count}___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty ${_item_row_count}__qty _common_keyup" value="0"  ${((_unique_barcode==1) ? 'readonly' : '') }>
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif">
                                                <input type="number" name="_rate[]" class="form-control _rate " readonly value="${_rate}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup" value="${_sales_rate}">
                                              </td>
                                               
                                                <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" value="${_vat}" >
                                              </td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" value="0" >
                                              </td>
                                                <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="text" name="_discount[]" class="form-control  _discount _common_keyup" value="${_discount}" >
                                              </td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="text" name="_discount_amount[]" class="form-control  _discount_amount" value="0" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly value="0" >
                                              </td>
                                               <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " value="${_manufacture_date}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " value="${_expire_date }" >
                                              </td>
                                              <td class="@if($_show_branch==0) display_none @endif">
                                              <input type="hidden" class="_main_branch_id_detail" name="_main_branch_id_detail[]" value="${data[i]._branch_id}" />
                                              <input type="text" readonly class="_main_branch_name_detail" name="_main_branch_name_detail[]" value="${data[i]._detail_branch._name}" />
                                                
                                              </td>
                                              
                                               <td class="@if($_show_cost_center==0) display_none @endif">

                                                <input type="hidden" class="_main_cost_center" name="_main_cost_center[]" value="${data[i]._cost_center_id}" />
                                              <input type="text" readonly class="_main_cost_center_name_detail" name="_main_cost_center_name_detail[]" value="${data[i]._detail_cost_center._name}" />
                                                 
                                              </td>
                                              
                                             
                                              <td class="@if($_show_store==0) display_none @endif">
                                              <input type="hidden" class="_main_store_id" name="_main_store_id[]" value="${data[i]._store_id}" />
                                              <input type="text" readonly class="_main_store_name_detail" name="_main_store_name_detail[]" value="${data[i]._store._name}" />

                                                
                                                
                                              </td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="${_store_salves_id}" >
                                              </td>
                                              
                                              
                                            </tr>`);
$("."+_item_row_count+"___warranty").val(_warranty);

console.log("data[i]?._transection_unit "+ data[i]?._transection_unit)
          $(document).find("._transection_unit___"+i).val(data[i]?._transection_unit);

                                            if(_unique_barcode ==1){
                                             _new_barcode_function(_item_row_count)   
                                           }

                                          }

                                          

                                        }



           // $(document).find("#area__purchase_details").html(_purchase_row_single);
              _purchase_total_calculation();
    })



  })

 function _new_barcode_function(_item_row_count){
      $('#'+_item_row_count+'__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }
  
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
  var _sales_rate =parseFloat( __this.closest('tr').find('._sales_rate').val());
  var _item_vat = __this.closest('tr').find('._vat').val();
  var conversion_qty = parseFloat(__this.closest('tr').find('.conversion_qty').val());
  var _item_discount = parseFloat(__this.closest('tr').find('._discount').val());


   if(isNaN(_item_vat)){ _item_vat   = 0 }

  if(isNaN(conversion_qty)){ conversion_qty   = 1 }
  var converted_price_rate = (( conversion_qty/1)*_base_rate);

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   if(isNaN(_base_rate)){ _base_rate =0 }

  if(converted_price_rate ==0){
    converted_price_rate = _sales_rate;
  }
  converted_price_rate = parseFloat(converted_price_rate).toFixed(2);
  if(isNaN(converted_price_rate)){converted_price_rate=0}

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*converted_price_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*converted_price_rate)*_item_discount)/100)


   var _value = parseFloat(converted_price_rate*_qty).toFixed(2);
 __this.closest('tr').find('._sales_rate').val(converted_price_rate);
 __this.closest('tr').find('._value').val(_value);
  __this.closest('tr').find('._vat_amount').val(_vat_amount);
  __this.closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();


}
  

 

$(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $('.search_box_main_ledger').hasClass('search_box_show');
    var search_row_purchase_order= $('.search_box_purchase_order').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }

    if(search_box_main_ledger ==true){
      $('.search_box_main_ledger').removeClass('search_box_show').hide();
    }

    if(search_row_purchase_order ==true){
      $('.search_box_purchase_order').removeClass('search_box_show').hide();
    }
})

$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._rate').val());
  var _sales_rate =parseFloat( $(this).closest('tr').find('._sales_rate').val());
  var _item_vat = parseFloat($(this).closest('tr').find('._vat').val());
  var _item_discount = parseFloat($(this).closest('tr').find('._discount').val());

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*_sales_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*_sales_rate)*_item_discount)/100)

  $(this).closest('tr').find('._value').val((_qty*_sales_rate));
  $(this).closest('tr').find('._vat_amount').val(_vat_amount);
  $(this).closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();
})

$(document).on('keyup','._vat_amount',function(){
 var _item_vat =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
  var _vat_amount =  $(this).closest('tr').find('._vat_amount').val();
  
   if(isNaN(_vat_amount)){ _vat_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _vat = parseFloat((_vat_amount/(_sales_rate*_qty))*100).toFixed(2);
    $(this).closest('tr').find('._vat').val(_vat);

    $(this).closest('tr').find('._value').val((_qty*_sales_rate));
 
    _purchase_total_calculation();
})
$(document).on('keyup','._discount_amount',function(){
 var _item_vat =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
  var _discount_amount =  $(this).closest('tr').find('._discount_amount').val();
  
   if(isNaN(_discount_amount)){ _discount_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _discount = parseFloat((_discount_amount/(_sales_rate*_qty))*100).toFixed(2);
    $(this).closest('tr').find('._discount').val(_discount);

    $(this).closest('tr').find('._value').val((_qty*_sales_rate));
 
    _purchase_total_calculation();
})

$(document).on("change","#_discount_input",function(){
  var _discount_input = $(this).val();
  var res = _discount_input.match(/%/gi);
  if(res){
     res = _discount_input.split("%");
    res= parseFloat(res);
    on_invoice_discount = ($("#_sub_total").val()*res)/100
    $("#_discount_input").val(on_invoice_discount)

  }else{
    on_invoice_discount = _discount_input;
  }

   $("#_discount_input").val(on_invoice_discount);
    _purchase_total_calculation()
})



 function _purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount_amount = 0;
      $(document).find("._value").each(function() {
          _total__value +=parseFloat($(this).val());
      });
      $(document).find("._qty").each(function() {
          _total_qty +=parseFloat($(this).val());
      });

      $(document).find("._vat_amount").each(function() {
          _total__vat +=parseFloat($(this).val());
      });
      $(document).find("._discount_amount").each(function() {
          _total_discount_amount +=parseFloat($(this).val());
      });
      $("._total_qty_amount").val(_total_qty);
      $("._total_value_amount").val(_total__value);
      $("._total_vat_amount").val(_total__vat);
      $("._total_discount_amount").val(_total_discount_amount);

      var _discount_input = parseFloat($("#_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }
      var _total_discount = parseFloat(_discount_input)+parseFloat(_total_discount_amount);
      $("#_sub_total").val(_math_round(_total__value));
      $("#_total_vat").val(_total__vat);
      $("#_total_discount").val(parseFloat(_discount_input)+parseFloat(_total_discount_amount));
      var _total = _math_round((parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_total_discount));
      $("#_total").val(_total);
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger" @if($__user->_ac_type==1) attr_account_head_no="1" @endif >
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                       @if(sizeof($permited_branch)>1)
                      <td>
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        @else
                          <td class="display_none">
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        @endif

                         @if(sizeof($permited_costcenters)>1)
                        <td>
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        @else
                        <td class="display_none">
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        @endif
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            <td class=" @if($__user->_ac_type==1) display_none @endif" >
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $("#area__voucher_details").append(single_row);
  }

var _purchase_row_single =`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" >
                                                <div class="search_box_item">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                             
                                              <td class="@if($_show_barcode==0) display_none @endif">
                                                <input type="text" name="_barcode[]" class="form-control _barcode " >
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif">
                                                <input type="number" name="_rate[]" class="form-control _rate " readonly >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup" >
                                              </td>
                                               
                                                <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" >
                                              </td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" >
                                              </td>
                                                <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="text" name="_discount[]" class="form-control  _discount _common_keyup" >
                                              </td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="text" name="_discount_amount[]" class="form-control  _discount_amount" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                              
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                               <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                             
                                              <td class="@if(sizeof($store_houses)==1) display_none @endif">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " >
                                              </td>
                                              
                                              
                                            </tr>`;
function purchase_row_add(event){
   event.preventDefault();
      $("#area__purchase_details").append(_purchase_row_single);
}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _purchase_total_calculation();
  })

 


  $(document).on('click','.submit-button',function(event){
    event.preventDefault();

    var _over_qty_barcode = [];
    $(document).find("._unique_barcode").each(function(__index) {
      var _new_index=(__index+1)
      var __barcodes =   $("#"+_new_index+"__barcode").val();
      var _qtys  =   $("#"+_new_index+"__qty").val();
      var __unique_barcode  =   $("#"+_new_index+"_unique_barcode").val();
      console.log("__unique_barcode "+__unique_barcode)
      if(__unique_barcode ==1){
        var __barcodes_string = isEmpty(__barcodes);
        if(__barcodes_string !=''){
           var _single_barcode_array = __barcodes_string.split(",");
           console.log("_single_barcode_array "+_single_barcode_array.length);
           console.log("_qtys "+_qtys);
           if(_single_barcode_array.length !=_qtys ){
            console.log("not equal with barcode and qty")
              _over_qty_barcode.push(_new_index);
           }
        }
      }
      });

    var _total_qty_amount = $(document).find("._total_qty_amount").val();
    if(_total_qty_amount ==0){
      alert('Return QTY Must not be Zero');
      $(document).find("._total_qty_amount").addClass("required_border").focus();
      return false;
    }

    // if(_over_qty_barcode.length > 0){
    //   for (var i = 0; i < _over_qty_barcode.length; i++) {
    //     $("."+ _over_qty_barcode[i]+"__search_item_id").addClass('_required');
    //   }
    //   var _message = "Unique Barcode and Qty Is not Equal ";
    //   var _type = "danger";
    //   _show_notify_message(_message,_type)
    //   return false;
    // }

    
      

    var _p_p_l_ids_qtys = new Array();
     var _only_p_ids = [];
     var empty_qty = [];
    var _id_and_qtys = [];
    var _sales_detail_ref_ids = [];
    var _sales_return_id = $("._sales_return_id").val();

    $(document).find('._p_p_l_id').each(function(index){
     var _p_id =  $(this).val();
     var _p_qty = $(document).find('._qty').eq(index).val();
     var _s_d_id = $(document).find('._sales_detail_ref_id').eq(index).val();
     var conversion_qty = $(document).find('.conversion_qty').eq(index).val();
     conversion_qty = parseFloat(conversion_qty);
     _p_qty = parseFloat(parseFloat(_p_qty)*parseFloat(conversion_qty));

     if(isNaN(_p_qty)){
        empty_qty.push(_p_id);
     }
     _only_p_ids.push(_p_id);
     _sales_detail_ref_ids.push({_s_d_id:_s_d_id,_p_qty:_p_qty});
      _p_p_l_ids_qtys.push( {_p_id: _p_id, _p_qty: _p_qty});
     

    })
     var unique_p_ids = [...new Set(_only_p_ids)];
     var _stop_sales =0;
    if(_p_p_l_ids_qtys.length > 0){
        var request = $.ajax({
                url: "{{url('check-sales-return-available-qty')}}",
                method: "GET",
                async:false,
                data: { _p_p_l_ids_qtys,unique_p_ids,_sales_detail_ref_ids:_sales_detail_ref_ids,_sales_return_id },
                dataType: "JSON"
              });
               
              request.done(function( result ) {
                
                  if(result.length > 0){
                     
                   _stop_sales=1;
                  }else{
                     $(document).find("._over_qty").text('');
                  }
              })
    }
    if(_stop_sales ==1){
        alert(" You Can not Return More then Sales Qty  ");
       var _message =" You Can not Return More then Sales Qty";
        $(document).find("._over_qty").text(_message);
        $(".remove_area").hide();
      return false;
    }

 
    
   
    var _total_dr_amount = $(document).find("._total_dr_amount").val();
    var _total_cr_amount = $(document).find("._total_cr_amount").val();
    var _voucher_type = $(document).find('._voucher_type').val();
    var _note = $(document).find('._note').val();
    var _main_ledger_id = $(document).find('._main_ledger_id').val();



    if(_main_ledger_id  ==""){
       alert(" Please Add Ledger  ");
        $(document).find('._search_main_ledger_id').addClass('required_border').focus();
        return false;
    }

    if(empty_qty.length > 0){
       alert(" You Can not sale empty qty !");
      return false;

    }


    var empty_ledger = [];
    $(document).find("._search_item_id").each(function(){
        if($(this).val() ==""){
          alert(" Please Add Item  ");
          $(this).addClass('required_border');
          empty_ledger.push(1);
        }  
    })

    if(empty_ledger.length > 0){
      return false;
    }
   


    
     if(_note ==""){
       
       $(document).find('._note').addClass('required_border').focus();
      return false;
    }else if(_main_ledger_id ==""){
       
      $(document).find('._search_main_ledger_id').addClass('required_border').focus();
      return false;
    }else{
      $(document).find('.purchase_form').submit();
    }
  })




 

$(".datetimepicker-input").val(date__today())

          function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

</script>
@endsection

