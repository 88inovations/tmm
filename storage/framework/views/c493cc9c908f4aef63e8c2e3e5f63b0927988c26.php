
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('hrm-employee.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-employee-create')): ?>
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="<?php echo e(route('hrm-employee.create')); ?>">
                   <i class="nav-icon fas fa-plus"></i> <?php echo e(__('label.create_new')); ?>

                </a>

               </li>
              <?php endif; ?>
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
                      <?php echo $__env->make('hrm.hrm-employee.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               <div class="dropdown-divider"></div>
                                <a target="__blank" href="<?php echo e($print_url_detal); ?>"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             
                        
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b><?php echo e(__('label.sl')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.User ID')); ?></b></th>
                         <th class=""><b>Ledger ID</b></th>
                         <th class=""><b><?php echo e(__('label._name')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._code')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._mobile1')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._email')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.employee_category_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._department_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._jobtitle_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._grade_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.organization')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.Branch')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.Cost center')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._location')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._status')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.user')); ?></b></th>
                      </tr>

                      



                     </thead>
                     <tbody>
                      
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                             <td style="display: flex;">
                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-employee-delete')): ?>
                                 <?php echo Form::open(['method' => 'DELETE','route' => ['hrm-employee.destroy', $data->id],'style'=>'display:inline']); ?>

                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  <?php echo Form::close(); ?>

                               <?php endif; ?> 
                              <a  type="button" 
                                  href="<?php echo e(route('hrm-employee.show',$data->id)); ?>"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>

                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-employee-edit')): ?>
                                  <a  type="button" 
                                  href="<?php echo e(route('hrm-employee.edit',$data->id)); ?>"
                                 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                              <?php endif; ?>  
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-employee-edit')): ?>
                                  <a  type="button" 
                                  href="<?php echo e(url('resume')); ?>/<?php echo e($data->id); ?>"
                                 
                                  class="btn btn-sm btn-default  mr-1">Resume</a>
                              <?php endif; ?>  
                               
                            </td>
                            <td><?php echo e(($key+1)); ?></td>
                            <td><?php echo e($data->id); ?></td>
                            <td><?php echo e($data->user_id  ?? ''); ?></td>
                            <td><?php echo e($data->_ledger_id  ?? ''); ?></td>
                            <td><?php echo e($data->_name ?? ''); ?></td>
                            <td><?php echo e($data->_code ?? ''); ?></td>
                            <td><?php echo e($data->_mobile1 ?? ''); ?></td>
                            <td><?php echo e($data->_email ?? ''); ?></td>
                            <td><?php echo e($data->_employee_cat->_name ?? ''); ?></td>
                            <td><?php echo e($data->_emp_department->_name ?? ''); ?></td>
                            <td><?php echo e($data->_emp_designation->_name ?? ''); ?></td>
                            <td><?php echo e($data->_emp_grade->_name ?? ''); ?></td>
                            <td><?php echo e($data->_organization->_name ?? ''); ?></td>
                            <td><?php echo e($data->_branch->_name ?? ''); ?></td>
                            <td><?php echo e($data->_cost_center->_name ?? ''); ?></td>
                            <td><?php echo e($data->_emp_location->_name ?? ''); ?></td>
                            <td><?php echo e(selected_status($data->_status)); ?></td>
                            <td><?php echo e($data->_entry_by->name ?? ''); ?></td>



                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="17">
                              <div class="d-flex flex-row justify-content-start">
                                 <?php echo $datas->render(); ?>

                                </div>
                            </td>
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

 

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/hrm/hrm-employee/index.blade.php ENDPATH**/ ?>