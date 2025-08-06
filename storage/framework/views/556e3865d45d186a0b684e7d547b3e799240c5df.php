

<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<style type="text/css">
 
  @media  print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="<?php echo e(route('stm_students.index')); ?>" role="button"><i class="fa fa-arrow-left"></i></a>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_students_edit')): ?>
 <a  href="<?php echo e(route('stm_students.edit',$data->id)); ?>" 
    class="nav-link "  title="Edit"  >
    <i class="nav-icon fas fa-edit"></i>
     </a>
  <?php endif; ?>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
    <a href="<?php echo e(route('students.admissionFormPdf')); ?>?id=<?php echo e($data->id); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
    Download Admission PDF
</a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </div>

<section class="invoice" id="printablediv">
    
    <?php
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
$_date_of_birth = $data->_date_of_birth ?? old('_date_of_birth');
$id = $data->id ?? '';



    ?>
    <div class="card-body pt-2">
    
   <table width="100%">
    <tr>
        <td style="width: 80%;vertical-align: top;">

            <div style="text-align:center;width: 20%;float: left;">
             
                <img src="<?php echo e(asset($settings->logo ?? '')); ?>" 
                     alt="Logo"
                     style="height: 120px; width: auto; display: block; margin-bottom: 10px;" />
           
             </div>
            
             <table style="width:80%;float: left;">
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b><?php echo e($settings->name ?? ''); ?></b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><?php echo e($settings->_address ?? ''); ?></td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><?php echo e($settings->_phone ?? ''); ?>,<?php echo e($settings->_email ?? ''); ?></td></tr>
             </table>
        </td>
        <td style="width: 20%; text-align: right; vertical-align: top;">
            <img id="output_1" class="banner_image_create" 
                 src="<?php echo e(asset($_student_image ?? '')); ?>"  
                 style="height:150px; width:auto; border:1px solid #000; padding:5px;" />
        </td>
    </tr>
</table>
</div>
 <div class="card-body p-2">
<h5>Academic Information</h5>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th><?php echo e(__('label._admission_date')); ?></th>
                <td><?php echo e($_admission_date); ?></td>

                <th><?php echo e(__('label._roll_no')); ?></th>
                <td><?php echo e($_roll_no); ?></td>
            </tr>
            <tr>
                <th><?php echo e(__('label._student_id')); ?></th>
                <td><?php echo e($_student_id); ?></td>

                <th><?php echo e(__('label._proximity_card_no')); ?></th>
                <td><?php echo e($_proximity_card_no); ?></td>
            </tr>
            <tr>
                <th><?php echo e(__('label._education_type')); ?></th>
                <td colspan="3"><?php echo e($data->_edu_division->_name ?? ''); ?></td>
            </tr>
            <tr>
                <th><?php echo e(__('label._admission_session_id')); ?></th>
                <td>
                    <?php echo $data->_edu_session->_name ?? ''; ?>

                </td>
                <th><?php echo e(__('label._admission_class_id')); ?></th>
                <td>
                    <?php echo $data->_edu_class->_name ?? ''; ?>

                </td>
            </tr>
            
            <tr>
                <th><?php echo e(__('label._roll_no')); ?></th>
                <td><?php echo e($data->_roll_no ?? ''); ?></td>

                <th><?php echo e(__('label._student_id')); ?></th>
                <td><?php echo e($data->_student_id ?? ''); ?></td>
            </tr>
            <tr>
                <th><?php echo e(__('label._resedential_type')); ?></th>
                <td>
                    <?php if($data->_resedential_type==1): ?> Non Residential <?php endif; ?>
                    <?php if($data->_resedential_type==2): ?> Residential <?php endif; ?>
                </td>
            </tr>
             <tr>
                <th><?php echo e(__('label._adminssion_fee_amount')); ?></th>
                <td><?php echo e(_report_amount($_adminssion_fee_amount)); ?></td>

                <th><?php echo e(__('label._monthly_fee')); ?></th>
                <td><?php echo _report_amount($_monthly_fee); ?></td>
            </tr>
        </tbody>
    </table>
