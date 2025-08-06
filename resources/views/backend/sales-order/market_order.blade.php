@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('sales-order.index') }}">{!! $page_name ?? '' !!} </a>
            
          </div>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     @include('backend.message.message')

     @php
$auth_user = \Auth::user();
     @endphp
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <form action="{{url('market_order_save')}}" method="POST">
              @csrf
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 ">
                    <div class="form-group">
                      <label class="mr-2" for="_date">{{__('label._date')}}:</label>
                      <input type="date" id="_date" name="_date" class="form-control _date" value="{{old('_date',date('Y-m-d'))}}"   >
                        
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_delivery_date">{{__('label._delivery_date')}}:</label>
                              <input type="date" id="_delivery_date" name="_delivery_date" class="form-control _delivery_date" value="{{old('_delivery_date')}}"   >
                                
                            </div>
                        </div>
                @include('basic.org_create')

                @if($auth_user->user_type=='user')

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

                <div class="col-xs-12 col-sm-12 col-md-6">
                  <label for="_customer_id">{{__('label._customer_id')}} <span class="_required">*</span> </label>
                  <select class="form-control " name="_customer_id" id="_customer_id" required>
                    <option value="">Select Customer</option>
                    @forelse($customers as $customer)
                    <option value="{{$customer->id ?? '' }}">{!! $customer->_code ?? '' !!}- {!! $customer->_name ?? '' !!}-{!! $customer->_phone ?? '' !!}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>

              </form>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

<div class="container">
    <h4 class="text-center mb-3">Create Sales Order</h4>

    <form id="salesOrderForm" method="POST" action="{{ url('sales.order.store') }}">
        @csrf

        <!-- Customer Selection -->
        <div class="card mb-3">
            <div class="card-body">
                <h6>Customer Information</h6>
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label for="customer_id" class="form-label">Select Customer</label>
                        <select id="customer_id" name="customer_id" class="form-control">
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Item Button -->
        <div class="text-center mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
                Add Item
            </button>
        </div>

        <!-- Cart Table -->
        <div class="card mb-3">
            <div class="card-body">
                <h6>Cart Items</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Value</th>
                                <th>Discount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <!-- Items added to the cart will appear here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Invoice Discount and Total -->
        <div class="card mb-3">
            <div class="card-body">
                <h6>Discounts & Total</h6>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="invoice_discount_percentage" class="form-label">Invoice Discount (%)</label>
                        <input type="number" id="invoice_discount_percentage" name="invoice_discount_percentage" class="form-control" placeholder="0">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="invoice_discount_amount" class="form-label">Invoice Discount (Amount)</label>
                        <input type="number" id="invoice_discount_amount" name="invoice_discount_amount" class="form-control" placeholder="0">
                    </div>
                    <div class="col-12 mt-2">
                        <label for="total_amount" class="form-label">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-success">Submit Sales Order</button>
        </div>
    </form>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal_item_id" class="form-label">Item Name</label>
                    <select id="modal_item_id" class="form-control select2">
                        @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->_item }} ({{ $item->_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="modal_quantity" class="form-label">Quantity</label>
                    <input type="number" id="modal_quantity" class="form-control" placeholder="Qty">
                </div>
                <div class="form-group">
                    <label for="modal_rate" class="form-label">Rate per Unit</label>
                    <input type="number" id="modal_rate" class="form-control" placeholder="Rate">
                </div>
                <div class="form-group">
                    <label for="modal_line_discount" class="form-label">Line Discount</label>
                    <input type="number" id="modal_line_discount" class="form-control" placeholder="Discount">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="addItemToCart" class="btn btn-primary">Add Item</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cart = [];
        const cartTableBody = document.getElementById('cartTableBody');
        const totalAmountInput = document.getElementById('total_amount');

        // Add item to cart
        document.getElementById('addItemToCart').addEventListener('click', () => {
            const itemName = document.getElementById('modal_item_id').selectedOptions[0].text;
            const itemId = document.getElementById('modal_item_id').value;
            const quantity = parseFloat(document.getElementById('modal_quantity').value || 0);
            const rate = parseFloat(document.getElementById('modal_rate').value || 0);
            const lineDiscount = parseFloat(document.getElementById('modal_line_discount').value || 0);
            const lineValue = quantity * rate - lineDiscount;

            if (quantity > 0 && rate > 0) {
                cart.push({ itemId, itemName, quantity, rate, lineValue, lineDiscount });

                updateCartTable();
                clearModalInputs();
                $('#addItemModal').modal('hide'); // Close the modal
            } else {
                alert('Please enter valid quantity and rate.');
            }
        });

        // Update Cart Table
        const updateCartTable = () => {
            cartTableBody.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                total += item.lineValue;

                const row = `
                    <tr>
                        <td>${item.itemName}</td>
                        <td>${item.quantity}</td>
                        <td>${item.rate.toFixed(2)}</td>
                        <td>${item.lineValue.toFixed(2)}</td>
                        <td>${item.lineDiscount.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" onclick="editCartItem(${index})">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeCartItem(${index})">Remove</button>
                        </td>
                    </tr>
                `;
                cartTableBody.innerHTML += row;
            });

            totalAmountInput.value = total.toFixed(2);
        };

        // Clear modal input fields
        const clearModalInputs = () => {
            document.getElementById('modal_quantity').value = '';
            document.getElementById('modal_rate').value = '';
            document.getElementById('modal_line_discount').value = '';
        };

        // Remove item from cart
        window.removeCartItem = (index) => {
            cart.splice(index, 1);
            updateCartTable();
        };

        // Edit item in cart
        window.editCartItem = (index) => {
            const item = cart[index];
            document.getElementById('modal_item_id').value = item.itemId;
            document.getElementById('modal_quantity').value = item.quantity;
            document.getElementById('modal_rate').value = item.rate;
            document.getElementById('modal_line_discount').value = item.lineDiscount;

            cart.splice(index, 1);
            updateCartTable();
            $('#addItemModal').modal('show'); // Open the modal
        };
    });
</script>

@endsection

@section('script')

<script type="text/javascript">
 

</script>
@endsection