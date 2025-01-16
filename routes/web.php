<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin panel Socialite auth routes
Route::get('/admin/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('admin.socialite.redirect')
    ->defaults('panel', 'admin');

Route::get('/admin/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('admin.socialite.callback');

// Employee panel Socialite auth routes
Route::get('/app/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('app.socialite.redirect')
    ->defaults('panel', 'app');

Route::get('/app/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('app.socialite.callback');

require __DIR__ . '/auth.php';
