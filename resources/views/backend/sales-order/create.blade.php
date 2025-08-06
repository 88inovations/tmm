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
@php
$auth_user = \Auth::user();
@endphp  
              </div>
              <div class="card-body">
               <form action="{{route('sales-order.store')}}" method="POST" class="purchase_form" >
                @csrf
                                   <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name" value="sales_orders">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>

                        
                        <div class="col-xs-12 col-sm-12 col-md-2 display_none">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Order Number:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number')}}" placeholder="Order Number" readonly >
                              <input type="hidden" name="_search_form_value" class="_search_form_value" value="2">
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_delivery_date">{{__('label._delivery_date')}}:</label>
                              <input type="date" id="_delivery_date" name="_delivery_date" class="form-control _delivery_date" value="{{old('_delivery_date')}}"   >
                                
                            </div>
                        </div>
                        
                      @include('basic.org_create')

@php
$user_type = $auth_user->user_type ?? '';
@endphp
                @if($user_type !='admin')

                <div class="col-xs-12 col-sm-12 col-md-2 ">
                    <div class="form-group">
                      <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                      <select class="form-control _sales_man" name="_sales_man_id">
                        <option value="{{$auth_user->ref_id ?? '' }}">{!! $auth_user->user_name ?? '' !!}-{!! $auth_user->name ?? '' !!}</option>
                      </select>
                      
                    </div>
                </div>
                @else

                 <div class="col-xs-12 col-sm-12 col-md-2 ">
                    <div class="form-group">
                      <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                      <select class="form-control _sales_man" name="_sales_man_id">
                        <option value=""><---Select {{__('label._sales_man_id')}}---></option>
                      </select>
                      
                    </div>
                </div>

                @endif

                       <div class="col-xs-12 col-sm-12 col-md-2  ">
                            <div class="form-group">
                              <label class="mr-2" for="_payment_terms">Payment Terms:</label>
                              <select class="form-control _payment_terms" name="_payment_terms" id="_payment_terms">
                                @forelse($payment_terms as $terms)
                                <option value="{{$terms->id}}" attr_date_number="{{ $terms->_days ?? 1 }}">{{ $terms->_name ?? '' }}</option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2 _required" for="_delivery_status">Delivery Status:</label>
                              <select class="form-control _delivery_status" name="_delivery_status">
                                @forelse(_delivery_status() as $key=>$d_val)
                                  <option value="{{$key}}">{{$d_val ?? ''}}</option>
                                @empty
                                @endforelse
                              </select>
                             
                                
                            </div>
                        </div>
                     
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2 _required" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id')}}" placeholder="Customer" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id')}}" placeholder="Customer" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone')}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address')}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                              <label class="mr-2" for="_alious">{{__('label._alious')}}:</label>
                              <input  readonly type="text" id="_alious" name="_alious" class="form-control _alious" value="{{old('_alious','')}}" placeholder="{{__('label._alious')}}" >
                            </div>
                          </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                              <div class="form-group">
                                <label class="mr-2" for="_credit_limit">{{__('label._credit_limit')}}:</label>
                                <input readonly  type="text" id="_credit_limit" name="_credit_limit" class="form-control _credit_limit" value="{{old('_credit_limit',0)}}" placeholder="{{__('label._credit_limit')}}" >
                                  
                              </div>
                          </div>
                          
                          <div class="col-xs-12 col-sm-12 col-md-2">
                              <div class="form-group">
                                <label class="mr-2" for="_balance">{{__('label._balance')}}:</label>
                                <input readonly  type="text" id="_balance" name="_balance" class="form-control _balance" value="{{old('_balance',0)}}" placeholder="{{__('label._balance')}}" >
                                  
                              </div>
                          </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance')}}" placeholder="Referance" >
                                
                            </div>
                        </div>
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                               
  <div class="text-left ">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
                Add Product
            </button>
        </div>
                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-middle" >&nbsp;</th>
                                            <th class="text-middle" >Code of Product</th>
                                            <th class="text-middle" >Name of Product</th>
                                           <th class="text-left display_none" >Base Unit</th>
                                            <th class="text-left display_none" >Con. Qty</th>
                                            <th class="text-left " >Tran. Unit</th>
                                            <th class="text-middle" >Pack Size</th>
                                            <th class="text-middle" >Sales Qty</th>
                                            <th class="text-left">Free Qty</th>
                                            <th class="text-left">Total Qty</th>
                                            <th class="text-middle" >Sales Rate</th>
                                            <th class="text-middle" >Discount %</th>
                                            <th class="text-middle" >Discount Amount</th>
                                            <th class="text-middle" >Sales Value</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                           
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="3" class="text-right"><b>Total</b></td>
                                             <td class=""></td>
                                              <td class=""></td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              <td>
                                                <input type="text" name="_total_discount_amount" step="any" min="0" class="form-control _total_discount_amount" readonly value="0">
                                              </td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly required>
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

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr class="">
                              <td style="width: 10%;border:0px;"><label for="_sub_total">Sub Total</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="0">
                              </td>
                            </tr>
                            <tr class="">
                              <td style="width: 10%;border:0px;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_discount_input" class="form-control width_200_px" id="_discount_input" value="0" >
                              </td>
                            </tr>
                            <tr  class="">
                              <td style="width: 10%;border:0px;"><label for="_total_discount">Total Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_discount" class="form-control width_200_px" id="_total_discount" readonly value="0">
                              </td>
                            </tr>
                           
                            <tr >
                              <td style="width: 10%;border:0px;"><label for="_total">NET Total </label></td>
                              <td style="width: 70%;border:0px;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="0">
                          <input type="hidden" name="_item_row_count" value="1" class="_item_row_count">
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button mt-4 mb-4"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
              </div>
            </div>
            <!-- /.card -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="modal_item_code" class="form-label">Product Code</label>
                    <input type="text" name="modal_item_code" class="form-control modal_item_code" id="modal_item_code">
                    <div class="modal_item_display_box"></div>
                </div>
                <div class="form-group">
                    <label for="modal_item_name" class="form-label">Product Name</label>
                    <input type="text" name="modal_item_name" class="form-control modal_item_name" id="modal_item_name">
                    <input type="hidden" name="modal_item_id" class="form-control modal_item_id" id="modal_item_id">
                    <div class="modal_item_display_box"></div>
                </div>

                <div class="form-group">
                    <label for="modal_transection_unit" class="form-label">Transection Unit</label>
                     <select class="form-control modal_transection_unit" name="modal_transection_unit" id="modal_transection_unit">
                      </select>
                </div>
                <div class="form-group">
                    <label for="modal_pack_size" class="form-label">Pack Size</label>
                    <input type="text" name="modal_pack_size" class="form-control modal_pack_size" id="modal_pack_size" readonly>
                    <input type="hidden" name="modal_base_rate" class="form-control modal_base_rate" id="modal_base_rate" readonly>
                    <input type="hidden" name="modal_base_unit_id" class="form-control modal_base_unit_id" id="modal_base_unit_id" readonly>
                    <input type="hidden" name="modal_main_unit_val" class="form-control modal_main_unit_val" id="modal_main_unit_val" readonly>
                    <input type="hidden" name="modal_conversion_qty" class="form-control modal_conversion_qty" id="modal_conversion_qty" readonly>
                </div>
                
                <div class="form-group">
                    <label for="modal_sales_qty" class="form-label">Sales Quantity</label>
                    <input type="number" step="any" min="0" id="modal_sales_qty" class="form-control modal_sales_qty modal_common_keyup" placeholder="Free Qty" value="0">
                </div>
                <div class="form-group">
                    <label for="modal_free_qty" class="form-label">Free Quantity</label>
                    <input type="number" step="any" min="0" id="modal_free_qty" class="form-control modal_free_qty modal_common_keyup" placeholder="Free Qty" value="0">
                </div>
                <div class="form-group">
                    <label for="modal_quantity" class="form-label">Total Quantity</label>
                    <input type="number" step="any" min="0" id="modal_quantity" class="form-control modal_quantity modal_common_keyup" placeholder="Sales Qty" value="0">
                </div>
                <div class="form-group">
                    <label for="modal_rate" class="form-label">Rate per Unit</label>
                    <input type="number" step="any" min="0" id="modal_rate" class="form-control modal_rate" placeholder="Rate" readonly value="0">
                </div>
                <div class="form-group">
                    <label for="modal_discount_rate" class="form-label">Discount Rate %</label>
                    <input type="number" step="any" min="0" id="modal_discount_rate" class="form-control modal_common_keyup modal_discount_rate" placeholder="Discount Rate" value="0">
                </div>
                <div class="form-group">
                    <label for="modal_discount_amount" class="form-label">Discount Amount</label>
                    <input type="number" step="any" min="0" id="modal_discount_amount" class="form-control modal_discount_amount" placeholder="Discount Amount" value="0">
                </div>
                <div class="form-group">
                    <label for="modal_line_total" class="form-label">Total</label>
                    <input type="number" step="any" min="0" id="modal_line_total" class="form-control modal_line_total" placeholder="Value" value="0" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="addItemToCart" class="btn btn-primary">Add Item</button>
            </div>

           
        </div>
    </div>
