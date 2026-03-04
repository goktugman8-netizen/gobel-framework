<?php

namespace App\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // Register policies here
    }
}
