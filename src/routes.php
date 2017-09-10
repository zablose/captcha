<?php

use Zablose\Captcha\Captcha;

Route::get('captcha/{config_name?}', function (Captcha $captcha, $config_name = 'default')
{
    return $captcha->create($config_name);
})->middleware('web');