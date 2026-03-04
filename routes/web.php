<?php

$router->get('/', [App\Controllers\HomeController::class, 'index']);
$router->get('/about', [App\Controllers\HomeController::class, 'about']);
$router->get('/docs', [App\Controllers\DocsController::class, 'index']);
