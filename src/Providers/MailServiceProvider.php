<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Mail\MailManager;

class MailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('mail.manager', function ($app) {
            return new MailManager($app);
        });

        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
    }
}
