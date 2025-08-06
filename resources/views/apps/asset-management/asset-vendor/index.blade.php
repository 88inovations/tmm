@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-vendor-list')
            <li class="breadcrumb-item"><a href="{{route('account-ledger.create')}}">{{__('label.asset-vendor')}}</a></li>
            @endcan
          </ol>
        </nav>

        <div class="mb-9">
          @include('messages.message')







        <div id="orderTable" data-list='{"valueNames":["id","_name","_phone","_address","description","status","order","created_at","updated_at"],"page":10,"pagination":true}'>
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
                  @can('asset-vendor-create')
                  <a class="btn btn-primary "
                  href="{{route('account-ledger.create')}}"
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
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="_account_head_id" >{{__('label._account_head_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_account_group_id" >{{__('label._account_group_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_name" >{{__('label._name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_code" >{{__('label._code')}}</th>
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="_phone" >{{__('label._phone')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_address" >{{__('label._address')}}</th>
                              
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
                          <a 
                                  href="{{ route('account-ledger.show',$value->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                  <a 
                                  href="{{ route('account-ledger.edit',$value->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $value->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
            
            <td class="_account_head_id align-middle white-space-nowrap ps-8 ">{!! $value->account_type->_name ?? '' !!}</td>
            <td class="_account_group_id align-middle white-space-nowrap ps-8 ">{!! $value->account_group->_name ?? '' !!}</td>
            <td class="_name align-middle white-space-nowrap ps-8 ">{!! $value->_name ?? '' !!}</td>
            <td class="_code align-middle white-space-nowrap ps-8 ">{!! $value->code ?? '' !!}</td>
            <td class="_phone align-middle white-space-nowrap ps-8 ">{!! $value->phone ?? '' !!}</td>
            <td class="_address align-middle white-space-nowrap ps-8 ">{!! $value->address ?? '' !!}</td>
           
           <td class="status align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 {{_status_base_class($value->status)}}">
            <span class="badge-label">{{ selected_status($value->_status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
        
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