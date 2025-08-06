
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a class="m-0 _page_name" href="<?php echo e(route('budgets.index')); ?>"> <?php echo $page_name ?? ''; ?> </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>">Home</a></li> -->
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="<?php echo e(route('budgets.index')); ?>"> <?php echo e($page_name ?? ''); ?> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                <?php echo Form::open(array('route' => 'budgets.store','method'=>'POST')); ?>

                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label><?php echo e(__('label._name')); ?>:<span class="_required">*</span></label>
                                <?php echo Form::text('_name', null, array('placeholder' => __('label._name'),'class' => 'form-control','required'=>'true')); ?>

                            </div>
                    </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                     <div class="form-group ">
                         <label><?php echo __('label.organization'); ?>:<span class="_required">*</span></label>
                        <select class="form-control _master_organization_id" name="organization_id" required >

                           <?php if(sizeof($permited_organizations)>1): ?> 
                            <option value=""><?php echo e(__('label.organization')); ?></option>
                            <?php endif; ?>
                           <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                           <option value="<?php echo e($val->id); ?>" <?php if(isset($request->organization_id)): ?> <?php if($request->organization_id == $val->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                           <?php endif; ?>
                         </select>
                     </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                     <div class="form-group ">
                         <label>Branch:<span class="_required">*</span></label>
                        <select class="form-control _master_branch_id" name="_branch_id" required >
                           <?php if(sizeof($permited_branch) > 1): ?> 
                           <option value=""><?php echo e(__('label.Branch')); ?></option>
                            <?php endif; ?>
                           <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                           <option value="<?php echo e($branch->id); ?>" <?php if(isset($request->_branch_id)): ?> <?php if($request->_branch_id == $branch->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                           <?php endif; ?>
                         </select>
                     </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                     <div class="form-group ">
                         <label><?php echo e(__('label.Cost center')); ?>:<span class="_required">*</span></label>
                        <select class="form-control _cost_center_id" name="_cost_center_id" required >
                          <?php if(sizeof($permited_costcenters)>1): ?> 
<option value=""><?php echo e(__('label.Cost center')); ?></option>
                           <?php endif; ?>
                           
                           <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                           <option value="<?php echo e($cost_center->id); ?>" <?php if(isset($request->_cost_center_id)): ?> <?php if($request->_cost_center_id == $cost_center->id): ?> selected <?php endif; ?>   <?php endif; ?>><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                           <?php endif; ?>
                         </select>
                     </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="<?php echo e(old('_search_main_ledger_id')); ?>" placeholder="Customer" required>

                            <input type="hidden" id="_main_ledger_id" name="_customer_id" class="form-control _main_ledger_id" value="<?php echo e(old('_customer_id')); ?>" placeholder="Supplier" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('label._po_order')); ?>:</label>
                                <?php echo Form::text('_po_order', null, array('placeholder' => __('label._po_order'),'class' => 'form-control')); ?>

                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('label._wo_order')); ?>:</label>
                                <?php echo Form::text('_wo_order', null, array('placeholder' => __('label._wo_order'),'class' => 'form-control')); ?>

                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('label.start_date')); ?>:</label>
                                <?php echo Form::date('_start_date', null, array('placeholder' => __('label.start_date'),'class' => 'form-control')); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('label.end_date')); ?>:</label>
                                <?php echo Form::date('_end_date', null, array('placeholder' => __('label.end_date'),'class' => 'form-control')); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('label._project_value')); ?>:<span class="_required">*</span></label>
                                <?php echo Form::number('_project_value', null, array('placeholder' => __('label._project_value'),'class' => 'form-control','step'=>'any','required'=>'required')); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_status">
                                  <?php $__currentLoopData = common_status(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$s_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key); ?>" ><?php echo e($s_val); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                   </div>
                   <div class="row">
                    <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong><?php echo e(__('label.budget_income_head')); ?></strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>Ledger</th>
                                            <th>Short Narr.</th>
                                            <th>Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details form_body" id="area__voucher_details">
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                                                <div class="search_box"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount budget_income" placeholder="Cr. Amount" value="<?php echo e(old('_cr_amount',0)); ?>">
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td></td>
                                              
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="0" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                     <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong><?php echo e(__('label.budget_material_detail')); ?></strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left" >Unit</th>
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left" >Rate</th>
                                            <th class="text-left" >Value</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              <td >
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" >
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td  class="text-right"><b>Total</b></td>
                                             <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>



                        <div class="col-md-12  ">
                             <div class="card ">
                              <div class="card-header">
                                <strong><?php echo e(__('label.budget_expenses_head')); ?></strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>Ledger</th>
                                            <th><?php echo e(__('label._type')); ?></th>
                                            <th>Short Narr.</th>
                                            <th>Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details_expenses form_body" id="area__voucher_details_expenses">
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                                                <input type="hidden" name="_exp_ledger_id[]" class="form-control _ledger_id" >
                                                <div class="search_box"> </div>
                                              </td>
                                              <td>
                                                <select class="form-control" name='_ledger_type[]'>
                                                  <option value="expense">Expenses</option>
                                                  <option value="deduction">Deduction</option>
                                                </select>
                                              </td>
                                              <td>
                                                <input type="text" name="_exp_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              <td>
                                                <input type="number" name="_exp_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="<?php echo e(old('_dr_amount',0)); ?>">
                                              </td>
                                              
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="voucher_row_add_expense(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                               <td  class="text-right"><b>Total</b></td>
                                              <td></td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="0" readonly required>
                                              </td>
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;">
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_remarks">Note<span class="_required">*</span></label></td>
                              <td style="width: 70%;border:0px;">
                                
                                    <textarea required name="_remarks" class="form-control _remarks"><?php echo e(old('_remarks',$data->_remarks ?? '' )); ?></textarea>
                                    
                              </td>
                            </tr>

                            <tr>
                              <td style="width: 20%;border:0px;"><label for="expected_income"><?php echo e(__('label.expected_income')); ?></label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="expected_income" class="form-control width_200_px" id="expected_income" readonly value="0">
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 20%;border:0px;"><label for="expected_material_expense"><?php echo e(__('label.expected_material_expense')); ?></label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="expected_material_expense" class="form-control width_200_px" id="expected_material_expense" readonly value="0">
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 20%;border:0px;"><label for="expected_other_expenses"><?php echo e(__('label.expected_other_expenses')); ?></label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="expected_other_expenses" class="form-control width_200_px" id="expected_other_expenses" readonly value="0">
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 20%;border:0px;"><label for="expected_profit"><?php echo e(__('label.expected_profit')); ?></label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="expected_profit" class="form-control width_200_px" id="expected_profit" readonly value="0">
                              </td>
                            </tr>

                            <tr class="display_none">
                              <td style="width: 20%;border:0px;"><label for="_sub_total"><?php echo e(__('label.expected_income')); ?></label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_purchase_sub_total" readonly value="0">
                              </td>
                            </tr>
                            <tr class="display_none">
                              <td style="width: 20%;border:0px;"><label for="_total">NET Total </label></td>
                              <td style="width: 70%;border:0px;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_purchase_total" readonly value="0">
                              </td>
                            </tr>
                             
                          </table>
                        </div>
                       
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
                    
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
  var _item_row_count =1;
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


