
<?php $__env->startSection('title',$page_name); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<style type="text/css">
    .width_150_px{
        width: 150px !important;
    }
    .width_250_px{
        width: 250px !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('admission_fee_collection_list')); ?>"><?php echo $page_name ?? ''; ?> </a>
           
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<div class="container-fluid p-2">
     <?php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';
$_month =  $data->_month_id ?? '';
?>
    
          <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
            
          
    <form action="<?php echo e(route('admission_fee_collection_store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card p-2">
        <div class="row">
            <div class="form-group col-md-2">
            <label for="_date">Date</label>
            <div class="">
            <input type="date" name="_date" class="form-control " value="<?php echo e($data->_date ?? date('Y-m-d')); ?>" required>
            <input type="hidden" name="_stm_division_id" value="<?php echo e($data->_education_type ?? 0); ?>">
            <input type="hidden" name="_class_id" value="<?php echo e($data->_class_id ?? 0); ?>">
            <input type="hidden" name="_master__session_id" value="<?php echo e($data->_session_id ?? 0); ?>">
            <input type="hidden" name="_student_table_id" value="<?php echo e($data->_student_table_id ?? 0); ?>">
                
            </div>
        </div>
        <div class="form-group col-md-2">
            <label for="_roshid_book_no"><?php echo e(__('label._order_number')); ?></label>
            <div class="">
                <input type="text" name="_order_number" class="form-control _order_number " value="<?php echo e(old('_order_number',$data->_order_number ?? '')); ?>" readonly>

                <input type="hidden" name="stm_bill_masters_id" class="form-control stm_bill_masters_id " value="<?php echo e(old('stm_bill_masters_id',$data->stm_bill_masters_id ?? '')); ?>" readonly>
                <input type="hidden" name="stm_collection_masters_id" class="form-control stm_collection_masters_id " value="<?php echo e(old('stm_collection_masters_id',$data->id ?? '')); ?>" readonly>
            </div>
            
        </div>
        <div class="col-md-2">
         <label class="mr-2" for="_month"><?php echo e(__('label._month')); ?><span class="_required">*</span></label>
        <select class="form-control _month" name="_month" required>
            <option value=""><?php echo e(__('label.select')); ?></option>
            <?php $__empty_1 = true; $__currentLoopData = _month_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month_key=>$month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <option value="<?php echo e($month_key); ?>" <?php if($month_key==$_month): ?> selected <?php endif; ?> ><?php echo e($month ?? ''); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </select>
    </div>
      <?php
          $currentYear = date('Y');
          $_year = $data->_year ?? $currentYear;
          $year_start = ($currentYear - 10);
      ?>

      <div class="col-xs-12 col-sm-12 col-md-2">
          <label class="mr-2" for="_year"><?php echo e(__('label._year')); ?><span class="_required">*</span></label>
          <select name="_year" class="form-control" required>
              <?php for($i = $year_start; $i <= $currentYear; $i++): ?>
                  <option value="<?php echo e($i); ?>" <?php if($i == $_year): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
              <?php endfor; ?>
          </select>
      </div>
        

        <div class="form-group <?php if(sizeof($permited_organizations) == 1): ?> display_none <?php endif; ?> col-md-6">
            <label for="organization_id"><?php echo e(__('label.organization_id')); ?></label>
            <div class="width_250_px">
                <select name="organization_id" class="form-control " required>
                <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($org->id); ?>" <?php if($org->id==$data->_organization_id): ?> selected <?php endif; ?> ><?php echo e($org->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
            </div>
            
        </div>

        <div class="form-group <?php if(sizeof($permited_branch) == 1): ?> display_none <?php endif; ?> col-md-6">
            <label for="_branch_id"><?php echo e(__('label._branch_id')); ?></label>
            <select name="_branch_id" class="form-control width_250_px" required>
                <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($branch->id); ?>"  <?php if($branch->id==$data->_branch_id): ?> selected <?php endif; ?>><?php echo e($branch->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group  <?php if(sizeof($permited_costcenters) == 1): ?> display_none <?php endif; ?> col-md-6">
            <label for="_cost_center_id"><?php echo e(__('label._cost_center_id')); ?></label>
            <select name="_cost_center_id" class="form-control width_250_px">
                <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($center->id); ?>" <?php if($center->id==$data->_cost_center_id): ?> selected <?php endif; ?>><?php echo e($center->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>


        <div class="form-group col-md-3">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control width_250_px">
                <option value="_admission_fee">Admission Fee</option>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="_dr_ledger_id">BILL RECEIVE LEDGER</label>
            <select name="_dr_ledger_id" class="form-control width_250_px">
                <option value="<?php echo e($income_ledgers->_admission_fee_ledger ?? 0); ?>"><?php echo e(_ledger_name($income_ledgers->_admission_fee_ledger ?? 0)); ?></option>
            </select>
        </div>
       
        <div class="form-group col-md-3">
            <label for="_roshid_book_no"><?php echo e(__('label._roshid_book_no')); ?></label>
            <input type="text" name="_roshid_book_no" class="form-control _roshid_book_no _width_250_px" value="<?php echo e(old('_roshid_book_no',$data->_roshid_book_no ?? '')); ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="_roshid_no"><?php echo e(__('label._roshid_no')); ?></label>
            <input type="text" name="_roshid_no" class="form-control _roshid_no _width_250_px" value="<?php echo e(old('_roshid_no',$data->_roshid_no ?? '')); ?>">
        </div>

