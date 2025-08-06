@extends('backend.layouts.app')
@section('title',$page_name ?? '')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name">{!! $page_name ?? '' !!} </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @can('monthly-salary-structure-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('monthly-salary-structure.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
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
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee ID:</th>
                        <th class="text-left">{!! $data->_employee->_code ?? '' !!}</th>
                        <th>Division:</th>
                        <th class="text-left">{!! $data->_employee->_organization->_name ?? '' !!}</th>
                    </tr>
                    <tr>
                        <th>Employee Name:</th>
                        <th class="text-left">{!! $data->_employee->_name ?? '' !!}</th>
                        <th>Branch:</th>
                        <th class="text-left">{!! $data->_employee->_branch->_name ?? '' !!}</th>
                    </tr>
                    <tr>
                        <th>DOJ:</th>
                        <th class="text-left">{!! $data->_employee->_doj ?? '' !!}</th>
                        <th>Section:</th>
                        <th class="text-left"></th>
                    </tr>
                    <tr>
                        <th>Designation:</th>
                        <th class="text-left">{!! $data->_employee->_emp_designation->_name ?? '' !!}</th>
                        <th>Location:</th>
                        <th class="text-left">{!! $data->_employee->_emp_location->_name ?? '' !!}</th>
                    </tr>
                    <tr>
                        <th>Grade:</th>
                        <th class="text-left">{!! $data->_employee->_emp_grade->_name ?? '' !!}</th>
                        <th>Category:</th>
                        <th class="text-left">{!! $data->_employee->_employee_cat->_name ?? '' !!}</th>
                    </tr>
                    <tr>
                        <th>Department:</th>
                        <th class="text-left">{!! $data->_employee->_emp_department->_name ?? '' !!}</th>
                        <th>Job Type:</th>
                        <th class="text-left"></th>
                    </tr>

                        
                </thead>
            </table>
            @php
    $previous_detail = $data->_details ?? [];
@endphp
            <div class="row">
                    @forelse($payheads as $p_key=>$p_val)
                    <div class="col-md-4 ">
                        <h3>{!! $p_key ?? '' !!}</h3>
                        @if(sizeof($p_val) > 0)
                            @forelse($p_val as $l_val)
                            @php
                            //dump($l_val);
                            @endphp
                            <div class="form-group row ">
                            <label class="col-sm-6 col-form-label" for="_item">{{$l_val->_ledger ?? '' }}:</label>
                             <div class="col-sm-6">
                                 @if($l_val->_payhead_type->cal_type==2)  @endif
                               @forelse($previous_detail as $p_val)
                                @if($p_val->_payhead_id==$l_val->id)
                               {{$p_val->_amount ?? 0}}
                               @endif
                              @empty
                              @endforelse
                            </div>
                        </div>
                        @empty
                        @endforelse
                        @endif
                    </div>

                        @empty
                        @endforelse
                    
                </div>
                <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Total Earnings:</label>
                         <div class="col-sm-6"><b>{{$data->total_earnings ?? 0}}</b>
                        </div>
                    </div>
                    <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Total Deduction:</label>
                         <div class="col-sm-6">
                           {{$data->total_deduction ?? 0}}
                        </div>
                    </div>
                    <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Net Total Salary:</label>
                         <div class="col-sm-6">{{$data->net_total_earning ?? 0}}</div>
                        </div>
                    </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection