<div class="tab-pane " id="hrm_jobcontracts">

    <?php
    $hrm_jobcontracts = $data->hrm_jobcontracts ?? '';
    ?>
    <div class="">
            <div class="form-group row">
                <label class="col-md-2"><?php echo e(__('label._ctype')); ?>:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_ctype" class="form-control" value="<?php echo e($hrm_jobcontracts->_ctype ?? ''); ?>" placeholder="<?php echo e(__('label._ctype')); ?>">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2"><?php echo e(__('label._csdate')); ?>:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="date" name="_csdate" class="form-control" value="<?php echo e($hrm_jobcontracts->_csdate ?? ''); ?>" placeholder="<?php echo e(__('label._csdate')); ?>">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2"><?php echo e(__('label._cedate')); ?>:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="date" name="_cedate" class="form-control" value="<?php echo e($hrm_jobcontracts->_cedate ?? ''); ?>" placeholder="<?php echo e(__('label._cedate')); ?>">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2"><?php echo e(__('label._cdetail')); ?>:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                    <textarea class="form-control" name="_cdetail"><?php echo $hrm_jobcontracts->_cdetail ?? ''; ?></textarea>
                   
                 </div>
            </div>
    </div>

</div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/hrm_jobcontracts.blade.php ENDPATH**/ ?>