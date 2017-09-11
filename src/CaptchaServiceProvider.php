<?php

namespace Zablose\Captcha;

use Illuminate\Config\Repository;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        $validator->extend('captcha', function ($attribute, $value, $parameters)
        {
            /** @var Captcha $captcha */
            $captcha = $this->app['captcha'];

            return $captcha->check($value);
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('captcha', function ($app)
        {
            return new Captcha(
                $app[Store::class],
                $app[Repository::class]
            );
        });
    }

}
