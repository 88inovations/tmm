@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

         <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('customer_sales_target_list') }}"> {!! $page_name ?? '' !!} </a>
            
          </div>
          
      </div><!-- /.container-fluid -->
    </div>
    
  <div class="message-area">
    @include('backend.message.message')
    </div>
<section class="content">
<div class="container-fluid">


<div class="col-md-12">
<div class="card card-primary card-outline">
<div class="card-header">
<h3 class="card-title">{{$page_name ?? '' }}</h3>


</div>



<div class="card-body ">
    {!! Form::model($data, ['method' => 'POST','route' => 'customer_sales_target_update']) !!}

                    <div class="row">
                        @include("backend.widgets.budget_select")
                       
                        @php
                          $currentYear = date('Y');
                          $_year = $data->_year ?? $currentYear;
                          $year_start = ($currentYear - 10);
                          $sales_commision_plans_id   = $data->sales_commision_plans_id ?? 0;
                      @endphp

                      <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_year">{{ __('label._year') }}</label>
                          <select name="_year" class="form-control" required>
                              @for ($i = $year_start; $i <= $currentYear; $i++)
                                  <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
                              @endfor
                          </select>


                          <input type="hidden" name="id" value="{{$data->id}}">
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3">
                          <label class="mr-2" for="_ledger_id">{{ __('label._ledger_id') }}</label>
                          <input type="hidden" name="_ledger_id" value="{{$data->_ledger->id ?? 0}}">
                          <input type="text" name="_ledger_name" value="{{$data->_ledger->_name ?? ''}}" class="form-control" readonly>
                          
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3">
                          <label class="mr-2" for="_code">{{ __('label._code') }}</label>
                        
                          <input type="text" name="_ledger_code" value="{{$data->_ledger->_code ?? ''}}" class="form-control" readonly>
                          
                      </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Target Sales Amount:</label>
                                <select class="form-control sales_commision_plans_id"  name="sales_commision_plans_id" >
                                          @forelse($sales_commision_plans as $plan)
                                          @php
                                            $_plan_details  = $plan->_detail ?? [];
                                          @endphp
                                          <optgroup label="{!! $plan->_name ?? '' !!}">
                                            @forelse($_plan_details as $plan_detail)
                                              <option value="{{$plan_detail->id ?? ''}}" @if($sales_commision_plans_id ==$plan_detail->id ) selected @endif  >{!! $plan->_name ?? '' !!}|{!! $plan_detail->_target_min ?? 0  !!},{!! $plan_detail->_target_max ?? 0  !!}|{!! $plan_detail->_grade ?? ''  !!}</option>
                                            @empty
                                            @endforelse
                                         @empty
                                         @endforelse
                                      </select>
                            </div>
                        </div>
                        
                     
                       
                        
                        
                       
                       <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Status:</label>
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
                    {!! Form::close() !!}

</div>


</div>

</div>

</div>
</div>
</section>



@endsection

@section('script')


@endsection