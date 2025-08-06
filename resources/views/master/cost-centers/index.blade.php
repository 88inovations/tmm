@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">{{__('label.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('cost-centers.index')}}">{{__('label.cost-centers')}}</a></li>
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
          
        <div id="orderTable" data-list='{"valueNames":["_name","_code","_start_date","_end_date","_detail","_is_close","_status","order","_created_by","_updated_by","created_at","updated_at"],"page":10,"pagination":true}'>
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
                  @can('cost-centers-create')
                  <a class="btn btn-primary "
                  href="{{route('cost-centers.create')}}"
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
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="_name" >{{__('label._name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_code" >{{__('label._code')}}</th>
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="_start_date" >{{__('label._start_date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_end_date" >{{__('label._end_date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_is_close" >{{__('label._is_close')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_detail" >{{__('label.description')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_status" >{{__('label._status')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="order" >{{__('label.order')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_created_by" >{{__('label._created_by')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_updated_by" >{{__('label._updated_by')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_at" >{{__('label.created_at')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_at" >{{__('label.updated_at')}}</th>
                            
                             
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
             <td class=" align-middle white-space-nowrap ps-8">
                      <div class="d-flex align-items-center text-90">
                         @can('cost-centers-edit')
                            <a class="mr-10"  href="{{ route('cost-centers.edit',$value->id) }}?_lang_ref={!! $lan_data->lang_code ?? 'en_US' !!}" title="{!! $lan_data->lang_name ?? 'English' !!}">
                              <span class="fas fa-pen"></span>
                            </a>
                           

                        @endcan
                       
                         @can('cost-centers-delete')         
                                    {!! Form::open(['method' => 'DELETE','route' => ['cost-centers.destroy', $value->id],'style'=>'display:inline']) !!}
                                         <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                                    {!! Form::close() !!}
                          @endcan
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
           
            <td class="_name align-middle white-space-nowrap ps-8 ">{!! $value->_name ?? '' !!}</td>
            <td class="_code align-middle white-space-nowrap ps-8 ">{!! $value->_code ?? '' !!}</td>
            
            <td class="_start_date align-middle white-space-nowrap ps-8 ">{!! $value->_start_date ?? '' !!}</td>
            <td class="_end_date align-middle white-space-nowrap ps-8 ">{!! $value->_end_date ?? '' !!}</td>
            <td class="_is_close align-middle white-space-nowrap ps-8 ">{!! $value->_is_close ?? '' !!}</td>
            <td class="_detail align-middle white-space-nowrap ps-8 ">{!! $value->_detail ?? '' !!}</td>
           <td class="status align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 {{_status_base_class($value->status)}}">
            <span class="badge-label">{{ selected_status($value->status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
        
            <td class="order align-middle white-space-nowrap ps-8 ">{!! $value->order ?? '' !!}</td>    
            <td class="_created_by align-middle white-space-nowrap ps-8 ">{!! $value->_created_by ?? '' !!}</td>    
            <td class="_updated_by align-middle white-space-nowrap ps-8 ">{!! $value->_updated_by ?? '' !!}</td>    
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
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endsection