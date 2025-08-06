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
              <a class="m-0 _page_name" href="{{ route('item_bonus_setups.index') }}">{!! $page_name ?? '' !!} </a>
           
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
                @can('musak-four-point-three-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('item_bonus_setups.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
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
               <form action="{{route('item_bonus_setups.store')}}" method="POST" class="purchase_form" >
                @csrf
                
                  <div class="row">


                       <div class="col-xs-12 col-sm-12 col-md-3 ">
                        
                            <div class="form-group">
                                <label>Date:</label>
                                <input type="hidden" name="id" value="" class="_main_id">
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" id="_search_form_value" name="_search_form_value" class="_search_form_value" value="1" >
                              <input type="hidden" name="_item_row_count" value="1" class="_item_row_count">
                        </div>
                        @include("backend.widgets.budget_select")
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <label class="mr-2" for="_main_item__search_item_id">Item:<span class="_required">*</span></label>
                            <input type="text" id="_main_item__search_item_id" name="_main_item__search_item_id" class="form-control _main_item__search_item_id width_280_px" placeholder="Item" required>
                              <input type="hidden" name="_main_item_id" class="form-control _main_item_id width_200_px" >
                              <div class="_main_item_search_box_item"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_main_transection_unit">{{__('label.Tran. Unit')}}:<span class="_required">*</span></label>
                            <select class="form-control _main_transection_unit" name="_main_transection_unit" required>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_main_base_unit">{{__('label._base_unit')}}:<span class="_required">*</span></label>
                            <input type="hidden" name="_main_base_unit" class="form-control _main_base_unit">
                            <input type="text" readonly name="_main_base_unit_name" class="form-control _main_base_unit_name">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_main_unit_conversion">{{__('label._unit_conversion')}}:<span class="_required">*</span></label>
                            <input type="text" readonly name="_main_unit_conversion" class="form-control _main_unit_conversion" value="1" >
                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_main_qty_slot_min">{{__('label._qty_slot_min')}}:<span class="_required">*</span></label>
                            <input type="number" name="_main_qty_slot_min" class="form-control _main_qty_slot_min" step="any" min="0" required value="{{old('_main_qty_slot_min')}}">
                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_main_qty_slot_max">{{__('label._qty_slot_max')}}:<span class="_required">*</span></label>
                            <input type="number" name="_main_qty_slot_max" class="form-control _main_qty_slot_max" step="any" min="0" required value="{{old('_main_qty_slot_max')}}">
                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_start_time">{{__('label._start_time')}}:<span class="_required">*</span></label>
                            <input type="date" name="_start_time" class="form-control _start_time" value="{{old('_start_time')}}" required>
                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_end_time">{{__('label._end_time')}}:<span class="_required">*</span></label>
                            <input type="date" name="_end_time" class="form-control _end_time" required value="{{old('_end_time')}}" >
                            
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_main_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>{{__('label._allow_all_branch')}}:</label>
                                <select class="form-control" name="_main_status">
                                  <option value="0">No</option>
                                  <option value="1">Yes</option>
                                </select>
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
                                            <th class="text-left" >Item</th>
                                            <th class="text-left" >Base Unit</th>
                                            <th class="text-left" >Con. Qty</th>
                                            <th class="text-left" >Tran. Unit</th>
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left" >Status</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="hidden" name="inputs_id[]" value="0">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" required>
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              
                                              <td >
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val " readonly name="_main_unit_val[]" />
                                              </td>
                                              <td>
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="0" >
                                              </td>
                                              <td>
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                             
                                              <td class="">
                                                <select class="form-control _status" name="_status[]">
                                                 
                                                  @forelse(common_status() as $key=>$val)
                                                    <option value="{{$key}}">{{$val ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                               <td colspan="5" class="text-right"><b>Total</b></td>
                                              <td>
                                                <input type="number" min="0" step="any" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                             
                                              <td></td>
                                              
                                            
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                     
                        
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
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

  var after_desimal=4;

  @if(empty($form_settings))
    $("#form_settings").click();
  @endif
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  var _item_row_count =1;
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


$(document).on('change','._main_transection_unit',function(){
  var __this = $(this);
  var conversion_qty = $('option:selected', this).attr('attr_conversion_qty');
  $(document).find("._main_unit_conversion").val(conversion_qty);
})
  

  $(document).on('keyup','._main_item__search_item_id',delay(function(e){
    $(document).find('._main_item__search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
console.log("ok")

  var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered" style="width: 350px;">
                            <thead>
                            <tr>
                              <th>ID</th>
                              <th>Code</th>
                              <th>Name</th>
                              <th>Unit</th>
                              <th>Pack Size</th>
                              <th>Brand</th>
                              <th>Manufacture</th>
                            </tr>
                            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]?. _manufacture_company;
                         search_html += `<tr class="_main_item_row_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td>
                                        <td>${data[i]?._code }</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_unit_id" class="_item_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                  <input type="hidden" name="_base_unit_id" class="_base_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_base_unit_name" class="_base_unit_name" value="${data[i]?._units?._name}">
                                   </td>
                                   
                                   <td>${data[i]?._units?._name }</td>
                                   <td>${data[i]?._pack_size?._name }</td>
                                   <td>${data[i]?._brands?._name }</td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="4">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('._main_item_search_box_item').html(search_html);
      _gloabal_this.parent('div').find('._main_item_search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','._main_item_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _main_base_unit = $(this).find('._item_unit_id').val();
  var _main_base_unit_name  = $(this).find('._base_unit_name').val();

  var self = $(this);

    var request = $.ajax({
      url: "{{url('item-wise-units')}}",
      method: "GET",
      data: { item_id:_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      $(document).find('._main_transection_unit').html("")
      $(document).find("._main_transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });


  $(document).find("#_main_item__search_item_id").val(_name);
  $(document).find("._main_item_id").val(_id);
  $(document).find("._main_base_unit").val(_main_base_unit);
  $(document).find("._main_base_unit_name").val(_main_base_unit_name);


  $('._main_item_search_box_item').hide();
  $('._main_item_search_box_item').removeClass('search_box_show').hide();
  
})
  

 $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


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
            search_html +=`<div class="card"><table class="table table-bordered" style="width: 350px;">
                            <thead>
                            <tr>
                              <th>ID</th>
                              <th>Code</th>
                              <th>Name</th>
                              <th>Unit</th>
                              <th>Pack Size</th>
                              <th>Brand</th>
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
                                        <td>${data[i]?._code }</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                   
                                   </td>
                                   
                                   <td>${data[i]?._units?._name }</td>
                                   <td>${data[i]?._pack_size?._name }</td>
                                   <td>${data[i]?._brands?._name }</td>
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

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _item_unit_id = $(this).find('._item_unit_id').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).find('._unique_barcode').val());

    var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();
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
  


  
    


 var _item_row_count = _ref_counter;
  if(_unique_barcode ==1){
    _new_barcode_function(_item_row_count);
  }
  
  if(isNaN(_item_vat)){ _item_vat=0 }
  _vat_amount = ((_item_rate*_item_vat)/100)
  

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._unit_id').val(_item_unit_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._code').val(_item_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_item_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_item_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat_amount').val(_vat_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('._status').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_item_rate);
 var _ref_counter = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();

 $(this).parent().parent().parent().parent().parent().parent().find('._base_rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);
 
  var _item_row_count = _ref_counter;
  if(_unique_barcode ==1){
    _new_barcode_function(_item_row_count);
  }

  _purchase_total_calculation();
  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();
  
})

$(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $('.search_box_main_ledger').hasClass('search_box_show');
    var search_box_purchase_order= $('.search_box_purchase_order').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }

    if(search_box_main_ledger ==true){
      $('.search_box_main_ledger').removeClass('search_box_show').hide();
    }

    if(search_box_purchase_order ==true){
      $('.search_box_purchase_order').removeClass('search_box_show').hide();
    }
})





$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _item_vat = $(this).closest('tr').find('._vat').val();
  var _wastage_rate = $(this).closest('tr').find('._wastage_rate').val();
  var conversion_qty = parseFloat($(this).closest('tr').find('.conversion_qty').val());


   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_wastage_rate)){ _wastage_rate   = 0 }
   if(isNaN(conversion_qty)){ conversion_qty   = 1 }
    

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   var _value = parseFloat(_rate*_qty).toFixed(after_desimal);
   
  $(this).closest('tr').find('._value').val(_value);
  var _wastage_amt  = _math_round((_wastage_rate*_value)/100);
  $(this).closest('tr').find('._wastage_amt').val(_wastage_amt);
    _purchase_total_calculation();
    
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
  var _rate =parseFloat( __this.closest('tr').find('._rate').val());
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


   var _value = parseFloat(converted_price_rate*_qty).toFixed(after_desimal);
 __this.closest('tr').find('._rate').val(converted_price_rate);
 __this.closest('tr').find('._value').val(_value);
  __this.closest('tr').find('._vat_amount').val(_vat_amount);
  __this.closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();


}


