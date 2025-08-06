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
            @can('asset-entry-assign-list')
            <li class="breadcrumb-item"><a href="{{route('asset_item_entry.index')}}">{{__('label.asset_item_entry')}}</a></li>
            
            @endcan
              @can('asset-entry-assign-create')
            <li class="breadcrumb-item"> <a class="btn btn-primary btn-sm "
                  href="{{route('asset_item_entry.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a>
                  </li>
             @endcan
               <li class="breadcrumb-item">
                <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                  </li>
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
          
        <div >
                  <div class="mb-4">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="search-box">
                   
                      
                    @include('apps.asset-management.modals.asset_assign_search_modal')
                  </div>
                </div>
                
               
              </div>
            </div>
                    
                    <div class="">
                      <div class="d-flex flex-row justify-content-end">
                       Number of Item: {{$data_count}} {!! $data->render() !!}
                      </div>
                      <div class="">
                        <table class="table table-bordered table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                            <th class=" align-middle ps-8">{{__('label.action')}}</th>
                            <th class=" align-middle ps-8">{{__('label.id')}}</th>
                            <th class=" align-middle ps-8">{{__('label.device_name')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset_tag')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset_code')}}</th>
                              <th class=" align-middle ps-8">{{__('label.serial_no')}}</th>
                            <th class=" align-middle ps-8">{{__('label.model_no')}}</th>
                            <th class=" align-middle ps-8">{{__('label.assign-status')}}</th>
                            <th class=" align-middle ps-8">{{__('label.assign_users')}}</th>
                          
                            <th class=" align-middle ps-8">{{__('label.remarks')}}</th>
                            <th class=" align-middle ps-8">{{__('label.description')}}</th>
                            <th class=" align-middle ps-8">{{__('label.category')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset-brand')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset-condition')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset-vendor')}}</th>
                            <th class=" align-middle ps-8">{{__('label._is_sold')}}</th>
                            <th class=" align-middle ps-8">{{__('label.status')}}</th>
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="" >
            <td class=" align-middle white-space-nowrap ps-8" >
                      <div class="d-flex align-items-center text-90">
                         @can('asset-entry-assign-edit')
                            <a class="mr-4"  href="{!! route('asset_item_entry.edit',$value->id) !!}" title="{{__('label.item_details')}}">
                              <span class="fas fa-pen"></span>
                            </a>
                        @endcan
                         @can('asset-entry-assign-edit')
                            <a class="mr-4"   href="{!! route('asset-entry-assign.show',$value->id) !!}" title="{{__('label.item_details')}}">
                              <span class="fas fa-eye"></span>
                            </a>
                        @endcan
                        @if($value->assign_status_id !=1)
                            <a class="mr-4" style="color:{{($value->assign_status_id !=1) ? 'green' :'' }}" href="{{url('asset-management/asset-assign-to-user')}}/{!! $value->id!!}" 
                            title="{{__('label.assign_to_user')}}"><span class="fas fa-reply"></span></a>  
                        @else
                          <a class="mr-4" style="color: red;" href="{{url('asset-management/return_from_user')}}/{{$value->id}}" 
                          title="{{__('label.return_from_user')}}">
                            <span class="fas fa-reply"></span>
                          </a>
                        @endif
                        <!--<a class="mr-4"  href="" title="{{__('label.asset-history')}}">-->
                        <!--      <span class="fas fa-header"></span>-->
                        <!--</a>-->
                        <a class="mr-4"  href="{{url('asset-management/inspection-report')}}/{{$value->id}}" title="{{__('label.asset-inspection-report')}}">
                              <span class="fas fa-flag"></span>
                        </a>
                        @can('asset-entry-assign-delete')
                        <a class="mr-4" onclick="return confirm('are you sure?')" href="{{url('asset-management/asset-entry-assign/delete')}}/{{$value->id}}" title="{{__('label.asset-inspection-report')}}">
                              <span class="fas fa-trash" style="color:red;"></span>
                        </a>
                        @endcan
                        
                       
                      </div>
                      
            </td>
                      
            <td class="= align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->name ?? '' !!}</td>
             <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->asset_tag ?? '' !!}</td>
             <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->asset_code ?? '' !!}</td>
             <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->serial_no ?? '' !!}</td>
              <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->model_no ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 fw-bold">
              {!! $value->assign_status->name ?? '' !!}
            </td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->current_user->_user->_name ?? '' !!}</td>
            
           
           
            
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->description ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->remarks ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->category->_name ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->brand->_name ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->condition->name ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->vendor->name ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">
              @if($value->_is_sold==1)
              <span class="btn btn-sm btn-danger">Sold</span>
              @else
              <span class="btn btn-sm btn-info">Saleable</span>
              @endif
             
            </td>
            
           <td class=" align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 badge-phoenix-success">
            <span class="badge-label">{{ selected_status($value->status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
          </td>
                    </tr>
                   @empty
                   @endforelse
                          </tbody>

                        </table>

                      </div>
                     <div class="d-flex flex-row justify-content-end">
                        {!! $data->render() !!}
                      </div>
                    </div>
                  </div>
        </div>
        </div>
        </div>
        </div>



@endsection

@section('script')
@endsection