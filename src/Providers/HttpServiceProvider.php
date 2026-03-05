<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('request', function ($app) {
            return Request::capture();
        });

        $this->app->singleton(ResponseFactoryContract::class, function ($app) {
            return new ResponseFactory($app['view'], $app['redirect']);
        });
    }
}
