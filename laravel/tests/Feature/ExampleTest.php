<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function testBasicTest()
    {
        $this->withoutExceptionHandling();

        $this->get('/captcha/default/abc')->assertStatus(200);
    }
}
