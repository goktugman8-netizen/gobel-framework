<?php

namespace Gobel\Providers;

use Gobel\Support\ServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('db', function ($app) {
            $capsule = new Capsule;
            
            $dbConfig = require $app->configPath('database.php');
            $default = $dbConfig['default'];
            $config = $dbConfig[$default];

            $capsule->addConnection([
                'driver'    => $config['driver'] ?? 'mysql',
                'host'      => $config['host'] ?? '127.0.0.1',
                'database'  => $config['database'] ?? '',
                'username'  => $config['username'] ?? '',
                'password'  => $config['password'] ?? '',
                'charset'   => $config['charset'] ?? 'utf8mb4',
                'collation' => $config['collation'] ?? 'utf8mb4_unicode_ci',
                'prefix'    => $config['prefix'] ?? '',
            ]);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        });

        $this->app->singleton('db.schema', function ($app) {
            return $app->make('db')->getConnection()->getSchemaBuilder();
        });
    }

    public function boot()
    {
        //
    }
}
