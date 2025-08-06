
<?php $__env->startSection('title','General Settings'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">


<style>
    .search_box_honorarium_ledger{
        position: absolute;
        z-index: 9999;
        background: #fff;
        display: none;
      }
      ._search_honorarium_row:hover{
          background: #f5f5f5;
          cursor: pointer;
      }

</style>
<?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name" >General Settings </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
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
             
              <div class="card-body" style="margin-bottom: 20px;">
                <form method="POST" action="<?php echo e(route('admin-settings-store')); ?>" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
                    <div class="row">
                      <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>LOGO:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="logo" class="form-control">
                               <img id="output_1" class="banner_image_create" src="<?php echo e(asset('/')); ?><?php echo e($settings->logo ?? ''); ?>"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                      <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Small Logo:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,2 )"  name="small_logo" class="form-control">
                               <img id="output_2" class="banner_image_create" src="<?php echo e(asset('/')); ?><?php echo e($settings->small_logo ?? ''); ?>"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                      <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Water Mark Image:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,3 )"  name="_water_mark_image" class="form-control">
                               <img id="output_3" class="banner_image_create" src="<?php echo e(asset($settings->_water_mark_image ?? '')); ?>"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                      <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Background Image:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,4 )"  name="bg_image" class="form-control">
                               <img id="output_4" class="banner_image_create" src="<?php echo e(asset($settings->bg_image ?? '')); ?>"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Title:</label>
                               <input type="text" name="title"  class="form-control" value="<?php echo e(old('title',$settings->title ?? '' )); ?>">
                               <input type="hidden" name="id" value="<?php echo e($settings->id ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Name:</label>
                               <input type="text" name="name" required class="form-control" value="<?php echo e(old('name',$settings->name ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Short Details:</label>
                               <input type="text" name="keywords"  class="form-control" value="<?php echo e(old('keywords',$settings->keywords ?? '' )); ?>" placeholder="Short Details">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Author:</label>
                               <input type="text" name="author"  class="form-control" value="<?php echo e(old('author',$settings->author ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label> VAT REGISTRATION NO:</label>
                               <input type="text" name="_bin"  class="form-control" value="<?php echo e(old('_bin',$settings->_bin ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>TIN:</label>
                               <input type="text" name="_tin"  class="form-control" value="<?php echo e(old('_tin',$settings->_tin ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Email:</label>
                               <input type="text" name="_email"  class="form-control" value="<?php echo e(old('_email',$settings->_email ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Phone:</label>
                               <input type="text" name="_phone"  class="form-control" value="<?php echo e(old('_phone',$settings->_phone ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea  name="_address"  class="form-control"><?php echo e(old('_address',$settings->_address ?? '' )); ?></textarea>
                              
                            </div>
                        </div>
                    </div>
                    <div class="row" style="background: #ffeb3b42;padding: 10px;">
                        <div class="col-xs-6 col-sm-6 col-md-4">
                           <div class="form-group">
                                <label>SMS Service:</label>
                               <select class="form-control " name="_sms_service">
                                  <option value="0" <?php if($settings->_sms_service==0): ?> selected <?php endif; ?> >NO</option>
                                  <option value="1" <?php if($settings->_sms_service==1): ?> selected <?php endif; ?> >YES</option>
                                </select>
                              </div>
                            </div>
                        <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label><?php echo e(__('label._order_phones')); ?>:</label>
                                <textarea  name="_order_phones"  class="form-control"><?php echo e(old('_order_phones',$settings->_order_phones ?? '' )); ?></textarea>
                              
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label><?php echo e(__('label._sales_phones')); ?>:</label>
                                <textarea  name="_sales_phones"  class="form-control"><?php echo e(old('_sales_phones',$settings->_sales_phones ?? '' )); ?></textarea>
                              
                            </div>
                        </div>


                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group">
                                <label><?php echo e(__('label.sms_url')); ?>:</label>
                                <textarea  name="sms_url"  class="form-control"><?php echo e(old('sms_url',$settings->sms_url ?? '' )); ?></textarea>
                              
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group">
                                <label><?php echo e(__('label.sms_sender')); ?>:</label>
                               <input type="text" name="sms_sender"  class="form-control" value="<?php echo e(old('sms_sender',$settings->sms_sender ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group">
                                <label><?php echo e(__('label.sms_apikey')); ?>:</label>
                               <input type="text" name="sms_apikey"  class="form-control" value="<?php echo e(old('sms_apikey',$settings->sms_apikey ?? '' )); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group">
                                <label><?php echo e(__('label.sms_secretkey')); ?>:</label>
                               <input type="text" name="sms_secretkey"  class="form-control" value="<?php echo e(old('sms_secretkey',$settings->sms_secretkey ?? '' )); ?>">
                            </div>
                        </div>
                        
                          
                          
                        </div>
                        

                  <div class="row" style="background:#1e1b1b5c;padding: 10px;">          
                        <?php


