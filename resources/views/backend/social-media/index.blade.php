@extends('backend.layouts.app')


@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name">Social Media Management </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               @can('social_media-create')
                        <a class="btn btn-success" href="{{ route('social_media.create') }}"> Create New Social Media</a>
                @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <!-- /.content-header -->
<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 @include('roles.search')
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered _list_table">
                     <thead>
                       <tr>
                       <th>No</th>
                       <th>Name</th>
                       <th>URL</th>
                       <th>Icon</th>
                       <th>Position</th>
                       <th>Status</th>
                       <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach ($data as $key => $social_media)
                      <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{ $social_media->name ?? '' }}</td>
                        <td>{{ $social_media->url ?? '' }}</td>
                        <td><i class="{{ $social_media->icon ?? '' }}"></i></td>
                        <td>{{ $social_media->position ?? '' }}</td>
                        <td>
                          @if($social_media->status==1) Active @endif
                          @if($social_media->status==0) In Active @endif
                        </td>
                        <td>
                           <a class="btn btn-info" href="{{ route('social_media.show',$social_media->id) }}"> <i class="far fa-eye"></i></a>
                           <a class="btn btn-primary" href="{{ route('social_media.edit',$social_media->id) }}"><i class="fas fa-pen"></i></a>
                            {!! Form::open(['method' => 'DELETE','route' => ['social_media.destroy', $social_media->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Trash', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
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