</div>
            
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


  $(document).ready(function () {
    var cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    console.log(cart);

    for (var i = 0; i < cart?.length; i++) {
        var item = cart[i];
        const modal_item_code = item?.modal_item_code;
        const modal_item_name = item?.modal_item_name;
        const modal_item_id = item?.modal_item_id;
        const modal_pack_size = item?.modal_pack_size;
        const modal_base_rate = parseFloat(item?.modal_base_rate || 0);
        const modal_base_unit_id = parseFloat(item?.modal_base_unit_id || 0);
        const modal_main_unit_val = item?.modal_main_unit_val;
        const modal_conversion_qty = parseFloat(item?.modal_conversion_qty || 0);
        const modal_transection_unit = parseFloat(item?.modal_transection_unit || 0);
        const modal_sales_qty = parseFloat(item?.modal_sales_qty || 0);
        const modal_free_qty = parseFloat(item?.modal_free_qty || 0);
        const modal_quantity = parseFloat(item?.modal_quantity || 0);
        const modal_discount_rate = parseFloat(item?.modal_discount_rate || 0);
        const modal_discount_amount = parseFloat(item?.modal_discount_amount || 0);
        const modal_rate = parseFloat(item?.modal_rate || 0);
        const lineValue = parseFloat(item?.modal_line_total || 0);
        var _id = modal_item_id;

        var _item_row_count = i + 1;

        var _purchase_row_single = `<tr class="_purchase_row">
            <td>
                <a href="#none" class="btn btn-default _purchase_row_remove"><i class="fa fa-trash"></i></a>
            </td>
            <td>
                <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code" value="${modal_item_code}">
                <div class="search_box_item"></div>
            </td>
            <td>
                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="${modal_item_name}">
                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="${modal_item_id}">
                <div class="search_box_item"></div>
            </td>
           
            <td>
                <select class="form-control _transection_unit _transection_unit__${_item_row_count}" name="_transection_unit[]"></select>
                
                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="${modal_base_unit_id}" />
                <input type="hidden" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty" value="${modal_conversion_qty}" readonly>
                <input type="hidden" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="${modal_main_unit_val}" />
                <input type="hidden" name="_base_rate[]" min="0" step="any" class="form-control _base_rate" readonly value="${modal_base_rate}">
            </td>
            <td>
                <input readonly type="text" name="pack_size[]" class="form-control pack_size" value="${modal_pack_size}">
            </td>
            <td>
                <input type="number" name="sale_qty[]" class="form-control sale_qty _common_keyup" value="${modal_sales_qty}" step="any" min="0">
            </td>
            <td>
                <input type="number" name="free_qty[]" class="form-control free_qty _common_keyup" value="${modal_free_qty}" step="any" min="0">
            </td>
            <td>
                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="${modal_quantity}" step="any" min="0">
            </td>
            <td>
                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="${modal_rate}" step="any" min="0">
            </td>
            <td>
                <input type="number" name="_discount[]" class="form-control _discount _common_keyup" value="${modal_discount_rate}" step="any" min="0">
            </td>
            <td>
                <input type="number" name="_discount_amount[]" class="form-control _discount_amount" value="${modal_discount_amount}" step="any" min="0" readonly>
            </td>
            <td>
                <input type="number" name="_value[]" class="form-control _value" value="${lineValue}" step="any" min="0" readonly>
            </td>
        </tr>`;

        // Append row to table
        $('#area__purchase_details').append(_purchase_row_single);

        // Fetch transaction units for the current item
        fetchTransactionUnits(_id, _item_row_count,modal_transection_unit);

         _purchase_total_calculation();
    }

    function fetchTransactionUnits(item_id, row_count,modal_transection_unit) {
        $.ajax({
            url: "{{url('item-wise-units')}}",
            method: 'GET',
            data: { item_id: item_id },
            dataType: 'html',
            success: function (response) {
                $(document).find(`._transection_unit__${row_count}`).html(response); // Populate dropdown
                console.log(modal_transection_unit);
                 $(document).find(`._transection_unit__${row_count}`).val(modal_transection_unit);
            },
            error: function () {
                alert('Failed to load transaction units.');
            },
        });
    }
});



