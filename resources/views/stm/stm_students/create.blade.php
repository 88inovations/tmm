@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

<style type="text/css">
  .section-div > h5 {
    color: #636363;
    text-shadow: 2px 1px #dbdbdb;
    font-size: 18px;
}
</style>

  <div class="content mt-2">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="{{ route('stm_students.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
@php
$id = $data->id ?? '';
@endphp
@if($id !='')
                <div class="_report_button_header">
   
    <a href="{{ route('students.admissionFormPdf') }}?id={{$data->id}}" class="btn btn-sm btn-outline-primary" target="_blank">
    Download Admission PDF
</a>

  </div>
@endif
          <div class="message-area">
    @include('backend.message.message')
    </div>

    @php
$_admission_session_id =  $data->_admission_session_id ?? old('_admission_session_id');
$_admission_class_id =  $data->_admission_class_id ?? old('_admission_class_id');
$_education_type =  $data->_education_type ?? old('_education_type');
$_gender =  $data->_gender ?? old('_gender');
$_bloodgroup =  $data->_bloodgroup ?? old('_bloodgroup');
$_admission_date = $data->_admission_date ?? old('_admission_date');
$_religion = $data->_religion ?? old('_religion');
$_student_id = $data->_student_id ?? old('_student_id');
$_proximity_card_no = $data->_proximity_card_no ?? old('_proximity_card_no');
$_father_name_bangla = $data->_father_name_bangla ?? old('_father_name_bangla');
$_father_name_english = $data->_father_name_english ?? old('_father_name_english');
$_occupation = $data->_occupation ?? old('_occupation');
$_annual_income = $data->_annual_income ?? old('_annual_income');
$_f_mobile_no = $data->_f_mobile_no ?? old('_f_mobile_no');
$_f_nid_no = $data->_f_nid_no ?? old('_f_nid_no');
$_f_email = $data->_f_email ?? old('_f_email');
$_mother_name_english = $data->_mother_name_english ?? old('_mother_name_english');
$_mother_name_of_bangla = $data->_mother_name_of_bangla ?? old('_mother_name_of_bangla');
$_mother_occupation = $data->_mother_occupation ?? old('_mother_occupation');
$_mother_anual_income = $data->_mother_anual_income ?? old('_mother_anual_income');
$_mother_nid_no = $data->_mother_nid_no ?? old('_mother_nid_no');
$_mother_email = $data->_mother_email ?? old('_mother_email');
$_local_guardian_name = $data->_local_guardian_name ?? old('_local_guardian_name');
$_local_guardian_address = $data->_local_guardian_address ?? old('_local_guardian_address');
$_local_guardian_mobile = $data->_local_guardian_mobile ?? old('_local_guardian_mobile');
$_local_guardian_nid = $data->_local_guardian_nid ?? old('_local_guardian_nid');
$_local_guardian_nid_image = $data->_local_guardian_nid_image ?? old('_local_guardian_nid_image');
$_local_guardian_occupation = $data->_local_guardian_occupation ?? old('_local_guardian_occupation');
$_present_address = $data->_present_address ?? old('_present_address');
$_per_country_id = $data->_per_country_id ?? old('_per_country_id');
$_per_division_id = $data->_per_division_id ?? old('_per_division_id');
$_per_district_id = $data->_per_district_id ?? old('_per_district_id');
$_per_thana_id = $data->_per_thana_id ?? old('_per_thana_id');
$_per_union_id = $data->_per_union_id ?? old('_per_union_id');
$_cur_division_id = $data->_cur_division_id ?? old('_cur_division_id');
$_cur_country_id = $data->_cur_country_id ?? old('_cur_country_id');
$_cur_district_id = $data->_cur_district_id ?? old('_cur_district_id');
$_cur_thana_id = $data->_cur_thana_id ?? old('_cur_thana_id');
$_cur_union_id = $data->_cur_union_id ?? old('_cur_union_id');
$_parmanent_address = $data->_parmanent_address ?? old('_parmanent_address');
$_previous_institute_name = $data->_previous_institute_name ?? old('_previous_institute_name');
$_pre_class = $data->_pre_class ?? old('_pre_class');
$_pre_result = $data->_pre_result ?? old('_pre_result');
$_pre_roll_no = $data->_pre_roll_no ?? old('_pre_roll_no');
$_father_nid_image = $data->_father_nid_image ?? old('_father_nid_image');
$_mother_nid_image = $data->_mother_nid_image ?? old('_mother_nid_image');
$_birth_certificate = $data->_birth_certificate ?? old('_birth_certificate');
$_transfer_certificate = $data->_transfer_certificate ?? old('_transfer_certificate');
$_testimonial = $data->_testimonial ?? old('_testimonial');
$_academic_certificate = $data->_academic_certificate ?? old('_academic_certificate');
$_marksheet = $data->_marksheet ?? old('_marksheet');
$_student_photo = $data->_student_photo ?? old('_student_photo');
$_adminssion_fee_amount = $data->_adminssion_fee_amount ?? old('_adminssion_fee_amount');
$_monthly_fee = $data->_monthly_fee ?? old('_monthly_fee');
$_resedential_type = $data->_resedential_type ?? old('_resedential_type');
$_parents_signature = $data->_parents_signature ?? old('_parents_signature');
$_detail = $data->_detail ?? old('_detail');
$_per_post_office = $data->_per_post_office ?? old('_per_post_office');
$_mother_mobile_no = $data->_mother_mobile_no ?? old('_mother_mobile_no');
$_resedential_type = $data->_resedential_type ?? old('_resedential_type');
$_roll_no = $data->_roll_no ?? old('_roll_no');
$_student_image = $data->_student_image ?? old('_student_image');
$id = $data->id ?? '';
$_account_group_id = $data->_account_group_id ?? old('_account_group_id');
$_ledger_id = $data->_ledger_id ?? old('_ledger_id');




