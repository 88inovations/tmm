<div class="tab-pane " id="hrm_education">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._level')); ?></th>
            <th><?php echo e(__('label._subject')); ?></th>
            <th><?php echo e(__('label._institute')); ?></th>
            <th><?php echo e(__('label._year')); ?></th>
            <th><?php echo e(__('label._score')); ?></th>
            <th><?php echo e(__('label._edsdate')); ?></th>
            <th><?php echo e(__('label._ededate')); ?></th>
        </tr>
    </thead>
    <?php
$hrm_educations=$data->_hrm_education ?? [];
    ?>
    <tbody class="hrm_educations_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$edu_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_education_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_education_id[]" value="<?php echo e($edu_val->id ?? 0); ?>">
          </td>
           <td>
                 <input type="text"   name="_level[]" class="form-control _level " value="<?php echo e($edu_val->_level ?? ''); ?>" placeholder="<?php echo e(__('label._level')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_subject[]" class="form-control _subject " value="<?php echo e($edu_val->_subject ?? ''); ?>" placeholder="<?php echo e(__('label._subject')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_institute[]" class="form-control _institute " value="<?php echo e($edu_val->_institute ?? ''); ?>" placeholder="<?php echo e(__('label._institute')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_year[]" class="form-control _year " value="<?php echo e($edu_val->_year ?? ''); ?>" placeholder="<?php echo e(__('label._year')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_score[]" class="form-control _score " value="<?php echo e($edu_val->_score ?? ''); ?>" placeholder="<?php echo e(__('label._score')); ?>" >
            </td>
            <td>
                 <input type="date"   name="_edsdate[]" class="form-control _edsdate " value="<?php echo e($edu_val->_edsdate ?? ''); ?>" placeholder="<?php echo e(__('label._edsdate')); ?>" >
            </td>
            <td>
                 <input type="date"   name="_ededate[]" class="form-control _ededate " value="<?php echo e($edu_val->_ededate ?? ''); ?>" placeholder="<?php echo e(__('label._ededate')); ?>" >
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_education(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_education.blade.php ENDPATH**/ ?>