$(document).on('click', '#addItemToCart', function () {
    const modal_item_code = $(document).find('.modal_item_code').val();
    const modal_item_name = $(document).find('.modal_item_name').val();
    const modal_item_id = $(document).find('.modal_item_id').val();
    const modal_pack_size = $(document).find('.modal_pack_size').val();
    const modal_base_rate = $(document).find('.modal_base_rate').val();
    const modal_base_unit_id = parseFloat($(document).find('.modal_base_unit_id').val() || 0);
    const modal_main_unit_val = parseFloat($(document).find('.modal_main_unit_val').val() || 0);
    const modal_conversion_qty = parseFloat($(document).find('.modal_conversion_qty').val() || 0);
    const modal_sales_qty = parseFloat($(document).find('.modal_sales_qty').val() || 0);
    const modal_free_qty = parseFloat($(document).find('.modal_free_qty').val() || 0);
    const modal_quantity = parseFloat($(document).find('.modal_quantity').val() || 0);
    const modal_discount_rate = parseFloat($(document).find('.modal_discount_rate').val() || 0);
    const modal_discount_amount = parseFloat($(document).find('.modal_discount_amount').val() || 0);
    const modal_rate = parseFloat($(document).find('.modal_rate').val() || 0);
    const lineValue = parseFloat($(document).find('.modal_line_total').val() || 0);

    var _master_branch_id = $(document).find("._master_branch_id").val();

    if (modal_quantity > 0) {
        // Get the current row count
        var _item_row_count = parseInt($(document).find("._item_row_count").val() || 0);

        // Prepare the HTML for the new row
        var _purchase_row_single = `<tr class="_purchase_row">
                                      <td>
                                          <a href="#none" class="btn btn-default _purchase_row_remove"><i class="fa fa-trash"></i></a>
                                      </td>
                                      <td>
                                          <input type="text" name="_search_item_code[]" class="form-control _search_item_code width_150_px" placeholder="Code" value="${modal_item_code}">
                                      </td>
                                      <td>
                                          <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="${modal_item_name}">
                                          <input type="hidden" name="_item_id[]" class="form-control _item_id" value="${modal_item_id}">
                                      </td>
                                      <td class="">
                                          <select class="form-control _transection_unit _transection_unit__${_item_row_count}" name="_transection_unit[]">
                                          </select>
                                           <input type="hidden" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="${modal_conversion_qty}" readonly>

                                          <input type="hidden" name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly value="${modal_base_rate}">
                                      </td>
                                      <td>
                                          <input type="text" name="pack_size[]" class="form-control pack_size" readonly value="${modal_pack_size}">
                                      </td>
                                   <td >
                                                <input type="number" name="sale_qty[]" class="form-control sale_qty _common_keyup" value="${modal_sales_qty}" step="any" min="0">
                                              </td>
                                              <td class="">
                                                <input type="number" name="free_qty[]" class="form-control free_qty _common_keyup" value="${modal_free_qty}" step="any" min="0">
                                              </td>

                                      <td>
                                          <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="${modal_quantity}" step="any" min="0">
                                      </td>
                                      <td>
                                          <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="${modal_rate}" step="any" min="0">
                                      </td>

                                       <td class="">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup"  value="${modal_discount_rate}" step="any" min="0">
                                              </td>
                                              <td class="">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount" value="${modal_discount_amount}" step="any" min="0" readonly>
                                              </td>
                                      <td>
                                          <input type="number" name="_value[]" class="form-control _value" readonly value="${lineValue}" step="any" min="0">
                                      </td>
                                  </tr>`;

        // Append the new row to the table
        $(document).find("#area__purchase_details").append(_purchase_row_single);

        // Populate the transaction unit dropdown
        const sourceSelect = $(document).find('.modal_transection_unit'); // Source dropdown
        const targetSelect = $(document).find(`._transection_unit__${_item_row_count}`); // Target dropdown for the new row

        // Copy options from the source to the target with all attributes
sourceSelect.find('option').each(function () {
    const option = $(this); // Current option
    const value = option.val(); // Get option value
    const text = option.text(); // Get option text
    const isSelected = option.is(':selected'); // Check if the option is selected

    // Create a new option with all attributes
    const newOption = $('<option>', {
        value: value,
        text: text,
        selected: isSelected // Retain the selected status
    });

    // Copy custom attributes
    $.each(option[0].attributes, function () {
        if (this.name.startsWith('attr_')) {
            newOption.attr(this.name, this.value);
        }
    });

    // Append the new option to the target select
    targetSelect.append(newOption);
});

        // Update row count and perform calculations
        $(document).find("._item_row_count").val(_item_row_count + 1);
        _purchase_total_calculation();

        // Clear modal inputs
        clearModalInputs();

        // Close the modal
        $(document).find('#addItemModal').modal('hide');
    } else {
        alert('Please enter a valid quantity');
    }
});


