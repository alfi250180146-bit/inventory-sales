<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Route yang Wajib Login
Route::middleware(['auth'])->group(function () {

    // 1. Fitur yang BISA diakses SEMUA Role (Admin & Staff Kasir)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sales', SaleController::class); // Kasir & Admin bisa transaksi penjualan

    // 2. Fitur KHUSUS ADMIN (Staff Kasir ditolak jika akses via URL)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('purchases', PurchaseController::class);
    });

});