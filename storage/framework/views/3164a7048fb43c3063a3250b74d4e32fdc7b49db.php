

<?php $__env->startSection('content'); ?>
<div class="content">
<div class="container-fluid">
    <h4>Class-wise Student Attendance Report</h4>

    <form method="GET" action="">
        <div class="row">
            <div class="col-md-3">
                <label>Date:</label>
                <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>" required>
            </div>
            <div class="col-md-3">
                <label>Division:</label>
                <select name="division_id" class="form-control" required>
                    <option value="">Select Division</option>
                    <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($division->id); ?>" <?php echo e(request('division_id') == $division->id ? 'selected' : ''); ?>>
                            <?php echo e($division->_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Class:</label>
                <select name="class_id" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($class->id); ?>" <?php echo e(request('class_id') == $class->id ? 'selected' : ''); ?>>
                            <?php echo e($class->_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2 mt-4">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <?php if(!empty($reports) && count($reports) > 0): ?>
        
        <div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

        <div id="printablediv">
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Student Roll</th>
                    <th>Name</th>
                    <th>Division</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($r->student_roll); ?></td>
                        <td><?php echo e($r->student_name); ?></td>
                        <td><?php echo e($r->division_name); ?></td>
                        <td><?php echo e($r->class_name); ?></td>
                        <td><?php echo e($r->date ? \Carbon\Carbon::parse($r->date)->format('Y-m-d') : ''); ?></td>
                        <td><?php echo e($r->in_time); ?></td>
                        <td><?php echo e($r->out_time); ?></td>
                        <td><?php echo e($r->remarks); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php elseif(request()->filled('date') && request()->filled('class_id')): ?>
        <div class="alert alert-warning mt-4">No attendance records found for this date & class.</div>
    <?php endif; ?>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/stm/report/datewiseattendance.blade.php ENDPATH**/ ?>