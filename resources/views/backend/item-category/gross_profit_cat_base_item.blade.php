@php

$previous_filter= Session::get('filter_gross_profit');

@endphp

@forelse($data as $val )
      <option value="{{$val->id}}" 
      	@if(isset($previous_filter["_item_id"]))
      	@if(in_array($val->id,$previous_filter["_item_id"])) selected @endif
        @endif  >{{ $val->_item ?? '' }}  {{ $val->_pack_size->_name ?? '' }}</option>
  @empty
  @endforelse