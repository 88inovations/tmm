
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>


<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="<?php echo e(url('report-panel')); ?>">Report</a> / 
            <a class="_page_name" href="#"><?php echo e($page_name ?? ''); ?></a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
          
          
         
            <div class="card-body filter_body" >
               <form  action="<?php echo e(url('bank-book-report')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                 <?php echo $__env->make('basic.report_date_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                 
                    <div class="row">
                    
                      <?php echo $__env->make('basic.org_report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      

                    </div>
                    
                     <div class="row">
                      <label>Ledger:<span class="_required">*</span></label><br></div>
                     <div class="row">
                         <select id="_account_ledger_id" class="form-control  _account_ledger_id multiple_select" name="_account_ledger_id[]" multiple size='6' required>
                         
                           <?php $__empty_1 = true; $__currentLoopData = $account_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                           <option value="<?php echo e($ledger->id); ?>" <?php if(isset($previous_filter["_account_ledger_id"])): ?> <?php if(in_array($ledger->id,$previous_filter["_account_ledger_id"])): ?> selected <?php endif; ?>  <?php endif; ?>><?php echo e($ledger->_name); ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                           <?php endif; ?>
                          
                         </select>
                     </div>
                     <br>
                  
                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                               
                              <a href="<?php echo e(url('bank-book-filter-reset')); ?>"    class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
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

    var _account_group_ids = $(document).find('._account_group_id').val();
    if(_account_group_ids?.length > 0){
      _nv_group_base_ledger(_account_group_ids);
    }

  $(document).find('#_account_group_id').on('change',function(){
    var _account_group_id = $(this).val();
    
      _nv_group_base_ledger(_account_group_id);
    
  })

  function _nv_group_base_ledger(_account_group_id){
    var request = $.ajax({
        url: "<?php echo e(url('group-base-ledger')); ?>",
        method: "GET",
        data: { _account_group_id : _account_group_id },
        dataType: "HTML"
      });
    request.done(function( result ) {
      $("#_account_ledger_id").html(result);
      });
       
      request.fail(function( jqXHR, textStatus ) {
       console.log(textStatus)
      });
  }




$(document).on('keyup','._search_ledger_id_ledger',delay(function(e){
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
        
            search_html +=`<div class="card"><table class="_filter_ledger_search_table" >
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row _ledger_search_row" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_ledger" class="_id_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_leder" class="_name_leder" value="${data[i]._name}">
                                        </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      $(document).find('.search_box').html(search_html);
      $(document).find('.search_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

  
 $(document).on('click','._ledger_search_row',function(){
  var _id = $(this).children('td').find('._id_ledger').val();
  var _name = $(this).find('._name_leder').val();
  $(document).find('._ledger_id').val(_id);
  var _id_name = `${_name} `;
  $(document).find('._search_ledger_id_ledger').val(_id_name);

  $('.search_box').hide();
  $('.search_box').removeClass('search_box_show').hide();
})

$(document).on('click',function(){
    var searach_show= $('.search_box').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box').removeClass('search_box_show').hide();
    }
})

        

         

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/account-report/filter_bank_book.blade.php ENDPATH**/ ?>