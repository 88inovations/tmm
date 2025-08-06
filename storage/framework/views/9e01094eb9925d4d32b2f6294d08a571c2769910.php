
<?php $__env->startSection('title',$page_name ?? ''); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/new_style.css')); ?>">
<style type="text/css">
    .report_link{
        font-size: 16px;
        padding-top: 7px;
        border-bottom: 1px solid silver;
    }
    .dropdown-item{
      font-weight: bold;
      font-size: 16px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
$__user= Auth::user();
?>

    <div class="content">
      <div class="container">
   <h2 class="text-center _page_name"><?php echo $page_name ?? ''; ?></h2>
    <div class="container   " >
        <div class="row  ">
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-report-menu')): ?> 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center"><?php echo e(__('label.account_report')); ?></h4>
                        <div class="dropdown-divider"></div>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('day-book')): ?>
          
          <a href="<?php echo e(url('day-book')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Day Book')); ?>

          </a>
         <?php endif; ?>
          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-book')): ?>
           
          <a href="<?php echo e(url('cash-book')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Cash Book')); ?>

          </a>
         <?php endif; ?>
          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-book')): ?>
           
          <a href="<?php echo e(url('bank-book')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Bank Book')); ?>

          </a>
         <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('receipt-payment')): ?>
          <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('receipt-payment')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Receipt & Payment')); ?>

          </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger-report')): ?>
         
          <a href="<?php echo e(url('ledger-report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Ledger Report')); ?>

          </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('group_wise_ledger_list')): ?>
         
          <a href="<?php echo e(url('group_wise_ledger_list')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.group_wise_ledger_list')); ?>

          </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger-report')): ?>
         
          <a href="<?php echo e(url('ledger_report_with_item_detail')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.ledger_report_with_item_detail')); ?>

          </a>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger_report_foreign')): ?>
          
          <a href="<?php echo e(url('filter-report-foreign_amount')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>Ledger Report[Foreign Amount] 
          </a>
         <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('single_customer_statement')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('single_customer_statement')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.single_customer_statement')); ?>

          </a>
         <?php endif; ?>

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_collection_report')): ?>
         
          <a href="<?php echo e(url('sales_collection_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.sales_collection_report')); ?>

          </a>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_due_statement')): ?>
       
          <a href="<?php echo e(url('customer_due_statement')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.customer_due_statement')); ?>

          </a>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('final_due_statement')): ?>
        
          <a href="<?php echo e(url('final_due_statement')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.final_due_statement')); ?>

          </a>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_statement')): ?>
         
          <a href="<?php echo e(url('customer_statement')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.customer_statement')); ?>

          </a>
         <?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date_to_date_sales_amount_report')): ?>
         
          <a href="<?php echo e(url('date_to_date_sales_amount_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_sales_amount_report')); ?>

          </a>
<?php endif; ?>


         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('group-ledger')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('group-ledger')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.Group Ledger Report')); ?>

          </a>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ledger-summary-report')): ?>
       
          <a href="<?php echo e(url('filter-ledger-summary')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>  <?php echo e(__('label.Ledger Summary Report')); ?>

          </a>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('group_sub_group_summary_report')): ?>
        
          <a href="<?php echo e(url('group_sub_group_summary_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>  <?php echo e(__('label.group_sub_group_summary_report')); ?>

          </a>
<?php endif; ?>
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('outstanding_detail_report')): ?>
         
          <a href="<?php echo e(url('outstanding_detail_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.outstanding_detail_report')); ?>

          </a>
         <?php endif; ?>


          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payable_receivalbe_report')): ?>
        
          <a href="<?php echo e(url('payable_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.payable_report')); ?>

          </a>
