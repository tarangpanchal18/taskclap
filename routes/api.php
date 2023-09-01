<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\API\v1\HomeApiController;

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
Route::prefix(config('app.api_version'))->name('api.v1.')->group( function () {
    Route::post('login', [AuthController::class, 'signin'])->name('signin');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::middleware(['customApiAuthenticate'])->group( function () {
        Route::get('getHomeData', [HomeApiController::class, 'getHomeData'])->name('getHomeData');
    });
});

Route::get('category', [CategoryApiController::class, 'index'])->name('api.category');
Route::get('subcategory', [CategoryApiController::class, 'subcategory'])->name('api.subcategory');
