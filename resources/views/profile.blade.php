@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-5 align-items-end">
        <div class="col-md-8">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2">Профиль клиента</span>
            <h1 class="fw-bold text-dark mb-1">Личный кабинет</h1>
            <p class="text-muted mb-0">Здравствуйте, <span class="text-primary fw-bold">{{ $user->name }}</span>! Рады видеть вас снова.</p>
        </div>
        <div class="col-md-4 text-md-end d-none d-md-block">
            <div class="bg-white p-2 px-3 rounded-pill shadow-sm border d-inline-flex align-items-center">
                <div class="bg-success rounded-circle me-2" style="width: 10px; height: 10px;"></div>
                <span class="small fw-bold text-muted">Аккаунт подтвержден</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-custom overflow-hidden mb-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">{{ $user->name }}</h5>
                        <p class="text-muted small">ID клиента: #00{{ $user->id }}</p>
                    </div>
                    
                    <hr class="opacity-10">

                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase mb-1" style="font-size: 0.65rem;">Электронная почта</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope text-primary me-2"></i>
                            <span class="text-dark">{{ $user->email }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <label class="small text-muted fw-bold text-uppercase mb-1" style="font-size: 0.65rem;">Дата регистрации</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event text-primary me-2"></i>
                            <span class="text-dark">{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

               <div class="bg-primary bg-opacity-10 rounded-custom p-4 border border-primary border-opacity-10">
                <h6 class="fw-bold text-primary mb-2"><i class="bi bi-info-circle me-2"></i>Помощь</h6>
                <p class="small text-muted mb-0">Если у вас возникли вопросы по заказам, свяжитесь с нашей поддержкой.</p>
            </div>
        </div>

        <div class="col-lg-8">
            
            <div class="d-flex align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Текущие заказы</h4>
                <div class="ms-3 flex-grow-1 border-bottom opacity-10"></div>
            </div>
                
            <div class="row g-3 mb-5">
                @forelse($activeOrders as $order)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-custom profile-order-card">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Заказ</div>
                                        <h5 class="fw-bold mb-0">№{{ $order->id }}</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Статус</div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-bold" style="font-size: 0.7rem;">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Сумма</div>
                                        <div class="fw-bold text-dark">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</div>
                                    </div>
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                        <a href="{{ route('orders.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                            Детали
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 bg-white shadow-sm rounded-custom">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-bag-x text-muted fs-3"></i>
                        </div>
                        <p class="text-muted mb-0">Активных заказов нет</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">История покупок</h4>
                <div class="ms-3 flex-grow-1 border-bottom opacity-10"></div>
            </div>
            
            <div class="card border-0 shadow-sm rounded-custom overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-muted" style="font-size: 0.75rem;">
                                <th class="ps-4 py-3 text-uppercase fw-bold border-0">Номер</th>
                                <th class="py-3 text-uppercase fw-bold border-0">Дата</th>
                                <th class="py-3 text-uppercase fw-bold border-0">Сумма</th>
                                <th class="py-3 text-uppercase fw-bold border-0">Статус</th>
                                <th class="pe-4 py-3 border-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                    <td class="text-muted">{{ $order->created_at->format('d.m.Y') }}</td>
                                    <td><span class="fw-bold text-dark">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</span></td>
                                    <td>
                                        <span class="text-muted small">{{ $order->status }}</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary">Посмотреть</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Список пуст</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .rounded-custom { border-radius: 20px !important; }
    
    .profile-order-card { 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        border: 1px solid transparent !important;
    }
    
    .profile-order-card:hover { 
        transform: translateX(10px); 
        box-shadow: 0 1rem 2rem rgba(13, 110, 253, 0.08) !important;
        border-color: rgba(13, 110, 253, 0.1) !important;
    }

    .table th { font-weight: 700; letter-spacing: 0.5px; }
    .table td { border-bottom: 1px solid #f8f9fa; }
</style>
@endsection