$(document).on('change','._master_branch_id',function(){
  var _master_branch_id = $(document).find("._master_branch_id").val();
  $(document).find("._main_branch_id_detail").val(_master_branch_id).change();
})


  // Clear modal input fields
  const clearModalInputs = () => {
      $(document).find('.modal_item_id').val('');
      $(document).find('.modal_item_code').val('');
      $(document).find('.modal_item_name').val('');
      $(document).find('.modal_quantity').val(0);
      $(document).find('.modal_sales_qty').val(0);
      $(document).find('.modal_free_qty').val(0);
      $(document).find('.modal_discount_rate').val(0);
      $(document).find('.modal_discount_amount').val(0);
      $(document).find('.modal_rate').val(0);
      $(document).find('.modal_line_total').val(0);
  };
  

  
$(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var onclick_row_class="search_row_item";
    var display_box_class=".search_box_item";
     var clostest_td="td";
    purchase_item_search(_gloabal_this,_text_val,onclick_row_class,display_box_class,clostest_td);

}, 500));

  $(document).on('keyup','._search_item_code',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
     var onclick_row_class="search_row_item";
    var display_box_class=".search_box_item";
    var clostest_td="td";
    purchase_item_search(_gloabal_this,_text_val,onclick_row_class,display_box_class,clostest_td);

}, 500));


  
$(document).on('keyup','.modal_item_code',delay(function(e){
    $(document).find('.modal_item_code').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var onclick_row_class="modal_row_item";
     var display_box_class=".modal_item_display_box";
     var clostest_td="div";
    purchase_item_search(_gloabal_this,_text_val,onclick_row_class,display_box_class,clostest_td);

}, 500));

  $(document).on('keyup','.modal_item_name',delay(function(e){
    $(document).find('.modal_item_name').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
      var onclick_row_class="modal_row_item";
       var display_box_class=".modal_item_display_box";
       var clostest_td="div";
    purchase_item_search(_gloabal_this,_text_val,onclick_row_class,display_box_class,clostest_td);

}, 500));



