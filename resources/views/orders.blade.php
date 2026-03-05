@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Мои заказы</h2>

    @if($orders->isEmpty())
        <div class="alert alert-light border text-center">
            <p>У вас еще нет совершенных заказов.</p>
            <a href="{{ route('landing.catalog') }}" class="btn btn-primary">Перейти в каталог</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <strong>Заказ №{{ $order->id }}</strong>
                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                        {{ $order->status == 'pending' ? 'В обработке' : 'Выполнен' }}
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="text-muted small">
                                <th>Товар</th>
                                <th>Кол-во</th>
                                <th>Цена</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->quantity }} шт.</td>
                                    <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <span>Дата: {{ $order->created_at->format('d.m.Y H:i') }}</span>
                    <strong>Итого: {{ number_format($order->total_price, 0, ',', ' ') }} ₽</strong>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection