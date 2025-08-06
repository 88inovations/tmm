@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <a class="m-0 _page_name" href="{{ route('table-info.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('table-info.index') }}"> {{ $page_name ?? '' }} </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @if (count($errors) > 0)
           <div class="alert alert-danger">
               
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
               
                   {!! Form::model($data, ['method' => 'PATCH','route' => ['table-info.update', $data->id]]) !!}
                    @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label>Branch:</label>
                                
                                <select class="form-control" name="_branch_id" required>
                                  @forelse($branchs as $branch)
                                  <option value="{{$branch->id}}" @if($data->_branch_id==$branch->id) selected @endif>{{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Name:</label>
                                
                                <input type="text" name="_name" class="form-control" required="true" value="{!! $data->_name ?? '' !!}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Number of Chair:</label>
                                {!! Form::text('_number_of_chair', $data->_number_of_chair, array('placeholder' => 'Number of Chair','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" @if($data->_status==1) selected @endif >Active</option>
                                  <option value="0" @if($data->_status==0) selected @endif >In Active</option>
                                </select>
                            </div>
                        </div>
                       
                        
                       <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
                    </div>
                    </form>
                
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