<?php

use Gobel\Foundation\Application;
use Gobel\View\View;

require_once dirname(__DIR__) . '/src/Support/helpers.php';

$app = new Application(dirname(__DIR__));

// Bind the HTTP Kernel
$app->singleton(Gobel\Http\Kernel::class);

// Bind the Router
$app->singleton('router', function ($app) {
    return new Gobel\Routing\Router($app);
});

// --- Illuminate Database (Eloquent) Setup ---
$capsule = new \Illuminate\Database\Capsule\Manager;

$dbConfig = require $app->configPath('database.php');
$default = $dbConfig['default'];
$config = $dbConfig[$default];

$capsule->addConnection([
    'driver'    => $config['driver'],
    'host'      => $config['host'],
    'database'  => $config['database'],
    'username'  => $config['username'],
    'password'  => $config['password'],
    'charset'   => $config['charset'] ?? 'utf8mb4',
    'collation' => $config['collation'] ?? 'utf8mb4_unicode_ci',
    'prefix'    => $config['prefix'] ?? '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Bind the Capsule to the container
$app->instance('db', $capsule);

// Bind the Logging system (Monolog)
$app->singleton(\Gobel\Log\Logger::class, function ($app) {
    if (class_exists(\Monolog\Logger::class)) {
        $log = new \Monolog\Logger('gobel');
        $log->pushHandler(new \Monolog\Handler\StreamHandler($app->storagePath('logs/gobel.log'), \Monolog\Logger::DEBUG));
        return $log;
    }
    // Fallback to custom logger if Monolog is not installed correctly
    return new \Gobel\Log\Logger($app->storagePath('logs/gobel.log'));
});

// Bind the Hashing system
$app->singleton(\Gobel\Support\Hash::class);

// Bind the Session
$app->singleton(\Gobel\Session\Session::class);
$app->make(\Gobel\Session\Session::class)->ageFlashData();

// Bind the Authentication system
$app->singleton(\Gobel\Auth\Auth::class, function ($app) {
    return new \Gobel\Auth\Auth($app->make(\Gobel\Session\Session::class));
});

// Bind the Validator
$app->singleton(\Gobel\Validation\Validator::class);

// Bind the Filesystem
$app->singleton('filesystem', function ($app) {
    return new \Illuminate\Filesystem\FilesystemManager($app);
});

// Configure hashing
$app->singleton('hash', function ($app) {
    return new \Gobel\Support\Hash($app);
});

// Bind Cache
$app->singleton('cache', function ($app) {
    return new \Illuminate\Cache\CacheManager($app);
});

// Bind Mail
$app->singleton('mail.manager', function ($app) {
    return new \Illuminate\Mail\MailManager($app);
});

$app->bind('mailer', function ($app) {
    return $app->make('mail.manager')->mailer();
});

// Bind Queue
$app->singleton('queue', function ($app) {
    return new \Illuminate\Queue\QueueManager($app);
});

$app->singleton('queue.worker', function ($app) {
    return new \Illuminate\Queue\Worker(
        $app['queue'],
        $app['events'],
        $app['errors.handler'] ?? null,
        function() { return false; }
    );
});

// Bind Notification
$app->singleton('notification', function ($app) {
    return new \Illuminate\Notifications\ChannelManager($app);
});

// Bind Authorization Gate
$app->singleton('auth.gate', function ($app) {
    return new \Illuminate\Auth\Access\Gate($app, function () use ($app) {
        return $app->make('auth')->user();
    });
});

// Bind Localization (Translator already semi-bound in Validator, making it global)
$app->singleton('translator', function ($app) {
    $loader = new \Illuminate\Translation\FileLoader(new \Illuminate\Filesystem\Filesystem(), $app->resourcePath('lang'));
    return new \Illuminate\Translation\Translator($loader, 'en');
});

// Bind JWT Manager
$app->singleton(\Gobel\Auth\JwtManager::class, function ($app) {
    return new \Gobel\Auth\JwtManager(env('JWT_SECRET', 'gobel_secret_key_1234567890abcdef'));
});

// Bind the View Engine
$app->singleton(Gobel\View\View::class, function ($app) {
    return new Gobel\View\View(
        $app->resourcePath('views'),
        $app->basePath('storage/framework/views')
    );
});

return $app;
