
<?php $__env->startSection('title',$settings->name ?? ''); ?>
<?php $__env->startSection('content'); ?>
<?php
$users = Auth::user();
?>
<!-- Content Header (Page header) -->


    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a class="_page_name" href="<?php echo e(url('home')); ?>">Dashboard</a></li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <style type="text/css">
      .card-title {
        float: none;
    text-align: center !important;

    font-size: 1.1rem;
    font-weight: 400;
    margin: 0;
    padding: 5px;
}
.card-body{
  background: #fff;
  padding:10px;
}
    </style>

       <?php
//echo $ipAddr=\Request::ip();
 //$macAddr = exec('getmac');
 //$MAC = strtok($macAddr, ' '); 

$_ac_type    = $auth_user->_ac_type ?? 0; // 1 = Sales Officer
$user_type   = $auth_user->user_type ?? '';
$_sales_man_id   = $auth_user->ref_id ?? 0;

$currentTime = \Carbon\Carbon::now()->format('H:i');

  $entry_type = 'Time Assign';
// Determine Entry Type Based on Time
  if ($currentTime >= '06:00' && $currentTime <= '12:00') {
      $entry_type = 'Start';
  } elseif ($currentTime >= '12:01' && $currentTime <= '16:00') {
      $entry_type = 'Launch';
  } else {
      $entry_type = 'Close';
  }



          ?>


    <!-- /.content-header -->
<div class="content" >
      <div class="container-fluid">


        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_dashboard')): ?>
        <?php echo $__env->make('stm.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php endif; ?>







        <div class="row">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_duty-create')): ?>
<div class="col-md-2 col-sm-6 col-6">
      <div class="card text-center ">
            <div class="card-header "><h6>Attandance Confirmation</h6></div>
            <div class="card-footer text_blue text-bold">
              <button type="button" class="btn btn-info" attr_url="<?php echo e(url('start-duty')); ?>" id="startDutyBtn">Duty <?php echo $entry_type ?? ''; ?></button>
            </div>
        </div>
    </div>
    <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_duty-list')): ?>
<div class="col-md-2 col-sm-6 col-6">
      <div class="card text-center ">
             <a href="<?php echo e(url('employee_duty')); ?>" class="dropdown-item">
                <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.employee_duty')); ?>

              </a>
        </div>
    </div>
            <?php endif; ?>

           
       


         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily_dashboard')): ?>
<div class="col-md-12">
              <?php echo $__env->make('backend.dashboard.daily_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
<?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quick-link')): ?>
          <div class="col-md-6">
            <div class="card ">
              <div class="card-header border-0">
                <h3 class="card-title">Quick Link</h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body table-responsive p-0 info-box">
                  <table class="table table-striped table-valign-middle">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('avaiable_product_list')): ?>
                    <tr>
                      <th>
                          <div style="display: flex;">
                           <a href="<?php echo e(url('product_show')); ?>" class="dropdown-item">
                              <i class="fa fa-fax mr-2" aria-hidden="true"></i><?php echo e(__('label.avaiable_product_list')); ?>

                            </a>
                             
                          </div>
                      </th>
                  </tr>
                   <?php endif; ?> 
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-order-list')): ?>
                    <tr>
                      <th>
                          <div style="display: flex;">
                           <a href="<?php echo e(url('sales-order')); ?>" class="dropdown-item">
                              <i class="fa fa-fax mr-2" aria-hidden="true"></i>Order Collection
                            </a>
                             <a  href="<?php echo e(route('sales-order.create')); ?>" class="dropdown-item text-right">
                              <i class="nav-icon fas fa-plus"></i>
                            </a>
                          </div>
                      </th>
                  </tr>
                   <?php endif; ?> 

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-list')): ?>
                    <tr>
                      <th>
                         
                          <div style="display: flex;">
                           <a href="<?php echo e(url('voucher')); ?>" class="dropdown-item">
                              <i class="fa fa-fax mr-2" aria-hidden="true"></i> Voucher
                            </a>
                             <a  href="<?php echo e(route('voucher.create')); ?>" class="dropdown-item text-right">
                              <i class="nav-icon fas fa-plus"></i>
                            </a>
                          </div>
                          
                      </th>
                  </tr>
                   <?php endif; ?> 
                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-list')): ?>
                    <tr>
                      <th>
                        
                           <div style="display: flex;">
                           <a href="<?php echo e(url('purchase')); ?>" class="dropdown-item">
                            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_receive')); ?>

                          </a>

                             <a  href="<?php echo e(route('purchase.create')); ?>" class="dropdown-item text-right " > 
            <i class="nav-icon fas fa-plus"></i> </a>
                        </div>
                         
                      </th>
                  </tr>
                  <?php endif; ?>
                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-list')): ?>
                    <tr>
                      <th>
                        
                            <div style="display: flex;">
                               <a href="<?php echo e(url('purchase-return')); ?>" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>  <?php echo e(__('label.material_return')); ?>

                              </a>
                              <a  href="<?php echo e(route('purchase-return.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>
                               
                            </div>
                            
                      </th>
                  </tr>
                   <?php endif; ?>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-list')): ?>
                    <tr>
                      <th>
                         
                        <div style="display: flex;">
                           <a href="<?php echo e(url('sales')); ?>" class="dropdown-item">
                            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_issue')); ?>

                          </a>
                           <a  href="<?php echo e(route('sales.create')); ?>" class="dropdown-item text-right">
                            <i class="nav-icon fas fa-plus"></i>
                          </a>
                        </div>
                        
                      </th>
                  </tr>
                   <?php endif; ?> 
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-sales-list')): ?>
                    <tr>
                      <th>
                         
                        <div style="display: flex;">
                           <a href="<?php echo e(url('restaurant-sales')); ?>" class="dropdown-item">
                            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> Restaurant Sales
                          </a>
                           <a  href="<?php echo e(route('restaurant-sales.create')); ?>" class="dropdown-item text-right">
                            <i class="nav-icon fas fa-plus"></i>
                          </a>
                        </div>
                        
                      </th>
                  </tr>
                   <?php endif; ?> 
                    <tr>
                      <th>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-list')): ?>
          
                        <div style="display: flex;">
                           <a href="<?php echo e(url('sales-return')); ?>" class="dropdown-item">
                            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.issued_material_return')); ?>

                          </a>
                           <a  href="<?php echo e(route('sales-return.create')); ?>" class="dropdown-item text-right">
                            <i class="nav-icon fas fa-plus"></i>
                          </a>
                        </div>
                          
                         <?php endif; ?>  
                      </th>
                  </tr>
                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_list')): ?>
                    <tr>
                      <th>
                       
                        <div style="display: flex;">
              <i class="fa fa-users mr-2" class="dropdown-item" aria-hidden="true"></i> <a href="<?php echo e(route('customer_create')); ?>" >Add Customer</a>
                        </div>
                      </th>
                  </tr>
                     <?php endif; ?>  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('day-wise-summary-report')): ?> 
                    <tr>
                      <th>
                        <div style="display: flex;">
                           <a href="<?php echo e(url('day-wise-summary-report')); ?>" class="dropdown-item">
                            <i class="fa fa-file mr-2" aria-hidden="true"></i> Work Period Sales Summary Report
                          </a>
                        </div>
                      </th>
                  </tr>
                <?php endif; ?>  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-sales-report')): ?> 
                    <tr>
                      <th>
                        <div style="display: flex;">
                           <a href="<?php echo e(url('item-sales-report')); ?>" class="dropdown-item">
                            <i class="fa fa-file mr-2" aria-hidden="true"></i>Item Sales Report
                          </a>
                        </div>
                      </th>
                  </tr>
                <?php endif; ?> 
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('detail-item-sales-report')): ?> 
                    <tr>
                      <th>
                        <div style="display: flex;">
                           <a href="<?php echo e(url('detail-item-sales-report')); ?>" class="dropdown-item">
                            <i class="fa fa-file mr-2" aria-hidden="true"></i>Detail Item Sales Report 
                          </a>
                        </div>
                      </th>
                  </tr>
                <?php endif; ?>  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income-statement')): ?> 
                    <tr>
                      <th>
                        <div style="display: flex;">
                           <a href="<?php echo e(url('income-statement')); ?>" class="dropdown-item">
                            <i class="fa fa-file mr-2" aria-hidden="true"></i><?php echo e(__('label.Income Statement')); ?> 
                          </a>
                        </div>
                      </th>
                  </tr>
                <?php endif; ?>  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('so_wise_due_invoice')): ?> 
                    <tr>
                      <th>
                        <div style="display: flex;">
                           <a href="<?php echo e(url('so_wise_due_invoice')); ?>" class="dropdown-item">
                            <i class="fa fa-file mr-2" aria-hidden="true"></i><?php echo e(__('label.so_wise_due_invoice')); ?> 
                          </a>
                        </div>
                      </th>
                  </tr>
                <?php endif; ?>  
                  </table>
              </div>
            </div>
          </div>
          <?php endif; ?>


          <div class="col-md-6">

            <div class="row">
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('total-purchase')): ?>
<?php        
$_purchase = \DB::select( " SELECT  t1._account_ledger,SUM(t1.`_dr_amount`) AS _balance  FROM `accounts` AS t1 
INNER JOIN purchase_form_settings AS t2 ON t1.`_account_ledger`=t2._default_purchase
WHERE t1._status=1 AND t1.`_branch_id` IN(".$users->branch_ids.") AND t1.`_cost_center` IN(".$users->cost_center_ids.")  " );
?>
               <div class="col-md-6 col-sm-6 col-xs-12 col-custom">
                 <div class="info-box info-box-new-style">
                      <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-basket  text-white" aria-hidden="true"></i>
</span>
                        <?php $__empty_1 = true; $__currentLoopData = $_purchase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <div class="info-box-content">
                        <span class="info-box-text"><h4>Total  <?php echo e(_ledger_name($val->_account_ledger) ?? 'Purchase'); ?></h4></span>
                        <span class="info-box-number total_purchase"><h3> <?php echo e(prefix_taka()); ?>. <?php echo e(_report_amount($val->_balance ?? 0)); ?></h3></span>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                      <?php endif; ?>
                      <!-- /.info-box-content -->
                 </div>
                 <!-- /.info-box -->
              </div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('total-sales')): ?>
