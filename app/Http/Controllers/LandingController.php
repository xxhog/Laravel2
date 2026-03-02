<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;

class LandingController extends Controller
{
    public function home()
    {
        $products = DB::table('products')-> get();

        return view('home' , compact('products'));
    }

    public function catalog()
    {
        $products = Product::orderBy('title')->get();

        return view('catalog', compact('products'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function contact()
    {
        return view('contact');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function profile()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['cart.items'])->latest()->get();
        $activeOrders = $orders->whereIn('status', ['pending', 'processing'])->take(2);
        $recentOrders = $orders->take(5);
        $stats = [
            'active' => $orders->whereIn('status', ['pending', 'processing'])->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'completed' => $orders->where('status', 'done')->count(),
        ];

        return view('profile', compact('user', 'activeOrders', 'recentOrders', 'stats'));
    }

    public function admin()
    {
        return view('admin');
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

    public function product(Product $product): View
    {
        return view('product', compact('product'));
    }
}

