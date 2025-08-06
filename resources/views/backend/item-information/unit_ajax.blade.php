@forelse($conversionUnits as $value)
	<tr>
                  
                  <td>
                    <input type="number" name="_conversion_qty[]" min="0" step="any" class="form-control _conversion_qty" value="{{ $value->_conversion_qty ?? 0 }}">
                  </td>
                  <td>
                    <span class="baseUnitName">{{$base_unit_name}}</span> <b>=</b>
                    <input type="hidden" name="conversion_id[]" class="conversion_id" value="{{$value->id}}">
                    <input type="hidden" name="conversion_item_id[]" class="conversion_item_id" value="{{$value->_item_id}}">
                    <input type="hidden" name="_base_unit_id[]" class="_base_unit_id" value="{{$value->_base_unit_id}}">
                  </td>
                  <td>
                    <select class="form-control _conversion_unit" id="_conversion_unit" name="_conversion_unit[]" >
                      <option value="" >--Units--</option>
                      @foreach($units as $unit)
                       <option value="{{$unit->id}}" @if($unit->id==$value->_conversion_unit) selected @endif >{{ $unit->_name ?? '' }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-danger unitRemoveButton">X</button>
                    
                  </td>
                </tr>
@empty
@endforelse