</div>
    <div class="card-body p-2">
    <h5>Student Information</h5>
    <table class="table table-bordered">
        <tbody>
            
            <tr>
                <th><?php echo e(__('label._name_in_english')); ?></th>
                <td><?php echo e($data->_name_in_english ?? ''); ?></td>

                <th><?php echo e(__('label._name_in_bangla')); ?></th>
                <td><?php echo e($data->_name_in_bangla ?? ''); ?></td>
            </tr>
            <tr>
                <th><?php echo e(__('label._gender')); ?></th>
                <td><?php echo e($_gender ?? ''); ?></td>

                <th><?php echo e(__('label._date_of_birth')); ?></th>
                <td><?php echo e(_view_date_formate($_date_of_birth)); ?></td>
            </tr>
            <tr>
                <th><?php echo e(__('label._barth_id')); ?></th>
                <td><?php echo e($_barth_id ?? ''); ?></td>

                <th><?php echo e(__('label._email')); ?></th>
                <td><?php echo e($data->_email ?? ''); ?></td>

            </tr>
            <tr>
                <th><?php echo e(__('label._bloodgroup')); ?></th>
                <td><?php echo e($data->_bloodgroup ?? ''); ?></td>

                <th><?php echo e(__('label._religion_Id')); ?></th>
                <td><?php echo e($_religion ?? ''); ?></td>

            </tr>
            <tr>
                <th><?php echo e(__('label._s_identification_mark')); ?></th>
                <td><?php echo e($data->_s_identification_mark ?? ''); ?></td>

                <th><?php echo e(__('label._nationality')); ?></th>
                <td><?php echo e($_nationality ?? ''); ?></td>

            </tr>
            <tr>
                <th><?php echo e(__('label._age')); ?></th>
                <td><?php echo e($data->_age ?? ''); ?></td>

                <th><?php echo e(__('label._height')); ?></th>
                <td><?php echo e($_height ?? ''); ?></td>

            </tr>
            <tr>
                <th></th>
                <td></td>

                <th><?php echo e(__('label._weight')); ?></th>
                <td><?php echo e($_weight ?? ''); ?></td>

            </tr>
            
        </tbody>
    </table>
