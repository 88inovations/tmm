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
            <a class="m-0 _page_name" href="{{ route('item-replace.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item ">
               <a target="__blank" href="{{url('item-replace/print')}}/{{$data->id}}" class="btn btn-sm btn-warning"> <i class="nav-icon fas fa-print"></i> </a>
                  
                
               </li>
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
                @can('item-replace-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('item-replace.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php
    $_show_delivery_man = $form_settings->_show_delivery_man ?? 0;
    $_show_sales_man = $form_settings->_show_sales_man ?? 0;
    $_show_barcode = $form_settings->_show_barcode ?? 0;
    $_show_cost_rate =  $form_settings->_show_cost_rate ?? 0;
    $_show_vat =  $form_settings->_show_vat ?? 0;
   $_inline_discount = $form_settings->_inline_discount ?? 0;
    $_show_self = $form_settings->_show_self ?? 0;
    $_show_warranty = $form_settings->_show_warranty ?? 0;
    $_defaut_customer = $form_settings->_defaut_customer ?? 0;
    @endphp
  
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
              <div class="card-body">
                @if($settings->_barcode_service ==1)
                <div class="row mb-2">
                  <div class="col-md-2"></div>
                     <div class="col-md-8">
                       <div class="_barcode_search_div mt-2" >
                                <div class="form-group">
                                  <input required="" type="text" id="_serach_baorce" name="_serach_baorce" class="form-control _serach_baorce"  placeholder="Search with Unique Barcode"  >
                                    <div class="_main_item_search_box"></div>
                                </div>
                          </div>
                        </div>
                    <div class="col-md-2">
                   <button class="btn btn-danger mt-2 _clear_icon display_none" title="Clear Search"><i class=" fas fa-retweet "></i></button>
                 </div> 
               </div>
               @endif
             <form action="{{url('item-replace/update')}}" method="POST" class="purchase_form" >
                @csrf
                
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name"  value="replacement_masters">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_date)}}"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Invoice Number:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number',$data->_order_number)}}" placeholder="Invoice Number" readonly >
                <input type="hidden" id="_search_form_value" name="_search_form_value" class="_search_form_value" value="2" >
                <input type="hidden" name="_replacement_id" value="{{$data->id}}" class="_replacement_id" >
                                
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2 @if(sizeof($permited_branch) == 1) display_none @endif" >
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control _master_branch_id" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Complain Number:<span class="_required">*</span></label>
                              <input type="text" id="_search_order_ref_id" name="_search_order_ref_id" class="form-control _search_order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id)}}" placeholder="Complain Number" required>
                              <input type="hidden" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id)}}" placeholder="Purchase Order" required>
                              <div class="search_box_purchase_order"></div>
                                
                            </div>
                        </div>
                     
                         @if($_show_sales_man ==1)
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_sales_man">Sales Man:</label>
                              <input type="text" id="_search_main_sales_man" name="_search_main_sales_man" class="form-control _search_main_sales_man" value="{{$data->_sales_man->_name ?? ''}}" placeholder="Sales Man" >

                            <input type="hidden" id="_sales_man" name="_sales_man_id" class="form-control _sales_man" value="{{$data->_sales_man_id}}" placeholder="Sales Man" >
                            <div class="search_box_sales_man"> </div>
                            </div>
                        </div>
                        @endif
                          @if($_show_delivery_man ==1)
                        <div class="col-xs-12 col-sm-12 col-md-3 @if($_show_delivery_man==0 ) display_none @endif">
                            <div class="form-group">
                              <label class="mr-2" for="_delivery_man">Delivery Man:</label>
                              <input type="text" id="_search_main_delivery_man" name="_search_main_delivery_man" class="form-control _search_main_delivery_man" 
                              value="{{$data->_delivery_man->_name ?? '' }}" placeholder="Delivery Man" >

                            <input type="hidden" id="_delivery_man" name="_delivery_man_id" class="form-control _delivery_man" value="{{$data->_delivery_man_id}}" placeholder="Delivery Man" >
                            <div class="search_box_delivery_man"> </div>
                            </div>
                        </div>
                        @endif
                       
                        
                       <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->_ledger->_name ?? '' )}}" placeholder="Customer" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Customer" required>
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
                        
                        @php
                        $_master_details = $data->_master_details ?? [];
                        $_master_in_details = $data->_master_in_details ?? [];

                        $_total_qty_amount = 0;
                        $_total_vat_amount =0;
                        $_total_value_amount =0;
                        $_total_discount_amount =0;

                        @endphp
                        @if(sizeof($_master_details) > 0)
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Item Details</strong>
                                
                               
                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >Item</th>
                                          
                                            <th class="text-left @if($_show_barcode  ==0) display_none @endif" >Barcode</th>
                                            <th class="text-left @if($_show_warranty  ==0) display_none @endif" >Warranty</th>
                                            
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left @if($_show_cost_rate  ==0) display_none @endif" >Cost</th>
                                            <th class="text-left" >Sales Rate</th>
                                            
                                            <th class="text-left  @if($_show_vat  ==0) display_none @endif" >VAT%</th>
                                            <th class="text-left  @if($_show_vat  ==0) display_none @endif" >VAT Amount</th>
                                           
                                             
                                            <th class="text-left @if($_inline_discount  ==0) display_none @endif" >Dis%</th>
                                            <th class="text-left @if($_inline_discount  ==0) display_none @endif" >Discount</th>
                                            <th class="text-left" >Value</th>

                                            <th class="text-middle @if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none @endif
                                            @endif" >Manu. Date</th>
                                             <th class="text-middle @if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none @endif
                                            @endif"> Expired Date </th>
                                           
                                            <th class="text-left  @if(sizeof($permited_branch)  ==1) display_none @endif " >Branch</th>
                                            
                                            
                                             <th class="text-left  @if(sizeof($permited_costcenters)  ==1) display_none @endif " >Cost Center</th>
                                            
                                             
                                             <th class="text-left @if(sizeof($store_houses)  ==1) display_none @endif" >Store</th>
                                           
                                            
                                             <th class="text-left  @if($_show_self  ==0) display_none @endif " >Shelf</th>
                                           
                                           
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @forelse($_master_details as $m_key=> $detail)
                                            @php
                                              $_total_qty_amount += $detail->_qty ??  0;
                                              $_total_vat_amount += $detail->_vat_amount ??  0;
                                              $_total_value_amount += $detail->_value ??  0;
                                              $_total_discount_amount += $detail->_discount_amount ??  0;
                                              @endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>{{ $detail->id }}</td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id _search_item_id__counter_{{($m_key+1)}} width_280_px _search_item_id__{{$detail->_p_p_l_id}}" placeholder="Item" value="{{ $detail->_purchase_invoice_no ?? '' }},{{$detail->_items->_name ?? '' }}, {{$detail->_items->_qty ?? '' }}">

                                                <input type="hidden" name="_item_id[]" class="form-control _item_id _item_id__counter_{{($m_key+1)}} _item_id__{{$detail->_p_p_l_id}} width_200_px" value="{{$detail->_item_id}}">

                                                
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id _p_p_l_id__counter_{{($m_key+1)}} _p_p_l_id__{{$detail->_p_p_l_id}} " value="{{$detail->_p_p_l_id}}" >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no _purchase_invoice_no__counter_{{($m_key+1)}} _purchase_invoice_no__{{$detail->_p_p_l_id}}" value="{{$detail->_purchase_invoice_no}}">
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id _purchase_detail_id__counter_{{($m_key+1)}} _purchase_detail_id__{{$detail->_p_p_l_id}}" value="{{$detail->_purchase_detail_id}}" >
                                                <input type="hidden" name="_sales_detail_row_id[]" class="form-control _sales_detail_row_id _sales_detail_row_id__counter_{{($m_key+1)}} _sales_detail_row_id__{{$detail->_p_p_l_id}}" value="{{$detail->id}}" >

                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                             
                                              
                                              <td class=" @if($form_settings->_show_barcode == 0) display_none  @endif ">
                                                <div class="d-flex" style="width: 100%;">
                                               @php
                                               $__barcode = $detail->_barcode ?? '';
                                               if($__barcode !=''){
                                                  $_barcode_array =  explode(",",$__barcode);
                                                 }else{
                                                 $_barcode_array = [];
                                               }
                                               @endphp
                                                <input type="text" readonly name="counter_{{($m_key+1)}}__barcode__{{$detail->_item_id}}" class="form-control _barcode _barcode__counter_{{($m_key+1)}} _barcode__{{$detail->_p_p_l_id}}"  value="{{$detail->_barcode ?? '' }} " id="counter_{{($m_key+1)}}__barcode" >
                                               

                                                <input type="hidden" name="_ref_counter[]" value="counter_{{($m_key+1)}}" class="_ref_counter _ref_counter__counter_{{($m_key+1)}} _ref_counter__{{$detail->_p_p_l_id}}" id="counter_{{($m_key+1)}}__ref_counter">

                                                 @php
                                                $_unique_barcode = $detail->_items->_unique_barcode ?? 0;
                                                @endphp
                                                @if( $_unique_barcode==1)
                                                <div  class="modal" tabindex="-1" role="dialog" style="display: contents;">
                                                        <button 
                                                        attr_row_counter="counter_{{($m_key+1)}}" 
                                                        attr_p_p_l_id="{{$detail->_p_p_l_id}}" 
                                                        attr_item_name="{{$detail->_items->_name ?? '' }}" 
                                                        attr_item_id="{{$detail->_item_id}}" 
                                                        attr_item_p_p_id="{{$detail->_p_p_l_id}}" 
                                                        attr_item_barcodes="{{$detail->_barcode ?? '' }}" 
                                                        type="button" class="btn btn-sm btn-default _barcode_modal_button _barcode_modal_button__counter_{{($m_key+1)}} _barcode_modal_button__{{$detail->_p_p_l_id}}" 
                                                        data-toggle="modal" data-target="#barcodeDisplayModal"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                      </div>
                                                @endif
                                              </div>
                                               
                                              </td>
                                               <td class="@if($_show_warranty  ==0) display_none @endif">
                                                <select name="_warranty[]" class="form-control _warranty 1___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" @if($_warranty->id==$detail->_warranty) selected @endif >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              
                                              <td>
                                                <input type="number" min="0"  name="_qty[]" class="form-control _qty _qty__counter_{{($m_key+1)}}  _qty__{{$detail->_p_p_l_id}} _common_keyup"  value="{{$detail->_qty ?? 0 }}" >
                                              </td>
                                              <td class="@if($form_settings->_show_cost_rate == 0) display_none @endif">
                                                <input type="number" min="0"  name="_rate[]" class="form-control _rate _rate__counter_{{($m_key+1)}} _rate__{{$detail->_p_p_l_id}}  " value="{{$detail->_rate ?? 0 }}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" min="0"  name="_sales_rate[]" class="form-control _sales_rate _sales_rate__counter_{{($m_key+1)}}  _sales_rate__{{$detail->_p_p_l_id}} _common_keyup" value="{{$detail->_sales_rate ?? 0 }}" >
                                              </td>
                                             
                                              <td class="@if($form_settings->_show_vat == 0) display_none @endif">
                                                <input type="number" name="_vat[]" class="form-control  _vat _vat__counter_{{($m_key+1)}} _vat__{{$detail->_p_p_l_id}} _common_keyup" value="{{$detail->_vat ?? 0 }}">
                                              </td>
                                              <td class="@if($form_settings->_show_vat == 0) display_none @endif">
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount _vat_amount__counter_{{($m_key+1)}} _vat_amount__{{$detail->_p_p_l_id}} " value="{{$detail->_vat_amount ?? 0 }}" >
                                              </td>
                                             
                                              
                                              <td class="@if($form_settings->_inline_discount == 0) display_none @endif">
                                                <input type="number" name="_discount[]" class="form-control  _discount _discount__counter_{{($m_key+1)}}  _discount__{{$detail->_p_p_l_id}} _common_keyup" value="{{$detail->_discount}}">
                                              </td>
                                              <td class="@if($form_settings->_inline_discount == 0) display_none @endif">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount _discount_amount__counter_{{($m_key+1)}}  _discount_amount__{{$detail->_p_p_l_id}} " value="{{$detail->_discount_amount}}">
                                              </td>
                                             
                                              <td>
                                                <input type="number" min="0"  name="_value[]" class="form-control _value _value__counter_{{($m_key+1)}} _value__{{$detail->_p_p_l_id}} " readonly value="{{ $detail->_value ?? 0 }}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date _manufacture_date__counter_{{($m_key+1)}}  _manufacture_date__{{$detail->_p_p_l_id}} " value="{{ $detail->_manufacture_date ?? '' }}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date _expire_date__counter_{{($m_key+1)}}  _expire_date__{{$detail->_p_p_l_id}} " value="{{ $detail->_expire_date ?? '' }}" >
                                              </td>
                                            
                                               <td class="@if(sizeof($permited_branch) == 1) display_none @endif">
                                                <select class="form-control  _main_branch_id_detail _main_branch_id_detail__counter_{{($m_key+1)}} _main_branch_id_detail__{{$detail->_p_p_l_id}}" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                             
                                               <td class=" @if(sizeof($permited_costcenters) == 1) display_none @endif">
                                                 <select class="form-control  _main_cost_center _main_cost_center__counter_{{($m_key+1)}} _main_cost_center__{{$detail->_p_p_l_id}}" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif > {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                             
                                              <td class=" @if(sizeof($store_houses) == 1) display_none @endif ">
                                                <select class="form-control  _main_store_id _main_store_id__counter_{{($m_key+1)}}  _main_store_id__{{$detail->_p_p_l_id}} " name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}"   @if(isset($detail->_store_id)) @if($detail->_store_id == $costcenter->id) selected @endif   @endif  >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              
                                             
                                              <td class="@if($form_settings->_show_self == 0) display_none @endif">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id _store_salves_id__counter_{{($m_key+1)}}  _store_salves_id__{{$detail->_p_p_l_id}} " value="{{$detail->_store_salves_id ?? '' }}" >
                                              </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td colspan="2">
                                                <a href="#none"  class="btn btn-default" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td  class="text-right"><b>Total</b></td>
                                              
                                                <td  class="text-right @if($_show_barcode==0) display_none @endif"></td>
                                                <td  class="text-right @if($_show_warranty==0) display_none @endif"></td>
                                              
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="{{$_total_qty_amount}}" readonly required>
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif"></td>
                                              <td></td>
                                              
                                              <td class="@if($_show_vat==0) display_none @endif"></td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="{{ $_total_vat_amount}}" readonly required>
                                              </td>
                                              
                                              <td class="@if($_inline_discount==0) display_none @endif"></td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" step="any" min="0" name="_total_discount_amount" class="form-control _total_discount_amount" value="{{$_total_discount_amount}}" readonly required>
                                              </td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="{{$_total_value_amount}}" readonly required>
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                              </td>
                                             
                                               <td class="@if(sizeof($permited_branch) == 1) display_none @endif"></td>
                                              
                                              
                                               <td class="@if(sizeof($permited_costcenters) == 1) display_none @endif"></td>
                                             
                                               <td class="@if(sizeof($store_houses) == 1) display_none @endif"></td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif"></td>
                                             
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        @endif
                      @include('backend.item-replace.replace_item_edit')
                        
                      @if($__user->_ac_type==1)
                      @include('backend.item-replace.edit_ac_cb')
                         
                      @else
                       @include('backend.item-replace.edit_ac_detail')
                      @endif


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
                                     <input type="hidden" name="_master_id" value="{{url('item-replace/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note)}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_sub_total">Sub Total</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="number" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="{{$data->_sub_total}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="number" name="_discount_input" class="form-control width_200_px" id="_discount_input" value="{{$data->_discount_input}}" >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total_discount">Total Discount</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="number" name="_total_discount" class="form-control width_200_px" id="_total_discount" readonly value="{{$data->_total_discount}}">
                              </td>
                            </tr>
                           
                            <tr class=" @if($_show_vat==0) display_none @endif">
                              <td style="border:0px;width: 20%;"><label for="_total_vat">Total VAT</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="number" name="_total_vat" class="form-control width_200_px" id="_total_vat" readonly value="{{$data->_total_vat}}">
                              </td>
                            </tr>
                           
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total">Net Total </label></td>
                              <td style="border:0px;width: 80%;">
                          <input type="number" name="_total" class="form-control width_200_px" id="_total" readonly value="{{_php_round($data->_total ?? 0)}}">
                            <input type="hidden" name="_item_row_count" value="{{sizeof($_master_details)}}" class="_item_row_count">
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

