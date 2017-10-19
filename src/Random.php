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

}
