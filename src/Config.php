<?php

declare(strict_types=1);

namespace Zablose\Captcha;

use Zablose\Captcha\Exception\HeightIsOutOfRangeException;
use Zablose\Captcha\Exception\LengthIsOutOfRangeException;
use Zablose\Captcha\Exception\RatioIsOutOfRangeException;
use Zablose\Captcha\Exception\RotationAngleIsOutOfRangeException;
use Zablose\Captcha\Exception\BlurIsOutOfRangeException;
use Zablose\Captcha\Exception\CompressionIsOutOfRangeException;
use Zablose\Captcha\Exception\ContrastIsOutOfRangeException;
use Zablose\Captcha\Exception\LinesIsOutOfRangeException;
use Zablose\Captcha\Exception\SharpnessIsOutOfRangeException;
use Zablose\Captcha\Exception\WidthIsOutOfRangeException;

final class Config
{
    public const ASSETS_PATH = 'vendor'.DIRECTORY_SEPARATOR.'zablose'.DIRECTORY_SEPARATOR.'captcha'.DIRECTORY_SEPARATOR.'assets';
    public const CHARACTERS = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}';

    public const CONTRAST_MAX = -100;
    public const CONTRAST_NO_CHANGE = 0;
    public const CONTRAST_MIN = 100;

    public const BLUR_NO_CHANGE = 0;
    public const BLUR_MAX = 5;

    public const SHARPNESS_NO_CHANGE = 0;
    public const SHARPNESS_MAX = 100;

    public const COMPRESSION_NONE = 0;
    public const COMPRESSION_MAX = 9;

    public const ROTATION_ANGLE_NO_CHANGE = 0;
    public const ROTATION_ANGLE_MAX = 60;

    public const LINES_NONE = 0;

    public const LENGTH_MIN = 1;
    public const LENGTH_DEFAULT = 5;
    public const WIDTH_MIN = 8;
    public const WIDTH_DEFAULT = 160;
    public const HEIGHT_MIN = 16;
    public const HEIGHT_DEFAULT = 60;

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
    private int $sharpness = self::SHARPNESS_NO_CHANGE;
    private int $blur = self::BLUR_NO_CHANGE;
    private bool $invert = false;
    private int $contrast = self::CONTRAST_NO_CHANGE;
    private int $rotation_angle = self::ROTATION_ANGLE_MAX;

    public function __construct()
    {
        $this->assets_dir = Assets::dir();
        $this->colors = Color::allButWhite();
    }

    public function getAssetsDir(): string
    {
        return $this->assets_dir;
    }

    public function getCharacters(): string
    {
        return $this->characters;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getCompression(): int
    {
        return $this->compression;
    }

    public function getLines(): int
    {
        return $this->lines;
    }

    public function isUseBackgroundImage(): bool
    {
        return $this->use_background_image;
    }

    public function getBackgroundColor(): string
    {
        return $this->background_color;
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function isSensitive(): bool
    {
        return $this->sensitive;
    }

    public function getSharpness(): int
    {
        return $this->sharpness;
    }

    public function getBlur(): int
    {
        return $this->blur;
    }

    public function isInvert(): bool
    {
        return $this->invert;
    }

    public function getContrast(): int
    {
        return $this->contrast;
    }

    public function getRotationAngle(): int
    {
        return $this->rotation_angle;
    }

    public function update(array $config): self
    {
        foreach ($config as $property_name => $value) {
            if (property_exists($this, $property_name)) {
                $this->$property_name = $value;
            }
        }

        return $this;
    }

    /**
     * Do NOT use on production, meant to be used within app tests.
     *
     * There is no reason to validate config every time captcha is generated,
     * unless, config is changed dynamically.
     */
    public function validate(): self
    {
        if ($this->length < self::LENGTH_MIN) {
            throw new LengthIsOutOfRangeException();
        }

        if ($this->width < self::WIDTH_MIN) {
            throw new WidthIsOutOfRangeException();
        }

        if ($this->height < self::HEIGHT_MIN) {
            throw new HeightIsOutOfRangeException();
        }

        if ($this->currentRatio() > $this->maxRatio()) {
            throw new RatioIsOutOfRangeException();
        }

        if ($this->compression < self::COMPRESSION_NONE || $this->compression > self::COMPRESSION_MAX) {
            throw new CompressionIsOutOfRangeException();
        }

        if ($this->lines < self::LINES_NONE) {
            throw new LinesIsOutOfRangeException();
        }

        if ($this->sharpness < self::SHARPNESS_NO_CHANGE || $this->sharpness > self::SHARPNESS_MAX) {
            throw new SharpnessIsOutOfRangeException();
        }

        if ($this->blur < self::BLUR_NO_CHANGE || $this->blur > self::BLUR_MAX) {
            throw new BlurIsOutOfRangeException();
        }

        if ($this->contrast > self::CONTRAST_MIN || $this->contrast < self::CONTRAST_MAX) {
            throw new ContrastIsOutOfRangeException();
        }

        if ($this->rotation_angle < self::ROTATION_ANGLE_NO_CHANGE || $this->rotation_angle > self::ROTATION_ANGLE_MAX) {
            throw new RotationAngleIsOutOfRangeException();
        }

        return $this;
    }

    private function currentRatio(): float
    {
        return $this->height / ($this->width / $this->length);
    }

    private function maxRatio(): float
    {
        return self::HEIGHT_MIN / self::WIDTH_MIN;
    }
}
