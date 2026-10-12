<?php

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Facades\Route;

Route::prefix('benchmark')->group(function () {
    Route::get('/easy', [BenchmarkController::class, 'easy']);
    Route::get('/relations', [BenchmarkController::class, 'relations']);
    Route::get('/complex', [BenchmarkController::class, 'complex']);
});
