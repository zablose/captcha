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

    public static function all(): array
    {
        return [
            self::BLACK,
            self::BROWN,
            self::DARK_BLUE,
            self::GREEN,
            self::LIGHT_BLUE,
            self::ORANGE,
            self::PINK,
            self::RED,
            self::WHITE,
            self::YELLOW,
        ];
    }

    public static function allBut(string $color): array
    {
        return array_diff(self::all(), [$color]);
    }

    public static function allButWhite(): array
    {
        return self::allBut(self::WHITE);
    }
}
