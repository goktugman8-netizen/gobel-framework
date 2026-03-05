<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Gobel\View\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Gobel\View\View::class, function ($app) {
            return new View(
                $app->resourcePath('views'),
                $app->storagePath('framework/views')
            );
        });

        $this->app->alias(\Gobel\View\View::class, 'view');
    }
}
