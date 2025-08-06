

<?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__empty_1 = true; $__currentLoopData = $conversionUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversionUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <?php if($conversionUnit->_conversion_unit == $unit->id): ?>
 <option value="<?php echo e($unit->id); ?>"  
        attr_base_unit_id="<?php echo e($conversionUnit->_base_unit_id); ?>" 
        attr_conversion_qty="<?php echo e($conversionUnit->_conversion_qty); ?>" 
        attr_conversion_unit="<?php echo e($conversionUnit->_conversion_unit); ?>" 
        attr_item_id="<?php echo e($conversionUnit->_item_id); ?>"
        <?php if($unit->id ==$conversionUnit->_base_unit_id): ?> selected  <?php endif; ?>

         ><?php echo e($unit->_name ?? ''); ?></option>
 <?php endif; ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
 <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/item-information/unit_option.blade.php ENDPATH**/ ?>