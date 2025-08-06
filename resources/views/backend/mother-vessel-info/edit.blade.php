@extends('backend.layouts.app')
@section('title',$page_name ?? '')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('mother-vessel-info.index') }}"> {!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               @can('mother-vessel-info-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="{{ route('mother-vessel-info.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
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
               
                  {!! Form::model($data, ['method' => 'PATCH','route' => ['mother-vessel-info.update', $data->id]]) !!} 
                    @csrf
                    <div class="row">
                      
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._name')}}:</label>
                                {!! Form::text('_name', null, array('placeholder' => __('label._name'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._code')}}:</label>
                                {!! Form::text('_code', null, array('placeholder' => __('label._code'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._license_no')}}:</label>
                                {!! Form::text('_license_no', null, array('placeholder' => __('label._license_no'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._type')}}:</label>
                                <select class="form-control" name="_type">
                                    @forelse(_vessel_types() as $key=>$val)
                                    <option value="{{$key}}" @if($data->_type==$key) selected @endif>{{$val}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._route')}}:</label>
                                {!! Form::text('_route', null, array('placeholder' => __('label._route'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._owner_name')}}:</label>
                                {!! Form::text('_owner_name', null, array('placeholder' => __('label._owner_name'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._country_name')}}:</label>
                                {!! Form::text('_country_name', null, array('placeholder' => __('label._country_name'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._contact_one')}}:</label>
                                {!! Form::text('_contact_one', null, array('placeholder' => __('label._contact_one'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._contact_two')}}:</label>
                                {!! Form::text('_contact_two', null, array('placeholder' => __('label._contact_two'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._contact_three')}}:</label>
                                {!! Form::text('_contact_three', null, array('placeholder' => __('label._contact_three'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._capacity')}}:</label>
                                {!! Form::text('_capacity', null, array('placeholder' => __('label._capacity'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._status')}}:</label>
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