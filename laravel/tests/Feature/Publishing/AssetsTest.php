<?php

declare(strict_types=1);

namespace Tests\Feature\Publishing;

use Illuminate\Support\Facades\File;
use Tests\FeatureTestCase;
use Zablose\Captcha\CaptchaServiceProvider;
use Zablose\Captcha\Config;

class AssetsTest extends FeatureTestCase
{
    /** @test */
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
