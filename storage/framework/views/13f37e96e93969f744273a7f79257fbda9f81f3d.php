
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
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

     
   <?php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_bill_type =  $request->_bill_type ?? '';
$_month =  $request->_month ?? '';
$_year =  $request->_year ?? '';
$_order_number =  $request->_order_number ?? '';

$asc_cloumn =  $request->asc_cloumn ?? '';
$_asc_desc =  $request->_asc_desc ?? '';
 $row_numbers = filter_page_numbers();





?>


     <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 <div class="row">


                   <form class="mb-2" action="<?php echo e(route('stm_bill_masters.index')); ?>" method="GET">
            <?php echo csrf_field(); ?>
                
                      <div>
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._admission_session_id')); ?>:</label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id" >
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
                                    <label class="form-control-label"><?php echo e(__('label._education_type')); ?>:</label>
                                    <select class="form-control _education_type" name="_education_type" >
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
                                    <label class="form-control-label"><?php echo e(__('label._admission_class_id')); ?>:</label>
                                    <select class="form-control _admission_class_id" name="_admission_class_id" >
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
                                 <label class="mr-2" for="_month"><?php echo e(__('label._month')); ?></label>
                                <select class="form-control _month" name="_month" >
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
                                  <label class="mr-2" for="_year"><?php echo e(__('label._year')); ?></label>
                                  <select name="_year" class="form-control" >
                                      <?php for($i = $year_start; $i <= $currentYear; $i++): ?>
                                          <option value="<?php echo e($i); ?>" <?php if($i == $_year): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                                      <?php endfor; ?>
                                  </select>
                              </div>
                                    <?php                     
                                    $bill_types =_fees_types();
                                    ?>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <label class="mr-2" for="_bill_type"><?php echo e(__('label._bill_type')); ?></label>
                                  <select name="_bill_type" class="form-control" >
                                      <?php $__empty_1 = true; $__currentLoopData = $bill_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill_key=>$lebel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                          <option value="<?php echo e($bill_key); ?>" <?php if($bill_key == $_bill_type): ?> selected <?php endif; ?>><?php echo e($lebel); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                  </select>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._order_number')); ?>:</label>
                                    <input type="text" name="_order_number" class="form-control _order_number" value="<?php echo e($_order_number); ?>" placeholder="<?php echo e(__('label._order_number')); ?>">
                                </div>
                            </div>

                        <?php
             $cloumns = [ 'id'=>'ID','_date'=>'Date'];





                      ?>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_order_number">Order By</label>
                         <select class="form-control" name="asc_cloumn" >
                            
                            <?php $__currentLoopData = $cloumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>"  <?php if($key==$asc_cloumn): ?> selected <?php endif; ?>  ><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="_asc_desc">Sort Order</label>
                             <select class=" form-control" name="_asc_desc">
                            <?php $__currentLoopData = asc_desc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>"  <?php if($val==$_asc_desc): ?> selected <?php endif; ?>  ><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="limit">Limit</label>
                            <select name="limit" class="form-control" >
                              <?php $__empty_1 = true; $__currentLoopData = $row_numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option  <?php if($limit == $row): ?> selected <?php endif; ?>   value="<?php echo e($row); ?>"><?php echo e($row); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <?php endif; ?>
                      </select>
                        </div>




                            <div class="col-xs-12 col-sm-12 col-md-3 mt-3 ">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary btn-sm mr-2"><i class="fa fa-search "></i> Search</button>
                                  <a href="<?php echo e(route('stm_bill_masters.index')); ?>" class="btn btn btn-danger btn-sm">🔄 Reset</a>
                                </div>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>
