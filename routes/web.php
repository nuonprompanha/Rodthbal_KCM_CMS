<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserDepartmentController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
});

// Login — all login URLs use this route and show resources/views/Dashboard/login.blade.php
Route::get('/login', function () {
    return view('dashboard.login');
})->name('login')->middleware('guest');

// Admin Panel (Authenticated users only; Public users cannot access)
Route::get('/dashboard', function () {
    return view('dashboard.home-dashboard');
})->middleware(['auth', 'verified', 'dashboard.access'])->name('dashboard');

// Admin Panel - Users Accounts
Route::middleware(['auth', 'verified', 'dashboard.access'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/user-accounts', [UserAccountController::class, 'index'])->name('user-accounts');
    Route::get('/requested-users', [UserAccountController::class, 'requestedUsers'])->name('requested-users');
    Route::get('/public-users', [UserAccountController::class, 'publicUsers'])->name('public-users');
    Route::get('/suspended-users', [UserAccountController::class, 'suspendedUsers'])->name('suspended-users');
    Route::post('/user-accounts', [UserAccountController::class, 'store'])->name('user-accounts.store');
    Route::post('/user-accounts/{user}/approve', [UserAccountController::class, 'approve'])->name('user-accounts.approve');
    Route::put('/user-accounts/{user}/modify', [UserAccountController::class, 'modify'])->name('user-accounts.modify');
    Route::post('/user-accounts/{user}/suspend', [UserAccountController::class, 'suspend'])->name('user-accounts.suspend');
    Route::post('/user-accounts/{user}/restore', [UserAccountController::class, 'restore'])->name('user-accounts.restore');
});

// Admin Panel - Account Setup
Route::get('/dashboard/account-setup', function () {
    return view('dashboard.user-accounts.account-setup');
})->middleware(['auth', 'verified', 'dashboard.access'])->name('dashboard.account-setup');

// Admin Panel - User Departments & Permissions (CRUD)
Route::middleware(['auth', 'verified', 'dashboard.access'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('user-departments', UserDepartmentController::class);
    Route::resource('user-permissions', UserPermissionController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
