<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <style>
    /* Add this CSS to ensure vertical alignment */
    .table tbody td {
        vertical-align: top !important;
    }
    
    /* For the month cell specifically */
    .month-header-cell {
        vertical-align: top;
        padding-top: 12px; /* Adjust as needed */
    }
</style>
  <div class="_report_button_header">
    <a class="nav-link"  href="<?php echo e(url('report-panel')); ?>" role="button">
          <i class="fas fa-search"></i>
        </a>
  <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b><?php echo e($settings->name ?? ''); ?></b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><?php echo e($settings->_address ?? ''); ?></td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><?php echo e($settings->_phone ?? ''); ?>,<?php echo e($settings->_email ?? ''); ?></td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b><?php echo e($page_name); ?> </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><strong>Date:<?php echo e($previous_filter["_datex"] ?? ''); ?> To <?php echo e($previous_filter["_datey"] ?? ''); ?></strong></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                   <?php echo e(__('label._branch_id')); ?> : <?php echo e(_branch_name($previous_filter["_branch_id"] ?? '')); ?>

                  <br>
                   <?php echo e(__('label._cost_center_id')); ?> : <?php echo e(_cost_center_name($previous_filter["_cost_center_id"] ?? '')); ?></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
        </div>
      </div>

    <!-- Table row -->
     <table class="cewReportTable">
          <tbody>

            <tr>
              <td style="vertical-align: top !important;">
                <table class="table">
                 
                  <thead>
                    <tr>
                      <td colspan="3" class="text-center"><h3>Income</h3></td>
                    </tr>
                    <tr>
                      <th>Code</th>
                      <th>Ledger</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$total_income = 0;
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $income_8; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$incomes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                      <td colspan="3"><?php echo $key ?? ''; ?></td>
                    </tr>
                      <?php $__empty_2 = true; $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                          <?php
$total_income += $income->_current_balance ?? 0;
                    ?>
                        <tr>
                          
                            <td><?php echo $income->_code ?? ''; ?></td>
                            <td><?php echo $income->_l_name ?? ''; ?></td>
                            <td><?php echo _report_amount($income->_current_balance ?? 0); ?></td>
                            
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                     <tr>
                          
                            <th colspan="2">Total Income</th>
                            <th><?php echo _report_amount($total_income ?? 0); ?></th>
                            
                        </tr>
                  </tfoot>
                 
                </table>
              </td>
              <td style="vertical-align: top !important;">
                <table class="table">

                  <thead>
                    <tr>
                      <td colspan="3" class="text-center"><h3>Expenses</h3></td>
                    </tr>
                    <tr>
                       
                      <th>Code</th>
                      <th>Ledger</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$total_expense = 0;
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $other_income_expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$expenses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                      <td colspan="3"><?php echo $key ?? ''; ?></td>
                    </tr>
                      <?php $__empty_2 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                          <?php
$total_expense += -($expense->_current_balance ?? 0);
                    ?>
                        <tr>
                          
                            <td><?php echo $expense->_code ?? ''; ?></td>
                            <td><?php echo $expense->_l_name ?? ''; ?></td>
                            <td><?php echo _report_amount(-$expense->_current_balance ?? 0); ?></td>
                            
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                     <tr>
                          
                            <th colspan="2">Total expense</th>
                            <th><?php echo _report_amount($total_expense ?? 0); ?></th>
                            
                        </tr>
                  </tfoot>
                 
                </table>
              </td>
            </tr>

            <tr>
              <th><b>Balance Income & Expneses</b></th>
              <th><b><?php echo _report_amount($total_income-$total_expense); ?></b></th>
            </tr>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                <div class="row">
                   <?php echo $__env->make('backend.message.invoice_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
     


    <!-- /.row -->
  </section>

</div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/reports/income_report_2.blade.php ENDPATH**/ ?>