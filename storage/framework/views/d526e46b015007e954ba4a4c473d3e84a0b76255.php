 
                                  <option value="">--Select Account Group--</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $account_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($account_group->id); ?>" <?php if(isset($request->_account_head_id)): ?> <?php if($request->_account_head_id == $account_group->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($account_group->id ?? ''); ?> - <?php echo e($account_group->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                <?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/account-ledger/type_base_group.blade.php ENDPATH**/ ?>