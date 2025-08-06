
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

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('stm_bill_masters.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_students_create')): ?>
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="<?php echo e(route('stm_bill_masters.create')); ?>">
                   <i class="nav-icon fas fa-plus"></i> <?php echo e(__('label.create_new')); ?>

                </a>

               </li>
              <?php endif; ?>

              
                 <div class="col-md-3">

            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<div class="container">
<div class="container">
     <?php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_bill_type =  $request->_bill_type ?? '';
$_month =  $request->_month ?? '';
$_year =  $request->_year ?? '';







?>
    
          <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
            
           <form class="mb-2" action="<?php echo e(route('stm_bill_masters.create')); ?>" method="GET">
            <?php echo csrf_field(); ?>
                
                      <div class="report_box">
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._admission_session_id')); ?>:<span class="_required">*</span></label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id" required>
                                      <option value="">Select Session</option>
                                      <?php $__empty_1 = true; $__currentLoopData = $stm_education_sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($session->id); ?>"
                                         <?php if($_admission_session_id ==$session->id): ?> selected <?php endif; ?> > <?php echo $session->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
                                </div>
                                <input type="hidden" name="search" value="search">
                            </div>
                        
                   
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._education_type')); ?>:<span class="_required">*</span></label>
                                    <select class="form-control _education_type" name="_education_type" required>
                                      <option value="">Select <?php echo e(__('label._education_type')); ?></option>
                                      <?php $__empty_1 = true; $__currentLoopData = $edu_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($type->id); ?>"
                                         <?php if($_education_type ==$type->id): ?> selected <?php endif; ?> > <?php echo $type->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._admission_class_id')); ?>:<span class="_required">*</span></label>
                                    <select class="form-control _admission_class_id" name="_admission_class_id" required>
                                      <option value="">Select Class</option>
                                      <?php $__empty_1 = true; $__currentLoopData = $edu_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($class->id); ?>"
                                         <?php if($_admission_class_id ==$class->id): ?> selected <?php endif; ?> > <?php echo $class->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
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
                                  $_year = $request->_year ?? $currentYear;
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
<?php                     
$bill_types =_fees_types();
?>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <label class="mr-2" for="_bill_type"><?php echo e(__('label._bill_type')); ?><span class="_required">*</span></label>
                                  <select name="_bill_type" class="form-control" required>
                                      <?php $__empty_1 = true; $__currentLoopData = $bill_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill_key=>$lebel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                          <option value="<?php echo e($bill_key); ?>" <?php if($bill_key == $_bill_type): ?> selected <?php endif; ?>><?php echo e($lebel); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                  </select>
                              </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 mt-3 ">
                                   <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search "></i> Search</button>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>
</div>





<?php if(sizeof($datas) > 0): ?>
    <form action="<?php echo e(route('stm_bill_masters.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card p-2">
        <div class="row">
        <div class="form-group col-md-6">
            <label for="_date">Date</label>
            <div class="width_250_px">
            <input type="date" name="_date" class="form-control " value="<?php echo e(date('Y-m-d')); ?>" required>
            <input type="hidden" name="_master__session_id" value="<?php echo e($_admission_session_id ?? 0); ?>">
            <input type="hidden" name="_stm_division_id" value="<?php echo e($_education_type ?? 0); ?>">
            <input type="hidden" name="_class_id" value="<?php echo e($_admission_class_id ?? 0); ?>">
            <input type="hidden" name="_bill_type" value="<?php echo e($_bill_type ?? 0); ?>">
            <input type="hidden" name="_month" value="<?php echo e($_month ?? 0); ?>">
            <input type="hidden" name="_year" value="<?php echo e($_year ?? 0); ?>">


                
            </div>
        </div>

        <div class="form-group <?php if(sizeof($permited_organizations) == 1): ?> display_none <?php endif; ?> col-md-6">
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

        <div class="form-group <?php if(sizeof($permited_branch) == 1): ?> display_none <?php endif; ?> col-md-6">
            <label for="_branch_id"><?php echo e(__('label._branch_id')); ?></label>
            <select name="_branch_id" class="form-control " required>
                <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group  <?php if(sizeof($permited_costcenters) == 1): ?> display_none <?php endif; ?> col-md-6">
            <label for="_cost_center_id"><?php echo e(__('label._cost_center_id')); ?></label>
            <select name="_cost_center_id" class="form-control ">
                <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($center->id); ?>"><?php echo e($center->_name ?? ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>

<?php
$_make_ledger_coloumn_name = $_bill_type.'_ledger';
?>
        <div class="form-group col-md-6">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control ">
                <option value="<?php echo e($_bill_type); ?>"><?php echo e($bill_types[$_bill_type] ?? ''); ?></option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="_dr_ledger_id">BILL LEDGER</label>
            <select name="_dr_ledger_id" class="form-control ">
                <option value="<?php echo e($income_ledgers->$_make_ledger_coloumn_name ?? 0); ?>"><?php echo e(_ledger_name($income_ledgers->$_make_ledger_coloumn_name ?? 0)); ?></option>
            </select>


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
                        <th>Division</th>
                        <th>Class </th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Short Note</th>
                        <th><?php echo e($bill_types[$_bill_type] ?? ''); ?></th>
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
$fee_column = $_bill_type ?? '_tution_fee';
$_grand_total            +=$data->$fee_column ??  0;
$_grand_due_balance            +=$data->fee_column ??  0;
$_grand_discount_amount            +=$data->_discount_amount ??  0;
?>
                          <tr class="_voucher_row">
                                              <td>
                                                

                                                <input type="hidden" name="_student_id[]" value="<?php echo e($data->_student_id); ?>">
                                                <input type="hidden" name="_session_id[]" value="<?php echo e($data->_session ?? 0); ?>">
                                                <input type="hidden" name="stm_bill_master_details_id[]" value="0">
                                                <input type="hidden" name="stm_bill_collections_id[]" value="0">
                                                
                                              </td>
                                              <td><?php echo ($key+1); ?></td>
                                              <td style="white-space: nowrap;"><?php echo $data->_division->_name ?? ''; ?>  </td>
                                              <td style="white-space: nowrap;"><?php echo $data->_class_info->_name ?? ''; ?>  </td>
                                              
                                              <td style="white-space: nowrap;"><?php echo $data->_student->_name_in_english ?? ''; ?>  </td>
                                              <td style="white-space: nowrap;"><?php echo $data->_roll_no ?? ''; ?>  </td>
                                            
                                              
                                              
                                             <td>
                                                 <input type="text" name="_short_narration[]" value="<?php echo e($bill_types[$_bill_type] ?? ''); ?>" class="form-control _short_narration">
                                             </td>
                                            
                                               <td>
                                                <input type="number" min="0" step="any" name="_admission_fee[]" class="form-control  _total" placeholder="<?php echo e(__('label._total')); ?>" value="<?php echo e(old('_total',$data->$fee_column)); ?>" >
                                                <input type="hidden" name="_bill_type_name[]" value="<?php echo e($_bill_type ?? ''); ?>">
                                              

                                              </td>
                                             

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                      </tbody>
                      <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="7">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="<?php echo e($_grand_total); ?>" readonly>
                                              </td>
                                             
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
<?php endif; ?>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    

$(document).on('keyup','._total',function(){
    payment_total_calculatins();
})



function payment_total_calculatins(){
    var _grand_total=0;
  
 $(document).find('._total').each(function(){
     var _total =parseFloat($(this).val());
     if(isNaN(_total)){_total=0}
      _grand_total +=_total;
 })

 $(document).find("._grand_total").val(_grand_total);



}
 
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/stm_bill_masters/create.blade.php ENDPATH**/ ?>