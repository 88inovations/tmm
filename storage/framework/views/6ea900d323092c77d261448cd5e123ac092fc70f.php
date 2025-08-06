
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('account-ledger.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-create')): ?>
              <li class="breadcrumb-item active">
                  
   <button type="button" 
       class="btn btn-sm btn-info active attr_base_create_url" 
       data-toggle="modal" data-target="#commonEntryModal_item" 
       attr_base_create_url="<?php echo e(route('account-ledger.create')); ?>">
        <i class="nav-icon fas fa-plus"></i> Create New
       </button>
                 


               </li>
              <?php endif; ?>
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success">
      <p><?php echo e($message); ?></p>
    </div>
    <?php endif; ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 

                  <div class="row">
                   <?php

 $currentURL = URL::full();
 $current = URL::current();
if($currentURL === $current){
   $print_url = $current."?print=single";
   $print_url_detal = $current."?print=detail";
}else{
     $print_url = $currentURL."&print=single";
     $print_url_detal = $currentURL."&print=detail";
}
    

                   ?>
                    <div class="col-md-4">
                      <?php echo $__env->make('backend.account-ledger.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-print')): ?>
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="<?php echo e($print_url); ?>" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i> Print
                                </a>  
                            </li>
                             <?php endif; ?>   
                         <?php echo $datas->render(); ?>

                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table" >
                      <thead>
                        <tr>
                         <th>SL</th>
                         <th class="">Action</th>
                         <th>Type</th>
                         <th>Group</th>
                         <th><?php echo e(__('label._branch_id')); ?></th>
                         <th>Ledger ID</th>
                         <th>Ledger Name</th>
                         <th>Code</th>
                         
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Credit Limit</th>
                         <th>Balance</th>
                         <th>Note</th>
                         <th>Possition</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                       $_new_datas=array();
                        foreach ($datas as $value) {
                            $_new_datas[$value->_account_head_id ?? ''."-".$value->account_type->_name ?? ''][$value->_account_group_id ?? ''."-".$value->account_group->_name ?? ''][]=$value;
                        }
                      ?>
                        
                           <?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>
                           <td><?php echo e(($key3+1)); ?></td>
                           <td style="display: flex;">
                           
                                <a 
                                  href="<?php echo e(route('account-ledger.show',$data->id)); ?>"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-edit')): ?>
                                     <button type="button" 
                                     class="btn btn-sm btn-info active attr_base_edit_url mr-2" 
                                     data-toggle="modal" data-target="#commonEntryModal_item" 
                                    attr_base_edit_url="<?php echo e(route('account-ledger.edit',$data->id)); ?>">
                                      <i class="fa fa-pen "></i>
                                     </button>
                                  <?php endif; ?>
                                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-module')): ?>
                                  <?php if(in_array($data->_account_group_id,$_employee_group_array)): ?>
                                     <a class="btn btn-sm  mr-2" title="Copy To Employee" target="__blank" href="<?php echo e(url('copy_to_employee')); ?>/<?php echo e($data->id); ?>"><i class="fa fa-copy"></i></a>
                                  <?php endif; ?>
                                  <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-delete')): ?>
                                 <?php echo Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $data->id],'style'=>'display:inline']); ?>

                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  <?php echo Form::close(); ?>

                               <?php endif; ?>  
                               
                        </td>

                          
                             
                            <td><?php echo e($data->account_type->_name ?? ''); ?></td>
                            <td><?php echo e($data->account_group->_name ?? ''); ?></td>
                            <td><?php echo e($data->_entry_branch->id ?? ''); ?>-<?php echo e($data->_entry_branch->_name ?? ''); ?></td>
                            <td><a href="<?php echo e(url('full_ledger_detail')); ?>?_ledger_id=<?php echo e($data->id); ?>"><?php echo e($data->id); ?></a></td>
                            <td><a href="<?php echo e(url('full_ledger_detail')); ?>?_ledger_id=<?php echo e($data->id); ?>"><?php echo e($data->_name); ?></a></td>
                            <td><a href="<?php echo e(url('full_ledger_detail')); ?>?_ledger_id=<?php echo e($data->id); ?>"><?php echo e($data->_code ?? ''); ?></a></td>
                            
                            <td><?php echo e($data->_email ?? ''); ?></td>
                            <td><?php echo e($data->_phone ?? ''); ?></td>
                            
                            
                           
                            <td><?php echo e(_report_amount($data->_credit_limit)); ?></td>
                            <td><?php echo e(_show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))); ?></td>
                            <td><?php echo e($data->_note ?? ''); ?></td>
                            <td><?php echo e($data->_short ?? ''); ?></td>
                           <td><?php echo e(selected_status($data->_status)); ?></td>
                           
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                       
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 <?php echo $datas->render(); ?>

                </div>
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/account-ledger/index.blade.php ENDPATH**/ ?>