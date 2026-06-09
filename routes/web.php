<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// 1. ANA SAYFA VE ÜRÜN DETAY ROTALARI
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', function () {
    return view('welcome');
})->name('home.index');

// 2. SEPET VE ÖDEME ÖN YÜZ ROTALARI (Giriş Şartı Kaldırıldı - Hoca Direkt Görecek)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

// 3. ADMIN PANELİ VE SİPARİŞ YÖNETİM ROTALARI
Route::prefix('/admin')->name('admin')->group(function () {
    
    // Ürün, Kategori ve Müşteri Panelleri (Eski Yapı)
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

    // Hocanın İstediği Sipariş Yönetim Rotaları
    Route::prefix('orders')->name('.orders.')->controller(AdminOrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');                // admin.orders.index
        Route::get('/show/{order}', 'show')->name('show');      // admin.orders.show
        Route::post('/status/{order}', 'updateStatus')->name('updateStatus'); // admin.orders.updateStatus
    });
});