<?php endif; ?>



        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('month_wise_sallary_sheet')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('month_wise_sallary_sheet')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.month_wise_sallary_sheet')); ?>

          </a>
         <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorarium_bill_sheet')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('honorarium_bill_sheet')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.honorarium_bill_sheet')); ?>

          </a>
         <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income-statement')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('reports/income-expense')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.income_expense_summary')); ?> </a>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income-statement')): ?>
        
          <a href="<?php echo e(url('income-statement')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.Income Statement')); ?>

          </a>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advance_income_statement')): ?>
         
          <a href="<?php echo e(url('advance_income_statement')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.advance_income_statement')); ?>

          </a>
         <?php endif; ?>
         
        

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-history')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('filter-voucher-history')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>  <?php echo e(__('label.filter-voucher-history')); ?>

          </a>
<?php endif; ?>
 
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('balance-sheet')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('balance-sheet')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.Balance Sheet')); ?>

          </a>
         <?php endif; ?> 
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('general_balance-sheet')): ?>
        
          <a href="<?php echo e(url('general_balance-sheet')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> General Balance Sheet
          </a>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advance_balance_sheet')): ?>
       
          <a href="<?php echo e(url('advance_balance_sheet')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> Balance Sheet [Advance]
          </a>
         <?php endif; ?> 

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('trail-balance')): ?>
         <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('trail-balance')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Trail Balance')); ?>

          </a>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work-sheet')): ?>
         
          <a href="<?php echo e(url('work-sheet')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.Work Sheet')); ?>

          </a>
         <?php endif; ?>
      
        
         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('chart-of-account')): ?>
       
          <a href="<?php echo e(url('chart-of-account')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('label.Chart of Account')); ?>

          </a>
         <?php endif; ?>  
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('chart-of-ledger')): ?>
        
          <a href="<?php echo e(url('chart-of-ledger')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> <?php echo e(__('Chart of Ledger')); ?>

          </a>
         <?php endif; ?>  
             
                   </div>
                </div>
                <?php endif; ?>



                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventory-report')): ?> 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center"><?php echo e(__('label.inventory_report')); ?></h4>
                   
     
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('day-wise-summary-report')): ?>
        <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('day-wise-summary-report')); ?>" class="dropdown-item">
            <i class="fa fa-file mr-2" aria-hidden="true"></i>Work Period Sales Summary Report 
          </a>
        </div>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-sales-report')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('item-sales-report')); ?>" class="dropdown-item">
            <i class="fa fa-file mr-2" aria-hidden="true"></i>Item Sales Report 
          </a>
        </div>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('detail-item-sales-report')): ?>
        
        <div style="display: flex;">
           <a href="<?php echo e(url('detail-item-sales-report')); ?>" class="dropdown-item">
            <i class="fa fa-file mr-2" aria-hidden="true"></i>Detail Item Sales Report 
          </a>
        </div>
           <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-wise-item-list')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('category-wise-item-list')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.category-wise-item-list')); ?>

          </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('warranty-check')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('warranty-check')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.warranty-check')); ?>

          </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('branch_wise_sales_statement')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('branch_wise_sales_statement')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.branch_wise_sales_statement')); ?>

          </a>
        </div>
         <?php endif; ?>

         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('branch_wise_item_sales_return_summary')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('branch_wise_item_sales_return_summary')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.branch_wise_item_sales_return_summary')); ?>

          </a>
        </div>
         <?php endif; ?>

         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('branch_wise_item_sales_return_details')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('branch_wise_item_sales_return_details')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.branch_wise_item_sales_return_details')); ?>

          </a>
        </div>
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('branch_and_customer_wise_s_r')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('branch_and_customer_wise_s_r')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.branch_and_customer_wise_s_r')); ?>

          </a>
        </div>
         <?php endif; ?>

         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transection_terms_wise_sales_report')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('transection_terms_wise_sales_report')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.transection_terms_wise_sales_report')); ?>

          </a>
        </div>
         <?php endif; ?>
         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bill-party-statement')): ?>
          
           <div style="display: flex;">
           <a href="<?php echo e(url('bill-party-statement')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Bill of Supplier Statement')); ?>

          </a>
        </div>
         <?php endif; ?>
         <div class="dropdown-divider"></div>
          
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-purchase')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('date-wise-purchase')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Date Wise Purchase')); ?>

          </a>
        </div>
         
         <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-purchase')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('date_to_date_purchases_detail')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_purchases_detail')); ?>

          </a>
        </div>
         <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-purchase')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('date_to_date_purchases_item_detail')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_purchases_item_detail')); ?>

          </a>
        </div>
         <?php endif; ?>
         
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-purchase')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('date_to_date_purchases_item_summary')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_purchases_item_summary')); ?>

          </a>
        </div>
         
         <?php endif; ?>
         
    
           
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-return-detail')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('purchase-return-detail')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Purchase Return Detail')); ?>

          </a>
        </div>
         <?php endif; ?> 
         
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
       <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="<?php echo e(url('date-wise-sales')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Date Wise Sales')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
     
        <div style="display: flex;">
           <a href="<?php echo e(url('date_to_date_sales_detail')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_sales_detail')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
      
        <div style="display: flex;">
           <a href="<?php echo e(url('date_to_date_sales_item_detail')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_sales_item_detail')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-sales')): ?>
       
        <div style="display: flex;">
           <a href="<?php echo e(url('date_to_date_sales_item_summary')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.date_to_date_sales_item_summary')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('actual-sales-report')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('filter-actual-sales')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.actual-sales-report')); ?>

          </a>
        </div>
         <?php endif; ?> 

       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-restaurant-sales')): ?>
        <div style="display: flex;">
       <div class="dropdown-divider"></div>  
           <a href="<?php echo e(url('date-wise-restaurant-sales')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Date Wise Restaurant Sales')); ?>

          </a>
        </div>
         <?php endif; ?> 
          
      
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-return-detail')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('sales-return-detail')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> <?php echo e(__('label.Sales Return Details')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-possition')): ?>
         <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="<?php echo e(url('stock-possition')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Stock Possition')); ?>

          </a>
        </div>
         <?php endif; ?>  
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-possition')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('over_all_stock_possition')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>Over all Stock Possition Report
          </a>
        </div>
         <?php endif; ?> 
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-ledger')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('stock-ledger')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Stock Ledger')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-ledger')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('single-stock-ledger')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.single-stock-ledger')); ?>

          </a>
        </div>
         <?php endif; ?> 
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-value')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('stock-value')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Stock Value')); ?>

          </a>
        </div>
         <?php endif; ?> 
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-balance')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('stock-balance')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('Stock Balance Report')); ?>

          </a>
        </div>
         <?php endif; ?> 
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-value-register')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('stock-value-register')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Stock Value Register')); ?>

          </a>
        </div>
         <?php endif; ?> 
          
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gross-profit')): ?>
       <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="<?php echo e(url('gross-profit')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Gross Profit')); ?>

          </a>
        </div>
         <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expired-item')): ?>
         <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="<?php echo e(url('expired-item')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Expired Item')); ?>

          </a>
        </div>
         <?php endif; ?>   
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('shortage-item')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('shortage-item')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Shortage Item')); ?>

          </a>
        </div>
         <?php endif; ?>  
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('barcode-history')): ?>
        <div style="display: flex;">
           <a href="<?php echo e(url('barcode-history')); ?>" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo e(__('label.Barcode History')); ?>

          </a>
        </div>
      <?php endif; ?> 
         
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-wise-collection-payment')): ?>
      <div class="dropdown-divider"></div>
          <a href="<?php echo e(url('user-wise-collection-payment')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.User Wise Collection Payment')); ?>

          </a>
      <?php endif; ?>
          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-invoice-print')): ?>
           
          <a href="<?php echo e(url('date-wise-invoice-print')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Date Wise Invoice Print')); ?>

          </a>
         <?php endif; ?>
        
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('date-wise-restaurant-invoice-print')): ?>
           
          <a href="<?php echo e(url('date-wise-restaurant-invoice-print')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Date Wise Restaurant Invoice Print')); ?>

          </a>
         <?php endif; ?>
          
       
          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_man_wise_sales_detail')): ?>
          
          <a href="<?php echo e(url('sales_man_wise_sales_detail')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.sales_man_wise_sales_detail')); ?> </a>
         <?php endif; ?>
          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-man-invoice')): ?>
          
          <a href="<?php echo e(url('sales-man-invoice')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Sales Man Invoice')); ?> </a>
         <?php endif; ?>
          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delivery-man-sales-invoice')): ?>
           
          <a href="<?php echo e(url('delivery-man-sales-invoice')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.Delivery Man Sales Invoice')); ?> </a>
         <?php endif; ?>
     
                            </div>
                        </div>
                <?php endif; ?>


                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('damage_report')): ?> 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center"><?php echo e(__('label.damage_report')); ?></h4>
                   
     
           <div class="dropdown-divider"></div>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dm_item_ledger')): ?>
           
          <a href="<?php echo e(url('dm_item_ledger')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.dm_item_ledger')); ?> </a>
         <?php endif; ?>

          
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dm_item_stock_possition')): ?>
           
          <a href="<?php echo e(url('dm_item_stock_possition')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.dm_item_stock_possition')); ?> </a>
         <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dm_item_stock_value')): ?>
           
          <a href="<?php echo e(url('dm_item_stock_value')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.dm_item_stock_value')); ?> </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dm_receive_from_customer')): ?>
           
          <a href="<?php echo e(url('dm_receive_from_customer')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.dm_receive_from_customer')); ?> </a>
         <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dm_receive_from_stock')): ?>
           
          <a href="<?php echo e(url('dm_receive_from_stock')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.dm_receive_from_stock')); ?> </a>
         <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dm_send_to_supplier')): ?>
           
          <a href="<?php echo e(url('dm_send_to_supplier')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.dm_send_to_supplier')); ?> </a>
         <?php endif; ?>

                            </div>
                        </div>
                <?php endif; ?>


                <!-- Asset Management Report -->

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset-management-report')): ?>




