@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="#">{{__('label.profile_update')}}</a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li> -->
              <li class="breadcrumb-item active">
                 {{__('label.profile')}}
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
     @include('backend.message.message')
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
               <form action="{{ url('user-profile-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                         <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Name:</label>
                                {!! Form::text('name', $user->name, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>User Name/EMP ID:</label>
                                {!! Form::text('user_name', $user->user_name, array('placeholder' => 'User Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Email:</label>
                                {!! Form::text('email', $user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Password:</label>
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            
                            <div class="form-group">
                                <label>Image:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="image" class="form-control">
                               <img id="output_1" class="banner_image_create" src="{{asset($user->image ?? '')}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        
                        </div>
                        
                        
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control " name="status">
                                      <option value="1"  @if($user->status==1) selected @endif >Active</option>
                                      <option value="0"  @if($user->status==0) selected @endif >In Active</option>
                                    </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
                    </div>
                    {!! Form::close() !!}
                
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