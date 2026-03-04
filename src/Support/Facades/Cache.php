<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Cache
{
    /**
     * Handle dynamic static method calls into the Cache manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('cache')->$method(...$parameters);
    }
}
