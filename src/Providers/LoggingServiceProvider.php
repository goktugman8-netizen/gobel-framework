<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Gobel\Log\Logger as CustomLogger;

class LoggingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\Gobel\Log\Logger::class, function ($app) {
            if (class_exists(Logger::class)) {
                $log = new Logger('gobel');
                $log->pushHandler(new StreamHandler($app->storagePath('logs/gobel.log'), Logger::DEBUG));
                return $log;
            }
            return new CustomLogger($app->storagePath('logs/gobel.log'));
        });
    }
}
