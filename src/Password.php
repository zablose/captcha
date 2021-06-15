<?php

declare(strict_types=1);

namespace Zablose\Captcha;

final class Password
{
    public static function hash(string $password, bool $sensitive = false): string
    {
        return password_hash($sensitive ? $password : strtolower($password), PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hash, bool $sensitive = false): bool
    {
        return password_verify($sensitive ? $password : strtolower($password), $hash);
    }
}
