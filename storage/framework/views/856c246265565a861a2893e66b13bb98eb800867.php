
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
    <a class="nav-link"  href="<?php echo e(url('bank-book')); ?>" role="button">
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
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b><?php echo e($page_name); ?> </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date: <?php echo e(_view_date_formate($request->_datex ?? '')); ?> To <?php echo e(_view_date_formate($request->_datey ?? '')); ?> </strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                   <?php echo e(__('label._branch_id')); ?> : <?php echo e(_branch_name($previous_filter["_branch_id"] ?? '')); ?>

                  <br>
                   <?php echo e(__('label._cost_center_id')); ?> : <?php echo e(_cost_center_name($previous_filter["_cost_center_id"] ?? '')); ?></td> </tr>
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
            <th style="border:1px solid silver;width: 7%;" class="text-left" >Date</th>
            <th style="border:1px solid silver;width: 7%;" class="text-left" >ID</th>
            <th style="border:1px solid silver;width: 30%;" class="text-left" >Ledger </th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Referance</th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Narration</th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Receipt </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Payment </th>
          </tr>
          
          
          </thead>
          <tbody>
              <?php
              $_grand_total_dr_amount = 0;
              $_grand_total_cr_amount = 0;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $_result_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td colspan="7"><b><?php echo e($key); ?></b></td>
            </tr>
            <?php
              $_ledger_group_dr_amount = 0;
              $_ledger_group_cr_amount = 0;
            ?>
            <?php $__empty_2 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
             <?php
              $_ledger_group_dr_amount += $value->_dr_amount ?? 0;
              $_ledger_group_cr_amount +=  $value->_cr_amount ?? 0;

             
            ?>
            <tr>
              <?php if($key=="A. Opening Bank"): ?>
              <td><?php echo e(_view_date_formate($request->_datex ?? '')); ?></td>
              <?php endif; ?>
              <?php if($key=="B. Receipt & Payment"): ?>
              <td><?php echo e(_view_date_formate($value->_date ?? '')); ?></td>
              <?php endif; ?>
              <?php if($key=="C. Closing Bank"): ?>
              <td><?php echo e(_view_date_formate($request->_datey ?? '')); ?></td>
              <?php endif; ?>
              <td>
                <?php if($value->_table_name=="voucher_masters"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(route('voucher.show',$value->_id)); ?>">
                <?php echo e(voucher_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="purchases"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('purchase/print',$value->_id)); ?>">
                  <?php echo e(_purchase_pfix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="purchase_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('purchase/print',$value->_id)); ?>">
                  <?php echo e(_purchase_pfix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="purchases_return"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('purchase-return/print',$value->_id)); ?>">
                  <?php echo e(_purchase_return_pfix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="purchase_return_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('purchase-return/print',$value->_id)); ?>">
                  <?php echo e(_purchase_return_pfix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="sales"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('sales/print',$value->_id)); ?>">
                  <?php echo e(_sales_pfix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="sales_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('sales/print',$value->_id)); ?>">
                  <?php echo e(_sales_pfix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="warranty_masters"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('warranty-manage/print',$value->_id)); ?>">
                  <?php echo e(warranty_prefix()); ?> <?php echo $value->_id ?? ''; ?></a> <br>
                    <?php endif; ?>

                    <?php if($value->_table_name=="warranty_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('warranty-manage/print',$value->_id)); ?>">
                   <?php echo e(warranty_prefix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="resturant_sales"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('restaurant-sales/print',$value->_id)); ?>">
                  <?php echo e(resturant_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="restaurant_sales_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('restaurant-sales/print',$value->_id)); ?>">
                  <?php echo e(resturant_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="resturant_sales_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('restaurant-sales/print',$value->_id)); ?>">
                 <?php echo e(resturant_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="sales_return"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('sales-return/print',$value->_id)); ?>">
                  <?php echo e(_sales_return_pfix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="sales_return_accounts"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('sales-return/print',$value->_id)); ?>">
                  <?php echo e(_sales_return_pfix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="damage"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('damage/print',$value->_id)); ?>">
                  <?php echo e(_damage_pfix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>

                <?php if($value->_table_name=="transfer"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('transfer-production/print',$value->_id)); ?>">
                  <?php echo e(_transfer_prefix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                    <?php if($value->_table_name=="production"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('transfer-production/print',$value->_id)); ?>">
                  <?php echo e(production_prefix()); ?> <?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>

                    <?php if($value->_table_name=="replacement_masters"): ?>
                       <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('item-replace/print',$value->_id)); ?>">
                       <?php echo e(_replace_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                   <?php endif; ?>
                   <?php if($value->_table_name=="replacement_item_accounts"): ?>
                       <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('item-replace/print',$value->_id)); ?>">
                        <?php echo e(_replace_prefix()); ?> <?php echo $value->_id ?? ''; ?></a>
                   <?php endif; ?>

                   <?php if($value->_table_name=="warranty_masters"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('warranty-manage/print',$value->_id)); ?>">
                  <?php echo e(warranty_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                   <?php if($value->_table_name=="service_masters"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('third-party-service/print',$value->_id)); ?>">
                  <?php echo e(service_prefix()); ?><?php echo $value->_id ?? ''; ?></a>
                    <?php endif; ?>
                   <?php if($value->_table_name=="individual_replace_masters"): ?>
                 <a style="text-decoration: none;" target="__blank" href="<?php echo e(url('individual-replacement-print',$detail->_id)); ?>">
                  <?php echo e(ind_rep_prefix()); ?><?php echo $detail->_id ?? ''; ?></a>
                    <?php endif; ?>
                   
              </td>
 <?php if($key=="B. Receipt & Payment"): ?>
              <td>
               <?php 
              $ledgers=  _oposite_account($value->_id,$value->_table_name,$value->_account_ledger);
              foreach($ledgers as $key_s=> $l){
                echo $l->_name;
                echo "<br/>";
              }
              ?>
              </td>
  <?php else: ?>
<td><?php echo e($value->_l_name ?? ''); ?></td>
  <?php endif; ?>

              <td><?php echo e($value->_reference ?? ''); ?></td>
              <td><?php echo e($value->_short_narration ?? ''); ?></td>
              <td class="text-right"><?php echo e(_report_amount(  $value->_dr_amount ?? 0 )); ?></td>
              <td class="text-right"><?php echo e(_report_amount(  $value->_cr_amount ?? 0 )); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
            <?php endif; ?>
            <tr>
              <td colspan="5"><b>Summary of <?php echo e($key); ?></b></td>
              <td class="text-right"><b><?php echo e(_report_amount(  $_ledger_group_dr_amount )); ?></b></td>
              <td class="text-right"><b><?php echo e(_report_amount(  $_ledger_group_cr_amount )); ?></b></td>
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

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/account-report/report_bank_book.blade.php ENDPATH**/ ?>