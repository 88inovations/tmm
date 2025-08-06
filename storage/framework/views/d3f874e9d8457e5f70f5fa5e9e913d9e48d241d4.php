<div class="tab-pane " id="hrm_emergencies">
<table class="table">
    <thead>
       
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._name')); ?></th>
            <th><?php echo e(__('label._relationship')); ?></th>
            <th><?php echo e(__('label._mobile')); ?></th>
            <th><?php echo e(__('label._home')); ?></th>
            <th><?php echo e(__('label._work')); ?></th>
        </tr>
    </thead>
    <?php
$hrm_emergencies=$data->hrm_emergencies ?? [];

    ?>
    <tbody class="hrm_emergencies_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_emergencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $em_key=>$em_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_emergencies_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_emergencies_id[]" value="<?php echo e($em_val->id ?? 0); ?>">
          </td>
           <td>
                 <input type="text"   name="emerg_name[]" class="form-control _name " value="<?php echo e($em_val->_name ?? ''); ?>" placeholder="<?php echo e(__('label._name')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="emerg_relationship[]" class="form-control _relationship " value="<?php echo e($em_val->_relationship ?? ''); ?>" placeholder="<?php echo e(__('label._relationship')); ?>" >
            </td>
            <td>
                 <input type="text"   name="emerg_mobile[]" class="form-control _mobile " value="<?php echo e($em_val->_mobile ?? ''); ?>" placeholder="<?php echo e(__('label._mobile')); ?>" >
            </td>
            <td>
                 <input type="text"   name="emerg_home[]" class="form-control _home " value="<?php echo e($em_val->_home ?? ''); ?>" placeholder="<?php echo e(__('label._home')); ?>" >
            </td>
            <td>
                 <input type="text"   name="emerg_work[]" class="form-control _work " value="<?php echo e($em_val->_work ?? ''); ?>" placeholder="<?php echo e(__('label._work')); ?>" >
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="6">
                    <a href="#none" class="btn btn-default" onclick="addNewhrm_emergencies(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_emergencies.blade.php ENDPATH**/ ?>