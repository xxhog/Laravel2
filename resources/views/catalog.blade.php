@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="catalog-title">Каталог товаров</h1>

        <div class="row gy-4">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="catalog-card card h-100">
                        <a href="{{ route('landing.product', $product) }}" class="d-block text-decoration-none">
                            <img src="{{ asset('images/landing/' . $product->image_path) }}"
                                 class="catalog-card-image card-img-top"
                                 alt="{{ $product->title }}">
                        </a>

                        <div class="card-body d-flex flex-column">
                            <a href="{{ route('landing.product', $product) }}"
                               class="text-decoration-none">
                                <h5 class="catalog-card-title">{{ $product->title }}</h5>
                            </a>

                            <p class="catalog-card-description flex-grow-1">
                                {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                            </p>

                            <p class="catalog-card-price">
                                {{ number_format($product->price, 0, ',', ' ') }} ₽
                            </p>

                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button class="catalog-btn-outline btn"
                                        {{ $product->stock === 0 ? 'disabled' : '' }}>
                                        {{ $product->stock === 0 ? 'Нет в наличии' : 'В корзину' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="catalog-btn-pink btn">
                                    Войдите, чтобы купить
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
