<?php declare(strict_types=1);

namespace Zablose\Captcha;

final class Config
{
    public string $assets_dir = __DIR__.'/../assets/';
    public string $characters = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ@#~!?<>{}';
    public int $length = 5;
    public int $width = 160;
    public int $height = 60;

    /** Compression level: from 0 (no compression) to 9. */
    public int $compression = 9;

    public int $lines = 10;
    public bool $use_background_image = true;
    public string $background_color = '#FFFFFF';
    public array $colors = [
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
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
