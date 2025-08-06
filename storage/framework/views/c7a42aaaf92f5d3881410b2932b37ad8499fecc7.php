
<?php $__env->startSection('title',$page_name); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <h1 class="m-0 _page_name"><a  href="<?php echo e(route('voucher.index')); ?>"> <?php echo $page_name ?? ''; ?> </a>  
              <?php echo $__env->make('backend.message.voucher-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </h1>

          </div><!-- /.col -->
           <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
                  <button type="button" class="btn btn-sm btn-default new_ledger_button" attr_base_create_url="<?php echo e(url('account-type-for-new-ledger')); ?>" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button>  
              </li>
              <li class="breadcrumb-item active">
                 <a class="btn btn-sm btn-default" title="List" href="<?php echo e(route('voucher.index')); ?>"> Voucher List </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
     <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                <?php echo Form::open(array('url' => 'voucher-save','method'=>'POST','class'=>'voucher-form')); ?>

                    <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" value="voucher_masters">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>

                       <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Voucher Type: <span class="_required">*</span></label>
                               <select class="form-control _voucher_type" name="_voucher_type" required="true">
                                  
                                  <?php $__empty_1 = true; $__currentLoopData = $voucher_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($voucher_type->_code); ?>" <?php if(isset($request->_voucher_type)): ?> <?php if($request->_voucher_type == $voucher_type->_code): ?> selected <?php endif; ?>   <?php endif; ?>>
                                    <?php echo e($voucher_type->_name ?? ''); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                            

                        <?php echo $__env->make("backend.widgets.budget_select", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_transection_ref">Reference:</label>
                              <input type="text" id="_transection_ref" name="_transection_ref" class="form-control _transection_ref" value="<?php echo e(old('_transection_ref')); ?>" placeholder="Reference" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group ">
                                <label>Cash Accounts:<span class="_required">*</span></label>
                               <select class="form-control" name="_defalut_ledger_id" required >
                                   <?php $__empty_1 = true; $__currentLoopData = $_defalut_group_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                  <option value="<?php echo e($_ledger->id); ?>" <?php if(isset($request->_defalut_ledger_id)): ?> <?php if($request->_defalut_ledger_id == $_ledger->id): ?> selected <?php endif; ?>   <?php endif; ?>> <?php echo e($_ledger->_name ?? ''); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                  <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php echo $__env->make('backend.voucher.voucher_check_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                       
                          <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th><?php echo e(__('label._ledger_id')); ?></th>
                                            <th><?php echo e(__('label.Short Narr.')); ?></th>
                                            <th >Payment Amount</th>
                                            <th class="display_none">Receive Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details" id="area__voucher_details">
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                                                <div class="search_box">
                                                  
                                                </div>
                                              </td>
                                              
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              <td >
                                                <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Payment Amount" value="<?php echo e(old('_dr_amount',0)); ?>">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="<?php echo e(old('_cr_amount',0)); ?>">
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-info" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              
                                              <td  class="text-right"></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td >
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="0" readonly required>
                                              </td>
                                              <td class="display_none">
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="0" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                            <div class="form-group">
                               
                                
                                <div class="row">
                                  <div class="col-md-1">
                                     <label class="mr-2" for="_note">Note:<span class="_required">*</span></label>
                                  </div>
                                  <div class="col-md-11">
                                    <?php if($_print = Session::get('_print_value')): ?>
                                     <input type="hidden" name="_after_print" value="<?php echo e($_print); ?>" class="_after_print" >
                                    <?php else: ?>
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    <?php endif; ?>
                                    <?php if($_master_id = Session::get('_master_id')): ?>
                                     <input type="hidden" name="_master_id" value="<?php echo e(url('money-payment-receipt')); ?>/<?php echo e($_master_id); ?>" class="_master_id">
                                    
                                    <?php endif; ?>
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="<?php echo e(old('_note')); ?>" placeholder="Note" required >
                                  </div>
                                </div>
                                 <?php echo $__env->make('backend.message.send_sms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button mt-2 ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button mt-2 _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
                        </div>
                        <br><br>
                    </div>
                    <?php echo Form::close(); ?>

                
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
  var default_date_formate = `<?php echo e(default_date_formate()); ?>`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  if(_after_print ==1){
      var open_new = window.open(_master_id, '_blank');
      if (open_new) {
          //Browser has allowed it to be opened
          open_new.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      
                      
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            <td >
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="<?php echo e(old('_dr_amount',0)); ?>">
                            </td>
                            <td class="display_none">
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Receive Amount" value="<?php echo e(old('_cr_amount',0)); ?>">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $("#area__voucher_details").append(single_row);
  }

  

  $(document).on('click','._voucher_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._ledger_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _voucher_total_calculation();
  })

  // function _voucher_total_calculation(){
  //   var _total_dr_amount = 0;
  //   var _total_cr_amount = 0;
  //     $(document).find("._cr_amount").each(function() {
  //         _total_cr_amount +=parseFloat($(this).val());
  //     });
  //     $(document).find("._dr_amount").each(function() {
  //         _total_dr_amount +=parseFloat($(this).val());
  //     });
  //     $("._total_dr_amount").val(Math.round(_total_dr_amount));
  //     $("._total_cr_amount").val(Math.round(_total_cr_amount));
  // }


  $(document).on('keyup','._dr_amount',function(){
    $(this).parent().parent('tr').find('._cr_amount').val(0);
    $(document).find("._total_dr_amount").removeClass('required_border');
    $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })



  $(document).on('keyup','._cr_amount',function(){
     $(this).parent().parent('tr').find('._dr_amount').val(0);
     $(document).find("._total_dr_amount").removeClass('required_border');
      $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })

  $(document).on('change','._voucher_type',function(){
    $(document).find('._voucher_type').removeClass('required_border');
  })

  $(document).on('keyup','._note',function(){
    $(document).find('._note').removeClass('required_border');
  })

  $(document).on('click','._save_and_print',function(){
    $(document).find('._save_and_print_value').val(1);
  })






 

$(".datetimepicker-input").val(date__today())

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

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/voucher/cash-payment.blade.php ENDPATH**/ ?>