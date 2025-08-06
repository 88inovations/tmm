@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('customer_sales_target_list') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('customer_sales_target_create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('customer_sales_target_create') }}"> Add New </a>
               </li>
              @endcan
              
            </ol>
            <ol class="breadcrumb float-sm-right ml-2">
               
              <li class="breadcrumb-item active">
                  @include('backend.monthly_sales_targets.search')
               </li>
            
              
            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
   
<div class=" ">
<table class="table table-bordered table-hover table-striped">
  <thead>
    <tr>
      <th class="white_space">{{__('label.action')}}</th>
      <th class="white_space">{{__('label.sl')}}</th>
      <th class="white_space">{{__('label.organization_id')}}</th>
      <th class="white_space">{{__('label._branch_id')}}</th>
      <th class="white_space">{{__('label._cost_center_id')}}</th>
      <th class="white_space">{{__('label._fescal_year')}}</th>
      <th class="white_space">{{__('label._group')}}</th>
      <th class="white_space">{{__('label._year')}}</th>
      <th class="white_space">{{__('label._ledger_id')}}</th>
      <th class="white_space">{{__('label._period_start')}}</th>
      <th class="white_space">{{__('label._period_end')}}</th>
      <th class="white_space">{{__('label._target_amount')}}</th>
      <th class="white_space">{{__('label._sales_amount')}}</th>
      <th class="white_space">{{__('label._sales_return_amount')}}</th>
      <th class="white_space">{{__('label._collection_amount')}}</th>
      <th class="white_space">{{__('label._achivments')}}</th>
      <th class="white_space">{{__('label._status')}}</th>
    </tr>
  </thead>
  
<tbody>
  @forelse($datas as $key=>$data)
<tr>
  
    <td style="display:flex;">
      @can('customer_sales_target_show')
      <a  href="{{ url('customer_sales_target_show') }}/{{$data->id}}"
        class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye "></i></a>
        @endcan
      @can('customer_sales_target_edit')
      <a  href="{{ url('customer_sales_target_edit') }}/{{$data->id}}"
        class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
        @endcan
        @can('monthly_sales_targets-delete')
             {!! Form::open(['method' => 'DELETE','route' => ['monthly_sales_targets.destroy', $data->id],'style'=>'display:inline']) !!}
                  <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
              {!! Form::close() !!}
           @endcan 
    </td>
    <td  class="white_space">{{($key+1)}}</td>
    <td  class="white_space">{!! $data->_organization->_name ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_master_branch->_name ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_master_cost_center->_name ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_fescal_year ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_group ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_year ?? ''  !!}</td>
    <td  class="white_space">{!! $data->_ledger->_name ?? ''  !!}</td>
    <td  class="white_space">{!! _view_date_formate($data->_period_start ?? '')  !!}</td>
    <td  class="white_space">{!! _view_date_formate($data->_period_end ?? '')  !!}</td>
    <td  class="white_space">{!! _report_amount($data->_target_amount ?? 0)  !!}</td>
    <td  class="white_space">{!! _report_amount($data->_sales_amount ?? 0)  !!}</td>
    <td  class="white_space">{!! _report_amount($data->_sales_return_amount ?? 0 ) !!}</td>
    <td  class="white_space">{!! _report_amount($data->_collection_amount ?? 0 ) !!}</td>
    <td  class="white_space"></td>
    <td  class="white_space">{!! selected_status($data->_status ?? '' ) !!}</td>
  
</tr>











@empty
@endforelse

</tbody>
<tfoot>
  <tr>
    <td colspan="17">{!! $datas->render() !!}</td>
  </tr>
</tfoot>
</table>

</div>
 </div>
 






@endsection