<?php        
$data = \DB::select( " SELECT  t1._account_ledger,SUM(t1.`_cr_amount`-t1._dr_amount) AS _balance  FROM `accounts` AS t1 
INNER JOIN sales_form_settings AS t2 ON t1.`_account_ledger`=t2._default_sales
WHERE t1._status=1 AND t1.`_branch_id` IN(".$users->branch_ids.") AND t1.`_cost_center` IN(".$users->cost_center_ids.")  " );
?>
               <div class="col-md-6 col-sm-6 col-xs-12 col-custom">
                 <div class="info-box info-box-new-style">
                      <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart text-white" aria-hidden="true"></i></span>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <div class="info-box-content">
                        <span class="info-box-text"><h4>Total  <?php echo e(_ledger_name($val->_account_ledger)); ?></h4></span>
                        <span class="info-box-number total_purchase"><h3> <?php echo e(prefix_taka()); ?>. <?php echo e(_report_amount($val->_balance ?? 0)); ?></h3></span>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                      <?php endif; ?>
                      <!-- /.info-box-content -->
                 </div>
                 <!-- /.info-box -->
              </div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('total-purchase-return')): ?>
<?php        
$data = \DB::select( " SELECT  t1._account_ledger,SUM(t1.`_cr_amount`) AS _balance  FROM `accounts` AS t1 
INNER JOIN purchase_return_form_settings AS t2 ON t1.`_account_ledger`=t2._default_purchase
WHERE t1._status=1 AND t1.`_branch_id` IN(".$users->branch_ids.") AND t1.`_cost_center` IN(".$users->cost_center_ids.")  " );
?>
               <div class="col-md-6 col-sm-6 col-xs-12 col-custom">
                 <div class="info-box info-box-new-style">
                      <span class="info-box-icon bg-red"><i class="fa fa-shopping-basket  text-white" aria-hidden="true"></i></span>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <div class="info-box-content">
                        <span class="info-box-text"><h4>Total  <?php echo e(_ledger_name($val->_account_ledger)); ?></h4></span>
                        <span class="info-box-number total_purchase"><h3> <?php echo e(prefix_taka()); ?>. <?php echo e(_report_amount($val->_balance ?? 0)); ?></h3></span>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                      <?php endif; ?>
                      <!-- /.info-box-content -->
                 </div>
                 <!-- /.info-box -->
              </div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('total-sales-return')): ?>
