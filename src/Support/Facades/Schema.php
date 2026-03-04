<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Schema
{
    /**
     * Handle dynamic static method calls into the Schema builder.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('db')->getConnection()->getSchemaBuilder()->$method(...$parameters);
    }
}