function purchase_item_search(_gloabal_this,_text_val,onclick_row_class,display_box_class,clostest_td){
  console.log(display_box_class)
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
            search_html +=`<div class="card table-responsive"><table class="table">
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
                         search_html += `<tr class="${onclick_row_class}" >

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
        <thead><th colspan="4">@can('item-information-create')<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-plus"></i> New Item
                </button>@endcan</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent(clostest_td).find(display_box_class).html(search_html);
      _gloabal_this.parent(clostest_td).find(display_box_class).addClass('search_box_show').show();
      
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
  var _item_sales_discount = $(this).children('td').find('._item_sales_discount').val();

  var _item_pack_size = $(this).children('td').find('._item_pack_size').val();

 var _item_row_count = _ref_counter;
  if(_unique_barcode ==1){
    _new_barcode_function(_item_row_count);
  }
  
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






  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_item_sales_rate);

 var _ref_counter = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').attr('name',_ref_counter+'__barcode__'+_id);
  var _item_row_count = _ref_counter;
  
  $(this).parent().parent().parent().parent().parent().parent().find('._base_rate').val(_item_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);
    $(this).parent().parent().parent().parent().parent().parent().find('.pack_size').val(_item_pack_size);

  _purchase_total_calculation();
  $(document).find('.search_box_item').hide();
  $(document).find('.search_box_item').removeClass('search_box_show').hide();
  
})


