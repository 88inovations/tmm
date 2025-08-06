

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
                <th>SL</th>
                <th>Division</th>
                <th>Class</th>
                <th>Name</th>
                <th><?php echo e(__('label._name_in_english')); ?></th>
                <th>Roll</th>
                <?php for($i = 1; $i <= 12; $i++): ?>
                    <th><?php echo e(strtoupper(DateTime::createFromFormat('!m', $i)->format('M'))); ?></th>
                <?php endfor; ?>
                <th>Total</th>
            </tr>
    </thead>
    <tbody>
            <?php
            $sl=1;
                $monthTotals = array_fill(1, 12, 0);
                $grandTotal = 0;
            ?>

            <?php $__empty_1 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($sl++); ?></td>
                    <td><?php echo e($row['division']); ?></td>
                    <td><?php echo e($row['class']); ?></td>
                    <td><?php echo e($row['name']); ?></td>
                    <td><?php echo e($row['_name_in_english']); ?></td>
                    <td><?php echo e($row['roll']); ?></td>
                    <?php for($i = 1; $i <= 12; $i++): ?>
                        <?php
                            $monthTotals[$i] += $row['monthly'][$i];
                        ?>
                        <td><?php echo e($row['monthly'][$i] > 0 ? _report_amount($row['monthly'][$i]) : ''); ?></td>
                    <?php endfor; ?>
                    <td>
                        <?php $grandTotal += $row['total']; ?>
                        <?php echo e(_report_amount($row['total'])); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>

            
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="6" style="text-align:right">Total</td>
                <?php for($i = 1; $i <= 12; $i++): ?>
                    <td><?php echo e(_report_amount($monthTotals[$i])); ?></td>
                <?php endfor; ?>
                <td><?php echo e(_report_amount($grandTotal)); ?></td>
            </tr>
        </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="17" style="border: none;">
                 <?php echo $__env->make('backend.message.invoice_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/report/month_wise_payment_status_list.blade.php ENDPATH**/ ?>