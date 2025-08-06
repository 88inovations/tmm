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
                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" name="id" class="form-control" placeholder="Exp:1,2,3,4" value="<?php if(isset($request->id)): ?> <?php echo e($request->id ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Item:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_item" class="form-control" placeholder="Search By Item" value="<?php if(isset($request->_item)): ?> <?php echo e($request->_item ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
<?php
$_category_id   = $request->_category_id ?? '';
$item_cateogries  = \DB::table('item_categories')->orderBy('_name','ASC')->get();
?>
                  <div class="form-group row">
                    <label for="_category_id   " class="col-sm-2 col-form-label"><?php echo e(__('label._category_id')); ?>  :</label>
                    <div class="col-sm-10">
                       <select class="form-control" name="_category_id">
                           <option value="">Select <?php echo e(__('label._category_id')); ?></option>
                           <?php $__empty_1 = true; $__currentLoopData = $item_cateogries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                           <option value="<?php echo $category->id ?? ''; ?>"><?php echo $category->_name ?? ''; ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                           <?php endif; ?>
                            
                       </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_unit_id" class="col-sm-2 col-form-label">Unit:</label>
                    <div class="col-sm-10">
                      <select class="form-control _unit_id select2" id="_unit_id" name="_unit_id" >
                                  <option value="" >--Units--</option>
                                  <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($unit->id); ?>" <?php if(isset($request->_unit_id)): ?> <?php if($request->_unit_id==$unit->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($unit->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="_input_type" class="col-sm-2 col-form-label">In Type:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_input_type" class="form-control" placeholder="In Type" value="<?php if(isset($request->_input_type)): ?> <?php echo e($request->_input_type ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">Code:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_code" class="form-control" placeholder="Search By Code" value="<?php if(isset($request->_code)): ?> <?php echo e($request->_code ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_barcode" class="col-sm-2 col-form-label">Model:</label>
                    <div class="col-sm-10">
                       <input type="text" name="_barcode" class="form-control" placeholder="Search By Model" value="<?php if(isset($request->_barcode)): ?> <?php echo e($request->_barcode ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_discount " class="col-sm-2 col-form-label">Discount :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_discount" name="_discount" class="form-control" placeholder="Search By Discount" value="<?php if(isset($request->_discount)): ?> <?php echo e($request->_discount  ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_vat " class="col-sm-2 col-form-label">Vat :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_vat" name="_vat" class="form-control" placeholder="Search By Vat Rate" value="<?php if(isset($request->_vat)): ?> <?php echo e($request->_vat  ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_pur_rate " class="col-sm-2 col-form-label">Purchase Rate :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_pur_rate" name="_pur_rate" class="form-control" placeholder="Search By Purchase Rate" value="<?php if(isset($request->_pur_rate)): ?> <?php echo e($request->_pur_rate  ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_sale_rate " class="col-sm-2 col-form-label">Sales Rate :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_sale_rate" name="_sale_rate" class="form-control" placeholder="Search By Sales Rate" value="<?php if(isset($request->_sale_rate)): ?> <?php echo e($request->_sale_rate  ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_manufacture_company   " class="col-sm-2 col-form-label">Manufacture Company  :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_manufacture_company  " name="_manufacture_company  " class="form-control" placeholder="Manufacture Company" value="<?php if(isset($request->_manufacture_company  )): ?> <?php echo e($request->_manufacture_company   ?? ''); ?>  <?php endif; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_status   " class="col-sm-2 col-form-label">Status  :</label>
                    <div class="col-sm-10">
                       <select class="form-control" name="_status">
                           <option value="">Select</option>
                            <option value="1" <?php if(isset($request->_status)): ?> <?php if($request->_status==1): ?> selected <?php endif; ?> <?php endif; ?>>Active</option>
                             <option value="0" <?php if(isset($request->_status)): ?> <?php if($request->_status==0): ?> selected <?php endif; ?> <?php endif; ?>>In Active</option>
                       </select>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      <?php
                        $cloumns = [ 'id'=>'ID','_item'=>'Item','_code'=>'Code','_barcode'=>'Barcode','_category_id'=>'Category Id','_discount'=>'Discount', '_vat'=>'Vat','_pur_rate'=>'Purchase Rate','_sale_rate'=>'Sales Rate','_manufacture_company'=>'Manufacture Company'];

                      ?>

                                        
                       <select class="form-control" name="asc_cloumn" >
                            <?php $__currentLoopData = $cloumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($request->asc_cloumn)): ?> <?php if($key==$request->asc_cloumn): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>
                     
                     <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Sort Order:</label>
                    <div class="col-sm-10">
                       <select class=" form-control" name="_asc_desc">
                        <?php $__currentLoopData = asc_desc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php if(isset($request->_asc_desc)): ?> <?php if($val==$request->_asc_desc): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                  </div>    
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Limit:</label>
                    <div class="col-sm-10">
                     <select name="limit" class="form-control" >
                              <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option <?php if($limit == $row): ?> selected <?php endif; ?>  value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <?php endif; ?>
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
                                     <a href="<?php echo e(url('cylinder_product')); ?>" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/item-information/cylinder_search.blade.php ENDPATH**/ ?>