<div class="tab-pane " id="hrm_languages">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._language')); ?></th>
            <th><?php echo e(__('label._fluency')); ?></th>
            <th><?php echo e(__('label._lnote')); ?></th>
        </tr>
    </thead>
    <?php
$hrm_languagess=$data->_hrm_languages ?? [];
    ?>
    <tbody class="hrm_languagess_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_languagess; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_languages_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_languages_id[]" value="<?php echo e($lan->id ?? 0); ?>">
          </td>
           <td>
                 <input type="text"   name="_language[]" class="form-control _language " value="<?php echo e($lan->_language ?? ''); ?>" placeholder="<?php echo e(__('label._language')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_fluency[]" class="form-control _fluency " value="<?php echo e($lan->_fluency ?? ''); ?>" placeholder="<?php echo e(__('label._fluency')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_lnote[]" class="form-control _lnote " value="<?php echo e($lan->_lnote ?? ''); ?>" placeholder="<?php echo e(__('label._lnote')); ?>" >
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_languages(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_languages.blade.php ENDPATH**/ ?>