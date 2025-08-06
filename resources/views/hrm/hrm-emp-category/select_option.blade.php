@forelse($datas as $key=>$val)
<option value="{{$val->id}}">{{$val->$_column_name ?? ''}}</option>
@empty
@endforelse