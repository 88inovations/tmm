<nav class="main-header navbar navbar-expand  navbar-light" id="ewMobileMenu">
    <!-- Left navbar links -->
    <ul class="navbar-nav" >
      
    <li class="nav-item">
        <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_management')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <?php echo e(__('label.student_management')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
     
     
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admission_fee_collection')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('admission_fee_collection_list')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.admission_fee_collection')); ?>

          </a>
          <a  href="<?php echo e(route('admission_fee_collection')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_collection_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_collection.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_collection')); ?>

          </a>
          <a  href="<?php echo e(route('stm_collection.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_bill_masters_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_bill_masters.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_bill_masters')); ?>

          </a>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_bill_masters_create')): ?>
          <a  href="<?php echo e(route('stm_bill_masters.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_students_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_students.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_students')); ?>

          </a>
          <a  href="<?php echo e(route('stm_students.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>

        
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_education_sessions_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_education_sessions.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_education_sessions')); ?>

          </a>
          <a  href="<?php echo e(route('stm_education_sessions.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_division_class_students')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_division_class_students')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_division_class_students')); ?>

          </a>
        
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_income_ledger_setups')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_income_ledger_setups')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_income_ledger_setups')); ?>

          </a>
        
        </div>
        <?php endif; ?>

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_divisions_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_divisions.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_divisions')); ?>

          </a>
          <a  href="<?php echo e(route('stm_divisions.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_classes_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_classes.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_classes')); ?>

          </a>
          <a  href="<?php echo e(route('stm_classes.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_subjects_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('stm_subjects.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.stm_subjects')); ?>

          </a>
          <a  href="<?php echo e(route('stm_subjects.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
       
       
       
      </li>
    <?php endif; ?>



       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-management-report')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <?php echo e(__('label.asset')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
     
     
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-location-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset-location.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset-location')); ?>

          </a>
          <a  href="<?php echo e(route('asset-location.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-actual-location-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset-actual-location.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset-actual-location')); ?>

          </a>
          <a  href="<?php echo e(route('asset-actual-location.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inspection-check-category-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('inspection-check-category.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.inspection-check-category')); ?>

          </a>
          <a  href="<?php echo e(route('inspection-check-category.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inspection-check-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('inspection-check.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.inspection-check')); ?>

          </a>
          <a  href="<?php echo e(route('inspection-check.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-condition-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset-condition.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset-condition')); ?>

          </a>
          <a  href="<?php echo e(route('asset-condition.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-condition-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('assign-status.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.assign-status')); ?>

          </a>
          <a  href="<?php echo e(route('assign-status.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-entry-assign-list')): ?>
        <!-- <div style="display: flex;">
         <a href="<?php echo e(route('asset-entry-assign.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset-entry-assign')); ?>

          </a>
          <a  href="<?php echo e(route('asset-entry-assign.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div> -->
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-entry-assign-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset_item_entry.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset_item_entry')); ?>

          </a>
          <a  href="<?php echo e(route('asset_item_entry.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
       
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset_depreciation-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset_depreciation.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset_depreciation')); ?>

          </a>
          <a  href="<?php echo e(route('asset_depreciation.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset_maintainces-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset_maintainces.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset_maintainces')); ?>

          </a>
          <a  href="<?php echo e(route('asset_maintainces.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset_eng_consumptions_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset_eng_consumptions.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset_eng_consumptions')); ?>

          </a>
          <a  href="<?php echo e(route('asset_eng_consumptions.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset_sales_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(route('asset_sales_list')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset_sales')); ?>

          </a>
          <a  href="<?php echo e(route('asset_sales_create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset_sales_list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('asset-management/report')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.report')); ?>

          </a>
        </div>
        <?php endif; ?>
       
       
      </li>
    <?php endif; ?>

    

       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quaterly_insentive_setups-list')): ?>
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <?php echo e(__('Others')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
       <div class="dropdown-divider"></div>
        <p class="text-center"><?php echo e(__('label.honorarium_module')); ?></p>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorim_setups_list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('honorim_setups.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.honorim_setups')); ?>

          </a>
          <a  href="<?php echo e(route('honorim_setups.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorarium_bills_list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('honorarium_bills.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.honorarium_bills')); ?>

          </a>
          <a  href="<?php echo e(route('honorarium_bills.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorarium_payments_list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('honorarium_payments.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.honorarium_payments')); ?>

          </a>
          <a  href="<?php echo e(route('honorarium_payments.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorarium_report')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('honorarium_report')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.honorarium_report')); ?>

          </a>
          
        </div>
        <?php endif; ?>

       <div class="dropdown-divider"></div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_commision_plans-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('sales_commision_plans.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.sales_commision_plans')); ?>

          </a>
          <a  href="<?php echo e(route('sales_commision_plans.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quaterly_insentive_setups-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('quaterly_insentive_setups.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.quaterly_insentive_setups')); ?>

          </a>
          <a  href="<?php echo e(route('quaterly_insentive_setups.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly_sales_targets-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('monthly_sales_targets.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.monthly_sales_targets')); ?>

          </a>
          <a  href="<?php echo e(route('monthly_sales_targets.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly_sales_targets-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(url('customer_sales_target_list')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.customer_sales_target_list')); ?>

          </a>
          
        </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_bonus_setups-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('item_bonus_setups.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.item_bonus_setups')); ?>

          </a>
          <a  href="<?php echo e(route('item_bonus_setups.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ta_da_setups-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('ta_da_setups.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.ta_da_setups')); ?>

          </a>
          <a  href="<?php echo e(route('ta_da_setups.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cat_wise_ta_bills-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('cat_wise_ta_bills.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.cat_wise_ta_bills')); ?>

          </a>
          <a  href="<?php echo e(route('cat_wise_ta_bills.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
       
      </li>
   
 <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-module')): ?> 
      <li class="nav-item dropdown remove_from_header ">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <?php echo e(__('label.hrm')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
       <p style="padding-left: 20px;"><b><?php echo e(__('label.leave')); ?></b></p>
       <div class="dropdown-divider"></div>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-attandance-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('attandance')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-attandance')); ?>

          </a>
          <a  href="<?php echo e(route('attandance.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_duty-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('employee_duty')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.employee_duty')); ?>

          </a>
        
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('week-work-day')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('weekworkday')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.weekworkday')); ?>

          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('holidays-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('holidays')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.holidays')); ?>

          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leave-type-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('leave-type')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.leave-type')); ?>

          </a>
          <a  href="<?php echo e(route('leave-type.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-employee-list')): ?>
        <p style="padding-left: 20px;"><b><?php echo e(__('label.hrm-employee')); ?></b></p>
       <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('hrm-employee')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-employee')); ?>

          </a>
          <a  href="<?php echo e(route('hrm-employee.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salary_sheet_list')): ?>
       
        <p style="padding-left: 20px;"><b><?php echo e(__('label.salary_sheet')); ?></b></p>
       <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('salary_sheet_list')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.salary_sheet')); ?>

          </a>
          <a  href="<?php echo e(url('salary_sheet')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
       
        <p style="padding-left: 20px;"><b><?php echo e(__('label.payrol-information')); ?></b></p>
       <div class="dropdown-divider"></div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly-salary-structure-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('monthly-salary-structure')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.monthly-salary-structure')); ?>

          </a>
          <a  href="<?php echo e(route('monthly-salary-structure.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('initial-salary-structure-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('initial-salary-structure')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.initial-salary-structure')); ?>

          </a>
          <a  href="<?php echo e(route('initial-salary-structure.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pay-heads-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('pay-heads')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.pay-heads')); ?>

          </a>
          <a  href="<?php echo e(route('pay-heads.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-department-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('hrm-department')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-department')); ?>

          </a>
          <a  href="<?php echo e(route('hrm-department.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-grade-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('hrm-grade')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-grade')); ?>

          </a>
          <a  href="<?php echo e(route('hrm-grade.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-emp-location-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('hrm-emp-location')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-emp-location')); ?>

          </a>
          <a  href="<?php echo e(route('hrm-emp-location.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
      
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zones-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('zones')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.zones')); ?>

          </a>
          <a  href="<?php echo e(route('zones.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-emp-category-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('hrm-emp-category')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-emp-category')); ?>

          </a>
          <a  href="<?php echo e(route('hrm-emp-category.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-designation-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('hrm-designation')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.hrm-designation')); ?>

          </a>
          <a  href="<?php echo e(route('hrm-designation.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        
      </li>
    <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-menu')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <?php echo e(__('label.Accounts')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
       
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-receive')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('voucher')); ?>?_voucher_type=CR" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Cash Receive')); ?>

          </a>
           <a  href="<?php echo e(url('cash-receive')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-payment')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('voucher')); ?>?_voucher_type=CP" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Cash Payment')); ?>

          </a>
           <a  href="<?php echo e(url('cash-payment')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('petty-cash')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('voucher')); ?>?_voucher_type=PC" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('Petty Cash')); ?>

          </a>
           <a  href="<?php echo e(url('petty-cash')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-receive')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('voucher')); ?>?_voucher_type=BR" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Bank Receive')); ?>

          </a>
           <a  href="<?php echo e(url('bank-receive')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-payment')): ?>
        <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('voucher')); ?>?_voucher_type=BP" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Bank Payment')); ?>

          </a>
           <a  href="<?php echo e(url('bank-payment')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
         
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-list')): ?>
          <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('voucher')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Voucher')); ?>

          </a>
           <a  href="<?php echo e(route('voucher.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('easy-voucher-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('easy-voucher')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Easy Voucher')); ?>

          </a>
           <a  href="<?php echo e(route('easy-voucher.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inter-project-voucher-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('inter-project-voucher')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.inter-project-voucher')); ?>

          </a>
           <a  href="<?php echo e(route('inter-project-voucher.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier_payment_list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('supplier_payment')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.supplier_payment')); ?>

          </a>
           <a  href="<?php echo e(route('supplier_payment.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_payment_list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('customer_payment')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.customer_payment')); ?>

          </a>
           <a  href="<?php echo e(route('customer_payment.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('so_wise_due_invoice')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('so_wise_due_invoice')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.so_wise_due_invoice')); ?>

          </a>
        </div>
         <?php endif; ?> 
         
      </li>
    <?php endif; ?>
     
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown"> </li>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventory-menu')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
          
          <?php echo e(__('label.Inventory')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
           
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-order-list')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('purchase-order')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.purchase order')); ?>

          </a>
           <a  href="<?php echo e(route('purchase-order.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('opening-inventory-entry')): ?>
         <div class="dropdown-divider"></div>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('opening-inventory-entry')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.openingInventory')); ?>

          </a>

          

          
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-list')): ?>
         <div class="dropdown-divider"></div>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('purchase')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_receive')); ?>

          </a>

          <a  href="<?php echo e(route('purchase.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>

          
        </div>
         <?php endif; ?>
          
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('purchase-return')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_return')); ?>

          </a>
           <a  href="<?php echo e(route('purchase-return.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('production-list')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('production')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.finished_goods_fabrication')); ?>

          </a>
           <a  href="<?php echo e(route('production.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('partical-production-receive')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('partical_production_receive_list')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.finished_goods_receive_to_stock')); ?>

          </a>
           <a  href="<?php echo e(url('partical-production-receive')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-list-wl')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('direct-sales')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.direct_sales')); ?>

          </a>
           <a  href="<?php echo e(route('direct-sales.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>

          </a>
        </div>
         <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_without_stock_deduct')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales_without_stock_deduct')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.sales_without_stock_deduct')); ?>

          </a>
           <a  href="<?php echo e(route('sales_without_stock_deduct.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>

          </a>
        </div>
         <?php endif; ?>
         
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('previous_bill_item_send')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('previous_bill_item_send')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.previous_bill_item_send')); ?>

          </a>
           <a  href="<?php echo e(route('previous_bill_item_send.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>

          </a>
        </div>
         <?php endif; ?>
         
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_return_wlm-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales_return_wlm')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.sales_return_wlm')); ?>

          </a>
           <a  href="<?php echo e(route('sales_return_wlm.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>  
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('security_deposits-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('security_deposits')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.security_deposits')); ?>

          </a>
           <a  href="<?php echo e(route('security_deposits.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>  
         
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('avaiable_product_list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('product_show')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.avaiable_product_list')); ?>

          </a>
          
        </div>
         <?php endif; ?>
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-order-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales-order')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.sales-order-list')); ?>

          </a>
          <a  href="<?php echo e(route('sales-order.create')); ?>" 
          class="dropdown-item text-right  "> 
            <i class="nav-icon fas fa-plus"></i> </a>
          </a>
        </div>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pos-sales-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.pos sales-list')); ?>

          </a>
           <a  href="<?php echo e(url('pos-sales')); ?>" class="dropdown-item text-right">
            <i class="fa fa-shopping-cart " style="color: green;margin-top: 9px;" aria-hidden="true"></i> 
          </a>
        </div>
         <?php endif; ?>
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_issue')); ?>

          </a>
           <a  href="<?php echo e(route('sales.create')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>

          </a>
        </div>
         <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.sales_form_two')); ?>

          </a>
           <a  href="<?php echo e(route('sales_form_two')); ?>" 
          class="dropdown-item text-right  " > 
            <i class="nav-icon fas fa-plus"></i> </a>

          </a>
        </div>
         <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('sales-return')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.issued_material_return')); ?>

          </a>
           <a  href="<?php echo e(route('sales-return.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('previous_sales_return-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('previous_sales_return')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.previous_sales_return')); ?>

          </a>
           <a  href="<?php echo e(route('previous_sales_return.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
      

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-issue-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('material-issue')); ?>" class="dropdown-item">
            <i class="fa fa-arrow-circle-right mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_issued')); ?>

          </a>
           <a  href="<?php echo e(route('material-issue.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-issue-return-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('material-issue-return')); ?>" class="dropdown-item">
            <i class="fa fa-arrow-circle-down mr-2" aria-hidden="true"></i> <?php echo e(__('label.material_issue_return')); ?>

          </a>
           <a  href="<?php echo e(route('material-issue-return.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
        
      
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-list')): ?>
         <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="<?php echo e(url('transfer')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.project_to_transfer')); ?>

          </a>
           <a  href="<?php echo e(route('transfer.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>

          
       
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('third-party-service-menu')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('third-party-service')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i><?php echo e(__('label.third-party-service-list')); ?>

          </a>
           <a  href="<?php echo e(route('third-party-service.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-manage-menu')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('warranty-manage')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.warranty-manage-list')); ?>

          </a>
           <a  href="<?php echo e(route('warranty-manage.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-replace-menu')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('item-replace')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i><?php echo e(__('label.item-replace-list')); ?>

          </a>
           <a  href="<?php echo e(route('item-replace.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>  

      
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('individual-replacement-menu')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('individual-replacement')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i><?php echo e(__('label.individual-replacement-list')); ?>

          </a>
           <a  href="<?php echo e(route('individual-replacement.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('w-item-receive-from-supp-menu')): ?>
          <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('w-item-receive-from-supp')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i><?php echo e(__('label.w-item-receive-from-supp-list')); ?>

          </a>
           <a  href="<?php echo e(route('w-item-receive-from-supp.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-module')): ?> 
         <div class="dropdown-divider"></div>
          <p style="text-align: center;"><b>Restaurant</b></p>

          <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-pos')): ?>
           <a href="<?php echo e(url('restaurant-pos')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i> <?php echo e(__('label.Restaurant POS')); ?>

          </a>
         
          <?php endif; ?>
        </div>
          <div class="dropdown-divider"></div>   
      
        <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-sales-list')): ?>
           <a href="<?php echo e(url('restaurant-sales')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i> <?php echo e(__('label.Restaurant Sales')); ?>

          </a>
          <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-sales-create')): ?>
           <a  href="<?php echo e(route('restaurant-sales.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
          <?php endif; ?>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kitchen-menu')): ?>
        <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kitchen-list')): ?>
           <a href="<?php echo e(url('kitchen')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i> Kitchen Panel
          </a>
          <?php endif; ?>
          </div>
        <?php endif; ?> 
          <?php endif; ?>

      </li>
    <?php endif; ?>
     
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import_module')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           RPL/LC <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
       <p style="padding-left: 20px;"><b><?php echo e(__('label.entry')); ?></b></p>
       <div class="dropdown-divider"></div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approval-chain-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('approval-chain.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.approval-chain')); ?>

          </a>
          <a  href="<?php echo e(route('approval-chain.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rlp-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('rlp.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.rlp-info')); ?>

          </a>
          <a  href="<?php echo e(route('rlp.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lc_manage-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('lc_manage.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.lc_manage')); ?>

          </a>
          <a  href="<?php echo e(route('lc_manage.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import-purchase-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('import-purchase.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.import-purchase')); ?>

          </a>
          <a  href="<?php echo e(route('import-purchase.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import-material-receive-list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('import-material-receive.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.import-material-receive')); ?>

          </a>
          <a  href="<?php echo e(route('import-material-receive.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset_import_cost_list')): ?>
         <div style="display: flex;">
         <a href="<?php echo e(route('asset_import_cost.index')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.asset_import_cost')); ?>

          </a>
          <a  href="<?php echo e(route('asset_import_cost.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
       
      </li>
    <?php endif; ?>
     
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown"> </li>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('DM_module')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
          
          <?php echo e(__('label.DM')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('damage')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.damage_adjustment')); ?>

          </a>
           <a  href="<?php echo e(route('damage.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage_receive-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('damage_receive')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.damage_receive')); ?>

          </a>
           <a  href="<?php echo e(route('damage_receive.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage_receive-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('damage_from_stocks')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.damage_from_stocks')); ?>

          </a>
           <a  href="<?php echo e(route('damage_from_stocks.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage_send-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('damage_send')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.damage_send')); ?>

          </a>
           <a  href="<?php echo e(route('damage_send.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage_report')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('damage_report')); ?>" class="dropdown-item">
            <i class="fa fa-recycle mr-2" aria-hidden="true"></i> <?php echo e(__('label.damage_report')); ?>

          </a>
           
        </div>
         <?php endif; ?>
          

      
         

      </li>
    <?php endif; ?>

    
       
   <li class="nav-item remove_from_header">
                   
           <a href="<?php echo e(url('report-panel')); ?>" class="nav-link custom_nav_item" title="Report">
           Report
          </a>
                </li>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventory-menu')): ?> 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
          
          <?php echo e(__('label.Master')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-type-list')): ?>
          <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('account-type')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Account Type')); ?>

          </a>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-group-list')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('account-group')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Account Group')); ?>

          </a>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('account-ledger')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.Account Ledger')); ?>

          </a>
          
           <a  href="<?php echo e(route('account-ledger.create')); ?>" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('group_wise_list?_type=cash')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label._cash_group')); ?>

          </a>
          
           <a  href="<?php echo e(route('group_wise_create')); ?>?_type=cash" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('group_wise_list?_type=bank')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label._bank_groups')); ?>

          </a>
          
           <a  href="<?php echo e(route('group_wise_create')); ?>?_type=bank" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('customer_list')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.customer_list')); ?>

          </a>
          
           <a  href="<?php echo e(route('customer_create')); ?>" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('group_wise_list?_type=supplier')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label._supplier_group')); ?>

          </a>
          
           <a  href="<?php echo e(route('group_wise_create')); ?>?_type=supplier" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('group_wise_list?_type=employee')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label._employee_group')); ?>

          </a>
          
           <a  href="<?php echo e(route('group_wise_create')); ?>?_type=employee" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-list')): ?>
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('group_wise_list?_type=honorarium')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label._honorarium_group')); ?>

          </a>
          
           <a  href="<?php echo e(route('group_wise_create')); ?>?_type=honorarium" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>


          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-category-list')): ?>
        <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="<?php echo e(url('item-category')); ?>" class="dropdown-item">
            <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.Item Category')); ?>

          </a>
           <a   
           class="dropdown-item text-right " 
               
               href="<?php echo e(route('item-category.create')); ?>"
                >
            <i class="nav-icon fas fa-plus"></i>
          </a>

        </div>
          
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-brand-list')): ?>
          <div class="dropdown-divider"></div>
              <div style="display: flex;">
                 <a href="<?php echo e(url('item-brand')); ?>" class="dropdown-item">
                  <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.item_brand')); ?>

                </a>
                <a  class="dropdown-item text-right "  href="<?php echo e(route('item-brand.create')); ?>" ><i class="nav-icon fas fa-plus"></i></a>
              </div>
          
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pack-size-list')): ?>
          <div class="dropdown-divider"></div>
              <div style="display: flex;">
                 <a href="<?php echo e(url('pack-size')); ?>" class="dropdown-item">
                  <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.pack_size')); ?>

                </a>
                <a  class="dropdown-item text-right "  href="<?php echo e(route('pack-size.create')); ?>" ><i class="nav-icon fas fa-plus"></i></a>
              </div>
          
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-list')): ?>
          <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('unit')); ?>" class="dropdown-item">
            <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.Unit Of Measurment')); ?>

          </a>
          <a   
           class="dropdown-item text-right " 
               
               href="<?php echo e(route('unit.create')); ?>"
                >
            <i class="nav-icon fas fa-plus"></i>
          </a>

        </div>
          
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-list')): ?>
          <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
           <a href="<?php echo e(url('warranty')); ?>" class="dropdown-item">
            <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.Warranty')); ?>

          </a>
           <a 
           class="dropdown-item text-right " 
               href="<?php echo e(route('warranty.create')); ?>"
                >
            <i class="nav-icon fas fa-plus"></i>
          </a>
          
        </div>
          
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('budgets-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('budgets')); ?>" class="dropdown-item">
            <i class="fas fa-store   mr-2"></i><?php echo e(__('label.budgets')); ?>

          </a>
          <a  href="<?php echo e(route('budgets.create')); ?>"
          class="dropdown-item text-right "> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
         <?php endif; ?>
         
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transection_terms-list')): ?>
           <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('transection_terms')); ?>" class="dropdown-item">
            <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.Transection Terms')); ?>

          </a>
          <a  
           class="dropdown-item text-right " 
               
               href="<?php echo e(route('transection_terms.create')); ?>"
                >
            <i class="nav-icon fas fa-plus"></i>
          </a>
          

        </div>
          
         <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vat-rules-list')): ?>
           <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('vat-rules')); ?>" class="dropdown-item">
            <i class="fa fa-laptop mr-2" aria-hidden="true"></i><?php echo e(__('label.Vat Rules')); ?>

          </a>
           <a 
           class="dropdown-item text-right " 
              
               href="<?php echo e(route('vat-rules.create')); ?>"
                >
            <i class="nav-icon fas fa-plus"></i>
          </a>
          
        </div>
          
         <?php endif; ?>
         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-information-list')): ?>
        <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('item-information')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Item Information')); ?>

          </a>
           <a  
           class="dropdown-item text-right " 
                
               href="<?php echo e(route('item-information.create')); ?>"
                >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('musak-four-point-three-menu')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('musak-four-point-three-list')): ?>
           <a href="<?php echo e(url('musak-four-point-three')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i> Item Wise Ingredients
          </a>
          <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('musak-four-point-three-create')): ?>
           <a  href="<?php echo e(route('musak-four-point-three.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
          <?php endif; ?>
        </div>
         <?php endif; ?> 
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lot-item-information')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('lot-item-information')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Lot Item Information')); ?>

          </a>
           
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lot-item-information')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('cylinder_product')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.cylinder_product')); ?>

          </a>
           
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('labels-print')): ?>
         <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('labels-print')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Labels Print')); ?>

          </a>
           
        </div>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vessel-info-list')): ?>
         <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('vessel-info')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.vessel-info')); ?>

          </a>
           
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('mother-vessel-info-list')): ?>
         <div class="dropdown-divider"></div> 
        <div style="display: flex;">
           <a href="<?php echo e(url('mother-vessel-info')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.mother-vessel-info')); ?>

          </a>
           
        </div>
         <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restaurant-module')): ?> 
          <p style="text-align: center;margin-bottom: 1px solid #000;"><b>Resturant Module</b></p>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('table-info-menu')): ?>
        <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('table-info-list')): ?>
           <a href="<?php echo e(url('table-info')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i> Table Information
          </a>
          <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('table-info-create')): ?>
           <a  href="<?php echo e(route('table-info.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
          <?php endif; ?>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('steward-waiter-menu')): ?>
          <div class="dropdown-divider"></div>   
        <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('steward-waiter-list')): ?>
           <a href="<?php echo e(url('steward-waiter')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i> Steward Waiter Setup
          </a>
          <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('steward-waiter-create')): ?>
           <a  href="<?php echo e(route('steward-waiter.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
          <?php endif; ?>
        </div>
         <?php endif; ?> 
       
       
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-allocation-list')): ?>
        <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-allocation-list')): ?>
           <a href="<?php echo e(url('category-allocation')); ?>" class="dropdown-item">
            <i class="fa fa-table mr-2" aria-hidden="true"></i>Pos Dispaly Category 
          </a>
          <?php endif; ?>
           
        </div>
          <?php endif; ?>
    <?php endif; ?>  
      </li>
    <?php endif; ?>
      
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
          
          <?php echo e(__('label.Settings')); ?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-settings')): ?>
          <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('admin-settings')); ?>" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> <?php echo e(__('label.General Settings')); ?>

          </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bulk-sms')): ?>
          <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('sms-send')); ?>" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> <?php echo e(__('label.SMS SEND')); ?>

          </a>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoice-prefix')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('invoice-prefix')); ?>" class="dropdown-item">
            <i class="fas fa-cog    mr-2"></i><?php echo e(__('label.Invoice Prefix')); ?>

          </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('roles')); ?>" class="dropdown-item">
          <i class="fa fa-server  mr-2" aria-hidden="true"></i><?php echo e(__('label.Roles')); ?>

          </a>
           <a   
          class="dropdown-item text-right "
            href="<?php echo e(route('roles.create')); ?>"> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
          
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
         <a href="<?php echo e(url('users')); ?>" class="dropdown-item">
            <i class="fas fa-users  mr-2"></i> <?php echo e(__('label.Users')); ?>

          </a>
          <a    
          class="dropdown-item text-right "
            href="<?php echo e(route('users.create')); ?>"> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
          
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('security_deposits-list')): ?>
         <div class="dropdown-divider"></div>  
          
        <div style="display: flex;">
           <a href="<?php echo e(url('security_deposits')); ?>" class="dropdown-item">
            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo e(__('label.security_deposits')); ?>

          </a>
           <a  href="<?php echo e(route('security_deposits.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('companies-list')): ?>
        <div style="display: flex;">
         <a href="<?php echo e(url('companies')); ?>" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> <?php echo e(__('label.companies')); ?>

          </a>
          <a  href="<?php echo e(route('companies.create')); ?>" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('branch-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('branch')); ?>" class="dropdown-item">
            <i class="fa fa-share-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Branch')); ?> 
          </a>
           <a  
          class="dropdown-item text-right "
            href="<?php echo e(route('branch.create')); ?>"> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
         
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost-center-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('cost-center')); ?>" class="dropdown-item">
           <i class="fa fa-adjust mr-2" aria-hidden="true"></i> <?php echo e(__('label.Cost center')); ?> 
          </a>
            <a  
          class="dropdown-item text-right "
            href="<?php echo e(route('cost-center.create')); ?>"> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-house-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('store-house')); ?>" class="dropdown-item">
           <i class="fa fa-adjust mr-2" aria-hidden="true"></i> Store House
          </a>
            <a    
          class="dropdown-item text-right "
            href="<?php echo e(route('store-house.create')); ?>"> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
          
         <?php endif; ?>
         <?php endif; ?>
         
         
       
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('budgets-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('budgets')); ?>" class="dropdown-item">
            <i class="fas fa-store   mr-2"></i><?php echo e(__('label.budgets')); ?>

          </a>
          <a  href="<?php echo e(route('budgets.create')); ?>"
          class="dropdown-item text-right "> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('countries_list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('countries')); ?>" class="dropdown-item">
            <i class="fas fa-store   mr-2"></i><?php echo e(__('label.countries')); ?>

          </a>
          <a  href="<?php echo e(route('countries.create')); ?>"
          class="dropdown-item text-right "> 
            <i class="nav-icon fas fa-plus"></i> </a>
        </div>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account_group_configs')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('account_group_configs')); ?>" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i><?php echo e(__('label.account_group_configs')); ?>

          </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock-permission')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('all-lock')); ?>" class="dropdown-item">
            <i class="fas fa-lock _required   mr-2"></i><?php echo e(__('label.Transection Lock System')); ?>

          </a>
        </div>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('documents-list')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('documents')); ?>" class="dropdown-item">
            <i class="fa fa-file    mr-2"></i><?php echo e(__('label.documents')); ?>

          </a>
        </div>
         <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('database-backup')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('databaseBackup')); ?>" class="dropdown-item">
            <i class="fa fa-database    mr-2"></i><?php echo e(__('label.Data Backup')); ?>

          </a>
        </div>
         <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('database-backup')): ?>
         <div class="dropdown-divider"></div>
        <div style="display: flex;">
          <a href="<?php echo e(url('clear-cache')); ?>" class="dropdown-item">
            <i class="fa fa-database    mr-2"></i>Cache Clear
          </a>
        </div>
         <?php endif; ?>
        
        
              
              
      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">User Name :  <b><?php echo e(Auth::user()->name ?? ''); ?></b></span>
          <div class="dropdown-divider"></div>
          <div class="text-center">
             <a href="<?php echo e(url('user-profile')); ?>"><?php echo e(__('label.profile')); ?></a>
          </div>
        <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" 
                        href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  <?php echo e(__('Logout')); ?>

                </a>


                  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                  </form>
             
          <div class="dropdown-divider"></div>
          
        </div>
      </li>
      <li class="nav-item">
        <a  class="nav-link full_screen_show" data-widget="fullscreen" href="#" role="button" >
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/layouts/navbar.blade.php ENDPATH**/ ?>