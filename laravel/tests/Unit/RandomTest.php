<?php declare(strict_types=1);

namespace Tests\Unit;

use Zablose\Captcha\Random;

class RandomTest extends UnitTestCase
{
    /** @test */
    public function string()
    {
        $this->assertTrue(
            is_string(Random::string(8)) &&
            strlen(Random::string(8)) === 8 &&
            Random::string(8) !== Random::string(8) &&
            Random::string(16, 'a') === Random::string(16, 'a')
        );
    }
}
