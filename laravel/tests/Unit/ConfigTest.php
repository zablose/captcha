<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\UnitTestCase;
use Zablose\Captcha\Config;
use Zablose\Captcha\Exception\RotationAngleIsOutOfRangeException;
use Zablose\Captcha\Exception\BlurIsOutOfRangeException;
use Zablose\Captcha\Exception\CompressionIsOutOfRangeException;
use Zablose\Captcha\Exception\ContrastIsOutOfRangeException;
use Zablose\Captcha\Exception\LinesIsOutOfRangeException;
use Zablose\Captcha\Exception\SharpnessIsOutOfRangeException;

class ConfigTest extends UnitTestCase
{
    /** @test */
    public function contrast_is_out_of_max_range()
    {
        $this->expectException(ContrastIsOutOfRangeException::class);

        (new Config())->update(['contrast' => Config::CONTRAST_MAX - 1]);
    }

    /** @test */
    public function contrast_is_out_of_min_range()
    {
        $this->expectException(ContrastIsOutOfRangeException::class);

        (new Config())->update(['contrast' => Config::CONTRAST_MIN + 1]);
    }

    /** @test */
    public function blur_is_out_of_min_range()
    {
        $this->expectException(BlurIsOutOfRangeException::class);

        (new Config())->update(['blur' => Config::BLUR_NO_CHANGE - 1]);
    }

    /** @test */
    public function blur_is_out_of_max_range()
    {
        $this->expectException(BlurIsOutOfRangeException::class);

        (new Config())->update(['blur' => Config::BLUR_MAX + 1]);
    }

    /** @test */
    public function sharpness_is_out_of_min_range()
    {
        $this->expectException(SharpnessIsOutOfRangeException::class);

        (new Config())->update(['sharpness' => Config::SHARPNESS_NO_CHANGE - 1]);
    }

    /** @test */
    public function sharpness_is_out_of_max_range()
    {
        $this->expectException(SharpnessIsOutOfRangeException::class);

        (new Config())->update(['sharpness' => Config::SHARPNESS_MAX + 1]);
    }

    /** @test */
    public function compression_is_out_of_min_range()
    {
        $this->expectException(CompressionIsOutOfRangeException::class);

        (new Config())->update(['compression' => Config::COMPRESSION_NONE - 1]);
    }

    /** @test */
    public function compression_is_out_of_max_range()
    {
        $this->expectException(CompressionIsOutOfRangeException::class);

        (new Config())->update(['compression' => Config::COMPRESSION_MAX + 1]);
    }

    /** @test */
    public function rotation_angle_is_out_of_min_range()
    {
        $this->expectException(RotationAngleIsOutOfRangeException::class);

        (new Config())->update(['rotation_angle' => Config::ROTATION_ANGLE_NO_CHANGE - 1]);
    }

    /** @test */
    public function rotation_angle_is_out_of_max_range()
    {
        $this->expectException(RotationAngleIsOutOfRangeException::class);

        (new Config())->update(['rotation_angle' => Config::ROTATION_ANGLE_MAX + 1]);
    }

    /** @test */
    public function lines_is_out_of_min_range()
    {
        $this->expectException(LinesIsOutOfRangeException::class);

        (new Config())->update(['lines' => Config::LINES_NONE - 1]);
    }
}
