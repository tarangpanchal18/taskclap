<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController AS AuthControllerV1;
use App\Http\Controllers\Api\v1\CategoryApiController AS CategoryApiControllerV1;

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
    Route::post('login', [AuthControllerV1::class, 'signin'])->name('signin');
    Route::post('signup', [AuthControllerV1::class, 'signup'])->name('signup');
    Route::middleware(['customApiAuthenticate'])->group( function () {
        Route::get('test', [CategoryApiControllerV1::class, 'index'])->name('test');
    });
});

Route::get('category', [CategoryApiControllerV1::class, 'index'])->name('api.category');
Route::get('subcategory', [CategoryApiControllerV1::class, 'subcategory'])->name('api.subcategory');
