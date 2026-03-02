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

        {{-- ПРОФИЛЬ И СТАТИСТИКА --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="profile-card card h-100">
                    <div class="profile-card-header">
                        Профиль
                    </div>
                    <div class="profile-card-body">
                        <div class="profile-card-label">Имя</div>
                        <div class="profile-card-value">{{ $user->name }}</div>

                        <div class="profile-card-label">Логин</div>
                        <div class="profile-card-value">{{ $user->login }}</div>

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
                        <div class="profile-order-card">
                            <div class="profile-order-header d-flex justify-content-between align-items-center">
                                <span class="profile-order-number">Заказ №{{ $order->id }}</span>
                                <span class="profile-order-badge profile-order-badge-pending">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="profile-order-body">
                                <div class="profile-order-info">
                                    <strong>Сумма:</strong>
                                    {{ number_format($order->cart->total_amount, 2, ',', ' ') }} ₽
                                </div>
                                <div class="profile-order-info">
                                    <strong>Товары:</strong>
                                    {{ $order->cart->items->sum('quantity') }} поз.
                                </div>
                                <div class="profile-order-info mb-3">
                                    <strong>Обновлён:</strong>
                                    {{ $order->updated_at->format('d.m.Y H:i') }}
                                </div>
                                <a href="{{ route('landing.orders') }}" class="profile-btn-outline">
                                    Детали заказа →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="profile-empty">Нет активных заказов.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ИСТОРИЯ ЗАКАЗОВ --}}
        <section class="mb-5">
            <h3 class="profile-section-title mb-3">История заказов</h3>

            <div class="table-responsive">
                <table class="profile-table table align-middle">
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
                            <td>{{ number_format($order->cart->total_amount, 2, ',', ' ') }} ₽</td>
                            <td>
                                    <span class="profile-badge profile-badge-secondary text-uppercase">
                                        {{ $order->status }}
                                    </span>
                            </td>
                            <td>
                                <a href="{{ route('landing.orders') }}" class="profile-btn-outline btn-sm">
                                    Детали
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center profile-empty">
                                История пуста.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
