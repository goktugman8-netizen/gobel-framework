<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Gobel\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('router', function ($app) {
            return new Router($app);
        });
    }

    public function boot()
    {
        // Add logic to load routes if needed, although it's currently in Kernel/Router
    }
}
