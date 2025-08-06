
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
            <a class="m-0 _page_name" href="{{ route('sales-order.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">

               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <a target="__blank" href="{{url('sales-order/print')}}/{{$data->id}}" class="btn btn-sm btn-warning"> <i class="nav-icon fas fa-print"></i> </a>
                  
                
               </li>
               @endcan
               @include('backend.common-modal.item_ledger_sub_link')
                
               
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('sales-order.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
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
                    
              </div>
             
              <div class="card-body">
               <form action="{{url('sales-order/update')}}" method="POST" class="purchase_form" >
                @csrf
                      <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                          <input type="hidden" name="_form_name" class="_form_name" value="sales_orders">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_date)}}"  />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" name="id" value="{{$data->id}}">
                        </div>

                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Order Number:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number',$data->_order_number)}}" placeholder="Order Number" readonly>
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_delivery_date">{{__('label._delivery_date')}}:</label>
                              <input type="date" id="_delivery_date" name="_delivery_date" class="form-control _delivery_date" value="{{old('_delivery_date',$data->_delivery_date ?? '')}}"   >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 display_none">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Purchase Order:</label>
                              <input type="text" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id)}}" placeholder="Purchase Order" >
                                
                            </div>
                        </div>
                      @include('basic.org_edit')
 @php
$user_type = $auth_user->user_type ?? '';
                @endphp
                @if($user_type !='admin')
                <div class="col-xs-12 col-sm-12 col-md-2 ">
                    <div class="form-group">
                      <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                      <select class="form-control _sales_man" name="_sales_man_id">
                        <option value="{{$data->_sales_man_id ?? '' }}">{{ _ledger_name($data->_sales_man_id ?? '') }}</option>
                      </select>
                      
                    </div>
                </div>
                @else

                 <div class="col-xs-12 col-sm-12 col-md-2 ">
                    <div class="form-group">
                      <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                      <select class="form-control _sales_man" name="_sales_man_id">
                        <option value="{{$data->_sales_man_id ?? ''}}">{{ _ledger_name($data->_sales_man_id ?? '') }}
                      </select>
                      
                    </div>
                </div>

                @endif
                @php
