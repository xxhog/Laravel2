<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToCartItemsTable extends Migration
{
    public function up()
    {
        // Используем table для обновления
        Schema::table('cart_items', function (Blueprint $table) {
            if (!Schema::hasColumn('cart_items', 'price')) {
                $table->decimal('price', 10, 2)->after('quantity');
            }
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}