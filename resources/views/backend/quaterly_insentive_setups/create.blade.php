@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

         <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('quaterly_insentive_setups.index') }}"> {!! $page_name ?? '' !!} </a>
          </div>
      </div><!-- /.container-fluid -->
    </div>
    
  
<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-3">
<a href="{{route('quaterly_insentive_setups.create')}}" class="btn btn-info btn-block mb-3"><i class="nav-icon fas fa-plus"></i> Create New</a>
<div class="card">
<div class="card-header">
<h3 class="card-title">Folders</h3>
<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse">
<i class="fas fa-minus"></i>
</button>
</div>
</div>
<div class="card-body p-0">
<ul class="nav nav-pills flex-column">
<li class="nav-item active">
<a href="{{url('quaterly_insentive_setups?_incentive_group=1')}}" class="nav-link">
<i class="fas fa-inbox"></i> {{__('label.insective_employee')}}
</a>
</li>
<li class="nav-item">
<a href="{{url('quaterly_insentive_setups?_incentive_group=2')}}" class="nav-link">
<i class="far fa-envelope"></i> {{__('label.insective_customer')}}
</a>
</li>
<li class="nav-item">
<a href="{{url('quaterly_insentive_setups?_incentive_group=3')}}" class="nav-link">
<i class="far fa-envelope"></i> {{__('label.insective_supplier')}}
</a>
</li>

</ul>
</div>

</div>



</div>

<div class="col-md-9">
<div class="card card-primary card-outline">
<div class="card-header">
<h3 class="card-title">{{$page_name ?? '' }}</h3>


</div>

<div class="message-area">
    @include('backend.message.message')
    </div>

<div class="card-body ">

{!! Form::open(array('route' => 'quaterly_insentive_setups.store','method'=>'POST')) !!}
                    
                            <div class="form-group row">
                        <label class="col-md-4">{{__('label.insective_groups')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                <select class="form-control" name="_incentive_group">
                                    @forelse(insective_groups() as $key=>$val)
                                  <option value="{{$key}}">{{$val}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        @include("backend.widgets.row_org_bud")
                       
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._insentive_year')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::text('_insentive_year', null, array('placeholder' => __('label._insentive_year'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._insentive_quater_no')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::text('_insentive_quater_no', null, array('placeholder' => __('label._insentive_quater_no'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._insentive_slap_no')}}:</label>
                         <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::text('_insentive_slap_no', null, array('placeholder' => __('label._insentive_slap_no'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._insentive_period_start')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::date('_insentive_period_start', null, array('placeholder' => __('label._insentive_period_start'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._insentive_period_end')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::date('_insentive_period_end', null, array('placeholder' => __('label._insentive_period_end'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                       
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._slap_min_amount')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::text('_slap_min_amount', null, array('placeholder' => __('label._slap_min_amount'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._slap_max_amount')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::text('_slap_max_amount', null, array('placeholder' => __('label._slap_max_amount'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-4">{{__('label._incentive_rate')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                                {!! Form::text('_incentive_rate', null, array('placeholder' => __('label._incentive_rate'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                       
                            <div class="form-group row">
                                <label class="col-md-4">Status:</label>
                       <div class="col-xs-12 col-sm-12 col-md-8">
                                <select class="form-control" name="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        
                       
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>

                   
                    {!! Form::close() !!}

</div>


</div>

</div>

</div>
</div>
</section>



@endsection