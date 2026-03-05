<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Оставляем только вызов твоего главного сидера с аптекой
        $this->call([
            ProductSeeder::class,
        ]);
    }
}