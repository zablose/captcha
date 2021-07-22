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

    public static function selectAssetsDir(): string
    {
        if (is_dir(self::vendorAssetsDir())) {
            return self::vendorAssetsDir();
        }

        if (is_dir(self::publishedAssetsDir())) {
            return self::publishedAssetsDir();
        }

        return __DIR__.DIRECTORY_SEPARATOR.self::oneDirUp().'assets';
    }

    public static function oneDirUp(): string
    {
        return '..'.DIRECTORY_SEPARATOR;
    }

    public static function baseDir(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.self::oneDirUp().self::oneDirUp().self::oneDirUp();
    }

    public static function vendorAssetsDir(): string
    {
        return self::baseDir().Config::ASSETS_PATH;
    }

    public static function publishedAssetsDir(): string
    {
        return self::baseDir().'resources'.DIRECTORY_SEPARATOR.Config::ASSETS_PATH;
    }
}
