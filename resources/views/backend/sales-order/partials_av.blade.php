@foreach ($data as $key=> $product)
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-1">
    <div class="card bg-light d-flex flex-fill">
        
        <div class="card-body pt-1">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead" style="font-size: 18px;font-weight: 900;color: green;"><b>{{ $product->_name ?? '' }}</b></h2>
                    <div style="color: orange;font-weight: bolder;font-size: 14px;">
                        {{ $product->_generic_name ?? '' }}
                    </div>
                    <p class="text-muted text-sm">
                        @if($product->_description !='')
                        <b>Composition:</b><br>
                         {{ $product->_description ?? '' }} <br>
                         @endif
                        <b>{{__('label._pack_size_id')}}        </b> <span style="padding-left: 30px;">: {{ $product->_pack_size_name ?? '' }}</span><br>
                        <b>{{__('label._code')}}               </b> <span style="padding-left: 55px;">: {{ $product->_code ?? '' }}</span> <br>
                        <b>Trade Price                           </b> <span style="padding-left: 13px;">: TK. {{ _report_amount($product->_sale_rate ?? 0) }}</span><br>
                        <b>MRP                                  </b> <span style="padding-left: 54px;">: TK. {{ _report_amount($product->_mrp_price ?? 0 )}}</span>
                        
                    </p>
                    
                </div>
                <div class="col-5 text-center">
                    <img 
                        src="{{ asset($product->_image ?? $settings->logo) }}" 
                        
                        alt="product-image" 
                        class="img-fluid" style="border: 1px solid orange;padding: 5px;margin-bottom: 5px;border-radius: 5px;"><br>
                        <div style="border: 1px solid orange;padding: 5px;border-radius: 5px;"><b>Origin  : {!! $product->_oringin ?? '' !!}</b></div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col" style="border: 1px solid grey;padding: 5px;border-radius: 5px;">
                    
                            Stock  : @if($product->_balance > 1)
                            <button class="btn btn-sm btn-success"> Available </button>@else <button class="btn btn-sm btn-danger">Low</button> @endif
                </div>
                <div class="col" style="    border: 1px solid grey;padding: 5px;margin-left: 5px;border-radius: 5px;">
                     <div class="text-right">
                        <button class="btn btn-sm btn-primary add-to-cart-btn" style="width:100%;" 
                            data-product='{{json_encode($product)}}'>  <i class="fas fa-cart-plus"></i>  Add to Cart</button>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endforeach
