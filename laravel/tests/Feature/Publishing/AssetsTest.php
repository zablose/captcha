<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests\Feature\Publishing;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Zablose\Captcha\CaptchaServiceProvider;
use Zablose\Captcha\Config;
use Zablose\Captcha\Tests\Laravel\Tests\FeatureTestCase;

class AssetsTest extends FeatureTestCase
{
    #[Test]
    public function is_publishable(): void
    {
        $assets_dir = resource_path(Config::ASSETS_PATH);

        if (File::exists($assets_dir)) {
            File::deleteDirectory($assets_dir);
        }

        $this->artisan('vendor:publish', ['--provider' => CaptchaServiceProvider::class, '--tag' => 'assets']);

        $this->assertTrue(File::exists($assets_dir));
    }
}
