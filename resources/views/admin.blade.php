@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2">Управление системой</span>
            <h1 class="fw-bold text-dark mb-0">Панель администратора</h1>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex bg-white p-2 rounded-pill shadow-sm border">
                <div class="px-3 border-end">
                    <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: 800; text-uppercase;">Заказов</small>
                    <span class="fw-bold text-primary">{{ $orders->count() }}</span>
                </div>
                <div class="px-3">
                    <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: 800; text-uppercase;">Товаров</small>
                    <span class="fw-bold text-primary">{{ $products->count() }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-cart-check me-2 text-primary"></i>Заказы клиентов</h4>
        <div class="ms-3 flex-grow-1 border-bottom opacity-10"></div>
    </div>

    <div class="card border-0 shadow-sm rounded-custom overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <th class="ps-4 py-3 text-uppercase fw-bold border-0">Дата и время</th>
                        <th class="py-3 text-uppercase fw-bold border-0">Заказчик</th>
                        <th class="py-3 text-uppercase fw-bold border-0">Статус заказа</th>
                        <th class="pe-4 py-3 text-uppercase fw-bold border-0 text-end">Изменить статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $order->created_at->format('d.m.Y') }}</div>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </td>
                        <td class="fw-semibold">{{ $order->user->name ?? 'Гость' }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'new' => 'bg-primary',
                                    'confirmed' => 'bg-success',
                                    'cancelled' => 'bg-danger'
                                ][$order->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} bg-opacity-10 text-{{ str_replace('bg-', '', $statusClass) }} px-3 py-2 rounded-pill fw-bold" style="font-size: 0.7rem;">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" class="d-inline-block">
                                @csrf
                                <select name="status" class="form-select form-select-sm rounded-pill border-light shadow-sm" onchange="this.form.submit()" style="min-width: 140px;">
                                    <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новый</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Подтвержден</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center flex-grow-1">
            <h4 class="fw-bold text-dark mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Каталог товаров</h4>
            <div class="ms-3 flex-grow-1 border-bottom opacity-10"></div>
        </div>
        <button class="btn btn-primary rounded-pill px-4 ms-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-lg me-2"></i>Добавить товар
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-custom overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <th class="ps-4 py-3 text-uppercase fw-bold border-0">Препарат</th>
                        <th class="py-3 text-uppercase fw-bold border-0">Категория</th>
                        <th class="py-3 text-uppercase fw-bold border-0">Цена</th>
                        <th class="pe-4 py-3 text-uppercase fw-bold border-0 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="product-row">
                        <td>
                            <img src="{{ $product->image_path ? asset(str_replace(['public/', 'public\\'], '', $product->image_path)) : asset('images/no_image.jpg') }}" 
                                class="rounded-2 border" 
                                style="width: 40px; height: 40px; object-fit: cover;"
                                onerror="this.src='{{ asset('images/no_image.jpg') }}'">
                            </td>
                        <td><span class="badge bg-light text-muted border px-2 py-1 rounded">{{ $product->category }}</span></td>
                        <td><span class="fw-bold text-primary">{{ number_format($product->price, 0, ',', ' ') }} ₽</span></td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-sm btn-outline-primary rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $product->id }}" title="Редактировать">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Удалить этот препарат из базы?')" title="Удалить">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($products as $product)
<div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 rounded-custom shadow">
            @csrf @method('PUT')
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold">Редактировать товар</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Название препарата</label>
                    <input type="text" name="title" value="{{ $product->title }}" class="form-control rounded-3" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Цена (₽)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Склад (шт)</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="form-control rounded-3" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Категория</label>
                    <select name="category" class="form-select rounded-3">
                        <option value="Обезболивающие" {{ $product->category == 'Обезболивающие' ? 'selected' : '' }}>Обезболивающие</option>
                        <option value="Витамины" {{ $product->category == 'Витамины' ? 'selected' : '' }}>Витамины</option>
                        <option value="Антибиотики" {{ $product->category == 'Антибиотики' ? 'selected' : '' }}>Антибиотики</option>
                        <option value="Простуда" {{ $product->category == 'Простуда' ? 'selected' : '' }}>Простуда</option>
                    </select>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-bold text-muted text-uppercase">Новое изображение</label>
                    <input type="file" name="image" class="form-control rounded-3">
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 p-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endforeach
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 rounded-custom shadow">
            @csrf
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-primary">Добавить новый препарат</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Название</label>
                    <input type="text" name="title" class="form-control rounded-3" placeholder="Введите название..." required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Цена</label>
                        <input type="number" name="price" class="form-control rounded-3" placeholder="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Склад</label>
                        <input type="number" name="stock" class="form-control rounded-3" placeholder="0" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Категория</label>
                    <select name="category" class="form-select rounded-3">
                        <option value="Обезболивающие">Обезболивающие</option>
                        <option value="Витамины">Витамины</option>
                        <option value="Антибиотики">Антибиотики</option>
                        <option value="Простуда">Простуда</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Описание</label>
                    <textarea name="description" class="form-control rounded-3" rows="3"></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-bold text-muted text-uppercase">Фотография</label>
                    <input type="file" name="image" class="form-control rounded-3" required>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 p-4">
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-bold">Добавить в каталог</button>
            </div>
        </form>
    </div>
</div>

<style>
    .rounded-custom { border-radius: 20px !important; }
    
    .table thead th {
        background-color: #f8faff;
        color: #7c8db5;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        padding: 15px 10px;
    }

    .product-row { transition: all 0.2s; }
    .product-row:hover { background-color: #f0f7ff !important; }

    .form-control, .form-select {
        border: 1px solid #edf2f7;
        padding: 0.6rem 1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
    }

    .btn-outline-primary:hover, .btn-outline-danger:hover { color: white; }
</style>
@endsection