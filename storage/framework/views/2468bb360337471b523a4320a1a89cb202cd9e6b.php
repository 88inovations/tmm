<div class="tab-pane table-responsive" id="hrm_trainings">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._type')); ?></th>
            <th><?php echo e(__('label._name')); ?></th>
            <th><?php echo e(__('label._subject')); ?></th>
            <th><?php echo e(__('label.organization_id')); ?></th>
            <th><?php echo e(__('label._place')); ?></th>
            <th><?php echo e(__('label._trfrom')); ?></th>
            <th><?php echo e(__('label._trto')); ?></th>
            <th><?php echo e(__('label._result')); ?></th>
            <th><?php echo e(__('label._note')); ?></th>
        </tr>
    </thead>
    <?php
$hrm_trainingss=$data->_hrm_trainings ?? [];
    ?>
    <tbody class="hrm_trainingss_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_trainingss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_trainings_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_trainings_id[]" value="<?php echo e($training->id ?? 0); ?>">
          </td>
           <td>
                 <input type="text"   name="training_type[]" class="form-control _type " value="<?php echo e($training->_type ?? ''); ?>" placeholder="<?php echo e(__('label._type')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="training_name[]" class="form-control _name " value="<?php echo e($training->_name ?? ''); ?>" placeholder="<?php echo e(__('label._name')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_subject[]" class="form-control _subject " value="<?php echo e($training->_subject ?? ''); ?>" placeholder="<?php echo e(__('label._subject')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_organized[]" class="form-control _organized " value="<?php echo e($training->_organized ?? ''); ?>" placeholder="<?php echo e(__('label._organized')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_place[]" class="form-control _place " value="<?php echo e($training->_place ?? ''); ?>" placeholder="<?php echo e(__('label._place')); ?>" >
            </td>
            <td>
                 <input type="date"   name="training_trfrom[]" class="form-control _trfrom " value="<?php echo e($training->_trfrom ?? ''); ?>" placeholder="<?php echo e(__('label._trfrom')); ?>" >
            </td>
            <td>
                 <input type="date"   name="training_trto[]" class="form-control _trto " value="<?php echo e($training->_trto ?? ''); ?>" placeholder="<?php echo e(__('label._trto')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_result[]" class="form-control _result " value="<?php echo e($training->_result ?? ''); ?>" placeholder="<?php echo e(__('label._result')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_note[]" class="form-control _note " value="<?php echo e($training->_note ?? ''); ?>" placeholder="<?php echo e(__('label._note')); ?>" >
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="10">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_trainings(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/hrm/hrm-employee/hrm_trainings.blade.php ENDPATH**/ ?>