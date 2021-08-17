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

    public static function up(int $levels = 1): string
    {
        return str_repeat('..'.DIRECTORY_SEPARATOR, $levels);
    }

    public static function appRoot(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.self::up(3);
    }
}
