@extends('layouts.app')

@section('content')
    {{-- 1. Герой-секция --}}
    <div class="bg-light py-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
        <div class="container text-center py-5">
            <h1 class="display-4 fw-bold text-primary">Ваше здоровье — наш приоритет</h1>
            <p class="lead mb-4">Широкий выбор лекарств, витаминов и товаров для здоровья с доставкой.</p>
            <a href="{{ route('landing.catalog') }}" class="btn btn-primary btn-lg px-5 shadow">Перейти в каталог</a>
        </div>
    </div>

    <div class="container">
        {{-- 2. Секция преимуществ --}}
        <div class="row text-center mb-5">
            <div class="col-md-4">
                <div class="p-3">
                    <i class="bi bi-truck fs-1 text-primary"></i>
                    <h4 class="mt-3">Быстрая доставка</h4>
                    <p class="text-muted">Привезем заказ в течение 2-х часов по городу.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <i class="bi bi-shield-check fs-1 text-primary"></i>
                    <h4 class="mt-3">Качество</h4>
                    <p class="text-muted">Только сертифицированные препараты.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <i class="bi bi-chat-dots fs-1 text-primary"></i>
                    <h4 class="mt-3">Консультация</h4>
                    <p class="text-muted">Поможем с выбором в режиме онлайн.</p>
                </div>
            </div>
        </div>

        {{-- 3. Блок "Популярные товары" --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Популярные товары</h2>
            <a href="{{ route('landing.catalog') }}" class="text-decoration-none text-primary fw-bold">Смотреть все →</a>
        </div>

        <div class="row gy-4 mb-5">
            @forelse ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm catalog-card" style="transition: transform 0.2s;">
                        {{-- Метка "Рецептурный", если нужно --}}
                        @if($product->is_prescription)
                            <span class="badge bg-danger position-absolute mt-2 ms-2" style="z-index: 1;">Рецепт</span>
                        @endif

                        <a href="{{ route('landing.product', $product->id) }}">
                            {{-- ИСПРАВЛЕН ПУТЬ К КАРТИНКЕ --}}
                            <img src="{{ asset('storage/' . ($product->image_path ?? 'products/no_image.jpg')) }}" 
     class="card-img-top p-3" 
     alt="{{ $product->title }}" 
     style="height: 200px; object-fit: contain;">
                        </a>
                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title fs-6 fw-bold">{{ $product->title }}</h5>
                            <p class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($product->specs, 30) }}</p>
                            <p class="text-primary fw-bold fs-5 mb-3">{{ number_format($product->price, 0, ',', ' ') }} ₽</p>
                            
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm w-100 shadow-sm">
                                        В корзину
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm mt-auto">Войти для покупки</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Товары пока не добавлены в базу данных.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection