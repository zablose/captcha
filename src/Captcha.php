<?php

namespace Zablose\Captcha;

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
    protected $font;

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
     * Get Captcha as a string.
     *
     * @return string
     */
    public function txt()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function hash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function png()
    {
        return $this->image->png($this->config->quality);
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
        $image = (new Image())->setWidth($this->config->width)->setHeight($this->config->height);

        $this->image = $this->config->use_background_image
            ? $image->setPath($this->background())->make()
            : $image->setBackgroundColor($this->config->background_color)->make();

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
     * @param int    $x
     *
     * @return $this
     */
    private function char($char, $x)
    {
        $this->config->randomizeSize();

        $this->image->text(
            $char,
            $x + $this->getCharWidthMargin(),
            $this->config->height - $this->getCharHeightMargin(),
            $this->randomizeFont()->getFont(),
            $this->config->getSize(),
            $this->config->randomizeColor()->getColor(),
            $this->config->randomizeAngle()->getAngle()
        );

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
     * @return $this
     */
    private function randomizeFont()
    {
        $this->font = $this->fonts[array_rand($this->fonts)];

        return $this;
    }

    /**
     * Get random image font path from the list.
     *
     * @return string
     */
    private function getFont()
    {
        return $this->font;
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
        $this->image->line(
            mt_rand(0, $this->config->width),
            mt_rand(0, $this->config->height),
            mt_rand(0, $this->config->width),
            mt_rand(0, $this->config->height),
            $this->config->randomizeColor()->getColor()
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
        $x = 0;

        $captcha = '';
        for ($i = 0; $i < $this->config->length; $i++)
        {
            $char = Random::char($this->config->characters);
            $this->char($char, $x);
            $x       += $this->getCharWidth();
            $captcha .= $char;
        }

        $this->text = $captcha;

        $this->hash = password_hash($this->config->sensitive ? $captcha : strtolower($captcha), PASSWORD_BCRYPT);

        return $this;
    }

    protected function getCharHeightMargin()
    {
        return mt_rand(0, $this->config->height - $this->config->getSize());
    }

    protected function getCharWidthMargin()
    {
        return $this->getCharWidth() > $this->config->getSize()
            ? mt_rand(0, (int) ($this->getCharWidth() - $this->config->getSize()) / 2)
            : 0;
    }

    protected function getCharWidth()
    {
        return (int) $this->config->width / $this->config->length;
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
