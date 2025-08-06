<aside class="main-sidebar   sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="<?php echo e(url('home')); ?>" class="brand-link">
      <img src="<?php echo e(asset('/')); ?><?php echo e($settings->logo ?? ''); ?>" alt="<?php echo e($settings->name ?? ''); ?>" class="brand-image  elevation-3" >
      <span class="brand-text font-weight-light"><?php echo e($settings->title ?? ''); ?></span>
    </a>
<?php
   $current_url = Route::current()->getName();
?>
    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar Menu -->
     
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item ">
            <a href="<?php echo e(url('home')); ?>" class="nav-link <?php echo e(( $current_url=='home' ) ? 'nest_active' : ''); ?>"  >
              <i class="nav-icon fas fa-tachometer-alt" aria-hidden="true"></i>
              <p>
                  <?php echo e(__('label.Dashboard')); ?>

              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?php echo e(url('report-panel')); ?>" class="nav-link <?php echo e(( $current_url=='home' ) ? 'nest_active' : ''); ?>"  >
              <i class="nav-icon fas fa-file" aria-hidden="true"></i>
              <p>
                  <?php echo e(__('label.report')); ?>

              </p>
            </a>
          </li>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-menu')): ?> 
          <li class="nav-item <?php echo e(Route::is('voucher.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('purchase-return.*')    ? 'main_nav_active' : ''); ?>">
              <i class="nav-icon fas fa-th nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.Accounts')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-receive')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(url('voucher')); ?>?_voucher_type=CR" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Cash Receive')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-payment')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('voucher')); ?>?_voucher_type=CP" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Cash Payment')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('petty-cash')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('petty-cash')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('Petty Cash')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-receive')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('voucher')); ?>?_voucher_type=BR" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Bank Receive')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-payment')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('voucher')); ?>?_voucher_type=BP" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Bank Payment')); ?></p></a>
              </li>
              <?php endif; ?>
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('voucher')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Voucher')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('easy-voucher-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('easy-voucher')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Easy Voucher')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inter-project-voucher-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('inter-project-voucher')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.inter-project-voucher')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier_payment_list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('supplier_payment')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.supplier_payment')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_payment_list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('customer_payment')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.customer_payment')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('so_wise_due_invoice')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('so_wise_due_invoice')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.so_wise_due_invoice')); ?></p></a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>
   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_management')): ?> 
          <li class="nav-item <?php echo e(Route::is('voucher.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('purchase-return.*')    ? 'main_nav_active' : ''); ?>">
              <i class="nav-icon fas fa-th nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.student_management')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admission_fee_collection')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('admission_fee_collection_list')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.admission_fee_collection')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_collection_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_collection.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_collection_list')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_bill_masters_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_bill_masters.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_bill_masters')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_students_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_students.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_students')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_education_sessions_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_education_sessions.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_education_sessions')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_division_class_students')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_division_class_students')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_division_class_students')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_income_ledger_setups')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_income_ledger_setups')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_income_ledger_setups')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_divisions_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_divisions.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_divisions')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_classes_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_classes.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_classes')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_subjects_list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('stm_subjects.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.stm_subjects')); ?></p></a>
              </li>
              <?php endif; ?>
           
            </ul>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_commision_plans')): ?>
          <li class="nav-item <?php echo e(Route::is('sales_commision_plans.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('sales_commision_plans.*')    ? 'main_nav_active' : ''); ?>">
              <i class="nav-icon fas fa-th nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.Others')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ta_da_setups-list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('ta_da_setups.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.ta_da_setups')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cat_wise_ta_bills-list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('cat_wise_ta_bills.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.cat_wise_ta_bills')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_bonus_setups-list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('item_bonus_setups.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.item_bonus_setups')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly_sales_targets-list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('monthly_sales_targets.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.monthly_sales_targets')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quaterly_insentive_setups-list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('quaterly_insentive_setups.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.quaterly_insentive_setups')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_commision_plans-list')): ?>
              <li class="nav-item" >
                  <a href="<?php echo e(route('sales_commision_plans.index')); ?>" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.sales_commision_plans')); ?></p></a>
              </li>
              <?php endif; ?>
             
            </ul>
          </li>
        <?php endif; ?>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-module')): ?> 
          <li class="nav-item <?php echo e(Route::is('restaurant-sales.*') || Route::is('table-info.*')  || Route::is('steward-waiter.*')  || Route::is('musak-four-point-three.*')|| Route::is('kitchen.*')   ? 'menu-is-opening menu-open' : ''); ?> ">
            <a href="#" class="nav-link ">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                <?php echo e(__('label.Restaurants')); ?> 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-pos')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('restaurant-pos')); ?>" class="nav-link" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Restaurant POS')); ?></p></a>
              </li>
              <?php endif; ?>
             
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-sales-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('restaurant-sales')); ?>" class="nav-link <?php echo e(Route::is('restaurant-sales.*') ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Restaurant Sales')); ?></p></a>
              </li>
              <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('table-info-menu')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('table-info')); ?>"  class="nav-link <?php echo e(Route::is('table-info.*') ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p> Table Information </p></a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('steward-waiter-menu')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('steward-waiter')); ?>"  class="nav-link <?php echo e(Route::is('steward-waiter.*') ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p> Steward/Waiter Setup </p></a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('musak-four-point-three-menu')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('musak-four-point-three')); ?>" class="nav-link <?php echo e(Route::is('musak-four-point-three.*') ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p> Item Wise Ingredients </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kitchen-menu')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('kitchen')); ?>" class="nav-link <?php echo e(Route::is('kitchen.*') ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p>  Kitchen Panel </p></a>
              </li>
              <?php endif; ?>
            
             
            
              
            </ul>
          </li>
          <?php endif; ?>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-order-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('purchase-order.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('purchase-order.*')    ? 'main_nav_active' : ''); ?>">

              <i class="far fa-plus-square nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.purchase order')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-order-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase-order/create')); ?>" class="nav-link <?php echo e(( $current_url=='purchase-order.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Purchase Order Create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-order-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase-order')); ?>" class="nav-link <?php echo e(( $current_url=='purchase-order.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Purchase Order List')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?> 

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('purchase.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('purchase.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-cart-plus nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.purchase')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase/create')); ?>" class="nav-link <?php echo e(( $current_url=='purchase.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Purchase Create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase')); ?>" class="nav-link <?php echo e(( $current_url=='purchase.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Purchase List')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('purchase-return.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('purchase-return.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-cart-arrow-down nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.purchase-return')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase-return/create')); ?>" class="nav-link <?php echo e(( $current_url=='purchase-return.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.purchase-return-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase-return')); ?>" class="nav-link <?php echo e(( $current_url=='purchase-return.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.purchase-return-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-order-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('sales-order.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('sales-order.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.sales-order')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
           
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('avaiable_product_list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('product_show')); ?>" class="nav-link <?php echo e(( $current_url=='product_show' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.avaiable_product_list')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-order-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-order/create')); ?>" class="nav-link <?php echo e(( $current_url=='sales-order.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales-order-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-order-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-order')); ?>" class="nav-link <?php echo e(( $current_url=='sales-order.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales-order-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('sales.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('sales.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.sales')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales/create')); ?>" class="nav-link <?php echo e(( $current_url=='sales.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales')); ?>" class="nav-link <?php echo e(( $current_url=='sales.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales-list')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_without_stock_deduct')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales_without_stock_deduct')); ?>" class="nav-link <?php echo e(( $current_url=='sales_without_stock_deduct.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales_without_stock_deduct')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('previous_bill_item_send')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('previous_bill_item_send')); ?>" class="nav-link <?php echo e(( $current_url=='previous_bill_item_send.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.previous_bill_item_send')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('sales-return.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('sales-return.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.sales-return')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-return/create')); ?>" class="nav-link <?php echo e(( $current_url=='sales-return.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales-return-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-return')); ?>" class="nav-link <?php echo e(( $current_url=='sales-return.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.sales-return-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('previous_sales_return-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('previous_sales_return.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('previous_sales_return.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.previous_sales_return')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('previous_sales_return-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('previous_sales_return/create')); ?>" class="nav-link <?php echo e(( $current_url=='previous_sales_return.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.previous_sales_return')); ?> Create</p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('previous_sales_return-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('previous_sales_return')); ?>" class="nav-link <?php echo e(( $current_url=='previous_sales_return.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.previous_sales_return')); ?> List</p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('damage.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('damage.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.damage')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('damage/create')); ?>" class="nav-link <?php echo e(( $current_url=='damage.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.damage-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('damage')); ?>" class="nav-link <?php echo e(( $current_url=='damage.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.damage-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('damage_from_stocks.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('damage_from_stocks.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.damage_from_stocks')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('damage_from_stocks/create')); ?>" class="nav-link <?php echo e(( $current_url=='damage_from_stocks.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.damage_from_stocks')); ?> Create </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('damage_from_stocks')); ?>" class="nav-link <?php echo e(( $current_url=='damage_from_stocks.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.damage_from_stocks')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('transfer.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('transfer.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.transfer')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('transfer/create')); ?>" class="nav-link <?php echo e(( $current_url=='transfer.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.transfer-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('transfer')); ?>" class="nav-link <?php echo e(( $current_url=='transfer.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.transfer-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('production-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('production.*') ||  Route::is('partical-production-receive')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('production.*') ||  Route::is('partical-production-receive')     ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.production')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('production-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('production/create')); ?>" class="nav-link <?php echo e(( $current_url=='production.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.production-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('production-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('production')); ?>" class="nav-link <?php echo e(( $current_url=='production.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.production-list')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('partical-production-receive')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('partical-production-receive')); ?>" class="nav-link <?php echo e(( $current_url=='partical-production-receive' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.partical-production-receive')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('third-party-service-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('third-party-service.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('third-party-service.*')    ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.third-party-service')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('third-party-service-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('third-party-service/create')); ?>" class="nav-link <?php echo e(( $current_url=='third-party-service.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.third-party-service-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('third-party-service-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('third-party-service')); ?>" class="nav-link <?php echo e(( $current_url=='third-party-service.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.third-party-service-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-manage-list')): ?> 
          <li class="nav-item <?php echo e(Route::is('warranty-manage.*') || Route::is('individual-replacement.*') || Route::is('item-replace.*') ||  Route::is('individual-replacement.*') ||  Route::is('warranty-check')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('warranty-manage.*') || Route::is('individual-replacement.*') || Route::is('item-replace.*') ||  Route::is('individual-replacement.*') ||  Route::is('warranty-check')   ? 'main_nav_active' : ''); ?>">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.warranty-manage')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-check')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('warranty-check')); ?>" class="nav-link <?php echo e(( $current_url=='warranty-check' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.warranty-check')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-manage-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('warranty-manage/create')); ?>" class="nav-link <?php echo e(( $current_url=='warranty-manage.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.warranty-manage-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-manage-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('warranty-manage')); ?>" class="nav-link <?php echo e(( $current_url=='warranty-manage.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.warranty-manage-list')); ?></p></a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-replace-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('item-replace/create')); ?>" class="nav-link <?php echo e(( $current_url=='item-replace.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.item-replace-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-replace-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('item-replace')); ?>" class="nav-link <?php echo e(( $current_url=='item-replace.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.item-replace-list')); ?></p></a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('individual-replacement-create')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('individual-replacement/create')); ?>" class="nav-link <?php echo e(( $current_url=='individual-replacement.create' ) ? 'nest_active' : ''); ?>"  ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.individual-replacement-create')); ?> </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('individual-replacement-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('individual-replacement')); ?>" class="nav-link <?php echo e(( $current_url=='individual-replacement.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.individual-replacement-list')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('w-item-receive-from-supp-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('w-item-receive-from-supp')); ?>" class="nav-link <?php echo e(( $current_url=='w-item-receive-from-supp.index' ) ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.w-item-receive-from-supp-list')); ?></p></a>
              </li>
              <?php endif; ?>
              
            </ul>
          </li>
          <?php endif; ?>
          
          

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventory-report')): ?> 
          <li class="nav-item ">
            <a href="#" class="nav-link ">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 <?php echo e(__('label.Inventory Report')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bcategory-wise-item-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('bcategory-wise-item-list')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.category-wise-item-list')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('day-wise-summary-report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('day-wise-summary-report')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>Work Period Sales Summary Report </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-sales-report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('item-sales-report')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>Item Sales Report </p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('detail-item-sales-report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('detail-item-sales-report')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>Detail Item Sales Report </p></a>
              </li>
              <?php endif; ?>



              
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bill-party-statement')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('bill-party-statement')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Bill of Party Statement')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-purchase')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date-wise-purchase')); ?>" class="nav-link <?php echo e(Route::is('date-wise-purchase')   ? 'nest_active' : ''); ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Date Wise Purchase')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-detail')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('purchase-return-detail')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p><?php echo e(__('label.Purchase Return Detail')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date-wise-sales')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Date Wise Sales')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transection_terms_wise_sales_report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('transection_terms_wise_sales_report')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.transection_terms_wise_sales_report')); ?></p></a>
              </li>
              <?php endif; ?>

             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date_to_date_sales_detail')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.date_to_date_sales_detail')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date_to_date_sales_item_detail')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.date_to_date_sales_item_detail')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date_to_date_sales_item_summary')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.date_to_date_sales_item_summary')); ?></p></a>
              </li>
              <?php endif; ?>


             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-restaurant-sales')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date-wise-restaurant-sales')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Date Wise Restaurant Sales')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-detail')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-return-detail')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Sales Return Details')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-possition')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('stock-possition')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Stock Possition')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-balance')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('stock-balance')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('Stock Balance Report')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-ledger')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('stock-ledger')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Stock Ledger')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-value')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('stock-value')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Stock Value')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-value-register')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('stock-value-register')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Stock Value Register')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gross-profit')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('gross-profit')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Gross Profit')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expired-item')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('expired-item')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Expired Item')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('shortage-item')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('shortage-item')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Shortage Item')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('barcode-history')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('barcode-history')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Barcode History')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-wise-collection-payment')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('user-wise-collection-payment')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.User Wise Collection Payment')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-invoice-print')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date-wise-invoice-print')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Date Wise Invoice Print')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-restaurant-invoice-print')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date-wise-restaurant-invoice-print')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Date Wise Restaurant Invoice Print')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delivery-man-sales')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('delivery-man-sales')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Delivery Man Sales')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delivery-man-sales-return')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('delivery-man-sales-return')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Delivery Man Sales Return')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-man-sales-return')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-man-sales-return')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Sales Man Sales Return')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-man-invoice')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('sales-man-invoice')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Sales Man Invoice')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delivery-man-sales-invoice')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('delivery-man-sales-invoice')); ?>" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> <?php echo e(__('label.Delivery Man Sales Invoice')); ?></p></a>
              </li>
              <?php endif; ?>
            
              
            </ul>
          </li>
          <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-report-menu')): ?> 
          <li class="nav-item <?php echo e(Route::is('ledger-report') || Route::is('group-ledger')  || Route::is('date_to_date_sales_amount_report')  || Route::is('outstanding_detail_report') || Route::is('day-book') || Route::is('income-statement') || Route::is('trail-balance') || Route::is('work-sheet') || Route::is('balance-sheet') || Route::is('bank-book') || Route::is('receipt-payment')  || Route::is('filter-ledger-summary') || Route::is('customer_due_statement') || Route::is('final_due_statement') || Route::is('chart-of-account')  || Route::is('payable_report') ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('ledger-report') || Route::is('group-ledger') || Route::is('date_to_date_sales_amount_report') || Route::is('outstanding_detail_report') || Route::is('income-statement') || Route::is('trail-balance') || Route::is('work-sheet') || Route::is('balance-sheet') || Route::is('day-book')   || Route::is('bank-book') || Route::is('receipt-payment') || Route::is('filter-ledger-summary') || Route::is('chart-of-account') || Route::is('customer_due_statement') || Route::is('payable_report')  || Route::is('final_due_statement')    ? 'active' : ''); ?>">
              <i class="fa fa-file nav-icon" aria-hidden="true"></i>
              <p>
                <?php echo e(__('label.Accounts Report')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('day-book')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('day-book')); ?>" class="nav-link <?php echo e(Route::is('day-book')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Day Book')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-book')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('cash-book')); ?>" class="nav-link <?php echo e(Route::is('cash-book')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Cash Book')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-book')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('bank-book')); ?>" class="nav-link <?php echo e(Route::is('bank-book')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Bank Book')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('receipt-payment')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('receipt-payment')); ?>" class="nav-link <?php echo e(Route::is('receipt-payment')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Receipt & Payment')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger-report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('ledger-report')); ?>" class="nav-link <?php echo e(Route::is('ledger-report')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Ledger Report')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('group-ledger')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('group-ledger')); ?>" class="nav-link <?php echo e(Route::is('group-ledger')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Group Ledger Report')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger-summary-report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('filter-ledger-summary')); ?>" class="nav-link <?php echo e(Route::is('filter-ledger-summary')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p> <?php echo e(__('label.Ledger Summary Report')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income-statement')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('income-statement')); ?>" class="nav-link <?php echo e(Route::is('income-statement')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Income Statement')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('outstanding_detail_report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('outstanding_detail_report')); ?>" class="nav-link <?php echo e(Route::is('outstanding_detail_report')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.outstanding_detail_report')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_due_statement')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('customer_due_statement')); ?>" class="nav-link <?php echo e(Route::is('customer_due_statement')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.customer_due_statement')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payable_receivalbe_report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('payable_report')); ?>" class="nav-link <?php echo e(Route::is('payable_report')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.payable_report')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date_to_date_sales_amount_report')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('date_to_date_sales_amount_report')); ?>" class="nav-link <?php echo e(Route::is('date_to_date_sales_amount_report')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.date_to_date_sales_amount_report')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_due_statement')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('final_due_statement')); ?>" class="nav-link <?php echo e(Route::is('final_due_statement')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.final_due_statement')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_due_statement')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('single_customer_statement')); ?>" class="nav-link <?php echo e(Route::is('single_customer_statement')   ? 'nest_active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.single_customer_statement')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('trail-balance')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('trail-balance')); ?>" class="nav-link <?php echo e(Route::is('trail-balance')   ? 'active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Trail Balance')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work-sheet')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('work-sheet')); ?>" class="nav-link <?php echo e(Route::is('work-sheet')   ? 'active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Work Sheet')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('balance-sheet')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('balance-sheet')); ?>" class="nav-link <?php echo e(Route::is('balance-sheet')   ? 'active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Balance Sheet')); ?></p>
                </a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('chart-of-account')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('chart-of-account')); ?>" class="nav-link <?php echo e(Route::is('chart-of-account')   ? 'active' : ''); ?>" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p><?php echo e(__('label.Chart of Account')); ?></p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventory-menu')): ?> 
          <li class="nav-item <?php echo e(Route::is('account-type.*') || Route::is('account-group.*') || Route::is('unit.*')  || Route::is('item-information.*')  || Route::is('lot-item-information.*')  || Route::is('account-ledger.*')  || Route::is('item-category.*')  || Route::is('warranty.*') || Route::is('transection_terms.*') || Route::is('vat-rules.*') || Route::is('labels-print') || Route::is('lot-item-information') || Route::is('pack-size.*') || Route::is('item-brand.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link  Route::is('account-type.*') || Route::is('account-group.*')  || Route::is('unit.*')   || Route::is('item-information.*')    || Route::is('lot-item-information.*')   || Route::is('account-ledger.*')  || Route::is('item-category.*') || Route::is('warranty.*') || Route::is('transection_terms.*')  || Route::is('vat-rules.*')   || Route::is('labels-print')   || Route::is('lot-item-information') || Route::is('pack-size.*') || Route::is('item-brand.*')   ? 'active' : '' }}">
              <i class="fa fa-file nav-icon" aria-hidden="true"></i>
              <p>
               <?php echo e(__('label.Master')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-type-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('account-type')); ?>"  class="nav-link <?php echo e(Route::is('account-type.*')   ? 'active' : ''); ?>" ><i class="fa fa-sitemap nav-icon"></i> <p><?php echo e(__('label.Account Type')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-group-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('account-group')); ?>"  class="nav-link <?php echo e(Route::is('account-group.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Account Group')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('account-ledger')); ?>"  class="nav-link <?php echo e(Route::is('account-ledger.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Account Ledger')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-category-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('item-category')); ?>"  class="nav-link <?php echo e(Route::is('item-category.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Item Category')); ?></p></a>
              </li>
              <?php endif; ?>

             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-brand-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('item-brand')); ?>"  class="nav-link <?php echo e(Route::is('item-brand.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.item_brand')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pack-size-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('pack-size')); ?>"  class="nav-link <?php echo e(Route::is('pack-size.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.pack_size')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('unit')); ?>"  class="nav-link <?php echo e(Route::is('unit.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Unit Of Measurment')); ?></p></a>
              </li>
              <?php endif; ?>
             
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('warranty')); ?>"  class="nav-link <?php echo e(Route::is('warranty.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Warranty')); ?></p></a>
              </li>
              <?php endif; ?>

             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transection_terms-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('transection_terms')); ?>"  class="nav-link <?php echo e(Route::is('transection_terms.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Transection Terms')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vat-rules-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('vat-rules')); ?>"  class="nav-link <?php echo e(Route::is('vat-rules.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Vat Rules')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-information-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('item-information')); ?>"  class="nav-link <?php echo e(Route::is('item-information.*')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Item Information')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lot-item-information')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('lot-item-information')); ?>"  class="nav-link <?php echo e(Route::is('lot-item-information')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Lot Item Information')); ?></p></a>
              </li>
              <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('labels-print')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('labels-print')); ?>"  class="nav-link <?php echo e(Route::is('labels-print')   ? 'active' : ''); ?>" ><i class="fa fa-laptop nav-icon"></i> <p><?php echo e(__('label.Labels Print')); ?></p></a>
              </li>
              <?php endif; ?>

             
            </ul>
          </li>
          <?php endif; ?>
          <li class="nav-item <?php echo e(Route::is('roles.*') || Route::is('users.*') || Route::is('sms-send')  || Route::is('all-lock') || Route::is('invoice-prefix') || Route::is('database-backup') || Route::is('admin-settings') || Route::is('branch.*') || Route::is('social_media.*') || Route::is('cost-center.*') || Route::is('store-house.*')  ? 'menu-is-opening menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Route::is('roles.*') || Route::is('users.*') || Route::is('admin-settings') || Route::is('branch.*')  || Route::is('cost-center.*')|| Route::is('sms-send') || Route::is('invoice-prefix')  || Route::is('database-backup')  || Route::is('all-lock')  || Route::is('store-house.*')   ? 'active' : ''); ?>">
            
               <i class="fas fa-cog nav-icon"></i> 
              <p>
                <?php echo e(__('label.Settings')); ?>

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-settings')): ?>
              <li class="nav-item">

                <a href="<?php echo e(url('admin-settings')); ?>" class="nav-link <?php echo e(Route::is('admin-settings')   ? 'active' : ''); ?>">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p><?php echo e(__('label.General Settings')); ?></p>
                </a>
              </li>
              <?php endif; ?>
            
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bulk-sms')): ?>
              <li class="nav-item">

                <a href="<?php echo e(url('sms-send')); ?>" class="nav-link <?php echo e(Route::is('sms-send')   ? 'active' : ''); ?>">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p><?php echo e(__('label.SMS SEND')); ?></p>
                </a>
              </li>
              <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoice-prefix')): ?>
              <li class="nav-item">

                <a href="<?php echo e(url('invoice-prefix')); ?>" class="nav-link <?php echo e(Route::is('invoice-prefix')   ? 'active' : ''); ?>">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p><?php echo e(__('label.Invoice Prefix')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('social_media-list')): ?>
              <li class="nav-item">

                <a href="<?php echo e(url('social_media')); ?>" class="nav-link <?php echo e(Route::is('social_media.*')   ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Social Media</p>
                </a>
              </li>
              <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('roles')); ?>" class="nav-link <?php echo e(Route::is('roles.*')   ? 'active' : ''); ?>">
                  <i class="fa fa-server nav-icon"></i>
                  <p><?php echo e(__('label.Roles')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('users')); ?>" class="nav-link <?php echo e(Route::is('users.*')   ? 'active' : ''); ?>">
                  <i class="fas fa-users nav-icon"></i>
                  <p><?php echo e(__('label.Users')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('branch-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('branch')); ?>" class="nav-link <?php echo e(Route::is('branch.*')   ? 'active' : ''); ?>">
                 <i class="fa fa-share-alt nav-icon"></i>
                  <p><?php echo e(__('label.Branch')); ?> </p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost-center-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('cost-center')); ?>" class="nav-link <?php echo e(Route::is('cost-center.*')   ? 'active' : ''); ?>">
                  <i class="fa fa-adjust nav-icon"></i>
                  <p><?php echo e(__('label.Cost center')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-house-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('store-house')); ?>" class="nav-link <?php echo e(Route::is('store-house.*')   ? 'active' : ''); ?>">
                  <i class="fas fa-store  nav-icon"></i>
                  <p><?php echo e(__('label.Store House')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account_group_configs')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('account_group_configs')); ?>" class="nav-link <?php echo e(Route::is('account_group_configs')   ? 'active' : ''); ?>">
                  <i class="fas fa-store  nav-icon"></i>
                  <p><?php echo e(__('label.account_group_configs')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock-permission')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('all-lock')); ?>" class="nav-link <?php echo e(Route::is('all-lock')   ? 'active' : ''); ?>">
                  <i class="fas fa-store  nav-icon"></i>
                  <p><?php echo e(__('label.Transection Lock System')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('documents-list')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('documents')); ?>" class="nav-link <?php echo e(Route::is('documents')   ? 'active' : ''); ?>">
                  <i class="fas fa-file  nav-icon"></i>
                  <p><?php echo e(__('label.documents')); ?></p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('database-backup')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('database-backup')); ?>" class="nav-link <?php echo e(Route::is('database-backup')   ? 'active' : ''); ?>">
                  <i class="fas fa-store  nav-icon"></i>
                  <p><?php echo e(__('label.Data Backup')); ?></p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside><?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/layouts/main_sidebar.blade.php ENDPATH**/ ?>