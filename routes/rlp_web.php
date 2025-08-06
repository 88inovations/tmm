<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RLP\RlpController;
use App\Http\Controllers\RLP\RlpChainController;
use App\Http\Controllers\Notesheet\NoteSheetMasterController;


//##########################
//  RLP Section Start
//
//#########
Route::group(['middleware' => ['auth']], function() {

Route::resource('rlp',RlpController::class);
Route::get('rlp-chain-wise-detail',[RlpController::class,'chainWiseDetail']);
Route::get('rlp-reset',[RlpController::class,'reset']);
Route::post('rlp-approve-reject',[RlpController::class,'rlpApproveReject']);
Route::resource('approval-chain',RlpChainController::class);
Route::resource('notesheet',NoteSheetMasterController::class);









});
