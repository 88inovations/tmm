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
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li> -->
              <li class="breadcrumb-item active">
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
               {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Organization:<span class="_required">*</span></label>
                                @php
                                $organizations= \DB::table('companies')->where('_status',1)->get();
                                @endphp
                                @php
                                $selected_organization_ids=[];
                                if($user->organization_ids !=0){
                                 $selected_organization_ids =  explode(",",$user->organization_ids);
                                }
                                @endphp
                                
                                <select class="form-control" name="organization_ids[]" multiple="" required>
                                  @forelse($organizations as $val)
                                  <option value="{{$val->id}}" @if(in_array($val->id,$selected_organization_ids)) selected @endif >{{ $val->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Branch:<span class="_required">*</span></label>
                                @php
                                $selected_branchs=[];
                                if($user->branch_ids !=0){
                                 $selected_branchs =  explode(",",$user->branch_ids);
                                }
                                @endphp
                                <select class="form-control" name="branch_ids[]" multiple required>
                                  @forelse($branchs as $branch)
                                  <option value="{{$branch->id}}" @if(in_array($branch->id,$selected_branchs)) selected @endif >{{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Cost Center:<span class="_required">*</span></label>
                                @php
                                $selected_costcenter=[];
                                if($user->cost_center_ids !=0){
                                 $selected_costcenter =  explode(",",$user->cost_center_ids);
                                }
                                @endphp
                                <select class="form-control" name="cost_center_ids[]" multiple required >
                                  @forelse($cost_centers as $cost_center)
                                  <option value="{{$cost_center->id}}" @if(in_array($cost_center->id,$selected_costcenter)) selected @endif  >{{ $cost_center->_name ?? '' }}</option>
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
                                
                                $selected_stores=[];
                                if($user->store_ids !=0){
                                 $selected_stores =  explode(",",$user->store_ids);
                                }
                                @endphp
                                <select class="form-control" name="store_ids[]" multiple="" required>
                                  @forelse($stores as $val)
                                  <option value="{{$val->id}}" @if(in_array($val->id,$selected_stores)) selected @endif  >{{ $val->_name ?? '' }}</option>
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
                                 <option value="visitor" @if($user->user_type=='visitor') selected @endif >User</option>
                                 <option value="admin"  @if($user->user_type=='admin') selected @endif >Admin</option>
                               </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Account Details Type: [If use multiple branch and multiple cost center must use All Ledger Option]</label>
                                <select class="form-control " name="_ac_type">
                                      <option value="0" @if($user->_ac_type==0) selected @endif >All Ledger</option>
                                      <option value="1" @if($user->_ac_type==1) selected @endif >Only Cash & Bank Ledger</option>
                                    </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control " name="status">
                                      <option value="1"  @if($user->status==1) selected @endif >Active</option>
                                      <option value="0"  @if($user->status==0) selected @endif >In Active</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-5">
                            <div class="form-group">
                                <label>Role:</label>
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
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