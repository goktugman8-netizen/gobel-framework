<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Gobel\Auth\Auth;
use Gobel\Session\Session;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Auth::class, function ($app) {
            return new Auth($app->make(Session::class));
        });

        $this->app->singleton('auth.gate', function ($app) {
            return new \Illuminate\Auth\Access\Gate($app, function () use ($app) {
                return $app->make(Auth::class)->user();
            });
        });
    }
}
