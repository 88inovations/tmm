
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name"><?php echo $page_name ?? ''; ?> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>">Home</a></li> -->
              <li class="breadcrumb-item active">
              
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success">
      <p><?php echo e($message); ?></p>
    </div>
    <?php endif; ?>
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
                      <?php echo $__env->make('backend.item-information.cylinder_search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-print')): ?>
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="<?php echo e($print_url); ?>" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i> Print
                                </a>  
                            </li>
                             <?php endif; ?>   
                         <?php echo $datas->render(); ?>

                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                        <th>##</th>
                         <th>SL</th>
                         <th>ID</th>
                         <th>Ref</th>
                         <th>IN Type</th>
                         <th><?php echo e(__('label._item_category')); ?></th>
                         <th>Item Id</th>
                         <th>Item</th>
                         <th>Unit</th>
                         <th>Code</th>
                         <th>Barcode</th>
                         <th>Model</th>
                         <th>Warranty</th>
                         <th>QTY</th>
                         
                         <th>Discount</th>
                         <th>Vat</th>
                         <th>Purchase Rate</th>
                         <th>Sales Rate</th>
                         <th>Total Value</th>
                         <th>Manu. Date</th>
                         <th>Exp. Date</th>
                         <th><?php echo e(__('label.organization_id')); ?></th>
                         <th><?php echo e(__('label._branch_id')); ?></th>
                         <th><?php echo e(__('label._cost_center_id')); ?></th>
                         <th><?php echo e(__('label._store_id')); ?></th>
                         <th><?php echo e(__('label._customer_id')); ?></th>
                         <th><?php echo e(__('label._supplier_id')); ?></th>
                         <th><?php echo e(__('label._short_note')); ?></th>
                         <th>Status</th>            
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        $total_qty=0;
                        $total_value=0;
                      ?>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                        $total_qty +=$data->_qty;
                        $total_value +=($data->_qty*$data->_pur_rate);
                      ?>
                        <tr>
                           
                           <td class="_list_table_td">
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-sales-price-update')): ?>
                            <a class="mr-4"  href="<?php echo e(url('cylinder_product')); ?>/<?php echo e($data->id); ?>" role="button"><i class="nav-icon fas fa-edit"></i></a>
                            <?php endif; ?>
                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-management-report')): ?>
                            <?php if($data->_transfer_to_asset==0): ?>
                           

                              <button 
                              attr_item_id="<?php echo e($data->_item_id); ?>" 
                              attr_p_p_id="<?php echo e($data->id); ?>" 
                              attr_item_qty="<?php echo e($data->_qty); ?>"
                              attr_item_name="<?php echo e($data->_item ?? ''); ?>"
                              attr_barcode="<?php echo e($data->_barcode ?? ''); ?>"
                              attr_unique_barcode="<?php echo e($data->_items->_unique_barcode ?? ''); ?>"
                              type="button" class="btn btn-sm btn-warning transferModalButton " 
                              data-toggle="modal" data-target="#exampleModalFour">
                                                        <?php echo e(__('label.transfer_to_asset_item')); ?>

                              </button>
                            <?php endif; ?>
                            <?php endif; ?>
                             

                          </td>
                            <td class="_list_table_td"><?php echo e(($key+1)); ?></td>
                            <td class="_list_table_td"><?php echo e($data->id ?? ''); ?></td>
                            
                            <td class="_list_table_td"><?php echo $data->_p_p_id ?? ''; ?></td>
                            
                            
                            <td class="_list_table_td"><?php echo e($data->_input_type ?? ''); ?></td>
                            <td class="_list_table_td"><?php echo e($data->_items->_item_category ?? ''); ?></td>
                            <td class="_list_table_td"><?php echo e($data->_item_id ?? ''); ?></td>
                            <td class="_list_table_td"><?php echo e($data->_item ?? ''); ?></td>
                            <td class="_list_table_td"><?php echo e($data->_units->_name ?? ''); ?></td>
                           <td class="_list_table_td"><?php echo e($data->_items->_code ?? ''); ?></td>
                            <td class="_list_barcode">
                              <?php
                                $barcode_arrays = explode(',', $data->_barcode ?? '');
                                ?>
                                <?php $__empty_1 = true; $__currentLoopData = $barcode_arrays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                              <span style="width: 100%;"><?php echo e($barcode); ?></span><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td class="_list_table_td"><?php echo e($data->_model ?? ''); ?></td>
                            <td class="_list_table_td"><?php echo e($data->_warranty_name->_name ?? ''); ?></td>
                            <td class="text-right _list_table_td"><?php echo e(_report_amount($data->_qty ?? 0)); ?></td>
                            <td class="text-right _list_table_td"><?php echo e(_report_amount( $data->_discount ?? 0 )); ?></td>
                            <td class="text-right _list_table_td"><?php echo e(_report_amount( $data->_vat ?? 0 )); ?></td>
                            <td class="text-right _list_table_td"><?php echo e(_report_amount($data->_pur_rate ?? 0 )); ?></td>
                            <td class="text-right _list_table_td"><?php echo e(_report_amount($data->_sales_rate ?? 0 )); ?></td>
                            <td class="text-right _list_table_td"><?php echo e(_report_amount(($data->_qty*$data->_pur_rate) )); ?></td>
                            <td class="_list_table_td"><?php echo e(_view_date_formate($data->_manufacture_date ?? '')); ?></td>
                            <td class="_list_table_td"><?php echo e(_view_date_formate($data->_expire_date ?? '')); ?></td>

                          <td><?php echo $data->_organization->_name ?? ''; ?></td>
                          <td><?php echo $data->_master_branch->_name ?? ''; ?></td>
                          <td><?php echo $data->_master_cost_center->_name ?? ''; ?></td>
                          <td><?php echo $data->_master_store->_name ?? ''; ?></td>
                          <td><?php echo $data->_customer->_name ?? ''; ?></td>
                          <td><?php echo $data->_supplier->_name ?? ''; ?></td>
                          <td><?php echo $data->_short_note ?? ''; ?></td>
                          
                           <td class="_list_table_td">
                             <?php if($data->_status ==1): ?>
                             <span class="btn btn-sm btn-info">Saleable</span>
                             <?php else: ?>
                               <span class="btn btn-sm btn-danger">Not Saleable</span>
                             <?php endif; ?>
                           </td>
                           
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <th colspan="12" class="text-right">Total</th>
                          <th class="text-right"><?php echo e(_report_amount($total_qty)); ?></th>
                          <th colspan="4"></th>
                          <th class="text-right"><?php echo e(_report_amount($total_value)); ?></th>
                          <th colspan="3"></th>
                          <th colspan="6"></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 <?php echo $datas->render(); ?>

                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


