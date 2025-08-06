@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('branch.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('branch-create')
              <li class="breadcrumb-item active">
                <a  
       class="btn btn-sm btn-info active " 
       href="{{ route('branch.create') }}">
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
                 @include('backend.branch.search')
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class="_no">No</th>
                         <th class="">Action</th>
                         <th>Name</th>
                         <th>Code</th>
                         <th>Address</th>
                         <th>Date</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Created By</th>
                         <th>Updated By</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
 <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('branch.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('branch-edit')
                                  <a 
                                  href="{{ route('branch.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('branch-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['branch.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                              
                        
                            
                            <td>{{ $data->id }} - {{ $data->_name }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ $data->_address ?? '' }}</td>
                            <td>{{ $data->_date ?? '' }}</td>
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ $data->_created_by ?? '' }}</td>
                            <td>{{ $data->_updated_by ?? '' }}</td>
                            <td>{{ ($data->_status==1) ? 'Active' : 'In Active' }}</td>
                           
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