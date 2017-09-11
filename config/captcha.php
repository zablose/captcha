<?php

return [

    'default' => [
        'assets_dir'           => __DIR__ . '/../vendor/zablose/captcha/assets/',
        'characters'           => '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}',
        'length'               => 5,
        'width'                => 160,
        'height'               => 60,
        'quality'              => 70,
        'lines'                => 5,
        'use_background_image' => true,
        'background_color'     => '#FFFFFF',
        'colors'               => [
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
        'sensitive'            => false,
        'sharpen'              => 0,
        'blur'                 => 0,
        'invert'               => false,
        'contrast'             => 0,
        'angle'                => 15,
    ],

    'small' => [
        'length' => 3,
        'width'  => 60,
        'height' => 20,
    ],

];
