<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::prefix(config('app.admin_path_name'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function() {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
    });

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');
        Route::resource('users', UserController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('banner', BannerController::class);
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

});
?>
