<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// 1. ANA SAYFA VE ÜRÜN DETAY ROTALARI (Tam Yol Tanımlayarak Hataları Kökten Çözdük Kral)
Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');
Route::post('/product/{id}/review', [\App\Http\Controllers\ProductController::class, 'storeReview'])->name('product.review.store');
Route::get('/home', [\App\Http\Controllers\ProductController::class, 'index'])->name('home.index');
Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.detail');

// 2. SEPET VE ÖDEME ÖN YÜZ ROTALARI
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
// Giriş ve Kayıt Rotaları 
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'registerForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});
// 3. ADMIN PANELİ VE SİPARİŞ YÖNETİM ROTALARI
Route::prefix('/admin')->name('admin')->group(function () {
    
    // Ürün, Kategori ve Müşteri Panelleri
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

    // Hocanın İstediği Sipariş Yönetim Rotaları
    Route::prefix('orders')->name('.orders.')->controller(AdminOrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');                // admin.orders.index
        Route::get('/show/{order}', 'show')->name('show');      // admin.orders.show
        Route::post('/status/{order}', 'updateStatus')->name('updateStatus'); // admin.orders.updateStatus
        // Ürün yönetimi ve envanter kayıt rotaları
Route::get('/admin/products/create', [App\Http\Controllers\ProductController::class, 'create']);
Route::post('/admin/products/store', [App\Http\Controllers\ProductController::class, 'store']);
    });
});