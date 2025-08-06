

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
    <a class="nav-link"  href="<?php echo e(url('ledger-report')); ?>" role="button"><i class="fas fa-search"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->
    
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <h2 class="page-header">
            <?php echo e($settings->name ?? ''); ?>

          <small class="float-right"></small>
        </h2>
        <address>
          <strong><?php echo e($settings->_address ?? ''); ?></strong><br>
          <?php echo e($settings->_phone ?? ''); ?><br>
          <?php echo e($settings->_email ?? ''); ?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
      <div class="invoice-col" style="width:100%;white-spcae:nowrap;">
        <h3 class="text-center" style="font-size:24px;"><b><?php echo _ledger_name($ledger_id_rows); ?></b> </h3>
        </div>
        <?php
        $_alious = $ledger_info->_alious ?? '';
        ?>
        <?php if($_alious !=''): ?>
       <h5 class="text-center">Proprietor: <?php echo e($ledger_info->_alious ?? ''); ?></h5> 
        <?php endif; ?>
        <h5 class="text-center"><small>Date: <?php echo e(_view_date_formate($request->_datex ?? '')); ?> To <?php echo e(_view_date_formate($request->_datey ?? '')); ?></small></h5>
          <h5 class="text-center"><b>Ledger Report</b></h5>
          <h6 class="text-center"> <?php echo e(__('label._branch_id')); ?> : <?php echo e(_branch_name($previous_filter["_branch_id"] ?? '')); ?> </h6>
          <h6 class="text-center">  <?php echo e(__('label._cost_center_id')); ?> : <?php echo e(_cost_center_name($previous_filter["_cost_center_id"] ?? '')); ?> </h6>

      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
        <b>Group Name: <?php echo $ledger_info->account_group->_name ?? ''; ?> </b><br>
        <b>Address: <?php echo e($ledger_info->_address ?? ''); ?></b><br>
        
        <b>Phone:</b> <?php echo e($ledger_info->_phone ?? ''); ?><br>
        <b>Email:</b> <?php echo e($ledger_info->_email ?? ''); ?><br>
       
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <table class="cewReportTable">
          <thead>
          <tr>
            <?php
            $colspan=4;
            $_less=0;
            $grand_colspan =1;
             
            ?>
            <th style="width: 8%;border:1px solid silver;">Date</th>
            <?php if(isset($previous_filter['_check_id'])): ?>
            <?php
            $colspan +=1;
            $grand_colspan +=1;
            ?>
            <th style="width: 8%;border:1px solid silver;">ID</th>
            <?php else: ?>
            
            <?php endif; ?>

            <?php if(isset($previous_filter['short_naration'])): ?>
            <th style="width: 20%;border:1px solid silver;">Short Narration</th>
            <?php
            $colspan +=1;
            $grand_colspan +=1;
            ?>
           <?php else: ?>
            
            <?php endif; ?>
            <?php if(isset($previous_filter['naration'])): ?>
            <th style="width: 20%;border:1px solid silver;">Narration</th>
            <?php
            $colspan +=1;
            $grand_colspan +=1;
            ?>
            <?php else: ?>
            
            <?php endif; ?>
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Dr. Amount</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right" >Cr. Amount</th>
            <th style="width: 15%;border:1px solid silver;" class="text-right" >Balance</th>
          </tr>
          
          
          </thead>
          <tbody>
            <?php
            $_dr_grand_total = 0;
            $_cr_grand_total = 0;
            $_total_balance = 0;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $group_array_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              
                
            </tr>
                <?php $__empty_2 = true; $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l_key=>$l_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>

               
                  <?php
                    $running_sub_dr_total=0;
                    $running_sub_cr_total=0;
                    $runing_balance_total = 0;
                  ?>
                  <?php $__empty_3 = true; $__currentLoopData = $l_val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_dkey=>$detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                  <?php
                    $_dr_grand_total +=$detail->_dr_amount ?? 0;
                    $_cr_grand_total +=$detail->_cr_amount ?? 0;
                    $running_sub_dr_total +=$detail->_dr_amount ?? 0;
                    $running_sub_cr_total +=$detail->_cr_amount ?? 0;
                    $runing_balance_total += (($detail->_balance+$detail->_dr_amount)-$detail->_cr_amount);
                    $_total_balance += (($detail->_balance+$detail->_dr_amount)-$detail->_cr_amount);
                  ?>
                  
                    <tr>
                    <td style="width: 8%;text-align: left;">
                      
                      <?php echo e(_view_date_formate($detail->_date ?? $_datex)); ?> </td>
                       <?php if(isset($previous_filter['_check_id'])): ?>
                 <td class="text-left" style="width: 7%;white-space: nowrap;">
                     <?php echo _make_link_for_account($detail->_table_name,$detail->_id,$detail->_voucher_code ?? $detail->_id ); ?>

                    
             </td>
             <?php endif; ?>
             
             <?php if(isset($previous_filter['short_naration'])): ?>
                    <td style="text-align: left;width: 20%;"><?php echo e($detail->_short_narration ?? ''); ?> </td>
              <?php endif; ?>
             <?php if(isset($previous_filter['naration'])): ?>
                    <td style="text-align: left;width: 20%;"><?php echo e($detail->_narration ?? ''); ?> </td>
            <?php endif; ?>
                    <td style="text-align: right;width: 10%;"><?php echo e(_report_amount($detail->_dr_amount ?? 0)); ?> </td>
                    <td style="text-align: right;width: 10%;"><?php echo e(_report_amount($detail->_cr_amount ?? 0)); ?> </td>
                    <td style="text-align: right;width: 15%;"><?php echo e(_show_amount_dr_cr(_report_amount(  $runing_balance_total ))); ?> </td>

                  </tr>

                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                  <?php endif; ?>

                 
                

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <?php endif; ?>



              
            <tr>
                 <td colspan="<?php echo e($colspan); ?>"></td>
            </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
            <tr>
              
                <td colspan="<?php echo e(($grand_colspan)); ?>" style="text-align: left;background: #f5f9f9;"><b>Grand Total </b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b><?php echo e(_report_amount($_dr_grand_total)); ?></b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b><?php echo e(_report_amount($_cr_grand_total)); ?></b> </td>
                <td style="text-align: right;background: #f5f9f9;"> <b><?php echo e(_show_amount_dr_cr(_report_amount($_total_balance))); ?></b> </td>
            </tr>
          
          </tbody>
          <tfoot>
            <tr>
              <td colspan="<?php echo e($colspan); ?>">
                 <?php echo $__env->make('backend.message.invoice_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </td>
            </tr>
          </tfoot>
        </table>
     

  
    <!-- /.row -->
  </section>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script type="text/javascript">

 function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


        }
         

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/account-report/ledger_show.blade.php ENDPATH**/ ?>