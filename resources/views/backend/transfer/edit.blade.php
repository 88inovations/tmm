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
            <a class="m-0 _page_name" href="{{ route('transfer.index') }}">{!! $page_name ?? '' !!} </a>
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
                @can('transfer-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('transfer.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php
    
    $_show_barcode = $form_settings->_show_barcode ?? 0;
    $_show_cost_rate =  $form_settings->_show_cost_rate ?? 0;
    $_show_self = $form_settings->_show_self ?? 0;
    $_show_warranty = $form_settings->_show_warranty ?? 0;
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
               <form action="{{url('transfer/update')}}" method="POST" class="purchase_form" >
                @csrf
                    <div class="row">
                      <input type="hidden" name="id" value="{{$data->id}}" class="_main_id">
                       <div class="col-xs-12 col-sm-12 col-md-4">
                        <input type="hidden" name="_form_name" class="_form_name"  value="transfer">
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
                        
                        
@php
              $users = \Auth::user();
              $permited_organizations = permited_organization(explode(',',$users->organization_ids));
              @endphp 
              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{!! __('label.from_organization') !!}:<span class="_required">*</span></label>
                  <select class="form-control " name="_from_organization_id" required >
                     @forelse($permited_organizations as $val )
                     <option value="{{$val->id}}" @if(isset($data->_from_organization_id)) @if($data->_from_organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>From Branch:<span class="_required">*</span></label>
                               <select class="form-control" name="_from_branch" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_from_branch)) @if($data->_from_branch == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>From Cost Center:<span class="_required">*</span></label>
                               <select class="form-control" name="_from_cost_center" required >
                                  
                                  @forelse($permited_costcenters as $cost_center )
                                  <option value="{{$cost_center->id}}" @if(isset($data->_from_cost_center)) @if($data->_from_cost_center == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        @php
                        $_types = [$data->_type];
                        @endphp
                        <div class="col-xs-12 col-sm-12 col-md-4 " >
                            <div class="form-group ">
                                <label>Type:<span class="_required">*</span></label>
                               <select class="form-control" name="_type" required >
                                  <option value="{{$data->_type}}">{{$data->_type}}</option>
                                  
                                </select>
                            </div>
                        </div>
                         @php
                          $all_organizations = \DB::table('companies')->select('id','_name')->where('_status',1)->get();
                          $all_branch = \DB::table('branches')->select('id','_name')->where('_status',1)->get();
                          $all_costcenters = \DB::table('cost_centers')->select('id','_name')->where('_status',1)->get();
                          @endphp
                         <div class="col-xs-12 col-sm-12 col-md-2 " >
                          
                            <div class="form-group ">
                                <label>{{__('label.to_organization')}}:<span class="_required">*</span></label>
                               <select class="form-control" name="_to_organization_id" required >
                                  
                                  @forelse($all_organizations as $organization )
                                  <option value="{{$organization->id}}" @if(isset($data->_to_organization_id)) @if($data->_to_organization_id == $organization->id) selected @endif   @endif>{{ $organization->id ?? '' }} - {{ $organization->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-2 " >
                          
                            <div class="form-group ">
                                <label>To Branch:<span class="_required">*</span></label>
                               <select class="form-control" name="_to_branch" required >
                                  
                                  @forelse($all_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_to_branch)) @if($data->_to_branch == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>To Cost Center:<span class="_required">*</span></label>
                               <select class="form-control" name="_to_cost_center" required >
                                  
                                  @forelse($all_costcenters as $cost_center )
                                  <option value="{{$cost_center->id}}" @if(isset($data->_to_cost_center)) @if($data->_to_cost_center == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-8 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance',$data->_reference)}}" placeholder="Referance" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 " >
                            <div class="form-group ">
                                <label>ID:</label>
                               <input type="text" name="" readonly value="{{$data->id}}" class="form-control">
                            </div>
                        </div>
                        @php


                        $___stock_in = $data->_stock_in ?? [];
                        $___stock_out = $data->_stock_out ?? [];
                        @endphp
                        
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Stock Out</strong>
                                
                               
                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >SL</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left display_none" >Base Unit</th>
                                            <th class="text-left display_none" >Con. Qty</th>
                                            <th class="text-left @if(isset($form_settings->_show_unit)) @if($form_settings->_show_unit==0) display_none    @endif @endif" >Tran. Unit</th>
                                          
                                            <th class="text-left @if($_show_barcode  ==0) display_none @endif" >Barcode</th>
                                            <th class="text-left @if($_show_warranty  ==0) display_none @endif" >Warranty</th>
                                            
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left @if($_show_cost_rate  ==0) display_none @endif" >Cost</th>
                                            <th class="text-left" >Sales Rate</th>
                                            
                                            <th class="text-left" >Value</th>

                                            <th class="text-middle @if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none @endif
                                            @endif" >Manu. Date</th>
                                             <th class="text-middle @if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none @endif
                                            @endif"> Expired Date </th>
                                           
                                            <th class="text-left  @if(sizeof($permited_branch)  ==1) display_none @endif " >Branch</th>
                                            
                                            
                                             <th class="text-left  @if(sizeof($permited_costcenters)  ==1) display_none @endif " >Cost Center</th>
                                            
                                             
                                             <th class="text-left @if(sizeof($store_houses) ==1) display_none @endif" >Store</th>
                                           
                                            
                                             <th class="text-left  @if($_show_self  ==0) display_none @endif " >Shelf</th>
                                           
                                           
                                          </thead>
                                          @php
                                          $_stock_out_qty = 0;
                                          $_stock_out_total = 0;
                                          @endphp
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @if(sizeof($___stock_out) > 0)
                                            @forelse($___stock_out as $key=>$detail)

                                            @php
                                          $_stock_out_qty +=$detail->_qty ?? 0;
                                          $_stock_out_total +=$detail->_value ?? 0;
                                          @endphp
                                            <tr class="_purchase_row _purchase_row__">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                {{ $detail->id }}
                                                <input type="hidden" name="_purchase_detail_id[]" value="{{ $detail->id }}" class="form-control _purchase_detail_id" >
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{_item_name($detail->_item_id)}}">

                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " value="{{$detail->_item_id}}" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id "  value="{{$detail->_p_p_l_id}}"  >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" value="{{$detail->_purchase_invoice_no}}">
                                                
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>

                                              <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="{{$detail->_units->id}}" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="{{ $detail->_units->_name}}" />
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="{!! $detail->_base_rate ?? 0 !!}" >
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="{{$detail->_unit_conversion ?? 1}}" readonly>
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                  @php
                                                  $own_unit_conversions = $detail->unit_conversion ?? [];
                                                  @endphp
                                                  @forelse($own_unit_conversions as $conversionUnit)
                                                  <option value="{{$conversionUnit->_conversion_unit}}"  
                                                attr_base_unit_id="{{$conversionUnit->_base_unit_id}}" 
                                                attr_conversion_qty="{{$conversionUnit->_conversion_qty}}" 
                                                attr_conversion_unit="{{$conversionUnit->_conversion_unit}}" 
                                                attr_item_id="{{$conversionUnit->_item_id}}"
                                                @if($detail->_transection_unit ==$conversionUnit->_conversion_unit) selected  @endif

                                                 >{{ $conversionUnit->_conversion_unit_name ?? '' }}
                                               </option>
                                                @empty
                                                @endforelse

                                                </select>
                                              </td>
                                             
                                              <td class=" @if($_show_barcode  ==0) display_none @endif ">
                                               
                                                <input type="text" name="_barcode_[]" class="form-control _barcode {{($key+1)}}__barcode"  value="{{$detail->_barcode ?? '' }}" id="{{($key+1)}}__barcode" readonly >
                                                <input type="hidden" name="_ref_counter[]" value="{{($key+1)}}" class="_ref_counter" id="{{($key+1)}}__ref_counter">
                                              </td>
                                              <td  class="@if($_show_warranty  ==0) display_none @endif" >
                                                <select name="_warranty[]" class="form-control _warranty 1___warranty">
                                                   <option value="0">--Select --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" @if($_warranty->id==$detail->_warranty) selected @endif >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup"  value="{{$detail->_qty}}">
                                              </td>
                                              <td class=" @if($_show_cost_rate ==0) display_none @endif " >
                                                <input type="number" name="_rate[]" class="form-control _rate  " value="{{$detail->_rate}}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup " value="{{$detail->_sales_rate}}" >
                                              </td>
                                              
                                              
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly value="{{$detail->_value}}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " value="{{_view_date_formate($detail->_manufacture_date)}}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " value="{{_view_date_formate($detail->_expire_date)}}"  >
                                              </td>
                                            
                                               <td class="@if(sizeof($permited_branch) == 1) display_none @endif ">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                             
                                             
                                               <td class=" @if(sizeof($permited_costcenters) == 1) display_none @endif " >
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            
                                              <td class=" @if(sizeof($store_houses) == 1) display_none @endif ">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}" @if($detail->_store_id==$store->id) selected @endif >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                             
                                             
                                              <td class=" @if($_show_self==0) display_none @endif ">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="{{$detail->_store_salves_id ?? '' }}">
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
                                              <td colspan="2"  class="text-right"><b>Total</b></td>
                                              <td class="display_none"></td>
                                              <td class="display_none"></td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif"></td>
                                              
                                                <td  class="text-right @if($_show_barcode==0) display_none @endif"></td>
                                                <td  class="text-right @if($_show_warranty==0) display_none @endif"></td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="{{$_stock_out_qty}}" readonly required>
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif"></td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="{{$_stock_out_total}}" readonly required>
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

                        
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Stock In</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <tr>
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >Item</th> 
                                            <th class="text-left display_none" >Base Unit</th>
                                            <th class="text-left display_none" >Con. Qty</th>
                                            <th class="text-left @if(isset($form_settings->_show_unit)) @if($form_settings->_show_unit==0) display_none    @endif @endif" >Tran. Unit</th>
                                           
                                            <th class="text-left @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==0) display_none    @endif @endif" >Barcode</th>
                                         
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left" >Rate</th>
                                            <th class="text-left" >Sales Rate</th>
                                           
                                            
                                          

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
                                             
                                            <th class="text-left" >Store</th>
                                            
                                             
                                             <th class="text-left @if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none @endif
                                            @endif" >Manu. Date</th>
                                             <th class="text-left @if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none @endif
                                            @endif"> Expired Date </th>
                                            <th class="text-left @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==0) display_none @endif
                                            @endif" >Shelf</th>
                                            </tr>
                                           
                                          </thead>
                                          @php
                                            $_stock_in_qty_total=0;
                                            $_stock_in_total_amount=0;
                                          @endphp
                                          <tbody class="area__purchase_details" id="_stock_in_area__purchase_details">
                                            @if(sizeof( $___stock_in)> 0)
                                            @forelse($___stock_in as $key=>$detail)
                                            @php
                                            $_stock_in_qty_total +=$detail->_qty ?? 0 ;
                                            $_stock_in_total_amount +=$detail->_value ?? 0 ;
                                          @endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>{{$detail->id ?? ''}}</td>
                                              <td>
                                                <input type="text" name="_stock_in__search_item_id[]" class="form-control _stock_in__search_item_id width_280_px" placeholder="Item" value="{{ _item_name($detail->_item_id ?? '') }}">
                                                 <input type="hidden" name="_stock_in__item_id[]" class="form-control _stock_in__item_id width_200_px" value="{{$detail->_item_id ?? ''}}">
                                                <input type="hidden" name="_stock_in__p_p_l_id[]" class="form-control _stock_in__p_p_l_id "   value="{{$detail->id ?? ''}}">
                                                <input type="hidden" name="_stock_in__purchase_invoice_no[]" class="form-control _stock_in__purchase_invoice_no"  value="{{$detail->_purchase_invoice_no ?? ''}}"  >
                                                <input type="hidden" name="_stock_in__purchase_detail_id[]" class="form-control _stock_in__purchase_detail_id" value="{{$detail->id ?? ''}}" >
                                                <div class="_stock_in_search_box_item">
                                                  
                                                </div>
                                              </td>

                                              <td class="display_none">
                                                <input type="hidden" class="form-control _stock_in_base_unit_id width_100_px" name="_stock_in_base_unit_id[]" value="{{$detail->_units->id ?? 1 }}" />
                                                <input type="text" class="form-control _stock_in_main_unit_val width_100_px" readonly name="_stock_in_main_unit_val[]" value="{{ $detail->_units->_name ?? ''}}" />
                                                <input type="hidden" name="_stock_in_base_rate[]" class="form-control _stock_in_base_rate _common_keyup" value="{!! $detail->_base_rate ?? 0 !!}" >
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_stock_inconversion_qty[]" min="0" step="any" class="form-control _stock_inconversion_qty " value="{{$detail->_unit_conversion ?? 1}}" readonly>
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _stock_in_transection_unit" name="_stock_in_transection_unit[]">
                                                  @php
                                                  $own_unit_conversions = $detail->unit_conversion ?? [];
                                                  @endphp
                                                  @forelse($own_unit_conversions as $conversionUnit)
                                                  <option value="{{$conversionUnit->_conversion_unit}}"  
                                                attr_base_unit_id="{{$conversionUnit->_base_unit_id}}" 
                                                attr_conversion_qty="{{$conversionUnit->_conversion_qty}}" 
                                                attr_conversion_unit="{{$conversionUnit->_conversion_unit}}" 
                                                attr_item_id="{{$conversionUnit->_item_id}}"
                                                @if($detail->_transection_unit ==$conversionUnit->_conversion_unit) selected  @endif

                                                 >{{ $conversionUnit->_conversion_unit_name ?? '' }}
                                               </option>
                                                @empty
                                                @endforelse

                                                </select>
                                              </td>
                                                 
                                              
                                             
                                              
                                              <td class="@if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==0) display_none   @endif @endif">
                                                <input type="text" name="_stock_in__barcode[]" class="form-control _stock_in__barcode {{($key+1)}}___stock_in_barcode "  id="{{($key+1)}}___stock_in_barcode" value="{{$detail->_barcode ?? '' }}">

                                                <input type="hidden" name="_stock_in__ref_counter[]" value="{{($key+1)}}" class="_stock_in__ref_counter" id="{{($key+1)}}___stock_in_ref_counter">

                                              </td>
                                            
                                              <td>
                                                <input type="number" name="_stock_in__qty[]" class="form-control _stock_in__qty _stock_in_common_keyup" value="{{ $detail->_qty ?? 0 }}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__rate[]" class="form-control _stock_in__rate _stock_in_common_keyup" value="{{ $detail->_rate ?? 0 }}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__sales_rate[]" class="form-control _stock_in__sales_rate " value="{{ $detail->_sales_rate ?? 0 }}" >
                                              </td>
                                             
                                             
                                             
                                              <td>
                                                <input type="number" name="_stock_in__value[]" class="form-control _stock_in__value " readonly value="{{ $detail->_value ?? 0 }}" >
                                              </td>
                                            @if(sizeof($permited_branch) > 1)  
                                              <td>
                                                <select class="form-control  _stock_in__main_branch_id_detail" name="_stock_in__main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                <select class="form-control  _stock_in__main_branch_id_detail" name="_stock_in__main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                                <td>
                                                 <select class="form-control  _stock_in__main_cost_center" name="_stock_in__main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                 <select class="form-control  _stock_in__main_cost_center" name="_stock_in__main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                             
                                              <td>
                                                <select class="form-control  _stock_in__main_store_id" name="_stock_in__main_store_id[]">
                                                  @forelse($_all_store_houses as $store)
                                                  <option value="{{$store->id}}" @if($detail->_store_id==$store->id) selected @endif >{{$store->_name ?? '' }}/{{$store->_branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                              
                                              
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_stock_in__manufacture_date[]" class="form-control _stock_in__manufacture_date "  value="{{ _view_date_formate( $detail->_manufacture_date ?? '') }}" >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_stock_in__expire_date[]" class="form-control _stock_in__expire_date " value="{{ _view_date_formate($detail->_expire_date ?? '') }}"  >
                                              </td>
                                             <td class="@if(isset($form_settings->_show_self)) @if($form_settings->_show_self==0) display_none  @endif @endif">
                                                <input type="text" name="_stock_in__store_salves_id[]" class="form-control _stock_in__store_salves_id " value="{{$detail->_store_salves_id ?? '' }}" >
                                              </td>
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                            @endif
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="_stock_in_purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="2"  class="text-right"><b>Total</b></td>
                                              <td class="display_none"></td>
                                              <td class="display_none"></td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif"></td>

                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right display_none"></td>
                                             @endif
                                            @endif
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _stock_in__total_qty_amount" value="{{$_stock_in_qty_total}}" readonly required>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _stock_in__total_value_amount" value="{{$_stock_in_total_amount}}" readonly required>
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
                                              
                                              <td></td>
                                              

                                              
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif  @endif"></td>

                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif  @endif"></td>

                                              <td class="@if(isset($form_settings->_show_self)) @if($form_settings->_show_self==0) display_none  @endif  @endif"></td>
                                              
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
                                     <input type="hidden" name="_master_id" value="{{url('transfer/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '')}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_p_status">Status</label></td>
                              <td style="border:0px;width: 80%;">
                                @php
                                $_p_statues = \DB::table("production_status")->get();
                                @endphp
                                
                               <select class="form-control" name="_p_status" required >
                                  
                                  @forelse($_p_statues as $_statues )
                                  <option value="{{$_statues->id}}" @if(isset($data->_p_status)) @if($data->_p_status == $_statues->id) selected @endif   @endif> {{ $_statues->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                              </td>
                            </tr>
                           
                           
                           
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total">Stock Out Total </label></td>
                              <td style="border:0px;width: 80%;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="{{ $data->_total ?? 0 }}">
                           <input type="hidden" name="_item_row_count" value="{{sizeof($___stock_out)}}" class="_item_row_count">
                           <input type="hidden" name="_stock_in__item_row_count" value="{{sizeof($___stock_in)}}" class="_stock_in__item_row_count">
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_stock_in__total">Stock In Total </label></td>
                              <td style="border:0px;width: 80%;">
                          <input type="text" name="_stock_in__total" class="form-control width_200_px" id="_stock_in__total" readonly value="{{$data->_stock_in__total ?? 0}}">
                              </td>
                            </tr>
                            
                              
                            
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
    <form action="{{ url('production-form-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Production/Transfer Form Settings</h5>
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
@include('backend.transfer.stock_out_script')
@include('backend.transfer.stock_in_script')
@endsection

