

<div class="modal-content">
      <div class="modal-header">
      	<button class="btn btn-danger" onclick="modalPrint('printablediv')"><i class="fa fa-print"></i></button>
        <h5 class="modal-title _modal_title"  id="checkAbailableModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body " id="printablediv">
      	<div style="text-align: center;">
      		<h4>Production Item Wise Raw Material Details</h4>
      	</div>
        <div class="card">
				<div class="card-header">
					<h3>Production Items</h3>
				</div>
				<div class="card-body">
					<table class="table" style="width:100%;border-collapse: collapse;">
						<thead>
							<tr>
								<th style="border:1px solid silver;">{{__('label.sl')}}</th>
								<th style="border:1px solid silver;">{{__('label._item_id')}}</th>
								<th style="border:1px solid silver;">{{__('label._qty')}}</th>
								<th style="border:1px solid silver;">{{__('label._unit_id')}}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($_stock_in__item_names as $key=>$val)
							<tr>
								<td style="border:1px solid silver;">{{($key+1)}}</td>
								<td style="border:1px solid silver;">{!! $_stock_in__item_names[$key] ?? '' !!}</td>
								<td style="border:1px solid silver;">{!! $_stock_in__qtys[$key] ?? '' !!}</td>
								<td style="border:1px solid silver;">{!! $_stock_in_main_unit_vals[$key] ?? '' !!}</td>
							</tr>

							@empty
							@endforelse
						</tbody>
					</table>
				</div>
				<div class="card-header">
					<h3>Raw material Details</h3>
				</div>
				<div class="card-body">
					<table class="table" style="width:100%;border-collapse: collapse;">
						<thead>
							<tr>
								<th style="border:1px solid silver;">{{__('label.sl')}}</th>
								<th style="border:1px solid silver;">{{__('label._id')}}</th>
								<th style="border:1px solid silver;">{{__('label._item_id')}}</th>
								<th style="border:1px solid silver;">{{__('label._required_qty')}}</th>
								<th style="border:1px solid silver;">{{__('label.available_qty')}}</th>
								<th style="border:1px solid silver;">{{__('label._unit_id')}}</th>
								<th style="border:1px solid silver;">{{__('label._status')}}</th>
							</tr>
						</thead>
						<tbody>
							@php
							$production_allow=0;
							$sl=0;
							@endphp


							@forelse($single_item_array as $key=>$details)
							@php
							$item_wise_required_qty=0;
							$stock_qty=0
							@endphp

							@forelse($details as $de_key=>$value)
							@if($de_key==0)
							<tr>
								<td style="border:1px solid silver;">{{$sl=($sl+1)}}</td>
								<td style="border:1px solid silver;">{!! $value->_raw_item_id ?? '' !!}</td>
								<td style="border:1px solid silver;">{!! $value->_item ?? '' !!}</td>
								
								<td style="border:1px solid silver;">
									

									{!! array_sum($single_item_array_qty[$value->_raw_item_id]) !!}
								</td>
								<td style="border:1px solid silver;">
									@php
									$pr_val_ab_qty = 0;
									@endphp

									@forelse($abailable_raw_materials as $pr_val)
									@php
									$pr_val_item_id = $pr_val->_item_id ?? 0;
									@endphp
									@if($pr_val_item_id==$value->_raw_item_id)

									@php
								 	$pr_val_ab_qty = $pr_val->ab_qty ?? 0;
									@endphp
									
									{{ $pr_val_ab_qty ?? 0 }}
									@endif

									@empty
									@endforelse
								</td>
								<td style="border:1px solid silver;">{!! $value->_base_unit_name ?? '' !!}</td>
								<td style="border:1px solid silver;">
									@if( $pr_val_ab_qty >= array_sum($single_item_array_qty[$value->_raw_item_id]))
									<span class="btn btn-success">Available</span>

									@else
										@php
										$production_allow=1;
										@endphp
									<span class="btn btn-danger">Not Available</span>
									@endif


								</td>
							</tr>
							@endif
								@empty
							@endforelse

							@empty
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close" data-dismiss="modal">Close</button>
        @if($production_allow==0)
         <button type="submit" class="btn btn-primary  _confirm_save">Confirm & Save</button>
         @endif
      </div>
    </div>