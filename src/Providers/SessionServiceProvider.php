<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Gobel\Session\Session;

class SessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Session::class);
    }

    public function boot()
    {
        $this->app->make(Session::class)->ageFlashData();
    }
}
