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
            <a class="m-0 _page_name" href="{{ route('admission_fee_collection_list') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('stm_students_create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('admission_fee_collection') }}">
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
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';
$asc_cloumn =  $request->asc_cloumn ?? '';
$_asc_desc =  $request->_asc_desc ?? '';
 $row_numbers = filter_page_numbers();



@endphp


     @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 <div class="row">


                  <form class="" action="{{route('admission_fee_collection_list')}}" method="GET">
            @csrf
                
                      <div class="report_box">
                           
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
                                                
                                            </select>
                                    </div>
                                   
                                </div>
                            </div>

                            @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date'];





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
                                   <a  href="{{route('admission_fee_collection_list')}}" class="btn btn-danger mt-1"><i class="fa fa-retweet"></i> Reset</a>
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
                         <th class=""><b>{{__('label._father_name_bangla')}}</b></th>
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
                                  href="{{ route('admission_fee_collection_show') }}?id={{$data->id}}"
                                  class="btn btn-sm btn-default  mr-2">Money Receipt</a>

                             @can('admission_fee_collection_edit')
                                  <a  
                                  href="{{ route('admission_fee_collection_edit') }}?id={{$data->id}}"
                                 
                                  class="btn btn-sm btn-default  mr-2"><i class="fa fa-pen "></i></a>
                              @endcan 
                             @can('admission_fee_collection_delete')
                                  <a   
                                  href="{{ route('admission_fee_collection_delete') }}?id={{$data->id}}"
                                  onclick="return confirm('Do You Want to Delete!')" 
                                 
                                  class="btn btn-sm btn-warning  mr-2"><i class="fa fa-trash "></i></a>
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
                            <td>{{ $data->_student->_father_name_bangla ?? '' }}</td>
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
                            <td colspan="9">  {!! $datas->render() !!}</td>
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
 $(function () {
   var default_date_formate = `{{default_date_formate()}}`
   var _datex = `{{$request->_datex ?? '' }}`
   var _datey = `{{$request->_datey ?? '' }}`
    
     $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });
 


function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }


  

function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

});

 

</script>

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