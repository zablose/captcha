<?php

declare(strict_types=1);

namespace Zablose\Captcha;

final class Config
{
    public const ASSETS_PATH = 'vendor'.DIRECTORY_SEPARATOR.'zablose'.DIRECTORY_SEPARATOR.'captcha'.DIRECTORY_SEPARATOR.'assets';
    public const CHARACTERS = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}';

    private string $assets_dir;
    private string $characters = self::CHARACTERS;
    private int $length = 5;
    private int $width = 160;
    private int $height = 60;

    /** Compression level: from 0 (no compression) to 9. */
    private int $compression = 9;

    private int $lines = 10;
    private bool $use_background_image = true;
    private string $background_color = Color::WHITE;
    private array $colors;
    private bool $sensitive = false;

    /** Between 0 and 100 */
    private int $sharpen = 0;

    /** Between 0 and 100 */
    private int $blur = 0;

    private bool $invert = false;

    /** Contrast level (-100 = max contrast, 0 = no change, +100 = min contrast) */
    private int $contrast = 0;

    private int $angle = 45;

    public function __construct(array $config)
    {
        $this->assets_dir = self::selectAssetsDir();
        $this->colors = Color::allButWhite();

        foreach ($config as $property_name => $value) {
            if (property_exists($this, $property_name)) {
                $this->{$this->makeSetterName($property_name)}($value);
            }
        }
    }

    private function makeSetterName(string $property_name): string
    {
        return 'set'.implode('', array_map('ucfirst', explode('_', $property_name)));
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
        $this->compression = $compression;

        return $this;
    }

    public function getLines(): int
    {
        return $this->lines;
    }

    public function setLines(int $lines): Config
    {
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
        $this->sharpen = $sharpen;

        return $this;
    }

    public function getBlur(): int
    {
        return $this->blur;
    }

    public function setBlur(int $blur): Config
    {
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
        $this->contrast = $contrast;

        return $this;
    }

    public function getAngle(): int
    {
        return $this->angle;
    }

    public function setAngle(int $angle): Config
    {
        $this->angle = $angle;

        return $this;
    }

    public static function selectAssetsDir(): string
    {
        $one_dir_up = '..'.DIRECTORY_SEPARATOR;
        $base_dir = __DIR__.DIRECTORY_SEPARATOR.$one_dir_up.$one_dir_up.$one_dir_up;

        $vendor_assets_dir = $base_dir.self::ASSETS_PATH;
        $published_assets_dir = $base_dir.'resources'.DIRECTORY_SEPARATOR.self::ASSETS_PATH;

        if (is_dir($vendor_assets_dir)) {
            return $vendor_assets_dir;
        }

        if (is_dir($published_assets_dir)) {
            return $published_assets_dir;
        }

        return __DIR__.DIRECTORY_SEPARATOR.$one_dir_up.'assets';
    }
}
