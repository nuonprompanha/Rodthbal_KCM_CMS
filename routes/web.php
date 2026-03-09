<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
});

// Login — all login URLs use this route and show resources/views/Dashboard/login.blade.php
Route::get('/login', function () {
    return view('dashboard.login');
})->name('login')->middleware('guest');

Route::get('/Admin-Panel', function () {
    return view('dashboard.Admin-Panel');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::redirect('/dashboard', '/Admin-Panel');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
