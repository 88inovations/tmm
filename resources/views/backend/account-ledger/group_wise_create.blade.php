@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')

@php
$_type  = $request->_type ?? 'customer';
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('group_wise_list') }}?_type={{$_type}}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             @can('account-ledger-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('group_wise_list') }}?_type={{$_type}}"> {{$page_name ?? ''}}</a>
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
              @php
                            $users = \Auth::user();
                            $branchs = permited_branch(explode(',',$users->branch_ids));
                            $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                            $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
                            @endphp 
              <div class="card-body">
                {!! Form::open(array('route' => 'customer_store','method'=>'POST')) !!}
                   
                      
                      <div class="form-group row">
                                <label class="col-md-2">Account Type: <span class="_required">*</span></label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                               <select type_base_group="{{url('type_base_group')}}" class="form-control _account_head_id " name="_account_head_id" required>
                                @if(sizeof($account_types) > 1)
                                  <option value="">--Select Account Type--</option>
                                @endif
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
                                @if(sizeof($account_groups) > 1)
                                  <option value="">--Select Account Group--</option>
                                @endif
                                  @forelse($account_groups as $account_group )
                                  <option value="{{$account_group->id}}"  @if(old('_account_group_id') == $account_group->id) selected @endif   >{{ $account_group->_code ?? '' }} - {{ $account_group->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                       


                          
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

                        @if($_type=='honorarium')

                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label._designation')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_designation" class="form-control _designation" value="{{old('_designation')}}" placeholder="{{__('label._designation')}}" >
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label._specialist')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_specialist" class="form-control _specialist" value="{{old('_specialist')}}" placeholder="{{__('label._specialist')}}" >
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label._address_2')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_address_2" class="form-control _address_2" value="{{old('_address_2')}}" placeholder="{{__('label._address_2')}}" >
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label._whatsup_number')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_whatsup_number" class="form-control _whatsup_number" value="{{old('_whatsup_number')}}" placeholder="{{__('label._whatsup_number')}}" >
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label._reg_no')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_reg_no" class="form-control _reg_no" value="{{old('_reg_no')}}" placeholder="{{__('label._reg_no')}}" >
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label._date_of_birth')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="date" name="_date_of_birth" class="form-control _date_of_birth" value="{{old('_date_of_birth')}}" placeholder="{{__('label._date_of_birth')}}" >
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">{{__('label.Image')}}:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                 

                                   <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_image" class="form-control">
                               <img id="output_1" class="banner_image_create" src="{{asset($settings->logo ?? '')}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>


                        @endif
                        
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