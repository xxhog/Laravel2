<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'title' => 'CopyStar A1 Pro',
                'price' => 18900,
                'description' => 'Многофункциональное устройство для офиса с поддержкой двусторонней печати и сканирования.',
                'specs' => "Скорость печати 35 стр/мин\nЦветной сенсорный дисплей 7\"\nПоддержка Wi-Fi и AirPrint",
                'stock' => 5,
                'image_path' => 'images/landing/04a3f27df4.jpg',
            ],
            [
                'title' => 'CopyStar Lite 300',
                'price' => 7500,
                'description' => 'Компактный настольный принтер. Идеален для малого бизнеса и домашнего офиса.',
                'specs' => "Скорость печати 18 стр/мин\nЕмкость лотка 250 листов\nПростое обслуживание картриджей",
                'stock' => 10,
                'image_path' => 'images/landing/foto.png',
            ],
            [
                'title' => 'CopyStar Toner Pack',
                'price' => 4200,
                'description' => 'Комплект оригинальных картриджей для устройств CopyStar, рассчитанный на 5000 страниц.',
                'specs' => "Высокая плотность печати\nСистема защиты от подделок\nРасширенная гарантия 12 мес.",
                'stock' => 8,
                'image_path' => 'images/landing/logo.png',
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
