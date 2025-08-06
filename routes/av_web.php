<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\HON\HonorimSetupController;
use App\Http\Controllers\HON\HonorariumBillController;
use App\Http\Controllers\HON\HonorariumPaymentController;
use App\Http\Controllers\HON\HonorariumReportController;



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


use App\Http\Controllers\CustomFormController;

Route::get('/custom-form/create', [CustomFormController::class, 'createForm'])->name('customform.create');
Route::post('/custom-form/store', [CustomFormController::class, 'storeForm'])->name('customform.store');
Route::get('/custom-form/generate/{id}', [CustomFormController::class, 'generateTable'])->name('customform.generate');




Route::group(['middleware' => 'auth'], function () {
//transection_terms Wise Sales Report :Group By Sales Invoice,Month and (Month and Teritory)
//INSERT INTO `permissions` (`id`, `name`, `module_name`, `guard_name`, `type`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'transection_terms_wise_sales', 'Sales And Distributor Report', 'web', 'Sales And Distributor Report', '1', '2025-01-21 01:12:41', NULL);

Route::get('transection_terms_wise_sales',[App\Http\Controllers\AV\AvReportController::class,'transection_terms_wise_sales'])->name('transection_terms_wise_sales');
Route::post('transection_terms_wise_sales_report',[App\Http\Controllers\AV\AvReportController::class,'transection_terms_wise_sales_report'])->name('transection_terms_wise_sales_report');







/*honorarium Section Start */
Route::resource('honorim_setups',HonorimSetupController::class);
Route::resource('honorarium_bills',HonorariumBillController::class);
Route::resource('honorarium_payments',HonorariumPaymentController::class);

Route::get('honorarium_report',[HonorariumReportController::class,'index'])->name('honorarium_report');
Route::get('honorarium_bill_sheet',[HonorariumReportController::class,'honorarium_bill_sheet'])->name('honorarium_bill_sheet');
Route::post('honorarium_bill_sheet_report',[HonorariumReportController::class,'honorarium_bill_sheet_report'])->name('honorarium_bill_sheet_report');
Route::get('honorarium_bill_sheet_reset',[HonorariumReportController::class,'honorarium_bill_sheet_reset'])->name('honorarium_bill_sheet_reset');


/*honorarium Section End */








    
});

