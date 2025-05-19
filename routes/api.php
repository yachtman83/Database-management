<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// 📌 Авторизация (остается доступной без токена)
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    // 🔒 Доступ только для авторизованных пользователей
    Route::middleware(['jwt.auth'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [AuthController::class, 'me']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::put('change-password', [AuthController::class, 'changePassword']);
    });
});


// 🔒 Защищаем CRUD-операции, требующие авторизации
Route::middleware(['jwt.auth'])->group(function () {
    Route::apiResource('product_types', App\Http\Controllers\ProductTypeController::class);
    Route::apiResource('details', App\Http\Controllers\DetailController::class);
    Route::apiResource('employees', App\Http\Controllers\EmployeeController::class);
    Route::apiResource('workshops', App\Http\Controllers\WorkshopController::class);
    Route::apiResource('salary_histories', App\Http\Controllers\SalaryHistoryController::class);
    Route::post('/workshops/{workshop}/attach-product', [App\Http\Controllers\WorkshopController::class, 'attachProduct']);
    Route::post('/workshops/{workshop}/detach-product', [App\Http\Controllers\WorkshopController::class, 'detachProduct']);
});
