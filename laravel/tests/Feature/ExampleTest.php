<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function ok()
    {
        $this->get('/')->assertOk();
    }
}
