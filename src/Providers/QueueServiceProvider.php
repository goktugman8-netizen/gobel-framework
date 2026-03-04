<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Queue\QueueManager;
use Illuminate\Queue\Worker;

class QueueServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('queue', function ($app) {
            return new QueueManager($app);
        });

        $this->app->singleton('queue.worker', function ($app) {
            return new Worker(
                $app['queue'],
                $app['events'],
                $app['errors.handler'] ?? null,
                function() { return false; }
            );
        });
    }
}
