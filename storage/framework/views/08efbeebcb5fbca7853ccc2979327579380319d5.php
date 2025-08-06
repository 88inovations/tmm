
<?php
$_student_table_id  = $student_info->id;
$_user_table_id  = $student_info->_user_table_id;
$_admission_session_id = $student_info->_admission_session_id ?? 0;
$_stm_division_id = $student_info->_education_type ?? 0;
$_admission_class_id = $request->_admission_class_id ?? 0;
 $_bill_type          = $request->_bill_type;

?>


<div  class="p-2 purple_bg">
<?php if(sizeof($datas) > 0): ?>
    <form action="<?php echo e(route('stm_collection.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card p-2 purple_bg" >
        <div class="row">
        <div class="form-group col-md-3">
            <label for="_date">Date</label>
            <div class="width_250_px">
            <input type="date" name="_date" class="form-control " value="<?php echo e(date('Y-m-d')); ?>" required>
            
            <input type="hidden" name="_student_table_id" value="<?php echo e($_student_table_id ?? 0); ?>">
            <input type="hidden" name="_user_table_id" value="<?php echo e($_user_table_id ?? 0); ?>">
           
            <input type="hidden" name="_admission_class_id" value="<?php echo e($_admission_class_id ?? 0); ?>">
            <input type="hidden" name="_form_name" value="stm_collection_masters">
            <input type="hidden" name="stm_collection_id" value="0">
                
            </div>
        </div>

        <div class="col-md-3 col-sm-12">
            <label for="_stm_division_id"><?php echo e(__('label._admission_session_id')); ?></label>
            <select class="form-control _admission_session_id" name="_admission_session_id">
                <option value="<?php echo e($_admission_session_id); ?>">
                <?php echo _id_to_name($_admission_session_id,'_name','stm_education_sessions'); ?></option>
            </select>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_stm_division_id"><?php echo e(__('label._stm_division_id')); ?></label>
            <select class="form-control _stm_division_id" name="_stm_division_id">
                <option value="<?php echo e($_stm_division_id); ?>">
                <?php echo _id_to_name($_stm_division_id,'_name','stm_divisions'); ?></option>
            </select>
            
        </div>

        <div class="col-md-3 col-sm-12">
            <label for="_admission_class_id"><?php echo e(__('label._admission_class_id')); ?></label>
            <select class="form-control _admission_class_id" name="_admission_class_id">
                <option value="<?php echo e($_admission_class_id); ?>">
                <?php echo _id_to_name($_admission_class_id,'_name','stm_classes'); ?></option>
            </select>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_student_id"><?php echo e(__('label._student_id')); ?></label>
            <input type="text" name="_student_id" class="form-control _student_id" value="<?php echo $student_info->_student_id ?? ''; ?>" readonly>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_name_in_english"><?php echo e(__('label._name_in_english')); ?></label>
            <input type="text" name="_name_in_english" class="form-control _name_in_english" value="<?php echo $student_info->_name_in_english ?? ''; ?>" readonly>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_father_name_english"><?php echo e(__('label._father_name_english')); ?></label>
            <input type="text" name="_father_name_english" class="form-control _father_name_english" value="<?php echo $student_info->_father_name_english ?? ''; ?>" readonly>
            
        </div>

        <div class="form-group <?php if(sizeof($permited_organizations) == 1): ?> display_none <?php endif; ?> col-md-3">
            <label for="organization_id"><?php echo e(__('label.organization_id')); ?></label>
            <div class="">
                <select name="organization_id" class="form-control " required>
                <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($org->id); ?>"><?php echo e($org->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
            </div>
            
        </div>

        <div class="form-group <?php if(sizeof($permited_branch) == 1): ?> display_none <?php endif; ?> col-md-3">
            <label for="_branch_id"><?php echo e(__('label._branch_id')); ?></label>
            <select name="_branch_id" class="form-control " required>
                <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group  <?php if(sizeof($permited_costcenters) == 1): ?> display_none <?php endif; ?> col-md-3">
            <label for="_cost_center_id"><?php echo e(__('label._cost_center_id')); ?></label>
            <select name="_cost_center_id" class="form-control ">
                <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($center->id); ?>"><?php echo e($center->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>

<?php
$bill_types =_fees_types();
$_bill_type  = $request->_bill_type ?? '_admission_fee';
$_make_ledger_coloumn_name = $_bill_type.'_ledger';
?>
       <div class="form-group col-md-3">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control ">
                <option value="<?php echo e($_bill_type); ?>"><?php echo e($bill_types[$_bill_type] ?? ''); ?></option>
            </select>
        </div>

       
        <div class="form-group col-md-3">
            <label for="_roshid_book_no"><?php echo e(__('label._roshid_book_no')); ?></label>
            <input type="text" name="_roshid_book_no" class="form-control _roshid_book_no " value="<?php echo e(old('_roshid_book_no',$data->_roshid_book_no ?? '')); ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="_roshid_no"><?php echo e(__('label._roshid_no')); ?></label>
            <input type="text" name="_roshid_no" class="form-control _roshid_no " value="<?php echo e(old('_roshid_no',$data->_roshid_no ?? '')); ?>">
        </div>
</div>
</div>
      <div class="col-md-12">
          <div class="card">
              <table class="table table-bordered">
                   <thead>
                        <tr>
                        <th>&nbsp;</th>
                        <th><?php echo e(__('label.sl')); ?></th>
                        <th>Month </th>
                        <th>Year </th>
                        <th>Fee </th>
                        <th>Pre. Receive </th>
                        <th>Pre. Due Amount </th>
                        <th><?php echo e(__('label._collection_ledger')); ?></th>
                        <th><?php echo e(__('label.collect_amount')); ?></th>
                        <th><?php echo e(__('label._discount_amount')); ?></th>
                        <th><?php echo e(__('label.current_due')); ?></th>
                        <th><?php echo e(__('label._is_close')); ?></th>
                        <th><?php echo e(__('label.effect')); ?></th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
