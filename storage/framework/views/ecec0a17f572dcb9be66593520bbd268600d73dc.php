
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="<?php echo e(route('material-issue.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-issue-create')): ?>
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="<?php echo e(route('material-issue.create')); ?>"> Add New </a>
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
                       <?php echo $__env->make('backend.material-issue.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-issue-print')): ?>
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
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class=""><b><?php echo e(__('label.action')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._date')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.organization')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._branch_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._cost_center_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.issue_number')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._referance')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._ledger_id')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._sub_total')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._total')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._user_name')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.created_at')); ?></b></th>
                         <th class=""><b><?php echo e(__('label.updated_at')); ?></b></th>
                         <th class=""><b><?php echo e(__('label._lock')); ?></b></th>
                         
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
                           $sum_of_sub_total += $data->_sub_total ?? 0;
                        ?>
                        <tr>
                            
                          <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item " href="<?php echo e(url('material-issue/print')); ?>/<?php echo e($data->id); ?>" >View & Print</a>
                                     
                                     <a class="dropdown-item " href="<?php echo e(url('material-issue/challan')); ?>/<?php echo e($data->id); ?>" >
                                         Challan
                                      </a>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-issue-edit')): ?>
                                        <a class="dropdown-item " href="<?php echo e(route('material-issue.edit',$data->id)); ?>" >
                                          Edit
                                        </a>
                                    <?php endif; ?>
                                     

                                   
                                  </div>
                                </div>
                                <a class="btn btn-sm btn-default  " attr_invoice_id="<?php echo e($data->id); ?>" _attr_key="<?php echo e($key); ?>" data-toggle="collapse" href="#collapseExample__<?php echo e($key); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i></a>
                            </td>
                            <td><?php echo e($data->id); ?></td>
                            <td><?php echo e(_view_date_formate($data->_date ?? '')); ?></td>
                            <td><?php echo e($data->_organization->_name ?? ''); ?></td>
                            <td><?php echo e($data->_master_branch->_name ?? ''); ?></td>
                            <td><?php echo e($data->_master_cost_center->_name ?? ''); ?></td>
                            <td><?php echo e($data->_order_number ?? ''); ?></td>
                            <td><?php echo e($data->_referance ?? ''); ?></td>
                            <td><?php echo e($data->_ledger->_name ?? ''); ?></td>
                            <td><?php echo e(_report_amount( $data->_sub_total ?? 0)); ?> </td>
                            <td><?php echo e(_report_amount( $data->_total ?? 0)); ?> </td>
                            <td><?php echo e($data->_user_name ?? ''); ?></td>
                            <td><?php echo e($data->created_at ?? ''); ?></td>
                            <td><?php echo e($data->updated_at ?? ''); ?></td>
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

                        <tr>
                          <td colspan="14" class="collapse " id="collapseExample__<?php echo e($key); ?>">
                            <div class="_single_data_display__<?php echo e($data->id); ?>">
                              <?php
                              $_master_details = $data->_master_details ?? [];
                              ?>
                              <?php if(sizeof($_master_details) > 0): ?>
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th><?php echo e(__('label.sl')); ?></th>
                                    <th><?php echo e(__('label._item')); ?></th>
                                    <th><?php echo e(__('label._unit')); ?></th>
                                    <th><?php echo e(__('label._qty')); ?></th>
                                    <th><?php echo e(__('label._cost_rate')); ?></th>
                                    <th><?php echo e(__('label._issue_rate')); ?></th>
                                    <th><?php echo e(__('label._value')); ?></th>
                                  </tr>
                                </thead>
                                <tbody>

                                  <?php
                                   $invoice_total_qty=0;
                                   $invoice_total_amount=0;
                                  ?>
                                  <?php $__empty_1 = true; $__currentLoopData = $_master_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m_key=>$m_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <?php
                                   $invoice_total_qty +=$m_detail->_qty ?? 0;
                                   $invoice_total_amount +=$m_detail->_value ?? 0;
                                  ?>
                                  <tr>
                                    <td><?php echo ($m_key+1); ?></td>
                                    <td><?php echo $m_detail->_items->_name ?? ''; ?></td>
                                    <td><?php echo $m_detail->_items->_units->_name ?? ''; ?></td>
                                    <td><?php echo _report_amount($m_detail->_qty ?? 0); ?></td>
                                    <td><?php echo _report_amount($m_detail->_rate ?? 0); ?></td>
                                    <td><?php echo _report_amount($m_detail->_sales_rate ?? 0); ?></td>
                                    <td><?php echo _report_amount($m_detail->_value ?? 0); ?></td>
                                  </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th colspan="3">Total</th>
                                    <th><?php echo _report_amount($invoice_total_qty); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo _report_amount($invoice_total_amount); ?></th>
                                  </tr>
                                </tfoot>
                              </table>

                              <?php endif; ?>
                            </div>
                            
                          </td>
                         </tr>
                          
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                        
                          <td colspan="8" class="text-center"><b>Total</b></td>
                          <td><b><?php echo e(_report_amount($sum_of_sub_total)); ?> </b></td>
                          <td><b><?php echo e(_report_amount($sum_of_amount)); ?> </b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                          </td>
                        </tr>
                        
                       
                        </tbody>

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


  $(document).on("click","._single_data_click",function(){
      var has_class = $(this).hasClass("already_show")
      if(has_class){ return false; }
      var invoice_id = $(this).attr("attr_invoice_id");
      var _attr_key = $(this).attr("_attr_key");
      $(this).addClass("already_show");
      $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
               type:'POST',
               url:"<?php echo e(url('invoice-wise-detail')); ?>",
               data:{invoice_id,_attr_key},
               success:function(data){
                $(document).find("._single_data_display__"+invoice_id).html(data);
               }

            });
    })


  

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
                                        </td><td>${data[i]._name} | ${data[i]._phone}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}"></td></tr>`;
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
  

 $(document).on('keyup','._search_main_delivery_man_id',delay(function(e){
    $(document).find('._search_main_delivery_man_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    

  var request = $.ajax({
      url: "<?php echo e(url('main-ledger-search')); ?>",
      method: "GET",
      data: { _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_delivery_man_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_delivery_man_ledger" class="_id_delivery_man_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_delivery_man_ledger" class="_name_delivery_man_ledger" value="${data[i]._name}"></td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_delivery_man').html(search_html);
      _gloabal_this.parent('div').find('.search_box_delivery_man').addClass('search_box_show').show();
      
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


  $(document).on("click",'.search_row_delivery_man_ledger',function(){
    var _id = $(this).children('td').find('._id_delivery_man_ledger').val();
    var _name = $(this).find('._name_delivery_man_ledger').val();
    $("._delivery_man_id").val(_id);
    $("._search_main_delivery_man_id").val(_name);
    $('.search_box_delivery_man').hide();
    $('.search_box_delivery_man').removeClass('search_box_show').hide();
  })

  

 $(document).on('keyup','._search_main_sales_man_id',delay(function(e){
    $(document).find('._search_main_sales_man_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    

  var request = $.ajax({
      url: "<?php echo e(url('main-ledger-search')); ?>",
      method: "GET",
      data: { _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_sales_man_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_sales_man_ledger" class="_id_sales_man_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_delivery_man_ledger" class="_name_sales_man_ledger" value="${data[i]._name}"></td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_sales_man').html(search_html);
      _gloabal_this.parent('div').find('.search_box_sales_man').addClass('search_box_show').show();
      
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


  $(document).on("click",'.search_row_sales_man_ledger',function(){
    var _id = $(this).children('td').find('._id_delivery_man_ledger').val();
    var _name = $(this).find('._name_sales_man_ledger').val();
    $("._sales_man_id").val(_id);
    $("._search_main_sales_man_id").val(_name);
    $('.search_box_sales_man').hide();
    $('.search_box_sales_man').removeClass('search_box_show').hide();
  })
 
  $(document).on("click",'.search_modal',function(){
    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })



  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="material_issues";
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/material-issue/index.blade.php ENDPATH**/ ?>