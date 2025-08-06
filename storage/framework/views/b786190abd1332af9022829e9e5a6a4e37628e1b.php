 <option value="">--Select Account Type--</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($account_type->id); ?>"  <?php if(old('_account_head_id') == $account_type->id): ?> selected <?php endif; ?>   ><?php echo e($account_type->_code ?? ''); ?>-<?php echo e($account_type->_name ?? ''); ?></option>

                                  <?php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  ?>
                                  <?php $__empty_2 = true; $__currentLoopData = $_child_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <option value="<?php echo e($group->id); ?>"  <?php if(old('_account_head_id') == $group->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;<?php echo e($group->_code ?? ''); ?>-<?php echo e($group->_name ?? ''); ?></option>

                                        <?php
                                        $third_child_group=$group->_child_group ?? [];
                                        ?>

                                         <?php $__empty_3 = true; $__currentLoopData = $third_child_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $third_child_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>

 <option value="<?php echo e($third_child_val->id); ?>"  <?php if(old('_account_head_id') == $third_child_val->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<?php echo e($third_child_val->_code ?? ''); ?>-<?php echo e($third_child_val->_name ?? ''); ?></option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                         <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                  <?php endif; ?>

                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/account-type/account_type_options.blade.php ENDPATH**/ ?>