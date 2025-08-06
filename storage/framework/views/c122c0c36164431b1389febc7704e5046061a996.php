<?php if($form_settings->_show_due_history==1): ?>
<?php if(sizeof($history_sales_invoices) > 0): ?> 
        <table class=" " style="width: 100%; border-collapse: collapse;">
          <thead style="background:#96d896;">
            <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;">Date</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Invoice No.</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Sales Amount</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Pending Amount</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">O/D By Days</td>
            </tr>
          </thead>
         
            <?php
            $due_sales_amount=0;
            $due_due_amount =0;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $history_sales_invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $his_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
            $due_sales_amount +=$his_val->_total ?? 0;
            $due_due_amount +=$his_val->_due_amount ?? 0;
            ?>
              <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;"><?php echo e(_view_date_formate($his_val->_date ?? '')); ?></td>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;padding-right:5px;z"><?php echo e($his_val->_order_number ?? ''); ?></td>
              <td style="border:1px solid #000;text-align: right;font-size: 10px;white-space: nowrap;padding-right:5px;"><?php echo e(_report_amount($his_val->_total ?? 0)); ?></td>
              <td style="border:1px solid #000;text-align: right;font-size: 10px;white-space: nowrap;padding-right:5px;"><?php echo e(_report_amount($his_val->_due_amount ?? 0)); ?></td>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;color:red;font-weight:bold;">
                  <?php
                  $diff_days = _date_diff($his_val->_date,date('Y-m-d'));
                   $_days = $data->_terms_con->_days ?? 0;
                  ?>
                  <?php if($diff_days > $_days): ?> 
                  <?php echo e(($diff_days-$_days)); ?> Days
                  <?php endif; ?>
                  
                  </td>
              
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
         
          
            <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;" colspan="2"><b>Total</b></td>
              <td style="border:1px solid #000;text-align: right;font-size: 12px;white-space: nowrap;"><b><?php echo e(_report_amount($due_sales_amount ?? 0)); ?></b></td>
              <td style="border:1px solid #000;text-align: right;font-size: 12px;white-space: nowrap;"><b><?php echo e(_report_amount($due_due_amount ?? 0)); ?></b></td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;"></td>
            </tr>
          
        </table>

<?php endif; ?>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/sales/invoice_history.blade.php ENDPATH**/ ?>