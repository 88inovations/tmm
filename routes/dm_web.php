<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DamageAdjustmentController;
use App\Http\Controllers\DamageReceiveMasterController;
use App\Http\Controllers\DamageSendMasterController;
use App\Http\Controllers\DamageFromStockController;






 Route::get('item-damage-search', 'App\Http\Controllers\SalesController@itemDamageSearch');
Route::get('item-damage-search-edit', 'App\Http\Controllers\SalesController@itemDamageSearchEdit');
Route::get('check-available-qty-update-damage', 'App\Http\Controllers\SalesController@checkAvailableQtyUpdateDamage');



Route::resource('damage', DamageAdjustmentController::class);
 Route::post('damage/update', 'App\Http\Controllers\DamageAdjustmentController@update');
 Route::get('damage-reset', 'App\Http\Controllers\DamageAdjustmentController@reset');
 Route::get('damage/print/{id}', 'App\Http\Controllers\DamageAdjustmentController@Print');
 Route::post('damage-settings', 'App\Http\Controllers\DamageAdjustmentController@Settings');
 Route::get('damage-setting-modal', 'App\Http\Controllers\DamageAdjustmentController@formSettingAjax');




  /*Damage Item Receive Routes
     Start Time: 18-06-2024 1:40px
     End Time: 19-06-2024 12:16 AM
    
     Author: Md Farhad Ali

    */

    Route::resource('damage_receive', DamageReceiveMasterController::class);
    Route::post('damage_receive/update', 'App\Http\Controllers\DamageReceiveMasterController@update');
    Route::post('damage_receive-wise-detail', 'App\Http\Controllers\DamageReceiveMasterController@damage_receiveWiseDetail');
    Route::get('damage_receive-reset', 'App\Http\Controllers\DamageReceiveMasterController@reset');
    Route::get('damage_receive/print/{id}', 'App\Http\Controllers\DamageReceiveMasterController@damage_receivePrint');
    Route::post('damage_receive-settings', 'App\Http\Controllers\DamageReceiveMasterController@damage_receiveSettings');
    Route::get('damage_receive-money-receipt/{id}', 'App\Http\Controllers\DamageReceiveMasterController@moneyReceipt');

    /*Damage Item Send to Supplier Routes
     Start Time: 18-06-2024 1:40px
     End Time: 19-06-2024 12:16 AM
    
     Author: Md Farhad Ali

    */

    Route::resource('damage_send', DamageSendMasterController::class);
    Route::post('damage_send/update', 'App\Http\Controllers\DamageSendMasterController@update');
    Route::post('damage_send-wise-detail', 'App\Http\Controllers\DamageSendMasterController@damage_sendWiseDetail');
    Route::get('damage_send-reset', 'App\Http\Controllers\DamageSendMasterController@reset');
    Route::get('damage_send/print/{id}', 'App\Http\Controllers\DamageSendMasterController@damage_sendPrint');
    Route::post('damage_send-settings', 'App\Http\Controllers\DamageSendMasterController@damage_sendSettings');
    Route::get('damage_send-money-receipt/{id}', 'App\Http\Controllers\DamageSendMasterController@moneyReceipt');



   Route::resource('damage_from_stocks', DamageFromStockController::class);
   Route::post('damage_from_stocks/update', 'App\Http\Controllers\DamageFromStockController@update');
   Route::get('damage_from_stocks/print/{id}', 'App\Http\Controllers\DamageFromStockController@Print');


   Route::get('damage_report','App\Http\Controllers\DMReportController@damage_report');
   Route::get('dm_send_to_supplier','App\Http\Controllers\DMReportController@dm_send_to_supplier');
   Route::get('dm_receive_from_stock','App\Http\Controllers\DMReportController@dm_receive_from_stock');
   Route::get('dm_receive_from_customer','App\Http\Controllers\DMReportController@dm_receive_from_customer');
   //Route::get('dm_item_stock_value','App\Http\Controllers\DMReportController@dm_item_stock_value');
   Route::get('dm_item_stock_possition','App\Http\Controllers\DMReportController@dm_item_stock_possition');
   Route::post('report-damage-stock-possition','App\Http\Controllers\DMReportController@dm_report_item_stock_possition');
   Route::get('dm_item_ledger','App\Http\Controllers\DMReportController@dm_item_ledger');

   Route::get('dm_item_stock_value','App\Http\Controllers\DMReportController@stockBalance');
Route::post('report-damage-stock-balance','App\Http\Controllers\DMReportController@ReportstockBalance');







