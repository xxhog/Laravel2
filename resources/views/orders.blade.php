@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
            <i class="bi bi-box-seam fs-3 text-primary"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0">История ваших заказов</h2>
            <p class="text-muted mb-0">Здесь хранится информация о всех ваших покупках и рецептах</p>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <i class="bi bi-cart-x text-muted mb-3" style="font-size: 4rem;"></i>
                <h4 class="fw-bold">Пока пусто</h4>
                <p class="text-muted mb-4">Вы еще не совершали покупок в нашей аптеке.</p>
                <a href="{{ route('landing.catalog') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    Перейти к выбору препаратов
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-10 mx-auto">
                @foreach($orders as $order)
                    <div class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small text-uppercase fw-bold">Номер заказа</span>
                                <h5 class="fw-bold mb-0 text-primary">№{{ $order->id }}</h5>
                            </div>
                            <div class="text-end">
                                <span class="badge rounded-pill px-3 py-2 
                                    @if($order->status == 'new') bg-info bg-opacity-10 text-info border border-info border-opacity-25
                                    @elseif($order->status == 'confirmed') bg-success bg-opacity-10 text-success border border-success border-opacity-25
                                    @else bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 @endif">
                                    <i class="bi bi-dot fs-4 align-middle"></i>
                                    {{ $order->status == 'new' ? 'В обработке' : ($order->status == 'confirmed' ? 'Готов к выдаче' : 'Завершен') }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body px-4 py-4">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="border-bottom">
                                        <tr class="text-muted small text-uppercase">
                                            <th class="pb-3" style="width: 60%">Препарат</th>
                                            <th class="pb-3 text-center">Кол-во</th>
                                            <th class="pb-3 text-end">Цена за шт.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr class="border-bottom-dashed">
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light rounded-2 p-2 me-3 d-none d-sm-block">
                                                            <i class="bi bi-capsule text-primary"></i>
                                                        </div>
                                                        <span class="fw-semibold">{{ $item->product->title }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-center">{{ $item->quantity }} шт.</td>
                                                <td class="py-3 text-end fw-bold text-dark">{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer bg-light bg-opacity-50 border-0 px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-sm-6 text-muted small">
                                    <i class="bi bi-calendar3 me-2"></i> Оформлен: {{ $order->created_at->format('d.m.Y в H:i') }}
                                </div>
                                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                                    <span class="text-muted me-2">Итоговая сумма:</span>
                                    <span class="fs-4 fw-bold text-primary">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .border-bottom-dashed { border-bottom: 1px dashed #dee2e6; }
    .border-bottom-dashed:last-child { border-bottom: none; }
    .badge { letter-spacing: 0.3px; font-weight: 600; }
    .table > :not(caption) > * > * { background-color: transparent; }
    .card { transition: transform 0.2s ease; }
    .card:hover { transform: translateY(-3px); }
</style>
@endsection