<?php

namespace Zablose\Captcha;

class Captcha
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Image
     */
    private $image;

    /**
     * @var array
     */
    private $backgrounds = [];

    /**
     * @var array
     */
    private $fonts = [];

    /**
     * @var string
     */
    private $font;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var int
     */
    private $angle = 0;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $color;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->configure($config)->loadBackgrounds()->loadFonts()->setImage()->addText()->addLines();

        $this->image
            ->addContrast($this->config->contrast)
            ->sharpen($this->config->sharpen)
            ->invert($this->config->invert)
            ->blur($this->config->blur);
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
        $this->config = new Config($config);

        return $this;
    }

    /**
     * Create base image for captcha.
     *
     * @return $this
     */
    private function setImage()
    {
        $image = (new Image())->setWidth($this->config->width)->setHeight($this->config->height);

        $this->image = $this->config->use_background_image
            ? $image->setPath(Random::value($this->backgrounds))->make()
            : $image->setBackgroundColor($this->config->background_color)->make();

        return $this;
    }

    /**
     * @return $this
     */
    private function addText()
    {
        $x = 0;

        $this->text = '';
        for ($i = 0; $i < $this->config->length; $i++)
        {
            $this->font  = Random::value($this->fonts);
            $this->size  = Random::size($this->config->height);
            $this->color = Random::value($this->config->colors);
            $this->angle = Random::angle($this->config->angle);

            $this->image->addText(
                $char = Random::char($this->config->characters),
                $x + $this->getCharWidthMargin(),
                $this->config->height - $this->getCharHeightMargin(),
                $this->font,
                $this->size,
                $this->color,
                $this->angle
            );

            $this->text .= $char;

            $x += $this->getCharWidth();
        }

        $this->hash = password_hash($this->config->sensitive ? $this->text : strtolower($this->text), PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Add random lines to the image.
     *
     * @return $this
     */
    private function addLines()
    {
        for ($i = 0; $i < $this->config->lines; $i++)
        {
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

    /**
     * Load backgrounds.
     *
     * @return $this
     */
    private function loadBackgrounds()
    {
        $this->backgrounds = $this->getFiles($this->config->assets_dir . 'backgrounds', '.png');

        return $this;
    }

    /**
     * Load fonts.
     *
     * @return $this
     */
    private function loadFonts()
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
     * @return int
     */
    private function getCharWidth()
    {
        return (int) $this->config->width / $this->config->length;
    }

    /**
     * @return int
     */
    private function getCharWidthMargin()
    {
        return $this->getCharWidth() > $this->size
            ? mt_rand(0, (int) ($this->getCharWidth() - $this->size) / 2)
            : 0;
    }

    /**
     * @return int
     */
    private function getCharHeightMargin()
    {
        return mt_rand(0, $this->config->height - $this->size);
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
        return $this->image->png($this->config->compression);
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
