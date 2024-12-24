<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class Quiz extends Model
{
    protected $fillable = [
        'region_id',
        'category_id',
        'question',
        'explanation',
        'is_ai_generated',
    ];

    protected $casts = [
        'is_ai_generated' => 'boolean',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }   

    public function category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class, 'category_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class)->orderBy('display_order');
    }

     /**
     * 指定された地域とカテゴリーのクイズをランダムに取得します。
     * 
     * @param int $regionId 地域ID
     * @param int $categoryId カテゴリーID
     * @param int $limit 取得する問題数
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRandomQuizzes(int $regionId, int $categoryId, int $limit): Collection
    {
        return static::with(['options', 'region', 'category'])
                     ->where('region_id', $regionId)
                     ->where('category_id', $categoryId)
                     ->inRandomOrder()
                     ->take($limit)
                     ->get();
    }

    public function getCorrectOption(): QuizOption
    {
        return $this->options()->where('is_correct', true)->first();
    }

    public function isCorrectAnswer(int $optionId): bool
    {
        return $this->options()
            ->where('id', $optionId)
            ->where('is_correct', true)
            ->exists();
    }

    /**
     * AIによって生成された問題かどうかを判定します。
     * 
     * @return bool
     */
    public function isAiGenerated(): bool
    {
        return $this->is_ai_generated;
    }
}
