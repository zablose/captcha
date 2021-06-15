<?php

declare(strict_types=1);

namespace Zablose\Captcha;

final class Random
{
    public const CHARACTERS = '0123456789abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';

    public static function string(int $length = 12, string $characters = self::CHARACTERS): string
    {
        $string = '';

        if (strlen($characters) >= 1) {
            for ($i = 0; $i < $length; $i++) {
                $string .= self::char($characters);
            }
        }

        return $string;
    }

    public static function lower(int $length, string $characters = self::CHARACTERS)
    {
        return strtolower(self::string($length, $characters));
    }

    public static function char(string $characters = self::CHARACTERS): string
    {
        return $characters[array_rand(str_split($characters))];
    }

    /**
     * @param  array  $data
     *
     * @return mixed
     */
    public static function value(array $data)
    {
        return $data[array_rand($data)];
    }

    public static function angle(int $angle): int
    {
        return mt_rand((-1 * $angle), $angle);
    }

    public static function size(int $size): int
    {
        return mt_rand(intval($size * 0.5), intval($size * 0.8));
    }

    public static function margin(int $space, int $size): int
    {
        return $size < $space ? mt_rand(0, $space - $size) : -1 * mt_rand(0, $size - $space);
    }

    public static function number(int $max): int
    {
        return mt_rand(0, $max);
    }
}
