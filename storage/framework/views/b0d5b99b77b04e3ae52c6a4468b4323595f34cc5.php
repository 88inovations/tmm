
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
 <a class="nav-link"  href="<?php echo e(route('stm_collection.index')); ?>" role="button"><i class="fa fa-arrow-left"></i></a>

     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_collection_edit')): ?>
        <a title="Edit" class="nav-link mr-3" href="<?php echo e(route('stm_collection.edit',$data->id)); ?>">
          <i class="nav-icon fas fa-edit"></i>
        </a>
    <?php endif; ?>
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
        <h4 class="text-center"><b> Money Receipt</b></h4>
      </div>
      <!-- /.col -->
      
      
    </div>
    <!-- /.row -->

 

    <div class="row ">
            <div class="col-md-6 col-sm-6 text-left">
              <strong>Receipt No:</strong><?php echo $data->_order_number ?? ''; ?>

            </div>
            <div class="col-md-6 col-sm-6 text-right">
              <strong>Date:</strong> <?php echo _view_date_formate($data->_date ?? date('Y-m-d')); ?>

            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong>Student ID:</strong> <?php echo $data->_student->_student_id ?? ''; ?>

            </div>
            <div class="col-md-6 col-sm-6 text-right">
              <strong>Class:</strong> <?php echo $data->_edu_class->_name ?? ''; ?>

            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong>Student Name:</strong> <?php echo $data->_student->_name_in_english ?? ''; ?>

            </div>
            
            <div class="col-md-6 col-sm-6 text-right">
              <strong>Divssion:</strong> <?php echo $data->_edu_division->_name ?? ''; ?>

            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <strong>Guardian Name:</strong> <?php echo $data->_student->_father_name_english ?? ''; ?>

            </div>
            
            <div class="col-md-6 col-sm-6 text-right">
              <strong>Roll No:</strong> <?php echo $data->_student->_roll_no ?? ''; ?>

            </div>
            
            
            
    </div>

   

    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>SL</th>
          <th>Month</th>
          <th>Description</th>
          <th class="text-right">Amount (৳)</th>
        </tr>
      </thead>
      <tbody>
        <?php
$_detail  = $data->_detail ?? [];
$_collect_ledgers = [];
$_collection_amount_total = 0;
        ?>
        <?php $__empty_1 = true; $__currentLoopData = $_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$d_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

         <?php
$_collection_amount_total += $d_data->_collection_amount ?? 0;
$_collect_ledgers[]= $d_data->_collection_ledger_id ?? 0;
        ?>
      <?php if($d_data->_collection_amount > 0): ?>
        <tr>
          <td><?php echo e(($key+1)); ?></td>
          <td><?php echo _number_to_month($d_data->_month_id ?? 0); ?></td>
          <td><?php echo _fee_lebel($d_data->_bill_type ?? ''); ?></td>
          <td class="text-right"><?php echo _report_amount($d_data->_collection_amount ?? 0); ?></td>
        </tr>
      <?php endif; ?>
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
        <tr>
          <th colspan="3">Total</th>
          <th class="text-right"><?php echo _report_amount($_collection_amount_total); ?></th>
        </tr>
      </tbody>
    </table>

    <p><strong>Amount in Words:</strong> <?php echo e(nv_number_to_text($_collection_amount_total)); ?></p>

    <!-- Payment Mode Section -->
    <div class="mb-4">
      <p><strong>Payment Mode:</strong></p>
      <div class="checkbox-group">
        <?php $__empty_1 = true; $__currentLoopData = $_collect_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <span><input type="checkbox" checked > <?php echo _ledger_name($ledger); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
        
      </div>
    </div>

    <div class="row mt-5 text-center">
      <div class="col-md-6 col-sm-6">
        <p>------------------------</p>
        <p>Guardian Signature</p>
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/stm_collection/show.blade.php ENDPATH**/ ?>