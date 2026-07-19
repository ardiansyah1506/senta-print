<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\Admin\MasterDataController;
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

// User/Customer Routes (No auth for buatan pesanan in initial design maybe? But let's leave it outside or group it if specified)
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/buat-pesanan', [CustomerPortalController::class, 'createOrder'])->name('order.create');
    Route::get('/lacak-pesanan', [CustomerPortalController::class, 'trackOrder'])->name('order.track');
    Route::get('/riwayat-pesanan', [CustomerPortalController::class, 'orderHistory'])->name('order.history');
});

// Protected Admin & Operator Routes
Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/master-kategori', [MasterDataController::class, 'indexCategory'])->name('category.index');
        Route::post('/master-kategori', [MasterDataController::class, 'storeCategory'])->name('category.store');
        Route::get('/master-kategori/show', [MasterDataController::class, 'showCategory'])->name('category.show');
        
        Route::get('/data-master', [MasterDataController::class, 'indexMaster'])->name('master.index');
        Route::post('/data-master/addon', [MasterDataController::class, 'storeAddon'])->name('addon.store');
        Route::delete('/data-master/addon/{id}', [MasterDataController::class, 'destroyAddon'])->name('addon.destroy');
        
        Route::get('/kelola-pesanan', [OrderController::class, 'index'])->name('order.index');
        Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    });

    // Operator Routes
    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('/kelolaproduksi', [ProductionController::class, 'index'])->name('production.index');
        Route::get('/tracking', [ProductionController::class, 'tracking'])->name('tracking');
    });
});

