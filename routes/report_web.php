<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;


//##########################
//  Import Related Report Section
//
//#########
Route::group(['middleware' => ['auth']], function() {


Route::get('report-panel',[ReportController::class,'reportPanel']);




});