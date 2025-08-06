<table align="center" style="border-spacing: 0in 0in; overflow: hidden !important;">
	<!-- create a new row -->
	@php 
	$generator = new Picqer\Barcode\BarcodeGeneratorPNG();

	$items = $data["_search_item_id"];
	$_qtys = $data["_qty"];
	$_barcodes = $data["_barcode"];
	$_sales_rates = $data["_sales_rate"];
	$_vats = $data["_vat"];
	$_discounts = $data["_discount"];
	$_product_name_check = $data["_product_name_check"] ?? '';
	$_product_price_check = $data["_product_price_check"] ?? '';
	$_bussiness_name = $data["_bussiness_name"] ?? '';
	$_vat_check = $data["_vat_check"] ?? '';
	$_discount_check = $data["_discount_check"] ?? '';
	$_product_name_size = $data["_product_name_size"] ?? 8;
	$_product_price_size = $data["_product_price_size"] ?? 8;
	$_bussiness_name_size = $data["_bussiness_name_size"] ?? 8;
	$_vat_size = $data["_vat_size"] ?? 8;
	$_discount_size = $data["_discount_size"] ?? 8;

	$_manufacture_date = $data["_manufacture_date"] ?? [];
	$_expire_date = $data["_expire_date"] ?? [];
	$_manufacture_date_check = $data["_manufacture_date_check"] ?? '';
	$_expire_date_check = $data["_expire_date_check"] ?? '';


	@endphp
	@forelse($items as $key=>$item)
	@php
	$_qty = $_qtys[$key];
	$_loop_time = ceil($_qty/4);
	@endphp
	@for($i=0; $i<$_loop_time; $i++)
	<tr>
		<!-- <columns column-count="4" column-gap="0"> -->
		<td align="center" valign="center">
			<div style="overflow: hidden !important;display: flex; flex-wrap: wrap;align-content: center;width: 2in; height: 1.25in; justify-content: center;">
				<div> 
	@if($_bussiness_name !='') <b style="display: block !important; font-size: {{$_bussiness_name_size}}px">{{$settings->name ?? '' }}</b> @endif 
	@if($_product_name_check !='')<span style="display: block !important; font-size: {{$_product_name_size}}px">{{$items[$key]}} </span>  @endif
	@if($_product_price_check !='')<span style="font-size: {{$_product_price_size}}px;">Price:<b>{{prefix_taka()}}.{{$_sales_rates[$key]}}</b></span>  @endif
	@if($_vat_check !='')<span style="font-size: {{$_vat_size}}px;">VAT:<b>{{$_vats[$key]}}</b></span> @endif
	@if($_discount_check !='')<span style="font-size: {{$_discount_size}}px;">Discount:<b>{{$_discounts[$key]}}</b></span> @endif

	@if($_manufacture_date_check !='')<span style="font-size: {{$_discount_size}}px;">MFG date:<b>{{$_manufacture_date[$key] ?? ''}}</b></span> @endif
			@if($_expire_date_check !='')<span style="font-size: {{$_discount_size}}px;">EXP:<b>{{$_expire_date[$key] ?? ''}}</b></span> @endif


				@php
			$barcode = $_barcodes[$key] ?? '';
			@endphp
@if($barcode !='')
			<br> <?php echo  '<img style="max-width:90% !important;height: 0.24in !important; display: block;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode('"'.$barcode.'"', $generator::TYPE_CODE_128)) . '">'; ?> <span style="font-size: 10px !important">
				{{$_barcodes[$key]}}
			</span>
