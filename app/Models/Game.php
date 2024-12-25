<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'id',
        'game_name',
        'base_score',
        'config_json',
        'detail_id'
    ];

    public $incrementing = false;

    protected $casts = [
        'config_json' => 'array'
    ];

    public function gameDetail()
    {
        return $this->belongsTo(GameDetail::class, 'detail_id');
    }

    public function userGames()
    {
        return $this->hasMany(UserGame::class);
    }
}
