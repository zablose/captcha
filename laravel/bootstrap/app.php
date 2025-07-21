<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Zablose\Captcha\Tests\Laravel\App\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: dirname(__DIR__).'/routes/web.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

$prefix = 'Zablose\\Captcha\\Tests\\Laravel\\';

$app->useEnvironmentPath(dirname(__DIR__, 2));
$app->setNamespace($prefix.'App\\');

Factory::useNamespace($prefix.'Database\\Factories\\');

return $app;
