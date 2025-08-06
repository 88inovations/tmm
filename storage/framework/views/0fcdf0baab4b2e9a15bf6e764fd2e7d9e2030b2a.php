 


              <div class="col-xs-12 col-sm-12 col-md-2 ">
              <div class="form-group ">
              <label><?php echo __('label.organization'); ?>:<span class="_required">*</span></label>
              <select class="form-control _master_organization_id" name="organization_id" required >
                <?php if(sizeof($permited_organizations)>1): ?> 
                            <option value="">--<?php echo e(__('label.select')); ?>--</option>
                            <?php endif; ?>
               <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
               <option value="<?php echo e($val->id); ?>" <?php if(isset($data->organization_id)): ?> <?php if($data->organization_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
               <?php endif; ?>
              </select>
              </div>
              </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group ">
                                <label><?php echo e(__('label.Branch')); ?>:<span class="_required">*</span></label>
                               <select class="form-control _master_branch_id" name="_branch_id" required >
                                  <?php if(sizeof($permited_branch) > 1): ?> 
                           <option value="">--<?php echo e(__('label.select')); ?>--</option>
                            <?php endif; ?>
                                  <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($branch->id); ?>" <?php if(isset($data->_branch_id)): ?> <?php if($data->_branch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2  ">
                            <div class="form-group ">
                                <label><?php echo e(__('label.Cost center')); ?>:<span class="_required">*</span></label>
                               <select class="form-control _master_cost_center_id" name="_cost_center_id" required >
                                <?php if(sizeof($permited_costcenters)>1): ?> 
                              <option value="">--<?php echo e(__('label.select')); ?>--</option>
                           <?php endif; ?>
                                   <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costcenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                  <option value="<?php echo e($costcenter->id); ?>" <?php if(isset($data->_cost_center_id)): ?> <?php if($data->_cost_center_id == $costcenter->id): ?> selected <?php endif; ?>   <?php endif; ?>> <?php echo e($costcenter->_name ?? ''); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>

<div class="col-xs-12 col-sm-12 col-md-2  ">
   <div class="form-group ">
       <label><?php echo e(__('label._budget_id')); ?>:</label>
      <select class="form-control _master_budget_id" name="_budget_id"  >
           <?php if(sizeof($permited_budgets)>1): ?> 
             <option value=""><?php echo e(__('label.select')); ?></option>
           <?php endif; ?>
          <?php $__empty_1 = true; $__currentLoopData = $permited_budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                         <option value="<?php echo e($b_val->id); ?>" <?php if(isset($data->_budget_id)): ?> <?php if($data->_budget_id == $b_val->id): ?> selected <?php endif; ?>   <?php endif; ?>> <?php echo e($b_val->_name ?? ''); ?></option>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
           <?php endif; ?>
       </select>
   </div>
</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/widgets/budget_select.blade.php ENDPATH**/ ?>