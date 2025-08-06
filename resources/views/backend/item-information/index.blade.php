@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('item-information.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('item-information-create')
                <a 
               class="btn btn-sm btn-info active "  
               href="{{ route('item-information.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
              
              @endcan
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 

                  <div class="row">
                   @php

 $currentURL = URL::full();
 $current = URL::current();
if($currentURL === $current){
   $print_url = $current."?print=single";
   $print_url_detal = $current."?print=detail";
}else{
     $print_url = $currentURL."&print=single";
     $print_url_detal = $currentURL."&print=detail";
}
    

                   @endphp
                    <div class="col-md-4">
                      @include('backend.item-information.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('voucher-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i> Print
                                </a>  
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                         <th class="">Action</th>
                         <th>SL</th>
                         <th>ID</th>
                         <th>Item</th>
                         <th>{{__('label._item_category')}}</th>
                         <th>Unit Conversion</th>
                         <th>Image</th>
                         <th>Unit</th>
                         <th>Pack Size</th>
                         <th>Code</th>
                         <th>{{__('label._hs_code')}}</th>
                         <th>{{__('label.hs_code_2')}}</th>
                         <th>Serial</th>
                         <th>Barcode</th>
                         <th>Model</th>
                         <th>Warranty</th>
                         <th>Category</th>
                         
                         <th>Discount</th>
                         <th>Vat</th>
                         <th>Purchase Rate</th>
                         <th>Sales Rate</th>
                         <th>Stock</th>
                         <th>Reorder Level</th>
                         <th>Order Qty</th>
                         <th>Manufacture Company</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Status</th> 
                         @php
                         $default_image = $settings->logo;
                         @endphp           
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                          <td style="display: flex;">
                           
                                <a   
                                  href="{{ route('item-information.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('item-information-edit')
                                  <a   
                                  href="{{ route('item-information.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('item-information-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['item-information.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                             
                            
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->id ?? '' }}</td>
                            <td>{{ $data->_item ?? '' }}<br>
                          
                              <b>Production Item:</b> {{selected_yes_no($data->_kitchen_item ?? 0)}}<br>
                              <b>Unique Barcode: </b>{{selected_yes_no($data->_unique_barcode ?? 0)}}<br>

                            </td>
                              <td>{{ $data->_item_category ?? '' }}</td>
                            <td>
                              <button type="button" class="btn btn-info showUnitConversion" data-toggle="modal" data-target="#unitConversionModal" 
                              attr_item_id="{{$data->id}}"  
                              attr_item_name="{{$data->_item}}" 
                              attr_base_unit="{{$data->_unit_id}}" 
                              attr_base_unit_name="{{ $data->_units->_name ?? '' }}" 
                              >Unit Conversions</button>
                            </td>
                            <td>
                              <img class="myImage" src="{{asset('/')}}{{$data->_image ?? $default_image }}" alt="Click me to open modal" title="Click display Image" data-toggle="modal" data-target="#imageModal" style="max-height:50px;max-width: 50px;" >
                              </td>
                            </td>
                            <td>{{ $data->_units->_name ?? '' }}</td>
                            <td>{{ $data->_pack_size->_name ?? '' }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            
                            <td>{{ $data->_hs_code ?? '' }}</td>
                            <td>{{ $data->_hs_code_2 ?? '' }}</td>
                            <td>{{ $data->_serial ?? '' }}</td>
                            <td>{{ $data->_barcode ?? '' }}</td>
                            <td>{{ $data->_model ?? '' }}</td>
                            <td>{{ $data->_warranty_name->_name ?? '' }}</td>
                            <td>{{ $data->_category->_parents->_name ?? 'C' }}-{{ $data->_category->_name ?? '' }}</td>
                            <td>{{ _report_amount( $data->_discount ?? 0 ) }}</td>
                            <td>{{ _report_amount( $data->_vat ?? 0 ) }}</td>
                            <td>{{ _report_amount($data->_pur_rate ?? 0 ) }}</td>
                            <td>{{ _report_amount($data->_sale_rate ?? 0 ) }}</td>
                            <td>{{ $data->_balance ?? 0 }}</td>
                            <td>{{ $data->_reorder ?? 0 }}</td>
                            <td>{{ $data->_order_qty ?? 0 }}</td>
                            <td>{{ $data->_manufacture_company ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->updated_at ?? '' }}</td>
                           <td>{{ selected_status($data->_status ?? 0) }}</td>
                           
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>

       <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid" id="modalImage" src="">
                </div>
            </div>
        </div>
    </div>
      <!-- /.container-fluid -->
    </div>
</div>
@include("backend.item-information.unit_conversion")
@endsection


@section("script")

<script type="text/javascript">

  $('.myImage').on('click', function() {
        var imgSrc = $(this).attr('src');
        $('#modalImage').attr('src', imgSrc);
    });


  var base_unit_name="";
  var item_id="";
  var item_name="";
  var base_unit="";
  $(document).on("click",".showUnitConversion",function(){
     item_id = $(this).attr("attr_item_id");
     item_name = $(this).attr("attr_item_name");
    base_unit = $(this).attr("attr_base_unit");
     base_unit_name = $(this).attr("attr_base_unit_name");
    $(document).find(".unitConversionItem").text(item_name);
    $(document).find(".baseUnitName").text(base_unit_name);
    console.log(item_id)

    var request = $.ajax({
      url: "{{url('item-wise-unit-conversion')}}",
      method: "GET",
      data: { item_id,base_unit_name },
       dataType: "html"
    });
     
    request.done(function( response ) {
      console.log(response)
      $(document).find(".unitConversionArea").html(response);
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  })

  $(document).on('click','.unitConversionSave',function(){


    var conversion_id =[];
    var conversion_item_id=[];
    var _base_unit_id =[];
    var _conversion_qty=[];
    var _conversion_unit=[];
    var _converted_unit_names=[];
    $(document).find(".conversion_id").each(function(){
        conversion_id.push($(this).val());
    })
    $(document).find(".conversion_item_id").each(function(){
        conversion_item_id.push(item_id);
    })
    $(document).find("._base_unit_id").each(function(){
        _base_unit_id.push(base_unit);
    })
    $(document).find("._conversion_qty").each(function(){
        _conversion_qty.push($(this).val());
    })
    $(document).find("._conversion_unit").each(function(){
        _conversion_unit.push($(this).val());
        _converted_unit_names.push($(this).text());
    })
   // console.log(_converted_unit_names)

    var request = $.ajax({
      url: "{{url('item-wise-unit-conversion-save')}}",
      method: "GET",
      data: { item_id,conversion_id,conversion_item_id,_base_unit_id,_conversion_qty,_conversion_unit,_converted_unit_names },
      dataType: "json"
    });
     
    request.done(function( response ) {
      console.log(response)
      alert(response.message)
      $('#exampleModal').modal('hide');
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });


    
  })

  $(document).on("click",".unitRemoveButton",function(){
    if(confirm("Are You Sure !")){
      $(this).closest("tr").remove();
    }
  })

  $(document).on("click",".addNewRow",function(){
    $(document).find(".unitConversionArea").append(`<tr>
                  
                  <td>
                    <input type="number" name="_conversion_qty[]" min="0" step="any" class="form-control _conversion_qty" value="">
                  </td>
                  <td>
                    <span class="baseUnitName"></span> <b>=</b>
                    <input type="hidden" name="conversion_id[]" class="conversion_id" value="0">
                    <input type="hidden" name="conversion_item_id[]" class="conversion_item_id" value="0">
                    <input type="hidden" name="_base_unit_id[]" class="_base_unit_id" value="0">
                  </td>
                  <td>
                    <select class="form-control _conversion_unit" id="_conversion_unit" name="_conversion_unit[]" >
                      <option value="" >--Units--</option>
                      @foreach($units as $unit)
                       <option value="{{$unit->id}}" >{{ $unit->_name ?? '' }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-danger unitRemoveButton">X</button>
                    
                  </td>
                </tr>`);
    $(document).find(".baseUnitName").text(base_unit_name);
    $(document).find("._base_unit_id").text(base_unit);
    $(document).find(".conversion_item_id").text(item_id);
    
  })

  $(document).on('keyup','._search_main_item_id',delay(function(e){
   
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
            search_html +=`<div class="card"><table class="table table-bordered" style="width: 350px;">
                            <thead>
                            <tr>
                              <th>ID</th>
                              <th>Code</th>
                              <th>Name</th>
                              <th>Unit</th>
                              <th>Pack Size</th>
                              <th>Brand</th>
                              <th>Manufacture</th>
                            </tr>
                            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]. _manufacture_company;
                         search_html += `<tr class="search_row_main_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td>
                                        <td>${data[i]?._code }</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_unit_id" class="_item_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   </td>
                                   <td>${data[i]?._units?._name }</td>
                                   <td>${data[i]?._pack_size?._name }</td>
                                   <td>${data[i]?._brands?._name }</td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="4">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_main_item').html(search_html);
      _gloabal_this.parent('div').find('.search_box_main_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));
 
$(document).on('click','.search_row_main_item',function(){
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
 $(document).find("._search_main_item_id").val(_name);
 $(document).find("._main_item_id").val(_id);

  

 
  $('.search_box_main_item').hide();
  $('.search_box_main_item').removeClass('search_box_show').hide();
  
})


</script>
@endsection