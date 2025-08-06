
<?php $__env->startSection('title',$settings->title); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <a class="m-0 _page_name" href="<?php echo e(route('roles.index')); ?>">Role Management </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>">Home</a></li> -->
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="<?php echo e(route('roles.index')); ?>"> Role Management</a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                <?php echo Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]); ?>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <?php echo Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')); ?>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                              <?php
                              $types = ['admin','visitor','sales_officer'];
                              ?>
                                <strong>Type:</strong>
                                <select class="form-control" name="type">
                                  <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option <?php if($role->type==$value): ?> selected <?php endif; ?> value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-10" >
                                <div class="form-group">
                                    <strong>Permission: <input type="checkbox" name="all_all_check" class="">ALL </strong>
                                    <br/>
                                <?php
                                $number = 1;
                               ?>
                                   <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class=" card" >
                                      <?php
                                      $make_class = "group_check__".strtolower(str_replace(' ', '', $key));
                                        $class_names ="name all_check ".$make_class;

                                      ?>
                                      <div class="card-header">
                                        <h4 style="background: #f4f6f9;padding: 5px;border-radius: 5px;"><?php echo e($number); ?>.<?php echo e($key); ?> <input type="checkbox" name="group_check" class="<?php echo e($make_class); ?>"></h4>
                                      </div>

                                      
                                  
                                   <div class="row card-body">
                                    <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3">
                                        <label><?php echo e(Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => $class_names))); ?>

                                          <?php echo e($value->name); ?></label>
                                    </div>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                  </div>

                                     
                                  </div>
                                  <?php
                                $number++;
                               ?>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               </div>
                            </div>
                           
                             <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle ">
                            <button type="submit" class="btn btn-success submit-button "><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                        </div>
                        <br><br>
                        </div>
                        <?php echo Form::close(); ?>

                
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/roles/edit.blade.php ENDPATH**/ ?>