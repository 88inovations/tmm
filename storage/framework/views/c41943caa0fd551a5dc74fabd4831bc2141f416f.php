
<?php $__env->startSection('title',$page_name); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-8 ">
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
    <div class="message-area">
     <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                <?php echo Form::open(array('route' => 'voucher.store','method'=>'POST','class'=>'voucher-form')); ?>

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
                                  <option value="">--Voucher Type--</option>
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
                                            <th class="<?php if(sizeof($permited_organizations)==1): ?> display_none <?php endif; ?>"><?php echo e(__('label.organization_id')); ?></th>
                                            <th class="<?php if(sizeof($permited_branch)==1): ?> display_none <?php endif; ?>"><?php echo e(__('label.Branch')); ?></th>
                                            <th class="<?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>"><?php echo e(__('label.Cost center')); ?></th>
                                            <th class="<?php if(sizeof($permited_budgets)==1): ?> display_none <?php endif; ?>"><?php echo e(__('label._budget_id')); ?></th>
                                            <th><?php echo e(__('label.Short Narr.')); ?></th>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger_report_foreign')): ?>
                                             <th><?php echo e(__('label._foreign_amount')); ?></th>
                                             <?php endif; ?>
                                            <th><?php echo e(__('label.Dr. Amount')); ?></th>
                                            <th><?php echo e(__('label.Cr. Amount')); ?></th>
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
                                              <td class="<?php if(sizeof($permited_organizations)==1): ?> display_none <?php endif; ?>">
                                                 <select class="form-control organization_details_id" name="organization_details_id[]"  >
                                                  
                                                 <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                 <option value="<?php echo e($val->id); ?>" ><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                 <?php endif; ?>
                                                </select>
                                              </td>
                                              <td class="<?php if(sizeof($permited_branch)==1): ?> display_none <?php endif; ?>">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                  <option value="<?php echo e($branch->id); ?>" <?php if(isset($request->_branch_id)): ?> <?php if($request->_branch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->_name ?? ''); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                  <?php endif; ?>
                                                </select>
                                              </td>
                                             
                                                <td class="<?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                                            
                                                  <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costcenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                  <option value="<?php echo e($costcenter->id); ?>" <?php if(isset($request->_cost_center)): ?> <?php if($request->_cost_center == $costcenter->id): ?> selected <?php endif; ?>   <?php endif; ?>> <?php echo e($costcenter->_name ?? ''); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                  <?php endif; ?>
                                                </select>
                                              </td>
                                              <td class="<?php if(sizeof($permited_budgets)==1): ?> display_none <?php endif; ?>">
                                                <select class="form-control _budget_details_id" name="_budget_details_id[]"  >
                                                     
                                                    <?php $__empty_1 = true; $__currentLoopData = $permited_budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                   <option value="<?php echo e($b_val->id); ?>" <?php if(isset($data->_budget_id)): ?> <?php if($data->_budget_id == $b_val->id): ?> selected <?php endif; ?>   <?php endif; ?>> <?php echo e($b_val->_name ?? ''); ?></option>
                                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                     <?php endif; ?>
                                                 </select>
                                              </td>
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger_report_foreign')): ?>
                                               <td>
                                                <input type="number" name="_foreign_amount[]" class="form-control  _foreign_amount" placeholder="<?php echo e(__('label._foreign_amount')); ?>" value="<?php echo e(old('_foreign_amount',0)); ?>">
                                              </td>
                                              <?php endif; ?>
                                              <td>
                                                <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="<?php echo e(old('_dr_amount',0)); ?>">
                                              </td>
                                              <td>
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="<?php echo e(old('_cr_amount',0)); ?>">
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-info" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="2" class="text-right"><b>Total</b></td>
                                              <td class="<?php if(sizeof($permited_organizations)==1): ?> display_none <?php endif; ?>"></td>
                                              <td class="<?php if(sizeof($permited_branch)==1): ?> display_none <?php endif; ?>"></td>
                                              <td class="<?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>"></td>
                                              <td class="<?php if(sizeof($permited_budgets)==1): ?> display_none <?php endif; ?>"></td>
                                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger_report_foreign')): ?>
                                              <td></td>
                                              <?php endif; ?>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="0" readonly required>
                                              </td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="0" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                                <!-- IF IMport Module IS Available -->

                                <div class="import_item_display"></div>

                                <div class="import_item_displayMultiple"></div>
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
                                     <input type="hidden" name="_master_id" value="<?php echo e(url('voucher/print')); ?>/<?php echo e($_master_id); ?>" class="_master_id">
                                    
                                    <?php endif; ?>
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">
                                       <input type="hidden" class="number_of_row" name="number_of_row" value="1">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="<?php echo e(old('_note')); ?>" placeholder="Note" required >
                                  </div>
                                </div>
                                 <?php echo $__env->make('backend.message.send_sms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5 mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print mt-2"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
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

<?php echo $__env->make('backend.voucher.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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




  function voucher_row_add(event) {
    var number_of_row = $(document).find(".number_of_row").val();
    var new_row_number = (number_of_row+1);
      event.preventDefault();
      $("#area__voucher_details").append(`<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      <td class="<?php if(sizeof($permited_organizations)==1): ?> display_none <?php endif; ?>">
                      <select class="form-control width_150_px organization_details_id organization_details_id__${new_row_number}" name="organization_details_id[]"  required >
                        <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($org->id); ?>" ><?php echo e($org->_name ?? ''); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                        </select>
                        </td>
                      <td class="<?php if(sizeof($permited_branch)==1): ?> display_none <?php endif; ?>">
                      <select class="form-control width_150_px _branch_id_detail _branch_id_detail__${new_row_number}" name="_branch_id_detail[]"  required >
                        <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($branch->id); ?>" ><?php echo e($branch->_name ?? ''); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                        </select>
                        </td>
                        <td class="<?php if(sizeof($permited_costcenters)==1): ?> display_none <?php endif; ?>">
                          <select class="form-control width_150_px _cost_center _cost_center__${new_row_number}" name="_cost_center[]" required >
                            <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costcenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                              <option value="<?php echo e($costcenter->id); ?>" > <?php echo e($costcenter->_name ?? ''); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                            </select>
                      </td>
                        <td class="<?php if(sizeof($permited_budgets)==1): ?> display_none <?php endif; ?>">
                          <select class="form-control _budget_details_id _budget_details_id__${new_row_number}" name="_budget_details_id[]"  >
                            <?php $__empty_1 = true; $__currentLoopData = $permited_budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                           <option value="<?php echo e($b_val->id); ?>" > <?php echo e($b_val->_name ?? ''); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                             <?php endif; ?>
                         </select>
                      </td>
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger_report_foreign')): ?>
                              <td>
                                <input type="number" name="_foreign_amount[]" class="form-control  _foreign_amount" placeholder="<?php echo e(__('label._foreign_amount')); ?>" value="<?php echo e(old('_foreign_amount',0)); ?>">
                              </td>
      <?php endif; ?>
                            <td>
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="<?php echo e(old('_dr_amount',0)); ?>">
                            </td>
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="<?php echo e(old('_cr_amount',0)); ?>">
                              </td>
                            </tr>`);

      $(document).find('.number_of_row').val(new_row_number);

var _master_organization_id = $(document).find("._master_organization_id").val();
var _master_branch_id = $(document).find('._master_branch_id').val();
var _master_cost_center_id = $(document).find("._master_cost_center_id").val();
var _master_budget_id = $(document).find('._master_budget_id').val();

$(document).find(".organization_details_id__"+new_row_number).val(_master_organization_id).change();
$(document).find("._branch_id_detail__"+new_row_number).val(_master_branch_id).change();
$(document).find("._cost_center__"+new_row_number).val(_master_cost_center_id).change();
$(document).find("._budget_details_id__"+new_row_number).val(_master_budget_id).change();

      
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


  $(document).on('click','.submit-button',function(event){
    event.preventDefault();
    var _total_dr_amount = $(document).find("._total_dr_amount").val();
    var _total_cr_amount = $(document).find("._total_cr_amount").val();
    var _voucher_type = $(document).find('._voucher_type').val();

    var _master_organization_id  = $(document).find('._master_organization_id').val();
    var _master_branch_id        = $(document).find('._master_branch_id').val();
    var _master_cost_center_id    = $(document).find('._master_cost_center_id').val();

    if(_master_organization_id ==''){
      $(document).find('._master_organization_id').focus().addClass('required_border');
      alert("Please Select Organization");
      return false;
    }
    if(_master_branch_id ==''){
      $(document).find('._master_branch_id').focus().addClass('required_border');
      alert("Please Select Branch");
      return false;
    }
    if(_master_cost_center_id ==''){
       $(document).find('._master_cost_center_id').focus().addClass('required_border');
      alert("Please Select Cost Center");
      return false;
    }

    var _note = $(document).find('._note').val();
    var _search_ledger_id = $(document).find('._search_ledger_id').val();


    var empty_ledger = [];
    $(document).find("._ledger_id").each(function(){
        if($(this).val() ==""){
          alert(" Please Add Ledger  ");
          $(document).find('._search_ledger_id').focus().addClass('required_border');
          empty_ledger.push(1);
        }  
    })

    if(empty_ledger.length > 0){
      return false;
    }


    if(_total_dr_amount !=_total_cr_amount){
      $(document).find("._total_dr_amount").focus().addClass('required_border');
      $(document).find("._total_cr_amount").focus().addClass('required_border');
      return false;

    }else if(_voucher_type ==""){
       $(document).find('._voucher_type').focus().addClass('required_border');
       alert('Please Select Voucher Type.');
      return false;
    }else if(_note ==""){
       
       $(document).find('._note').focus().addClass('required_border');
      return false;
    }else if(_search_ledger_id ==""){
       
      $(document).find('._search_ledger_id').focus().addClass('required_border');
      return false;
    }else{
       $('.submit-button').attr('disabled','true');
      $(document).find('.voucher-form').submit();
    }
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


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/voucher/create.blade.php ENDPATH**/ ?>