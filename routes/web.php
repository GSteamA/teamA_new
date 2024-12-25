<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaraveltravelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizGameController;
use App\Http\Controllers\Lasvegas\LasvegasController;
use App\Http\Controllers\Quiz\QuizTestController;
use App\Http\Controllers\ShowPictureController;

//ルートではログイン画面を表示（lasvegas/welcome.blade.phpを正式なトップページとして作成済み）
Route::get('/', function () {
    return view('lasvegas.welcome');
});

// ログイン後の画面を表示
Route::get('/laraveltravel', [LaravelTravelController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

//ユーザー認証ずみのユーザーのみ表示可能
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/laraveltravel', [LaravelTravelController::class, 'index'])->name('laraveltravel.index');
    // Route::get('/laraveltravel', [LaravelTravelController::class, 'index'])->name('dashboard');


    //一覧画面
    Route::get('/laraveltravel/create', [LaravelTravelController::class, 'create'])->name('laraveltravel.create');
    Route::get('/api/show-picture', [ShowPictureController::class, 'showPictures']);

    //ラスベガスゲーム
    Route::get('/lasvegas', function () {return view('lasvegas.lasvegas1');})->name('lasvegas1');
    Route::get('/lasvegas2', function () {return view('lasvegas.lasvegas');})->name('lasvegas2');
    Route::post('/lasvegas/store-or-update', [LasvegasController::class, 'storeOrUpdate']);

    //原宿ゲーム
    Route::get('/harajuku', function () {return view('quiz.wellcome');})->name('quiz.wellcome');
    Route::get('/hakata', function () {return view('quiz.hakatawellcome');})->name('quiz.hakatawellcome');
    // クイズ機能に関するルートをグループ化
    Route::prefix('quiz')->name('quiz.')->controller(QuizGameController::class)->group(function () {
    Route::get('menu/{region}', 'showMenu')->name('menu'); // メニュー表示
    Route::post('start', 'startGame')->name('start'); // ゲーム開始
    Route::post('submit-answer', 'submitAnswer')->name('submit-answer'); // 回答提出
    Route::get('result', 'showResult')->name('result'); // 結果表示
    Route::get('award/{gameId}', 'showAward')->name('award'); // 表彰状表示
    });
});


// 開発環境専用のテストルート
if (app()->environment('local')) {
    Route::get('/quiz/test-driver', [QuizTestController::class, 'showTestDriver'])->name('quiz.test-driver');
    Route::post('/quiz/test-login', [QuizTestController::class, 'testLogin'])->name('quiz.test-login');
}


require __DIR__.'/auth.php';
