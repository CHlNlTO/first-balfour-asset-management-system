<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\RegisterController;

// // Custom registration route
// Route::get('/app/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/app/register', [RegisterController::class, 'store'])->name('register.store');

// // Other routes
// Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

// require __DIR__.'/auth.php';
