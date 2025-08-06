<?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<option value="<?php echo e($val->id); ?>"><?php echo e($val->$_column_name ?? ''); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/hrm/hrm-emp-category/select_option.blade.php ENDPATH**/ ?>