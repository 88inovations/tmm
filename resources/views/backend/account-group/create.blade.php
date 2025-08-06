@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('account-group.index') }}"> {!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             @can('account-group-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('account-group.index') }}">  <i class="fa fa-th-list" aria-hidden="true"></i> </a>
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
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                {!! Form::open(array('route' => 'account-group.store','method'=>'POST')) !!}
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Account Type:</label>
                               <select class="form-control" name="_account_head_id">
                                  <option value="">--Select--</option>
                                  @forelse($account_types as $account_type )


                                  <option value="{{$account_type->id}}"  @if(old('_account_head_id') == $account_type->id) selected @endif  @if($account_type->_has_child==1) disabled @endif >{{ $account_type->_code ?? '' }}-{{ $account_type->_name ?? '' }}</option>

                                  @php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  @endphp
                                  @forelse($_child_groups as $group)
                                        <option value="{{$group->id}}"  @if(old('_account_head_id') == $group->id) selected @endif   > &nbsp; &nbsp; &nbsp; &nbsp;{{ $group->_code ?? '' }}-{{ $group->_name ?? '' }}</option>

                                        @php
                                        $third_child_group=$group->_child_group ?? [];
                                        @endphp

                                         @forelse($third_child_group as $third_child_val)

 <option value="{{$third_child_val->id}}"  @if(old('_account_head_id') == $third_child_val->id) selected @endif   > &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;{{ $third_child_val->_code ?? '' }}-{{ $third_child_val->_name ?? '' }}</option>
                                         @empty
                                         @endforelse



                                  @empty
                                  @endforelse

                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Name:</label>
                                {!! Form::text('_name', null, array('placeholder' => 'Name','class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Code:</label>
                                {!! Form::text('_code', null, array('placeholder' => 'Code','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Display Possition:</label>
                                {!! Form::text('_short', null, array('placeholder' => 'Possition','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Details:</label>
                               <textarea placeholder="Details" class="form-control" name="_details" cols="10" rows="5"></textarea>
                                
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="ml-10">
                            <button type="submit" class="btn btn-success "><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
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