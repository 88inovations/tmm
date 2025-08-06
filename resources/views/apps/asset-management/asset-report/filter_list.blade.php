@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
 <nav class="mb-2" aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
      <li class="breadcrumb-item"><a href="{{url('asset-management/report')}}">{{__('label.report')}}</a></li>
      <li class="breadcrumb-item"><b>{!! $page_name ?? '' !!}</b></li>
     
    </ol>
  </nav>
  <div class="mb-9">
    <div class="card">
      <div class="card-body">
        <form class="" action="" method="GET">
          <input type="hidden" name="asset_list_filter" value="list_filter">
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
                                  <td class="mb-1 text-1000">{{__('label.organizations')}}</td>
                                  <td>
                                 
                              <select class="form-control" name="organization_id">
                                <option value=""><<--{{__('label.select')}}-->></option>
                                @forelse($organizations as $key=>$val)
                                <option value="{{$val->id}}"  @if(isset($request['organization_id']) && $request['organization_id']==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                        
                                  </td>
                                </tr>  
                  <tr>
                    <td class="mb-1 text-1000">{{__('label.branch')}}</td>
                    <td>
                      <select class="form-control" name="branch_id">
                            <option value=""><<--{{__('label.select')}}-->></option>
                            @forelse($branchs as $key=>$val)
                            <option value="{{$val->id}}"  @if(isset($request['branch_id']) && $request['branch_id']==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                            @empty
                            @endforelse
                          </select>
                        
                    </td>
                  </tr> 
                  <tr>
                    <td class="mb-1 text-1000">{{__('label.cost-centers')}}</td>
                    <td>
                      <select class="form-control" name="cost_center_id">
                            <option value=""><<--{{__('label.select')}}-->></option>
                            @forelse($cost_centers as $key=>$val)
                            <option value="{{$val->id}}"  @if(isset($request['cost_center_id']) && $request['cost_center_id']==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                            @empty
                            @endforelse
                          </select>
                        
                    </td>
                  </tr>
                                 <tr>
                                  <td class="mb-1 text-1000">{{__('label.assign-status')}}</td>
                                  <td>
                                 
                              <select class="form-control" name="assign_status_id">
                                <option value=""><<--{{__('label.select')}}-->></option>
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
                                      <option value=""><<--{{__('label.select')}}-->></option>
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
                                      <option value=""><<--{{__('label.select')}}-->></option>
                                        @forelse($conditions as $key=>$val)
                                        <option value="{{$val->id}}" @if(isset($request['asset_condition_id']) && $request['asset_condition_id']==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
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
                              <div class="modal-footer">
                              
                              <a class="btn btn-danger mr-5" href="{{url('asset-management/list-filter')}}" >{{__('label.reset')}}</a>
                              <button class="btn btn-primary" type="submit">
                                <span class="fas fa-search "></span> {{__('label.search')}}
                              </button>
                            </div>
                              </form>
      </div>
    </div>
@if(sizeof($data) > 0)
<div style="width: 100px;margin:0px auto;">
  <nav  aria-label="breadcrumb" style="margin-top:10px;">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
         <a style="cursor: pointer;"   title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>
         </a>
      </li>
      <li class="breadcrumb-item">
          <a style="cursor: pointer;" onclick="fnExcelReport();"   title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      </li>
    </ol>
  </nav>
</div>
    <div class="invoice" id="printablediv">
  <div class="text-center">
      <address>
        <img src="{{asset('/')}}{{$settings->logo ?? '' }}" style="width:60px;height: 60px;"><br>
            {!! $settings->name ?? '' !!}<br>
            @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}<br>@endif
           
           Date: {{date('d-m-Y')}}<br>
           <b>{!! $category->name ?? '' !!} {{__('label.category_wise_asset_list')}}</b>
           <p>Number of Item: {{sizeof($data)}}</p>
        </address>
  </div>
  
  
       
                        <table class="table table-bordered table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.sl')}}</th>

                            <th class=" align-middle ps-8" style="width:10%">{{__('label.assign-status')}}</th>
                            <th class=" align-middle ps-8" style="width:10%;display: none;">{{__('label.category')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.asset-brand')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.asset-condition')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset-vendor')}}</th>
                            
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.asset_tag')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.serial_no')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.model_no')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.device_name')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.description')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.remarks')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.users')}}</th>
                            <th class=" align-middle ps-8">{{__('label.status')}}</th>
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="">
            
                      
                     
            <td class="= align-middle  ps-8 white-space-nowrap">{!! ($key+1) !!}</td>
            
            <td class=" align-middle  ps-8 white-space-nowrap">
              {!! $value->assign_status->name ?? '' !!}
            </td>
             <td class=" align-middle  ps-8 " style="display: none;">{!! $value->category->_name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->brand->_name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->condition->name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->vendor->name ?? '' !!}</td>
            
            <td class=" align-middle  ps-8 ">{!! $value->asset_tag ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->serial_no ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->model_no ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->description ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->remarks ?? '' !!}</td>
           <td class=" align-middle  ps-8 ">{!! $value->current_user->name ?? '' !!}</td>
            
           <td class=" align-middle  text-start fw-bold text-700">
          {{ selected_status($value->status) }}
          
                    </tr>
                   @empty
                   <tr>
                     <td colspan="14" style="text-align:center;"><b>{!! __('label.no_data_found') !!}</b></td>
                   </tr>
                   @endforelse
                </tbody>
              </table>

                     
 </div>
 @endif
       
  </div>
  </div>
  </div>
 



@endsection

@section('script')
@endsection