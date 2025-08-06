<div class="row">
	<div class="col-md-12 col-sm-12">
		@if(sizeof($kitchen_finish_goods) > 0)
			<h5 >Ordered Details</h5>
			<table class="table table-bordered" style="width: 100%">
				<thead>
					<tr>
						<th>SL</th>
						<th>Item ID</th>
						<th>Item Name</th>
						<th>Qty</th>
					</tr>
				</thead>
				<tbody>
					@forelse($kitchen_finish_goods as $key=>$data)
					
					
					<tr>
						<td>{{($key+1)}}</td>
						<td>{{ $data->_item_id ?? '' }}</td>
						<td>{{ $data->_item ?? '' }}</td>
						<td>{{ $data->_qty ?? 0 }}</td>
						
					</tr>
					
					@empty
					@endforelse
				</tbody>
				
			</table>

		@endif
		
	</div>

	<div class="col-md-12 col-sm-12">
		@if(sizeof($kitchen_row_goods) > 0)
			<h5 style="border-top: 2px solid #000;">Item wise Ingredients</h5>
			<table class="table table-bordered" style="width: 100%">
				<thead>
					<tr>
						<th>##</th>
						<th>SL</th>
						<th>Item ID</th>
						<th>Item Name</th>
						<th>Required Qty</th>
						<th>Available Qty</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody class="_row_goods_display">
					@forelse($kitchen_row_goods as $key=>$data)
					
					<tr class="_row_goods">
						<td>
                            <a  href="#none" class="btn btn-default _row_goods_remove" ><i class="fa fa-trash"></i></a>
                          </td>
						<td>{{($key+1)}}
							<input type="hidden" name="id[]" value="{{$data->id ?? 0}}">
						</td>
						<td>
							<input type="text" name="_item_id[]" class="form-control _item_id" readonly value="{{ $data->_item_id ?? '' }}">
							<input type="hidden" name="_rate[]" class="form-control _rate" readonly value="{{ $data->_rate ?? 0 }}">
						</td>
						<td>
							<input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{ $data->_item ?? '' }}">
								<div class="search_box_item"></div>
							<input type="hidden" name="_item[]" class="form-control _item" value="{{ $data->_item ?? '' }}">
						</td>
						<td>
							<input type="number" min="0" step="any" name="_qty[]" class="form-control" value="{{ $data->_require_qty ?? 0 }}">
						</td>
						<td>
							<input type="text" class="form-control _available_qty" readonly name="_available_qty[]" value="{{ $data->_available_qty ?? 0 }}">
						</td>
						@if($data->_require_qty >= $data->_available_qty )
						<td><span style="color: red;">Not Available</span></td>
						@else
						<td style="color: green;">Available</td>
						@endif
					</tr>
					
					
					
					@empty
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<td>
                        <a href="#none"  class="btn btn-default " onclick="addNewRowGoods(event)"><i class="fa fa-plus"></i></a>
                      </td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tfoot>
				
			</table>

		@endif
		
	</div>
	
</div>


