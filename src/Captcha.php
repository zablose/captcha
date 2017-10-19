<?php

namespace Zablose\Captcha;

use Intervention\Image\AbstractFont;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class Captcha
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var array
     */
    protected $backgrounds = [];

    /**
     * @var array
     */
    protected $fonts = [];

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $hash;

    /**
     * Create captcha image
     *
     * @param array $config
     *
     * @return $this
     */
    public function create($config = [])
    {
        return $this
            ->configure($config)->backgrounds()->fonts()
            ->image()->contrast()->generate()->lines()->sharpen()->invert()->blur();
    }

    /**
     * @return bool
     */
    public function sensitive()
    {
        return $this->config->sensitive;
    }

    /**
     * @return string
     */
    public function hash()
    {
        return $this->hash;
    }

    /**
     * @return mixed
     */
    public function png()
    {
        return $this->image->response('png', $this->config->quality);
    }

    /**
     * Apply configuration from the file, if present.
     *
     * @param array $config
     *
     * @return $this
     */
    private function configure($config)
    {
        $this->config = (new Config())->apply($config);

        return $this;
    }

    /**
     * Create base image for captcha.
     *
     * @return $this
     */
    private function image()
    {
        $image_manager = new ImageManager();

        $this->image = $this->config->use_background_image
            ? $image_manager->make($this->background())->resize(
                $this->config->width,
                $this->config->height
            )
            : $image_manager->canvas(
                $this->config->width,
                $this->config->height,
                $this->config->background_color
            );

        return $this;
    }

    /**
     * @return $this
     */
    private function contrast()
    {
        if ($this->config->contrast <> 0)
        {
            $this->image->contrast($this->config->contrast);
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function sharpen()
    {
        if ($this->config->sharpen)
        {
            $this->image->sharpen($this->config->sharpen);
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function invert()
    {
        if ($this->config->invert)
        {
            $this->image->invert();
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function blur()
    {
        if ($this->config->blur)
        {
            $this->image->blur($this->config->blur);
        }

        return $this;
    }

    /**
     * Add char to the image.
     *
     * @param string $char
     * @param int    $margin_left
     *
     * @return $this
     */
    private function char($char, $margin_left)
    {
        $size       = $this->config->size();
        $margin_top = mt_rand(1, (int) ($this->config->height - $size) * 1.25);

        $this->image->text($char, $margin_left, $margin_top, function (AbstractFont $font) use ($size)
        {
            $font->file($this->font());
            $font->size($size);
            $font->color($this->config->color());
            $font->valign('top');
            $font->angle($this->config->angle());
        });

        return $this;
    }

    /**
     * Get random image background path from the list.
     *
     * @return string
     */
    private function background()
    {
        return $this->backgrounds[array_rand($this->backgrounds)];
    }

    /**
     * Get random image font path from the list.
     *
     * @return string
     */
    private function font()
    {
        return $this->fonts[array_rand($this->fonts)];
    }

    /**
     * Add random lines to the image.
     *
     * @return $this
     */
    private function lines()
    {
        for ($i = 0; $i < $this->config->lines; $i++)
        {
            $this->line();
        }

        return $this;
    }

    /**
     * Add random line to the image.
     *
     * @return $this
     */
    private function line()
    {
        $half_width  = (int) $this->config->width / 2;
        $half_height = (int) $this->config->height / 2;

        $this->image->line(
            mt_rand(0, $half_width),
            mt_rand(0, $half_height),
            mt_rand($half_width, $this->config->width),
            mt_rand($half_height, $this->config->height),
            function ($draw)
            {
                $draw->color($this->config->color());
            }
        );

        return $this;
    }

    /**
     * Load backgrounds.
     *
     * @return $this
     */
    private function backgrounds()
    {
        $this->backgrounds = $this->getFiles($this->config->assets_dir . 'backgrounds', '.png');

        return $this;
    }

    /**
     * Load fonts.
     *
     * @return $this
     */
    private function fonts()
    {
        $this->fonts = $this->getFiles($this->config->assets_dir . 'fonts', '.ttf');

        return $this;
    }

    /**
     * Get files from the directory by extension.
     *
     * @param string $path
     * @param string $extension
     *
     * @return string[]
     */
    private function getFiles($path, $extension)
    {
        $files = [];

        foreach (scandir($path) as $key => $item)
        {
            if (stripos($item, $extension) > 1)
            {
                $files[] = $path . '/' . $item;
            }
        }

        return $files;
    }

    /**
     * @return $this
     */
    private function generate()
    {
        $margin_left = (int) $this->config->width / $this->config->length * 0.02;
        $width       = $this->config->width / $this->config->length;

        $captcha = '';
        for ($i = 0; $i < $this->config->length; $i++)
        {
            $char = Random::char($this->config->characters);
            $this->char($char, $margin_left);
            $margin_left += (int) $width * mt_rand(90, 100) / 100;
            $captcha     .= $char;
        }

        $this->text = $captcha;

        $this->hash = password_hash($this->config->sensitive ? $captcha : strtolower($captcha), PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * @param bool   $sensitive
     * @param string $captcha
     * @param string $hash
     *
     * @return bool
     */
    public static function check($sensitive, $captcha, $hash)
    {
        return password_verify($sensitive ? $captcha : strtolower($captcha), $hash);
    }

}
