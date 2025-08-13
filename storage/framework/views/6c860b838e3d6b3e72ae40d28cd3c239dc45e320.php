
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 _page_name"><a  href="<?php echo e(route('voucher.index')); ?>"> <?php echo $page_name ?? ''; ?> </a>  
            <?php echo $__env->make('backend.message.voucher-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </h1>
          </div><!-- /.col -->
          <div class=" col-sm-4 ">
            <ol class="breadcrumb float-sm-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-create')): ?>
             <li class="breadcrumb-item active">
                 <button type="button" class="btn btn-sm btn-default new_ledger_button" attr_base_create_url="<?php echo e(url('account-type-for-new-ledger')); ?>" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button>
               </li>
               <?php endif; ?>
              <li class="breadcrumb-item active">
                 <a class="btn btn-sm btn-default" title="List" href="<?php echo e(route('voucher.index')); ?>">Voucher List</a>
               </li>
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
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
                       <?php echo $__env->make('backend.voucher.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Main  Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="<?php echo e($print_url_detal); ?>"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
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
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Code</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>Type</b></th>
                         <th class=" text-right"><b>Amount</b></th>
                         <th class=""><b>Refarance</b></th>
                         <th class=""><b>Note</b></th>
                         <th class=""><b><?php echo e(__('label._sales_man_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.organization')); ?></b></th>
                         <th class=""><b>Branch</b></th>
                         <th class=""><b>User</b></th>
                         <th>Lock</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Table</th>
                         <th>Ref Table</th>
                      </tr>
                     </thead>
                     <tbody>
                      <?php
                      $sum_of_amount=0;
                      ?>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                           $sum_of_amount += $data->_amount ?? 0;
                        ?>
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item " href="<?php echo e(route('voucher.show',$data->id)); ?>">
                                        View
                                      </a>
                                     <a target="__blank" class="dropdown-item " href="<?php echo e(url('voucher/print',$data->id)); ?>">
                                        Print
                                      </a>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-edit')): ?>
                                        <a class="dropdown-item " href="<?php echo e(route('voucher.edit',$data->id)); ?>">
                                         Edit
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                      $_types =['CR','BR'];
                                    ?>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('money-receipt-print')): ?>
                                     <?php if(in_array($data->_voucher_type,$_types)): ?>
                                        <a class="dropdown-item " href="<?php echo e(url('money-receipt-print')); ?>/<?php echo e($data->id); ?>">
                                         Money Receipt
                                        </a>
                                      <?php endif; ?>
                                    <?php endif; ?>

                                    <?php
                                      $_p_types =['CP','BP','PC'];
                                    ?>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('money-payment-receipt')): ?>
                                     <?php if(in_array($data->_voucher_type,$_p_types)): ?>
                                        <a class="dropdown-item " href="<?php echo e(url('money-payment-receipt')); ?>/<?php echo e($data->id); ?>">
                                         Payment Receipt
                                        </a>
                                      <?php endif; ?>
                                    <?php endif; ?>

                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-delete')): ?>
                                    <?php echo Form::open(['method' => 'DELETE','route' => ['voucher.destroy', $data->id],'style'=>'display:inline']); ?>

                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm ">
                                            <span class="_required">Delete</span>
                                        </button>
                                    <?php echo Form::close(); ?>

                                <?php endif; ?>
                                   
                                  </div>
                                </div>
                               
                               
                               
                                <a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__<?php echo e($key); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td><?php echo e($data->id); ?></td>
                            <td>
                              <a target="__blank" title="Voucher Print"  href="<?php echo e(url('voucher/print',$data->id)); ?>">
                                        <?php echo e($data->_code ?? ''); ?>

                                      </a></td>
                            <td><?php echo e(_view_date_formate($data->_date ?? '')); ?> <?php echo e($data->_time ?? ''); ?></td>
                            <td><?php echo e($data->_voucher_type ?? ''); ?></td>
                            <td class="text-right"><?php echo e(_report_amount( $data->_amount ?? 0)); ?> </td>
                            <td><?php echo e($data->_transection_ref ?? ''); ?></td>
                            <td><?php echo e($data->_note ?? ''); ?></td>
                            <td><?php echo e($data->_voucher_emp_ref->_name ?? ''); ?></td>
                            <td><?php echo e($data->_organization->_name ?? ''); ?></td>
                            <td><?php echo e($data->_master_branch->_name ?? ''); ?></td>
                            <td><?php echo e($data->_user_name ?? ''); ?></td>
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
                            <td><?php echo e($data->created_at ?? ''); ?></td>
                            <td><?php echo e($data->updated_at ?? ''); ?></td>
                            <td><?php echo e($data->_form_name ?? ''); ?></td>
                            <td><?php echo e($data->_ref_table ?? ''); ?></td>
                            
                           
                        </tr>
                        <tr>
                          <td colspan="15" >
                           <div class="collapse" id="collapseExample__<?php echo e($key); ?>">
                            <div class="card " >
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>Ledger</th>
                                  <th>Branch</th>
                                  <th>Cost Center</th>
                                  <th>Short Narr.</th>
                                  <th class="text-right" >Dr. Amount</th>
                                  <th class="text-right" >Cr. Amount</th>
                                </thead>
                                <tbody>
                                  <?php
                                    $_dr_amount = 0;
                                    $_cr_amount = 0;
                                  ?>
                                  <?php $__empty_1 = true; $__currentLoopData = $data->_master_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail_key=>$_master_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <tr>
                                    <td><?php echo e(($_master_val->id)); ?></td>
                                    <td><?php echo e($_master_val->_voucher_ledger->_name ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_detail_branch->_name ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_detail_cost_center->_name ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_short_narr ?? ''); ?></td>
                  <td class="text-right"><?php echo e(_report_amount( $_master_val->_dr_amount ?? 0)); ?></td>
                  <td class="text-right"> <?php echo e(_report_amount( $_master_val->_cr_amount ?? 0)); ?> </td>
                                    <?php 
                                    $_dr_amount += $_master_val->_dr_amount;   
                                    $_cr_amount += $_master_val->_cr_amount;  
                                    ?>
                                  </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td  class="text-right"><b><?php echo e(_report_amount($_dr_amount ?? 0 )); ?> </b></td>
                                    <td  class="text-right"><b><?php echo e(_report_amount( $_cr_amount ?? 0 )); ?> </b></td>
                                    
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td colspan="6" class="text-center"><b>Total</b></td>
                          <td class="text-right"><b><?php echo e(_report_amount($sum_of_amount)); ?> </b></td>
                          <td colspan="4"></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td colspan="12" class="text-center">
                            <?php echo $datas->render(); ?>

                          </td>
                        </tr>

                        </tbody>
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
 $(function () {
   var default_date_formate = `<?php echo e(default_date_formate()); ?>`
   var _datex = `<?php echo e($request->_datex ?? ''); ?>`
   var _datey = `<?php echo e($request->_datey ?? ''); ?>`
    
     $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });
 

 

// if(_datex =='' && _datey =='' ){
//   $(".datetimepicker-input_datex").val(date__today());
//   $(".datetimepicker-input_datey").val(date__today());
//   console.log('Ok new Page')
// }else{
//   $(".datetimepicker-input_datex").val(after_request_date__today( `<?php echo e($request->_datex); ?>` ))
//   $(".datetimepicker-input_datey").val(after_request_date__today( `<?php echo e($request->_datey); ?>` ))
//   console.log('after search')
// }

function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }


  

function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

});

  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="voucher_masters";
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/voucher/index.blade.php ENDPATH**/ ?>