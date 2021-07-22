<?php

declare(strict_types=1);

use Zablose\Captcha\Color;
use Zablose\Captcha\Config;

return [

    'default' => [
        'assets_dir' => Config::selectAssetsDir(),
        'characters' => Config::CHARACTERS,
        'length' => 5,
        'width' => 160,
        'height' => 60,
        'compression' => 9,
        'lines' => 10,
        'use_background_image' => true,
        'background_color' => Color::WHITE,
        'colors' => Color::allButWhite(),
        'sensitive' => false,
        'sharpen' => 0,
        'blur' => 0,
        'invert' => false,
        'contrast' => 0,
        'angle' => 45,
    ],

    'small' => [
        'length' => 3,
        'width' => 90,
        'height' => 40,
    ],

    'invert' => [
        'invert' => true,
    ],

    'sharpen' => [
        'sharpen' => 25,
    ],

    'blur' => [
        'blur' => 5,
    ],

    'contrast' => [
        'contrast' => 50,
    ],

    'no-angle' => [
        'angle' => 0,
    ],

    'bg-color' => [
        'use_background_image' => false,
    ],

];
