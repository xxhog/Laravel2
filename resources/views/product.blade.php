@extends('layouts.app')

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('landing.home') }}" class="text-decoration-none">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('landing.catalog') }}" class="text-decoration-none">Каталог</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="product-image-wrapper p-4 border rounded-4 bg-white shadow-sm d-flex align-items-center justify-content-center" style="min-height: 450px;">
                @php
                    $cleanPath = str_replace(['public/', 'public\\'], '', $product->image_path);
                @endphp

                <img src="{{ $product->image_path ? asset($cleanPath) : asset('images/no_image.jpg') }}" 
                     class="img-fluid transition-zoom" 
                     alt="{{ $product->title }}" 
                     style="max-height: 400px; object-fit: contain;"
                     onerror="this.src='{{ asset('images/no_image.jpg') }}'">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ps-lg-3">
                @if($product->is_prescription)
                    <span class="badge bg-danger rounded-pill px-3 py-2 mb-3 shadow-sm">Нужен рецепт</span>
                @endif
                
                <h1 class="display-6 fw-bold mb-2">{{ $product->title }}</h1>
                <p class="text-muted mb-4 small">Артикул: CS-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>

                  <div class="p-4 bg-light rounded-4 mb-4 border border-white shadow-sm">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="h1 fw-bold text-primary mb-0">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        @if($product->stock > 0)
                            <span class="badge bg-success-subtle text-success border border-success-subtle">В наличии</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Нет в наличии</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-0">Остаток на складе: {{ $product->stock }} шт.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Описание товара</h5>
                    <p class="text-secondary lh-lg" style="text-align: justify;">{{ $product->description }}</p>
                </div>
                @if($product->specs)
                    <div class="mb-5">
                        <h5 class="fw-bold mb-3">Характеристики</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                @foreach (preg_split('/\r\n|\r|\n/', $product->specs) as $feature)
                                    @if(strlen(trim($feature)) > 0)
                                        <tr>
                                            <td class="ps-0 py-2 text-muted border-bottom w-50 small">{{ $feature }}</td>
                                            <td class="pe-0 py-2 border-bottom text-end fw-medium small">Есть</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
                <div class="d-grid gap-3">
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100 py-3 fw-bold shadow-sm">
                                    <i class="bi bi-cart-plus me-2 fs-5"></i>Добавить в корзину
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg rounded-pill w-100 py-3 disabled opacity-50">
                                <i class="bi bi-x-circle me-2"></i>Нет в наличии
                            </button>
                        @endif
                    @else
                        <div class="alert alert-info border-0 rounded-4 py-3 shadow-sm d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-3 fs-4 text-primary"></i>
                            <div>
                                <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Войдите</a>, чтобы добавить этот товар в корзину
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg rounded-pill w-100 py-3 fw-bold mt-2">
                            Авторизоваться
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-image-wrapper {
        transition: transform 0.3s ease;
    }
    .product-image-wrapper:hover .transition-zoom {
        transform: scale(1.05);
    }
    .transition-zoom {
        transition: transform 0.4s ease;
    }
    .breadcrumb-item a {
        color: #6c757d;
        transition: color 0.2s;
    }
    .breadcrumb-item a:hover {
        color: #0d6efd;
    }
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3) !important;
    }
</style>
@endsection