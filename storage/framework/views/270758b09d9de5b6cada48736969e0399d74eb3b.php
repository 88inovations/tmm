
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="<?php echo e(route('account-ledger.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="<?php echo e(route('account-ledger.index')); ?>"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               <?php endif; ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                 <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>
             
              <div class="card-body">
                <?php echo Form::open(array('route' => 'account-ledger.store','method'=>'POST')); ?>

                   
                      
                      <div class="form-group row">
                                <label class="col-md-2">Account Type: <span class="_required">*</span></label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                               <select type_base_group="<?php echo e(url('type_base_group')); ?>" class="form-control _account_head_id " name="_account_head_id" required>
                                  <option value="">--Select Account Type--</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($account_type->id); ?>"  <?php if(old('_account_head_id') == $account_type->id): ?> selected <?php endif; ?>  <?php if($account_type->_has_child==1): ?> disabled <?php endif; ?> ><?php echo e($account_type->id ?? ''); ?>-<?php echo e($account_type->_name ?? ''); ?></option>

                                  <?php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  ?>
                                  <?php $__empty_2 = true; $__currentLoopData = $_child_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <option value="<?php echo e($group->id); ?>"  <?php if(old('_account_head_id') == $group->id): ?> selected <?php endif; ?>   > &nbsp; &nbsp; &nbsp; &nbsp;<?php echo e($group->id ?? ''); ?>-<?php echo e($group->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                  <?php endif; ?>

                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                       
                            <div class="form-group row">
                                <label  class="col-md-2">Account Group:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                               <select class="form-control _account_groups " name="_account_group_id" required>
                                  <option value="">--Select Account Group--</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $account_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($account_group->id); ?>"  <?php if(old('_account_group_id') == $account_group->id): ?> selected <?php endif; ?>   ><?php echo e($account_group->id ?? ''); ?> - <?php echo e($account_group->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            $users = \Auth::user();
                            $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                            $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
                            ?> 


                          
                             <div class="form-group row <?php if(sizeof($permited_organizations)==1): ?> display_none <?php endif; ?>">
                                  <label  class="col-md-2"><?php echo __('label.organization'); ?>:<span class="_required">*</span></label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control _ledger_organization_id" name="organization_id" required >

                                   
                                   <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                   <option value="<?php echo e($val->id); ?>" <?php if(isset($request->organization_id)): ?> <?php if($request->organization_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                   <?php endif; ?>
                                 </select>
                             </div>
                            </div>
                            
                            <div class="form-group row">
                                 <label  class="col-md-2">Branch:<span class="_required">*</span></label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                               <select class="form-control" name="_branch_id" required >
                                  
                                  <?php $__empty_1 = true; $__currentLoopData = $branchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($branch->id); ?>" <?php if(isset($request->_branch_id)): ?> <?php if($request->_branch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        
                         <div class="form-group row  <?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>">
                              <label  class="col-md-2">Cost Center:<span class="_required">*</span></label>
                              <div class="col-xs-12 col-sm-12 col-md-6">
                            <select class="form-control _ledger_cost_center_id" name="_cost_center_id" required >
                               
                               <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($cost_center->id); ?>" <?php if(isset($request->_cost_center_id)): ?> <?php if($request->_cost_center_id == $cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
                         </div>
                        </div>
                       
                            <div class="form-group row">
                                 <label  class="col-md-2">Code:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_code" class="form-control" value="<?php echo e(old('_code')); ?>" placeholder="CODE Number">
                            </div>
                        </div>
                            <div class="form-group row">
                                 <label  class="col-md-2">Ledger Name:<span class="_required">*</span></label>
                              <div class="col-xs-12 col-sm-12 col-md-6">  
                                <input type="text" name="_name" class="form-control" value="<?php echo e(old('_name')); ?>" placeholder="Ledger Name" required>
                            </div>
                        </div>
                         <div class="form-group row">
                                 <label  class="col-md-2">Proprietor:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_alious" class="form-control" value="<?php echo e(old('_alious')); ?>" placeholder="Proprietor">
                            </div>
                        </div>
                            <div class="form-group row">
                                 <label  class="col-md-2">Email:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="email" name="_email" class="form-control" value="<?php echo e(old('_email')); ?>" placeholder="Email" >
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Phone:</label>
                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" name="_phone" class="form-control" value="<?php echo e(old('_phone')); ?>" placeholder="Phone" >
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Address:</label>
                                
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <textarea name="_address" class="form-control" placeholder="Address"><?php echo e(old('_address')); ?></textarea>
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Details:</label>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <textarea name="_note" class="form-control" placeholder="Details"></textarea>
                                   
                                </div>
                            </div>
                           
                        
                            <div class="form-group row display_none" >
                                 <label  class="col-md-2">Display Possition:</label>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                <?php echo Form::text('_short', null, array('placeholder' => 'Possition','class' => 'form-control')); ?>

                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">NID Number:</label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                               <input type="text" name="_nid" class="form-control" value="<?php echo e(old('_nid')); ?>" placeholder="NID Number">
                            </div>
                        </div>
                        
                       
                            <div class="form-group row">
                                 <label  class="col-md-2">Credit Limit:</label>
                             <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="number" step="any" name="_credit_limit" class="form-control" value="<?php echo e(old('_credit_limit',0)); ?>" placeholder="Credit Limit" >
                            </div>
                        </div>
                       
                        <?php
$yes_nos =[1=>'Yes',0=>'No'];
                        ?>
                           
                        
                            <div class="form-group row ">
                                 <label  class="col-md-2">Sales Form:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_sales_form">
                                  <?php $__currentLoopData = $yes_nos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$s_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key); ?>"><?php echo e($s_val); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row ">
                                 <label  class="col-md-2">Is Purchase Form:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_purchase_form">
                                  <?php $__currentLoopData = $yes_nos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$s_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key); ?>"><?php echo e($s_val); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                 <label  class="col-md-2">Search For All Branch:</label>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_is_all_branch">
                                  <?php $__currentLoopData = $yes_nos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$s_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key); ?>"><?php echo e($s_val); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Opening Dr Amount:</label>
                                  <div class="col-xs-12 col-sm-12 col-md-6">
                                <input id="opening_dr_amount" type="number" name="opening_dr_amount" class="form-control" placeholder="Dr Amount" value="0" step="any" min="0">
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                 <label  class="col-md-2">Opening Cr Amount:</label>
                                  <div class="col-xs-12 col-sm-12 col-md-6">
                                <input id="opening_cr_amount" type="number" name="opening_cr_amount" class="form-control" placeholder="Cr Amount" value="0" step="any" min="0">
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                 <label  class="col-md-2">Status:</label>
                                  <div class="col-xs-12 col-sm-12 col-md-6">
                                <select class="form-control" name="_status">
                                  <?php $__currentLoopData = common_status(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$s_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key); ?>"><?php echo e($s_val); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


<?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/account-ledger/create_ajax.blade.php ENDPATH**/ ?>