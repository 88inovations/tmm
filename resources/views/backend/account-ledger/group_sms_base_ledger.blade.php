
@php

$previous_filter= Session::get('group_sms_send_filter');

@endphp

@forelse($data as $val )
      <option value="{{$val->id}}" 
      	@if(isset($previous_filter["_account_ledger_id"]))
      	@if(in_array($val->id,$previous_filter["_account_ledger_id"])) selected @endif
        @endif  >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }} - {{ $val->_phone ?? '' }}</option>
      @empty
      @endforelse