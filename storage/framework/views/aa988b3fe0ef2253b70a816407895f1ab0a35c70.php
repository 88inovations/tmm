
<?php $__env->startSection('title',$settings->title); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a class="m-0 _page_name" href="<?php echo e(route('account-type.index')); ?>"> <?php echo $page_name ?? ''; ?> </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-type-list')): ?>
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="<?php echo e(route('account-type.index')); ?>"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               <?php endif; ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    <?php if(count($errors) > 0): ?>
           <div class="alert alert-danger">
                
                <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
               
                 <form action="<?php echo e(url('account-type/update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="id" value="<?php echo e($data->id); ?>">
                            <div class="form-group">
                                <label>Account:</label>
                                  <?php
$main_accounts = \DB::table('main_account_head')->get();
                        ?>
                        <select class="form-control" name="_account_id">
                                    <?php $__empty_1 = true; $__currentLoopData = $main_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($main->id); ?>" <?php if($data->_account_id==$main->id): ?> selected <?php endif; ?>><?php echo e($main->_name); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                 <?php endif; ?>
                                </select>
                                

                       
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Account Level:</label>
                                <select class="form-control" name="_parent_id">
                                  <option value="">--Select--</option>
                                 <?php $__empty_1 = true; $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($account_type->id); ?>" <?php if(isset($data->_parent_id)): ?> <?php if($data->_parent_id == $account_type->id): ?> selected <?php endif; ?>   <?php endif; ?>  ><?php echo e($account_type->_code ?? ''); ?>-<?php echo e($account_type->_name ?? ''); ?></option>


                                  <?php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  ?>
                                  <?php $__empty_2 = true; $__currentLoopData = $_child_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <option value="<?php echo e($group->id); ?>"  <?php if($data->_parent_id == $group->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;<?php echo e($group->_code ?? ''); ?>-<?php echo e($group->_name ?? ''); ?></option>

                                         <?php
                                        $third_child_group=$group->_child_group ?? [];
                                        ?>

                                         <?php $__empty_3 = true; $__currentLoopData = $third_child_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $third_child_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>

 <option value="<?php echo e($third_child_val->id); ?>"  <?php if($data->_parent_id == $third_child_val->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<?php echo e($third_child_val->_code ?? ''); ?>-<?php echo e($third_child_val->_name ?? ''); ?></option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                         <?php endif; ?>



                                  
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                  <?php endif; ?>

                                  
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Name:</label>
                                
                                <input type="text" name="_name" class="form-control" required="true" value="<?php echo $data->_name ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Code:</label>
                                
                                 <input type="text" name="_code" class="form-control" required="true" value="<?php echo $data->_code ?? ''; ?>">
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" <?php if($data->_status==1): ?> selected <?php endif; ?> >Active</option>
                                  <option value="0" <?php if($data->_status==0): ?> selected <?php endif; ?> >In Active</option>
                                </select>
                            </div>
                        </div>
                       
                       
                        <div class="col-xs-6 col-sm-6 col-md-6 text-center mt-1">
                            <button type="submit" class="btn btn-success "><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>
                        <br><br>
                    </div>
                    </form>
                
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/account-type/edit.blade.php ENDPATH**/ ?>