$(document).on('click','.modal_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).children('td').find('._name_item').val();
  var _item_barcode = $(this).children('td').find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).children('td').find('._item_rate').val();
  var _item_sales_rate = $(this).children('td').find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).children('td').find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).children('td').find('._unique_barcode').val());
  var _unique_barcode = parseFloat($(this).children('td').find('._unique_barcode').val());

  var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();
  var _item_code = $(this).children('td').find('._item_code').val();
  var _p_item_sales_discount = $(this).children('td').find('._p_item_sales_discount').val();
 // var modal_conversion_qty = $(this).children('td').find('.modal_conversion_qty').val();
  if(isNaN(_p_item_sales_discount)){_p_item_sales_discount=0}

  var _item_pack_size = $(this).children('td').find('._item_pack_size').val();

 var _item_row_count = _ref_counter;
 
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
      console.log(response)
      $(document).find('.modal_transection_unit').html("")
      $(document).find('.modal_transection_unit').html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  

  $(document).find('.modal_item_id').val(_id);
  var _id_name = `${_name} `;
  $(document).find('.modal_item_code').val(_item_code);
  $(document).find('.modal_item_name').val(_id_name);
  $(document).find('.modal_sales_qty').val(1);
  $(document).find('.modal_free_qty').val(0);
  $(document).find('.modal_rate').val(_item_sales_rate);
  $(document).find('.modal_discount_rate').val(_p_item_sales_discount);
  $(document).find('.modal_conversion_qty').val(1);
  
  $(document).find('.modal_rate').val(_item_sales_rate);
  $(document).find('.modal_quantity').val(1);
  
  $(document).find('.modal_line_total').val(_item_sales_rate);
 var _ref_counter = $(document).find('._ref_counter').val();
  var _item_row_count = _ref_counter;
 
  $(document).find('.modal_base_rate').val(_item_sales_rate);
  $(document).find('.modal_base_unit_id').val(_main_unit_id);
  $(document).find('.modal_main_unit_val').val(_main_unit_val);
  $(document).find('.modal_pack_size').val(_item_pack_size);
  //$(document).find('.modal_net_line_total').val();

  $(document).find('.modal_item_display_box').hide();
  $(document).find('.modal_item_display_box').removeClass('search_box_show').hide();
  
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

 $(document).on('keyup','.modal_common_keyup',function(){

    var modal_sales_qty = parseFloat($(document).find(".modal_sales_qty").val() || 0);
    var modal_free_qty = parseFloat($(document).find(".modal_free_qty").val() || 0);
    var modal_quantity = parseFloat(parseFloat(modal_sales_qty)+parseFloat(modal_free_qty));
    if(isNaN(modal_quantity)){modal_quantity=0}

    $(document).find(".modal_quantity").val(modal_quantity);

  

 
    
    var modal_rate = parseFloat($(document).find(".modal_rate").val() || 0);
  var modal_line_total = parseFloat(modal_sales_qty*modal_rate);
  if(isNaN(modal_line_total)){modal_line_total=0}

     var modal_discount_rate = parseFloat($(document).find(".modal_discount_rate").val() || 0);
     var modal_discount_amount = Math.ceil(((modal_line_total)*modal_discount_rate)/100);
     if(isNaN(modal_discount_amount)){modal_discount_amount=0}

     $(document).find(".modal_discount_amount").val(modal_discount_amount);
    $(document).find(".modal_line_total").val(modal_line_total);

  });


