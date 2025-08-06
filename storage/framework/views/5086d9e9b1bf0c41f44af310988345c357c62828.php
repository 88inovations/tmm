
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          <div class="card">
               <?php if(count($errors) > 0): ?>
                 <div class="alert alert-danger">
                      <strong>Whoops!</strong> There were some problems with your input.<br><br>
                      <ul>
                      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><?php echo e($error); ?></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                  </div>
              <?php endif; ?>
            <div class="card-header">
              <div class="row">
                <div class="col-sm-7 text-right">
                  <h4><?php echo e($page_name ?? ''); ?></h4>
                </div>
                <div class="col-sm-5 text-right" >
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income-statement-settings')): ?>
                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  <i class="fa fa-cog" aria-hidden="true"></i> 
                </button>
                <?php endif; ?>
                 
                </div>
              </div>
                
             
            </div>
          
         
            <div class="card-body filter_body" style="">
               <form  action="<?php echo e(url('income-statement-report')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                 <?php echo $__env->make('basic.report_date_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="row">
                      
                      <?php echo $__env->make('basic.org_report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      

                    
                    </div>
                    
                    
                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <a href="<?php echo e(url('income-statement-filter-reset')); ?>"  class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
                        </div>
                        <br><br>
                     </div>

                     
                    <?php echo Form::close(); ?>

                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>
<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
           <form action="<?php echo e(url('income-statement-settings')); ?>" method="post">
            <?php echo csrf_field(); ?>
          <div class="modal-content">
           
            <div class="modal-header">
              <h4 class="modal-title">Income Statement Settings</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th class="text-right">Show</th>
                  </tr>
                  <?php $__empty_1 = true; $__currentLoopData = $_filter_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr >
                    <th  colspan="2"><?php echo e($key); ?></th>
                  </tr>
                      <?php $__empty_2 = true; $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_key=>$led): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <tr class="<?php if($led->_show==0): ?> _nv_warning <?php endif; ?>">
                          <th>
                            <input type="hidden" name="_l_id[]" value="<?php echo e($led->id); ?>">
                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($led->_name ?? ''); ?>

                          </th>
                          <th class="text-right  " >
                            <select class="form-control" name="_show[]">
                              <option value="1" <?php if($led->_show==1): ?> selected <?php endif; ?> >Show</option>
                              <option value="0" <?php if($led->_show==0): ?> selected <?php endif; ?> >Hide</option>
                            </select>
                          </th>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                      <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <?php endif; ?>

                </thead>
              </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script type="text/javascript">


 
    $(function () {

     var default_date_formate = `<?php echo e(default_date_formate()); ?>`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }
     
     


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
     

  })



</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/account-report/income-statement.blade.php ENDPATH**/ ?>