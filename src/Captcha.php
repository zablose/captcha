<?php declare(strict_types=1);

namespace Zablose\Captcha;

class Captcha
{
    private Image $image;
    private string $text;

    public function __construct(array $config = [])
    {
        $this->image = new Image($config);
        $this->text  = $this->image->addRandomText();
    }

    public function sensitive(): bool
    {
        return $this->image->config->sensitive;
    }

    public function txt(): string
    {
        return $this->text;
    }

    public function hash(): string
    {
        return password_hash($this->sensitive() ? $this->text : strtolower($this->text), PASSWORD_BCRYPT);
    }

    public static function check(bool $sensitive, string $captcha, string $hash): bool
    {
        return password_verify($sensitive ? $captcha : strtolower($captcha), $hash);
    }

    public function png(): string
    {
        return $this->image->addRandomLines()->addContrast()->sharpen()->invert()->blur()->png();
    }
}
