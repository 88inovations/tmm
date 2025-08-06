
<nav class="main-header navbar navbar-expand  navbar-light" id="ewMobileMenu">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    	
       @can('student_management') 
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           {{ __('label.student_management') }} <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
     
     
         @can('admission_fee_collection')
        <div style="display: flex;">
         <a href="{{route('admission_fee_collection_list')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.admission_fee_collection') }}
          </a>
          <a  href="{{route('admission_fee_collection')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
         @can('stm_collection_list')
        <div style="display: flex;">
         <a href="{{route('stm_collection.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_collection') }}
          </a>
          <a  href="{{route('stm_collection.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
         @can('stm_bill_masters_list')
        <div style="display: flex;">
         <a href="{{route('stm_bill_masters.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_bill_masters') }}
          </a>
          @can('stm_bill_masters_create')
          <a  href="{{route('stm_bill_masters.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
          @endcan
        </div>
        @endcan

         @can('stm_students_list')
        <div style="display: flex;">
         <a href="{{route('stm_students.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_students') }}
          </a>
          <a  href="{{route('stm_students.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan

        
         @can('stm_education_sessions_list')
        <div style="display: flex;">
         <a href="{{route('stm_education_sessions.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_education_sessions') }}
          </a>
          <a  href="{{route('stm_education_sessions.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
         @can('stm_division_class_students')
        <div style="display: flex;">
         <a href="{{route('stm_division_class_students')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_division_class_students') }}
          </a>
        
        </div>
        @endcan
         @can('stm_income_ledger_setups')
        <div style="display: flex;">
         <a href="{{route('stm_income_ledger_setups')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_income_ledger_setups') }}
          </a>
        
        </div>
        @endcan

         @can('stm_divisions_list')
        <div style="display: flex;">
         <a href="{{route('stm_divisions.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_divisions') }}
          </a>
          <a  href="{{route('stm_divisions.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
         @can('stm_classes_list')
        <div style="display: flex;">
         <a href="{{route('stm_classes.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_classes') }}
          </a>
          <a  href="{{route('stm_classes.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
         @can('stm_subjects_list')
        <div style="display: flex;">
         <a href="{{route('stm_subjects.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.stm_subjects') }}
          </a>
          <a  href="{{route('stm_subjects.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
       
       
       
      </li>
    @endcan

        @can('asset-management-report')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ __('label.asset') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                    @can('asset-location-list')
                        <div style="display: flex;">
                            <a href="{{ route('asset-location.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset-location') }}
                            </a>
                            <a href="{{ route('asset-location.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset-actual-location-list')
                        <div style="display: flex;">
                            <a href="{{ route('asset-actual-location.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset-actual-location') }}
                            </a>
                            <a href="{{ route('asset-actual-location.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('inspection-check-category-list')
                        <div style="display: flex;">
                            <a href="{{ route('inspection-check-category.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.inspection-check-category') }}
                            </a>
                            <a href="{{ route('inspection-check-category.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('inspection-check-list')
                        <div style="display: flex;">
                            <a href="{{ route('inspection-check.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.inspection-check') }}
                            </a>
                            <a href="{{ route('inspection-check.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset-condition-list')
                        <div style="display: flex;">
                            <a href="{{ route('asset-condition.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset-condition') }}
                            </a>
                            <a href="{{ route('asset-condition.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset-condition-list')
                        <div style="display: flex;">
                            <a href="{{ route('assign-status.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.assign-status') }}
                            </a>
                            <a href="{{ route('assign-status.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset-entry-assign-list')
                        <!-- <div style="display: flex;">
                 <a href="{{ route('asset-entry-assign.index') }}" class="dropdown-item">
                    <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset-entry-assign') }}
                  </a>
                  <a  href="{{ route('asset-entry-assign.create') }}" class="dropdown-item text-right">
                    <i class="nav-icon fas fa-plus"></i>
                  </a>
                </div> -->
                    @endcan
                    @can('asset-entry-assign-list')
                        <div style="display: flex;">
                            <a href="{{ route('asset_item_entry.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset_item_entry') }}
                            </a>
                            <a href="{{ route('asset_item_entry.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('asset_depreciation-list')
                        <div style="display: flex;">
                            <a href="{{ route('asset_depreciation.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset_depreciation') }}
                            </a>
                            <a href="{{ route('asset_depreciation.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset_maintainces-list')
                        <div style="display: flex;">
                            <a href="{{ route('asset_maintainces.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset_maintainces') }}
                            </a>
                            <a href="{{ route('asset_maintainces.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset_eng_consumptions_list')
                        <div style="display: flex;">
                            <a href="{{ route('asset_eng_consumptions.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset_eng_consumptions') }}
                            </a>
                            <a href="{{ route('asset_eng_consumptions.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset_sales_list')
                        <div style="display: flex;">
                            <a href="{{ route('asset_sales_list') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset_sales') }}
                            </a>
                            <a href="{{ route('asset_sales_create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset_sales_list')
                        <div style="display: flex;">
                            <a href="{{ url('asset-management/report') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.report') }}
                            </a>
                        </div>
                    @endcan


            </li>
        @endcan

        @can('hrm-module')
            <li class="nav-item dropdown remove_from_header ">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ __('label.hrm') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <p style="padding-left: 20px;"><b>{{ __('label.leave') }}</b></p>
                    <div class="dropdown-divider"></div>
                    @can('hrm-attandance-list')
                        <div style="display: flex;">
                            <a href="{{ url('attandance') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-attandance') }}
                            </a>
                            <a href="{{ route('attandance.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('week-work-day')
                        <div style="display: flex;">
                            <a href="{{ url('weekworkday') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.weekworkday') }}
                            </a>
                        </div>
                    @endcan
                    @can('holidays-list')
                        <div style="display: flex;">
                            <a href="{{ url('holidays') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.holidays') }}
                            </a>
                        </div>
                    @endcan
                    @can('leave-type-list')
                        <div style="display: flex;">
                            <a href="{{ url('leave-type') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.leave-type') }}
                            </a>
                            <a href="{{ route('leave-type.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('hrm-employee-list')
                        <p style="padding-left: 20px;"><b>{{ __('label.hrm-employee') }}</b></p>
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('hrm-employee') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-employee') }}
                            </a>
                            <a href="{{ route('hrm-employee.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('salary_sheet_list')
                        <p style="padding-left: 20px;"><b>{{ __('label.salary_sheet') }}</b></p>
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('salary_sheet_list') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.salary_sheet') }}
                            </a>
                            <a href="{{ url('salary_sheet') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    <p style="padding-left: 20px;"><b>{{ __('label.payrol-information') }}</b></p>
                    <div class="dropdown-divider"></div>
                    @can('monthly-salary-structure-list')
                        <div style="display: flex;">
                            <a href="{{ url('monthly-salary-structure') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.monthly-salary-structure') }}
                            </a>
                            <a href="{{ route('monthly-salary-structure.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('initial-salary-structure-list')
                        <div style="display: flex;">
                            <a href="{{ url('initial-salary-structure') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.initial-salary-structure') }}
                            </a>
                            <a href="{{ route('initial-salary-structure.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('pay-heads-list')
                        <div style="display: flex;">
                            <a href="{{ url('pay-heads') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.pay-heads') }}
                            </a>
                            <a href="{{ route('pay-heads.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('hrm-department-list')
                        <div style="display: flex;">
                            <a href="{{ url('hrm-department') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-department') }}
                            </a>
                            <a href="{{ route('hrm-department.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('hrm-grade-list')
                        <div style="display: flex;">
                            <a href="{{ url('hrm-grade') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-grade') }}
                            </a>
                            <a href="{{ route('hrm-grade.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('hrm-emp-location-list')
                        <div style="display: flex;">
                            <a href="{{ url('hrm-emp-location') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-emp-location') }}
                            </a>
                            <a href="{{ route('hrm-emp-location.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('zones-list')
                        <div style="display: flex;">
                            <a href="{{ url('zones') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.zones') }}
                            </a>
                            <a href="{{ route('zones.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('hrm-emp-category-list')
                        <div style="display: flex;">
                            <a href="{{ url('hrm-emp-category') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-emp-category') }}
                            </a>
                            <a href="{{ route('hrm-emp-category.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('hrm-designation-list')
                        <div style="display: flex;">
                            <a href="{{ url('hrm-designation') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.hrm-designation') }}
                            </a>
                            <a href="{{ route('hrm-designation.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

            </li>
        @endcan

       @can('quaterly_insentive_setups-list')
      <li class="nav-item dropdown remove_from_header">
        <a class="nav-link" data-toggle="dropdown" href="#">
           {{ __('Others') }} <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
       <div class="dropdown-divider"></div>
        <p class="text-center">{{__('label.honorarium_module')}}</p>
        @can('honorim_setups_list')
         <div style="display: flex;">
         <a href="{{route('honorim_setups.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.honorim_setups') }}
          </a>
          <a  href="{{route('honorim_setups.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('honorarium_bills_list')
         <div style="display: flex;">
         <a href="{{route('honorarium_bills.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.honorarium_bills') }}
          </a>
          <a  href="{{route('honorarium_bills.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('honorarium_payments_list')
         <div style="display: flex;">
         <a href="{{route('honorarium_payments.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.honorarium_payments') }}
          </a>
          <a  href="{{route('honorarium_payments.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('honorarium_report')
         <div style="display: flex;">
         <a href="{{route('honorarium_report')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.honorarium_report') }}
          </a>
          
        </div>
        @endcan

       <div class="dropdown-divider"></div>
        @can('sales_commision_plans-list')
         <div style="display: flex;">
         <a href="{{route('sales_commision_plans.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.sales_commision_plans') }}
          </a>
          <a  href="{{route('sales_commision_plans.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('quaterly_insentive_setups-list')
         <div style="display: flex;">
         <a href="{{route('quaterly_insentive_setups.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.quaterly_insentive_setups') }}
          </a>
          <a  href="{{route('quaterly_insentive_setups.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('monthly_sales_targets-list')
         <div style="display: flex;">
         <a href="{{route('monthly_sales_targets.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.monthly_sales_targets') }}
          </a>
          <a  href="{{route('monthly_sales_targets.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('monthly_sales_targets-list')
         <div style="display: flex;">
         <a href="{{url('customer_sales_target_list')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.customer_sales_target_list') }}
          </a>
          
        </div>
        @endcan
        
        @can('item_bonus_setups-list')
         <div style="display: flex;">
         <a href="{{route('item_bonus_setups.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.item_bonus_setups') }}
          </a>
          <a  href="{{route('item_bonus_setups.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('ta_da_setups-list')
         <div style="display: flex;">
         <a href="{{route('ta_da_setups.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.ta_da_setups') }}
          </a>
          <a  href="{{route('ta_da_setups.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
        @can('cat_wise_ta_bills-list')
         <div style="display: flex;">
         <a href="{{route('cat_wise_ta_bills.index')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.cat_wise_ta_bills') }}
          </a>
          <a  href="{{route('cat_wise_ta_bills.create')}}" class="dropdown-item text-right">
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
        @endcan
       
      </li>
   
 @endcan
        
        
        @can('inventory-menu')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">

                    {{ __('label.productmenu') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @can('item-category-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('item-category') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.Item Category') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('item-category.create') }}">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>

                        </div>
                    @endcan
                    @can('item-brand-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('item-brand') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.item_brand') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('item-brand.create') }}"><i
                                    class="nav-icon fas fa-plus"></i></a>
                        </div>
                    @endcan
                    @can('pack-size-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('pack-size') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.pack_size') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('pack-size.create') }}"><i
                                    class="nav-icon fas fa-plus"></i></a>
                        </div>
                    @endcan
                    @can('unit-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('unit') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.Unit Of Measurment') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('unit.create') }}">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>

                        </div>
                    @endcan
                    @can('warranty-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('warranty') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.Warranty') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('warranty.create') }}">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>

                        </div>
                    @endcan
                    
                    
                    @can('item-information-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('item-information') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.Item Information') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('item-information.create') }}">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('musak-four-point-three-menu')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            @can('musak-four-point-three-list')
                                <a href="{{ url('musak-four-point-three') }}" class="dropdown-item">
                                    <i class="fa fa-table mr-2" aria-hidden="true"></i> Item Wise Ingredients
                                </a>
                            @endcan
                            @can('musak-four-point-three-create')
                                <a href="{{ route('musak-four-point-three.create') }}" class="dropdown-item text-right">
                                    <i class="nav-icon fas fa-plus"></i>
                                </a>
                            @endcan
                        </div>
                    @endcan
                    @can('lot-item-information')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('lot-item-information') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Lot Item Information') }}
                            </a>

                        </div>
                    @endcan
                    @can('labels-print')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('labels-print') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.Labels Print') }}
                            </a>

                        </div>
                    @endcan
                    
            </li>
        @endcan
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown"> </li>
        @can('inventory-menu')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">

                    {{ __('label.purchasemenu') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @can('opening-inventory-entry')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('opening-inventory-entry') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.openingInventory') }}
                            </a>
                        </div>
                    @endcan
                    @can('purchase-order-list')
                        <div style="display: flex;">
                            <a href="{{ url('purchase-order') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.purchase order') }}
                            </a>
                            <a href="{{ route('purchase-order.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('purchase-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('purchase') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.material_receive') }}
                            </a>

                            <a href="{{ route('purchase.create') }}" class="dropdown-item text-right  ">
                                <i class="nav-icon fas fa-plus"></i> </a>


                        </div>
                    @endcan

                    @can('purchase-return-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('purchase-return') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i> {{ __('label.material_return') }}
                            </a>
                            <a href="{{ route('purchase-return.create') }}" class="dropdown-item text-right  ">
                                <i class="nav-icon fas fa-plus"></i> </a>
                        </div>
                    @endcan
                    
                    @can('restaurant-module')
                        <div class="dropdown-divider"></div>
                        <p style="text-align: center;"><b>Restaurant</b></p>

                        <div style="display: flex;">
                            @can('restaurant-pos')
                                <a href="{{ url('restaurant-pos') }}" class="dropdown-item">
                                    <i class="fa fa-table mr-2" aria-hidden="true"></i> {{ __('label.Restaurant POS') }}
                                </a>
                            @endcan
                        </div>
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            @can('restaurant-sales-list')
                                <a href="{{ url('restaurant-sales') }}" class="dropdown-item">
                                    <i class="fa fa-table mr-2" aria-hidden="true"></i> {{ __('label.Restaurant Sales') }}
                                </a>
                            @endcan
                            @can('restaurant-sales-create')
                                <a href="{{ route('restaurant-sales.create') }}" class="dropdown-item text-right">
                                    <i class="nav-icon fas fa-plus"></i>
                                </a>
                            @endcan
                        </div>

                        @can('kitchen-menu')
                            <div style="display: flex;">
                                @can('kitchen-list')
                                    <a href="{{ url('kitchen') }}" class="dropdown-item">
                                        <i class="fa fa-table mr-2" aria-hidden="true"></i> Kitchen Panel
                                    </a>
                                @endcan
                            </div>
                        @endcan
                    @endcan

            </li>
        @endcan
        
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown"> </li>
        @can('inventory-menu')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">

                    {{ __('label.salesmenu') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    
                    @can('production-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('production') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i>
                                {{ __('label.finished_goods_fabrication') }}
                            </a>
                            <a href="{{ route('production.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('partical-production-receive')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('partical_production_receive_list') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i>
                                {{ __('label.finished_goods_receive_to_stock') }}
                            </a>
                            <a href="{{ url('partical-production-receive') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('sales-list-wl')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('direct-sales') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> {{ __('label.direct_sales') }}
                            </a>
                            <a href="{{ route('direct-sales.create') }}" class="dropdown-item text-right  ">
                                <i class="nav-icon fas fa-plus"></i> </a>

                            </a>
                        </div>
                    @endcan
                    @can('sales_return_wlm-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('sales_return_wlm') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                                {{ __('label.sales_return_wlm') }}
                            </a>
                            <a href="{{ route('sales_return_wlm.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('security_deposits-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('security_deposits') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                                {{ __('label.security_deposits') }}
                            </a>
                            <a href="{{ route('security_deposits.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan


                    @can('avaiable_product_list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('product_show') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                                {{ __('label.avaiable_product_list') }}
                            </a>

                        </div>
                    @endcan

                    @can('sales-order-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('sales-order') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                                {{ __('label.sales-order-list') }}
                            </a>
                            <a href="{{ route('sales-order.create') }}" class="dropdown-item text-right  ">
                                <i class="nav-icon fas fa-plus"></i> </a>
                            </a>
                        </div>
                    @endcan
                    @can('pos-sales-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('sales') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> {{ __('label.pos sales-list') }}
                            </a>
                            <a href="{{ url('pos-sales') }}" class="dropdown-item text-right">
                                <i class="fa fa-shopping-cart " style="color: green;margin-top: 9px;" aria-hidden="true"></i>
                            </a>
                        </div>
                    @endcan

                    @can('sales-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('sales') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> {{ __('label.material_issue') }}
                            </a>
                            <a href="{{ route('sales.create') }}" class="dropdown-item text-right  ">
                                <i class="nav-icon fas fa-plus"></i> </a>

                            </a>
                        </div>
                    @endcan
                    @can('sales-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('sales') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> {{ __('label.sales_form_two') }}
                            </a>
                            <a href="{{ route('sales_form_two') }}" class="dropdown-item text-right  ">
                                <i class="nav-icon fas fa-plus"></i> </a>

                            </a>
                        </div>
                    @endcan
                    @can('sales-return-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('sales-return') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                                {{ __('label.issued_material_return') }}
                            </a>
                            <a href="{{ route('sales-return.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('previous_sales_return-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('previous_sales_return') }}" class="dropdown-item">
                                <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                                {{ __('label.previous_sales_return') }}
                            </a>
                            <a href="{{ route('previous_sales_return.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('material-issue-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('material-issue') }}" class="dropdown-item">
                                <i class="fa fa-arrow-circle-right mr-2" aria-hidden="true"></i>
                                {{ __('label.material_issued') }}
                            </a>
                            <a href="{{ route('material-issue.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('material-issue-return-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('material-issue-return') }}" class="dropdown-item">
                                <i class="fa fa-arrow-circle-down mr-2" aria-hidden="true"></i>
                                {{ __('label.material_issue_return') }}
                            </a>
                            <a href="{{ route('material-issue-return.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan


                    @can('transfer-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('transfer') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.project_to_transfer') }}
                            </a>
                            <a href="{{ route('transfer.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan



                    @can('third-party-service-menu')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('third-party-service') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2"
                                    aria-hidden="true"></i>{{ __('label.third-party-service-list') }}
                            </a>
                            <a href="{{ route('third-party-service.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('warranty-manage-menu')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('warranty-manage') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.warranty-manage-list') }}
                            </a>
                            <a href="{{ route('warranty-manage.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('item-replace-menu')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('item-replace') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i>{{ __('label.item-replace-list') }}
                            </a>
                            <a href="{{ route('item-replace.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan


                    @can('individual-replacement-menu')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('individual-replacement') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2"
                                    aria-hidden="true"></i>{{ __('label.individual-replacement-list') }}
                            </a>
                            <a href="{{ route('individual-replacement.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('w-item-receive-from-supp-menu')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('w-item-receive-from-supp') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2"
                                    aria-hidden="true"></i>{{ __('label.w-item-receive-from-supp-list') }}
                            </a>
                            <a href="{{ route('w-item-receive-from-supp.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
            </li>
        @endcan
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown"> </li>
        @can('DM_module')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">

                    {{ __('label.DM') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @can('damage-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('damage') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.damage_adjustment') }}
                            </a>
                            <a href="{{ route('damage.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('damage_receive-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('damage_receive') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.damage_receive') }}
                            </a>
                            <a href="{{ route('damage_receive.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('damage_receive-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('damage_from_stocks') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.damage_from_stocks') }}
                            </a>
                            <a href="{{ route('damage_from_stocks.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('damage_send-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('damage_send') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.damage_send') }}
                            </a>
                            <a href="{{ route('damage_send.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('damage_report')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('damage_report') }}" class="dropdown-item">
                                <i class="fa fa-recycle mr-2" aria-hidden="true"></i> {{ __('label.damage_report') }}
                            </a>
                        </div>
                    @endcan
            </li>
        @endcan
        @can('account-menu')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ __('label.Accounts') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @can('cash-receive')
                        <div style="display: flex;">
                            <a href="{{ url('voucher') }}?_voucher_type=CR" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Cash Receive') }}
                            </a>
                            <a href="{{ url('cash-receive') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('cash-payment')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('voucher') }}?_voucher_type=CP" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Cash Payment') }}
                            </a>
                            <a href="{{ url('cash-payment') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('petty-cash')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('voucher') }}?_voucher_type=PC" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('Petty Cash') }}
                            </a>
                            <a href="{{ url('petty-cash') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('bank-receive')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('voucher') }}?_voucher_type=BR" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Bank Receive') }}
                            </a>
                            <a href="{{ url('bank-receive') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('bank-payment')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('voucher') }}?_voucher_type=BP" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Bank Payment') }}
                            </a>
                            <a href="{{ url('bank-payment') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

                    @can('voucher-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('voucher') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Voucher') }}
                            </a>
                            <a href="{{ route('voucher.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('easy-voucher-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('easy-voucher') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Easy Voucher') }}
                            </a>
                            <a href="{{ route('easy-voucher.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('inter-project-voucher-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('inter-project-voucher') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.inter-project-voucher') }}
                            </a>
                            <a href="{{ route('inter-project-voucher.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('supplier_payment_list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('supplier_payment') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.supplier_payment') }}
                            </a>
                            <a href="{{ route('supplier_payment.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('customer_payment_list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('customer_payment') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.customer_payment') }}
                            </a>
                            <a href="{{ route('customer_payment.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('so_wise_due_invoice')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('so_wise_due_invoice') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.so_wise_due_invoice') }}
                            </a>
                        </div>
                    @endcan

            </li>
        @endcan
        @can('import_module')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    Import <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <p style="padding-left: 20px;"><b>{{ __('label.entry') }}</b></p>
                    <div class="dropdown-divider"></div>
                    @can('approval-chain-list')
                        <div style="display: flex;">
                            <a href="{{ route('approval-chain.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.approval-chain') }}
                            </a>
                            <a href="{{ route('approval-chain.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('rlp-list')
                        <div style="display: flex;">
                            <a href="{{ route('rlp.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.rlp-info') }}
                            </a>
                            <a href="{{ route('rlp.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('lc_manage-list')
                        <div style="display: flex;">
                            <a href="{{ route('lc_manage.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.lc_manage') }}
                            </a>
                            <a href="{{ route('lc_manage.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('import-purchase-list')
                        <div style="display: flex;">
                            <a href="{{ route('import-purchase.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.import-purchase') }}
                            </a>
                            <a href="{{ route('import-purchase.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('import-material-receive-list')
                        <div style="display: flex;">
                            <a href="{{ route('import-material-receive.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.import-material-receive') }}
                            </a>
                            <a href="{{ route('import-material-receive.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    @can('asset_import_cost_list')
                        <div style="display: flex;">
                            <a href="{{ route('asset_import_cost.index') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.asset_import_cost') }}
                            </a>
                            <a href="{{ route('asset_import_cost.create') }}" class="dropdown-item text-right">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan

            </li>
        @endcan

        

        <li class="nav-item remove_from_header">

            <a href="{{ url('report-panel') }}" class="nav-link custom_nav_item" title="Report">
                Report
            </a>
        </li>
        
        
        
        @can('inventory-menu')
            <li class="nav-item dropdown remove_from_header">
                <a class="nav-link" data-toggle="dropdown" href="#">

                    {{ __('label.Master') }} <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    @can('account-type-list')
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('account-type') }}" class="dropdown-item">
                            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.Account Type') }}
                        </a>
                    @endcan
                    @can('account-group-list')
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('account-group') }}" class="dropdown-item">
                            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Account Group') }}
                        </a>
                    @endcan
                    
                    @can('account-ledger-list')
                        <div class="dropdown-divider"></div>

                        <div style="display: flex;">
                            <a href="{{ url('account-ledger') }}" class="dropdown-item">
                                <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.Account Ledger') }}
                            </a>

                            <a href="{{ route('account-ledger.create') }}" class="dropdown-item text-right ">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>
                        </div>
                    @endcan
                    
                    @can('customer_list')
         <div class="dropdown-divider"></div>
          
        <div style="display: flex;">
          <a href="{{url('customer_list')}}" class="dropdown-item">
            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.customer_list') }}
          </a>
          
           <a  href="{{route('customer_create')}}" class="dropdown-item text-right "  >
            <i class="nav-icon fas fa-plus"></i>
          </a>
        </div>
          
         @endcan

                    
                    @can('budgets-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('budgets') }}" class="dropdown-item">
                                <i class="fas fa-store   mr-2"></i>{{ __('label.budgets') }}
                            </a>
                            <a href="{{ route('budgets.create') }}" class="dropdown-item text-right ">
                                <i class="nav-icon fas fa-plus"></i> </a>
                        </div>
                    @endcan

                    @can('transection_terms-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('transection_terms') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.Transection Terms') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('transection_terms.create') }}">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>


                        </div>
                    @endcan

                    @can('vat-rules-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('vat-rules') }}" class="dropdown-item">
                                <i class="fa fa-laptop mr-2" aria-hidden="true"></i>{{ __('label.Vat Rules') }}
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('vat-rules.create') }}">
                                <i class="nav-icon fas fa-plus"></i>
                            </a>

                        </div>
                    @endcan

                   
                    @can('vessel-info-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('vessel-info') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.vessel-info') }}
                            </a>

                        </div>
                    @endcan
                    @can('mother-vessel-info-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('mother-vessel-info') }}" class="dropdown-item">
                                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>{{ __('label.mother-vessel-info') }}
                            </a>

                        </div>
                    @endcan

                    @can('restaurant-module')
                        <p style="text-align: center;margin-bottom: 1px solid #000;"><b>Resturant Module</b></p>
                        @can('table-info-menu')
                            <div style="display: flex;">
                                @can('table-info-list')
                                    <a href="{{ url('table-info') }}" class="dropdown-item">
                                        <i class="fa fa-table mr-2" aria-hidden="true"></i> Table Information
                                    </a>
                                @endcan
                                @can('table-info-create')
                                    <a href="{{ route('table-info.create') }}" class="dropdown-item text-right">
                                        <i class="nav-icon fas fa-plus"></i>
                                    </a>
                                @endcan
                            </div>
                        @endcan
                        @can('steward-waiter-menu')
                            <div class="dropdown-divider"></div>
                            <div style="display: flex;">
                                @can('steward-waiter-list')
                                    <a href="{{ url('steward-waiter') }}" class="dropdown-item">
                                        <i class="fa fa-table mr-2" aria-hidden="true"></i> Steward Waiter Setup
                                    </a>
                                @endcan
                                @can('steward-waiter-create')
                                    <a href="{{ route('steward-waiter.create') }}" class="dropdown-item text-right">
                                        <i class="nav-icon fas fa-plus"></i>
                                    </a>
                                @endcan
                            </div>
                        @endcan


                        @can('category-allocation-list')
                            <div class="dropdown-divider"></div>
                            <div style="display: flex;">
                                @can('category-allocation-list')
                                    <a href="{{ url('category-allocation') }}" class="dropdown-item">
                                        <i class="fa fa-table mr-2" aria-hidden="true"></i>Pos Dispaly Category
                                    </a>
                                @endcan

                            </div>
                        @endcan
                    @endcan
            </li>
        @endcan

        <li class="nav-item dropdown remove_from_header">
            <a class="nav-link" data-toggle="dropdown" href="#">

                {{ __('label.Settings') }} <i class="right fas fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                @can('admin-settings')
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('admin-settings') }}" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> {{ __('label.General Settings') }}
                    </a>
                @endcan
                @can('bulk-sms')
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('sms-send') }}" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> {{ __('label.SMS SEND') }}
                    </a>
                @endcan
                @can('invoice-prefix')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('invoice-prefix') }}" class="dropdown-item">
                            <i class="fas fa-cog    mr-2"></i>{{ __('label.Invoice Prefix') }}
                        </a>
                    </div>
                @endcan
                @can('role-list')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('roles') }}" class="dropdown-item">
                            <i class="fa fa-server  mr-2" aria-hidden="true"></i>{{ __('label.Roles') }}
                        </a>
                        <a class="dropdown-item text-right " href="{{ route('roles.create') }}">
                            <i class="nav-icon fas fa-plus"></i> </a>
                    </div>
                @endcan
                @can('user-list')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('users') }}" class="dropdown-item">
                            <i class="fas fa-users  mr-2"></i> {{ __('label.Users') }}
                        </a>
                        <a class="dropdown-item text-right " href="{{ route('users.create') }}">
                            <i class="nav-icon fas fa-plus"></i> </a>
                    </div>
                @endcan
                @can('security_deposits-list')
                    <div class="dropdown-divider"></div>

                    <div style="display: flex;">
                        <a href="{{ url('security_deposits') }}" class="dropdown-item">
                            <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                            {{ __('label.security_deposits') }}
                        </a>
                        <a href="{{ route('security_deposits.create') }}" class="dropdown-item text-right">
                            <i class="nav-icon fas fa-plus"></i>
                        </a>
                    </div>
                @endcan
                @can('companies-list')
                    <div style="display: flex;">
                        <a href="{{ url('companies') }}" class="dropdown-item">
                            <i class="fa fa-fax mr-2" aria-hidden="true"></i> {{ __('label.companies') }}
                        </a>
                        <a href="{{ route('companies.create') }}" class="dropdown-item text-right">
                            <i class="nav-icon fas fa-plus"></i>
                        </a>
                    </div>
                @endcan
                @can('branch-list')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('branch') }}" class="dropdown-item">
                            <i class="fa fa-share-alt mr-2" aria-hidden="true"></i> {{ __('label.Branch') }}
                        </a>
                        <a class="dropdown-item text-right " href="{{ route('branch.create') }}">
                            <i class="nav-icon fas fa-plus"></i> </a>
                    </div>
                @endcan
                @can('cost-center-list')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('cost-center') }}" class="dropdown-item">
                            <i class="fa fa-adjust mr-2" aria-hidden="true"></i> {{ __('label.Cost center') }}
                        </a>
                        <a class="dropdown-item text-right " href="{{ route('cost-center.create') }}">
                            <i class="nav-icon fas fa-plus"></i> </a>
                    </div>
                    @can('store-house-list')
                        <div class="dropdown-divider"></div>
                        <div style="display: flex;">
                            <a href="{{ url('store-house') }}" class="dropdown-item">
                                <i class="fa fa-adjust mr-2" aria-hidden="true"></i> Store House
                            </a>
                            <a class="dropdown-item text-right " href="{{ route('store-house.create') }}">
                                <i class="nav-icon fas fa-plus"></i> </a>
                        </div>
                    @endcan
                @endcan

                @can('budgets-list')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('budgets') }}" class="dropdown-item">
                            <i class="fas fa-store   mr-2"></i>{{ __('label.budgets') }}
                        </a>
                        <a href="{{ route('budgets.create') }}" class="dropdown-item text-right ">
                            <i class="nav-icon fas fa-plus"></i> </a>
                    </div>
                @endcan
                @can('account_group_configs')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('account_group_configs') }}" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i>{{ __('label.account_group_configs') }}
                        </a>
                    </div>
                @endcan
                @can('lock-permission')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('all-lock') }}" class="dropdown-item">
                            <i class="fas fa-lock _required   mr-2"></i>{{ __('label.Transection Lock System') }}
                        </a>
                    </div>
                @endcan
                @can('documents-list')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('documents') }}" class="dropdown-item">
                            <i class="fa fa-file    mr-2"></i>{{ __('label.documents') }}
                        </a>
                    </div>
                @endcan

                @can('database-backup')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('databaseBackup') }}" class="dropdown-item">
                            <i class="fa fa-database    mr-2"></i>{{ __('label.Data Backup') }}
                        </a>
                    </div>
                @endcan

                @can('database-backup')
                    <div class="dropdown-divider"></div>
                    <div style="display: flex;">
                        <a href="{{ url('clear-cache') }}" class="dropdown-item">
                            <i class="fa fa-database    mr-2"></i>Cache Clear
                        </a>
                    </div>
                @endcan




        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">User Name : <b>{{ Auth::user()->name ?? '' }}</b></span>
                <div class="dropdown-divider"></div>
                <div class="text-center">
                    <a href="{{ url('user-profile') }}">{{ __('label.profile') }}</a>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="dropdown-divider"></div>

            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link full_screen_show" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
