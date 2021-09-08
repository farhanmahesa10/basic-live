<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\DreamController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MotivationController;
use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//for react testing
   
Route::group(['middleware' => 'auth:sanctum'],function(){
    
     Route::get('/allnotes',[NoteController::class,'index']);
    Route::post('/note/store',[NoteController::class,'store']);
    Route::post('/note/order',[NoteController::class,'order']);
    Route::post('/note/update',[NoteController::class,'update']);
    Route::post('/note/delete',[NoteController::class,'destroy']);
    Route::post('/note/delete/undo',[NoteController::class,'undoDestroy']);
    
    Route::get('/todolist/getall',[TodolistController::class,'index']);
    Route::get('/todolist/getbydream/{dreamid}',[TodolistController::class,'getbydream']);
    Route::post('/todolist/store',[TodolistController::class,'store']);
    Route::post('/todolist/updateorder',[TodolistController::class,'updateOrder']);
    Route::post('/todolist/update',[TodolistController::class,'update']);
    Route::post('/todolist/destroy',[TodolistController::class,'destroy']);
    Route::post('/todolist/destroyUndo',[TodolistController::class,'destroyUndo']);

    Route::get('/dream/getall',[DreamController::class,'index']);
    Route::post('/dream/store',[DreamController::class,'store']);
    Route::post('/dream/destroy',[DreamController::class,'destroy']);
    Route::post('/dream/destroyundo',[DreamController::class,'destroyUndo']);

    Route::get('/finance/getfinancebytype',[FinanceController::class,'index']);
    Route::get('/finance/totalallamount',[FinanceController::class,'totalallamount']);
    Route::post('/finance/store',[FinanceController::class,'store']);
    Route::post('/finance/update',[FinanceController::class,'update']);
    Route::post('/finance/destroy',[FinanceController::class,'destroy']);
    Route::post('/finance/delete/undo',[FinanceController::class,'destroyUndo']);

    Route::get('/motivation/getall',[MotivationController::class,'index']);
    Route::post('/motivation/store',[MotivationController::class,'store']);
    Route::post('/motivation/update',[MotivationController::class,'update']);
    Route::post('/motivation/destroy',[MotivationController::class,'destroy']);
    Route::post('/motivation/destroyundo',[MotivationController::class,'destroyUndo']);
    Route::post('/motivation/updateorder',[MotivationController::class,'updateOrder']);

    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/isauthenticated',[AuthController::class,'isauthenticated']);
}); 

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);