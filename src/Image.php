<?php declare(strict_types=1);

namespace Zablose\Captcha;

class Image
{
    public Config $config;

    /** @var resource */
    private $canvas;

    public function __construct(array $config)
    {
        $this->config = new Config($config);

        $this->config->use_background_image
            ? $this->createFromImage()->resize()
            : $this->createFromColor();
    }

    protected function createFromImage(): self
    {
        $this->canvas = imagecreatefrompng(
            Random::value(Directory::files($this->config->assets_dir.'backgrounds', '.png'))
        );

        return $this;
    }

    protected function createFromColor(): self
    {
        $this->canvas = imagecreatetruecolor($this->config->width, $this->config->height);
        imagefill($this->canvas, 0, 0, $this->getColor($this->config->background_color));

        return $this;
    }

    protected function resize(): self
    {
        $dst_w = $this->config->width;
        $dst_h = $this->config->height;
        $src_w = imagesx($this->canvas);
        $src_h = imagesy($this->canvas);

        if ($dst_w !== $src_w || $dst_h !== $src_w) {
            $dst_image = imagecreatetruecolor($dst_w, $dst_h);
            imagecopyresampled($dst_image, $this->canvas, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            $this->canvas = $dst_image;
        }

        return $this;
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

    public function addContrast(): self
    {
        if ($this->config->contrast <> 0) {
            imagefilter($this->canvas, IMG_FILTER_CONTRAST, $this->config->contrast);
        }

        return $this;
    }

    public function sharpen(): self
    {
        if ($this->config->sharpen) {
            $min = $this->config->sharpen >= 10 ? $this->config->sharpen * -0.01 : 0;
            $max = $this->config->sharpen * -0.025;
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

    public function invert(): self
    {
        if ($this->config->invert) {
            imagefilter($this->canvas, IMG_FILTER_NEGATE);
        }

        return $this;
    }

    public function blur(): self
    {
        for ($i = 0; $i < intval($this->config->blur); $i++) {
            imagefilter($this->canvas, IMG_FILTER_GAUSSIAN_BLUR);
        }

        return $this;
    }

    public function addText(
        int $left,
        int $space_x,
        int $space_y,
        string $text,
        string $font,
        int $size,
        string $color,
        int $angle
    ): self
    {
        $box = imagettfbbox($size, $angle, $font, $text);

        $min_x = min($box[0], $box[2], $box[4], $box[6]);
        $max_x = max($box[0], $box[2], $box[4], $box[6]);

        $min_y = min($box[1], $box[3], $box[5], $box[7]);
        $max_y = max($box[1], $box[3], $box[5], $box[7]);

        $width  = $max_x - $min_x;
        $height = $max_y - $min_y;

        $x = $left - $min_x + Random::margin($space_x, $width);
        $y = $space_y - $max_y - Random::margin($space_y, $height);

        imagettftext($this->canvas, $size, $angle, $x, $y, $this->getColor($color), $font, $text);

        return $this;
    }

    public function addRandomText(): string
    {
        $text  = '';
        $width = intval($this->config->width / $this->config->length);
        $fonts = Directory::files($this->config->assets_dir.'fonts', '.ttf');

        for ($i = 0; $i < $this->config->length; $i++) {
            $this->addText(
                $width * $i,
                $width,
                $this->config->height,
                $char = Random::char($this->config->characters),
                Random::value($fonts),
                Random::size($this->config->height),
                Random::value($this->config->colors),
                Random::angle($this->config->angle)
            );

            $text .= $char;
        }

        return $text;
    }

    public function addLine(int $x1, int $y1, int $x2, int $y2, string $color): self
    {
        imageline($this->canvas, $x1, $y1, $x2, $y2, $this->getColor($color));

        return $this;
    }

    public function addRandomLines(): self
    {
        for ($i = 0; $i < $this->config->lines; $i++) {
            $this->addLine(
                mt_rand(0, $this->config->width),
                mt_rand(0, $this->config->height),
                mt_rand(0, $this->config->width),
                mt_rand(0, $this->config->height),
                Random::value($this->config->colors)
            );
        }

        return $this;
    }

    public function png(): string
    {
        ob_start();
        imagepng($this->canvas, null, $this->config->compression);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }
}
