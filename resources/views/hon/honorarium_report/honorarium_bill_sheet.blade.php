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
            <a class="m-0 _page_name" href="{{route('honorarium_report')}}">{!! $page_name ?? '' !!} </a>
           
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php

$organization_id = $previous_filter["organization_id"] ?? '';
$_branch_id = $previous_filter["_branch_id"] ?? '';
$_cost_center_id = $previous_filter["_cost_center_id"] ?? '';
$_ledger_id  = $previous_filter["_ledger_id "] ?? '';



$_month = $previous_filter["_month"] ?? '';
$_year = $previous_filter["_year"] ?? '';



@endphp


    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            
              
                    <form action="{{route('honorarium_bill_sheet_report')}}" method="POST">


                    <div class="row p-2">
                     
                        @csrf

              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._month')}}:</label>
                    <select class="form-control _month" name="_month" >
                                    <option value="">{{__('label.select')}}</option>
                                    @forelse(_month_names() as $month_key=>$month)
                                    <option value="{{$month_key}}" @if($_month==$month_key) selected @endif >{{$month ?? '' }}</option>
                                    @empty
                                    @endforelse
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
                  
                        
              <div class="col-xs-12 col-sm-12 col-md-2  @if(sizeof($permited_organizations) == 1) display_none @endif ">
               <div class="form-group ">
                   <label>{!! __('label.organization') !!}:</label>
                  <select class="form-control _master_organization_id" name="organization_id" required >
              @if(sizeof($permited_organizations) > 1)
              <option value=""><---Select---></option>
              @endif
                     
                     @forelse($permited_organizations as $val )
                     <option value="{{$val->id}}"  @if($organization_id == $val->id) selected @endif >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._branch_id')}}:</label>
                  <select class="form-control _master_branch_id" name="_branch_id"  >
                    
              <option value=""><---Select {{__('label._branch_id')}}---></option>

                     @forelse($permited_branch as $branch )
                     <option value="{{$branch->id}}"  @if($_branch_id == $branch->id) selected @endif >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._cost_center_id')}}:</label>
                  <select class="form-control _master_cost_center_id" name="_cost_center_id"  >
                    
              <option value=""><---Select {{__('label._cost_center_id')}}---></option>

                     @forelse($permited_costcenters as $cost_center )
                     <option value="{{$cost_center->id}}"  @if($_cost_center_id == $cost_center->id) selected @endif >{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>

             
              

                  <div class="col-xs-12 col-sm-12 col-md-2 mt-4 flex" >
                    
                   <button type="submit" class="btn btn-primary "><i class="fa fa-search "></i> Search</button>
                   <a  href="{{url('honorarium_bill_sheet_reset')}}" class="btn btn-danger"><i class="fa fa-retweet"></i> Reset</a>
                  </div>
                  
                      </form>
                    
  
                  
             
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
<script type="text/javascript"></script>


@endsection