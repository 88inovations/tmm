<div  >

  
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="" method="GET" class="form-horizontal">
            <?php echo csrf_field(); ?>
              <div class="modal-content">
                <div class="modal-header">
                  <h1><?php echo e($page_name ?? ''); ?> <?php echo e(__('label.search')); ?></h1>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 <?php 
                        $row_numbers = filter_page_numbers();
                         
                        ?>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label.Limit')); ?>:</label>
                    <div class="col-sm-10">
                     <select name="limit" class="form-control" >
                              <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option <?php if($limit == $row): ?> selected <?php endif; ?>  value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <?php endif; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label.employee_category_id')); ?>:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _category_id" name="_category_id">
                        <option value=""><?php echo e(__('label.select')); ?></option>
                        <?php $__empty_1 = true; $__currentLoopData = $employee_catogories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <option value="<?php echo e($val->id); ?>" <?php if(isset($request->_category_id)): ?> <?php if($request->_category_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->_name ?? ''); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._department_id')); ?>:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_department_id">
                          <option value=""><?php echo e(__('label.select')); ?></option>
                          <?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <option value="<?php echo e($val->id); ?>" <?php if(isset($request->_department_id)): ?> <?php if($request->_department_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->_department ?? ''); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._jobtitle_id')); ?>:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_jobtitle_id">
                          <option value=""><?php echo e(__('label.select')); ?></option>
                          <?php $__empty_1 = true; $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <option value="<?php echo e($val->id); ?>" <?php if(isset($request->_jobtitle_id) && $request->_jobtitle_id == $val->id): ?>  selected  <?php endif; ?>><?php echo e($val->_name ?? ''); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._grade_id')); ?>:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_grade_id">
                          <option value=""><?php echo e(__('label.select')); ?></option>
                          <?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <option value="<?php echo e($val->id); ?>" <?php if(isset($request->_grade_id) && $request->_grade_id == $val->id): ?>  selected  <?php endif; ?>><?php echo e($val->_grade ?? ''); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label.id')); ?>:</label>
                    <div class="col-sm-10">
                      <input type="text" name="id" class="form-control" placeholder="Exp:1,2,3,4" value="<?php if(isset($request->id)): ?> <?php echo e($request->id ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._name')); ?>:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_name" class="form-control" placeholder="<?php echo e(__('label._name')); ?>" value="<?php if(isset($request->_name)): ?> <?php echo e($request->_name ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._code')); ?>:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_code" class="form-control" placeholder="<?php echo e(__('label._code')); ?>" value="<?php if(isset($request->_code)): ?> <?php echo e($request->_code ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._phone')); ?>:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_mobile1" class="form-control" placeholder="<?php echo e(__('label._phone')); ?>" value="<?php if(isset($request->_mobile1)): ?> <?php echo e($request->_mobile1 ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._email')); ?>:</label>
                    <div class="col-sm-10">
                       <input type="text" name="_email" class="form-control" placeholder="<?php echo e(__('label._email')); ?>" value="<?php if(isset($request->_email)): ?> <?php echo e($request->_email ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>

                  
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label._order_by')); ?>:</label>
                    <div class="col-sm-10">
                      <?php
                        $cloumns = [ 'id'=>'ID','_account_group_id'=>'Account Group','_account_head_id'=>'Account Head','_name'=>'Name','_code'=>'Code','_nid'=>'NID', '_email'=>'Email','_phone'=>'Phone'];

                      ?>
                       <select class="form-control" name="asc_cloumn" >
                            
                            <?php $__currentLoopData = $cloumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($request->asc_cloumn)): ?> <?php if($key==$request->asc_cloumn): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>
                     
                     <div class="form-group row">
                    <label  class="col-sm-2 col-form-label"><?php echo e(__('label.short_order')); ?>:</label>
                    <div class="col-sm-10">
                       <select class=" form-control" name="_asc_desc">
                        <?php $__currentLoopData = asc_desc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php if(isset($request->_asc_desc)): ?> <?php if($val==$request->_asc_desc): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>    

                             
                          
                       
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('label._close')); ?></button>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-search mr-2"></i> <?php echo e(__('label.search')); ?></button>
                </div>
              </div>
            </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                  <form action="" method="GET">
                    <?php echo csrf_field(); ?>

                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                                
                                <select name="limit" class="form-control" onchange="this.form.submit()">
                                        <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                         <option <?php if($limit == $row): ?> selected <?php endif; ?>   value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                </select>
                              </div>
                          </div>
                          
                          
                          <div class="col-md-8">
                              <div class="form-group mr-2">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="<?php echo e(url('hrm-employee')); ?>" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/search.blade.php ENDPATH**/ ?>