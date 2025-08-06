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
</ul>
</div>
<div class="card-body">
  
              <form action="{{ url('item-information/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
<div class="tab-content">
    
<div class="tab-pane active" id="tab1">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label"  for="_code">Code:</label>
        <div class="col-sm-6">
            <input type="text" id="_code" name="_code" class="form-control" value="{{old('_code',$data->_code ?? '' )}}" placeholder="Code" >
            <input type="hidden" name="id" value="{{$data->id}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_item">{{__('label._item')}}:<span class="_required">*</span></label>
         <div class="col-sm-6">
          <input type="text" id="_item" name="_item" class="form-control" value="{{old('_item',$data->_item)}}" placeholder="Item" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_item_category">{{__('label._item_category')}}:<span class="_required">*</span></label>
         <div class="col-sm-6">
            <select class="_item_category form-control" name="_item_category">
                <option value="Inventory" @if($data->_item_category=='Inventory') selected @endif>Inventory</option>
                <option value="Fixed_asset" @if($data->_item_category=='Fixed_asset') selected @endif>Fixed_asset</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Update Name Old Data: <span class="_required">*</span></label>
         <div class="col-sm-6">
           <select  class="form-control _update_all_item_name " name="_update_all_item_name" required>
                <option value="1">Yes</option>
              <option value="0">NO</option>
             
             
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">{{__('label._category_id')}}: <span class="_required">*</span></label>
         <div class="col-sm-6">
           <select  class="form-control _category_id " name="_category_id" required>
              <option value="">--Select Category--</option>
              
               @forelse($categories as $category)
                                @php
                                  $_childs_category = $category->_childs ?? [];
                                  $has_child = sizeof($_childs_category);
                                 @endphp
                                  <option value="{{$category->id}}" @if($category->id==$data->_category_id) selected @endif >{{ $category->_name ?? '' }}</option>
                                   @if($has_child > 0)
                                   {!! display_child_category($_childs_category,$level=0,$data->_category_id,$data->_category_id) !!}
                                    
                                    @endif
                                  @empty
                                  @endforelse
              
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">{{__('label._brand_id')}}: <span class="_required">*</span></label>
         <div class="col-sm-6">
           <select  class="form-control _brand_id " name="_brand_id" required>
              <option value="">--Select {{__('label._brand_id')}}--</option>
              @forelse($item_brands as $brand )
              <option value="{{$brand->id}}"  @if($data->_brand_id == $brand->id) selected @endif  >{{ $brand->id ?? '' }}|{{ $brand->_name ?? '' }}</option>
              @empty
              @endforelse
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_unit">{{__('label._unit')}}:<span class="_required">*</span></label>
         <div class="col-sm-2">
            <select class="form-control _unit_id " id="_unit_id" name="_unit_id" required>
              <option value="" >--Units--</option>
              @foreach($units as $unit)
               <option value="{{$unit->id}}" @if($data->_unit_id==$unit->id) selected @endif >{{$unit->_name ?? ''}}</option>
              @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_pack_size_id">{{__('label._pack_size_id')}}:<span class="_required">*</span></label>
         <div class="col-sm-2">
            <select class="form-control _pack_size_id " id="_pack_size_id" name="_pack_size_id" required>
              <option value="" >--Pack Size--</option>
              @foreach($pack_sizes as $pack)
               <option value="{{$pack->id}}" @if($data->_pack_size_id==$pack->id) selected @endif >{{$pack->id}}|{{$pack->_name ?? ''}}</option>
              @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_barcode">Barcode:</label>
        <div class="col-sm-6">
            <input type="text" id="_barcode" name="_barcode" class="form-control" value="{{old('_barcode',$data->_barcode)}}" placeholder="Barcode" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_model">Model:</label>
        <div class="col-sm-6">
            <input type="text" id="_model" name="_model" class="form-control" value="{{old('_model',$data->_model)}}" placeholder="Model" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_hs_code">{{__('label._hs_code')}}:</label>
        <div class="col-sm-6">
            <input type="text" id="_hs_code" name="_hs_code" class="form-control" value="{{old('hs_code',$data->_hs_code ?? '')}}" placeholder="{{__('label._hs_code')}}" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_hs_code_2">{{__('label._hs_code_2')}}:</label>
        <div class="col-sm-6">
            <input type="text" id="_hs_code_2" name="_hs_code_2" class="form-control" value="{{old('_hs_code_2',$data->_hs_code_2 ?? '')}}" placeholder="{{__('label._hs_code_2')}}" >
        </div>
    </div>

    <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="_manufacture_company">Manufacture Company:</label>
            <div class="col-sm-6">
                <input type="text" id="_manufacture_company" name="_manufacture_company" class="form-control _manufacture_company" value="{{old('_manufacture_company',$data->_manufacture_company)}}" placeholder="Manufacture Company" >
                <div class="search_boxManufacCompany"></div>
            </div>
    </div>

     
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_generic_name">{{__('label._generic_name')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_generic_name" name="_generic_name" class="form-control" value="{{old('_generic_name',$data->_generic_name)}}" placeholder="{{__('label._generic_name')}}" >
    </div>
</div>

<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_strength">{{__('label._strength')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_strength" name="_strength" class="form-control" value="{{old('_strength',$data->_strength)}}" placeholder="{{__('label._strength')}}" >
    </div>
</div>

