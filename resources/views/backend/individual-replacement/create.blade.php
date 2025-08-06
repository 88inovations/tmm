@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
<style type="text/css">
  .box_shadow{
    box-shadow: 1px 1px 1px 1px #f1f1f1;
  }
</style>
@endsection
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
              <a class="m-0 _page_name" href="{{ route('individual-replacement.index') }}">{!! $page_name ?? '' !!} </a>
           
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
                @can('individual-replacement-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('individual-replacement.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
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
    $_show_short_note =  $form_settings->_show_short_note ?? 0;
    $_show_payment_terms =  $form_settings->_show_payment_terms ?? 0;
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
              </div>
              <div class="card-body">
               {!! Form::open(array('route' => 'individual-replacement.store','method'=>'POST')) !!}
                <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name"  value="individual_replace_masters">
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
                      <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_text">Invoice number:</label>
                              <input type="number" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number')}}" placeholder="Invoice number" readonly >
                            <input type="hidden" id="_search_form_value" name="_search_form_value" class="_search_form_value" value="13" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Complain No:<span class="_required">*</span></label>
                              <input type="text" required id="_search_order_ref_id" name="_search_order_ref_id" class="form-control _search_order_ref_id" value="{{old('_order_ref_id')}}" placeholder="Complain No" >
                              <input type="hidden" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id')}}" placeholder="Complain No" >
                              <div class="search_box_purchase_order"></div>
                                
                            </div>
                        </div>
                        

                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control _branch_id" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2  ">
                            <div class="form-group ">
                                <label>Cost Center:<span class="_required">*</span></label>
                               <select class="form-control" name="_cost_center_id" required >
                                   @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance')}}" placeholder="Referance" >
                                
                            </div>
                        </div>
                  </div>
                  <br>
                  <div class="row">

                  <div class="col-md-4 box_shadow"> <!-- Old item information -->
                    <h4 class="text-center">Old Item Information</h4>
                     @include('backend.individual-replacement.item_old')
                  </div> <!-- Old item information -->

                  <div class="col-md-4 box_shadow"> <!-- Individual Stock In -->
                    <h4 class="text-center">Individual Stock In</h4>
                      @include('backend.individual-replacement.item_in')
                  </div> <!-- Individual Stock In -->

                  <div class="col-md-4 box_shadow"><!-- Individual Stock Out -->
                    <h4 class="text-center">Individual Stock Out</h4>
                      @include('backend.individual-replacement.item_out')
                  </div><!-- Individual Stock Out -->

                </div>
                <br>
                <div class="form-group row ">
                        <label for="_note" class="col-sm-2 col-form-label">Note:<span class="_required">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="_note" required class="form-control" id="_note" placeholder="Note">
                         
                        </div>
                      </div>
              
                <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
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
    <form action="{{ url('individual-replacement-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$page_name}} Form Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <div class="form-group row">
        <label for="_default_rep_manage_account" class="col-sm-5 col-form-label">Default Replacement Manage Account</label>
        <select class="form-control col-sm-7 " name="_default_rep_manage_account">
          @foreach($p_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_rep_manage_account))@if($form_settings->_default_rep_manage_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
        <div class="form-group row">
        <label for="_default_sales_dicount" class="col-sm-5 col-form-label">Sales Discount Account</label>
        <select class="form-control col-sm-7 " name="_default_sales_dicount">
          @foreach($p_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_sales_dicount))@if($form_settings->_default_sales_dicount==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
       
      
      <div class="form-group row">
        <label for="_default_discount" class="col-sm-5 col-form-label">Default Discount Account</label>
        <select class="form-control col-md-7 " name="_default_discount">
          @foreach($dis_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_discount))@if($form_settings->_default_discount==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_vat_account" class="col-sm-5 col-form-label">Default VAT Account</label>
        <select class="form-control col-md-7 " name="_default_vat_account">
          @foreach($dis_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_vat_account))@if($form_settings->_default_vat_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
       
       
      <div class="form-group row">
        <label for="_inline_discount" class="col-sm-5 col-form-label">Show Inline Discount</label>
        <select class="form-control col-sm-7" name="_inline_discount">
         
          <option value="0" @if(isset($form_settings->_inline_discount))@if($form_settings->_inline_discount==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_inline_discount))@if($form_settings->_inline_discount==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_vat" class="col-sm-5 col-form-label">Show VAT</label>
        <select class="form-control col-sm-7" name="_show_vat">
         
          <option value="0" @if(isset($form_settings->_show_vat))@if($form_settings->_show_vat==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_vat))@if($form_settings->_show_vat==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_short_note" class="col-sm-5 col-form-label">Show Short Note</label>
        <select class="form-control col-sm-7" name="_show_short_note">
         
          <option value="0" @if(isset($form_settings->_show_short_note))@if($form_settings->_show_short_note==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_short_note))@if($form_settings->_show_short_note==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_barcode" class="col-sm-5 col-form-label">Show Barcode</label>
        <select class="form-control col-sm-7" name="_show_barcode">
          <option value="0" @if(isset($form_settings->_show_barcode))@if($form_settings->_show_barcode==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_barcode))@if($form_settings->_show_barcode==1) selected @endif @endif>YES</option>
        </select>
      </div>
      
      
      
      
      <div class="form-group row">
        <label for="_show_p_balance" class="col-sm-5 col-form-label">Invoice Show Previous Balance</label>
        <select class="form-control col-sm-7" name="_show_p_balance">
          <option value="0" @if(isset($form_settings->_show_p_balance))@if($form_settings->_show_p_balance==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_p_balance))@if($form_settings->_show_p_balance==1) selected @endif @endif>YES</option>
        </select>
      </div>
       <div class="form-group row">
        <label for="_invoice_template" class="col-sm-5 col-form-label">Invoice Template</label>
        <select class="form-control col-sm-7" name="_invoice_template">
          <option value="1" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==1) selected @endif @endif>Template A</option>
          <option value="2" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==2) selected @endif @endif>Template B</option>
          <option value="3" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==3) selected @endif @endif>Template C</option>
          <option value="4" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==4) selected @endif @endif>Template D</option>
        </select>
      </div>
         
      
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

