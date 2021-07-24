<?php

declare(strict_types=1);

namespace Tests\Traits;

use Zablose\Captcha\Captcha;
use Zablose\Captcha\Config;
use Zablose\Captcha\Image;

trait makeCaptcha
{
    protected function makeCaptcha(array $config = []): Captcha
    {
        return new Captcha(new Image((new Config())->load($config)));
    }
}
