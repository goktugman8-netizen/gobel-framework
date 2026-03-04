<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Notification
{
    /**
     * Handle dynamic static method calls into the Notification manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('notification')->$method(...$parameters);
    }
}
