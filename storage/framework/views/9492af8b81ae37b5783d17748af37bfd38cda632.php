<div>
                  <form action="" method="GET">
                    <?php echo csrf_field(); ?>
                     <?php 
                        $row_numbers = [10,20,30,40,50,100,200,300,400,500,600,1000,2000,100000,200000,500000];
                        ?>
                        <div class="row">
                          <div class="col-md-2">
                            <select name="limit" class="form-control">
                                    <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                     <option <?php if(isset($request->limit)): ?> <?php if($request->limit == $row): ?> selected <?php endif; ?>  <?php endif; ?> value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="_name" class="form-control" placeholder="Search By Name" value="<?php if(isset($request->_name)): ?> <?php echo e($request->_name ?? ''); ?>  <?php endif; ?>">
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="_code" class="form-control" placeholder="Code" value="<?php if(isset($request->_code)): ?> <?php echo e($request->_code ?? ''); ?>  <?php endif; ?>">
                          </div>
                          <!-- Status Filter -->
            <div class="col-md-2">
                <div class="form-group">
                    
                    <select name="_status" id="_status" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="1" <?php echo e(request('_status') == '1' ? 'selected' : ''); ?>>Active</option>
                        <option value="0" <?php echo e(request('_status') == '0' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
            </div>
             <?php
$order_cloumns = ['id'=>'ID','_name'=>'Name','_code'=>'CODE', 'status'=>'Status', 'created_at'=>'Created at', 'updated_at'=>'Updated At'];

$_order_cloumn = $request->_order_cloumn ?? 'id';
$limit = $request->limit ?? 10;
$_asc_des = $request->_asc_des ?? 'DESC';


            ?>


            <div class="col-md-2">
                
                <select name="_order_cloumn" class="form-control">
                   <option value="">Order Cloumn</option>
                   <?php $__empty_1 = true; $__currentLoopData = $order_cloumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c_key=>$c_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($c_key); ?>" <?php if($c_key==$_order_cloumn): ?> selected <?php endif; ?> ><?php echo e($c_name ?? ''); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                   <?php endif; ?>
                </select>
            </div>
            <div class="col-md-2">
               
                <select name="_asc_des" class="form-control">
                   <option value="">Order By</option>
                    <option value="DESC" <?php if($_asc_des=='DESC'): ?> selected <?php endif; ?> >DESC</option>
                    <option value="ASC" <?php if($_asc_des=='ASC'): ?> selected <?php endif; ?> >ASC</option>
                  
                </select>
            </div>
                          
                          
                          
                          <div class="col-md-2">
                              <button class=" btn btn-info" type="submit"><i class="fa fa-search "></i> Search</button>
                          </div>
                          <div class="col-md-2">
                      <div class="d-flex flex-row justify-content-end">
                         
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               <div class="dropdown-divider"></div>
                                <a target="__blank" href="<?php echo e($print_url_detal); ?>"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             
                        
                          </div>
                    </div>
                        </div><!-- end row -->
                   
                  </form>
                </div><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/stm/common_search.blade.php ENDPATH**/ ?>