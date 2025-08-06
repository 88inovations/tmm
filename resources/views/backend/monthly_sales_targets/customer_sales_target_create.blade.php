@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

<div class="content">
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
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="container-fluid">

<div class="card-body ">

{!! Form::open(array('route' => 'customer_sales_target_create','method'=>'GET')) !!}
                    <div class="row">
                       
              <div class="col-xs-12 col-sm-12 col-md-2 ">
              <div class="form-group ">
              <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
              <select class="form-control _master_organization_id" name="organization_id" required >
                @if(sizeof($permited_organizations)>1) 
                            <option value="">--{{__('label.select')}}--</option>
                            @endif
               @forelse($permited_organizations as $val )
               <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
               @empty
               @endforelse
              </select>
              </div>
              </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group ">
                                <label>{{__('label.Branch')}}:<span class="_required">*</span></label>
                               <select class="form-control _master_branch_id" name="_branch_id" required >
                                  @if(sizeof($permited_branch) > 1) 
                           <option value="">--{{__('label.select')}}--</option>
                            @endif
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2  ">
                            <div class="form-group ">
                                <label>{{__('label.Cost center')}}:<span class="_required">*</span></label>
                               <select class="form-control _master_cost_center_id" name="_cost_center_id" required >
                                @if(sizeof($permited_costcenters)>1) 
                              <option value="">--{{__('label.select')}}--</option>
                           @endif
                                   @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                            </div>
                        </div>

<div class="col-xs-12 col-sm-12 col-md-2  ">
   <div class="form-group ">
       <label>{{__('label._budget_id')}}:</label>
      <select class="form-control _master_budget_id" name="_budget_id"  >
           @if(sizeof($permited_budgets)>1) 
             <option value="">{{__('label.select')}}</option>
           @endif
          @forelse($permited_budgets as $b_val )
                         <option value="{{$b_val->id}}" @if(isset($request->_budget_id)) @if($request->_budget_id == $b_val->id) selected @endif   @endif> {{ $b_val->_name ?? '' }}</option>
           @empty
           @endforelse
       </select>
   </div>
</div>
                       <div class="col-xs-12 col-sm-12 col-md-2 display_none">
                            <div class="form-group">
                                <label>{{__('label._group')}}:</label>
                                <select class="form-control" name="_group">
                                  <option value="2">Customer</option>
                                 
                                </select>
                            </div>
                        </div>

                     @php
                          $currentYear = date('Y');
                          $_year = $request->_year ?? $currentYear;
                          $year_start = ($currentYear - 10);
                      @endphp

                      <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_year">{{ __('label._year') }}</label>
                          <select name="_year" class="form-control" required>
                              @for ($i = $year_start; $i <= $currentYear; $i++)
                                  <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
                              @endfor
                          </select>
                      </div>

                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-info  ml-5"><i class="fa fa-search mr-2" aria-hidden="true"></i> Search</button>
                           
                        </div>
                        <br><br>

                    {!! Form::close() !!}
                    </div><!--  -->
@if(sizeof($customers) > 0)
<div class="card">
  <div class="card-header">
   @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
  </div>
  <div class="card-body">
    <form class="form-horizontal" action="{{route('customer_sales_target_store')}}" method="POST">
      @csrf
      <input type="hidden" name="organization_id" value="{{$request->organization_id ?? 0}}">
      <input type="hidden" name="_branch_id" value="{{$request->_branch_id ?? 0}}">
      <input type="hidden" name="_cost_center_id" value="{{$request->_cost_center_id ?? 0}}">
      <input type="hidden" name="_budget_id" value="{{$request->_budget_id ?? 0}}">
      <input type="hidden" name="_fescal_year" value="{{$request->_year ?? 0}}">
     <div class="col-md-12">
       <table class="table table-bordered">
         <thead>
           <tr>
             <th>SL</th>
             <th>Code</th>
             <th>Ledger</th>
             <th>Target Sales Amount</th>
           </tr>
         </thead>
         <tbody>
          @forelse($customers as $key=>$customer)
           <tr>
             <td>{{($key+1)}}</td>
             <td>
              <input type="hidden" name="_ledger_id[]" value="{{$customer->id}}">
              {!! $customer->_code ?? '' !!}</td>
             <td>{!! $customer->_name ?? '' !!}</td>
             <td>

              <select class="form-control sales_commision_plans_id"  name="sales_commision_plans_id[]" >
                  @forelse($sales_commision_plans as $plan)
                  @php
                    $_plan_details  = $plan->_detail ?? [];
                  @endphp
                  <optgroup label="{!! $plan->_name ?? '' !!}">
                    @forelse($_plan_details as $plan_detail)
                      <option value="{{$plan_detail->id ?? ''}}">{!! $plan->_name ?? '' !!}|{!! $plan_detail->_target_min ?? 0  !!},{!! $plan_detail->_target_max ?? 0  !!}|{!! $plan_detail->_grade ?? ''  !!}</option>
                    @empty
                    @endforelse
                 @empty
                 @endforelse
              </select>

             </td>
             
           </tr>
           @empty
           @endforelse
         </tbody>
       </table>
     </div>
     <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
           <button type="submit" class="btn btn-info  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
      </div>


    </form>
  </div>
  <div class="card-footer"></div>
</div>
@endif
</div>
</div>








@endsection