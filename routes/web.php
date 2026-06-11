<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

// Admin Kontrolcülerini Karışmasın Diye Doğrudan İsimlendirerek Çağırıyoruz Kral
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes - NovaStore Rota Yönetimi
|--------------------------------------------------------------------------
*/

// ==========================================================
// 1. HOCANIN İSTEDİĞİ ESAS ADMIN PANELİ GRUBU (EN ÜSTE ALDIK Kİ ÇAKIŞMASIN)
// ==========================================================
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // Admin Dashboard Ana Sayfası
    Route::get('/', function () { 
        return view('admin.index'); 
    })->name('index');

    // Sipariş Yönetimi Rotaları (Durum Güncellemeli)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/show/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/status/{order}', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
    });

    // Ürün ve Kategori Yönetimi (Doğrudan Admin Klasöründeki Özel Kontrolcülere Gidiyor Reis)
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);

    // Müşteri Listesi
    Route::resource('customers', CustomerController::class);
});


// ==========================================================
// 2. KULLANICI ÖN YÜZÜ VE DİĞER ALANLAR (KARIŞIKLIĞI ÖNLEMEK İÇİN AYRILDI)
// ==========================================================

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/home', [ProductController::class, 'index'])->name('home.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('product.review.store');

// Sepet ve Ödeme Sistemleri
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

// Giriş / Çıkış İşlemleri
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'registerForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});