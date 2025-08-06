<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



use App\Http\Controllers\AssetManagement\AssetsDashboardController;
use App\Http\Controllers\AssetManagement\AssetsCategoryController;
use App\Http\Controllers\AssetManagement\AssetsConditionController;
use App\Http\Controllers\AssetManagement\AssetsLocationController;
use App\Http\Controllers\AssetManagement\AssetsDeviceLocationController;
use App\Http\Controllers\AssetManagement\AssetsVendorController;
use App\Http\Controllers\AssetManagement\AssetsUserController;
use App\Http\Controllers\AssetManagement\AssetAssignController;
use App\Http\Controllers\AssetManagement\AssetBrandController;
use App\Http\Controllers\AssetManagement\InspectionCheckCategoryController;
use App\Http\Controllers\AssetManagement\InspectionCheckListController;
use App\Http\Controllers\AssetManagement\AssignStatusController;
use App\Http\Controllers\AssetManagement\AssetReportController;
use App\Http\Controllers\AssetManagement\AssestDepreciationController;
use App\Http\Controllers\AssetManagement\AssestDisposalController;
use App\Http\Controllers\AssetManagement\AssetImportCostController;
use App\Http\Controllers\AssetManagement\AssetMaintainceController;
use App\Http\Controllers\AssetManagement\AssetEngConsumptionController;
use App\Http\Controllers\AssetManagement\AssetItemController;
use App\Http\Controllers\Settings\LanguageController;

use App\Http\Controllers\Basic\OrganizationController;
use App\Http\Controllers\Basic\BranchController;
use App\Http\Controllers\Basic\CostCenterController;
use App\Http\Controllers\Basic\StoreController;
use App\Http\Controllers\Basic\DepartmentController;
use App\Http\Controllers\Basic\DesignationController;








/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->prefix('basic')->group(function () {
    Route::resource('organizations', OrganizationController::class);
    Route::post('organization-relation',[OrganizationController::class,'organizationRelation']);
    Route::get('organizationWisechain',[OrganizationController::class,'organizationWisechain']);
    Route::get('user_base_org_chain',[OrganizationController::class,'user_base_org_chain']);
    Route::resource('branches', BranchController::class);
    Route::resource('cost-centers', CostCenterController::class);
    //Route::resource('store-house', StoreController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
});



