<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request; // Обязательно добавь это!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function home()
    {
        // Берем последние 8 товаров, которые есть в наличии
        $products = Product::where('stock', '>', 0)->latest()->take(8)->get();

        return view('home', compact('products'));
    }

    public function catalog(Request $request)
    {
        // 1. Получаем список всех уникальных категорий для выпадающего списка
        $categories = Product::distinct()->pluck('category');

        // 2. Начинаем строить запрос
        $query = Product::query();

        // 3. Если есть поиск по названию
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 4. Если выбрана категория
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 5. Берем товары в наличии (используем scope из модели) и выполняем запрос
        $products = $query->available()->get();

        // 6. ОДИН return в самом конце со всеми данными
        return view('catalog', compact('products', 'categories'));
    }

    public function product(Product $product): View
    {
        return view('product', compact('product'));
    }

    // --- Остальные методы (cart, profile, orders и т.д.) ---

    public function cart()
    {
        return view('cart');
    }

    public function contact()
    {
        return view('contact');
    }

    public function profile()
    {
        $user = Auth::user();

        // Получаем все заказы пользователя с товарами
        $allOrders = $user->orders()->with(['items.product'])->latest()->get();

        // Фильтруем активные (новые или в обработке)
        $activeOrders = $allOrders->whereIn('status', ['pending', 'processing']);

        // Берем последние 5 для истории
        $recentOrders = $allOrders->take(5);

        // Считаем простую статистику
        $stats = [
            'active' => $activeOrders->count(),
            'completed' => $allOrders->where('status', 'done')->count(),
        ];

        // Передаем ВСЕ переменные в компактном виде
        return view('profile', compact('user', 'activeOrders', 'recentOrders', 'stats'));
    }

    public function orders()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('orders', compact('orders'));
    }
}