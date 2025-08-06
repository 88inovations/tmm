@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

<style type="text/css">
 
</style>
<div class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('account-type.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('account-type-create')
              <li class="breadcrumb-item active">
                <a 
       class="btn btn-sm btn-info active "  
       href="{{ route('account-type.create') }}">
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
                      @include('backend.account-type.search')
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

                    @forelse($base_accounts as $key=>$base_val)
                        <ul>
                        <li>{!! $base_val->_name ?? '' !!}
@php
$first_heads = \App\Models\AccountHead::where('_account_id',$base_val->id)->where('_parent_id',0)->get();
@endphp
                          @forelse($first_heads as $first_heads_val)
                          <ul>
                            <li class="list_li">{!! $first_heads_val->_code ?? '' !!}-{!! $first_heads_val->_name ?? '' !!}

                               <a  
                                  href="{{ route('account-type.show',$first_heads_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-type-edit')
                                  <a  
                                  href="{{ route('account-type.edit',$first_heads_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-type-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-type.destroy', $first_heads_val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 

@php
$second_heads = \App\Models\AccountHead::where('_account_id',$base_val->id)->where('_parent_id',$first_heads_val->id)->get();
@endphp
@forelse($second_heads as $second_heads_val)
                              <ul>
                                <li  class="list_li"> 
                                  {!! $second_heads_val->_code ?? '' !!}.  {!! $second_heads_val->_name ?? '' !!}

                                  <a  
                                  href="{{ route('account-type.show',$second_heads_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-type-edit')
                                  <a  
                                  href="{{ route('account-type.edit',$second_heads_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-type-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-type.destroy', $second_heads_val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 

@php
$third_heads = \App\Models\AccountHead::where('_parent_id',$second_heads_val->id)->get();
@endphp

@forelse($third_heads as $third_heads_val)
<ul>
  <li  class="list_li">{!! $third_heads_val->_code ?? '' !!}.  {!! $third_heads_val->_name ?? '' !!}

    <a  
                                  href="{{ route('account-type.show',$third_heads_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-type-edit')
                                  <a  
                                  href="{{ route('account-type.edit',$third_heads_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-type-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-type.destroy', $third_heads_val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 

  </li>
</ul>

@empty
@endforelse

                                </li>
                              </ul>

                            @empty
                            @endforelse

                            </li>

                            
                          </ul>
                          @empty
                          @endforelse

                        </li>
                        
                      </ul>
                      @empty
                      @endforelse
               

                

                
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