$(document).on('change','.modal_transection_unit',function(){
  var __this = $(this);
  var conversion_qty = $('option:selected', this).attr('attr_conversion_qty');
 
  $(document).find(".modal_conversion_qty").val(conversion_qty);

 var _vat_amount =0;
  var modal_sales_qty = $(document).find('.modal_sales_qty').val();
  var modal_free_qty = $(document).find('.modal_free_qty').val();
  var _qty = $(document).find('.modal_quantity').val();
  var _rate = $(document).find('.modal_rate').val();
  var _base_rate = $(document).find('.modal_base_rate').val();
  var _sales_rate =parseFloat( $(document).find('.modal_rate').val());
  var _item_vat = $(document).find('._vat').val();
  var conversion_qty = parseFloat($(document).find('.modal_conversion_qty').val());
  var _item_discount = 0;




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
   _vat_amount = Math.ceil(((modal_sales_qty*converted_price_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((modal_sales_qty*converted_price_rate)*_item_discount)/100)


   var _value = parseFloat(converted_price_rate*modal_sales_qty).toFixed(2);
 $(document).find('.modal_rate').val(converted_price_rate);
 $(document).find('.modal_line_total').val(_value);
 
})

$(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $('.search_box_main_ledger').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }

    if(search_box_main_ledger ==true){
      $('.search_box_main_ledger').removeClass('search_box_show').hide();
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
   if(isNaN(sale_qty)){ sale_qty =0 }
   _vat_amount = Math.ceil(((_qty*sale_qty)*_item_vat)/100)
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
      $("._total_vat_amount").val(_total__vat);
      $("._total_discount_amount").val(_total_discount_amount);
      $("._total_value_amount").val(_total__value);

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
                                                <input type="number" name="sale_qty[]" class="form-control sale_qty _common_keyup" value="0" step="any" min="0">
                                              </td>
                                              <td class="">
                                                <input type="number" name="free_qty[]" class="form-control free_qty _common_keyup" value="0" step="any" min="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="0" step="any" min="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="0" step="any" min="0">
                                              </td>
                                               <td class="">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup"  value="0" step="any" min="0">
                                              </td>
                                              <td class="">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount" value="0" step="any" min="0" readonly>
                                              </td>
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " value="0" step="any" min="0" readonly >
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
      sessionStorage.setItem('cart', JSON.stringify([]));

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
