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
  <h3 class="card-title">{{insective_select_group($_incentive_group)}} {!! $page_name ?? '' !!}</h3>
  <!-- <div class="card-tools">
    <div class="input-group input-group-sm">
      <input type="text" class="form-control" placeholder="Search Mail">
    <div class="input-group-append">
      <div class="btn btn-primary">
        <i class="fas fa-search"></i>
      </div>
    </div>
    </div>
  </div>
 -->
</div>

<div class="card-body p-0">
<div class="mailbox-controls">

{!! $datas->render() !!}
     





</div>
<div class="table-responsive ">
<table class="table table-bordered table-hover table-striped">
  <thead>
    <tr>
      <th class="white_space">{{__('label.action')}}</th>
      <th class="white_space">{{__('label.sl')}}</th>
      <th class="white_space">{{__('label._insentive_year')}}</th>
      <th class="white_space">{{__('label._insentive_quater_no')}}</th>
      <th class="white_space">{{__('label._insentive_period_start')}}</th>
      <th class="white_space">{{__('label._insentive_period_end')}}</th>
      <th class="white_space">{{__('label._insentive_slap_no')}}</th>
      <th class="white_space">{{__('label._slap_min_amount')}}</th>
      <th class="white_space">{{__('label._slap_max_amount')}}</th>
      <th class="white_space">{{__('label._incentive_rate')}}</th>
      <th class="white_space">{{__('label._status')}}</th>
    </tr>
  </thead>
<tbody>
  @forelse($datas as $key=>$data)
<tr>
  
    <td style="display:flex;">
      @can('quaterly_insentive_setups-edit')
      <a  href="{{ route('quaterly_insentive_setups.edit',$data->id) }}"
        class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
        @endcan
        @can('quaterly_insentive_setups-delete')
             {!! Form::open(['method' => 'DELETE','route' => ['quaterly_insentive_setups.destroy', $data->id],'style'=>'display:inline']) !!}
                  <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
              {!! Form::close() !!}
           @endcan 
    </td>
    <td  class="white_space">{{($key+1)}}</td>
    <td  class="white_space">{!! $data->_insentive_year ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_insentive_quater_no ?? ''  !!}</td>
    <td  class="white_space">{!! _view_date_formate($data->_insentive_period_start ?? '')  !!}</td>
    <td  class="white_space">{!! _view_date_formate($data->_insentive_period_end ?? '')  !!}</td>
    <td  class="white_space">{!! $data->_insentive_slap_no ?? ''  !!}</td>
    <td  class="white_space">{!! _report_amount($data->_slap_min_amount ?? '')  !!}</td>
    <td  class="white_space">{!! _report_amount($data->_slap_max_amount ?? '')  !!}</td>
    <td  class="white_space">{!! _report_amount($data->_incentive_rate ?? '' ) !!}</td>
    <td  class="white_space">{!! selected_status($data->_status ?? '' ) !!}</td>
  
</tr>

@empty
@endforelse

</tbody>
</table>

</div>

</div>

<div class="card-footer p-0">
<div class="mailbox-controls">
{!! $datas->render() !!}
</div>
</div>
</div>

</div>

</div>
</div>
</section>



@endsection