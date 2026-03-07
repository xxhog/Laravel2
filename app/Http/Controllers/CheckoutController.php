<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        //поиск корзины
        $cart = Cart::where('user_id', Auth::id())->with('items')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Ваша корзина пуста');
        }

        DB::transaction(function () use ($cart) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $cart->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                }),
                'status' => 'pending',
            ]);

            //в заказ
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            $cart->items()->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Заказ успешно оформлен!');
    }
}