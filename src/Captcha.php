<?php

declare(strict_types=1);

namespace Zablose\Captcha;

final class Captcha
{
    private Image $image;

    public function __construct(array $config = [])
    {
        $this->image = new Image($config);
    }

    public function isSensitive(): bool
    {
        return $this->image->config->isSensitive();
    }

    public function getCode(): string
    {
        return $this->image->getText();
    }

    public function hash(): string
    {
        return Password::hash($this->getCode(), $this->isSensitive());
    }

    public static function verify(string $captcha, string $hash, bool $sensitive = false): bool
    {
        return Password::verify($captcha, $hash, $sensitive);
    }

    public function toPng(): string
    {
        return $this->image->toPng();
    }
}
