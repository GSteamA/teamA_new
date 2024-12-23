<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'name', 
        'display_name',
        'code',
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function awardImages(): HasMany
    {
        return $this->hasMany(AwardImage::class);  
    }

    public static function findByCode(string $code): ?Region
    {
        return static::where('code', $code)->first();
    }

    public function hasQuizzes(): boolval
    {
        return $this->quizzes()->exists();
    }
}
