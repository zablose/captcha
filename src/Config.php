<?php

namespace Zablose\Captcha;

class Config
{

    /**
     * @var string
     */
    public $assets_dir = __DIR__ . '/../assets/';

    /**
     * @var string
     */
    public $characters = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}';

    /**
     * @var int
     */
    public $length = 5;

    /**
     * @var int
     */
    public $width = 160;

    /**
     * @var int
     */
    public $height = 60;

    /**
     * Compression level: from 0 (no compression) to 9.
     *
     * @var int
     */
    public $compression = 9;

    /**
     * @var int
     */
    public $lines = 10;

    /**
     * @var bool
     */
    public $use_background_image = true;

    /**
     * @var string
     */
    public $background_color = '#FFFFFF';

    /**
     * @var array
     */
    public $colors = [
        '#000000', // Black
        '#A60F0F', // Red
        '#6E3200', // Brown
        '#FF6804', // Orange
        '#A50065', // Pink
        '#342A99', // Dark blue
        '#126565', // Light blue
        '#0D5F09', // Green
        '#9F9000', // Yellow
    ];

    /**
     * @var bool
     */
    public $sensitive = false;

    /**
     * @var int
     */
    public $sharpen = 0;

    /**
     * @var int
     */
    public $blur = 0;

    /**
     * @var bool
     */
    public $invert = false;

    /**
     * @var int
     */
    public $contrast = 0;

    /**
     * @var int
     */
    public $angle = 45;

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        foreach ($config as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $value;
            }
        }
    }

}