$_main_subjects  = $data->_main_subjects ?? old('_main_subjects');

$_main_subjects_array = explode(",", $_main_subjects);
$_optional_subjects  = $data->_optional_subjects ?? old('_optional_subjects');
$_optional_subjects_array = explode(",", $_optional_subjects);

$_status = $data->_status ?? 1;






    @endphp

    
         
            <div class="card-body p-4" >
              {!! Form::open(['route' => 'stm_students.store', 'method' => 'POST', 'files' => true]) !!}
                
                      <div class="col-xs-12 col-sm-12 col-md-12 section-div">
                           <h5>Academic Information</h5>
                           <hr>
                         
                           <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_date')}}:<span class="_required">*</span></label>
                                    <input type="date" name="_admission_date" class="form-control _admission_date" value="{{$_admission_date}}">

                                    <input type="hidden" name="id" value="{{$id}}">

                                </div>
                            </div>
                           
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._student_id')}}:<span class="_required">*</span></label>
                                    <input type="text" name="_student_id" class="form-control _student_id" value="{{$_student_id}}" placeholder="{{__('label._student_id')}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._proximity_card_no')}}:<span class="_required">*</span></label>
                                    <input type="text" name="_proximity_card_no" class="form-control   _proximity_card_no" value="{{$_proximity_card_no}}" placeholder="{{__('label._proximity_card_no')}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:<span class="_required">*</span></label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id">
                                      <option value="">Select Session</option>
                                      @forelse($stm_education_sessions as $session)
                                        <option value="{{$session->id }}"
                                         @if($_admission_session_id ==$session->id) selected @endif > {!! $session->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._resedential_type')}}:<span class="_required">*</span></label>
                                    <select class="form-control _resedential_type" name="_resedential_type">
                                      <option value="1" @if($_resedential_type==1) selected @endif>Non Residential</option>
                                      <option value="2" @if($_resedential_type==2) selected @endif>Residential</option>
                                      
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="_account_group_id" class="form-control-label">{{__('label._account_group_id')}}:<span class="_required">*</span></label>
                                   <select class="form-control _account_group_id" name="_account_group_id">
                                       @forelse($account_groups as $group)
                                        <option value="{{$group->id}}" @if($group->id==$_account_group_id) selected @endif >{!! $group->_name ?? '' !!}</option>
                                       @empty
                                       @endforelse
                                   </select>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._education_type')}}:<span class="_required">*</span></label>
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
                                    <label class="form-control-label">{{__('label._admission_class_id')}}:<span class="_required">*</span></label>
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
                                    <label class="form-control-label">{{__('label._roll_no')}}:<span class="_required">*</span></label>
                                    <input type="text" name="_roll_no" class="form-control _roll_no" value="{{$_roll_no}}" placeholder="{{__('label._roll_no')}}">
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="_adminssion_fee_amount" class="form-control-label">{{__('label._adminssion_fee_amount')}}:<span class="_required">*</span></label>
                                   <input type="number" name="_adminssion_fee_amount" class="form-control _adminssion_fee_amount" min="0" step="any" placeholder="{{__('label._adminssion_fee_amount')}}" value="{{$_adminssion_fee_amount}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="_monthly_fee" class="form-control-label">{{__('label._monthly_fee')}}:<span class="_required">*</span></label>
                                   <input type="number" name="_monthly_fee" class="form-control _monthly_fee" min="0" step="any" placeholder="{{__('label._monthly_fee')}}" value="{{$_monthly_fee}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="_ledger_id" class="form-control-label">{{__('label._ledger_id')}}:</label>
                                    <input type="text" name="_ledger_id" class="form-control _ledger_id" value="{{$_ledger_id}}" readonly>
                                  
                                </div>
                            </div>
@if($id !='')
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="card p-2 mt-2">
    <div class="table-responsive">
        <table class="table">
    <thead>
        <tr>
            <th>{{__('label.sl')}}</th>
            <th>{{__('label._admission_session_id')}}</th>
            <th>{{__('label._education_type')}}</th>
            <th>{{__('label._admission_class_id')}}</th>
            <th>{{__('label._roll_no')}}</th>
            <th>{{__('label._adminssion_fee_amount')}}</th>
            <th>{{__('label._monthly_fee')}}</th>
            <th>{{__('label._exam_fee')}}</th>
            <th>{{__('label._monthly_food_fee')}}</th>
            <th>{{__('label._residential_fee')}}</th>
            <th>{{__('label._status')}}</th>
        </tr>
    </thead>
    <tbody class="feeSectionBody">
@php

$_division_class_student = $data->_division_class_student ?? [];
@endphp
@forelse($_division_class_student as $_d_c_s)

@php

$_division_id = $_d_c_s->_division_id ?? 0;
$_class_id = $_d_c_s->_class_id ?? 0;
$_dsc_roll_no = $_d_c_s->_roll_no ?? 0;
$_admission_fee = $_d_c_s->_admission_fee ?? 0;
$_tution_fee = $_d_c_s->_tution_fee ?? 0;
$_exam_fee = $_d_c_s->_exam_fee ?? 0;
$_monthly_food_fee = $_d_c_s->_monthly_food_fee ?? 0;
$_residential_fee = $_d_c_s->_residential_fee ?? 0;
$_std_session_id = $_d_c_s->_session ?? 0;

@endphp
        <tr>
            <td>
                <button class="btn btn-sm btn-danger remove_student_fee">X</button>
                <input type="hidden" name="division_class_student_id[]" value="{{$_d_c_s->id ?? 0}}">
            </td>
            <td>
                <select class="form-control _std_session_id" name="_std_session_id[]">
                  <option value="">Select {{__('label._admission_session_id')}}</option>
                  @forelse($stm_education_sessions as $session)
                                        <option value="{{$session->id }}"
                                         @if($_std_session_id ==$session->id) selected @endif > {!! $session->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                  
                </select>
            </td>
            <td>
                <select class="form-control _division_id" name="_division_id[]">
                  <option value="">Select {{__('label._education_type')}}</option>
                  @forelse($edu_types as $type)
                    <option value="{{$type->id }}"
                     @if($_division_id ==$type->id) selected @endif > {!! $type->_name ?? '' !!} </option>
                  @empty
                  @endforelse
                  
                </select>
            </td>
            <td>
                <select class="form-control _class_id" name="_class_id[]">
                  <option value="">Select Class</option>
                  @forelse($edu_class as $class)
                    <option value="{{$class->id }}"
                     @if($_class_id ==$class->id) selected @endif > {!! $class->_name ?? '' !!} </option>
                  @empty
                  @endforelse
                  
                </select>
            </td>
            <td>
                 <input type="text" name="_dsc_roll_no[]" class="form-control _dsc_roll_no" value="{{$_dsc_roll_no}}" placeholder="{{__('label._roll_no')}}">
            </td>
            <td>
                <input type="number" name="_admission_fee[]" class="form-control _admission_fee" min="0" step="any" placeholder="{{__('label._adminssion_fee_amount')}}" value="{{$_admission_fee}}">
            </td>
            <td>
                <input type="number" name="_tution_fee[]" class="form-control _tution_fee" min="0" step="any" placeholder="{{__('label._tution_fee')}}" value="{{$_tution_fee}}">
            </td>
            
            <td>
                <input type="number" name="_exam_fee[]" class="form-control _exam_fee" min="0" step="any" placeholder="{{__('label._exam_fee')}}" value="{{$_exam_fee}}">
            </td>
            <td>
                <input type="number" name="_monthly_food_fee[]" class="form-control _monthly_food_fee" min="0" step="any" placeholder="{{__('label._monthly_food_fee')}}" value="{{$_monthly_food_fee}}">
            </td>
            <td>
                <input type="number" name="_residential_fee[]" class="form-control _residential_fee" min="0" step="any" placeholder="{{__('label._residential_fee')}}" value="{{$_residential_fee}}">
            </td>
            <td>
               <select class="form-control" name="_detail_status[]">
                    @foreach(common_status() as $key=>$s_val)
                                  <option value="{{$key}}" @if($key==$_d_c_s->_status) selected @endif >{{$s_val}}</option>
                                  @endforeach
               </select>
            </td>

        </tr>
        @empty
         <tr>
          <td>
    <button class="btn btn-sm btn-danger remove_student_fee">X</button>
     <input type="hidden" name="division_class_student_id[]" value="0">
            </td>
             <td>
                <select class="form-control _std_session_id" name="_std_session_id[]">
                  <option value="">Select {{__('label._admission_session_id')}}</option>
                  @forelse($stm_education_sessions as $session)
                                        <option value="{{$session->id }}"
                                         > {!! $session->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                  
                </select>
            </td>

            <td>
                <select class="form-control _division_id" name="_division_id[]">
                  <option value="">Select {{__('label._education_type')}}</option>
                  @forelse($edu_types as $type)
                    <option value="{{$type->id }}"
                     > {!! $type->_name ?? '' !!} </option>
                  @empty
                  @endforelse
                  
                </select>
            </td>
            <td>
                <select class="form-control _class_id" name="_class_id[]">
                  <option value="">Select Class</option>
                  @forelse($edu_class as $class)
                    <option value="{{$class->id }}"
                     > {!! $class->_name ?? '' !!} </option>
                  @empty
                  @endforelse
                  
                </select>
            </td>
            <td>
                 <input type="text" name="_dsc_roll_no[]" class="form-control _dsc_roll_no" value="" placeholder="{{__('label._roll_no')}}">
            </td>
            <td>
                <input type="number" name="_admission_fee[]" class="form-control _admission_fee" min="0" step="any" placeholder="{{__('label._adminssion_fee_amount')}}" value="0">
            </td>
            <td>
                <input type="number" name="_tution_fee[]" class="form-control _tution_fee" min="0" step="any" placeholder="{{__('label._tution_fee')}}" value="0">
            </td>
            
            <td>
                <input type="number" name="_exam_fee[]" class="form-control _exam_fee" min="0" step="any" placeholder="{{__('label._exam_fee')}}" value="0">
            </td>
            <td>
                <input type="number" name="_monthly_food_fee[]" class="form-control _monthly_food_fee" min="0" step="any" placeholder="{{__('label._monthly_food_fee')}}" value="0">
            </td>
            <td>
                <input type="number" name="_residential_fee[]" class="form-control _residential_fee" min="0" step="any" placeholder="{{__('label._residential_fee')}}" value="0">
            </td>

        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                <button type="button" class="btn btn-lg btn-info add_new_row_for_fees">+</button>
            </td>
            <td colspan="9"></td>
        </tr>
    </tfoot>
</table>
    </div>

    </div>


</div> <!-- End of Division Class StudentDetail Section -->

@endif

                          
                            
                             
                           </div>
                          
                        </div>


                        <!-- Student Information Start -->
                      <div class="col-xs-12 col-sm-12 col-md-12 section-div pt-4">
                           <h5>Student Information</h5>
                           <hr>
                           <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-9">
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._name_in_english')}}:<span class="_required">*</span></label>
                                      
                                       <input type="text" name="_name_in_english" class="form-control _name_in_english" placeholder="{{__('label._name_in_english')}}:" value="{{old('_name_in_english',$data->_name_in_english ?? '')}}" required>
                                  </div>
                              </div>
                           
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._name_in_bangla')}}:<span class="_required">*</span></label>
                                       <input type="text" name="_name_in_bangla" class="form-control _name_in_bangla" placeholder="{{__('label._name_in_bangla')}}:" value="{{old('_name_in_bangla',$data->_name_in_bangla ?? '')}}" required>
                                  </div>
                              </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._gender')}}:<span class="_required">*</span></label>
                                       <select class="form-control" name="_gender">
                                         <option value="">Select Gender</option>
                                         @forelse(_gender_list() as $gender)
                                         <option value="{{$gender}}" @if($gender==$_gender) selected @endif> {!! $gender ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._date_of_birth')}}:<span class="_required">*</span></label>
                                       <input type="date" name="_date_of_birth" class="form-control _date_of_birth" placeholder="{{__('label._date_of_birth')}}:" value="{{old('_date_of_birth',$data->_date_of_birth ?? '')}}" required>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._barth_id')}}:</label>
                                       <input type="text" name="_barth_id" class="form-control _barth_id" placeholder="{{__('label._barth_id')}}:" value="{{old('_barth_id',$data->_barth_id ?? '')}}" >
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._email')}}:</label>
                                       <input type="email" name="_email" class="form-control _email" placeholder="{{__('label._email')}}:" value="{{old('_email',$data->_email ?? '')}}" >
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._bloodgroup')}}:</label>

                                      <select class="form-control" name="_bloodgroup">
                                         <option value="">Select Blood Group</option>
                                         @forelse(_blood_group_list() as $bloodgroup)
                                         <option value="{{$bloodgroup}}" @if($bloodgroup==$_bloodgroup) selected @endif> {!! $bloodgroup ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._religion_Id')}}:</label>

                                      <select class="form-control" name="_religion">
                                         <option value="">Select Religion</option>
                                         @forelse(_religion_list() as $religion)
                                         <option value="{{$religion}}" @if($religion==$_religion) selected @endif> {!! $religion ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._s_identification_mark')}}:</label>
                                       <input type="text" name="_s_identification_mark" class="form-control _s_identification_mark" placeholder="{{__('label._s_identification_mark')}}:" value="{{old('_s_identification_mark',$data->_s_identification_mark ?? '')}}" >
                                  </div>
                              </div>
                              
                              <div class="col-xs-12 col-sm-12 col-md-3">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._nationality')}}:</label>
                                       <input type="text" name="_nationality" class="form-control _nationality" placeholder="{{__('label._nationality')}}:" value="{{old('_nationality',$data->_nationality ?? '')}}" >
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._age')}}:</label>
                                       <input type="text" name="_age" class="form-control _age" placeholder="{{__('label._age')}}:" value="{{old('_age',$data->_age ?? '')}}" >
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._height')}}:</label>
                                       <input type="text" name="_height" class="form-control _height" placeholder="{{__('label._height')}}:" value="{{old('_height',$data->_height ?? '')}}" >
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._weight')}}:</label>
                                       <input type="text" name="_weight" class="form-control  _weight" placeholder="{{__('label._weight')}}" value="{{old('_weight',$data->_weight ?? '')}}" >
                                  </div>
                              </div>


                              </div>  <!-- Row -->
                        </div> <!-- div-col-9 -->
                               
                            
                            <div class="col-xs-12 col-sm-12 col-md-3">
                              <div class="form-group">
                                      <label class="form-control-label">{{__('label._student_image')}}:</label>
                                   
                                       <input type="file" name="_student_image" class="form-control _student_image " onchange="loadFile(event,1 )" placeholder="{{__('label._student_image')}}:" value="{{old('_student_image',$data->_student_image ?? '')}}" >

                               <img id="output_1" class="banner_image_create" src="{{asset($_student_image ?? '')}}"  style="height:200px;width: auto;" />
                                  </div>
                               
                            </div>
                           
                             
                           </div><!-- Row -->
                           
                        </div>
                        <!-- Student inforamtion end -->

                        <!-- Present Address Start -->
                      <div class="col-xs-12 col-sm-12 col-md-12 section-div pt-4">
                        
                           <h5 class="">Present Address</h5>
                           <hr>
                           <div class="row">
                            
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._cur_country_id')}}:<span class="_required">*</span></label>
                                       <select class="form-control" name="_cur_country_id">
                                         <option value="">Select {{__('label._cur_country_id')}}</option>
                                         @forelse($counteries as $country)
                                         <option value="{{$country->id}}" @if($country->id==$_cur_country_id) selected @endif> {!! $country->countryname ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._cur_division_id')}}:</label>
                                       <select class="form-control _cur_division_id" name="_cur_division_id" _attr_url="{{url('division_wise_districts')}}">
                                         <option value="">Select {{__('label._cur_division_id')}}</option>
                                         @forelse($loc_divisions as $_loc_division)
                                         <option value="{{$_loc_division->id}}" @if($_loc_division->id==$_cur_division_id) selected @endif> {!! $_loc_division->name ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>

                      @php

                      $division_wise_districts = _division_wise_districts($_cur_division_id);
                      $_district_wise_upazillas = _district_wise_upazillas($_cur_district_id);
                      $_upazilla_wise_postcodes = _upazilla_wise_postcodes($_cur_district_id,$_cur_thana_id);

                      @endphp
                             
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._cur_district_id')}}:</label>
                                        <select class="form-control _cur_district_id" name="_cur_district_id" _attr_url="{{url('district_wise_upazilla')}}">
                                         <option value="">Select {{__('label._cur_district_id')}}</option>
                                         @forelse($division_wise_districts as $district)
                                         <option value="{{$district->id}}" @if($district->id==$_cur_district_id) selected @endif> {!! $district->name ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._cur_thana_id')}}:</label>
                                        <select class="form-control _cur_thana_id" name="_cur_thana_id" _attr_url="{{url('upazilla_wise_union')}}">
                                         <option value="">Select {{__('label._cur_thana_id')}}</option>
                                         @forelse($_district_wise_upazillas as $thana)
                                         <option 
                                         attr_district_id="{{$thana->district_id}}"
                                         value="{{$thana->name}}" @if($thana->name==$_cur_thana_id) selected @endif> {!! $thana->name ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._cur_union_id')}}:</label>
                                        <select class="form-control _cur_union_id" name="_cur_union_id">
                                         <option value="">Select {{__('label._cur_union_id')}}</option>
                                         @forelse($_upazilla_wise_postcodes as $union)
                                         <option value="{{$union->id}}" @if($union->id==$_cur_union_id) selected @endif> {!! $union->postOffice ?? '' !!} {!! $union->postCode ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._cur_post_office')}}:</label>
                                      <input type="text" name="_cur_post_office" class="form-control _cur_post_office" placeholder="{{__('label._cur_post_office')}}" value="{{$_cur_post_office ?? ''}}">
                                        
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._present_address')}}:</label>
                                        <textarea class="form-control _present_address" name="_present_address">{!! $_present_address ?? '' !!}</textarea>
                                  </div>
                              </div>
                           </div><!-- Row -->
                           
                        </div>
                        <!-- Present Address end -->



                        <!-- parmanent Address Start -->
                      <div class="col-xs-12 col-sm-12 col-md-12 section-div pt-4">
                           <h5 class="">Permanent Address</h5>
                           <hr>
                           <div class="row">
                            
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._per_country_id')}}:<span class="_required">*</span></label>
                                       <select class="form-control" name="_per_country_id">
                                         <option value="">Select {{__('label._per_country_id')}}</option>
                                         @forelse($counteries as $country)
                                         <option value="{{$country->id}}" @if($country->id==$_per_country_id) selected @endif> {!! $country->countryname ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._per_division_id')}}:</label>
                                       <select class="form-control _per_division_id" name="_per_division_id" _attr_url="{{url('division_wise_districts')}}">
                                         <option value="">Select {{__('label._per_division_id')}}</option>
                                         @forelse($loc_divisions as $_loc_division)
                                         <option value="{{$_loc_division->id}}" @if($_loc_division->id==$_per_division_id) selected @endif> {!! $_loc_division->name ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>

                      @php

                      $_per_division_wise_districts = _division_wise_districts($_per_division_id);
                      $_per_district_wise_upazillas = _district_wise_upazillas($_per_district_id);
                      $_per_upazilla_wise_postcodes = _upazilla_wise_postcodes($_per_district_id,$_per_thana_id);

                      @endphp
                             
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._per_district_id')}}:</label>
                                        <select class="form-control _per_district_id" name="_per_district_id" _attr_url="{{url('district_wise_upazilla')}}">
                                         <option value="">Select {{__('label._per_district_id')}}</option>
                                         @forelse($_per_division_wise_districts as $district)
                                         <option value="{{$district->id}}" @if($district->id==$_per_district_id) selected @endif> {!! $district->name ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._per_thana_id')}}:</label>
                                        <select class="form-control _per_thana_id" name="_per_thana_id" _attr_url="{{url('upazilla_wise_union')}}">
                                         <option value="">Select {{__('label._per_thana_id')}}</option>
                                         @forelse($_per_district_wise_upazillas as $thana)
                                         <option 
                                         attr_district_id="{{$thana->district_id}}"
                                         value="{{$thana->name}}" @if($thana->name==$_per_thana_id) selected @endif> {!! $thana->name ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._per_union_id')}}:</label>
                                        <select class="form-control _per_union_id" name="_per_union_id">
                                         <option value="">Select {{__('label._per_union_id')}}</option>
                                         @forelse($_per_upazilla_wise_postcodes as $union)
                                         <option value="{{$union->id}}" @if($union->id==$_per_union_id) selected @endif> {!! $union->postOffice ?? '' !!} {!! $union->postCode ?? '' !!}</option>
                                         @empty
                                         @endforelse
                                       </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._per_post_office')}}:</label>
                                      <input type="text" name="_per_post_office" class="form-control _per_post_office" placeholder="{{__('label._per_post_office')}}" value="{{$_per_post_office ?? ''}}">
                                        
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label class="form-control-label">{{__('label._parmanent_address')}}:</label>
                                        <textarea class="form-control _parmanent_address" name="_parmanent_address">{!! $_parmanent_address ?? '' !!}</textarea>
                                  </div>
                              </div>
                           </div><!-- Row -->
                          
                        </div>
                        <!-- parmanent Address end -->


                        <div class="col-sm-12 section-div pt-4">
                        <h5>Father's Information</h5>
                        <hr>
                        <div class="row pr-4">
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                 
                                      <label for="_father_name_bangla" class="form-control-label">{{__('label._father_name_bangla')}}:</label>
                                      <input type="text" name="_father_name_bangla" class="form-control _father_name_bangla" placeholder="{{__('label._father_name_bangla')}}" value="{{$_father_name_bangla ?? ''}}">
                                        
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_father_name_english" class="form-control-label">{{__('label._father_name_english')}}:</label>
                                      <input type="text" name="_father_name_english" class="form-control _father_name_english" placeholder="{{__('label._father_name_english')}}" value="{{$_father_name_english ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_occupation" class="form-control-label">{{__('label._occupation')}}:</label>
                                      <input type="text" name="_occupation" class="form-control _occupation" placeholder="{{__('label._occupation')}}" value="{{$_occupation ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_annual_income" class="form-control-label">{{__('label._annual_income')}}:</label>
                                      <input type="text" name="_annual_income" class="form-control _annual_income" placeholder="{{__('label._annual_income')}}" value="{{$_annual_income ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_f_mobile_no" class="form-control-label">{{__('label._f_mobile_no')}}:</label>
                                      <input type="text" name="_f_mobile_no" class="form-control _f_mobile_no" placeholder="{{__('label._f_mobile_no')}}" value="{{$_f_mobile_no ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_f_nid_no" class="form-control-label">{{__('label._f_nid_no')}}:</label>
                                      <input type="text" name="_f_nid_no" class="form-control _f_nid_no" placeholder="{{__('label._f_nid_no')}}" value="{{$_f_nid_no ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_f_email" class="form-control-label">{{__('label._f_email')}}:</label>
                                      <input type="text" name="_f_email" class="form-control _f_email" placeholder="{{__('label._f_email')}}" value="{{$_f_email ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_father_nid_image" class="form-control-label">{{__('label._father_nid_image')}}:</label>
                                      <input type="file" name="_father_nid_image" class="form-control _father_nid_image" placeholder="{{__('label._father_nid_image')}}" value="{{$_father_nid_image ?? ''}}">
                                        
                              </div>

                        </div>
                    </div>
                    <!-- Father Information end -->

                        <div class="col-sm-12 pt-2 section-div">
                        <h5>Mother's Information</h5>
                        <hr>
                        <div class="row pr-4">
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                 
                                      <label for="_mother_name_english" class="form-control-label">{{__('label._mother_name_english')}}:</label>
                                      <input type="text" name="_mother_name_english" class="form-control _mother_name_english" placeholder="{{__('label._mother_name_english')}}" value="{{$_mother_name_english ?? ''}}">
                                        
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_name_of_bangla" class="form-control-label">{{__('label._mother_name_of_bangla')}}:</label>
                                      <input type="text" name="_mother_name_of_bangla" class="form-control _mother_name_of_bangla" placeholder="{{__('label._mother_name_of_bangla')}}" value="{{$_mother_name_of_bangla ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_occupation" class="form-control-label">{{__('label._mother_occupation')}}:</label>
                                      <input type="text" name="_mother_occupation" class="form-control _mother_occupation" placeholder="{{__('label._mother_occupation')}}" value="{{$_mother_occupation ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_mobile_no" class="form-control-label">{{__('label._mother_mobile_no')}}:</label>
                                      <input type="text" name="_mother_mobile_no" class="form-control _mother_mobile_no" placeholder="{{__('label._mother_mobile_no')}}" value="{{$_mother_mobile_no ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_anual_income" class="form-control-label">{{__('label._mother_anual_income')}}:</label>
                                      <input type="text" name="_mother_anual_income" class="form-control _mother_anual_income" placeholder="{{__('label._mother_anual_income')}}" value="{{$_mother_anual_income ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_nid_no" class="form-control-label">{{__('label._mother_nid_no')}}:</label>
                                      <input type="text" name="_mother_nid_no" class="form-control _mother_nid_no" placeholder="{{__('label._mother_nid_no')}}" value="{{$_mother_nid_no ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_email" class="form-control-label">{{__('label._mother_email')}}:</label>
                                      <input type="text" name="_mother_email" class="form-control _mother_email" placeholder="{{__('label._mother_email')}}" value="{{$_mother_email ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_mother_nid_image" class="form-control-label">{{__('label._mother_nid_image')}}:</label>
                                      <input type="file" name="_mother_nid_image" class="form-control _mother_nid_image" placeholder="{{__('label._mother_nid_image')}}" value="{{$_mother_nid_image ?? ''}}">
                                        
                              </div>

                           
                        </div>
                    </div>
                    <!-- Mother's Information end -->


                        <div class="col-sm-12 pt-2 section-div">
                        <h5>Local Guardian's Information</h5>
                        <hr>
                        <div class="row pr-4">
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                 
                                      <label for="_local_guardian_name" class="form-control-label">{{__('label._local_guardian_name')}}:</label>
                                      <input type="text" name="_local_guardian_name" class="form-control _local_guardian_name" placeholder="{{__('label._local_guardian_name')}}" value="{{$_local_guardian_name ?? ''}}">
                                        
                              </div>

                             
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_local_guardian_mobile" class="form-control-label">{{__('label._local_guardian_occupation')}}:</label>
                                      <input type="text" name="_local_guardian_occupation" class="form-control _local_guardian_occupation" placeholder="{{__('label._local_guardian_occupation')}}" value="{{$_local_guardian_occupation ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_local_guardian_mobile" class="form-control-label">{{__('label._local_guardian_mobile')}}:</label>
                                      <input type="text" name="_local_guardian_mobile" class="form-control _local_guardian_mobile" placeholder="{{__('label._local_guardian_mobile')}}" value="{{$_local_guardian_mobile ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_local_guardian_nid" class="form-control-label">{{__('label._local_guardian_nid')}}:</label>
                                      <input type="text" name="_local_guardian_nid" class="form-control _local_guardian_nid" placeholder="{{__('label._local_guardian_nid')}}" value="{{$_local_guardian_nid ?? ''}}">
                                        
                              </div>
                              
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_local_guardian_nid_image" class="form-control-label">{{__('label._local_guardian_nid_image')}}:</label>
                                      <input type="file" name="_local_guardian_nid_image" class="form-control _local_guardian_nid_image" placeholder="{{__('label._local_guardian_nid_image')}}" value="{{$_local_guardian_nid_image ?? ''}}">
                                        
                              </div>
                               <div class="col-xs-12 col-sm-12 col-md-6 form-group">
                                      <label for="_local_guardian_address" class="form-control-label">{{__('label._local_guardian_address')}}:</label>
                                      <textarea class="form-control _local_guardian_address" name="_local_guardian_address">{!! $_local_guardian_address ?? '' !!}</textarea>
                                     
                                        
                              </div>

                           
                        </div>
                    </div>
                    <!-- Local Guardian's Information end -->

                        <div class="col-sm-12 pt-2 section-div">
                        <h5>Pervious Institution Information</h5>
                        <hr>
                        <div class="row pr-4">
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                 
                                      <label for="_previous_institute_name" class="form-control-label">{{__('label._previous_institute_name')}}:</label>
                                      <input type="text" name="_previous_institute_name" class="form-control _previous_institute_name" placeholder="{{__('label._previous_institute_name')}}" value="{{$_previous_institute_name ?? ''}}">
                                        
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_pre_class" class="form-control-label">{{__('label._pre_class')}}:</label>
                                      <input type="text" name="_pre_class" class="form-control _pre_class" placeholder="{{__('label._pre_class')}}" value="{{$_pre_class ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_pre_result" class="form-control-label">{{__('label._pre_result')}}:</label>
                                      <input type="text" name="_pre_result" class="form-control _pre_result" placeholder="{{__('label._pre_result')}}" value="{{$_pre_result ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_pre_roll_no" class="form-control-label">{{__('label._pre_roll_no')}}:</label>
                                      <input type="text" name="_pre_roll_no" class="form-control _pre_roll_no" placeholder="{{__('label._pre_roll_no')}}" value="{{$_pre_roll_no ?? ''}}">
                                        
                              </div>

                           
                        </div>
                    </div>
                    <!-- Pervious Institution Information end -->
                    
                        <div class="col-sm-12 pt-2 section-div">
                        <h5>Attach Files</h5>
                        <hr>
                        <div class="row pr-4">
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_birth_certificate" class="form-control-label">{{__('label._birth_certificate')}}:</label>
                                      <input type="file" name="_birth_certificate" class="form-control _birth_certificate" placeholder="{{__('label._birth_certificate')}}" value="{{$_birth_certificate ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_transfer_certificate" class="form-control-label">{{__('label._transfer_certificate')}}:</label>
                                      <input type="file" name="_transfer_certificate" class="form-control _transfer_certificate" placeholder="{{__('label._transfer_certificate')}}" value="{{$_transfer_certificate ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_testimonial" class="form-control-label">{{__('label._testimonial')}}:</label>
                                      <input type="file" name="_testimonial" class="form-control _testimonial" placeholder="{{__('label._testimonial')}}" value="{{$_testimonial ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_academic_certificate" class="form-control-label">{{__('label._academic_certificate')}}:</label>
                                      <input type="file" name="_academic_certificate" class="form-control _academic_certificate" placeholder="{{__('label._academic_certificate')}}" value="{{$_academic_certificate ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 form-group">
                                      <label for="_marksheet" class="form-control-label">{{__('label._marksheet')}}:</label>
                                      <input type="file" name="_marksheet" class="form-control _marksheet" placeholder="{{__('label._marksheet')}}" value="{{$_marksheet ?? ''}}">
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-7 form-group">
                                      <label for="_detail" class="form-control-label">{{__('label._detail')}}:</label>
                                      
                                      <textarea class="form-control _detail" name="_detail">{{$_detail ?? ''}}</textarea>
                                        
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">{{__('label._status')}}:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" @if($_status==1) selected @endif>Active</option>
                                  <option value="0" @if($_status==0) selected @endif>In Active</option>
                                </select>
                            </div>
                        </div>


                           
                        </div>
                    </div>
                    <!-- Attach Files end -->


                    
                        <div class="col-sm-12 pt-2 section-div">
                        <h5>Subject</h5>
                        <hr>
                       <div class="row">
            <div class="col-md-12 mb-4 mt-4">
                 <h5 class="text-bold" for="_main_subjects">{{__('label._main_subjects')}}</h5>

                 


                 @forelse($subjects as $subject)
                 
                    <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="_main_subjects[]" id="_main_subjects__{{$subject->id}}" value="{{$subject->id}}"
                          @if(in_array($subject->id,$_main_subjects_array)) checked @endif
                           style="width: 25px;height: 25px;">
                          <label class="form-check-label" for="_main_subjects__{{$subject->id}}">{{$subject->_name ?? ''}}</label>
                        </div>

                 @empty
                 @endforelse

            </div>
            <div class="col-md-12 mb-4 mt-4">
                 <h5 class="text-bold" for="_optional_subjects">{{__('label._optional_subjects')}}</h5>

                 @forelse($subjects as $subject)
                 
                    <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="_optional_subjects[]" id="_optional_subjects__{{$subject->id}}" value="{{$subject->id}}" 
                           @if(in_array($subject->id,$_optional_subjects_array)) checked @endif
                          style="width: 25px;height: 25px;">
                          <label class="form-check-label" for="_optional_subjects__{{$subject->id}}">{{$subject->_name ?? ''}}</label>
                        </div>

                 @empty
                 @endforelse

            </div>

          </div>


                           
                        </div>
                    </div>
                    <!-- Attach Files end -->

                    
                    
                
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle p-4">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
                        </div>
                        <br><br>
                    
                 
                    
                    
                     
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

$(document).on('change','._cur_division_id',function(){

  var url = $(this).attr('_attr_url');
  var division_id = $(this).val();
  var display_class = "._cur_district_id";
  var data = {division_id}
   division_wise_district(data,display_class,url);

});

$(document).on('change','._cur_district_id',function(){

  var url = $(this).attr('_attr_url');
  var _cur_district_id = $(this).val();
  var display_class = "._cur_thana_id";
  var data = {_cur_district_id}
   division_wise_district(data,display_class,url);

});

$(document).on('change','._cur_thana_id',function(){

  var url = $(this).attr('_attr_url');
  var _cur_thana_id = $(this).val();
   var _cur_district_id = $(this).find('option:selected').attr('attr_district_id');

  var display_class = "._cur_union_id";
  var data = {_cur_thana_id,_cur_district_id}
  console.log(data);


   division_wise_district(data,display_class,url);

});

  

$(document).on('change','._per_division_id',function(){

  var url = $(this).attr('_attr_url');
  var division_id = $(this).val();
  var display_class = "._per_district_id";
  var data = {division_id}
   division_wise_district(data,display_class,url);

});

$(document).on('change','._per_district_id',function(){

  var url = $(this).attr('_attr_url');
  var _cur_district_id = $(this).val();
  var display_class = "._per_thana_id";
  var data = {_cur_district_id}
   division_wise_district(data,display_class,url);

});

$(document).on('change','._per_thana_id',function(){

  var url = $(this).attr('_attr_url');
  var _cur_thana_id = $(this).val();
   var _cur_district_id = $(this).find('option:selected').attr('attr_district_id');

  var display_class = "._per_union_id";
  var data = {_cur_thana_id,_cur_district_id}
  console.log(data);


   division_wise_district(data,display_class,url);

});

  

  
$(document).on('click','.add_new_row_for_fees',function(){


    var row=`<tr>
            <td>
    <button class="btn btn-sm btn-danger remove_student_fee">X</button>
     <input type="hidden" name="division_class_student_id[]" value="0">
            </td>
      <td>
                <select class="form-control _std_session_id" name="_std_session_id[]">
                  <option value="">Select {{__('label._admission_session_id')}}</option>
                  @forelse($stm_education_sessions as $session)
                                        <option value="{{$session->id }}"
                                         > {!! $session->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                  
                </select>
            </td>
            <td>
                <select class="form-control _division_id" name="_division_id[]">
                  <option value="">Select {{__('label._education_type')}}</option>
                  @forelse($edu_types as $type)
                    <option value="{{$type->id }}"
                     > {!! $type->_name ?? '' !!} </option>
                  @empty
                  @endforelse
                  
                </select>
            </td>
            <td>
                <select class="form-control _class_id" name="_class_id[]">
                  <option value="">Select Class</option>
                  @forelse($edu_class as $class)
                    <option value="{{$class->id }}"
                     > {!! $class->_name ?? '' !!} </option>
                  @empty
                  @endforelse
                  
                </select>
            </td>
            <td>
                 <input type="text" name="_dsc_roll_no[]" class="form-control _dsc_roll_no" value="" placeholder="{{__('label._roll_no')}}">
            </td>
            <td>
                <input type="number" name="_admission_fee[]" class="form-control _admission_fee" min="0" step="any" placeholder="{{__('label._adminssion_fee_amount')}}" value="0">
            </td>
            <td>
                <input type="number" name="_tution_fee[]" class="form-control _tution_fee" min="0" step="any" placeholder="{{__('label._tution_fee')}}" value="0">
            </td>
            
            <td>
                <input type="number" name="_exam_fee[]" class="form-control _exam_fee" min="0" step="any" placeholder="{{__('label._exam_fee')}}" value="0">
            </td>
            <td>
                <input type="number" name="_monthly_food_fee[]" class="form-control _monthly_food_fee" min="0" step="any" placeholder="{{__('label._monthly_food_fee')}}" value="0">
            </td>
            <td>
                <input type="number" name="_residential_fee[]" class="form-control _residential_fee" min="0" step="any" placeholder="{{__('label._residential_fee')}}" value="0">
            </td>
    <td>
               <select class="form-control" name="_detail_status[]">
                    @foreach(common_status() as $key=>$s_val)
                                  <option value="{{$key}}"  >{{$s_val}}</option>
                                  @endforeach
               </select>
            </td>

        </tr>`;


    $(document).find(".feeSectionBody").append(row);

})
     

$(document).on('click','.remove_student_fee',function(){
    $(this).closest('tr').remove();
})   

</script>
@endsection

