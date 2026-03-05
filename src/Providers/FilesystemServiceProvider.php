<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemManager;

class FilesystemServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('filesystem', function ($app) {
            return new FilesystemManager($app);
        });
    }
}
