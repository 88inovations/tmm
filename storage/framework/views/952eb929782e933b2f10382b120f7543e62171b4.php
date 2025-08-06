
<?php $__env->startSection('title',$page_name ?? ''); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="<?php echo e(route('attandance.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('attandance-list')): ?>
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="<?php echo e(route('attandance.index')); ?>"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               <?php endif; ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-md-12">
<div class="card">

<div class="card-body">
   <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo Form::open(array('route' => 'attandance.store','method'=>'POST','enctype'=>'multipart/form-data')); ?>

<div class="tab-content">
    
<div class="tab-pane active" id="tab1">
    
     
    <div class="form-group row pt-2">
                            <label class="col-sm-2 col-form-label" ><?php echo e(__('EMP ID')); ?>:</label>
                             <div class="col-sm-6">
                                <input type="hidden" name="_employee_id" class="_employee_id" value="" value="<?php echo e(old('_employee_id')); ?>">
                                <input type="hidden" name="_employee_ledger_id" class="_employee_ledger_id" value="">
                                <input type="text" name="_employee_id_text" class="form-control _employee_id_text" placeholder="<?php echo e(__('EMP ID')); ?>" value="<?php echo e(old('_employee_id_text')); ?>" required>
                               <div class="search_box_employee"> </div>
                            </div>
                        </div>
                <div class="form-group row pt-2">
                            <label class="col-sm-2 col-form-label" ><?php echo e(__('Employee Name')); ?>:</label>
                             <div class="col-sm-6">
                                <input type="text" name="_employee_name_text" class="form-control _employee_name_text" placeholder="<?php echo e(__('Employee')); ?>" value="<?php echo e(old('_employee_name_text')); ?>" required>
                               <div class="search_box_employee"> </div>
                            </div>
                        </div>
    
    
   

    <div class="form-group row">
            <label class="col-sm-2 col-form-label"  for="_datetime" class="_required"><?php echo e(__('label._date')); ?>:</label>
            <div class="col-sm-3 ">
                <input type="date" name="_datetime" class="form-control" value="<?php echo e(old('_datetime')); ?>">
            </div>
    </div>
     
     <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="in_time"><?php echo e(__('label.in_time')); ?>:</label>
        <div class="col-sm-2">
            <input class="form-group" type="time" id="in_time" name="in_time" value="<?php echo e(old('in_time')); ?>" required>
        </div>
</div>
     <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="out_time"><?php echo e(__('label.out_time')); ?>:</label>
        <div class="col-sm-2">
            <input class="form-group" type="time" id="out_time" name="out_time" value="<?php echo e(old('out_time')); ?>" >
        </div>
</div>
     <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="remarks"><?php echo e(__('label.remarks')); ?>:</label>
        <div class="col-sm-6">
            <input class="form-control" type="text" id="remarks" name="remarks" value="<?php echo e(old('remarks')); ?>" >
        </div>
</div>

</div><!-- End fo Tab One -->

<div class="form-group row">
<div class="offset-sm-2 col-sm-6">
<button type="submit" class="btn btn-danger">Submit</button>
</div>
</div>

</div> <!-- End of tab content -->
</form> <!-- End of form -->

</div>
</div>

</div>
         
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $(document).on('keyup','._employee_id_text',delay(function(e){
    
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "<?php echo e(url('ledger-search')); ?>",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered" style="width: 300px;"> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="_employee_search_row_em _cursor_pointer" >
                                        <td>${data[i]._code}
                                        <input type="hidden" name="_emp_all_data" class="_emp_all_data" attr_value='${JSON.stringify(data[i])}'>
                                        <input type="hidden" name="_emplyee_row_id" class="_emplyee_row_id" value="${data[i].id}">
                                        <input type="hidden" name="_emplyee_row_code_id" class="_emplyee_row_code_id" value="${data[i]._code}">
                                        </td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_search_employee_name" class="_search_employee_name" value="${data[i]._name}">
                                        
                                        </td>
                                        <td>${data[i]?._emp_designation?._name}
                                        
                                        </td>
                                        
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }   

       _gloabal_this.parent('div').find('.search_box_employee').html(search_html);
      _gloabal_this.parent('div').find('.search_box_employee').addClass('search_box_show').show();  
      
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));

    


$(document).on('click','._employee_search_row_em',function(){
 var _emp_all_data = $(this).children('td').find('._emp_all_data').attr('attr_value');

var data = JSON.parse(_emp_all_data);
console.log(data)
$(document).find("._employee_name_text").val(data?._name);
$(document).find("._employee_id").val(data?.id);
$(document).find("._employee_id_text").val(data?._code);
$(document).find("._employee_ledger_id").val(data?._ledger_id);

  $(document).find('.search_box_employee').hide();
  $(document).find('.search_box_employee').removeClass('search_box_show').hide();
})
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/hrm/attandance/create.blade.php ENDPATH**/ ?>