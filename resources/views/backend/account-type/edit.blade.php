@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a class="m-0 _page_name" href="{{ route('account-type.index') }}"> {!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               @can('account-type-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="{{ route('account-type.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
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
               
                 <form action="{{ url('account-type/update') }}" method="POST">
                    @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label>Account:</label>
                                  @php
$main_accounts = \DB::table('main_account_head')->get();
                        @endphp
                        <select class="form-control" name="_account_id">
                                    @forelse($main_accounts as $main)
                                  <option value="{{$main->id}}" @if($data->_account_id==$main->id) selected @endif>{{$main->_name}}</option>
                                 @empty
                                 @endforelse
                                </select>
                                

                       
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Account Level:</label>
                                <select class="form-control" name="_parent_id">
                                  <option value="">--Select--</option>
                                 @forelse($account_types as $account_type )
                                  <option value="{{$account_type->id}}" @if(isset($data->_parent_id)) @if($data->_parent_id == $account_type->id) selected @endif   @endif  >{{ $account_type->_code ?? '' }}-{{ $account_type->_name ?? '' }}</option>


                                  @php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  @endphp
                                  @forelse($_child_groups as $group)
                                        <option value="{{$group->id}}"  @if($data->_parent_id == $group->id) selected @endif   > &nbsp; &nbsp; &nbsp; &nbsp;{{ $group->_code ?? '' }}-{{ $group->_name ?? '' }}</option>

                                         @php
                                        $third_child_group=$group->_child_group ?? [];
                                        @endphp

                                         @forelse($third_child_group as $third_child_val)

 <option value="{{$third_child_val->id}}"  @if($data->_parent_id == $third_child_val->id) selected @endif   > &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;{{ $third_child_val->_code ?? '' }}-{{ $third_child_val->_name ?? '' }}</option>
                                         @empty
                                         @endforelse



                                  
                                  @empty
                                  @endforelse

                                  
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
                                <label>Code:</label>
                                
                                 <input type="text" name="_code" class="form-control" required="true" value="{!! $data->_code ?? '' !!}">
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
                       
                       
                        <div class="col-xs-6 col-sm-6 col-md-6 text-center mt-1">
                            <button type="submit" class="btn btn-success "><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
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