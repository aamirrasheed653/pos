<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/stock', [StockController::class, 'index']);
Route::Post('/purchase', [PurchaseController::class, 'purchase']);
Route::get('/p_index', [PurchaseController::class, 'index']);

Route::Post('/login', [UserController::class, 'login']);
Route::post('/update/{purchase}', [PurchaseController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::Post('/register', [UserController::class, 'register']);
    Route::Post('/purchase', [PurchaseController::class, 'purchase']);
    Route::Post('/update', [PurchaseController::class, 'update']);


});

