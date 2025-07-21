<?php

declare(strict_types=1);

use Zablose\Captcha\Tests\Laravel\App\Http\Controllers\Auth\LoginController;
use Zablose\Captcha\Tests\Laravel\App\Http\Controllers\Auth\RegisterController;
use Zablose\Captcha\Tests\Laravel\App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', fn() => view('welcome'));
Route::get('/captcha', fn() => view('captcha'));
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
