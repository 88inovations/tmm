<div class="tab-pane table-responsive" id="hrm_guarantors">
    <div class="">
<table class="table">
    <thead>
        <tr>
            <th >#</th>
            <th class="width_200_px"><?php echo e(__('label._name')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._father')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._mother')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._occupation')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._workstation')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._address1')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._address2')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._mobile')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._email')); ?></th>
            <th class="width_200_px"><?php echo e(__('label._nationalid')); ?></th>
            <th class="width_150_px"><?php echo e(__('label._dob')); ?></th>
        </tr>
    </thead>
      
    <?php
$hrm_guarantorss=$data->_hrm_guarantors ?? [];
    ?>
    <tbody class="hrm_guarantorss_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_guarantorss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$guar_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_guarantors_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_guarantors_id[]" value="<?php echo e($guar_val->id ?? 0); ?>">
          </td>
           <td>
            <input type="text"   name="gur_name[]" class="form-control width_250_px gur_name " value="<?php echo e($guar_val->_name ?? ''); ?>" placeholder="<?php echo e(__('label._name')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_father[]" class="form-control width_250_px gur_father " value="<?php echo e($guar_val->_father ?? ''); ?>" placeholder="<?php echo e(__('label._father')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_mother[]" class="form-control width_250_px gur_mother " value="<?php echo e($guar_val->_mother ?? ''); ?>" placeholder="<?php echo e(__('label._mother')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_occupation[]" class="form-control width_250_px gur_occupation " value="<?php echo e($guar_val->_occupation ?? ''); ?>" placeholder="<?php echo e(__('label._occupation')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_workstation[]" class="form-control width_250_px gur_workstation " value="<?php echo e($guar_val->_workstation ?? ''); ?>" placeholder="<?php echo e(__('label._workstation')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_address1[]" class="form-control width_250_px gur_address1 " value="<?php echo e($guar_val->_address1 ?? ''); ?>" placeholder="<?php echo e(__('label._address1')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_address2[]" class="form-control width_250_px gur_address2 " value="<?php echo e($guar_val->_address2 ?? ''); ?>" placeholder="<?php echo e(__('label._address2')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_mobile[]" class="form-control width_250_px gur_mobile " value="<?php echo e($guar_val->_mobile ?? ''); ?>" placeholder="<?php echo e(__('label._mobile')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_email[]" class="form-control width_250_px gur_email " value="<?php echo e($guar_val->_email ?? ''); ?>" placeholder="<?php echo e(__('label._email')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_nationalid[]" class="form-control width_250_px gur_nationalid " value="<?php echo e($guar_val->_nationalid ?? ''); ?>" placeholder="<?php echo e(__('label._nationalid')); ?>" >
           </td>
           <td>
            <input type="date"   name="gur_dob[]" class="form-control width_250_px gur_dob " value="<?php echo e($guar_val->_dob ?? ''); ?>" placeholder="<?php echo e(__('label._dob')); ?>" >
           </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="11">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_guarantors(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>
</div>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_guarantors.blade.php ENDPATH**/ ?>