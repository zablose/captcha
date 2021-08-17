<?php

declare(strict_types=1);

namespace Zablose\Captcha;

class Assets
{
    public static function dir(): string
    {
        if (is_dir(Assets::vendorDir())) {
            return Assets::vendorDir();
        }

        if (is_dir(Assets::publishedDir())) {
            return Assets::publishedDir();
        }

        return Assets::defaultDir();
    }

    public static function vendorDir(): string
    {
        return Directory::appRoot().Config::ASSETS_PATH;
    }

    public static function publishedDir(): string
    {
        return Directory::appRoot().'resources'.DIRECTORY_SEPARATOR.Config::ASSETS_PATH;
    }

    public static function defaultDir(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.Directory::up().'assets';
    }
}
