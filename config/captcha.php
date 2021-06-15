<?php

declare(strict_types=1);

return [

    'default' => [
        'assets_dir' => __DIR__.'/../vendor/zablose/captcha/assets/',
        'characters' => '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}',
        'length' => 5,
        'width' => 160,
        'height' => 60,
        'compression' => 9,
        'lines' => 10,
        'use_background_image' => true,
        'background_color' => '#FFFFFF',
        'colors' => [
            '#000000', // Black
            '#A60F0F', // Red
            '#6E3200', // Brown
            '#FF6804', // Orange
            '#A50065', // Pink
            '#342A99', // Dark blue
            '#126565', // Light blue
            '#0D5F09', // Green
            '#9F9000', // Yellow
        ],
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
