<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\AccountGroup;
use App\Models\AccountLedger;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\AccountHeadController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\StoreHouseController;
use App\Http\Controllers\AccountLedgerController;
use App\Http\Controllers\VoucherMasterController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\ReceivePaymentController;
use App\Http\Controllers\AccountReportController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemPackSizeController;
use App\Http\Controllers\ItemBrandController;

use App\Http\Controllers\AdvanceAccountReportController;

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PreviousSalesReturnController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesWithoutStockDeductController;
use App\Http\Controllers\PreviousBillItemSendController;
use App\Http\Controllers\SalesCommisionPlanController;
//use App\Http\Controllers\DamageFromStockController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\PurchaseOrderController;
//use App\Http\Controllers\DamageAdjustmentController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\BulkSmsController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TableInfoController;
use App\Http\Controllers\MusakFourPointThreeController;
use App\Http\Controllers\ResturantSalesController;
use App\Http\Controllers\ResturantFormSettingController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\VatRuleController;
use App\Http\Controllers\StewardAllocationController;
use App\Http\Controllers\RestaurantCategorySettingController;
use App\Http\Controllers\WarrantyMasterController;
use App\Http\Controllers\ReplacementMasterController;
use App\Http\Controllers\TransectionTermsController;
use App\Http\Controllers\ServiceMasterController;
use App\Http\Controllers\IndividualReplaceMasterController;
use App\Http\Controllers\EasyVoucherController;
use App\Http\Controllers\InterProjectVoucherController;
use App\Http\Controllers\WItemReceiveFromSupplierController;
use App\Http\Controllers\SalesOfficerReportController;
use App\Http\Controllers\CountryController;



use App\Http\Controllers\HrmEmployeesController;
use App\Http\Controllers\HrmWeekworkdayController;
use App\Http\Controllers\HrmHolidaysController;
use App\Http\Controllers\HrmLeavetypesController;
use App\Http\Controllers\HrmPayheadsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HrmDepartmentController;
use App\Http\Controllers\HrmGradeController;
use App\Http\Controllers\HrmEmpCategoryController;
use App\Http\Controllers\HrmEmpLocationController;
use App\Http\Controllers\HrmDesignationController;

use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MaterialIssueController;
use App\Http\Controllers\MaterialIssueReturnController;
use App\Http\Controllers\DirectProductionController;
use App\Http\Controllers\QuaterlyInsentiveSetupController;
use App\Http\Controllers\MonthlySalesTargetController;
use App\Http\Controllers\ItemBonusSetupController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ImportPuchaseController;
use App\Http\Controllers\ImportMRController;
use App\Http\Controllers\VesselInfoController;
use App\Http\Controllers\MotherVesselController;



use App\Http\Controllers\ItemRateHistorycontroller;
use App\Http\Controllers\SalesWithoutLotController;
use App\Http\Controllers\SalesReturnWlmController;
use App\Http\Controllers\SecurityDepositController;
use Illuminate\Support\Facades\Artisan;



use App\Http\Controllers\TaDaSetupController;
use App\Http\Controllers\CatWiseTaBillController;
use App\Http\Controllers\EmployeeDutyController;




use App\Http\Controllers\CylindarController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DataMigrationController;

//use App\Http\Controllers\DamageReceiveMasterController;
//use App\Http\Controllers\DamageSendMasterController;
use Illuminate\Support\Facades\DB;



Route::get('/clear-cache',function(){
 // Clear application cache
        Artisan::call('cache:clear');
        // Clear route cache
        Artisan::call('route:clear');
        // Clear configuration cache
        Artisan::call('config:clear');
        // Clear compiled views
        Artisan::call('view:clear');


        
        return response()->json([
            'status' => 'success',
            'message' => 'Cache cleared successfully!'
        ]);
});


Route::group(['middleware' => ['auth']], function() {
    Route::get('/data-migration', [DataMigrationController::class, 'showForm'])->name('data-migration.form');
    Route::post('/data-migration', [DataMigrationController::class, 'migrateData'])->name('data-migration.migrate');
});

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

Route::get('/', 'App\Http\Controllers\FrontendController@index');

