
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('stm_students.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_students_create')): ?>
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="<?php echo e(route('stm_students.create')); ?>">
                   <i class="nav-icon fas fa-plus"></i> <?php echo e(__('label.create_new')); ?>

                </a>

               </li>
              <?php endif; ?>

               <li class="breadcrumb-item active">
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
  Upload Student
</button>

               </li>
                 <div class="col-md-3">

            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Student Excel File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<?php echo e(route('stm_students_excel_upload')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                     
                   
                        <div class="form-group">
                            <label for="file">Choose Excel File:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                        </div>
                   
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <?php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';

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


                  <form class="" action="<?php echo e(route('stm_students.index')); ?>" method="GET">
            <?php echo csrf_field(); ?>
                
                      <div>
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._admission_session_id')); ?>:</label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id">
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
                                    <select class="form-control _education_type" name="_education_type">
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
                                    <select class="form-control _admission_class_id" name="_admission_class_id">
                                      <option value="">Select Class</option>
                                      <?php $__empty_1 = true; $__currentLoopData = $edu_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($class->id); ?>"
                                         <?php if($_admission_class_id ==$class->id): ?> selected <?php endif; ?> > <?php echo $class->_name ?? ''; ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                      
                                    </select>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._roll_no')); ?>:</label>
                                    <input type="text" name="_roll_no" class="form-control _roll_no" value="<?php echo e($_roll_no); ?>" placeholder="<?php echo e(__('label._roll_no')); ?>">
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><?php echo e(__('label._student_name')); ?>:</label>
                                    <input type="text" name="_student_name" class="form-control _student_name" value="<?php echo e($_student_name); ?>" placeholder="<?php echo e(__('label._student_name')); ?>">
                                </div>
                            </div>


                        <?php
             $cloumns = [ 'id'=>'ID','_name_in_english'=>'Name','_age'=>'Age'];





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
                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="limit">Status</label>
                           <select class="form-control" name="_status">
                               <option value="">Select Status</option>
                                <option value="1" <?php if(isset($request->_status)): ?> <?php if($request->_status==1): ?> selected <?php endif; ?> <?php endif; ?>>Active</option>
                                 <option value="0" <?php if(isset($request->_status)): ?> <?php if($request->_status==0): ?> selected <?php endif; ?> <?php endif; ?>>In Active</option>
                           </select>
                        </div>



                            <div class="col-xs-12 col-sm-12 col-md-3 mt-3 flex">
                                   <button type="submit" class="btn btn-primary mt-1 mr-2"><i class="fa fa-search "></i> Search</button>
                                   <a  href="<?php echo e(route('stm_students.index')); ?>" class="btn btn-danger mt-1"><i class="fa fa-retweet"></i> Reset</a>
                                  </div>
                        </div>
                            
                          </div>
                    </form>


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
                         <th class=""><b>SL</b></th>
                         <th class=""><b><?php echo e(__('label.id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._admission_date')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._admission_session_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._education_type')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._admission_class_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._student_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._proximity_card_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._roll_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._name_in_bangla')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._name_in_english')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._f_mobile_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._mother_mobile_no')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._local_guardian_mobile')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._status')); ?></b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        <?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                        <tr>
                            
                             <td style="display: flex;">
                              
                              <a  type="button" 
                                  href="<?php echo e(route('stm_students.show',$data->id)); ?>"
                                  class="btn btn-sm btn-default  mr-2"><i class="fa fa-eye"></i></a>

                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_students_edit')): ?>
                                  <a  type="button" 
                                  href="<?php echo e(route('stm_students.edit',$data->id)); ?>"
                                 
                                  class="btn btn-sm btn-default  mr-2"><i class="fa fa-pen "></i></a>
                              <?php endif; ?>  

                              <a href="<?php echo e(route('students.admissionFormPdf')); ?>?id=<?php echo e($data->id); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
    Download Admission 
</a>
                               
                            </td>
                            <td><?php echo e(($key+1)); ?></td>
                            <td><?php echo e($data->id); ?></td>
                            <td><?php echo e(_view_date_formate($data->_admission_date ?? '')); ?></td>
                            <td><?php echo e($data->_edu_session->_name ?? ''); ?></td>
                            <td><?php echo e($data->_edu_division->_name ?? ''); ?></td>
                            <td><?php echo e($data->_edu_class->_name ?? ''); ?></td>
                            <td><?php echo e($data->_student_id ?? ''); ?></td>
                            <td><?php echo e($data->_proximity_card_no ?? ''); ?></td>
                            <td><?php echo e($data->_roll_no ?? ''); ?></td>
                            <td><?php echo e($data->_name_in_bangla ?? ''); ?></td>
                            <td><?php echo e($data->_name_in_english ?? ''); ?></td>
                            <td><?php echo e($data->_f_mobile_no ?? ''); ?></td>
                            <td><?php echo e($data->_mother_mobile_no ?? ''); ?></td>
                            <td><?php echo e($data->_local_guardian_mobile ?? ''); ?></td>
                           <td><?php echo e(selected_status($data->_status)); ?></td>
                            
                           
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                        

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="11">  <?php echo $datas->render(); ?></td>
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/stm/stm_students/index.blade.php ENDPATH**/ ?>