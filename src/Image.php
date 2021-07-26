<?php

declare(strict_types=1);

namespace Zablose\Captcha;

use GdImage;

final class Image
{
    public Config $config;
    private GdImage $canvas;
    private string $text;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    private function setCanvas(): self
    {
        $this->config->isUseBackgroundImage()
            ? $this->setCanvasFromPng()->resize()
            : $this->setCanvasFromColor();

        return $this;
    }

    private function setCanvasFromPng(): self
    {
        $this->canvas = imagecreatefrompng(
            Random::value(Directory::files($this->config->getAssetsDir().DIRECTORY_SEPARATOR.'backgrounds', '.png'))
        );

        return $this;
    }

    private function resize(): void
    {
        $dst_w = $this->config->getWidth();
        $dst_h = $this->config->getHeight();
        $src_w = imagesx($this->canvas);
        $src_h = imagesy($this->canvas);

        if ($dst_w !== $src_w || $dst_h !== $src_w) {
            $dst_image = imagecreatetruecolor($dst_w, $dst_h);
            imagecopyresampled($dst_image, $this->canvas, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            $this->canvas = $dst_image;
        }
    }

    private function setCanvasFromColor(): void
    {
        $this->canvas = imagecreatetruecolor($this->config->getWidth(), $this->config->getHeight());
        imagefill($this->canvas, 0, 0, $this->getColor($this->config->getBackgroundColor()));
    }

    private function getColor(string $code = ''): int
    {
        [$red, $green, $blue] = [255, 255, 255];

        if ($code) {
            $codes = str_split(substr($code, -6), 2);
            [$red, $green, $blue] = [hexdec($codes[0]), hexdec($codes[1]), hexdec($codes[2])];
        }

        return imagecolorallocate($this->canvas, $red, $green, $blue);
    }

    private function addText(
        int $left,
        int $space_x,
        int $space_y,
        string $text,
        string $font,
        int $size,
        string $color,
        int $angle
    ): void {
        $box = imagettfbbox($size, $angle, $font, $text);

        $min_x = min($box[0], $box[2], $box[4], $box[6]);
        $max_x = max($box[0], $box[2], $box[4], $box[6]);

        $min_y = min($box[1], $box[3], $box[5], $box[7]);
        $max_y = max($box[1], $box[3], $box[5], $box[7]);

        $width = $max_x - $min_x;
        $height = $max_y - $min_y;

        $x = $left - $min_x + Random::margin($space_x, $width);
        $y = $space_y - $max_y - Random::margin($space_y, $height);

        imagettftext($this->canvas, $size, $angle, $x, $y, $this->getColor($color), $font, $text);
    }

    private function addRandomText(): self
    {
        $this->text = '';
        $width = intval($this->config->getWidth() / $this->config->getLength());
        $fonts = Directory::files($this->config->getAssetsDir().DIRECTORY_SEPARATOR.'fonts', '.ttf');

        for ($i = 0; $i < $this->config->getLength(); $i++) {
            $this->addText(
                $width * $i,
                $width,
                $this->config->getHeight(),
                $char = Random::char($this->config->getCharacters()),
                Random::value($fonts),
                Random::size($this->config->getHeight()),
                Random::value($this->config->getColors()),
                Random::angle($this->config->getAngle())
            );

            $this->text .= $char;
        }

        return $this;
    }

    private function addRandomLines(): self
    {
        for ($i = 0; $i < $this->config->getLines(); $i++) {
            imageline(
                $this->canvas,
                Random::number($this->config->getWidth()),
                Random::number($this->config->getHeight()),
                Random::number($this->config->getWidth()),
                Random::number($this->config->getHeight()),
                $this->getColor(
                    Random::value($this->config->getColors())
                )
            );
        }

        return $this;
    }

    private function addContrast(): self
    {
        if ($this->config->getContrast() <> 0) {
            imagefilter($this->canvas, IMG_FILTER_CONTRAST, $this->config->getContrast());
        }

        return $this;
    }

    private function addSharpness(): self
    {
        if ($this->config->getSharpness() > Config::SHARPNESS_NO_CHANGE) {
            $min = $this->config->getSharpness() >= 10 ? $this->config->getSharpness() * -0.01 : 0;
            $max = $this->config->getSharpness() * -0.025;
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

    private function addInversion(): self
    {
        if ($this->config->isInvert()) {
            imagefilter($this->canvas, IMG_FILTER_NEGATE);
        }

        return $this;
    }

    private function addBlur(): self
    {
        for ($i = 0; $i < $this->config->getBlur(); $i++) {
            imagefilter($this->canvas, IMG_FILTER_GAUSSIAN_BLUR);
        }

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function make(): self
    {
        $this->setCanvas()->addRandomText()->addRandomLines()->addContrast()->addSharpness()->addInversion()->addBlur();

        return $this;
    }

    public function toPng(): string
    {
        ob_start();
        imagepng($this->canvas, null, $this->config->getCompression());
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }
}
