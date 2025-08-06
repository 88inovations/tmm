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
            <a class="m-0 _page_name" href="{{ route('stm_students.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('stm_students_create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('stm_students.create') }}">
                   <i class="nav-icon fas fa-plus"></i> {{__('label.create_new')}}
                </a>

               </li>
              @endcan

               <li class="breadcrumb-item active">
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
  Upload Student
</button>

               </li>
                 <div class="col-md-3">

            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Student Excel File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('stm_students_excel_upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                     
                   
                        <div class="form-group">
                            <label for="file">Choose Excel File:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                        </div>
                   
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
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


                  <form class="" action="{{route('stm_students.index')}}" method="GET">
            @csrf
                
                      <div>
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:</label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id">
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
                                    <select class="form-control _education_type" name="_education_type">
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
                                    <select class="form-control _admission_class_id" name="_admission_class_id">
                                      <option value="">Select Class</option>
                                      @forelse($edu_class as $class)
                                        <option value="{{$class->id }}"
                                         @if($_admission_class_id ==$class->id) selected @endif > {!! $class->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._roll_no')}}:</label>
                                    <input type="text" name="_roll_no" class="form-control _roll_no" value="{{$_roll_no}}" placeholder="{{__('label._roll_no')}}">
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._student_name')}}:</label>
                                    <input type="text" name="_student_name" class="form-control _student_name" value="{{$_student_name}}" placeholder="{{__('label._student_name')}}">
                                </div>
                            </div>


                        @php
             $cloumns = [ 'id'=>'ID','_name_in_english'=>'Name','_age'=>'Age'];





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
                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="limit">Status</label>
                           <select class="form-control" name="_status">
                               <option value="">Select Status</option>
                                <option value="1" @if(isset($request->_status)) @if($request->_status==1) selected @endif @endif>Active</option>
                                 <option value="0" @if(isset($request->_status)) @if($request->_status==0) selected @endif @endif>In Active</option>
                           </select>
                        </div>



                            <div class="col-xs-12 col-sm-12 col-md-3 mt-3 flex">
                                   <button type="submit" class="btn btn-primary mt-1 mr-2"><i class="fa fa-search "></i> Search</button>
                                   <a  href="{{route('stm_students.index')}}" class="btn btn-danger mt-1"><i class="fa fa-retweet"></i> Reset</a>
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
                    <div class="col-md-4">
                      
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               <div class="dropdown-divider"></div>
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             
                        
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b>SL</b></th>
                         <th class=""><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label._admission_date')}}</b></th>
                         <th class=""><b>{{__('label._admission_session_id')}}</b></th>
                         <th class=""><b>{{__('label._education_type')}}</b></th>
                         <th class=""><b>{{__('label._admission_class_id')}}</b></th>
                         <th class=""><b>{{__('label._student_id')}}</b></th>
                         <th class=""><b>{{__('label._proximity_card_no')}}</b></th>
                         <th class=""><b>{{__('label._roll_no')}}</b></th>
                         <th class=""><b>{{__('label._name_in_bangla')}}</b></th>
                         <th class=""><b>{{__('label._name_in_english')}}</b></th>
                         <th class=""><b>{{__('label._f_mobile_no')}}</b></th>
                         <th class=""><b>{{__('label._mother_mobile_no')}}</b></th>
                         <th class=""><b>{{__('label._local_guardian_mobile')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        @forelse ($datas as $key => $data)
                        
                        <tr>
                            
                             <td style="display: flex;">
                              
                              <a  type="button" 
                                  href="{{ route('stm_students.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-2"><i class="fa fa-eye"></i></a>

                             @can('stm_students_edit')
                                  <a  type="button" 
                                  href="{{ route('stm_students.edit',$data->id) }}"
                                 
                                  class="btn btn-sm btn-default  mr-2"><i class="fa fa-pen "></i></a>
                              @endcan  

                              <a href="{{ route('students.admissionFormPdf') }}?id={{$data->id}}" class="btn btn-sm btn-outline-primary" target="_blank">
    Download Admission 
</a>
                               
                            </td>
                            <td>{{($key+1)}}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_admission_date ?? '') }}</td>
                            <td>{{ $data->_edu_session->_name ?? '' }}</td>
                            <td>{{ $data->_edu_division->_name ?? '' }}</td>
                            <td>{{ $data->_edu_class->_name ?? '' }}</td>
                            <td>{{ $data->_student_id ?? '' }}</td>
                            <td>{{ $data->_proximity_card_no ?? '' }}</td>
                            <td>{{ $data->_roll_no ?? '' }}</td>
                            <td>{{ $data->_name_in_bangla ?? '' }}</td>
                            <td>{{ $data->_name_in_english ?? '' }}</td>
                            <td>{{ $data->_f_mobile_no ?? '' }}</td>
                            <td>{{ $data->_mother_mobile_no ?? '' }}</td>
                            <td>{{ $data->_local_guardian_mobile ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                            
                           
                        </tr>
                        @empty
                        @endforelse
                        

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="11">  {!! $datas->render() !!}</td>
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
@endsection