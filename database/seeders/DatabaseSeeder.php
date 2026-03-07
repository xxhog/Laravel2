<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //вызов продукт сидер с аптечным заполнением
        $this->call([
            ProductSeeder::class,
        ]);
    }
}