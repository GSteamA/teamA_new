<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuizDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // シーダーを実行する順序を制御します
        $this->call([
            Quiz\RegionSeeder::class,
            Quiz\QuizCategorySeeder::class,
            Quiz\QuizSeeder::class,
        ]);
    }
}