Route::middleware(['auth'])->prefix('asset-management')->group(function () {
    Route::get('dashboard',[AssetsDashboardController::class,'index'])->name('asset-dashboard');
    Route::resource('asset-category', AssetsCategoryController::class);
    Route::get('category_detail', [AssetsCategoryController::class,'category_detail'])->name('category_detail');

    Route::resource('asset_depreciation', AssestDepreciationController::class);
    Route::get('asset_depreciation_detail/{id}', [AssestDepreciationController::class,'depDetail'])->name('asset_depreciation_detail');

    Route::get('asset_sales_create',[AssestDepreciationController::class,'asset_sales_create'])->name('asset_sales_create');
    Route::get('asset_search',[AssestDepreciationController::class,'asset_search'])->name('asset_search');
    Route::post('asset_sales_store',[AssestDepreciationController::class,'asset_sales_store'])->name('asset_sales_store');
    Route::get('asset_sales_list',[AssestDepreciationController::class,'asset_sales_list'])->name('asset_sales_list');
    Route::get('asset_sales_edit/{id}',[AssestDepreciationController::class,'asset_sales_edit'])->name('asset_sales_edit');
    Route::get('asset_sales_print/{id}',[AssestDepreciationController::class,'asset_sales_print'])->name('asset_sales_print');
    Route::get('asset_sales_delete/{id}',[AssestDepreciationController::class,'asset_sales_delete'])->name('asset_sales_delete');
    Route::resource('asset_disposal', AssestDisposalController::class);
    Route::resource('asset_import_cost', AssetImportCostController::class);
    Route::resource('asset_maintainces', AssetMaintainceController::class);
    Route::resource('asset_eng_consumptions', AssetEngConsumptionController::class);
    Route::get('import_cost_detail_ref', [AssetImportCostController::class,"import_cost_detail_ref"])->name("import_cost_detail_ref");
    Route::any('import_asset_file_upload', [AssetImportCostController::class,"import_asset_file_upload"])->name("import_asset_file_upload");
    Route::any('import_cost_setting_modal', [AssetImportCostController::class,"import_cost_setting_modal"])->name("import_cost_setting_modal");
    Route::any('import_modal_settings', [AssetImportCostController::class,"import_modal_settings"])->name("import_modal_settings");



    
    Route::resource('asset-condition', AssetsConditionController::class);
    Route::resource('asset_item_entry', AssetItemController::class);


    Route::resource('asset-brand', AssetBrandController::class);
    Route::resource('asset-location', AssetsLocationController::class);
    Route::resource('asset-actual-location', AssetsDeviceLocationController::class);
    Route::resource('asset-vendor', AssetsVendorController::class);
    Route::resource('asset-users', AssetsUserController::class);
    Route::resource('asset-entry-assign', AssetAssignController::class);
    Route::get('asset-entry-assign/delete/{id}', [AssetAssignController::class,'destroy']);
  
    Route::get('asset-assign-to-user/{id}', [AssetAssignController::class,'assetAssignToUser']);
    Route::get('return_from_user/{id}', [AssetAssignController::class,'returnFromUser']);
    Route::post('assign_to_user', [AssetAssignController::class,'assign_to_user'])->name('assign_to_user');
    Route::post('return-receive', [AssetAssignController::class,'returnReceived']);
    //Route::get('asset-detail/{id}', [AssetAssignController::class,'assetDetail']);
    Route::resource('inspection-check-category', InspectionCheckCategoryController::class);
    Route::resource('inspection-check', InspectionCheckListController::class);
    Route::resource('assign-status', AssignStatusController::class);
    
    Route::get('category-wise-asset/{id}', [AssetReportController::class,'categoryWiseAsset']);
    Route::get('brand-wise-asset/{id}', [AssetReportController::class,'brandWiseAsset']);
    Route::get('condition-wise-asset/{id}', [AssetReportController::class,'conditionWiseAsset']);
    Route::get('inspection-report/{id}', [AssetReportController::class,'inspectionReport']);




    // Asset Report Section
    Route::get('report',[AssetReportController::class,'AssetReportPage']);
    Route::get('single_asset_depriciation',[AssetReportController::class,'single_asset_depriciation'])->name('single_asset_depriciation');
    Route::get('single_asset_sales_report',[AssetReportController::class,'single_asset_sales_report'])->name('single_asset_sales_report');
    Route::get('asset_sales_report',[AssetReportController::class,'asset_sales_report'])->name('asset_sales_report');
    Route::get('asset_import_report',[AssetReportController::class,'asset_import_report'])->name('asset_import_report');
    Route::get('all_asset_import_report',[AssetReportController::class,'all_asset_import_report'])->name('all_asset_import_report');
    Route::get('depriciation_report_all',[AssetReportController::class,'depriciation_report_all'])->name('depriciation_report_all');
    Route::get('asset_valuation_report',[AssetReportController::class,'asset_valuation_report'])->name('asset_valuation_report');
    Route::get('asset_utilization_report',[AssetReportController::class,'asset_utilization_report'])->name('asset_utilization_report');
    Route::get('maintenance_and_repair_costs_report',[AssetReportController::class,'maintenance_and_repair_costs_report'])->name('maintenance_and_repair_costs_report');
    Route::get('total_asset_value_report',[AssetReportController::class,'total_asset_value_report'])->name('total_asset_value_report');
    Route::get('asset_age_report',[AssetReportController::class,'asset_age_report'])->name('asset_age_report');
    Route::get('asset_status_report',[AssetReportController::class,'asset_status_report'])->name('asset_status_report');
    Route::get('asset_location_report',[AssetReportController::class,'asset_location_report'])->name('asset_location_report');
    Route::get('insurance_coverage_report',[AssetReportController::class,'insurance_coverage_report'])->name('insurance_coverage_report');
    Route::get('asset_eng_consumptions_report',[AssetReportController::class,'asset_eng_consumptions_report'])->name('asset_eng_consumptions_report');

    



    Route::get('list-filter',[AssetReportController::class,'listFilter']);
    Route::post('filter-wise-search',[AssetReportController::class,'filterWiseSearch']);

    // Asset List Filter By Organization,Branch,Cost center,Category,Status,Condition,Vendor,
    // User Wise Asset Uses List
    // Asset Wise User List
    // As Date User Wise Asset Condition Compare History
    // Date Wise Purchase Asset List
    // Warranty Wise  Asset List
    // Vendor Wise Asset List
    // Individual Asset Full History

    //Route::get('')
});



Route::group(['middleware' => 'auth'], function () {

    //Asset Management 
    Route::get('assets-dashboard',[AssetsDashboardController::class,'index'])->name('assets-dashboard');
    Route::get('general-settings',[GeneralSettingsController::class,'settings'])->name('general-settings');
    Route::get('database-backup',[GeneralSettingsController::class,'databaseBackup'])->name('database-backup');
    Route::post('general-settings-save',[GeneralSettingsController::class,'settingsSave'])->name('general-settings-save');



    Route::resource('admin-language', LanguageController::class);
    Route::resource('admin-product-label', ProductLebelController::class);
    Route::resource('admin-product-brand', BrandController::class);
    Route::resource('admin-product-category', ProdcutCategoryController::class);
});

