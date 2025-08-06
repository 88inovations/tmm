
<?php

$previous_filter= Session::get('groupBaseLedgerReportFilter');

?>

<?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <option value="<?php echo e($val->id); ?>" 
      	<?php if(isset($previous_filter["_account_ledger_id"])): ?>
      	<?php if(in_array($val->id,$previous_filter["_account_ledger_id"])): ?> selected <?php endif; ?>
        <?php endif; ?>  ><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <?php endif; ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/account-ledger/group_base_ledger.blade.php ENDPATH**/ ?>