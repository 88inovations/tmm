@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('attandance.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('hrm-attandance-create')
                <a 
               class="btn btn-sm btn-info active " 
               
               href="{{ route('attandance.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
              
              @endcan
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 

                  <div class="row">
                   @php

 $currentURL = URL::full();
 $current = URL::current();
if($currentURL === $current){
   $print_url = $current."?print=single";
   $print_url_detal = $current."?print=detail";
}else{
     $print_url = $currentURL."&print=single";
     $print_url_detal = $currentURL."&print=detail";
}
    

                   @endphp
                   @php
$users = \Auth::user();
$permited_branch = permited_branch(explode(',',$users->branch_ids));
$permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
$permited_organizations = permited_organization(explode(',',$users->organization_ids));
@endphp 
                    <div class="col-md-4">
                      
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                           
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                         <th>{{__('Action')}}</th>
                         <th>{{__('SL')}}</th>
                         @if(sizeof($permited_organizations) > 1)
                         <th>{{__('label.organization_id')}}</th>
                         @endif
                         @if(sizeof($permited_branch) > 1)
                         <th>{{__('label._branch_id')}}</th>
                         @endif
                         @if(sizeof($permited_costcenters) > 1)
                         <th>{{__('label._cost_center_id')}}</th>
                         @endif
                         <th>{{__('EMP ID')}}</th>
                         <th>{{__('Employee Name')}}</th>
                         <th>{{__('label._date')}}</th>
                         <th>{{__('label.in_time')}}</th>
                         <th>{{__('label.out_time')}}</th>
                         <th>{{__('label.remarks')}}</th>
                         
                         @php
                         $default_image = $settings->logo;
                         @endphp           
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                          <td style="display: flex;">
                           


                                  @can('hrm-attandance-edit')
                                  <a   
                                  href="{{ route('attandance.edit',$data->id) }}"
                                  
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                
                               
                        </td>

                             


                            
                            <td>{{ ($key+1) }}</td>
                            @if(sizeof($permited_organizations) > 1)
                         <td>{{ $data->_organization->_name ?? '' }}</td>
                         @endif
                         @if(sizeof($permited_branch) > 1)
                         <td>{{ $data->_branch->_name ?? '' }}</td>
                         @endif
                         @if(sizeof($permited_costcenters) > 1)
                         <td>{{ $data->_cost_center->_name ?? '' }}</td>
                         @endif
                            
                           
                            <td>{{ $data->_employee_info->_code ?? '' }}</td>
                            <td>{{ $data->_employee_info->_name ?? '' }}</td>
                            
                            
                            <td>{{ $data->_datetime ?? '' }}</td>
                            <td>{{ $data->in_time ?? '' }}</td>
                            <td>{{ $data->out_time ?? '' }}</td>
                            <td>{{ $data->remarks ?? '' }}</td>
                           
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>
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


@section("script")


@endsection