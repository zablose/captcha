<?php declare(strict_types=1);

namespace Zablose\Captcha;

class Captcha
{
    private Config $config;
    private Image $image;
    private array $backgrounds = [];
    private array $fonts = [];
    private string $text = '';

    public function __construct(array $config = [])
    {
        $this->configure($config)->loadBackgrounds()->loadFonts()->setImage()->addText()->addLines();

        $this->image
            ->addContrast($this->config->contrast)
            ->sharpen($this->config->sharpen)
            ->invert($this->config->invert)
            ->blur($this->config->blur);
    }

    private function configure(array $config): self
    {
        $this->config = new Config($config);

        return $this;
    }

    private function setImage(): self
    {
        $image = (new Image())->setWidth($this->config->width)->setHeight($this->config->height);

        $this->image = $this->config->use_background_image
            ? $image->setPath(Random::value($this->backgrounds))->make()
            : $image->setBackgroundColor($this->config->background_color)->make();

        return $this;
    }

    private function addText(): self
    {
        $width = intval($this->config->width / $this->config->length);

        $this->text = '';

        for ($i = 0; $i < $this->config->length; $i++) {
            $this->image->addText(
                $width * $i,
                $width,
                $this->config->height,
                $char = Random::char($this->config->characters),
                Random::value($this->fonts),
                Random::size($this->config->height),
                Random::value($this->config->colors),
                Random::angle($this->config->angle)
            );

            $this->text .= $char;
        }

        return $this;
    }

    private function addLines(): self
    {
        for ($i = 0; $i < $this->config->lines; $i++) {
            $this->image->addLine(
                mt_rand(0, $this->config->width),
                mt_rand(0, $this->config->height),
                mt_rand(0, $this->config->width),
                mt_rand(0, $this->config->height),
                Random::value($this->config->colors)
            );
        }

        return $this;
    }

    private function loadBackgrounds(): self
    {
        $this->backgrounds = $this->getFiles($this->config->assets_dir.'backgrounds', '.png');

        return $this;
    }

    private function loadFonts(): self
    {
        $this->fonts = $this->getFiles($this->config->assets_dir.'fonts', '.ttf');

        return $this;
    }

    private function getFiles(string $path, string $extension): array
    {
        $files = [];

        foreach (scandir($path) as $key => $item) {
            if (stripos($item, $extension) > 1) {
                $files[] = $path.'/'.$item;
            }
        }

        return $files;
    }

    public function sensitive(): bool
    {
        return $this->config->sensitive;
    }

    public function txt(): string
    {
        return $this->text;
    }

    public function hash(): string
    {
        return password_hash($this->config->sensitive ? $this->text : strtolower($this->text), PASSWORD_BCRYPT);
    }

    public function png(): string
    {
        return $this->image->png($this->config->compression);
    }

    public static function check(bool $sensitive, string $captcha, string $hash): bool
    {
        return password_verify($sensitive ? $captcha : strtolower($captcha), $hash);
    }
}
