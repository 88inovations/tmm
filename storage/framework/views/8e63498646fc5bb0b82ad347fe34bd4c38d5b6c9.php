
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>

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
          <div class="">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="<?php echo e(route('stm_division_class_students')); ?>"><?php echo $page_name; ?> </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->

          <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

 <?php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';
?>
    
         
            
           <form class="" action="<?php echo e(route('stm_division_class_students')); ?>" method="GET">
            <?php echo csrf_field(); ?>
                
                      <div>
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._admission_session_id')); ?>:</label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id">
                                      <option value="">Select Session</option>
                                      <?php $__empty_1 = true; $__currentLoopData = $stm_education_sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($session->id); ?>"
                                         <?php if($_admission_session_id ==$session->id): ?> selected <?php endif; ?> > <?php echo $session->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
                                </div>
                                <input type="hidden" name="search" value="search">
                            </div>
                        
                   
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._education_type')); ?>:</label>
                                    <select class="form-control _education_type" name="_education_type">
                                      <option value="">Select <?php echo e(__('label._education_type')); ?></option>
                                      <?php $__empty_1 = true; $__currentLoopData = $edu_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($type->id); ?>"
                                         <?php if($_education_type ==$type->id): ?> selected <?php endif; ?> > <?php echo $type->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._admission_class_id')); ?>:</label>
                                    <select class="form-control _admission_class_id" name="_admission_class_id">
                                      <option value="">Select Class</option>
                                      <?php $__empty_1 = true; $__currentLoopData = $edu_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($class->id); ?>"
                                         <?php if($_admission_class_id ==$class->id): ?> selected <?php endif; ?> > <?php echo $class->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._roll_no')); ?>:</label>
                                    <input type="text" name="_roll_no" class="form-control _roll_no" value="<?php echo e($_roll_no); ?>" placeholder="<?php echo e(__('label._roll_no')); ?>">
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._student_name')); ?>:</label>
                                    <input type="text" name="_student_name" class="form-control _student_name" value="<?php echo e($_student_name); ?>" placeholder="<?php echo e(__('label._student_name')); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 mt-3 ">
                                   <button type="submit" class="btn btn-primary"><i class="fa fa-search "></i> Search</button>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>

<?php if(sizeof($datas) > 0): ?>

<form action="<?php echo e(route('stm_division_class_students_store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

<div class="col-xs-12 col-sm-12 col-md-12">
    
    <div class="">
        <table class="table">
    <thead>
        <tr>
           
            <th><?php echo e(__('label.sl')); ?></th>
            <th><?php echo e(__('label._admission_session_id')); ?></th>
            <th><?php echo e(__('label._education_type')); ?></th>
            <th><?php echo e(__('label._admission_class_id')); ?></th>
            <th><?php echo e(__('label._roll_no')); ?></th>
            <th><?php echo e(__('label._name')); ?></th>
            <th><?php echo e(__('label._adminssion_fee_amount')); ?></th>
            <th><?php echo e(__('label._monthly_fee')); ?></th>
            <th><?php echo e(__('label._exam_fee')); ?></th>
            <th><?php echo e(__('label._anual_fee')); ?></th>
            <th><?php echo e(__('label._monthly_food_fee')); ?></th>
            <th><?php echo e(__('label._residential_fee')); ?></th>
            <th><?php echo e(__('label._other_fee')); ?></th>
            <th><?php echo e(__('label._other_2_fee')); ?></th>
            <th><?php echo e(__('label._other_3_fee')); ?></th>
            <th><?php echo e(__('label._status')); ?></th>
        </tr>


    </thead>
    <tbody class="feeSectionBody">

<?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$_d_c_s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<?php

$_division_id = $_d_c_s->_division_id ?? 0;
$_stuendt_class_id = $_d_c_s->_class_id ?? 0;
$_dsc_roll_no = $_d_c_s->_roll_no ?? 0;
$_admission_fee = $_d_c_s->_admission_fee ?? 0;
$_tution_fee = $_d_c_s->_tution_fee ?? 0;
$_exam_fee = $_d_c_s->_exam_fee ?? 0;
$_monthly_food_fee = $_d_c_s->_monthly_food_fee ?? 0;
$_residential_fee = $_d_c_s->_residential_fee ?? 0;
$_std_session_id = $_d_c_s->_session ?? 0;
$_anual_fee = $_d_c_s->_anual_fee ?? 0;
$_other_fee = $_d_c_s->_other_fee ?? 0;
$_other_2_fee = $_d_c_s->_other_2_fee ?? 0;
$_other_3_fee = $_d_c_s->_other_3_fee ?? 0;






