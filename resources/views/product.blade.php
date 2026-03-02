@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
    <div class="container my-5 product-container">
        <div class="row g-4">
            {{-- КОЛОНКА С ИЗОБРАЖЕНИЕМ --}}
            <div class="col-lg-6">
                <div class="product-image-card card shadow-sm">
                    <img src="{{ asset("images/landing/".$product->image_path) }}"
                         class="product-image card-img-top"
                         alt="{{ $product->title }}">
                </div>
            </div>

            {{-- КОЛОНКА С ИНФОРМАЦИЕЙ --}}
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="product-title h3">{{ $product->title }}</h1>
                        <p class="product-id mb-2">
                            ID: CS-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                    <a href="{{ route('landing.catalog') }}"
                       class="product-back-btn btn btn-outline-secondary btn-sm">
                        ← Назад в каталог
                    </a>
                </div>

                {{-- ЦЕНА И НАЛИЧИЕ --}}
                <div class="mb-4">
                    <span class="product-price">
                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                    </span>
                    <p class="product-stock text-muted mb-0">
                        В наличии: {{ $product->stock }} шт.
                    </p>
                </div>

                {{-- ОПИСАНИЕ --}}
                <p class="product-description lead">{{ $product->description }}</p>

                {{-- ХАРАКТЕРИСТИКИ --}}
                @if($product->specs)
                    <ul class="product-specs list-group list-group-flush mb-4">
                        @foreach (preg_split('/\r\n|\r|\n/', $product->specs) as $feature)
                            @if(strlen($feature) > 0)
                                <li class="list-group-item">{{ $feature }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                {{-- КНОПКИ ДЕЙСТВИЙ --}}
                <div class="d-flex gap-2">
                    @auth
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="product-add-btn btn btn-lg"
                                {{ $product->stock === 0 ? 'disabled' : '' }}>
                                {{ $product->stock === 0 ? 'Нет в наличии' : 'Добавить в корзину' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="product-guest-btn btn btn-lg">
                            Войдите, чтобы купить
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
