<?php

use Zablose\Captcha\Random;

if (! function_exists('captcha_url')) {
    function captcha_url(string $type = 'default'): string
    {
        return url('/captcha/'.$type).'/'.Random::lower(12);
    }
}
