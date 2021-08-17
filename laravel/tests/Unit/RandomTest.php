<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\UnitTestCase;
use Zablose\Captcha\Random;

class RandomTest extends UnitTestCase
{
    /** @test */
    public function string_gives_string()
    {
        $this->assertTrue(
            is_string(Random::string())
        );
    }

    /** @test */
    public function string_gives_random_string()
    {
        $this->assertTrue(
            Random::string() !== Random::string()
        );
    }

    /** @test */
    public function string_gives_custom_length_string()
    {
        $this->assertTrue(
            strlen(Random::string(8)) === 8
        );
    }

    /** @test */
    public function string_gives_twelve_characters_long_string_by_default()
    {
        $this->assertTrue(
            strlen(Random::string()) === 12
        );
    }

    /** @test */
    public function string_gives_same_string_if_characters_set_is_one_character_long()
    {
        $this->assertTrue(
            Random::string(16, 'a') === Random::string(16, 'a')
        );
    }

    /** @test */
    public function string_gives_empty_string_if_characters_set_is_empty()
    {
        $this->assertTrue(
            Random::string(3, '') === ''
        );
    }

    /** @test */
    public function string_gives_empty_string_if_length_set_to_zero()
    {
        $this->assertTrue(
            Random::string(0) === ''
        );
    }

    /** @test */
    public function string_gives_empty_string_if_length_is_negative()
    {
        $this->assertTrue(
            Random::string(-3) === ''
        );
    }

    /** @test */
    public function string_do_not_lowercase_string()
    {
        $this->assertTrue(
            Random::string(3, 'A') === 'AAA'
        );
    }

    /** @test */
    public function lower_gives_lowercase_string()
    {
        $this->assertTrue(
            Random::lower(3, 'A') === 'aaa'
        );
    }

    /** @test */
    public function lower_gives_empty_string_if()
    {
        $this->assertTrue(
            Random::lower(3, '') === ''
        );
    }
}
