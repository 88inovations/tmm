<table style="width: 100%">
	<thead>
		<tr>
			<th>SL</th>
			<th>Item ID</th>
			<th>Item Name</th>
			<th>Required Qty</th>
			<th>Available Qty</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@forelse($datas as $key=>$data)
		@if($data->_require_qty >= $data->_available_qty )
		<tr>
			<td style="color: red;">{{($key+1)}}</td>
			<td style="color: red;">{{ $data->_item_id ?? '' }}</td>
			<td style="color: red;">{{ $data->_item ?? '' }}</td>
			<td style="color: red;">{{ $data->_require_qty ?? 0 }}</td>
			<td style="color: red;">{{ $data->_available_qty ?? 0 }}</td>
			<td><span style="color: red;">Not Available</span></td>
		</tr>
		@else
		<tr>
			<td>{{($key+1)}}</td>
			<td>{{ $data->_item_id ?? '' }}</td>
			<td>{{ $data->_item ?? '' }}</td>
			<td>{{ $data->_require_qty ?? 0 }}</td>
			<td>{{ $data->_available_qty ?? 0 }}</td>
			<td>Available</td>
		</tr>
		@endif
		@empty
		@endforelse
	</tbody>
	
</table>