<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Mail
{
    /**
     * Handle dynamic static method calls into the Mail manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('mail.manager')->$method(...$parameters);
    }
}
