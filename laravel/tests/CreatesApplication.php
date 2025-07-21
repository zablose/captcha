<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests;

use Zablose\Captcha\Tests\Laravel\App\Application;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $app = require dirname(__DIR__).'/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
