<?php

namespace Zablose\Captcha;

class Image
{

    protected $resource;
    protected $width;
    protected $height;

    public function make($path)
    {
        $resource = @imagecreatefrompng($path);

        $this->width  = imagesx($resource);
        $this->height = imagesy($resource);

        // new canvas
        $canvas = imagecreatetruecolor($this->width, $this->height);

        // fill with transparent color
        imagealphablending($canvas, false);
        $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefilledrectangle($canvas, 0, 0, $this->width, $this->height, $transparent);
        imagecolortransparent($canvas, $transparent);
        imagealphablending($canvas, true);

        // copy original
        imagecopy($canvas, $resource, 0, 0, 0, 0, $this->width, $this->height);
        imagedestroy($resource);

        $this->resource = $canvas;

        return $this;
    }

    public function canvas($width, $height, $background = null)
    {
        $this->resource = imagecreatetruecolor($width, $height);

        imagefill($this->resource, 0, 0, $this->getColor($background));

        return $this;
    }

    public function resize($width, $height)
    {
        $image = imagecreatetruecolor($width, $height);
        imagecopyresampled($image, $this->resource, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
        $this->resource = $image;

        return $this;
    }

    /**
     * @param int $level Contrast level (-100 = max contrast, 0 = no change, +100 = min contrast)
     *
     * @return $this
     */
    public function contrast($level)
    {
        imagefilter($this->resource, IMG_FILTER_CONTRAST, $level);

        return $this;
    }

    /**
     * @param int $amount Between 0 and 100
     *
     * @return $this
     */
    public function sharpen($amount)
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

        imageconvolution($this->resource, $matrix, $div, 0);

        return $this;
    }

    public function invert()
    {
        imagefilter($this->resource, IMG_FILTER_NEGATE);

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
            imagefilter($this->resource, IMG_FILTER_GAUSSIAN_BLUR);
        }

        return $this;
    }

    public function text($text, $x, $y, $font, $size, $color, $angle)
    {
        imagettftext($this->resource, intval(ceil($size * 0.75)), $angle, $x, $y, $this->getColor($color), $font, $text);

        return $this;
    }

    public function line($x1, $y1, $x2, $y2, $color)
    {
        imageline($this->resource, $x1, $y1, $x2, $y2, $this->getColor($color));

        return $this;
    }

    public function png($quality)
    {
        ob_start();
        imagealphablending($this->resource, false);
        imagesavealpha($this->resource, true);
        imagepng($this->resource, null, $quality);
        $data = ob_get_contents();
        ob_end_clean();

        header('Content-Type: image/png');
        header('Content-Length: ' . strlen($data));

        echo $data;
    }

    protected function getColor($code = null)
    {
        list($red, $green, $blue) = [255, 255, 255];

        if ($code)
        {
            $codes = str_split(substr($code, -6), 2);
            list($red, $green, $blue) = [hexdec($codes[0]), hexdec($codes[1]), hexdec($codes[2])];
        }

        return imagecolorallocate($this->resource, $red, $green, $blue);
    }

}
