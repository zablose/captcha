<?php

declare(strict_types=1);

namespace Zablose\Captcha;

final class Config
{
    public const ASSETS_PATH = 'vendor'.DIRECTORY_SEPARATOR.'zablose'.DIRECTORY_SEPARATOR.'captcha'.DIRECTORY_SEPARATOR.'assets';
    public const CHARACTERS = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}';

    public string $assets_dir;
    public string $characters = self::CHARACTERS;
    public int $length = 5;
    public int $width = 160;
    public int $height = 60;

    /** Compression level: from 0 (no compression) to 9. */
    public int $compression = 9;

    public int $lines = 10;
    public bool $use_background_image = true;
    public string $background_color = Color::WHITE;
    public array $colors;
    public bool $sensitive = false;

    /** Between 0 and 100 */
    public int $sharpen = 0;

    /** Between 0 and 100 */
    public int $blur = 0;

    public bool $invert = false;

    /** Contrast level (-100 = max contrast, 0 = no change, +100 = min contrast) */
    public int $contrast = 0;

    public int $angle = 45;

    public function __construct(array $config)
    {
        $this->assets_dir = self::getAssetsDir();
        $this->colors = Color::allButWhite();

        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function getAssetsDir(): string
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
