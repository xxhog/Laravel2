@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 cart-title">Корзина</h1>

        {{-- СООБЩЕНИЯ --}}
        @if(session('success'))
            <div class="alert alert-dismissible fade show cart-alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ТОВАРЫ В КОРЗИНЕ --}}
        @if($cart->items->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle cart-table">
                    <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Сумма</th>
                        <th>Количество</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart->items as $item)
                        <tr>
                            {{-- ТОВАР --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->product->image_path)
                                        <img src="{{ asset('images/landing/' . $item->product->image_path) }}"
                                             alt="{{ $item->product->title }}"
                                             class="cart-product-image">
                                    @endif
                                    <span class="cart-text-dark">{{ $item->product->title }}</span>
                                </div>
                            </td>

                            {{-- СУММА --}}
                            <td class="fw-semibold cart-text-dark">
                                {{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} ₽
                            </td>

                            {{-- КНОПКИ + И - --}}
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-2">
                                    {{-- МИНУС --}}
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                        <button type="submit"
                                                class="btn btn-sm cart-btn-black"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <strong>−</strong>
                                        </button>
                                    </form>

                                    {{-- ТЕКУЩЕЕ ЗНАЧЕНИЕ --}}
                                    <span class="cart-quantity-badge">
                                        {{ $item->quantity }}
                                    </span>

                                    {{-- ПЛЮС --}}
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit"
                                                class="btn btn-sm cart-btn-black"
                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                            <strong>+</strong>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            {{-- УДАЛИТЬ --}}
                            <td>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm cart-btn-pink"
                                            onclick="return confirm('Удалить товар из корзины?')">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong class="cart-text-dark">Итого:</strong></td>
                        <td colspan="2">
                            <strong class="fs-5 cart-text-dark">
                                {{ number_format($cart->total, 0, ',', ' ') }} ₽
                            </strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            {{-- КНОПКИ ДЕЙСТВИЙ --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn cart-btn-black"
                            onclick="return confirm('Очистить корзину?')">
                        Очистить корзину
                    </button>
                </form>

            <form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        Оформить заказ
    </button>
</form>
            </div>
        @else
            {{-- ПУСТАЯ КОРЗИНА --}}
            <div class="text-center py-5">
                <h3 class="mb-3 cart-empty-title">Корзина пуста</h3>
                <p class="mb-4 cart-empty-text">Добавьте товары в корзину, чтобы оформить заказ</p>
                <a href="{{ route('landing.catalog') }}" class="btn btn-lg cart-btn-pink">
                    Перейти в каталог
                </a>
            </div>
        @endif
    </div>
@endsection
