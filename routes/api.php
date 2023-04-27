<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;

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

Route::get('category', [CategoryApiController::class, 'index'])->name('api.category');
Route::get('subcategory', [CategoryApiController::class, 'subcategory'])->name('api.subcategory');
