
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="<?php echo e(route('stm_classes.index')); ?>"><?php echo $page_name; ?> </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
         <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div> 
        



            <div class="card-body p-4" >
               <?php echo Form::model($data, ['method' => 'PATCH','route' => ['stm_classes.update', $data->id]]); ?>

                <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label><?php echo e(__('label._code')); ?>:<span class="_required">*</span></label>
                                <input class="form-control" type="text" name="_code" placeholder="<?php echo e(__('label._code')); ?>" value="<?php echo e(old('_code',$data->_code ?? '' )); ?>" required>
                                <input type="hidden" name="id" value="<?php echo e($data->id); ?>">
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label><?php echo e(__('label._name')); ?>:<span class="_required">*</span></label>
                                <input class="form-control" type="text" name="_name" placeholder="<?php echo e(__('label._name')); ?>" value="<?php echo e(old('_name',$data->_name ?? '' )); ?>" required>
                            </div>
                        </div>
                        
                      
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label><?php echo e(__('label._detail')); ?>:</label>
                                <textarea class="form-control" type="text" name="_detail" placeholder="<?php echo e(__('label._detail')); ?>"><?php echo e(old('_detail',$data->_detail ?? '' )); ?></textarea>
                                
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label><?php echo e(__('label._status')); ?>:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" <?php if($data->_status==1): ?> selected <?php endif; ?>>Active</option>
                                  <option value="0" <?php if($data->_status==0): ?> selected <?php endif; ?>>In Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> <?php echo e(__('label.save')); ?></button>
                           
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




    function new_row_holiday(event){

      var _row =`<tr class="_voucher_row">
                      <td>
                        <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                        <input type="hidden" name="_detail_id[]" value="0">
                      </td>
                      <td>
                        <input type="text" name="_name[]" class="form-control  width_280_px" placeholder="<?php echo e(__('label.title')); ?>">
                      </td>
                      <td>
                        <input type="date" name="_date[]" class="form-control width_250_px _date" placeholder="<?php echo e(__('label.date')); ?>">
                      </td>
                      <td>
                        <select class="form-control" name="_type[]">
                          <?php $__empty_1 = true; $__currentLoopData = full_half(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <option value="<?php echo e($fh); ?>"><?php echo $fh ?? ''; ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                        </select>
                      </td>
                    </tr>`;

      $(document).find('.area__voucher_details').append(_row);

    }

  

  

     

         

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/stm/stm_classes/edit.blade.php ENDPATH**/ ?>