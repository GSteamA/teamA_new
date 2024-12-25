<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // クイズゲームの固定レコードを作成または更新
        Game::updateOrCreate(
            ['id' => 2], // ID=2で固定
            [
                'game_name' => 'quiz',
                'base_score' => config('quiz.base_score', 20),
                'config_json' => json_encode(['type' => 'quiz']),
                'detail_id' => null // detail_idは不要なのでnull
            ]
        );
    }
} 