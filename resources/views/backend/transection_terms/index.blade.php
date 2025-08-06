@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('transection_terms.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('transection_terms-create')
              <li class="breadcrumb-item active">
                <a 
       class="btn btn-sm btn-info active " 
      
       href="{{ route('transection_terms.create') }}">
        <i class="nav-icon fas fa-plus"></i> Create New
       </a>

               </li>
              @endcan
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
                @include('backend.message.message')
            
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
                      @include('backend.transection_terms.search')
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
                <div class="table-responsive">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class="_action">Action</th>
                         <th>ID</th>
                         <th>Name</th>
                         <th>Font Color</th>
                         <th>Number of Days</th>
                         <th>Detail</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td style="display: flex;">
                           <a   
                                  href="{{ route('transection_terms.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('transection_terms-edit')
                                  <a   
                                  href="{{ route('transection_terms.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan


                                
                                @can('transection_terms-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['transection_terms.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                           
                            <td>{{ $data->id }} </td>
                            <td style="color:{{$data->_font_color ?? '#000000'}}"> {{ $data->_name ?? '' }}</td>
                            <td> {{ $data->_font_color ?? '' }}</td>
                            <td> {{ $data->_days ?? 0 }}</td>
                            <td> {{ $data->_detail ?? '' }}</td>
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