@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('project_management.index') }}">{{$page_name}}</a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('user-create')
              <li class="breadcrumb-item active">
                <a 
               class="btn btn-sm btn-info active " 
               
               href="{{ route('project_management.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
                  
               </li>
              @endcan
            </ol>
          </div>

        
      </div><!-- /.container-fluid -->
    </div>
     @include('backend.message.message')
    <!-- /.content-header -->
<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                     <thead>
                       <tr>
                       <th>No</th>
                       <th class="">Action</th>
                       <th>Name</th>
                       <th>Address</th>
                       <th>Status</th>
                     
                     </tr>
                     </thead>
                     <tbody>
                     @foreach ($data as $key => $val)
                      <tr>

                        <td>{{ $key+1 }}</td>
                        <td>{{ $val->id }} - {!! $val->project_name ?? '' !!}</td>
                        <td>{!! $val->project_addess ?? '' !!}</td>
                        
                        <td>
                          
                          {{ ($val->status==1) ? 'Active' : 'In Active' }}</td>
                       
                      </tr>
                     @endforeach
                     </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex flex-row justify-content-end">
                  {!! $data->render() !!}
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