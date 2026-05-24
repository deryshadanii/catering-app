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
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\MealPackageController as AdminMealPackageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;


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
    Route::post('/keranjang/paket/{mealPackage}', [CartController::class, 'addPackage'])->name('cart.addPackage');

    Route::patch('/keranjang/{cartKey}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/keranjang', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/menu', [AdminMenuItemController::class, 'index'])->name('menu-items.index');
        Route::get('/menu/create', [AdminMenuItemController::class, 'create'])->name('menu-items.create');
        Route::post('/menu', [AdminMenuItemController::class, 'store'])->name('menu-items.store');
        Route::get('/menu/{menuItem}/edit', [AdminMenuItemController::class, 'edit'])->name('menu-items.edit');
        Route::patch('/menu/{menuItem}', [AdminMenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('/menu/{menuItem}', [AdminMenuItemController::class, 'destroy'])->name('menu-items.destroy');

        Route::get('/paket', [AdminMealPackageController::class, 'index'])->name('packages.index');
        Route::get('/paket/create', [AdminMealPackageController::class, 'create'])->name('packages.create');
        Route::post('/paket', [AdminMealPackageController::class, 'store'])->name('packages.store');
        Route::get('/paket/{mealPackage}/edit', [AdminMealPackageController::class, 'edit'])->name('packages.edit');
        Route::patch('/paket/{mealPackage}', [AdminMealPackageController::class, 'update'])->name('packages.update');
        Route::delete('/paket/{mealPackage}', [AdminMealPackageController::class, 'destroy'])->name('packages.destroy');

        Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        Route::patch('/pesanan/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::patch('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::delete('/pesanan/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('/laporan', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan/export', [AdminReportController::class, 'exportCsv'])->name('reports.export');
    });
});
