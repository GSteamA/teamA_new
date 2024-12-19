<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{
    protected $fillable = [
        'json'
    ];

    protected $casts = [
        'json' => 'array'
    ];

    public function games()
    {
        return $this->hasMany(Game::class, 'detail_id');
    }

    public function userGames()
    {
        return $this->hasMany(UserGame::class, 'detail_id');
    }
}
