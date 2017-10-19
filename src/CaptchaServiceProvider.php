<?php

namespace Zablose\Captcha;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Session;

class CaptchaServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/captcha.php' => config_path('captcha.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        /** @var Validator $validator */
        $validator = $this->app['validator'];
        $validator->extend(
            'captcha',
            function ($attribute, $value, $parameters)
            {
                if (! Session::has('captcha'))
                {
                    return false;
                }

                $sensitive = Session::get('captcha.sensitive');
                $key       = Session::get('captcha.key');

                Session::remove('captcha');

                return password_verify($sensitive ? $value : strtolower($value), $key);
            },
            'The :attribute does not match.'
        );

        require_once __DIR__ . '/helpers.php';
    }

}
