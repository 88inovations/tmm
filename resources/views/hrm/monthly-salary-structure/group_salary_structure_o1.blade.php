@extends('backend.layouts.app')
@section('title',$page_name ?? '')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('monthly-salary-structure.index') }}">{!! $page_name ?? '' !!} </a>
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
<div class="card ">
<div class="card-body">
    @include('backend.message.message')
    <form action="" method="GET" >
        @csrf
      <div class="form-group row">
                             <label class="col-md-2">{!! __('label.organization') !!}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_organization_id" name="organization_id"  >
                                @if(sizeof($permited_organizations) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               
                               @forelse($permited_organizations as $val )
                               <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{{__('label.Branch')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_branch_id" name="_branch_id"  >
                               @if(sizeof($permited_branch) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_branch as $branch )
                               <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{{__('label.Cost center')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <select class="form-control _cost_center_id" name="_cost_center_id"  >
                               @if(sizeof($permited_costcenters) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label.employee_category_id') !!}:</label>
                            <div class="col-md-5">
                                <select class="form-control" name="_category_id" >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($employee_catogories as $val)
                                  <option value="{{$val->id}}" @if(isset($request->_category_id)) @if($request->_category_id == $val->id) selected @endif   @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._department_id') !!}:</label>
                        <div class="col-md-5">
                                <select class="form-control " name="_department_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($departments as $val)
                                  <option value="{{$val->id}}" @if(isset($request->_department_id)) @if($request->_department_id == $val->id) selected @endif   @endif>{!! $val->_department ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._jobtitle_id') !!}:</label>
                        <div class="col-md-5">
                                <select class="form-control " name="_jobtitle_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($designations as $val)
                                  <option value="{{$val->id}}"  @if(isset($request->_jobtitle_id)) @if($request->_jobtitle_id == $val->id) selected @endif   @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._grade_id') !!}:</label>
                        <div class="col-md-5">
                                <select class="form-control " name="_grade_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($grades as $val)
                                  <option value="{{$val->id}}" @if(isset($request->_grade_id)) @if($request->_grade_id == $val->id) selected @endif   @endif>{!! $val->_grade ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2">{!!__('label._location') !!}:</label>
                        <div class="col-md-5">
                                <select class="form-control " name="_location"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_locations as $val)
                                  <option value="{{$val->id}}" @if(isset($request->_location)) @if($request->_location == $val->id) selected @endif   @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2">{!!__('label._zone_id') !!}:</label>
                        <div class="col-md-5">
                                <select class="form-control " name="_zone_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_zones as $val)
                                  <option value="{{$val->id}}"  @if(isset($request->_zone_id)) @if($request->_zone_id == $val->id) selected @endif   @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2"></label>
                        <div class="col-md-5">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search mr-2"></i>Search</button>
                            </div>
                        </div>
              </form>
</div><!-- End of Card body -->
</div><!-- End of Card -->

<div class="card">
    <div class="card-body">
         <form action="{{url('group_salary_structure_save')}}" method="POST">
             @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="selected_all_employee" class="form-control selected_all_employee">
                    </th>
                        <th>{{__('label._payment_type')}}</th>
                        <th>
                            <select class="form-control _payment_type" name="_payment_type" required>
                                    <option value="1">Salary</option>
                                   
                                </select>
                        </th>
                        <th>{{__('label._month')}}</th>
                        <th>
                            <select class="form-control _month" name="_month" required>
                                <option value="">{{__('label.select')}}</option>
                                @forelse(_month_names() as $month_key=>$month)
                                <option value="{{$month_key}}">{{$month ?? '' }}</option>
                                @empty
                                @endforelse
                            </select>
                        </th>
                        <th>{{__('label._year')}}</th>
                        <th>
                            <select name="_year" class="form-control" required>
                                <?php
                                // Get the current year
                                $currentYear = date('Y');
                                // Display the last two years
                                for ($i = 2; $i > 0; $i--) {
                                    $year = $currentYear - $i;
                                    echo "<option value='$year'>$year</option>";
                                }
                                echo "<option value='$currentYear' selected>$currentYear</option>";
                                $nextYear = $currentYear + 1;
                                echo "<option value='$nextYear'>$nextYear</option>";
                                ?>
                            </select>
                        </th>
                        <th>
                            {{__('label._budget_id')}}
                        </th>
                        <th>
                            <select class="form-control _master_budget_id" name="_budget_id"  >
                           @if(sizeof($permited_budgets)>1) 
                             <option value="">{{__('label.select')}}</option>
                           @endif
                          @forelse($permited_budgets as $b_val )
                                <option value="{{$b_val->id}}" @if(isset($data->_budget_id)) @if($data->_budget_id == $b_val->id) selected @endif   @endif> {{ $b_val->_name ?? '' }}</option>
                           @empty
                           @endforelse
                       </select>
                        </th>
                        
                    </tr>

                
            </thead>
            <tbody>
                </tbody>

        </table>
               
                    
                   <div class="row">
                @forelse($employees as $key=>$val)

                <div class="col-md-4">
                    <div class=" border1px">
                        <div class="card-header">
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                        <input type="checkbox" name="selected_employee[]" class="form-control selected_employee">
                        <input type="hidden" name="selected_employee_check[]" class="form-control selected_employee_check" value="0">

                        <input type="hidden" name="id[]" class="employee_id" value="{{$val->id}}">
                        <input type="hidden" name="_code[]" class="_employee_id" value="{{$val->_code}}">
                        <input type="hidden" name="_employee_id[]" class="_employee_id" value="{{$val->id}}">
                        <input type="hidden" name="_employee_ledger_id[]" class="_employee_ledger_id" value="{{$val->_ledger_id}}">
                        <input type="hidden" name="_jobtitle_id[]" class="_jobtitle_id" value="{{$val->_jobtitle_id}}">
                        <input type="hidden" name="_department_id[]" class="_department_id" value="{{$val->_department_id}}">
                        <input type="hidden" name="_category_id[]" class="_category_id" value="{{$val->_category_id}}">
                        <input type="hidden" name="_grade_id[]" class="_grade_id" value="{{$val->_grade_id}}">
                        <input type="hidden" name="organization_id[]" class="organization_id" value="{{$val->organization_id}}">
                        <input type="hidden" name="_branch_id[]" class="_branch_id" value="{{$val->_branch_id}}">
                        <input type="hidden" name="_cost_center_id[]" class="_cost_center_id" value="{{$val->_cost_center_id}}">
                        <input type="hidden" name="total_earnings[]" class="total_earnings" value="{{$val->_basic_salary_master->total_earnings ?? '' }}">
                        <input type="hidden" name="total_deduction[]" class="total_deduction" value="{{$val->_basic_salary_master->total_deduction ?? '' }}">
                        <input type="hidden" name="net_total_earning[]" class="net_total_earning" value="{{$val->_basic_salary_master->net_total_earning ?? '' }}">



                    </td>
                    <td>
                        <h5>ID:{{$val->id}}</h5>
                        
                    </td>
                                </tr>
                                <tr>
                                    <th>{{__('label._code')}}</th>
                                    <td>{{$val->_code ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>{{__('label._name')}}</th>
                                    <td>{{$val->_name ?? '' }}</td>
                                </tr>
                               
                       
                                <tr>
                                    <th>{{__('label.organization')}}</th>
                                    <td>{{$val->_organization->_name ?? '' }}</td>
                                </tr>

                                <tr>
                                <th>{{__('label._cost_center_id')}}</th>
                                <td>{{$val->_cost_center->_name ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label.employee_category_id')}}</th>
                                <td>{{$val->_employee_cat->_name ?? '' }}</td>
                                </tr>
                                <tr>
                                <th>{{__('label._department_id')}}</th>
                                <td>{{$val->_emp_department->_name ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label._jobtitle_id')}}</th>
                                <td>{{$val->_emp_designation->_name ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label._grade_id')}}</th>
                                 <td>{{$val->_emp_grade->_name ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label._location')}}</th>
                                <td>{{$val->_emp_location->_name ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label.total_earnings')}}</th>
                                 <td>{{$val->_basic_salary_master->total_earnings ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label.total_deduction')}}</th>
                                <td>{{$val->_basic_salary_master->total_deduction ?? '' }}</td>
                                </tr>
                                <tr>

                                <th>{{__('label.net_total_earning')}}</th>
                                <td>{{$val->_basic_salary_master->net_total_earning ?? '' }}</td>
                                </tr>
                                <tr>


                    
                    
                    
                   
                    
                   
                    
                    
                            </table>
                        </div>
                    </div>
                </div>

                
                @empty
                @endforelse
                </div>

              
                        <button type="submit" class="btn btn-success submit-button ml-5" >Save</button>
                   

                
            
        </form>
    </div>
</div>








</div><!-- End of Container -->
</div><!-- End of Content -->



@endsection
@section('script')

<script type="text/javascript">
    $(document).on('click','.selected_all_employee',function(){
        if ($(this).is(':checked')) {
                $(document).find(".selected_employee_check").val(1);
                $(document).find(".selected_employee").attr('checked',true);
            } else {
               $(document).find(".selected_employee").attr('checked',false);
               $(document).find(".selected_employee_check").val(0);
            }
    })


    $(document).on('click','.selected_employee',function(){
        if ($(this).is(':checked')) {
                $(this).closest('td').find(".selected_employee_check").val(1);
            } else {
                $(this).closest('td').find(".selected_employee_check").val(0);
            }
    })
</script>
@endsection
