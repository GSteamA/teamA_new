<?php

namespace App\Http\Controllers\Lasvegas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGame;
use Exception;

class LasvegasController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        try {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }
        $score = $request->input('score');
        if (!is_numeric($score)) {
            return response()->json(['success' => false, 'message' => 'Invalid score value'], 400);
        }
        $gameId = 1;

        // 現在のゲームデータを取得または新規作成
        $game = UserGame::firstOrNew(
            ['user_id' => $user->id, 'game_id' => $gameId],
            ['status' => 'play', 'score' => $score]
        );

        // ベストスコア判定
        if ($score > $game->score) {
            $game->score = $score;
        }

        // クリア条件（80点以上）
        if ($score >= 80) {
            $game->status = 'clear';
            $game->picture = '/img/lasvegas/lasvegas_clear.png'; // 表彰データのパスを設定
        }

        // データ保存
        $game->save();

        return response()->json(['success' => true, 'game' => $game]);
        }catch (\Exception $e) {
            \Log::error('Game save error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save game data'
            ], 500);
        }
    }
}
