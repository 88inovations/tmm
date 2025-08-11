<div  >

  
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="<?php echo e(url('transfer')); ?>" method="GET" class="form-horizontal">
            <?php echo csrf_field(); ?>
              <div class="modal-content">
                <div class="modal-header">
                  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body search_modal">
                 <?php 
                    $row_numbers = filter_page_numbers();
                         
                  ?>
                 
                  
                  
                  <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">ID:</label>
                    <div class="col-sm-9">
                      <input type="text" id="id" name="id" class="form-control" placeholder="Search By Id" 
                      value="<?php if(isset($request->id)): ?><?php echo e($request->id ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_from_branch " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_from_branch" required >
                                  
                                  <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($branch->id); ?>" <?php if(isset($request->_from_branch)): ?> <?php if($request->_from_branch == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_from_cost_center " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_from_cost_center" required >
                                  
                                  <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($_cost_center->id); ?>" <?php if(isset($request->_from_cost_center)): ?> <?php if($request->_from_cost_center == $_cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($_cost_center->id ?? ''); ?> - <?php echo e($_cost_center->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_to_branch " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_to_branch" required >
                                  
                                  <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($branch->id); ?>" <?php if(isset($request->_to_branch)): ?> <?php if($request->_to_branch == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_to_cost_center " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_to_cost_center" required >
                                  
                                  <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($_cost_center->id); ?>" <?php if(isset($request->_to_cost_center)): ?> <?php if($request->_to_cost_center == $_cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($_cost_center->id ?? ''); ?> - <?php echo e($_cost_center->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_date" class="col-sm-3 col-form-label">Date:</label>
                    <div class="col-sm-9">
                      <div class="row">
                         <div class="col-sm-2">Use Date: 
                          <select class="form-control" name="_user_date">
                            <option value="no" <?php if(isset($request->_user_date)): ?> <?php if($request->_user_date=='no'): ?> selected <?php endif; ?>  <?php endif; ?>>No</option>
                            <option value="yes" <?php if(isset($request->_user_date)): ?> <?php if($request->_user_date=='yes'): ?> selected <?php endif; ?>  <?php endif; ?>>Yes</option>
                          </select>

                         </div>
                        <div class="col-sm-5">From: 
                          
                          <div class="input-group date" id="reservationdate_datex" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input_datex" data-target="#reservationdate_datex" value="<?php if(isset($request->_datex)): ?><?php echo e($request->_datex ?? ''); ?><?php endif; ?>" />
                                      <div class="input-group-append" data-target="#reservationdate_datex" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                        </div>
                        <div class="col-sm-5">To: 
                          <div class="input-group date" id="reservationdate_datey" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_datey" data-target="#reservationdate_datey" value="<?php if(isset($request->_datey)): ?><?php echo e($request->_datey ?? ''); ?><?php endif; ?>" />
                                      <div class="input-group-append" data-target="#reservationdate_datey" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_reference" class="col-sm-3 col-form-label">Reference:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_reference" name="_reference" class="form-control" placeholder="Search By Reference" value="<?php if(isset($request->_reference)): ?><?php echo e($request->_reference ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_note" class="col-sm-3 col-form-label">Note:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_note" name="_note" class="form-control" placeholder="Search By Note" value="<?php if(isset($request->_note)): ?><?php echo e($request->_note ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  

                  <div class="form-group row">
                    <label for="_total" class="col-sm-3 col-form-label">Stock Out Total:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_total" name="_total" class="form-control" placeholder="Stock Out Total" value="<?php if(isset($request->_total)): ?><?php echo e($request->_total ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_stock_in__total" class="col-sm-3 col-form-label">Stock In Amount:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_stock_in__total" name="_stock_in__total" class="form-control" placeholder="Search By Stock In Amount" value="<?php if(isset($request->_stock_in__total)): ?><?php echo e($request->_stock_in__total ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_created_by" class="col-sm-3 col-form-label">Created By:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_created_by" name="_created_by" class="form-control" placeholder="Search  Created By" value="<?php if(isset($request->_created_by)): ?><?php echo e($request->_created_by ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_updated_by" class="col-sm-3 col-form-label">Updated By:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_updated_by" name="_updated_by" class="form-control" placeholder="Search Updated By " value="<?php if(isset($request->_updated_by)): ?><?php echo e($request->_updated_by ?? ''); ?><?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_p_status" class="col-sm-3 col-form-label">Status:</label>
                    <div class="col-sm-9">
                      <?php
                      $_p_statuss = [ '1'=>'Transit', '2'=>'Work-in-progress', '3'=>'Complete'];
                      ?>
                       <select id="_p_status" class="form-control" name="_p_status" >
                        <option value="">Select</option>
                            <?php $__currentLoopData = $_p_statuss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($request->_p_status)): ?> <?php if($key==$request->_p_status): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_lock" class="col-sm-3 col-form-label">Lock:</label>
                    <div class="col-sm-9">
                      <?php
                    $_locks = [ '0'=>'Open', '1'=>'Locked'];
                      ?>
                       <select id="_lock" class="form-control" name="_lock" >
                        <option value="">Select</option>
                            <?php $__currentLoopData = $_locks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($request->_lock)): ?> <?php if($key==$request->_lock): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Limit:</label>
                    <div class="col-sm-9">
                     <select name="limit" class="form-control" >
                              <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option  <?php if($limit == $row): ?> selected <?php endif; ?>   value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <?php endif; ?>
                      </select>
                    </div>
                  </div>

                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Order By:</label>
                    <div class="col-sm-9">
                      <?php
             $cloumns = [ 'id'=>'ID','_date'=>'Date','_from_cost_center'=>'From cost center','_from_branch'=>'From Branch','_to_cost_center'=>'To Cost Center','_to_branch'=>'To branch','_reference'=>'Reference', '_note '=>'Note','_type'=>'Type','_total'=>'Stock Out Total','_stock_in__total'=>'Stock In Total','_p_status'=>'Status','_lock'=>'Lock'];

                      ?>
                       <select class="form-control" name="asc_cloumn" >
                            
                            <?php $__currentLoopData = $cloumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($request->asc_cloumn)): ?> <?php if($key==$request->asc_cloumn): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Sort Order:</label>
                    <div class="col-sm-9">
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
                  <form action="<?php echo e(url('transfer')); ?>" method="GET">
                    <?php echo csrf_field(); ?>

                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                                
                                <select name="limit" class="form-control" onchange="this.form.submit()">
                                        <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                         <option  <?php if($limit == $row): ?> selected <?php endif; ?>  value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-group ">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="<?php echo e(url('transfer-production-reset')); ?>" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/transfer/search.blade.php ENDPATH**/ ?>