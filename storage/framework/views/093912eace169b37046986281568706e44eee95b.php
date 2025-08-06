

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
      <div class="col-sm-12 invoice-col text-center">
        <h2 class="page-header">
            <?php echo e($settings->name ?? ''); ?>

          
        </h2>
        <address>
          <strong><?php echo e($settings->_address ?? ''); ?></strong><br>
          <?php echo e($settings->_phone ?? ''); ?><br>
          <?php echo e($settings->_email ?? ''); ?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-12 invoice-col text-center">
        <h3 class="text-center"><b><?php echo e($page_name ?? ''); ?></b></h3>
      </div>
      <!-- /.col -->
      
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <table class="cewReportTable" >
          <thead>
          <tr>
            <td>&emsp;&emsp;&emsp;&emsp;<b>Title</b></th>
          </tr>
          <tbody>
            <?php
            $data_level_one = \DB::table('main_account_head')->orderBy('id','ASC')->get();
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $data_level_one; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;<b> <?php echo $value->id ?? ''; ?>. <?php echo $value->_name ?? ''; ?></b></td>
            </tr>
             <?php
            $data_level_twos = \DB::table('account_heads')->where('_account_id',$value->id)->where('_parent_id',0)->orderBy('_name','ASC')->get();
            ?>
            <?php $__empty_2 = true; $__currentLoopData = $data_level_twos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_type_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
            <tr>
             
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b><?php echo $_type_value->_code ?? ''; ?>. <?php echo $_type_value->_name ?? ''; ?></b></td>
            </tr>
            <?php if($_type_value->_has_child ==1): ?><!-- Has Child -->
            <?php
            $data_level_threes = \DB::table('account_heads')->where('_parent_id',$_type_value->id)->orderBy('_name','ASC')->get();
            ?>

            <?php $__empty_3 = true; $__currentLoopData = $data_level_threes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b><?php echo $_group_value->_code ?? ''; ?>. <?php echo $_group_value->_name ?? ''; ?></b>
              </td>
            </tr>
<?php
            $data_level_fours = \DB::table('account_groups')->where('_account_head_id',$_group_value->id)->orderBy('_name','ASC')->get();
            ?>
<?php $__empty_4 = true; $__currentLoopData = $data_level_fours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_fours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_4 = false; ?>
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $_fours->_code ?? ''; ?>. <?php echo $_fours->_name ?? ''; ?>

              </td>
            </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_4): ?>
<?php endif; ?>            

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
            <?php endif; ?>

            <?php else: ?>
<?php
            $data_level_fours = \DB::table('account_groups')->where('_account_head_id',$_type_value->id)->orderBy('_name','ASC')->get();
            ?>
<?php $__empty_3 = true; $__currentLoopData = $data_level_fours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_fours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $_fours->_code ?? ''; ?>. <?php echo $_fours->_name ?? ''; ?>

              </td>
            </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
<?php endif; ?>

            <?php endif; ?> <!-- ENd Has Child -->


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
            <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
          </tbody>
          <tfoot>
           
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/account-report/chart-of-account.blade.php ENDPATH**/ ?>