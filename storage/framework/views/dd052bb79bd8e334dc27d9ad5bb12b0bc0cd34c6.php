
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="<?php echo e(url('salary_sheet_list')); ?>"><?php echo $page_name; ?> </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
         <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
            <div class="card-body p-4" >
                <?php echo Form::open(array('url' => 'salary_sheet_generate','method'=>'POST','enctype'=>'multipart/form-data')); ?>

                
                        
                      <?php
                        $users = \Auth::user();
                        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                        $permited_branch = permited_branch(explode(',',$users->branch_ids));
                        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
                        ?> 
 <div class="form-group row">
<label class="col-sm-2 col-form-label _required" ><?php echo e(__('label._month')); ?>:</label>
                            <div class="col-md-2">
                                <select class="form-control _month" name="_month" required>
                                    <option value=""><?php echo e(__('label.select')); ?></option>
                                    <?php $__empty_1 = true; $__currentLoopData = _month_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month_key=>$month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($month_key); ?>"><?php echo e($month ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </select>
                            </div>
</div>
         <div class="form-group row">
                    <label class="col-sm-2 col-form-label _required" ><?php echo e(__('label._year')); ?>:</label>
                             <div class="col-sm-2">
                                <select name="_year" class="form-control" required>
    <?php
    // Get the current year
    $currentYear = date('Y');

    // Display the last two years
    for ($i = 2; $i > 0; $i--) {
        $year = $currentYear - $i;
        echo "<option value='$year'>$year</option>";
    }

    // Display the current year
    echo "<option value='$currentYear' selected>$currentYear</option>";

    // Display the next year
    $nextYear = $currentYear + 1;
    echo "<option value='$nextYear'>$nextYear</option>";
    ?>
</select>

                            </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2"><?php echo __('label.organization'); ?>:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_organization_id" name="organization_id"  >
                                <?php if(sizeof($permited_organizations) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               
                               <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($val->id); ?>" <?php if(isset($request->organization_id)): ?> <?php if($request->organization_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2"><?php echo e(__('label._branch_id')); ?>:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_branch_id" name="_branch_id"  >
                               <?php if(sizeof($permited_branch) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($branch->id); ?>" <?php if(isset($request->_branch_id)): ?> <?php if($request->_branch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2"><?php echo e(__('label.Cost center')); ?>:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <select class="form-control _cost_center_id" name="_cost_center_id"  >
                               <?php if(sizeof($permited_costcenters) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($cost_center->id); ?>" <?php if(isset($request->_cost_center_id)): ?> <?php if($request->_cost_center_id == $cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
                         </div>
                        </div>
                        
                            
                      
                
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-4 mb-4  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> <?php echo e(__('label.submit')); ?></button>
                           
                        </div>
                        <br><br>
                    
                 
                    
                    
                     
                    <?php echo Form::close(); ?>

                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script type="text/javascript">


 

  

  

     

         

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/hrm/salary_sheet/form.blade.php ENDPATH**/ ?>