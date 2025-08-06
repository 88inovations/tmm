@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="{{ route('hrm-employee.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
        <div class="message-area">
    @include('backend.message.message')
    </div>



            <div class="card-body p-4" >
               {!! Form::model($data, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['hrm-employee.update', $data->id]]) !!}
                <div class="row">
                        
                      
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label.employee_category_id') !!}:<span class="_required">*</span></label>
                                <select class="form-control" name="_category_id" required>
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($employee_catogories as $val)
                                  <option value="{{$val->id}}" @if($data->_category_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._department_id') !!}:<span class="_required">*</span></label>
                                <select class="form-control select2" name="_department_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($departments as $val)
                                  <option value="{{$val->id}}" @if($data->_department_id==$val->id) selected @endif>{!! $val->_department ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._jobtitle_id') !!}:<span class="_required">*</span></label>
                                <select class="form-control select2" name="_jobtitle_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($designations as $val)
                                  <option value="{{$val->id}}" @if($data->_jobtitle_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._grade_id') !!}:<span class="_required">*</span></label>
                                <select class="form-control " name="_grade_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($grades as $val)
                                  <option value="{{$val->id}}" @if($data->_grade_id==$val->id) selected @endif>{!! $val->_grade ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._name') !!}:</label>
                                {!! Form::text('_name', old('_name'), array('placeholder' => __('label._name'),'class' => 'form-control')) !!}
                                <input type="hidden" name="_ledger_id" value="{{$data->_ledger_id}}">
                                <input type="hidden" name="user_id" value="{{$data->user_id ?? 0}}">
                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._code') !!}:</label>
                                {!! Form::text('_code', old('_code'), array('placeholder' => __('label._code'),'class' => 'form-control')) !!}
                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._father') !!}:</label>
                                {!! Form::text('_father', old('_father'), array('placeholder' => __('label._father'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._mother') !!}:</label>
                                {!! Form::text('_mother', old('_mother'), array('placeholder' => __('label._mother'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._spouse') !!}:</label>
                                {!! Form::text('_spouse', old('_spouse'), array('placeholder' => __('label._spouse'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._mobile1') !!}:</label>
                                {!! Form::text('_mobile1', old('_mobile1'), array('placeholder' => __('label._mobile1'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._mobile2') !!}:</label>
                                {!! Form::text('_mobile2', old('_mobile2'), array('placeholder' => __('label._mobile2'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._spousesmobile') !!}:</label>
                                {!! Form::text('_spousesmobile', old('_spousesmobile'), array('placeholder' => __('label._spousesmobile'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._nid') !!}:</label>
                                {!! Form::text('_nid', old('_nid'), array('placeholder' => __('label._nid'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._gender') !!}:</label>
                                <select class="form-control" name="_gender">
                                    <option value="">{!! __('label.select') !!}--></option>
                                    @forelse(_gender_list() as $val)
                                     <option value="{{$val}}" @if($val==$data->_gender) selected @endif>{!! $val !!}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._bloodgroup') !!}:</label>
                                {!! Form::text('_bloodgroup', old('_bloodgroup'), array('placeholder' => __('label._bloodgroup'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._religion') !!}:</label>
                                {!! Form::text('_religion', old('_religion'), array('placeholder' => __('label._religion'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._dob') !!}:</label>
                                {!! Form::date('_dob', old('_dob'), array('placeholder' => __('label._dob'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._education') !!}:</label>
                                {!! Form::text('_education', old('_education'), array('placeholder' => __('label._education'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._email') !!}:</label>
                                {!! Form::email('_email', old('_email'), array('placeholder' => __('label._email'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._officedes') !!}:</label>
                                {!! Form::text('_officedes', old('_officedes'), array('placeholder' => __('label._officedes'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._bank') !!}:</label>
                                {!! Form::text('_bank', old('_bank'), array('placeholder' => __('label._bank'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._bankac') !!}:</label>
                                {!! Form::text('_bankac', old('_bankac'), array('placeholder' => __('label._bankac'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._doj') !!}:</label>
                                {!! Form::date('_doj', old('_doj'), array('placeholder' => __('label._doj'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>{!!__('label._tin') !!}:</label>
                                {!! Form::text('_tin', old('_tin'), array('placeholder' => __('label._tin'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._location') !!}:</label>
                                <select class="form-control select2" name="_location"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_locations as $val)
                                  <option value="{{$val->id}}" @if($data->_location==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
@php
$users = \Auth::user();
$permited_organizations = permited_organization(explode(',',$users->organization_ids));
$permited_branch = permited_branch(explode(',',$users->branch_ids));
$permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
@endphp 


<div class="col-xs-12 col-sm-12 col-md-3 @if(sizeof($permited_organizations)==1) display_none @endif">
 <div class="form-group ">
     <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
    <select class="form-control _master_organization_id" name="organization_id" required >

       
       @forelse($permited_organizations as $val )
       <option value="{{$val->id}}" @if(isset($data->organization_id)) @if($data->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
       @empty
       @endforelse
     </select>
 </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-3 @if(sizeof($permited_branch)==1) display_none @endif">
 <div class="form-group ">
     <label>{{__('label.Branch')}}:<span class="_required">*</span></label>
    <select class="form-control _master_branch_id" name="_branch_id" required >
       
       @forelse($permited_branch as $branch )
       <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
       @empty
       @endforelse
     </select>
 </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-3 @if(sizeof($permited_costcenters)==1) display_none @endif">
 <div class="form-group ">
     <label>{{__('label.Cost center')}}:<span class="_required">*</span></label>
    <select class="form-control _cost_center_id" name="_cost_center_id" required >
       
       @forelse($permited_costcenters as $cost_center )
       <option value="{{$cost_center->id}}" @if(isset($data->_cost_center_id)) @if($data->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
       @empty
       @endforelse
     </select>
 </div>
</div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label.image') !!}:</label>
                                <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_photo" class="form-control">
                               <img id="output_1" class="banner_image_create" src="{{asset($data->_photo)}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{!!__('label._signature') !!}:</label>
                                <input type="file" accept="image/*" onchange="loadFile(event,2 )"  name="_signature" class="form-control">
                               <img id="output_2" class="banner_image_create" src="{{asset($data->_signature ?? '')}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label._ledger_is_user')}}:</label>
                                <select class="form-control" name="_ledger_is_user">
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label._status')}}:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" @if($data->_status==1) selected @endif >Active</option>
                                  <option value="0" @if($data->_status==0) selected @endif >In Active</option>
                                </select>
                            </div>
                        </div>
                </div>
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
                        </div>
                        <br><br>
                   </div> 
                 
                    
                    
                     
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript">


 
    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }
     
     


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
  })




    function new_row_holiday(event){

      var _row =`<tr class="_voucher_row">
                      <td>
                        <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                        <input type="hidden" name="_detail_id[]" value="0">
                      </td>
                      <td>
                        <input type="text" name="_name[]" class="form-control  width_280_px" placeholder="{{__('label.title')}}">
                      </td>
                      <td>
                        <input type="date" name="_date[]" class="form-control width_250_px _date" placeholder="{{__('label.date')}}">
                      </td>
                      <td>
                        <select class="form-control" name="_type[]">
                          @forelse(full_half() as $fh)
                          <option value="{{$fh}}">{!! $fh ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                      </td>
                    </tr>`;

      $(document).find('.area__voucher_details').append(_row);

    }

  

  

     

         

</script>
@endsection

