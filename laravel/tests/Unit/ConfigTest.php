<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\UnitTestCase;
use Zablose\Captcha\Config;
use Zablose\Captcha\Exception\AngleIsOutOfRangeException;
use Zablose\Captcha\Exception\BlurIsOutOfRangeException;
use Zablose\Captcha\Exception\CompressionIsOutOfRangeException;
use Zablose\Captcha\Exception\ContrastIsOutOfRangeException;
use Zablose\Captcha\Exception\SharpenIsOutOfRangeException;

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

    /** @test */
    public function sharpen_is_out_of_min_range()
    {
        $this->expectException(SharpenIsOutOfRangeException::class);

        (new Config())->load(['sharpen' => Config::SHARPEN_NO_CHANGE - 1]);
    }

    /** @test */
    public function sharpen_is_out_of_max_range()
    {
        $this->expectException(SharpenIsOutOfRangeException::class);

        (new Config())->load(['sharpen' => Config::SHARPEN_MAX + 1]);
    }

    /** @test */
    public function compression_is_out_of_min_range()
    {
        $this->expectException(CompressionIsOutOfRangeException::class);

        (new Config())->load(['compression' => Config::COMPRESSION_NONE - 1]);
    }

    /** @test */
    public function compression_is_out_of_max_range()
    {
        $this->expectException(CompressionIsOutOfRangeException::class);

        (new Config())->load(['compression' => Config::COMPRESSION_MAX + 1]);
    }

    /** @test */
    public function angle_is_out_of_min_range()
    {
        $this->expectException(AngleIsOutOfRangeException::class);

        (new Config())->load(['angle' => Config::ANGLE_NO_ROTATION - 1]);
    }

    /** @test */
    public function angle_is_out_of_max_range()
    {
        $this->expectException(AngleIsOutOfRangeException::class);

        (new Config())->load(['angle' => Config::ANGLE_MAX + 1]);
    }
}