$_payment_terms = $data->_payment_terms ?? 1;
                @endphp
                   <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_payment_terms">Payment Terms:</label>
                              <select class="form-control _payment_terms" name="_payment_terms" id="_payment_terms">
                                @forelse($payment_terms as $terms)
                                <option value="{{$terms->id}}" attr_date_number="{{ $terms->_days ?? 1 }}"  @if($data->_payment_terms==$terms->id) selected @endif >{{ $terms->_name ?? '' }}</option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2 _required" for="delivery_status">Delivery Status:</label>
                              <select class="form-control" name="_delivery_status">
                                @forelse(_delivery_status() as $key=>$d_val)
                                  <option value="{{$key}}" @if($data->_delivery_status==$key) selected @endif >{{$d_val ?? ''}}</option>
                                @empty
                                @endforelse
                              </select>
                             
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2 _required" for="_main_ledger_id">Supplier:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->_ledger->_name ?? '' )}}" placeholder="Supplier" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Supplier" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_code">{{__('label._code')}}:</label>
                              <input  readonly type="text" id="_code" name="_code" class="form-control _code" value="{{old('_code',$data->_ledger->_code ?? '')}}" placeholder="{{__('label._code')}}" >
                            </div>
                          </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone',$data->_phone)}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address',$data->_address)}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance',$data->_referance)}}" placeholder="Referance" >
                                
                            </div>
                        </div>
                        
                            
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_alious">{{__('label._alious')}}:</label>
                              <input  readonly type="text" id="_alious" name="_alious" class="form-control _alious" value="{{old('_alious',$data->_ledger->_alious ?? '')}}" placeholder="{{__('label._alious')}}" >
                            </div>
                          </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_credit_limit">{{__('label._credit_limit')}}:</label>
                                <input readonly  type="text" id="_credit_limit" name="_credit_limit" class="form-control _credit_limit" value="{{old('_credit_limit',$data->_ledger->_credit_limit ?? '')}}" placeholder="{{__('label._credit_limit')}}" >
                                  
                              </div>
                          </div>
                          
                          <div class="col-xs-12 col-sm-12 col-md-3 ">
                              <div class="form-group">
                                <label class="mr-2" for="_balance">{{__('label._balance')}}:</label>
                                <input readonly  type="text" id="_balance" name="_balance" class="form-control _balance" value="{{old('_balance',$data->_ledger->_balance ?? '')}}" placeholder="{{__('label._balance')}}" >
                                  
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
                                            <th class="text-left " >Tran. Unit</th>
                                            <th class="text-left">Pack Size</th>
                                              <th class="text-left" >Sales Qty</th>
                                            <th class="text-left" >Free Qty</th>
                                           <th class="text-left " >Total Qty</th>
                                            <th class="text-right" >Rate</th>
                                            <th class="text-left  " >Dis%</th>
                                            <th class="text-left  " >Discount</th>
                                            <th class="text-right" >Value</th>
                                           
                                             
                                           
                                          </thead>
                                          @php
                                          $_total_qty_amount = 0;
                                          $_total_vat_amount =0;
                                          $_total_value_amount =0;
                                          $_total_sale_qty =0;
                                          $_total_free_qty =0;
                                          $_total_discount_amount =0;


                                          @endphp
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @forelse($data->_master_details as $detail)
                                             @php
                                              $_total_qty_amount += $detail->_qty ??  0;
                                              $_total_vat_amount += $detail->_vat_amount ??  0;
                                              $_total_value_amount += $detail->_value ??  0;

                                            $_total_sale_qty +=$detail->sale_qty ?? 0;
                                            $_total_free_qty +=$detail->free_qty ?? 0;
                                             $_total_discount_amount +=$detail->_discount_amount ?? 0;
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
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>

                                                <input type="number" name="_base_rate[]" min="0" step="any" class="form-control _base_rate " value="{{$detail->_items->_sale_rate ?? 0}}"  readonly>
                                              </td>
                                              <td class="">

                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                  @php
                                                  $own_unit_conversions = $detail->_items->unit_conversion ?? [];
                                                  @endphp
                                                  @forelse($own_unit_conversions as $conversionUnit)
                                                  <option value="{{$conversionUnit->_conversion_unit}}"  
                                                attr_base_unit_id="{{$conversionUnit->_base_unit_id}}" 
                                                attr_conversion_qty="{{$conversionUnit->_conversion_qty}}" 
                                                attr_conversion_unit="{{$conversionUnit->_conversion_unit}}" 
                                                attr_item_id="{{$conversionUnit->_item_id}}"
                                                @if($detail->_transection_unit ==$conversionUnit->_conversion_unit) selected  @endif

                                                 >{{ $conversionUnit->_conversion_unit_name ?? '' }}</option>
                                                @empty
                                                @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input readonly type="text" name="pack_size[]" class="form-control pack_size" value="{{$detail->_items->_pack_size->_name ?? ''}}" >
                                              </td>
                                               <td>
                                                <input type="number" min="0"  name="sale_qty[]" class="form-control sale_qty sale_qty__counter_ _common_keyup"  value="{{$detail->sale_qty ?? 0 }}" >
                                              </td>
                                              <td class="">
                                                <input type="number" min="0"  name="free_qty[]" class="form-control free_qty free_qty__counter_ _common_keyup"  value="{{$detail->free_qty ?? 0 }}" >
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control text-right _qty _common_keyup"  value="{{$detail->_qty ?? 0 }}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate text-right _common_keyup" value="{{$detail->_rate ?? 0 }}" >
                                              </td>
                                               <td class="">
                                                <input type="number" name="_discount[]" class="form-control  _discount _discount__counter_  _discount__  _common_keyup" value="{{$detail->_discount}}">
                                              </td>
                                              <td class="">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount _discount_amount__counter_ _discount_amount__ " value="{{$detail->_discount_amount}}">
                                              </td>
                                             
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value text-right " readonly value="{{ $detail->_value ?? 0 }}" >
                                              </td>
                                           
                                              
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td colspan="3" class="text-right"><b>Total</b></td>
                                             <td class="display_none"></td>
                                              <td class="display_none"></td>
                                              <td></td>
                                              <td>
                                                <input type="number" min="0"  step="any" min="0" name="_total_sale_qty" class="form-control _total_sale_qty" value="{{$_total_sale_qty}}" readonly required>
                                              </td>
                                              <td class="">
                                                <input type="number" min="0"  step="any" min="0" name="_total_free_qty" class="form-control _total_free_qty" value="{{$_total_free_qty}}" readonly required>
                                              </td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control text-right _total_qty_amount" value="{{$_total_qty_amount}}" readonly required>
                                              </td>
                                              <td></td>
                                               <td class=""></td>
                                              <td class="">
                                                <input type="number" min="0"  step="any" min="0" name="_total_discount_amount" class="form-control _total_discount_amount"  readonly required value="{{$_total_discount_amount ?? 0}}">
                                              </td>
                                            
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control text-right _total_value_amount" value="{{$_total_value_amount ?? 0}}" readonly required>



                                              </td>
                                            
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                       
                          

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
                                     <input type="hidden" name="_master_id" value="{{url('sales-order/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '' )}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_sub_total">Sub Total</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="{{ _php_round($data->_sub_total ?? 0) }}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_discount_input" class="form-control width_200_px" id="_discount_input" value="{{$data->_discount_input ?? 0}}" >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total_discount">Total Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_discount" class="form-control width_200_px" id="_total_discount" readonly value="{{$data->_total_discount ?? 0}}">
                              </td>
                            </tr>
                           
                            
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total">Net Total </label></td>
                              <td style="width: 70%;border:0px;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="{{ _php_round($data->_total ?? 0)}}">
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                          
                            <button type="submit" class="btn btn-success submit-button ml-5 mb-4"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                          
                          
                            
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




