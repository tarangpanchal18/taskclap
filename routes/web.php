<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__ . '/admin_web.php';
require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
Route::get('category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('cart/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('cart/fetchService', [CartController::class, 'fetchService']);
Route::post('apply/promocode', [CartController::class, 'applyPromocode']);

Route::middleware('auth')->group(function () {
    Route::post('cart/fetchAddress', [CartController::class, 'fetchAddress']);
    Route::post('cart/rating', [CartController::class, 'rateOrder']);
    Route::post('cart/addAddress', [CartController::class, 'addAddress']);
    Route::post('cart/placeOrder', [CartController::class, 'placeOrder'])->name('placeOrder');
    Route::get('order/success', [CartController::class, 'orderPlaced'])->name('orderPlaced');
    Route::get('order/failed', [CartController::class, 'orderFailed'])->name('orderFailed');
    Route::get('my-bookings', [BookingController::class, 'index'])->name('myBookings');
    Route::get('my-bookings/{orderId}', [BookingController::class, 'detail'])->name('myBookingDetail');
    Route::get('download/invoice/{orderId}', [BookingController::class, 'downloadInvoice'])->name('downloadInvoice');

    Route::get('payment', [BookingController::class, 'charge'])->name('goToPayment');
});

Route::get('{subcategory}', [CartController::class, 'index'])->name('cart');
