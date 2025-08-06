<div class="tab-pane " id="hrm_experiences">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._company')); ?></th>
            <th><?php echo e(__('label._jobtitle_id')); ?></th>
            <th><?php echo e(__('label._wfrom')); ?></th>
            <th><?php echo e(__('label._wto')); ?></th>
            <th><?php echo e(__('label._note')); ?></th>
        </tr>
    </thead>
    <?php
$hrm_experiences=$data->hrm_experiences ?? [];
    ?>
    <tbody class="hrm_experiences_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_experiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_experiences_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_experiences_id[]" value="<?php echo e($val->id ?? 0); ?>">
          </td>
           <td>
                 <input type="text" name="_company[]" class="form-control _company" placeholder="<?php echo e(__('label._company')); ?>" value="<?php echo e($val->_company ?? ''); ?>">
            </td>
            <td>
                <select class="form-control " name="hrm_experiences_jobtitle_id[]"  >
                  <option value=""><?php echo e(__('label.select')); ?></option>
                  <?php $__empty_2 = true; $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                  <option value="<?php echo e($deg->id); ?>" <?php if($val->_jobtitle_id==$deg->id): ?> selected <?php endif; ?>><?php echo $deg->_name ?? ''; ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                  <?php endif; ?>
                </select>
            </td>
            <td>
                 <input type="date"   name="_wfrom[]" class="form-control _wfrom " value="<?php echo e($val->_wfrom ?? ''); ?>" placeholder="<?php echo e(__('label._wfrom')); ?>" >
            </td>
            <td>
                 <input type="date"   name="_wto[]" class="form-control _wto " value="<?php echo e($val->_wto ?? ''); ?>" placeholder="<?php echo e(__('label._wto')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_note[]" class="form-control _note " value="<?php echo e($val->_note ?? ''); ?>" placeholder="<?php echo e(__('label._note')); ?>" >
            </td>
            
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNewhrm_experiences(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div><!-- ENd of Tab --><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_experiences.blade.php ENDPATH**/ ?>