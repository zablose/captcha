<?php

namespace Zablose\Captcha;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class CaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/captcha.php', 'captcha');

        require __DIR__.'/../helpers.php';
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/captcha.php' => config_path('captcha.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/../routes/captcha.php');

        /** @var Validator $validator */
        $validator = $this->app['validator'];
        $validator->extend(
            'captcha',
            function ($attribute, $captcha, $parameters)
            {
                if (! Session::has('captcha')) {
                    return false;
                }

                $sensitive = Session::get('captcha.sensitive');
                $hash      = Session::get('captcha.hash');

                Session::remove('captcha');

                return Captcha::verify($captcha, $hash, $sensitive);
            },
            'The :attribute does not match.'
        );
    }
}
