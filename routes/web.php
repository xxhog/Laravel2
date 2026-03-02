<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'home'])->name('landing.home');
Route::get('/catalog', [LandingController::class, 'catalog'])->name('landing.catalog');
Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
Route::get('/landing/login', [LandingController::class, 'login'])->name('landing.login');
Route::get('/landing/register', [LandingController::class, 'register'])->name('landing.register');
Route::get('/product/{product}', [LandingController::class, 'product'])->name('landing.product');
Route::get('/admin', [LandingController::class, 'admin'])->name('admin');


Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.status');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
});


Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Profile & Orders
    Route::get('/profile', [LandingController::class, 'profile'])->name('landing.profile');
    Route::get('/orders', [LandingController::class, 'orders'])->name('landing.orders');

    Route::get('/404', function() {
        return view('404');
    });
});

Auth::routes();
