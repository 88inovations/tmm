@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
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
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp

    <div class="content">
      <div class="container">
   <h2 class="text-center _page_name">{!! $page_name ?? '' !!}</h2>
    <div class="container   " >
        <div class="row  ">
                 @can('account-report-menu') 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center">{{__('label.account_report')}}</h4>
                        <div class="dropdown-divider"></div>
         @can('day-book')
          
          <a href="{{url('day-book')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Day Book') }}
          </a>
         @endcan
          
           @can('cash-book')
           
          <a href="{{url('cash-book')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Cash Book') }}
          </a>
         @endcan
          
           @can('bank-book')
           
          <a href="{{url('bank-book')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Bank Book') }}
          </a>
         @endcan

           @can('receipt-payment')
          <div class="dropdown-divider"></div>
          <a href="{{url('receipt-payment')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Receipt & Payment') }}
          </a>
         @endcan
           @can('ledger-report')
         
          <a href="{{url('ledger-report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Ledger Report') }}
          </a>
         @endcan
           @can('group_wise_ledger_list')
         
          <a href="{{url('group_wise_ledger_list')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.group_wise_ledger_list') }}
          </a>
         @endcan
           @can('ledger-report')
         
          <a href="{{url('ledger_report_with_item_detail')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.ledger_report_with_item_detail') }}
          </a>
         @endcan
          @can('ledger_report_foreign')
          
          <a href="{{url('filter-report-foreign_amount')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>Ledger Report[Foreign Amount] 
          </a>
         @endcan
          @can('single_customer_statement')
         <div class="dropdown-divider"></div>
          <a href="{{url('single_customer_statement')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.single_customer_statement') }}
          </a>
         @endcan

         @can('sales_collection_report')
         
          <a href="{{url('sales_collection_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.sales_collection_report') }}
          </a>
         @endcan
         @can('customer_due_statement')
       
          <a href="{{url('customer_due_statement')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.customer_due_statement') }}
          </a>
         @endcan
         @can('final_due_statement')
        
          <a href="{{url('final_due_statement')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.final_due_statement') }}
          </a>
         @endcan
         @can('customer_statement')
         
          <a href="{{url('customer_statement')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.customer_statement') }}
          </a>
         @endcan
@can('date_to_date_sales_amount_report')
         
          <a href="{{url('date_to_date_sales_amount_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_sales_amount_report') }}
          </a>
@endcan


         
        @can('group-ledger')
         <div class="dropdown-divider"></div>
          <a href="{{url('group-ledger')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.Group Ledger Report') }}
          </a>
         @endcan
        @can('ledger-summary-report')
       
          <a href="{{url('filter-ledger-summary')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>  {{ __('label.Ledger Summary Report') }}
          </a>
         @endcan
         @can('group_sub_group_summary_report')
        
          <a href="{{url('group_sub_group_summary_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>  {{ __('label.group_sub_group_summary_report') }}
          </a>
@endcan
 @can('outstanding_detail_report')
         
          <a href="{{url('outstanding_detail_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.outstanding_detail_report') }}
          </a>
         @endcan


          @can('payable_receivalbe_report')
        
          <a href="{{url('payable_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.payable_report') }}
          </a>
@endcan



        @can('month_wise_sallary_sheet')
         <div class="dropdown-divider"></div>
          <a href="{{url('month_wise_sallary_sheet')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.month_wise_sallary_sheet') }}
          </a>
         @endcan

        @can('honorarium_bill_sheet')
         <div class="dropdown-divider"></div>
          <a href="{{url('honorarium_bill_sheet')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.honorarium_bill_sheet') }}
          </a>
         @endcan

        @can('income-statement')
         <div class="dropdown-divider"></div>
          <a href="{{url('reports/income-expense')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.income_expense_summary') }} </a>
         @endcan
        @can('income-statement')
        
          <a href="{{url('income-statement')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.Income Statement') }}
          </a>
         @endcan
         @can('advance_income_statement')
         
          <a href="{{url('advance_income_statement')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.advance_income_statement') }}
          </a>
         @endcan
         
        

@can('voucher-history')
         <div class="dropdown-divider"></div>
          <a href="{{url('filter-voucher-history')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>  {{ __('label.filter-voucher-history') }}
          </a>
