<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MealPackageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/menu', [MenuItemController::class, 'index'])->name('menu.index');

Route::get('/paket', [MealPackageController::class, 'index'])->name('packages.index');
Route::get('/paket/{package}', [MealPackageController::class, 'show'])->name('packages.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/menu/{menuItem}', [CartController::class, 'addMenu'])->name('cart.addMenu');
    Route::post('/keranjang/paket/{package}', [CartController::class, 'addPackage'])->name('cart.addPackage');
    Route::patch('/keranjang/{key}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{key}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/keranjang', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
});
