<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;

abstract class FeatureTestCase extends TestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }
}