<?php endif; ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stm_report_section')): ?>
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center"><?php echo e(__('label.stm_report_section')); ?></h4>
                   
     
           <div class="dropdown-divider"></div>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('division_class_student_report')): ?>
           
          <a href="<?php echo e(route('division_class_student_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.division_class_student_report')); ?> </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('division_class_collection_report')): ?>
           
          <a href="<?php echo e(route('division_class_collection_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.division_class_collection_report')); ?> </a>
         <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('division_class_collection_status_report')): ?>
           
          <a href="<?php echo e(route('division_class_collection_status_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.division_class_collection_status_report')); ?> </a>
         <?php endif; ?>

         
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_ledger_report')): ?>
           
          <a href="<?php echo e(route('student_ledger_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.student_ledger_report')); ?> </a>
         <?php endif; ?>

         
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('month_wise_payment_status_report')): ?>
           
          <a href="<?php echo e(route('month_wise_payment_status_report')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.month_wise_payment_status_report')); ?> </a>
         <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('monthly_fee_collection_ledger')): ?>
           
          <a href="<?php echo e(route('monthly_class_wise_fee_collection_ledger')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.monthly_class_wise_fee_collection_ledger')); ?> </a>
         <?php endif; ?>

           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stmd_monthly_income_expense_compare')): ?>
           
          <a href="<?php echo e(url('reports/income-expense')); ?>" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i><?php echo e(__('label.income_expense_summary')); ?> </a>
         <?php endif; ?>

          

                            </div>
                        </div>
 


<?php endif; ?>

    
    
</div>
</div>
</div>
    
    </div>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/report-panel/dashboard.blade.php ENDPATH**/ ?>