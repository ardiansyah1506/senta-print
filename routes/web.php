<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Operator\ProductionController;
use App\Http\Controllers\User\CustomerPortalController;

// Public Pages
Route::get('/', [PublicPageController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/master-kategori', [MasterDataController::class, 'indexCategory'])->name('category.index');
    Route::get('/master-kategori/create', [MasterDataController::class, 'createCategory'])->name('category.create');
    Route::get('/master-kategori/show', [MasterDataController::class, 'showCategory'])->name('category.show');
    Route::get('/data-master', [MasterDataController::class, 'indexMaster'])->name('master.index');
    Route::get('/kelola-pesanan', [OrderController::class, 'index'])->name('order.index');
    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
});

// Operator Routes
Route::prefix('operator')->name('operator.')->group(function () {
    Route::get('/kelolaproduksi', [ProductionController::class, 'index'])->name('production.index');
    Route::get('/tracking', [ProductionController::class, 'tracking'])->name('tracking');
});

// User/Customer Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/buat-pesanan', [CustomerPortalController::class, 'createOrder'])->name('order.create');
    Route::get('/lacak-pesanan', [CustomerPortalController::class, 'trackOrder'])->name('order.track');
    Route::get('/riwayat-pesanan', [CustomerPortalController::class, 'orderHistory'])->name('order.history');
});