$(document).on('change','.addition__status',function(){
  _cost_and_sales_amt_cal();
})
$(document).on('keyup','._amount',function(){
    _cost_and_sales_amt_cal();
})

function _cost_and_sales_amt_cal(){
    // Total Amount Calculations
    var _addition_total_amount =0;
    var _cost_total_cal =0;
    $(document).find("._amount").each(function() {
        var line_value = parseFloat($(this).val());
          if(isNaN(line_value)){ line_value=0 }
          _addition_total_amount +=parseFloat(line_value);
        var addition__status = $(this).closest('tr').find('.addition__status').val();
        if(addition__status ==1){
            _cost_total_cal +=parseFloat(line_value);
        }
      });
    var _total_value_amount = $("._total_value_amount").val();
    if(isNaN(_total_value_amount )){ _total_value_amount =0 }

      var _cost_price = parseFloat(parseFloat(_total_value_amount)+parseFloat(_cost_total_cal)).toFixed(after_desimal);
      var _sales_price = parseFloat(parseFloat(_total_value_amount)+parseFloat(_addition_total_amount)).toFixed(after_desimal);
      _addition_total_amount = parseFloat(_addition_total_amount).toFixed(after_desimal);
    $(document).find("._total_amount").val(parseFloat(_addition_total_amount));

  $(document).find("#_cost_price").val(_cost_price)
 // $(document).find("#_sales_price").val(_sales_price)

 var _sales_price = $("#_sales_price").val();
  var _cost_price = $("#_cost_price").val();
  if(isNaN(_sales_price)){_sales_price=0}
  if(isNaN(_cost_price)){_cost_price=0}

  var _gp_amount = parseFloat(parseFloat(_sales_price)-parseFloat(_cost_price)).toFixed(after_desimal);
  if(isNaN(_gp_amount)){_gp_amount=0}

  var _gp_per = parseFloat((parseFloat(_gp_amount)/parseFloat(_sales_price))*100).toFixed(after_desimal);
  if(isNaN(_gp_per)){_gp_per=0}

    $(document).find("#_gp_amount").val(_gp_amount);
    $(document).find("#_gp_per").val(_gp_per);

}

