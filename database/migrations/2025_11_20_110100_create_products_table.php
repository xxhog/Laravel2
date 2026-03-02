<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Создание таблицы товаров (аптека).
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');            // Название (напр. "Анальгин")
            $table->string('category')->index(); // Категория (Обезболивающие, Витамины)
            $table->decimal('price', 10, 2);    // Цена (напр. 150.50)
            $table->text('description')->nullable(); // Инструкция/описание
            $table->string('specs')->nullable();     // Дозировка (напр. "500 мг, 20 шт")
            $table->integer('stock')->default(0);    // Остаток на складе
            $table->string('image_path')->nullable(); // Путь к фото
            $table->boolean('is_prescription')->default(false); // Нужно ли наличие рецепта
            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};