</div>
@include('backend.common-modal.item_ledger_modal')

@endsection

@section('script')

<script type="text/javascript">
  @if(empty($form_settings))
    $(document).find("#form_settings").click();
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
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                    <input type="hidden" name="_p_item_sales_discount" class="_item_sales_discount" value="${data[i]?._discount}">
                                   <input type="hidden" name="_item_pack_size" class="_item_pack_size" value="${data[i]?._pack_size?._name}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                    <td>${data[i]?._pack_size?._name}</td>
                                   <td>${data[i]._units?._name}</td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="4"><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-plus"></i> New Item
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
  var _item_sales_discount = $(this).children('td').find('._item_sales_discount').val();

  var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();
  var _item_code = $(this).children('td').find('._item_code').val();

  var _item_pack_size = $(this).children('td').find('._item_pack_size').val();

 var _item_row_count = _ref_counter;

  if(isNaN(_item_sales_discount)){ _item_sales_discount=0 }
  if(isNaN(_item_vat)){ _item_vat=0 }
  _vat_amount = ((_item_rate*_item_vat)/100);
  _discount_amount = ((_item_rate*_item_sales_discount)/100);

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
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_item_sales_rate);
  
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_item_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_item_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat_amount').val(_vat_amount);

  $(this).parent().parent().parent().parent().parent().parent().find('.sale_qty').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('.free_qty').val(0);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
    $(this).parent().parent().parent().parent().parent().parent().find('._discount').val(_item_sales_discount);
  $(this).parent().parent().parent().parent().parent().parent().find('._discount_amount').val(_discount_amount);
  

  
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_item_rate);
 var _ref_counter = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').attr('name',_ref_counter+'__barcode__'+_id);
  var _item_row_count = _ref_counter;
  
  $(this).parent().parent().parent().parent().parent().parent().find('._base_rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);
    $(this).parent().parent().parent().parent().parent().parent().find('.pack_size').val(_item_pack_size);

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
  var _sales_rate =parseFloat( __this.closest('tr').find('._sales_rate').val());
  var _item_vat = __this.closest('tr').find('._vat').val();
  var conversion_qty = parseFloat(__this.closest('tr').find('.conversion_qty').val());
  var _item_discount = parseFloat(__this.closest('tr').find('._discount').val());




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
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*converted_price_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*converted_price_rate)*_item_discount)/100)


   var _value = parseFloat(converted_price_rate*_qty).toFixed(2);
 __this.closest('tr').find('._rate').val(converted_price_rate);
 __this.closest('tr').find('._value').val(_value);
  __this.closest('tr').find('._vat_amount').val(_vat_amount);
  __this.closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();


}

$(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }
})

$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;

    var sale_qty  = parseFloat($(this).closest('tr').find('.sale_qty').val());
  var free_qty = parseFloat($(this).closest('tr').find('.free_qty').val());
  $(this).closest('tr').find('._qty').val(parseFloat(sale_qty)+parseFloat(free_qty))


  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _item_vat = $(this).closest('tr').find('._vat').val();
    var _item_discount = parseFloat($(this).closest('tr').find('._discount').val());


   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   _vat_amount = Math.ceil(((sale_qty*_rate)*_item_vat)/100)
  if(isNaN(_item_discount)){ _item_discount =0 }
 _discount_amount = Math.ceil(((sale_qty*_rate)*_item_discount)/100)

    $(this).closest('tr').find('._value').val((sale_qty*_rate));
  $(this).closest('tr').find('._vat_amount').val(_vat_amount);
   $(this).closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();
})

