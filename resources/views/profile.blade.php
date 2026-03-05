@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="container my-4 profile-container">
        {{-- ЗАГОЛОВОК --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="profile-title mb-1">Личный кабинет</h1>
            </div>
        </div>

        {{-- ПРОФИЛЬ --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="profile-card card h-100">
                    <div class="profile-card-header">Профиль</div>
                    <div class="profile-card-body">
                        <div class="profile-card-label">Имя</div>
                        <div class="profile-card-value">{{ $user->name }}</div>

                        <div class="profile-card-label">Email</div>
                        <div class="profile-card-value">{{ $user->email }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- АКТИВНЫЕ ЗАКАЗЫ --}}
        <section class="mb-5">
            <h3 class="profile-section-title mb-3">Активные заказы</h3>
            <div class="row g-3">
                @forelse($activeOrders as $order)
                    <div class="col-md-6">
                        <div class="profile-order-card p-3 border rounded shadow-sm">
                            <div class="profile-order-header d-flex justify-content-between align-items-center mb-2">
                                <span class="profile-order-number fw-bold">Заказ №{{ $order->id }}</span>
                                <span class="badge bg-warning text-dark">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="profile-order-body">
                                <div class="profile-order-info">
                                    <strong>Сумма:</strong> 
                                    {{-- ИСПРАВЛЕНО: берем напрямую из $order->total_price --}}
                                    {{ number_format($order->total_price, 2, ',', ' ') }} ₽
                                </div>
                                <div class="profile-order-info">
                                    <strong>Товары:</strong>
                                    {{-- ИСПРАВЛЕНО: считаем через связь items --}}
                                    {{ $order->items->sum('quantity') }} поз.
                                </div>
                                <div class="profile-order-info mb-3">
                                    <strong>Обновлён:</strong>
                                    {{ $order->updated_at->format('d.m.Y H:i') }}
                                </div>
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">
                                    Детали заказа →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Нет активных заказов.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ИСТОРИЯ ЗАКАЗОВ --}}
        <section class="mb-5">
            <h3 class="profile-section-title mb-3">История заказов</h3>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Номер</th>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                            {{-- ИСПРАВЛЕНО: total_price --}}
                            <td>{{ number_format($order->total_price, 2, ',', ' ') }} ₽</td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                                    Детали
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">История пуста.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection