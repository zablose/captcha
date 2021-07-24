<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\UnitTestCase;
use Zablose\Captcha\Config;
use Zablose\Captcha\Exception\ContrastIsOutOfRangeException;

class ConfigTest extends UnitTestCase
{
    /** @test */
    public function contrast_is_out_of_max_range()
    {
        $this->expectException(ContrastIsOutOfRangeException::class);

        $this->makeCaptcha(['contrast' => Config::CONTRAST_LEVEL_MAX - 1]);
    }

    /** @test */
    public function contrast_is_out_of_min_range()
    {
        $this->expectException(ContrastIsOutOfRangeException::class);

        $this->makeCaptcha(['contrast' => Config::CONTRAST_LEVEL_MIN + 1]);
    }
}
