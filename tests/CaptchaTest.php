<?php declare(strict_types=1);

namespace Zablose\Captcha\Tests;

use Zablose\Captcha\Captcha;

class CaptchaTest extends TestCase
{
    /** @test */
    public function is_resizeable()
    {
        $this->assertCaptcha(['width' => 200, 'height' => 40]);
    }

    /** @test */
    public function is_checkable()
    {
        $captcha = new Captcha();

        $this->assertTrue(Captcha::check($captcha->sensitive(), $captcha->txt(), $captcha->hash()));
    }

    /** @test */
    public function with_color_as_background()
    {
        $this->assertCaptcha(['use_background_image' => false]);
    }

    /** @test */
    public function is_configurable()
    {
        $this->assertCaptcha([
            'contrast' => 50,
            'sharpen' => 10,
            'invert' => true,
            'blur' => 25,
        ]);
    }
}