<div class="modal fade" id="exampleModalFour" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelText" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelText">Modal Four</h5>
             <button type="button" class="btn btn-danger commonModalClose" attr_modal_name='#exampleModalFour' >Close</button>
          </div>
          <div class="modal-body" id="commonEntryModalFormFour">
            <form class="itemTransferForm" action="<?php echo e(url('transfer_to_asset_item')); ?>">
              <?php echo csrf_field(); ?>
              <div class="form-group">
                <label class="form-lable">ID</label>
                <input type="text" readonly name="id" class="form-control _pp_id">
              </div>
              <div class="form-group">
                <label class="form-lable">Qty</label>
                <input type="number" name="_qty" class="form-control attr_item_qty">
                <input type="hidden" name="attr_unique_barcode" class="form-control attr_unique_barcode">
              </div>
              <div class="form-group ">
                <label class="form-lable">Availbale Barcode</label>
                 <input type="text" readonly name="attr_barcode" class="form-control  attr_barcode " id="attr_barcode" >
              </div>
              <div class="form-group  row__barcode">
                <label class="form-lable">Transfer <?php echo e(__('label._barcode')); ?></label>
                 <input type="text" name="_barcode" class="form-control _barcode __barcode " id="1__barcode" >
               
              </div>

              <div class="form-group  ">
               
                 <button class="btn btn-lg btn-success transfer_to_asset_item" type="button"> <?php echo e(__('label.transfer_to_asset_item')); ?></button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
           <button type="button" class="btn btn-danger commonModalClose" attr_modal_name='#exampleModalFour' >Close</button>
           
          </div>
        </div>
      </div>
    </div>