</div>
                                <div class="card-body p-2">
                                <h5>Address</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        
                                        <tr>
                                            <th colspan="6"><b>Present Address</b></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._cur_country_id')); ?></th>
                                            <td><?php echo e($data->_cur_country->countryname ?? ''); ?></td>

                                            <th><?php echo e(__('label._cur_division_id')); ?></th>
                                            <td><?php echo e($data->_cur_division->name ?? ''); ?></td>
                                            <th><?php echo e(__('label._cur_district_id')); ?></th>
                                            <td><?php echo e($data->_cur_district->name ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._cur_thana_id')); ?></th>
                                            <td><?php echo e($data->_cur_thana->name ?? ''); ?></td>

                                            <th><?php echo e(__('label._cur_union_id')); ?></th>
                                            <td><?php echo e($data->_cur_union->postOffice ?? ''); ?></td>
                                            <th><?php echo e(__('label._cur_post_office')); ?></th>
                                            <td><?php echo e($data->_cur_post_office ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._present_address')); ?></th>
                                            <td colspan="5"><?php echo $data->_present_address ?? ''; ?></td>
                                        </tr>
                                       
                                        
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <tbody>
                                        
                                        <tr>
                                            <th colspan="6"><b>Present Address</b></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._per_country_id')); ?></th>
                                            <td><?php echo e($data->_per_country->countryname ?? ''); ?></td>

                                            <th><?php echo e(__('label._per_division_id')); ?></th>
                                            <td><?php echo e($data->_per_division->name ?? ''); ?></td>
                                            <th><?php echo e(__('label._per_district_id')); ?></th>
                                            <td><?php echo e($data->_per_district->name ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._per_thana_id')); ?></th>
                                            <td><?php echo e($data->_per_thana->name ?? ''); ?></td>

                                            <th><?php echo e(__('label._per_union_id')); ?></th>
                                            <td><?php echo e($data->_per_union->postOffice ?? ''); ?></td>
                                            <th><?php echo e(__('label._per_post_office')); ?></th>
                                            <td><?php echo e($data->_per_post_office ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._parmanent_address')); ?></th>
                                            <td colspan="5"><?php echo $data->_parmanent_address ?? ''; ?></td>
                                        </tr>
                                       
                                        
                                    </tbody>
                                </table>
                            </div>


                            <div class="card-body section-div p-2">
                                <h5>Family Information</h5>
                                <table class="table table-bordered mb-2">
                                    <tbody>
                                        
                                       <tr>
                                           <th colspan="6"><strong>Father's Information</strong></th>
                                       </tr>
                                        <tr>
                                            <th><?php echo e(__('label._father_name_bangla')); ?></th>
                                            <td><?php echo e($data->_father_name_bangla ?? ''); ?></td>

                                            <th><?php echo e(__('label._father_name_english')); ?></th>
                                            <td><?php echo e($data->_father_name_english ?? ''); ?></td>
                                            <th><?php echo e(__('label._occupation')); ?></th>
                                            <td><?php echo e($data->_occupation ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._annual_income')); ?></th>
                                            <td><?php echo e($data->_annual_income ?? ''); ?></td>

                                            <th><?php echo e(__('label._f_mobile_no')); ?></th>
                                            <td><?php echo e($data->_f_mobile_no ?? ''); ?></td>
                                            <th><?php echo e(__('label._f_nid_no')); ?></th>
                                            <td><?php echo e($data->_f_nid_no ?? ''); ?></td>
                                        </tr>
                                    </tbody>


                                </table>
                                <table class="table table-bordered mb-2">
                                    <tbody>
                                         <tr>
                                           <th colspan="6"><strong>Mother's Information</strong></th>
                                       </tr>
                                        
                                        <tr>
                                            <th><?php echo e(__('label._mother_name_of_bangla')); ?></th>
                                            <td><?php echo e($data->_mother_name_of_bangla ?? ''); ?></td>

                                            <th><?php echo e(__('label._mother_name_english')); ?></th>
                                            <td><?php echo e($data->_mother_name_english ?? ''); ?></td>
                                            <th><?php echo e(__('label._mother_occupation')); ?></th>
                                            <td><?php echo e($data->_mother_occupation ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                             <th><?php echo e(__('label._mother_anual_income')); ?></th>
                                            <td><?php echo e($data->_mother_anual_income ?? ''); ?></td>
                                            <th><?php echo e(__('label._mother_mobile_no')); ?></th>
                                            <td><?php echo e($data->_mother_mobile_no ?? ''); ?></td>

                                           
                                            <th><?php echo e(__('label._mother_nid_no')); ?></th>
                                            <td><?php echo e($data->_mother_nid_no ?? ''); ?></td>
                                        </tr>
                                    </tbody>

                                    
                                </table>
                                <table class="table table-bordered mb-2">
                                    <tbody>
                                         <tr>
                                           <th colspan="6"><strong>Local Guardian's Information</strong></th>
                                       </tr>
                                        <tr>
                                            <th><?php echo e(__('label._local_guardian_name')); ?></th>
                                            <td><?php echo e($data->_local_guardian_name ?? ''); ?></td>
                                            <th><?php echo e(__('label._local_guardian_address')); ?></th>
                                            <td ><?php echo e($data->_local_guardian_address ?? ''); ?></td>

                                          
                                        </tr>
                                        <tr>
                                             
                                            <th><?php echo e(__('label._local_guardian_mobile')); ?></th>
                                            <td><?php echo e($data->_local_guardian_mobile ?? ''); ?></td>
                                            <th><?php echo e(__('label._local_guardian_nid')); ?></th>
                                            <td><?php echo e($data->_local_guardian_nid ?? ''); ?></td>
                                           
                                        </tr>
                                    </tbody>

                                    
                                </table>
                               
                            </div>
         
                            <div class="card-body section-div p-2">
                                <h5>Pervious Institution Information</h5>
                                <table class="table table-bordered mb-2">
                                    <tbody>
                                        
                                      
                                        <tr>
                                            <th><?php echo e(__('label._previous_institute_name')); ?></th>
                                            <td><?php echo e($data->_previous_institute_name ?? ''); ?></td>

                                            <th><?php echo e(__('label._pre_class')); ?></th>
                                            <td><?php echo e($data->_pre_class ?? ''); ?></td>
                                            <th><?php echo e(__('label._pre_result')); ?></th>
                                            <td><?php echo e($data->_pre_result ?? ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('label._pre_roll_no')); ?></th>
                                            <td><?php echo e($data->_pre_roll_no ?? ''); ?></td>

                                            <th colspan="4"></th>
                                        </tr>
                                    </tbody>


                                </table>
                              
                              
                               
                            </div>
         

         <div style="padding-top: 50px;">
                                <table width="100%">
                                    <tbody>
                                        
                                      
                                        <tr>
                                            <th>
                                                <div><span style="border-top:1px dotted #000;">Student Signature</span></div>
                                            </th>
                                            <th>
                                                <div><span style="border-top:1px dotted #000;">Guardian Signature</span></div>
                                            </th>
                                            <th>
                                                <div><span style="border-top:1px dotted #000;">Examiner's Signature</span></div>
                                            </th>
                                            <th>
                                                <div><span style="border-top:1px dotted #000;">Principal Signature</span></div>
                                            </th>
                                        </tr>
                                        
                                    </tbody>


                                </table>
                              
                              
                               
                            </div>
                       
                           
                             
                      
  </section>


<!-- Page specific script -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/stm_students/show.blade.php ENDPATH**/ ?>