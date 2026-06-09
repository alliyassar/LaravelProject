<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. KULLANICI ÖN YÜZÜ VE ÜRÜN ROTALARI
// ==========================================
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/home', [ProductController::class, 'index'])->name('home.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('product.review.store');

// ==========================================
// 2. SEPET VE ÖDEME ROTALARI
// ==========================================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

// ==========================================
// 3. GİRİŞ YAPMA / KAYIT OLMA ROTALARI
// ==========================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'registerForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});

// ==========================================
// 4. HOCANIN İSTEDİĞİ ADMIN PANELİ ROTALARI (AdminLTE UYUMU)
// ==========================================
Route::prefix('/admin')->name('admin.')->group(function () {
    
    // Admin Panel Ana Sayfası (Dashboard - Renkli Kutuların Olduğu Yer)
    Route::get('/', function () { 
        return view('admin.index'); 
    })->name('index');

    // Sipariş Yönetimi Rotaları (Filtreleme, Detay ve Durum Güncelleme)
    Route::prefix('orders')->name('orders.')->controller(AdminOrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');                                // admin.orders.index
        Route::get('/show/{order}', 'show')->name('show');                      // admin.orders.show
        Route::post('/status/{order}', 'updateStatus')->name('updateStatus');   // admin.orders.updateStatus
    });

    // Ürün, Kategori ve Müşteri Resource Rotaları
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('customers', CustomerController::class);
});