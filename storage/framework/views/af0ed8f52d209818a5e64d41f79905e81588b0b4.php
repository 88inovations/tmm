
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="<?php echo e(url('report-panel')); ?>">Report</a> / 
            <a class="_page_name" href="#"><?php echo e($page_name ?? ''); ?></a>
          
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


  <div class="content ">
      <div class="container">
          <div class="card">
            <div class="card-body filter_body" >
               <form  action="" method="GET">
                <?php echo csrf_field(); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <label><?php echo e(__('label._category_id')); ?>:</label>
                        <select id="_category_id" class="form-control _category_id " name="_category_id" >
                          <option value="">ALL</option>
                          <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <option value="<?php echo e($val->id); ?>" <?php if(isset($request->_category_id) && $request->_category_id==$val->id): ?> selected <?php endif; ?> ><?php echo e($val->_name ?? ''); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <?php endif; ?>
                         </select>
                      </div>

                    </div>
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         
                        <br><br>
                     </div>
                    <?php echo Form::close(); ?>

                
              </div>
        <!-- /.row -->
      </div>
    </div>  
<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
  <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b><?php echo e($settings->name ?? ''); ?></b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><?php echo e($settings->_address ?? ''); ?></td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><?php echo e($settings->_phone ?? ''); ?>,<?php echo e($settings->_email ?? ''); ?></td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b><?php echo e($page_name); ?> </b></td> </tr>
                 
               
              </table>
            </td>
            
          </tr>
        </table>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>SL</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Unit</th>
            <th>W.H Price</th>
            <th>Trade Price</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
         
          <?php $__empty_1 = true; $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <th colspan="7"><?php echo e($key ?? ''); ?></th>
          </tr>
           <?php
          $serial =1;
          ?>

          <?php $__empty_2 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
          <tr class="">
            <td><?php echo e(($serial)); ?></td>
            <td><?php echo $val->_code ?? ''; ?></td>
            <td><?php echo $val->_item ?? ''; ?></td>
            <td><?php echo $val->unit_name ?? ''; ?></td>
            <td><?php echo $val->_sale_rate ?? ''; ?></td>
            <td><?php echo $val->_trade_price ?? ''; ?></td>
            <td></td>
          </tr>
          <?php
          $serial++;
          ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
          <?php endif; ?>
          
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
</div>



<?php $__env->stopSection(); ?>




<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/inventory-report/category_wise_item_list.blade.php ENDPATH**/ ?>