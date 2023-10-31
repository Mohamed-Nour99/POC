<?php

namespace Src\Domain\Dashboard\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Src\Domain\Dashboard\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix(config('system.admin.prefix'))
            ->namespace($this->namespace)
            ->group(base_path('src/Domain/Dashboard/Routes/web/public.php'));

        Route::middleware('web')
            ->prefix(config('system.admin.prefix'))
            ->namespace($this->namespace)
            ->group(base_path('src/Domain/Dashboard/Routes/web/guest.php'));

        Route::middleware('web')
            ->prefix(config('system.admin.prefix'))
            ->namespace($this->namespace)
            ->group(base_path('src/Domain/Dashboard/Routes/web/auth.php'));

    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(base_path("src/Domain/Dashboard/Routes/api/public.php"));

        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(base_path("src/Domain/Dashboard/Routes/api/guest.php"));

        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(base_path("src/Domain/Dashboard/Routes/api/auth.php"));
    }
}
