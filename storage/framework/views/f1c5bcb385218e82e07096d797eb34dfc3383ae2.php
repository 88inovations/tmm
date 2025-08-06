

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>


<section class="invoice p-2" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;"><b><?php echo e($settings->name ?? ''); ?></b><br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> <?php echo e($settings->keywords ?? ''); ?></div>
                </td> </tr>
                
              <?php
              $sequence_to_remove = "––------------–--";
              ?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><?php echo e($settings->_address ?? ''); ?></td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><?php echo e(str_replace($sequence_to_remove, "", $settings->_email ?? '')); ?><br><?php echo e($settings->_phone ?? ''); ?></td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <h3><?php echo $page_name ?? ''; ?></h3>
              </td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  Date & Time: <?php echo e(date('d-m-Y H:s a')); ?>

              </td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
        
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space"><?php echo e(__('label.sl')); ?></td>
            <td style="width:15%;"class="white_space"><?php echo e(__('label._date')); ?></td>
            <td style="width:15%;"class="white_space"><?php echo e(__('label._order_number')); ?></td>
            <td style="width:15%;"class="white_space"><?php echo e(__('label._bill_type')); ?></td>
            <td style="width:15%;"class="white_space"><?php echo e(__('label._type')); ?></td>
            <td style="width:15%;" class="white_space"><?php echo e(__('label._name_in_bangla')); ?></td>
            <td style="width:15%;" class="white_space"><?php echo e(__('label._total_bill')); ?></td>
            <td style="width:15%;" class="white_space"><?php echo e(__('label._concession')); ?></td>
            <td style="width:15%;" class="white_space"><?php echo e(__('label._receive_amount')); ?></td>
            <td style="width:15%;" class="white_space"><?php echo e(__('label._balance')); ?></td>
          </tr>
          
         
          </thead>
          <tbody>
<?php
$_total__fee_amount=0;
$_total__discount_amount=0;
$_total__receive_amount=0;
$_total__due_amount=0;
$_sl = 1;
?>
<?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d_key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<?php
$_total__fee_amount  +=$data->_fee_amount ?? 0;
$_total__discount_amount  +=$data->_discount_amount ?? 0;
$_total__receive_amount  +=$data->_receive_amount ?? 0;
$_total__due_amount  +=(($data->_fee_amount ?? 0)-(($data->_discount_amount ?? 0)+($data->_receive_amount ?? 0)));
?>
        <tr>
            <td class="white_space"><?php echo e(($_sl++)); ?></td>
            <td class="white_space"><?php echo _view_date_formate($data->_date ?? ''); ?> </td>
            <td class="white_space"><?php echo $data->_order_number ?? ''; ?> </td>
            <?php
$_bill_type = str_replace('_', ' ', ltrim($data->_bill_type ?? '', '_'));

// Capitalize the first letter of each word
$_bill_type = ucwords($_bill_type);
            ?>

            <td class="white_space"><?php echo $_bill_type ?? ''; ?> </td>
            <td class="white_space"><?php echo $data->_type ?? ''; ?> </td>
            <td class="white_space"><?php echo $data->_name_in_bangla ?? ''; ?> </td>
            

            <td class="white_space"><?php echo _report_amount($data->_fee_amount ?? 0); ?></td>
            <td class="white_space"><?php echo _report_amount($data->_discount_amount ?? 0); ?></td>
            <td class="white_space"><?php echo _report_amount($data->_receive_amount ?? 0); ?></td>
            <td class="white_space"><?php echo _report_amount($_total__due_amount); ?></td>
          </tr>
  
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>
<tr>
  <tr>
            <th colspan="6" class="white_space">Total Amount</th>
            <th class="white_space"><?php echo _report_amount($_total__fee_amount ?? 0); ?></th>
            <th class="white_space"><?php echo _report_amount($_total__discount_amount ?? 0); ?></th>
            <th class="white_space"><?php echo _report_amount($_total__receive_amount ?? 0); ?></th>
            <th class="white_space"><?php echo _report_amount($_total__due_amount ?? 0); ?></th>
          </tr>
</tr>
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="10" style="border: none;">
                 <?php echo $__env->make('backend.message.invoice_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/report/student_ledger_report_data.blade.php ENDPATH**/ ?>