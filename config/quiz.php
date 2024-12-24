<?php

return [
    /*
    |--------------------------------------------------------------------------
    | クイズゲーム設定
    |--------------------------------------------------------------------------
    */

    // 1ゲームあたりの問題数
    'questions_per_game' => env('QUIZ_QUESTIONS_PER_GAME', 5),

    // 表彰状獲得に必要な最小正解数
    'min_correct_for_award' => env('QUIZ_MIN_CORRECT_FOR_AWARD', 4),

    // 基本スコア（1問あたりの得点）
    'base_score' => env('QUIZ_BASE_SCORE', 100),

    // デバッグモード（開発時のみtrue）
    'debug_mode' => env('QUIZ_DEBUG_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | 画像設定
    |--------------------------------------------------------------------------
    */
    'award_image' => [
        'storage_path' => 'awards',  // storage/app/public/awards/
        'default_extension' => 'jpg',
    ],
];