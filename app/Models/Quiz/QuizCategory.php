<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class QuizCategory extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'code', 
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'category_id');
    }

    public static function getAvailableForRegion(int $regionId): Collection
    {
        return static::whereHas('quizzes', function ($query) use ($regionId) {
            $query->where('region_id', $regionId);
        })->get();
    }

    public static function findByCode(string $code): ?QuizCategory
    {
        return static::where('code', $code)->first();
    }

    public function hasQuizzesInRegion(int $regionId): bool
    {
        return $this->quizzes()->where('region_id', $regionId)->exists();
    }
}
