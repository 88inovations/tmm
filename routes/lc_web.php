<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\LC\LcMasterController;



Route::middleware(['auth'])->prefix('lc')->group(function () {
    Route::resource('lc_manage',LcMasterController::class);
    Route::get('lc_wise_item',[LcMasterController::class,'lc_wise_item'])->name('lc_wise_item');
    Route::get('lc_cost_calculation/{id}',[LcMasterController::class,'lc_cost_calculation'])->name('lc_cost_calculation');
    Route::get('/lc/export', [LcMasterController::class, 'exportToExcel'])->name('lc.export');
    
});

Route::get('/lc-master', function(){
   return view('procurment.lc-management.create');
});

Route::get('/lc-entry', function(){
   return view('procurment.lc-management.LCEntry');
});


