<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Queue
{
    /**
     * Handle dynamic static method calls into the Queue manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('queue')->$method(...$parameters);
    }
}
