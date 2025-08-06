@extends('backend.layouts.app')


@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name">Edit Social Media </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="{{ route('board.index') }}"> Social Media Management</a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @if (count($errors) > 0)
           <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                   
                    <form action="{{ route('social_media.update', $social_media->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="name" class="form-control" required value="{{old('name',$social_media->name ?? '')}}" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>URL:</strong>
                                <input type="text" name="url" class="form-control" required value="{{old('url',$social_media->url ?? '')}}" placeholder="URL">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>ICON Class :</strong>
                                <small><a target="__blank" href="https://fontawesome.com/">icon</a></small>
                                <input type="text" name="icon" class="form-control" required value="{{old('icon',$social_media->icon ?? '')}}" placeholder="fab fa-facebook-square">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Position:</strong>
                                <input type="number" name="position" class="form-control" required value="{{old('position',$social_media->position ?? '')}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Status:</strong>
                               <select class="form-control" name="status" required="">
                                 <option @if($social_media->status==1) selected @endif value="1">Active</option>
                                 <option @if($social_media->status==0) selected @endif value="0">In Active</option>
                               </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                
              </div>
            <!-- /.card -->
          </div>
            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection