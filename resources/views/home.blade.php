@extends('layouts.app')
@section('content')

    <section class="hero-floral py-5">
        <div class="container py-5">
            <div class="text-center max-w-600 mx-auto">
                <h1 class="hero-title mb-4">
                    Маленькие радости <br> в каждом лепестке
                </h1>

                <p class="text-secondary mb-5">
                    Создаем букеты, которые рассказывают вашу историю.
                    От нежных тюльпанов до роскошных роз — найдется цветок для каждого настроения.
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="/catalog" class="btn btn-outline-dark">
                        Заказать сюрприз
                    </a>
                    <a href="/contact" class="btn btn-dark">
                        О нас
                    </a>

                </div>

                <div class="mt-5 pt-4">
                    <div class="d-flex justify-content-center gap-4 text-muted">
                        <div class="text-center">
                            <div class="fs-2">🌷</div>
                            <small>Свежие цветы</small>
                        </div>
                        <div class="text-center">
                            <div class="fs-2">🚚</div>
                            <small>Быстрая доставка</small>
                        </div>
                        <div class="text-center">
                            <div class="fs-2">💝</div>
                            <small>Индивидуальный подход</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <h1 class="text-center my-4">Новинки компании</h1>
    <div id="landingCarousel" class="carousel slide">
        <div class="carousel-inner">
            @foreach($products as $product)
                @if($loop->index==0)
                    <div class="carousel-item active">

                        <img src="{{ asset("images/landing/".$product->image_path)}}" class="card-img-top"
                             alt="{{ $product->title }}" style="width: 90%; height: 300px">
                    </div>
                @else
                    <div class="carousel-item ">

                        <img src="{{ asset("images/landing/".$product->image_path)}}" class="card-img-top"
                             alt="{{ $product->title }}" style="width: 90%; height: 300px">
                    </div>
                @endif

            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endsection

