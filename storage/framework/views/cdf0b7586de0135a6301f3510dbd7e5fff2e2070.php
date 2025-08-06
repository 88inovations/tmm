
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($page_name); ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/adminlte.min.css')); ?>">
  <style type="text/css">
    .table td, .table th {
        padding: .15rem !important;
        vertical-align: top;
        border-top: 1px solid #CCCCCC;
    }
  </style>
</head>
<body>
<div class="wrapper">

<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
       
        <div style="text-align: center;">
       <h3> <?php echo e($settings->name ?? ''); ?> </h3>
       <div><?php echo e($settings->_address ?? ''); ?></br>
       <?php echo e($settings->_phone ?? ''); ?></div>
       <h3><?php echo e($page_name); ?></h3>

      </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
   
  
<div class="table-responsive">
   <table class="table table-bordered _list_table">
                     <thead>
                       <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b><?php echo e(__('label.id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._admission_date')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._admission_session_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._education_type')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._admission_class_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._student_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._proximity_card_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._name_in_english')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._f_mobile_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._mother_mobile_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._local_guardian_mobile')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._status')); ?></b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <tr>
                            <td style="white-space: nowrap;"><?php echo e(($key+1)); ?></td>
                            <td style="white-space: nowrap;"><?php echo e($data->id); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e(_view_date_formate($data->_admission_date ?? '')); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_edu_session->_name ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_edu_division->_name ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_edu_class->_name ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_student_id ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_proximity_card_no ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_name_in_english ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_f_mobile_no ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_mother_mobile_no ?? ''); ?></td>
                            <td  style="white-space: nowrap;"><?php echo e($data->_local_guardian_mobile ?? ''); ?></td>
                           <td  style="white-space: nowrap;"><?php echo e(selected_status($data->_status)); ?></td>
                           
                        </tr>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        

                        </tbody>
                    </table>
                </div>
    
    <!-- /.row -->

    <div class="row">
      
      <!-- /.col -->
      <div class="col-12 mt-5">
        <div class="row">
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Received By</span></div>
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Prepared By</span></div>
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Checked By</span></div>
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;"> Approved By</span></div>
        </div>

          
       
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/stm_students/print.blade.php ENDPATH**/ ?>