@endsection

@section('script')

<script type="text/javascript">

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

$('#reservationdate_delivery').datetimepicker({
        format:default_date_formate

});


$(document).on('keyup','._search_order_ref_id',delay(function(e){
    $(document).find('._search_order_ref_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _branch_id = $(document).find('._master_branch_id').val();

  var request = $.ajax({
      url: "{{url('warranty-search')}}",
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
                              <th style="border:1px solid #ccc;text-align:center;">Customer</th>
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
      url: "{{url('warranty-detail-search')}}",
      method: "POST",
      data: { _purchase_main_id,_main_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {
      var data = result?.[0];
     console.log(data)

     var date1 = new Date();
    var date2 = new Date(data?._sales_date);
    var diffTime = Math.abs(date2 - date1);
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    var _warranty_comment = "This Item Sold "+diffDays+" Days Ago.";

    console.log(diffDays + " days");


     $("#_old_item_name").val(data?._item_name);
     $("#_old_item_id").val(data?._item_id);
     $("#_old_barcode").val(data?._barcode);
     $("#_old_p_p_l_id").val(data?._p_p_l_id);
     $("#_old_manufacture_date").val(data?._manufacture_date);
     $("#_old_expire_date").val(data?._expire_date);
     
     $("#_old_short_note").val('');
     $("#_old_qty").val(data?._qty);
     $("#_old_rate").val(data?._rate);
     $("#_old_sales_rate").val(data?._sales_rate);
     $("#_old_sales_date").val(data?._sales_date);
     $("#_old_warranty_date").val(data?._warranty_date);
     $("#_old_discount").val(data?._discount);
     $("#_old_discount_amount").val(data?._discount_amount);
     $("#_old_vat").val(data?._vat);
     $("#_old_vat_amount").val(data?._vat_amount);
     $("#_old_value").val(((data?._qty)*(data?._sales_rate)));
     $("#_old_warranty_text").val(data?._warrenty_name);
     $("#_old_warranty_comment").val(_warranty_comment);
     $("#_old_warranty_comment_text").text(_warranty_comment);

     $("#_old_warranty").val(data?._warranty);

     $("#_supplier_name").val(data?._supplier_name);
     $("#_supplier_id").val(data?.supplier_id);
     
     $("#_customer_name").val(data?._customer_name);
     $("#_customer_id").val(data?._customer_id);
     
     $("#_old_cost_center_id").val(data?._cost_center_id);
     $("#_in_cost_center_id").val(data?._cost_center_id);
     $("#_out_cost_center_id").val(data?._cost_center_id);

     $("#_old_store_id").val(data?._store_id);
     $("#_in_store_id").val(data?._store_id);
     $("#_out_store_id").val(data?._store_id);

     $("#_old_store_salves_id").val(data?._store_salves_id);
     $("#_in_store_salves_id").val(data?._store_salves_id);
     $("#_out_store_salves_id").val(data?._store_salves_id);




      
    })



  })




  $(document).on('keyup','._in_item_name',delay(function(e){
    $(document).find('._in_item_name').removeClass('required_border');
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
            search_html +=`<div class="card"><table style="width: 400px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]. _manufacture_company;
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                  <input type="hidden" name="_item_warranty" class="_item_warranty" value="${data[i]._warranty}">
                                   </td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="4">No Data Found</th></thead><tbody></tbody></table></div>`;
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
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).find('._unique_barcode').val());
  var _item_warranty = parseFloat($(this).find('._item_warranty').val());
console.log(_name)
console.log(_id)

$("._in_item_name").val(_name)
$("._in_item_id ").val(_id)
$("#_in_barcode ").val(_item_barcode)
$("#_in_qty ").val(1)
$("#_in_rate ").val(0)
$("#_in_sales_rate").val(0)
$("#_in_vat").val(_item_vat)
$("#_in_vat_amount").val(_item_vat)
$("#_in_value").val(0)
$("#_in_warrenty").val(_item_warranty)
  


$("#_out_item_name").val(_name)
$("#_out_item_id ").val(_id)
$("#_out_barcode ").val(_item_barcode)
$("#_out_qty ").val(1)
$("#_out_rate ").val(0)
$("#_out_sales_rate").val(0)
$("#_out_vat").val(_item_vat)
$("#_out_vat_amount").val(_item_vat)
$("#_out_value").val(0)
$("#_out_warrenty").val(_item_warranty)
  

  
 
  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();

  individual_out_calculation();
    individual_in_calculation();
  
})

function individual_in_calculation(){
      var _in_discount = $("#_in_discount").val();
      var _in_discount_amount = $("#_in_discount_amount").val();

      var _in_qty = parseFloat($("#_in_qty").val());
      var _in_rate = parseFloat($("#_in_rate").val());

      var _in_vat = $("#_in_vat").val();
      var _in_vat_amount = $("#_in_vat_amount").val();
      var _in_value = $("#_in_value").val();

      var res = _in_discount.match(/%/gi);
      if(res){
         res = _in_discount.split("%");
        res= parseFloat(res);
        on_invoice_discount = ((_in_qty*_in_rate)*res)/100
        $("#_in_discount").val(_in_discount)

      }else{
        on_invoice_discount = _in_discount;
      }

      var _vat_res = _in_vat.match(/%/gi);
      if(_vat_res){
         _vat_res = _in_vat.split("%");
        _vat_res= parseFloat(_vat_res);
        on_invoice_vat = ((_in_qty*_in_rate)*_vat_res)/100
        $("#_in_vat").val(_in_vat)

      }else{
        on_invoice_vat = _in_vat;
      }

       $("#_in_vat_amount").val(on_invoice_vat);

       $("#_in_value").val((_in_qty*_in_rate));
       var _in_net_total= parseFloat(_in_qty*_in_rate)+ parseFloat(on_invoice_vat)-parseFloat(on_invoice_discount);

       $("#_in_net_total").val(_in_net_total);
 }

function individual_out_calculation(){
      var _out_discount = $("#_out_discount").val();
      var _out_discount_amount = $("#_out_discount_amount").val();

      var _out_qty = parseFloat($("#_out_qty").val());
      var _out_rate = parseFloat($("#_out_rate").val());
      var _out_sales_rate = parseFloat($("#_out_sales_rate").val());

      var _out_vat = $("#_out_vat").val();
      var _out_vat_amount = $("#_out_vat_amount").val();
      var _out_value = $("#_out_value").val();

      var res = _out_discount.match(/%/gi);
      if(res){
         res = _out_discount.split("%");
        res= parseFloat(res);
        on_outvoice_discount = ((_out_qty*_out_sales_rate)*res)/100
        $("#_out_discount").val(_out_discount)

      }else{
        on_outvoice_discount = _out_discount;
      }

      var _vat_res = _out_vat.match(/%/gi);
      if(_vat_res){
         _vat_res = _out_vat.split("%");
        _vat_res= parseFloat(_vat_res);
        on_outvoice_vat = ((_out_qty*_out_sales_rate)*_vat_res)/100
        $("#_out_vat").val(_out_vat)

      }else{
        on_outvoice_vat = _out_vat;
      }

       $("#_out_vat_amount").val(on_outvoice_vat);

       $("#_out_value").val((_out_qty*_out_sales_rate));
       var _out_net_total= parseFloat(_out_qty*_out_sales_rate)+ parseFloat(on_outvoice_vat)-parseFloat(on_outvoice_discount);

       $("#_out_net_total").val(_out_net_total);


 }

 $(document).on("change","#_in_discount",function(){
  var _in_qty = parseFloat($("#_in_qty").val());
  var _in_rate = parseFloat($("#_in_rate").val());

  var _in_discount = $("#_in_discount").val();
  var res = _in_discount.match(/%/gi);
  if(res){
     res = _in_discount.split("%");
    res= parseFloat(res);
    on_invoice_discount = ((_in_qty*_in_rate)*res)/100
    $("#_in_discount").val(_in_discount)

  }else{
    on_invoice_discount = _in_discount;
  }

   $("#_in_discount_amount").val(on_invoice_discount);
    individual_out_calculation();
    individual_in_calculation();
})

 $(document).on('keyup','#_in_discount_amount',function(){
 
  var _qty = $('#_in_qty').val();
  var _rate = $('#_in_rate').val();
  var _sales_rate = $('#_in_sales_rate').val();
  var _discount_amount =  $('#_in_discount_amount').val();
  
   if(isNaN(_discount_amount)){ _discount_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _discount = parseFloat((_discount_amount/(_rate*_qty))*100).toFixed(2);
    $('#_in_discount').val(_discount);
    individual_out_calculation();
    individual_in_calculation();
})

 

 $(document).on("change","#_in_vat",function(){
  var _in_qty = parseFloat($("#_in_qty").val());
  var _in_rate = parseFloat($("#_in_rate").val());

  var _in_vat = $("#_in_vat").val();
  var res = _in_vat.match(/%/gi);
  if(res){
     res = _in_vat.split("%");
    res= parseFloat(res);
    _in_vat_amount = ((_in_qty*_in_rate)*res)/100
    $("#_in_vat").val(_in_vat)

  }else{
    _in_vat_amount = _in_vat;
  }

   $("#_in_vat_amount").val(_in_vat_amount);
    individual_out_calculation();
    individual_in_calculation();
})

 $(document).on('keyup','#_in_vat_amount',function(){
 
  var _qty = $('#_in_qty').val();
  var _rate = $('#_in_rate').val();
  var _sales_rate = $('#_in_sales_rate').val();
  var _in_vat_amount =  $('#_in_vat_amount').val();
  
   if(isNaN(_in_vat_amount)){ _in_vat_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _in_vat_amount = parseFloat((_in_vat_amount/(_rate*_qty))*100).toFixed(2);
    $('#_in_vat_amount').val(_in_vat_amount);
    individual_out_calculation();
    individual_in_calculation();
})



 $(document).on("change","#_out_discount",function(){
  var _out_qty = parseFloat($("#_out_qty").val());
  var _out_rate = parseFloat($("#_out_rate").val());
  var _out_sales_rate = parseFloat($("#_out_sales_rate").val());

  var _out_discount = $("#_out_discount").val();
  var res = _out_discount.match(/%/gi);
  if(res){
     res = _out_discount.split("%");
    res= parseFloat(res);
    on_invoice_discount = ((_out_qty*_out_sales_rate)*res)/100
    $("#_out_discount").val(_out_discount)

  }else{
    on_invoice_discount = _out_discount;
  }

   $("#_out_discount_amount").val(on_invoice_discount);
    individual_out_calculation();
    individual_in_calculation();
})

 $(document).on('keyup','#_out_discount_amount',function(){
 
  var _qty = $('#_out_qty').val();
  var _rate = $('#_out_rate').val();
  var _sales_rate = $('#_out_sales_rate').val();
  var _discount_amount =  $('#_out_discount_amount').val();
  
   if(isNaN(_discount_amount)){ _discount_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _discount = parseFloat((_discount_amount/(_rate*_sales_rate))*100).toFixed(2);
    $('#_out_discount').val(_discount);
    individual_out_calculation();
    individual_in_calculation();
})

 

 $(document).on("change","#_out_vat",function(){
  var _out_qty = parseFloat($("#_out_qty").val());
  var _out_rate = parseFloat($("#_out_rate").val());
  var _out_sales_rate = parseFloat($("#_out_sales_rate").val());

  var _out_vat = $("#_out_vat").val();
  var res = _out_vat.match(/%/gi);
  if(res){
     res = _out_vat.split("%");
    res= parseFloat(res);
    _out_vat_amount = ((_out_qty*_out_sales_rate)*res)/100
    $("#_out_vat").val(_out_vat)

  }else{
    _out_vat_amount = _out_vat;
  }

   $("#_out_vat_amount").val(_out_vat_amount);
    individual_out_calculation();
    individual_in_calculation();
})

 $(document).on('keyup','#_out_vat_amount',function(){
 
  var _qty = $('#_out_qty').val();
  var _rate = $('#_out_rate').val();
  var _out_sales_rate = $('#_out_sales_rate').val();
  var _out_vat_amount =  $('#_out_vat_amount').val();
  
   if(isNaN(_out_vat_amount)){ _out_vat_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_out_sales_rate)){ _out_sales_rate =0 }
   var _out_vat_amount = parseFloat((_out_vat_amount/(_out_sales_rate*_qty))*100).toFixed(2);
    $('#_out_vat_amount').val(_in_vat_amount);
    individual_out_calculation();
    individual_in_calculation();
})

 

 $(document).on('keyup','._in_common_keyup',function(){
 
    individual_out_calculation();
    individual_in_calculation();
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

