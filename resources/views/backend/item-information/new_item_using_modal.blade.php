<form class="_item_modal_form">

    <div class="form-group ">
        <label class="col-sm-12 col-form-label" for="_item_category">{{__('label._item_category')}}:<span class="_required">*</span></label>
         <div class="col-sm-12">
            <select class="_item_category form-control" name="_item_category">
                <option value="Inventory">Inventory</option>
                <option value="Fixed_asset">Fixed_asset</option>
            </select>
        </div>
    </div>


          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="_item">Item:<span class="_required">*</span></label>
                                <input type="text" id="_item" name="_item" class="form-control _item_item" value="" placeholder="Item" required>
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                <label for="_code">Code:</label>
                                <input type="text" id="_code" name="_code" class="form-control _item_code" value="" placeholder="Code" >
                            </div>
                        </div>


                       <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="form-group ">
                                <label>Category: <span class="_required">*</span>   <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._category_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="item_categories"
                                 attr_select_option_class="._category_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button></label>
                               <select  class="form-control _category_id " name="_category_id" required>
                                  <option value="">--Select Category--</option>
                                  @php
                                  $categories = \App\Models\ItemCategory::with(['_parents'])->get();
                                  @endphp
                                  @forelse($categories as $category )
                                  <option value="{{$category->id}}" >{{ $category->_parents->_name ?? '' }}/{{ $category->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                                
                            </div>
                        </div>
                      
                       
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                <label for="_brand_id">{{__('label._brand_id')}}:     <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._brand_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="item_brands"
                                 attr_select_option_class="._brand_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button></label>
                                <select  class="form-control _brand_id  _item_brand_id " name="_brand_id" required>
              <option value="">--Select {{__('label._brand_id')}}--</option>
              @forelse($item_brands as $brand )
              <option value="{{$brand->id}}"  @if(old('_brand_id') == $brand->id) selected @endif  >{{ $brand->id ?? '' }}|{{ $brand->_name ?? '' }}</option>
              @empty
              @endforelse
            </select>
          
                            </div>
                        </div>
                     
 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                <label for="_unit">Unit:<span class="_required">*</span>  
                                <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._item_unit_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="units"
                                 attr_select_option_class="._item_unit_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button></label>
                                @php
                                  $units = \DB::table('units')->get();
                                  @endphp
                                <select class="form-control _unit_id _item_unit_id" id="_unit_id" name="_unit_id" required>
                                  <option value="" >--Units--</option>
                                  @foreach($units as $unit)
                                   <option value="{{$unit->id}}" >{{$unit->_name ?? ''}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                <label for="_pack_size_id">{{__('label._pack_size_id')}}:  
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
                                  class="btn btn-sm btn-warning sub_form_data_entry ml-2 mr-1">+</button></label>
                                <select  class="form-control _pack_size_id  _item_pack_size_id " name="_pack_size_id" required>
              <option value="">--Select {{__('label._pack_size_id')}}--</option>
              @forelse($pack_sizes as $brand )
              <option value="{{$brand->id}}"  @if(old('_brand_id') == $brand->id) selected @endif  >{{ $brand->id ?? '' }}|{{ $brand->_name ?? '' }}</option>
              @empty
              @endforelse
            </select>

                            </div>
                        </div>





<div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="_item_curum">{{__('label._curum')}}:</label>
                                <input type="text" id="_item_curum" name="_item_curum" class="form-control" value="{{old('_curum')}}" placeholder="{{__('label._curum')}}" >
                            </div>
                        </div>

<div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="_item_length">{{__('label._length')}}:</label>
                                <input type="text" id="_item_length" name="_item_length" class="form-control" value="{{old('_length')}}" placeholder="{{__('label._length')}}" >
                            </div>
                        </div>





             
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="_barcode">Model:</label>
                                <input type="text" id="_barcode" name="_barcode" class="form-control _item_barcode" value="" placeholder="Model" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="hs_code">{{__('label.hs_code')}}:</label>
                                <input type="text" id="hs_code" name="hs_code" class="form-control _itemhs_code" value="" placeholder="{{__('label.hs_code')}}" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="hs_code_2">{{__('label.hs_code_2')}}:</label>
                                <input type="text" id="hs_code_2" name="hs_code_2" class="form-control _itemhs_code_2" value="" placeholder="{{__('label.hs_code_2')}}" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_discount">Discount Rate:</label>
                                <input type="number" id="_discount" name="_discount" class="form-control _item_discount" value="0" placeholder="Discount Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_vat">Vat Rate:</label>
                                <input type="number" id="_vat" name="_vat" class="form-control _item_vat" value="0" placeholder="Vat Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 display_none">
                            <div class="form-group">
                                <label for="_item_opening_qty">Opening QTY:</label>
                                <input type="number" id="_item_opening_qty" name="_item_opening_qty" class="form-control" value="0" placeholder="Opening QTY" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_pur_rate">Purchase Rate:</label>
                                <input type="number" id="_pur_rate" name="_pur_rate" class="form-control _item_pur_rate" value="0" placeholder="Purchase Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_sale_rate">Sales Rate:</label>
                                <input type="number" id="_sale_rate" name="_sale_rate" class="form-control _item_sale_rate" value="0" placeholder="Sales Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 @if(sizeof($permited_branch)==1) display_none @endif ">
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control _item_branch_id" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 @if(sizeof($permited_costcenters)==1) display_none @endif ">
                            <div class="form-group ">
                                <label>Cost Center:<span class="_required">*</span></label>
                               <select class="form-control _item_cost_center_id" name="_cost_center_id" required >
                                  
                                  @forelse($permited_costcenters as $cost_center )
                                  <option value="{{$cost_center->id}}" >{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 @if(sizeof($store_houses)==1) display_none @endif">
                            <div class="form-group ">
                                <label>Store House:<span class="_required">*</span></label>
                                <select class="form-control  _item_store_id" name="_store_id">
                                      @forelse($store_houses as $store)
                                      <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                      @empty
                                      @endforelse
                                    </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_manufacture_company">Manufacture Company:</label>
                                <input type="text" id="_manufacture_company" name="_manufacture_company" class="form-control _item_manufacture_company" value="" placeholder="Manufacture Company" >
                            </div>
                        </div>
                        @can('restaurant-module') 
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_kitchen_item" class="_required" title="if Yes then this item will send to kitchen to cook/production for sales and store deduct as per item ingredient wise automaticaly">Kitchen/Production Item ?:</label>
                                <select class="form-control" name="_kitchen_item" id="_kitchen_item">
                                  <option value="0">No</option>
                                  <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        @endcan
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_unique_barcode">Use Unique Barcode ?:</label>
                                <select class="form-control _item_unique_barcode" name="_unique_barcode" id="_item_unique_barcode">
                                  <option value="0">NO</option>
                                  <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_status">Status:</label>
                                <select class="form-control _item_status" name="_status" id="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
          </form>