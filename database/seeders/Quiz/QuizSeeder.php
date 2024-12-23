<?php

namespace Database\Seeders\Quiz;

use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\Region;
use App\Models\Quiz\QuizCategory;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 原宿の文化に関するサンプルクイズを作成
        $harajuku = Region::where('code', 'harajuku')->first();
        $culture = QuizCategory::where('name', 'culture')->first();

        $quizzes = [
            [
                'question' => '原宿のファッションカルチャーを代表する通りは次のうちどれ？',
                'explanation' => '竹下通りは原宿を代表するファッションストリートで、若者向けのブティックや雑貨店が立ち並びます。',
                'options' => [
                    ['text' => '竹下通り', 'is_correct' => true],
                    ['text' => '表参道', 'is_correct' => false],
                    ['text' => '明治通り', 'is_correct' => false],
                    ['text' => '井の頭通り', 'is_correct' => false]
                ]
            ],
            // その他のクイズを追加...
        ];

        foreach ($quizzes as $quizData) {
            $quiz = Quiz::create([
                'region_id' => $harajuku->id,
                'category_id' => $culture->id,
                'question' => $quizData['question'],
                'explanation' => $quizData['explanation'],
                'is_ai_generated' => false
            ]);

            // クイズの選択肢を作成
            QuizOption::createOptionsForQuiz(
                $quiz->id,
                collect($quizData['options'])->map(function ($option, $index) {
                    return [
                        'text' => $option['text'],
                        'is_correct' => $option['is_correct']
                    ];
                })->toArray()
            );
        }

        // 同様に他の地域とカテゴリーのクイズも作成...

    }
}
