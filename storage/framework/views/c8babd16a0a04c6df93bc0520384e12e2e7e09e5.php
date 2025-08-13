
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('transfer.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-create')): ?>
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="<?php echo e(route('transfer.create')); ?>"> Add New </a>
               </li>
              <?php endif; ?>
            </ol>
          </div>

          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                       <?php echo $__env->make('backend.transfer.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-print')): ?>
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="<?php echo e($print_url); ?>" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Main  Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="<?php echo e($print_url_detal); ?>"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             <?php endif; ?>   
                         <?php echo $datas->render(); ?>

                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  
                  <table class="table table-bordered table-striped table-hover _list_table">
                      <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>Type</b></th>
                         <th class=""><b>Status</b></th>
                         <th class=""><b>From Branch</b></th>
                         <th class=""><b>To Branch</b></th>
                         <th class=""><b>From Cost Center</b></th>
                         <th class=""><b>To Cost Center</b></th>
                         <th class=""><b>Referance</b></th>
                         <th class=""><b>Stock In Amount</b></th>
                         <th class=""><b>Stock Out Amount</b></th>
                         <th class=""><b>Created By</b></th>
                         <th class=""><b>Updated By</b></th>
                         <th>Lock</th>

                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $sum_of_amount=0;
                       $sum_of_sub_total=0;
                      ?>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                           $sum_of_amount += $data->_total ?? 0;
                           $sum_of_sub_total += $data->_stock_in__total ?? 0;
                        ?>

                        <?php


                        $___stock_in = $data->_stock_in ?? [];
                        $___stock_out = $data->_stock_out ?? [];
                        ?>
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item " href="<?php echo e(url('transfer/print')); ?>/<?php echo e($data->id); ?>" >
                                         View & Print
                                      </a>
                                     <a class="dropdown-item " href="<?php echo e(url('transfer/stock-in')); ?>/<?php echo e($data->id); ?>" >
                                         Stock In Print Print
                                      </a>
                                     <a class="dropdown-item " href="<?php echo e(url('transfer/stock-out')); ?>/<?php echo e($data->id); ?>" >
                                         Stock Out Print
                                      </a>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-edit')): ?>
                                        <a class="dropdown-item " href="<?php echo e(route('transfer.edit',$data->id)); ?>" >
                                          Edit
                                        </a>
                                    <?php endif; ?>
                                     
                                  </div>
                                </div>
                                
                                
                                <a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__<?php echo e($key); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td><?php echo e($data->id); ?></td>
                            <td><?php echo e(_view_date_formate($data->_date ?? '')); ?> <?php echo e($data->_time ?? ''); ?></td>
                            <td><?php echo e($data->_type ?? ''); ?></td>

                            <td>
                              <span class="btn btn-sm <?php if($data->_p_status ==3): ?> btn-success <?php elseif($data->_p_status ==2): ?> btn-warning <?php else: ?> btn-info <?php endif; ?>"><?php echo e(_p_t_status($data->_p_status ?? '')); ?></span>
                            </td>
                            <td><?php echo e(_branch_name($data->_from_branch ?? 1)); ?></td>
                            <td><?php echo e(_branch_name($data->_to_branch ?? 1)); ?></td>
                            <td><?php echo e(_cost_center_name($data->_from_cost_center ?? 1)); ?></td>
                            <td><?php echo e(_cost_center_name($data->_to_cost_center ?? 1)); ?></td>
                            <td><?php echo e($data->_reference ?? ''); ?></td>
                            <td><?php echo e(_report_amount( $data->_stock_in__total ?? 0)); ?> </td>
                            <td><?php echo e(_report_amount( $data->_total ?? 0)); ?> </td>
                            <td><?php echo e($data->_created_by ?? ''); ?></td>
                            <td><?php echo e($data->_updated_by ?? ''); ?></td>
                           <td style="display: flex;">
                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock-permission')): ?>
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="<?php echo e($data->id); ?>" value="<?php echo e($data->_lock); ?>" <?php if($data->_lock==1): ?> checked <?php endif; ?>>
                              <?php endif; ?>

                              <?php if($data->_lock==1): ?>
                              <i class="fa fa-lock _green ml-1 _icon_change__<?php echo e($data->id); ?>" aria-hidden="true"></i>
                              <?php else: ?>
                              <i class="fa fa-lock _required ml-1 _icon_change__<?php echo e($data->id); ?>" aria-hidden="true"></i>
                              <?php endif; ?>

                            </td>
                            
                           
                        </tr>
                        <?php if(sizeof($___stock_in) > 0): ?>


                        <tr>
                          <td colspan="15" >
                           <div class="collapse" id="collapseExample__<?php echo e($key); ?>">
                           <div class="card-header">
                                <b>Stock In</b>
                              </div>
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>Item</th>
                                  <th>Store</th>
                                  <th>Unit</th>
                                  <th>Qty</th>
                                  <th>Rate</th>
                                  <th>Sales Rate</th>
                                  <th class="text-right">Value</th>
                                  <th>Manu. Date  </th>
                                  <th>Expired Date  </th>
                                  <th>Shelf</th>
                                </thead>
                                <tbody>
                                  <?php
                                    $_stock_in_total = 0;
                                  ?>
                                  <?php $__empty_1 = true; $__currentLoopData = $data->_stock_in; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_key=>$_master_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <tr>
                                    <td><?php echo e(($_master_val->id)); ?></td>
                                    <td><?php echo e(_item_name($_master_val->_item_id)); ?> <br>
                                      <small><span>Barcode: <?php echo e($_master_val->_barcode ?? 'N/A'); ?></span></small>
                                    </td>
                                    <td><?php echo e(_store_name($_master_val->_store_id ?? 1 )); ?></td>
                                    <td><?php echo e(_find_unit($_master_val->_store_id ?? 1 )); ?></td>
                                    <td><?php echo e(_report_amount($_master_val->_qty ?? '')); ?></td>
                                    <td><?php echo e(_report_amount($_master_val->_rate ?? '')); ?></td>
                                    <td><?php echo e(_report_amount($_master_val->_sales_rate ?? '')); ?></td>
                                    <td class="text-right"><?php echo e(_report_amount( $_master_val->_value ?? 0)); ?></td>
                                    <td><?php echo e($_master_val->_manufacture_date  ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_expire_date  ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_store_salves_id  ?? ''); ?></td>
                                    <?php 
                                    $_stock_in_total += $_master_val->_value;    
                                    ?>
                                  </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </tbody>
                                
                                <tfoot>
                                  <tr>
                                    <td colspan="7" class="text-left"><b>Total</b></td>
                                    <td  class="text-right"><b><?php echo e(_report_amount($_stock_in_total ?? 0 )); ?> </b></td>
                                    <td colspan="3"></td>
                                   
                                    
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </td>
                        </tr>
                        <?php endif; ?>
                        <?php if(sizeof($___stock_out) > 0): ?>
                        <tr>
                          <td colspan="15" >
                           <div class="collapse" id="collapseExample__<?php echo e($key); ?>">
                            <div class="card " >
                              <div class="card-header">
                                <b>Stock Out</b>
                              </div>
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>Item</th>
                                  <th>Store</th>
                                  <th>Unit</th>
                                  <th>Qty</th>
                                  <th>Rate</th>
                                  <th>Sales Rate</th>
                                  <th class="text-right">Value</th>
                                  <th>Manu. Date  </th>
                                  <th>Expired Date  </th>
                                  <th>Shelf</th>
                                </thead>
                                <tbody>
                                  <?php
                                    $_stock_out_total = 0;
                                  ?>
                                  <?php $__empty_1 = true; $__currentLoopData = $data->_stock_out; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail_key=>$_master_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <tr>
                                    <td><?php echo e(($_master_val->id)); ?></td>
                                    <td><?php echo e(_item_name($_master_val->_item_id)); ?> <br>
                                      <small><span>Barcode: <?php echo e($_master_val->_barcode ?? 'N/A'); ?></span></small>
                                    </td>
                                    <td><?php echo e(_store_name($_master_val->_store_id ?? 1 )); ?></td>
                                    <td><?php echo e(_find_unit($_master_val->_transection_unit ?? 1)); ?></td>
                                    <td><?php echo e(_report_amount($_master_val->_qty ?? '')); ?></td>
                                    <td><?php echo e(_report_amount($_master_val->_rate ?? '')); ?></td>
                                    <td><?php echo e(_report_amount($_master_val->_sales_rate ?? '')); ?></td>
                                    <td class="text-right"><?php echo e(_report_amount( $_master_val->_value ?? 0)); ?></td>
                                    <td><?php echo e($_master_val->_manufacture_date  ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_expire_date  ?? ''); ?></td>
                                    <td><?php echo e($_master_val->_store_salves_id  ?? ''); ?></td>
                                    <?php 
                                    $_stock_out_total += $_master_val->_value;    
                                    ?>
                                  </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="8" class="text-left"><b>Total</b></td>
                                    <td  class="text-right"><b><?php echo e(_report_amount($_stock_out_total ?? 0 )); ?> </b></td>
                                    <td colspan="3"></td>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td colspan="11" class="text-left"><b>Total</b></td>
                          <td><b><?php echo e(_report_amount($sum_of_sub_total)); ?> </b></td>
                          <td><b><?php echo e(_report_amount($sum_of_amount)); ?> </b></td>
                          <td colspan="3" ></td>
                        </tr>
                        </tbody>

                        <tfoot>
                          <tr>
                            <td colspan="17"> <?php echo $datas->render(); ?></td>
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

 $(document).on('keyup','._search_main_ledger_id',delay(function(e){
    $(document).find('._search_main_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _account_head_id = 13;

  var request = $.ajax({
      url: "<?php echo e(url('main-ledger-search')); ?>",
      method: "GET",
      data: { _text_val,_account_head_id },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                  
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $("._ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);

    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })
  
  $(document).on("click",'.search_modal',function(){
    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })


  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="productions";
   if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })



</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/transfer/index.blade.php ENDPATH**/ ?>