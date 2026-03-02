<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ГЛАВНАЯ АДМИНКИ
    public function index()
    {
        $orders = Order::with('user', 'cart.items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        $products = Product::orderBy('title')->get();

        return view('admin', compact('orders', 'products'));
    }

    // СМЕНА СТАТУСА ЗАКАЗА
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,confirmed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.index')->with('success', 'Статус заказа обновлен');
    }

    // ДОБАВЛЕНИЕ ТОВАРА
    public function storeProduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'specs' => 'nullable|string',
            'image_path' => 'nullable|string'
        ]);

        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'specs' => $request->specs,
            'image_path' => $request->image_path ?? 'default.jpg'
        ]);

        return redirect()->route('admin')->with('success', 'Товар успешно добавлен');
    }

    // ОБНОВЛЕНИЕ ТОВАРА
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'specs' => 'nullable|string',
            'image_path' => 'nullable|string'
        ]);

        $product->update([
            'title' => $request->title,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'specs' => $request->specs,
            'image_path' => $request->image_path ?? $product->image_path
        ]);

        return redirect()->route('admin')->with('success', 'Товар успешно обновлен');
    }

    // УДАЛЕНИЕ ТОВАРА
    public function destroyProduct(Product $product)
    {
        // Проверяем, есть ли заказы с этим товаром
        $inOrders = \DB::table('cart_items')
            ->where('product_id', $product->id)
            ->exists();

        if ($inOrders) {
            return redirect()->route('admin')->with('error', 'Нельзя удалить товар, который есть в заказах');
        }

        $product->delete();

        return redirect()->route('admin')->with('success', 'Товар успешно удален');
    }
}
