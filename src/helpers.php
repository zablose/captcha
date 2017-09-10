<?php

if (! function_exists('captcha_src'))
{
    /**
     * Generate url of the captcha image source.
     *
     * @param string $config_name
     *
     * @return string
     */
    function captcha_url($config_name = 'default')
    {
        return app('captcha')->url($config_name);
    }
}
