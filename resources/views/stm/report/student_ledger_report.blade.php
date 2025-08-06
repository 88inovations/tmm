@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
<style type="text/css">
    .width_150_px{
        width: 150px !important;
    }
    .width_250_px{
        width: 250px !important;
    }
</style>
@endsection
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<div class="container">
<div class="container">
     @php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';
$_student_id =  $request->_student_id ?? '';
@endphp
    
          <div class="message-area">
    @include('backend.message.message')
    </div>
            
           
                
                      <div class="report_box">
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:<span class="_required">*</span></label>
                                    <select class="form-control stduent_seach _admission_session_id _search_admission_session_id" name="_admission_session_id" required attr_url="{{route('session_class_div_wise_student')}}">
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
                                    <label class="form-control-label">{{__('label._education_type')}}:<span class="_required">*</span></label>
                                    <select class="form-control stduent_seach _education_type _search_education_type" name="_education_type" required attr_url="{{route('session_class_div_wise_student')}}">
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
                                    <label class="form-control-label">{{__('label._admission_class_id')}}:<span class="_required">*</span></label>
                                    <select class="form-control stduent_seach _admission_class_id _search_admission_class_id" name="_admission_class_id" required attr_url="{{route('session_class_div_wise_student')}}">
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
                                    <label class="form-control-label">{{__('label._student_id')}}:<span class="_required">*</span></label>
                                    <div class="_search_stduent_list">
                                        
                                         <select class="_student_id form-control  select2" name="_student_id">
                                                <option value="">Select Student</option>
                                            </select>
                                    </div>
                                   
                                </div>
                            </div>
                            
                             
                            
                            <div class="col-xs-12 col-sm-12 col-md-2 mt-3 ">
                                   <button type="button" class="btn btn-primary due_bill_search_button" attr_url="{{route('student_ledger_report_data')}}"><i class="fa fa-search "></i> Report</button>
                                   

                            </div>
                        </div>
                            
                          </div>
                   
</div>


<div class="DueBillDisplayArea"></div>


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



$(document).on('click','.due_bill_search_button',function(){

    var _admission_session_id = $(document).find('._search_admission_session_id').val();
    var _education_type = $(document).find('._search_education_type').val();
    var _admission_class_id = $(document).find('._search_admission_class_id').val();
    var _student_id = $(document).find('._student_id').val();

    var  page_url = $(this).attr('attr_url');
    var display_area = ".DueBillDisplayArea";
    var data ={ _admission_session_id,_education_type,_admission_class_id,_student_id }
    console.log(page_url)
   
         fetch_list_data_without_paginate(page_url,display_area,data);

    

})


 
</script>

@endsection

