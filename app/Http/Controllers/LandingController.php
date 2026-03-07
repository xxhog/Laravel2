<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function home()
    {
        $products = Product::where('stock', '>', 0)->latest()->take(8)->get();

        return view('home', compact('products'));
    }

    public function catalog(Request $request)
    {
        $categories = Product::distinct()->pluck('category');

        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->available()->get();

        return view('catalog', compact('products', 'categories'));
    }

    public function product(Product $product): View
    {
        return view('product', compact('product'));
    }


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

        $allOrders = $user->orders()->with(['items.product'])->latest()->get();

        $activeOrders = $allOrders->whereIn('status', ['pending', 'processing']);

        $recentOrders = $allOrders->take(5);

        $stats = [
            'active' => $activeOrders->count(),
            'completed' => $allOrders->where('status', 'done')->count(),
        ];

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