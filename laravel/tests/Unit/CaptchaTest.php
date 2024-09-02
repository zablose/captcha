<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Zablose\Captcha\Captcha;
use Tests\UnitTestCase;

class CaptchaTest extends UnitTestCase
{
    #[Test]
    public function resizeable()
    {
        $this->assertCaptcha(['width' => 200, 'height' => 40]);
    }

    #[Test]
    public function checkable()
    {
        $captcha = $this->makeCaptcha();

        $this->assertTrue(Captcha::verify($captcha->getCode(), $captcha->hash(), $captcha->isSensitive()));
    }

    #[Test]
    public function check_fails_if_text_does_not_match()
    {
        $captcha = $this->makeCaptcha();

        $this->assertFalse(Captcha::verify($captcha->getCode().'abc', $captcha->hash(), $captcha->isSensitive()));
    }

    #[Test]
    public function check_fails_if_hash_does_not_match()
    {
        $captcha = $this->makeCaptcha();

        $this->assertFalse(Captcha::verify($captcha->getCode(), $captcha->hash().'abc', $captcha->isSensitive()));
    }

    #[Test]
    public function sensitive_check_fails_if_text_case_does_not_match()
    {
        $captcha = $this->makeCaptcha(['characters' => 'abcdef', 'sensitive' => true,]);

        $this->assertFalse(Captcha::verify(strtoupper($captcha->getCode()), $captcha->hash(), $captcha->isSensitive()));
    }

    #[Test]
    public function with_color_as_background()
    {
        $this->assertCaptcha(['use_background_image' => false]);
    }

    #[Test]
    public function configurable()
    {
        $this->assertCaptcha(
            [
                'contrast' => 50,
                'sharpness' => 10,
                'invert' => true,
                'blur' => 3,
            ]
        );
    }
}
