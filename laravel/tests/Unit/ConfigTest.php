<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\UnitTestCase;
use Zablose\Captcha\Config;
use Zablose\Captcha\Exception\BlurIsOutOfRangeException;
use Zablose\Captcha\Exception\ContrastIsOutOfRangeException;

class ConfigTest extends UnitTestCase
{
    /** @test */
    public function contrast_is_out_of_max_range()
    {
        $this->expectException(ContrastIsOutOfRangeException::class);

        (new Config())->load(['contrast' => Config::CONTRAST_MAX - 1]);
    }

    /** @test */
    public function contrast_is_out_of_min_range()
    {
        $this->expectException(ContrastIsOutOfRangeException::class);

        (new Config())->load(['contrast' => Config::CONTRAST_MIN + 1]);
    }

    /** @test */
    public function blur_is_out_of_min_range()
    {
        $this->expectException(BlurIsOutOfRangeException::class);

        (new Config())->load(['blur' => Config::BLUR_NO_CHANGE - 1]);
    }

    /** @test */
    public function blur_is_out_of_max_range()
    {
        $this->expectException(BlurIsOutOfRangeException::class);

        (new Config())->load(['blur' => Config::BLUR_MAX + 1]);
    }
}
