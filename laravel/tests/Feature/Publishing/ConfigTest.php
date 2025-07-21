<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests\Feature\Publishing;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Zablose\Captcha\Tests\Laravel\Tests\FeatureTestCase;
use Zablose\Captcha\CaptchaServiceProvider;
use Zablose\Captcha\Config;

class ConfigTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('config:clear');
    }

    #[Test]
    public function is_publishable(): void
    {
        $config = config_path('captcha.php');

        if (File::exists($config)) {
            File::delete($config);
        }

        $this->artisan('vendor:publish', ['--provider' => CaptchaServiceProvider::class, '--tag' => 'config']);

        $this->assertTrue(File::exists($config));
    }

    #[Test]
    public function is_readable(): void
    {
        $this->assertEquals(Config::CHARACTERS, config('captcha.default.characters'));
    }
}