</div>


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
                    
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b>SL</b></th>
                         <th class=""><b>ID</b></th>
                         <th class=""><b><?php echo e(__('label._date')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._order_number')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._bill_type')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._stm_division_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._class_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._month_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._year')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._bill_amount')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._note')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._user_name')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._status')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._lock')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._created_by')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._updated_by')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.created_at')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.updated_at')); ?></b></th>
                      </tr>

                     
                     </thead>
                     <tbody>
                      
                        <?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                        <tr>
                            
                             <td style="display: flex;">
                              
                              <a  type="button" 
                                  href="<?php echo e(route('stm_bill_masters.show',$data->id)); ?>"
                                  class="btn btn-sm btn-info  mr-2">Print</a>

                            
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_bill_masters_delete')): ?>
                                 
                            
                              <form action="<?php echo e(route('stm_bill_masters.destroy', $data->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="mr-2 btn btn-danger btn-sm" type="submit" onclick="return confirm('Do You Want to Delete!')" >Delete</button>
                                    </form>
                              <?php endif; ?>  

                              <a class="btn btn-sm btn-default _action_button " attr_invoice_id="<?php echo e($data->id); ?>" _attr_key="<?php echo e($key); ?>" data-toggle="collapse" href="#collapseExample__<?php echo e($key); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i></a>

                               
                            </td>
                            <td><?php echo e(($key+1)); ?></td>
                            <td><?php echo e($data->id); ?></td>
                            <td><?php echo e(_view_date_formate($data->_date ?? '')); ?></td>
                            <td><?php echo e($data->_order_number ?? ''); ?></td>
                            <td><?php echo e(_fee_lebel($data->_bill_type ?? '')); ?></td>
                            <td><?php echo e($data->_edu_division->_name ?? ''); ?></td>
                            <td><?php echo e($data->_edu_class->_name ?? ''); ?></td>
                            <td><?php echo e(_number_to_month($data->_month_id ?? '')); ?></td>
                            <td><?php echo e($data->_year ?? ''); ?></td>
                            <td><?php echo e($data->_total_amount ?? ''); ?></td>
                            <td><?php echo e($data->_note ?? ''); ?></td>
                            <td><?php echo e($data->_user_name ?? ''); ?></td>
                           <td><?php echo e(selected_status($data->_status)); ?></td>
                          
                          <td style="display: flex;">
                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock-permission')): ?>
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="<?php echo e($data->id); ?>" value="<?php echo e($data->_lock); ?>" <?php if($data->_lock==1): ?> checked <?php endif; ?>>
                              <?php endif; ?>

                              
                              <?php if($data->_lock==1): ?>
                              <i class="fa fa-lock _green ml-1 _icon_change__<?php echo e($data->id); ?>" aria-hidden="true"></i>
                              <?php else: ?>
                              <i class="fa fa-lock _required ml-1 _icon_change__<?php echo e($data->id); ?>" aria-hidden="true"></i>
                              <?php endif; ?>
                              

                            </td>
                            <td><?php echo e($data->_created_by ?? ''); ?></td>
                            <td><?php echo e($data->_updated_by ?? ''); ?></td>
                            <td><?php echo e($data->created_at ?? ''); ?></td>
                            <td><?php echo e($data->created_at ?? ''); ?></td>
                            
                            
                        </tr>

                        <tr>
                            <td colspan="10"  class="collapse " id="collapseExample__<?php echo e($key); ?>">
                                 <?php
                      
                        $___master_details = $data->_detail ?? [];
                        ?>
 <?php if(sizeof($___master_details) > 0): ?>
                          
                           <div >
                            <div class="card  " >
                              <table class="table">
                                <thead >
                                            <th class="text-middle" >SL</th>
                                            <th class="text-left" ><?php echo e(__('label._student_id')); ?></th>
                                            <th class="text-left" ><?php echo e(__('label._name_in_english')); ?></th>
                                            <th class="text-left" ><?php echo e(__('label._father_name_english')); ?></th>
                                            <th class="text-left" ><?php echo e(__('label._roll_no')); ?></th>
                                            <th class="text-left" ><?php echo e(__('label._amount')); ?></th>
                                           
                                           
                                           
                                          </thead>
                                <tbody>
                                  <?php
                                    $_gross_fee_amount = 0;
                                  ?>
                                  <?php $__empty_2 = true; $__currentLoopData = $___master_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_key=>$_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                  <tr>
                                   
                                     <?php
                                     $_gross_fee_amount = $_item->_fee_amount ?? 0;
                                     ?>
                                            <td class="" ><?php echo ($item_key+1); ?></td>
                                            <td class="" ><?php echo $_item->_student->_student_id ?? ''; ?></td>
                                            <td class="" ><?php echo $_item->_student->_name_in_english ?? ''; ?></td>
                                            <td class="" ><?php echo $_item->_student->_father_name_english ?? ''; ?></td>
                                            <td class="" ><?php echo $_item->_student->_roll_no ?? ''; ?></td>
                                            <td class="" ><?php echo _report_amount($_item->_fee_amount ?? 0); ?></td>
                                           
                                           
                                          </thead>
                                  </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                  <?php endif; ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td>
                                                
                                              </td>
                                              <td colspan="4" class="text-right"><b>Total</b></td>
                                              <td  class="text-right"><b><?php echo e(_report_amount($_gross_fee_amount)); ?></b></td>
                                             
                                              
                                            </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        
                        <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                        

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="9">  <?php echo $datas->render(); ?></td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.d-flex -->
                
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

<?php $__env->startSection('script'); ?>

<script type="text/javascript">
  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="stm_bill_masters";
      if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })




 

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/stm/stm_bill_masters/index.blade.php ENDPATH**/ ?>