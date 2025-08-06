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
            <a class="m-0 _page_name" href="{{ route('stm_collection.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('stm_collection_create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('stm_collection.create') }}">
                   <i class="nav-icon fas fa-plus"></i> {{__('label.create_new')}}
                </a>

               </li>
              @endcan

              
                 <div class="col-md-3">

            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

     
 @php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_student_id =  $request->_student_id ?? '';
$_order_number =  $request->_order_number ?? '';
$_month =  $request->_month ?? '';
$_year =  $request->_year ?? '';
$asc_cloumn =  $request->asc_cloumn ?? '';
$_asc_desc =  $request->_asc_desc ?? '';
$_bill_type =  $request->_bill_type ?? '';







@endphp


     @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 <div class="row">


                  <form class="" action="{{route('stm_collection.index')}}" method="GET">
            @csrf
                
                      <div>
                           
                         <div class="row">
                          
                            
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:</label>
                                    <select class="form-control stduent_seach _admission_session_id _search_admission_session_id" name="_admission_session_id"  attr_url="{{route('session_class_div_wise_student')}}">
                                      <option value="">Select Session</option>
                                      @forelse($stm_education_sessions as $session)
                                        <option value="{{$session->id }}"
                                         @if($_admission_session_id ==$session->id) selected @endif > {!! $session->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                                <input type="hidden" name="search" value="search">
                            </div>
                        
                   
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._education_type')}}:</label>
                                    <select class="form-control stduent_seach _education_type _search_education_type" name="_education_type"  attr_url="{{route('session_class_div_wise_student')}}">
                                      <option value="">Select {{__('label._education_type')}}</option>
                                      @forelse($edu_types as $type)
                                        <option value="{{$type->id }}"
                                         @if($_education_type ==$type->id) selected @endif > {!! $type->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_class_id')}}:</label>
                                    <select class="form-control stduent_seach _admission_class_id _search_admission_class_id" name="_admission_class_id"  attr_url="{{route('session_class_div_wise_student')}}">
                                      <option value="">Select Class</option>
                                      @forelse($edu_class as $class)
                                        <option value="{{$class->id }}"
                                         @if($_admission_class_id ==$class->id) selected @endif > {!! $class->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._student_id')}}:</label>
                                    <div class="_search_stduent_list">
                                        
                                         <select class="_student_id form-control  select2" name="_student_id">
                                                <option value="">Select Student</option>
                                                @forelse($students_lists as $student)
                                                 <option value="{{$student->id}}" @if($_student_id==$student->id) selected @endif >{!! $student->_name_in_english ?? '' !!}  | {!! $student->_student_id ?? '' !!} | {!! $student->_father_name_english ?? '' !!}</option>

                                                @empty
                                                @endforelse
                                            </select>
                                    </div>
                                   
                                </div>
                            </div>
                            @php                     
                        $bill_types =_fees_types();
                        @endphp
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_bill_type">{{ __('label._bill_type') }}</label>
                          <select name="_bill_type" class="form-control _bill_type" >
                            <option value="">Select {{ __('label._bill_type') }}</option>
                              @forelse($bill_types as $bill_key=>$lebel)
                                  <option value="{{ $bill_key }}" @if($_bill_type ==$bill_key) selected @endif >{{ $lebel }}</option>
                              @empty
                              @endforelse
                          </select>
                        </div>

                        <div class="col-md-2">
                                 <label class="mr-2" for="_month">{{ __('label._month') }}</label>
                                <select class="form-control _month" name="_month" >
                                    <option value="">{{__('label.select')}} {{ __('label._month') }}</option>
                                    @forelse(_month_names() as $month_key=>$month)
                                    <option value="{{$month_key}}" @if($month_key==$_month) selected @endif >{{$month ?? '' }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                              @php
                                  $currentYear = date('Y');
                                  $_year = $request->_year ?? '';
                                  $year_start = ($currentYear - 10);
                              @endphp

                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <label class="mr-2" for="_year">{{ __('label._year') }}</label>
                                  <select name="_year" class="form-control" >
                                    <option value="">{{__('label.select')}} {{ __('label._year') }}</option>
                                      @for ($i = $year_start; $i <= $currentYear; $i++)
                                          <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
                                      @endfor
                                  </select>
                              </div>
                             
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_order_number">{{ __('label._order_number') }}</label>
                         <input type="text" name="_order_number" class="form-control _order_number" value="{{$_order_number}}">
                        </div>

                        @php 
                    $row_numbers = filter_page_numbers();
                         
                  @endphp


                        @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date',];

                      @endphp
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_order_number">Order By</label>
                         <select class="form-control" name="asc_cloumn" >
                            
                            @foreach($cloumns AS $key=>$val)
                            <option value="{{$key}}"  @if($key==$asc_cloumn) selected @endif  >{{$val}}</option>
                        @endforeach
                        </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="_asc_desc">Sort Order</label>
                             <select class=" form-control" name="_asc_desc">
                            @foreach(asc_desc() AS $key=>$val)
                                <option value="{{$val}}"  @if($val==$_asc_desc) selected @endif  >{{$val}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="limit">Limit</label>
                            <select name="limit" class="form-control" >
                              @forelse($row_numbers as $row)
                               <option  @if($limit == $row) selected @endif   value="{{ $row }}">{{$row}}</option>
                              @empty
                              @endforelse
                      </select>
                        </div>

                            <div class="col-xs-12 col-sm-12 col-md-3 mt-3 flex">
                                   <button type="submit" class="btn btn-primary mt-1 mr-2"><i class="fa fa-search "></i> Search</button>
                                   <a  href="{{route('stm_collection.index')}}" class="btn btn-danger mt-1"><i class="fa fa-retweet"></i> Reset</a>
                                  </div>
                        </div>
                            
                          </div>
                    </form>


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
                    
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b>SL</b></th>
                         <th class=""><b>ID</b></th>
                         <th class=""><b>{{__('label._date')}}</b></th>
                         <th class=""><b>{{__('label._order_number')}}</b></th>
                         <th class=""><b>{{__('label._bill_type')}}</b></th>
                         <th class=""><b>{{__('label._month_id')}}</b></th>
                         <th class=""><b>{{__('label._year')}}</b></th>
                         <th class=""><b>{{__('label._name_in_bangla')}}</b></th>
                         <th class=""><b>{{__('label._name_in_english')}}</b></th>
                         <th class=""><b>{{__('label._roll_no')}}</b></th>
                         <th class=""><b>{{__('label._total_amount')}}</b></th>
                         <th class=""><b>{{__('label._discount_amount')}}</b></th>
                         <th class=""><b>{{__('label._net_amount')}}</b></th>
                         <th class=""><b>{{__('label._note')}}</b></th>
                         <th class=""><b>{{__('label._user_name')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label._lock')}}</b></th>
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
                              
                              <a  type="button" 
                                  href="{{ route('stm_collection.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-2">Money Receipt</a>

                             @can('stm_collection_edit')
                                  <a  
                                  href="{{ route('stm_collection.edit',$data->id) }}"
                                 
                                  class="btn btn-sm btn-default  mr-2"><i class="fa fa-pen "></i></a>
                              @endcan 
                             @can('stm_collection_delete')
                                 <form action="{{ route('stm_collection.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="mr-2 btn btn-danger btn-sm" type="submit" onclick="return confirm('Do You Want to Delete!')" > <i class="fa fa-trash "></i> </button>
                                    </form>
                              @endcan  

                               
                            </td>
                            <td>{{($key+1)}}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }}</td>
                            <td>{{ $data->_order_number ?? '' }}</td>
                           
                            <td>{{ _fee_lebel($data->_bill_type ?? '') }}</td>
                            <td>{{ _number_to_month($data->_month_id ?? '') }}</td>
                            <td>{{ $data->_year ?? '' }}</td>
                            <td>{{ $data->_student->_name_in_bangla ?? '' }}</td>
                            <td>{{ $data->_student->_name_in_english ?? '' }}</td>
                            <td>{{ $data->_student->_roll_no ?? '' }}</td>
                            <td>{{ $data->_total_amount ?? '' }}</td>
                            <td>{{ $data->_discount_amount ?? '' }}</td>
                            <td>{{ $data->_net_amount ?? '' }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_user_name ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                            <td>{{ $data->_lock ?? '' }}</td>
                            <td>{{ $data->_created_by ?? '' }}</td>
                            <td>{{ $data->_updated_by ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            
                            
                        </tr>
                        @empty
                        @endforelse
                        

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="10">  {!! $datas->render() !!}</td>
                          </tr>
                        </tfoot>
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


 $(document).on('change','.stduent_seach',function(){
  
   var _admission_session_id = $(document).find('._search_admission_session_id').val();
    var _education_type = $(document).find('._search_education_type').val();
    var _admission_class_id = $(document).find('._search_admission_class_id').val();

    var  page_url = $(this).attr('attr_url');
    var display_area = "._search_stduent_list";
    var data ={ _admission_session_id,_education_type,_admission_class_id }
    console.log(page_url)
    if(_admission_session_id !='' && _education_type !='' && _admission_class_id !=''){
         fetch_list_data_without_paginate(page_url,display_area,data);

    }

  })


</script>
@endsection