<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    // Эти поля разрешаем записывать при оформлении заказа
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Связь: этот пункт заказа принадлежит конкретному Заказу
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Связь: этот пункт заказа ссылается на конкретный Товар
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}