<?php

namespace App\Http\Controllers;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("matrix", [MatrixController::class, 'index']);
Route::post("register-customer", [TenantController::class, 'registerCustomer']);
Route::post("paying-tenant", [TenantController::class, 'payingTenant']);
Route::post("rendeem-voucher", [TenantController::class, 'rendeemVoucher']);
Route::post("use-voucher", [TenantController::class, 'useVoucher']);
