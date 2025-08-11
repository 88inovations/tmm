     <?php
              $users = \Auth::user();
              $permited_organizations = permited_organization(explode(',',$users->organization_ids));
              
              ?> 


              <div class="col-xs-12 col-sm-12 col-md-12 ">
              <div class="form-group ">
              <label><?php echo __('label.organization'); ?>:</label>
              <select  class="form-control _master_organization_id " name="organization_id"  >

                <?php if(sizeof($permited_organizations) > 1): ?>
                <option value="all">All <?php echo __('label.organization'); ?></option>
                <?php endif; ?>
               <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
               <option value="<?php echo e($val->id); ?>" 
                <?php if(isset($previous_filter["organization_id"]) && $val->id==$previous_filter["organization_id"]): ?> ) selected <?php endif; ?>
                               ><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
               <?php endif; ?>
              </select>
              </div>
              </div>
              <div class="col-md-12">
                          <label><?php echo e(__('label._branch_id')); ?>:</label>
                         <select id="_branch_id" class="form-control _branch_id _master_branch_id" name="_branch_id"  >
                          <?php if(sizeof($permited_branch) > 1): ?>
                          <option value="all">All <?php echo e(__('label._branch_id')); ?></option>
                          <?php endif; ?>
                          <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <option value="<?php echo e($branch->id); ?>" 
                            <?php if(isset($previous_filter["_branch_id"]) && $branch->id==$previous_filter["_branch_id"]): ?> selected <?php endif; ?>
                             > <?php echo e($branch->_name ?? ''); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                         </select>
                      </div>
                      <div class="col-md-12">
                          <label><?php echo e(__('label._cost_center_id')); ?>:</label>
                         <select class="form-control  _cost_center "  name="_cost_center"   >
                          <?php if(sizeof($permited_costcenters) > 1): ?>
                                      <option value="all">All <?php echo e(__('label._cost_center_id')); ?></option>
                          <?php endif; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costcenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($costcenter->id); ?>" 
                              <?php if(isset($previous_filter["_cost_center"]) && $costcenter->id==$previous_filter["_cost_center"]): ?> selected <?php endif; ?>
                                 
                              > <?php echo e($costcenter->_name ?? ''); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                          </select>
                      </div><?php /**PATH D:\xampp\htdocs\tmm\resources\views/basic/org_report.blade.php ENDPATH**/ ?>