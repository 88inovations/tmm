@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a class="m-0 _page_name" href="{{ route('cost-center.index') }}"> {!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li> -->
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="{{ route('cost-center.index') }}"> {{ $page_name ?? '' }} </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
               
                 <form action="{{ url('cost-center/update') }}" method="POST">
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
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Name:</label>
                                {!! Form::text('_name', $data->_name, array('placeholder' => 'Name','class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Code:</label>
                                {!! Form::text('_code', $data->_code, array('placeholder' => 'Code','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>{{__('label.start_date')}}:</label>
                                {!! Form::date('_start_date', $data->_start_date, array('placeholder' => __('label.start_date'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>{{__('label.end_date')}}:</label>
                                {!! Form::date('_end_date', $data->_end_date, array('placeholder' => __('label.end_date'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label.details')}}:</label>
                                <textarea class="form-control" name="_detail">{!! $data->_detail ?? '' !!}</textarea>
                               
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label.condition')}}:</label>
                               <select class="form-control" name="_is_close">
                                    <option value="1" @if($data->_is_close==1) selected @endif >Running</option>
                                    <option value="2" @if($data->_is_close==2) selected @endif >Complete</option>
                                    <option value="3" @if($data->_is_close==3) selected @endif >Stop</option>
                               </select>
                               
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._status')}}:</label>
                               <select class="form-control" name="_status">
                                    <option value="1" @if($data->_status==1) selected @endif >Active</option>
                                    <option value="0" @if($data->_status==0) selected @endif >Disable</option>
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