<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'confirm' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', fn() => view('welcome'));
Route::get('/captcha', fn() => view('captcha'));
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
