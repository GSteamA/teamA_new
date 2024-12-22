<?php

namespace App\Models\Models\Laraveltravel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laraveltravel extends Model
{
    /** @use HasFactory<\Database\Factories\Models\Laraveltravel\LaraveltravelFactory> */
    use HasFactory;
    public function laraveltravel()
    {
      return $this->hasMany(Laraveltravel::class);
    }
}
