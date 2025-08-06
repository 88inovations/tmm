<select class="_student_id form-control  select2" name="_student_id">
    <option value="">Select Student</option>
    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <option value="<?php echo e($student->id); ?>"><?php echo $student->_name_in_bangla ?? ''; ?>  |<?php echo $student->_name_in_english ?? ''; ?>  | <?php echo $student->_student_id ?? ''; ?> | <?php echo $student->_father_name_english ?? ''; ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
</select>


<script type="text/javascript">
     $(document).find('.select2').select2()
</script><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/stm_students/select_option_student.blade.php ENDPATH**/ ?>