?>
        <tr>
            
            <td><?php echo e(($key+1)); ?>


                <input type="hidden" name="id[]" value="<?php echo e($_d_c_s->id ?? 0); ?>">

            </td>
            <td>
                <select class="form-control _std_session_id" name="_std_session_id[]">
                  <option value="">Select <?php echo e(__('label._admission_session_id')); ?></option>
                  <?php $__empty_2 = true; $__currentLoopData = $stm_education_sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <option value="<?php echo e($session->id); ?>"
                                         <?php if($_std_session_id ==$session->id): ?> selected <?php endif; ?> > <?php echo $session->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                      <?php endif; ?>
                  
                </select>
            </td>
            <td>
                <select class="form-control _division_id" name="_division_id[]">
                  <option value="">Select <?php echo e(__('label._education_type')); ?></option>
                  <?php $__empty_2 = true; $__currentLoopData = $edu_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <option value="<?php echo e($type->id); ?>"
                     <?php if($_division_id ==$type->id): ?> selected <?php endif; ?> > <?php echo $type->_name ?? ''; ?> </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                  <?php endif; ?>
                  
                </select>
            </td>
            <td>
                <select class="form-control _class_id" name="_class_id[]">
                  <option value="">Select Class</option>
                  <?php $__empty_2 = true; $__currentLoopData = $edu_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <option value="<?php echo e($class->id); ?>"
                     <?php if($_stuendt_class_id ==$class->id): ?> selected <?php endif; ?> > <?php echo $class->_name ?? ''; ?> </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                  <?php endif; ?>
                  
                </select>
            </td>
            <td>
                 <input type="text" name="_dsc_roll_no[]" class="form-control _dsc_roll_no" value="<?php echo e($_dsc_roll_no); ?>" placeholder="<?php echo e(__('label._roll_no')); ?>">
            </td>
            <td class ="white_space">
                <?php echo $_d_c_s->_student->_name_in_english ?? ''; ?>

            </td>
            <td>
                <input type="number" name="_admission_fee[]" class="form-control _admission_fee" min="0" step="any" placeholder="<?php echo e(__('label._adminssion_fee_amount')); ?>" value="<?php echo e($_admission_fee); ?>">
            </td>
            <td>
                <input type="number" name="_tution_fee[]" class="form-control _tution_fee" min="0" step="any" placeholder="<?php echo e(__('label._tution_fee')); ?>" value="<?php echo e($_tution_fee); ?>">
            </td>
            
            <td>
                <input type="number" name="_exam_fee[]" class="form-control _exam_fee" min="0" step="any" placeholder="<?php echo e(__('label._exam_fee')); ?>" value="<?php echo e($_exam_fee); ?>">
            </td>
            <td>
                <input type="number" name="_anual_fee[]" class="form-control _anual_fee" min="0" step="any" placeholder="<?php echo e(__('label._anual_fee')); ?>" value="<?php echo e($_anual_fee); ?>">
            </td>
            <td>
                <input type="number" name="_monthly_food_fee[]" class="form-control _monthly_food_fee" min="0" step="any" placeholder="<?php echo e(__('label._monthly_food_fee')); ?>" value="<?php echo e($_monthly_food_fee); ?>">
            </td>
            <td>
                <input type="number" name="_residential_fee[]" class="form-control _residential_fee" min="0" step="any" placeholder="<?php echo e(__('label._residential_fee')); ?>" value="<?php echo e($_residential_fee); ?>">
            </td>
            <td>
                <input type="number" name="_other_fee[]" class="form-control _other_fee" min="0" step="any" placeholder="<?php echo e(__('label._other_fee')); ?>" value="<?php echo e($_other_fee); ?>">
            </td>
            <td>
                <input type="number" name="_other_2_fee[]" class="form-control _other_2_fee" min="0" step="any" placeholder="<?php echo e(__('label._other_2_fee')); ?>" value="<?php echo e($_other_2_fee); ?>">
            </td>
            <td>
                <input type="number" name="_other_3_fee[]" class="form-control _other_3_fee" min="0" step="any" placeholder="<?php echo e(__('label._other_3_fee')); ?>" value="<?php echo e($_other_3_fee); ?>">
            </td>
            <td>
               <select class="form-control" name="_status[]">
                    <?php $__currentLoopData = common_status(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$s_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key); ?>" <?php if($key==$_d_c_s->_status): ?> selected <?php endif; ?> ><?php echo e($s_val); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </select>
            </td>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
         
        <?php endif; ?>
    </tbody>
    <tfoot>
       
    </tfoot>
</table>
    </div>

    
<div class="col-xs-12 col-sm-12 col-md-12  text-middle p-4">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> <?php echo e(__('label.save')); ?></button>
                           
                        </div>

</div> <!-- End of Division Class StudentDetail Section -->
</form>
<?php else: ?>
<h4 class="text-center _required p-4">Search With Currect Information</h4>
<?php endif; ?>

                          
                            
                             
                          
                          
                        </div>


                    </div>
                    <!-- Attach Files end -->


                    
                 
                    
                    
                     
                    
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script type="text/javascript">

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/stm_division_class_students/index.blade.php ENDPATH**/ ?>