
<option value=""><--Select--></option>
@forelse($datas as $data)
<option value="{{$data->id}}">{!! $data->$_return_cloumn ?? '' !!}</option>

@empty
@endforelse