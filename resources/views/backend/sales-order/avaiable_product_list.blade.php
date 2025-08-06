@extends('backend.layouts.app')
@section('title',$page_name)

@section('css')
<style>
        .loading-spinner {
            display: none;
            text-align: center;
        }
        .cartItemNumber{
          color: red;
          font-weight: bold;
        }
    </style>
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp
    

    <div class="container pt-3">
        <div class="row mb-4">
            <div class="col-md-2 mb-2">
                <input type="text" id="search-name" class="form-control" placeholder="Search by Name">
            </div>
            <div class="col-md-2  mb-2">
                <input type="text" id="search-code" class="form-control" placeholder="Search by Code">
            </div>
            <div class="col-md-2  mb-2">
                <select id="search-category" class="form-control">
                    <option value="">Filter by Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->_name }}</option>
                    @endforeach
                </select>
            </div>
            @can('sales-order-create')
            <div class="col-md-2  mb-2">
                <a class="btn btn-info" href="{{route('sales-order.create')}}"><i class="fas fa-cart-plus"></i> <span class="cartItemNumber"></span></a>
            </div>
            <div class="col-md-2  mb-2">
                <button class="btn btn-sm btn-danger clearCardData" ><i class="fas fa-cart-plus"></i> Clear Cart</button>
            </div>

            @endif
        </div>

        <div class="row" id="product-list">
            @include('backend.sales-order.partials', ['data' => []])
        </div>
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

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
                    <label for="modal_transection_unit" class="form-label">Conversion With Base Unit</label>
                     <input type="text" name="modal_conversion_qty" class="form-control modal_conversion_qty" id="modal_conversion_qty" readonly>
                     <input type="text" name="modal_main_unit_val" class="form-control modal_main_unit_val" id="modal_main_unit_val" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_pack_size" class="form-label">Pack Size</label>
                    <input type="text" name="modal_pack_size" class="form-control modal_pack_size" id="modal_pack_size" readonly>
                    <input type="hidden" name="modal_base_rate" class="form-control modal_base_rate" id="modal_base_rate" readonly>
                    <input type="hidden" name="modal_base_unit_id" class="form-control modal_base_unit_id" id="modal_base_unit_id" readonly>
                    <input type="hidden" name="modal_main_unit_val" class="form-control modal_main_unit_val" id="modal_main_unit_val" readonly>
                    
                </div>
                
                <div class="form-group">
                    <label for="modal_sales_qty" class="form-label">Sales Quantity</label>
                    <input type="number" step="any" min="0" id="modal_sales_qty" class="form-control modal_sales_qty modal_common_keyup" placeholder="Qty" value="0">
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

@endsection

@section('script')
    <script>




        let page = 1;
let loading = false;
let hasMoreItems = true; // Flag to track whether more items are available

function loadProducts(reset = false) {
    if (!loading && hasMoreItems) {
        loading = true;
        $('.loading-spinner').show();

        const name = $('#search-name').val();
        const code = $('#search-code').val();
        const category = $('#search-category').val();

        $.ajax({
            url: "{{ route('avaiable_product_list') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                page: page,
                name: name,
                code: code,
                category: category,
            },
            success: function (response) {
                if (reset) {
                    $('#product-list').html(response);
                } else {
                    $('#product-list').append(response);
                }

                // Check if there are more items
                if ($.trim(response) === '') {
                    hasMoreItems = false;
                }

                $('.loading-spinner').hide();
                loading = false;
            },
            error: function () {
                $('.loading-spinner').hide();
                loading = false;
            }
        });
    }
}

// Infinite scroll
$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        if (hasMoreItems) {
            page++;
            loadProducts();
        }
    }
});

// Search filter
$('#search-name, #search-code, #search-category').on('input change', function () {
    page = 1;
    hasMoreItems = true; // Reset the flag for new filters
    loadProducts(true);
});

// Initial load
$(document).ready(function () {
    loadProducts(true);
});



$(document).on('click', '.add-to-cart-btn', function () {
    const product = $(this).data('product');
    console.log(product);
    var _id = product.id;
    $('#modal_item_id').val(product?.id);
    $('#modal_item_code').val(product?._code);
    $('#modal_item_name').val(product?._name);
    $('#modal_pack_size').val(product?._pack_size_name);
    $('#modal_base_unit_id').val(product?._unit_id);
    $('#modal_main_unit_val').val(product?._unit_name);
    $('#modal_conversion_qty').val(1);
    $('#modal_rate').val(product?._sale_rate);
    $('#modal_base_rate').val(product?._sale_rate);
    //$('#modal_sales_qty').val(0);
    $('#modal_quantity').val(0);
    $('#modal_discount_rate').val(0);
    $('#modal_discount_amount').val(0);
    $('#modal_line_total').val(0);
    $('#addItemModal').modal('show');


  


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


});



  var cart = JSON.parse(sessionStorage.getItem('cart')) || [];

$(document).ready(function(){

    var cart = JSON.parse(sessionStorage.getItem('cart')) || [];
     $(document).find(".cartItemNumber").text(cart?.length);
    console.log(cart);
    
  })

$(document).on('click','.clearCardData',function(){
  sessionStorage.setItem('cart', JSON.stringify([]));
  var cart = JSON.parse(sessionStorage.getItem('cart')) || [];
     $(document).find(".cartItemNumber").text(cart?.length);
})

// Add product to cart
$('#addItemToCart').on('click', function () {
    const product = {
        modal_item_code: $('#modal_item_code').val(),
        modal_item_name: $('#modal_item_name').val(),
        modal_item_id: $('#modal_item_id').val(),
        modal_pack_size: $('#modal_pack_size').val(),
        modal_main_unit_val: $('#modal_main_unit_val').val(),
        modal_main_unit_val: $('#modal_main_unit_val').val(),
        modal_transection_unit: parseFloat($('#modal_transection_unit').val()),
        modal_conversion_qty: parseFloat($('#modal_conversion_qty').val()),
        modal_base_rate: parseFloat($('#modal_base_rate').val()),
        modal_base_unit_id: parseFloat($('#modal_base_unit_id').val()),
        modal_sales_qty: parseFloat($('#modal_sales_qty').val()),
        modal_free_qty: parseFloat($('#modal_free_qty').val()),
        modal_quantity: parseFloat($('#modal_quantity').val()),
        modal_rate: parseFloat($('#modal_rate').val()),
        modal_discount_rate: parseFloat($('#modal_discount_rate').val()),
        modal_discount_amount: parseFloat($('#modal_discount_amount').val()),
        modal_line_total: parseFloat($('#modal_line_total').val()),
    };

    // Validate product details
    if (product?.modal_item_code && product?.modal_quantity > 0) {
        cart.push(product);
         sessionStorage.setItem('cart', JSON.stringify(cart)); //

        $('#addItemModal').modal('hide');

        // Clear modal input fields
        $('#addItemModal input').val('');
        $('#addItemModal select').prop('selectedIndex', 0); 

        $(document).find(".cartItemNumber").text(cart?.length);
        console.log(cart);


    } else {
        alert('Please fill out all fields correctly.');
    }
});




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
 // var conversion_qty = parseFloat($(document).find('.modal_conversion_qty').val());
  var _item_discount = 0;
console.log(conversion_qty)



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


    </script>
@endsection