Auth::routes();
Route::post('/login', 'App\Http\Controllers\CustomLoginController@login');
Route::get('inv/{id}','App\Http\Controllers\SalesController@OnlineInvoice');
Route::get('invoice_print','App\Http\Controllers\SalesController@invoice_print');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {




Route::get('openig_ledger_amount_to_voucher',function(){
    return openig_ledger_amount_to_voucher();
});

Route::get('all_inventory_stock_update',function(){
    return all_inventory_stock_update();
});

Route::get('ledger_balance_update',function(){
    return ledger_balance_update();
});


Route::get('account_table_voucher_code_update',function(){
    return account_table_voucher_code_update();
});







/*Old Database to New Database Update Process Start*/

Route::get('moveMissingTablesChunked',function(){
    return moveMissingTablesChunked();
});
Route::get('moveMissingTablesChunked_2',function(){
    return moveMissingTablesChunked_2();
});
Route::get('setDefaultZeroForNumericColumns',function(){
    return setDefaultZeroForNumericColumns();
});

Route::get('database_table_column_update',function(){
    return database_table_column_update();
});
Route::get('updateSpecificColumns',function(){
    return updateSpecificColumns();
});


Route::get('two_db_table_dirr',function(){
    return two_db_table_dirr();
});
Route::get('find_out_two_permission_table_data_diff_and_insert_second_db',function(){
    return find_out_two_permission_table_data_diff_and_insert_second_db();
});

Route::get('column_name_diff',function(){
    return column_name_diff();
});

Route::get('updateSecondDatabaseTablesWithData',function(){
return updateSecondDatabaseTablesWithData();
});

Route::get('set_default_unit_conversion',function(){
return set_default_unit_conversion();
});

Route::get('customer_invoice_wise_due_update', function () {
    $customer_wise_sales_invoices = \DB::table('sales')
            ->orderBy('id', 'DESC') // Fetch sales invoices in descending order of ID
            ->get();
    foreach($customer_wise_sales_invoices as $sales_inv){
        \DB::table('sales')->where('id',$sales_inv->id)->update(['_receive_amount'=>0,'_due_amount'=>$sales_inv->_total,'_is_close'=>0]);
    }

    return "All Data Updated. Sales Due and Customer Balance Are Now in Sync.";
});



/*Old database to new version update process end*/



    Route::resource('security_deposits', SecurityDepositController::class);
    Route::resource('employee_duty', EmployeeDutyController::class);
    Route::post('start-duty', [EmployeeDutyController::class,'start_duty'])->name('start_duty');






    Route::get('direct-inv/{id}','App\Http\Controllers\SalesWithoutLotController@OnlineInvoice');

/*Update Date 14-7-2024*/
    Route::get('check_coupon_duplicate','App\Http\Controllers\SalesWithoutLotController@check_coupon_duplicate');
    /*Update Date 14-7-2024*/
    Route::resource('direct-sales', SalesWithoutLotController::class);
    


    Route::post('direct-invoice-wise-detail', 'App\Http\Controllers\SalesWithoutLotController@invoiceWiseDetail');
    Route::post('direct-sales/update', 'App\Http\Controllers\SalesWithoutLotController@update');
    Route::get('direct-sales-reset', 'App\Http\Controllers\SalesWithoutLotController@reset');
    Route::get('direct-sales/print/{id}', 'App\Http\Controllers\SalesWithoutLotController@Print');
    Route::get('direct-sales/challan/{id}', 'App\Http\Controllers\SalesWithoutLotController@challanPrint');
    Route::get('direct-net-sales-after-return/{id}', 'App\Http\Controllers\SalesWithoutLotController@salesAfterReturn');

    Route::post('direct-sales-settings', 'App\Http\Controllers\SalesWithoutLotController@Settings');
    Route::get('direct-sales-setting-modal', 'App\Http\Controllers\SalesWithoutLotController@formSettingAjax');
    
    Route::get('direct-item-sales-search', 'App\Http\Controllers\SalesWithoutLotController@itemSalesSearch');
    Route::get('direct-check-available-qty', 'App\Http\Controllers\SalesWithoutLotController@checkAvailableQty');
    Route::get('direct-check-available-qty-update', 'App\Http\Controllers\SalesWithoutLotController@checkAvailableQtyUpdate');
    Route::get('direct-sales-money-receipt/{id}', 'App\Http\Controllers\SalesWithoutLotController@moneyReceipt');

    Route::resource('sales_return_wlm', SalesReturnWlmController::class);
    Route::post('sales_return_wlm/update', 'App\Http\Controllers\SalesReturnWlmController@update');
    Route::get('sales_return_wlm-reset', 'App\Http\Controllers\SalesReturnWlmController@reset');
    Route::get('sales_return_wlm/print/{id}', 'App\Http\Controllers\SalesReturnWlmController@Print');
    Route::post('sales_return_wlm-settings', 'App\Http\Controllers\SalesReturnWlmController@Settings');
    Route::get('sales_return_wlm-setting-modal', 'App\Http\Controllers\SalesReturnWlmController@formSettingAjax');
    Route::get('sales_return_wlm-order-search', 'App\Http\Controllers\SalesReturnWlmController@orderSearch');
    Route::get('check-sales_return_wlm-available-qty', 'App\Http\Controllers\SalesReturnWlmController@checkAvailableSalesQty');
    Route::post('sales_return_wlm-order-details', 'App\Http\Controllers\SalesReturnWlmController@salesOrderDetails');
    Route::get('sales_return_wlm-money-receipt/{id}', 'App\Http\Controllers\SalesReturnWlmController@moneyReceipt');
    Route::post('sales_return_wlm-detail', 'App\Http\Controllers\SalesReturnWlmController@salesReturnDetail');





Route::resource('import-purchase',ImportPuchaseController::class);
Route::resource('import-material-receive',ImportMRController::class);
Route::get('import-invoice-wise-detail',[ImportMRController::class,'importInvoiceWiseDetail']);
Route::get('import-material-receive/print/{id}', 'App\Http\Controllers\ImportMRController@purchasePrint');
Route::get('purchase-invoice-search', 'App\Http\Controllers\ImportMRController@purchaseInvoiceSerarch');
Route::get('id-base-purchase-detail', 'App\Http\Controllers\ImportMRController@idBasePurchase');

Route::resource('vessel-info',VesselInfoController::class);
Route::resource('mother-vessel-info',MotherVesselController::class);

Route::get('import-purchase-setting-modal',[ImportPuchaseController::class,'formSettingAjax']);
Route::post('import-purchase-settings',[ImportPuchaseController::class,'Settings']);
Route::get('import-purchase/print/{id}', 'App\Http\Controllers\ImportPuchaseController@purchasePrint');
Route::get('import-purchase-money-receipt/{id}', 'App\Http\Controllers\ImportPuchaseController@moneyReceipt');



Route::get('/sales_previous_balance_update', function(){

   $all_sales = \DB::table('sales')->where('_status',1)->get();

   foreach ($all_sales as $key => $value) {
      $ledger = $value->_ledger_id;
      /*Sales Invoice wise last Accounts Table row fetch*/
      $accounts_row = \DB::table('accounts')
            ->where('_ref_master_id',$value->id)
            ->where('_account_ledger',$ledger)
            ->where('_transaction','Sales')
            ->orderBy('id','ASC')
            ->first();

      //Update Inventory and Account Table to Branch id

         \DB::table('accounts')
               ->where('_ref_master_id',$value->id)
               ->update(['_branch_id'=>$value->_branch_id]);

            \DB::table('item_inventories')
               ->where('_transection','Sales')
               ->where('_transection_ref',$value->id)
               ->update(['_branch_id'=>$value->_branch_id]);

      $accounts_last_row = \DB::table('accounts')
            ->where('_ref_master_id',$value->id)
            ->where('_account_ledger',$ledger)
            ->where('_transaction','Sales')
            ->orderBy('id','DESC')
            ->first();

      // Fetch Row ID
      $account_id = $accounts_row->id;

      $account_last_row_id = $accounts_last_row->id;

      /*Calculation This sales Previous Balance Transection*/
      $previous_balance=\DB::select("SELECT SUM(IFNULL(_dr_amount,0)-IFNULL(_cr_amount,0)) as _balance 
            FROM `accounts` WHERE _account_ledger=$ledger  AND _status=1 AND id < $account_id  ");

       $last_balance=\DB::select("SELECT SUM(IFNULL(_dr_amount,0)-IFNULL(_cr_amount,0)) as _balance 
            FROM `accounts` WHERE _account_ledger=$ledger  AND _status=1 AND id <= $account_last_row_id ");

      $_p_balance = $previous_balance[0]->_balance ?? 0;
      $_l_balance = $last_balance[0]->_balance ?? 0;


      // Update Sales Invoice Previous Balance Column Data with $balance data
      \DB::table('sales')->where('id',$value->id)->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance]);


      return "Update Sales Invoice Previous and Current Balance Update";

   }

});



Route::get('/sales_invoice_due_update', function(){


    $all_ledger_balances = \DB::select(" SELECT t1._account_ledger,SUM(t1._dr_amount-t1._cr_amount) as _balance FROM accounts as t1 where t1._status=1  GROUP BY t1._account_ledger ");


    // Update All Sales Invoice and Make full Collection and due Zero
   $update_all_sales_data =  \DB::statement("   UPDATE sales as t1
                        INNER JOIN sales as t2 ON t1.id=t2.id
                        SET t1._receive_amount=t2._total,t1._due_amount=0,t1._is_close=1  WHERE t1.id=t2.id  ");


   // run all ledger balance array and find out current due and fetch sales table data order by DESC where _ledger_id=_account_ledger
   // AND reset _receive_amount and due_amount and if due_amoutn > 0 then set _is_close=0

   foreach($all_ledger_balances as $balance){
        $_account_ledger         = $balance->_account_ledger;
        $orderQuantity           = $balance->_balance ?? 0;


        // Retrieve all lots for this item
        $lots = \App\Models\Sales::where('_status', '=', 1)
            ->where('_ledger_id', $_account_ledger)
            ->orderBy('id', 'DESC') // Sort by created date
            ->get();

        $availableQuantity = 0;

        // Process each lot to fulfill the order
        foreach ($lots as $lot) {
            // Check if this lot can be used to fulfill the order
            if ($availableQuantity < $orderQuantity) {
                $neededQty = $orderQuantity - $availableQuantity;
                $qtyToUse = min($neededQty, $lot->_total); // Determine quantity to use from this lot

                // Update total available quantity
                $availableQuantity += $qtyToUse;
                // Update lot quantity and status
                if ($qtyToUse == $lot->_total) {
                    $lot->_receive_amount  = 0; // Lot fully used
                    $lot->_due_amount      = $qtyToUse; // Lot fully used
                    $lot->_is_close = 0;
                } else {

                    $lot->_receive_amount  -= $qtyToUse; // Lot fully used
                    $lot->_due_amount      = $qtyToUse; // Lot fully used
                    $lot->_is_close         = 0;
                }
                $lot->save();
            }
        }

   }

return " All Sales Invoice _recive and Due Amount Updated";

    
});






Route::get('/av_data_transfer', function(){


    $all_ledger_balances = \DB::select(" SELECT t1._account_ledger,SUM(t1._dr_amount-t1._cr_amount) as _balance FROM accounts as t1 where t1._status=1  GROUP BY t1._account_ledger ");


    // Update All Sales Invoice and Make full Collection and due Zero
   $update_all_sales_data =  \DB::statement("   UPDATE sales as t1
                        INNER JOIN sales as t2 ON t1.id=t2.id
                        SET t1._receive_amount=t2._total,t1._due_amount=0,t1._is_close=1  WHERE t1.id=t2.id  ");


   // run all ledger balance array and find out current due and fetch sales table data order by DESC where _ledger_id=_account_ledger
   // AND reset _receive_amount and due_amount and if due_amoutn > 0 then set _is_close=0

   foreach($all_ledger_balances as $balance){
        $_account_ledger         = $balance->_account_ledger;
        $orderQuantity           = $balance->_balance ?? 0;


        // Retrieve all lots for this item
        $lots = \App\Models\Sales::where('_status', '=', 1)
            ->where('_ledger_id', $_account_ledger)
            ->orderBy('id', 'DESC') // Sort by created date
            ->get();

        $availableQuantity = 0;

        // Process each lot to fulfill the order
        foreach ($lots as $lot) {
            // Check if this lot can be used to fulfill the order
            if ($availableQuantity < $orderQuantity) {
                $neededQty = $orderQuantity - $availableQuantity;
                $qtyToUse = min($neededQty, $lot->_total); // Determine quantity to use from this lot

                // Update total available quantity
                $availableQuantity += $qtyToUse;
                // Update lot quantity and status
                if ($qtyToUse == $lot->_total) {
                    $lot->_receive_amount  = 0; // Lot fully used
                    $lot->_due_amount      = $qtyToUse; // Lot fully used
                    $lot->_is_close = 0;
                } else {

                    $lot->_receive_amount  -= $qtyToUse; // Lot fully used
                    $lot->_due_amount      = $qtyToUse; // Lot fully used
                    $lot->_is_close         = 0;
                }
                $lot->save();
            }
        }

   }

return " All Sales Invoice _recive and Due Amount Updated";
// $device_url = "http://172.16.8.203:9872/api/get-attendance-data";
// //$device_url = "http://172.16.11.239:443/api/get-attendance-data";

// // Initialize cURL
// $ch = curl_init($device_url);

// // Set cURL options
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // Execute the request
// $response = curl_exec($ch);

// // Check for errors
// if (curl_errno($ch)) {
//     echo 'cURL Error: ' . curl_error($ch);
// } else {
//    return $data_array = json_decode($response, true);
// }

// // Close cURL
// curl_close($ch);


  // return purchase_table_due_receive_update();
//return sales_details_update_to_item_inventory();
//return sales_table_due_receive_update();



  //return insert_unit();
  //return insert_pack_size();
  //return insert_item();
  //return insert_branch();
  //return insert_party_info();
  //return insert_supplier_info();
 // return insert_doctor_info();
 // return insert_employee_info();
 // return  insert_sales_retun_collection();

 //$data =   actural_sales_collection_sales_return_and_incentive();
// return $inc= insenctive_expense_insert();
    
});



/*Cylinder Management Section*/




Route::post('cylindar_location_transfer',[CylindarController::class,'cylindar_location_transfer'])->name('cylindar_location_transfer');
Route::resource('cylindar_location',CylindarController::class);



/*Sales Officer Module Start*/
Route::any('date_to_date_sales_amount_report',[SalesOfficerReportController::class,'date_to_date_sales_amount_report'])->name('date_to_date_sales_amount_report');


/*Sales Office Module End*/



 Route::get('reports/income-expense', [AccountReportController::class,'incomeExpenseReport'])->name('reports.income-expense');
Route::get('reports/income-expense/data', [AccountReportController::class,'getIncomeExpenseData'])->name('reports.income-expense.data');

Route::get('collection_expense_report', [AccountReportController::class,'collection_expense_report'])->name('collection_expense_report');
Route::get('collection_expenseData', [AccountReportController::class,'collection_expenseData'])->name('collection_expenseData');


Route::get('sales_collection_report',[AdvanceAccountReportController::class,'sales_collection_report']);
Route::get('customer_due_statement',[AdvanceAccountReportController::class,'customer_due_statement']);
Route::get('final_due_statement',[AdvanceAccountReportController::class,'final_due_statement']);
Route::get('sales_man_wise_sales_detail',[InventoryReportController::class,'sales_man_wise_sales_detail']);
Route::any('customer_statement','App\Http\Controllers\AccountReportController@customer_statement')->name('customer_statement');
Route::any('single_customer_statement','App\Http\Controllers\AccountReportController@single_customer_statement')->name('single_customer_statement');
Route::any('branch_wise_sales_statement','App\Http\Controllers\InventoryReportController@branch_wise_sales_statement')->name('branch_wise_sales_statement');

Route::any('branch_wise_item_sales_return_summary','App\Http\Controllers\InventoryReportController@branch_wise_item_sales_return_summary')->name('branch_wise_item_sales_return_summary');


Route::any('branch_wise_item_sales_return_details','App\Http\Controllers\InventoryReportController@branch_wise_item_sales_return_details')->name('branch_wise_item_sales_return_details');
Route::post('branch_wise_item_sales_return_details_report','App\Http\Controllers\InventoryReportController@branch_wise_item_sales_return_details_report')->name('branch_wise_item_sales_return_details_report');


Route::any('branch_and_customer_wise_s_r','App\Http\Controllers\InventoryReportController@branch_and_customer_wise_s_r')->name('branch_and_customer_wise_s_r');
Route::post('branch_and_customer_wise_s_r_report','App\Http\Controllers\InventoryReportController@branch_and_customer_wise_s_r_report')->name('branch_and_customer_wise_s_r_report');




Route::get('ledger_report_with_item_detail','App\Http\Controllers\AccountReportController@ledger_report_with_item_detail')->name('ledger_report_with_item_detail');
Route::post('ledger_report_with_item_detail_response','App\Http\Controllers\AccountReportController@ledger_report_with_item_detail_response')->name('ledger_report_with_item_detail_response');


Route::get('full_ledger_detail','App\Http\Controllers\AccountReportController@full_ledger_detail')->name('full_ledger_detail');
Route::get('group_wise_ledger_list','App\Http\Controllers\AccountReportController@group_wise_ledger_list')->name('group_wise_ledger_list');
Route::get('group_wise_ledger_list_reset','App\Http\Controllers\AccountReportController@group_wise_ledger_list_reset')->name('group_wise_ledger_list_reset');








//#########################
// Budgets Section Start
//#########################
    Route::resource('budgets',BudgetsController::class);
    Route::get('budget-compare-report/{id}',[BudgetsController::class,'budgetCompareReport']);



/*
// Insective Setup and Incentive Calculation
//
//
*/

Route::resource('quaterly_insentive_setups',QuaterlyInsentiveSetupController::class);
Route::resource('monthly_sales_targets',MonthlySalesTargetController::class);
Route::resource('ta_da_setups',TaDaSetupController::class);
Route::resource('cat_wise_ta_bills',CatWiseTaBillController::class);


Route::get('customer_sales_target_list',[MonthlySalesTargetController::class,'customer_sales_target_list'])->name('customer_sales_target_list');
Route::get('customer_sales_target_create',[MonthlySalesTargetController::class,'customer_sales_target_create'])->name('customer_sales_target_create');
Route::get('customer_sales_target_edit/{id}',[MonthlySalesTargetController::class,'customer_sales_target_edit'])->name('customer_sales_target_edit');
Route::get('customer_sales_target_show/{id}',[MonthlySalesTargetController::class,'customer_sales_target_show'])->name('customer_sales_target_show');
Route::post('customer_sales_target_update',[MonthlySalesTargetController::class,'customer_sales_target_update'])->name('customer_sales_target_update');
Route::post('customer_sales_target_store',[MonthlySalesTargetController::class,'customer_sales_target_store'])->name('customer_sales_target_store');
Route::post('customer_sales_target_delete',[MonthlySalesTargetController::class,'customer_sales_target_delete'])->name('customer_sales_target_delete');


Route::resource('item_bonus_setups',ItemBonusSetupController::class);



/*
Audit Log Section

*/

Route::get('audit_logs',[AuditLogController::class,'index'])->name('audit_logs');

//##########################
//  HRM Section Start
//
//#########


/*
    
*/

Route::resource('documents',DocumentController::class);
Route::resource('hrm-employee',HrmEmployeesController::class);
Route::resource('hrm-designation',HrmDesignationController::class);
Route::resource('zones',ZoneController::class);

Route::resource('weekworkday',HrmWeekworkdayController::class);
Route::resource('holidays',HrmHolidaysController::class);
Route::resource('leave-type',HrmLeavetypesController::class);
Route::resource('pay-heads',HrmPayheadsController::class);
Route::resource('companies',CompanyController::class);
Route::resource('hrm-department',HrmDepartmentController::class);
Route::resource('hrm-grade',HrmGradeController::class);
Route::resource('hrm-emp-location',HrmEmpLocationController::class);
Route::resource('hrm-emp-category',HrmEmpCategoryController::class);

Route::get('hrm-emp-category_sub_new',[HrmEmpCategoryController::class,'sub_new']);
Route::get('sub_entry_data_save',[HrmEmpCategoryController::class,'sub_entry_data_save']);


/* HRM SECTION END*/

/*Advance Account Report Sections*/


Route::get('advance_income_statement',[AdvanceAccountReportController::class,'advance_income_statement']);
Route::post('advance_income_statement_report',[AdvanceAccountReportController::class,'advance_income_statement_report']);

Route::get('advance_balance_sheet',[AdvanceAccountReportController::class,'advance_balance_sheet']);
Route::post('advance_balance_sheet_report',[AdvanceAccountReportController::class,'advance_balance_sheet_report']);




 Route::get('advance_income_statement',[AdvanceAccountReportController::class,'advance_income_statement']);
    Route::post('advance_income_statement_report',[AdvanceAccountReportController::class,'advance_income_statement_report']);



    //Account Report Section 
    Route::get('ledger-report','App\Http\Controllers\AccountReportController@ledgerReprt')->name('ledger-report');
    Route::get('filter-report-foreign_amount','App\Http\Controllers\AccountReportController@ledgerReportForeign_amount')->name('ledger-report-foreign_amount');
    Route::get('report_ledger_foreign_amount','App\Http\Controllers\AccountReportController@ledgerReprtShowForeign_amount')->name('report_ledger_foreign_amount');

    Route::get('ledger-report-show','App\Http\Controllers\AccountReportController@ledgerReprtShow');
    Route::get('group-ledger','App\Http\Controllers\AccountReportController@groupLedger')->name('group-ledger');
    Route::get('group-wise-ledger-report','App\Http\Controllers\AccountReportController@groupWiseLedgerReport')->name('group-wise-ledger-report');

    Route::post('group-base-ledger-report','App\Http\Controllers\AccountReportController@groupBaseLedgerReport');
    Route::get('group-base-ledger-filter-reset','App\Http\Controllers\AccountReportController@groupBaseLedgerFilterReset');
    Route::get('LedgerReportFilterReset','App\Http\Controllers\AccountReportController@LedgerReportFilterReset');
    Route::get('group_sub_group_summary_report','App\Http\Controllers\AccountReportController@group_sub_group_summary_report');
    Route::any('payable_report','App\Http\Controllers\AccountReportController@payable_report')->name('payable_report');
    





Route::resource('direct_productions', DirectProductionController::class);
Route::post('direct_productions/update', 'App\Http\Controllers\DirectProductionController@update');
Route::get('direct_productions-reset', 'App\Http\Controllers\DirectProductionController@reset');
Route::get('partical-production-receive-print1', 'App\Http\Controllers\DirectProductionController@PrintOne');
Route::get('partical-production-receive-print2', 'App\Http\Controllers\DirectProductionController@Printtwo');
Route::get('direct_productions/print/{id}', 'App\Http\Controllers\DirectProductionController@Show');
Route::get('direct_productions/stock-in/{id}', 'App\Http\Controllers\DirectProductionController@PrintStockIn');
Route::any('check_available_row_materials', 'App\Http\Controllers\DirectProductionController@check_available_row_materials');
Route::get('finished_goods_receive_to_stock', 'App\Http\Controllers\DirectProductionController@finished_goods_receive_to_stock');


Route::get('partical-production-receive', 'App\Http\Controllers\DirectProductionController@partialProductionReceive')->name('partical-production-receive');
Route::get('partical-production-receive/{id}', 'App\Http\Controllers\DirectProductionController@edit');
Route::get('partical_production_receive_list', 'App\Http\Controllers\DirectProductionController@partical_production_receive_list')->name('partical_production_receive_list');




//IndividualReplaceMasterController Start
Route::resource('individual-replacement',IndividualReplaceMasterController::class);
Route::post('/individual-replacement/update', 'App\Http\Controllers\IndividualReplaceMasterController@update');
Route::post('individual-replacement-settings', 'App\Http\Controllers\IndividualReplaceMasterController@Settings');
Route::post('individual-replacement-wise-detail', 'App\Http\Controllers\IndividualReplaceMasterController@Detail');
Route::get('individual-replacement-out-report/{id}', [IndividualReplaceMasterController::class,'individualReplacementOutReport']);
Route::get('individual-replacement-customer-delivery-report/{id}', [IndividualReplaceMasterController::class,'individualReplacementCustomerDeliveryReport']);
Route::get('individual-replacement-in-report/{id}', [IndividualReplaceMasterController::class,'individualReplacementInReport']);
Route::get('individual-replacement-print/{id}', [IndividualReplaceMasterController::class,'individualReplacementPrint']);
//IndividualReplaceMasterController End

// WItemReceiveFromSupplierController Start
Route::resource('w-item-receive-from-supp',WItemReceiveFromSupplierController::class);
Route::post('/w-item-receive-from-supp/update', 'App\Http\Controllers\WItemReceiveFromSupplierController@update');
Route::post('w-item-receive-from-supp-settings', 'App\Http\Controllers\WItemReceiveFromSupplierController@Settings');
Route::post('w-item-receive-from-supp-wise-detail', 'App\Http\Controllers\WItemReceiveFromSupplierController@Detail');
Route::get('w-item-receive-from-supp-out-report/{id}', [WItemReceiveFromSupplierController::class,'individualReplacementOutReport']);
Route::get('w-item-receive-from-supp-customer-delivery-report/{id}', [WItemReceiveFromSupplierController::class,'individualReplacementCustomerDeliveryReport']);
Route::get('w-item-receive-from-supp-in-report/{id}', [WItemReceiveFromSupplierController::class,'individualReplacementInReport']);
Route::get('w-item-receive-from-supp-print/{id}', [WItemReceiveFromSupplierController::class,'individualReplacementPrint']);
// WItemReceiveFromSupplierController End
    
Route::resource('third-party-service',ServiceMasterController::class);
Route::post('third-party-service-settings', 'App\Http\Controllers\ServiceMasterController@Settings');
Route::post('third-party-service-wise-detail', 'App\Http\Controllers\ServiceMasterController@purchaseWiseDetail');
Route::get('third-party-service/print/{id}', 'App\Http\Controllers\ServiceMasterController@Print');
Route::post('third-party-service/update', 'App\Http\Controllers\ServiceMasterController@update');
Route::get('third-party-service-money-receipt/{id}', 'App\Http\Controllers\ServiceMasterController@moneyReceipt');

//ReplacementMasterController

Route::resource('item-replace',ReplacementMasterController::class);
Route::get('item-replace-setting-modal', 'App\Http\Controllers\ReplacementMasterController@formSettingAjax');

Route::post('item-replace-setting', 'App\Http\Controllers\ReplacementMasterController@Settings');
Route::get('item-replace-order-search', 'App\Http\Controllers\ReplacementMasterController@orderSearch');

 Route::get('item-replace-reset', 'App\Http\Controllers\ReplacementMasterController@reset');

Route::post('item-replace-order-details', 'App\Http\Controllers\ReplacementMasterController@purchaseOrderDetails');
Route::post('item-replace-invoice-wise-detail', 'App\Http\Controllers\ReplacementMasterController@invoiceWiseDetail');
Route::post('item-replace/update', 'App\Http\Controllers\ReplacementMasterController@update');
Route::get('item-replace/challan/{id}', 'App\Http\Controllers\ReplacementMasterController@challanPrint');
Route::get('item-replace/print/{id}', 'App\Http\Controllers\ReplacementMasterController@Print');
Route::get('item-replace-money-receipt/{id}', 'App\Http\Controllers\ReplacementMasterController@moneyReceipt');

//Resturant POS SECTION
Route::resource('table-info', TableInfoController::class);
Route::resource('steward-waiter', StewardAllocationController::class);
Route::resource('musak-four-point-three', MusakFourPointThreeController::class);
Route::post('musak-four-point-three-wise-detail',  'App\Http\Controllers\MusakFourPointThreeController@detail');
Route::get('musak-four-point-three-tem1/{id}',  'App\Http\Controllers\MusakFourPointThreeController@musakFourPointThreeTem1');
Route::get('musak-four-point-three-tem2/{id}',  'App\Http\Controllers\MusakFourPointThreeController@musakFourPointThreeTem2');

Route::get('restaurant-pos', 'App\Http\Controllers\ResturantSalesController@restaurantPos');
Route::get('kitchen-slip/{id}', 'App\Http\Controllers\ResturantSalesController@kitchenSlip');
Route::resource('kitchen', KitchenController::class);
Route::post('check_available_ingredients', 'App\Http\Controllers\KitchenController@check_available_ingredients');
Route::post('coocked_confirm_check', 'App\Http\Controllers\KitchenController@coocked_confirm_check');
Route::post('coocked-served-confirm', 'App\Http\Controllers\KitchenController@coockedServedConfirm');
Route::get('book_table_list_ajax', 'App\Http\Controllers\ResturantSalesController@book_table_list_ajax');



    

    //Admin Section start
    Route::resource('roles', RoleController::class);
    Route::resource('category-allocation', RestaurantCategorySettingController::class);
    
    Route::resource('warranty-manage', WarrantyMasterController::class);
    Route::get('warranty-setting-modal', 'App\Http\Controllers\WarrantyMasterController@formSettingAjax');
    Route::post('warranty-settings', 'App\Http\Controllers\WarrantyMasterController@warrantySettings');
    Route::get('barcode-warranty-search', 'App\Http\Controllers\WarrantyMasterController@barcodeWarrantySearch');
    Route::get('warranty-manage/print/{id}', 'App\Http\Controllers\WarrantyMasterController@print');
    Route::get('warranty-manage-reset', 'App\Http\Controllers\WarrantyMasterController@reset');
    Route::get('warranty-search', 'App\Http\Controllers\WarrantyMasterController@warrantySearch');
    Route::post('warranty-detail-search', 'App\Http\Controllers\WarrantyMasterController@warrantySearchDetail');
    Route::get('warranty-check', 'App\Http\Controllers\WarrantyMasterController@warrantyCheck')->name('warranty-check');


    
    Route::get('sms-send', 'App\Http\Controllers\BulkSmsController@index')->name('sms-send');
    Route::post('bulk-sms-send', 'App\Http\Controllers\BulkSmsController@store');
    Route::resource('users', UserController::class);
    Route::resource('social_media', SocialMediaController::class);
    Route::resource('branch', BranchController::class);
    
    Route::post('branch/update', 'App\Http\Controllers\BranchController@update');

    Route::resource('account-type', AccountHeadController::class);
    Route::post('account-type/update', 'App\Http\Controllers\AccountHeadController@update');
    Route::get('account-type-reset', 'App\Http\Controllers\AccountHeadController@reset');
    Route::get('account-type-for-new-ledger', 'App\Http\Controllers\AccountHeadController@accountTypeForNewLedger');

    Route::resource('account-group', AccountGroupController::class);
    Route::post('account_group_short_update',[AccountGroupController::class,'account_group_short_update']);
    Route::post('account-group/update', 'App\Http\Controllers\AccountGroupController@update');
    Route::get('account-group-reset', 'App\Http\Controllers\AccountGroupController@reset');

    Route::resource('cost-center', CostCenterController::class);
    Route::post('cost-center/update', 'App\Http\Controllers\CostCenterController@update');
    Route::get('cost-center-chain/{id}', 'App\Http\Controllers\CostCenterController@csAuthorizationChain');
    Route::post('cost-center-authorization-chain', 'App\Http\Controllers\CostCenterController@csAuthorizationChainUpdate');

    Route::resource('item-category', ItemCategoryController::class);
    Route::post('item-category/update', 'App\Http\Controllers\ItemCategoryController@update');
    
    Route::resource('warranty', WarrantyController::class);
    Route::post('warranty/update', 'App\Http\Controllers\WarrantyController@update');

    Route::resource('item-information', InventoryController::class);
    Route::resource('pack-size', ItemPackSizeController::class);
    Route::resource('item-brand', ItemBrandController::class);
    Route::resource('countries', CountryController::class);

    Route::get('division_wise_districts',[CountryController::class,'division_wise_districts'])->name('division_wise_districts');
    Route::get('district_wise_upazilla',[CountryController::class,'district_wise_upazilla'])->name('district_wise_upazilla');
    Route::get('upazilla_wise_union',[CountryController::class,'upazilla_wise_union'])->name('upazilla_wise_union');




    Route::post('item-information/update', 'App\Http\Controllers\InventoryController@update');
    Route::post('file-upload', 'App\Http\Controllers\InventoryController@fileUpload');
    Route::post('cylinder_upload', 'App\Http\Controllers\InventoryController@cylinder_upload');

    Route::get('item-wise-unit-conversion', 'App\Http\Controllers\InventoryController@itemWiseUnitConversion');
    Route::get('item-wise-unit-conversion-save', 'App\Http\Controllers\InventoryController@itemWiseUnitConversionSave');
    Route::get('item-wise-units', 'App\Http\Controllers\InventoryController@itemWiseUnits');
    Route::post('ajax-item-save', 'App\Http\Controllers\InventoryController@ajaxItemSave');
    Route::get('item-information-reset', 'App\Http\Controllers\InventoryController@reset');
    Route::get('item-purchase-search', 'App\Http\Controllers\InventoryController@itemPurchaseSearch');
    Route::get('lot-item-information', 'App\Http\Controllers\InventoryController@lotItemInformation')->name('lot-item-information');
    Route::get('lot-item-information-reset', 'App\Http\Controllers\InventoryController@lotReset');
    Route::get('item-sales-price-edit/{id}', 'App\Http\Controllers\InventoryController@salesPriceEdit');
    Route::post('item-sales-price-update', 'App\Http\Controllers\InventoryController@salesPriceUpdate');
    Route::get('labels-print', 'App\Http\Controllers\InventoryController@labelPrint')->name('labels-print');
    Route::post('barcode-print-store', 'App\Http\Controllers\InventoryController@barcodePrintStore');
Route::get('manufacture-comapany-search', 'App\Http\Controllers\InventoryController@showManufactureCompanys');
Route::get('new_item_using_modal', 'App\Http\Controllers\InventoryController@new_item_using_modal');
Route::get('transfer_to_asset_item', 'App\Http\Controllers\InventoryController@transfer_to_asset_item');


Route::get('cylinder_product', 'App\Http\Controllers\InventoryController@cylinder_product')->name('cylinder_product');
Route::get('cylinder_product/{id}', 'App\Http\Controllers\InventoryController@cylinder_product_edit')->name('cylinder_product_edit');


    
    Route::resource('store-house', StoreHouseController::class);
    Route::post('store-house/update', 'App\Http\Controllers\StoreHouseController@update');

    Route::resource('account-ledger', AccountLedgerController::class);
    Route::post('account-ledger/update', 'App\Http\Controllers\AccountLedgerController@update');
    Route::post('ledger_excel_upload', 'App\Http\Controllers\AccountLedgerController@ledger_excel_upload')->name('ledger_excel_upload');

    Route::post('ajax-ledger-save', 'App\Http\Controllers\AccountLedgerController@ajaxLedgerSave');
    Route::get('account-ledger-reset', 'App\Http\Controllers\AccountLedgerController@reset');
    Route::get('copy_to_employee/{id}', 'App\Http\Controllers\AccountLedgerController@copy_to_employee');

    Route::get('customer_list', 'App\Http\Controllers\AccountLedgerController@customer_list')->name('customer_list');
    Route::get('customer_create', 'App\Http\Controllers\AccountLedgerController@customer_create')->name('customer_create');
    Route::post('customer_store', 'App\Http\Controllers\AccountLedgerController@customer_store')->name('customer_store');

    Route::get('group_wise_list', 'App\Http\Controllers\AccountLedgerController@group_wise_list')->name('group_wise_list');
    Route::get('group_wise_create', 'App\Http\Controllers\AccountLedgerController@group_wise_create')->name('group_wise_create');
    Route::post('group_wise_store', 'App\Http\Controllers\AccountLedgerController@group_wise_store')->name('group_wise_store');



    
    Route::get('supplier_list', 'App\Http\Controllers\AccountLedgerController@supplier_list')->name('supplier_list');
    Route::get('supplier_create', 'App\Http\Controllers\AccountLedgerController@supplier_create')->name('supplier_create');

    Route::resource('purchase', PurchaseController::class);
    Route::post('purchase/update', 'App\Http\Controllers\PurchaseController@update');
    Route::post('purchase-wise-detail', 'App\Http\Controllers\PurchaseController@purchaseWiseDetail');
    Route::get('purchase-reset', 'App\Http\Controllers\PurchaseController@reset');
    Route::get('purchase/print/{id}', 'App\Http\Controllers\PurchaseController@purchasePrint');
    Route::post('purchase-settings', 'App\Http\Controllers\PurchaseController@purchaseSettings');
    Route::get('purchase_modal_form', 'App\Http\Controllers\PurchaseController@purchase_modal_form');
    Route::get('purchase-money-receipt/{id}', 'App\Http\Controllers\PurchaseController@moneyReceipt');
    Route::get('item-purchase-barcode-check', 'App\Http\Controllers\PurchaseController@itemPurchaseBarcodeCheck');
    Route::get('opening-inventory-entry', 'App\Http\Controllers\PurchaseController@openingInventory');
    Route::get('sales-qty-check-for-purchase-update', 'App\Http\Controllers\PurchaseController@salesQtyCheckForPurchaseUpdate');

   
    
   


    Route::resource('previous_sales_return', PreviousSalesReturnController::class);
    Route::post('previous_sales_return/update', 'App\Http\Controllers\PreviousSalesReturnController@update');
    Route::post('previous_sales_return-wise-detail', 'App\Http\Controllers\PreviousSalesReturnController@purchaseWiseDetail');
    Route::get('previous_sales_return-reset', 'App\Http\Controllers\PreviousSalesReturnController@reset');
    Route::get('previous_sales_return/print/{id}', 'App\Http\Controllers\PreviousSalesReturnController@purchasePrint');
    Route::post('previous_sales_return-settings', 'App\Http\Controllers\PreviousSalesReturnController@purchaseSettings');
    Route::get('previous_sales_return_modal_form', 'App\Http\Controllers\PreviousSalesReturnController@purchase_modal_form');
    Route::get('previous_sales_return_modal_form-money-receipt/{id}', 'App\Http\Controllers\PreviousSalesReturnController@moneyReceipt');

   
    
   





    Route::resource('purchase-order', PurchaseOrderController::class);
    Route::post('purchase-order/update', 'App\Http\Controllers\PurchaseOrderController@update');
    Route::get('purchase-order-reset', 'App\Http\Controllers\PurchaseOrderController@reset');
    Route::get('purchase-order/print/{id}', 'App\Http\Controllers\PurchaseOrderController@purchaseOrderPrint');
    Route::post('purchase-order-settings', 'App\Http\Controllers\PurchaseOrderController@purchaseOrderSettings');
    Route::get('purchase-pre-order-search', 'App\Http\Controllers\PurchaseOrderController@orderSearch');
    Route::post('purchase-pre-order-details', 'App\Http\Controllers\PurchaseOrderController@purchaseOrderDetails');
     Route::get('purchase_order_wise_item_receive/{id}', 'App\Http\Controllers\PurchaseOrderController@orderWiseItemReceive');


    Route::resource('sales-order', SalesOrderController::class);
    Route::post('sales-order/update', 'App\Http\Controllers\SalesOrderController@update');

    Route::get('market-order','App\Http\Controllers\SalesOrderController@marketOrder');
    Route::any('avaiable_product_list','App\Http\Controllers\SalesOrderController@avaiable_product_list')->name('avaiable_product_list');
    Route::get('product_show','App\Http\Controllers\SalesOrderController@product_show')->name('product_show');
   
    // Route::get('sales-order-reset', 'App\Http\Controllers\SalesOrderController@reset');
     Route::get('sales-order-delete/{id}', 'App\Http\Controllers\SalesOrderController@destroy');
     Route::get('sales-order/print/{id}', 'App\Http\Controllers\SalesOrderController@SalesOrderPrint');
    // Route::post('sales-order-settings', 'App\Http\Controllers\SalesOrderController@SalesOrderSettings');
    // Route::get('purchase-pre-order-search', 'App\Http\Controllers\PurchaseOrderController@orderSearch');
    // Route::post('purchase-pre-order-details', 'App\Http\Controllers\PurchaseOrderController@purchaseOrderDetails');
    
//Sales section Start
  




    Route::resource('sales_commision_plans', SalesCommisionPlanController::class);


    Route::resource('sales', SalesController::class);

    
    Route::resource('sales_without_stock_deduct', SalesWithoutStockDeductController::class);
    Route::post('sales_without_stock_deduct/update', 'App\Http\Controllers\SalesWithoutStockDeductController@update');
    Route::get('sales_without_stock_deduct_delete/{id}', 'App\Http\Controllers\SalesWithoutStockDeductController@destroy');
    Route::get('sales_without_stock_deduct-reset', 'App\Http\Controllers\SalesWithoutStockDeductController@reset');



    Route::resource('previous_bill_item_send', PreviousBillItemSendController::class);
    Route::post('previous_bill_item_send/update', 'App\Http\Controllers\PreviousBillItemSendController@update');
    Route::get('previous_bill_item_send_delete/{id}', 'App\Http\Controllers\PreviousBillItemSendController@destroy');
    Route::get('previous_bill_item_send-reset', 'App\Http\Controllers\PreviousBillItemSendController@reset');



    
    Route::get('so_wise_due_invoice', [SalesController::class,'so_wise_due_invoice']);
    Route::get('sales-reset', 'App\Http\Controllers\SalesController@reset');
    Route::post('invoice-wise-detail', 'App\Http\Controllers\SalesController@invoiceWiseDetail');

    Route::post('sales/update', 'App\Http\Controllers\SalesController@update');
    Route::post('invoice_wise_collection_save', 'App\Http\Controllers\SalesController@invoice_wise_collection_save')->name('invoice_wise_collection_save');

    Route::get('invoice_wise_due_collection', 'App\Http\Controllers\SalesController@invoice_wise_due_collection')->name('invoice_wise_due_collection');
    

    Route::get('sales/print/{id}', 'App\Http\Controllers\SalesController@Print');
    Route::get('sales/office_print/{id}', 'App\Http\Controllers\SalesController@office_print');
    Route::get('sales/challan/{id}', 'App\Http\Controllers\SalesController@challanPrint');
    Route::get('sales_order_to_invoice/{id}', 'App\Http\Controllers\SalesController@sales_order_to_invoice');
    
    Route::get('order_to_invoice/{id}', 'App\Http\Controllers\SalesController@order_to_invoice');
    Route::get('net-sales-after-return/{id}', 'App\Http\Controllers\SalesController@salesAfterReturn');
    Route::get('branch_wise_sales_person', [SalesController::class,'branch_wise_sales_person']);
   

    Route::post('sales-settings', 'App\Http\Controllers\SalesController@Settings');
    Route::post('order_to_sales_confirm', 'App\Http\Controllers\SalesController@order_to_sales_confirm')->name('order_to_sales_confirm');
    Route::get('check_available_sales_qty', 'App\Http\Controllers\SalesController@check_available_sales_qty')->name('check_available_sales_qty');
    Route::get('sales-setting-modal', 'App\Http\Controllers\SalesController@formSettingAjax');
    
    Route::get('item-sales-search', 'App\Http\Controllers\SalesController@itemSalesSearch');
    Route::get('sales_form_two', 'App\Http\Controllers\SalesController@sales_form_two')->name('sales_form_two');

   


    Route::get('item-sales-barcode-search', 'App\Http\Controllers\SalesController@itemSalesBarcodeSearch');
    Route::post('pos-payment-row', 'App\Http\Controllers\SalesController@posPaymentRow');
    Route::post('pos-sales-save', 'App\Http\Controllers\SalesController@posSalesSave');
    Route::get('item-sales-edit-barcode-search', 'App\Http\Controllers\SalesController@itemSalesEditBarcodeSearch');
    Route::get('check-available-qty', 'App\Http\Controllers\SalesController@checkAvailableQty');
    Route::get('check-available-qty-update', 'App\Http\Controllers\SalesController@checkAvailableQtyUpdate');
    Route::get('sales-money-receipt/{id}', 'App\Http\Controllers\SalesController@moneyReceipt');
    Route::get('pos-sales', 'App\Http\Controllers\SalesController@posSales');
    Route::get('sales_item_search_without_lot', 'App\Http\Controllers\SalesController@sales_item_search_without_lot')->name('sales_item_search_without_lot');

    Route::post('category-wise-item', 'App\Http\Controllers\SalesController@categoryWiseItem');
    Route::post('hold-invoice-list', 'App\Http\Controllers\SalesController@holdInvoiceList');

    //ONline invoice print

//Sales section end


    
//Sales section Start
  //  Route::resource('restaurant', ResturantSalesController::class);
    Route::resource('restaurant-sales', ResturantSalesController::class);
    Route::post('restaurant-invoice-wise-detail', 'App\Http\Controllers\ResturantSalesController@invoiceWiseDetail');
    Route::get('restaurant-edit', 'App\Http\Controllers\ResturantSalesController@restaurantEdit');

    Route::post('restaurant-sales/update', 'App\Http\Controllers\ResturantSalesController@update');
    Route::get('restaurant-sales-reset', 'App\Http\Controllers\ResturantSalesController@reset');
    Route::get('restaurant-sales/print/{id}', 'App\Http\Controllers\ResturantSalesController@Print');
    Route::get('restaurant-sales/challan/{id}', 'App\Http\Controllers\ResturantSalesController@challanPrint');
    Route::post('restaurant-sales-settings', 'App\Http\Controllers\ResturantSalesController@Settings');
    Route::get('restaurant-sales-setting-modal', 'App\Http\Controllers\ResturantSalesController@formSettingAjax');
    Route::get('item-restaurant-sales-search', 'App\Http\Controllers\ResturantSalesController@itemSalesSearch');
  //  Route::get('item-damage-search', 'App\Http\Controllers\ResturantSalesController@itemDamageSearch');
    Route::get('item-restaurant-sales-barcode-search', 'App\Http\Controllers\ResturantSalesController@itemSalesBarcodeSearch');
    Route::post('pos-payment-row', 'App\Http\Controllers\ResturantSalesController@posPaymentRow');
    Route::post('pos-restaurant-sales-save', 'App\Http\Controllers\ResturantSalesController@posSalesSave');
    Route::get('item-restaurant-sales-edit-barcode-search', 'App\Http\Controllers\ResturantSalesController@itemSalesEditBarcodeSearch');
    Route::get('restaurant-sales-check-available-qty', 'App\Http\Controllers\ResturantSalesController@checkAvailableQty');
    Route::get('restaurant-sales-check-available-qty-update', 'App\Http\Controllers\ResturantSalesController@checkAvailableQtyUpdate');
    Route::get('restaurant-sales-check-available-qty-update-damage', 'App\Http\Controllers\ResturantSalesController@checkAvailableQtyUpdateDamage');
    Route::get('restaurant-sales-money-receipt/{id}', 'App\Http\Controllers\ResturantSalesController@moneyReceipt');
    Route::get('pos-restaurant-sales', 'App\Http\Controllers\ResturantSalesController@posSales');
    Route::post('restaurant-sales-category-wise-item', 'App\Http\Controllers\ResturantSalesController@categoryWiseItem');
    Route::post('restaurant-sales-hold-invoice-list', 'App\Http\Controllers\ResturantSalesController@holdInvoiceList');



    Route::post('restaurant-category-wise-item', 'App\Http\Controllers\ResturantSalesController@categoryWiseItem');
    Route::get('recent-restaurnt-sales-list', 'App\Http\Controllers\ResturantSalesController@recentRestaurntSalesList');
//Sales section end




    

    Route::resource('production', ProductionController::class);
    Route::post('production/update', 'App\Http\Controllers\ProductionController@update');
    Route::get('production-reset', 'App\Http\Controllers\ProductionController@reset');
    Route::get('production/print/{id}', 'App\Http\Controllers\ProductionController@Print');
    Route::get('transfer-production/print/{id}', 'App\Http\Controllers\ProductionController@Print');
    Route::get('production/stock-in/{id}', 'App\Http\Controllers\ProductionController@PrintStockIn');


    Route::resource('transfer', TransferController::class);
    Route::post('transfer/update', 'App\Http\Controllers\TransferController@update');
    Route::get('transfer-reset', 'App\Http\Controllers\TransferController@reset');
    Route::get('transfer/print/{id}', 'App\Http\Controllers\TransferController@Print');
    Route::get('transfer/stock-in/{id}', 'App\Http\Controllers\TransferController@PrintStockIn');
    Route::get('transfer/stock-out/{id}', 'App\Http\Controllers\TransferController@PrintStockOut');

   

    

    Route::get('transfer-production/stock-out/{id}', 'App\Http\Controllers\ProductionController@PrintStockOut');
    Route::get('production-setting-modal', 'App\Http\Controllers\ProductionController@formSettingAjax');
    Route::post('production-form-settings', 'App\Http\Controllers\ProductionController@Settings');
   
    
    
    

    Route::resource('sales-return', SalesReturnController::class);
    Route::post('sales-return/update', 'App\Http\Controllers\SalesReturnController@update');
    Route::get('sales-return-reset', 'App\Http\Controllers\SalesReturnController@reset');
    Route::get('sales-return/print/{id}', 'App\Http\Controllers\SalesReturnController@Print');
    Route::post('sales-return-settings', 'App\Http\Controllers\SalesReturnController@Settings');
    Route::get('sales-return-setting-modal', 'App\Http\Controllers\SalesReturnController@formSettingAjax');
    Route::get('sales-order-search', 'App\Http\Controllers\SalesReturnController@orderSearch');
    Route::get('check-sales-return-available-qty', 'App\Http\Controllers\SalesReturnController@checkAvailableSalesQty');
    Route::post('sales-order-details', 'App\Http\Controllers\SalesReturnController@salesOrderDetails');
    Route::get('sales-return-money-receipt/{id}', 'App\Http\Controllers\SalesReturnController@moneyReceipt');
    Route::post('sales-return-detail', 'App\Http\Controllers\SalesReturnController@salesReturnDetail');
    
    

    Route::resource('purchase-return', PurchaseReturnController::class);
    Route::post('purchase-return/update', 'App\Http\Controllers\PurchaseReturnController@update');
    Route::get('purchase-return-reset', 'App\Http\Controllers\PurchaseReturnController@reset');
    Route::get('purchase-return/print/{id}', 'App\Http\Controllers\PurchaseReturnController@purchasePrint');
    Route::post('purchase-return-settings', 'App\Http\Controllers\PurchaseReturnController@purchaseSettings');
    Route::get('purchase-order-search', 'App\Http\Controllers\PurchaseReturnController@purchaseOrderSearch');
    Route::post('purchase-order-details', 'App\Http\Controllers\PurchaseReturnController@purchaseOrderDetails');
    Route::get('purchase-return-money-receipt/{id}', 'App\Http\Controllers\PurchaseReturnController@moneyReceipt');

    Route::resource('unit', UnitsController::class);
    Route::post('unit/update', 'App\Http\Controllers\UnitsController@update');
    Route::get('unit-reset', 'App\Http\Controllers\UnitsController@reset');


    Route::resource('vat-rules', VatRuleController::class);
    Route::post('vat-rules/update', 'App\Http\Controllers\VatRuleController@update');
    Route::get('vat-rules-reset', 'App\Http\Controllers\VatRuleController@reset');

    Route::resource('transection_terms', TransectionTermsController::class);
    Route::post('transection_terms/update', 'App\Http\Controllers\TransectionTermsController@update');
    Route::get('transection_terms-reset', 'App\Http\Controllers\TransectionTermsController@reset');

    Route::resource('voucher', VoucherMasterController::class);


    Route::resource('supplier_payment',SupplierPaymentController::class);
    Route::get('find_supplier_due_history',[SupplierPaymentController::class,'find_supplier_due_history'])->name('find_supplier_due_history');
    Route::get('supplier_payment/print/{id}',[SupplierPaymentController::class,'supplier_payment_print'])->name('supplier_payment_print');


    Route::resource('customer_payment',ReceivePaymentController::class);
    Route::get('find_customer_due_history',[ReceivePaymentController::class,'find_customer_due_history'])->name('find_supplier_due_history');
    Route::get('customer_wise_due_collection',[ReceivePaymentController::class,'customer_wise_due_collection'])->name('customer_wise_due_collection');

    Route::get('customer_payment/print/{id}',[ReceivePaymentController::class,'customer_payment_print'])->name('customer_payment_print');
    Route::get('customer_payment_receipt/{id}',[ReceivePaymentController::class,'customer_payment_receipt'])->name('customer_payment_receipt');

    Route::resource('easy-voucher', EasyVoucherController::class);
    Route::resource('inter-project-voucher', InterProjectVoucherController::class);

    Route::post('voucher/update', 'App\Http\Controllers\VoucherMasterController@update');
    Route::get('voucher/print/{id}', 'App\Http\Controllers\VoucherMasterController@voucherPrint');
    Route::get('voucher-main-print', 'App\Http\Controllers\VoucherMasterController@voucherMainPrint');
    Route::get('voucher-detail-print', 'App\Http\Controllers\VoucherMasterController@voucherDetailPrint');
    Route::get('voucher-reset', 'App\Http\Controllers\VoucherMasterController@reset');
    Route::get('money-receipt-print/{id}', 'App\Http\Controllers\VoucherMasterController@moneyReceiptPrint');
    Route::get('money-payment-receipt/{id}', 'App\Http\Controllers\VoucherMasterController@moneyPaymentReceiptPrint');

    Route::post('master-base-detils','App\Http\Controllers\VoucherMasterController@masterBseDetails');
    Route::get('cash-receive','App\Http\Controllers\VoucherMasterController@cashReceive');
    Route::get('bank-receive','App\Http\Controllers\VoucherMasterController@bankReceive');
    Route::get('cash-payment','App\Http\Controllers\VoucherMasterController@cashPayment');
    Route::get('bank-payment','App\Http\Controllers\VoucherMasterController@bankPayment');
    Route::get('petty-cash','App\Http\Controllers\VoucherMasterController@pettyCash');



    Route::post('voucher-save','App\Http\Controllers\VoucherMasterController@voucherSave');


    //Account Report Section 
    Route::get('ledger-report','App\Http\Controllers\AccountReportController@ledgerReprt')->name('ledger-report');
    Route::get('ledger-report-show','App\Http\Controllers\AccountReportController@ledgerReprtShow');
    Route::get('group-ledger','App\Http\Controllers\AccountReportController@groupLedger')->name('group-ledger');
    Route::get('group-wise-ledger-report','App\Http\Controllers\AccountReportController@groupWiseLedgerReport')->name('group-wise-ledger-report');

    Route::post('group-base-ledger-report','App\Http\Controllers\AccountReportController@groupBaseLedgerReport');
    Route::get('group-base-ledger-filter-reset','App\Http\Controllers\AccountReportController@groupBaseLedgerFilterReset');
    Route::get('LedgerReportFilterReset','App\Http\Controllers\AccountReportController@LedgerReportFilterReset');


    Route::get('filter-voucher-history','App\Http\Controllers\AccountReportController@filterVoucherHistory');
    Route::post('report-voucher-history','App\Http\Controllers\AccountReportController@reportVoucherHistory');
    Route::get('resetFilter-voucher-history','App\Http\Controllers\AccountReportController@resetFilterVoucherHistory');

    Route::post('ledger-summary-report','App\Http\Controllers\AccountReportController@ledgerSummaryReport')->name('ledger-summary-report');
    Route::get('ledger-summary-filter-reset','App\Http\Controllers\AccountReportController@ledgerSummaryFilterReset');
    Route::get('filter-ledger-summary','App\Http\Controllers\AccountReportController@filterLedgerSummarray');



    Route::any('trail-balance','App\Http\Controllers\AccountReportController@trailBalance')->name('trail-balance');
    Route::any('trail-balance-report','App\Http\Controllers\AccountReportController@trailBalanceReport');
    Route::get('trail-balance-filter-reset','App\Http\Controllers\AccountReportController@trailBalanceReportFilterReset');

    Route::get('income-statement','App\Http\Controllers\AccountReportController@incomeStatement')->name('income-statement');
    Route::get('income-statement-filter-reset','App\Http\Controllers\AccountReportController@incomeStatementFilterReset');
    Route::post('income-statement-report','App\Http\Controllers\AccountReportController@incomeStatementReport');
    Route::post('income-statement-settings','App\Http\Controllers\AccountReportController@incomeStatementSettings');

    Route::get('balance-sheet','App\Http\Controllers\AccountReportController@balanceSheet')->name('balance-sheet');
    Route::get('balance-sheet-filter-reset','App\Http\Controllers\AccountReportController@balanceSheetFilterReset');
    Route::get('balance-sheet-report','App\Http\Controllers\AccountReportController@balanceSheetReport');


    Route::get('check_voucher_diff_amount','App\Http\Controllers\AccountReportController@check_voucher_diff_amount')->name('check_voucher_diff_amount');
    Route::get('general_balance-sheet','App\Http\Controllers\AccountReportController@general_balanceSheet')->name('general_balance-sheet');
    Route::get('general_balance-sheet-filter-reset','App\Http\Controllers\AccountReportController@general_balanceSheetFilterReset');
    Route::get('general_balance-sheet-report','App\Http\Controllers\AccountReportController@general_balanceSheetReport');

    Route::get('work-sheet','App\Http\Controllers\AccountReportController@workSheet')->name('work-sheet');
    Route::get('work-sheet-filter-reset','App\Http\Controllers\AccountReportController@workSheetFilterReset');
    Route::get('work-sheet-report','App\Http\Controllers\AccountReportController@workSheetReport');

    Route::get('cash-book','App\Http\Controllers\AccountReportController@cashBook')->name('cash-book');
    Route::get('cash-book-filter-reset','App\Http\Controllers\AccountReportController@cashBookFilterReset');
    Route::post('cash-book-report','App\Http\Controllers\AccountReportController@cashBookReport');

    Route::get('day-book','App\Http\Controllers\AccountReportController@dayBook')->name('day-book');
    Route::get('day-book-filter-reset','App\Http\Controllers\AccountReportController@dayBookFilterReset');
    Route::post('day-book-report','App\Http\Controllers\AccountReportController@dayBookReport');


    //Resturant Report Start
     Route::get('day-wise-summary-report','App\Http\Controllers\AccountReportController@dayWiseSummaryReportFilter');
    Route::get('day-wise-summary-report-filter-reset','App\Http\Controllers\AccountReportController@dayWiseSummaryReportFilterReset');
    Route::post('day-wise-summary-report','App\Http\Controllers\AccountReportController@dayWiseSummaryReport');

    Route::get('item-sales-report','App\Http\Controllers\AccountReportController@itemSalesReportFilter');
    Route::post('item-sales-report','App\Http\Controllers\AccountReportController@itemSalesReport');
    Route::get('item-sales-report-filter-reset','App\Http\Controllers\AccountReportController@itemSalesReportFilterReset');
    
    Route::get('detail-item-sales-report','App\Http\Controllers\AccountReportController@detailItemSalesReportFilter');
    Route::post('detail-item-sales-report','App\Http\Controllers\AccountReportController@detailItemSalesReport');
    Route::get('detail-item-sales-report-filter-reset','App\Http\Controllers\AccountReportController@detailItemSalesReportFilterReset');

    //Resturant Report End

    Route::get('user-wise-collection-payment','App\Http\Controllers\AccountReportController@userReceiptPayment');
    Route::get('user-wise-collection-payment-filter-reset','App\Http\Controllers\AccountReportController@userReceiptPaymentFilterReset');
    Route::post('user-wise-collection-payment-report','App\Http\Controllers\AccountReportController@userReceiptPaymentReport');

    Route::get('date-wise-invoice-print','App\Http\Controllers\AccountReportController@dateWiseInvoice');
    Route::get('date-wise-invoice-print-filter-reset','App\Http\Controllers\AccountReportController@dateWiseInvoiceFilterReset');
    Route::post('date-wise-invoice-print-report','App\Http\Controllers\AccountReportController@dateWiseInvoiceReport');

    Route::get('date-wise-restaurant-invoice-print','App\Http\Controllers\AccountReportController@dateWiseRestaurantInvoice');
    Route::get('date-wise-restaurant-invoice-print-filter-reset','App\Http\Controllers\AccountReportController@dateWiseRestaurantInvoiceFilterReset');
    Route::post('date-wise-restaurant-invoice-print-report','App\Http\Controllers\AccountReportController@dateWiseRestaurantInvoiceReport');

    Route::get('bank-book','App\Http\Controllers\AccountReportController@bankBook')->name('bank-book');
    Route::get('bank-book-filter-reset','App\Http\Controllers\AccountReportController@bankBookFilterReset');
    Route::post('bank-book-report','App\Http\Controllers\AccountReportController@bankBookReport');

    Route::get('receipt-payment','App\Http\Controllers\AccountReportController@receiptPayment')->name('receipt-payment');
    Route::get('receipt-payment-filter-reset','App\Http\Controllers\AccountReportController@receiptPaymentFilterReset');
    Route::post('receipt-payment-report','App\Http\Controllers\AccountReportController@receiptPaymentReport');
    
    //Searching section 
    Route::any('ledger-search','App\Http\Controllers\AccountLedgerController@ledger_search');
    Route::any('main-ledger-search','App\Http\Controllers\AccountLedgerController@mainLedgerSearch');
    Route::any('type_base_group','App\Http\Controllers\AccountLedgerController@type_base_group');
    Route::any('group-base-ledger','App\Http\Controllers\AccountLedgerController@groupBaseLedger');
    Route::any('group-base-sms-ledger','App\Http\Controllers\AccountLedgerController@groupBaseSmsLedger');
    Route::any('group-base-bill-party-ledger','App\Http\Controllers\AccountLedgerController@groupBaseBillParty');
    
    Route::any('group-base-ledger-purchase-statement','App\Http\Controllers\AccountLedgerController@groupBaseLedgerPurchaseStatement');
    Route::any('chart-of-account','App\Http\Controllers\AccountReportController@chartOfAccount')->name('chart-of-account');
    Route::any('chart-of-ledger','App\Http\Controllers\AccountReportController@chartOfLedger')->name('chart-of-ledger');
    Route::any('outstanding_detail_report','App\Http\Controllers\AccountReportController@outstanding_detail_report')->name('outstanding_detail_report');
 
    
    
    
    
    //################################
    //  Inventory Report Section Start
    //################################
    
Route::get('diff-inventory','App\Http\Controllers\InventoryReportController@difInventory');
Route::get('stock-balance','App\Http\Controllers\InventoryReportController@stockBalance');
Route::post('report-stock-balance','App\Http\Controllers\InventoryReportController@ReportstockBalance');

    Route::post('report-bill-party-statement','App\Http\Controllers\InventoryReportController@reportBillOfPartyStatement');
    Route::get('bill-party-statement','App\Http\Controllers\InventoryReportController@filterBillOfPartyStatement');
    Route::get('reset-bill-party-statement','App\Http\Controllers\InventoryReportController@resetBillOfPartyStatement');


Route::get('filter-item-history','App\Http\Controllers\InventoryReportController@filterItemHistory');
Route::post('report-item-history','App\Http\Controllers\InventoryReportController@reportItemHistory');
Route::get('reset-item-history','App\Http\Controllers\InventoryReportController@resetItemHistory');
Route::get('item-history-update','App\Http\Controllers\InventoryReportController@itemHistoryUpdate');




Route::get('category-wise-item-list','App\Http\Controllers\InventoryReportController@categoryWiseItemList');

    
    

    Route::post('report-barcode-history','App\Http\Controllers\InventoryReportController@reportBarcodeHistory');
    Route::get('barcode-history','App\Http\Controllers\InventoryReportController@filterBarcodeHistory');
    Route::get('reset-barcode-history','App\Http\Controllers\InventoryReportController@resetBarcodeHistory');   

    Route::post('report-date-wise-purchase','App\Http\Controllers\InventoryReportController@reportDateWisePurchaseStatement');
    Route::get('date-wise-purchase','App\Http\Controllers\InventoryReportController@filterDateWisePurchaseStatement');
    Route::get('reset-date-wise-purchase','App\Http\Controllers\InventoryReportController@resetDateWisePurchaseStatement'); 



    Route::post('report-date-wise-purchase-return','App\Http\Controllers\InventoryReportController@reportDateWisePurchaseReturnStatement');
    Route::get('purchase-return-detail','App\Http\Controllers\InventoryReportController@filterDateWisePurchaseReturnStatement');
    Route::get('reset-date-wise-purchase-return','App\Http\Controllers\InventoryReportController@resetDateWisePurchaseReturnStatement');
    Route::any('group-base-ledger-purchase-return','App\Http\Controllers\AccountLedgerController@groupBaseLedgerPurchaseReturnStatement');

    Route::post('report-date-wise-sales','App\Http\Controllers\InventoryReportController@reportDateWiseSalesStatement');
    Route::get('date-wise-sales','App\Http\Controllers\InventoryReportController@filterDateWiseSalesStatement');
    Route::get('reset-date-wise-sales','App\Http\Controllers\InventoryReportController@resetDateWiseSalesStatement');


/*New Extra Report for Purchase and Sales*/
    Route::get('transection_terms_wise_sales_report','App\Http\Controllers\InventoryReportController@transection_terms_wise_sales_report')->name('transection_terms_wise_sales_report');

    Route::get('date_to_date_sales_detail','App\Http\Controllers\InventoryReportController@date_to_date_sales_detail')->name('date_to_date_sales_detail');
    Route::get('date_to_date_sales_item_detail','App\Http\Controllers\InventoryReportController@date_to_date_sales_item_detail')->name('date_to_date_sales_item_detail');
    Route::get('date_to_date_sales_item_summary','App\Http\Controllers\InventoryReportController@date_to_date_sales_item_summary')->name('date_to_date_sales_item_summary');

    
    Route::get('date_to_date_purchases_detail','App\Http\Controllers\InventoryReportController@date_to_date_purchases_detail')->name('date_to_date_purchases_detail');
    Route::get('date_to_date_purchases_item_detail','App\Http\Controllers\InventoryReportController@date_to_date_purchases_item_detail')->name('date_to_date_purchases_item_detail');
    Route::get('date_to_date_purchases_item_summary','App\Http\Controllers\InventoryReportController@date_to_date_purchases_item_summary')->name('date_to_date_purchases_item_summary');

/*New Extra report for purchase and sales*/

    Route::post('report-actual-sales','App\Http\Controllers\InventoryReportController@reportActualSales');
    Route::get('filter-actual-sales','App\Http\Controllers\InventoryReportController@filterActualSales');
    Route::get('reset-actual-sales','App\Http\Controllers\InventoryReportController@resetActualSales');

    Route::get('date-wise-restaurant-sales','App\Http\Controllers\InventoryReportController@filterDateWiseRestaurantSalesStatement');
    Route::post('report-date-wise-restaurant-sales','App\Http\Controllers\InventoryReportController@reportDateWiseRestaurantSalesStatement');
    Route::get('reset-date-wise-restaurant-sales','App\Http\Controllers\InventoryReportController@resetDateWiseRestaurantSalesStatement');



    Route::any('group-base-ledger-sales','App\Http\Controllers\AccountLedgerController@groupBaseLedgerSalesStatement');

    Route::post('report-date-wise-sales-return','App\Http\Controllers\InventoryReportController@reportDateWiseSalesReturnStatement');
    Route::get('sales-return-detail','App\Http\Controllers\InventoryReportController@filterDateWiseSalesReturnStatement');
    Route::get('reset-date-wise-sales-return','App\Http\Controllers\InventoryReportController@resetDateWiseSalesReturnStatement');
    Route::any('group-base-ledger-sales-return','App\Http\Controllers\AccountLedgerController@groupBaseLedgerSalesReturnStatement');

    Route::post('report-stock-possition','App\Http\Controllers\InventoryReportController@reportStockPossition');
    Route::get('stock-possition','App\Http\Controllers\InventoryReportController@filterStockPossition');
    Route::get('reset-stock-possition','App\Http\Controllers\InventoryReportController@resetStockPossition');
    Route::get('stock-possition-cat-item','App\Http\Controllers\InventoryReportController@stockPossitionCatItem');
    Route::get('over_all_stock_possition','App\Http\Controllers\InventoryReportController@over_all_stock_possition');


    Route::post('report-stock-ledger','App\Http\Controllers\InventoryReportController@reportStockLedger');
    Route::get('stock-ledger','App\Http\Controllers\InventoryReportController@filterStockLedger');
    Route::get('reset-stock-ledger','App\Http\Controllers\InventoryReportController@resetStockLedger');
    Route::get('stock-ledger-cat-item','App\Http\Controllers\InventoryReportController@stockLedgerCatItem');

    Route::post('report-single-stock-ledger','App\Http\Controllers\InventoryReportController@reportSingleStockLedger');
    Route::get('single-stock-ledger','App\Http\Controllers\InventoryReportController@filterSingleStockLedger');
    Route::get('reset-single-stock-ledger','App\Http\Controllers\InventoryReportController@resetSingleStockLedger');

    Route::post('report-stock-value','App\Http\Controllers\InventoryReportController@reportStockValue');
    Route::get('stock-value','App\Http\Controllers\InventoryReportController@filterStockValue');
    Route::get('reset-stock-value','App\Http\Controllers\InventoryReportController@resetStockValue');
    Route::get('stock-value-cat-item','App\Http\Controllers\InventoryReportController@stockValueCatItem');

    Route::post('report-stock-value-register','App\Http\Controllers\InventoryReportController@reportStockValueRegister');
    Route::get('stock-value-register','App\Http\Controllers\InventoryReportController@filterStockValueRegister');
    Route::get('reset-stock-value-register','App\Http\Controllers\InventoryReportController@resetStockValueRegister');
    Route::get('stock-value-register-cat-item','App\Http\Controllers\InventoryReportController@stockValueRegisterCatItem');

    Route::post('report-gross-profit','App\Http\Controllers\InventoryReportController@reportGrossProfit');
    Route::get('gross-profit','App\Http\Controllers\InventoryReportController@filterGrossProfit');
    Route::get('reset-gross-profit','App\Http\Controllers\InventoryReportController@resetGrossProfit');
    Route::get('gross-profit-cat-item','App\Http\Controllers\InventoryReportController@grossProfitCatItem');

    Route::post('report-expired-item','App\Http\Controllers\InventoryReportController@reportExpiredItem');
    Route::get('expired-item','App\Http\Controllers\InventoryReportController@filterExpiredItem');
    Route::get('reset-expired-item','App\Http\Controllers\InventoryReportController@resetExpiredItem');
    Route::get('expired-item-cat-item','App\Http\Controllers\InventoryReportController@expiredItemCatItem');

    Route::get('shortage-item','App\Http\Controllers\InventoryReportController@filterShortageItem');
    Route::post('report-shortage-item','App\Http\Controllers\InventoryReportController@reportShortageItem');
    Route::get('reset-shortage-item','App\Http\Controllers\InventoryReportController@resetShortageItem');
    Route::get('shortage-item-cat-item','App\Http\Controllers\InventoryReportController@shortageItemCatItem');

    

    //################################
    //  Inventory Report Section End
    //################################
    

    //Admin section end

    //Admin section Route Controller
    Route::get('admin-settings','App\Http\Controllers\GeneralSettingsController@settings')->name('admin-settings');
    Route::get('admin-truncate','App\Http\Controllers\GeneralSettingsController@tableTruncate')->name('admin-truncate');
    Route::post('admin-settings-store','App\Http\Controllers\GeneralSettingsController@settingsSave')->name('admin-settings-store');
    Route::post('_lock_action','App\Http\Controllers\GeneralSettingsController@lockAction');
    Route::post('all-lock','App\Http\Controllers\GeneralSettingsController@allLockSystem');
    Route::get('all-lock','App\Http\Controllers\GeneralSettingsController@allLock')->name('all-lock');
    Route::get('lock-reset','App\Http\Controllers\GeneralSettingsController@lockReset');
    Route::get('databaseBackup','App\Http\Controllers\GeneralSettingsController@databaseBackup')->name('databaseBackup');


    Route::get('invoice-prefix','App\Http\Controllers\GeneralSettingsController@invoicePrefix')->name('invoice-prefix');
    Route::post('invoice-prefix-store','App\Http\Controllers\GeneralSettingsController@invoicePrefixStore');
    Route::get('account_group_configs','App\Http\Controllers\AccountGroupConfigController@index');
    Route::post('account_group_configs_save','App\Http\Controllers\AccountGroupConfigController@store')->name('account_group_configs_save');



Route::resource('material-issue',MaterialIssueController::class);
Route::resource('item-type',ItemTypeController::class);

Route::post('material-issue-setting', 'App\Http\Controllers\MaterialIssueController@Settings');
Route::get('material-issue-setting-modal', 'App\Http\Controllers\MaterialIssueController@formSettingAjax');
Route::get('available-qty-check-for-materail-issue-update', 'App\Http\Controllers\MaterialIssueController@checkQtyUpdateFoMaterialIssue');
Route::get('item-issue-edit-barcode-search', 'App\Http\Controllers\MaterialIssueController@itemIssueEditBarcodeSearch');
Route::get('material-issue/print/{id}', 'App\Http\Controllers\MaterialIssueController@Print');
Route::get('material-issue/challan/{id}', 'App\Http\Controllers\MaterialIssueController@challanPrint');
Route::get('net-material-issue-after-return/{id}', 'App\Http\Controllers\MaterialIssueController@issueAfterReturn');




 Route::resource('material-issue-return', MaterialIssueReturnController::class);
    Route::post('material-issue-return/update', 'App\Http\Controllers\MaterialIssueReturnController@update');
    Route::get('material-issue-return-reset', 'App\Http\Controllers\MaterialIssueReturnController@reset');
    Route::get('material-issue-return/print/{id}', 'App\Http\Controllers\MaterialIssueReturnController@Print');
    Route::post('material-issue-return-settings', 'App\Http\Controllers\MaterialIssueReturnController@Settings');
    Route::get('material-issue-return-setting-modal', 'App\Http\Controllers\MaterialIssueReturnController@formSettingAjax');
    Route::get('material-issue-search', 'App\Http\Controllers\MaterialIssueReturnController@orderSearch');
    Route::post('material-issue-details', 'App\Http\Controllers\MaterialIssueReturnController@issueDetail');
    Route::get('check-material-issue-return-available-qty', 'App\Http\Controllers\MaterialIssueReturnController@checkAvailableSalesQty');
    Route::get('material-issue-return-money-receipt/{id}', 'App\Http\Controllers\MaterialIssueReturnController@moneyReceipt');
    Route::post('material-issue-return-detail', 'App\Http\Controllers\MaterialIssueReturnController@salesReturnDetail');
    Route::get('material-issue-return/challan/{id}', 'App\Http\Controllers\MaterialIssueReturnController@challanPrint');
    



Route::get('user-profile','App\Http\Controllers\UserController@userProfile');
    Route::post('user-profile-update','App\Http\Controllers\UserController@profileUpdate');


});

