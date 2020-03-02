<?php declare(strict_types=1);

namespace Zablose\Captcha;

class Image
{
    /** @var resource */
    protected $canvas;

    protected int $width = 160;
    protected int $height = 60;
    protected string $path = '';
    protected string $background_color = '#ffffff';

    public function make(): self
    {
        return $this->path ? $this->load()->resize() : $this->create();
    }

    protected function load(): self
    {
        $this->canvas = @imagecreatefrompng($this->path);

        return $this;
    }

    protected function create(): self
    {
        $this->canvas = @imagecreatetruecolor($this->width, $this->height);
        imagefill($this->canvas, 0, 0, $this->getColor($this->background_color));

        return $this;
    }

    protected function resize(): self
    {
        $width  = imagesx($this->canvas);
        $height = imagesy($this->canvas);

        if ($this->width !== $width || $this->height !== $width) {
            $dst_image = imagecreatetruecolor($this->width, $this->height);
            imagecopyresampled($dst_image, $this->canvas, 0, 0, 0, 0, $this->width, $this->height, $width, $height);
            $this->canvas = $dst_image;
        }

        return $this;
    }

    /**
     * @param  int  $level  Contrast level (-100 = max contrast, 0 = no change, +100 = min contrast)
     *
     * @return $this
     */
    public function addContrast(int $level): self
    {
        if ($level <> 0) {
            imagefilter($this->canvas, IMG_FILTER_CONTRAST, $level);
        }

        return $this;
    }

    /**
     * @param  int  $amount  Between 0 and 100
     *
     * @return $this
     */
    public function sharpen(int $amount): self
    {
        if ($amount) {
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

    public function invert(bool $yes = false): self
    {
        if ($yes) {
            imagefilter($this->canvas, IMG_FILTER_NEGATE);
        }

        return $this;
    }

    /**
     * @param  int  $amount  Between 0 and 100
     *
     * @return $this
     */
    public function blur(int $amount): self
    {
        for ($i = 0; $i < intval($amount); $i++) {
            imagefilter($this->canvas, IMG_FILTER_GAUSSIAN_BLUR);
        }

        return $this;
    }

    public function addText(string $text, int $x, int $y, string $font, int $size, string $color, int $angle): self
    {
        $box = imagettfbbox($this->getFontPoints($size), $angle, $font, $text);

        $x = $x - min($box[0], $box[6]);
        $y = $y - max($box[1], $box[3]);

        imagettftext($this->canvas, $this->getFontPoints($size), $angle, $x, $y, $this->getColor($color), $font, $text);

        return $this;
    }

    public function getFontPoints(int $size): int
    {
        return intval(ceil($size * 0.75));
    }

    public function addLine(int $x1, int $y1, int $x2, int $y2, string $color): self
    {
        imageline($this->canvas, $x1, $y1, $x2, $y2, $this->getColor($color));

        return $this;
    }

    public function png(int $compression): string
    {
        ob_start();
        imagepng($this->canvas, null, $compression);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }

    protected function getColor(string $code = ''): int
    {
        [$red, $green, $blue] = [255, 255, 255];

        if ($code) {
            $codes = str_split(substr($code, -6), 2);
            [$red, $green, $blue] = [hexdec($codes[0]), hexdec($codes[1]), hexdec($codes[2])];
        }

        return imagecolorallocate($this->canvas, $red, $green, $blue);
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function setBackgroundColor(string $code): self
    {
        $this->background_color = $code;

        return $this;
    }
}
