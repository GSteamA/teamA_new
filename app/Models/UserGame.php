<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'status',
        'score',
        'picture',
        'detail_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function gameDetail()
    {
        return $this->belongsTo(GameDetail::class, 'detail_id');
    }
}
