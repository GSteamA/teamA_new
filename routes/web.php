<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaraveltravelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizGameController;
use App\Http\Controllers\Lasvegas\LasvegasController;


//ルートではログイン画面を表示（現在は仮でlasvegas/welcome.blade.phpを表示）
Route::get('/', function () {
    return view('lasvegas.welcome');
});

//ログインすると、ララベルトラベルのトップページを表示
Route::get('/dashboard', [LaravelTravelController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

//追加したルートRoute::get('/laraveltravel/create', [LaravelTravelController::class, 'create'])->name('laraveltravel.create');
Route::get('/laraveltravel/Game_test/game-test-harajuku', [LaravelTravelController::class, 'show'])->name('game_test_harajuku');

// Route::get('/laraveltravel/Game_test/game-test-harajuku', function () {
//     return view('laraveltravel.Game_test.game_test_harajuku');
// })->name('game_test_harajuku');

// クイズ機能に関するルートをグループ化
Route::prefix('quiz')->name('Quiz.')->controller(QuizGameController::class)->group(function () {
    Route::get('menu/{region}', 'showMenu')->name('menu'); // メニュー表示
    Route::post('start', 'startGame')->name('start'); // ゲーム開始
    Route::post('submit-answer', 'submitAnswer')->name('submit-answer'); // 回答提出
    Route::get('result', 'showResult')->name('result'); // 結果表示
    Route::get('award/{gameId}', 'showAward')->name('award'); // 表彰状表示
});


//開発中は認証を経由せずにテストするため以下のルートを記載しない
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/lasvegas2', function () {return view('lasvegas.lasvegas');})->name('lasvegas2');
    Route::post('/lasvegas/store-or-update', [LasvegasController::class, 'storeOrUpdate']);
});

require __DIR__.'/auth.php';
