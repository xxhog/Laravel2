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
        $orders = $user->orders()->with(['cart.items'])->latest()->get();

        $stats = [
            'active' => $orders->whereIn('status', ['pending', 'processing'])->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'completed' => $orders->where('status', 'done')->count(),
        ];

        return view('profile', [
            'user' => $user,
            'activeOrders' => $orders->whereIn('status', ['pending', 'processing'])->take(2),
            'recentOrders' => $orders->take(5),
            'stats' => $stats
        ]);
    }

    public function orders()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['cart.items.product'])
            ->latest()
            ->get();

        return view('orders', compact('orders'));
    }
}