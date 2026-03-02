<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'title' => 'Нурофен',
            'category' => 'Обезболивающие',
            'price' => 450.00,
            'description' => 'Оказывает обезболивающее и противовоспалительное действие.',
            'specs' => '200 мг, 10 таблеток',
            'stock' => 100,
            'is_prescription' => false,
        ]);

        Product::create([
            'title' => 'Амоксиклав',
            'category' => 'Антибиотики',
            'price' => 720.50,
            'description' => 'Антибиотик широкого спектра действия.',
            'specs' => '500 мг + 125 мг, 15 шт',
            'stock' => 15,
            'is_prescription' => true,
        ]);

        Product::create([
            'title' => 'Витамин C',
            'category' => 'Витамины',
            'price' => 120.00,
            'description' => 'Для укрепления иммунитета.',
            'specs' => '1000 мг, шипучие таблетки',
            'stock' => 50,
            'is_prescription' => false,
        ]);
    }
}