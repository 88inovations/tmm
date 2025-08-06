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
           <ol class="breadcrumb float-sm-right ml-2">
               @can('honorarium_bills_create')
              <li class="breadcrumb-item active">
                <a  
               class="btn btn-sm btn-info active " 
               href="{{ route('honorarium_bills.create') }}">
                <i class="nav-icon fas fa-plus"></i> Create New
               </a>
                  
               </li>
              @endcan
            </ol>
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
                    
                   <button type="submit" class="btn btn-primary"><i class="fa fa-search "></i> Search</button>
                  </div>
                  
                      </form>
                    
  
                  
             
              </div>
    @if(sizeof($datas) > 0)
             <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                         <th>{{__('Action')}}</th>
                         <th>{{__('SL')}}</th>
                         <th>{{__('label.voucher_id')}}</th>
                         <th>{{__('label.voucher_code')}}</th>
                         <th>{{__('label._month')}}</th>
                         <th>{{__('label._year')}}</th>
                         <th>{{__('label.organization_id')}}</th>
                         <th>{{__('label._branch_id')}}</th>
                         <th>{{__('label._cost_center_id')}}</th>
                         <th>{{__('label._amount')}}</th>
                         <th>{{__('label._note')}}</th>
                         <th>{{__('label._user_name')}}</th>
                         <th>{{__('label._is_posting')}}</th>
                         <th>{{__('label._lock')}}</th>
                         <th>{{__('label._status')}}</th>
                         <th>{{__('Created At')}}</th>
                         <th>{{__('Updated At')}}</th>
                         @php
                         $default_image = $settings->logo;
                         @endphp           
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                          <td >
                           <a href="{{ route('honorarium_bills.show',$data->id) }}"
                                 class="btn btn-sm btn-warning" >Print</a>
                        </td>

                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->voucher_id ?? '' }}</td>
                            <td>{{ $data->voucher_code ?? '' }}</td>
                            <td>{{ _number_to_month($data->_month) ?? '' }}</td>
                            <td>{{ $data->_year ?? '' }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_branch->_name ?? '' }}</td>
                            <td>{{ $data->_cost_center->_name ?? '' }}</td>
                            <td>{{ _report_amount($data->_amount ?? 0) }}</td>
                            
                            <td>{!! $data->_note ?? '' !!}</td>
                            <td>{!! $data->_user_name ?? '' !!}</td>
                            <td>{!! $data->_is_posting ?? '' !!}</td>
                           <td style="display: flex;">
                              @can('lock-permission')
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="{{$data->id}}" value="{{$data->_lock}}" @if($data->_lock==1) checked @endif>
                              @endcan

                              @if($data->_lock==1)
                              <i class="fa fa-lock _green ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @else
                              <i class="fa fa-lock _required ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @endif

                            </td>
                           <td>{{ selected_status($data->_status) }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->updated_at ?? '' }}</td>
                           
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
<script type="text/javascript">
    $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="honorarium_bills";
      if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })
</script>


@endsection