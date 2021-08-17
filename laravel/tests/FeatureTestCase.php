<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\Traits\makeCaptcha;

abstract class FeatureTestCase extends TestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use makeCaptcha;

    /** @noinspection PhpIncompatibleReturnTypeInspection */
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