$_cash_group_data= $settings->_cash_group ?? '';

$_cash_group_array = explode(",",$_cash_group_data);

$_bank_group= $settings->_bank_group ?? '';
$_bank_group_array = explode(",",$_bank_group);

                            ?>   
                        
                       
                          
                            <div class="col-xs-6 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <label>Cash Group:</label>
                                   <select class="form-control select2" name="_cash_group[]" multiple>
                                    <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                         <?php if(in_array($_group->id,$_cash_group_array)): ?> selected <?php endif; ?>
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                              </div>
                                
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <label>Bank Group:</label>
                                   <select class="form-control select2" name="_bank_group[]" multiple>
                                      <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" <?php if(in_array($_group->id,$_bank_group_array)): ?> selected <?php endif; ?> ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <?php
$income_expenses_heads =\DB::table('account_heads')->where('_has_child',0)->get();

$_direct_inc_exp_heads= $settings->_direct_inc_exp_heads ?? '';
$_direct_inc_exp_heads_array = explode(",",$_direct_inc_exp_heads);

$_indirect_inc_exp_heads= $settings->_indirect_inc_exp_heads ?? '';
$_indirect_inc_exp_heads_array = explode(",",$_indirect_inc_exp_heads);

                            ?>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <label>Direct Income & Expense Heads:</label>
                                   <select class="form-control select2" name="_direct_inc_exp_heads[]" multiple>
                                      <?php $__empty_1 = true; $__currentLoopData = $income_expenses_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                        <?php if(in_array($_group->id,$_direct_inc_exp_heads_array)): ?> selected <?php endif; ?>
                                        
                                         ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <label>Indirect Income & Expense Heads:</label>
                                   <select class="form-control select2" name="_indirect_inc_exp_heads[]" multiple>
                                      <?php $__empty_1 = true; $__currentLoopData = $income_expenses_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                        <?php if(in_array($_group->id,$_indirect_inc_exp_heads_array)): ?> selected <?php endif; ?> ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            $openig_ledgers = \DB::select(" SELECT t1.id,t1._name,t1._code FROM account_ledgers AS t1
INNER JOIN account_heads AS t2 ON t1._account_head_id=t2.id
INNER JOIN main_account_head AS t3 ON t3.id=t2._account_id
WHERE t3.id IN(5) ");
                            ?>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="form-group">
                                  <label>Opening Balance Ledger:</label>
                                   <select class="form-control " name="_opening_ledger">
                                      <?php $__empty_1 = true; $__currentLoopData = $openig_ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($ledger->id); ?>" <?php if($settings->_opening_ledger==$ledger->id): ?> selected <?php endif; ?> ><?php echo e($ledger->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-module')): ?>
                            <?php
                            $_employee_group = $settings->_employee_group ?? '';
                            ?>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="form-group">
                                  <label>Employee Group:</label>
                                   <select class="form-control select2" name="_employee_group" >
                                      <?php $__empty_1 = true; $__currentLoopData = $all_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($_group->id); ?>" 
                                        <?php if($_group->id==$_employee_group): ?> selected <?php endif; ?>
                                        ><?php echo e($_group->_name ?? ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>
                        <div class="col-sm-3">
                    
                     <div class="form-group">
                        <label>Customer Incentive Ledger </label>
                            <input type="text" id="_search_customer_incentive_ledger" name="_search_customer_incentive_ledger" class="form-control _search_customer_incentive_ledger" value="<?php echo e(old('_search_customer_incentive_ledger',_find_ledger($settings->_customer_incentive_ledger ?? ''))); ?>" placeholder="Customer Incentive Ledger"   attr_url="<?php echo e(url('main-ledger-search')); ?>" >

                            <input type="hidden" id="_customer_incentive_ledger" name="_customer_incentive_ledger" class="form-control _customer_incentive_ledger" value="<?php echo e(old('_customer_incentive_ledger',$settings->_customer_incentive_ledger ?? '')); ?>"  >
                            <div class="asset_dep_search_box_main_ledger"> </div>
                        </div>
                    </div>
                        <div class="col-sm-3">
                    
                     <div class="form-group">
                        <label>Bad Debt Expense Ledger </label>
                            <input type="text" id="_search_baddebt_ledgers" name="_search_baddebt_ledgers" class="form-control _search_baddebt_ledgers" value="<?php echo e(old('_search_baddebt_ledgers',_find_ledger($settings->_baddebt_ledgers ?? ''))); ?>" placeholder="Bad Debt Expense Ledger"   attr_url="<?php echo e(url('main-ledger-search')); ?>" >

                            <input type="hidden" id="_baddebt_ledgers" name="_baddebt_ledgers" class="form-control _baddebt_ledgers" value="<?php echo e(old('_baddebt_ledgers',$settings->_baddebt_ledgers ?? '')); ?>"  >
                            <div class="search_box_bank"> </div>
                        </div>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorarium_module')): ?>
                        <div class="col-sm-3">
                    
                     <div class="form-group">
                        <label><?php echo e(__('label._honorarium_ledger')); ?></label>
                            <input type="text" id="_search_honorarium_ledger" name="_search_honorarium_ledger" class="form-control _search_honorarium_ledger" value="<?php echo e(old('_search_honorarium_ledger',_find_ledger($settings->_honorarium_ledger ?? ''))); ?>" placeholder="<?php echo e(__('label._honorarium_ledger')); ?>"   attr_url="<?php echo e(url('main-ledger-search')); ?>" >

                            <input type="hidden" id="_honorarium_ledger" name="_honorarium_ledger" class="form-control _honorarium_ledger" value="<?php echo e(old('_honorarium_ledger',$settings->_honorarium_ledger ?? '')); ?>"  >
                            <div class="search_box_honorarium_ledger"> </div>
                        </div>
                    </div>
                <?php endif; ?>

                        </div>
                        <div class="row" style="background:#f43665;padding: 10px;">  
                            <div class="col-xs-6 col-sm-6 col-md-4">
                              <div class="form-group">
                                <label>Sales Using Unique Barcode:</label>
                               <select class="form-control " name="_barcode_service">
                                  <option value="0" <?php if($settings->_barcode_service==0): ?> selected <?php endif; ?> >NO</option>
                                  <option value="1" <?php if($settings->_barcode_service==1): ?> selected <?php endif; ?> >YES</option>
                                </select>
                              </div>
                            </div>

                          <div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="form-group">
                                 <label>Auto Lock:</label>
                                   <select class="form-control " name="_auto_lock">
                                      <option value="0" <?php if($settings->_auto_lock==0): ?> selected <?php endif; ?> >NO</option>
                                      <option value="1" <?php if($settings->_auto_lock==1): ?> selected <?php endif; ?> >YES</option>
                                    </select>
                            </div>  
                          </div>


                        <div class="col-xs-6 col-sm-6 col-md-4">
                           <div class="form-group">
                                <label>Purchase Base Model Barcode:</label>
                               <select class="form-control " name="_pur_base_model_barcode">
                                  <option value="0" <?php if($settings->_pur_base_model_barcode==0): ?> selected <?php endif; ?> >NO</option>
                                  <option value="1" <?php if($settings->_pur_base_model_barcode==1): ?> selected <?php endif; ?> >YES</option>
                                </select>
                              </div>
                        </div>
</div>
<div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Invoice Top Text:</label>
                                <textarea class="form-control" name="_top_title" ><?php echo e(old('_top_title',$settings->_top_title ?? '' )); ?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Sales Note:</label>
                                <textarea class="form-control" name="_sales_note" ><?php echo e(old('_sales_note',$settings->_sales_note ?? '' )); ?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Sales Return Note:</label>
                                <textarea class="form-control" name="_sales_return__note" ><?php echo e(old('_sales_return__note',$settings->_sales_return__note ?? '' )); ?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Purchase Note:</label>
                                <textarea class="form-control" name="_purchse_note" ><?php echo e(old('_purchse_note',$settings->_purchse_note ?? '' )); ?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Purchase Return Note:</label>
                                <textarea class="form-control" name="_purchase_return_note" ><?php echo e(old('_purchase_return_note',$settings->_purchase_return_note ?? '' )); ?></textarea>
                            </div>
                        </div>
                       
                  
                    

                       
                        
                        
                        <br><br>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>
                    </form>
                
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
    
  $(document).on('keyup','._search_honorarium_ledger',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_honorarium_ledger').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="_search_honorarium_row" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_honorarium_ledger').html(search_html);
      _gloabal_this.parent('div').find('.search_box_honorarium_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'._search_honorarium_row',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find("._honorarium_ledger").val(_id);
    $(document).find("._search_honorarium_ledger").val(_name);
  


    $(document).find('.search_box_honorarium_ledger').hide();
    $(document).find('.search_box_honorarium_ledger').removeClass('search_box_show').hide();
  })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/settings/index.blade.php ENDPATH**/ ?>