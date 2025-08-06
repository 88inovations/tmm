<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PM\ProjectManagementController;
use App\Http\Controllers\PM\TenderController;


//##########################
//  Project Management Section Start
//
//#########
Route::group(['middleware' => ['auth']], function() {


//PM SECTION
Route::resource('tender',TenderController::class);
Route::resource('project_management',ProjectManagementController::class);



});