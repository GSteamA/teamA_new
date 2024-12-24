<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class QuizOption extends Model
{
    protected $fillable = [
        'quiz_id',
        'option_text',
        'is_correct',
        'display_order',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'display_order' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * 新しい選択肢群をクイズに追加します。
     * 既存の選択肢は削除され、新しい選択肢が設定されます。
     * 
     * @param int $quizId クイズID
     * @param array<array{text: string, is_correct: bool}> $options 選択肢データの配列
     * @return Collection 作成された選択肢のコレクション
     * @throws \InvalidArgumentException 正解が1つでない場合や選択肢が2個未満、5個超過の場合
     */
    public static function addOptionsToQuiz(int $quizId, array $options): Collection
    {
        // 選択肢の数をバリデーション
        if (count($options) < 2 || count($options) > 5) {
            throw new \InvalidArgumentException('選択肢は2個以上5個以下でなければなりません。');
        }

        // 正解が1つだけであることを確認
        $correctCount = collect($options)->where('is_correct', true)->count();
        if ($correctCount !== 1) {
            throw new \InvalidArgumentException('正解は1つだけである必要があります。');
        }

        // トランザクション開始
        return \DB::transaction(function () use ($quizId, $options) {
            // 既存の選択肢を削除
            static::where('quiz_id', $quizId)->delete();

            // 新しい選択肢を追加
            $createdOptions = collect();
            foreach ($options as $index => $option) {
                $createdOptions->push(static::create([
                    'quiz_id' => $quizId,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'display_order' => $index + 1,
                ]));
            }

            return $createdOptions;
        });
    }

    /**
     * 指定されたクイズの選択肢を表示順で取得します。
     * 
     * @param int $quizId クイズID
     * @return Collection
     */
    public static function getOptionsByQuizId(int $quizId): Collection
    {
        return static::where('quiz_id', $quizId)
            ->orderBy('display_order')
            ->get();
    }
    /**
     * この選択肢が正解かどうかを判定します。
     * 
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->is_correct;
    }

    /**
     * 選択肢の表示順序を更新します。
     * 
     * @param int $newOrder 新しい表示順序
     * @return bool
     */
    public function updateDisplayOrder(int $newOrder): bool
    {
        return $this->update(['display_order' => $newOrder]);
    }

    /**
     * Seeder向けのエイリアス。Cludeが生成したSeederが指定しているメソッド名に揃えるためのエイリアスメソッド。
     * 
     */
    public static function createOptionsForQuiz(int $quizId, array $options): Collection
    {
        return static::addOptionsToQuiz($quizId, $options);
    }

}
