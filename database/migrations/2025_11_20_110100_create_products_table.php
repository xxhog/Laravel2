<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    //таблица товаров 

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->index();
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('specs')->nullable();
            $table->integer('stock')->default(0);
            $table->string('image_path')->nullable();
            $table->boolean('is_prescription')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};