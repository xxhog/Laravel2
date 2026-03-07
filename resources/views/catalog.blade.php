@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2">Наш ассортимент</span>
        <h1 class="display-5 fw-bold text-dark">Аптечный каталог</h1>
        <p class="text-muted">Найдено сертифицированных товаров: <span class="fw-bold text-dark">{{ $products->count() }}</span></p>
    </div>
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <a href="{{ route('landing.catalog') }}" 
           class="btn btn-sm {{ !request('category') ? 'btn-primary shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4">
            Все товары
        </a>
        @foreach($categories as $category)
            <a href="{{ route('landing.catalog', ['category' => $category]) }}" 
               class="btn btn-sm {{ request('category') == $category ? 'btn-primary shadow-sm' : 'btn-outline-primary' }} rounded-pill px-3">
                {{ $category }}
            </a>
        @endforeach 
    </div>

<div class="row gy-4">
    @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <a href="{{ route('landing.product', $product->id) }}" class="position-relative p-3 bg-light d-block text-center" style="border-radius: 20px 20px 0 0;">
                    @php
                        $cleanPath = str_replace(['public/', 'public\\'], '', $product->image_path);
                    @endphp

                    <img src="{{ $product->image_path ? asset($cleanPath) : asset('images/no_image.jpg') }}" 
                         class="card-img-top img-fluid transition-zoom" 
                         style="height: 160px; object-fit: contain;" 
                         alt="{{ $product->title }}"
                         onerror="this.src='{{ asset('images/no_image.jpg') }}'">

                    @if($product->stock < 5 && $product->stock > 0)
                        <span class="badge bg-warning position-absolute top-0 start-0 m-3 shadow-sm" style="font-size: 0.7rem; z-index: 3;">Заканчивается</span>
                    @endif
                </a>

                <div class="card-body d-flex flex-column p-3 pt-0 text-center">
                    <div class="text-muted small mb-1">{{ $product->category }}</div>
                    <h5 class="card-title fs-6 fw-bold text-dark mb-2" style="height: 2.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        <a href="{{ route('landing.product', $product->id) }}" class="text-decoration-none text-dark hover-primary">
                            {{ $product->title }}
                        </a>
                    </h5>
                    
                    <div class="mt-auto">
                        <p class="text-primary fs-5 fw-bold mb-3">
                            {{ number_format($product->price, 0, '.', ' ') }} ₽
                        </p>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary w-100 rounded-pill d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm">
                                <i class="bi bi-cart-plus fs-5"></i>
                                <span>В корзину</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
</div>
</div>

<style>
    .transition-zoom {
        transition: transform 0.5s ease;
    }

    .product-card:hover .transition-zoom {
        transform: scale(1.1);
    }

    .position-relative.p-3 {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-card {
        border-radius: 20px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px); 
        shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; 
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.1);
    }

    .product-card .btn-primary {
        transition: all 0.3s ease;
    }

    .product-card:hover .btn-primary {
        background-color: #0b5ed7;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
    .card-title {
        line-height: 1.2;
    }

    @media (max-width: 576px) {
        .container { padding-left: 10px; padding-right: 10px; }
        .row { --bs-gutter-x: 10px; }
    }
</style>
@endsection