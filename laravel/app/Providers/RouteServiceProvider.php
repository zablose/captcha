<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = null;

    public function boot(): void
    {
        $this->routes(
            fn() => Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'))
        );
    }
}
