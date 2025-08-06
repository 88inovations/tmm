

@php
$_cur_thana_id  = old('_cur_thana_id');
@endphp

<option value="">Select {{__('label._cur_thana_id')}}</option>
                                         @forelse($_district_wise_upazillas as $thana)
                                         <option
                                         attr_district_id="{{$thana->district_id}}"
                                          value="{{$thana->name}}" @if($thana->name==$_cur_thana_id) selected @endif> {!! $thana->name ?? '' !!}</option>
                                         @empty
                                         @endforelse