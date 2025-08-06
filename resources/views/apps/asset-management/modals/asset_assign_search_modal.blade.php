
<div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="" method="GET" class="form-horizontal">
            @csrf
              <div class="modal-content">
                <div class="modal-header">
                  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body search_modal">
                  <form class="" action="" method="GET">
                                <table class="table table-sm fs--1 mb-0">
                                
                                @php

                                $column_names=['id'=>'ID','name'=>'Device Name','category_id'=>'Category','brand_id'=>'Brand','vendor_id'=>'Vendor','asset_condition_id'=>'Asset Condition','assign_status_id'=>'Assign Status'];

                                $order_types=['DESC'=>'DESC','ASC'=>'ASC'];

                                $categories = \DB::select("SELECT DISTINCT t1.category_id as id,t2._name as name FROM `asset_items` AS t1
                                INNER JOIN item_categories as t2 ON t1.category_id=t2.id ");

                                $assign_status = \App\Models\AssetManagement\AssignStatus::where('is_delete',0)
                                                ->orderBy('order','ASC')
                                                ->orderBy('name','ASC')->get();
                                @endphp
                                 <tr>
                                  <td class="mb-1 text-1000">{{__('label.id')}}</td>
                                  <td>
                                 <input type="text" name="id" class="form-control" placeholder="{{__('label.id')}}">
                        
                                  </td>
                                </tr>
                                 <tr>
                                  <td class="mb-1 text-1000">{{__('label.assign-status')}}</td>
                                  <td>
                                 
                              <select class="form-control" name="assign_status_id">
                                <option value="">--{{__('label.select')}}--</option>
                                @forelse($assign_status as $key=>$val)
                                <option value="{{$val->id}}"  @if(isset($request['assign_status_id']) && $request['assign_status_id']==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                        
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.asset-category')}}</td>
                                  <td>
                                    <select class="form-control" name="category_id">
                                      <option value="">{{__('label.select_category')}}</option>
                                        @forelse($categories as $key=>$val)
                                        <option value="{{$val->id}}" @if(isset($request['category_id']) && $request['category_id']==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.asset-conditions')}}</td>
                                  <td>
                                    <select class="form-control" name="asset_condition_id">
                                      <option value="">{{__('label.select_asset-condition')}}</option>
                                        @forelse($conditions as $key=>$val)
                                        <option value="{{$val->id}}" @if(isset($request['asset_condition_id']) && $request['asset_condition_id']==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.asset_tag')}}</td>
                                  <td>
                                    <input type="text" name="asset_tag" class="form-control" value="@if(isset($request['asset_tag'])) {{$request['asset_tag']}} @endif" placeholder="{{__('label.asset_tag')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.device_name')}}</td>
                                  <td>
                                    <input type="text" name="name" class="form-control" value="@if(isset($request['name'])) {{$request['name']}} @endif" placeholder="{{__('label.name')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.asset_code')}}</td>
                                  <td>
                                    <input type="text" name="asset_code" class="form-control" value="@if(isset($request['asset_code'])) {{$request['asset_code']}} @endif" placeholder="{{__('label.asset_code')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.model_no')}}</td>
                                  <td>
                                    <input type="text" name="model_no" class="form-control" value="@if(isset($request['model_no'])) {{$request['model_no']}} @endif" placeholder="{{__('label.model_no')}}">
                                  </td>
                                </tr>
                                <tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.description')}}</td>
                                  <td>
                                    <input type="text" name="description" class="form-control" value="@if(isset($request['description'])) {{$request['description']}} @endif" placeholder="{{__('label.description')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.remarks')}}</td>
                                  <td>
                                    <input type="text" name="remarks" class="form-control" value="@if(isset($request['remarks'])) {{$request['remarks']}} @endif" placeholder="{{__('label.remarks')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.year_manufacture')}}</td>
                                  <td>
                                    <input type="text" name="year_manufacture" class="form-control" value="@if(isset($request['year_manufacture'])) {{$request['year_manufacture']}} @endif" placeholder="{{__('label.year_manufacture')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.origin')}}</td>
                                  <td>
                                    <input type="text" name="origin" class="form-control" value="@if(isset($request['origin'])) {{$request['origin']}} @endif" placeholder="{{__('label.origin')}}">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.serial_no')}}</td>
                                  <td>
                                    <input type="text" name="serial_no" class="form-control" value="@if(isset($request['serial_no'])) {{$request['serial_no']}} @endif" placeholder="{{__('label.serial_no')}}">
                                  </td>
                                </tr>
                                
                               
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.limit')}}</td>
                                  <td>
                                    <select class="form-control" name="limit">
                                        @forelse(filter_page_numbers() as $key=>$val)
                                        <option value="{{$val}}" @if(isset($request['limit']) && $request['limit']==$val) selected @endif >{!!$val ?? '' !!}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.order_by')}}</td>
                                  <td>
                                    <select class="form-control" name="order_column">
                                        @forelse($column_names as $key=>$val)
                                        <option value="{{$val}}" @if(isset($request['order_column']) && $request['order_column']==$val) selected @endif >{!!$val ?? '' !!}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="mb-1 text-1000">{{__('label.order_type')}}</td>
                                  <td>
                                    <select class="form-control" name="order_by">
                                        @forelse($order_types as $key=>$val)
                                        <option value="{{$val}}" @if(isset($request['order_by']) && $request['order_by']==$val) selected @endif >{!!$val ?? '' !!}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                  </td>
                                </tr>
                              </table>
                              
                              </form>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-search mr-2"></i> Search</button>
                </div>
              </div>
            </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


