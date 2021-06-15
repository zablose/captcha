<?php

declare(strict_types=1);

namespace Zablose\Captcha;

final class Directory
{
    public static function files(string $path, string $extension): array
    {
        $files = [];

        foreach (scandir($path) as $item) {
            if (stripos($item, $extension) > 1) {
                $files[] = $path.DIRECTORY_SEPARATOR.$item;
            }
        }

        return $files;
    }
}
