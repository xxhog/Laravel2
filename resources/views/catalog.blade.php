@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="catalog-title mb-4">Аптечный каталог</h1>

{{-- Форма поиска и фильтрации --}}
        <div class="row mb-5 justify-content-center">
            <div class="col-md-6">
                {{-- Исправлено имя маршрута на landing.catalog --}}
                <form action="{{ route('landing.catalog') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Поиск лекарств..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Найти</button>
                    {{-- Полезная кнопка сброса --}}
                    @if(request('search'))
                        <a href="{{ route('landing.catalog') }}" class="btn btn-outline-secondary">Сбросить</a>
                    @endif
                </form>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="catalog-card card h-100 shadow-sm">
                        {{-- Ссылка на товар и изображение --}}
                        <a href="{{ route('landing.product', $product) }}" class="d-block text-decoration-none">
                            <img src="{{ asset('images/landing/' . ($product->image_path ?? 'default_medicine.png')) }}"
                                 class="catalog-card-image card-img-top p-3"
                                 alt="{{ $product->title }}">
                        </a>

                        <div class="card-body d-flex flex-column">
                            <a href="{{ route('landing.product', $product) }}" class="text-decoration-none text-dark">
                                <h5 class="catalog-card-title mb-1">{{ $product->title }}</h5>
                                {{-- Добавляем отображение дозировки из поля specs --}}
                                <small class="text-muted d-block mb-2">{{ $product->specs }}</small>
                            </a>

                            {{-- Ограничение описания --}}
                            <p class="catalog-card-description flex-grow-1 text-secondary" style="font-size: 0.9rem;">
                                {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                            </p>

                            {{-- Метка "По рецепту" --}}
                            @if($product->is_prescription)
                                <div class="mb-2">
                                    <span class="badge bg-danger">Нужен рецепт</span>
                                </div>
                            @endif

                            <p class="catalog-card-price fw-bold fs-5 mb-3">
                                {{ number_format($product->price, 0, ',', ' ') }} ₽
                            </p>

                            {{-- Кнопка покупки --}}
                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button class="catalog-btn-outline btn w-100"
                                        {{ $product->stock === 0 ? 'disabled' : '' }}>
                                        {{ $product->stock === 0 ? 'Нет в наличии' : 'В корзину' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
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