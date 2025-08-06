<aside class="main-sidebar   sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
      <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}" class="brand-image  elevation-3" >
      <span class="brand-text font-weight-light">{{$settings->title ?? '' }}</span>
    </a>
@php
   $current_url = Route::current()->getName();
@endphp
    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar Menu -->
     
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item ">
            <a href="{{url('home')}}" class="nav-link {{ ( $current_url=='home' ) ? 'nest_active' : '' }}"  >
              <i class="nav-icon fas fa-tachometer-alt" aria-hidden="true"></i>
              <p>
                  {{ __('label.Dashboard') }}
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('report-panel')}}" class="nav-link {{ ( $current_url=='home' ) ? 'nest_active' : '' }}"  >
              <i class="nav-icon fas fa-file" aria-hidden="true"></i>
              <p>
                  {{ __('label.report') }}
              </p>
            </a>
          </li>
          @can('account-menu') 
          <li class="nav-item {{ Route::is('voucher.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('purchase-return.*')    ? 'main_nav_active' : '' }}">
              <i class="nav-icon fas fa-th nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.Accounts') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('cash-receive')
              <li class="nav-item" >
                  <a href="{{url('voucher')}}?_voucher_type=CR" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.Cash Receive') }}</p></a>
              </li>
              @endcan
             @can('cash-payment')
              <li class="nav-item">
                <a href="{{url('voucher')}}?_voucher_type=CP" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Cash Payment') }}</p></a>
              </li>
              @endcan
             @can('petty-cash')
              <li class="nav-item">
                <a href="{{url('petty-cash')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('Petty Cash') }}</p></a>
              </li>
              @endcan
             @can('bank-receive')
              <li class="nav-item">
                <a href="{{url('voucher')}}?_voucher_type=BR" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Bank Receive') }}</p></a>
              </li>
              @endcan
             @can('bank-payment')
              <li class="nav-item">
                <a href="{{url('voucher')}}?_voucher_type=BP" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Bank Payment') }}</p></a>
              </li>
              @endcan
             
             @can('voucher-list')
              <li class="nav-item">
                <a href="{{url('voucher')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Voucher') }}</p></a>
              </li>
              @endcan
             @can('easy-voucher-list')
              <li class="nav-item">
                <a href="{{url('easy-voucher')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Easy Voucher') }}</p></a>
              </li>
              @endcan
             @can('inter-project-voucher-list')
              <li class="nav-item">
                <a href="{{url('inter-project-voucher')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.inter-project-voucher') }}</p></a>
              </li>
              @endcan
             @can('supplier_payment_list')
              <li class="nav-item">
                <a href="{{url('supplier_payment')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.supplier_payment') }}</p></a>
              </li>
              @endcan
             @can('customer_payment_list')
              <li class="nav-item">
                <a href="{{url('customer_payment')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.customer_payment') }}</p></a>
              </li>
              @endcan
             @can('so_wise_due_invoice')
              <li class="nav-item">
                <a href="{{url('so_wise_due_invoice')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.so_wise_due_invoice') }}</p></a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
   @can('student_management') 
          <li class="nav-item {{ Route::is('voucher.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('purchase-return.*')    ? 'main_nav_active' : '' }}">
              <i class="nav-icon fas fa-th nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.student_management') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('admission_fee_collection')
              <li class="nav-item" >
                  <a href="{{route('admission_fee_collection_list')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.admission_fee_collection') }}</p></a>
              </li>
              @endcan
            @can('stm_collection_list')
              <li class="nav-item" >
                  <a href="{{route('stm_collection.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_collection_list') }}</p></a>
              </li>
              @endcan
            @can('stm_bill_masters_list')
              <li class="nav-item" >
                  <a href="{{route('stm_bill_masters.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_bill_masters') }}</p></a>
              </li>
              @endcan
            @can('stm_students_list')
              <li class="nav-item" >
                  <a href="{{route('stm_students.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_students') }}</p></a>
              </li>
              @endcan
            @can('stm_education_sessions_list')
              <li class="nav-item" >
                  <a href="{{route('stm_education_sessions.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_education_sessions') }}</p></a>
              </li>
              @endcan
            @can('stm_division_class_students')
              <li class="nav-item" >
                  <a href="{{route('stm_division_class_students')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_division_class_students') }}</p></a>
              </li>
              @endcan
            @can('stm_income_ledger_setups')
              <li class="nav-item" >
                  <a href="{{route('stm_income_ledger_setups')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_income_ledger_setups') }}</p></a>
              </li>
              @endcan
            @can('stm_divisions_list')
              <li class="nav-item" >
                  <a href="{{route('stm_divisions.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_divisions') }}</p></a>
              </li>
              @endcan
            @can('stm_classes_list')
              <li class="nav-item" >
                  <a href="{{route('stm_classes.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_classes') }}</p></a>
              </li>
              @endcan
            @can('stm_subjects_list')
              <li class="nav-item" >
                  <a href="{{route('stm_subjects.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p>{{ __('label.stm_subjects') }}</p></a>
              </li>
              @endcan
           
            </ul>
          </li>
          @endcan

          @can('sales_commision_plans')
          <li class="nav-item {{ Route::is('sales_commision_plans.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('sales_commision_plans.*')    ? 'main_nav_active' : '' }}">
              <i class="nav-icon fas fa-th nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.Others') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
             @can('ta_da_setups-list')
              <li class="nav-item" >
                  <a href="{{route('ta_da_setups.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> {{ __('label.ta_da_setups') }}</p></a>
              </li>
              @endcan
             @can('cat_wise_ta_bills-list')
              <li class="nav-item" >
                  <a href="{{route('cat_wise_ta_bills.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> {{ __('label.cat_wise_ta_bills') }}</p></a>
              </li>
              @endcan
             @can('item_bonus_setups-list')
              <li class="nav-item" >
                  <a href="{{route('item_bonus_setups.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> {{ __('label.item_bonus_setups') }}</p></a>
              </li>
              @endcan
             @can('monthly_sales_targets-list')
              <li class="nav-item" >
                  <a href="{{route('monthly_sales_targets.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> {{ __('label.monthly_sales_targets') }}</p></a>
              </li>
              @endcan
             @can('quaterly_insentive_setups-list')
              <li class="nav-item" >
                  <a href="{{route('quaterly_insentive_setups.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> {{ __('label.quaterly_insentive_setups') }}</p></a>
              </li>
              @endcan
             @can('sales_commision_plans-list')
              <li class="nav-item" >
                  <a href="{{route('sales_commision_plans.index')}}" class="nav-link " >
                  <i class="far fa-circle nav-icon"></i><p> {{ __('label.sales_commision_plans') }}</p></a>
              </li>
              @endcan
             
            </ul>
          </li>
        @endcan
 @can('restaurant-module') 
          <li class="nav-item {{ Route::is('restaurant-sales.*') || Route::is('table-info.*')  || Route::is('steward-waiter.*')  || Route::is('musak-four-point-three.*')|| Route::is('kitchen.*')   ? 'menu-is-opening menu-open' : '' }} ">
            <a href="#" class="nav-link ">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                {{ __('label.Restaurants') }} 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('restaurant-pos')
              <li class="nav-item">
                <a href="{{url('restaurant-pos')}}" class="nav-link" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Restaurant POS') }}</p></a>
              </li>
              @endcan
             
            @can('restaurant-sales-list')
              <li class="nav-item">
                <a href="{{url('restaurant-sales')}}" class="nav-link {{ Route::is('restaurant-sales.*') ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Restaurant Sales') }}</p></a>
              </li>
              @endcan
            @can('table-info-menu')
              <li class="nav-item">
                <a href="{{url('table-info')}}"  class="nav-link {{ Route::is('table-info.*') ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p> Table Information </p></a>
              </li>
              @endcan
              @can('steward-waiter-menu')
              <li class="nav-item">
                <a href="{{url('steward-waiter')}}"  class="nav-link {{ Route::is('steward-waiter.*') ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p> Steward/Waiter Setup </p></a>
              </li>
              @endcan
              @can('musak-four-point-three-menu')
              <li class="nav-item">
                <a href="{{url('musak-four-point-three')}}" class="nav-link {{ Route::is('musak-four-point-three.*') ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p> Item Wise Ingredients </p></a>
              </li>
              @endcan
             @can('kitchen-menu')
              <li class="nav-item">
                <a href="{{url('kitchen')}}" class="nav-link {{ Route::is('kitchen.*') ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>  Kitchen Panel </p></a>
              </li>
              @endcan
            
             
            
              
            </ul>
          </li>
          @endcan
 @can('purchase-order-list') 
          <li class="nav-item {{ Route::is('purchase-order.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('purchase-order.*')    ? 'main_nav_active' : '' }}">

              <i class="far fa-plus-square nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.purchase order') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('purchase-order-create')
              <li class="nav-item">
                <a href="{{url('purchase-order/create')}}" class="nav-link {{ ( $current_url=='purchase-order.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Purchase Order Create') }} </p></a>
              </li>
              @endcan
             @can('purchase-order-list')
              <li class="nav-item">
                <a href="{{url('purchase-order')}}" class="nav-link {{ ( $current_url=='purchase-order.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Purchase Order List') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan 

          @can('purchase-list') 
          <li class="nav-item {{ Route::is('purchase.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('purchase.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-cart-plus nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.purchase') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('purchase-create')
              <li class="nav-item">
                <a href="{{url('purchase/create')}}" class="nav-link {{ ( $current_url=='purchase.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Purchase Create') }} </p></a>
              </li>
              @endcan
             @can('purchase-list')
              <li class="nav-item">
                <a href="{{url('purchase')}}" class="nav-link {{ ( $current_url=='purchase.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Purchase List') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan

          @can('purchase-return-list') 
          <li class="nav-item {{ Route::is('purchase-return.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('purchase-return.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-cart-arrow-down nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.purchase-return') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('purchase-return-create')
              <li class="nav-item">
                <a href="{{url('purchase-return/create')}}" class="nav-link {{ ( $current_url=='purchase-return.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.purchase-return-create') }} </p></a>
              </li>
              @endcan
             @can('purchase-return-list')
              <li class="nav-item">
                <a href="{{url('purchase-return')}}" class="nav-link {{ ( $current_url=='purchase-return.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.purchase-return-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan

          @can('sales-order-list') 
          <li class="nav-item {{ Route::is('sales-order.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('sales-order.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.sales-order') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
           
             @can('avaiable_product_list')
              <li class="nav-item">
                <a href="{{url('product_show')}}" class="nav-link {{ ( $current_url=='product_show' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{__('label.avaiable_product_list')}} </p></a>
              </li>
              @endcan
             @can('sales-order-create')
              <li class="nav-item">
                <a href="{{url('sales-order/create')}}" class="nav-link {{ ( $current_url=='sales-order.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales-order-create') }} </p></a>
              </li>
              @endcan
             @can('sales-order-list')
              <li class="nav-item">
                <a href="{{url('sales-order')}}" class="nav-link {{ ( $current_url=='sales-order.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales-order-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan

          @can('sales-list') 
          <li class="nav-item {{ Route::is('sales.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('sales.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.sales') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('sales-create')
              <li class="nav-item">
                <a href="{{url('sales/create')}}" class="nav-link {{ ( $current_url=='sales.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales-create') }} </p></a>
              </li>
              @endcan
             @can('sales-list')
              <li class="nav-item">
                <a href="{{url('sales')}}" class="nav-link {{ ( $current_url=='sales.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales-list') }}</p></a>
              </li>
              @endcan
             @can('sales_without_stock_deduct')
              <li class="nav-item">
                <a href="{{url('sales_without_stock_deduct')}}" class="nav-link {{ ( $current_url=='sales_without_stock_deduct.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales_without_stock_deduct') }}</p></a>
              </li>
              @endcan
             @can('previous_bill_item_send')
              <li class="nav-item">
                <a href="{{url('previous_bill_item_send')}}" class="nav-link {{ ( $current_url=='previous_bill_item_send.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.previous_bill_item_send') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan

          @can('sales-return-list') 
          <li class="nav-item {{ Route::is('sales-return.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('sales-return.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.sales-return') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('sales-return-create')
              <li class="nav-item">
                <a href="{{url('sales-return/create')}}" class="nav-link {{ ( $current_url=='sales-return.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales-return-create') }} </p></a>
              </li>
              @endcan
             @can('sales-return-list')
              <li class="nav-item">
                <a href="{{url('sales-return')}}" class="nav-link {{ ( $current_url=='sales-return.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.sales-return-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          @can('previous_sales_return-list') 
          <li class="nav-item {{ Route::is('previous_sales_return.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('previous_sales_return.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.previous_sales_return') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('previous_sales_return-create')
              <li class="nav-item">
                <a href="{{url('previous_sales_return/create')}}" class="nav-link {{ ( $current_url=='previous_sales_return.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.previous_sales_return') }} Create</p></a>
              </li>
              @endcan
             @can('previous_sales_return-list')
              <li class="nav-item">
                <a href="{{url('previous_sales_return')}}" class="nav-link {{ ( $current_url=='previous_sales_return.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.previous_sales_return') }} List</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          @can('damage-list') 
          <li class="nav-item {{ Route::is('damage.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('damage.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.damage') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('damage-create')
              <li class="nav-item">
                <a href="{{url('damage/create')}}" class="nav-link {{ ( $current_url=='damage.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.damage-create') }} </p></a>
              </li>
              @endcan
             @can('damage-list')
              <li class="nav-item">
                <a href="{{url('damage')}}" class="nav-link {{ ( $current_url=='damage.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.damage-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          @can('damage-list') 
          <li class="nav-item {{ Route::is('damage_from_stocks.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('damage_from_stocks.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.damage_from_stocks') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('damage-create')
              <li class="nav-item">
                <a href="{{url('damage_from_stocks/create')}}" class="nav-link {{ ( $current_url=='damage_from_stocks.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.damage_from_stocks') }} Create </p></a>
              </li>
              @endcan
             @can('damage-list')
              <li class="nav-item">
                <a href="{{url('damage_from_stocks')}}" class="nav-link {{ ( $current_url=='damage_from_stocks.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.damage_from_stocks') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          @can('transfer-list') 
          <li class="nav-item {{ Route::is('transfer.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('transfer.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.transfer') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('transfer-create')
              <li class="nav-item">
                <a href="{{url('transfer/create')}}" class="nav-link {{ ( $current_url=='transfer.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.transfer-create') }} </p></a>
              </li>
              @endcan
             @can('transfer-list')
              <li class="nav-item">
                <a href="{{url('transfer')}}" class="nav-link {{ ( $current_url=='transfer.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.transfer-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          @can('production-list') 
          <li class="nav-item {{ Route::is('production.*') ||  Route::is('partical-production-receive')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('production.*') ||  Route::is('partical-production-receive')     ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.production') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('production-create')
              <li class="nav-item">
                <a href="{{url('production/create')}}" class="nav-link {{ ( $current_url=='production.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.production-create') }} </p></a>
              </li>
              @endcan
             @can('production-list')
              <li class="nav-item">
                <a href="{{url('production')}}" class="nav-link {{ ( $current_url=='production.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.production-list') }}</p></a>
              </li>
              @endcan
             @can('partical-production-receive')
              <li class="nav-item">
                <a href="{{url('partical-production-receive')}}" class="nav-link {{ ( $current_url=='partical-production-receive' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.partical-production-receive') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          @can('third-party-service-list') 
          <li class="nav-item {{ Route::is('third-party-service.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('third-party-service.*')    ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.third-party-service') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('third-party-service-create')
              <li class="nav-item">
                <a href="{{url('third-party-service/create')}}" class="nav-link {{ ( $current_url=='third-party-service.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.third-party-service-create') }} </p></a>
              </li>
              @endcan
             @can('third-party-service-list')
              <li class="nav-item">
                <a href="{{url('third-party-service')}}" class="nav-link {{ ( $current_url=='third-party-service.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.third-party-service-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan

          @can('warranty-manage-list') 
          <li class="nav-item {{ Route::is('warranty-manage.*') || Route::is('individual-replacement.*') || Route::is('item-replace.*') ||  Route::is('individual-replacement.*') ||  Route::is('warranty-check')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('warranty-manage.*') || Route::is('individual-replacement.*') || Route::is('item-replace.*') ||  Route::is('individual-replacement.*') ||  Route::is('warranty-check')   ? 'main_nav_active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.warranty-manage') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('warranty-check')
              <li class="nav-item">
                <a href="{{url('warranty-check')}}" class="nav-link {{ ( $current_url=='warranty-check' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.warranty-check') }} </p></a>
              </li>
              @endcan
             @can('warranty-manage-create')
              <li class="nav-item">
                <a href="{{url('warranty-manage/create')}}" class="nav-link {{ ( $current_url=='warranty-manage.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.warranty-manage-create') }} </p></a>
              </li>
              @endcan
             @can('warranty-manage-list')
              <li class="nav-item">
                <a href="{{url('warranty-manage')}}" class="nav-link {{ ( $current_url=='warranty-manage.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.warranty-manage-list') }}</p></a>
              </li>
              @endcan
              @can('item-replace-create')
              <li class="nav-item">
                <a href="{{url('item-replace/create')}}" class="nav-link {{ ( $current_url=='item-replace.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.item-replace-create') }} </p></a>
              </li>
              @endcan
             @can('item-replace-list')
              <li class="nav-item">
                <a href="{{url('item-replace')}}" class="nav-link {{ ( $current_url=='item-replace.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.item-replace-list') }}</p></a>
              </li>
              @endcan
              @can('individual-replacement-create')
              <li class="nav-item">
                <a href="{{url('individual-replacement/create')}}" class="nav-link {{ ( $current_url=='individual-replacement.create' ) ? 'nest_active' : '' }}"  ><i class="far fa-circle nav-icon"></i><p>{{ __('label.individual-replacement-create') }} </p></a>
              </li>
              @endcan
             @can('individual-replacement-list')
              <li class="nav-item">
                <a href="{{url('individual-replacement')}}" class="nav-link {{ ( $current_url=='individual-replacement.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.individual-replacement-list') }}</p></a>
              </li>
              @endcan
             @can('w-item-receive-from-supp-list')
              <li class="nav-item">
                <a href="{{url('w-item-receive-from-supp')}}" class="nav-link {{ ( $current_url=='w-item-receive-from-supp.index' ) ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.w-item-receive-from-supp-list') }}</p></a>
              </li>
              @endcan
              
            </ul>
          </li>
          @endcan
          
          

        @can('inventory-report') 
          <li class="nav-item ">
            <a href="#" class="nav-link ">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 {{ __('label.Inventory Report') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @can('bcategory-wise-item-list')
              <li class="nav-item">
                <a href="{{url('bcategory-wise-item-list')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>{{ __('label.category-wise-item-list') }}</p></a>
              </li>
              @endcan
             @can('day-wise-summary-report')
              <li class="nav-item">
                <a href="{{url('day-wise-summary-report')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>Work Period Sales Summary Report </p></a>
              </li>
              @endcan
             @can('item-sales-report')
              <li class="nav-item">
                <a href="{{url('item-sales-report')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>Item Sales Report </p></a>
              </li>
              @endcan
             @can('detail-item-sales-report')
              <li class="nav-item">
                <a href="{{url('detail-item-sales-report')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>Detail Item Sales Report </p></a>
              </li>
              @endcan



              
             @can('bill-party-statement')
              <li class="nav-item">
                <a href="{{url('bill-party-statement')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Bill of Party Statement') }}</p></a>
              </li>
              @endcan
             @can('date-wise-purchase')
              <li class="nav-item">
                <a href="{{url('date-wise-purchase')}}" class="nav-link {{Route::is('date-wise-purchase')   ? 'nest_active' : '' }}" ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Date Wise Purchase') }}</p></a>
              </li>
              @endcan
             @can('purchase-return-detail')
              <li class="nav-item">
                <a href="{{url('purchase-return-detail')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p>{{ __('label.Purchase Return Detail') }}</p></a>
              </li>
              @endcan
             @can('date-wise-sales')
              <li class="nav-item">
                <a href="{{url('date-wise-sales')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Date Wise Sales') }}</p></a>
              </li>
              @endcan
             @can('transection_terms_wise_sales_report')
              <li class="nav-item">
                <a href="{{url('transection_terms_wise_sales_report')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.transection_terms_wise_sales_report') }}</p></a>
              </li>
              @endcan

             @can('date-wise-sales')
              <li class="nav-item">
                <a href="{{url('date_to_date_sales_detail')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.date_to_date_sales_detail') }}</p></a>
              </li>
              @endcan
             @can('date-wise-sales')
              <li class="nav-item">
                <a href="{{url('date_to_date_sales_item_detail')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.date_to_date_sales_item_detail') }}</p></a>
              </li>
              @endcan
             @can('date-wise-sales')
              <li class="nav-item">
                <a href="{{url('date_to_date_sales_item_summary')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.date_to_date_sales_item_summary') }}</p></a>
              </li>
              @endcan


             @can('date-wise-restaurant-sales')
              <li class="nav-item">
                <a href="{{url('date-wise-restaurant-sales')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Date Wise Restaurant Sales') }}</p></a>
              </li>
              @endcan
             @can('sales-return-detail')
              <li class="nav-item">
                <a href="{{url('sales-return-detail')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Sales Return Details') }}</p></a>
              </li>
              @endcan
             @can('stock-possition')
              <li class="nav-item">
                <a href="{{url('stock-possition')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Stock Possition') }}</p></a>
              </li>
              @endcan
             @can('stock-balance')
              <li class="nav-item">
                <a href="{{url('stock-balance')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('Stock Balance Report') }}</p></a>
              </li>
              @endcan
             @can('stock-ledger')
              <li class="nav-item">
                <a href="{{url('stock-ledger')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Stock Ledger') }}</p></a>
              </li>
              @endcan
             @can('stock-value')
              <li class="nav-item">
                <a href="{{url('stock-value')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Stock Value') }}</p></a>
              </li>
              @endcan
             @can('stock-value-register')
              <li class="nav-item">
                <a href="{{url('stock-value-register')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Stock Value Register') }}</p></a>
              </li>
              @endcan
             @can('gross-profit')
              <li class="nav-item">
                <a href="{{url('gross-profit')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Gross Profit') }}</p></a>
              </li>
              @endcan
             @can('expired-item')
              <li class="nav-item">
                <a href="{{url('expired-item')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Expired Item') }}</p></a>
              </li>
              @endcan
             @can('shortage-item')
              <li class="nav-item">
                <a href="{{url('shortage-item')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Shortage Item') }}</p></a>
              </li>
              @endcan
             @can('barcode-history')
              <li class="nav-item">
                <a href="{{url('barcode-history')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Barcode History') }}</p></a>
              </li>
              @endcan
             @can('user-wise-collection-payment')
              <li class="nav-item">
                <a href="{{url('user-wise-collection-payment')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.User Wise Collection Payment') }}</p></a>
              </li>
              @endcan
             @can('date-wise-invoice-print')
              <li class="nav-item">
                <a href="{{url('date-wise-invoice-print')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Date Wise Invoice Print') }}</p></a>
              </li>
              @endcan
             @can('date-wise-restaurant-invoice-print')
              <li class="nav-item">
                <a href="{{url('date-wise-restaurant-invoice-print')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Date Wise Restaurant Invoice Print') }}</p></a>
              </li>
              @endcan
             @can('delivery-man-sales')
              <li class="nav-item">
                <a href="{{url('delivery-man-sales')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Delivery Man Sales') }}</p></a>
              </li>
              @endcan
             @can('delivery-man-sales-return')
              <li class="nav-item">
                <a href="{{url('delivery-man-sales-return')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Delivery Man Sales Return') }}</p></a>
              </li>
              @endcan
             @can('sales-man-sales-return')
              <li class="nav-item">
                <a href="{{url('sales-man-sales-return')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Sales Man Sales Return') }}</p></a>
              </li>
              @endcan
             @can('sales-man-invoice')
              <li class="nav-item">
                <a href="{{url('sales-man-invoice')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Sales Man Invoice') }}</p></a>
              </li>
              @endcan
             @can('delivery-man-sales-invoice')
              <li class="nav-item">
                <a href="{{url('delivery-man-sales-invoice')}}" class="nav-link " ><i class="far fa-circle nav-icon"></i><p> {{ __('label.Delivery Man Sales Invoice') }}</p></a>
              </li>
              @endcan
            
              
            </ul>
          </li>
          @endcan
            @can('account-report-menu') 
          <li class="nav-item {{ Route::is('ledger-report') || Route::is('group-ledger')  || Route::is('date_to_date_sales_amount_report')  || Route::is('outstanding_detail_report') || Route::is('day-book') || Route::is('income-statement') || Route::is('trail-balance') || Route::is('work-sheet') || Route::is('balance-sheet') || Route::is('bank-book') || Route::is('receipt-payment')  || Route::is('filter-ledger-summary') || Route::is('customer_due_statement') || Route::is('final_due_statement') || Route::is('chart-of-account')  || Route::is('payable_report') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('ledger-report') || Route::is('group-ledger') || Route::is('date_to_date_sales_amount_report') || Route::is('outstanding_detail_report') || Route::is('income-statement') || Route::is('trail-balance') || Route::is('work-sheet') || Route::is('balance-sheet') || Route::is('day-book')   || Route::is('bank-book') || Route::is('receipt-payment') || Route::is('filter-ledger-summary') || Route::is('chart-of-account') || Route::is('customer_due_statement') || Route::is('payable_report')  || Route::is('final_due_statement')    ? 'active' : '' }}">
              <i class="fa fa-file nav-icon" aria-hidden="true"></i>
              <p>
                {{ __('label.Accounts Report') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('day-book')
              <li class="nav-item">
                <a href="{{url('day-book')}}" class="nav-link {{Route::is('day-book')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Day Book') }}</p>
                </a>
              </li>
              @endcan
             @can('cash-book')
              <li class="nav-item">
                <a href="{{url('cash-book')}}" class="nav-link {{Route::is('cash-book')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Cash Book') }}</p>
                </a>
              </li>
              @endcan
             @can('bank-book')
              <li class="nav-item">
                <a href="{{url('bank-book')}}" class="nav-link {{Route::is('bank-book')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Bank Book') }}</p>
                </a>
              </li>
              @endcan
             @can('receipt-payment')
              <li class="nav-item">
                <a href="{{url('receipt-payment')}}" class="nav-link {{Route::is('receipt-payment')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Receipt & Payment') }}</p>
                </a>
              </li>
              @endcan
              @can('ledger-report')
              <li class="nav-item">
                <a href="{{url('ledger-report')}}" class="nav-link {{Route::is('ledger-report')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Ledger Report') }}</p>
                </a>
              </li>
              @endcan
             @can('group-ledger')
              <li class="nav-item">
                <a href="{{url('group-ledger')}}" class="nav-link {{Route::is('group-ledger')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Group Ledger Report') }}</p>
                </a>
              </li>
              @endcan
             @can('ledger-summary-report')
              <li class="nav-item">
                <a href="{{url('filter-ledger-summary')}}" class="nav-link {{Route::is('filter-ledger-summary')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p> {{ __('label.Ledger Summary Report') }}</p>
                </a>
              </li>
              @endcan
             @can('income-statement')
              <li class="nav-item">
                <a href="{{url('income-statement')}}" class="nav-link {{Route::is('income-statement')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Income Statement') }}</p>
                </a>
              </li>
              @endcan
             @can('outstanding_detail_report')
              <li class="nav-item">
                <a href="{{url('outstanding_detail_report')}}" class="nav-link {{Route::is('outstanding_detail_report')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.outstanding_detail_report') }}</p>
                </a>
              </li>
              @endcan
             @can('customer_due_statement')
              <li class="nav-item">
                <a href="{{url('customer_due_statement')}}" class="nav-link {{Route::is('customer_due_statement')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.customer_due_statement') }}</p>
                </a>
              </li>
              @endcan
             @can('payable_receivalbe_report')
              <li class="nav-item">
                <a href="{{url('payable_report')}}" class="nav-link {{Route::is('payable_report')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.payable_report') }}</p>
                </a>
              </li>
              @endcan
             @can('date_to_date_sales_amount_report')
              <li class="nav-item">
                <a href="{{url('date_to_date_sales_amount_report')}}" class="nav-link {{Route::is('date_to_date_sales_amount_report')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.date_to_date_sales_amount_report') }}</p>
                </a>
              </li>
              @endcan
             @can('customer_due_statement')
              <li class="nav-item">
                <a href="{{url('final_due_statement')}}" class="nav-link {{Route::is('final_due_statement')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.final_due_statement') }}</p>
                </a>
              </li>
              @endcan
             @can('customer_due_statement')
              <li class="nav-item">
                <a href="{{url('single_customer_statement')}}" class="nav-link {{Route::is('single_customer_statement')   ? 'nest_active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.single_customer_statement') }}</p>
                </a>
              </li>
              @endcan
             @can('trail-balance')
              <li class="nav-item">
                <a href="{{url('trail-balance')}}" class="nav-link {{Route::is('trail-balance')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Trail Balance') }}</p>
                </a>
              </li>
              @endcan
             @can('work-sheet')
              <li class="nav-item">
                <a href="{{url('work-sheet')}}" class="nav-link {{Route::is('work-sheet')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Work Sheet') }}</p>
                </a>
              </li>
              @endcan
             @can('balance-sheet')
              <li class="nav-item">
                <a href="{{url('balance-sheet')}}" class="nav-link {{Route::is('balance-sheet')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Balance Sheet') }}</p>
                </a>
              </li>
              @endcan
             @can('chart-of-account')
              <li class="nav-item">
                <a href="{{url('chart-of-account')}}" class="nav-link {{Route::is('chart-of-account')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>{{ __('label.Chart of Account') }}</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan

           @can('inventory-menu') 
          <li class="nav-item {{ Route::is('account-type.*') || Route::is('account-group.*') || Route::is('unit.*')  || Route::is('item-information.*')  || Route::is('lot-item-information.*')  || Route::is('account-ledger.*')  || Route::is('item-category.*')  || Route::is('warranty.*') || Route::is('transection_terms.*') || Route::is('vat-rules.*') || Route::is('labels-print') || Route::is('lot-item-information') || Route::is('pack-size.*') || Route::is('item-brand.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link  Route::is('account-type.*') || Route::is('account-group.*')  || Route::is('unit.*')   || Route::is('item-information.*')    || Route::is('lot-item-information.*')   || Route::is('account-ledger.*')  || Route::is('item-category.*') || Route::is('warranty.*') || Route::is('transection_terms.*')  || Route::is('vat-rules.*')   || Route::is('labels-print')   || Route::is('lot-item-information') || Route::is('pack-size.*') || Route::is('item-brand.*')   ? 'active' : '' }}">
              <i class="fa fa-file nav-icon" aria-hidden="true"></i>
              <p>
               {{ __('label.Master') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @can('account-type-list')
              <li class="nav-item">
                <a href="{{url('account-type')}}"  class="nav-link {{Route::is('account-type.*')   ? 'active' : '' }}" ><i class="fa fa-sitemap nav-icon"></i> <p>{{ __('label.Account Type') }}</p></a>
              </li>
              @endcan
             @can('account-group-list')
              <li class="nav-item">
                <a href="{{url('account-group')}}"  class="nav-link {{Route::is('account-group.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Account Group') }}</p></a>
              </li>
              @endcan
             @can('account-ledger-list')
              <li class="nav-item">
                <a href="{{url('account-ledger')}}"  class="nav-link {{Route::is('account-ledger.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Account Ledger') }}</p></a>
              </li>
              @endcan
             @can('item-category-list')
              <li class="nav-item">
                <a href="{{url('item-category')}}"  class="nav-link {{Route::is('item-category.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Item Category') }}</p></a>
              </li>
              @endcan

             @can('item-brand-list')
              <li class="nav-item">
                <a href="{{url('item-brand')}}"  class="nav-link {{Route::is('item-brand.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.item_brand') }}</p></a>
              </li>
              @endcan
             @can('pack-size-list')
              <li class="nav-item">
                <a href="{{url('pack-size')}}"  class="nav-link {{Route::is('pack-size.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.pack_size') }}</p></a>
              </li>
              @endcan
             @can('unit-list')
              <li class="nav-item">
                <a href="{{url('unit')}}"  class="nav-link {{Route::is('unit.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Unit Of Measurment') }}</p></a>
              </li>
              @endcan
             
             @can('warranty-list')
              <li class="nav-item">
                <a href="{{url('warranty')}}"  class="nav-link {{Route::is('warranty.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Warranty') }}</p></a>
              </li>
              @endcan

             @can('transection_terms-list')
              <li class="nav-item">
                <a href="{{url('transection_terms')}}"  class="nav-link {{Route::is('transection_terms.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Transection Terms') }}</p></a>
              </li>
              @endcan
             @can('vat-rules-list')
              <li class="nav-item">
                <a href="{{url('vat-rules')}}"  class="nav-link {{Route::is('vat-rules.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Vat Rules') }}</p></a>
              </li>
              @endcan
             @can('item-information-list')
              <li class="nav-item">
                <a href="{{url('item-information')}}"  class="nav-link {{Route::is('item-information.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Item Information') }}</p></a>
              </li>
              @endcan
             @can('lot-item-information')
              <li class="nav-item">
                <a href="{{url('lot-item-information')}}"  class="nav-link {{Route::is('lot-item-information')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Lot Item Information') }}</p></a>
              </li>
              @endcan
             @can('labels-print')
              <li class="nav-item">
                <a href="{{url('labels-print')}}"  class="nav-link {{Route::is('labels-print')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>{{ __('label.Labels Print') }}</p></a>
              </li>
              @endcan

             
            </ul>
          </li>
          @endcan
          <li class="nav-item {{ Route::is('roles.*') || Route::is('users.*') || Route::is('sms-send')  || Route::is('all-lock') || Route::is('invoice-prefix') || Route::is('database-backup') || Route::is('admin-settings') || Route::is('branch.*') || Route::is('social_media.*') || Route::is('cost-center.*') || Route::is('store-house.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('roles.*') || Route::is('users.*') || Route::is('admin-settings') || Route::is('branch.*')  || Route::is('cost-center.*')|| Route::is('sms-send') || Route::is('invoice-prefix')  || Route::is('database-backup')  || Route::is('all-lock')  || Route::is('store-house.*')   ? 'active' : '' }}">
            
               <i class="fas fa-cog nav-icon"></i> 
              <p>
                {{ __('label.Settings') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               @can('admin-settings')
              <li class="nav-item">

                <a href="{{url('admin-settings')}}" class="nav-link {{Route::is('admin-settings')   ? 'active' : '' }}">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p>{{ __('label.General Settings') }}</p>
                </a>
              </li>
              @endcan
            
               @can('bulk-sms')
              <li class="nav-item">

                <a href="{{url('sms-send')}}" class="nav-link {{Route::is('sms-send')   ? 'active' : '' }}">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p>{{ __('label.SMS SEND') }}</p>
                </a>
              </li>
              @endcan
               @can('invoice-prefix')
              <li class="nav-item">

                <a href="{{url('invoice-prefix')}}" class="nav-link {{Route::is('invoice-prefix')   ? 'active' : '' }}">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p>{{ __('label.Invoice Prefix') }}</p>
                </a>
              </li>
              @endcan
              @can('social_media-list')
              <li class="nav-item">

                <a href="{{url('social_media')}}" class="nav-link {{Route::is('social_media.*')   ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Social Media</p>
                </a>
              </li>
              @endcan
               @can('role-list')
              <li class="nav-item">
                <a href="{{url('roles')}}" class="nav-link {{Route::is('roles.*')   ? 'active' : '' }}">
                  <i class="fa fa-server nav-icon"></i>
                  <p>{{ __('label.Roles') }}</p>
                </a>
              </li>
              @endcan
              @can('user-list')
              <li class="nav-item">
                <a href="{{url('users')}}" class="nav-link {{Route::is('users.*')   ? 'active' : '' }}">
                  <i class="fas fa-users nav-icon"></i>
                  <p>{{ __('label.Users') }}</p>
                </a>
              </li>
              @endcan
              @can('branch-list')
              <li class="nav-item">
                <a href="{{url('branch')}}" class="nav-link {{Route::is('branch.*')   ? 'active' : '' }}">
                 <i class="fa fa-share-alt nav-icon"></i>
                  <p>{{ __('label.Branch') }} </p>
                </a>
              </li>
              @endcan
              @can('cost-center-list')
              <li class="nav-item">
                <a href="{{url('cost-center')}}" class="nav-link {{Route::is('cost-center.*')   ? 'active' : '' }}">
                  <i class="fa fa-adjust nav-icon"></i>
                  <p>{{ __('label.Cost center') }}</p>
                </a>
              </li>
              @endcan
              @can('store-house-list')
              <li class="nav-item">
                <a href="{{url('store-house')}}" class="nav-link {{Route::is('store-house.*')   ? 'active' : '' }}">
                  <i class="fas fa-store  nav-icon"></i>
                  <p>{{ __('label.Store House') }}</p>
                </a>
              </li>
              @endcan
              @can('account_group_configs')
              <li class="nav-item">
                <a href="{{url('account_group_configs')}}" class="nav-link {{Route::is('account_group_configs')   ? 'active' : '' }}">
                  <i class="fas fa-store  nav-icon"></i>
                  <p>{{ __('label.account_group_configs') }}</p>
                </a>
              </li>
              @endcan
              @can('lock-permission')
              <li class="nav-item">
                <a href="{{url('all-lock')}}" class="nav-link {{Route::is('all-lock')   ? 'active' : '' }}">
                  <i class="fas fa-store  nav-icon"></i>
                  <p>{{ __('label.Transection Lock System') }}</p>
                </a>
              </li>
              @endcan
              @can('documents-list')
              <li class="nav-item">
                <a href="{{url('documents')}}" class="nav-link {{Route::is('documents')   ? 'active' : '' }}">
                  <i class="fas fa-file  nav-icon"></i>
                  <p>{{ __('label.documents') }}</p>
                </a>
              </li>
              @endcan
              @can('database-backup')
              <li class="nav-item">
                <a href="{{url('database-backup')}}" class="nav-link {{Route::is('database-backup')   ? 'active' : '' }}">
                  <i class="fas fa-store  nav-icon"></i>
                  <p>{{ __('label.Data Backup') }}</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>