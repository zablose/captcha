<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests\Traits;

use Zablose\Captcha\Captcha;
use Zablose\Captcha\Config;
use Zablose\Captcha\Image;

trait MakeCaptcha
{
    protected function makeCaptcha(array $config = []): Captcha
    {
        return new Captcha(new Image((new Config())->update($config)));
    }
}
