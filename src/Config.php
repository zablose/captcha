<?php

declare(strict_types=1);

namespace Zablose\Captcha;

use Zablose\Captcha\Exception\AngleIsOutOfRangeException;
use Zablose\Captcha\Exception\BlurIsOutOfRangeException;
use Zablose\Captcha\Exception\CompressionIsOutOfRangeException;
use Zablose\Captcha\Exception\ContrastIsOutOfRangeException;
use Zablose\Captcha\Exception\LinesIsOutOfRangeException;
use Zablose\Captcha\Exception\SharpenIsOutOfRangeException;

final class Config
{
    public const ASSETS_PATH = 'vendor'.DIRECTORY_SEPARATOR.'zablose'.DIRECTORY_SEPARATOR.'captcha'.DIRECTORY_SEPARATOR.'assets';
    public const CHARACTERS = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}';

    public const CONTRAST_MAX = -100;
    public const CONTRAST_NO_CHANGE = 0;
    public const CONTRAST_MIN = 100;

    public const BLUR_NO_CHANGE = 0;
    public const BLUR_MAX = 5;

    public const SHARPEN_NO_CHANGE = 0;
    public const SHARPEN_MAX = 100;

    public const COMPRESSION_NONE = 0;
    public const COMPRESSION_MAX = 9;

    public const ANGLE_NO_ROTATION = 0;
    public const ANGLE_MAX = 60;

    public const LINES_NONE = 0;

    private string $assets_dir;
    private string $characters = self::CHARACTERS;
    private int $length = 5;
    private int $width = 160;
    private int $height = 60;
    private int $compression = self::COMPRESSION_MAX;
    private int $lines = 10;
    private bool $use_background_image = true;
    private string $background_color = Color::WHITE;
    private array $colors;
    private bool $sensitive = false;
    private int $sharpen = self::SHARPEN_NO_CHANGE;
    private int $blur = self::BLUR_NO_CHANGE;
    private bool $invert = false;
    private int $contrast = self::CONTRAST_NO_CHANGE;
    private int $angle = self::ANGLE_MAX;

    public function __construct()
    {
        $this->assets_dir = Assets::dir();
        $this->colors = Color::allButWhite();
    }

    private function makeSetterName(string $property_name): string
    {
        return 'set'.implode('', array_map('ucfirst', explode('_', $property_name)));
    }

    public function load(array $config): Config
    {
        foreach ($config as $property_name => $value) {
            if (property_exists($this, $property_name)) {
                $this->{$this->makeSetterName($property_name)}($value);
            }
        }

        return $this;
    }

    public function getAssetsDir(): string
    {
        return $this->assets_dir;
    }

    public function setAssetsDir(string $assets_dir): Config
    {
        $this->assets_dir = $assets_dir;

        return $this;
    }

    public function getCharacters(): string
    {
        return $this->characters;
    }

    public function setCharacters(string $characters): Config
    {
        $this->characters = $characters;

        return $this;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): Config
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): Config
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): Config
    {
        $this->height = $height;

        return $this;
    }

    public function getCompression(): int
    {
        return $this->compression;
    }

    public function setCompression(int $compression): Config
    {
        if ($compression < self::COMPRESSION_NONE || $compression > self::COMPRESSION_MAX) {
            throw new CompressionIsOutOfRangeException();
        }

        $this->compression = $compression;

        return $this;
    }

    public function getLines(): int
    {
        return $this->lines;
    }

    public function setLines(int $lines): Config
    {
        if ($lines < self::LINES_NONE) {
            throw new LinesIsOutOfRangeException();
        }

        $this->lines = $lines;

        return $this;
    }

    public function isUseBackgroundImage(): bool
    {
        return $this->use_background_image;
    }

    public function setUseBackgroundImage(bool $use_background_image): Config
    {
        $this->use_background_image = $use_background_image;

        return $this;
    }

    public function getBackgroundColor(): string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): Config
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function setColors(array $colors): Config
    {
        $this->colors = $colors;

        return $this;
    }

    public function isSensitive(): bool
    {
        return $this->sensitive;
    }

    public function setSensitive(bool $sensitive): Config
    {
        $this->sensitive = $sensitive;

        return $this;
    }

    public function getSharpen(): int
    {
        return $this->sharpen;
    }

    public function setSharpen(int $sharpen): Config
    {
        if ($sharpen < self::SHARPEN_NO_CHANGE || $sharpen > self::SHARPEN_MAX) {
            throw new SharpenIsOutOfRangeException();
        }

        $this->sharpen = $sharpen;

        return $this;
    }

    public function getBlur(): int
    {
        return $this->blur;
    }

    public function setBlur(int $blur): Config
    {
        if ($blur < self::BLUR_NO_CHANGE || $blur > self::BLUR_MAX) {
            throw new BlurIsOutOfRangeException();
        }

        $this->blur = $blur;

        return $this;
    }

    public function isInvert(): bool
    {
        return $this->invert;
    }

    public function setInvert(bool $invert): Config
    {
        $this->invert = $invert;

        return $this;
    }

    public function getContrast(): int
    {
        return $this->contrast;
    }

    public function setContrast(int $contrast): Config
    {
        if ($contrast > self::CONTRAST_MIN || $contrast < self::CONTRAST_MAX) {
            throw new ContrastIsOutOfRangeException();
        }

        $this->contrast = $contrast;

        return $this;
    }

    public function getAngle(): int
    {
        return $this->angle;
    }

    public function setAngle(int $angle): Config
    {
        if ($angle < self::ANGLE_NO_ROTATION || $angle > self::ANGLE_MAX) {
            throw new AngleIsOutOfRangeException();
        }

        $this->angle = $angle;

        return $this;
    }
}
