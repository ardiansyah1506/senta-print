<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Operator\ProductionController;
use App\Http\Controllers\User\CustomerPortalController;
use App\Http\Controllers\AuthController;

// Public Pages
Route::get('/', [PublicPageController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User/Customer Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/buat-pesanan', [CustomerPortalController::class, 'createOrder'])->name('order.create');
    Route::get('/lacak-pesanan', [CustomerPortalController::class, 'trackOrder'])->name('order.track');
    Route::get('/riwayat-pesanan', [CustomerPortalController::class, 'orderHistory'])->name('order.history');
});

// Protected Admin & Operator Routes
Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('master-kategori', CategoryController::class)->parameters(['master-kategori' => 'category']);
        Route::resource('data-master', AddonController::class)->parameters(['data-master' => 'addon']);
        
        Route::get('/kelola-pesanan', [OrderController::class, 'index'])->name('order.index');
        Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    });

    // Operator Routes
    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('/kelolaproduksi', [ProductionController::class, 'index'])->name('production.index');
        Route::get('/tracking', [ProductionController::class, 'tracking'])->name('tracking');
    });
});