$_grand_total   = 0;
$_grand_receive_amount   = 0;
$_grand_due_amount   = 0;
$_grand_collection_amount   = 0;
$_grand_discount_amount   = 0;
$_grand_due_balance   = 0;
?>
                          <?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
$_grand_total                   +=$data->_fee_amount ??  0;
$_grand_due_balance             +=$data->_due_amount ??  0;
$_grand_receive_amount          +=$data->_receive_amount ??  0;
$_grand_due_amount              +=$data->_due_amount ??  0;
$_grand_discount_amount         +=$data->_discount_amount ??  0;
?>
                          <tr class="_voucher_row">
                                              <td>
                                                

                                                <input type="hidden" name="_session_id[]" value="<?php echo e($data->_session_id ?? 0); ?>">
                                                <input type="hidden" name="_month_id[]" value="<?php echo e($data->_month_id ?? 0); ?>">
                                                <input type="hidden" name="_year[]" value="<?php echo e($data->_year ?? 0); ?>">
                                                <input type="hidden" name="stm_bill_master_details_id[]" value="<?php echo e($data->id ?? 0); ?>">
                                                <input type="hidden" name="stm_bill_collections_id[]" value="0">
                                                
                                              </td>
                                              <td><?php echo ($key+1); ?></td>
                                              <td style="white-space: nowrap;"><?php echo _number_to_month($data->_month_id ?? '' ); ?>  </td>
                                              <td style="white-space: nowrap;"><?php echo $data->_year ?? ''; ?>  </td>
                                              
                                            
                                              
                                              
                                             
                                            
                                               <td>
                                                <input type="number" min="0" step="any" name="_fee_amount[]" class="form-control  _total" placeholder="<?php echo e(__('label._total')); ?>" value="<?php echo e(old('_total',$data->_fee_amount ?? 0)); ?>" readonly>

                                                
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_receive_amount[]" class="form-control  _receive_amount" placeholder="Receive Amount" value="<?php echo e($data->_receive_amount ?? 0); ?>" readonly="">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="Due Amount" value="<?php echo e($data->_due_amount ?? 0); ?>" readonly="">
                                              </td>
                                               
                                               <td> 
                                                    <select class="form-control _collection_ledger_id" name="_collection_ledger_id[]" >
                                                    <?php $__empty_2 = true; $__currentLoopData = $collection_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c_ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                     <option value="<?php echo e($c_ledger->id ?? 0); ?>"><?php echo e($c_ledger->_code ?? ''); ?>-<?php echo e($c_ledger->_name ?? 0); ?></option>
                                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                     <?php endif; ?>
                                                    </select>
                                               </td>
                                               <td>
                                                <input type="number"  type="number" min="0" max="<?php echo e($data->_fee_amount ?? 0); ?>" step="any" name="_collection_amount[]" class="form-control _collection_discount_amount  _collection_amount" placeholder="<?php echo e(__('label._collection_amount')); ?>" value="<?php echo e(old('_collection_amount',$data->_collection_amount ?? 0)); ?>" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0"  step="any" name="_discount_amount[]" class="form-control _collection_discount_amount  _discount_amount" placeholder="<?php echo e(__('label._discount_amount')); ?>" value="<?php echo e(old('_discount_amount',$data->_discount_amount ?? 0)); ?>" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="<?php echo e(__('label._due_balance')); ?>" value="<?php echo e(old('_due_balance',$data->_due_amount ?? 0)); ?>" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0">Open</option>
                                                  <option value="1">Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1">Yes</option>
                                                  <option value="0">No</option>
                                                </select>
                                               </td>
                                            </tr>

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                      </tbody>
                      <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="4">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="<?php echo e($_grand_total); ?>" readonly>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_grand_receive_amount" class="form-control  _grand_receive_amount" placeholder="Receive Amount" value="<?php echo e($_grand_receive_amount ?? 0); ?>" readonly="">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_grand_due_amount" class="form-control  _grand_due_amount" placeholder="Due Amount" value="<?php echo e($_grand_due_amount ?? 0); ?>" readonly="">
                                              </td>
                                              <td></td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_collection_amount" class="form-control  _grand_collection_amount" placeholder="<?php echo e(__('label._collection_amount')); ?>" value="<?php echo e($_grand_collection_amount); ?>" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_discount_amount" class="form-control  _grand_discount_amount" placeholder="<?php echo e(__('label._discount_amount')); ?>" value="<?php echo e($_grand_discount_amount); ?>" readonly>
                                              </td>
                                              
                                               
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_balance" class="form-control  _grand_due_balance" placeholder="label._due_balance" value="<?php echo e($_grand_due_balance); ?>" readonly="">
                                              </td>
                                             
                                             
                                              <td> </td>
                                               <td></td>
                                            </tr>
                                          </tfoot>
              </table>
          </div>
      </div>
      

        <div class="form-group">
            <label for="_note">Note <span class="_required">*</span></label>
            <textarea name="_note" rows="3" class="form-control" required><?php echo old('_note'); ?></textarea>
        </div>

       
        <div class="text-center p-4">
        <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </form>
<?php else: ?>

<h3 class="text-center">No Data Found</h3>
<?php endif; ?>

</div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/stm_collection/due_bill_search_form.blade.php ENDPATH**/ ?>