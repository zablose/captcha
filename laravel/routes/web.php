<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/captcha', fn() => view('captcha'));

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
