<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Storage
{
    /**
     * Handle dynamic static method calls into the Filesystem manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('filesystem')->disk()->$method(...$parameters);
    }
}
