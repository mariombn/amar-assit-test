<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('customer')->group(function () {
        Route::post('/', [\App\Http\Controllers\CustomerController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\CustomerController::class, 'show']);
        Route::put('{id}', [\App\Http\Controllers\CustomerController::class, 'update']);
    });

    Route::prefix('charge')->group(function () {
        Route::post('/', [\App\Http\Controllers\ChargeController::class, 'index']);
        Route::post('{id}/make-payment', [\App\Http\Controllers\ChargeController::class, 'makePayment']);
    });
});