$(document).on('keyup',"#_sales_price",function(){
  var _sales_price = $("#_sales_price").val();
  var _cost_price = $("#_cost_price").val();
  if(isNaN(_sales_price)){_sales_price=0}
  if(isNaN(_cost_price)){_cost_price=0}

  var _gp_amount = parseFloat(parseFloat(_sales_price)-parseFloat(_cost_price)).toFixed(after_desimal);;
if(isNaN(_gp_amount)){_gp_amount=0}
  var _gp_per = parseFloat((parseFloat(_gp_amount)/parseFloat(_sales_price))*100).toFixed(after_desimal);
  if(isNaN(_gp_per)){_gp_per=0}

    $(document).find("#_gp_amount").val(_gp_amount);
    $(document).find("#_gp_per").val(_gp_per);

})

$(document).on('keyup',"#_gp_amount",function(){
 var _gp_amount = $("#_gp_amount").val();
  var _cost_price = $("#_cost_price").val();
  if(isNaN(_gp_amount)){_gp_amount=0}
  if(isNaN(_cost_price)){_cost_price=0}

  var _sales_price = parseFloat(parseFloat(_gp_amount)+parseFloat(_cost_price)).toFixed(after_desimal);;
if(isNaN(_sales_price)){_sales_price=0}

$("#_sales_price").val(_sales_price)
  var _gp_per = parseFloat((parseFloat(_gp_amount)/parseFloat(_sales_price))*100).toFixed(after_desimal)
  if(isNaN(_gp_per)){_gp_per=0}

    $(document).find("#_gp_amount").val(_gp_amount);
    $(document).find("#_gp_per").val(_gp_per);

})




 function _purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _wastage_amt =0;
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
      $(document).find("._wastage_amt").each(function() {
        var line__vat = parseFloat($(this).val());
        if(isNaN(line__vat)){ line__vat=0 }
          _wastage_amt +=parseFloat(line__vat);
      });
      $("._total_qty_amount").val(_total_qty);

      if(isNaN(_wastage_amt)){_wastage_amt=0}

      $("._total_wastage_amt").val(_wastage_amt);
      var _total = parseFloat(_total__value);;
      $("._total_value_amount").val(_total);
      _cost_and_sales_amt_cal();
  }





function purchase_row_add(event){
   event.preventDefault();
      

       _item_row_count= $("._item_row_count").val();
      $("._item_row_count").val((parseFloat(_item_row_count)+1));
     var  _item_row_count = (parseFloat(_item_row_count)+1);
     $("#area__purchase_details").append(` <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                               <td>
                                                <input type="hidden" name="inputs_id[]" value="0">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" required>
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              <td >
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td>
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="0" >
                                              </td>
                                              <td>
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_qty[]" class="form-control _qty _common_keyup" value="0">
                                              </td>
                                              
                                              <td class="">
                                                <select class="form-control _status" name="_status[]">
                                                 
                                                  @forelse(common_status() as $key=>$val)
                                                    <option value="{{$key}}">{{$val ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
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

 var _purchase_row_single_new =``;

  



  

//_new_barcode_function(_item_row_count);
  function _new_barcode_function(_item_row_count){
      $('#'+_item_row_count+'__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }


 

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

