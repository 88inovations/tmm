@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<div class="container">
  @include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-location-list')
            <li class="breadcrumb-item"><a href="{{route('asset-location.index')}}">{{__('label.asset-location')}}</a></li>
            @endcan
              @can('asset-location-create')
                  <li class="breadcrumb-item">
                    <a class="btn btn-sm btn-info" 
                  href="{{route('asset-location.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a></li>
                   @endcan
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
          
        <div id="orderTable" data-list='{"valueNames":["name","code","description","status","order","created_at","updated_at"],"page":10,"pagination":true}'>
                  
                    
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                      <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                              
                             
                              <th class=" align-middle ps-8" scope="col"  >{{__('label.action')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="id" >{{__('label.id')}}</th>
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="name" >{{__('label.name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="code" >{{__('label.code')}}</th>
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="description" >{{__('label.description')}}</th>
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
                         @can('asset-location-edit')
                            <a class="mr-4"  href="{{ route('asset-location.edit',$value->id) }}?_lang_ref={!! $lan_data->lang_code ?? 'en_US' !!}" title="{!! $lan_data->lang_name ?? 'English' !!}">
                              <span class="fas fa-pen"></span>
                            </a>
                        @endcan
                       
                         @can('asset-location-delete')         
                                    {!! Form::open(['method' => 'DELETE','route' => ['asset-location.destroy', $value->id],'style'=>'display:inline']) !!}
                                         <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                                    {!! Form::close() !!}
                          @endcan
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
           
            <td class="name align-middle white-space-nowrap ps-8 ">{!! $value->name ?? '' !!}</td>
            <td class="code align-middle white-space-nowrap ps-8 ">{!! $value->code ?? '' !!}</td>
            
            <td class="description align-middle white-space-nowrap ps-8 ">{!! $value->description ?? '' !!}</td>
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
</div>


@endsection

@section('script')
@endsection