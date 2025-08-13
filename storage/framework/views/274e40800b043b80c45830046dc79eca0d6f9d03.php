
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('attandance.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-attandance-create')): ?>
                <a 
               class="btn btn-sm btn-info active " 
               
               href="<?php echo e(route('attandance.create')); ?>">
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
                   <?php

 $currentURL = URL::full();
 $current = URL::current();
if($currentURL === $current){
   $print_url = $current."?print=single";
   $print_url_detal = $current."?print=detail";
}else{
     $print_url = $currentURL."&print=single";
     $print_url_detal = $currentURL."&print=detail";
}
    

                   ?>
                   <?php
$users = \Auth::user();
$permited_branch = permited_branch(explode(',',$users->branch_ids));
$permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
$permited_organizations = permited_organization(explode(',',$users->organization_ids));
?> 
                    <div class="col-md-4">
                      
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                           
                         <?php echo $datas->render(); ?>

                          </div>
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
                         <?php if(sizeof($permited_organizations) > 1): ?>
                         <th><?php echo e(__('label.organization_id')); ?></th>
                         <?php endif; ?>
                         <?php if(sizeof($permited_branch) > 1): ?>
                         <th><?php echo e(__('label._branch_id')); ?></th>
                         <?php endif; ?>
                         <?php if(sizeof($permited_costcenters) > 1): ?>
                         <th><?php echo e(__('label._cost_center_id')); ?></th>
                         <?php endif; ?>
                         <th><?php echo e(__(' ID')); ?></th>
                         <th><?php echo e(__(' Name')); ?></th>
                         <th><?php echo e(__('label._date')); ?></th>
                         <th><?php echo e(__('label.in_time')); ?></th>
                         <th><?php echo e(__('label.out_time')); ?></th>
                         <th><?php echo e(__('label.remarks')); ?></th>
                         
                         <?php
                         $default_image = $settings->logo;
                         ?>           
                      </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td style="display: flex;">
                           


                                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-attandance-edit')): ?>
                                  <a   
                                  href="<?php echo e(route('attandance.edit',$data->id)); ?>"
                                  
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  <?php endif; ?>
                                
                               
                        </td>

                             


                            
                            <td><?php echo e(($key+1)); ?></td>
                            <?php if(sizeof($permited_organizations) > 1): ?>
                         <td><?php echo e($data->_organization->_name ?? ''); ?></td>
                         <?php endif; ?>
                         <?php if(sizeof($permited_branch) > 1): ?>
                         <td><?php echo e($data->_branch->_name ?? ''); ?></td>
                         <?php endif; ?>
                         <?php if(sizeof($permited_costcenters) > 1): ?>
                         <td><?php echo e($data->_cost_center->_name ?? ''); ?></td>
                         <?php endif; ?>
                            
                           
                            <td><?php echo e($data->_employee_info->_code ?? ''); ?></td>
                            <td><?php echo e($data->_employee_info->_name ?? ''); ?></td>
                            
                            
                            <td><?php echo e($data->_datetime ?? ''); ?></td>
                            <td><?php echo e($data->in_time ?? ''); ?></td>
                            <td><?php echo e($data->out_time ?? ''); ?></td>
                            <td><?php echo e($data->remarks ?? ''); ?></td>
                           
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


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/hrm/attandance/index.blade.php ENDPATH**/ ?>