<aside class="main-sidebar  elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
      <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{$settings->title ?? '' }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @can('inventory-menu') 
          <li class="nav-item ">
            <a href="#" class="nav-link ">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 Accounts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('cash-receive')
              <li class="nav-item" >
                  <a href="{{url('voucher')}}?_voucher_type=CR" class="nav-link" >
                  <i class="fa fa-list-alt nav-icon"></i><p>Cash Receive</p></a>
              </li>
              @endcan
             @can('cash-payment')
              <li class="nav-item">
                <a href="{{url('voucher')}}?_voucher_type=CP" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p>Cash Payment</p></a>
              </li>
              @endcan
             @can('bank-receive')
              <li class="nav-item">
                <a href="{{url('voucher')}}?_voucher_type=BR" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p>Bank Receive</p></a>
              </li>
              @endcan
             @can('bank-payment')
              <li class="nav-item">
                <a href="{{url('voucher')}}?_voucher_type=BP" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p>Bank Payment</p></a>
              </li>
              @endcan
             
             @can('voucher-list')
              <li class="nav-item">
                <a href="{{url('voucher')}}" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p>Voucher</p></a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
 @can('restaurant-module') 
          <li class="nav-item ">
            <a href="#" class="nav-link ">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 Restaurants
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('restaurant-pos')
              <li class="nav-item">
                <a href="{{url('restaurant-pos')}}" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p>Restaurant POS</p></a>
              </li>
              @endcan
             
            @can('restaurant-sales-list')
              <li class="nav-item">
                <a href="{{url('restaurant-sales')}}" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p> Restaurant Sales</p></a>
              </li>
              @endcan
            @can('table-info-menu')
              <li class="nav-item">
                <a href="{{url('table-info')}}"  class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p> Table Information </p></a>
              </li>
              @endcan
              @can('steward-waiter-menu')
              <li class="nav-item">
                <a href="{{url('steward-waiter')}}"  class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p> Steward/Waiter Setup </p></a>
              </li>
              @endcan
              @can('musak-four-point-three-menu')
              <li class="nav-item">
                <a href="{{url('musak-four-point-three')}}" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p> Item Wise Ingredients </p></a>
              </li>
              @endcan
             @can('kitchen-menu')
              <li class="nav-item">
                <a href="{{url('kitchen')}}" class="nav-link" ><i class="fa fa-list-alt nav-icon"></i><p>  Kitchen Panel </p></a>
              </li>
              @endcan
            
             
            
              
            </ul>
          </li>
          @endcan
 @can('inventory-menu') 
          <li class="nav-item {{ Route::is('purchase-order.*') || Route::is('purchase.*') || Route::is('purchase-return.*') || Route::is('sales-order.*') || Route::is('sales.*') || Route::is('sales-return.*')  || Route::is('damage.*') || Route::is('transfer-production.*')  || Route::is('item-replace.*') || Route::is('warranty-manage.*') || Route::is('third-party-service.*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('purchase-order.*') || Route::is('purchase.*') || Route::is('purchase-return.*') || Route::is('sales-order.*') || Route::is('sales.*') || Route::is('sales-return.*')  || Route::is('damage.*')   || Route::is('transfer-production.*')  || Route::is('item-replace.*')  || Route::is('warranty-manage.*')    || Route::is('third-party-service.*')   || Route::is('individual-replacement.*')    ? 'active' : '' }}">
              <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
              <p>
                 Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             @can('purchase-order-list')
              <li class="nav-item">
                <a href="{{url('purchase-order')}}" class="nav-link {{Route::is('purchase-order.*')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p>Purchase Order</p></a>
              </li>
              @endcan
             @can('purchase-list')
              <li class="nav-item">
                <a href="{{url('purchase')}}" class="nav-link {{Route::is('purchase.*')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p>Purchase </p></a>
              </li>
              @endcan
             @can('purchase-return-list')
              <li class="nav-item">
                <a href="{{url('purchase-return')}}" class="nav-link {{Route::is('purchase-return.*')   ? 'active' : '' }}"  ><i class="fa fa-list-alt nav-icon"></i><p>Purchase Return </p></a>
              </li>
              @endcan
             @can('sales-order-list')
              <li class="nav-item">
                <a href="{{url('sales-order')}}" class="nav-link {{Route::is('sales-order.*')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p> Sales Order</p></a>
              </li>
              @endcan
             @can('sales-list')
              <li class="nav-item">
                <a href="{{url('sales')}}" class="nav-link {{Route::is('sales.*')   ? 'active' : '' }}"  ><i class="fa fa-list-alt nav-icon"></i><p> Sales </p></a>
              </li>
              @endcan
             @can('sales-return-list')
              <li class="nav-item">
                <a href="{{url('sales-return')}}" class="nav-link {{Route::is('sales-return.*')   ? 'active' : '' }}"   ><i class="fa fa-list-alt nav-icon"></i><p> Sales Return </p></a>
              </li>
              @endcan
             @can('damage-list')
              <li class="nav-item">
                <a href="{{url('damage')}}"  class="nav-link {{Route::is('damage.*')   ? 'active' : '' }}"   ><i class="fa fa-list-alt nav-icon"></i><p> Damage Adjustment </p></a>
              </li>
              @endcan
             @can('transfer-production-list')
              <li class="nav-item">
                <a href="{{url('transfer-production')}}" class="nav-link {{Route::is('transfer-production.*')   ? 'active' : '' }}"   ><i class="fa fa-list-alt nav-icon"></i><p> Transfer/Production </p></a>
              </li>
              @endcan
             @can('warranty-manage-menu')
              <li class="nav-item">
                <a href="{{url('warranty-manage')}}" class="nav-link {{Route::is('warranty-manage.*')   ? 'active' : '' }}"  ><i class="fa fa-list-alt nav-icon"></i><p> Warranty Management</p></a>
              </li>
              @endcan
             @can('item-replace-menu')
              <li class="nav-item">
                <a href="{{url('item-replace')}}" class="nav-link {{Route::is('item-replace.*')   ? 'active' : '' }}"  ><i class="fa fa-list-alt nav-icon"></i><p> Replacement Management</p></a>
              </li>
              @endcan
             @can('third-party-service-menu')
              <li class="nav-item">
                <a href="{{url('third-party-service')}}" class="nav-link {{Route::is('third-party-service.*')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p> Third Party Service</p></a>
              </li>
              @endcan
             @can('individual-replacement-menu')
              <li class="nav-item">
                <a href="{{url('individual-replacement')}}" class="nav-link {{Route::is('individual-replacement.*')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p> Individual Replacement</p></a>
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
                 Inventory Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @can('bill-party-statement')
              <li class="nav-item">
                <a href="{{url('bill-party-statement')}}" class="nav-link {{Route::is('bill-party-statement')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p>Bill of Party Statement</p></a>
              </li>
              @endcan
             @can('date-wise-purchase')
              <li class="nav-item">
                <a href="{{url('date-wise-purchase')}}" class="nav-link {{Route::is('date-wise-purchase')   ? 'active' : '' }}" ><i class="fa fa-list-alt nav-icon"></i><p>Date Wise Purchase</p></a>
              </li>
              @endcan
             @can('purchase-return-detail')
              <li class="nav-item">
                <a href="{{url('purchase-return-detail')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p>Purchase Return Detail</p></a>
              </li>
              @endcan
             @can('date-wise-sales')
              <li class="nav-item">
                <a href="{{url('date-wise-sales')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Date Wise Sales</p></a>
              </li>
              @endcan
             @can('sales-return-detail')
              <li class="nav-item">
                <a href="{{url('sales-return-detail')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Sales Return Details</p></a>
              </li>
              @endcan
             @can('stock-possition')
              <li class="nav-item">
                <a href="{{url('stock-possition')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Stock Possition</p></a>
              </li>
              @endcan
             @can('stock-ledger')
              <li class="nav-item">
                <a href="{{url('stock-ledger')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Stock Ledger</p></a>
              </li>
              @endcan
             @can('stock-value')
              <li class="nav-item">
                <a href="{{url('stock-value')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Stock Value</p></a>
              </li>
              @endcan
             @can('stock-value-register')
              <li class="nav-item">
                <a href="{{url('stock-value-register')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Stock Value Register</p></a>
              </li>
              @endcan
             @can('gross-profit')
              <li class="nav-item">
                <a href="{{url('gross-profit')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Gross Profit</p></a>
              </li>
              @endcan
             @can('expired-item')
              <li class="nav-item">
                <a href="{{url('expired-item')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Expired Item</p></a>
              </li>
              @endcan
             @can('shortage-item')
              <li class="nav-item">
                <a href="{{url('shortage-item')}}" class="nav-link " ><i class="fa fa-list-alt nav-icon"></i><p> Shortage Item</p></a>
              </li>
              @endcan
            
              
            </ul>
          </li>
          @endcan
            @can('account-report-menu') 
          <li class="nav-item {{ Route::is('ledger-report.*') || Route::is('group-ledger.*') || Route::is('income-statement.*') || Route::is('trail-balance.*') || Route::is('work-sheet.*') || Route::is('balance-sheet.*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('ledger-report.*') || Route::is('group-ledger.*') || Route::is('income-statement.*') || Route::is('trail-balance.*') || Route::is('work-sheet.*') || Route::is('balance-sheet.*')    ? 'active' : '' }}">
              <i class="fa fa-file nav-icon" aria-hidden="true"></i>
              <p>
                Accounts Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @can('ledger-report')
              <li class="nav-item">
                <a href="{{url('ledger-report')}}" class="nav-link {{Route::is('ledger-report.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>Ledger Report</p>
                </a>
              </li>
              @endcan
             @can('group-ledger')
              <li class="nav-item">
                <a href="{{url('group-ledger')}}" class="nav-link {{Route::is('group-ledger.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>Group Ledger Report</p>
                </a>
              </li>
              @endcan
             @can('ledger-summary-report')
              <li class="nav-item">
                <a href="{{url('filter-ledger-summary')}}" class="nav-link {{Route::is('filter-ledger-summary.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p> Ledger Summary Report</p>
                </a>
              </li>
              @endcan
             @can('income-statement')
              <li class="nav-item">
                <a href="{{url('income-statement')}}" class="nav-link {{Route::is('income-statement.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>Income Statement</p>
                </a>
              </li>
              @endcan
             @can('trail-balance')
              <li class="nav-item">
                <a href="{{url('trail-balance')}}" class="nav-link {{Route::is('trail-balance.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>Trail Balance</p>
                </a>
              </li>
              @endcan
             @can('work-sheet')
              <li class="nav-item">
                <a href="{{url('work-sheet')}}" class="nav-link {{Route::is('work-sheet.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>Work Sheet</p>
                </a>
              </li>
              @endcan
             @can('balance-sheet')
              <li class="nav-item">
                <a href="{{url('balance-sheet')}}" class="nav-link {{Route::is('balance-sheet.*')   ? 'active' : '' }}" >
                  <i class="fa fa-id-card nav-icon"></i>
                  <p>Balance Sheet</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan

           @can('inventory-menu') 
          <li class="nav-item {{ Route::is('account-type.*') || Route::is('account-group.*') || Route::is('unit.*')  || Route::is('item-information.*')  || Route::is('lot-item-information.*')  || Route::is('account-ledger.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link  Route::is('account-type.*') || Route::is('account-group.*')  || Route::is('unit.*')   || Route::is('item-information.*')    || Route::is('lot-item-information.*')   || Route::is('account-ledger.*')   ? 'active' : '' }}">
              <i class="fa fa-file nav-icon" aria-hidden="true"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @can('account-type-list')
              <li class="nav-item">
                <a href="{{url('account-type')}}"  class="nav-link {{Route::is('account-type.*')   ? 'active' : '' }}" ><i class="fa fa-sitemap nav-icon"></i> <p>Account Type</p></a>
              </li>
              @endcan
             @can('account-group-list')
              <li class="nav-item">
                <a href="{{url('account-group')}}"  class="nav-link {{Route::is('account-group.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Account Group</p></a>
              </li>
              @endcan
             @can('account-ledger-list')
              <li class="nav-item">
                <a href="{{url('account-ledger')}}"  class="nav-link {{Route::is('account-ledger.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Account Ledger</p></a>
              </li>
              @endcan
             @can('item-category-list')
              <li class="nav-item">
                <a href="{{url('item-category')}}"  class="nav-link {{Route::is('item-category.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Item Category</p></a>
              </li>
              @endcan
             
             @can('warranty-list')
              <li class="nav-item">
                <a href="{{url('warranty')}}"  class="nav-link {{Route::is('warranty.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Warranty</p></a>
              </li>
              @endcan
             @can('unit-list')
              <li class="nav-item">
                <a href="{{url('unit')}}"  class="nav-link {{Route::is('unit.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Unit Of Measurment</p></a>
              </li>
              @endcan
             @can('vat-rules-list')
              <li class="nav-item">
                <a href="{{url('vat-rules')}}"  class="nav-link {{Route::is('vat-rules.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Vat Rules</p></a>
              </li>
              @endcan
             @can('transection_terms-list')
              <li class="nav-item">
                <a href="{{url('transection_terms')}}"  class="nav-link {{Route::is('transection_terms.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Transection Terms</p></a>
              </li>
              @endcan
             @can('item-information-list')
              <li class="nav-item">
                <a href="{{url('item-information')}}"  class="nav-link {{Route::is('item-information.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Item Information</p></a>
              </li>
              @endcan
             @can('lot-item-information')
              <li class="nav-item">
                <a href="{{url('lot-item-information')}}"  class="nav-link {{Route::is('lot-item-information.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Lot Item Information</p></a>
              </li>
              @endcan
             @can('labels-print')
              <li class="nav-item">
                <a href="{{url('labels-print')}}"  class="nav-link {{Route::is('labels-print.*')   ? 'active' : '' }}" ><i class="fa fa-laptop nav-icon"></i> <p>Labels Print</p></a>
              </li>
              @endcan

             
            </ul>
          </li>
          @endcan
          <li class="nav-item {{ Route::is('roles.*') || Route::is('users.*') || Route::is('sms-send.*') || Route::is('admin-settings') || Route::is('branch.*') || Route::is('social_media.*') || Route::is('cost-center.*') || Route::is('store-house.*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('roles.*') || Route::is('users.*') || Route::is('admin-settings') || Route::is('branch.*')  || Route::is('cost-center.*')|| Route::is('sms-send.*')  || Route::is('store-house.*')   ? 'active' : '' }}">
            
               <i class="fas fa-cog nav-icon"></i> 
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               @can('admin-settings')
              <li class="nav-item">

                <a href="{{url('admin-settings')}}" class="nav-link {{Route::is('admin-settings')   ? 'active' : '' }}">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p>General Settings</p>
                </a>
              </li>
              @endcan
            
               @can('bulk-sms')
              <li class="nav-item">

                <a href="{{url('sms-send')}}" class="nav-link {{Route::is('sms-send')   ? 'active' : '' }}">
                  <i class="fa fa-asterisk nav-icon"></i> 
                  <p>SMS SEND</p>
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
                  <p>Role</p>
                </a>
              </li>
              @endcan
              @can('user-list')
              <li class="nav-item">
                <a href="{{url('users')}}" class="nav-link {{Route::is('users.*')   ? 'active' : '' }}">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              @endcan
              @can('branch-list')
              <li class="nav-item">
                <a href="{{url('branch')}}" class="nav-link {{Route::is('branch.*')   ? 'active' : '' }}">
                 <i class="fa fa-share-alt nav-icon"></i>
                  <p>Branch</p>
                </a>
              </li>
              @endcan
              @can('cost-center-list')
              <li class="nav-item">
                <a href="{{url('cost-center')}}" class="nav-link {{Route::is('cost-center.*')   ? 'active' : '' }}">
                  <i class="fa fa-adjust nav-icon"></i>
                  <p>Cost Center</p>
                </a>
              </li>
              @endcan
              @can('store-house-list')
              <li class="nav-item">
                <a href="{{url('store-house')}}" class="nav-link {{Route::is('store-house.*')   ? 'active' : '' }}">
                  <i class="fas fa-store  nav-icon"></i>
                  <p>Store House</p>
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