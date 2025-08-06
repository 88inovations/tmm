@extends('backend.layouts.app')
@section('title',$page_name ?? '')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('item-information.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             @can('item-information-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('item-information.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-md-12">
<div class="card">
<div class="card-header p-2">
<ul class="nav nav-pills">
<li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">{{__('Basic')}}</a></li>
<li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">{{__('Pricing Information')}}</a></li>
<li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">{{__('Other Information')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#tab4" data-toggle="tab">{{__('Opening Balance')}}</a></li>
</ul>
</div>
<div class="card-body">
  
                {!! Form::open(array('route' => 'item-information.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
<div class="tab-content">
    
<div class="tab-pane active" id="tab1">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label"  for="_code">Code:</label>
        <div class="col-sm-6">
            <input type="text" id="_code" name="_code" class="form-control" value="{{old('_code')}}" placeholder="Code" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_item">{{__('label._item')}}:<span class="_required">*</span></label>
         <div class="col-sm-6">
          <input type="text" id="_item" name="_item" class="form-control" value="{{old('_item')}}" placeholder="Item" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_item_category">{{__('label._item_category')}}:<span class="_required">*</span></label>
         <div class="col-sm-6">
            <select class="_item_category form-control" name="_item_category">
                <option value="Inventory">Inventory</option>
                <option value="Fixed_asset">Fixed_asset</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">{{__('label._category_id')}}: <span class="_required">*</span></label>
         <div class="col-sm-6 display_flex">
           <select  class="form-control _category_id " name="_category_id" required>
              <option value="">--Select Category--</option>
              

              @forelse($categories as $category)
                                @php
                                  $_childs_category = $category->_childs ?? [];
                                  $has_child = sizeof($_childs_category);
                                 @endphp
                                  <option value="{{$category->id}}"  >{{ $category->_name ?? '' }}</option>
                                   @if($has_child > 0)
                                   {!! display_child_category($_childs_category,$level=0) !!}
                                    
                                    @endif
                                  @empty
                                  @endforelse
            </select>
            <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._category_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="item_categories"
                                 attr_select_option_class="._category_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button>

        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">{{__('label._brand_id')}}: <span class="_required">*</span></label>
         <div class="col-sm-6 display_flex">
           <select  class="form-control _brand_id " name="_brand_id" required>
              <option value="">--Select {{__('label._brand_id')}}--</option>
              @forelse($item_brands as $brand )
              <option value="{{$brand->id}}"  @if(old('_brand_id') == $brand->id) selected @endif  >{{ $brand->id ?? '' }}|{{ $brand->_name ?? '' }}</option>
              @empty
              @endforelse
            </select>
            <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._brand_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="item_brands"
                                 attr_select_option_class="._brand_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button>
        </div>
    </div>

     <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_pack_size_id">{{__('label._pack_size_id')}}:<span class="_required">*</span></label>
         <div class="col-sm-4 display_flex">
            <select class="form-control _pack_size_id " id="_pack_size_id" name="_pack_size_id" required>
              <option value="" >--Pack Size--</option>
              @foreach($pack_sizes as $pack)
               <option value="{{$pack->id}}" @if(old('_unit_id')==$pack->id) selected @endif >{{$pack->id}}|{{$pack->_name ?? ''}}</option>
              @endforeach
            </select>
             <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._pack_size_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="item_pack_sizes"
                                 attr_select_option_class="._pack_size_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_unit">{{__('label._unit')}}:<span class="_required">*</span></label>
         <div class="col-sm-4 display_flex">
            <select class="form-control _unit_id " id="_unit_id" name="_unit_id" required>
              <option value="" >--Units--</option>
              @foreach($units as $unit)
               <option value="{{$unit->id}}" @if(old('_unit_id')==$unit->id) selected @endif >{{$unit->_name ?? ''}}</option>
              @endforeach
            </select>
            <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._unit_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="units"
                                 attr_select_option_class="._unit_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button>
        </div>
    </div>
   
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_barcode">Barcode:</label>
        <div class="col-sm-6">
            <input type="text" id="_barcode" name="_barcode" class="form-control" value="{{old('_barcode')}}" placeholder="Barcode" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_model">Model:</label>
        <div class="col-sm-6">
            <input type="text" id="_model" name="_model" class="form-control" value="{{old('_model')}}" placeholder="Model" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="hs_code">{{__('label.hs_code')}}:</label>
        <div class="col-sm-6">
            <input type="text" id="hs_code" name="hs_code" class="form-control" value="{{old('hs_code')}}" placeholder="{{__('label.hs_code')}}" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="hs_code_2">{{__('label.hs_code_2')}}:</label>
        <div class="col-sm-6">
            <input type="text" id="hs_code_2" name="hs_code_2" class="form-control" value="{{old('hs_code_2')}}" placeholder="{{__('label.hs_code_2')}}" >
        </div>
    </div>
    <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="_manufacture_company">Manufacture Company:</label>
            <div class="col-sm-6">
                <input type="text" id="_manufacture_company" name="_manufacture_company" class="form-control _manufacture_company" value="{{old('_manufacture_company')}}" placeholder="Manufacture Company" >
                <div class="search_boxManufacCompany"></div>
            </div>
    </div>

     
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_generic_name">{{__('label._generic_name')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_generic_name" name="_generic_name" class="form-control" value="{{old('_generic_name')}}" placeholder="{{__('label._generic_name')}}" >
    </div>
</div>

<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_strength">{{__('label._strength')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_strength" name="_strength" class="form-control" value="{{old('_strength')}}" placeholder="{{__('label._strength')}}" >
    </div>
</div>

@can('cylindar_location')
<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_curum">{{__('label._curum')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_curum" name="_curum" class="form-control" value="{{old('_curum')}}" placeholder="{{__('label._curum')}}" >
    </div>
</div>
<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_length">{{__('label._length')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_length" name="_length" class="form-control" value="{{old('_length')}}" placeholder="{{__('label._length')}}" >
    </div>
</div>

@endcan






<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_oringin">{{__('label._oringin')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_oringin" name="_oringin" class="form-control" value="{{old('_oringin')}}" placeholder="{{__('label._oringin')}}" >
    </div>
</div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label"  for="_description">Description:</label>
        <div class="col-sm-6">
            <textarea class="form-control" name="_description">{{old('_description')}}</textarea>
        </div>
    </div>
    
    
    

    
      <div class="form-group row">
            <label class="col-sm-3 col-form-label"  for="_unique_barcode" class="_required">Use Unique Barcode ?:</label>
            <div class="col-sm-2 ">
                <select class="form-control" name="_unique_barcode" id="_unique_barcode">
                  <option value="0">NO</option>
                  <option value="1">Yes</option>
                </select>
            </div>
    </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="_kitchen_item" class="_required" title="if Yes then this item will send to kitchen to cook/production for sales and store deduct as per item ingredient wise automaticaly">Own Manufacture Item?:</label>
            <div class="col-sm-2 ">
            <select class="form-control" name="_kitchen_item" id="_kitchen_item">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
        </div>
    </div>
    
     <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="_status">Status:</label>
        <div class="col-sm-2">
        <select class="form-control" name="_status" id="_status">
          <option value="1">Active</option>
          <option value="0">In Active</option>
        </select>
    </div>
</div>

</div><!-- End fo Tab One -->

<div class="tab-pane" id="tab2"><!-- Starting Point Two -->
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_pur_rate">Purchase Rate:</label>
        <div class=" col-sm-6">
            <input type="number" step="any" min="0" id="_item_pur_rate" name="_pur_rate" class="form-control" value="{{old('_pur_rate',0)}}" placeholder="Purchase Rate" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_sale_rate">Sales Rate:</label>
         <div class=" col-sm-6">
        
            <input type="number" step="any" min="0" id="_item_sale_rate" name="_sale_rate" class="form-control" value="{{old('_sale_rate',0)}}" placeholder="Sales Rate" >
        </div>
    </div>
    <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="_trade_price">{{__('label._trade_price')}}:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_trade_price" name="_trade_price" class="form-control" value="{{old('_trade_price',0)}}" placeholder="{{__('label._trade_price')}}" >
        </div>
    </div>
    <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="_mrp_price">{{__('label._mrp_price')}}:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_mrp_price" name="_mrp_price" class="form-control" value="{{old('_mrp_price',0)}}" placeholder="{{__('label._mrp_price')}}" >
        </div>
    </div>

        <div class="form-group row">
            
            <label class="col-sm-2 col-form-label" for="_discount">Discount Rate:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_discount" name="_discount" class="form-control" value="{{old('_discount',0)}}" placeholder="Discount Rate" >
        </div>
    </div>
    
        <div class="form-group row">
            
            <label class="col-sm-2 col-form-label" for="_vat">Vat Rate:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_vat" name="_vat" class="form-control" value="{{old('_vat',0)}}" placeholder="Vat Rate" >
        </div>
    </div>
    
      
    
</div><!-- End of Second Tab -->

<div class="tab-pane" id="tab3"><!-- Starting point tab 3 -->


    <div class="form-group row">
         <label class="col-sm-2 col-form-label">Warranty: </label>
         <div class="col-sm-6">
           <select  class="form-control _warranty " name="_warranty" >
              <option value="">--Select Warranty--</option>
              @forelse($_warranties as $_warranty )
              <option value="{{$_warranty->id}}" @if(isset($request->_warranty)) @if($request->_warranty == $_warranty->id) selected @endif   @endif>{{ $_warranty->_name ?? '' }}</option>
              @empty
              @endforelse
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_reorder">Reorder Level:</label>
        <div class="col-sm-6">
        <input type="text" id="_reorder" name="_reorder" class="form-control" value="{{old('_reorder')}}" placeholder="Reorder Level" >
    </div>
</div>


    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_order_qty">Order Qty:</label>
        <div class="col-sm-6">
        <input type="text" id="_order_qty" name="_order_qty" class="form-control" value="{{old('_order_qty')}}" placeholder="Order Qty" >
    </div>
</div>

 

 
   

 
    <div class="form-group">
        <label class="col-sm-2 col-form-label">Image:</label>
        <div class="col-sm-6">
       <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_image" class="form-control">
       <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$settings->logo ?? ''}}"  style="max-height:100px;max-width: 100px; " />
    </div>
</div>


</div><!-- End of Tab Three -->
<div class="tab-pane " id="tab4">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label.organization_id')}}</th>
            <th>{{__('label._branch_id')}}</th>
            <th>{{__('label._cost_center_id')}}</th>
            <th>{{__('label._store_id')}}</th>
            <th>{{__('label._qty')}}</th>
            <th>{{__('label._cost_rate')}}</th>
            <th>{{__('label._sales_rate')}}</th>
            <th>{{__('label._amount')}}</th>
        </tr>
    </thead>
    <tbody class="opeing_body">
        <tr>
            <td>
            <a href="#none" class="btn btn-default _opening_row_remove"><i class="fa fa-trash"></i></a>
          </td>
            <td>
                <select class="form-control _master_branch_id" name="organization_id[]" required >
                  @forelse($permited_organizations as $val )
                  <option value="{{$val->id}}" >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                <select class="form-control _master_branch_id" name="_branch_id[]" required >
                  @forelse($permited_branch as $branch )
                  <option value="{{$branch->id}}" >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                <select class="form-control _cost_center_id" name="_cost_center_id[]" required >    
                  @forelse($permited_costcenters as $cost_center )
                  <option value="{{$cost_center->id}}" >{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                <select class="form-control  _store_id" name="_store_id[]">
                  @forelse($store_houses as $store)
                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            
            <td>
                 <input type="number" step="any" min="0"  name="_opening_qty[]" class="form-control _opening_qty _common_keyup_opening" value="0" placeholder="Opening QTY" >
            </td>
            <td>
                 <input type="number" step="any" min="0"  name="_opening_rate[]" class="form-control _opening_rate _common_keyup_opening" value="0" placeholder="Opening Cost Rate" >
            </td>
            <td>
                 <input type="number" step="any" min="0"  name="_openig_sales_rate[]" class="form-control" value="0" placeholder="Opening Sales Rate" >
            </td>
            <td>
                <input type="number" step="any" min="0"  name="_openig_amount[]" class="form-control _opening_amount" value="0" readonly >
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNewRowForOpenig(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="3">{{__('label._total')}}</th>
            <th>
                <input type="text" name="_total_opening_qty" class="form-control _total_opening_qty" value="0" readonly>
            </th>
            <th></th>
            <th></th>
            <th>
                 <input type="text" name="_total_opening_amount" class="form-control _total_opening_amount" value="0" readonly>
            </th>
        </tr>
    </tfoot>
</table>

</div>
<div class="form-group row">
<div class="offset-sm-2 col-sm-6">
<button type="submit" class="btn btn-danger">Submit</button>
</div>
</div>

</div> <!-- End of tab content -->
</form> <!-- End of form -->

</div>
</div>

</div>
         
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>




@endsection
@section('script')
<script type="text/javascript">
    function addNewRowForOpenig(event){
        $(document).find(".opeing_body").append(` <tr>
            <td>
            <a href="#none" class="btn btn-default _opening_row_remove"><i class="fa fa-trash"></i></a>
          </td>
            <td>
                <select class="form-control " name="organization_id[]" required >
                  @forelse($permited_organizations as $val )
                  <option value="{{$val->id}}" >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                <select class="form-control _master_branch_id" name="_branch_id[]" required >
                  @forelse($permited_branch as $branch )
                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                <select class="form-control _cost_center_id" name="_cost_center_id[]" required >    
                  @forelse($permited_costcenters as $cost_center )
                  <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                <select class="form-control  _store_id" name="_store_id[]">
                  @forelse($store_houses as $store)
                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            
            <td>
                 <input type="number" step="any" min="0"  name="_opening_qty[]" class="form-control _opening_qty _common_keyup_opening" value="{{old('_opening_qty',0)}}" placeholder="Opening QTY" >
            </td>
            <td>
                 <input type="number" step="any" min="0"  name="_opening_rate[]" class="form-control _common_keyup_opening _opening_rate" value="{{old('_cost_rate',0)}}" placeholder="Opening Cost Rate" >
            </td>
            <td>
                 <input type="number" step="any" min="0"  name="_openig_sales_rate[]" class="form-control _common_keyup_opening" value="{{old('_opening_sales_rate',0)}}" placeholder="Opening Sales Rate" >
            </td>
            <td>
                <input type="number" step="any" min="0"  name="_openig_amount[]" class="form-control _opening_amount" value="{{old('_opening_amount',0)}}"  readonly >
            </td>
        </tr>`);
    }

    $(document).on('click','._opening_row_remove',function(){
        $(this).closest('tr').remove();
    })

$(document).on('keyup','._common_keyup_opening',function(){
 
  var _qty = parseFloat($(this).closest('tr').find('._opening_qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._opening_rate').val());
  var _sales_rate =parseFloat( $(this).closest('tr').find('._opening_sales_rate').val());

  console.log(_rate)
  console.log(_qty)

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }

  $(this).closest('tr').find('._opening_amount').val((_qty*_rate));
    var _total_qty = 0;
    var _total__value = 0;
      $(document).find("._opening_amount").each(function() {
            var _s_value =parseFloat($(this).val());
            if(isNaN(_s_value)){_s_value = 0}
          _total__value +=parseFloat(_s_value);
      });
      $(document).find("._opening_qty").each(function() {
            var _s_qty =parseFloat($(this).val());
            if(isNaN(_s_qty)){_s_qty = 0}
          _total_qty +=parseFloat(_s_qty);
      });
     

     
      $(document).find("._total_opening_qty").val(_total_qty);
      $(document).find("._total_opening_amount").val(_total__value);

})
</script>
@endsection