<?php        
$data = \DB::select( " SELECT  t1._account_ledger,-SUM(t1.`_cr_amount`-t1._dr_amount) AS _balance  FROM `accounts` AS t1 
INNER JOIN sales_return_form_settings AS t2 ON t1.`_account_ledger`=t2._default_sales
WHERE t1._status=1 AND t1.`_branch_id` IN(".$users->branch_ids.") AND t1.`_cost_center` IN(".$users->cost_center_ids.")  " );
?>
               <div class="col-md-6 col-sm-6 col-xs-12 col-custom ">
                 <div class="info-box info-box-new-style">
                      <span class="info-box-icon bg-red"><i class="fa fa-shopping-cart   text-white" aria-hidden="true"></i></span>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <div class="info-box-content">
                        <span class="info-box-text"><h4>Total  <?php echo e(_ledger_name($val->_account_ledger)); ?></h4></span>
                        <span class="info-box-number total_purchase"><h3> <?php echo e(prefix_taka()); ?>. <?php echo e(_report_amount($val->_balance ?? 0)); ?></h3></span>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                      <?php endif; ?>
                      <!-- /.info-box-content -->
                 </div>
                 <!-- /.info-box -->
              </div>
<?php endif; ?>




            </div>
          </div>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-chart')): ?>
<!-- Sales Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 Days Sales Report</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="dailySalesReport" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
<?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-chart')): ?>
  <div class="col-md-6 mt-2">
    <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 12 Month Sales  Report</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthWiseSalesBarChart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div><!-- Sales realted Chart End -->
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-restaurant-sales-chart')): ?>
<!-- Sales Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 Days Resturant Sales Report</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="dailyResturantSalesReport" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
<?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-restaurant-sales-chart')): ?>
  <div class="col-md-6 mt-2">
    <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 12 Month Resturant Sales  Report</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthWiseResturantSalesBarChart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div><!-- Sales realted Chart End -->
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-chart')): ?>
  <!-- Purchase Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 Days Purchase Report</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="dailyPurchaseReport" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
  <?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-chart')): ?>
  <div class="col-md-6 mt-2">
    <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 12 Month Purchase  Report</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthWisePurchaseBarChart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div><!-- Purchase realted Chart End -->
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-return-chart')): ?>
  <!-- SalesReturn Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 Days Sales Return Report</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="dailySalesReturnReport" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
  <?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-return-chart')): ?>
  <div class="col-md-6 mt-2">
    <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 12 Month Sales Return  Report</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthWiseSalesReturnBarChart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div><!-- Purchase realted Chart End -->
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-return-chart')): ?>
  <!-- PurchaseReturn Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 Days Purchase Return Report</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="dailyPurchaseReturnReport" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
  <?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-return-chart')): ?>
  <div class="col-md-6 mt-2">
    <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 12 Month Purchase Return  Report</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthWisePurchaseReturnBarChart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div><!-- Purchase realted Chart End -->
  <?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-damage-chart')): ?>
  <!-- Damage Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 Days Damage Report</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="dailyDamageReport" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
  <?php endif; ?>
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-damage-chart')): ?>
  <div class="col-md-6 mt-2">
    <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 12 Month Damage  Report</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthWiseDamageBarChart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div><!-- Damage realted Chart End -->
  <?php endif; ?>
  
  
  
<?php
$account_group_configs = DB::table("account_group_configs")->first();
 $_customer_group       = $account_group_configs->_customer_group ?? '';
 $_supplier_group       = $account_group_configs->_supplier_group ?? '';

$_customer_group_array = explode(",",$_customer_group);
$_supplier_group_array = explode(",",$_supplier_group);

$_customer_group_ids = implode(",",$_customer_group_array);
$_supplier_group_ids = implode(",",$_supplier_group_array);

?>
  


          <!-- /.col-md-6 -->
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('top-due-customer')): ?>

           <style>
             
             /* Initially setting modal size */
.modal-dialog {
    max-width: 80%; /* Optional: To make it large but not 100% */
    margin: 30px auto;
}

/* Fullscreen modal styling */
.modal-fullscreen .modal-dialog {
    max-width: 100%;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.modal-fullscreen .modal-content {
    height: 100%;
    overflow-y: auto;
}
           </style>
          <div class="col-md-12 mt-2">
            <div class="card " >
              <div class="card-header border-0">
                <h3 class="card-title">Top Due Customer</h3>
                <div class="card-tools"></div>
              </div>
              <div class="card-body table-responsive p-0 info-box" >
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>SL</th>
                    <th>Code</th>
                    <th>Ledger</th>
                    <th>Phone</th>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('so_wise_due_invoice')): ?>
                    <th>Action</th>
                    <?php endif; ?>
                    <th class="text-right">Amount</th>
                  </tr>
                  </thead>
                  <?php
        

