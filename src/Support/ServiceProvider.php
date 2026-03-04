<?php

namespace Gobel\Support;

use Gobel\Foundation\Application;

abstract class ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Gobel\Foundation\Application
     */
    protected $app;

    /**
     * Create a new service provider instance.
     *
     * @param \Gobel\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    abstract public function register();

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
