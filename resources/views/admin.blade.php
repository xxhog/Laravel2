@extends('layouts.app')

@section('content')
    <div class="container my-4 admin-container">
        <h1 class="admin-title">Панель администратора</h1>

        {{-- ФИЛЬТР ЗАКАЗОВ --}}
        <div class="admin-filter-group">
            <h4 class="mb-3">Фильтр заказов</h4>
            <div class="btn-group" role="group">
                <button type="button" class="admin-filter-btn btn active" data-filter="all">Все</button>
                <button type="button" class="admin-filter-btn btn" data-filter="new">Новые</button>
                <button type="button" class="admin-filter-btn btn" data-filter="confirmed">Подтвержденные</button>
                <button type="button" class="admin-filter-btn btn" data-filter="cancelled">Отмененные</button>
            </div>
        </div>

        {{-- ТАБЛИЦА ЗАКАЗОВ --}}
        <div class="table-responsive mb-4">
            <table class="admin-table table table-bordered" id="ordersTable">
                <thead>
                <tr>
                    <th>Таймстамп</th>
                    <th>ФИО заказчика</th>
                    <th>Количество товаров</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr data-status="{{ $order->status }}">
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->user->name ?? 'Неизвестно' }}</td>
                        <td>{{ $order->cart->items->sum('quantity') ?? 0 }}</td>
                        <td>
                            <span class="admin-status
                                @if($order->status == 'new') admin-status-new
                                @elseif($order->status == 'confirmed') admin-status-confirmed
                                @else admin-status-cancelled
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" style="display: inline-block;">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новый</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Подтвержден</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Заказов нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- УПРАВЛЕНИЕ ТОВАРАМИ --}}
        <h2 class="admin-section-title">Управление товарами</h2>

        <button class="admin-btn-pink btn mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            ➕ Добавить товар
        </button>

        <table class="admin-table table table-bordered" id="productsTable">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>В наличии</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ number_format($product->price, 0, ',', ' ') }} ₽</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        {{-- КНОПКА РЕДАКТИРОВАНИЯ --}}
                        <button class="admin-btn-pink btn btn-sm me-2 edit-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editProductModal"
                                data-id="{{ $product->id }}"
                                data-title="{{ $product->title }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}"
                                data-description="{{ $product->description }}"
                                data-specs="{{ $product->specs }}"
                                data-image="{{ $product->image_path }}">
                            Редактировать
                        </button>

                        {{-- ФОРМА УДАЛЕНИЯ --}}
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn-black btn btn-sm" onclick="return confirm('Удалить товар?')">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Товаров нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- МОДАЛКА ДОБАВЛЕНИЯ --}}
        <div class="modal fade admin-modal" id="addProductModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">➕ Добавить товар</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.products.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="admin-label">Название</label>
                                <input type="text" name="title" class="admin-input form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="admin-label">Цена</label>
                                <input type="number" name="price" class="admin-input form-control" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label class="admin-label">В наличии</label>
                                <input type="number" name="stock" class="admin-input form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="admin-label">Описание</label>
                                <textarea name="description" class="admin-input form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="admin-label">Характеристики</label>
                                <textarea name="specs" class="admin-input form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="admin-label">Изображение</label>
                                <input type="text" name="image_path" class="admin-input form-control" value="default.jpg">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="admin-btn-outline-black btn" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="admin-btn-pink btn">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- МОДАЛКА РЕДАКТИРОВАНИЯ --}}
        <div class="modal fade admin-modal" id="editProductModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">✏️ Редактировать товар</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="editProductForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" id="edit_product_id">

                            <div class="mb-3">
                                <label class="admin-label">Название</label>
                                <input type="text" name="title" id="edit_title" class="admin-input form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="admin-label">Цена</label>
                                <input type="number" name="price" id="edit_price" class="admin-input form-control" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label class="admin-label">В наличии</label>
                                <input type="number" name="stock" id="edit_stock" class="admin-input form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="admin-label">Описание</label>
                                <textarea name="description" id="edit_description" class="admin-input form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="admin-label">Характеристики</label>
                                <textarea name="specs" id="edit_specs" class="admin-input form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="admin-label">Изображение</label>
                                <input type="text" name="image_path" id="edit_image" class="admin-input form-control">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="admin-btn-outline-black btn" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="admin-btn-pink btn">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // РЕДАКТИРОВАНИЕ ТОВАРА (ПРОСТОЙ JS)
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                document.getElementById('editProductForm').action = `/admin/products/${id}`;
                document.getElementById('edit_product_id').value = id;
                document.getElementById('edit_title').value = this.dataset.title;
                document.getElementById('edit_price').value = this.dataset.price;
                document.getElementById('edit_stock').value = this.dataset.stock;
                document.getElementById('edit_description').value = this.dataset.description || '';
                document.getElementById('edit_specs').value = this.dataset.specs || '';
                document.getElementById('edit_image').value = this.dataset.image || 'default.jpg';
            });
        });

        // ФИЛЬТР ЗАКАЗОВ
        document.querySelectorAll('.admin-filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.admin-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                document.querySelectorAll('#ordersTable tbody tr').forEach(row => {
                    row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
                });
            });
        });
    </script>
@endpush
