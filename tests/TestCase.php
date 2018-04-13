<?php

namespace Zablose\Captcha\Tests;

use Zablose\Captcha\Captcha;
use Zablose\Captcha\Config;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * @param array  $config
     * @param string $message
     */
    protected function assertCaptcha(array $config = [], string $message = '') : void
    {
        list($width, $height, $type) = getimagesizefromstring((new Captcha($config))->png());

        $config = new Config($config);

        $this->assertTrue(
            IMAGETYPE_PNG === $type && $config->width === $width && $config->height === $height,
            $message
        );
    }

}
