@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp

 <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-header">
                <h4 class="text-center">{{ $page_name ?? '' }}</h4>
                 @include('backend.message.message')
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                @include('backend.message.message') 
              </div>
              <div class="card-body">
               <form target="__blank" action="{{url('barcode-print-store')}}" method="POST" class="purchase_form" >
                @csrf
                    <div class="row">
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Item Details</strong>
                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left " >Barcode</th>
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left" >Sales Rate</th>
                                            <th class="text-left " >VAT%</th>
                                            <th class="text-left " >Dis%</th>
                                            <th class="text-left " >MFG Date:</th>
                                            <th class="text-left " >EXP Date:</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @php
                                            $_master_details = $datas ??  [];
                                            @endphp
                                            @forelse($_master_details as $key=>$val)
                                            @php
                                            //dump($val);
                                            @endphp
                                            <tr class="_purchase_row _purchase_row__">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{!! $val->_items->_name ?? '' !!}">

                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " value="{{$val->_item_id }}">
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " value="{{$val->_lot_product->id ?? 0}}" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                             
                                              <td class=" ">
                                               
                                                <input type="text" name="_barcode[]" class="form-control _barcode "  value="{{$val->_barcode ?? $val->items->_barcode ?? '' }}"   >
                                                
                                              </td>
                                              
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="{{$val->_qty ?? 0 }}">
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup " value="{{$val->_sales_rate ?? 0 }}">
                                              </td>
                                              
                                              <td class="  ">
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" placeholder="VAT%" value="{{$val->_vat ?? 0}}">
                                              </td>
                                              <td class=" " >
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" value="{{$val->_discount ?? 0}}" >
                                              </td>
                                              <td class=" " >
                                                <input type="date" name="_manufacture_date[]" class="form-control  _discount " value="{{$val->_manufacture_date ?? ''}}" >
                                              </td>
                                              <td class=" " >
                                                <input type="date" name="_expire_date[]" class="form-control  _expire_date " value="{{$val->_expire_date ?? ''}}" >
                                              </td>
                                            </tr>
                                            @empty
                                            
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="8"></td>
                                            </tr>
                                            
                                          </tfoot>
                                      </table>
                                      <table class="table table-bordered" style="width: 100%">
                                        <tr>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_product_name_check" id="_product_name_check" checked>
                                                <label class="form-check-label" for="_product_name_check"> Product Name</label>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_product_price_check" id="_product_price_check" checked>
                                                <label class="form-check-label" for="_product_price_check"> Product Price</label>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_bussiness_name" id="_bussiness_name" checked>
                                                <label class="form-check-label" for="_bussiness_name"> Business name</label>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_vat_check" id="_vat_check">
                                                <label class="form-check-label" for="_vat_check"> VAT%</label>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_discount_check" id="_discount_check">
                                                <label class="form-check-label" for="_discount_check"> Discount%</label>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_manufacture_date_check" id="_manufacture_date_check">
                                                <label class="form-check-label" for="_manufacture_date_check"> MFG date</label>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="_expire_date_check" id="_expire_date_check">
                                                <label class="form-check-label" for="_expire_date_check"> EXP</label>
                                              </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="_product_name_size" id="_product_name_size" placeholder="Product Name Size" value="10">
                                            </div>
                                          </td>
                                          <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="_product_price_size" id="_product_price_size" placeholder="Product Price Size" value="12">
                                            </div>
                                          </td>
                                          <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="_bussiness_name_size" id="_bussiness_name_size" placeholder="Business name size" value="12">
                                            </div>
                                          </td>
                                          <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="_vat_size" id="_vat_size" placeholder="VAT size" value="8">
                                            </div>
                                           
                                          </td>
                                          <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="_discount_size" id="_discount_size" placeholder="Discount size" value="8">
                                            </div>
                                            
                                          </td>
                                          <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="_discount_size" id="_discount_size" placeholder="Discount size" value="8">
                                            </div>
                                            
                                          </td>
                                          <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="_discount_size" id="_discount_size" placeholder="Discount size" value="8">
                                            </div>
                                            
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="4">
                                            <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-cog"></i>
            </span>
            <select class="form-control" name="barcode_setting">
              <option value="1">20 Labels per Sheet, Sheet Size: 8.5" x 11", Label Size: 4" x 1", Labels per sheet: 20</option><option value="2">30 Labels per sheet, Sheet Size: 8.5" x 11", Label Size: 2.625" x 1", Labels per sheet: 30</option>
              <option value="3">32 Labels per sheet, Sheet Size: 8.5" x 11", Label Size: 2" x 1.25", Labels per sheet: 32</option>
              <option value="4">40 Labels per sheet, Sheet Size: 8.5" x 11", Label Size: 2" x 1", Labels per sheet: 40</option><option value="5">50 Labels per Sheet, Sheet Size: 8.5" x 11", Label Size: 1.5" x 1", Labels per sheet: 50</option>
              <option value="6">Continuous Rolls - 31.75mm x 25.4mm, Label Size: 31.75mm x 25.4mm, Gap: 3.18mm</option>
            </select>
          </div>
                                          </td>
                                        </tr>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                      
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                          
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Print</button>
                            
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


@endsection

@section('script')

<script type="text/javascript">





 

  $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-sales-search')}}",
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
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').val(_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_sales_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._discount').val(_sales_discount);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(_qty);
var _search_item_id="_search_item_id__"+row_id;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').addClass(_search_item_id)


  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();
})










function purchase_row_add(event){
   event.preventDefault();
   var _item_row_count = parseFloat($(document).find('._item_row_count').val());
   var _item_row_count = (parseFloat(_item_row_count)+1);
  $("._item_row_count").val(_item_row_count)

      $("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                             
                                              <td class="">

                                                <input type="text"  name="_barcode[]" class="form-control _barcode  __barcode " value=""  required >
                                              </td>
                                                
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup" >
                                              </td>
                                               
                                                <td class="">
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" >
                                              </td>
                                             
                                                <td class="">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" >
                                              </td>
                                              <td class=" " >
                                                <input type="date" name="_manufacture_date[]" class="form-control  _discount " value="" >
                                              </td>
                                              <td class=" " >
                                                <input type="date" name="_expire_date[]" class="form-control  _expire_date " value="" >
                                              </td>
                                              
                                              
                                            </tr>`);

}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _purchase_total_calculation();
  })

 


  $(document).on('click','.submit-button',function(event){
    event.preventDefault();

      $(document).find('.purchase_form').submit();
    
  })





</script>
@endsection

