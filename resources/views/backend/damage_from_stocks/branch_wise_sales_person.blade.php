<option value=""><----{{__('label._sales_man_id')}}----></option>
@forelse($sales_persons as $key=>$person)
<option value="{{$person->id}}">{{ $person->_code ?? '' }}- {{ $person->_name ?? '' }}</option>
@empty
@endforelse