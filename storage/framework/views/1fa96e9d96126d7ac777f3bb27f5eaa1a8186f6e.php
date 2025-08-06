
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>


<div class="container">
    <h3>Income Ledger Setup Entry</h3>
    <form action="<?php echo e(route('stm_income_ledger_setups_store')); ?>" method="POST">

        <input type="hidden" name="id" value="<?php echo e($editData->id ?? ''); ?>">
        <?php echo csrf_field(); ?>

        <?php
            $fields = [
                '_admission_fee_ledger' => 'Admission Fee Ledger',
                '_tution_fee_ledger' => 'Tuition Fee Ledger',
                '_anual_fee_ledger' => 'Annual Fee Ledger',
                '_exam_fee_ledger' => 'Exam Fee Ledger',
                '_monthly_food_fee_ledger' => 'Monthly Food Fee Ledger',
                '_residential_fee_ledger' => 'Residential Fee Ledger',
                '_other_fee_ledger' => 'Other Fee Ledger',
                '_other_2_fee_ledger' => 'Other 2 Fee Ledger',
                '_other_3_fee_ledger' => 'Other 3 Fee Ledger',
                '_discount_ledger' => 'Discount Ledger',
            ];
        ?>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row mb-3">
                <label class="col-md-3" for="<?php echo e($name); ?>"><?php echo e($label); ?></label>
                <div class="col-md-6">
                 <select name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" class="form-control select2" >

                    <?php $__empty_1 = true; $__currentLoopData = $ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <option value="<?php echo e($ledger->id); ?>" <?php if($ledger->id==$editData->$name): ?> selected <?php endif; ?> ><?php echo e($ledger->_code ?? ''); ?> <?php echo e($ledger->_name ?? ''); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                    
                </select>
</div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     
<div class="col-xs-12 col-sm-12 col-md-12  text-middle p-4">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> <?php echo e(__('label.save')); ?></button>
                           
                        </div>
     
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script>

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/stm_division_class_students/stm_income_ledger_setups.blade.php ENDPATH**/ ?>