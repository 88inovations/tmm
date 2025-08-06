@php

$previous_filter= Session::get('bill_of_party_statement');

@endphp

@forelse($data as $val )
      <option value="{{$val->id}}" 
      	@if(isset($previous_filter["_account_ledger_id"]))
      	@if(in_array($val->id,$previous_filter["_account_ledger_id"])) selected @endif
        @endif  >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
      @empty
      @endforelse