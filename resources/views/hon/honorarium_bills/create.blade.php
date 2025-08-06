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
            <a class="m-0 _page_name" href="{{route('honorarium_bills.index')}}">{!! $page_name ?? '' !!} </a>
           
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php

$organization_id = $request->organization_id ?? '';
$_branch_id = $request->_branch_id ?? '';
$_cost_center_id = $request->_cost_center_id ?? '';



$_month = $request->_month ?? '';
$_year = $request->_year ?? '';
$_note = $request->_note ?? '';
$_date = date('Y-m-d');


@endphp


    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            
              
                    <form action="" method="GET">


                    <div class="row p-2">
                     
                        @csrf

              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._month')}}:</label>
                    <select class="form-control _month" name="_month" required>
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

              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._honorarium_ledger')}}:</label>
                    <input type="text" class="form-control" name="_honorarium_ledger" value="{{_ledger_name($settings->_honorarium_ledger ?? 0)}}" readonly>
               </div>
              </div>
              

                  <div class="col-xs-12 col-sm-12 col-md-2 mt-3">
                    
                   <button type="submit" class="btn btn-primary"><i class="fa fa-search "></i> Find Ledger</button>
                  </div>
                  
                      </form>
                    
  
                  
             
              </div>
    @if(sizeof($datas) > 0)
              <div class="card-body">
                <div class="">
                  {!! Form::open(array('route' => 'honorarium_bills.store','method'=>'POST')) !!}
                  <div class="row p-2">
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                       <div class="form-group ">
                           <label>{{__('label._date')}}:</label>
                            <input type="date" class="form-control _date" name="_date" value="{{ $_date ?? ''}}" >
                            <input type="hidden" class="form-control _month" name="_month" value="{{ $_month ?? ''}}" >
                            <input type="hidden" class="form-control _year" name="_year" value="{{ $_year ?? ''}}" >
                            <input type="hidden" class="form-control _year" name="honorarium_payments_id" value="{{ $honorarium_payments->id ?? ''}}" >
                       </div>
                      </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 ">
                       <div class="form-group ">
                           <label>{{__('label._note')}}:</label>
                            <input type="text" class="form-control _note" name="_note" value="{{ $_note ?? ''}}" >
                       </div>
                      </div>
                  </div>

                 <div class="table-responsive">
                  <table class="table table-bordered ">
                      <thead>
                        <tr>
                         
                         <th style="width: 5%;"><b>{{__('label.sl')}}</b></th>
                          @if(sizeof($permited_organizations) > 1)
                         <th style="width: 10%;"><b>{{__('label.organization')}}</b></th>
                         @endif
                          @if(sizeof($permited_branch) > 1)
                         <th style="width: 10%;"><b>{{__('label._branch_id')}}</b></th>
                         @endif
                          @if(sizeof($permited_costcenters) > 1)
                         <th style="width: 10%;"><b>{{__('label._cost_center_id')}}</b></th>
                         @endif
                         <th style="width: 5%;"><b>{{__('label.id')}}</b></th>
                         <th style="width: 7%;white-space: nowrap;"><b>{{__('label._code')}}</b></th>
                         <th style="width: 20%;"><b>{{__('label._ledger_id')}}</b></th>
                         <th style="width: 10%;"><b>{{__('label._amount')}}</b></th>
                         <th style="width: 5%;"><b>{{__('label._status')}}</b></th>


                      </tr>
                      </thead>
                      <tbody>
                      
                      @forelse($datas as  $d_key=>$data)

                      @php
$_status = $data->_honorarium_info->_status ?? 1; 
                      @endphp
                      <tr class="@if($_status==0) _required @endif">
                        <td>{!! ($d_key+1) !!}</td>
                         @if(sizeof($permited_organizations) > 1)
                        <td>{!! $data->_organization->_name ?? '' !!}</td>
                        @endif
                         @if(sizeof($permited_branch) > 1)
                        <td>{!! $data->_branch->_name ?? '' !!}</td>
                        @endif
                         @if(sizeof($permited_costcenters) > 1)
                        <td>{!! $data->_cost_center->_name ?? '' !!}</td>
                        @endif
                        <td>{!! $data->id ?? '' !!}</td>
                        <td>{!! $data->_code ?? '' !!}</td>
                        <td>{!! $data->_name ?? '' !!}</td>
                        <td>
                          
                          <input type="hidden" name="_ledger_id[]" value="{{$data->id ?? 0}}">
                          <input type="hidden" name="organization_id[]" value="{{$data->organization_id ?? 0}}">
                          <input type="hidden" name="_cost_center_id[]" value="{{$data->_cost_center_id ?? 0}}">
                          <input type="hidden" name="_branch_id[]" value="{{$data->_branch_id ?? 0}}">
                          <input type="hidden" name="_setup_id[]" value="{{$data->_honorarium_info->id ?? 0}}">
                          <input class="form-control" type="number" step="any" min="0" name="_amount[]" value="{{$data->_honorarium_info->_amount ?? 0 }}">
                        </td>
                        <td>
                          <select class="form-control" name="_status[]">
                            <option value="1" @if($_status==1) selected @endif>Active</option>
                            <option value="0" @if($_status==0) selected @endif>In Active</option>
                          </select>
                        </td>
                      </tr>

                      @empty
                      @endforelse

                       

                        
                        
                       
                        </tbody>
                        <tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2"></td>
                            <td colspan="2">
                              <div class="col-xs-12 col-sm-12 col-md-12  m-4">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
                        </div>
                            </td>
                            <td colspan="4"></td>
                          </tr>
                          </tfoot>
                        </tbody>

                    </table>
                    </div>

                   {!! Form::close() !!}
                </div>
                <!-- /.d-flex -->
                
              </div>

@endif


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