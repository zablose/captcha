<?php

namespace Zablose\Captcha;

class Image
{

    /**
     * Image canvas.
     *
     * @var resource
     */
    protected $canvas;

    /**
     * @var int
     */
    protected $width = 160;

    /**
     * @var int
     */
    protected $height = 60;

    /**
     * Path to the picture to load.
     *
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $background_color = '#ffffff';

    /**
     * @return $this
     */
    public function make()
    {
        return $this->path ? $this->load()->resize() : $this->create();
    }

    /**
     * @return $this
     */
    protected function load()
    {
        $this->canvas = @imagecreatefrompng($this->path);

        return $this;
    }

    /**
     * @return $this
     */
    protected function create()
    {
        $this->canvas = @imagecreatetruecolor($this->width, $this->height);
        imagefill($this->canvas, 0, 0, $this->getColor($this->background_color));

        return $this;
    }

    /**
     * @return $this
     */
    protected function resize()
    {
        $width  = imagesx($this->canvas);
        $height = imagesy($this->canvas);

        if ($this->width !== $width || $this->height !== $width)
        {
            $dst_image = imagecreatetruecolor($this->width, $this->height);
            imagecopyresampled($dst_image, $this->canvas, 0, 0, 0, 0, $this->width, $this->height, $width, $height);
            $this->canvas = $dst_image;
        }

        return $this;
    }

    /**
     * @param int $level Contrast level (-100 = max contrast, 0 = no change, +100 = min contrast)
     *
     * @return $this
     */
    public function addContrast($level)
    {
        if ($level <> 0)
        {
            imagefilter($this->canvas, IMG_FILTER_CONTRAST, $level);
        }

        return $this;
    }

    /**
     * @param int $amount Between 0 and 100
     *
     * @return $this
     */
    public function sharpen($amount)
    {
        if ($amount)
        {
            $min = $amount >= 10 ? $amount * -0.01 : 0;
            $max = $amount * -0.025;
            $abs = ((4 * $min + 4 * $max) * -1) + 1;
            $div = 1;

            $matrix = [
                [$min, $max, $min],
                [$max, $abs, $max],
                [$min, $max, $min],
            ];

            imageconvolution($this->canvas, $matrix, $div, 0);
        }

        return $this;
    }

    /**
     * @param bool $yes
     *
     * @return $this
     */
    public function invert($yes = false)
    {
        if ($yes)
        {
            imagefilter($this->canvas, IMG_FILTER_NEGATE);
        }

        return $this;
    }

    /**
     * @param int $amount Between 0 and 100
     *
     * @return $this
     */
    public function blur($amount)
    {
        for ($i = 0; $i < intval($amount); $i++)
        {
            imagefilter($this->canvas, IMG_FILTER_GAUSSIAN_BLUR);
        }

        return $this;
    }

    /**
     * @param string $text
     * @param int    $x
     * @param int    $y
     * @param string $font
     * @param int    $size
     * @param int    $color
     * @param int    $angle
     *
     * @return $this
     */
    public function addText($text, $x, $y, $font, $size, $color, $angle)
    {
        $box = imagettfbbox($this->getFontPoints($size), $angle, $font, $text);

        $x = $x - min($box[0], $box[6]);
        $y = $y - max($box[1], $box[3]);

        imagettftext($this->canvas, $this->getFontPoints($size), $angle, $x, $y, $this->getColor($color), $font, $text);

        return $this;
    }

    /**
     * @param int $size
     *
     * @return int
     */
    public function getFontPoints($size)
    {
        return intval(ceil($size * 0.75));
    }

    /**
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $color
     *
     * @return $this
     */
    public function addLine($x1, $y1, $x2, $y2, $color)
    {
        imageline($this->canvas, $x1, $y1, $x2, $y2, $this->getColor($color));

        return $this;
    }

    /**
     * @param int $quality
     *
     * @return string
     */
    public function png($quality)
    {
        ob_start();
        imagepng($this->canvas, null, $quality);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }

    /**
     * @param string|null $code
     *
     * @return int
     */
    protected function getColor($code = null)
    {
        list($red, $green, $blue) = [255, 255, 255];

        if ($code)
        {
            $codes = str_split(substr($code, -6), 2);
            list($red, $green, $blue) = [hexdec($codes[0]), hexdec($codes[1]), hexdec($codes[2])];
        }

        return imagecolorallocate($this->canvas, $red, $green, $blue);
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setBackgroundColor($code)
    {
        $this->background_color = $code;

        return $this;
    }

}
