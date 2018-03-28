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
    public $quality = 9;

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
    public $angle = 45;

    /**
     * @var int
     */
    private $current_angle = 0;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $color;

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
     * @return $this
     */
    public function randomizeAngle()
    {
        $this->current_angle = mt_rand((-1 * $this->angle), $this->angle);

        return $this;
    }

    /**
     * Get random angle based on angle.
     *
     * @return int
     */
    public function getAngle()
    {
        return $this->current_angle;
    }

    public function randomizeColor()
    {
        $this->color = $this->colors[array_rand($this->colors)];

        return $this;
    }

    /**
     * Get random font color from the list.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get random font size based on height.
     *
     * @return $this
     */
    public function randomizeSize()
    {
        $this->size = mt_rand((int) $this->height * 0.75, (int) $this->height * 0.95);

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}