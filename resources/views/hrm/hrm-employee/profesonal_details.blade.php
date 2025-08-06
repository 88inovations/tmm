<div class="form-group row">
                             <label class="col-md-2">{!! __('label.organization') !!}:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_organization_id" name="organization_id" required >
                                @if(sizeof($permited_organizations) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               
                               @forelse($permited_organizations as $val )
                               <option value="{{$val->id}}" @if(isset($data->organization_id)) @if($data->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{{__('label.Branch')}}:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_branch_id" name="_branch_id" required >
                               @if(sizeof($permited_branch) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_branch as $branch )
                               <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{{__('label.Cost center')}}:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <select class="form-control _cost_center_id" name="_cost_center_id" required >
                               @if(sizeof($permited_costcenters) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($data->_cost_center_id)) @if($data->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label.employee_category_id') !!}:<span class="_required">*</span>   <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label.employee_category_id') !!}"
                                 _column_name="_name"
                                 attr_table_name="hrm_emp_categories"
                                 attr_select_option_class="._sub_category_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button></label>
                            <div class="col-md-5">
                                <select class="form-control _sub_category_id" name="_category_id" required>
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($employee_catogories as $val)
                                  <option value="{{$val->id}}" @if($data->_category_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._department_id') !!}:<span class="_required">*</span>   <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title="{!!__('label._department_id') !!}"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                _column_name="_department"
                                 attr_table_name="hrm_departments"
                                 attr_select_option_class=".sub_department_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button></label>
                        <div class="col-md-5">
                                <select class="form-control sub_department_id" name="_department_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($departments as $val)
                                  <option value="{{$val->id}}" @if($data->_department_id==$val->id) selected @endif>{!! $val->_department ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">{!!__('label._jobtitle_id') !!}:<span class="_required">*</span>  
                                <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._jobtitle_id') !!}"
                                _column_name="_name"
                                 attr_table_name="designations"
                                 attr_select_option_class=".sub_jobtitle_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button></label>
                        <div class="col-md-5">
                                <select class="form-control sub_jobtitle_id" name="_jobtitle_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($designations as $val)
                                  <option value="{{$val->id}}" @if($data->_jobtitle_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._grade_id') !!}:<span class="_required">*</span>  
                                 <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._grade_id') !!}"
                                _column_name="_grade"
                                 attr_table_name="hrm_grades"
                                 attr_select_option_class=".sub_grade_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button></label>
                        <div class="col-md-5">
                                <select class="form-control sub_grade_id" name="_grade_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($grades as $val)
                                  <option value="{{$val->id}}" @if($data->_grade_id==$val->id) selected @endif>{!! $val->_grade ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2">{!!__('label._location') !!}:  
                                 <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._location') !!}"
                                _column_name="_name"
                                 attr_table_name="hrm_emp_locations"
                                 attr_select_option_class=".sub_location"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button></label>
                        <div class="col-md-5">
                                <select class="form-control sub_location" name="_location"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_locations as $val)
                                  <option value="{{$val->id}}" @if($data->_location==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2">{!!__('label._zone_id') !!}:  
                                <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._zone_id') !!}"
                                _column_name="_name"
                                 attr_table_name="zones"
                                 attr_select_option_class=".sub_zone_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button></label>
                        <div class="col-md-5">
                                <select class="form-control sub_zone_id" name="_zone_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_zones as $val)
                                  <option value="{{$val->id}}" @if($data->_zone_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._name') !!}:<span class="_required">*</span></label>
                          <div class="col-md-5">
                                <input type="text" class="form-control" name="_name" value="{{old('_name',$data->_name ?? '')}}" placeholder="{{__('label._name')}}">
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label.EMP_ID') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_code', old('_code'), array('placeholder' => __('label._code'),'class' => 'form-control')) !!}
                                
                            </div>
                        </div>
                         <div class="form-group row">
                                <label class="col-md-2">User ID: <small>User Table ID</small></label>
                        <div class="col-md-5">
                               <input type="text" name="user_id" class="form-control" value="{{$data->user_id ?? ''}}">
                            </div>
                        </div>
                         <div class="form-group row">
                                <label class="col-md-2">Ledger ID: <small>Account Ledger Table ID</small></label>
                        <div class="col-md-5">
                               <input type="text" name="_ledger_id" class="form-control" value="{{$data->_ledger_id ?? ''}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">{!!__('label._email') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::email('_email', old('_email'), array('placeholder' => __('label._email'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">{!!__('label._mobile1') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_mobile1', old('_mobile1'), array('placeholder' => __('label._mobile1'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._mobile2') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_mobile2', old('_mobile2'), array('placeholder' => __('label._mobile2'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._father') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_father', old('_father'), array('placeholder' => __('label._father'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._mother') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_mother', old('_mother'), array('placeholder' => __('label._mother'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._spouse') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_spouse', old('_spouse'), array('placeholder' => __('label._spouse'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._spousesmobile') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_spousesmobile', old('_spousesmobile'), array('placeholder' => __('label._spousesmobile'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._nid') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_nid', old('_nid'), array('placeholder' => __('label._nid'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._gender') !!}:</label>
                        <div class="col-md-5">
                                <select class="form-control" name="_gender">
                                    <option value="">{!! __('label.select') !!}--></option>
                                    @forelse(_gender_list() as $val)
                                     <option value="{{$val}}" @if($val==$data->_gender) selected @endif>{!! $val !!}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._bloodgroup') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_bloodgroup', old('_bloodgroup'), array('placeholder' => __('label._bloodgroup'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._religion') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_religion', old('_religion'), array('placeholder' => __('label._religion'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._dob') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::date('_dob', old('_dob'), array('placeholder' => __('label._dob'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._education') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_education', old('_education'), array('placeholder' => __('label._education'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._officedes') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_officedes', old('_officedes'), array('placeholder' => __('label._officedes'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._bank') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_bank', old('_bank'), array('placeholder' => __('label._bank'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._bankac') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_bankac', old('_bankac'), array('placeholder' => __('label._bankac'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._doj') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::date('_doj', old('_doj'), array('placeholder' => __('label._doj'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-md-2">{!!__('label._tin') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_tin', old('_tin'), array('placeholder' => __('label._tin'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                    
                    <div class="form-group row">
                            <label class="col-md-2">{!!__('label.basic_salary') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('basic_salary', old('basic_salary'), array('placeholder' => __('label.basic_salary'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                     <div class="form-group row">
                            <label class="col-md-2">{!!__('label.allowances') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('allowances', old('allowances'), array('placeholder' => __('label.allowances'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                     <div class="form-group row">
                            <label class="col-md-2">{!!__('label.deductions') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('deductions', old('deductions'), array('placeholder' => __('label.deductions'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        
                     <div class="form-group row">
                            <label class="col-md-2">{!!__('label._gross_salary') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('_gross_salary', old('_gross_salary'), array('placeholder' => __('label._gross_salary'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                     <div class="form-group row">
                            <label class="col-md-2">{!!__('label.net_salary') !!}:</label>
                        <div class="col-md-5">
                                {!! Form::text('net_salary', old('net_salary'), array('placeholder' => __('label.net_salary'),'class' => 'form-control')) !!}
                            </div>
                        </div>



                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label.image') !!}:</label>
                        <div class="col-md-5">
                                <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_photo" class="form-control">
                               <img id="output_1" class="banner_image_create" src="{{asset($data->_photo ?? $settings->logo)}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._signature') !!}:</label>
                        <div class="col-md-5">
                                <input type="file" accept="image/*" onchange="loadFile(event,2 )"  name="_signature" class="form-control">
                               <img id="output_2" class="banner_image_create" src="{{asset($data->_signature ?? $settings->logo)}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                           
                            <div class="form-group row">
                                <label class="col-md-2">{{__('label._status')}}:</label>
                        <div class="col-md-5">
                                <select class="form-control" name="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>