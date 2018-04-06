<?php

namespace Zablose\Captcha;

class Random
{

    const CHARACTERS = '0123456789abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';

    /**
     * @param int    $length
     * @param string $characters
     *
     * @return string
     */
    public static function string($length, $characters = self::CHARACTERS)
    {
        $string = '';

        for ($i = 0; $i < $length; $i++)
        {
            $string .= self::char($characters);
        }

        return $string;
    }

    /**
     * @param string $characters
     *
     * @return string
     */
    public static function char($characters = self::CHARACTERS)
    {
        return $characters[array_rand(str_split($characters))];
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public static function value($data)
    {
        return $data[array_rand($data)];
    }

    /**
     * @param int $angle
     *
     * @return int
     */
    public static function angle($angle)
    {
        return mt_rand((-1 * $angle), $angle);
    }

    /**
     * Get random font size based on height.
     *
     * @param int $height
     *
     * @return int
     */
    public static function size($height)
    {
        return mt_rand((int) $height * 0.75, (int) $height * 0.95);
    }

}
