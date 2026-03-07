@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            {{-- Заголовок в стиле нового Layout --}}
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">На связи 24/7</span>
                <h1 class="display-5 fw-bold text-dark">Контактная информация</h1>
                <p class="text-muted mx-auto" style="max-width: 500px;">Мы всегда готовы помочь вам и вашим близким. Выберите удобный способ связи или посетите нас лично.</p>
            </div>

            <div class="row g-4">
                {{-- Левая колонка: Карточка контактов --}}
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-custom">
                        <div class="card-body">
                            <h4 class="fw-bold mb-4 text-dark">Аптека "Здоровье"</h4>
                            
                            {{-- Адрес --}}
                            <div class="d-flex align-items-center mb-4 contact-item">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle me-3">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small fw-bold text-uppercase" style="font-size: 0.65rem;">Наш адрес</p>
                                    <span class="fw-bold text-dark">г. Казань, ул. Тукая, д. 11</span>
                                </div>
                            </div>

                            {{-- Телефон --}}
                            <div class="d-flex align-items-center mb-4 contact-item">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle me-3">
                                    <i class="bi bi-telephone-fill fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small fw-bold text-uppercase" style="font-size: 0.65rem;">Горячая линия</p>
                                    <span class="fw-bold text-dark">+7 (912) 565-45-52</span>
                                </div>
                            </div>

                            {{-- Почта --}}
                            <div class="d-flex align-items-center mb-4 contact-item">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle me-3">
                                    <i class="bi bi-envelope-fill fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small fw-bold text-uppercase" style="font-size: 0.65rem;">Электронная почта</p>
                                    <span class="fw-bold text-dark">info@aptekazdrav.ru</span>
                                </div>
                            </div>

                            <hr class="my-4 opacity-10">

                            <h6 class="fw-bold mb-3 text-dark text-uppercase small" style="letter-spacing: 1px;">Режим работы</h6>
                            <div class="bg-light rounded-4 p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Пн — Пт</span>
                                    <span class="fw-bold small">08:00 — 22:00</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">Сб — Вс</span>
                                    <span class="fw-bold text-primary small">Круглосуточно</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Правая колонка: Карта --}}
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm overflow-hidden h-100 rounded-custom" style="min-height: 400px;">
                        {{-- Замените URL на реальный Embed от Яндекс или Google Карт --}}
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2243.61523456789!2d49.11!3d55.78!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTXCsDQ2JzQ4LjAiTiA0OcKwMDYnMzYuMCJF!5e0!3m2!1sru!2sru!4v1620000000000!5m2!1sru!2sru" 
                            width="100%" 
                            height="100%" 
                            style="border:0; min-height: 400px; filter: grayscale(0.2) contrast(1.1);" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>

            {{-- Дополнительный блок: Как добраться --}}
            <div class="mt-5 p-4 bg-white shadow-sm rounded-custom d-flex align-items-center border border-primary border-opacity-10">
                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle me-4 d-none d-md-flex" style="min-width: 60px; height: 60px;">
                    <i class="bi bi-info-circle-fill fs-3"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Как до нас добраться?</h5>
                    <p class="mb-0 text-muted">Мы находимся в 15 минутах ходьбы от метро "Пушкинская". Вход со стороны главного проспекта, первая дверь справа от торгового центра. Для посетителей на авто есть бесплатная парковка.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Единый стандарт закруглений */
    .rounded-custom { border-radius: 20px !important; }
    
    /* Контейнеры для иконок */
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .contact-item:hover .icon-box {
        background-color: #0d6efd !important;
        color: white !important;
        transform: scale(1.1);
    }

    /* Карта */
    iframe {
        display: block;
    }

    /* Плавное появление карточек */
    .card {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(13, 110, 253, 0.08) !important;
    }
</style>
@endsection