@foreach ($data as $key=> $product)
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-4">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            {{ $product->_generic_name }}
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{ $product->_name ?? '' }}</b></h2>
                    
                    <p class="text-muted text-sm">
                        <b>{{__('label.id')}}: </b> {{ $product->id ?? '' }} <br>
                        <b>{{__('label._code')}}: </b> {{ $product->_code ?? '' }} <br>
                        <b>{{__('label._pack_size_id')}}: </b> {{ $product->_pack_size_name ?? '' }}<br>
                        <b>{{__('label._unit_id')}}: </b> {{ $product->_unit_name ?? '' }}<br>
                        <b>{{__('label._brand_id')}}: </b> {{ $product->brand_name ?? '' }}
                    </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li>
                            <span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> 
                            Stock : @if($product->_balance > 1)
                            <span class="btn btn-sm btn-success"> Available </span>@else <span class="btn btn-sm btn-danger">LOW</span> @endif
                        </li>
                        <li class="text-bold">
                            <span class="fa-li"><i class="fas fa-lg fa-tags"></i></span> 
                            TP: TK. {{ _report_amount($product->_sale_rate ?? 0) }}
                        </li>
                        <li class="text-bold">
                            <span class="fa-li"><i class="fas fa-lg fa-tags"></i></span> 
                            MRP: TK. {{ _report_amount($product->_mrp_price ?? 0 )}}
                        </li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img 
                        src="{{ asset($product->_image ?? $settings->logo) }}" 
                        
                        alt="product-image" 
                        class="img-circle img-fluid">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <button class="btn btn-primary add-to-cart-btn" 
                            data-product='{{json_encode($product)}}'>  <i class="fas fa-cart-plus"></i>  Add to Cart</button>
                
                
            </div>
        </div>
    </div>
</div>
@endforeach
