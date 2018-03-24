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
     * @var int
     */
    public $quality = 0;

    /**
     * @var int
     */
    public $lines = 5;

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
    private $colors = [
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
    private $angle = 15;

    /**
     * @param array $config
     *
     * @return $this
     */
    public function apply($config)
    {
        foreach ($config as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * Get random angle based on angle.
     *
     * @return int
     */
    public function angle()
    {
        return mt_rand((-1 * $this->angle), $this->angle);
    }

    /**
     * Get random font color from the list.
     *
     * @return array
     */
    public function color()
    {
        return $this->colors[array_rand($this->colors)];
    }

    /**
     * Get random font size based on height.
     *
     * @return integer
     */
    public function size()
    {
        return mt_rand((int) $this->height * 0.85, (int) $this->height * 0.95);
    }
}