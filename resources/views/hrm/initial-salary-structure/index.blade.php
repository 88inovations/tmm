@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('initial-salary-structure.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('initial-salary-structure-create')
                <a 
               class="btn btn-sm btn-info active " 
               
               href="{{ route('initial-salary-structure.create') }}">
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
                    <div class="col-md-4">
                      @include('hrm.initial-salary-structure.search')
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
                         <th>{{__('EMP ID')}}</th>
                         <th>{{__('label.Employee Name')}}</th>
                         <th>{{__('Gross Earnings')}}</th>
                         <th>{{__('Gross Deduction')}}</th>
                         <th>{{__('Net Earnings')}}</th>
                         <th>{{__('Created At')}}</th>
                         <th>{{__('Updated At')}}</th>
                         <th>{{__('label._status')}}</th>
                         @php
                         $default_image = $settings->logo;
                         @endphp           
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                          <td style="display: flex;">
                           
                                <a   
                                  href="{{ route('initial-salary-structure.show',$data->id) }}"
                                  
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('initial-salary-structure-edit')
                                  <a   
                                  href="{{ route('initial-salary-structure.edit',$data->id) }}"
                                  
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                
                               
                        </td>

                             
                            
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->_emp_code ?? '' }}</td>
                            <td>{{ $data->_employee->_name ?? '' }}</td>
                            <td>{{ _report_amount($data->total_earnings ?? 0) }}</td>
                            <td>{{ _report_amount($data->total_deduction ?? 0) }}</td>
                            <td>{{ _report_amount($data->net_total_earning ?? 0) }}</td>
                            
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->updated_at ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
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