@extends('layouts.app')

@section('content')
    <div class="py-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, #f0f7ff 0%, #e0eaff 100%); border-bottom: 1px solid #dee2e6;">
        <div class="container text-center py-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-3">Забота о вас 24/7</span>
            <h1 class="display-4 fw-bold text-dark mb-3">Ваше здоровье — <span class="text-primary">наш приоритет</span></h1>
            <p class="lead text-muted mb-4 mx-auto" style="max-width: 600px;">Широкий выбор лекарств, витаминов и сертифицированных товаров для здоровья с быстрой доставкой.</p>
            <a href="{{ route('landing.catalog') }}" class="btn btn-primary btn-lg px-5 shadow rounded-pill fw-bold py-3">
                Перейти в каталог
            </a>
        </div>
    </div>

    <div class="container">
         <div class="row text-center mb-5 g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-truck fs-2 text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Быстрая доставка</h4>
                    <p class="text-muted mb-0 small">Привезем заказ в течение 2-х часов в любую точку города.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-check fs-2 text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Качество ГАРАНТ</h4>
                    <p class="text-muted mb-0 small">Только проверенные и сертифицированные препараты.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-chat-dots fs-2 text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Консультация</h4>
                    <p class="text-muted mb-0 small">Наши фармацевты помогут с выбором в режиме онлайн.</p>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-1">Популярные товары</h2>
                <p class="text-muted mb-0 small">То, что чаще всего выбирают наши клиенты</p>
            </div>
            <a href="{{ route('landing.catalog') }}" class="btn btn-link text-decoration-none fw-bold p-0">Смотреть все →</a>
        </div>

        <div class="row gy-4 mb-5">
    @forelse ($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-absolute mt-2 ms-2" style="z-index: 2;">
                    @if($product->is_prescription)
                        <span class="badge bg-danger rounded-pill shadow-sm" style="font-size: 0.65rem;">По рецепту</span>
                    @endif
                </div>
                <a href="{{ route('landing.product', $product->id) }}" class="p-3 text-center d-block">
                    @php
                        $cleanPath = str_replace(['public/', 'public\\'], '', $product->image_path);
                    @endphp
                    
                    <img src="{{ $product->image_path ? asset($cleanPath) : asset('images/no_image.jpg') }}" 
                         class="card-img-top img-fluid transition-zoom" 
                         alt="{{ $product->title }}" 
                         style="height: 160px; object-fit: contain;"
                         onerror="this.src='{{ asset('images/no_image.jpg') }}'">
                </a>

                <div class="card-body d-flex flex-column p-3 pt-0 text-center">
                    <h5 class="card-title fs-6 fw-bold text-dark mb-1" style="height: 2.4rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        <a href="{{ route('landing.product', $product->id) }}" class="text-decoration-none text-dark hover-primary">
                            {{ $product->title }}
                        </a>
                    </h5>
                    
                    <p class="text-muted small mb-3" style="font-size: 0.75rem;">
                        {{ \Illuminate\Support\Str::limit($product->specs ?? $product->description, 25) }}
                    </p>
                    
                    <p class="text-primary fw-bold fs-5 mb-3">
                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                    </p>
                    
                    <div class="mt-auto">
                        @auth
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary w-100 rounded-pill py-2 shadow-sm border-0 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-cart-plus fs-5"></i>
                                    <span class="fw-bold">В корзину</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill py-2">Войти для покупки</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 bg-light rounded-4 border border-dashed">
            <p class="text-muted mb-0">Товары скоро появятся. Мы обновляем ассортимент!</p>
        </div>
    @endforelse
</div>
    </div>

<style>
     .rounded-4 { border-radius: 1rem !important; }

    .product-card {
        border-radius: 20px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 2rem rgba(13, 110, 253, 0.1) !important;
    }

     .btn-primary {
        background-color: #0d6efd;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3) !important;
    }

    .border-dashed { border-style: dashed !important; }
</style>
@endsection