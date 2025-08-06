 <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong> Receive Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>ID</th>
                                            <th>Ledger</th>
                                            <?php if(sizeof($permited_branch)>1): ?>
                                               <th>Branch</th>
                                              <?php else: ?>
                                               <th class="display_none">Branch</th>
                                              <?php endif; ?>
                                              <?php if(sizeof($permited_costcenters)>1): ?>
                                                <th>Cost Center</th>
                                              <?php else: ?>
                                                <th class="display_none">Cost Center</th>
                                              <?php endif; ?>
                                            <th>Short Narr.</th>
                                            <th>Receive Amount</th>
                                            <th style="display: none;">Cr. Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details form_body" id="area__voucher_details">
                                            <?php
                                              $_account_dr_total = 0;
                                              $_account_cr_total = 0;
                                              $s_accounts =  $data->s_account ?? [];
                                            ?>

                                            <?php if(sizeof($s_accounts) > 0): ?>
                                            <?php $__empty_1 = true; $__currentLoopData = $data->s_account; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            

                                            <?php
                                              $_account_dr_total += $account->_dr_amount ?? 0;
                                              $_account_cr_total += $account->_cr_amount ?? 0;
                                            ?>
                                            <?php if($data->_ledger_id !=$account->_ledger_id): ?>
                                            <tr class="_voucher_row  ">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <?php echo e($account->id); ?>

                                                <input type="hidden" name="purchase_account_id[]" class="form-control purchase_account_id" value="<?php echo e($account->id); ?>">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger" value="<?php echo e($account->_ledger->_name ?? ''); ?>" <?php if($__user->_ac_type==1): ?> attr_account_head_no="<?php echo e(_cash_bank_type_id()); ?>" <?php endif; ?>>
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" value="<?php echo e($account->_ledger_id); ?>" >
                                                <div class="search_box">
                                                  
                                                </div>
                                              </td>
                                              
                                              <td class="<?php if(sizeof($permited_branch)==1): ?> display_none <?php endif; ?>">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  <?php $__empty_2 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                  <option value="<?php echo e($branch->id); ?>" <?php if(isset($account->_branch_id)): ?> <?php if($account->_branch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->_name ?? ''); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                  <?php endif; ?>
                                                </select>
                                              </td>
                                              <td class="<?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required  >
                                            
                                                  <?php $__empty_2 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costcenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                  <option value="<?php echo e($costcenter->id); ?>" <?php if(isset($account->_cost_center)): ?> <?php if($account->_cost_center == $costcenter->id): ?> selected <?php endif; ?>   <?php endif; ?>> <?php echo e($costcenter->_name ?? ''); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                  <?php endif; ?>
                                                </select>
                                              </td>
                                              
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr" value="<?php echo e($account->_short_narr ?? ''); ?>">
                                              </td>
                                              <td>
                                                <input type="number" min="0"  name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="<?php echo e(old('_dr_amount',$account->_dr_amount ?? 0 )); ?>">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" min="0"  name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="<?php echo e(old('_cr_amount',$account->_cr_amount ?? 0 )); ?>">
                                              </td>
                                            </tr>
                                             <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              
                                               <td class="<?php if(sizeof($permited_branch)==1): ?> display_none <?php endif; ?>"></td>
                                              <td class="<?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>"></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td>
                                                <input type="number" min="0"  step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="<?php echo e(_php_round($_account_dr_total)); ?>" readonly required>
                                              </td>


                                              <td class="display_none">
                                                <input type="number" min="0"  step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="<?php echo e(_php_round($_account_cr_total)); ?>" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/sales/edit_ac_cb.blade.php ENDPATH**/ ?>