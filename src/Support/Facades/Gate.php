<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Gate
{
    /**
     * Handle dynamic static method calls into the Gate manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('auth.gate')->$method(...$parameters);
    }
}