$limit=20;
if($users->user_type !='admin'){
  $limit = 200;
}
           
            
        $accounts = \DB::select( " SELECT  t2.id as _account_ledger, t2._code,t2._phone,t2._name,SUM(t1.`_dr_amount`-t1.`_cr_amount`) AS _balance  
FROM `accounts` AS t1 
INNER JOIN account_ledgers AS t2 ON t1._account_ledger=t2.id
WHERE t1._status=1 AND t1.`_branch_id` IN(".$users->branch_ids.") 
AND t1.`_cost_center` IN(".$users->cost_center_ids.") AND t2._account_group_id IN (".$_customer_group_ids.")
GROUP BY t1._account_ledger 
HAVING SUM(t1.`_dr_amount`-t1.`_cr_amount`) != 0
ORDER BY ABS(SUM(t1.`_dr_amount`-t1.`_cr_amount`)) DESC LIMIT $limit
" );


                  ?>
                  <tbody >
                    <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a_key=> $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                    <td class="white_space"><?php echo ($a_key+1); ?></td>
                    <td class="white_space"><a href="<?php echo e(url('full_ledger_detail')); ?>?_ledger_id=<?php echo e($val->_account_ledger); ?>"><?php echo $val->_code ?? ''; ?></a></td>
                    <td><?php echo $val->_name ?? ''; ?></td>
                    <td><?php echo $val->_phone ?? ''; ?></td>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('so_wise_due_invoice')): ?>
                    <td style="border:1px solid silver;" class="text-left" >
                            <button type="button" 
                         class="btn btn-sm btn-success customer_wise_due_invoice customer_wise_due_invoice__<?php echo e($val->_account_ledger); ?> mr-3 ml-3" 
                         attr_id="<?php echo e($val->_account_ledger); ?>"
                         
                         attr_url="<?php echo e(url('customer_wise_due_collection')); ?>"
                         data-toggle="modal" 
                         data-target="#exampleModalSecond" title="Invoice Wise Due Collection">Details </button>
                       </td>
                       <?php endif; ?>
                    <td class="text-right white_space"> <?php echo _show_amount_dr_cr(_report_amount($val->_balance ?? 0)); ?></td>
                    
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <?php endif; ?>
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('top-payable-supplier')): ?>
          <div class="col-md-12 mt-2">
            <div class="card ">
              <div class="card-header border-0">
                <h3 class="card-title">Top Payable Supplier</h3>
                <div class="card-tools"></div>
              </div>
              <div class="card-body table-responsive p-0 info-box">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Ledger</th>
                    <th class="text-right">Amount</th>
                  </tr>
                  </thead>
                  <?php

                  
        
        $accounts = \DB::select( " SELECT t2.id as _account_ledger, t2._name,SUM(t1.`_dr_amount`-t1.`_cr_amount`) AS _balance  
FROM `accounts` AS t1 
INNER JOIN account_ledgers AS t2 ON t1._account_ledger=t2.id
WHERE t1._status=1 AND t1.`_branch_id` IN(".$users->branch_ids.") 
AND t1.`_cost_center` IN(".$users->cost_center_ids.") AND  t2._account_group_id IN (".$_supplier_group_ids.")
GROUP BY t1._account_ledger 
HAVING SUM(t1.`_dr_amount`-t1.`_cr_amount`) != 0
ORDER BY ABS(SUM(t1.`_dr_amount`-t1.`_cr_amount`))
 DESC LIMIT 10 " );


                  ?>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                    <td>
                     <a href="<?php echo e(url('full_ledger_detail')); ?>?_ledger_id=<?php echo e($val->_account_ledger); ?>"><?php echo $val->_name ?? ''; ?></a>
                    </td>
                    <td class="text-right"> <?php echo _show_amount_dr_cr(_report_amount($val->_balance ?? 0)); ?></td>
                    
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <?php endif; ?>
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>


<?php
  $filtered_month =[];
  $filtered_purchase = [];
  $filtered_purchase_return = [];
  $filtered_sales = [];
  $filtered_sales_return = [];
  $filtered_damage = [];

  
  $qur = " select DATE_FORMAT(_date, '%m-%Y') as _month from accounts GROUP BY YEAR(_date),MONTH(_date)  ";
  $months = \DB::select($qur);
  ?>

 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-chart')): ?>
<?php

  $sales = " Select round(sum(t1._cr_amount)) as _amount,DATE_FORMAT(t1._date, '%m-%y') as _month 
from accounts as t1
INNER JOIN sales_form_settings AS t2 ON t1._account_ledger=t2._default_sales
where (t1._transaction collate utf8mb4_unicode_ci = 'Sales') AND (t1._date > now() - INTERVAL 12 month ) AND t1._status=1 ";
      if($user_type !='admin' && $_ac_type ==1){
          $sales .= " AND t1._sales_man_id=$_sales_man_id ";
      }
  $sales .="  AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date)  ";
  $sales_amounts = \DB::select($sales);
$_sales_months=array();
$_sales_month_amounts = array();
foreach ($sales_amounts as $value) {
    array_push($_sales_months, $value->_month);
    array_push($_sales_month_amounts, floatval($value->_amount));
  }
  ?>
  <?php endif; ?>

 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-restaurant-sales-chart')): ?>
<?php

  $sales_restaurant = " select round(sum(t1._cr_amount)) as _amount,DATE_FORMAT(t1._date, '%m-%y') as _month 
from accounts as t1
INNER JOIN resturant_form_settings AS t2 ON t1._account_ledger=t2._default_sales
where (t1._transaction collate utf8mb4_unicode_ci = 'Restaurant Sales') AND (t1._date > now() - INTERVAL 12 month ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date)  ";
  $sales_amounts_restaurant = \DB::select($sales_restaurant);
$_sales_months_restaurant=array();
$_sales_month_amounts_restaurant = array();
foreach ($sales_amounts_restaurant as $value) {
    array_push($_sales_months_restaurant, $value->_month);
    array_push($_sales_month_amounts_restaurant, floatval($value->_amount));
  }
  ?>
  <?php endif; ?>


    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-chart')): ?>
  <?php

//Last 30 days sales line chart
  $_daily_sales = " select round(sum(t1._cr_amount)) as _amount,DATE_FORMAT(t1._date, '%d-%m') as _month 
from accounts as t1
INNER JOIN sales_form_settings AS t2 ON t1._account_ledger=t2._default_sales
where (t1._transaction collate utf8mb4_unicode_ci = 'Sales') AND (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1 ";
      if($user_type !='admin' && $_ac_type ==1){
          $_daily_sales .= " AND t1._sales_man_id=$_sales_man_id ";
      }
  $_daily_sales .=" AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ASC ";
  $daily_sales_report = \DB::select($_daily_sales);

  //Last 30 days sales line chart
  $sales_days=array();
  $last_30_days_sales = array();
  foreach ($daily_sales_report as $value) {
    array_push($sales_days, $value->_month);
    array_push($last_30_days_sales, floatval($value->_amount));
  }

?>
<?php endif; ?>




<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-restaurant-sales-chart')): ?>
  <?php

//Last 30 days sales line chart
  $_daily_sales_restaurant = " select round(sum(t1._cr_amount)) as _amount,DATE_FORMAT(t1._date, '%d-%m') as _month 
from accounts as t1
INNER JOIN sales_form_settings AS t2 ON t1._account_ledger=t2._default_sales
where (t1._transaction collate utf8mb4_unicode_ci = 'Restaurant Sales') AND (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ASC ";
  $daily_sales_report_restaurant = \DB::select($_daily_sales_restaurant);

  //Last 30 days sales line chart
  $sales_days_restaurant=array();
  $last_30_days_sales_restaurant = array();
  foreach ($daily_sales_report_restaurant as $value) {
    array_push($sales_days_restaurant, $value->_month);
    array_push($last_30_days_sales_restaurant, floatval($value->_amount));
  }

?>
<?php endif; ?>



<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-return-chart')): ?>

<?php

  $sales_return = " select round(sum(t1._dr_amount)) as _amount,DATE_FORMAT(t1._date, '%m-%y') as _month 
from accounts as t1
INNER JOIN sales_return_form_settings AS t2 ON t1._account_ledger=t2._default_sales
where (t1._transaction collate utf8mb4_unicode_ci = 'Sales Return') AND (t1._date > now() - INTERVAL 12 month ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date) ASC ";
   $sales_return_amounts = \DB::select($sales_return);

$_sales_retun_months=array();
$_sales_return_month_amounts = array();
foreach ($sales_return_amounts as $value) {
    array_push($_sales_retun_months, $value->_month);
    array_push($_sales_return_month_amounts, floatval($value->_amount));
  }

?>
<?php endif; ?>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-return-chart')): ?>
<?php
  //Last 30 days sales_return line chart
  $_daily_sales_return = "  select round(sum(t1._dr_amount)) as _amount,DATE_FORMAT(t1._date, '%d-%m-%y') as _month 
from accounts as t1
INNER JOIN sales_return_form_settings AS t2 ON t1._account_ledger=t2._default_sales
where (t1._transaction collate utf8mb4_unicode_ci = 'Sales Return') AND (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date),DATE(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DATE(t1._date) ASC ";
  $_daily_sales_return_report = \DB::select($_daily_sales_return);

    //Last 30 days sales_return line chart
  $sales_return_days=array();
  $last_30_days_sales_return = array();
  foreach ($_daily_sales_return_report as $value) {
    array_push($sales_return_days, $value->_month);
    array_push($last_30_days_sales_return, floatval($value->_amount));
  }

?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-chart')): ?>

<?php
    $purchases = " select round(sum(t1._dr_amount)) as _amount,DATE_FORMAT(t1._date, '%m-%y') as _month 
from accounts as t1
INNER JOIN purchase_form_settings AS t2 ON t1._account_ledger=t2._default_purchase
where (t1._transaction collate utf8mb4_unicode_ci = 'Purchase') AND (t1._date > now() - INTERVAL 12 month ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date) ASC ";
  $purchases_amount  = \DB::select($purchases);

$_purchase_months=array();
$_purchase_month_amounts = array();
foreach ($purchases_amount  as $value) {
    array_push($_purchase_months, $value->_month);
    array_push($_purchase_month_amounts, floatval($value->_amount));
  }
?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-chart')): ?>
<?php

//Last 30 days Purchase line chart
  $_daily_purchase = " select round(sum(t1._dr_amount)) as _amount,DATE_FORMAT(t1._date, '%d-%m') as _month 
from accounts as t1
INNER JOIN purchase_form_settings AS t2 ON t1._account_ledger=t2._default_purchase
where (t1._transaction collate utf8mb4_unicode_ci = 'Purchase') AND (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date),DATE(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DATE(t1._date) ASC ";
  $_daily_purchase_report = \DB::select($_daily_purchase);

    //Last 30 days Purchase line chart
  $purchase_days=array();
  $last_30_days_purchase = array();
  foreach ($_daily_purchase_report as $value) {
    array_push($purchase_days, $value->_month);
    array_push($last_30_days_purchase, floatval($value->_amount));
  }

?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-return-chart')): ?>

<?php
  
  $purchase_return = " select round(sum(t1._cr_amount)) as _amount,DATE_FORMAT(t1._date, '%m-%y') as _month 
from accounts as t1
INNER JOIN purchase_return_form_settings AS t2 ON t1._account_ledger=t2._default_purchase
where (t1._transaction collate utf8mb4_unicode_ci = 'Purchase Return') AND (t1._date > now() - INTERVAL 12 month ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date) ASC";
  $purchase_return_amounts = \DB::select($purchase_return);

$_purchase_return_months=array();
$_purchase_return_month_amounts = array();
foreach ($purchase_return_amounts  as $value) {
    array_push($_purchase_return_months, $value->_month);
    array_push($_purchase_return_month_amounts, floatval($value->_amount));
  }

?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-return-chart')): ?>
<?php
//Last 30 days purchase_return line chart
  $_daily_purchase_return = " SELECT round(sum(t1._cr_amount)) as _amount,DATE_FORMAT(t1._date, '%d-%m') as _month 
from accounts as t1
INNER JOIN purchase_return_form_settings AS t2 ON t1._account_ledger=t2._default_purchase
where (t1._transaction collate utf8mb4_unicode_ci = 'Purchase Return') AND (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1 AND t1._branch_id IN(".$users->branch_ids.")  
AND `_cost_center` IN(".$users->cost_center_ids.")  GROUP BY YEAR(t1._date),MONTH(t1._date),DATE(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ASC ";
  $_daily_purchase_return_report = \DB::select($_daily_purchase_return);

    //Last 30 days purchase_return line chart
  $purchase_return_days=array();
  $last_30_days_purchase_return = array();
  foreach ($_daily_purchase_return_report as $value) {
    array_push($purchase_return_days, $value->_month);
    array_push($last_30_days_purchase_return, floatval($value->_amount));
  }
?>
 <?php endif; ?>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-damage-chart')): ?>
 <?php

  $_damage = " SELECT round(sum(_dr_amount)) as _amount,DATE_FORMAT(_date, '%m-%Y') as _month from accounts where (_transaction collate utf8mb4_unicode_ci = 'Damage') AND (_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND _status=1 AND `_branch_id` IN(".$users->branch_ids.") 
AND `_cost_center` IN(".$users->cost_center_ids.") GROUP BY YEAR(_date),MONTH(_date) ORDER BY YEAR(_date),MONTH(_date) ASC ";
  $_damage_amounts = \DB::select($_damage);

  $damage_months=array();
$damage_month_amounts = array();
foreach ($_damage_amounts  as $value) {
    array_push($damage_months, $value->_month);
    array_push($damage_month_amounts, floatval($value->_amount));
  }
?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-damage-chart')): ?>
<?php
//Last 30 days damage line chart
  $_daily_damage = " select round(sum(_dr_amount)) as _amount,DATE_FORMAT(_date, '%d-%m') as _month from accounts where (_transaction collate utf8mb4_unicode_ci = 'Damage') AND (_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND _status=1 AND `_branch_id` IN(".$users->branch_ids.") 
AND `_cost_center` IN(".$users->cost_center_ids.") GROUP BY YEAR(_date),MONTH(_date),DATE(_date) ORDER BY  YEAR(_date),MONTH(_date),DATE(_date) ASC ";
  $_daily_damage_report = \DB::select($_daily_damage);

    //Last 30 days damage line chart
  $damage_days=array();
  $last_30_days_damage = array();
  foreach ($_daily_damage_report as $value) {
    array_push($damage_days, $value->_month);
    array_push($last_30_days_damage, floatval($value->_amount));
  }
?>
 <?php endif; ?>

  
  
 



</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('plugins/chart.js/Chart.min.js')); ?>"></script>
<script type="text/javascript">




/* Damage  Information Start */
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-damage-chart')): ?>
  var damage_months =  <?php echo json_encode($damage_months) ?>;
  var damage_month_amounts=  <?php echo json_encode($damage_month_amounts) ?>;
  <?php endif; ?>

  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-damage-chart')): ?>
  var damage_days =  <?php echo json_encode($damage_days) ?>;
  var last_30_days_damage =  <?php echo json_encode($last_30_days_damage) ?>;
  <?php endif; ?>

/* Damage  Information End  */



/* Purchase  Information Start */
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-chart')): ?>

  var _purchase_months =  <?php echo json_encode($_purchase_months) ?>;
  var _purchase_month_amounts=  <?php echo json_encode($_purchase_month_amounts) ?>;
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-chart')): ?>
  var purchase_days =  <?php echo json_encode($purchase_days) ?>;
  var last_30_days_purchase =  <?php echo json_encode($last_30_days_purchase) ?>;
<?php endif; ?>  

/* Purchase  Information End  */





/* Purchase Return  Information Start */
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-return-chart')): ?>
  var _purchase_return_months =  <?php echo json_encode($_purchase_return_months) ?>;
  var _purchase_return_month_amounts=  <?php echo json_encode($_purchase_return_month_amounts) ?>;
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-return-chart')): ?>
  var purchase_return_days =  <?php echo json_encode($purchase_return_days) ?>;
  var last_30_days_purchase_return =  <?php echo json_encode($last_30_days_purchase_return) ?>;
 <?php endif; ?> 

/* Purchase Return  Information End  */


/* Sales  Information Start */
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-chart')): ?>

  var _sales_months =  <?php echo json_encode($_sales_months) ?>;
  var _sales_month_amounts=  <?php echo json_encode($_sales_month_amounts) ?>;
<?php endif; ?>

/* monthly-restaurant-sales-chart */
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-restaurant-sales-chart')): ?>

  var _sales_months_restaurant =  <?php echo json_encode($_sales_months_restaurant) ?>;
  var _sales_month_amounts_restaurant=  <?php echo json_encode($_sales_month_amounts_restaurant) ?>;
<?php endif; ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-chart')): ?>
  var sales_days =  <?php echo json_encode($sales_days) ?>;
  var last_30_days_sales =  <?php echo json_encode($last_30_days_sales) ?>;
<?php endif; ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-restaurant-sales-chart')): ?>
  var sales_days_restaurant =  <?php echo json_encode($sales_days_restaurant) ?>;
  var last_30_days_sales_restaurant =  <?php echo json_encode($last_30_days_sales_restaurant) ?>;
<?php endif; ?>

/* Sales  Information End  */

/* Sales Return Information Start */
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-return-chart')): ?>
  var sales_return_days =  <?php echo json_encode($sales_return_days) ?>;
  var last_30_days_sales_return=  <?php echo json_encode($last_30_days_sales_return) ?>;
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-return-chart')): ?>
  var _sales_retun_months =  <?php echo json_encode($_sales_retun_months) ?>;
  var _sales_return_month_amounts =  <?php echo json_encode($_sales_return_month_amounts) ?>;
<?php endif; ?>

/* Sales Return Information End  */





  $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  




<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-chart')): ?>

  var $salesChart = $('#monthWiseSalesBarChart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: _sales_months,
      datasets: [
        {
          backgroundColor: '#28a745',
          borderColor: '#007bff',
          label: 'Sales',
          data: _sales_month_amounts
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return 'Tk.' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-restaurant-sales-chart')): ?>

  var $salesChart = $('#monthWiseResturantSalesBarChart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: _sales_months_restaurant,
      datasets: [
        {
          backgroundColor: '#28a745',
          borderColor: '#007bff',
          label: 'Sales',
          data: _sales_month_amounts_restaurant
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return 'Tk.' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-chart')): ?>
  var $visitorsChart = $('#dailySalesReport')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels:sales_days,
      datasets: [{
        type: 'line',
        data: last_30_days_sales,
        backgroundColor: 'transparent',
        borderColor: '#28a745',
        pointBorderColor: '#28a745',
        pointBackgroundColor: '#28a745',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },


    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-restaurant-sales-chart')): ?>
  var $visitorsChart = $('#dailyResturantSalesReport')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels:sales_days_restaurant,
      datasets: [{
        type: 'line',
        data: last_30_days_sales_restaurant,
        backgroundColor: 'transparent',
        borderColor: '#28a745',
        pointBorderColor: '#28a745',
        pointBackgroundColor: '#28a745',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },


    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

<?php endif; ?>



<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-chart')): ?>
  var $salesChart = $('#monthWisePurchaseBarChart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: _purchase_months,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          label: 'Purchase',
          data: _purchase_month_amounts
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return 'Tk.' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-chart')): ?>
  var $visitorsChart = $('#dailyPurchaseReport')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels:purchase_days,
      datasets: [{
        type: 'line',
        data: last_30_days_purchase,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>



<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-sales-return-chart')): ?>
  var $salesChart = $('#monthWiseSalesReturnBarChart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: _sales_retun_months,
      datasets: [
        {
          backgroundColor: '#e83e8c',
          borderColor: '#007bff',
          label: 'Sales Return',
          data: _sales_return_month_amounts
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return 'Tk.' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-sales-return-chart')): ?>
  var $visitorsChart = $('#dailySalesReturnReport')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels:sales_return_days,
      datasets: [{
        type: 'line',
        data: last_30_days_sales_return,
        backgroundColor: 'transparent',
        borderColor: '#e83e8c',
        pointBorderColor: '#e83e8c',
        pointBackgroundColor: '#e83e8c',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>





<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-purchase-return-chart')): ?>

  var $salesChart = $('#monthWisePurchaseReturnBarChart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: _purchase_return_months,
      datasets: [
        {
          backgroundColor: '#6610f2',
          borderColor: '#007bff',
          label: 'Purchase Return',
          data: _purchase_return_month_amounts
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return 'Tk.' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-purchase-return-chart')): ?>
  var $visitorsChart = $('#dailyPurchaseReturnReport')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels:purchase_return_days,
      datasets: [{
        type: 'line',
        data: last_30_days_purchase_return,
        backgroundColor: 'transparent',
        borderColor: '#6610f2',
        pointBorderColor: '#6610f2',
        pointBackgroundColor: '#6610f2',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>





 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-damage-chart')): ?>

  var $salesChart = $('#monthWiseDamageBarChart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: damage_months,
      datasets: [
        {
          backgroundColor: '#dc3545',
          borderColor: '#007bff',
          label: 'Damge Inventory',
          data: damage_month_amounts
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return 'Tk.' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily-damage-chart')): ?>
  var $visitorsChart = $('#dailyDamageReport')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels:damage_days,
      datasets: [{
        type: 'line',
        data: last_30_days_damage,
        backgroundColor: 'transparent',
        borderColor: '#dc3545',
        pointBorderColor: '#dc3545',
        pointBackgroundColor: '#dc3545',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
<?php endif; ?>







})


$(document).on("click", ".customer_wise_due_invoice", function() {
    var _id = $(this).attr("attr_id");
    var _form_name = 'receive_payments';
    var _form_type = 'entry_form';
    var _master_id = 0;

    var url = $(this).attr("attr_url");
    $(document).find("#exampleModalSecondLabel").text('Customer Wise Due Invoice Details');

    // Make the modal fullscreen when clicked
    $(document).find("#exampleModalSecond").addClass('modal-fullscreen');

    var request = $.ajax({
        url: url,
        method: "GET",
        data: { _id, _form_name,_form_type, _master_id, url },
        dataType: "HTML"
    });

    request.done(function(result) {
        $(document).find("#commonEntryModalFormSecond").html(result);
    });
});

// Close button functionality to remove fullscreen
$(document).on("click", ".commonModalClose", function() {
    $(document).find("#exampleModalSecond").removeClass('modal-fullscreen');
});

// Add event listener for clicking outside of the modal content (backdrop)
$(document).on("click", "#exampleModalSecond", function(e) {
    if (e.target === this) {  // If clicked outside of modal content (backdrop)
        $(document).find("#exampleModalSecond").removeClass('modal-fullscreen');
    }
});





</script>


<script>

  const myButton = document.getElementById('myButton');

if (myButton) {
    myButton.addEventListener('click', function() {
  var url = $(this).attr('attr_url');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            console.log(latitude)
            console.log(longitude)

           $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
            $.ajax({
               type:'POST',
               url:url,
               data:{latitude,longitude},
               success:function(data){
                  alert(data["message"]);
               }
            });
        }, function(error) {
            alert("Error getting location: " + error.message);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }

});
  }
</script>



 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_30_days_income_barchart')): ?>
  <?php

//Last 30 days sales line chart
  $stmd_30_days_incomes = " select round(sum(t1._collection_amount)) as _amount,DATE_FORMAT(t1._date, '%d-%m') as _month 
FROM stm_collection_master_details as t1

WHERE (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1  
GROUP BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ASC ";
  $daily_incode_report = \DB::select($stmd_30_days_incomes);

  //Last 30 days sales line chart
  $sales_days=array();
  $last_30_days_incomdes = array();
  foreach ($daily_incode_report as $value) {
    array_push($sales_days, $value->_month);
    array_push($last_30_days_incomdes, floatval($value->_amount));
  }

?>
<?php endif; ?>

<script type="text/javascript">
  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_30_days_income_barchart')): ?>
// Define required Chart.js configuration variables
var mode = 'index';
var intersect = false;
var ticksStyle = {
  fontColor: '#495057',
  fontStyle: 'bold'
};

var sales_days = <?php echo json_encode($sales_days) ?>;
var last_30_days_incomdes = <?php echo json_encode($last_30_days_incomdes) ?>;

var $visitorsChart = $('#stmd_30_days_income_barchart');
var visitorsChart = new Chart($visitorsChart, {
  data: {
    labels: sales_days,
    datasets: [{
      type: 'line',
      data: last_30_days_incomdes,
      backgroundColor: 'transparent',
      borderColor: '#28a745',
      pointBorderColor: '#28a745',
      pointBackgroundColor: '#28a745',
      fill: false
    }]
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      mode: mode,
      intersect: intersect
    },
    hover: {
      mode: mode,
      intersect: intersect
    },
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          display: true,
          lineWidth: '4px',
          color: 'rgba(0, 0, 0, .2)',
          zeroLineColor: 'transparent'
        },
        ticks: $.extend({
          beginAtZero: true,
          suggestedMax: 200
        }, ticksStyle)
      }],
      xAxes: [{
        display: true,
        gridLines: {
          display: false
        },
        ticks: ticksStyle
      }]
    }
  }
});
<?php endif; ?>
</script>



 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_30_days_expense_barchart')): ?>
  <?php

//Last 30 days sales line chart
  $stmd_30_days_expenses = " SELECT SUM(t1._dr_amount-t1._cr_amount) as _amount ,DATE_FORMAT(t1._date, '%d-%m') as _month 
FROM `accounts` as t1 
INNER JOIN account_ledgers as t2 ON t2.id=t1._account_ledger 
INNER JOIN account_heads as t3 ON t3.id=t2._account_head_id 
WHERE t1._status=1 AND t3._account_id=4 AND (t1._date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ) AND t1._status=1  
GROUP BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ORDER BY YEAR(t1._date),MONTH(t1._date),DAY(t1._date) ASC ";
  $daily_expense_report = \DB::select($stmd_30_days_expenses);

  //Last 30 days sales line chart
  $sales_days=array();
  $last_30_days_expenses = array();
  foreach ($daily_expense_report as $value) {
    array_push($sales_days, $value->_month);
    array_push($last_30_days_expenses, floatval($value->_amount));
  }

?>
<?php endif; ?>

<script type="text/javascript">
  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_30_days_expense_barchart')): ?>
// Define required Chart.js configuration variables
var mode = 'index';
var intersect = false;
var ticksStyle = {
  fontColor: '#495057',
  fontStyle: 'bold'
};

var sales_days = <?php echo json_encode($sales_days) ?>;
var last_30_days_expenses = <?php echo json_encode($last_30_days_expenses) ?>;

var $visitorsChart = $('#stmd_30_days_expense_barchart');
var visitorsChart = new Chart($visitorsChart, {
  data: {
    labels: sales_days,
    datasets: [{
      type: 'line',
      data: last_30_days_expenses,
      backgroundColor: 'transparent',
      borderColor: '#28a745',
      pointBorderColor: '#28a745',
      pointBackgroundColor: '#28a745',
      fill: false
    }]
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      mode: mode,
      intersect: intersect
    },
    hover: {
      mode: mode,
      intersect: intersect
    },
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          display: true,
          lineWidth: '4px',
          color: 'rgba(0, 0, 0, .2)',
          zeroLineColor: 'transparent'
        },
        ticks: $.extend({
          beginAtZero: true,
          suggestedMax: 200
        }, ticksStyle)
      }],
      xAxes: [{
        display: true,
        gridLines: {
          display: false
        },
        ticks: ticksStyle
      }]
    }
  }
});
<?php endif; ?>
</script>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_monthly_income_expense_compare')): ?>


<?php
// Get last 12 months data
$months_query = "SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%b-%Y') as month 
                 FROM (SELECT 0 as n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 
                       UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 
                       UNION SELECT 9 UNION SELECT 10 UNION SELECT 11) months 
                 ORDER BY month DESC";
$month_list = \DB::select($months_query);

// Income data
$income_data = [];
foreach ($month_list as $month) {
  $income = \DB::selectOne("SELECT COALESCE(SUM(_collection_amount), 0) as amount 
                           FROM stm_collection_master_details 
                           WHERE _status=1 AND DATE_FORMAT(_date, '%b-%Y') = ?", 
                           [$month->month]);
  $income_data[] = (float)$income->amount;
}

// Expense data
$expense_data = [];
foreach ($month_list as $month) {
  $expense = \DB::selectOne("SELECT COALESCE(SUM(_dr_amount-_cr_amount), 0) as amount 
                            FROM accounts a
                            JOIN account_ledgers al ON al.id = a._account_ledger
                            JOIN account_heads ah ON ah.id = al._account_head_id
                            WHERE a._status=1 AND ah._account_id=4 
                            AND DATE_FORMAT(a._date, '%b-%Y') = ?", 
                            [$month->month]);
  $expense_data[] = (float)$expense->amount;
}

$labels = array_column($month_list, 'month');
?>
<?php endif; ?>

<script>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_monthly_income_expense_compare')): ?>
document.addEventListener('DOMContentLoaded', function() {
  const ctx = document.getElementById('stmd_monthly_income_expense_compare').getContext('2d');
  
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labels) ?>,
      datasets: [
        {
          label: 'Income',
          data: <?php echo json_encode($income_data) ?>,
          backgroundColor: 'rgba(75, 192, 192, 0.7)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        },
        {
          label: 'Expense',
          data: <?php echo json_encode($expense_data) ?>,
          backgroundColor: 'rgba(255, 99, 132, 0.7)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          stacked: false,
          grid: { display: false }
        },
        y: {
          stacked: false,
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return value.toLocaleString();
            }
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.raw.toLocaleString()}`;
            }
          }
        },
        legend: {
          position: 'top'
        }
      }
    }
  });
});
<?php endif; ?>
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/dashboard/index.blade.php ENDPATH**/ ?>