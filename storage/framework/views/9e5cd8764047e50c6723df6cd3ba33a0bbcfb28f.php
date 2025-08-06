
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('salary_sheet_list')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salary_sheet')): ?>
                <a class="btn btn-sm btn-info active " 
               href="<?php echo e(route('salary_sheet')); ?>">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
              <?php endif; ?>
               
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success">
      <p><?php echo e($message); ?></p>
    </div>
    <?php endif; ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 

                  <div class="row">
                 
                    <div class="col-md-4">
                     
                    </div>
                    <div class="col-md-8">
                      
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                         <th><?php echo e(__('Action')); ?></th>
                         <th><?php echo e(__('SL')); ?></th>
                         <th><?php echo e(__('label.voucher_id')); ?></th>
                         <th><?php echo e(__('label.voucher_code')); ?></th>
                         <th><?php echo e(__('label._month')); ?></th>
                         <th><?php echo e(__('label._year')); ?></th>
                         <th><?php echo e(__('label.organization_id')); ?></th>
                         <th><?php echo e(__('label._branch_id')); ?></th>
                         <th><?php echo e(__('label._cost_center_id')); ?></th>
                         <th><?php echo e(__('label.salary_amount')); ?></th>
                         <th><?php echo e(__('label.allowance_amount')); ?></th>
                         <th><?php echo e(__('label.deduction_amount')); ?></th>
                         <th><?php echo e(__('label.net_payable_amount')); ?></th>
                         <th><?php echo e(__('label._note')); ?></th>
                         <th><?php echo e(__('label._user_name')); ?></th>
                         <th><?php echo e(__('label._is_posting')); ?></th>
                         <th><?php echo e(__('label._lock')); ?></th>
                         <th><?php echo e(__('Created At')); ?></th>
                         <th><?php echo e(__('Updated At')); ?></th>
                         <th><?php echo e(__('label._status')); ?></th>
                         <?php
                         $default_image = $settings->logo;
                         ?>           
                      </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td >
                           <a href="<?php echo e(route('branch_wise_sallary_sheet',$data->id)); ?>"
                                 class="btn btn-sm btn-info" >Salary Sheet</a>
                        </td>

                             
                            


                            <td><?php echo e(($key+1)); ?></td>
                            <td><?php echo e($data->voucher_id ?? ''); ?></td>
                            <td><?php echo e($data->voucher_code ?? ''); ?></td>
                            <td><?php echo e(_number_to_month($data->_month) ?? ''); ?></td>
                            <td><?php echo e($data->_year ?? ''); ?></td>
                            <td><?php echo e($data->_organization->_name ?? ''); ?></td>
                            <td><?php echo e($data->_master_branch->_name ?? ''); ?></td>
                            <td><?php echo e($data->_master_cost_center->_name ?? ''); ?></td>
                            <td><?php echo e(_report_amount($data->salary_amount ?? 0)); ?></td>
                            <td><?php echo e(_report_amount($data->allowance_amount ?? 0)); ?></td>
                            <td><?php echo e(_report_amount($data->deduction_amount ?? 0)); ?></td>
                            <td><?php echo e(_report_amount($data->net_payable_amount ?? 0)); ?></td>
                            
                            <td><?php echo $data->_note ?? ''; ?></td>
                            <td><?php echo $data->_user_name ?? ''; ?></td>
                            <td><?php echo $data->_is_posting ?? ''; ?></td>
                           <td style="display: flex;">
                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock-permission')): ?>
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="<?php echo e($data->id); ?>" value="<?php echo e($data->_lock); ?>" <?php if($data->_lock==1): ?> checked <?php endif; ?>>
                              <?php endif; ?>

                              <?php if($data->_lock==1): ?>
                              <i class="fa fa-lock _green ml-1 _icon_change__<?php echo e($data->id); ?>" aria-hidden="true"></i>
                              <?php else: ?>
                              <i class="fa fa-lock _required ml-1 _icon_change__<?php echo e($data->id); ?>" aria-hidden="true"></i>
                              <?php endif; ?>

                            </td>
                            <td><?php echo e($data->created_at ?? ''); ?></td>
                            <td><?php echo e($data->updated_at ?? ''); ?></td>
                           <td><?php echo e(selected_status($data->_status)); ?></td>
                           
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 <?php echo $datas->render(); ?>

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


<?php $__env->startSection("script"); ?>
<script type="text/javascript">
   $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });

$(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="salary_sheets";
   if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/hrm/salary_sheet/list.blade.php ENDPATH**/ ?>