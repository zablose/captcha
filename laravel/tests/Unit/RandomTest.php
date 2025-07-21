<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Zablose\Captcha\Tests\Laravel\Tests\UnitTestCase;
use Zablose\Captcha\Random;

class RandomTest extends UnitTestCase
{
    #[Test]
    public function string_gives_string()
    {
        $this->assertTrue(
            is_string(Random::string())
        );
    }

    #[Test]
    public function string_gives_random_string()
    {
        $this->assertTrue(
            Random::string() !== Random::string()
        );
    }

    #[Test]
    public function string_gives_custom_length_string()
    {
        $this->assertTrue(
            strlen(Random::string(8)) === 8
        );
    }

    #[Test]
    public function string_gives_twelve_characters_long_string_by_default()
    {
        $this->assertTrue(
            strlen(Random::string()) === 12
        );
    }

    #[Test]
    public function string_gives_same_string_if_characters_set_is_one_character_long()
    {
        $this->assertTrue(
            Random::string(16, 'a') === Random::string(16, 'a')
        );
    }

    #[Test]
    public function string_gives_empty_string_if_characters_set_is_empty()
    {
        $this->assertTrue(
            Random::string(3, '') === ''
        );
    }

    #[Test]
    public function string_gives_empty_string_if_length_set_to_zero()
    {
        $this->assertTrue(
            Random::string(0) === ''
        );
    }

    #[Test]
    public function string_gives_empty_string_if_length_is_negative()
    {
        $this->assertTrue(
            Random::string(-3) === ''
        );
    }

    #[Test]
    public function string_do_not_lowercase_string()
    {
        $this->assertTrue(
            Random::string(3, 'A') === 'AAA'
        );
    }

    #[Test]
    public function lower_gives_lowercase_string()
    {
        $this->assertTrue(
            Random::lower(3, 'A') === 'aaa'
        );
    }

    #[Test]
    public function lower_gives_empty_string_if()
    {
        $this->assertTrue(
            Random::lower(3, '') === ''
        );
    }
}
