<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Traits\makeCaptcha;
use Zablose\Captcha\Config;

abstract class UnitTestCase extends TestCase
{
    use makeCaptcha;

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
