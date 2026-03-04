<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('notification', function ($app) {
            return new ChannelManager($app);
        });
    }
}
