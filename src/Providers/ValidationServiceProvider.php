<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Gobel\Validation\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('translator', function ($app) {
            $loader = new FileLoader(new Filesystem(), $app->resourcePath('lang'));
            return new Translator($loader, 'en');
        });

        $this->app->singleton(Validator::class);
    }
}