$(document).on('keyup','._vat_amount',function(){
 var _item_vat =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _vat_amount =  $(this).closest('tr').find('._vat_amount').val();
  
   if(isNaN(_vat_amount)){ _vat_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   var _vat = parseFloat((_vat_amount/(_rate*_qty))*100).toFixed(2);
    $(this).closest('tr').find('._vat').val(_vat);

    $(this).closest('tr').find('._value').val((_qty*_rate));
 
    _purchase_total_calculation();
})

$(document).on("change","#_discount_input",function(){
  var _discount_input = $(this).val();
  var res = _discount_input.match(/%/gi);
  if(res){
     res = _discount_input.split("%");
    res= parseFloat(res);
    on_invoice_discount = ($(document).find("#_sub_total").val()*res)/100
    $(document).find("#_discount_input").val(on_invoice_discount)

  }else{
    on_invoice_discount = _discount_input;
  }

   $(document).find("#_total_discount").val(on_invoice_discount);
    _purchase_total_calculation()
})



 function _purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
      $(document).find("._value").each(function() {
        var line_value = parseFloat($(this).val());
        if(isNaN(line_value)){ line_value=0 }
          _total__value +=parseFloat(line_value);
        
      });
      $(document).find("._qty").each(function() {
        var line__qty = parseFloat($(this).val());
        if(isNaN(line__qty)){ line__qty=0 }
          _total_qty +=parseFloat(line__qty);
      });
      $(document).find("._vat_amount").each(function() {
        var line__vat = parseFloat($(this).val());
        if(isNaN(line__vat)){ line__vat=0 }
          _total__vat +=parseFloat(line__vat);
      });

       var _total_discount_amount =0
      $(document).find("._discount_amount").each(function() {
        var line__dis_amount = parseFloat($(this).val());
        if(isNaN(line__dis_amount)){ line__dis_amount=0 }
          _total_discount_amount +=parseFloat(line__dis_amount);
      });


      $("._total_qty_amount").val(_total_qty);
      $("._total_value_amount").val(_total__value);
      $("._total_vat_amount").val(_total__vat);
       $("._total_discount_amount").val(_total_discount_amount);

      var _discount_input = parseFloat($(document).find("#_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }

          var _discount_input = parseFloat($("#_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }
      var _total_discount = parseFloat(_discount_input)+parseFloat(_total_discount_amount);

      $(document).find("#_sub_total").val(_math_round(_total__value));
      $(document).find("#_total_vat").val(_total__vat);
      $(document).find("#_total_discount").val(parseFloat(_discount_input)+parseFloat(_total_discount_amount));
      var _total = _math_round((parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_total_discount));
      $(document).find("#_total").val(_total);
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td>
                      <input type="hidden" name="purchase_account_id[]" class="form-control purchase_account_id" value="0"  />
                      </td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
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
                            <td>
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $(document).find("#area__voucher_details").append(single_row);
  }

var _purchase_row_single =`<tr class="_purchase_row">
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
                                               <td >
                                                <input type="number" name="sale_qty[]" class="form-control sale_qty _common_keyup" step="any" min="0">
                                              </td>
                                              <td class="">
                                                <input type="number" name="free_qty[]" class="form-control free_qty _common_keyup" step="any" min="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty text-right _common_keyup" min="0" step="any">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate text-right _common_keyup"  min="0" step="any">
                                              </td>
                                              
                                               <td class="">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup"  min="0" step="any">
                                              </td>
                                              <td class="">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount"  min="0" step="any">
                                              </td>
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value text-right" readonly  min="0" step="any">
                                              </td>
                                             
                                          
                                            
                                              
                                            </tr>`;
function purchase_row_add(event){
   event.preventDefault();
      $(document).find("#area__purchase_details").append(_purchase_row_single);
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
   
    var _note = $(document).find('._note').val();
    var _main_ledger_id = $(document).find('._main_ledger_id').val();
    if(_main_ledger_id  ==""){
       alert(" Please Add Ledger  ");
        $(document).find('._search_main_ledger_id').addClass('required_border').focus();
        return false;
    }


    var empty_ledger = [];
    $(document).find("._search_item_id").each(function(){
        if($(this).val() ==""){
          console.log($(this))
          alert(" Please Add Item  ");
          $(this).addClass('required_border');
          empty_ledger.push(1);
        }  
    })

    if(empty_ledger.length > 0){
      return false;
    }


   if(_note ==""){
       
       $(document).find('._note').focus().addClass('required_border');
      return false;
    }else if(_main_ledger_id ==""){
       
      $(document).find('._search_main_ledger_id').focus().addClass('required_border');
      return false;
    }else{
      $('.submit-button').attr('disabled','true');
      $(document).find('.purchase_form').submit();
    }
  })

</script>

@endsection