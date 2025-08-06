@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('category-allocation.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('category-allocation-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('category-allocation.create') }}"> Add New </a>
               </li>
              @endcan
             
               
              </li>
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
                 @include('backend.category-allocation.search')
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class="_no">No</th>
                         <th class="_action">Action</th>
                         <th>Branch</th>
                         <th>Categories</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                               <td style="display: flex;">
                            <div class="dropdown mr-1">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"> Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                   <a class="dropdown-item "  href="{{ route('category-allocation.show',$data->id) }}">View  </a>
                                  @can('category-allocation-edit')
                                    <a class="dropdown-item " href="{{ route('category-allocation.edit',$data->id) }}">Edit</a>
                                  @endcan
                                 @can('category-allocation-delete')
                                  {!! Form::open(['method' => 'DELETE','route' => ['category-allocation.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm "><span class="_required">Delete</span></button>
                                  {!! Form::close() !!}
                                  @endcan
                                </div>
                              </div>
                        </td>

                            
                           
                            <td>{{ $data->_branch->_name ?? '' }}</td>
                            <td>
                              @php
                                          $category = explode(',', $data->_category_ids ?? '');
                                          @endphp
                                          @forelse($category as $l_id)
                                        <span>{{_category_name($l_id)}}</span><br>
                                          @empty
                                          @endforelse
                            </td>
                           
                            
                           
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

    @include('backend.common-modal.item_ledger_modal')
</div>

@endsection