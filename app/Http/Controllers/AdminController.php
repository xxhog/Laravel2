<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::with('user', 'items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        $products = Product::orderBy('title')->get();
        return view('admin', compact('orders', 'products'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,confirmed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin')->with('success', 'Статус заказа обновлен');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = 'images/no_image.jpg';

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $fileName);
            $imagePath = 'images/' . $fileName;
        }

        Product::create([
            'title' => $request->title,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'specs' => $request->specs,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin')->with('success', 'Товар успешно добавлен!');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['title', 'category', 'price', 'stock', 'description', 'specs']);

        if ($request->hasFile('image')) {
            if ($product->image_path && $product->image_path !== 'images/no_image.jpg') {
                if (File::exists(public_path($product->image_path))) {
                    File::delete(public_path($product->image_path));
                }
            }

            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $fileName);
            $data['image_path'] = 'images/' . $fileName;
        }

        $product->update($data);

        return redirect()->route('admin')->with('success', 'Товар успешно обновлен');
    }


    // Метод удаления товара
    public function destroyProduct(Product $product)
    {
        // Проверяем, нет ли товара в активных корзинах
        $inItems = \DB::table('cart_items')->where('product_id', $product->id)->exists();

        if ($inItems) {
            return redirect()->back()->with('error', 'Нельзя удалить товар, который добавлен в корзины!');
        }

        // Удаляем файл изображения
        if ($product->image_path && $product->image_path !== 'images/no_image.jpg') {
            if (\File::exists(public_path($product->image_path))) {
                \File::delete(public_path($product->image_path));
            }
        }

        $product->delete();

        return redirect()->route('admin')->with('success', 'Препарат удален из базы');
    }
    // Замени финал на это для проверки

}