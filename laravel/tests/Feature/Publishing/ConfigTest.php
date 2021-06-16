<?php

declare(strict_types=1);

namespace Tests\Feature\Publishing;

use Illuminate\Support\Facades\File;
use Tests\FeatureTestCase;
use Zablose\Captcha\CaptchaServiceProvider;
use Zablose\Captcha\Config;

class ConfigTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('config:clear');
    }

    /** @test */
    public function is_publishable(): void
    {
        $config = config_path('captcha.php');

        if (File::exists($config)) {
            File::delete($config);
        }

        $this->artisan('vendor:publish', ['--provider' => CaptchaServiceProvider::class, '--tag' => 'config']);

        $this->assertTrue(File::exists($config));
    }

    /** @test */
    public function is_readable(): void
    {
        $this->assertEquals(Config::CHARACTERS, config('captcha.default.characters'));
    }
}
