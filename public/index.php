<?php

use Illuminate\Http\Request;

define('GOBEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Gobel\Http\Kernel::class);

$request = Request::capture();

try {
    // Load routes
    $router = $app->make('router');
    require __DIR__ . '/../routes/web.php';
    require __DIR__ . '/../routes/api.php';

    $response = $kernel->handle($request);
} catch (\Exception|\Throwable $e) {
    $response = $kernel->renderException(Request::capture(), $e);
}

if (isset($response)) {
    $response->send();
}

if (isset($kernel) && isset($request) && isset($response)) {
    $kernel->terminate($request, $response);
}
