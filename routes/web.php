<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- ПУБЛИЧНЫЕ МАРШРУТЫ (доступны всем) ---
Route::get('/', [LandingController::class, 'home'])->name('landing.home');
Route::get('/catalog', [LandingController::class, 'catalog'])->name('landing.catalog');
Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
Route::get('/product/{product}', [LandingController::class, 'product'])->name('landing.product');

// --- МАРШРУТЫ ДЛЯ АВТОРИЗОВАННЫХ (и юзер, и админ) ---
Route::middleware('auth')->group(function () {

    // Профиль и Заказы
    Route::get('/profile', [LandingController::class, 'profile'])->name('landing.profile');
    Route::get('/orders', [LandingController::class, 'orders'])->name('landing.orders');

    // Корзина (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Оформление заказа (Checkout) - не забудь добавить этот маршрут позже
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// --- МАРШРУТЫ ТОЛЬКО ДЛЯ АДМИНА ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // Управление товарами
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

    // Управление заказами
    Route::post('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.status');
});

// Авторизация (Login, Register, Logout)
Auth::routes();

// 404 страница
Route::fallback(function () {
    return view('404');
});