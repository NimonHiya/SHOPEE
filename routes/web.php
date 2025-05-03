<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\KategoriController; // Ensure this controller exists in the specified namespace

Route::get('/', function () {
    return view('welcome');
});

// Default authentication routes (login, register, etc.)
Auth::routes();  

Route::middleware(['auth'])->group(function () {
    // Routes for authenticated users
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    
    // Admin routes for managing transactions
    Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi.index');
    Route::post('/admin/transaksi/{id}/approve', [TransaksiController::class, 'approve'])->name('admin.transaksi.approve');
});

// Routes for product management
Route::get('/produk', [ProdukController::class, 'index'])->name('adminHome');
Route::get('produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Routes for the cart (only accessible to authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index'); 
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create'); 
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store'); 
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit'); 
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update'); 
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy'); 
});