@endcan
 
      @can('balance-sheet')
         <div class="dropdown-divider"></div>
          <a href="{{url('balance-sheet')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.Balance Sheet') }}
          </a>
         @endcan 
      @can('general_balance-sheet')
        
          <a href="{{url('general_balance-sheet')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> General Balance Sheet
          </a>
         @endcan 
         @can('advance_balance_sheet')
       
          <a href="{{url('advance_balance_sheet')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> Balance Sheet [Advance]
          </a>
         @endcan 

        @can('trail-balance')
         <div class="dropdown-divider"></div>
          <a href="{{url('trail-balance')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Trail Balance') }}
          </a>
         @endcan
        @can('work-sheet')
         
          <a href="{{url('work-sheet')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.Work Sheet') }}
          </a>
         @endcan
      
        
         
        @can('chart-of-account')
       
          <a href="{{url('chart-of-account')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('label.Chart of Account') }}
          </a>
         @endcan  
        @can('chart-of-ledger')
        
          <a href="{{url('chart-of-ledger')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i> {{ __('Chart of Ledger') }}
          </a>
         @endcan  
             
                   </div>
                </div>
                @endcan



                 @can('inventory-report') 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center">{{__('label.inventory_report')}}</h4>
                   
     
          @can('day-wise-summary-report')
        <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="{{url('day-wise-summary-report')}}" class="dropdown-item">
            <i class="fa fa-file mr-2" aria-hidden="true"></i>Work Period Sales Summary Report 
          </a>
        </div>
        @endcan
         @can('item-sales-report')
        <div style="display: flex;">
           <a href="{{url('item-sales-report')}}" class="dropdown-item">
            <i class="fa fa-file mr-2" aria-hidden="true"></i>Item Sales Report 
          </a>
        </div>
         @endcan
         @can('detail-item-sales-report')
        
        <div style="display: flex;">
           <a href="{{url('detail-item-sales-report')}}" class="dropdown-item">
            <i class="fa fa-file mr-2" aria-hidden="true"></i>Detail Item Sales Report 
          </a>
        </div>
           @endcan
        @can('category-wise-item-list')
          
           <div style="display: flex;">
           <a href="{{url('category-wise-item-list')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.category-wise-item-list') }}
          </a>
        </div>
         @endcan
        @can('warranty-check')
          
           <div style="display: flex;">
           <a href="{{url('warranty-check')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.warranty-check') }}
          </a>
        </div>
         @endcan
        @can('branch_wise_sales_statement')
          
           <div style="display: flex;">
           <a href="{{url('branch_wise_sales_statement')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.branch_wise_sales_statement') }}
          </a>
        </div>
         @endcan

         
        @can('branch_wise_item_sales_return_summary')
          
           <div style="display: flex;">
           <a href="{{url('branch_wise_item_sales_return_summary')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.branch_wise_item_sales_return_summary') }}
          </a>
        </div>
         @endcan

         
        @can('branch_wise_item_sales_return_details')
          
           <div style="display: flex;">
           <a href="{{url('branch_wise_item_sales_return_details')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.branch_wise_item_sales_return_details') }}
          </a>
        </div>
         @endcan
        @can('branch_and_customer_wise_s_r')
          
           <div style="display: flex;">
           <a href="{{url('branch_and_customer_wise_s_r')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.branch_and_customer_wise_s_r') }}
          </a>
        </div>
         @endcan

         
        @can('transection_terms_wise_sales_report')
          
           <div style="display: flex;">
           <a href="{{url('transection_terms_wise_sales_report')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.transection_terms_wise_sales_report') }}
          </a>
        </div>
         @endcan
         
        @can('bill-party-statement')
          
           <div style="display: flex;">
           <a href="{{url('bill-party-statement')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Bill of Supplier Statement') }}
          </a>
        </div>
         @endcan
         <div class="dropdown-divider"></div>
          
        @can('date-wise-purchase')
        <div style="display: flex;">
           <a href="{{url('date-wise-purchase')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Date Wise Purchase') }}
          </a>
        </div>
         
         @endcan
        @can('date-wise-purchase')
        <div style="display: flex;">
           <a href="{{url('date_to_date_purchases_detail')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_purchases_detail') }}
          </a>
        </div>
         @endcan

        @can('date-wise-purchase')
        <div style="display: flex;">
           <a href="{{url('date_to_date_purchases_item_detail')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_purchases_item_detail') }}
          </a>
        </div>
         @endcan
         
        @can('date-wise-purchase')
        <div style="display: flex;">
           <a href="{{url('date_to_date_purchases_item_summary')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_purchases_item_summary') }}
          </a>
        </div>
         
         @endcan
         
    
           
       @can('purchase-return-detail')
        <div style="display: flex;">
           <a href="{{url('purchase-return-detail')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Purchase Return Detail') }}
          </a>
        </div>
         @endcan 
         
       @can('date-wise-sales')
       <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="{{url('date-wise-sales')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Date Wise Sales') }}
          </a>
        </div>
         @endcan 
       @can('date-wise-sales')
     
        <div style="display: flex;">
           <a href="{{url('date_to_date_sales_detail')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_sales_detail') }}
          </a>
        </div>
         @endcan 
       @can('date-wise-sales')
      
        <div style="display: flex;">
           <a href="{{url('date_to_date_sales_item_detail')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_sales_item_detail') }}
          </a>
        </div>
         @endcan 
       @can('date-wise-sales')
       
        <div style="display: flex;">
           <a href="{{url('date_to_date_sales_item_summary')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.date_to_date_sales_item_summary') }}
          </a>
        </div>
         @endcan 
       @can('actual-sales-report')
        <div style="display: flex;">
           <a href="{{url('filter-actual-sales')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.actual-sales-report') }}
          </a>
        </div>
         @endcan 

       @can('date-wise-restaurant-sales')
        <div style="display: flex;">
       <div class="dropdown-divider"></div>  
           <a href="{{url('date-wise-restaurant-sales')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Date Wise Restaurant Sales') }}
          </a>
        </div>
         @endcan 
          
      
          
       @can('sales-return-detail')
        <div style="display: flex;">
           <a href="{{url('sales-return-detail')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Sales Return Details') }}
          </a>
        </div>
         @endcan 
       @can('stock-possition')
         <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="{{url('stock-possition')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Stock Possition') }}
          </a>
        </div>
         @endcan  
       @can('stock-possition')
        <div style="display: flex;">
           <a href="{{url('over_all_stock_possition')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>Over all Stock Possition Report
          </a>
        </div>
         @endcan 
          
       @can('stock-ledger')
        <div style="display: flex;">
           <a href="{{url('stock-ledger')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Stock Ledger') }}
          </a>
        </div>
         @endcan 
       @can('stock-ledger')
        <div style="display: flex;">
           <a href="{{url('single-stock-ledger')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.single-stock-ledger') }}
          </a>
        </div>
         @endcan 
          
       @can('stock-value')
        <div style="display: flex;">
           <a href="{{url('stock-value')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Stock Value') }}
          </a>
        </div>
         @endcan 
       @can('stock-balance')
        <div style="display: flex;">
           <a href="{{url('stock-balance')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('Stock Balance Report') }}
          </a>
        </div>
         @endcan 
          
       @can('stock-value-register')
        <div style="display: flex;">
           <a href="{{url('stock-value-register')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Stock Value Register') }}
          </a>
        </div>
         @endcan 
          
       @can('gross-profit')
       <div class="dropdown-divider"></div>
        <div style="display: flex;">
           <a href="{{url('gross-profit')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Gross Profit') }}
          </a>
        </div>
         @endcan
       @can('expired-item')
         <div class="dropdown-divider"></div>  
        <div style="display: flex;">
           <a href="{{url('expired-item')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Expired Item') }}
          </a>
        </div>
         @endcan   
       @can('shortage-item')
        <div style="display: flex;">
           <a href="{{url('shortage-item')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Shortage Item') }}
          </a>
        </div>
         @endcan  
      @can('barcode-history')
        <div style="display: flex;">
           <a href="{{url('barcode-history')}}" class="dropdown-item">
            <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Barcode History') }}
          </a>
        </div>
      @endcan 
         
      @can('user-wise-collection-payment')
      <div class="dropdown-divider"></div>
          <a href="{{url('user-wise-collection-payment')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.User Wise Collection Payment') }}
          </a>
      @endcan
          
           @can('date-wise-invoice-print')
           
          <a href="{{url('date-wise-invoice-print')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Date Wise Invoice Print') }}
          </a>
         @endcan
        
          @can('date-wise-restaurant-invoice-print')
           
          <a href="{{url('date-wise-restaurant-invoice-print')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Date Wise Restaurant Invoice Print') }}
          </a>
         @endcan
          
       
          
           @can('sales_man_wise_sales_detail')
          
          <a href="{{url('sales_man_wise_sales_detail')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.sales_man_wise_sales_detail') }} </a>
         @endcan
          
           @can('sales-man-invoice')
          
          <a href="{{url('sales-man-invoice')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Sales Man Invoice') }} </a>
         @endcan
          
           @can('delivery-man-sales-invoice')
           
          <a href="{{url('delivery-man-sales-invoice')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Delivery Man Sales Invoice') }} </a>
         @endcan
     
                            </div>
                        </div>
                @endcan


                 @can('damage_report') 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center">{{__('label.damage_report')}}</h4>
                   
     
           <div class="dropdown-divider"></div>
           @can('dm_item_ledger')
           
          <a href="{{url('dm_item_ledger')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.dm_item_ledger') }} </a>
         @endcan

          
           @can('dm_item_stock_possition')
           
          <a href="{{url('dm_item_stock_possition')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.dm_item_stock_possition') }} </a>
         @endcan

           @can('dm_item_stock_value')
           
          <a href="{{url('dm_item_stock_value')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.dm_item_stock_value') }} </a>
         @endcan
           @can('dm_receive_from_customer')
           
          <a href="{{url('dm_receive_from_customer')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.dm_receive_from_customer') }} </a>
         @endcan

           @can('dm_receive_from_stock')
           
          <a href="{{url('dm_receive_from_stock')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.dm_receive_from_stock') }} </a>
         @endcan

           @can('dm_send_to_supplier')
           
          <a href="{{url('dm_send_to_supplier')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.dm_send_to_supplier') }} </a>
         @endcan

                            </div>
                        </div>
                @endcan


                <!-- Asset Management Report -->

