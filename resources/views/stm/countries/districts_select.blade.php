

@php
$_cur_district_id = old('_cur_district_id');
@endphp
<option value="">Select {{__('label._cur_district_id')}}</option>
 @forelse($division_wise_districts as $district)
 <option value="{{$district->id}}" @if($district->id==$_cur_district_id) selected @endif> {!! $district->name ?? '' !!}</option>
 @empty
 @endforelse