@can('cylindar_location')
<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_curum">{{__('label._curum')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_curum" name="_curum" class="form-control" value="{{old('_curum',$data->_curum ?? '')}}" placeholder="{{__('label._curum')}}" >
    </div>
</div>
<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_length">{{__('label._length')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_length" name="_length" class="form-control" value="{{old('_length',$data->_length ?? '')}}" placeholder="{{__('label._length')}}" >
    </div>
</div>

@endcan

<div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_oringin">{{__('label._oringin')}}:</label>
        <div class="col-sm-6">
        <input type="text" id="_oringin" name="_oringin" class="form-control" value="{{old('_oringin',$data->_oringin)}}" placeholder="{{__('label._oringin')}}" >
    </div>
</div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label"  for="_description">Description:</label>
        <div class="col-sm-6">
            <textarea class="form-control" name="_description">{{old('_description',$data->_description ?? '' )}}</textarea>
        </div>
    </div>
    
    
    

    
      <div class="form-group row">
            <label class="col-sm-3 col-form-label"  for="_unique_barcode" class="_required">Use Unique Barcode ?:</label>
            <div class="col-sm-2 ">
                <select class="form-control" name="_unique_barcode" id="_unique_barcode">
                  <option value="0" @if($data->_unique_barcode==0) selected @endif>NO</option>
                  <option value="1" @if($data->_unique_barcode==1) selected @endif>Yes</option>
                </select>
            </div>
    </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="_kitchen_item" class="_required" title="if Yes then this item will send to kitchen to cook/production for sales and store deduct as per item ingredient wise automaticaly">Own Manufacture Item?:</label>
            <div class="col-sm-2 ">
            <select class="form-control" name="_kitchen_item" id="_kitchen_item">
              <option value="0" @if($data->_kitchen_item==0) selected @endif>No</option>
              <option value="1" @if($data->_kitchen_item==1) selected @endif>Yes</option>
            </select>
        </div>
    </div>
    
     <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="_status">Status:</label>
        <div class="col-sm-2">
        <select class="form-control" name="_status" id="_status">
          <option value="1" @if($data->_status==1) selected @endif>Active</option>
          <option value="0" @if($data->_status==0) selected @endif>In Active</option>
        </select>
    </div>
</div>

</div><!-- End fo Tab One -->

<div class="tab-pane" id="tab2"><!-- Starting Point Two -->
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_pur_rate">Purchase Rate:</label>
        <div class=" col-sm-6">
            <input type="number" step="any" min="0" id="_item_pur_rate" name="_pur_rate" class="form-control" value="{{old('_pur_rate',$data->_pur_rate ?? 0)}}" placeholder="Purchase Rate" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_sale_rate">Sales Rate:</label>
         <div class=" col-sm-6">
        
            <input type="number" step="any" min="0" id="_item_sale_rate" name="_sale_rate" class="form-control" value="{{old('_sale_rate',$data->_sale_rate ?? 0)}}" placeholder="Sales Rate" >
        </div>
    </div>
    <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="_trade_price">{{__('label._trade_price')}}:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_trade_price" name="_trade_price" class="form-control" value="{{old('_trade_price',$data->_trade_price ?? 0)}}" placeholder="{{__('label._trade_price')}}" >
        </div>
    </div>
    <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="_mrp_price">{{__('label._mrp_price')}}:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_mrp_price" name="_mrp_price" class="form-control" value="{{old('_mrp_price',$data->_mrp_price ?? 0)}}" placeholder="{{__('label._mrp_price')}}" >
        </div>
    </div>

        <div class="form-group row">
            
            <label class="col-sm-2 col-form-label" for="_discount">Discount Rate:</label>
            <div class="col-sm-6">
            <input type="number" step="any" min="0" id="_discount" name="_discount" class="form-control" value="{{old('_discount',$data->_discount ?? 0)}}" placeholder="Discount Rate" >
        </div>
    </div>
    
        <div class="form-group row">
            
            <label class="col-sm-2 col-form-label" for="_vat">Vat Rate:</label>
            <div class="col-sm-6">
            <input type="number" id="_vat" name="_vat" class="form-control" value="{{old('_vat',$data->_vat ?? 0)}}" placeholder="Vat Rate" >
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
              <option value="{{$_warranty->id}}"  @if($data->_warranty == $_warranty->id) selected @endif>{{ $_warranty->_name ?? '' }}</option>
              @empty
              @endforelse
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_reorder">Reorder Level:</label>
        <div class="col-sm-6">
        <input type="text" id="_reorder" name="_reorder" class="form-control" value="{{old('_reorder',$data->_reorder ?? 0)}}" placeholder="Reorder Level" >
    </div>
</div>


    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="_order_qty">Order Qty:</label>
        <div class="col-sm-6">
        <input type="text" id="_order_qty" name="_order_qty" class="form-control" value="{{old('_order_qty',$data->_order_qty ?? 0)}}" placeholder="Order Qty" >
    </div>
</div>

    

 
    <div class="form-group">
        <label class="col-sm-2 col-form-label">Image:</label>
        <div class="col-sm-6">
       <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_image" class="form-control">
       <img id="output_1" class="banner_image_create" src="{{asset($data->_image)}}"  style="max-height:100px;max-width: 100px; " />
    </div>
</div>


</div><!-- End of Tab Three -->

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
  
</script>
@endsection
