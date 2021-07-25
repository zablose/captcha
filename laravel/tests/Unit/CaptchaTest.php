<?php

declare(strict_types=1);

namespace Tests\Unit;

use Zablose\Captcha\Captcha;
use Tests\UnitTestCase;

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
        $captcha = $this->makeCaptcha();

        $this->assertTrue(Captcha::verify($captcha->getCode(), $captcha->hash(), $captcha->isSensitive()));
    }

    /** @test */
    public function check_fails_if_text_does_not_match()
    {
        $captcha = $this->makeCaptcha();

        $this->assertFalse(Captcha::verify($captcha->getCode().'abc', $captcha->hash(), $captcha->isSensitive()));
    }

    /** @test */
    public function check_fails_if_hash_does_not_match()
    {
        $captcha = $this->makeCaptcha();

        $this->assertFalse(Captcha::verify($captcha->getCode(), $captcha->hash().'abc', $captcha->isSensitive()));
    }

    /** @test */
    public function sensitive_check_fails_if_text_case_does_not_match()
    {
        $captcha = $this->makeCaptcha(['characters' => 'abcdef', 'sensitive' => true,]);

        $this->assertFalse(Captcha::verify(strtoupper($captcha->getCode()), $captcha->hash(), $captcha->isSensitive()));
    }

    /** @test */
    public function with_color_as_background()
    {
        $this->assertCaptcha(['use_background_image' => false]);
    }

    /** @test */
    public function configurable()
    {
        $this->assertCaptcha(
            [
                'contrast' => 50,
                'sharpen' => 10,
                'invert' => true,
                'blur' => 3,
            ]
        );
    }
}
