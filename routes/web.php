<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// 1. ANA SAYFA ROTASI
Route::get('/', function () {
    return view('welcome');
});

// 2. KULLANICI SEPET VE SİPARİŞ HAREKETLERİ
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

// 3. NOVALISTE ÜRÜN, KATEGORİ VE MÜŞTERİ ROTALARI (Butonların tam istediği formatta kanka)
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::resource('customers', \App\Http\Controllers\CustomerController::class);

// 4. HOCANIN İSTEDİĞİ SİPARİŞ YÖNETİM ROTALARI
Route::prefix('/admin/orders')->name('admin.orders.')->controller(AdminOrderController::class)->group(function () {
    Route::get('/', 'index')->name('index');                // admin.orders.index
    Route::get('/show/{order}', 'show')->name('show');      // admin.orders.show
    Route::post('/status/{order}', 'updateStatus')->name('updateStatus'); // admin.orders.updateStatus
});