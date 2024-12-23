<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lasvegas\LasvegasController;

Route::get('/', function () {
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
});

require __DIR__.'/auth.php';
