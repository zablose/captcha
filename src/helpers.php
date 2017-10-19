<?php

if (! function_exists('captcha_url'))
{
    /**
     * Generate url of the captcha image source.
     *
     * @param string $type
     *
     * @return string
     */
    function captcha_url($type = 'default')
    {
        return url('/captcha/' . $type) . '/' . \Zablose\Captcha\Random::string(12);
    }
}
