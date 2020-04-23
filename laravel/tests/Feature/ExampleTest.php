<?php

namespace Zablose\Captcha\Laravel\Tests\Feature;

use Zablose\Captcha\Laravel\Tests\FeatureTestCase;

class ExampleTest extends FeatureTestCase
{
    /** @test */
    public function ok()
    {
        $this->get('/')->assertOk();
    }
}
