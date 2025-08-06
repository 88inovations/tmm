@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('warranty.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('warranty-create')
               

              <li class="breadcrumb-item active">
                  <button type="button" 
               class="btn btn-sm btn-info active attr_base_create_url" 
               data-toggle="modal" 
               data-target="#commonEntryModal_item" 
               attr_base_create_url="{{ route('warranty.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </button>
               </li>
              @endcan
            </ol>
          </div>
        </div><!-- /.row -->

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
                 @include('backend.warranty.search')
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered _list_table ">
                      <thead>
                        <tr>
                         <th class="_no">No</th>
                         <th>Action</th>
                         <th>Name</th>
                         <th>Description</th>
                         <th>Duration</th>
                         <th>Period</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
 <td style="display: flex;">
                           
                                <button  type="button" 
                                  attr_base_edit_url="{{ route('warranty.show',$data->id) }}"
                                  data-toggle="modal" 
                                  data-target="#commonEntryModal_item" 
                                  class="btn btn-sm btn-default attr_base_edit_url mr-1"><i class="fa fa-eye"></i></button>


                                  @can('warranty-edit')
                                  <button  type="button" 
                                  attr_base_edit_url="{{ route('warranty.edit',$data->id) }}"
                                  data-toggle="modal" 
                                  data-target="#commonEntryModal_item" 
                                  class="btn btn-sm btn-default attr_base_edit_url mr-1"><i class="fa fa-pen "></i></button>

                                    
                                  @endcan
                                @can('warranty-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['warranty.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>
                        
                            <td>{{ $data->_name }}</td>
                            <td>{{ $data->_description ?? '' }}</td>
                            <td>{{ $data->_duration ?? '' }}</td>
                            <td>{{ $data->_period ?? '' }}</td>
                            
                           
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