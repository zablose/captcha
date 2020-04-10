<?php declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Zablose\Captcha\Captcha;
use Zablose\Captcha\Config;

abstract class UnitTestCase extends TestCase
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
