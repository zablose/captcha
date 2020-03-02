<?php declare(strict_types=1);

namespace Zablose\Captcha\Tests;

use Zablose\Captcha\Captcha;
use Zablose\Captcha\Config;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function assertCaptcha(array $config = [], string $message = ''): void
    {
        [$width, $height, $type] = getimagesizefromstring((new Captcha($config))->png());

        $config = new Config($config);

        $this->assertTrue(
            IMAGETYPE_PNG === $type && $config->width === $width && $config->height === $height,
            $message
        );
    }
}
