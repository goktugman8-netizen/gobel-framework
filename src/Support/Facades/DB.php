<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class DB
{
    /**
     * Handle dynamic static method calls into the Database connection.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('db')->getConnection()->$method(...$parameters);
    }
}
