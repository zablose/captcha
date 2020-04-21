<?php declare(strict_types=1);

namespace Zablose\Captcha;

class Directory
{
    public static function files(string $path, string $extension): array
    {
        $files = [];

        foreach (scandir($path) as $key => $item) {
            if (stripos($item, $extension) > 1) {
                $files[] = $path.'/'.$item;
            }
        }

        return $files;
    }
}