<script type="text/javascript">
	function addNewRowGoods(event){

		$(document).find("._row_goods_display").append(`<tr class="_row_goods">
						<td>
                            <a  href="#none" class="btn btn-default _row_goods_remove" ><i class="fa fa-trash"></i></a>
                          </td>
						<td>
							<input type="hidden" name="id[]" value="0">
						</td>
						<td>
							<input type="text" name="_item_id[]" class="form-control _item_id" readonly value="">
							<input type="text" name="_rate[]" class="form-control _rate" readonly value="{{ $data->_rate ?? '' }}">
						</td>
						<td>
							<input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
								<div class="search_box_item"></div>
							<input type="hidden" name="_item[]" class="form-control _item" value="0">
						</td>
						<td>
							<input type="number" min="0" step="any" name="_qty[]" class="form-control _qty" value="0">
						</td>
						<td>
							<input type="text" class="form-control _available_qty" readonly name="_available_qty[]" value="0">
						</td>
						<td></td>
					</tr>`)
		console.log(event);
	}

	$(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-restaurant-sales-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i]._master_id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i]._item_id}">
                                        </td><td>${data[i]._name}
                      <input type="hidden" name="_p_item_row_id" class="_p_item_row_id" value="${data[i].id}">
                      <input type="hidden" name="_p_item_name" class="_p_item__name" value="${data[i]._name}">
                      <input type="hidden" name="_p_item_item_id" class="_p_item_item_id" value="${data[i]._item_id}">
                      <input type="hidden" name="_p_item__unit_id" class="_p_item__unit_id" value="${data[i]._unit_id}">
                      <input type="hidden" name="_p_item_barcode" class="_p_item_barcode" value="${data[i]._barcode}">
  <input type="hidden" name="_p_item_manufacture_date" class="_p_item_manufacture_date" value="${data[i]._manufacture_date}">
  <input type="hidden" name="_p_item_expire_date" class="_p_item_expire_date" value="${data[i]._expire_date}">
  <input type="hidden" name="_p_item_sales_rate" class="_p_item_sales_rate" value="${data[i]._sales_rate}">
  <input type="hidden" name="_p_item_qty" class="_p_item_qty" value="${data[i]._qty}">
  <input type="hidden" name="_p_item_pur_rate" class="_p_item_pur_rate" value="${data[i]._pur_rate}">
  <input type="hidden" name="_p_item_sales_discount" class="_p_item_sales_discount" value="${data[i]._sales_discount}">
  <input type="hidden" name="_p_item_sales_vat" class="_p_item_sales_vat" value="${data[i]._sales_vat}">
  <input type="hidden" name="_p_item_purchase_detail_id" class="_p_item_purchase_detail_id" value="${data[i]._purchase_detail_id}">
  <input type="hidden" name="_p_item_master_id" class="_p_item_master_id" value="${data[i]._master_id}">
  <input type="hidden" name="_p_item_branch_id" class="_p_item_branch_id" value="${data[i]._branch_id}">
  <input type="hidden" name="_p_item_cost_center_id" class="_p_item_cost_center_id" value="${data[i]._cost_center_id}">
  <input type="hidden" name="_p_item_store_id" class="_p_item_store_id" value="${data[i]._store_id}">
  <input type="hidden" name="_p_item_store_salves_id" class="_p_item_store_salves_id" value="${data[i]._store_salves_id}">
  <input type="hidden" name="_p_item_warranty" class="_p_item_warranty" value="${data[i]._warranty}">
                                   </td>
                                   
                                   <td>${data[i]._qty}</td>
                                    <td>${data[i]._sales_rate}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var row_id = $(this).find('._p_item_row_id').val();
  var _name = $(this).find('._p_item__name').val();
  var _p_item_item_id = $(this).find('._p_item_item_id').val();
  var _unit_id = $(this).find('._p_item__unit_id').val();
  var _barcode = $(this).find('._p_item_barcode').val();
  var _manufacture_date = $(this).find('._p_item_manufacture_date').val();
  var _expire_date = $(this).find('._p_item_expire_date').val();
  var _sales_rate = parseFloat($(this).find('._p_item_sales_rate').val());
  var _qty = $(this).find('._p_item_qty').val();
  var _pur_rate = $(this).find('._p_item_pur_rate').val();
  var _sales_discount = $(this).find('._p_item_sales_discount').val();
  var _sales_vat = $(this).find('._p_item_sales_vat').val();
  var _purchase_detail_id = $(this).find('._p_item_purchase_detail_id').val();
  var _master_id = $(this).find('._p_item_master_id').val();
  var _branch_id = $(this).find('._p_item_branch_id').val();
  var _cost_center_id = $(this).find('._p_item_cost_center_id').val();
  var _store_id = $(this).find('._p_item_store_id').val();
  var _store_salves_id = $(this).find('._p_item_store_salves_id').val();
  var _warranty = $(this).find('._p_item_warranty').val();


  if(_barcode=='null'){ _barcode='' } 
  if(_store_salves_id=='null'){ _store_salves_id='' } 
  if(isNaN(_sales_rate)){ _sales_rate=0 }
  if(isNaN(_pur_rate)){ _pur_rate=0 }
  if(isNaN(_sales_vat)){ _sales_vat=0 }
  _vat_amount = ((_sales_rate*_sales_vat)/100)
  if(isNaN(_sales_discount)){ _sales_discount=0 }
  _discount_amount = ((_sales_rate*_sales_discount)/100);
  
var find_counter_id = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
var _new_name_for_barcode = `${find_counter_id}__barcode__${row_id}`;
$(this).parent().parent().parent().parent().parent().parent().find('.'+find_counter_id+"__barcode").attr('name',_new_name_for_barcode); 
  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_p_item_item_id);
  var _id_name = `${_name}`;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._p_p_l_id').val(row_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._purchase_invoice_no').val(_master_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._purchase_detail_id').val(_purchase_detail_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('._store_salves_id').val(_store_salves_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._available_qty').val(_qty);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_pur_rate);
var _search_item_id="_search_item_id__"+row_id;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').addClass(_search_item_id)


  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();
})

 $(document).on('click','._row_goods_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      
  })
</script>
