<?php

use Gobel\Foundation\Application;

require_once dirname(__DIR__) . '/src/Support/helpers.php';

$app = new Application(dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/

$app->singleton(Gobel\Http\Kernel::class);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

$config = require $app->configPath('app.php');

foreach ($config['providers'] as $provider) {
    $app->register($provider);
}

/*
|--------------------------------------------------------------------------
| Boot the Application
|--------------------------------------------------------------------------
*/

$app->boot();

return $app;
