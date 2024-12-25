<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGame;

class ShowPictureController extends Controller
{
    public function showPictures()
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();

        // user_gamesテーブルから該当ユーザーのデータを取得
        $games = UserGame::where('user_id', $user->id)
            ->get(['game_id', 'picture']); // 必要なカラムのみ取得

        // デバッグ用に取得したデータをログに出力
        \Log::info('取得したゲームデータ:', $games->toArray());
        
        if ($games->isEmpty()) {
            return response()->json(['success' => true, 'data' => []]);
        }

        // game_idごとにデータを整理
        $gameData = $games->groupBy('game_id')->map(function ($gameGroup) {
            $game = $gameGroup->first();
            return [
                'game_id' => $game->game_id,
                'has_picture' => !empty($game->picture), // pictureがあるかどうか
                'picture' => $game->picture,
            ];
        });

        return response()->json(['success' => true, 'data' => $gameData]);
    }
}
