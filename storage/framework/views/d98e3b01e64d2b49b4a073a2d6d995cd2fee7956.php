
<?php $__env->startSection('title',$page_name ?? '' ); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name" ><?php echo e($page_name ?? ''); ?> </h1>
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
                <form method="POST" action="<?php echo e(route('account_group_configs_save')); ?>" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
                   
                     
                            
                            
                        <?php
$all_groups =\DB::table('account_groups')->get();

$_employee_groups= $data->_employee_group ?? '';
$_employee_group_array = explode(",",$_employee_groups);

$_direct_inc_exp_heads= $data->_direct_inc_exp_heads ?? '';
$_direct_inc_exp_heads_array = explode(",",$_direct_inc_exp_heads);

$_indirect_inc_exp_heads= $data->_indirect_inc_exp_heads ?? '';
$_indirect_inc_exp_heads_array = explode(",",$_indirect_inc_exp_heads);

$_direct_income_group= $data->_direct_income_group ?? '';
$_direct_income_group_array = explode(",",$_direct_income_group);

$_indirect_income_group= $data->_indirect_income_group ?? '';
$_indirect_income_group_array = explode(",",$_indirect_income_group);

$_direct_expense_group= $data->_direct_expense_group ?? '';
$_direct_expense_group_array = explode(",",$_direct_expense_group);

$_indirect_expense_group= $data->_indirect_expense_group ?? '';
$_indirect_expense_group_array = explode(",",$_indirect_expense_group);

$_cash_group= $data->_cash_group ?? '';
$_cash_group_array = explode(",",$_cash_group);

$_bank_group= $data->_bank_group ?? '';
$_bank_group_array = explode(",",$_bank_group);

$_customer_group= $data->_customer_group ?? '';
$_customer_group_array = explode(",",$_customer_group);

$_supplier_group= $data->_supplier_group ?? '';
$_supplier_group_array = explode(",",$_supplier_group);

$_honorarium_group= $data->_honorarium_group ?? '';
$_honorarium_group_array = explode(",",$_honorarium_group);

$_student_groups= $data->_student_groups ?? '';
$_student_groups_array = explode(",",$_student_groups);

                            ?>   
                        
                       
                          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_management')): ?>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._student_groups')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_student_groups[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_student_groups_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                    
                                </div>
                                
                            </div>
                        <?php endif; ?>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._employee_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_employee_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_employee_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                    <input type="hidden" name="id" value="<?php echo e($data->id ?? ''); ?>">
                                </div>
                                
                            </div>
                            
                          
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._honorarium_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_honorarium_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_honorarium_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                    <input type="hidden" name="id" value="<?php echo e($data->id ?? ''); ?>">
                                </div>
                                
                            </div>
                            
                          
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._direct_inc_exp_heads')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_direct_inc_exp_heads[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_direct_inc_exp_heads_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._indirect_inc_exp_heads')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_indirect_inc_exp_heads[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_indirect_inc_exp_heads_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._direct_income_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_direct_income_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_direct_income_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._indirect_income_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_indirect_income_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_indirect_income_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._direct_expense_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_direct_expense_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_direct_expense_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._indirect_expense_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_indirect_expense_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_indirect_expense_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._cash_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_cash_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_cash_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._bank_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_bank_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_bank_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._customer_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_customer_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_customer_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2"><?php echo e(__('label._supplier_group')); ?>:</label>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <select class="form-control select2" name="_supplier_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_supplier_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            

                           
                            
                          
                        

                       
                        
                        <div class="col-xs-12 col-sm-12 col-md-6 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>
                        <br><br>
                    
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/account-group/account_group_configs.blade.php ENDPATH**/ ?>