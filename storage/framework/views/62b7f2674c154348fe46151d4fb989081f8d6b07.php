<div class="tab-pane " id="hrm_rewards">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._rcategory')); ?></th>
            <th><?php echo e(__('label._rtype')); ?></th>
            <th><?php echo e(__('label._rcause')); ?></th>
            <th><?php echo e(__('label._rnote')); ?></th>
        </tr>
    </thead>
    <?php
$_hrm_rewards=$data->_hrm_rewards ?? [];
//dump($_hrm_rewards);
    ?>
    <tbody class="hrm_rewardss_body">
        <?php $__empty_1 = true; $__currentLoopData = $_hrm_rewards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$reword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_rewards_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_rewards_id[]" value="<?php echo e($reword->id ?? 0); ?>">
          </td>
           <td>
                 <input type="text"   name="_rcategory[]" class="form-control _rcategory " value="<?php echo e($reword->_rcategory ?? ''); ?>" placeholder="<?php echo e(__('label._rcategory')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_rtype[]" class="form-control _rtype " value="<?php echo e($reword->_rtype ?? ''); ?>" placeholder="<?php echo e(__('label._rtype')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_rcause[]" class="form-control _rcause " value="<?php echo e($reword->_rcause ?? ''); ?>" placeholder="<?php echo e(__('label._rcause')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_rnote[]" class="form-control _rnote " value="<?php echo e($reword->_rnote ?? ''); ?>" placeholder="<?php echo e(__('label._rnote')); ?>" >
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="5">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_rewards(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_rewards.blade.php ENDPATH**/ ?>