<div class="modal fade" id="cylinderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelText" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelText">Modal Four</h5>
             <button type="button" class="btn btn-danger commonModalClose" attr_modal_name='#cylinderModal' >Close</button>
          </div>
          <div class="modal-body" >
            <form class="itemTransferForm_toCylinder" action="<?php echo e(url('cylindar_location_transfer')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <div class="form-group">
                <label class="form-lable">ID</label>
                <input type="text" readonly name="id" class="form-control _pp_id">
              </div>
              <div class="form-group">
                <label class="form-lable">Qty</label>
                <input type="number" name="_qty" class="form-control attr_item_qty">
                <input type="hidden" name="attr_unique_barcode" class="form-control attr_unique_barcode">
              </div>
              <div class="form-group ">
                <label class="form-lable">Availbale Barcode</label>
                 <input type="text" readonly name="attr_barcode" class="form-control  attr_barcode " id="attr_barcode" >
              </div>
              <div class="form-group  row__barcode">
                <label class="form-lable">Transfer <?php echo e(__('label._barcode')); ?></label>
                 <input type="text" name="_barcode" class="form-control _barcode __barcode " id="1__barcode" >
               
              </div>

              <div class="form-group  ">
               
                 <button class="btn btn-lg btn-success transfer_to_cylinder" type="button"> <?php echo e(__('label.cylinderTransferButton')); ?></button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
           <button type="button" class="btn btn-danger commonModalClose" attr_modal_name='#cylinderModal' >Close</button>
           
          </div>
        </div>
      </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
  

  $(document).on('click','.transferModalButton',function(){

    var attr_item_id = $(this).attr('attr_item_id');
    var attr_p_p_id = $(this).attr('attr_p_p_id');
    var attr_item_qty = $(this).attr('attr_item_qty');
    var attr_item_name = $(this).attr('attr_item_name');
    var attr_barcode = $(this).attr('attr_barcode');
    var attr_unique_barcode = $(this).attr('attr_unique_barcode');
    var attr_unique="1";

    $(document).find("#exampleModalLabelText").text(attr_item_name);
    $(document).find("._pp_id").val(attr_p_p_id);
    $(document).find(".attr_item_qty").val(attr_item_qty);
    $(document).find(".attr_unique_barcode").val(attr_unique_barcode);
    $(document).find(".attr_barcode").val(attr_barcode);

if(attr_unique_barcode ==1){
  $(document).find(".row__barcode").removeClass("display_none")
    _new_barcode_function(attr_unique);
  }else{
     $(document).find(".row__barcode").addClass("display_none");
     $(document).find("#1__barcode").val('');
  }


 

  });



 // When the transfer button is clicked