@endif
					 
				</div>
			</div>
		</td>
		<!-- <columns column-count="4" column-gap="0"> -->
		<td align="center" valign="center">
			<div style="overflow: hidden !important;display: flex; flex-wrap: wrap;align-content: center;width: 2in; height: 1.25in; justify-content: center;">
				<div> 
	@if($_bussiness_name !='') <b style="display: block !important; font-size: {{$_bussiness_name_size}}px">{{$settings->name ?? '' }}</b> @endif 
	@if($_product_name_check !='')<span style="display: block !important; font-size: {{$_product_name_size}}px">{{$items[$key]}} </span>  @endif
	@if($_product_price_check !='')<span style="font-size: {{$_product_price_size}}px;">Price:<b>{{prefix_taka()}}.{{$_sales_rates[$key]}}</b></span>  @endif
	@if($_vat_check !='')<span style="font-size: {{$_vat_size}}px;">VAT:<b>{{$_vats[$key]}}</b></span> @endif
	@if($_discount_check !='')<span style="font-size: {{$_discount_size}}px;">Discount:<b>{{$_discounts[$key]}}</b></span> @endif

	@if($_manufacture_date_check !='')<span style="font-size: {{$_discount_size}}px;">MFG date:<b>{{$_manufacture_date[$key] ?? ''}}</b></span> @endif
			@if($_expire_date_check !='')<span style="font-size: {{$_discount_size}}px;">EXP:<b>{{$_expire_date[$key] ?? ''}}</b></span> @endif

					 <br> <?php echo  '<img style="max-width:90% !important;height: 0.3in !important; display: block;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode('"'.$_barcodes[$key].'"', $generator::TYPE_CODE_128)) . '">'; ?> <span style="font-size: 10px !important">
				{{$_barcodes[$key]}}
			</span>
					 
				</div>
			</div>
		</td>
		<!-- <columns column-count="4" column-gap="0"> -->
		<td align="center" valign="center">
			<div style="overflow: hidden !important;display: flex; flex-wrap: wrap;align-content: center;width: 2in; height: 1.25in; justify-content: center;">
				<div> 
	@if($_bussiness_name !='') <b style="display: block !important; font-size: {{$_bussiness_name_size}}px">{{$settings->name ?? '' }}</b> @endif 
	@if($_product_name_check !='')<span style="display: block !important; font-size: {{$_product_name_size}}px">{{$items[$key]}} </span>  @endif
	@if($_product_price_check !='')<span style="font-size: {{$_product_price_size}}px;">Price:<b>{{prefix_taka()}}.{{$_sales_rates[$key]}}</b></span>  @endif
	@if($_vat_check !='')<span style="font-size: {{$_vat_size}}px;">VAT:<b>{{$_vats[$key]}}</b></span> @endif
	@if($_discount_check !='')<span style="font-size: {{$_discount_size}}px;">Discount:<b>{{$_discounts[$key]}}</b></span> @endif

	@if($_manufacture_date_check !='')<span style="font-size: {{$_discount_size}}px;">MFG date:<b>{{$_manufacture_date[$key] ?? ''}}</b></span> @endif
			@if($_expire_date_check !='')<span style="font-size: {{$_discount_size}}px;">EXP:<b>{{$_expire_date[$key] ?? ''}}</b></span> @endif


					 <br> <?php echo  '<img style="max-width:90% !important;height: 0.3in !important; display: block;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode('"'.$_barcodes[$key].'"', $generator::TYPE_CODE_128)) . '">'; ?> <span style="font-size: 10px !important">
				{{$_barcodes[$key]}}
			</span>
					 
				</div>
			</div>
		</td>
		<!-- <columns column-count="4" column-gap="0"> -->
		<td align="center" valign="center">
			<div style="overflow: hidden !important;display: flex; flex-wrap: wrap;align-content: center;width: 2in; height: 1.25in; justify-content: center;">
				<div> 
	@if($_bussiness_name !='') <b style="display: block !important; font-size: {{$_bussiness_name_size}}px">{{$settings->name ?? '' }}</b> @endif 
	@if($_product_name_check !='')<span style="display: block !important; font-size: {{$_product_name_size}}px">{{$items[$key]}} </span>  @endif
	@if($_product_price_check !='')<span style="font-size: {{$_product_price_size}}px;">Price:<b>{{prefix_taka()}}.{{$_sales_rates[$key]}}</b></span>  @endif
	@if($_vat_check !='')<span style="font-size: {{$_vat_size}}px;">VAT:<b>{{$_vats[$key]}}</b></span> @endif
	@if($_discount_check !='')<span style="font-size: {{$_discount_size}}px;">Discount:<b>{{$_discounts[$key]}}</b></span> @endif

	@if($_manufacture_date_check !='')<span style="font-size: {{$_discount_size}}px;">MFG date:<b>{{$_manufacture_date[$key] ?? ''}}</b></span> @endif
			@if($_expire_date_check !='')<span style="font-size: {{$_discount_size}}px;">EXP:<b>{{$_expire_date[$key] ?? ''}}</b></span> @endif


					 <br> <?php echo  '<img style="max-width:90% !important;height: 0.3in !important; display: block;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode('"'.$_barcodes[$key].'"', $generator::TYPE_CODE_128)) . '">'; ?> <span style="font-size: 10px !important">
				{{$_barcodes[$key]}}
			</span>
					 
				</div>
			</div>
		</td>
		
	</tr>
	<!-- create a new row -->
	@endfor
	@empty
	@endforelse
	
</table>
<style type="text/css">
td {
	border: 1px dotted lightgray;
}

@media print {
	table {
		page-break-after: always;
	}
	@page {
		size: 8.5in 11in;
		/*width: 8.5in !important;*/
		/*height:11in !important ;*/
		margin-top: 0.5in !important;
		margin-bottom: 0.5in !important;
		margin-left: 0.25in !important;
		margin-right: 0.25in !important;
	}
}
</style>
<script>
window.print()
</script>