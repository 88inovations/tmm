@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-entry-assign-list')
            <li class="breadcrumb-item"><a href="{{route('asset-entry-assign.index')}}">{{__('label.asset-entry-assign')}}</a></li>
            @endcan
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
          
        <div data-list='{"valueNames":["id",asset_tag",name","category","brand","vendor","model_no","description","status","order","remarks","created_at","updated_at"],"page":10,"pagination":true}'>
                  <div class="mb-4">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search orders" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div>
                </div>
                
                <div class="col-auto">
                  @can('asset-entry-assign-create')
                  <a class="btn btn-primary "
                  href="{{route('asset-entry-assign.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a>
                   @endcan
                </div>
              </div>
            </div>
                    
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                      <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                              
                            
                              <th class=" align-middle ps-8" scope="col"  >{{__('label.action')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="id" >{{__('label.id')}}</th>
                              <th class="short align-middle ps-8" scope="col" data-short="asset_tag"  >{{__('label.asset_tag')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="name" >{{__('label.name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="category" >{{__('label.category')}}</th>
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="brand" >{{__('label.brand')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="vendor" >{{__('label.vendor')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="model_no" >{{__('label.model_no')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="remarks" >{{__('label.remarks')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="status" >{{__('label.status')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="order" >{{__('label.order')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_at" >{{__('label.created_at')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_at" >{{__('label.updated_at')}}</th>
                              
                             
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
             <td class=" align-middle white-space-nowrap ps-8">
                      <div class="d-flex align-items-center text-90">
                         @can('asset-entry-assign-edit')
                            <a class="mr-10"  href="{{ route('asset-entry-assign.edit',$value->id) }}?_lang_ref={!! $lan_data->lang_code ?? 'en_US' !!}" title="{!! $lan_data->lang_name ?? 'English' !!}">
                              <span class="fas fa-pen"></span>
                            </a>
                           

                        @endcan
                       
                         @can('asset-entry-assign-delete')         
                                    {!! Form::open(['method' => 'DELETE','route' => ['asset-entry-assign.destroy', $value->id],'style'=>'display:inline']) !!}
                                         <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                                    {!! Form::close() !!}
                          @endcan
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
            <td class="asset_tag align-middle white-space-nowrap ps-8 ">
              {!! $value->asset_tag ?? '' !!}
            </td>
            <td class="name align-middle white-space-nowrap ps-8 ">{!! $value->name ?? '' !!}</td>
            <td class="category align-middle white-space-nowrap ps-8 ">{!! $value->category->name ?? '' !!}</td>
            <td class="brand align-middle white-space-nowrap ps-8 ">{!! $value->brand->name ?? '' !!}</td>
            <td class="vendor align-middle white-space-nowrap ps-8 ">{!! $value->vendor->name ?? '' !!}</td>
            <td class="model_no align-middle white-space-nowrap ps-8 ">{!! $value->model_no ?? '' !!}</td>
            <td class="description align-middle white-space-nowrap ps-8 ">{!! $value->description ?? '' !!}</td>
            <td class="remarks align-middle white-space-nowrap ps-8 ">{!! $value->remarks ?? '' !!}</td>
           <td class="status align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 {{_status_base_class($value->status)}}">
            <span class="badge-label">{{ selected_status($value->status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
        
            <td class="order align-middle white-space-nowrap ps-8 ">{!! $value->order ?? '' !!}</td>    
            <td class="created_at align-middle white-space-nowrap ps-8 ">{!! $value->created_at ?? '' !!}</td>    
            <td class="updated_at align-middle white-space-nowrap ps-8 ">{!! $value->updated_at ?? '' !!}</td>    
                    </tr>
                   @empty
                   @endforelse
                          </tbody>
                        </table>
                      </div>
                      @include('common-widgets.datatable_footer')
                    </div>
                  </div>
            
          
          
          
        </div>



@endsection

@section('script')
@endsection