<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Schedule::class, function ($app) {
            return new Schedule();
        });
    }

    public function boot()
    {
        // This is where user can define schedules in AppServiceProvider or here
    }
}
