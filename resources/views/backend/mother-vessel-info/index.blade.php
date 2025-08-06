@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

         <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('mother-vessel-info.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('mother-vessel-info-create')
              <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info active " 
               href="{{ route('mother-vessel-info.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
               </li>
              @endcan
            </ol>
          </div>
          
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 
                 <div class="row">
                   @php

                     $currentURL = URL::full();
                     $current = URL::current();
                    if($currentURL === $current){
                       $print_url = $current."?print=single";
                       $print_url_detal = $current."?print=detail";
                    }else{
                         $print_url = $currentURL."&print=single";
                         $print_url_detal = $currentURL."&print=detail";
                    }
    

                   @endphp
                    <div class="col-md-4">
                      @include('backend.mother-vessel-info.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('voucher-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                
                              
                                    
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                        <th>{{__('label._action')}}</th>
                        <th>{{ __('label.id') }} </th>
                        <th>{{ __('label._name') }}</th>
                        <th>{{ __('label._code') }}</th>
                        <th>{{ __('label._country_name') }}</th>
                        <th>{{ __('label._license_no') }}</th>
                        <th>{{ __('label._route') }}</th>
                        <th>{{ __('label._owner_name') }}</th>
                        <th>{{ __('label._contact_one') }}</th>
                        <th>{{ __('label._contact_two') }}</th>
                        <th>{{ __('label._contact_three') }}</th>
                        <th>{{ __('label._capacity') }}</th>
                        <th>{{ __('label._type') }}</th>
                        <th>{{ __('label._status') }}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                             <td style="display: flex;">
                           
                                <a  
                                  href="{{ route('mother-vessel-info.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('mother-vessel-info-edit')
                                  <a  
                                  href="{{ route('mother-vessel-info.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i>
                                </a>
                                  @endcan
                                  
                                @can('mother-vessel-info-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['mother-vessel-info.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                           
                            <td>{{ $data->id }} </td>
                            <td> {{ $data->_name ?? '' }}</td>
                            <td> {{ $data->_code ?? '' }}</td>
                            <td> {{ $data->_country_name ?? '' }}</td>
                            <td> {{ $data->_license_no ?? '' }}</td>
                            <td> {{ $data->_route ?? '' }}</td>
                            <td> {{ $data->_owner_name ?? '' }}</td>
                            <td> {{ $data->_contact_one ?? '' }}</td>
                            <td> {{ $data->_contact_two ?? '' }}</td>
                            <td> {{ $data->_contact_three ?? '' }}</td>
                            <td> {{ $data->_capacity ?? '' }}</td>
                            <td>{{ selected_vessel_type($data->_type) }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection