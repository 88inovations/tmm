@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

<style type="text/css">
  
</style>
<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .indent {
            padding-left: 20px;
        }
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
                         
                         
                          </div>
                    </div>
                  </div>
              </div>
        <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Children</th>
            </tr>
        </thead>
        <tbody>
            @php
$check_duplicates_main_head=[];
            @endphp
            @foreach ($datas as $data)
            <tr>
                @if(!in_array($data->_account_id,$check_duplicates_main_head))
                <td colspan="3"><b>{!! $data->_main_account_head->_name ?? '' !!}</b></td>

                 @php
                    $check_duplicates_main_head[]=$data->_account_id;
                    @endphp
                @endif
            </tr>

                <tr>
                    <td></td>
                    <td>
                        <li class="list_li">
                                         @can('account-type-edit')
                                  <a  
                                  href="{{ route('account-type.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-type-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-type.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 
                        {{ $data->_name ?? '' }}</td>
                    <td>
                        @if ($data->children->isNotEmpty())
                            <ul>
                                @foreach ($data->children as $child)
                                    <li class="list_li">
                                         @can('account-type-edit')
                                  <a  
                                  href="{{ route('account-type.edit',$child->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-type-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-type.destroy', $child->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 
                                        {{ $child->_name ?? '' }}
                                        @include('backend.account-type.children', ['children' => $child->children])
                                    </li>
                                @endforeach
                            </ul>
                        @else
                           
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection