<div class="tab-pane " id="current_salary_structures">
<?php
    $previous_detail = $data->_details ?? [];
?>
<div class="card">
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $payheads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_key=>$p_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-4 ">
                        <h3><?php echo $p_key ?? ''; ?></h3>
                        <?php if(sizeof($p_val) > 0): ?>
                            <?php $__empty_2 = true; $__currentLoopData = $p_val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <?php
                            //dump($l_val);
                            ?>
                            <div class="form-group row ">
                            <label class="col-sm-6 col-form-label" for="_item"><?php echo e($l_val->_ledger ?? ''); ?>:</label>
                             <div class="col-sm-6">
                                <input type="hidden" name="_payhead_id[]" class="_payhead_id" value="<?php echo e($l_val->id); ?>">
                                <input type="hidden" name="_payhead_type_id[]" class="_payhead_type_id" value="<?php echo e($l_val->_type); ?>">
                               
                              <input type="number"  name="_amount[]" class="form-control payhead_amount <?php if(isset($l_val->_payhead_type) && $l_val->_payhead_type->cal_type==1): ?> _add_salary <?php endif; ?>  <?php if($l_val->_payhead_type->cal_type==2): ?> _deduction_salary <?php endif; ?>"
                               <?php $__empty_3 = true; $__currentLoopData = $previous_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                <?php if($p_val->_payhead_id==$l_val->id): ?>
                                value="<?php echo e($p_val->_amount ?? 0); ?>"
                               <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                              <?php endif; ?>

                                placeholder="<?php echo e(__('label._amount')); ?>" >
                              <input type="hidden" name="_detail_row_id[]" class="_detail_row_id" 
                              <?php $__empty_3 = true; $__currentLoopData = $previous_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                <?php if($p_val->_payhead_id==$l_val->id): ?>
                                    value="<?php echo e($p_val->id ?? 0); ?>"

                               <?php endif; ?>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                              <?php endif; ?>

                               >
                              
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    
                </div>

              <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Total Earnings:</label>
                         <div class="col-sm-6">
                            <input type="text" name="total_earnings" class="form-control total_earnings" value="<?php echo e($data->total_earnings ?? 0); ?>"  readonly>
                        </div>
                    </div>
                    <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Total Deduction:</label>
                         <div class="col-sm-6">
                            <input type="text" name="total_deduction" class="form-control total_deduction" value="<?php echo e($data->total_deduction ?? 0); ?>"  readonly>
                        </div>
                    </div>
                    <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Net Total Salary:</label>
                         <div class="col-sm-6">
                            <input type="text" name="net_total_earning" class="form-control net_total_earning" value="<?php echo e($data->net_total_earning ?? 0); ?>"  readonly>
                        </div>
                    </div>
        </div>
</div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/hrm/hrm-employee/current_salary_structures.blade.php ENDPATH**/ ?>