<div class="modal fade" id="barcodeDisplayModal" tabindex="-1" role="dialog" aria-labelledby="barcodeDisplayModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title _barcode_modal_item_name" id="barcodeDisplayModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body _barcode_modal_list_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <form action="{{ url('item-replace-setting')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Replacement Form Settings</h5>
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
@include('backend.common-modal.item_ledger_modal')

@php
      $_string_ids = $form_settings->_cash_customer ?? 0;
      if($_string_ids !=0){
        $_cash_customer = explode(",",$_string_ids);
      }else{
        $_cash_customer =[];
      }
      @endphp

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

var _text_val="";
var _global_unique_barcode =0;
var _item_row_count = parseFloat($(document).find('._item_row_count').val());
$("#_serach_baorce").focus();
 

 

  $(document).on("click","#form_settings",function(){
         setting_data_fetch();
  })

  function setting_data_fetch(){
      var request = $.ajax({
            url: "{{url('item-replace-setting-modal')}}",
            method: "GET",
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_form_setting_info").html(result);
         })
  }

  //Complain Detail search


$(document).on('keyup','._search_order_ref_id',delay(function(e){
    $(document).find('._search_order_ref_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _branch_id = $(document).find('._master_branch_id').val();

  var request = $.ajax({
      url: "{{url('item-replace-order-search')}}",
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
                              <th style="border:1px solid #ccc;text-align:center;">Supplier</th>
                              <th style="border:1px solid #ccc;text-align:center;">Date</th>
                            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_purchase_order" >
                                        <td style="border:1px solid #ccc;">${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i]._ledger_id}">
                                        <input type="hidden" name="_purchase_main_id" class="_purchase_main_id" value="${data[i].id}">
                                        <input type="hidden" name="_purchase_main_date" class="_purchase_main_date" value="${after_request_date__today(data[i]._date)}">
                                        </td><td style="border:1px solid #ccc;">${data[i]._ledger._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._ledger._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        
                                        <input type="hidden" name="_date_main_ledger" class="_date_main_ledger" value="${after_request_date__today(data[i]._date)}">
                                   </td>
                                   <td style="border:1px solid #ccc;">${after_request_date__today(data[i]._date)}
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_purchase_order').html(search_html);
      _gloabal_this.parent('div').find('.search_box_purchase_order').addClass('search_box_show').show();

      _purchase_total_calculation();
      
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


    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
   
    if(_address_main_ledger =='null' ){ _address_main_ledger =""; } 
    if(_phone_main_ledger =='null' ){ _phone_main_ledger =""; } 

    $("._main_ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);
    $("._order_ref_id").val(_purchase_main_id);
    $("._phone").val(_phone_main_ledger);
    $("._address").val(_address_main_ledger);



    $("._search_order_ref_id").val(_purchase_main_id+","+_date_main_ledger);

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var request = $.ajax({
      url: "{{url('item-replace-order-details')}}",
      method: "POST",
      data: { _purchase_main_id,_main_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {
     
      var data = result;
      console.log(data)
      var _purchase_row_single = ``;
      $(document).find("#_old_area__purchase_details").empty();
     
if(data.length > 0 ){
  $('._old_purchase_row').remove();
 
  for (var i = 0; i < data.length; i++) {
   var _item_row_count = (parseFloat(i)+1);
    var _item_name = (data[i]._items._name) ? data[i]._items._name : '' ;
    var _barcode = (data[i]._barcode) ? data[i]._barcode : '' ;
    var _sales_detail_id = (data[i]._sales_detail_id) ? data[i]._sales_detail_id : '' ;
    var _warranty_row_id = (data[i].id) ? data[i].id : '' ;
    var _unique_barcode = (data[i]._items._unique_barcode) ? data[i]._items._unique_barcode : '' ;
    var _item_id = (data[i]._item_id) ? data[i]._item_id : '' ;
    var _warranty_reason = (data[i]._warranty_reason) ? data[i]._warranty_reason : '' ;
    var _qty   = (data[i]._qty  ) ? data[i]._qty   : 0 ;
    var _rate    = (data[i]._rate) ? data[i]._rate    : 0 ;
    var _sales_rate =  (data[i]._sales_rate) ? data[i]._sales_rate    : 0 ;
    var _value = ( (data[i]._qty*data[i]._sales_rate) ) ? (data[i]._qty*data[i]._sales_rate) : 0 ;
    
   

      $(document).find("#_old_area__purchase_details").append(`<tr class="_old_purchase_row">
                                              <td>
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _old_search_item_id width_280_px" placeholder="Item" value="${_item_name}" readonly>
                                                <input type="hidden" name="_old_item_id[]" class="form-control _item_id width_200_px" value="${_item_id}">
                                                <div class="search_box_item">
                                                  
                                                </div>

                                              </td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td>
                                                <input type="text" name="${_item_row_count}_old_barcode__${_item_id}" class="form-control _barcode ${_item_row_count}__barcode " id="${_item_row_count}__barcode" value="${_barcode}"  readonly>
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="${_item_row_count}_old_barcode__${_item_id}" class="form-control _old_barcode ${_item_row_count}__barcode " id="${_item_row_count}__barcode" value="${_barcode}"  readonly>
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _old_qty " value="${_qty}" readonly>
                                                <input type="hidden" name="_old_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _old_sales_rate " value="${_sales_rate}" readonly>
                                                <input type="hidden" name="_old_sales_detail_id[]" class="form-control _old_sales_detail_id " value="${_sales_detail_id}" readonly>
                                                <input type="hidden" name="_warranty_row_id[]" class="form-control _warranty_row_id " value="${_warranty_row_id}" readonly>
                                              </td>
                                              
                                              <td>
                                                <input type="text" name="_warranty_reason[]" class="form-control _old_warranty_reason " readonly value="${_warranty_reason}">
                                              </td>
                                              
                                              
                                            </tr>`);
                                          }

                                        }

            
            
             _purchase_total_calculation();
    })



  })


$(document).on('keyup','#_serach_baorce',function(event){
  event.preventDefault();
  
      _text_val = $(this).val().trim();
      
      if(event.keyCode ==13 || event.which==13){
         _main_item_search(_text_val)
        event.preventDefault();
         // console.log("Press Enter")
          $("._serach_baorce").val('');
          $("._serach_baorce").focus();
      }
  
event.stopPropagation();
});


$(document).on('click','._action_button',function(){
  $(this).closest('td').css({"background":"#fff"})
})

function _main_item_search(_text_val){
  var request = $.ajax({
      url: "{{url('item-sales-barcode-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
  request.done(function( result ) {
console.log("keyup call function and ger data")
console.log(result)
      var search_html =``;
      var data = result.datas; 
      var __this_barcode = result._this_barcode; 
      
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 70%;"><tbody>`;
                  for (var i = 0; i < data.length; i++) {
                    var _barcode_array =[];
                    var __barcode = data[i]._barcode;
                    __barcode = isEmpty(__barcode);
                    if(__barcode !=''){ _barcode_array = __barcode.split(",");}


                search_html += `<tr class="_barcode_search_row_item" >
                <td>${data[i]._master_id}
                <input type="hidden" name="_id_item" class="_id_item" value="${data[i]._item_id}">
                </td><td>${data[i]._name} </td>
                                   
                                   <td>${data[i]._qty}</td>
                                    <td>${data[i]._sales_rate}</td>
                                    `;
                                    if(_barcode_array.length == 1){ //_barcode _array_means it's Model Barcode if item qty is 1 then unique barcode count as model barcode 
                              search_html +=`<td class="text-center">
                                          <table class="table">`;
                                      for (var j = 0; j < _barcode_array.length; j++) {
                                       
                                    var _empty_barcode = isEmpty(_barcode_array[j]);
                                    if(_empty_barcode !=''){
                                      var _remove_barcode_space = _barcode_array[j].replace(/ /g,'');

                                      search_html +=`<tr><td class="_cursor_pointer _barcode_single_item  _barcode_single_item__${data[i].id}__${_remove_barcode_space}" 
                                       _attr__id_item="${data[i]._item_id}" 
                                       _attr__p_item_row_id="${data[i].id}"
                                       _attr__p_item_unique_barcode="${data[i]._unique_barcode}"
                                       _attr__p_item__name="${data[i]._name}"
                                       _attr__p_item_item_id="${data[i]._item_id}"
                                       _attr__p_item__unit_id="${data[i]._unit_id}"
                                       _attr__p_item_barcode="${_barcode_array[j]}"
                                       _attr__p_item_manufacture_date="${data[i]._manufacture_date}"
                                       _attr__p_item_expire_date="${data[i]._expire_date}"
                                       _attr__p_item_sales_rate="${data[i]._sales_rate}"
                                       _attr__p_item_qty="${data[i]._qty}"
                                       _attr__p_item_pur_rate="${data[i]._pur_rate}"
                                       _attr__p_item_sales_discount="${data[i]._sales_discount}"
                                       _attr__p_item_sales_vat="${data[i]._sales_vat}"
                                       _attr__p_item_purchase_detail_id="${data[i]._purchase_detail_id}"
                                       _attr__p_item_master_id="${data[i]._master_id}"
                                       _attr__p_item_warranty="${data[i]._warranty}"
                                       _attr__p_item_branch_id="${data[i]._branch_id}"
                                       _attr__p_item_cost_center_id="${data[i]._cost_center_id}"
                                       _attr__p_item_store_id="${data[i]._store_id}"
                                       _attr__p_item_store_salves_id="${data[i]._store_salves_id}"
                                        >${_barcode_array[j]} <i class="fas fa-plus"></i></td></tr>`;
                                    }
                                       
                                      }
                                           
                             search_html +=` </table></td>`;
                                    }else if(_barcode_array.length > 1){ //_barcode _array_means more then 1 means  it's Unique Barcode and it's qty will be aa 
                              search_html +=`<td class="text-center"><a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__${data[i].id}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i></a>
                                      <div class="collapse" id="collapseExample__${data[i].id}" style="max-height:200px;overflow:scroll;">
                                          <table class="table">`;
                                      for (var j = 0; j < _barcode_array.length; j++) {
                                         var _empty_barcode = isEmpty(_barcode_array[j]);
                                         if(_empty_barcode !=''){
                                          var _remove_barcode_space = _barcode_array[j].replace(/ /g,'');
                                       search_html +=`<tr style="border:1px solid silver;"><td class="_cursor_pointer _barcode_single_item _barcode_single_item__${data[i].id}__${_remove_barcode_space}" 
                                       _attr__id_item="${data[i]._item_id}" 
                                       _attr__p_item_row_id="${data[i].id}"
                                        _attr__p_item_unique_barcode="${data[i]._unique_barcode}"
                                       _attr__p_item__name="${data[i]._name}"
                                       _attr__p_item_item_id="${data[i]._item_id}"
                                       _attr__p_item__unit_id="${data[i]._unit_id}"
                                       _attr__p_item_barcode="${_barcode_array[j]}"
                                       _attr__p_item_manufacture_date="${data[i]._manufacture_date}"
                                       _attr__p_item_expire_date="${data[i]._expire_date}"
                                       _attr__p_item_sales_rate="${data[i]._sales_rate}"
                                       _attr__p_item_qty="1"
                                       _attr__p_item_pur_rate="${data[i]._pur_rate}"
                                       _attr__p_item_sales_discount="${data[i]._sales_discount}"
                                       _attr__p_item_sales_vat="${data[i]._sales_vat}"
                                       _attr__p_item_purchase_detail_id="${data[i]._purchase_detail_id}"
                                       _attr__p_item_master_id="${data[i]._master_id}"
                                       _attr__p_item_warranty="${data[i]._warranty}"
                                       _attr__p_item_branch_id="${data[i]._branch_id}"
                                       _attr__p_item_cost_center_id="${data[i]._cost_center_id}"
                                       _attr__p_item_store_id="${data[i]._store_id}"
                                       _attr__p_item_store_salves_id="${data[i]._store_salves_id}"
                                        >${_barcode_array[j]} <i class="fas fa-plus"></i></td></tr>`;
                                      }
                                    }
                                           
                             search_html +=` </table>
                                      <div></td>`;
                                    }else{
                              search_html +=`<td class="_cursor_pointer text-center _barcode_single_item  _barcode_single_item__${data[i].id}__" 
                                       _attr__id_item="${data[i]._item_id}" 
                                       _attr__p_item_row_id="${data[i].id}"
                                        _attr__p_item_unique_barcode="${data[i]._unique_barcode}"
                                       _attr__p_item__name="${data[i]._name}"
                                       _attr__p_item_item_id="${data[i]._item_id}"
                                       _attr__p_item__unit_id="${data[i]._unit_id}"
                                       _attr__p_item_barcode="${_barcode_array[j]}"
                                       _attr__p_item_manufacture_date="${data[i]._manufacture_date}"
                                       _attr__p_item_expire_date="${data[i]._expire_date}"
                                       _attr__p_item_sales_rate="${data[i]._sales_rate}"
                                       _attr__p_item_qty="${data[i]._qty}"
                                       _attr__p_item_pur_rate="${data[i]._pur_rate}"
                                       _attr__p_item_sales_discount="${data[i]._sales_discount}"
                                       _attr__p_item_sales_vat="${data[i]._sales_vat}"
                                       _attr__p_item_purchase_detail_id="${data[i]._purchase_detail_id}"
                                       _attr__p_item_master_id="${data[i]._master_id}"
                                       _attr__p_item_warranty="${data[i]._warranty}"
                                       _attr__p_item_branch_id="${data[i]._branch_id}"
                                       _attr__p_item_cost_center_id="${data[i]._cost_center_id}"
                                       _attr__p_item_store_id="${data[i]._store_id}"
                                       _attr__p_item_store_salves_id="${data[i]._store_salves_id}" >
                              <i class="fas fa-plus"></i>`;
                                    }
                              search_html +=` </td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        var _message = "Please Search With Unique Barcode";
        var _type = "danger";
        _show_notify_message(_message,_type);


        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      } 

      $(document).find('._main_item_search_box').html(search_html);
      $(document).find('._main_item_search_box').addClass('search_box_show').hide();
      if(data.length >0){
        for (var k = 0; k < data.length; k++) {
          var _barcode_array =[];
            var __barcode = data[k]._barcode;
            var __id = data[k].id;
            __barcode = isEmpty(__barcode);
            if(__barcode !=''){ _barcode_array = __barcode.split(",");} 
             if( _barcode_array.includes(__this_barcode)){
              var _remove_barcode_space = __this_barcode.replace(/ /g,'');
             
              var __class_name = `._barcode_single_item__${__id}__${_remove_barcode_space}`;
                  $(__class_name).click();
                  var _message = __this_barcode +" Item Added ";
                  var _type = "warning";
                  _show_notify_message(_message,_type)
             }
        }
        
      }
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });


} 

$(document).on('click','._clear_icon',function(){
  $("._serach_baorce").val('');
  $(document).find('._main_item_search_box').removeClass('search_box_show').hide();
}) 

$(document).on('click','._barcode_single_item',function(){
      _click_row_and_barcode($(this));
  //$(document).find('._main_item_search_box').removeClass('search_box_show').hide();
})


function _click_row_and_barcode(_click_global_this){
  var _vat_amount =0;
  var row_id = _click_global_this.attr('_attr__p_item_row_id');
  var _name = _click_global_this.attr('_attr__p_item__name');
  var _p_item_item_id = _click_global_this.attr('_attr__p_item_item_id');
  var _unit_id = _click_global_this.attr('_attr__p_item__unit_id');
  var _barcode = _click_global_this.attr('_attr__p_item_barcode');
  var _manufacture_date = _click_global_this.attr('_attr__p_item_manufacture_date');
  var _expire_date = _click_global_this.attr('_attr__p_item_expire_date');
  var _sales_rate = parseFloat(_click_global_this.attr('_attr__p_item_sales_rate'));
  var _qty = parseFloat(_click_global_this.attr('_attr__p_item_qty'));
  var _pur_rate = parseFloat(_click_global_this.attr('_attr__p_item_pur_rate'));
  var _sales_discount = parseFloat(_click_global_this.attr('_attr__p_item_sales_discount'));
  var _sales_vat = parseFloat(_click_global_this.attr('_attr__p_item_sales_vat'));
  var _purchase_detail_id = _click_global_this.attr('_attr__p_item_purchase_detail_id');
  var _master_id = _click_global_this.attr('_attr__p_item_master_id');
  var _branch_id = _click_global_this.attr('_attr__p_item_branch_id');
  var _cost_center_id = _click_global_this.attr('_attr__p_item_cost_center_id');
  var _store_id = _click_global_this.attr('_attr__p_item_store_id');
  var _store_salves_id = _click_global_this.attr('_attr__p_item_store_salves_id');
  var _unique_barcode = _click_global_this.attr('_attr__p_item_unique_barcode');
  var _warranty = _click_global_this.attr('_attr__p_item_warranty');

  _global_unique_barcode =_unique_barcode;


  
 _barcode = isEmpty(_barcode);
 _manufacture_date = isEmpty(_manufacture_date);
 _expire_date = isEmpty(_expire_date);
 _store_salves_id = isEmpty(_store_salves_id);

  
  var _search_item_id_s = $("._search_item_id");
  var _item_id_s = $("._item_id");
  var _p_p_l_id_s = $("._p_p_l_id");
  var _purchase_invoice_no_s = $("._purchase_invoice_no");
  var _purchase_detail_id_s = $("._purchase_detail_id");
  var _barcode_s = $("._barcode");
  var _rate_s = $("._rate");
  var _sales_rate_s = $("._sales_rate");
  var _vat_s = $("._vat");
  var _discount_s = $("._discount");
  var _vat_amount_s = $("._vat_amount");
  var _discount_amount_s = $("._discount_amount");
  var _qty_s = $("._qty");
  var _value_s = $("._value");
  var _store_salves_id_s = $("._store_salves_id");
  var _manufacture_date_s = $("._manufacture_date");
  var _expire_date_s = $("._expire_date");
  var _add_row_or_not = 0;

 //console.log("this row id "+row_id)
    for(var i = 0; i < _p_p_l_id_s.length; i++){
      var _p_p_l_id_s_val = $(_p_p_l_id_s[i]).val();
      //console.log("_p_p_l_id_s_val "+_p_p_l_id_s_val)
  //Remove all extra row where information is not available
      if(_p_p_l_id_s_val ==""){
        _add_row_or_not = 0;
        $(_p_p_l_id_s[i]).closest('tr').remove();
       
      }
    }
  //First check added this row is available yes or not if yes then increase the item qty amount or create new row
      var _has_item_row= $('._p_p_l_id').hasClass('_p_p_l_id__'+row_id); 
      if(_has_item_row ==true){
        console.log(" yes this row is here _global_unique_barcode " + _global_unique_barcode)
        var _old_qty = parseFloat($("._qty__"+row_id).val());

        if(isNaN(_old_qty)){ _old_qty =0 }

        var _barcode__ = $("._barcode__"+row_id).val();
        var _barcode__ =    isEmpty(_barcode__);
        if(_global_unique_barcode ==1){
             if(_barcode__ !=''){
                   var _check_duplicate_barcode = [];
                  var  __barcode___array = _barcode__.split(",");
                   for (var i = 0; i < __barcode___array.length; i++) {
                      if(__barcode___array[i] ==_barcode){
                        var yes_no =   confirm("Do You Want to Remove This Item !");
                        if(yes_no ==true){
                          _check_duplicate_barcode.push(_barcode);
                        }
                      }else{
                          var _old_barcode = $("._barcode__"+row_id).val();
                           var _all_barcode = _old_barcode.trim()+","+_barcode.trim();
                          _qty =   _add_new_barcode(_all_barcode,row_id)
                       var _line_action=   line_total_calculation(row_id,_sales_rate,_pur_rate,_sales_vat,_sales_discount,_qty);
                       if(_line_action ==true){
                          _purchase_total_calculation();
                       }

                          
                      }

                   }

                   //remove from old barcode list 
                  if(_check_duplicate_barcode.length > 0){
                    var _old_barcode = $("._barcode__"+row_id).val();
                    _qty =  barcode_array_to_string(_old_barcode,_barcode,row_id)
                     
                     var _line_action=   line_total_calculation(row_id,_sales_rate,_pur_rate,_sales_vat,_sales_discount,_qty);
                       if(_line_action ==true){ _purchase_total_calculation();  }
                  }




              }else{
                  $("._barcode__"+row_id).val(_barcode);
                  _qty = (_old_qty+1);
                  $("._qty__"+row_id).val(_qty);
                  var _line_action=   line_total_calculation(row_id,_sales_rate,_pur_rate,_sales_vat,_sales_discount,_qty);
                       if(_line_action ==true){
                          _purchase_total_calculation();
                       }
              }
        }else{

             var _old_qty = parseFloat($("._qty__"+row_id).val());
             $("._barcode__"+row_id).val(_barcode);
             _qty = (_old_qty+1);
             $("._qty__"+row_id).val(_qty);
             var _line_action=   line_total_calculation(row_id,_sales_rate,_pur_rate,_sales_vat,_sales_discount,_qty);
             if(_line_action ==true){
                          _purchase_total_calculation();
                       }
        }
        

         
        //Update this row information 
      }else{
        //Add new row for new data entry with all new data
          var  _qty=1; 
          
          if(isNaN(_sales_rate)){ _sales_rate=0 }
          if(isNaN(_pur_rate)){ _pur_rate=0 }
          if(isNaN(_sales_vat)){ _sales_vat=0 }

          _vat_amount = ((_sales_rate*_sales_vat)/100)
          if(isNaN(_sales_discount)){ _sales_discount=0 }
          _discount_amount = ((_sales_rate*_sales_discount)/100);
          var _value = (parseFloat(_qty)*parseFloat(_sales_rate));

        _add_new_row_for_barcode(_warranty,row_id,_name,_p_item_item_id,_unit_id,_barcode,_manufacture_date,_expire_date,_sales_rate,_qty,_pur_rate,_sales_discount,_sales_vat,_purchase_detail_id,_master_id,_branch_id,_cost_center_id,_store_id,_store_salves_id,_sales_vat,_discount_amount,_vat_amount,_value);
        _purchase_total_calculation();
      }
}

function line_total_calculation(row_id,_sales_rate,_pur_rate,_sales_vat,_sales_discount,_qty){
          if(isNaN(_sales_rate)){ _sales_rate=0 }
          if(isNaN(_pur_rate)){ _pur_rate=0 }
          if(isNaN(_sales_vat)){ _sales_vat=0 }

          _vat_amount = ((_sales_rate*_sales_vat)/100)
          if(isNaN(_sales_discount)){ _sales_discount=0 }
          _discount_amount = ((_sales_rate*_sales_discount)/100);
          var _value = (parseFloat(_qty)*parseFloat(_sales_rate));

          $(document).find("._discount__"+row_id).val(_sales_discount);
          $(document).find("._qty__"+row_id).val(_qty);
          $(document).find("._sales_rate__"+row_id).val(_sales_rate);
          $(document).find("._discount_amount__"+row_id).val(_discount_amount);
          $(document).find("._vat__"+row_id).val(_sales_vat);
          $(document).find("._vat_amount__"+row_id).val(_vat_amount);
          $(document).find("._value__"+row_id).val(_value);

          return true;

}

function barcode_array_to_string(_old_barcode,_barcode,row_id){
  console.log("come Here")
  // console.log("_old_barcode "+_old_barcode)
   console.log("_barcode row_id "+row_id)
  var _qtys = 0;
   _old_barcode = isEmpty(_old_barcode);
                    var _to_string_array = [];
                    var ___old_array=[];
                    if(_old_barcode !=''){
                        ___old_array=_old_barcode.split(",");
                        if(___old_array.length > 0){
                          for (var i = 0; i < ___old_array.length; i++) {
                              if(___old_array[i].trim() !=_barcode.trim()){
                                _qtys +=1;
                                  _to_string_array.push(___old_array[i]);
                              }
                          }
                        }
                    }
    $(document).find("._qty__"+row_id).val(_qtys);
    $(document).find("._barcode__"+row_id).val(_to_string_array.toString());
    console.log(" _to_string_array.toString() "+_to_string_array.toString())
    return _qtys;
    
      
}

function _add_new_barcode(_all_barcode,row_id){
  var ___all_barcode =[];
  var __update_barcodes =[];
  var _all_barcode = isEmpty(_all_barcode);
  if(_all_barcode !=''){
     ___all_barcode=_all_barcode.split(",");
      for (var i = 0; i < ___all_barcode.length; i++) {
          __update_barcodes.push(___all_barcode[i]);
      }
  }
  var unique__barcodes = __update_barcodes.filter((v, i, a) => a.indexOf(v) === i);
  console.log("unique__barcodes "+ unique__barcodes)
  $("._barcode__"+row_id).val(unique__barcodes.toString());
  $("._qty__"+row_id).val(unique__barcodes.length);
  return unique__barcodes.length;
}

//Remove Barcode using Modal
  $(document).on('click','.remove_from_barcode_list',function(){
    var _barcode_attr_row_counter = $(this).attr('_barcode_attr_row_counter');
    var _barcode_attr_item_p_p_id = $(this).attr('_barcode_attr_item_p_p_id');
    var _barcode_attr_item_id = $(this).attr('_barcode_attr_item_id');
    var _barcode_attr_barcode = $(this).attr('_barcode_attr_barcode');
    var _barcode = _barcode_attr_barcode;
    var _old_barcode = $("._barcode__"+_barcode_attr_item_p_p_id).val();
    var _sales_rate = $("._sales_rate__"+_barcode_attr_item_p_p_id).val();
    var _sales_vat = $("._vat__"+_barcode_attr_item_p_p_id).val();
    var _sales_discount = $("._discount__"+_barcode_attr_item_p_p_id).val();
    var row_id = _barcode_attr_item_p_p_id;
    var _pur_rate = 0;
   
      _qty =  barcode_array_to_string(_old_barcode,_barcode,row_id)
       var _line_action =   line_total_calculation(row_id,_sales_rate,_pur_rate,_sales_vat,_sales_discount,_qty);
       if(_line_action ==true){ _purchase_total_calculation();  }


    $(this).closest('tr').remove();
    //$("._barcode_modal_button__"+_barcode_attr_row_counter).text(_barcode_new_qty)

    _purchase_total_calculation();

  })


function _add_new_row_for_barcode(_warranty,row_id,_name,_p_item_item_id,_unit_id,_barcode,_manufacture_date,_expire_date,_sales_rate,_qty,_pur_rate,_sales_discount,_sales_vat,_purchase_detail_id,_master_id,_branch_id,_cost_center_id,_store_id,_store_salves_id,_discount_amount,_vat_amount,_value){
  // console.log("_value "+_value)
  // console.log("_qty "+_qty)
  // console.log("_sales_rate "+_sales_rate)
  var _unique_barcode =1;
  var _value_line = parseFloat(parseFloat(_qty)*parseFloat(_sales_rate));
  var _item_row_count = parseFloat($(document).find('._item_row_count').val());
   var _item_row_count = (parseFloat(_item_row_count)+1);

  $("._item_row_count").val(_item_row_count)
  console.log("_unique_barcode "+_unique_barcode)
 

 $("#area__purchase_details").append( `<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                               <td></td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id _search_item_id__${row_id} width_280_px" placeholder="Item" value="${_name}">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id _item_id__${row_id} width_200_px" value="${_p_item_item_id}">
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id _p_p_l_id__${row_id} " value="${row_id}">
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no _purchase_invoice_no__${row_id}" value="${_master_id}" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id _purchase_detail_id__${row_id}" value=${_purchase_detail_id} >
                                                
                                                <div class="search_box_item"></div>
                                              </td>
                                             
                                              <td class="@if($_show_barcode==0) display_none @endif d-flex">
                                                

                                                <input type="text" readonly name="${_item_row_count}__barcode__${row_id}" class="form-control _barcode _barcode__${row_id} ${_item_row_count}__barcode " value="${_barcode}" id="${_item_row_count}__barcode"  >

                                                <div  class="modal __modal_${row_id} _modal_show_class" tabindex="-1" role="dialog" style="display: ${(_global_unique_barcode==1) ? 'contents' : 'none'}">
                                                        <button 
                                                        attr_row_counter="${_item_row_count}" 
                                                        attr_item_name="${_name}" 
                                                        attr_item_id="${_p_item_item_id}" 
                                                        attr_item_p_p_id="${row_id}" 
                                                        attr_item_barcodes="${_barcode}" 

                                                        type="button" class="btn btn-sm btn-default _barcode_modal_button _barcode_modal_button__${_item_row_count}" 
                                                        data-toggle="modal" data-target="#barcodeDisplayModal"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                      </div>

                                                <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                              </td>
                                                <td class="@if($_show_warranty  ==0) display_none @endif">
                                                <select name="_warranty[]" class="form-control _warranty ${_item_row_count}___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _qty__${row_id} _common_keyup" value="${_qty}" >
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif">
                                                <input type="number" name="_rate[]" class="form-control _rate _rate__${row_id} " readonly value="${_pur_rate}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _sales_rate__${row_id} _common_keyup" value="${_sales_rate}" >
                                              </td>
                                               
                                                <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" name="_vat[]" class="form-control  _vat _vat__${row_id} _common_keyup" value="${_sales_vat}" >
                                              </td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount _vat_amount__${row_id}" value="${_vat_amount}" >
                                              </td>
                                                <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" name="_discount[]" class="form-control  _discount _discount__${row_id} _common_keyup" value="${_sales_discount}" >
                                              </td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount _discount_amount__${row_id}" value="${_discount_amount}" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value _value__${row_id} " readonly value="${_value_line}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date__${row_id} _manufacture_date " value="${_manufacture_date}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date__${row_id} _expire_date " value="${_expire_date}" >
                                              </td>
                                              
                                              <td class="@if(sizeof($permited_branch) == 1) display_none @endif ">
                                                <select class="form-control  _main_branch_id_detail__${row_id} _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                               <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control  _main_cost_center__${row_id} _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                             
                                              <td class="@if(sizeof($store_houses)==1) display_none @endif">
                                                <select class="form-control  _main_store_id__${row_id} _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}" >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id _store_salves_id__${row_id} " value="${_store_salves_id}" >
                                              </td>
                                              
                                              
                                            </tr>`);

$("."+_item_row_count+"___warranty").val(_warranty);


_purchase_total_calculation();

}


$(document).on("click",'._barcode_modal_button',function(){
    var attr_row_counter = $(this).attr('attr_row_counter');
    var attr_item_name = $(this).attr('attr_item_name');
    var attr_item_id = $(this).attr('attr_item_id');
    var attr_item_p_p_id = $(this).attr('attr_item_p_p_id');
    //var attr_item_barcodes = $(this).attr('attr_item_barcodes');
    var attr_item_barcodes = $("._barcode__"+attr_item_p_p_id).val();
    $(document).find('._barcode_modal_item_name').text(attr_item_name);
    attr_item_barcodes  = isEmpty(attr_item_barcodes);
    var after_add_remove = $("._barcode__"+attr_row_counter).val();
    after_add_remove  = isEmpty(after_add_remove);
      var _single_barcode_array =[];
      var after_add_remove_barcode_array =[];
      if(attr_item_barcodes !=''){ _single_barcode_array = attr_item_barcodes.split(",");}

       var search_html =`<table class="table">`;
      for (var j = 0; j < _single_barcode_array.length; j++) {

                                       search_html +=`<tr style="border:1px solid silver;"><td class="_cursor_pointer  " 
                                        >${_single_barcode_array[j]}</td>
                                        <td>
                                        <button _barcode_attr_row_counter="${attr_row_counter}" 
                                       _barcode_attr_item_p_p_id="${attr_item_p_p_id}" 
                                       _barcode_attr_barcode="${_single_barcode_array[j]}" 
                                       _barcode_attr_item_id="${attr_item_id}" class="btn btn-sm btn-danger remove_from_barcode_list" >X</button>`;
                                      
                                     search_html +=`</td>
                                        </tr>`;
                                      } 
      search_html +=`</table>`;
    $(document).find("._barcode_modal_list_body").html(search_html);
  })

  
  

  $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-sales-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i]._master_id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i]._item_id}">
                                        </td><td>${data[i]._name}
                      <input type="hidden" name="_p_item_row_id" class="_p_item_row_id" value="${data[i].id}">
                      <input type="hidden" name="_p_item_name" class="_p_item__name" value="${data[i]._name}">
                      <input type="hidden" name="_p_item_item_id" class="_p_item_item_id" value="${data[i]._item_id}">
                      <input type="hidden" name="_p_item__unit_id" class="_p_item__unit_id" value="${data[i]._unit_id}">
                      <input type="hidden" name="_p_item_barcode" class="_p_item_barcode" value="${data[i]._barcode}">
  <input type="hidden" name="_p_item_manufacture_date" class="_p_item_manufacture_date" value="${data[i]._manufacture_date}">
  <input type="hidden" name="_p_item_expire_date" class="_p_item_expire_date" value="${data[i]._expire_date}">
  <input type="hidden" name="_p_item_sales_rate" class="_p_item_sales_rate" value="${data[i]._sales_rate}">
  <input type="hidden" name="_p_item_qty" class="_p_item_qty" value="${data[i]._qty}">
  <input type="hidden" name="_p_item_pur_rate" class="_p_item_pur_rate" value="${data[i]._pur_rate}">
  <input type="hidden" name="_p_item_sales_discount" class="_p_item_sales_discount" value="${data[i]._sales_discount}">
  <input type="hidden" name="_p_item_sales_vat" class="_p_item_sales_vat" value="${data[i]._sales_vat}">
  <input type="hidden" name="_p_item_purchase_detail_id" class="_p_item_purchase_detail_id" value="${data[i]._purchase_detail_id}">
  <input type="hidden" name="_p_item_master_id" class="_p_item_master_id" value="${data[i]._master_id}">
  <input type="hidden" name="_p_item_branch_id" class="_p_item_branch_id" value="${data[i]._branch_id}">
  <input type="hidden" name="_p_item_cost_center_id" class="_p_item_cost_center_id" value="${data[i]._cost_center_id}">
  <input type="hidden" name="_p_item_store_id" class="_p_item_store_id" value="${data[i]._store_id}">
  <input type="hidden" name="_p_item_store_salves_id" class="_p_item_store_salves_id" value="${data[i]._store_salves_id}">
  <input type="hidden" name="_p_item_warranty" class="_p_item_warranty" value="${data[i]._warranty}">
                                   </td>
                                   
                                   <td>${data[i]._qty}</td>
                                    <td>${data[i]._sales_rate}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var row_id = $(this).find('._p_item_row_id').val();
  var _name = $(this).find('._p_item__name').val();
  var _p_item_item_id = $(this).find('._p_item_item_id').val();
  var _unit_id = $(this).find('._p_item__unit_id').val();
  var _barcode = $(this).find('._p_item_barcode').val();
  var _manufacture_date = $(this).find('._p_item_manufacture_date').val();
  var _expire_date = $(this).find('._p_item_expire_date').val();
  var _sales_rate = parseFloat($(this).find('._p_item_sales_rate').val());
  var _qty = $(this).find('._p_item_qty').val();
  var _pur_rate = $(this).find('._p_item_pur_rate').val();
  var _sales_discount = $(this).find('._p_item_sales_discount').val();
  var _sales_vat = $(this).find('._p_item_sales_vat').val();
  var _purchase_detail_id = $(this).find('._p_item_purchase_detail_id').val();
  var _master_id = $(this).find('._p_item_master_id').val();
  var _branch_id = $(this).find('._p_item_branch_id').val();
  var _cost_center_id = $(this).find('._p_item_cost_center_id').val();
  var _store_id = $(this).find('._p_item_store_id').val();
  var _store_salves_id = $(this).find('._p_item_store_salves_id').val();
  var _warranty = $(this).find('._p_item_warranty').val();


  if(_barcode=='null'){ _barcode='' } 
  if(_store_salves_id=='null'){ _store_salves_id='' } 
  if(isNaN(_sales_rate)){ _sales_rate=0 }
  if(isNaN(_pur_rate)){ _pur_rate=0 }
  if(isNaN(_sales_vat)){ _sales_vat=0 }
  _vat_amount = ((_sales_rate*_sales_vat)/100)
  if(isNaN(_sales_discount)){ _sales_discount=0 }
  _discount_amount = ((_sales_rate*_sales_discount)/100);
  
var find_counter_id = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
var _new_name_for_barcode = `${find_counter_id}__barcode__${row_id}`;
$(this).parent().parent().parent().parent().parent().parent().find('.'+find_counter_id+"__barcode").attr('name',_new_name_for_barcode); 
  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_p_item_item_id);
  var _id_name = `${_master_id} ,${_name}, ${_qty}`;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._p_p_l_id').val(row_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._purchase_invoice_no').val(_master_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._purchase_detail_id').val(_purchase_detail_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').val(_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_pur_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_sales_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat_amount').val(_vat_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._discount').val(_sales_discount);
  $(this).parent().parent().parent().parent().parent().parent().find('._discount_amount').val(_discount_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._store_salves_id').val(_store_salves_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._manufacture_date').val(_manufacture_date);
  $(this).parent().parent().parent().parent().parent().parent().find('._expire_date').val(_expire_date);
  $(this).parent().parent().parent().parent().parent().parent().find('._warranty').val(_warranty);
var _search_item_id="_search_item_id__"+row_id;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').addClass(_search_item_id)


  _purchase_total_calculation();
  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();
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
      $(document).find("._vat_amount").each(function() {
            var _s_vat =parseFloat($(this).val());
            if(isNaN(_s_vat)){_s_vat = 0}
          _total__vat +=parseFloat(_s_vat);
      });
      $(document).find("._discount_amount").each(function() {
            var _s_discount_amount =parseFloat($(this).val());
            if(isNaN(_s_discount_amount)){_s_discount_amount = 0}
          _total_discount_amount +=parseFloat(_s_discount_amount);
      });

      var _old_sales_rate = $(document).find("._old_sales_rate").val();
      _old_sales_rate  = parseFloat(_old_sales_rate);
      if(isNaN(_old_sales_rate)){_old_sales_rate=0}


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
      $("#_total").val(_total-_old_sales_rate);
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" @if($__user->_ac_type==1) attr_account_head_no="1" @endif  class="form-control _search_ledger_id width_280_px" placeholder="Ledger"   >
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      
                      <td class="@if(sizeof($permited_branch) == 1) display_none @endif ">
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                       

                         
                        <td class="@if(sizeof($permited_costcenters) == 1) display_none @endif ">
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            <td>
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td class=" @if($__user->_ac_type==1) display_none @endif ">
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $("#area__voucher_details").append(single_row);
  }


function purchase_row_add(event){
   event.preventDefault();
   var _item_row_count = parseFloat($(document).find('._item_row_count').val());
   var _item_row_count = (parseFloat(_item_row_count)+1);
  $("._item_row_count").val(_item_row_count)

      $("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                               <td></td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" >
                                                <input type="hidden" name="_sales_detail_row_id[]" class="form-control _sales_detail_row_id " value="0" >
                                               
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                             
                                              <td class="@if($_show_barcode==0) display_none @endif">
                                              

                                                <input type="text" readonly name="_barcode[]" class="form-control _barcode  ${_item_row_count}__barcode " value="" id="${_item_row_count}__barcode"  >

                                                <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                              </td>
                                                <td class="@if($_show_warranty  ==0) display_none @endif">
                                                <select name="_warranty[]" class="form-control _warranty ${_item_row_count}___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
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
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" >
                                              </td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount" >
                                              </td>
                                                <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" >
                                              </td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " >
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
                                              
                                              
                                            </tr>`);

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

     var _serach_baorce = $("#_serach_baorce").val()
    if(_serach_baorce){
      return false;
    }

    var _p_p_l_ids_qtys = new Array();
     var _only_p_ids = [];
     var empty_qty = [];
      var _id_and_qtys = [];

    $(document).find('._p_p_l_id').each(function(index){
     var _p_id =  $(this).val();
     var _p_qty = $(document).find('._qty').eq(index).val();
     if(isNaN(_p_qty)){
        empty_qty.push(_p_id);
     }
     _only_p_ids.push(_p_id);
      _p_p_l_ids_qtys.push( {_p_id: _p_id, _p_qty: _p_qty});
     

    })
     var unique_p_ids = [...new Set(_only_p_ids)];
     var _stop_sales =0;
    if(_p_p_l_ids_qtys.length > 0){
        var request = $.ajax({
                url: "{{url('check-available-qty-update')}}",
                method: "GET",
                async:false,
                data: { _p_p_l_ids_qtys,unique_p_ids },
                dataType: "JSON"
              });
               
              request.done(function( result ) {
                console.log(result);
                $("._search_item_id").removeClass('_required');
                  if(result.length > 0){
                     for (var i = 0; i < result.length; i++) {
                      $("._search_item_id__"+result[i]).addClass('_required'); 
                     }
                   _stop_sales=1;
                  }else{
                    $("._search_item_id__"+result[i]).removeClass('_required') 
                     $(document).find("._over_qty").text('');
                  }
              })
    }
    if(_stop_sales ==1){
        alert(" You Can not Sales More then Available Qty  ");
       var _message =" You Can not Sales More then Available Qty";
        $(document).find("._over_qty").text(_message);
        $(".remove_area").hide();
      return false;
    }

 
    
   
    var _total_dr_amount = $(document).find("._total_dr_amount").val();
    var _total_cr_amount = $(document).find("._total_cr_amount").val();
    var _voucher_type = $(document).find('._voucher_type').val();
    var _note = $(document).find('._note').val();
    var _main_ledger_id = $(document).find('._main_ledger_id').val();
    var _order_ref_id = $(document).find('._order_ref_id').val();



    if(_main_ledger_id  ==""){
       alert(" Please Add Ledger  ");
        $(document).find('._search_main_ledger_id').addClass('required_border').focus();
        return false;
    }
    if(_order_ref_id  ==""){
       alert(" Please Add Complain Number  ");
        $(document).find('._search_order_ref_id').addClass('required_border').focus();
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
   



@if($__user->_ac_type==0)
    if( parseFloat(_total_dr_amount) !=parseFloat(_total_cr_amount)){
      $(document).find("._total_dr_amount").addClass('required_border').focus();
      $(document).find("._total_cr_amount").addClass('required_border').focus();
       alert("Account Details Dr. And Cr. Amount Not Equal");
      return false;

    }
@endif

//Cash Customer Can not Sale without payment Start
var _cash_customers = <?php echo json_encode($_cash_customer); ?>;
if(_cash_customers.length > 0){
  var _total_dr_amount = $(document).find('._total_dr_amount').val();
  var _total = $(document).find('#_total').val();
  var _main_ledger_id = $(document).find('#_main_ledger_id').val();
  var check_cash_customer = 0;
  for (var i = 0; i < _cash_customers.length; i++) {
      if(_main_ledger_id ==_cash_customers[i]){
        check_cash_customer =1;
          break;
      }
  }
  if(check_cash_customer ==1){
    if(Math.round(_total_dr_amount) !=Math.round(_total)){
        $(document).find("._total_dr_amount").addClass('required_border').focus();
        alert(" You have to pay full Amount  ");
        return false;
    }
  }

} //Cash Customer Can not Sale without payment End

   if(_note ==""){
       $(document).find('._note').focus().addClass('required_border');
      return false;
    }else if(_main_ledger_id ==""){
       
      $(document).find('._search_main_ledger_id').focus().addClass('required_border');
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

