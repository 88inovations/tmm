

<script type="text/javascript">

function _stock_in_purchase_row_add(event){
   event.preventDefault();
   var _stock_in__item_row_count = parseFloat($(document).find('._stock_in__item_row_count').val());
   var _stock_in__item_row_count = (parseFloat(_stock_in__item_row_count)+1);
 $(document).find("._stock_in__item_row_count").val(_stock_in__item_row_count)

      $("#_stock_in_area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                                <td></td>
                                              <td>
                                                <input type="text" name="_stock_in__search_item_id[]" class="form-control _stock_in__search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_stock_in__item_id[]" class="form-control _stock_in__item_id width_200_px" >
                                                <input type="hidden" name="_stock_in__p_p_l_id[]" class="form-control _stock_in__p_p_l_id " >
                                                <input type="hidden" name="_stock_in__purchase_invoice_no[]" class="form-control _stock_in__purchase_invoice_no" >
                                                <input type="hidden" name="_stock_in__purchase_detail_id[]" class="form-control _stock_in__purchase_detail_id" >
                                               
                                                <div class="_stock_in_search_box_item">
                                                  
                                                </div>
                                              </td>

                                              <td class="display_none">
                                                <input type="hidden" class="form-control _stock_in_base_unit_id width_100_px" name="_stock_in_base_unit_id[]" />
                                                <input type="text" class="form-control _stock_in_main_unit_val width_100_px" readonly name="_stock_in_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_stock_inconversion_qty[]" min="0" step="any" class="form-control _stock_inconversion_qty " value="1" readonly>
                                                <input type="number" name="_stock_in_base_rate[]" min="0" step="any" class="form-control _stock_in_base_rate "  readonly>
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _stock_in_transection_unit" name="_stock_in_transection_unit[]">
                                                </select>
                                              </td>
                                             
                                              <td class="@if($_show_barcode==0) display_none @endif">
                                              

                                                <input type="text"  name="_stock_in__barcode[]" class="form-control _stock_in__barcode  ${_stock_in__item_row_count}__barcode " value="" id="${_stock_in__item_row_count}___stock_in_barcode"  >

                                                <input type="hidden" name="_stock_in__ref_counter[]" value="${_stock_in__item_row_count}" class="_stock_in__ref_counter" id="${_stock_in__item_row_count}___stock_in_ref_counter">
                                              </td>
                                               
                                              <td>
                                                <input type="number" name="_stock_in__qty[]" class="form-control _stock_in__qty _stock_in_common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__rate[]" class="form-control _stock_in__rate _stock_in_common_keyup"  >
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__sales_rate[]" class="form-control _stock_in__sales_rate _stock_in_common_keyup" >
                                              </td>
                                               
                                               
                                               
                                             
                                              <td>
                                                <input type="number" name="_stock_in__value[]" class="form-control _stock_in__value " readonly >
                                              </td>
                                              
                                              
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control  _stock_in__main_branch_id_detail" name="_stock_in__main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                               <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control  _stock_in__main_cost_center" name="_stock_in__main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                             <td>
                                                <select class="form-control  _stock_in__main_store_id" name="_stock_in__main_store_id[]">
                                                  @forelse($_all_store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}/{{$store->_branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_stock_in__manufacture_date[]" class="form-control _stock_in__manufacture_date " >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_stock_in__expire_date[]" class="form-control _stock_in__expire_date " >
                                              </td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif">
                                                <input type="text" name="_stock_in__store_salves_id[]" class="form-control _stock_in__store_salves_id " >
                                              </td>
                                              
                                              
                                            </tr>`);

}

$(document).on('change','._stock_in_transection_unit',function(){
  var __this = $(this);
  var _stock_inconversion_qty = $('option:selected', this).attr('attr_conversion_qty');
  console.log("_stock_inconversion_qty "+_stock_inconversion_qty)
 
  $(this).closest('tr').find("._stock_inconversion_qty").val(_stock_inconversion_qty);

  _stock_inconverted_qty_value(__this);
})

function _stock_inconverted_qty_value(__this){

  var _vat_amount =0;
  var _qty = parseFloat(__this.closest('tr').find('._stock_in__qty').val());
  var _rate =parseFloat( __this.closest('tr').find('._stock_in__rate').val());
  var _sales_rate =parseFloat( __this.closest('tr').find('._stock_in__sales_rate').val());
  var _item_vat = parseFloat(__this.closest('tr').find('._stock_in__vat').val());
  var _item_discount = parseFloat(__this.closest('tr').find('._stock_in__discount').val());
  var _stock_in_base_rate = __this.closest('tr').find('._stock_in_base_rate').val();
  var _stock_inconversion_qty = parseFloat(__this.closest('tr').find('._stock_inconversion_qty').val());
  if(isNaN(_stock_inconversion_qty)){ _stock_inconversion_qty   = 1 }
    console.log("_stock_in_base_rate "+_stock_in_base_rate)

    var _stock_inconverted_price_rate = (( _stock_inconversion_qty/1)*_stock_in_base_rate);
    if(_stock_inconverted_price_rate ==0){
    _stock_inconverted_price_rate = _rate;
  }
console.log("_stock_inconverted_price_rate "+_stock_inconverted_price_rate)

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_stock_inconverted_price_rate)){ _stock_inconverted_price_rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*_stock_inconverted_price_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*_stock_inconverted_price_rate)*_item_discount)/100);

   


  __this.closest('tr').find('._stock_in__rate').val(_stock_inconverted_price_rate);
  __this.closest('tr').find('._stock_in__value').val((_qty*_stock_inconverted_price_rate));
    _stock_in__purchase_total_calculation();


 //  var _stock_in_vat_amount =0;
 //  var _stock_in_qty = __this.closest('tr').find('._stock_in_qty').val();
 //  var _stock_in_rate = __this.closest('tr').find('._stock_in_rate').val();
 //  var _stock_in_base_rate = __this.closest('tr').find('._stock_in_base_rate').val();
 //  var _stock_in_sales_rate =parseFloat( __this.closest('tr').find('._stock_in_sales_rate').val());
 //  var _stock_in_item_vat = __this.closest('tr').find('._stock_in_vat').val();
 //  var _stock_inconversion_qty = parseFloat(__this.closest('tr').find('._stock_inconversion_qty').val());
 //  var _stock_in_item_discount = parseFloat(__this.closest('tr').find('._stock_in_discount').val());


 //   if(isNaN(_stock_in_item_vat)){ _stock_in_item_vat   = 0 }

 //  if(isNaN(_stock_inconversion_qty)){ _stock_inconversion_qty   = 1 }
 //  var _stock_inconverted_price_rate = (( _stock_inconversion_qty/1)*_stock_in_base_rate);

 //   if(isNaN(_stock_in_qty)){ _stock_in_qty   = 0 }
 //   if(isNaN(_stock_in_rate)){ _stock_in_rate =0 }
 //   if(isNaN(_stock_in_sales_rate)){ _stock_in_sales_rate =0 }
 //   if(isNaN(_stock_in_base_rate)){ _stock_in_base_rate =0 }

 //  if(_stock_inconverted_price_rate ==0){
 //    _stock_inconverted_price_rate = _stock_in_sales_rate;
 //  }
 //  _stock_inconverted_price_rate = parseFloat(_stock_inconverted_price_rate).toFixed(2);
 //  if(isNaN(_stock_inconverted_price_rate)){_stock_inconverted_price_rate=0}

 //   if(isNaN(_stock_in_item_vat)){ _stock_in_item_vat   = 0 }
 //   if(isNaN(_stock_in_qty)){ _stock_in_qty   = 0 }
 //   if(isNaN(_stock_in_rate)){ _stock_in_rate =0 }
 //   if(isNaN(_stock_in_item_discount)){ _stock_in_item_discount =0 }
 //   _vat_amount = Math.ceil(((_stock_in_qty*_stock_inconverted_price_rate)*_stock_in_item_vat)/100)
 //   _discount_amount = Math.ceil(((_stock_in_qty*_stock_inconverted_price_rate)*_stock_in_item_discount)/100)


 //   var _stock_in_value = parseFloat(_stock_inconverted_price_rate*_stock_in_qty).toFixed(2);
 // __this.closest('tr').find('._stock_in_sales_rate').val(_stock_inconverted_price_rate);
 // __this.closest('tr').find('._stock_in_value').val(_stock_in_value);
 //  __this.closest('tr').find('._stock_in_vat_amount').val(_stock_in_vat_amount);
 //  __this.closest('tr').find('._stock_in_discount_amount').val(_stock_in_item_discount);
 //    _stock_in__purchase_total_calculation();


}

$(document).on('keyup','._stock_in_common_keyup',function(){
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._stock_in__qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._stock_in__rate').val());
  var _sales_rate =parseFloat( $(this).closest('tr').find('._stock_in__sales_rate').val());
  var _item_vat = parseFloat($(this).closest('tr').find('._stock_in__vat').val());
  var _item_discount = parseFloat($(this).closest('tr').find('._stock_in__discount').val());

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*_rate)*_item_discount)/100)

  $(this).closest('tr').find('._stock_in__value').val((_qty*_rate));
    _stock_in__purchase_total_calculation();
})


$(document).on('keyup','._stock_in__search_item_id',delay(function(e){
   console.log($(this).val())
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
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
                          var   _manufacture_company = data[i]. _manufacture_company;
                         search_html += `<tr class="_stock_in_search_row_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   </td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="4">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('._stock_in_search_box_item').html(search_html);
      _gloabal_this.parent('td').find('._stock_in_search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


$(document).on('click','._stock_in_search_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).find('._unique_barcode').val());
 var _item_row_count = $("._stock_in__item_row_count").val();
  if(_unique_barcode ==1){
    _new_barcode_function(_item_row_count);
  }
  
  if(isNaN(_item_vat)){ _item_vat=0 }
  _vat_amount = ((_item_rate*_item_vat)/100)


var _stock_in_main_unit_id = $(this).children('td').find('._stock_in_main_unit_id').val();
  var _stock_in_main_unit_val = $(this).children('td').find('._stock_in_main_unit_text').val();
var self = $(this);

    var request = $.ajax({
      url: "{{url('item-wise-units')}}",
      method: "GET",
      data: { item_id:_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      self.parent().parent().parent().parent().parent().parent().find('._stock_in_transection_unit').html("")
      self.parent().parent().parent().parent().parent().parent().find("._stock_in_transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
     $(this).parent().parent().parent().parent().parent().parent().find('._stock_in_base_rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in_base_unit_id').val(_stock_in_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in_main_unit_val').val(_stock_in_main_unit_val);
  

  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__item_id').val(_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__barcode').val(_item_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__sales_rate').val(_item_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__vat').val(_item_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__vat_amount').val(_vat_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__qty').val(1);
   if(_unique_barcode ==1){
    $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__qty').val(0);
    $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__qty').attr('readonly',true);
  }
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__value').val(_item_rate);
 var _ref_counter = $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__ref_counter').val();
  $(this).parent().parent().parent().parent().parent().parent().find('._stock_in__barcode').attr('name',_ref_counter+'__barcode__'+_id);
  var _item_row_count = _ref_counter;
  if(_unique_barcode ==1){
    _new_barcode_function(_item_row_count);
  }

  _stock_in__purchase_total_calculation();
  $('._stock_in_search_box_item').hide();
  $('._stock_in_search_box_item').removeClass('search_box_show').hide();
  
})

function _stock_in__purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
      $(document).find("._stock_in__value").each(function() {
        var line_value = parseFloat($(this).val());
        if(isNaN(line_value)){ line_value=0 }
          _total__value +=parseFloat(line_value);
        
      });
      $(document).find("._stock_in__qty").each(function() {
        var line__qty = parseFloat($(this).val());
        if(isNaN(line__qty)){ line__qty=0 }
          _total_qty +=parseFloat(line__qty);
      });
      
      $("._stock_in__total_qty_amount").val(_total_qty);
      $("._stock_in__total_value_amount").val(_total__value);
      var _total = _math_round(parseFloat(_total__value))
      $("#_stock_in__total").val(_total);
  }

 function _new_barcode_function(_item_row_count){
      $('#'+_item_row_count+'___stock_in_barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }

</script>
