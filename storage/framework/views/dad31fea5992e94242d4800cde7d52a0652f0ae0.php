<div class="tab-pane table-responsive" id="hrm_transfers">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('label._forganization_id')); ?></th>
            <th><?php echo e(__('label._fbranch_id')); ?></th>
            <th><?php echo e(__('label._fcost_center_id')); ?></th>
            <th><?php echo e(__('label._ttransfer')); ?></th>

            <th><?php echo e(__('label._torganization_id')); ?></th>
            <th><?php echo e(__('label._tbranch_id')); ?></th>
            <th><?php echo e(__('label._tcost_center_id')); ?></th>
            <th><?php echo e(__('label._tjoin')); ?></th>
            <th><?php echo e(__('label._tnote')); ?></th>
        </tr>

        
    </thead>
    <?php
$hrm_transferss=$data->_hrm_transfers ?? [];
    ?>
    <tbody class="hrm_transferss_body">
        <?php $__empty_1 = true; $__currentLoopData = $hrm_transferss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_e_key=>$transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_transfers_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_transfers_id[]" value="<?php echo e($transfer->id ?? 0); ?>">
          </td>
           <td>
                 <select class="form-control _forganization_id" name="_forganization_id[]"  >
                    <?php if(sizeof($permited_organizations) > 1): ?> 
                    <option value="">--Select--</option>
                     <?php endif; ?>
                   
                   <?php $__empty_2 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                   <option value="<?php echo e($val->id); ?>" <?php if(isset($transfer->_forganization_id)): ?> <?php if($transfer->_forganization_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                   <?php endif; ?>
                 </select>
            </td>
            
            <td>
                 <select class="form-control _fbranch_id" name="_fbranch_id[]"  >
                               <?php if(sizeof($permited_branch) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_2 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                               <option value="<?php echo e($branch->id); ?>" <?php if(isset($transfer->_fbranch_id)): ?> <?php if($transfer->_fbranch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                <select class="form-control _fcost_center_id" name="_fcost_center_id[]"  >
                               <?php if(sizeof($permited_costcenters) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_2 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                               <option value="<?php echo e($cost_center->id); ?>" <?php if(isset($transfer->_fcost_center_id)): ?> <?php if($transfer->_fcost_center_id == $cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                 <input type="date"   name="_ttransfer[]" class="form-control _ttransfer " value="<?php echo e($transfer->_ttransfer ?? ''); ?>" placeholder="<?php echo e(__('label._ttransfer')); ?>" >
            </td>
            <td>
                 <select class="form-control _torganization_id" name="_torganization_id[]"  >
                    <?php if(sizeof($permited_organizations) > 1): ?> 
                    <option value="">--Select--</option>
                     <?php endif; ?>
                   
                   <?php $__empty_2 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                   <option value="<?php echo e($val->id); ?>" <?php if(isset($transfer->_torganization_id)): ?> <?php if($transfer->_torganization_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                   <?php endif; ?>
                 </select>
            </td>
            
            <td>
                 <select class="form-control _tbranch_id" name="_tbranch_id[]"  >
                               <?php if(sizeof($permited_branch) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_2 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                               <option value="<?php echo e($branch->id); ?>" <?php if(isset($transfer->_tbranch_id)): ?> <?php if($transfer->_tbranch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                <select class="form-control _tcost_center_id" name="_tcost_center_id[]"  >
                               <?php if(sizeof($permited_costcenters) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_2 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                               <option value="<?php echo e($cost_center->id); ?>" <?php if(isset($transfer->_tcost_center_id)): ?> <?php if($transfer->_tcost_center_id == $cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                 <input type="date"   name="_tjoin[]" class="form-control _tjoin " value="<?php echo e($transfer->_tjoin ?? ''); ?>" placeholder="<?php echo e(__('label._tjoin')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_tnote[]" class="form-control _tnote " value="<?php echo e($transfer->_tnote ?? ''); ?>" placeholder="<?php echo e(__('label._tnote')); ?>" >
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="10">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_transfers(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_transfers.blade.php ENDPATH**/ ?>