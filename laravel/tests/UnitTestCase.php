<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests;

use PHPUnit\Framework\TestCase;
use Zablose\Captcha\Tests\Laravel\Tests\Traits\MakeCaptcha;
use Zablose\Captcha\Config;

abstract class UnitTestCase extends TestCase
{
    use MakeCaptcha;

    protected function assertCaptcha(array $config = [], string $message = ''): void
    {
        [$width, $height, $type] = getimagesizefromstring($this->makeCaptcha($config)->toPng());

        $config = (new Config())->update($config);

        $this->assertTrue(
            IMAGETYPE_PNG === $type && $config->getWidth() === $width && $config->getHeight() === $height,
            $message
        );
    }
}
