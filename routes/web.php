<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/my-purchases', [ProdukController::class, 'myPurchases'])->middleware('auth')->name('purchase.purchases');
Route::get('/produk/{id}/buy', [ProdukController::class, 'showBuyForm'])->name('produk.buy');
Route::post('/produk/{id}/buy', [ProdukController::class, 'processPurchase'])->name('produk.purchase');




// Protected Routes (Requires Login)
Route::middleware(['auth'])->group(function () {

    // ✅ Show products to all logged-in users
    Route::get('/', [ProdukController::class, 'index'])->name('produk.index');

    // ✅ Only admin can manage products (Create, Edit, Delete)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::resource('produk', ProdukController::class)->except(['index', 'show']);
    });

});
