@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('users.index') }}">User Management </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right"> <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="{{ route('users.index') }}"> User Management</a>
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
                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Organization:<span class="_required">*</span></label>
                                @php
                                $organizations= \DB::table('companies')->where('_status',1)->get();
                                @endphp
                                <select class="form-control" name="organization_ids[]" multiple="" required>
                                  @forelse($organizations as $val)
                                  <option value="{{$val->id}}"  >{{ $val->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Branch:<span class="_required">*</span></label>
                                
                                <select class="form-control" name="branch_ids[]" multiple="" required>
                                  @forelse($branchs as $branch)
                                  <option value="{{$branch->id}}"  >{{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Cost Center:<span class="_required">*</span></label>
                                
                                <select class="form-control" name="cost_center_ids[]" multiple="" required >
                                  @forelse($cost_centers as $cost_center)
                                  <option value="{{$cost_center->id}}"  >{{ $cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Store:<span class="_required">*</span></label>
                                @php
                                $stores= \DB::table('store_houses')->where('_status',1)->get();
                                @endphp
                                <select class="form-control" name="organization_ids[]" multiple="" required>
                                  @forelse($stores as $val)
                                  <option value="{{$val->id}}"  >{{ $val->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Name:</label>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>User Name/EMP ID:</label>
                                {!! Form::text('user_name', null, array('placeholder' => 'EMP ID','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Ledger ID:</label>
                                {!! Form::text('ref_id', null, array('placeholder' => 'Ledger ID','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Email:</label>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Password:</label>
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Confirm Password:</label>
                                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                            </div>
                        </div>

@if(\Auth::user()->user_type=='admin')
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>User Type:</label>
                               <select name="user_type" class="form-control">
                                 <option value="visitor">User</option>
                                 <option value="admin">Admin</option>
                               </select>
                            </div>
                        </div>
@endif
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Account Details Type: [If use multiple branch and multiple cost center must use All Ledger Option]</label>
                                <select class="form-control " name="_ac_type">
                                      <option value="0"  >All Ledger</option>
                                      <option value="1"  >Only Cash & Bank Ledger</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-5">
                            <div class="form-group">
                                <label>Role:</label>
                                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control " name="status">
                                      <option value="1"  >Active</option>
                                      <option value="0"  >In Active</option>
                                    </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
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