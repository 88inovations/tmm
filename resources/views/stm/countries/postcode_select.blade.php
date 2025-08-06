   


@php
$_cur_union_id  = old('_cur_union_id');
@endphp

<option value="">Select {{__('label._cur_union_id')}}</option>
 @forelse($_upazilla_wise_postcodes as $union)
 <option value="{{$union->id}}" @if($union->id==$_cur_union_id) selected @endif> {!! $union->postOffice ?? '' !!} {!! $union->postCode ?? '' !!}</option>
 @empty
 @endforelse