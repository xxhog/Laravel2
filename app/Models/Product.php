<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Поля, разрешенные для массового заполнения.
     * Добавлены 'category' для фильтрации и 'is_prescription' для аптечной специфики.
     */
    protected $fillable = [
        'title',           // Название (напр., Нурофен)
        'category',        // Категория (напр., Обезболивающие)
        'price',           // Цена
        'description',     // Полное описание/инструкция
        'specs',           // Дозировка и форма выпуска (напр., 200 мг, таблетки)
        'stock',           // Остаток на складе
        'image_path',      // Путь к изображению упаковки
    ];

    /**
     * Приведение типов.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_prescription' => 'boolean', // Автоматически преобразует 0/1 из БД в true/false
        'stock' => 'integer',
    ];

    /**
     * Связь с элементами корзины.
     * Позволяет узнать, в каких корзинах лежит этот товар.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Вспомогательный метод (Scope) для фильтрации только тех товаров, что есть в наличии.
     * Использование в контроллере: Product::available()->get();
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
}
