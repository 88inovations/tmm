
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<style type="text/css">
 
  @media  print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
 <a class="nav-link"  href="<?php echo e(route('stm_bill_masters.index')); ?>" role="button"><i class="fa fa-arrow-left"></i></a>

    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </div>

<section class="invoice" id="printablediv">
 
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col text-center">
        <?php echo e($settings->_top_title ?? ''); ?>

        <h2 class="page-header">
           <img src="<?php echo e(asset($settings->logo ?? '')); ?>" alt="<?php echo e($settings->name ?? ''); ?>"  style="width: 120px;height:auto;"> <?php echo e($settings->name ?? ''); ?>

          
        </h2>
        <address>
          <strong><?php echo e($settings->_address ?? ''); ?></strong><br>
          <?php echo e($settings->_phone ?? ''); ?><br>
          <?php echo e($settings->_email ?? ''); ?><br>
        </address>
        <h4 class="text-center"><b> <?php echo e(_fee_lebel($data->_bill_type ?? '')); ?> Slip</b></h4>
      </div>
      <!-- /.col -->
      
      
    </div>
    <!-- /.row -->

 

    <div class="row ">
            <div class="col-md-6 col-sm-6 text-left">
              <strong>Bill No:</strong><?php echo $data->_order_number ?? ''; ?>

            </div>
            <div class="col-md-6 col-sm-6 text-right">
              <strong>Date:</strong> <?php echo _view_date_formate($data->_date ?? date('Y-m-d')); ?>

            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong><?php echo e(__('label._class_id')); ?>:</strong> <?php echo $data->_edu_class->_name ?? ''; ?>

            </div>
            
            <div class="col-md-6 col-sm-6 text-right">
              <strong><?php echo e(__('label._month_id')); ?>:</strong> <?php echo _number_to_month($data->_month_id ?? ''); ?>

            </div>

          
            <div class="col-md-6 col-sm-6 text-left">
              <strong><?php echo e(__('label._session_id')); ?>:</strong> <?php echo $data->_edu_session->_name ?? ''; ?>

            </div>
              <div class="col-md-6 col-sm-6 text-right">
              <strong><?php echo e(__('label._year')); ?>:</strong> <?php echo $data->_year ?? ''; ?>

            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong><?php echo e(__('label._stm_division_id')); ?>:</strong> <?php echo $data->_edu_division->_name ?? ''; ?>

            </div>
            
           
            
            
            
    </div>

   

    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>SL</th>
          <th>Student ID</th>
          <th>Student Name</th>
          <th>Roll No</th>
          <th>Father Name</th>
          <th class="text-right">Amount (৳)</th>
        </tr>
      </thead>
      <tbody>
        <?php
$_detail  = $data->_detail ?? [];

$_total_bill_amount = 0;
        ?>
        <?php $__empty_1 = true; $__currentLoopData = $_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $d_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

         <?php
$_total_bill_amount += $d_data->_net_fee_amount ?? 0;
        ?>
        <tr>
          <td><?php echo e(($key+1)); ?></td>
          <td><?php echo $d_data->_student->_student_id ?? ''; ?></td>
          <td><?php echo $d_data->_student->_name_in_english ?? ''; ?></td>
          <td><?php echo $d_data->_student->_roll_no ?? ''; ?></td>
          <td><?php echo $d_data->_student->_father_name_english ?? ''; ?></td>
          <td class="text-right"><?php echo _report_amount($d_data->_net_fee_amount ?? 0); ?></td>
        </tr>
        
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
        <tr>
          <th colspan="5">Total</th>
          <th class="text-right"><?php echo _report_amount($_total_bill_amount); ?></th>
        </tr>
      </tbody>
    </table>

    <p><strong>Amount in Words:</strong> <?php echo e(nv_number_to_text($_total_bill_amount)); ?></p>

   

    <div class="row mt-5 text-center">
      <div class="col-md-6 col-sm-6">
        <p>------------------------</p>
        <p>Prepared By</p>
      </div>
      <div class="col-md-6 col-sm-6 text-end">
        <p>------------------------</p>
        <p>Authorized Signature</p>
      </div>
    </div>

    <div class="text-center mt-3">
      <small>This is a computer-generated receipt and does not require a physical signature.</small>
    </div>
  
    <!-- /.row -->
  </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/stm_bill_masters/show.blade.php ENDPATH**/ ?>