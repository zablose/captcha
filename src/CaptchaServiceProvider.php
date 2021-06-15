<?php

namespace Zablose\Captcha;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class CaptchaServiceProvider extends ServiceProvider
{
    private const BASE_DIR = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;

    public function register(): void
    {
        $this->mergeConfigFrom(self::BASE_DIR.'config'.DIRECTORY_SEPARATOR.'captcha.php', 'captcha');

        require self::BASE_DIR.'helpers.php';
    }

    public function boot(): void
    {
        $this->publishes(
            [self::BASE_DIR.'config'.DIRECTORY_SEPARATOR.'captcha.php' => config_path('captcha.php')],
            'config'
        );

        $this->publishes(
            [self::BASE_DIR.'assets' => resource_path(Config::ASSETS_PATH)],
            'assets'
        );

        $this->loadRoutesFrom(self::BASE_DIR.'routes'.DIRECTORY_SEPARATOR.'captcha.php');

        /** @var Validator $validator */
        $validator = $this->app['validator'];
        $validator->extend(
            'captcha',
            function ($attribute, $captcha)
            {
                if (! Session::has('captcha')) {
                    return false;
                }

                $sensitive = Session::get('captcha.sensitive');
                $hash = Session::get('captcha.hash');

                Session::remove('captcha');

                return Captcha::verify($captcha, $hash, $sensitive);
            },
            'The :attribute does not match.'
        );
    }
}
