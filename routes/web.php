<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Operator\ProductionController;
use App\Http\Controllers\User\CustomerPortalController;
use App\Http\Controllers\AuthController;

// Public Pages
Route::get('/', [PublicPageController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User/Customer Routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':customer,admin'])->prefix('user')->name('user.')->group(function () {
    Route::get('/buat-pesanan', [CustomerPortalController::class, 'createOrder'])->name('order.create');
    Route::post('/buat-pesanan', [CustomerPortalController::class, 'storeOrder'])->name('order.store');
    Route::get('/lacak-pesanan', [CustomerPortalController::class, 'trackOrder'])->name('order.track');
    Route::get('/riwayat-pesanan', [CustomerPortalController::class, 'orderHistory'])->name('order.history');
});

// Protected Admin & Operator Routes
Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware([\App\Http\Middleware\CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('master-kategori', CategoryController::class)->parameters(['master-kategori' => 'category']);
        Route::post('master-kategori/{category}/sync-sizes', [CategoryController::class, 'syncSizes'])->name('master-kategori.syncSizes');
        Route::post('master-kategori/{category}/size-chart', [CategoryController::class, 'uploadSizeChart'])->name('master-kategori.uploadSizeChart');
        Route::delete('master-kategori/{category}/size-chart', [CategoryController::class, 'removeSizeChart'])->name('master-kategori.removeSizeChart');
        Route::post('master-kategori/{category}/addons', [CategoryController::class, 'addAddon'])->name('master-kategori.addAddon');
        Route::delete('master-kategori/{category}/addons/{addon_id}', [CategoryController::class, 'removeAddon'])->name('master-kategori.removeAddon');
        Route::post('master-kategori/{category}/products', [CategoryController::class, 'addProduct'])->name('master-kategori.addProduct');
        Route::delete('master-kategori/{category}/products/{product_id}', [CategoryController::class, 'removeProduct'])->name('master-kategori.removeProduct');
        Route::resource('data-master', AddonController::class)->parameters(['data-master' => 'addon']);
        Route::resource('ukuran', SizeController::class);
        Route::resource('manajemen-user', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'show', 'edit', 'update']);
        
        Route::resource('kelola-pesanan', OrderController::class)->parameters(['kelola-pesanan' => 'order'])->names('order');
        Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    });

    // Operator Routes
    Route::middleware([\App\Http\Middleware\CheckRole::class . ':operator,admin'])->prefix('operator')->name('operator.')->group(function () {
        Route::get('/kelolaproduksi', [ProductionController::class, 'index'])->name('production.index');
        Route::get('/tracking/{id}', [ProductionController::class, 'tracking'])->name('tracking');
        Route::post('/tracking/{id}', [ProductionController::class, 'storeLog'])->name('tracking.store');
    });
});

