<div  >

  
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="" method="GET" class="form-horizontal">
            <?php echo csrf_field(); ?>
              <div class="modal-content">
                <div class="modal-header">
                  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 <?php 
                    $row_numbers = filter_page_numbers();
                         
                  ?>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Limit:</label>
                    <div class="col-sm-10">
                     <select name="limit" class="form-control" >
                              <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option  <?php if($limit == $row): ?> selected <?php endif; ?>  value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <?php endif; ?>
                      </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" id="id" name="id" class="form-control" placeholder="EXP:1,2,3,4,5" value="<?php if(isset($request->id)): ?> <?php echo e($request->id ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_name" class="col-sm-2 col-form-label">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_name" name="_name" class="form-control" placeholder="Search By Name" value="<?php if(isset($request->_name)): ?> <?php echo e($request->_name ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">Code:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_code" name="_code" class="form-control" placeholder="Search By Code" value="<?php if(isset($request->_code)): ?> <?php echo e($request->_code ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_short" class="col-sm-2 col-form-label">Possition:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_short" name="_short" class="form-control" placeholder="Search By Possition" value="<?php if(isset($request->_short)): ?> <?php echo e($request->_short ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <?php
$_account_head_id = $request->_account_head_id ?? '';
                  ?>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Account Type :</label>
                    <div class="col-sm-10">
                       <select class=" form-control" name="_account_head_id">
                        
                                  <option value="">--Select--</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                                  <option value="<?php echo e($account_type->id); ?>"  <?php if($_account_head_id == $account_type->id): ?> selected <?php endif; ?>  ><?php echo e($account_type->_code ?? ''); ?>-<?php echo e($account_type->_name ?? ''); ?></option>

                                  <?php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  ?>
                                  <?php $__empty_2 = true; $__currentLoopData = $_child_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <option value="<?php echo e($group->id); ?>"  <?php if($_account_head_id == $group->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;<?php echo e($group->_code ?? ''); ?>-<?php echo e($group->_name ?? ''); ?></option>

                                        <?php
                                        $third_child_group=$group->_child_group ?? [];
                                        ?>

                                         <?php $__empty_3 = true; $__currentLoopData = $third_child_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $third_child_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>

 <option value="<?php echo e($third_child_val->id); ?>"  <?php if($_account_head_id == $third_child_val->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<?php echo e($third_child_val->_code ?? ''); ?>-<?php echo e($third_child_val->_name ?? ''); ?></option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                         <?php endif; ?>



                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                  <?php endif; ?>

                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>

                    </div>
                  </div>  


                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      <?php
                      $cloumns = [ 'id'=>'ID','_name'=>'Name','_code'=>'Code','_account_head_id'=>'Account Type','_short'=>'Possition'];

                      ?>
                       <select class="form-control" name="asc_cloumn" >
                            
                            <?php $__currentLoopData = $cloumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($request->asc_cloumn)): ?> <?php if($key==$request->asc_cloumn): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Sort :</label>
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
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-search mr-2"></i> Search</button>
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
                                         <option <?php if($limit): ?>) <?php if($limit == $row): ?> selected <?php endif; ?>  <?php endif; ?> value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-group mt-1">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="<?php echo e(url('account-group-reset')); ?>" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/account-group/search.blade.php ENDPATH**/ ?>