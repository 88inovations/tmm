
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="<?php echo e(url('day-book')); ?>" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b><?php echo e($settings->name ?? ''); ?></b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><?php echo e($settings->_address ?? ''); ?></td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><?php echo e($settings->_phone ?? ''); ?>,<?php echo e($settings->_email ?? ''); ?></td></tr>
         <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 20px;"><b><?php echo e($page_name); ?> </b></td> </tr>
   <tr style="line-height: 16px;" > 
      <td class="text-center" style="border:none;">
    <b><?php echo e(__('label._branch_id')); ?> : <?php echo e(_branch_name($previous_filter["_branch_id"] ?? '')); ?> </b></td>
  </tr>
                 

    <tr style="line-height: 16px;" > 
      <td class="text-center" style="border:none;">
    <b><?php echo e(__('label._cost_center_id')); ?> : <?php echo e(_cost_center_name($previous_filter["_cost_center_id"] ?? '')); ?> </b></td>
  </tr>


                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date: <?php echo e(_view_date_formate($request->_datex ?? '')); ?> To <?php echo e(_view_date_formate($request->_datey ?? '')); ?> </strong></td> </tr>
           
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
           <th style="border:1px solid silver;width: 10%;" class="text-left" >ID</th>
           <th style="border:1px solid silver;width: 20%;" class="text-left" >Group</th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Ledger </th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Narration</th>
            <th style="border:1px solid silver;width: 10%;" class="text-right" >Dr.Amount </th>
            <th style="border:1px solid silver;width: 10%;" class="text-right" >Cr.Amount </th>
          </tr>
          
          
          </thead>
          <tbody>
             <?php $__empty_1 = true; $__currentLoopData = $_result_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
             <tr>
               <td colspan="6"><?php echo e($key); ?></td>
             </tr>
             <?php
              $_sub_total_dr_amount =0;
              $_sub_total_cr_amount =0;
             ?>
             <?php $__empty_2 = true; $__currentLoopData = $detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
             <?php
              $_sub_total_dr_amount +=$value->_dr_amount ?? 0;
              $_sub_total_cr_amount +=$value->_cr_amount ?? 0;
             ?>
             <tr>
              
               <td>
                <?php if($key ==0): ?>
                   
                <?php echo _make_link_for_account($value->_table_name,$value->_id,$value->_voucher_code ?? $value->_id ); ?>




              <?php endif; ?>
                    


               </td>
               
               <td><?php echo e(_group_name($value->_account_group)); ?></td>
               <td><?php echo e(_ledger_name($value->_account_ledger)); ?></td>
               <td><?php echo e($value->_narration ?? 'N/A'); ?></td>
               
               <td class="text-right"><?php echo e(_report_amount(  $value->_dr_amount ?? 0 )); ?></td>
               <td class="text-right"><?php echo e(_report_amount(  $value->_cr_amount ?? 0 )); ?></td>
             </tr>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
             <?php endif; ?>
             <tr>
               <td colspan="4"><b>Sub Total</b></td>
               <td class="text-right"><b><?php echo e(_report_amount(  $_sub_total_dr_amount ?? 0 )); ?></b></td>
               <td class="text-right"><b><?php echo e(_report_amount(  $_sub_total_cr_amount ?? 0 )); ?></b></td>


             </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
           
          
          </tbody>
          
        </table>

      

    
    <!-- /.row -->
  </section>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/account-report/report_day_book.blade.php ENDPATH**/ ?>