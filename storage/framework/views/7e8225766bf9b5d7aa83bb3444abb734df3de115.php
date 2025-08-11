
<?php $__env->startSection('title',$page_name ?? ''); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="#"><?php echo e(__('label.profile_update')); ?></a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>">Home</a></li> -->
              <li class="breadcrumb-item active">
                 <?php echo e(__('label.profile')); ?>

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
               <form action="<?php echo e(url('user-profile-update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                         <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Name:</label>
                                <?php echo Form::text('name', $user->name, array('placeholder' => 'Name','class' => 'form-control')); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>User Name/EMP ID:</label>
                                <?php echo Form::text('user_name', $user->user_name, array('placeholder' => 'User Name','class' => 'form-control')); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Email:</label>
                                <?php echo Form::text('email', $user->email, array('placeholder' => 'Email','class' => 'form-control')); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Password:</label>
                                <?php echo Form::password('password', array('placeholder' => 'Password','class' => 'form-control')); ?>

                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            
                            <div class="form-group">
                                <label>Image:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="image" class="form-control">
                               <img id="output_1" class="banner_image_create" src="<?php echo e(asset($user->image ?? '')); ?>"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        
                        </div>
                        
                        
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control " name="status">
                                      <option value="1"  <?php if($user->status==1): ?> selected <?php endif; ?> >Active</option>
                                      <option value="0"  <?php if($user->status==0): ?> selected <?php endif; ?> >In Active</option>
                                    </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/users/profile.blade.php ENDPATH**/ ?>