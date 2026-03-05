@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1>Аптечный каталог</h1>
        <p class="text-muted">Найдено товаров: {{ $products->count() }}</p>
    </div>
    {{-- Вывод категорий (теперь они приходят из контроллера) --}}
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        <a href="{{ route('landing.catalog') }}" class="btn btn-sm btn-outline-primary rounded-pill">Все</a>
        @foreach($categories as $category)
            <a href="{{ route('landing.catalog', ['category' => $category]) }}" 
               class="btn btn-sm {{ request('category') == $category ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                {{ $category }}
            </a>
        @endforeach 
    </div>

    <div class="row gy-4">
        @forelse($products as $product)
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('storage/images/no_image.jpg') }}" 
                        class="card-img-top" 
                        style="height: 180px; object-fit: contain;" 
                        alt="{{ $product->title }}">
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title fs-6">{{ $product->title }}</h5>
                        <p class="text-primary fw-bold mt-auto">{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary w-100">В корзину</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h3>Товары не найдены</h3>
                <a href="{{ route('landing.catalog') }}" class="btn btn-link">Сбросить фильтры</a>
            </div>
        @endforelse
    </div>
</div>
@endsection