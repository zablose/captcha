<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Zablose\Captcha\Tests\Laravel\App\Models\User;
use Zablose\Captcha\Tests\Laravel\Tests\Traits\MakeCaptcha;

abstract class FeatureTestCase extends TestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use MakeCaptcha;

    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function assertPng(
        string $image,
        int $expected_width,
        int $expected_height,
        string $message = ''
    ): void {
        [$width, $height, $type] = getimagesizefromstring($image);

        $this->assertTrue(
            IMAGETYPE_PNG === $type && $expected_width === $width && $expected_height === $height,
            $message
        );
    }
}
