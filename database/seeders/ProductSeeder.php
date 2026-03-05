<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Отключаем проверку ключей, чтобы разрешить очистку таблицы
        Schema::disableForeignKeyConstraints();

        // 2. Очищаем таблицу полностью
        Product::truncate();

        // 3. Включаем проверку ключей обратно
        Schema::enableForeignKeyConstraints();

        $products = [
            [
                'title' => 'Нурофен Экспресс',
                'category' => 'Обезболивающие',
                'price' => 450.00,
                'description' => 'Быстродействующее средство против головной и зубной боли.',
                'specs' => '200 мг, 10 капсул',
                'stock' => 100,
                'is_prescription' => false,
            ],
            [
                'title' => 'Амоксиклав',
                'category' => 'Антибиотики',
                'price' => 720.50,
                'description' => 'Антибактериальное средство для лечения ЛОР-заболеваний.',
                'specs' => '500мг + 125мг, 15 таблеток',
                'stock' => 15,
                'is_prescription' => true,
            ],
            [
                'title' => 'Парацетамол-УБФ',
                'category' => 'Жаропонижающие',
                'price' => 55.00,
                'description' => 'Классическое средство при простуде и гриппе.',
                'specs' => '500 мг, 20 таблеток',
                'stock' => 200,
                'is_prescription' => false,
            ],
            [
                'title' => 'Арбидол Максимум',
                'category' => 'Противовирусные',
                'price' => 580.00,
                'description' => 'Противовирусное средство, активное против гриппа А и В.',
                'specs' => '200 мг, 10 капсул',
                'stock' => 45,
                'is_prescription' => false,
            ],
            [
                'title' => 'Супрастин',
                'category' => 'От аллергии',
                'price' => 190.00,
                'description' => 'Классический антигистаминный препарат.',
                'specs' => '25 мг, 20 таблеток',
                'stock' => 60,
                'is_prescription' => false,
            ],
            [
                'title' => 'Омепразол-Акрихин',
                'category' => 'Для желудка',
                'price' => 140.00,
                'description' => 'Ингибитор протонной помпы, помогает при изжоге.',
                'specs' => '20 мг, 28 капсул',
                'stock' => 30,
                'is_prescription' => false,
            ],
            [
                'title' => 'Мезим Форте',
                'category' => 'Для желудка',
                'price' => 320.00,
                'description' => 'Ферментный препарат для улучшения пищеварения.',
                'specs' => '80 ПАНКРЕАТИНА ЕД, 20 шт',
                'stock' => 85,
                'is_prescription' => false,
            ],
            [
                'title' => 'Валерианы экстракт',
                'category' => 'Успокоительные',
                'price' => 85.00,
                'description' => 'Натуральное седативное средство.',
                'specs' => '20 мг, 50 таблеток',
                'stock' => 120,
                'is_prescription' => false,
            ],
            [
                'title' => 'Магний B6 Форте',
                'category' => 'Витамины',
                'price' => 650.00,
                'description' => 'Восполняет дефицит магния в организме.',
                'specs' => '50 таблеток в оболочке',
                'stock' => 25,
                'is_prescription' => false,
            ],
            [
                'title' => 'Цефтриаксон',
                'category' => 'Антибиотики',
                'price' => 45.00,
                'description' => 'Антибиотик III поколения для инъекций.',
                'specs' => '1.0 г, порошок для р-ра',
                'stock' => 10,
                'is_prescription' => true,
            ],
            [
                'title' => 'Терафлю',
                'category' => 'Жаропонижающие',
                'price' => 480.00,
                'description' => 'Горячее питье для снятия симптомов гриппа и простуды.',
                'specs' => 'Лимон, 10 пакетиков',
                'stock' => 40,
                'is_prescription' => false,
            ],
            [
                'title' => 'Ксарелто',
                'category' => 'Сердечные',
                'price' => 3500.00,
                'description' => 'Антикоагулянт нового поколения.',
                'specs' => '20 мг, 28 таблеток',
                'stock' => 5,
                'is_prescription' => true,
            ],
        ];

        foreach ($products as $item) {
            Product::create([
                'title' => $item['title'],
                'category' => $item['category'],
                'price' => $item['price'],
                'description' => $item['description'],
                'specs' => $item['specs'],
                'stock' => $item['stock'],
                'is_prescription' => $item['is_prescription'],
                'image_path' => 'images/no_image.jpg',
            ]);
        }
    }
}