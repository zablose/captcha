<?php

use Zablose\Captcha\Captcha;

Route::get('captcha/{config_name?}', function ($config_name = 'default')
{
    $captcha = (new Captcha())->create(config('captcha.' . $config_name, []));

    Session::put('captcha', [
        'sensitive' => $captcha->sensitive(),
        'key'       => $captcha->key(),
    ]);

    return $captcha->png();
})
    ->middleware('web');
