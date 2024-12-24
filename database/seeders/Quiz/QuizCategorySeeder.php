<?php

namespace Database\Seeders\Quiz;

use App\Models\Quiz\QuizCategory; 
use Illuminate\Database\Seeder;

class QuizCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // クイズの5つのカテゴリーを作成します
        $categories = [
            [
                'name' => 'culture',
                'display_name' => '文化',
                'code' => 'culture-quiz'
            ],
            [
                'name' => 'history',
                'display_name' => '歴史',
                'code' => 'history-quiz'
            ],
            [
                'name' => 'language',
                'display_name' => 'ことば',
                'code' => 'language-quiz'
            ],
            [
                'name' => 'people',
                'display_name' => '人物',
                'code' => 'people-quiz'
            ],
            [
                'name' => 'economy',
                'display_name' => '経済',
                'code' => 'economy-quiz'
            ]
        ];

        foreach ($categories as $category) {
            QuizCategory::create($category);
        }
    }
}
