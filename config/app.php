<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */
    'name' => env('APP_NAME', 'Gobel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    */
    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    */
    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        /*
         * Framework Service Providers...
         */
        Gobel\Providers\HttpServiceProvider::class,
        Gobel\Providers\ConfigServiceProvider::class,
        Gobel\Providers\DatabaseServiceProvider::class,
        Gobel\Providers\ViewServiceProvider::class,
        Gobel\Providers\RouteServiceProvider::class,
        Gobel\Providers\AuthServiceProvider::class,
        Gobel\Providers\SessionServiceProvider::class,
        Gobel\Providers\ValidationServiceProvider::class,
        Gobel\Providers\LoggingServiceProvider::class,
        Gobel\Providers\QueueServiceProvider::class,
        Gobel\Providers\MailServiceProvider::class,
        Gobel\Providers\NotificationServiceProvider::class,
        Gobel\Providers\ScheduleServiceProvider::class,
        Gobel\Providers\RedisServiceProvider::class,
        Gobel\Providers\FilesystemServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ],
];
