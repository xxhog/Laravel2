<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('/', [LandingController::class, 'home'])->name('landing.home');

// ИСПРАВЛЕНО: Теперь имя совпадает с тем, что ищет ошибка (landing.catalog)
Route::get('/catalog', [LandingController::class, 'catalog'])->name('landing.catalog');

Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
Route::get('/product/{product}', [LandingController::class, 'product'])->name('landing.product');

// Эти маршруты обычно обрабатываются Auth::routes(), но если нужны свои:
Route::get('/landing/login', [LandingController::class, 'login'])->name('landing.login');
Route::get('/landing/register', [LandingController::class, 'register'])->name('landing.register');

// Маршруты только для авторизованных пользователей
Route::middleware('auth')->group(function () {

    // Админ-панель
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.status');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

    // Корзина (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Профиль и Заказы
    Route::get('/profile', [LandingController::class, 'profile'])->name('landing.profile');
    Route::get('/orders', [LandingController::class, 'orders'])->name('landing.orders');
});

// 404 страница
Route::fallback(function () {
    return view('404');
});

Auth::routes();
Auth::routes();


