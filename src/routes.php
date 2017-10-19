<?php

use Zablose\Captcha\Captcha;

Route::get('/captcha/{type}/{random_string?}', function ($type = 'default')
{
    $captcha = (new Captcha())->create(config('captcha.' . $type, []));

    Session::put('captcha', [
        'sensitive' => $captcha->sensitive(),
        'hash'      => $captcha->hash(),
    ]);

    return $captcha->png();
})
    ->middleware('web');
