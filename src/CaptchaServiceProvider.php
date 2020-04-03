<?php

namespace Zablose\Captcha;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class CaptchaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../laravel/config/captcha.php' => config_path('captcha.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/../laravel/routes/captcha.php');

        /** @var Validator $validator */
        $validator = $this->app['validator'];
        $validator->extend(
            'captcha',
            function ($attribute, $value, $parameters)
            {
                if (! Session::has('captcha')) {
                    return false;
                }

                $sensitive = Session::get('captcha.sensitive');
                $hash      = Session::get('captcha.hash');

                Session::remove('captcha');

                return Captcha::check($sensitive, $value, $hash);
            },
            'The :attribute does not match.'
        );

        if (! function_exists('captcha_url')) {
            function captcha_url(string $type = 'default'): string
            {
                return url('/captcha/'.$type).'/'.\Zablose\Captcha\Random::string(12);
            }
        }
    }
}
