

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
          
          
         <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
            <div class="card-body p-4" >
                <?php echo Form::open(array('class' => 'subEntryForm','id' => 'subEntryForm','method'=>'POST')); ?>

                
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-bold"><?php echo e(__('label._name')); ?>:<span class="_required">*</span></label>
                                <input class="form-control form-data" class="form-data" type="text" name="_name" placeholder="<?php echo e(__('label._name')); ?>" value="<?php echo e(old('_name',$data->_name ?? '' )); ?>" required>
                                <input type="hidden" class="attr_save_url form-data"  name="attr_save_url" value="<?php echo e($request->attr_save_url ?? ''); ?>">
                                <input type="hidden" class="attr_table_name form-data" name="attr_table_name" value="<?php echo e($request->attr_table_name ?? ''); ?>">
                                <input type="hidden" class="attr_select_option_class form-data" name="attr_select_option_class" value="<?php echo e($request->attr_select_option_class ?? ''); ?>">
                                <input type="hidden" class="modal_name form-data" name="modal_name" value="<?php echo e($request->modal_name ?? ''); ?>">
                                <input type="hidden" class="_column_name form-data" name="_column_name" value="<?php echo e($request->_column_name ?? ''); ?>">
                            </div>
                        </div>
                      
                      
                
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="button"
                           
                             class="btn btn-success subEntryButton ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> <?php echo e(__('label.save')); ?></button>
                           
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








<?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/hrm/hrm-emp-category/sub_new.blade.php ENDPATH**/ ?>