@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('ta_da_setups.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('ta_da_setups-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('ta_da_setups.create') }}"> Add New </a>
               </li>
              @endcan
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                  <div class="row">
                   @php
                   @endphp
                    <div class="col-md-4">
                      @include('backend.ta_da_setups.search')
                    </div>
                    <div class="col-md-8">
                      
                    </div>
                  </div>
              </div>
              
              <div class="card-body">
                <div class="table-responsive">
                  
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         
                         <th class=""><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label.organization_id')}}</b></th>
                         <th class=""><b>{{__('label._fescal_year')}}</b></th>
                         <th class=""><b>{{__('label._sloat_min')}}</b></th>
                         <th class=""><b>{{__('label._sloat_max')}}</b></th>
                         <th class=""><b>{{__('label._type')}}</b></th>
                         <th class=""><b>{{__('label._ta_rate')}}</b></th>
                         <th class=""><b>{{__('label._fixed_amount')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label._created_by')}}</b></th>
                         <th class=""><b>{{__('label._updated_by')}}</b></th>
                         <th class=""><b>{{__('label.created_at')}}</b></th>
                         <th class=""><b>{{__('label.updated_at')}}</b></th>
                      

                      </tr>
                      </thead>
                      <tbody>
                    
                        @forelse ($datas as $key => $data)
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    
                                     
                                     @can('ta_da_setups-edit')
                                        <a class="dropdown-item " href="{{ route('ta_da_setups.edit',$data->id) }}" >
                                          Edit
                                        </a>
                                    @endcan
                                    
                                  </div>
                                </div>
                                
                                
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_fescal_year ?? '' }}</td>
                            <td>{{ _report_amount($data->_sloat_min ?? 0) }}</td>
                            <td>{{ _report_amount($data->_sloat_max ?? 0) }}</td>
                            <td>{{ $data->_type ?? '' }}</td>
                            <td>{{ _report_amount($data->_ta_rate ?? 0) }}</td>
                            <td>{{ _report_amount($data->_fixed_amount ?? 0) }}</td>
                            <td>{{ selected_status($data->_status ?? 0)  }}</td>
                            <td>{{ $data->_created_by ?? '' }}</td>
                            <td>{{ $data->_updated_by ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->updated_at ?? '' }}</td>
                           
                            
                        </tr>
                        @empty
                        @endforelse
                        
                       
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->
                
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

@section('script')

<script type="text/javascript">



</script>
@endsection