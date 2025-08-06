

@foreach($units as $unit)
  @forelse($conversionUnits as $conversionUnit)
  @if($conversionUnit->_conversion_unit == $unit->id)
 <option value="{{$unit->id}}"  
        attr_base_unit_id="{{$conversionUnit->_base_unit_id}}" 
        attr_conversion_qty="{{$conversionUnit->_conversion_qty}}" 
        attr_conversion_unit="{{$conversionUnit->_conversion_unit}}" 
        attr_item_id="{{$conversionUnit->_item_id}}"
        @if($unit->id ==$conversionUnit->_base_unit_id) selected  @endif

         >{{ $unit->_name ?? '' }}</option>
 @endif
 @empty
 @endforelse
@endforeach