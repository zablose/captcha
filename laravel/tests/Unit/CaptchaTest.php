<?php declare(strict_types=1);

namespace Tests\Unit;

use Zablose\Captcha\Captcha;

class CaptchaTest extends UnitTestCase
{
    /** @test */
    public function resizeable()
    {
        $this->assertCaptcha(['width' => 200, 'height' => 40]);
    }

    /** @test */
    public function checkable()
    {
        $captcha = new Captcha();

        $this->assertTrue(Captcha::check($captcha->sensitive(), $captcha->txt(), $captcha->hash()));
    }

    /** @test */
    public function check_fails_if_text_does_not_match()
    {
        $captcha = new Captcha();

        $this->assertFalse(Captcha::check($captcha->sensitive(), $captcha->txt().'abc', $captcha->hash()));
    }

    /** @test */
    public function check_fails_if_hash_does_not_match()
    {
        $captcha = new Captcha();

        $this->assertFalse(Captcha::check($captcha->sensitive(), $captcha->txt(), $captcha->hash().'abc'));
    }

    /** @test */
    public function sensitive_check_fails_if_text_case_does_not_match()
    {
        $captcha = new Captcha([
            'characters' => 'abcdef',
            'sensitive' => true,
        ]);

        $this->assertFalse(Captcha::check($captcha->sensitive(), strtoupper($captcha->txt()), $captcha->hash()));
    }

    /** @test */
    public function with_color_as_background()
    {
        $this->assertCaptcha(['use_background_image' => false]);
    }

    /** @test */
    public function configurable()
    {
        $this->assertCaptcha([
            'contrast' => 50,
            'sharpen' => 10,
            'invert' => true,
            'blur' => 25,
        ]);
    }
}
