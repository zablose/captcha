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
    public function exceptions_triggered_by_wrong_configs(): array
    {
        return [
            [
                ContrastIsOutOfRangeException::class,
                ['contrast' => Config::CONTRAST_MAX - 1],
            ],
            [
                ContrastIsOutOfRangeException::class,
                ['contrast' => Config::CONTRAST_MIN + 1],
            ],
            [
                BlurIsOutOfRangeException::class,
                ['blur' => Config::BLUR_NO_CHANGE - 1],
            ],
            [
                BlurIsOutOfRangeException::class,
                ['blur' => Config::BLUR_MAX + 1],
            ],
            [
                SharpnessIsOutOfRangeException::class,
                ['sharpness' => Config::SHARPNESS_NO_CHANGE - 1],
            ],
            [
                SharpnessIsOutOfRangeException::class,
                ['sharpness' => Config::SHARPNESS_MAX + 1],
            ],
            [
                CompressionIsOutOfRangeException::class,
                ['compression' => Config::COMPRESSION_NONE - 1],
            ],
            [
                CompressionIsOutOfRangeException::class,
                ['compression' => Config::COMPRESSION_MAX + 1],
            ],
            [
                RotationAngleIsOutOfRangeException::class,
                ['rotation_angle' => Config::ROTATION_ANGLE_NO_CHANGE - 1],
            ],
            [
                RotationAngleIsOutOfRangeException::class,
                ['rotation_angle' => Config::ROTATION_ANGLE_MAX + 1],
            ],
            [
                LinesIsOutOfRangeException::class,
                ['lines' => Config::LINES_NONE - 1],
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider exceptions_triggered_by_wrong_configs()
     */
    public function validation_fails_if_config_is_wrong(string $exception, array $config)
    {
        $this->expectException($exception);

        (new Config())->update($config)->validate();
    }
}
