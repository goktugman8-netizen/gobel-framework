<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Redis\RedisManager;

class RedisServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            $config = require $app->configPath('database.php');
            return new RedisManager($app, 'phpredis', $config['redis'] ?? []);
        });

        $this->app->bind('redis.connection', function ($app) {
            return $app->make('redis')->connection();
        });
    }
}
