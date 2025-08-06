@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('account-ledger.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             @can('account-ledger-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('account-ledger.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                 @include('backend.message.message')
              </div>
             
              <div class="card-body">
                {!! Form::open(array('route' => 'account-ledger.store','method'=>'POST')) !!}
                   
                      
                      <div class="form-group row">
                                <label class="col-md-2">Account Type: <span class="_required">*</span></label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                               <select type_base_group="{{url('type_base_group')}}" class="form-control _account_head_id " name="_account_head_id" required>
                                  <option value="">--Select Account Type--</option>
                                  @forelse($account_types as $account_type )
                                  <option value="{{$account_type->id}}"  @if(old('_account_head_id') == $account_type->id) selected @endif   >{{ $account_type->_code ?? '' }}-{{ $account_type->_name ?? '' }}</option>

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
                       
                            <div class="form-group row">
                                <label  class="col-md-2">Account Group:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                               <select class="form-control _account_groups " name="_account_group_id" required>
                                  <option value="">--Select Account Group--</option>
                                  @forelse($account_groups as $account_group )
                                  <option value="{{$account_group->id}}"  @if(old('_account_group_id') == $account_group->id) selected @endif   >{{ $account_group->_code ?? '' }} - {{ $account_group->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        @php
                            $users = \Auth::user();
                            $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                            $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
                            @endphp 


                          
                             <div class="form-group row @if(sizeof($permited_organizations)==1) display_none @endif">
                                  <label  class="col-md-2">{!! __('label.organization') !!}:<span class="_required">*</span></label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control _ledger_organization_id" name="organization_id" required >

                                   
                                   @forelse($permited_organizations as $val )
                                   <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                                   @empty
                                   @endforelse
                                 </select>
                             </div>
                            </div>
                            
                            <div class="form-group row">
                                 <label  class="col-md-2">Branch:<span class="_required">*</span></label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                               <select class="form-control" name="_branch_id" required >
                                @if(sizeof($branchs) > 1)
                                    <option value=""><--- Select ---></option>
                                @endif
                                  @forelse($branchs as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                         <div class="form-group row  ">
                              <label  class="col-md-2">Cost Center:<span class="_required">*</span></label>
                              <div class="col-xs-12 col-sm-12 col-md-6">
                            <select class="form-control _ledger_cost_center_id" name="_cost_center_id" required >
                               @if(sizeof($permited_costcenters) > 1)
                                    <option value=""><--- Select ---></option>
                                @endif
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                       
                            <div class="form-group row">
                                 <label  class="col-md-2">Code:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_code" class="form-control" value="{{old('_code')}}" placeholder="CODE Number">
                            </div>
                        </div>
                            <div class="form-group row">
                                 <label  class="col-md-2">Ledger Name:<span class="_required">*</span></label>
                              <div class="col-xs-12 col-sm-12 col-md-6">  
                                <input type="text" name="_name" class="form-control" value="{{old('_name')}}" placeholder="Ledger Name" required>
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">Proprietor:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_alious" class="form-control" value="{{old('_alious')}}" placeholder="Proprietor">
                            </div>
                        </div>
                            <div class="form-group row">
                                 <label  class="col-md-2">Email:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="email" name="_email" class="form-control" value="{{old('_email')}}" placeholder="Email" >
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Phone:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_phone" class="form-control" value="{{old('_phone')}}" placeholder="Phone" >
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Address:</label>
                                
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <textarea name="_address" class="form-control" placeholder="Address">{{old('_address')}}</textarea>
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Details:</label>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <textarea name="_note" class="form-control" placeholder="Details"></textarea>
                                   
                                </div>
                            </div>
                           
                        
                            <div class="form-group row display_none" >
                                 <label  class="col-md-2">Display Possition:</label>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                {!! Form::text('_short', null, array('placeholder' => 'Possition','class' => 'form-control')) !!}
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">NID Number:</label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                               <input type="text" name="_nid" class="form-control" value="{{old('_nid')}}" placeholder="NID Number">
                            </div>
                        </div>
                        
                       
                            <div class="form-group row">
                                 <label  class="col-md-2">Credit Limit:</label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="number" step="any" name="_credit_limit" class="form-control" value="{{old('_credit_limit',0)}}" placeholder="Credit Limit" >
                            </div>
                        </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Image:</strong>
                                <input type="file" name="_image" class="form-control" placeholder="Image" style="line-height:1;">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>NID Image:</strong>
                                <input type="file" name="_nidimage" class="form-control" placeholder="Nid Image" style="line-height:1;">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Checkbook Page Image:</strong>
                                <input type="file" name="_checkbookpageimage" class="form-control" placeholder="Checkbook Page Image" style="line-height:1;">
                            </div>
                        </div>
                       
                        
                            <div class="form-group row ">
                                 <label  class="col-md-2">Is User:</label>
                         <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_user">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row ">
                                 <label  class="col-md-2">Sales Form:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_sales_form">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row ">
                                 <label  class="col-md-2">Is Purchase Form:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_purchase_form">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="form-group ">
                                 <label  class="col-md-2">Search For All Branch:</label>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_all_branch">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Opening Dr Amount:</label>
                                  <div class="col-xs-12 col-sm-12 col-md-6">
                                <input id="opening_dr_amount" type="number" name="opening_dr_amount" class="form-control" placeholder="Dr Amount" value="0" step="any" min="0">
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                 <label  class="col-md-2">Opening Cr Amount:</label>
                                  <div class="col-xs-12 col-sm-12 col-md-6">
                                <input id="opening_cr_amount" type="number" name="opening_cr_amount" class="form-control" placeholder="Cr Amount" value="0" step="any" min="0">
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Status:</label>
                                  <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_status">
                                  @foreach(common_status() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
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