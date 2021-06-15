<?php

declare(strict_types=1);

namespace Zablose\Captcha;

class Color
{
    public const BLACK = '#000000';
    public const BROWN = '#6E3200';
    public const DARK_BLUE = '#342A99';
    public const GREEN = '#0D5F09';
    public const LIGHT_BLUE = '#126565';
    public const ORANGE = '#FF6804';
    public const PINK = '#A50065';
    public const RED = '#A60F0F';
    public const WHITE = '#FFFFFF';
    public const YELLOW = '#9F9000';

    public static function allButWhite(): array
    {
        return [
            Color::BLACK,
            Color::BROWN,
            Color::DARK_BLUE,
            Color::GREEN,
            Color::LIGHT_BLUE,
            Color::ORANGE,
            Color::PINK,
            Color::RED,
            Color::YELLOW,
        ];
    }
}
