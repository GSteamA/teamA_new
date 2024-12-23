<?php

namespace Database\Seeders\Quiz;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Quiz\Region; 
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 要件で指定された3つの地域を作成します
        $regions = [
            [
                'name' => 'tokyo_harajuku',
                'display_name' => '東京（原宿）',
                'code' => 'harajuku'
            ],
            [
                'name' => 'fukuoka_hakata',
                'display_name' => '福岡（博多）',
                'code' => 'hakata'
            ],
            [
                'name' => 'nevada_las_vegas',
                'display_name' => 'ネバダ（ラスベガス）',
                'code' => 'las_vegas'
            ]
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
