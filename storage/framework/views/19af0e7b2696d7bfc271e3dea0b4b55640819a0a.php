<div class="tab-pane " id="hrm_empaddresses">
<table class="table">
    <thead>
      
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._type')); ?></th>
            <th><?php echo e(__('label._district')); ?></th>
            <th><?php echo e(__('label._police')); ?></th>
            <th><?php echo e(__('label._post')); ?></th>
            <th><?php echo e(__('label._address')); ?></th>
            <th><?php echo e(__('label._eaddress')); ?></th>
        </tr>
    </thead>
    <?php
$hrm_empaddresses=$data->hrm_empaddresses ?? [];
    ?>
    <tbody class="hrm_empaddresses_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_empaddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_empaddresses_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_empaddresses_id[]" value="<?php echo e($val->id ?? 0); ?>">
          </td>
           <td>
                 <select name="_type[]" class="form-control _type">
                     <option value="Present" <?php if($val->_type=="Present"): ?> selected <?php endif; ?>>Present</option>
                     <option value="Parmanent" <?php if($val->_type=="Parmanent"): ?> selected <?php endif; ?>>Parmanent</option>
                 </select>
            </td>
            <td>
                 <input type="text"   name="_district[]" class="form-control _district " value="<?php echo e($val->_district ?? ''); ?>" placeholder="<?php echo e(__('label._district')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_police[]" class="form-control _police " value="<?php echo e($val->_police ?? ''); ?>" placeholder="<?php echo e(__('label._police')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_post[]" class="form-control _post " value="<?php echo e($val->_post ?? ''); ?>" placeholder="<?php echo e(__('label._post')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_address[]" class="form-control _address " value="<?php echo e($val->_address ?? ''); ?>" placeholder="<?php echo e(__('label._address')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_eaddress[]" class="form-control _eaddress " value="<?php echo e($val->_eaddress ?? ''); ?>" placeholder="<?php echo e(__('label._eaddress')); ?>" >
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNewhrm_empaddresses(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div><!-- ENd of Tab --><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/hrm/hrm-employee/hrm_empaddresses.blade.php ENDPATH**/ ?>