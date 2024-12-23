<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('laraveltravel');
// });

// Route::get('/laraveltravel', [LaraveltravelController::class, 'edit'])->name('laraveltravel.edit');
// Route::get('/lasvegas', [LasvegasController::class, 'edit'])->name('lasvegas.edit');
Route::get('/harajyuku', [HarajyukuController::class, 'edit'])->name('harajyuku.edit');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

require __DIR__.'/auth.php';
