<?php

use App\Http\Controllers\Api\AccountApiController;
use App\Http\Controllers\Api\CartApiController;
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

// Account API
Route::prefix('account')->middleware(["auth"])->group(function () {
    Route::put("/infor", [AccountApiController::class, "updateInfor"])->name("api.account.infor.update");
    Route::patch("/password", [AccountApiController::class, "changePassword"])->name("api.account.password.update");
});

// Cart API
Route::get("/cart/count", [CartApiController::class, 'count'])->name('api.cart.count');
Route::post("/cart", [CartApiController::class, 'addToCart'])->name('api.cart.store');