$(document).on("click",".transfer_to_asset_item",function(event){
      // Get the value of available barcodes (old barcodes)
      var old_barcode = $(document).find('#attr_barcode').val(); // Assuming it's a comma-separated list
      var new_barcode = $(document).find('.__barcode').val(); // Assuming it's a comma-separated list
      var attr_item_qty = $(document).find(".attr_item_qty").val();
      var attr_unique_barcode = $(document).find(".attr_unique_barcode").val();


      if(isNaN(attr_item_qty)){attr_item_qty=0}
      // Get the value of the transfer barcodes (new barcodes)
    //  console.log(new_barcode)

      // Split the barcodes into arrays
      var oldBarcodeArray = old_barcode.split(',').map(function(item) { return item.trim(); });
      var newBarcodeArray = new_barcode.split(',').map(function(item) { return item.trim(); });

      var notMatchedBarcodes = [];
      if(newBarcodeArray.length > attr_item_qty){
        alert("You Want to Transfer More then Available Qty");
        return false;
      }

      // Check if all new barcodes exist in the old barcodes

      // Loop through each new barcode and check if it exists in the old barcode array
      newBarcodeArray.forEach(function(barcode) {
        if (!oldBarcodeArray.includes(barcode)) {
          notMatchedBarcodes.push(barcode); // Add to unmatched barcodes list
        }
      });

      // If there are unmatched barcodes, show a message
      if (notMatchedBarcodes.length > 0 && attr_unique_barcode !=0) {
        var message = "The following barcodes do not match: " + notMatchedBarcodes.join(', ');
        alert(message); // Show the message in an alert or update your UI
      } else {
        // If all barcodes match, submit the form
        $('.itemTransferForm').submit();  // Submit the form
      }
    });





  function _new_barcode_function(_item_row_count){
      $(document).find('#'+_item_row_count+'__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }




  $(document).on('click','.cylinderTransferButton',function(){

    var attr_item_id = $(this).attr('attr_item_id');
    var attr_p_p_id = $(this).attr('attr_p_p_id');
    var attr_item_qty = $(this).attr('attr_item_qty');
    var attr_item_name = $(this).attr('attr_item_name');
    var attr_barcode = $(this).attr('attr_barcode');
    var attr_unique_barcode = $(this).attr('attr_unique_barcode');
    var attr_unique="1";

    $(document).find("#exampleModalLabelText").text(attr_item_name);
    $(document).find("._pp_id").val(attr_p_p_id);
    $(document).find(".attr_item_qty").val(attr_item_qty);
    $(document).find(".attr_unique_barcode").val(attr_unique_barcode);
    $(document).find(".attr_barcode").val(attr_barcode);

if(attr_unique_barcode ==1){
  $(document).find(".row__barcode").removeClass("display_none")
    _new_barcode_function(attr_unique);
  }else{
     $(document).find(".row__barcode").addClass("display_none");
     $(document).find("#1__barcode").val('');
  }


 

  });

 // When the transfer button is clicked
$(document).on("click",".transfer_to_cylinder",function(event){
      // Get the value of available barcodes (old barcodes)
      var old_barcode = $(document).find('#attr_barcode').val(); // Assuming it's a comma-separated list
      var new_barcode = $(document).find('.__barcode').val(); // Assuming it's a comma-separated list
      var attr_item_qty = $(document).find(".attr_item_qty").val();
      var attr_unique_barcode = $(document).find(".attr_unique_barcode").val();


      if(isNaN(attr_item_qty)){attr_item_qty=0}
      // Get the value of the transfer barcodes (new barcodes)
    //  console.log(new_barcode)

      // Split the barcodes into arrays
      var oldBarcodeArray = old_barcode.split(',').map(function(item) { return item.trim(); });
      var newBarcodeArray = new_barcode.split(',').map(function(item) { return item.trim(); });

      var notMatchedBarcodes = [];
      if(newBarcodeArray.length > attr_item_qty){
        alert("You Want to Transfer More then Available Qty");
        return false;
      }

      // Check if all new barcodes exist in the old barcodes

      // Loop through each new barcode and check if it exists in the old barcode array
      newBarcodeArray.forEach(function(barcode) {
        if (!oldBarcodeArray.includes(barcode)) {
          notMatchedBarcodes.push(barcode); // Add to unmatched barcodes list
        }
      });

      // If there are unmatched barcodes, show a message
      if (notMatchedBarcodes.length > 0 && attr_unique_barcode !=0) {
        var message = "The following barcodes do not match: " + notMatchedBarcodes.join(', ');
        alert(message); // Show the message in an alert or update your UI
      } else {
        // If all barcodes match, submit the form
        $('.itemTransferForm_toCylinder').submit();  // Submit the form
      }
    });





</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/item-information/cylinder_product.blade.php ENDPATH**/ ?>