
<?php $__env->startSection('title','General Settings'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name" >Invoice Prefix Setup </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
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
             
              <div class="card-body" style="margin-bottom: 20px;">
                <form method="POST" action="<?php echo e(url('invoice-prefix-store')); ?>" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
                    <div class="row">
                     <div class="card">
             
              <div class="card-body">
                        <div class="col-md-12">
                          <table class="table table-bordered" style="width: 100%;">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Module Name</th>
                                <th>Prefix</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                              <tr>
                                <td>
                                  <input type="text" name="id[]" class="form-control" value="<?php echo e($val->id); ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" name="_table_name[]" class="form-control" value="<?php echo e($val->_table_name); ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" name="_prefix[]" class="form-control" value="<?php echo e($val->_prefix); ?>">
                                </td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>

                      </div>
                        </div>
                       
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/settings/invoice-prefix.blade.php ENDPATH**/ ?>