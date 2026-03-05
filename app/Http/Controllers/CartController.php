<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();

        // Получаем корзину пользователя
        $cart = $user->cart;

        // Если корзины нет — создаём
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        // 👇 БЕЗ ЭТОЙ СТРОКИ ТОВАРЫ НЕ ПОКАЖУТСЯ
        $cart->load('items.product');

        return view('cart', compact('cart'));
    }

    public function add(Product $product)
    {


        $user = Auth::user();

        $cart = $user->cart;


        if (!$cart) {
            try {
                $cart = Cart::create(['user_id' => $user->id]);
            } catch (\Exception $e) {
                dd($e->getMessage()); // 👈 ВЫПЛЮНЕТ ОШИБКУ
            }
        }

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity = $item->quantity + 1;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item->quantity = $request->quantity;
        $item->save();

        return redirect()->back()->with('success', 'Количество обновлено');
    }

    public function remove(CartItem $item)
    {
        $item->delete();

        return redirect()->back()->with('success', 'Товар удален из корзины');
    }

    public function clear()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->back()->with('success', 'Корзина очищена');
    }
}
