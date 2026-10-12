<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/branch', [BranchController::class, 'index'])
    ->name('branch.index')
    ->middleware(['auth', 'role:admin']);

Route::post('/branch', [BranchController::class, 'store'])
    ->name('branch.store')
    ->middleware(['auth', 'role:admin']);


Route::post('/transaction/send-email/{user}', [UserController::class, 'sendEmail'])
    ->name('transaction.sendEmail')
    ->middleware(['auth', 'role:admin']);

Route::get('/user', [UserController::class, 'index'])
    ->name('user.index')
    ->middleware(['auth', 'role:admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
