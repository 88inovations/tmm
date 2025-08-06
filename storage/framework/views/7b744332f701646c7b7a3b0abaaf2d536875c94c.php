
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>

    <div class="message-area">
     <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                     <h4><a  href="<?php echo e(route('voucher.index')); ?>"> <?php echo $page_name ?? ''; ?> </a>  
                      <?php echo $__env->make('backend.message.voucher-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      </h4>
                  </div>
                  <div class="col-md-6">
                   <div class="d-flex right" style="float: right;">
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-create')): ?>
                        <a title="Add New" class="btn  btn-sm btn-success  mr-3" href="<?php echo e(route('voucher.create')); ?>"> <i class="nav-icon fa fa-plus"></i> </a>
                      <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-edit')): ?>
                                    <a title="Edit" class="btn  btn-default  mr-3" href="<?php echo e(route('voucher.edit',$data->id)); ?>">
                                      <i class="nav-icon fas fa-edit"></i>
                                    </a>
                      <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-print')): ?>
                         <a style="cursor: pointer;" class="btn btn-sm btn-danger mr-3"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="nav-icon fas fa-print"></i></a>
     
                      <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-list')): ?>
                       <a class="btn btn-sm btn-primary" title="List" href="<?php echo e(route('voucher.index')); ?>"> <i class="nav-icon fa fa-th-list" aria-hidden="true"></i></a>
                       <?php endif; ?>
                    </div>
                   
                  </div>
                </div>
             </div>
              <div class="card-body">
                <div class="wrapper">
  <!-- Main content -->
<section class="invoice" id="printablediv">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
           <img src="<?php echo e(asset('/')); ?><?php echo e($settings->logo ?? ''); ?>" alt="<?php echo e($settings->name ?? ''); ?>"  style="width: 60px;height: 60px;"> <?php echo e($settings->name ?? ''); ?>

          <small class="float-right">Date: <?php echo e(_view_date_formate($data->_date ?? '')); ?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        
        <address>
          <strong><?php echo e($settings->_address ?? ''); ?></strong><br>
          <?php echo e($settings->_phone ?? ''); ?><br>
          <?php echo e($settings->_email ?? ''); ?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h3 class="text-center"><b><?php echo e(voucher_code_to_name($data->_voucher_type)); ?></b></h3>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
        <b>Voucher ID: <?php echo e($data->_code ?? ''); ?></b><br>
         <b>Time:</b> <?php echo e($data->_time ?? ''); ?><br>
             <?php
$_bank_name = $data->check_info->_bank_name ?? '';
$_branch_name = $data->check_info->_branch_name ?? '';
$_bank_account = $data->check_info->_bank_account ?? '';
$_check_no = $data->check_info->_check_no ?? '';
$_issue_date = $data->check_info->_issue_date ?? '';
$_cash_date = $data->check_info->_cash_date ?? '';
                ?>
             <?php if($_bank_name !=''): ?>
              <b><?php echo e(__('label._bank_name')); ?>:</b> <?php echo e($_bank_name ?? ''); ?><br>
              <?php endif; ?>
             <?php if($_branch_name !=''): ?>
              <b><?php echo e(__('label._branch_name')); ?>:</b> <?php echo e($_branch_name ?? ''); ?><br>
              <?php endif; ?>
             <?php if($_bank_account !=''): ?>
              <b><?php echo e(__('label._bank_account')); ?>:</b> <?php echo e($_bank_account ?? ''); ?><br>
              <?php endif; ?>
             <?php if($_check_no !=''): ?>
              <b><?php echo e(__('label._check_no')); ?>:</b> <?php echo e($_check_no ?? ''); ?><br>
              <?php endif; ?>
             <?php if($_check_no !=''): ?>
              <b><?php echo e(__('label._issue_date')); ?>:</b> <?php echo e(_view_date_formate($_issue_date ?? '')); ?><br>
              <?php endif; ?>
             <?php if($_check_no !=''): ?>
              <b><?php echo e(__('label._cash_date')); ?>:</b> <?php echo e(_view_date_formate($_cash_date ?? '')); ?><br>
              <?php endif; ?>
       
        <b><?php echo e(__('label._ref')); ?>:</b> <?php echo e($data->_transection_ref ?? ''); ?><br>
        <b>Created By:</b> <?php echo e($data->_user_name ?? ''); ?><br>
        <b>Branch:</b> <?php echo e($data->_master_branch->_name ?? ''); ?>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            
            <th>Ledger</th>
            <?php if(sizeof($permited_branch) > 1): ?>
            <th>Branch</th>
            <?php endif; ?>
            <?php if(sizeof($permited_costcenters) > 1): ?>
            <th>Cost Center</th>
            <?php endif; ?>
            <th>Short Narr.</th>
            <th class="text-right" >Dr. Amount</th>
            <th class="text-right" >Cr. Amount</th>
          </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $data->_master_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail_key=>$detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            
            <td><?php echo $detail->_voucher_ledger->_name ?? ''; ?></td>
           <?php if(sizeof($permited_branch) > 1): ?>
            <td><?php echo $detail->_detail_branch->_name ?? ''; ?></td>
            <?php endif; ?>
             <?php if(sizeof($permited_costcenters) > 1): ?>
            <td><?php echo $detail->_detail_cost_center->_name ?? ''; ?></td>
            <?php endif; ?>
            <td><?php echo $detail->_short_narr ?? ''; ?></td>
            <td class="text-right" ><?php echo _report_amount( $detail->_dr_amount ); ?></td>
            <td class="text-right" ><?php echo _report_amount( $detail->_cr_amount ); ?></td>
             
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <?php endif; ?>
          
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-right">Total:</th>
              <?php if(sizeof($permited_branch) > 1): ?>
            <td></td>
            <?php endif; ?>
             <?php if(sizeof($permited_costcenters) > 1): ?>
            <td></td>
            <?php endif; ?>
              <th class="text-right" ><?php echo _report_amount( $data->_amount ?? 0 ); ?></th>
              <th class="text-right" ><?php echo _report_amount( $data->_amount ?? 0 ); ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-12">
        <?php
$digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        ?>
        <p class="lead"> <b>In Words: <?php echo e(prefix_taka()); ?>. <?php echo e($digit->format($data->_amount ?? 0)); ?>. </b></p>
        
      </div>
       <?php echo $__env->make('backend.message.invoice_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
               
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/voucher/show.blade.php ENDPATH**/ ?>