<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Influencer\LinkController;
use App\Http\Controllers\Influencer\ProductController as InfluencerProductController;
use App\Http\Controllers\Checkout\LinkController as CheckoutLinkController;
use App\Http\Controllers\Checkout\OrderController as CheckoutOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Influencer\StatsController;
use Illuminate\Support\Facades\Route;

// Common
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::put('users/info', [AuthController::class, 'updateInfo']);
    Route::put('users/password', [AuthController::class, 'updatePassword']);
});

// Admin
Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api', 'scope:admin']], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::put('users/info', [AuthController::class, 'updateInfo']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);

        Route::namespace('Admin')->group(function () {
            Route::get('chart', [DashboardController::class, 'chart']);
            Route::post('upload', [ImageController::class, 'upload']);
            Route::get('export', [OrderController::class, 'export']);

            Route::apiResource('users', UserController::class);
            Route::apiResource('roles', RoleController::class);
            Route::apiResource('products', AdminProductController::class);
            Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
            Route::apiResource('permissions', PermissionController::class)->only(['index']);
        });
    });
});

// Influencer
Route::prefix('influencer')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('products', [InfluencerProductController::class, 'index']);

    Route::middleware(['auth:api', 'scope:influencer'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::put('users/info', [AuthController::class, 'updateInfo']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);

        Route::post('links', [LinkController::class, 'store']);
        Route::get('stats', [StatsController::class, 'index']);
        Route::get('rankings', [StatsController::class, 'rankings']);
    });
});

// Checkout
Route::group(['prefix' => 'checkout'], function () {
    Route::get('links/{code}', [CheckoutLinkController::class, 'show']);
    Route::post('orders', [CheckoutOrderController::class, 'store']);
    Route::post('orders/confirm', [CheckoutOrderController::class, 'confirm']);
});

