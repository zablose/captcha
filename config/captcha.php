<?php

declare(strict_types=1);

use Zablose\Captcha\Color;
use Zablose\Captcha\Config;
use Zablose\Captcha\Assets;

return [

    'default' => [
        'assets_dir' => Assets::dir(),
        'characters' => Config::CHARACTERS,
        'length' => Config::LENGTH_DEFAULT,
        'width' => Config::WIDTH_DEFAULT,
        'height' => Config::HEIGHT_DEFAULT,
        'compression' => Config::COMPRESSION_MAX,
        'lines' => 10,
        'use_background_image' => true,
        'background_color' => Color::WHITE,
        'colors' => Color::allButWhite(),
        'sensitive' => false,
        'sharpness' => Config::SHARPNESS_NO_CHANGE,
        'blur' => Config::BLUR_NO_CHANGE,
        'invert' => false,
        'contrast' => Config::CONTRAST_NO_CHANGE,
        'rotation_angle' => Config::ROTATION_ANGLE_MAX,
    ],

    'small' => [
        'length' => 3,
        'width' => 90,
        'height' => 40,
        'lines' => Config::LINES_NONE,
    ],

    'invert' => [
        'invert' => true,
    ],

    'sharpness' => [
        'sharpness' => Config::SHARPNESS_MAX,
    ],

    'blur' => [
        'blur' => Config::BLUR_MAX,
    ],

    'contrast' => [
        'contrast' => Config::CONTRAST_MAX,
    ],

    'no-angle' => [
        'rotation_angle' => Config::ROTATION_ANGLE_NO_CHANGE,
    ],

    'bg-color' => [
        'use_background_image' => false,
        'background_color' => Color::YELLOW,
        'colors' => Color::allBut(Color::YELLOW),
    ],

];
