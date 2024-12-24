<?php
// database/seeders/Quiz/QuizSeeder.php
namespace Database\Seeders\Quiz;

use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\Region;
use App\Models\Quiz\QuizCategory;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $harajuku = Region::where('code', 'harajuku')->first();
        
        // 原宿の各カテゴリーのクイズを作成
        $this->createCultureQuizzes($harajuku);
        $this->createHistoryQuizzes($harajuku);
        $this->createLanguageQuizzes($harajuku);
        $this->createPeopleQuizzes($harajuku);
        $this->createEconomyQuizzes($harajuku);
    }

    private function createCultureQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'culture')->first();
        
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
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createHistoryQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'history')->first();
        
        $quizzes = [
            [
                'question' => '原宿駅が開業した年は？',
                'explanation' => '原宿駅は1906年（明治39年）に開業しました。当時は原宿停車場と呼ばれていました。',
                'options' => [
                    ['text' => '1906年', 'is_correct' => true],
                    ['text' => '1920年', 'is_correct' => false],
                    ['text' => '1889年', 'is_correct' => false],
                    ['text' => '1912年', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createLanguageQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'language')->first();
        
        $quizzes = [
            [
                'question' => '「原宿」の「原」の字の読み方として正しいものは？',
                'explanation' => '「原宿」の「原」は「はら」と読みます。江戸時代、この地域が原っぱだったことに由来します。',
                'options' => [
                    ['text' => 'はら', 'is_correct' => true],
                    ['text' => 'げん', 'is_correct' => false],
                    ['text' => 'わら', 'is_correct' => false],
                    ['text' => 'かわ', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createPeopleQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'people')->first();
        
        $quizzes = [
            [
                'question' => '1964年の東京オリンピックの際、原宿に設置された選手村は誰の設計？',
                'explanation' => '丹下健三氏によって設計された原宿の選手村は、オリンピック後に若者の街として発展していく契機となりました。',
                'options' => [
                    ['text' => '丹下健三', 'is_correct' => true],
                    ['text' => '安藤忠雄', 'is_correct' => false],
                    ['text' => '黒川紀章', 'is_correct' => false],
                    ['text' => '坂倉準三', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createEconomyQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'economy')->first();
        
        $quizzes = [
            [
                'question' => '原宿・表参道エリアの特徴として正しいものは？',
                'explanation' => '原宿・表参道エリアは、ファッションブランドの旗艦店が多く立ち並ぶ商業地域として知られています。',
                'options' => [
                    ['text' => 'ファッションブランドの旗艦店が多い', 'is_correct' => true],
                    ['text' => 'IT企業のオフィスが集中している', 'is_correct' => false],
                    ['text' => '金融機関が多く集まっている', 'is_correct' => false],
                    ['text' => '工場地帯として栄えている', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createQuizzes(Region $region, QuizCategory $category, array $quizData): void
    {
        foreach ($quizData as $data) {
            $quiz = Quiz::create([
                'region_id' => $region->id,
                'category_id' => $category->id,
                'question' => $data['question'],
                'explanation' => $data['explanation'],
                'is_ai_generated' => false
            ]);

            QuizOption::createOptionsForQuiz(
                $quiz->id,
                collect($data['options'])->map(function ($option) {
                    return [
                        'text' => $option['text'],
                        'is_correct' => $option['is_correct']
                    ];
                })->toArray()
            );
        }
    }
}