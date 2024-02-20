<?php

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\InquiryController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\Auth\TokenController;
use App\Http\Controllers\API\Auth\PasswordController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\API\CustomerOrderController;
use App\Http\Controllers\API\OrderListController;
use App\Http\Controllers\API\ReceiptController;
use App\Http\Controllers\API\MenuController;

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
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])->middleware('throttle');

// Default API Homepage
Route::get('/', [HomeController::class, '__invoke']);

// Profile
Route::get('/profile', [ProfileController::class, 'index']);
Route::put('/profile', [ProfileController::class, 'update']);

// user logout
Route::delete('oauth/token', [TokenController::class, 'delete'])->middleware('auth:api');
Route::get('/token/verify', [TokenController::class, 'verify']);

Route::post('register', [UserController::class, 'register']);

Route::post('activate', [UserController::class, 'activate']);

// Routes for Forget and Reset Password
Route::post('password/forgot', [PasswordController::class, 'forgot']);
Route::post('password/reset', [PasswordController::class, 'reset']);

// users route
Route::prefix('users')
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'create']);
        Route::get('{id}', [UserController::class, 'read']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::delete('bulk-delete', [UserController::class, 'bulkDelete']);
        Route::delete('{id}', [UserController::class, 'delete']);
    });

// inquiries route
Route::prefix('inquiries')
    ->group(function () {
        Route::post('/', [InquiryController::class, 'create']);
        Route::get('{id}', [InquiryController::class, 'read']);
});

Route::post('customer/order', [CustomerOrderController::class, 'create']);
Route::get('customer/list', [CustomerOrderController::class, 'getCustomer']);
Route::get('customer/order/{id}', [CustomerOrderController::class, 'read']);
Route::delete('customer/{id}', [CustomerOrderController::class, 'delete']);

Route::post('order/list', [OrderListController::class, 'create']);
Route::get('order/list/{id}', [OrderListController::class, 'read']);
Route::get('order/receipt/{id}', [OrderListController::class, 'getOrder']);

Route::post('receipt/', [ReceiptController::class, 'create']);
Route::get('receipt/', [ReceiptController::class, 'getAllOrder']);
Route::get('receipt/{id}', [ReceiptController::class, 'getOrderReceipt']);

Route::get('order/menu', [MenuController::class, 'getMenuList']);
Route::post('order/menu/add', [MenuController::class, 'create']);
Route::get('order/menu{id}', [MenuController::class, 'getMenu']);
Route::post('order/menu', [MenuController::class, 'getEdit']);
Route::delete('order/menu/{id}', [MenuController::class, 'delete']);