</div>

      <div class="col-md-12">
          <div class="card mt-2">
              <table class="table table-bordered">
                   <thead>
                        <tr>
                        <th>&nbsp;</th>
                        <th><?php echo e(__('label.sl')); ?></th>
                        <th>Division</th>
                        <th>Class </th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Admission Fee</th>
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

$details = $data->_detail ?? [];
?>
                          <?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $d_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
$_grand_total                  +=$d_data->_fee_amount ??  0;
$_grand_due_balance            +=$d_data->_due_balance ??  0;
$_grand_collection_amount      +=$d_data->_collection_amount ??  0;
$_grand_discount_amount        +=$d_data->_discount_amount ??  0;
?>
                          <tr class="_voucher_row">
                                              <td>
                                              

                                                <input type="hidden" name="_student_id[]" value="<?php echo e($d_data->_student_id); ?>">
                                                <input type="hidden" name="_session_id[]" value="<?php echo e($d_data->_session ?? 0); ?>">
                                                <input type="hidden" name="stm_bill_master_details_id[]" value="<?php echo e($d_data->_bill_detail_id ?? 0); ?>">
                                                <input type="hidden" name="stm_bill_collections_id[]" value="<?php echo e($d_data->id ?? 0); ?>">
                                                
                                              </td>
                                              <td><?php echo ($key+1); ?></td>
                                              <td style="white-space: nowrap;"><?php echo $d_data->_division->_name ?? ''; ?>  </td>
                                              <td style="white-space: nowrap;"><?php echo $d_data->_class_info->_name ?? ''; ?>  </td>
                                              
                                              <td style="white-space: nowrap;"><?php echo $d_data->_student->_name_in_english ?? ''; ?>  </td>
                                              <td style="white-space: nowrap;"><?php echo $d_data->_roll_no ?? ''; ?>  </td>
                                            
                                              
                                              
                                             
                                            
                                               <td>
                                                <input type="number" min="0" step="any" name="_admission_fee[]" class="form-control  _total" placeholder="<?php echo e(__('label._total')); ?>" value="<?php echo e(old('_total',$d_data->_fee_amount ?? 0)); ?>" readonly>

                                                <input type="hidden"  type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="<?php echo e(__('label._due_amount')); ?>" value="<?php echo e(old('_due_amount',$d_data->_due_amount ?? 0)); ?>" readonly>
                                              </td>
                                               
                                               <td> 
                                                    <select class="form-control _collection_ledger_id" name="_collection_ledger_id[]" >
                                                    <?php $__empty_2 = true; $__currentLoopData = $collection_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c_ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                     <option value="<?php echo e($c_ledger->id ?? 0); ?>" <?php if($c_ledger->id==$d_data->_collection_ledger_id): ?> selected <?php endif; ?> ><?php echo e($c_ledger->_code ?? ''); ?>-<?php echo e($c_ledger->_name ?? 0); ?></option>
                                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                     <?php endif; ?>
                                                    </select>
                                               </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_collection_amount[]" class="form-control _collection_discount_amount  _collection_amount" placeholder="<?php echo e(__('label._collection_amount')); ?>" value="<?php echo e(old('_collection_amount',$d_data->_collection_amount ?? 0)); ?>" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0"  step="any" name="_discount_amount[]" class="form-control _collection_discount_amount  _discount_amount" placeholder="<?php echo e(__('label._discount_amount')); ?>" value="<?php echo e(old('_discount_amount',$d_data->_discount_amount ?? 0)); ?>" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="<?php echo e(__('label._due_balance')); ?>" value="<?php echo e(old('_due_balance',$d_data->_due_balance ?? 0)); ?>" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0" <?php if($d_data->_is_close==0): ?> selected <?php endif; ?>>Open</option>
                                                  <option value="1" <?php if($d_data->_is_close==1): ?> selected <?php endif; ?>>Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1" <?php if($d_data->_is_effect==1): ?> selected <?php endif; ?>>Yes</option>
                                                  <option value="0" <?php if($d_data->_is_effect==0): ?> selected <?php endif; ?>>No</option>
                                                </select>
                                               </td>
                                            </tr>

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                      </tbody>
                      <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="6">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="<?php echo e($_grand_total); ?>" readonly>
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
            <textarea name="_note" rows="3" class="form-control" required><?php echo old('_note',$data->_note ?? ''); ?></textarea>
        </div>

       
        <div class="text-center p-4">
        <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </form>

</div>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    