var duplicate_barcode_status=0;
  

  $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "<?php echo e(url('item-purchase-search')); ?>",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 500px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]?. _manufacture_company;
                          var _balance = data[i]?._balance
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                   <td>${_balance} ${data[i]._units?._name}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="4"><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-plus"></i> New Item
                </button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).find('._unique_barcode').val());

  var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();

 
  
  if(isNaN(_item_vat)){ _item_vat=0 }
  _vat_amount = ((_item_rate*_item_vat)/100);

var self = $(this);

    var request = $.ajax({
      url: "<?php echo e(url('item-wise-units')); ?>",
      method: "GET",
      data: { item_id:_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      self.parent().parent().parent().parent().parent().parent().find('._transection_unit').html("")
      self.parent().parent().parent().parent().parent().parent().find("._transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').val(_item_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_item_rate);
  
 
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);

  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_item_rate);

 
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);

  _purchase_total_calculation();
  $(document).find('.search_box_item').hide();
  $(document).find('.search_box_item').removeClass('search_box_show').hide();
  
})




$(document).on('click',function(){
    var searach_show= $(document).find('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $(document).find('.search_box_main_ledger').hasClass('search_box_show');
    var search_box_purchase_order= $(document).find('.search_box_purchase_order').hasClass('search_box_show');
    if(searach_show ==true){
      $(document).find('.search_box_item').removeClass('search_box_show').hide();
    }

    if(search_box_main_ledger ==true){
      $(document).find('.search_box_main_ledger').removeClass('search_box_show').hide();
    }

    if(search_box_purchase_order ==true){
      $(document).find('.search_box_purchase_order').removeClass('search_box_show').hide();
    }

     all_total_calculations();
})

$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._rate').val());

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }

  $(this).closest('tr').find('._value').val((_qty*_rate));
    _purchase_total_calculation();
})


