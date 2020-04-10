<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class ExampleTest extends FeatureTestCase
{
    /** @test */
    public function ok()
    {
        $this->get('/')->assertOk();
    }
}