$(document).on('keyup','._collection_discount_amount',function(){
  var line_this = $(this);
  var _total = parseFloat(line_this.closest('tr').find('._total').val());
  if(isNaN(_total)){_total=0}
  var _due_amount = parseFloat(line_this.closest('tr').find('._due_amount').val());
  if(isNaN(_due_amount)){_due_amount=0}
  var _receive_amount = 0;

  var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}

  var _discount_amount = parseFloat(line_this.closest('tr').find('._discount_amount').val());
  if(isNaN(_discount_amount)){_discount_amount=0}

  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)-parseFloat(_discount_amount)).toFixed(2);

if(_due_balance < 0 ){
  _due_balance = 0;
  line_this.closest('tr').find('._collection_amount').val(_due_amount);
   var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}
line_this.closest('tr').find('._discount_amount').val(0);
  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)).toFixed(2);

}
line_this.closest('tr').find('._due_balance').val(_due_balance);



 // Check if the _is_close value is already the same to prevent triggering the change event again
    var $isCloseField = line_this.closest('tr').find('._is_close');
    var currentCloseValue = $isCloseField.val();
    
    if (_due_balance == 0) {
        // Set value to 1 only if it's not already 1
        if (currentCloseValue != 1) {
            $isCloseField.val(1).change();
        }
    } else {
        // Set value to 0 only if it's not already 0
        if (currentCloseValue != 0) {
            $isCloseField.val(0).change();
        }
    }

 

payment_total_calculatins();

})

$(document).on('keyup','._discount_amount',function(){
    
})


$(document).on('change','._is_close',function(){
  var _is_close  = $(this).closest('tr').find('._is_close').val();
  var _due_balance  = $(this).closest('tr').find('._due_balance').val();
   if(isNaN(_due_balance)){_due_balance=0}
  if(_due_balance !=0){
   // alert('Due Amount Must be Zero to Close this Invoice');
    $(this).closest('tr').find('._is_close').val(0).change();
  }


});

function payment_total_calculatins(){
  var _grand_total          = 0;
  var _grand_receive_amount = 0;
  var _grand_due_amount       = 0;
  var _grand_collection_amount = 0;
  var _grand_discount_amount = 0;
  var _grand_due_balance = 0;
 $(document).find('._total').each(function(index){
     var _total =parseFloat($(this).val());
     if(isNaN(_total)){_total=0}
      _grand_total +=_total;



  var line_total             = parseFloat($(document).find("._total").eq(index).val());
  if(isNaN(line_total)){line_total=0}
  var line_receive_amount    = parseFloat($(document).find("._receive_amount").eq(index).val());
  if(isNaN(line_receive_amount)){line_receive_amount=0}
  var line_due_amount        = parseFloat($(document).find("._due_amount").eq(index).val());
  if(isNaN(line_due_amount)){line_due_amount=0}
  var line_collection_amount = parseFloat($(document).find("._collection_amount").eq(index).val());
  if(isNaN(line_collection_amount)){line_collection_amount=0}


  var line_discount_amount = parseFloat($(document).find("._discount_amount").eq(index).val());
  if(isNaN(line_discount_amount)){line_discount_amount=0}

  var _due_balance  = parseFloat(parseFloat(line_due_amount)-parseFloat(line_collection_amount)-parseFloat(line_discount_amount)).toFixed(2);
  $(document).find("._due_balance").eq(index).val(_due_balance);




 })
 $(document).find('._receive_amount').each(function(){
     var _receive_amount =parseFloat($(this).val());
     if(isNaN(_receive_amount)){_receive_amount=0}
      _grand_receive_amount +=_receive_amount;
 })
 $(document).find('._due_amount').each(function(){
     var _due_amount =parseFloat($(this).val());
     if(isNaN(_due_amount)){_due_amount=0}
      _grand_due_amount +=_due_amount;
 })

 $(document).find('._collection_amount').each(function(){
     var _collection_amount =parseFloat($(this).val());
     if(isNaN(_collection_amount)){_collection_amount=0}
      _grand_collection_amount +=_collection_amount;
 })

 $(document).find('._discount_amount').each(function(){
     var _discount_amount =parseFloat($(this).val());
     if(isNaN(_discount_amount)){_discount_amount=0}
      _grand_discount_amount +=_discount_amount;
 })

 $(document).find('._due_balance').each(function(){
     var _due_balance =parseFloat($(this).val());
     if(isNaN(_due_balance)){_due_balance=0}
      _grand_due_balance +=_due_balance;
 })

 $(document).find("._grand_total").val(_grand_total);
 $(document).find("._grand_receive_amount").val(_grand_receive_amount);
 $(document).find("._grand_collection_amount").val(_grand_collection_amount);
 $(document).find("._grand_discount_amount").val(_grand_discount_amount);
 $(document).find("._grand_due_amount").val(_grand_due_amount);
 $(document).find("._grand_due_balance").val(_grand_due_balance);



}
 
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/stm_bill_masters/admission_fee_collection_edit.blade.php ENDPATH**/ ?>