$(document).on('keyup','._dr_amount',function(){
  all_total_calculations();
})
$(document).on('keyup','._cr_amount',function(){
  all_total_calculations();
})
$(document).on('keyup','._dr_amount',function(){
  all_total_calculations();
})

function all_total_calculations(){
  var _total_cr_amount = $(document).find("._total_cr_amount").val();
    _total_cr_amount = parseFloat(_total_cr_amount);
    if(isNaN(_total_cr_amount)){_total_cr_amount=0}
  var _total_value_amount = $(document).find("._total_value_amount").val();
    _total_value_amount = parseFloat(_total_value_amount);
    if(isNaN(_total_value_amount)){_total_value_amount=0}
  var _total_dr_amount = $(document).find("._total_dr_amount").val();
    _total_dr_amount = parseFloat(_total_dr_amount);
    if(isNaN(_total_dr_amount)){_total_dr_amount=0}

  var expected_profit = _total_cr_amount-(_total_value_amount+_total_dr_amount);

  $(document).find("#expected_income").val(_total_cr_amount);
  $(document).find("#expected_material_expense").val(_total_value_amount);
  $(document).find("#expected_other_expenses").val(_total_dr_amount);
  $(document).find("#expected_profit").val(expected_profit);

}



 function _purchase_total_calculation(){
  console.log('calculation here')
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount  = 0;
      $(document).find("._value").each(function() {
            var _s_value =parseFloat($(this).val());
            if(isNaN(_s_value)){_s_value = 0}
          _total__value +=parseFloat(_s_value);
      });
      $(document).find("._qty").each(function() {
            var _s_qty =parseFloat($(this).val());
            if(isNaN(_s_qty)){_s_qty = 0}
          _total_qty +=parseFloat(_s_qty);
      });
    
      $(document).find("._total_qty_amount").val(_total_qty);
      $(document).find("._total_value_amount").val(_total__value);

      var _total = _math_round((parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_total_discount));
      $(document).find("#_purchase_total").val(_total);

      all_total_calculations();
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger"  >
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount budget_income" placeholder="Cr. Amount" value="<?php echo e(old('_cr_amount',0)); ?>">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $(document).find("#area__voucher_details").append(single_row);
  }

  var expense_single_row = `<tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                                                <input type="hidden" name="_exp_ledger_id[]" class="form-control _ledger_id" >
                                                <div class="search_box"> </div>
                                              </td>
                                               <td>
                                                <select class="form-control" name='_ledger_type[]'>
                                                  <option value="expense">Expenses</option>
                                                  <option value="deduction">Deduction</option>
                                                </select>
                                              </td>
                                              <td>
                                                <input type="text" name="_exp_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              <td>
                                                <input type="number" name="_exp_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="<?php echo e(old('_exp_dr_amount',0)); ?>">
                                              </td>
                                              
                                            </tr>`

  function voucher_row_add_expense(event) {
      event.preventDefault();
      $(document).find("#area__voucher_details_expenses").append(expense_single_row);
  }


function purchase_row_add(event){
   event.preventDefault();
      

       _item_row_count= $(document).find("._item_row_count").val();
      $(document).find("._item_row_count").val((parseFloat(_item_row_count)+1));
     var  _item_row_count = (parseFloat(_item_row_count)+1);
     $(document).find("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              <td >
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" >
                                                <input type="hidden" name="_base_rate[]" class="form-control _base_rate _common_keyup" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                            </tr>`);
     
      

}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
        
        $(this).parent().parent('tr').find('._ref_counter').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
           $(this).parent().parent('tr').find('._ref_counter').remove();
        } 
      }
      _purchase_total_calculation();
  })

 var _purchase_row_single_new =``;

$(document).find(".datetimepicker-input").val(date__today())

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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/budgets/create.blade.php ENDPATH**/ ?>