<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Config\Repository;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('config', function ($app) {
            $items = [];

            foreach (glob($app->configPath() . '/*.php') as $path) {
                $items[basename($path, '.php')] = require $path;
            }

            return new Repository($items);
        });
    }
}
