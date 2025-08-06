@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('cost-center.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('cost-center-create')
              
               <a  
               class="btn btn-sm btn-info active " 
               href="{{ route('cost-center.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
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
                 @include('backend.cost-center.search')
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <table class="table table-bordered _list_table ">
                      <thead>
                        <tr>
                         <th class="_no">No</th>
                         <th class="_action">Action</th>
                         <th>Name</th>
                         <th>Code</th>
                         <th>Start Date</th>
                         <th>End Date</th>
                         <th>Details</th>
                         <th>Condition</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        
                      
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                                <td style="display: flex;">
                           
                                <a   
                                  href="{{ route('cost-center.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('cost-center-edit')
                                  <a   
                                  href="{{ route('cost-center.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  @endcan
                                @can('cost-center-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['cost-center.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  

                               <!-- @can('cost-center-authorization-chain')
                                  <a  type="button" 
                                  href="{{ url('cost-center-chain') }}/{{$data->id}}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-users "></i></a>
                                  @endcan -->
                               
                        </td>  
                              
                            <td>{{ $data->id }} - {{ $data->_name }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_start_date ?? '') }}</td>
                            <td>{{ _view_date_formate($data->_end_date ?? '') }}</td>
                            <td>{{ $data->_detail ?? '' }}</td>
                            <td>
                  @if($data->_is_close==1) <span class="btn btn-warning">Running</span> @endif
                  @if($data->_is_close==2) <span class="btn btn-success">Completed</span> @endif
                  @if($data->_is_close==3) <span class="btn btn-danger">Stop</span> @endif
                            </td>
                            <td>
                  @if($data->_status==1) <span class="btn btn-success">Active</span> @endif
                  @if($data->_status==0) <span class="btn btn-danger">Disable</span> @endif
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
</div>

@endsection