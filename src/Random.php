<?php declare(strict_types=1);

namespace Zablose\Captcha;

class Random
{
    const CHARACTERS = '0123456789abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';

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

    public static function fontSize(int $height): int
    {
        return mt_rand(intval($height * 0.6), intval($height * 0.8));
    }
}
