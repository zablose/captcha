<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Zablose\Captcha\Captcha;

Route::get('/captcha/{type}/{random_string?}', function ($type = 'default')
{
    $captcha = new Captcha(config('captcha.'.$type, []));

    Session::put('captcha', [
        'sensitive' => $captcha->sensitive(),
        'hash' => $captcha->hash(),
    ]);

    return Response::make($captcha->png())->header('Content-Type', 'image/png');
})
    ->middleware('web');
