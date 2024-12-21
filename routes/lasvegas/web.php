<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/lasvegas', function () {
    return view('lasvegas.lasvegas');
});
