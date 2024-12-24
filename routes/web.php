<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizGameController;
use App\Http\Controllers\Lasvegas\LasvegasController;

Route::get('/', function () {
    return view('lasvegas.welcome');
});

Route::get('/lasve', function () {
    return view('lasvegas.welcome');
});



Route::get('/dashboard', function () {
    return view('lasvegas.lasvegas1');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/lasvegas2', function () {return view('lasvegas.lasvegas');})->name('lasvegas2');
    Route::post('/lasvegas/store-or-update', [LasvegasController::class, 'storeOrUpdate']);

    // クイズ機能に関するルートをグループ化
    Route::prefix('quiz')->name('Quiz.')->controller(QuizGameController::class)->group(function () {
        Route::get('menu/{region}', 'showMenu')->name('menu'); // メニュー表示
        Route::post('start', 'startGame')->name('start'); // ゲーム開始
        Route::post('submit-answer', 'submitAnswer')->name('submit-answer'); // 回答提出
        Route::get('result', 'showResult')->name('result'); // 結果表示
        Route::get('award/{gameId}', 'showAward')->name('award'); // 表彰状表示
    });
});

require __DIR__.'/auth.php';