@can('asset-management-report')




@endcan


@can('stm_report_section')
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center">{{__('label.stm_report_section')}}</h4>
                   
     
           <div class="dropdown-divider"></div>
           @can('division_class_student_report')
           
          <a href="{{route('division_class_student_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.division_class_student_report') }} </a>
         @endcan
           @can('division_class_collection_report')
           
          <a href="{{route('division_class_collection_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.division_class_collection_report') }} </a>
         @endcan

           @can('division_class_collection_status_report')
           
          <a href="{{route('division_class_collection_status_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.division_class_collection_status_report') }} </a>
         @endcan

         
           @can('student_ledger_report')
           
          <a href="{{route('student_ledger_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.student_ledger_report') }} </a>
         @endcan

         
           @can('month_wise_payment_status_report')
           
          <a href="{{route('month_wise_payment_status_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.month_wise_payment_status_report') }} </a>
         @endcan
           @can('monthly_fee_collection_ledger')
           
          <a href="{{route('monthly_class_wise_fee_collection_ledger')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.monthly_class_wise_fee_collection_ledger') }} </a>
         @endcan

           @can('stmd_monthly_income_expense_compare')
           
          <a href="{{url('reports/income-expense')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.income_expense_summary') }} </a>
         @endcan

           @can('collection_expense_report')
           
          <a href="{{url('collection_expense_report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.collection_expense_report') }} </a>
         @endcan

                            </div>

             <!-- Attendence Report Section -->
              <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center">{{__('label.attendence_report_section')}}</h4>
                   
     
           <div class="dropdown-divider"></div>
           @can('division_class_student_report')
           
          <a href="{{url('attendance-report')}}" class="dropdown-item">
            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.datewise_attendence_report') }} </a>
         @endcan
           

                            </div>

                        </div>
 


@endcan

    
    
</div>
</div>
</div>
    
    </div>

    @endsection